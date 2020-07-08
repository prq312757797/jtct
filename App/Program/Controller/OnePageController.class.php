<?php
namespace Program\Controller;
use Think\Controller;
header('content-type:application:json;charset=utf8'); 
header('Access-Control-Allow-Origin:*'); 
//header('Access-Control-Allow-Methods:POST'); 
header('Access-Control-Allow-Headers:x-requested-with,content-type');


class OnePageController extends Controller {
	
	//手机端   单页小程序
	function one_index_show(){
 		$data=M("store")
		->field('image_one_page')
		->where("program_id='".$_GET["program_id"]."'")
		->find();
		
		$this->ajaxReturn($data);
	}

	
}

?>