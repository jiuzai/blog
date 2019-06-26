<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //get admin.category 显示全部分类
    public function index(){
        $category = Category::all();
        return view('admin.category.index')->with('data',$category);
    }

    //post admin.category
    public function store(){
        
    }

    //添加分类
    public function create(){
        
    }

    //get admin/category/{category} 显示单个分类
    public function show(){
        
    }

    //delete admin/category/{category} 删除分类
    public function destroy(){
        
    }

    //put,patch admin/category/{category} 更新分类
    public function update(){
        
    }

    //get admin/category/{category}/edit 编辑分类
    public function edit(){
        
    }
}
