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

class IndexController extends Controller
{
    // all_notification
    public function all_notification(){
        //dd("ok");

        // iaccess notification
        $internetData = iaccessInternetRequest::whereNotNull('bu_approved')->whereNull('verify_status')->count();
        $accountData = iaccessAccountRequest::whereNotNull('bu_approved')->whereNull('verify_status')->count();
        $emailData = iaccessEmailRequest::whereNotNull('bu_approved')->whereNull('verify_status')->count();
        $guestData = iaccessGuestRequest::whereNotNull('bu_approved')->whereNull('verify_status')->count();

        //return response()->json(['internet'=> $internetData, 'account'=> $accountData, 'email'=> $emailData, 'guest'=> $guestData]);

        // application notification
        $application_notprocess = ApplicationComplain::with('makby', 'category', 'subcategory')
            ->where('status', 1)
            ->where('process', 'Not Process')
            ->count();

        // process
        $application_process = ApplicationComplain::with('makby', 'category', 'subcategory')
            ->where('status', 1)
            ->where('process', 'Processing')
            ->count();

        //return response()->json(['application_notprocess'=>$application_notprocess,'application_process'=>$application_process]);

        // hardware notification
        $accessZoneOffices = CommonController::NotificationZoneOfficesByAuth();


        $hardware_notprocess = HardwareComplain::with('makby')
            ->where('status', 1)
            ->whereHas('makby', function($q) use($accessZoneOffices){
                $q->whereIn('zone_office', $accessZoneOffices);
            })
            ->whereHas('makby', function($q) use($accessZoneOffices){
                $q->whereIn('zone_office', $accessZoneOffices);
            })
            ->where('process', 'Not Process')
            ->count();


        // process
        $hardware_process = HardwareComplain::with('makby')
            ->where('status', 1)
            ->whereHas('makby', function($q) use($accessZoneOffices){
                $q->whereIn('zone_office', $accessZoneOffices);
            })
            ->where('process', 'Processing')
            ->count();

        // deliverable 
        $hardware_deliverable = HardwareComplain::with('makby')
        ->whereHas('makby', function($q) use($accessZoneOffices){
            $q->whereIn('zone_office', $accessZoneOffices);
        })
        ->where('process', 'Deliverable')
        ->count();

         
        $hardware_service = HardwareComplain::with('makby')
            ->where('status', 1)
            ->whereHas('makby', function($q) use($accessZoneOffices){
                $q->whereIn('zone_office', $accessZoneOffices);
            })
            ->whereIn('process', ['Send Service', 'Back Service', 'Again Send Service', 'Service Quotation'])
            ->count();

        $hardware_serviceAccess = HardwareComplain::with('makby')
            ->whereIn('process', ['Send Service', 'Back Service', 'Again Send Service', 'Service Quotation'])
            ->count();

        // HO Service 
        $hardware_hoServiceAccess = HardwareComplain::with('makby')
            ->where('status', 1)
            ->where('process', 'HO Service')
            ->count();

        $hardware_hoService = HardwareComplain::with('makby')
            ->where('status', 1)
            ->whereHas('makby', function($q) use($accessZoneOffices){
                $q->whereIn('zone_office', $accessZoneOffices);
            })
            ->where('process', 'HO Service')
            ->count();

        $hardware_appDamage = HardwareComplain::with('dam_apply')
            ->whereHas('dam_apply', function($q){
                $q->where('applicable_type', 'Applicable');
            })
            ->where('process', 'Damaged')
            ->count();

        $hardware_appPartialDamage = HardwareComplain::with('dam_apply')
            ->whereHas('dam_apply', function($q){
                $q->where('applicable_type', 'Applicable');
            })
            ->where('process', 'Partial Damaged')
            ->count();

        $hardware_notAppDamage = HardwareComplain::with('dam_apply')
            ->whereHas('dam_apply', function($q){
                $q->where('applicable_type', 'Not Applicable');
            })
            ->where('process', 'Damaged')
            ->count();

        $hardware_notAppPartialDamage = HardwareComplain::with('dam_apply')
            ->whereHas('dam_apply', function($q){
                $q->where('applicable_type', 'Not Applicable');
            })
            ->where('process', 'Partial Damaged')
            ->count();

        // return response()->json([
        //     // iaccess
        //     'internet'=> $internetData, 'account'=> $accountData, 'email'=> $emailData, 'guest'=> $guestData,
        //     // application
        //     'application_notprocess'=>$application_notprocess,'application_process'=>$application_process,
        //     // hardware
        //     'hardware_notprocess'=>$hardware_notprocess,'hardware_process'=>$hardware_process, 'hardware_deliverable'=>$hardware_deliverable, 'hardware_service'=>$hardware_service , 'hardware_serviceAccess'=>$hardware_serviceAccess, 'hardware_hoService'=>$hardware_hoService, 'hardware_hoServiceAccess'=>$hardware_hoServiceAccess, 'hardware_appDamage'=>$hardware_appDamage, 'hardware_appPartialDamage'=>$hardware_appPartialDamage, 'hardware_notAppDamage'=>$hardware_notAppDamage, 'hardware_notAppPartialDamage'=>$hardware_notAppPartialDamage
        // ]);

        $today   = date("j-F-Y, g:i A"); 
        $message = "#All Pending: $today %0A";
        // iaccess
        if( $internetData != 0 && $accountData != 0 && $emailData != 0 && $guestData != 0 ){
            $message .= "iAccess %0A";
        }
        if( $internetData != 0 ){
            $message .= "Pending Internet Access Request: $internetData %0A";
        }
        if( $accountData != 0 ){
            $message .= "Pending Account Authority Request: $accountData %0A";
        }
        if( $emailData != 0 ){
            $message .= "Pending Email Request: $emailData %0A";
        }
        if( $guestData != 0 ){
            $message .= "Pending Guest User Request: $guestData %0A";
        }
        
       
        
        
        // application
        if( $application_notprocess != 0 && $application_process != 0 ){
            $message .= "Application(CMS) %0A";
        }
        if( $application_notprocess != 0 ){
            $message .= "Not Process Complain: $application_notprocess %0A";
        }
        if( $application_process != 0 ){
            $message .= "Processing Complain: $application_process %0A";
        }
        
        
        // hardware
        $message .= "Hardware(CMS) %0A";
        if( $hardware_notprocess != 0 ){
            $message .= "Not Process Complain: $hardware_notprocess %0A";
        }
        if( $hardware_process != 0 ){
            $message .= "Processing Complain: $hardware_process %0A";
        }
        if( $hardware_deliverable != 0 ){
            $message .= "Deliverable Product: $hardware_deliverable %0A";
        }
        if( $hardware_service != 0 ){
            $message .= "Service Product: $hardware_service %0A";
        }
        if( $hardware_serviceAccess != 0 ){
            $message .= "Service Access Product: $hardware_serviceAccess %0A";
        }
        if( $hardware_hoService != 0 ){
            $message .= "Head-office Service: $hardware_hoService %0A";
        }
        if( $hardware_hoServiceAccess != 0 ){
            $message .= "Head-office Service Access: $hardware_hoServiceAccess %0A";
        }
        if( $hardware_appDamage != 0 ){
            $message .= "Damage Applicable Product: $hardware_appDamage %0A";
        }
        if( $hardware_appPartialDamage != 0 ){
            $message .= "Partial Damage Applicable Product: $hardware_appPartialDamage %0A";
        }
        if( $hardware_notAppDamage != 0 ){
            $message .= "Not Applicable Damage Product: $hardware_notAppDamage %0A";
        }
        if( $hardware_notAppPartialDamage != 0 ){
            $message .= "Not Applicable Partial Damage Product: $hardware_notAppPartialDamage %0A";
        }
        
        self::lineMsg($message);


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
        $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.config('values.line_test_key'),); 

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
