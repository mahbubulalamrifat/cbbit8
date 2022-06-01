<?php

namespace App\Http\Controllers\PBI\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use App\Models\User;

class IndexController extends Controller
{
    //index
    public function index(){
        $roles = Auth::user()->roles->pluck('name');
        $otherData = Auth::user()->pbi_roles->pluck('name');
        // // Merge collections
        $roles = $roles->merge($otherData);
        // dd( $roles);
        return view('pbi.admin.index', compact('roles'));
    }

    // dashboard_data
    public function dashboard_data(){

        $total_user = User::with('pbi_roles')
        ->where('delete_temp', '!=', '1')
        ->count();

        $pbi_user = User::with('pbi_roles')
        ->where('delete_temp', '!=', '1')
        ->whereHas( 'roles', function($query){
            $query->where( 'name', 'Powerbi' );
        })
        ->count();

        $pbi_admin = User::with('pbi_roles')
        ->where('delete_temp', '!=', '1')
        ->whereHas( 'roles', function($query){
            $query->where( 'name', 'Powerbi-admin' );
        })
        ->count();

        return response()->json(['total_user'=> $total_user, 'pbi_user'=> $pbi_user, 'pbi_admin'=> $pbi_admin]);

    }
}
