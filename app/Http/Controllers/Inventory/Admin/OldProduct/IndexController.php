<?php

namespace App\Http\Controllers\Inventory\Admin\OldProduct;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Inventory\InventoryOldProduct;
// use App\Models\Inventory\InventoryOperation;
use App\Models\SuperAdmin\Operation;
use App\Models\User;
use Auth;

class IndexController extends Controller
{
    //index
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $search_field  = Request('search_field', '');
        $by_location   = Request('by_location', '');
        $search_type   = Request('search_type', '');

        $allDataQuery = InventoryOldProduct::with('makby', 'category', 'operation')
            ->where('delete_temp', '!=', '1');

        // location
        if( !empty($by_location) && $by_location != 'All' ){
            $allDataQuery->where('location', $by_location);
        }

        // search type
        if(!empty($search_type) && $search_type != 'All'){
            $allDataQuery->where('type', $search_type);
        }
        

        // Search
        if(!empty($search_field) && $search_field != 'All' && $search_field != 'cat_id'  && $search_field != 'operation'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));
            $allDataQuery->where($search_field, 'LIKE', '%'.$val.'%');

        }elseif($search_field == 'cat_id'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));

            $allDataQuery->whereHas( 'category', function($query) use($val){
                //$query->where( 'name', $search_field );
                $query->where('name', 'LIKE', '%'.$val.'%');
            });

        }
        elseif($search_field == 'operation'){

            $val = trim(preg_replace('/\s+/' ,' ', $search));

            $allDataQuery->whereHas( 'operation', function($query) use($val){
                //$query->where( 'name', $search_field );
                $query->where('name', 'LIKE', '%'.$val.'%');
            });

        }
        else{
            $allDataQuery->search( trim(preg_replace('/\s+/' ,' ', $search)) );
        }

        // Final Data
        $allData =  $allDataQuery->orderBy($sort_field, $sort_direction)
                ->paginate($paginate);


        return response()->json($allData, 200);

    }

    public function locations(){

        $allData = InventoryOldProduct::whereNotNull('location')
            ->select('location','id')
            ->orderBy('location')
            ->groupBy('location')
            ->get()
            ->toArray();

            // Custom Field Data Add
        $custom = collect( [['location' => 'All', 'id' => 'All']] );
        $allData = $custom->merge($allData);

        return response()->json($allData,200);

    }


     //options 
    public function options(){

        $department = User::where('status', 1)
            ->whereNotNull('department')
            ->Where('department','<>','')
            ->select('department','id')
            ->orderBy('department')
            //->distinct('department')
            ->groupBy('department')
            ->get()
            ->toArray();
            


            $zone_office = User::where('status', 1)
            ->whereNotNull('zone_office')
            ->Where('zone_office','<>','')
            ->select('zone_office','id')
            ->orderBy('zone_office')
            //->distinct('zone_office')
            ->groupBy('zone_office')
            ->get()
            ->toArray();

        $operation = Operation::select('id', 'name')->get()->toArray();

        return response()->json(['department'=>$department, 'zone_office'=>$zone_office, 'operation'=>$operation]);

    }


    // store
    public function store(Request $request){

        //Validate
        $this->validate($request,[
            'cat_id'           =>  'required',
            //'subcat_id'        =>  'required',
            'name'             =>  'required',
            'serial'           =>  'required|max:200|unique:inventory_old_products',
            'invoice_num'      =>  'nullable|max:200|unique:inventory_old_products',
            'req_payment_num'  =>  'nullable|max:200|unique:inventory_old_products',
            'operation_id'     =>  'required',
            'location'    =>  'required',
            'type'             =>  'required',
            'department'           =>  'required',
            'remarks'          =>  'nullable|string',
            
        ]);

        $data = new InventoryOldProduct();


        $data->cat_id          = $request->cat_id;
        //$data->subcat_id     = $request->subcat_id;
        $data->name            = $request->name;
        $data->serial          = $request->serial;
        $data->remarks         = $request->remarks;
        $data->operation       = $request->operation;
        $data->location        = $request->location;
        $data->type            = $request->type;
        $data->department      = $request->department;
        $data->invoice_num     = $request->invoice_num;
        $data->bill_submit     = $request->bill_submit;
        $data->req_payment_num = $request->req_payment_num;
        
        $data->created_by    = Auth::user()->id;
        $success             = $data->save();

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
            'cat_id'           =>  'required',
            //'subcat_id'        =>  'required',
            'name'             =>  'required',
            'serial'           =>  'required|max:200|unique:inventory_old_products,serial,'.$id,
            'invoice_num'      =>  'nullable|max:200|unique:inventory_old_products,invoice_num,'.$id,
            'req_payment_num'  =>  'nullable|max:200|unique:inventory_old_products,req_payment_num,'.$id,
            'operation_id'     =>  'required',
            'location'    =>  'required',
            'type'             =>  'required',
            'department'           =>  'required',
            'remarks'          =>  'nullable|string',
            
        ]);

        $data = InventoryOldProduct::find($id);


        $data->cat_id           = $request->cat_id;
        //$data->subcat_id        = $request->subcat_id;
        $data->name             = $request->name;
        $data->serial           = $request->serial;
        $data->remarks          = $request->remarks;
        $data->operation_id     = $request->operation_id;
        $data->location         = $request->location;
        $data->type             = $request->type;
        $data->department       = $request->department;
        $data->invoice_num     = $request->invoice_num;
        $data->bill_submit     = $request->bill_submit;
        $data->req_payment_num = $request->req_payment_num;
        
        $data->created_by       = Auth::user()->id;
        $success                = $data->save();

        if($success){
            return response()->json(['msg'=>'Stored Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }



    public function destroy_temp(Request $request){

        $data               =  InventoryOldProduct::find($request->id);
        $data->delete_temp  = 1;
        $data->delete_by    =  Auth::user()->id;
        $data->save();

        return response()->json('success', 200);

    }


    // destroy
    public function destroy(){
        
        $data       =  InventoryOldProduct::find($request->id);
        $success    =  $data->delete();
        return response()->json('success', 200);
      
    }

    // restore
    public function restore(){
        
        $data              = InventoryOldProduct::find($request->id);
        $data->delete_temp = 0;
        $success           = $data->save();
        return response()->json('success', 200);
      
    }
    
}
