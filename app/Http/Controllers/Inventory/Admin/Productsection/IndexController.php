<?php

namespace App\Http\Controllers\Inventory\Admin\Productsection;

use App\Models\Inventory\InventoryOldProduct;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Exports\inventory\product\givenProduct;
use App\Exports\inventory\product\runningProduct;
use App\Exports\inventory\product\damageProduct;
use Maatwebsite\Excel\Facades\Excel;

class IndexController extends Controller
{
    //index
    public function index(){

        $allDataQuery = self::GivenData();
        // Final Data
        $paginate       = Request('paginate', 10);
        $allData =  $allDataQuery->paginate($paginate);
        return response()->json($allData, 200);
    }

    // given export
    public function export_data_given() 
    {
        $allDataQuery = self::GivenData();
        // Final Data
        $allData =  $allDataQuery->get();
        //dd($allData);
        return Excel::download(new givenProduct($allData), 'product-' . time() . '.xlsx');
    }

    // GivenData
    public static function GivenData(){

        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $search_field  = Request('search_field', '');
        $by_location   = Request('by_location', '');

        $allDataQuery = InventoryOldProduct::with('makby', 'category', 'operation', 'newtbldata')
        // ->whereHas('newtbldata', function($q){
        //     $q->select('document');
        // })
        ->where('delete_temp', 0)
        ->whereNotNull('new_pro_id');
        
        // ->where('delete_temp', '!=', '1')
        // ->where('new_pro_id', '!=', '0');

        // location
        if( !empty($by_location) && $by_location != 'All' ){
            $allDataQuery->where('location', $by_location);
        }

        // Search
        if(!empty($search_field) && $search_field != 'All' && $search_field != 'cat_id' && $search_field != 'operation'){
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

        // $allData = $allDataQuery->get();

        return $allDataQuery->orderBy($sort_field, $sort_direction);
    }










    //running_product
    public function running_product(){
        $allDataQuery = self::RunningData();
        $paginate       = Request('paginate', 10);
        $allData =  $allDataQuery->paginate($paginate);
        return response()->json($allData, 200);
    }

    // running export
    public function export_data_running() 
    {
        $allDataQuery = self::RunningData();
        $allData =  $allDataQuery->get();
        return Excel::download(new runningProduct($allData), 'product-' . time() . '.xlsx');
    }

    // RunningData
    public static function RunningData(){

        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $search_field  = Request('search_field', '');
        $by_location   = Request('by_location', '');

        $allDataQuery = InventoryOldProduct::with('makby', 'category', 'operation')
            ->where('delete_temp', 0)
            ->where('type', 'Running');

        // location
        if( !empty($by_location) && $by_location != 'All' ){
            $allDataQuery->where('location', $by_location);
        }

        // Search
        if(!empty($search_field) && $search_field != 'All' && $search_field != 'cat_id' && $search_field != 'operation'){

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
        return $allData =  $allDataQuery->orderBy($sort_field, $sort_direction);

    }








    //damaged_product
    public function damaged_product(){
        $allDataQuery = self::DamagedData();
        $paginate = Request('paginate', 10);
        $allData = $allDataQuery->paginate($paginate);
        return response()->json($allData, 200);
    }

    // damage export
    public function export_data_damage() 
    {
        $allDataQuery = self::DamagedData();
        $allData =  $allDataQuery->get();
        return Excel::download(new damageProduct($allData), 'product-' . time() . '.xlsx');
    }
   
    // DamagedData
    public static function DamagedData(){
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $search_field  = Request('search_field', '');
        $by_location   = Request('by_location', '');

        $allDataQuery = InventoryOldProduct::with('makby', 'category', 'operation')
            ->where('delete_temp', '!=', '1')
            ->where('type', 'Damaged');


        // location
        if( !empty($by_location) && $by_location != 'All' ){
            $allDataQuery->where('location', $by_location);
        }

        // Search
        if(!empty($search_field) && $search_field != 'All' && $search_field != 'cat_id' && $search_field != 'operation'){

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
        return $allDataQuery->orderBy($sort_field, $sort_direction);
    }
   


   



   



}
