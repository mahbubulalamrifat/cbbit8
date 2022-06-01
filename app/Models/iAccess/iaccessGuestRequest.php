<?php

namespace App\Models\iAccess;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class iaccessGuestRequest extends Model
{
    use HasFactory;

    public function emailschedule(){
        return $this->belongsTo('App\Models\Email\ScheduleEmailIaccessGuestReq', 'id', 'guest_form_id');
    }

    public function manager(){
        // return $this->belongsTo(User::class, 'foreign_key', 'owner_key');
        return $this->belongsTo('App\Models\User', 'manager_id', 'id')->select('id', 'name', 'office_email', 'department', 'business_unit');
    }

    public function buhead(){
        return $this->belongsTo('App\Models\iAccess\iaccessBu', 'bu_id', 'id');
    }

    public function verify(){
        return $this->belongsTo('App\Models\User', 'verify_by', 'id')->select('id', 'name', 'office_email', 'department', 'business_unit');
    }

    public function makby(){
        return $this->belongsTo('App\Models\User', 'apply_by', 'id');
    }

    public function scopeSearch($query, $val='')
    {
        return $query
        ->where('number', 'LIKE', '%'.$val.'%')
        ->orWhere('name', 'LIKE', '%'.$val.'%')
        ->orWhere('branch', 'LIKE', '%'.$val.'%')
        ->orWhere('position', 'LIKE', '%'.$val.'%')
        ->orWhere('department', 'LIKE', '%'.$val.'%')
        ->orWhere('office_mobile', 'LIKE', '%'.$val.'%')
        ->orWhere('personal_mobile', 'LIKE', '%'.$val.'%')
        ->orWhere('personal_email', 'LIKE', '%'.$val.'%')
        ->orWhere('office_email', 'LIKE', '%'.$val.'%')
        ->orWhereHas('makby', function($query) use ($val){
            $query->WhereRaw('login LIKE ?', '%'.$val.'%')
            ->orWhereRaw('name LIKE ?', '%'.$val.'%');
        })
        ->orWhereHas('manager', function($query) use ($val){
            $query->WhereRaw('name LIKE ?', '%'.$val.'%');
        })
        ->orWhereHas('buhead', function($query) use ($val){
            $query->WhereRaw('name LIKE ?', '%'.$val.'%');
        }); 
    }
}
