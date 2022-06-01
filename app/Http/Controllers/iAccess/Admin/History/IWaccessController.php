<?php

namespace App\Http\Controllers\iAccess\Admin\History;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\iAccess\iaccessInternetRequest;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use PDF;

class IWaccessController extends Controller
{
    //index
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id'); 
        $sort_by_day    = Request('sort_by_day', '');
        $sort_by_startDate   = Request('sort_by_startDate', '');
        $sort_by_endDate     = Request('sort_by_endDate', '');
        $sort_by_type     = Request('sort_by_type', '');

        $allQuery =  iaccessInternetRequest::with('manager', 'buhead', 'verify', 'makby');
        
        
        // sort_by_day
        if(!empty($sort_by_day)){
            $date = Carbon::today()->subDays($sort_by_day);
            $allQuery->whereDate('created_at', '>=', $date );
        }
        
        // sort_by_Date
        if(!empty($sort_by_startDate) && !empty($sort_by_endDate) ){
            
            $allQuery->whereBetween('created_at' ,[$sort_by_startDate ." 00:00:00", $sort_by_endDate." 23:59:59"]);
        }


        // sort_by_ approve type
        if(!empty($sort_by_type)){

            if($sort_by_type == 'm'){
                // only manager_approved
                $allQuery->whereNotNull('manager_approved')
                        ->whereNull('bu_approved');
            }elseif($sort_by_type == 'mb'){
                // manager_approved & bu_approved
                $allQuery->whereNotNull('bu_approved')
                        ->whereNotNull('manager_approved')
                        ->whereNull('verify_by');
            }elseif($sort_by_type == 'v'){
                // bu_approved, manager_approved, verified
                $allQuery->whereNotNull('bu_approved')
                        ->whereNotNull('manager_approved')
                        ->whereNotNull('verify_by');
            }elseif($sort_by_type == 'nv'){
                // bu_approved, manager_approved, Not verified
                $allQuery->whereNull('bu_approved')
                        ->whereNull('manager_approved')
                        ->whereNull('verify_by');
            }
            
           
        }

        $allData =  $allQuery->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    }



    // remarks_action
    public function remarks_action(Request $request){

       //dd($request->all());
        //Validate
        $this->validate($request,[
            'verify_remarks'  => 'required|min:10|max:20000',
        ]);



        // IT Approve
        $data = iaccessInternetRequest::with('manager', 'buhead')->where('id', $request->id)->first();
        $data->verify_by      = Auth::user()->id;
        $data->verify_status  = $request->verify_status;
        $data->verify_remarks = $request->verify_remarks;
        $data->verify_date    = Carbon::now();
        $success = $data->save();
        //dd($data);

        //mail Start
        self::verifyEmail($data);
     

        //dd('mail send');
        if($success){
            return response()->json(['msg'=>'Verified Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Application could not Submit !!'
            ], 422);
        }

    }


    // resend manager approve email
    public function email_resend(){
        $id   = Request('id');
        $type = Request('type');
        // dd($id);
        
        // Email send
        if($type == 'v'){
            // verify
            $data = iaccessInternetRequest::find($id);
            self::verifyEmail($data);
        }elseif($type == 'm'){
            // manager
            $data = iaccessInternetRequest::with('manager')->find($id);
            self::managerEmail($data);
        }elseif($type == 'b'){
            // B U
            $data = iaccessInternetRequest::with('buhead', 'manager')->find($id);
            self::buEmail($data);
        }
        

        return response()->json('Verify Email Send', 200);
    }



    // Verify Email
    public static function verifyEmail($data){

        if(!empty($data->office_email)){
            $to = $data->office_email;
        }else{
            $to = $data->personal_email;
        }

        // $to = 'saifulislamw60@gmail.com';
        $to = $data->buhead->email;
        if(empty($to)){
            return response()->json([
                'msg' => 'Sending Email Error !!'
            ], 422);  
        }
        $managerMail = $data->manager->office_email ?? '';
        $buMail = $data->buhead->email?? '' ;
        $cc = [$managerMail,$buMail];

        $sub = $data->name.' : Internet / Web Access Request Update';

        $mailData = [
            'to'=> $to,
            'cc'=> $cc,
            'sub'=> $sub,
            'applicant_name'=> $data->name ?? '',
            'applicant_position'=> $data->position ?? '',
            'applicant_branch'=> $data->branch ?? '',
            'applicant_department'=> $data->department ?? '',
            'applicant_request_for'=> $data->request_for ?? '',
            'applicant_purpose'=> $data->purpose ?? '',
            'applicant_web_url'=> $data->web_url ?? '',
            'verify_status'  => $data->verify_status ?? '',
            'verify_remarks' => $data->verify_remarks ?? '',
        ];
 
        Mail::send('iaccess.user.email.iw-access.verify', compact('mailData'), function ($message) use ($mailData) {
            $message->to( $mailData['to'] );
            $message->cc( $mailData['cc'] );
            $message->subject( $mailData['sub'] );
            $message->from( 'it-noreply@cpbangladesh.com' );
        });

        return true;
    }


    // resend manager email
    public static function managerEmail($data){

        // $to = 'saifulislamw60@gmail.com';
        $to = $data->manager->office_email;
        if(empty($to)){
            return response()->json([
                'msg' => 'Sending Email Error !!'
            ], 422);  
        }
        $sub = $data->name.' : Internet / Web Access Request';

        $mailData = [
            'to'=> $to,
            'sub'=> $sub,
            'name'=> $data->manager->name ?? '',
            'applicant_name'=> $data->name ?? '',
            'applicant_position'=> $data->position ?? '',
            'applicant_branch'=> $data->branch ?? '',
            'applicant_department'=> $data->department ?? '',
            'applicant_request_for'=> $data->request_for ?? '',
            'applicant_purpose'=> $data->purpose ?? '',
            'applicant_web_url'=> $data->web_url ?? '',
            'token' => $data->manager_token
        ];


        Mail::send('iaccess.user.email.iw-access.approve', compact('mailData'), function ($message) use ($mailData) {
            $message->to( $mailData['to'] );
            $message->subject( $mailData['sub'] );
            $message->from( 'it-noreply@cpbangladesh.com' );
        });
        
        return true;      
            
    }


    // resend BU Email
    public static function buEmail($data){
    
        // B U mail Start
        // $to = 'saifulislamw60@gmail.com';
        $to = $data->buhead->email;
        if(empty($to)){
            return response()->json([
                'msg' => 'Sending Email Error !!'
            ], 422);  
        }
        $sub = $data->name.' : Internet / Web Access Request';

        $mailData = [
            'to'=> $to,
            'sub'=> $sub,
            'name'=> $data->buhead->name ?? '',
            'applicant_name'=> $data->name ?? '',
            'applicant_position'=> $data->position ?? '',
            'applicant_branch'=> $data->branch ?? '',
            'applicant_department'=> $data->department ?? '',
            'applicant_request_for'=> $data->request_for ?? '',
            'applicant_purpose'=> $data->purpose ?? '',
            'applicant_web_url'=> $data->web_url ?? '',
            'token' => $data->bu_token ?? '',
        ];

        Mail::send('iaccess.user.email.iw-access.approve', compact('mailData'), function ($message) use ($mailData) {
            $message->to( $mailData['to'] );
            $message->subject( $mailData['sub'] );
            $message->from( 'it-noreply@cpbangladesh.com' );
        });
        // B U mail End

        return true;
    }


    // get_app_details with pdf
    public function get_app_details($id){

        $data = iaccessInternetRequest::with('manager', 'buhead', 'verify')->where('id', $id)->first();

        // PDF Generate
        $pdf = PDF::loadView('iaccess.admin.pdf.internetRequestForm', compact('data'))
        ->setOption('footer-center', 'Page [page] of [toPage]')
        ->setOption('footer-font-size', 6)
        ->setOption('margin-bottom', 4)
        ->setOption("encoding", "UTF-8");

        $filename = 'internet_request_'.Str::random(10);
        $pdf->save(public_path('images/iaccess/pdf/internet/'.$filename.'.pdf'));

        $path = 'images/iaccess/pdf/internet/'.$filename.'.pdf';

        
        $infoPath = pathinfo(public_path($path));
        
        $extension = $infoPath['extension'];

        if($extension == 'pdf'){
            $file = file_get_contents($path);
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $base64 = base64_encode($file);
            return response()->json($base64);
        }
    

    }



}
