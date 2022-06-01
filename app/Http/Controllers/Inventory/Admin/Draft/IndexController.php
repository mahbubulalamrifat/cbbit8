<?php

namespace App\Http\Controllers\Inventory\Admin\Draft;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\InventoryReplyDraft;
use Auth;

class IndexController extends Controller
{
    
    //index
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = InventoryReplyDraft::with('makby')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    }

    // all_data
    public function all_data(){
        $allData = InventoryReplyDraft::where('status', 1)->select('name AS text', 'details AS value')->get()->toArray();
        return response()->json($allData, 200);
    }

   
    // store
    public function store(Request $request){

        //dd($request->all(), $request->image);

        //Validate
        $this->validate($request,[
            'name'     => 'required|string|max:100|unique:inventory_reply_drafts',
            'details'  => 'required|string|min:10|max:20000'
        ]);

        $data = new InventoryReplyDraft();

    
        //$data->name    = ucwords(strtolower($request->name));
        $data->name       = $request->name;
        $data->details    = $request->details;
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
    public function update(Request $request){

        $id = $request->id;

        //Validate
        $this->validate($request,[
            'name'     => 'required|string|max:1000|unique:inventory_reply_drafts,name,'.$id,
            'details'  => 'required|string|min:10|max:20000'
        ]);

        $data = InventoryReplyDraft::find($id);

      
        $data->name       = $request->name;
        $data->details    = $request->details;
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

    // destroy_temp
    public function destroy_temp($id)
    {
        $data       =  InventoryReplyDraft::find($id);
        $data->delete_temp  = 1;
        $data->delete_by    =  Auth::user()->id;
        $data->save();

        return response()->json('success', 200);
      
    }

    // destroy
    public function destroy(Request $request)
    {
        $id = $request->id;
        $data       =  InventoryReplyDraft::find($id);
        $success    =  $data->delete();
        return response()->json('success', 200);
      
    }


    // status
    public function status($id){

        $data       =  InventoryReplyDraft::find($id);
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