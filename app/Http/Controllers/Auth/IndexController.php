<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

class IndexController extends Controller
{
    //index
    public function index(){

        if( Auth::check() ){
            return redirect()->route('dashboard');
        }

        return view('auth.index');
    }


    // registerManual
    public function registerManual(){
        $path = public_path('/manuals/register/Register_Manual.pdf');

        $infoPath = pathinfo($path);
        $extension = $infoPath['extension'];

        if($extension == 'pdf'){
            $file = file_get_contents($path);
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $base64 = base64_encode($file);
            return response()->json($base64);
        }

    }
}
