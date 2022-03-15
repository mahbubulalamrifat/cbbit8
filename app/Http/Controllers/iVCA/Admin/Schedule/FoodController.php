<?php

namespace App\Http\Controllers\iVCA\Admin\Schedule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\iVca\ivcaVendorList;
use App\Models\iVca\ivcaFoodSchedule;
use Auth;
use App\Models\User;

class FoodController extends Controller
{
    
    //index
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = ivcaFoodSchedule::with(['vendor', 'user'])->orderBy($sort_field, $sort_direction)
                ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
                ->paginate($paginate);

        return response()->json($allData, 200);

    }


    //vendor_list
    public function vendor_list(){
        $allData = ivcaVendorList::where('status', 1)
                ->where('blocked', null)
                ->orderBy('vendor_number')
                ->get();

        return response()->json($allData, 200);
    }


    //user_list
    public function user_list(){
        $allData = user::where('status', 1)
                ->whereHas('roles', function($query){
                    // Check User Role
                    $query->where('name', ['Ivca', 'Ivca-admin']);
                })
                // ->whereHas('ivca_roles', function($query){
                //     // check iVCA Role
                //     $query->where('name', ['Auditor', 'Food']);
                // })
                ->whereHas('ivca_roles', function($query){
                    // check iVCA Role
                    $query->where('name', 'Auditor');
                })
                ->whereHas('ivca_roles', function($query){
                    // check iVCA Role
                    $query->where('name', 'Food');
                })
                ->orderBy('name')
                ->get();

        return response()->json($allData, 200);
    }


   


    // store
    public function store(Request $request){

        //dd($request->all(), $request->image);

        //Validate
        $this->validate($request,[
            'vendor_id'         => 'required',
            'user_id'           => 'required',
            'date'              => 'required',
            'business_type'     => 'required|string|max:500',
            'purchased_product' => 'required|string|max:500',
            'remarks'           => 'nullable|string|max:1000',
        ]);
        $vendor_id = $request->vendor_id;
        $date = $request->date;

        // Check have any schedule  
        $scheduleCount = ivcaFoodSchedule::where('vendor_id', $vendor_id)->where('date', $date)->count();
        if($scheduleCount > 0){
            return response()->json(['msg'=>'Schedule already assigned &#128542;', 'icon'=>'error'], 200);
        }

        $data = new ivcaFoodSchedule();
        

        $data->vendor_id            = $vendor_id;
        $data->date                 = $date;
        $data->user_id              = $request->user_id;
        $data->business_type        = $request->business_type;
        $data->purchased_product    = $request->purchased_product;
        $data->remarks              = $request->remarks;
        $data->status               = null;
        $data->created_by           = Auth::user()->id;
        $success                    = $data->save();

        if($success){
            return response()->json(['msg'=>'Stored Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }


    // update
    public function update(Request $request, $id){

        //Validate
        $this->validate($request,[
            'vendor_id'         => 'required',
            'user_id'           => 'required',
            'date'              => 'required',
            'business_type'     => 'required|string|max:500',
            'purchased_product' => 'required|string|max:500',
            'remarks'           => 'nullable|string|max:1000',
        ]);

        $vendor_id = $request->vendor_id;
        $user_id = $request->user_id;
        $date = $request->date;

        // Check match any schedule
        $scheduleCount = ivcaFoodSchedule::where('id', '!=', $id)
                        ->where('vendor_id', $vendor_id)
                        ->where('date', $date)
                        ->count();
        if($scheduleCount > 0){
            return response()->json(['msg'=>'Schedule already assigned &#128542;', 'icon'=>'error'], 200);
        }

        $data = ivcaFoodSchedule::find($id);

      
        $data->vendor_id            = $vendor_id;
        $data->date                 = $date;
        $data->user_id              = $request->user_id;
        $data->business_type        = $request->business_type;
        $data->purchased_product    = $request->purchased_product;
        $data->remarks              = $request->remarks;
        $data->status               = null;
        $data->created_by           = Auth::user()->id;
        $success                    = $data->save();

        if($success){
            return response()->json(['msg'=>'Updated Successfully &#128515;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }

    // destroy
    public function destroy($id)
    {
        $data       =  ivcaFoodSchedule::find($id);
        $success    =  $data->delete();

        return response()->json('success', 200);
      
    }


    // status
    public function status($id){

        $data       =  ivcaFoodSchedule::find($id);
        if($data){

           $status = $data->status;
           
            if($status == 1){
                $data->status = null;
                $data->status_by = Auth::user()->id;
            }else{
                $data->status = 1;
                $data->status_by = Auth::user()->id;
            }
            $success    =  $data->save();
            return response()->json('success', 200);

        }

    }



}

