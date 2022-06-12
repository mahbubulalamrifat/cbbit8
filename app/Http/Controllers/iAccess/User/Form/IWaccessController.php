<?php

namespace App\Http\Controllers\iAccess\User\Form;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\iAccess\iaccessInternetRequest;
use App\Http\Controllers\iAccess\CommonController;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class IWaccessController extends Controller
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

            'request_for'       => 'required',
            'internet_id'       => 'nullable',
            'purpose'           => 'required|max:20000',
        ]);

        $lastData = iaccessInternetRequest::whereNotNull('number')->select('number')->latest()->first();
        if($lastData && $lastData->number){
            $number = CommonController::RunningNumberGenerate('IR', $lastData->number);
        }else{
            $number = CommonController::RunningNumberGenerate('IR');
        }


        $data = new iaccessInternetRequest();
        
        $data->number            = $number;
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
        $data->web_url           = $request->web_url; 
        $data->purpose           = $request->purpose; 

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

        $savedData = iaccessInternetRequest::with('manager')->find($data->id);

        //$to = 'saifulislamw60@gmail.com';
        $to = $data->manager->office_email;
        if(empty($to)){
            return response()->json([
                'msg' => 'Sending Email Error !!'
            ], 422);  
        }
        $sub = $savedData->name.' : Internet / Web Access Request';

        $mailData = [
            'to'=> $to,
            'sub'=> $sub,
            'name'=> $savedData->manager->name ?? '',
            'applicant_name'=> $savedData->name ?? '',
            'applicant_position'=> $savedData->position ?? '',
            'applicant_branch'=> $savedData->branch ?? '',
            'applicant_department'=> $savedData->department ?? '',
            'applicant_request_for'=> $savedData->request_for ?? '',
            'applicant_purpose'=> $savedData->purpose ?? '',
            'applicant_web_url'=> $savedData->web_url ?? '',
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
                $data = iaccessInternetRequest::with('buhead')->where('manager_token', $token)->orderBy('id', 'desc')->first();

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
                    'request_for' => $data->request_for,
                ];

                if($data){

                    if( empty($data->manager_rejected) ){
                        if( empty($data->manager_approved) ){
                            // Manager Part

                            $data->manager_approved = Carbon::now();
                            $success = $data->save();

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
                        $notification = [ 'status' => 'warning', 'msg'=> 'Already Rejected', 'data'=> $userData ];
                    }

                }else{
                    $notification = [ 'status' => 'error', 'msg'=> 'Token Not found', 'data'=> null ];
                }
                

            }elseif($tokenArray[0] == 'b'){
                // BU Head Approve

                // Manager Approve
                $data = iaccessInternetRequest::with('buhead', 'manager')->where('bu_token', $token)->orderBy('id', 'desc')->first();

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
                     'request_for' => $data->request_for,
                ];

               
 
                if($data){
                    
                    if( empty($data->bu_rejected) ){
                        if( empty($data->bu_approved) ){
                            // Manager Part

                            $data->bu_approved = Carbon::now();
                            $success = $data->save();
    
                            // B U mail Start
                            // $to = 'saifulislamw60@gmail.com';
                            $to = 'sagor@cpbangladesh.com';
                            $sub = $data->name.' : Internet / Web Access Request';

                            $mailData = [
                                'to'=> $to,
                                'sub'=> $sub,
                                'name'=> 'Md. Saiful Alam',
                                'applicant_name'=> $data->name ?? '',
                                'applicant_position'=> $data->position ?? '',
                                'applicant_branch'=> $data->branch ?? '',
                                'applicant_department'=> $data->department ?? '',
                                'applicant_request_for'=> $data->request_for ?? '',
                                'applicant_purpose'=> $data->purpose ?? '',
                                'applicant_web_url'=> $data->web_url ?? '',
                                'bu_name' => $data->buhead->name ?? '',
                                'manager_name' => $data->manager->name ?? '',
                            ];
                    
                            Mail::send('iaccess.user.email.iw-access.accept', compact('mailData'), function ($message) use ($mailData) {
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
                        $notification = [ 'status' => 'warning', 'msg'=> 'Already Rejected', 'data'=> $userData ];
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
       
        Mail::send('iaccess.user.email.iw-access.approve', compact('mailData'), function ($message) use ($mailData) {
            $message->to( $mailData['to'] );
            $message->subject( $mailData['sub'] );
            $message->from( 'it-noreply@cpbangladesh.com' );
        });
 
    }




    // reject
    public function reject(){

        //dd( Request('token') );

        $token = Request('token');

        if( $token ){

            $notification = [];

            $tokenArray = explode("_", $token);
            if($tokenArray[0] == 'm'){
                // Manager reject
                $data = iaccessInternetRequest::with('buhead')->where('manager_token', $token)->orderBy('id', 'desc')->first();

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
                    'request_for' => $data->request_for,
                ];

                if($data){
                    if( empty($data->manager_approved) ){
                        if( empty($data->manager_rejected) ){
                            // Manager Part

                            $data->manager_rejected = Carbon::now();
                            $data->verify_status = 3;
                            $success = $data->save();

                            self::rejectEmail($data);
                            if($success){
                                $notification = [ 'status' => 'reject', 'msg'=> 'Successfully Rejected', 'data'=> $userData ];
                            }else{
                                $notification = [ 'status' => 'error', 'msg'=> 'Somthing going wrong. Try again, please.', 'data'=> null ];
                            }

                        }else{
                            $notification = [ 'status' => 'warning', 'msg'=> 'Already Rejected', 'data'=> $userData ];
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
                 $data = iaccessInternetRequest::with('buhead', 'manager')->where('bu_token', $token)->orderBy('id', 'desc')->first();

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
                    'request_for' => $data->request_for,
                 ];

               
 
                 if($data){
                    if( empty($data->approved) ){
                        if( empty($data->bu_rejected) ){
                            // Manager Part

                            $data->bu_rejected = Carbon::now();
                            $data->verify_status = 3;
                            $success = $data->save();

                            self::rejectEmail($data);


                            if($success){
                                $notification = [ 'status' => 'reject' ,'msg'=> 'Successfully Rejected', 'data'=> $userData ];
                            }else{
                                $notification = [ 'status' => 'error', 'msg'=> 'Somthing going wrong. Try again, please.', 'data'=> null ];
                            }

                        }else{
                            $notification = [ 'status' => 'warning', 'msg'=> 'Already Rejected', 'data'=> $userData ];
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


    // Reject Email
    public static function rejectEmail($data){

        if(!empty($data->office_email)){
            $to = $data->office_email;
        }else{
            $to = $data->personal_email;
        }

        if(empty($to)){
            return response()->json([
                'msg' => 'Sending Email Error !!'
            ], 422);  
        }

        $sub = $data->name.' : Internet / Web Access Request Update';

        $mailData = [
            'to'=> $to,
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
            $message->subject( $mailData['sub'] );
            $message->from( 'it-noreply@cpbangladesh.com' );
        });

        return true;
    }

}
