<?php

namespace App\Http\Controllers\Admin;

require_once 'resources/views/org/Code.class.php';

use App\Http\Model\User;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Crypt;

class LoginController extends CommController
{
    public function login(){
        if($input = Input::all()){
            $code = new \Code;
            $_code = $code->get();
            $user = User::where('name', $input['username'])->get();
            $isAuth = false;
            foreach($user as $one){
                if(Crypt::decrypt($one->pw)==$input['password']){
                    $isAuth = true;
                    session(['user'=>$one]);
                }
            }
            if(!$isAuth){
                return back()->with('msg', '用户名或密码错误');
            }
            //检查验证码
            if(strtoupper($input['code'])!=$_code){
                return back()->with('msg', '验证码错误');
            }
            return redirect('admin/index');
        }else{
            return view('admin.login');
        }
    }
    public function code(){
        $code = new \Code;
        $code->make();
    }
    public function logout(){
        session(['user'=>null]);
        return redirect('admin/login');
    }
}