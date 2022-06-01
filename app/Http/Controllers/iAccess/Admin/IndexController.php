<?php

namespace App\Http\Controllers\iAccess\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\iAccess\iaccessInternetRequest;
use App\Models\iAccess\iaccessAccountRequest;
use App\Models\iAccess\iaccessEmailRequest;
use App\Models\iAccess\iaccessGuestRequest;

use Auth;

class IndexController extends Controller
{
    public function index(){
        $roles = Auth::user()->roles->pluck('name');
        return view('iaccess.admin.index', compact('roles'));
    }

    // sidebar_count_data
    public function sidebar_count_data(){

        $internetData = iaccessInternetRequest::whereNotNull('bu_approved')->whereNull('verify_status')->count();
        $accountData = iaccessAccountRequest::whereNotNull('bu_approved')->whereNull('verify_status')->count();
        $emailData = iaccessEmailRequest::whereNotNull('bu_approved')->whereNull('verify_status')->count();
        $guestData = iaccessGuestRequest::whereNotNull('bu_approved')->whereNull('verify_status')->count();

        return response()->json(['internet'=> $internetData, 'account'=> $accountData, 'email'=> $emailData, 'guest'=> $guestData]);
    }


    public function dashboard_data(Request $request){
        $internetData = iaccessInternetRequest::count();
        $accountData = iaccessAccountRequest::count();
        $emailData = iaccessEmailRequest::count();
        $guestData = iaccessGuestRequest::count();

        $data = [
            'internetData' => $internetData,
            'accountData' => $accountData,
            'emailData' => $emailData,
            'guestData' => $guestData,
        ];

        return response()->json($data);
    }
}
