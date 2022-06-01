<?php

namespace App\Http\Controllers\SuperAdmin\Logs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\UserLoginLog;

class IndexController extends Controller
{
    //all
    public function all(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');
        $short_by       = Request('short_by', 'id');
        $start    = Request('start', '');
        $end     = Request('end', '');
        

        $allDataQuery = UserLoginLog::orderBy($sort_field, $sort_direction);

        if( !empty($short_by) ){
            if($short_by == 's'){
                $allDataQuery->where('status', 1);
            }elseif($short_by == 'ae'){
                 // AD Server Error
                $allDataQuery->where('status', 3);
            }elseif($short_by == 'ce'){
                 //code 0 Not authorized CPB-IT
                $allDataQuery->where('status', 0);
            }
        }

        if( !empty($start) && !empty($end) ){
            $allDataQuery->whereBetween('created_at' ,[$start ." 00:00:00", $end." 23:59:59"]);
        }



        $allData = $allDataQuery->search( trim(preg_replace('/\s+/' ,' ', $search)) )
                  ->paginate($paginate);

        return response()->json($allData, 200);

    }
}
