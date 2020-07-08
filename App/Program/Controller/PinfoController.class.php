<?php
namespace Program\Controller;
use Think\Controller;
header('content-type:application:json;charset=utf8'); 
header('Access-Control-Allow-Origin:*'); 
//header('Access-Control-Allow-Methods:POST'); 
header('Access-Control-Allow-Headers:x-requested-with,content-type');


class PinfoController extends Controller {
	//查询小程序是否开启分销功能
	function is_on_fenxiao(){
		$a=M("fx_info")->field('is_on_fenxiao')->where("program_id='".$_GET["program_id"]."'")->find();
		
		$data=array('data'=>$a["is_on_fenxiao"],'msg'=>"是否开启分销功能（1：开启、2：不开（默认）");
		$this->ajaxReturn($data);
	}
	
}

?>