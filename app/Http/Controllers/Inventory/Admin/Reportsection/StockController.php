<?php

namespace App\Http\Controllers\Inventory\Admin\Reportsection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Inventory\InventoryNewProduct;
use App\Models\Inventory\InventoryOperation;
use App\Models\Inventory\InventoryOldProduct;
use App\Models\User;
use Auth;

use App\Exports\inventory\stock;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class StockController extends Controller
{
    //index
    public function index(){

        $allData = $this->getData();
        return response()->json($allData, 200);

    }



    public function export_data(Request $request){

        
        $sort_by_startDate      = Request('sort_by_startDate', '');
        $sort_by_endDate        = Request('sort_by_endDate', '');
        $product_name           = Request('product_name', '');

        $allDataArray =  $this->getData();
     
        $allDataArray +=  [
            'catagoryName'  => '('. date('d F, Y', strtotime($sort_by_startDate)) .' to '.date('d F, Y', strtotime($sort_by_endDate)) .') '.$product_name,
        ];

       
        $allData = (object) $allDataArray;


        //dd($allData,  $allDataArray);

        return Excel::download(new stock($allData), 'product.xlsx');
    }



    public function export_view(){

        $sort_by_startDate      = Request('sort_by_startDate', '');
        $sort_by_endDate        = Request('sort_by_endDate', '');
        $product_name           = Request('product_name', '');

        $allDataArray =  $this->getData();
     
        $allDataArray +=  [
            'catagoryName'  => '('. date('d F, Y', strtotime($sort_by_startDate)) .' to '.date('d F, Y', strtotime($sort_by_endDate)) .') '.$product_name,
        ];

        $product = (object) $allDataArray;

        return view('inventory.admin.reports.stock', compact('product'));

    }




    public function getData(){

        $sort_by_startDate      = Request('sort_by_startDate', '');
        $sort_by_endDate        = Request('sort_by_endDate', '');
        $sort_by_category       = Request('sort_by_category', '');

        $sort_by_startDate   = '2022-06-01';
        $sort_by_endDate     = '2022-06-30';
        $sort_by_category    = '28';

        // $data = InventoryNewProduct::with('makby', 'category', 'newold')
        //     ->where('delete_temp', '!=', '1')
        //     ->where('give_st', 1)
        //     ->where('cat_id', $sort_by_category)
        //     ->whereDate('updated_at', '>=', $sort_by_startDate)
        //     ->whereDate('updated_at', '<=', $sort_by_endDate)
        //     ->get();
            //->groupBy('comp_id');

        $proDetailsArra = [];

        $data = InventoryNewProduct::with('newold', 'makby', 'category', )
            ->where('delete_temp', '!=', '1')
            ->where('give_st', 1)
            ->where('cat_id', $sort_by_category)
            ->whereDate('updated_at', '>=', $sort_by_startDate)
            ->whereDate('updated_at', '<=', $sort_by_endDate)
            ->get();

            // $counter = 1;
            foreach($data as $item){
                $proDetailsArra [] = [
                    'id'            => $item->id,
                    'updated_at'    => $item->updated_at,
                    'unit_price'    => $item->unit_price,
                    'remarks'       => $item->remarks,
                    //'cat_id'        => $item->cat_id,
                    'category'      => $item->category->name,
                    'compid'        => $item->newold->comp_id ?? 'm',
                    //'old_pro_id'    => $item->newold->id ?? '',
                    'location'      => $item->newold->location ?? '',
                    'department'    => $item->newold->department ?? '',
                ];
                
            }

            
            $groupByCmpData = array();
            foreach ($proDetailsArra as $key => $item) {
                $groupByCmpData[ $item['compid'] ] [] = $item;
            }

           

            $finalArrayData = [];
            foreach ($groupByCmpData as $key => $value) {

                //dd($value[0], $value[0]['id']);

                $total_price = 0; 
                $quantity = sizeof($value);
                if($quantity > 0){
                    foreach($value as $item2){
                        if($item2['unit_price']){
                            $total_price = $total_price + $item2['unit_price'];
                        }
                    }
                }
                
        
                $finalArrayData [] = [
                    'id' => $value[0]['id'] ?? '',
                    'quantity' => $quantity ?? '',
                    'unit_price'  =>  round( $total_price / $quantity,2),
                    'total_price' => $total_price,
                    'comp_id' => $value[0]['compid'] ?? '',
                    'category' => $value[0]['category'] ?? '',
                    'location' => $value[0]['location'] ?? '',
                    'department' => $value[0]['department'] ?? '',
                    'remarks' => $value[0]['remarks'] ?? '',
                    'updated_at' => $value[0]['updated_at'] ?? '',
                ];
            }

            //array_unique();

            $finalobjData = (object) $finalArrayData;

        //dd($finalobjData, $finalArrayData, $groupByCmpData ,$proDetailsArra,  $data);

        // totalReceived
        $totalReceivedQuery = InventoryNewProduct::where('delete_temp', '!=', '1')
                    ->where('cat_id', $sort_by_category)
                    ->whereDate('created_at', '>=', $sort_by_startDate)
                    ->whereDate('created_at', '<=', $sort_by_endDate);
        $totalReceived        = $totalReceivedQuery->count();
        $totalReceivedAmmount = $totalReceivedQuery->sum('unit_price');
        if($totalReceivedAmmount > 0) { 
            $receivedAmmountUnit  = round($totalReceivedAmmount/$totalReceived);
        }else{
            $receivedAmmountUnit = 0;
        }
        

        // totalIssue
        $totalIssueQuery = InventoryNewProduct::where('delete_temp', '!=', '1')
                    ->where('cat_id', $sort_by_category)
                    ->whereDate('updated_at', '>=', $sort_by_startDate)
                    ->whereDate('updated_at', '<=', $sort_by_endDate)
                    ->where('give_st', 1);    
        $totalIssue         = $totalIssueQuery->count();
        $totalIssueAmmount  = $totalIssueQuery->sum('unit_price');
        if($totalIssueAmmount > 0) { 
            $issueAmmountUnit   = round($totalIssueAmmount/$totalIssue);
        }else{
            $issueAmmountUnit = 0;
        }
        
        
        // totalDamaged
        $totalDamagedQuery = InventoryNewProduct::where('delete_temp', '!=', '1')
                    ->where('cat_id', $sort_by_category)
                    ->whereDate('updated_at', '>=', $sort_by_startDate)
                    ->whereDate('updated_at', '<=', $sort_by_endDate)
                    ->where('damage_st', 1);
                   
        $totalDamaged         = $totalDamagedQuery->count();
        $totalDamagedAmmount  = $totalDamagedQuery->sum('unit_price');
        if($totalDamagedAmmount > 0) { 
            $damagedAmmountUnit   = round($totalDamagedAmmount/$totalDamaged);
        }else{
            $damagedAmmountUnit = 0;
        }


        // totalRemainingQuery
        $totalRemainingQuery = InventoryNewProduct::where('delete_temp', '!=', '1')
                    ->where('cat_id', $sort_by_category)
                    ->whereDate('created_at', '<=', $sort_by_endDate)
                    ->where('give_st', 0)
                    ->whereNull('damage_st');

        
        // totalRemaining
        $totalRemaining        = $totalRemainingQuery->count();
        $totalRemainingAmmount = $totalRemainingQuery->sum('unit_price');
        if($totalRemainingAmmount > 0) { 
            $remainingAmmountUnit  = round($totalRemainingAmmount/$totalRemaining);
        }else{
            $remainingAmmountUnit = 0;
        }


        // totalBroughtForward query
        $totalBroughtForwardQuery = InventoryNewProduct::where('delete_temp', '!=', '1')
        ->where('cat_id', $sort_by_category)
        ->whereDate('created_at', '<=', $sort_by_startDate)
        ->where('give_st', 0)
        ->whereNull('damage_st');

        // totalBroughtForward
        
        $totalBroughtForward        = $totalBroughtForwardQuery->count();
        $totalBroughtForwardAmmount = $totalBroughtForwardQuery->sum('unit_price');
        if($totalBroughtForwardAmmount > 0) { 
            $broughtForwardAmmountUnit  = round($totalBroughtForwardAmmount/$totalBroughtForward);
        }else{
            $broughtForwardAmmountUnit = 0;
        }

              

        $allData = [
           'data' => $finalobjData,

           'totalReceived'          => $totalReceived,
           'totalReceivedAmmount'   => $totalReceivedAmmount,
           'receivedAmmountUnit'    => $receivedAmmountUnit,

           'totalIssue'             => $totalIssue,
           'totalIssueAmmount'      => $totalIssueAmmount,
           'issueAmmountUnit'       => $issueAmmountUnit,

           'totalDamaged'           => $totalDamaged,
           'totalDamagedAmmount'    => $totalDamagedAmmount,
           'damagedAmmountUnit'     => $damagedAmmountUnit,

           'totalRemaining'          => $totalRemaining,
           'remainingAmmountUnit'    => $remainingAmmountUnit,
           'totalRemainingAmmount'   => $totalRemainingAmmount,
           

           'totalBroughtForward'          => $totalBroughtForward,
           'broughtForwardAmmountUnit'    => $broughtForwardAmmountUnit,
           'totalBroughtForwardAmmount'   => $totalBroughtForwardAmmount,
           

        ];

        return $allData;

    }




}
