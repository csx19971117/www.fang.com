<?php

namespace App\Http\Controllers\Admin;
use App\Models\Node;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    // 路由中间件
    public  function __construct (){
        // // 绑定路由中间件
        // $this->middleware('checkadmin');
    }


    public function index(Request $request){
         // 获取闪存后，在存到闪存
         session()->flash('success',session('success'));
        // 得到当前登陆用户
        $userModel=auth()->user();
        // 用户对应的角色关联关系 属于
        $roleModel=$userModel->role;
        // 得到有菜单权限的权限
        if($userModel->username !='admin'){
            // 普通用户
            $nodeData=$roleModel->nodes()->where('is_menu','1')->get(['id','pid','name','route_name'])->toArray();
        }else{
            // 超级管理员
            $nodeData=Node::where('is_menu','1')->get(['id','pid','name','route_name'])->toArray();
        }
        
        $menuData=subTree($nodeData);
        // dump($menuData);

        return view('admin.index.index',compact('menuData'));
    }

    public function welcome(){
        return view('admin.index.welcome');
    }

    public function logout(){
        auth()->guard('web')->logout();

        return redirect(route('admin.login'))->with('success','退出成功');
    }

    public function show(Request $request){
        // $data=auth()->user()->
        // dump(auth()->user().attribute);
        
        return view('admin.index.show',compact('data'));
    }
}
