<?php

namespace App\Http\Controllers\iAccess\User\History;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\iAccess\iaccessInternetRequest;
use Auth;

class IWaccessController extends Controller
{
    //index
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id'); 
        $sort_by_day    = Request('sort_by_day', '');
        $start          = Request('sort_by_startDate', '');
        $end            = Request('sort_by_endDate', '');

        $allQuery =  iaccessInternetRequest::with('manager', 'buhead', 'verify')->where('apply_by', Auth::user()->id);
        
        
        // sort_by_day
        if(!empty($sort_by_day)){
            $date = Carbon::today()->subDays($sort_by_day);
            $allQuery->whereDate('created_at', '>=', $date );
        }
        
        
        // sort_by_Date
        if(!empty($start) && !empty($end) ){
            
            $allQuery->whereBetween('created_at' ,[$start ." 00:00:00", $end." 23:59:59"]);
        }

        $allData =  $allQuery->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    }

    public function get_app_details($id){
        
        $data = iaccessInternetRequest::where('id', $id)->first();

        return response()->json($data,200);
    }
}
