<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

# 引入邮件类
use Illuminate\Mail\Mailer;
use Mail;
use Illuminate\Mail\Message;

class LoginController extends Controller
{
    // 后台登录显示
    public function index(){
        // $chen=$_SERVER['SCRIPT_FILENAME'];
        // $chen=$_SERVER['QUERY_STRING'];
        // $chen=__FILE__;
        // dump($chen);die;
        return view('admin.login.index');
    }

    // 登录处理
    public function login(Request $request){
        // 表单验证 larvel5.5验证通过后返回验证字段值
        $data = $this->validate($request,[
            'username' => 'required',
            'password' => 'required',
        ]);
        

        // auth登录
        //$bool = auth()->guard('web')->attempt($data);
        // 简写 因为默认为web 如果不默认则一定要写guard指定
        $bool = auth()->attempt($data);

        // dump($bool);

        // // 得到用户的信息
        // dump(auth()->user());
        $haha=auth()->user();

        if(!$bool){
            return redirect(route('admin.login'))->withErrors(['error'=>'登陆失败']);
        }
        // // 发送登陆成功邮箱
        // Mail::send('admin.mailer.login',compact('haha'),function(Message $message) use ($haha){
        //     // 主题
        //     $message->subject('用户登陆通知');
        //     $message->to('906892939@qq.com','24.');
       
        // });
        // 跳转到后台首页  
        return redirect(route('admin.index'))->withErrors(['success'=>'登陆成功']);
        
    }


}
