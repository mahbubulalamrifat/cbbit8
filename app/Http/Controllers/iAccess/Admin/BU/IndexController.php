<?php

namespace App\Http\Controllers\iAccess\Admin\BU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\iAccess\iaccessBu;
use Auth;


class IndexController extends Controller
{
    
    //index
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = iaccessBu::with('makby')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    }

   
    // store
    public function store(Request $request){

        //Validate
        $this->validate($request,[
            'name'     => 'required|string|max:100',
            'email'    => 'required|string|max:100|unique:iaccess_bus',
            'designation' => 'nullable|string|max:100',
        ]);

        $data = new iaccessBu();

    
        $data->name       = $request->name;
        $data->email       = $request->email;
        $data->designation       = $request->designation;
        $data->status     = 1;
        $data->created_by =  Auth::user()->id;
        $success          = $data->save();

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
            'name'      => 'required|string|max:100',
            'email'     => 'required|string|max:1000|unique:iaccess_bus,email,'.$id,
            'designation' => 'nullable|string|max:100',
        ]);

        $data = iaccessBu::find($id);

      
        $data->name       = $request->name;
        $data->email      = $request->email;
        $data->designation  = $request->designation;
        $data->created_by = Auth::user()->id;
        $success          = $data->save();

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
        $data       =  iaccessBu::find($id);
        $success    =  $data->delete();
        return response()->json('success', 200);
      
    }


    // status
    public function status($id){

        $data       =  iaccessBu::find($id);
        if($data){

           $status = $data->status;
           
            if($status == 1){
                $data->status = null;
            }else{
                $data->status = 1;
            }
            $success    =  $data->save();
            return response()->json('success', 200);

        }

    }
}
