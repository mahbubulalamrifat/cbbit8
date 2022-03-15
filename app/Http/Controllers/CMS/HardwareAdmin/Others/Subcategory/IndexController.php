<?php

namespace App\Http\Controllers\CMS\HardwareAdmin\Others\Subcategory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cms\Hardware\HardwareSubcategory;
use App\Models\Cms\Hardware\HardwareCategory;
use Auth;

use App\Http\Controllers\CMS\HardwareAdmin\CommonFunctions;

class IndexController extends Controller
{
    use CommonFunctions;
    
    //index
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = HardwareSubcategory::with('makby', 'category')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    }

    // category
    public function category(){
        $allData = HardwareCategory::select('id','name')->orderBy('name')->get();
        return response()->json($allData);
    }

   
    // store
    public function store(Request $request){

        //dd($request->all(), $request->image);

        //Validate
        $this->validate($request,[
            'name'     => 'required|string|max:100|unique:application_subcategories',
            'cat_id'   => 'required',
        ]);

        $data = new HardwareSubcategory();


        $checksubcat = $this->checksubCat($request->cat_id, $request->name);


        if($checksubcat){
            return response()->json([
                'status'=>'error',
                'msg'=>'Subcategory Already Exist in this Category !! &#128530;', 
                'icon'=>'warning'
            ]);
        }

    
        //$data->name    = ucwords(strtolower($request->name));
        $data->name       = $request->name;
        $data->cat_id     = $request->cat_id;
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
    public function update(Request $request, $id){

        //Validate
        $this->validate($request,[
            'name'     => 'required|string|max:1000|unique:application_subcategories,name,'.$id,
            'cat_id'   => 'required',
        ]);

        $data = HardwareSubcategory::find($id);


        $checksubcat = $this->checksubCat($request->cat_id, $request->name);


        if($checksubcat){
            return response()->json([
                'status'=>'error',
                'msg'=>'Subcategory Already Exist in this Category !! &#128530;', 
                'icon'=>'warning'
            ]);
        }

      
        $data->name       = $request->name;
        $data->cat_id     = $request->cat_id;
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
        $data       =  HardwareSubcategory::find($id);
        $success    =  $data->delete();
        return response()->json('success', 200);
      
    }


    // status
    public function status($id){

        $data       =  HardwareSubcategory::find($id);
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
