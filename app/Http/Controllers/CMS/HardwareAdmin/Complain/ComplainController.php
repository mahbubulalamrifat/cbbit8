<?php

namespace App\Http\Controllers\CMS\HardwareAdmin\Complain;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cms\Hardware\HardwareComplain;
use App\Models\SuperAdmin\ZoneOffice;
use Auth;
// Form email
use App\Http\Controllers\CMS\Email\Hardware\EmailStore;
use App\Http\Controllers\CMS\HardwareAdmin\CommonController;
use App\Models\Cms\Hardware\HardwareDelivery;


class ComplainController extends Controller
{
    //not_process  
    public function not_process(){

        // Check access offices
        $accessZoneOffices = CommonController::ZoneOfficesByAuth();

        // dd($size, $finalArrOffices,  $zoneAccessName, $zoneOfficeName, $zoneOffices, $zoneAccess );

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');
        $zone_office    = Request('zone_office', 'All');

        $allDataQuery = HardwareComplain::with('makby', 'category', 'subcategory')
            ->where('status', 1)
            ->where('process', 'Not Process');

            if( !empty($zone_office) && $zone_office != 'All'){

                // Check access offices
                $accessZoneOfficesQuery = ZoneOffice::where('name', $zone_office)->select('offices')->first();
            
                if(!empty($accessZoneOfficesQuery)){
                    $offices = $accessZoneOfficesQuery->offices;
                    // string to array
                    $accessZoneOffices = explode(',', $offices);
                }else{
                    $accessZoneOffices = [];
                }
            
                //dd($zone_office,  $accessZoneOffices,  $accessZoneOfficesQuery);
                $allDataQuery->whereHas('makby', function($q) use($accessZoneOffices){
                    //dd($accessZoneOffices);
                    $q->whereIn('zone_office', $accessZoneOffices);
                }); 
                
            }else{
                $allDataQuery->whereHas('makby', function($q) use($accessZoneOffices){
                    //dd($accessZoneOffices[0]);
                    $q->whereIn('zone_office', $accessZoneOffices);
                    //$q->whereIn('zone_office', ['Chittagong Feedmill', "Chittagong 1 Farm", "Chittagong 2 Farm", "Chittagong 4 Farm"]);
                });
            }


            $allData = $allDataQuery->orderBy($sort_field, $sort_direction)
                ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
                ->paginate($paginate);

        return response()->json($allData, 200);

    } 


    //processing
    public function processing(){

        // Check access offices
        $accessZoneOffices = CommonController::ZoneOfficesByAuth();

        // dd($size, $finalArrOffices, $zoneAccessName, $zoneOfficeName, $zoneOffices, $zoneAccess );

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');
        $zone_office    = Request('zone_office', 'All');

        $allDataQuery = HardwareComplain::with('makby', 'category', 'subcategory')
            ->where('status', 1) 
            ->where('process', 'Processing');


            if( !empty($zone_office) && $zone_office != 'All'){
                // Check access offices
                $accessZoneOfficesQuery = ZoneOffice::where('name', $zone_office)->select('offices')->first();
            
                if(!empty($accessZoneOfficesQuery)){
                    $offices = $accessZoneOfficesQuery->offices;
                    // string to array
                    $accessZoneOffices = explode(',', $offices);
                }else{
                    $accessZoneOffices = [];
                }
            
                //dd($zone_office,  $accessZoneOffices,  $accessZoneOfficesQuery);
                $allDataQuery->whereHas('makby', function($q) use($accessZoneOffices){
                    //dd($accessZoneOffices);
                    $q->whereIn('zone_office', $accessZoneOffices);
                }); 
                
            }else{
                $allDataQuery->whereHas('makby', function($q) use($accessZoneOffices){
                    //dd($accessZoneOffices[0]);
                    $q->whereIn('zone_office', $accessZoneOffices);
                });
            }


        $allData = $allDataQuery->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);
    } 


    // closed
    public function closed(){

        // Check access offices
        $accessZoneOffices = CommonController::ZoneOfficesByAuth();

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');
        $zone_office    = Request('zone_office', 'All');

        $allDataQuery = HardwareComplain::with('makby', 'category', 'subcategory')
            ->where('status', 1)
            ->where('process', 'Closed');

            if( !empty($zone_office) && $zone_office != 'All'){
                // Check access offices
                $accessZoneOfficesQuery = ZoneOffice::where('name', $zone_office)->select('offices')->first();
            
                if(!empty($accessZoneOfficesQuery)){
                    $offices = $accessZoneOfficesQuery->offices;
                    // string to array
                    $accessZoneOffices = explode(',', $offices);
                }else{
                    $accessZoneOffices = [];
                }
            
                //dd($zone_office,  $accessZoneOffices,  $accessZoneOfficesQuery);
                $allDataQuery->whereHas('makby', function($q) use($accessZoneOffices){
                    //dd($accessZoneOffices);
                    $q->whereIn('zone_office', $accessZoneOffices);
                }); 
                
            }else{
                $allDataQuery->whereHas('makby', function($q) use($accessZoneOffices){
                    //dd($accessZoneOffices[0]);
                    $q->whereIn('zone_office', $accessZoneOffices);
                });
            }




        $allData = $allDataQuery->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    } 


    // deliverable complain list
    public function deliverable(){

        // Check access offices
        $accessZoneOffices = CommonController::ZoneOfficesByAuth();

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');
        $zone_office    = Request('zone_office', 'All');

        $allDataQuery = HardwareComplain::with('makby', 'category', 'subcategory')
            ->where('status', 1)
            ->where('process', 'Deliverable');

        if( !empty($zone_office) && $zone_office != 'All'){
            // Check access offices
            $accessZoneOfficesQuery = ZoneOffice::where('name', $zone_office)->select('offices')->first();
        
            if(!empty($accessZoneOfficesQuery)){
                $offices = $accessZoneOfficesQuery->offices;
                // string to array
                $accessZoneOffices = explode(',', $offices);
            }else{
                $accessZoneOffices = [];
            }
        
            //dd($zone_office,  $accessZoneOffices,  $accessZoneOfficesQuery);
            $allDataQuery->whereHas('makby', function($q) use($accessZoneOffices){
                //dd($accessZoneOffices);
                $q->whereIn('zone_office', $accessZoneOffices);
            }); 
            
        }else{
            $allDataQuery->whereHas('makby', function($q) use($accessZoneOffices){
                //dd($accessZoneOffices[0]);
                $q->whereIn('zone_office', $accessZoneOffices);
            });
        }

        $allData = $allDataQuery->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);
    }

    // delivered complain list
    public function delivered(){

        // Check access offices
        $accessZoneOffices = CommonController::ZoneOfficesByAuth();

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');
        $search_field   = Request('search_field', '');

        $start          = Request('start', '');
        $end            = Request('end', '');
        $zone_office    = Request('zone_office', '');
        $department     = Request('department', '');

        $allDataQuery = HardwareDelivery::with('makby', 'complain', 'complain.category', 'complain.subcategory', 'complain.makby')
            ->orderBy($sort_field, $sort_direction);

        // Check Zone Access
        $allDataQuery->whereHas('makby', function($q) use($accessZoneOffices){
            //dd($accessZoneOffices);
            $q->whereIn('zone_office', $accessZoneOffices);
        });


         // Department Selected
         if( !empty($start) && !empty($end) ){
            $allDataQuery->whereBetween('created_at' ,[$start ." 00:00:00", $end." 23:59:59"]);
        }

        // user Zone Selected
        if( !empty($zone_office) && $zone_office != 'All'){
            $allDataQuery->whereHas('complain.makby', function($q) use($zone_office){
                //dd($department);
                $q->whereIn('zone_office', explode(",",$zone_office));
                //$q->whereIn('zone_office', ['Chittagong Feedmill', "Chittagong 1 Farm", "Chittagong 2 Farm", "Chittagong 4 Farm"]);
            });
        }

        // user department Selected
        if( !empty($department) && $department != 'All'){
            $allDataQuery->whereHas('complain.makby', function($q) use($department){
                //dd($department);
                $q->where('department', $department);
            });
        }


        $allData = $allDataQuery->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);
    }


    // service
    public function service(){ 

        // Check access offices
        $accessZoneOffices = CommonController::ZoneOfficesByAuth();

        // dd($size, $finalArrOffices, $zoneAccessName, $zoneOfficeName, $zoneOffices, $zoneAccess );

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');
        $zone_office    = Request('zone_office', 'All');

        $allDataQuery = HardwareComplain::with('makby', 'category', 'subcategory')
            ->where('status', 1)
            ->whereIn('process', ['Send Service', 'Back Service', 'Again Send Service', 'Service Quotation']);

            if( !empty($zone_office) && $zone_office != 'All'){
                // Check access offices
                $accessZoneOfficesQuery = ZoneOffice::where('name', $zone_office)->select('offices')->first();
            
                if(!empty($accessZoneOfficesQuery)){
                    $offices = $accessZoneOfficesQuery->offices;
                    // string to array
                    $accessZoneOffices = explode(',', $offices);
                }else{
                    $accessZoneOffices = [];
                }
            
                //dd($zone_office,  $accessZoneOffices,  $accessZoneOfficesQuery);
                $allDataQuery->whereHas('makby', function($q) use($accessZoneOffices){
                    //dd($accessZoneOffices);
                    $q->whereIn('zone_office', $accessZoneOffices);
                }); 
                
            }else{
                $allDataQuery->whereHas('makby', function($q) use($accessZoneOffices){
                    //dd($accessZoneOffices[0]);
                    $q->whereIn('zone_office', $accessZoneOffices);
                });
            }
            
            $allData = $allDataQuery->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);
    } 



    

   





    // // zone Offices name By Admin Access 
    // public function zoneOfficesByAdminAccess(){

    //     // Zones By Users access
    //     $zoneAccess = Auth::user()->zons()->select('name')->get()->toArray();
    //     $zoneAccessName = [];
    //     foreach( $zoneAccess as $item ){
    //         array_push($zoneAccessName, $item['name'] );
    //     }

    //     // Zone offices
    //     $zoneOffices = ZoneOffice::whereIn('name', $zoneAccessName)->get()->toArray();
    //     $zoneOfficeName = [];
    //     foreach( $zoneOffices as $item ){
    //         $arr = explode(",", $item['offices'] );
    //         array_push($zoneOfficeName, $arr);
    //     }

    //     $finalArrOffices = [];
    //     // Array Size
    //     foreach($zoneOfficeName as $item){
    //         // Array Merge
    //         $finalArrOffices = array_merge($finalArrOffices, $item);
    //     }
      
    //     return $finalArrOffices;
        
    // }


    // zone_access
    public function zone_access(){

        $allData = CommonController::ZoneOfficesByAuth();
        //$allData = CommonController::ZoneOfficesByAuth();
        return response()->json($allData, 200);
    }


}

