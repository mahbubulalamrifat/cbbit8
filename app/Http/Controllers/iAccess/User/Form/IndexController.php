<?php

namespace App\Http\Controllers\iAccess\User\Form;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\iAccess\iaccessEmailRequest;
use App\Http\Models\iAccess\iaccessAccountRequest;
use App\Http\Models\iAccess\iaccessGuestRequest;
use App\Http\Models\iAccess\iaccessInternetRequest;
use Auth;
use Carbon\Carbon;

class IndexController extends Controller
{
    //email_store
    public function email_store(Request $request){


        //Validate
        $this->validate($request,[
            'name'              => 'required',
            'branch'            => 'required',
            'position'          => 'required',
            'department'        => 'required',
            'office_mobile'     => 'nullable',
            'personal_mobile'   => 'nullable',
            'personal_email'    => 'required',
            'bu_head_email'     => 'nullable',

            'request_for'       => 'required',
            'requested_email'   => 'nullable',
            'purpose'           => 'required',
        ]);

        $data = new iaccessEmailRequest();

    
        $data->name              = $request->name;
        $data->branch            = $request->branch;
        $data->position          = $request->position;
        $data->department        = $request->department;
        $data->office_mobile     = $request->office_mobile;
        $data->personal_mobile   = $request->personal_mobile;
        $data->personal_email    = $request->personal_email;
        $data->bu_head_email     = $request->bu_head_email;

        $data->request_for       = $request->request_for;
        $data->requested_email   = $request->requested_email;
        $data->purpose           = $request->purpose;

        $data->signature         = $request->name;
        $data->date              = Carbon::new();
        
        $data->created_by   =  Auth::user()->id;
        $success            = $data->save();

        if($success){
            return response()->json(['msg'=>'Stored Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }


    //internet_store
    public function internet_store(Request $request){

        //Validate
        $this->validate($request,[
            'name'              => 'required',
            'branch'            => 'required',
            'position'          => 'required',
            'department'        => 'required',
            'office_mobile'     => 'nullable',
            'personal_mobile'   => 'nullable',
            'personal_email'    => 'required',
            'office_email'      => 'nullable',

            'request_for'       => 'required',
            'internet_id'       => 'nullable',
            'purpose'           => 'required',
        ]);

        $data = new iaccessInternetRequest();

    
        $data->name              = $request->name;
        $data->branch            = $request->branch;
        $data->position          = $request->position;
        $data->department        = $request->department;
        $data->office_mobile     = $request->office_mobile;
        $data->personal_mobile   = $request->personal_mobile;
        $data->personal_email    = $request->personal_email;
        $data->office_email      = $request->office_email;

        $data->request_for       = $request->request_for;
        $data->internet_id       = $request->internet_id;
        $data->purpose           = $request->purpose;

        $data->signature         = $request->name;
        $data->date              = Carbon::new();
        
        $data->created_by   =  Auth::user()->id;
        $success            = $data->save();

        if($success){
            return response()->json(['msg'=>'Stored Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }


    //account_store
    public function account_store(Request $request){

        //Validate
        $this->validate($request,[
            'name'              => 'required',
            'branch'            => 'required',
            'position'          => 'required',
            'department'        => 'required',
            'office_mobile'     => 'nullable',
            'personal_mobile'   => 'nullable',
            'personal_email'    => 'required',
            'office_email'      => 'nullable',

            'request_for'       => 'required',
            'access_for'        => 'nullable',
            'purpose'           => 'required',
        ]);

        $data = new iaccessAccountRequest();

    
        $data->name              = $request->name;
        $data->branch            = $request->branch;
        $data->position          = $request->position;
        $data->department        = $request->department;
        $data->office_mobile     = $request->office_mobile;
        $data->personal_mobile   = $request->personal_mobile;
        $data->personal_email    = $request->personal_email;
        $data->office_email      = $request->office_email;

        $data->request_for       = $request->request_for;
        $data->access_for        = $request->access_for;
        $data->purpose           = $request->purpose;

        $data->signature         = $request->name;
        $data->date              = Carbon::new();
        
        $data->created_by   =  Auth::user()->id;
        $success            = $data->save();

        if($success){
            return response()->json(['msg'=>'Stored Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }


    //guest_store
    public function guest_store(Request $request){

        //Validate
        $this->validate($request,[
            'name'              => 'required',
            'branch'            => 'required',
            'position'          => 'required',
            'department'        => 'required',
            'mobile'            => 'nullable',
            'personal_email'    => 'required',

            'guest_company'     => 'required',
            'no_of_guest'       => 'nullable',
            'guest_job'         => 'required',
            'guest_duration'    => 'required',
            'start_date'        => 'nullable',
            'end_date'          => 'required',
        ]);

        $data = new iaccessGuestRequest();

    
        $data->name              = $request->name;
        $data->branch            = $request->branch;
        $data->position          = $request->position;
        $data->department        = $request->department;
        $data->mobile            = $request->mobile;
        $data->personal_email    = $request->personal_email;

        $data->guest_company     = $request->guest_company;
        $data->no_of_guest       = $request->no_of_guest;
        $data->guest_job         = $request->guest_job;
        $data->guest_duration    = $request->guest_duration;
        $data->start_date        = $request->start_date;
        $data->end_date          = $request->end_date;

        $data->signature         = $request->name;
        $data->date              = Carbon::new();
        
        $data->created_by   =  Auth::user()->id;
        $success            = $data->save();

        if($success){
            return response()->json(['msg'=>'Stored Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }
}
