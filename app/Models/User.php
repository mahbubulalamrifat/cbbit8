<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function scopeSearch($query, $val='')
    {
        return $query
        ->where('login', 'LIKE', '%'.$val.'%')
        ->Orwhere('name', 'LIKE', '%'.$val.'%')
        ->Orwhere('department', 'LIKE', '%'.$val.'%')
        ->Orwhere('office_id', 'LIKE', '%'.$val.'%')
        ->Orwhere('office_contact', 'LIKE', '%'.$val.'%')
        ->Orwhere('personal_contact', 'LIKE', '%'.$val.'%')
        ->Orwhere('office_email', 'LIKE', '%'.$val.'%')
        ->Orwhere('personal_email', 'LIKE', '%'.$val.'%')
        ->Orwhere('office', 'LIKE', '%'.$val.'%')
        ->Orwhere('business_unit', 'LIKE', '%'.$val.'%')
        ->Orwhere('nid', 'LIKE', '%'.$val.'%'); 
    }


    //Relation user to role
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    // Check Array of roles
    public function hasAnyRoles($roles)
    {
        if($this->roles()->whereIn('name',$roles)->first()){
            return true;
        }
        return false;
    }

    // Check single roles
    public function hasRole($role)
    {
        if($this->roles()->where('name',$role)->first()){
            return true;
        }
        return false;
    }



    //Relation user to sms role
    public function sms_roles()
    {
        return $this->belongsToMany('App\Models\Sms\SmsOperation');
    }

    // Check single roles sms
    public function sms_hasRole($role)
    {
        if($this->sms_roles()->where('name',$role)->first()){
            return true;
        }
        return false;
    }


    //Relation user to ivca role
    public function ivca_roles()
    {
        return $this->belongsToMany('App\Models\iVca\ivcaRole');
    }

    // Check Array of ivca roles 
    public function ivca_hasAnyRoles($roles)
    {
        if($this->ivca_roles()->whereIn('name',$roles)->first()){
            return true;
        }
        return false;
    }


    // Hardware Zone
    public function zons()
    {
        // return $this->belongsToMany('App\Models\iService\iservicePowerbi');
        return $this->belongsToMany('App\Models\SuperAdmin\Zone', 'hardware_zone_user_tabler', 'user_id', 'zone_id');
    }

    public function hard_roles(){
        return $this->belongsToMany('App\Models\Cms\Hardware\HardwareRole', 'hardware_user_role', 'user_id', 'hard_role_id');
    }

    // pbi_roles
    public function pbi_roles(){
        return $this->belongsToMany('App\Models\Pbi\PbiRole', 'pbi_user_role', 'user_id', 'pbi_role_id')->orderBy('name');
    }

    public function pbi_hasRole($role)
    {
        if($this->pbi_roles()->where('name',$role)->first()){
            return true;
        }
        return false;
    }


    //mobile_app_roles role
    public function mobile_app_roles()
    {
        return $this->belongsToMany('App\Models\MobileApp\MobileAppRole', 'mobile_app_role_user', 'user_id', 'mobile_app_role_id');
    }

    // Check single roles mobile_app
    public function mobile_app_hasRole($role)
    {
        if($this->mobile_app_roles()->where('name',$role)->first()){
            return true;
        }
        return false;
    }


    //Log
    public function last_login(){
        return $this->hasOne('App\Models\UserLoginLog', 'login_id', 'login')->where('status', 1)->latest();
    }

    
}
