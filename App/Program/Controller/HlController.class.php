<?php
namespace Program\Controller;
use Think\Controller;
use Think\DB;
header('content-type:application:json;charset=utf8'); 
header('Access-Control-Allow-Origin:*'); 
//header('Access-Control-Allow-Methods:POST'); 
header('Access-Control-Allow-Headers:x-requested-with,content-type');
header("Content-Type:text/html;CharSet=UTF-8");
class HlController extends Controller {
     
 	function dsh_chech_pay(){
		$a=M("h_admin")->field("is_on_charge_dsh,charge_dsh")->where("program_id='".$_GET["program_id"]."'")->find();
		if($a["is_on_charge_dsh"]==1){

			$date["state"]=1;
			$date["price"]=$a["charge_dsh"];
		}else{
			$date["state"]=2;
			$date["price"]=null;
		}
		$this->ajaxReturn($date);
	}
	
	
}
?>