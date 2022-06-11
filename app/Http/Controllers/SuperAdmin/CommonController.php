<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class CommonController extends Controller
{
    //

    public static function GetManagerBuMailArray( $login = null ){

        if( !empty($login) ){

            $data = User::where('login', $login)->select('login', 'manager_id', 'manager_emails')->first();

            $relay = [];
    
            if($data){
                if(!empty($data->manager_id)){
    
                    $idArray = explode(',' , $data->manager_id);
                    $mailArray = [];
    
                    foreach($idArray as $id){
                        $data2 = User::where('id', $id)->select('office_email', 'personal_email')->first();
                        if( $data2 && $data2->office_email ){
                            // office_email
                            $mailArray [] = $data2->office_email;
    
                        }elseif( $data2 && $data2->personal_email ){
                            // personal_email
                            $mailArray [] = $data2->personal_email;
                        }
                    }
    
                    return  $relay = (object) [
                        'status' => 'success',
                        'msg' => 'User manager ID found',
                        'login' => $login,
                        'emails' => $mailArray,
                    ]; 
                
                }elseif( !empty($data->manager_emails) ){
                    $mailArray = explode(',' , $data->manager_emails);
                    return  $relay = (object) [
                        'status' => 'success',
                        'msg' => 'User manager emails found',
                        'login' => $login,
                        'emails' => $mailArray,
                    ]; 
                }
            }
            
            return  $relay = (object) [
                'status' => 'error',
                'msg' => 'User data not found',
                'login' => $login,
                'emails' => [],
            ]; 

        }

        return  $relay = (object) [
            'status' => 'error',
            'msg' => 'User Login ID Error',
            'login' => $login,
            'emails' => [],
        ]; 
       

    }
}
