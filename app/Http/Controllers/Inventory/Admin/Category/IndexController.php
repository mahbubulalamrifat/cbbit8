<?php

namespace App\Http\Controllers\Inventory\Admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Inventory\inventoryCategory;
use Auth;

class IndexController extends Controller
{
    
    //index
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = inventoryCategory::with('makby')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    }

    // all
    public function all(){
        //dd("test");
        $allData = inventoryCategory::orderBy('name')->get();
        return response()->json($allData);
    }

    // stock
    public function stock(){
        //dd("test");
        $allData = inventoryCategory::where('stock', 'y')->orderBy('name')->get();
        return response()->json($allData);
    }

   
    // store
    public function store(Request $request){

        //dd($request->all(), $request->image);

        //Validate
        $this->validate($request,[
            'name'     => 'required|string|max:500|unique:inventory_categories',
        ]);

        $data = new inventoryCategory();

    
        //$data->name    = ucwords(strtolower($request->name));
        $data->name       = $request->name;
        $data->stock      = $request->stock;
        $data->created_by = Auth::user()->id;
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
    public function update(Request $request){

        $id = Request('id');

        //Validate
        $this->validate($request,[
            'name'     => 'required|string|max:500|unique:inventory_categories,name,'.$id,
        ]);

        $data = inventoryCategory::find($id);

      
        $data->name       = $request->name;
        $data->stock      = $request->stock;
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
        $data       =  inventoryCategory::find($id);
        $success    =  $data->delete();
        return response()->json('success', 200);
      
    }


    // status
    public function status($id){

        $data       =  inventoryCategory::find($id);
        if($data){

           $status = $data->status;
           
            if($status == 1){
                $data->status = null;
            }else{
                $data->status = 1;
            }
            $data->created_by = Auth::user()->id;
            $success    =  $data->save();
            return response()->json('success', 200);

        }

    }
}