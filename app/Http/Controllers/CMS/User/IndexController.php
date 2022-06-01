<?php

namespace App\Http\Controllers\CMS\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cms\Application\ApplicationComplain;
use App\Models\Cms\Hardware\HardwareComplain;

use Auth;

class IndexController extends Controller
{
    //index
    public function index(){
        $roles = Auth::user()->roles->pluck('name');
        // $ivcaData = Auth::user()->ivca_roles->pluck('name');
        // // Merge collections
        // $roles = $roleData->merge($ivcaData);
        return view('cms.user.index', compact('roles'));
    }


    public function ratings(){

        $applyDate = '2022-06-01 01:00:00';

        $app  =  ApplicationComplain::where('process', 'Closed')
            ->whereNull('rating')
            ->where('user_id', Auth::user()->id)
            ->where('updated_at', '>', $applyDate)
            ->count();

        $hard =  HardwareComplain::where('process', 'Closed')
            ->whereNull('rating')
            ->where('user_id', Auth::user()->id)
            ->where('updated_at', '>', $applyDate)
            ->count();

        return response()->json(['appRating'=>$app,'hardRating'=>$hard]);

    }
}
