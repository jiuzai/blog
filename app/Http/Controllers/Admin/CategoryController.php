<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Model\Category;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\In;

class CategoryController extends CommController
{
    //get admin.category 显示全部分类
    public function index(){
       $class_tree = (new Category())->tree();
        return view('admin.category.index')->with('data',$class_tree);
    }

    //添加分类
    public function create(){
        $data = (new Category())->tree();
        return view('admin.category.add')->with('data',$data);
    }

    //post admin.category
    public function store(){
        $input = Input::except('_token');
        $rules = [
            'cate_name'=>'required',
            'cate_title'=>'required',
        ];
        $message = [
            'cate_name.required'=>'分类名称不能为空',
            'cate_title.required'=>'分类标题不能为空',
        ];
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $result =  Category::create($input);
            if($result){
                return redirect('admin/category');
            }else{
                return back()->with('msg','添加分类失败！');
            }
        }else{
            return back()->withErrors($validator);
        }
    }

    //get admin/category/{category} 显示单个分类
    public function show(){
        
    }

    //delete admin/category/{category} 删除分类
    public function destroy(){
        $input = Input::all();
        $cate_set = array($input['cate_id']);
        $all_class = Category::orderBy('cate_order', 'asc')->get();
        (new Category())->get_cate_set($input['cate_id'], $all_class, $cate_set);
        $flag = true;
        foreach($cate_set as $cate){
            $result = Category::where('cate_id', $cate)->delete();
            if(!$result){
                $flag = false;
            }
        }
        if($flag){
            $data = [
                'status' => 0,
                'msg' => '分类删除成功!'
            ];
        }
        else{
            $data = [
                'status' => 1,
                'msg' => '分类删除失败!'
            ];
        }
        return $data;
    }

    //put,patch admin/category/{category} 更新分类
    public function update($cate_id){
        $input = Input::except('_token','_method');
        $result = Category::where('cate_id',$cate_id)->update($input);
        if($result){
            return redirect('admin/category');
        }else{
            return back()->with('msg','更新分类信息失败！');
        }
    }

    //get admin/category/{category}/edit 编辑分类
    public function edit($cate_id){
        $cate = Category::find($cate_id); 
        $data = (new Category())->tree();
        return view('admin.category.edit',compact('cate', 'data'));
    }

    public function changeOrder(){
        $input = Input::all();
        $cate = Category::find($input['cate_id']);
        $cate->cate_order = $input['cate_order'];
        $result = $cate->update();
        if($result){
            $data = [
                'status'=>0,
                'msg'=>'排序更新成功'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'排序更新失败'
            ];
        }
        return $data;
    }
}
