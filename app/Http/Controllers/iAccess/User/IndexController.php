<?php

namespace App\Http\Controllers\iAccess\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\iAccess\iaccessBu;

class IndexController extends Controller
{
    public function index(){
        $roles = Auth::user()->roles->pluck('name');
        return view('iaccess.user.index', compact('roles'));
    }

    // manager_bu_list
    public function manager_bu_list(){

        $userList = User::where('status', 1)->where('delete_temp', '!=', '1')->select('id', 'name', 'office_email', 'department', 'business_unit')->get();

        $allDepartment = User::where('status', 1)
        ->whereNotNull('department')
        ->Where('department','<>','')
        ->select('department')
        ->orderBy('department')
        ->distinct()
        ->get()
        ->toArray();

        $allOffices = User::where('status', 1)
        ->whereNotNull('zone_office')
        ->Where('zone_office','<>','')
        ->select('zone_office')
        ->orderBy('zone_office')
        ->distinct()
        ->get()
        ->toArray();
        
        $buList = iaccessBu::where('status', 1)->get();

        return response()->json(['userList'=>$userList, 'buList'=>$buList, 'allDepartment'=> $allDepartment, 'allOffices'=>$allOffices ], 200);

    }


    // iaccessManual
    public function iaccessManual(){
        $path = public_path('/manuals/iaccess/Iaccess_Manual.pdf');

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
