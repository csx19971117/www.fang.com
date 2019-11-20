<?php
// 用户管理
namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Services\AdminService;
use Illuminate\Http\Request;
# 引入邮件类
use Illuminate\Mail\Mailer;
use Mail;
use Illuminate\Mail\Message;
// 引入角色模型类
use App\Models\Role;

class AdminController extends BaseController {

    // 列表
    public function index(Request $request) {
        // 用户列表数据
        //$data = Admin::orderBy('id', 'desc')->paginate($this->pagesize);
        // 读业务层中的获取搜索用户列表数据
        $data = (new AdminService())->getList($request, $this->pagesize);
        return view('admin.admin.index', compact('data'));
    }


    public function create(){
        // 在添加用户中读取所有角色列表信息
        $roleData=Role::pluck('name','id');
        // dump($roleData);
        return view('admin.admin.create',compact('roleData'));
    }

    public function store(Request $request){
        $this->validate($request,[
            'username'=>'required|unique:admins,username',
            'truename'=>'required',
            'email'=>'nullable|email',
            'password'=>'required|confirmed',
            // 角色id
            'role_id'=>'required'
        ],[
            'role_id.required'=>'角色必须勾选至少一个'
        ]);
        // $model=Admin::create($request->except(['_token','password_confirmation']));
        $data=$request->except(['_token','password_confirmation']);
        $model=Admin::create($data);

        // 发送邮件通知
        // Mail::raw('添加用户成功',function (Message $message){
        //     // 主题
        //     $message->subject('添加用户通知');
        //     $message->to('906892939@qq.com','24.');

        // 发送文本邮件通知
        Mail::send('admin.mailer.adduser',compact('model'),function(Message $message) use ($model){
            // 主题
            $message->subject('添加用户通知');
            $message->to('906892939@qq.com','24.');
       
        });

        return redirect(route('admin.user.index'))->with('success','添加用户☆'.$model->truename.'☆成功');
    }


    // 用户修改页面展示
    public function edit(int $id){
        $data=Admin::find($id);
        return view('admin.admin.edit',compact('data'));
    }

    public function update(Request $request,int $id){
        $data=$this->validate($request,[
            'username' => 'required|unique:admins,username,' . $id,
            'truename'=>'required',
            'email'=>'nullable|email',
            'password'=>'nullable|confirmed',
            'phone'=>'nullable|min:6',
            'sex'=>'in:先生,女士'
        ]);
        if(!$data['password']){
            unset($data['password']);
        }
        Admin::where('id',$id)->update($data);
        return redirect(route('admin.user.index'))->with('success','修改用户☆'.$data['truename'].'☆成功');
    }

    public function destroy(int $id){

        // 注释思路
        // 先定义删除路由,然后 把页面的a标签换data-href 定义路由 增加css选择器  
        // jq去获取这个节点  绑定点击事件  layer 询问弹窗 确定的回调函数中发ajax请求  参数data加 csrf token 这些  然后ajax请求发成功后回掉函数
        // 获取dom节点   删除当前行的tr 提示一个layer弹窗  最后关闭浏览器默认行为 jq  return false
      Admin::destroy($id);
      return ['status'=>0,'msg'=>'删除成功'];
  }


  public function delall(Request $request){

    // 注释思路
    // 先定义路由 jq获取input 下name 等于ids的复选框  然后遍历复选框 得到被选中的id  
    // 写一个数组ids 把选中的id加进ids里
    // 然后发送ajax请求  把ids和定义好的token 放进ajax的data中   ajax回调函数删除 当前dom节点的tr
    $ids=$request->get('ids');
    Admin::destroy($ids);
    return ['status'=>0,'msg'=>'删除成功'];
  }

  public function restore(Request $request) {
    $id = $request->get('id');
    // 查找到此用户
    Admin::where('id', $id)->onlyTrashed()->restore();
    return ['status' => 0, 'msg' => '成功'];
}

    
}
