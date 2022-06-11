<?php

namespace App\Http\Controllers\iAccess;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Illuminate\Support\Str;
use App\Models\iAccess\iaccessInternetRequestMail;
use Illuminate\Support\Facades\Mail;

class CommonController extends Controller
{
    //
    public static function MailSendInternet($val){

        $data = new iaccessInternetRequestMail();



    }


    
    // Upload Documents
    public static function documentUpload($document, $uploadDocPath = 'images/', $docName=null){

        $document_full_name = '';
        if($document){
            $document_name      = $docName.time().Str::random(15);
            $ext                = strtolower($document->getClientOriginalExtension());
            $document_full_name = $document_name . '.' . $ext;
           // $document_url       = $uploadDocPath . $document_full_name;
            $successImg         = $document->move($uploadDocPath, $document_full_name);
        }
       
        return $document_full_name;
    }



    public static function MailSendIWAccessRequest($data, $to, $sub){
       // $managerName = $data->manager['name'];
        
        //$managerMail = $data->manager->office_email;
        // $managerMail = 'saifulislamw60@gmail.com';
        // $subject = $data->name.' : Official Internet Access Request';
        
        $mailData = [
            'to'         => $managerMail,
            'subject'    => $subject,
            'data'       => $data
        ];

       //dd($mailData);
        //Send Mail
        Mail::send('iaccess.user.email.iaccess-email', compact('mailData'), function ($message) use ($mailData) {
            $message->to( $mailData['to'] );
            $message->subject( $mailData['subject'] );
            $message->from( 'it-noreply@cpbangladesh.com' );
            //If Attachment Have
            // if ( !empty($item->document) ) {

            //     $message->attach( public_path('images/iaccess/document/'.$item->document.'pdf') );
            // }
        });

    }


    public function pdf_get_file(){
        $path = Request('document');
        
        $infoPath = pathinfo(public_path($path));
        
        $extension = $infoPath['extension'];

        if($extension == 'pdf'){
            $file = file_get_contents($path);
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $base64 = base64_encode($file);
            return response()->json($base64);
        }
    }


    public static function RunningNumberGenerate( $prefix=null, $lastNumber = null ){
        
        if($lastNumber){
            //$number = $lastData->number;
            //$firts6ch = substr($lastNumber, 0, 6);
            $lastNum = (int) substr($lastNumber,6) + 1;
            $number = $prefix.date('y').date('m').$lastNum;
            //dd($number,$firts6ch, $lastNum);
        }else{
            $prefix = $prefix??'NA'; 
            $number = $prefix.date('y').date('m').'1';
        }
        return $number;
    }


}
