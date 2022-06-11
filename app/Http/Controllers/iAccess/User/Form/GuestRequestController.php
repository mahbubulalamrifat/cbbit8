<?php

namespace App\Http\Controllers\iAccess\User\Form;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\iAccess\iaccessGuestRequest;
use App\Http\Controllers\iAccess\CommonController;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class GuestRequestController extends Controller
{
    

    //internet_store
    public function store(Request $request){

        //dd($request->all(), $request->manager['id'], $request->manager['office_email'],$request->manager['name'] );

        //Validate
        $this->validate($request,[
            'name'              => 'required',
            'branch'            => 'required',
            'position'          => 'required',
            'department'        => 'required',
            'office_mobile'     => 'nullable',
            'personal_mobile'   => 'nullable',
            'personal_email'    => 'required|max:100',
            'office_email'      => 'nullable|max:100',
            
            'guest_company'     => 'nullable|string',
            'no_of_guest'       => 'required|integer',
            'guest_job'         => 'nullable|string',
            'guest_duration'    => 'required|integer',
            'start_date'        => 'required',
            'end_date'          => 'required',

        ]);

        $lastData = iaccessGuestRequest::whereNotNull('number')->select('number')->latest()->first();
        if($lastData && $lastData->number){
            $number = CommonController::RunningNumberGenerate('GR', $lastData->number);
        }else{
            $number = CommonController::RunningNumberGenerate('GR');
        }


        $data = new iaccessGuestRequest();
        
        $data->number            = $number;
        $data->name              = $request->name;
        $data->branch            = $request->branch;
        $data->position          = $request->position;
        $data->department        = $request->department;
        $data->office_mobile     = $request->office_mobile;
        $data->personal_mobile   = $request->personal_mobile;
        $data->personal_email    = $request->personal_email;
        $data->office_email      = $request->office_email;
        $data->internet_id       = $request->internet_id;

        $data->guest_company     = $request->guest_company;
        $data->no_of_guest       = $request->no_of_guest;
        $data->guest_job         = $request->guest_job; 
        $data->guest_duration    = $request->guest_duration; 
        $data->start_date        = $request->start_date; 
        $data->end_date          = $request->end_date; 

        $data->manager_id        = $request->manager['id'];
        $data->manager_token     = 'm_'.Str::random(20);
        $data->bu_id             = $request->bu['id'];
        $data->bu_token          = 'b_'.Str::random(20);
        
        $data->apply_by          = Auth::user()->id;
        $data->apply_date        = Carbon::now();


        $documentPath = 'images/iaccess/';
        $document     = $request->file('document');
        // Direct any file store
        if ($document) {
            $document_full_name =  CommonController::documentUpload($document, $documentPath, $request->name);
            $data->document     = $document_full_name;
        }

        $document2     = $request->file('document2');
        if ($document2) {
            $document_full_name =  CommonController::documentUpload($document2, $documentPath, $request->name);
            $data->document2     = $document_full_name;
        }



        $success                 = $data->save();

        $savedData = iaccessGuestRequest::with('manager')->find($data->id);

        //$to = 'saifulislamw60@gmail.com';
        $to = $data->manager->office_email;
        if(empty($to)){
            return response()->json([
                'msg' => 'Sending Email Error !!'
            ], 422);  
        }
        $sub = $savedData->name.' : Guest User Request';

        $mailData = [
            'to'=> $to,
            'sub'=> $sub,
            'name'=> $savedData->manager->name ?? '',
            'applicant_name'=> $savedData->name ?? '',
            'applicant_position'=> $savedData->position ?? '',
            'applicant_branch'=> $savedData->branch ?? '',
            'applicant_department'=> $savedData->department ?? '',
            
            'applicant_guest_company'=> $savedData->guest_company ?? '',
            'applicant_no_of_guest'=> $savedData->no_of_guest ?? '',
            'applicant_guest_job'=> $savedData->guest_job ?? '',
            'applicant_guest_duration'=> $savedData->guest_duration ?? '',
            'applicant_start_date'=> $savedData->start_date ?? '',
            'applicant_end_date'=> $savedData->end_date ?? '',

            'token' => $savedData->manager_token
        ];

        self::MailSendIWAccessRequest($mailData);

        // Mail::send('iaccess.user.email.iaccess-email', compact('mailData'), function ($message) use ($mailData) {
        //     $message->to( $mailData['to'] );
        //     $message->subject( $mailData['sub'] );
        //     $message->from( 'it-noreply@cpbangladesh.com' );
        // });

        //dd($mailData);
        //CommonController::MailSendIWAccessRequest($mailData);


        //dd('mail send');
        //$this->pdfInternetGenerate($data->id);

        if($success){
            return response()->json(['msg'=>'Application Submitted Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Application could not Submit !!'
            ], 422);
        }

    }

    // approve by mail
    public function approve(){

        //dd( Request('token') );

        $token = Request('token');

        if( $token ){

            $notification = [];

            $tokenArray = explode("_", $token);
            if($tokenArray[0] == 'm'){
                // Manager Approve
                $data = iaccessGuestRequest::with('buhead')->where('manager_token', $token)->orderBy('id', 'desc')->first();

                $userData = [
                    'id' => $data->id,
                    'name' => $data->name,
                    'branch' => $data->branch,
                    'position' => $data->position,
                    'department' => $data->department,
                    'office_mobile' => $data->office_mobile,
                    'personal_mobile' => $data->personal_mobile,
                    'personal_email' => $data->personal_email,
                    'office_email' => $data->office_email,
                ];

                if($data){

                    if( empty($data->manager_approved) ){
                        // Manager Part

                        $data->manager_approved = Carbon::now();
                        $success = $data->save();

                        // B U mail Start
                        //$to = 'saifulislamw60@gmail.com';
                        $to = $data->buhead->email;
                        if(empty($to)){
                            return response()->json([
                                'msg' => 'Sending Email Error !!'
                            ], 422);  
                        }
                        
                        $sub = $data->name.' : Guest User Request';

                        $mailData = [
                            'to'=> $to,
                            'sub'=> $sub,
                            'name'=> $data->buhead->name ?? '',
                            'applicant_name'=> $data->name ?? '',
                            'applicant_position'=> $data->position ?? '',
                            'applicant_branch'=> $data->branch ?? '',
                            'applicant_department'=> $data->department ?? '',
                            
                            'applicant_guest_company'=> $data->guest_company ?? '',
                            'applicant_no_of_guest'=> $data->no_of_guest ?? '',
                            'applicant_guest_job'=> $data->guest_job ?? '',
                            'applicant_guest_duration'=> $data->guest_duration ?? '',
                            'applicant_start_date'=> $data->start_date ?? '',
                            'applicant_end_date'=> $data->end_date ?? '',

                            'token' => $data->bu_token ?? '',
                        ];
                
                        self::MailSendIWAccessRequest($mailData);
                        // B U mail End

                        if($success){
                            $notification = [ 'status' => 'success', 'msg'=> 'Successfully Approved', 'data'=> $userData ];
                        }else{
                            $notification = [ 'status' => 'error', 'msg'=> 'Somthing going wrong. Try again, please.', 'data'=> null ];
                        }

                    }else{
                        $notification = [ 'status' => 'warning', 'msg'=> 'Already Approved', 'data'=> $userData ];
                    }

                }else{
                    $notification = [ 'status' => 'error', 'msg'=> 'Token Not found', 'data'=> null ];
                }
                

            }elseif($tokenArray[0] == 'b'){
                // BU Head Approve

                // Manager Approve
                $data = iaccessGuestRequest::with('buhead', 'manager')->where('bu_token', $token)->orderBy('id', 'desc')->first();

                $userData = [
                    'id' => $data->id,
                    'name' => $data->name,
                    'branch' => $data->branch,
                    'position' => $data->position,
                    'department' => $data->department,
                    'office_mobile' => $data->office_mobile,
                    'personal_mobile' => $data->personal_mobile,
                    'personal_email' => $data->personal_email,
                    'office_email' => $data->office_email,
                ];

               
 
                if($data){

                    if( empty($data->bu_approved) ){
                        // Manager Part

                        $data->bu_approved = Carbon::now();
                        $success = $data->save();

                        // B U mail Start
                        //$to = 'saifulislamw60@gmail.com';
                        $to = 'sagor@cpbangladesh.com';
                        $sub = $data->name.' : Guest User Request';

                        $mailData = [
                            'to'=> $to,
                            'sub'=> $sub,
                            'name'=> 'Md. Saiful Alam',
                            'applicant_name'=> $data->name ?? '',
                            'applicant_position'=> $data->position ?? '',
                            'applicant_branch'=> $data->branch ?? '',
                            'applicant_department'=> $data->department ?? '',
                            
                            'applicant_guest_company'=> $data->guest_company ?? '',
                            'applicant_no_of_guest'=> $data->no_of_guest ?? '',
                            'applicant_guest_job'=> $data->guest_job ?? '',
                            'applicant_guest_duration'=> $data->guest_duration ?? '',
                            'applicant_start_date'=> $data->start_date ?? '',
                            'applicant_end_date'=> $data->end_date ?? '',
                                
                            'bu_name' => $data->buhead->name ?? '',
                            'manager_name' => $data->manager->name ?? '',
                        ];
                 
                        Mail::send('iaccess.user.email.guest-request.accept', compact('mailData'), function ($message) use ($mailData) {
                            $message->to( $mailData['to'] );
                            $message->subject( $mailData['sub'] );
                            $message->from( 'it-noreply@cpbangladesh.com' );
                        });
                        // B U mail End

                        if($success){
                            $notification = [ 'status' => 'success', 'msg'=> 'Successfully Approved', 'data'=> $userData ];
                        }else{
                            $notification = [ 'status' => 'error', 'msg'=> 'Somthing going wrong. Try again, please.', 'data'=> null ];
                        }

                    }else{
                        $notification = [ 'status' => 'warning', 'msg'=> 'Already Approved', 'data'=> $userData ];
                    }
 
                }else{
                    $notification = [ 'status' => 'error', 'msg'=> 'Token Not found', 'data'=> null ];
                }



            }else{
                $notification = [ 'status' => 'error', 'msg'=> 'Token not valid', 'data'=> null ];
            }

       

            //dd($notification['status'],  $notification );
            return view('iaccess.user.approve-status', compact('notification'));
         
           
        }


    }

    

    // MailSendIWAccessRequest
    public static function MailSendIWAccessRequest($mailData){
       
        Mail::send('iaccess.user.email.guest-request.approve', compact('mailData'), function ($message) use ($mailData) {
            $message->to( $mailData['to'] );
            $message->subject( $mailData['sub'] );
            $message->from( 'it-noreply@cpbangladesh.com' );
        });
 
    }


}
