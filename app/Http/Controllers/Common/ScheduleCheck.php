<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;

class ScheduleCheck extends Controller
{
    //Check Any error in schedules
    public static function ErrorMsgOnLine($msg = 'Somthing going wrong'){

        $today  = date("j-M-Y", strtotime( Carbon::today() ) );


        //*************For Sending Line Group Message*******************//
        $message = "#: $today, %0A $msg" ;

        // $message = "Booked #: $count, %0A Today Date ($today), %0A Booked By: $userName,%0A Department: $department,%0A Purpose: $purposeLine,%0A Car: $carName,%0A Start: $startLine,%0A End: $endLine,%0A Duration : $duration. ";


        //Send Line Message
       self::lineMsg($message);

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

        // //Test Group
        // $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.config('values.line_test_key'),);  // ��ѧ����� Bearer ��� line authen code �

        //Car Booking Group
        $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.config('values.line_schedule_key'),);  // ��ѧ����� Bearer ��� line authen code � env('APP_DEBUG')
        
        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
        //RETURN
        curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($chOne);

        //Check error
        if (curl_error($chOne)) {
            echo 'error:' . curl_error($chOne);
        } else {
            $result_ = json_decode($result, true);

            //************Status Print *************//

            //echo "status : ".$result_['status']; echo "message : ". $result_['message'];
            //echo "SMS send Successfully";
        }
        //Close connect
        curl_close($chOne);
    }
}
