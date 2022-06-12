<?php

namespace App\Http\Controllers\iAccess\Admin\Reject;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\iAccess\iaccessAccountRequest;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use PDF;

class AccountAuthorityController extends Controller
{
    //index
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id'); 
        $sort_by_day    = Request('sort_by_day', '');
        $sort_by_startDate   = Request('sort_by_startDate', '');
        $sort_by_endDate     = Request('sort_by_endDate', '');
        $sort_by_type     = Request('sort_by_type', '');

        $allQuery =  iaccessAccountRequest::with('manager', 'buhead', 'verify', 'makby')->where('verify_status', 3);
        
        
        // sort_by_day
        if(!empty($sort_by_day)){
            $date = Carbon::today()->subDays($sort_by_day);
            $allQuery->whereDate('created_at', '>=', $date );
        }
        
        // sort_by_Date
        if(!empty($sort_by_startDate) && !empty($sort_by_endDate) ){
            
            $allQuery->whereBetween('created_at' ,[$sort_by_startDate ." 00:00:00", $sort_by_endDate." 23:59:59"]);
        }


        // sort_by_ approve type
        if(!empty($sort_by_type)){

            if($sort_by_type == 'm'){
                // only manager_approved
                $allQuery->whereNotNull('manager_approved')
                        ->whereNull('bu_approved');
            }elseif($sort_by_type == 'mb'){
                // manager_approved & bu_approved
                $allQuery->whereNotNull('bu_approved')
                        ->whereNotNull('manager_approved')
                        ->whereNull('verify_by');
            }elseif($sort_by_type == 'v'){
                // bu_approved, manager_approved, verified
                $allQuery->whereNotNull('bu_approved')
                        ->whereNotNull('manager_approved')
                        ->whereNotNull('verify_by');
            }elseif($sort_by_type == 'nv'){
                // bu_approved, manager_approved, Not verified
                $allQuery->whereNull('bu_approved')
                        ->whereNull('manager_approved')
                        ->whereNull('verify_by');
            }
            
           
        }

        $allData =  $allQuery->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    }


}
