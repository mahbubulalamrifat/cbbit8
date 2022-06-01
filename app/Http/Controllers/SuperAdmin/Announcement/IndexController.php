<?php

namespace App\Http\Controllers\SuperAdmin\Announcement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\Models\User;
use App\Models\SuperAdmin\Announcement;
use Carbon\Carbon;

class IndexController extends Controller
{
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = Announcement::with('makby')
            ->orderBy($sort_field, $sort_direction)
            ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
            ->paginate($paginate);

        return response()->json($allData, 200);

    }

    // store
    public function store(Request $request){


        //Validate
        $this->validate($request,[
            'message'      => 'required',
            'start'   => 'nullable',
            'end'     => 'nullable',
        ]);

        $data = new Announcement();

    
        $data->message      = $request->message;
        $data->start   = $request->start;
        $data->end     = $request->end;
        
        $data->status       = 1;
        $data->created_by   = Auth::user()->id;
        $success            = $data->save();

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
            'message'      => 'required',
            'start'   => 'nullable',
            'end'     => 'nullable',
        ]);

        $data = Announcement::find($id);

        $data->message      = $request->message;
        $data->start   = $request->start;
        $data->end     = $request->end;
        
        $data->status       = 1;
        $data->created_by   = Auth::user()->id;
        $success            = $data->save();

        if($success){
            return response()->json(['msg'=>'Updated Successfully &#128515;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }


    //Delete
    public function destroy($id){

        $data       = Announcement::findOrFail($id);
        $success    = $data->delete();

        if($success){
            return response()->json(['success' => 'Successfully Deleted', 'icon' => 'success']);
        }else{
            return response()->json(['success' => 'Something going wrong !!', 'icon' => 'error']);
        }
    }


    // status
    public function status($id){

        $data       =  Announcement::find($id);
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


    // get_announcement
    public function get_announcement()
    {
        $date = Carbon::today()->toDateString();
        $allData = Announcement::where('status', 1)->whereDate('start','<=', $date)->whereDate('end','>=', $date)->get();
        return response()->json($allData, 200);

    }
}
