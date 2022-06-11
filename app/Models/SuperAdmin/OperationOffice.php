<?php

namespace App\Models\SuperAdmin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationOffice extends Model
{
    use HasFactory;

    public function makby(){
        // return $this->belongsTo(User::class, 'foreign_key', 'owner_key');
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function operation(){
        // return $this->belongsTo(User::class, 'foreign_key', 'owner_key');
        return $this->belongsTo('App\Models\SuperAdmin\Operation', 'operation_id', 'id');
    }

    public function scopeSearch($query, $val='')
    {
        return $query
        ->WhereHas('operation', function($query) use ($val){
            $query->WhereRaw('name LIKE ?', '%'.$val.'%');
        })
        ->orWhere('offices', 'LIKE', '%'.$val.'%'); 
    }
}
