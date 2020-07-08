<?php
namespace Program\Controller;
use Think\Controller;
header('content-type:application:json;charset=utf8'); 
header('Access-Control-Allow-Origin:*'); 
//header('Access-Control-Allow-Methods:POST'); 
header('Access-Control-Allow-Headers:x-requested-with,content-type');
class UrlController extends Controller {
	//商品搜索
	//小程序ID program_id搜索关键字str
	public function goodsearch(){
		$G=M('goods');
		$str=I('str');
		$pid=I('program_id');
		$where['goods.program_id']=$pid;
		$where['goods_img.program_id']=$pid;
		$where['_string']="goods.goods_title like '%".$str."%'";
		$list=$G
		->group('goods_img.goods_id')
		->field('goods.id,goods.goods_title,goods.price_own,goods.price_sell,goods_img.image')
		->join('goods_img ON goods.id=goods_img.goods_id')
		->where($where)
		->select();
        $this->ajaxReturn($list);
	}
	
	//商品链接
	//小程序ID   商品ID
	//
	public function goods_url(){
		$id=I('goods_id');
		$url='../product/detail?productId='.$id;
		$this->ajaxReturn($url);
	}
	
	//商品分类
	//小程序ID 
	//
	public function goods_class(){
		$pid=I('program_id');
		$info=M("attribute")
		->field('id,uid,title')
		->where(array("is_show"=>1,"program_id"=>$pid))
		->select();
		$this->ajaxReturn($info);
	}
	
	//商品分类链接
	//分类ID 
	//
	public function  class_url(){
		$id=I('class_id');
		$url='pages/category/index?id='.$id;
		$this->ajaxReturn($url);
	}
	
	//其他链接展示
	//需求参数
	public function other_url(){
		$list=M('url')->select();
//		print_r($list);
        $this->ajaxReturn($list);
	}
	
	//返回链接
	//需求参数id
	public function get_url(){
		$id=I('id');
		$data=M('url')->field('url')->where('id='.$id)->find();
		
		$this->ajaxReturn($data);
	}
}
?>