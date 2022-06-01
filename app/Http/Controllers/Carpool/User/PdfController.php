<?php

namespace App\Http\Controllers\Carpool\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    //base_64_format
    public function base_64_format(){

        
        $base64 = '';
        $status = '';
        $msg    =  '';

        // $path = 'myfile.pdf';

        $path = '/images/carpool/manual/user_manual.pdf';


        $fileExist = File::exists($path);

        //dd($fileExist, $path);

        if(!$fileExist){
            $status = 'error';
            $msg    =  'File Not Exist';
        }

        $infoPath = pathinfo(public_path($path));
        $extension = $infoPath['extension'];

        if( $extension != 'pdf'){
            $status = 'error';
            $msg    = 'File is not PDF';
        }

        //dd( $fileExist, $infoPath, $extension );

        if($fileExist && $extension == 'pdf'){
            $file = file_get_contents($path);
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $base64 = base64_encode($file);
            $status = 'success';
        }else{
            $msg    = 'File not converted';
            $status = 'error';
        }

        return response()->json(['status'=>$status, 'base64' => $base64, 'msg'=>$msg]);

    }
}
