<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Node;

class RoleController extends BaseController
{
    // role index
    public function index(){
        $data=Role::paginate($this->pagesize);
        return view('admin.role.index',compact('data'));
    }
    // role 添加页面
    public function create(){
        $nodeData=Node::all()->toArray();
        $nodeData=treeLevel($nodeData);
        return view('admin.role.create',compact('nodeData'));
    }
    // role  添加角色
    public function store(Request $request){
        $data=$this->validate($request,[
            'name'=>'required|unique:roles,name'
        ]);
         $model=Role::create($data);

        //  先根据role_id在中间件中查询，有则删除 没有不添加任何动作
        // 清理完毕后   添加新的对应关系进入表中
        // sync() 同步 删除原有的权限 添加新权限
        $model->nodes()->sync($request->get('node_ids'));
        return redirect(route('admin.role.index'))->with('success','添加角色成功');
    }

    // // role 修改角色
    // public function edit( int $id){
    //     $data=Role::find($id);
    //     return view('admin.role.edit',compact('data'));
    // }
    // // role 修改角色上传
    // public function update(Request $request,int $id){
    //     $data=$this->validate($request,[
    //         'name'=>'required|unique:roles,name,'.$id
    //     ]);
    //     Role::where('id',$id)->update($data);
    //     return redirect(route('admin.role.index'))->with('success','修改角色☆'.$data['name'].'☆成功');
    // }



    public function edit(Role $role) {
        // 转为数组
        $nodeData = Node::all()->toArray();
        // 递归是针对数组，所在一定把数据转为数组
        $nodeData = treeLevel($nodeData);

        // 属性当前角色权限  模型关联  多对多
        #dump($role->nodes()->get()->toArray());
        #dump($role->nodes->toArray());
        $role_node = $role->nodes()->pluck('id')->toArray();
        // dump($role_node);
        return view('admin.role.edit',compact('role','nodeData','role_node'));
    }

    public function update (Request $request,Role $role) {
        // 表单验证
        $data = $this->validate($request,[
            'name'=>'required|unique:roles,name,'.$role->id
        ]);
        $role->update($data);
        $role->nodes()->sync($request->get('node_ids'));

        return redirect(route('admin.role.index'))->with('success','修改角色成功');
    }

    // role 角色删除
    public function destroy(int $id){
        Role::destroy($id);
        return ['status'=>0,'msg'=>'删除成功'];
    }

}
