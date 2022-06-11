<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


// iaccess
use App\Models\iAccess\iaccessInternetRequest;
use App\Models\iAccess\iaccessAccountRequest;
use App\Models\iAccess\iaccessEmailRequest;
use App\Models\iAccess\iaccessGuestRequest;

// application
use App\Models\Cms\Application\ApplicationComplain;

// hardware
use App\Http\Controllers\CMS\HardwareAdmin\CommonController;
use App\Models\Cms\Hardware\HardwareComplain;

use Carbon\Carbon;
use App\Models\UserReginster;

class IndexController extends Controller
{
    // PendingNotify
    public function pendingNotify(){
        //dd("ok");

        // iaccess notification
        $internetData = iaccessInternetRequest::whereNotNull('bu_approved')->whereNull('verify_status')->count();
        $accountData = iaccessAccountRequest::whereNotNull('bu_approved')->whereNull('verify_status')->count();
        $emailData = iaccessEmailRequest::whereNotNull('bu_approved')->whereNull('verify_status')->count();
        $guestData = iaccessGuestRequest::whereNotNull('bu_approved')->whereNull('verify_status')->count();

        //return response()->json(['internet'=> $internetData, 'account'=> $accountData, 'email'=> $emailData, 'guest'=> $guestData]);

        // application notification
        $application_notprocess = ApplicationComplain::where('status', 1)
            ->where('process', 'Not Process')
            ->count();

        // process
        $application_process = ApplicationComplain::where('status', 1)
            ->where('process', 'Processing')
            ->count();

        $application_Closed = ApplicationComplain::where('status', 1)
            ->where('process', 'Closed')
            ->count();

        


        // hardware notification
        $hardware_notprocess = HardwareComplain::where('status', 1)
            ->where('process', 'Not Process')
            ->count();


        // process
        $hardware_process = HardwareComplain::where('status', 1)
            ->where('process', 'Processing')
            ->count();

        // deliverable 
        $hardware_deliverable = HardwareComplain::where('process', 'Deliverable')
        ->count();

         
        $hardware_service = HardwareComplain::where('status', 1)
            ->whereIn('process', ['Send Service', 'Back Service', 'Again Send Service', 'Service Quotation'])
            ->count();

        $hardware_hoService = HardwareComplain::where('status', 1)
            ->where('process', 'HO Service')
            ->count();

        $hardware_Damage = HardwareComplain::whereIn('process', ['Damaged', 'Partial Damaged'])
            ->count();
        
        $hardware_Closed = HardwareComplain::where('status', 1)->where('process', 'Closed')
            ->count();


        // User Register 
        $user_register = UserReginster::where('verify', '0')->count();

      

        $today   = date("j-F-y, g:i A"); 
        $message = "CPB-IT Portal Pendings:$today %0A";
        // iaccess
        if( $internetData != 0 || $accountData != 0 || $emailData != 0 || $guestData != 0 ){
            $message .= "iAccess: %0A";
        }
        if( $internetData != 0 ){
            $message .= "Internet Access: $internetData %0A";
        }
        if( $accountData != 0 ){
            $message .= "Account Authority: $accountData %0A";
        }
        if( $emailData != 0 ){
            $message .= "Email: $emailData %0A";
        }
        if( $guestData != 0 ){
            $message .= "Guest User: $guestData%0A";
        }
        

        
        
       
        
        
        // application
        if( $application_notprocess != 0 || $application_process != 0 ){
            $message .= "%0AApplication(CMS): %0A";
        }
        if( $application_notprocess != 0 ){
            $message .= "Not Process: $application_notprocess %0A";
        }
        if( $application_process != 0 ){
            $message .= "Processing: $application_process%0A";
        }
        if( $application_Closed != 0 ){
            $message .= "Closed: $application_Closed%0A";
        }
        
        
        
        // hardware
        if( $hardware_notprocess != 0 || $hardware_process != 0 || $hardware_deliverable != 0 || $hardware_service != 0 || $hardware_hoService != 0 || $hardware_Damage != 0 ){
            $message .= "%0AHardware(CMS) : %0A";
        }
        
        if( $hardware_notprocess != 0 ){
            $message .= "Not Process: $hardware_notprocess %0A";
        }
        if( $hardware_process != 0 ){
            $message .= "Processing: $hardware_process %0A";
        }
        if( $hardware_deliverable != 0 ){
            $message .= "Deliverable: $hardware_deliverable %0A";
        }
        if( $hardware_service != 0 ){
            $message .= "Service: $hardware_service %0A";
        }
        if( $hardware_hoService != 0 ){
            $message .= "Head-office Service: $hardware_hoService %0A";
        }
        if( $hardware_Damage != 0 ){
            $message .= "Damaged: $hardware_Damage%0A";
        }
        if( $hardware_Closed != 0 ){
            $message .= "Closed: $hardware_Closed%0A";
        }
      

        // user_register
        if( $user_register != 0 ){
            $message .= "%0ACPB-IT Portal Register: %0A";
            $message .= "User: $user_register %0A";
        }


        
        self::lineMsg($message);

        return true;
    }


    // Schedule function
    public static function PendingNotifySchedule(){
        $this->all_notification();
        return true;
    }


    //Line Message send
    public static function lineMsg($message)
    {
        $chOne = curl_init();
        curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
        // SSL USE
        curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
        //POST
        curl_setopt($chOne, CURLOPT_POST, 1);
        // Message
        curl_setopt($chOne, CURLOPT_POSTFIELDS, $message);
        //��ҵ�ͧ�������ػ ������ 2 parameter imageThumbnail ���imageFullsize
        curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=$message");
        // follow redirects
        curl_setopt($chOne, CURLOPT_FOLLOWLOCATION, 1);

        //Test Group
        $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.config('values.line_cpbit_notify_key'),); 

        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
        //RETURN
        curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($chOne);

        //Check error
        if (curl_error($chOne)) {
            echo 'error:' . curl_error($chOne);
        } else {
            $result_ = json_decode($result, true);

            // ************Status Print *************//

            // echo "status : ".$result_['status']; echo "message : ". $result_['message'];
            // echo "SMS send Successfully";
        }
        //Close connect
        curl_close($chOne);
    }
}
