<?php

namespace App\Http\Controllers\iAccess\User\Form;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\iAccess\iaccessEmailRequest;
use App\Models\iAccess\iaccessAccountRequest;
use App\Models\iAccess\iaccessGuestRequest;
use App\Models\iAccess\iaccessInternetRequest;
use App\Http\Controllers\Common\ImageUpload;
use Auth;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Str;

use App\Http\Controllers\Common\Email\ScheduleEmailIaccessEmailRequest;
use App\Http\Controllers\Common\Email\ScheduleEmailIaccessInternetRequest;
use App\Http\Controllers\Common\Email\ScheduleEmailIaccessAccountRequest;
use App\Http\Controllers\Common\Email\ScheduleEmailIaccessGuestRequest;

class IndexController extends Controller
{
    use ImageUpload;

    //email_store
    public function email_store(Request $request){


        //Validate
        $this->validate($request,[
            'name'              => 'required',
            'branch'            => 'required',
            'position'          => 'required',
            'department'        => 'required',
            'office_mobile'     => 'nullable',
            'personal_mobile'   => 'nullable',
            'personal_email'    => 'required',
            'bu_head_email'     => 'nullable',

            'request_for'       => 'required',
            'requested_email'   => 'nullable',
            'purpose'           => 'required',
        ]);

        $data = new iaccessEmailRequest();

    
        $data->name              = $request->name;
        $data->branch            = $request->branch;
        $data->position          = $request->position;
        $data->department        = $request->department;
        $data->office_mobile     = $request->office_mobile;
        $data->personal_mobile   = $request->personal_mobile;
        $data->personal_email    = $request->personal_email;
        $data->bu_head_email     = $request->bu_head_email;

        $data->request_for       = implode(",", $request->request_for);
        $data->requested_email   = $request->requested_email;
        $data->purpose           = $request->purpose;

        $data->signature         = $request->name;
        $data->date              = Carbon::now();
        
        $data->created_by        = Auth::user()->id;
        $success                 = $data->save();


        $this->pdfEmailGenerate($data->id);



    }

    // pdfEmailGenerate
    public function pdfEmailGenerate($id){

        $newData = iaccessEmailRequest::find($id);

       
        // PDF Generate
        $pdf = PDF::loadView('iaccess.user.pdf.emailRequestForm', compact('newData'))
        ->setOption('footer-font-size', 6)
        ->setOption('margin-bottom', 4)
        ->setOption("encoding", "UTF-8");

        $filename = 'email_access_'.Str::random(10);

        $pdf->save(public_path('images/iaccess/email/'.$filename.'.pdf'));
        
       

        $mail = ScheduleEmailIaccessEmailRequest::STORE($newData, $filename);

        if($mail){
            return response()->json(['msg'=>'Mail Sent Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Mail could not sent !!'
            ], 422);
        }

    }




    //internet_store
    public function webaccess_store(Request $request){

        //Validate
        $this->validate($request,[
            'name'              => 'required',
            'branch'            => 'required',
            'position'          => 'required',
            'department'        => 'required',
            'office_mobile'     => 'nullable',
            'personal_mobile'   => 'nullable',
            'personal_email'    => 'required',
            'office_email'      => 'nullable',

            'request_for'       => 'required',
            'internet_id'       => 'nullable',
            'purpose'           => 'required',
        ]);

        $data = new iaccessInternetRequest();

    
        $data->name              = $request->name;
        $data->branch            = $request->branch;
        $data->position          = $request->position;
        $data->department        = $request->department;
        $data->office_mobile     = $request->office_mobile;
        $data->personal_mobile   = $request->personal_mobile;
        $data->personal_email    = $request->personal_email;
        $data->office_email      = $request->office_email;

        $data->request_for       = implode(",", $request->request_for);
        $data->internet_id       = $request->internet_id;
        $data->purpose           = $request->purpose;

        $data->signature         = $request->name;
        $data->date              = Carbon::now();
        
        $data->created_by   =  Auth::user()->id;
        $success            = $data->save();


        $this->pdfInternetGenerate($data->id);

    }

    // pdfInternetGenerate
    public function pdfInternetGenerate($id){

        $newData = iaccessInternetRequest::find($id);

       
        // PDF Generate
        $pdf = PDF::loadView('iaccess.user.pdf.internetAccessRequestForm', compact('newData'))
        ->setOption('footer-font-size', 6)
        ->setOption('margin-bottom', 4)
        ->setOption("encoding", "UTF-8");

        $filename = 'internet_access_'.Str::random(10);

        $pdf->save(public_path('images/iaccess/internet/'.$filename.'.pdf'));
        
       

        $internet = ScheduleEmailIaccessInternetRequest::STORE($newData, $filename);

        if($internet){
            return response()->json(['msg'=>'Mail Sent Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Mail could not sent !!'
            ], 422);
        }

    }




    //account_store
    public function account_store(Request $request){

        //Validate
        $this->validate($request,[
            'name'              => 'required',
            'branch'            => 'required',
            'position'          => 'required',
            'department'        => 'required',
            'office_mobile'     => 'nullable',
            'personal_mobile'   => 'nullable',
            'personal_email'    => 'required',
            'office_email'      => 'nullable',

            'request_for'       => 'required',
            'access_for'        => 'nullable',
            'purpose'           => 'required',
        ]);

        $data = new iaccessAccountRequest();

    
        $data->name              = $request->name;
        $data->branch            = $request->branch;
        $data->position          = $request->position;
        $data->department        = $request->department;
        $data->office_mobile     = $request->office_mobile;
        $data->personal_mobile   = $request->personal_mobile;
        $data->personal_email    = $request->personal_email;
        $data->office_email      = $request->office_email;

        $data->request_for       = implode(",", $request->request_for);
        $data->access_for        = implode(",", $request->access_for);
        $data->purpose           = $request->purpose;

        $data->signature         = $request->name;
        $data->date              = Carbon::now();
        
        $data->created_by   =  Auth::user()->id;
        $success            = $data->save();


        $this->pdfIAccountGenerate($data->id);

        

    }

    // pdfInternetGenerate
    public function pdfIAccountGenerate($id){

        $newData = iaccessAccountRequest::find($id);

       
        // PDF Generate
        $pdf = PDF::loadView('iaccess.user.pdf.accountAuthorityForm', compact('newData'))
        ->setOption('footer-font-size', 6)
        ->setOption('margin-bottom', 4)
        ->setOption("encoding", "UTF-8");

        $filename = 'account_authority_'.Str::random(10);

        $pdf->save(public_path('images/iaccess/account/'.$filename.'.pdf'));
        
       

        $account = ScheduleEmailIaccessAccountRequest::STORE($newData, $filename);

        if($account){
            return response()->json(['msg'=>'Mail Sent Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Mail could not sent !!'
            ], 422);
        }
    }




    //guest_store
    public function guest_store(Request $request){

        //Validate
        $this->validate($request,[
            'name'              => 'required',
            'branch'            => 'required',
            'position'          => 'required',
            'department'        => 'required',
            'mobile'            => 'nullable',
            'personal_email'    => 'required',

            'guest_company'     => 'required',
            'no_of_guest'       => 'nullable',
            'guest_job'         => 'required',
            'guest_duration'    => 'required',
            'start_date'        => 'nullable',
            'end_date'          => 'required',
        ]);

        $data = new iaccessGuestRequest();

    
        $data->name              = $request->name;
        $data->branch            = $request->branch;
        $data->position          = $request->position;
        $data->department        = $request->department;
        $data->mobile            = $request->mobile;
        $data->personal_email    = $request->personal_email;

        $data->guest_company     = $request->guest_company;
        $data->no_of_guest       = $request->no_of_guest;
        $data->guest_job         = $request->guest_job;
        $data->guest_duration    = $request->guest_duration;
        $data->start_date        = $request->start_date;
        $data->end_date          = $request->end_date;

        $data->signature         = $request->name;
        $data->date              = Carbon::now();
        
        $data->created_by   =  Auth::user()->id;
        $success            = $data->save();


        $this->pdfGuestGenerate($data->id);


    }

    // pdfInternetGenerate
    public function pdfGuestGenerate($id){

        $newData = iaccessGuestRequest::find($id);

       
        // PDF Generate
        $pdf = PDF::loadView('iaccess.user.pdf.guestUserForm', compact('newData'))
        ->setOption('footer-font-size', 6)
        ->setOption('margin-bottom', 4)
        ->setOption("encoding", "UTF-8");

        $filename = 'guest_access_'.Str::random(10);

        $pdf->save(public_path('images/iaccess/guest/'.$filename.'.pdf'));
        
       

        $guest = ScheduleEmailIaccessGuestRequest::STORE($newData, $filename);


        if($guest){
            return response()->json(['msg'=>'Mail Sent Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Mail could not sent !!'
            ], 422);
        }

    }
}
