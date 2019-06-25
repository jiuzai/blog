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
            //检查验证码
            $code = new \Code;
            $_code = $code->get();
            if(strtoupper($input['code'])!=$_code){
                return back()->with('msg', '验证码错误');
            }
            //检查用户名、密码
            $user = User::where('name', $input['username'])->get();
            dd($user);
            echo $input['username'];
        }else{
            return view('admin.login');
        }
    }
    public function code(){
        $code = new \Code;
        $code->make();
    }
}
