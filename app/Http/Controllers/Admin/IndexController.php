<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{
    public function index(){
        return view('admin.index');
    }
    public function info(){
        return view('admin.info');
    }
    public function pass(){
        if($input = Input::all()){
            $rules = ['password'=>'required|between:6,20|confirmed',];
            $message = [
                'password.required'=>'新密码不能为空',
                'password.between'=>'新密码必须在6-20位之间',
                'password.confirmed'=>'两次输入密码不一致',
            ];
            $validator = Validator::make($input,$rules,$message);
            if($validator->passes()){
                $user = User::first();
                $_password = Crypt::decrypt($user->pw);
                if($input['password_o']==$_password){
                    $user->pw = Crypt::encrypt($input['password']);
                    $user->save();
                    return view('admin.info');
                }else{
                    return back()->with('msg', '原密码错误');
                }
            }else{
                return back()->withErrors($validator);
            }
        }else{
            return view('admin.pass');
        }
    }
}
