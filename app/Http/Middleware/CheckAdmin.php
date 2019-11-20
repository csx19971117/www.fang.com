<?php

namespace App\Http\Middleware;
use App\Models\Role;
use Closure;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$params)
    {
        // var_dump($params);
        // echo "陈思旭哈哈哈哈";

        // 判断是否已经登录
        if(!auth()->check()){
            // 登陆失败提示
            return redirect(route('admin.login'))->withErrors(['errors'=>'请您先登陆']);
        
        }
        // 获取当前用户
        $userModel=auth()->user();
        // 通过当前用户获取当前角色
        $roleModel=$userModel->role;
        // dump($roleModel);
        // 使用角色和权限的多对多关系 来获取对应的权限
        $auths=$roleModel->nodes()->pluck('route_name','id')->toArray();
        // dump($auths);
        // 过滤空数据  获得真正的权限
        $authList=array_filter($auths);
        // dump($authList);
        // 不需要验证的权限
        $allowList=[
            'admin.index',
            'admin.logout',
            'admin.welcome'
        ];
        // 合并权限
        $authList=array_merge($authList,$allowList);

        // 把权限写到request对象中
        $request->auths = $authList;
        // 获取当前路由的别名
        $currentRouteName=$request->route()->getName();
        // 获取当前用户名
        $currentUsername = auth()->user()->username;
        // 保存当前用户名
        $request->username = $currentUsername;
        // 权限判断
        if(!in_array($currentRouteName,$authList) && $currentUsername!='admin'){
            exit('您没有该权限');
        }


        return $next($request);
    }
}
