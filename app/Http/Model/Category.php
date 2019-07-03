<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'blog_category';
    protected $primaryKey = 'cate_id';
    public $timestamps = false;
    protected $guarded = [];

    public function tree(){
        $category = $this->orderBy('cate_order','asc')->get();
        $class_tree = array();
        $this->get_class_tree('0',$category,$class_tree,'┣');
        return $class_tree;
    }

    //获取分类树层次
    public function get_class_tree($id,$all_class,&$class_tree,$seperator){
        $seperator .= '─';
        foreach($all_class as $class){
            if($class['cate_pid']==$id){
                $new_node = array("cate_id"=>$class['cate_id'],
                        "cate_pid"=>$class['cate_pid'],
                        "cate_order"=>$class['cate_order'],
                        "cate_title"=>$class['cate_title'],
                        "cate_view"=>$class['cate_view'],
                        "cate_name"=>$class['cate_name'],
                        'seperator'=>$seperator);
                array_push($class_tree, $new_node);
                $this->get_class_tree($class['cate_id'],
                        $all_class, $class_tree, $seperator);
            }
        }
        return;
    }

    public function get_cate_set($id, $all_class, &$cate_set){
        foreach($all_class as $class){
            if($class['cate_pid'] == $id){
                array_push($cate_set, $class['cate_id']);
                $this->get_cate_set($class['cate_id'], $all_class, $cate_set);
            }
        }
        return;
    }
}
