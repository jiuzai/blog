@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; &raquo; 编辑分类
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
            @if(count($errors)>0)
            <div class="mark">
                @foreach($errors->all() as $error)
                <p>{{$error}}</p>    
                @endforeach
            </div>
            @endif
            @if(session('msg'))
            <div class="mark">
                <p>{{session('msg')}}</p>
            </div>
            @endif
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="#"><i class="fa fa-plus"></i>新增文章</a>
                <a href="#"><i class="fa fa-recycle"></i>批量删除</a>
                <a href="#"><i class="fa fa-refresh"></i>更新排序</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="#" method="post">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="put">
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120"><i class="require">*</i>父级分类：</th>
                        <td>
                            <select name="cate_pid">
                                <option value="0">==顶级分类==</option>
                                @foreach($data as $val)
                                @if($val['cate_id'] == $cate->cate_id)
                                <option selected value="{{$val['cate_pid']}}">{{$val['seperator']}}{{$val['cate_name']}}</option>
                                @else
                                <option  value="{{$val['cate_pid']}}">{{$val['seperator']}}{{$val['cate_name']}}</option>
                                @endif
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>分类名称：</th>
                        <td>
                            <input type="text" name="cate_name" value="{{$cate->cate_name}}">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>分类标题：</th>
                        <td>
                            <input type="text" class="lg" name="cate_title" value="{{$cate->cate_title}}">
                            <p>标题可以写30个字</p>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>关键字：</th>
                        <td>
                            <input type="text" class="sm" name="cate_keywords" value="{{$cate->cate_keywords}}">
                        </td>
                    </tr>
                    <tr>
                        <th>分类描述：</th>
                        <td>
                            <textarea name="cate_description">{{$cate->cate_description}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>分类排序：</th>
                        <td>
                            <input type="text" class="lg" name="cate_order" value="{{$cate->cate_order}}">
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>

</body>
@endsection