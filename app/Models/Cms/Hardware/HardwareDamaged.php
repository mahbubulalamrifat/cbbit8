<?php

namespace App\Models\Cms\Hardware;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Inventory\InventoryNewProduct;

class HardwareDamaged extends Model
{
    use HasFactory;

    public function makby(){
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function complain(){
        return $this->hasOne('App\Models\Cms\Hardware\HardwareComplain', 'id', 'comp_id');
    }

    // public function product(){
    //     //return $this->hasOne('App\Models\Inventory\InventoryNewProduct', 'id', 'rep_pro_id');
    //     return $this->hasMany('App\Models\Inventory\InventoryNewProduct', 'id', 'rep_pro_id');
    // }


    public function product()
    {
        $take_devs = explode(',', $this->rep_pro_id);
        $list_dev = array();
        foreach($take_devs as $value)
        {
            $list_dev[] = InventoryNewProduct::where('id', $value)->first();
        }

    }

  

    public function scopeSearch($query, $val='')
    {
        return $query
        ->where('comp_id', 'LIKE', '%'.$val.'%')
        ->where('damaged_type', 'LIKE', '%'.$val.'%')
        ->where('applicable_type', 'LIKE', '%'.$val.'%')
        ->orWhere('damaged_reason', 'LIKE', '%'.$val.'%')
        ->orWhere('rec_name', 'LIKE', '%'.$val.'%')
        ->orWhere('rec_contact', 'LIKE', '%'.$val.'%')
        ->orWhere('rec_position', 'LIKE', '%'.$val.'%')
        ->orWhereHas('makby', function($query) use ($val){
            $query->WhereRaw('login LIKE ?', '%'.$val.'%');
        })
        ->orWhereHas('complain.makby', function($query) use ($val){
            $query->WhereRaw('name LIKE ?', '%'.$val.'%');
        })
        ->orWhereHas('complain.makby', function($query) use ($val){
            $query->WhereRaw('department LIKE ?', '%'.$val.'%');
        })
        ->orWhereHas('complain.category', function($query) use ($val){
            $query->WhereRaw('name LIKE ?', '%'.$val.'%');
        })
        ->orWhereHas('complain.subcategory', function($query) use ($val){
            $query->WhereRaw('name LIKE ?', '%'.$val.'%');
        })
        ->orWhereHas('product', function($query) use ($val){
            $query->WhereRaw('name LIKE ?', '%'.$val.'%')
            ->WhereRaw('serial LIKE ?', '%'.$val.'%')
            ->WhereRaw('invoice_num LIKE ?', '%'.$val.'%')
            ->WhereRaw('po_number LIKE ?', '%'.$val.'%');
        }); 
    }
}
