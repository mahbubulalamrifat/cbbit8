<?php

namespace App\Http\Controllers\CMS\HardwareAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

use App\Http\Controllers\CMS\HardwareAdmin\CommonController;
use App\Models\Cms\Hardware\HardwareComplain;
use App\Models\Cms\Hardware\HardwareDamaged;


class IndexController extends Controller
{
    //index
    public function index(){
        $roles = Auth::user()->roles->pluck('name');
        $otherData = Auth::user()->hard_roles->pluck('name');
        // // Merge collections
        $roles = $roles->merge($otherData);
        // dd( $roles);
        return view('cms.hardware_admin.index', compact('roles'));
    }


    public function sidebar_count_data(){
        // Check access offices
        $accessZoneOffices = CommonController::ZoneOfficesByAuth();


        $notprocess = HardwareComplain::with('makby')
            ->where('status', 1)
            ->whereHas('makby', function($q) use($accessZoneOffices){
                $q->whereIn('zone_office', $accessZoneOffices);
            })
            ->whereHas('makby', function($q) use($accessZoneOffices){
                //dd($accessZoneOffices[0]);
                $q->whereIn('zone_office', $accessZoneOffices);
                //$q->whereIn('zone_office', ['Chittagong Feedmill', "Chittagong 1 Farm", "Chittagong 2 Farm", "Chittagong 4 Farm"]);
            })
            ->where('process', 'Not Process')
            ->count();


        // process
        $process = HardwareComplain::with('makby')
            ->where('status', 1)
            ->whereHas('makby', function($q) use($accessZoneOffices){
                $q->whereIn('zone_office', $accessZoneOffices);
            })
            ->where('process', 'Processing')
            ->count();

            // deliverable 
            $deliverable = HardwareComplain::with('makby')
            ->whereHas('makby', function($q) use($accessZoneOffices){
                $q->whereIn('zone_office', $accessZoneOffices);
            })
            ->where('process', 'Deliverable')
            ->count();

         
        $service = HardwareComplain::with('makby')
            ->where('status', 1)
            ->whereHas('makby', function($q) use($accessZoneOffices){
                $q->whereIn('zone_office', $accessZoneOffices);
            })
            ->whereIn('process', ['Send Service', 'Back Service', 'Again Send Service', 'Service Quotation'])
            ->count();

        $serviceAccess = HardwareComplain::with('makby')
            ->whereIn('process', ['Send Service', 'Back Service', 'Again Send Service', 'Service Quotation'])
            ->count();

        // HO Service 
        $hoServiceAccess = HardwareComplain::with('makby')
            ->where('status', 1)
            ->where('process', 'HO Service')
            ->count();

        $hoService = HardwareComplain::with('makby')
            ->where('status', 1)
            ->whereHas('makby', function($q) use($accessZoneOffices){
                $q->whereIn('zone_office', $accessZoneOffices);
            })
            ->where('process', 'HO Service')
            ->count();

        $appDamage = HardwareComplain::with('dam_apply')
            ->whereHas('dam_apply', function($q){
                $q->where('applicable_type', 'Applicable');
            })
            ->where('process', 'Damaged')
            ->count();

        $appPartialDamage = HardwareComplain::with('dam_apply')
            ->whereHas('dam_apply', function($q){
                $q->where('applicable_type', 'Applicable');
            })
            ->where('process', 'Partial Damaged')
            ->count();

        $notAppDamage = HardwareComplain::with('dam_apply')
            ->whereHas('dam_apply', function($q){
                $q->where('applicable_type', 'Not Applicable');
            })
            ->where('process', 'Damaged')
            ->count();

        $notAppPartialDamage = HardwareComplain::with('dam_apply')
            ->whereHas('dam_apply', function($q){
                $q->where('applicable_type', 'Not Applicable');
            })
            ->where('process', 'Partial Damaged')
            ->count();

        return response()->json(['notprocess'=>$notprocess,'process'=>$process, 'deliverable'=>$deliverable, 'service'=>$service , 'serviceAccess'=>$serviceAccess, 'hoService'=>$hoService, 'hoServiceAccess'=>$hoServiceAccess, 'appDamage'=>$appDamage, 'appPartialDamage'=>$appPartialDamage, 'notAppDamage'=>$notAppDamage, 'notAppPartialDamage'=>$notAppPartialDamage]);

    }



    // dashboard_data
    public function dashboard_data(){

        $allComplain = HardwareComplain::count();
        $allProcessingComplain = HardwareComplain::where('process', 'Processing')->count();
        $allClosedComplain = HardwareComplain::where('process', 'Closed')->count();

        $productWiseComplain = HardwareComplain::with('category')
            ->whereHas('category', function($q){
                $q->where('status', 1);
            })
            ->whereNotNull('cat_id')
            ->where('cat_id','!=', '0')
            ->where('cat_id','<>','')
            ->groupBy('cat_id')
            ->selectRaw('count(*) as total, cat_id')
            ->orderByRaw('(SELECT name FROM hardware_categories WHERE hardware_categories.id = hardware_complains.cat_id)')
            ->get()
            ->toArray();


        $damageWiseComplain = HardwareDamaged::with('complain', 'complain.category')
            ->groupBy('damaged_type')
            ->whereNotNull('damaged_type')
            ->selectRaw('count(*) as total, damaged_type')
            ->get()
            ->toArray();


         $alldata = ['productWiseComplain'=>$productWiseComplain,
            'allComplain'           => $allComplain, 
            'damageWiseComplain'    => $damageWiseComplain,
            'allProcessingComplain' => $allProcessingComplain,
            'allClosedComplain'     => $allClosedComplain,

            ];

        return response()->json($alldata, 200);
    }

    // pdf_get_file
    public function pdf_get_file(){
        $path = Request('document');
        
        $infoPath = pathinfo(public_path($path));
        
        $extension = $infoPath['extension'];

        if($extension == 'pdf'){
            $file = file_get_contents($path);
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $base64 = base64_encode($file);
            return response()->json($base64);
        }
    }




}
