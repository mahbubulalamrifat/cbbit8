<?php

namespace App\Http\Controllers\Common\Email;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Auth;
use DB;

use Illuminate\Support\Facades\Mail;
use App\Models\Email\ScheduleEmailIaccessGuestReq;
use App\Models\User;

class ScheduleEmailIaccessGuestRequest extends Controller
{
    //store 
    public static function STORE($Data, $doc){

        $userData = User::whereNotNull('manager_id')->where('department',$Data->department)->first();

        $personal_email = $userData->personal_email;
        $office_email   = $userData->office_email;

        if( !empty($office_email) ){
            $to = $office_email;
        }else{
            $to = $personal_email;
        }

        $managerId      = $userData->manager_id;
        if( !empty($managerId) )
        {
            $managerId      = explode(',', $managerId);
            $managerMail    = User::whereIn( 'id', $managerId )->pluck('office_email')->toArray();
            if( !empty($managerMail) ){
                $managerMail    = implode(", ", array_filter($managerMail));
            }else{ $managerMail = null; }
        }
        elseif( !empty($userData->manager_emails) ){
            $managerMail =  $userData->manager_emails;
        }
        else{ $managerMail    = null; }


        $subject = $Data->name.' : Official Guest User Request';

        $data = new ScheduleEmailIaccessGuestReq();

        $data->to             = $managerMail;
        $data->cc             = null;
        $data->name           = $Data->name;
        $data->guest_form_id  = $Data->id;
        $data->subject        = $subject;
        $data->document       = $doc;
        $data->created_by     = $Data->created_by;
        $success              = $data->save();

        if($success){
            return true;
        }else{
            return false;
        }

    }


    // Send Email
    public static function SEND(){

        $counter = ScheduleEmailIaccessGuestReq::whereNull('status')->count();

        if( !empty($counter) ){

            for($i=1; $i <= $counter; $i++){

                $item = ScheduleEmailIaccessGuestReq::whereNull('status')->first();
                
    
                $mailData = [
                    'to'         => $item->to,
                    'cc'         => $item->cc,
                    'name'       => $item->name,
                    'subject'    => $item->subject,
                    'document'   => $item->document,
                ];
    
               
                //Send Mail
                Mail::send('mail.app-complain-action', $mailData, function ($message) use ($mailData) {
                    //Remove if space have
                    $arrayTo = array_map( 'trim', explode(',', $mailData['to']) );
                        $message->to($arrayTo);

                    if( !empty($mailData['cc']) ){
                        $arrayCC = array_map( 'trim', explode(',', $mailData['cc']) );
                        $message->cc($arrayCC);
                    }
                    $message->subject($mailData['subject']);
                    $message->from('it-noreply@cpbangladesh.com');
                    //If Attachment Have
                    if ( !empty($mailData['document']) ) {
                        // $message->attach( public_path('/images/application/'.$mailData['document']) );

                        $message->attach( storage_path('images/iaccess/guest/'.$mailData['document'].'pdf') );
                    }
                });

                $item->status = 1;
                $item->save();

            }

            return true;
            
        }

        return true;

    }

}
