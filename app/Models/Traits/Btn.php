<?php

namespace App\Models\Traits;

trait Btn{
    private function CheckAuth(string $routeName){
        // 在中间件中得到当前角色的权限
        $auths=request()->auths;
        // 判断权限
        if(!in_array($routeName,$auths)&& request()->username!='admin'){
            return false;
        }
        return true;
    }

    // 修改
    public function editBtn(string $routeName){
        if($this->CheckAuth($routeName)){
            return '<a href="' . route($routeName, $this) . '" class="label label-secondary radius">修改</a>';
        }
        return '';
    }
    // 删除
    public function delBtn(string $routeName){
        if($this->CheckAuth($routeName)){
            return '<a href="' . route($routeName, $this) . '" class="label label-danger radius deluser">删除</a>';
        }
        return '';
    }
}