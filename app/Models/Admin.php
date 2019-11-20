<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
// 引入trait
use App\Models\Traits\Btn;

class Admin extends Authenticatable
{
    // 继承
    use SoftDeletes,Btn;
    // 添加到黑名单
    protected $guarded=[];

    public function setPasswordAttribute($value){
        $this->attributes['password']=bcrypt($value);
    }
// 用户与角色表关联
    public function role(){
        return $this->belongsTo(Role::class,'role_id');
    }
}
