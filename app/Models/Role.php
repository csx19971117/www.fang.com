<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // 添加到黑名单
    protected $guarded=[];


    // 多对多模型关系 增删改查
    public function nodes(){
        // 参数一关联的模型类
        // 参数二俩表的关联表
        // 参数三 本模型关联表中的字段
        // 参数四 另一个模型 关联表中的字段
        return $this->belongsToMany(Node::class,'role_node','role_id','node_id');
    }
}
