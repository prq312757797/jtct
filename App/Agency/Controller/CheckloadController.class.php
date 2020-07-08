<?php
namespace Agency\Controller;
use Think\Controller;
header('content-type:application:json;charset=utf8'); 
header('Access-Control-Allow-Origin:*');  
header('Access-Control-Allow-Headers:x-requested-with,content-type');
class CheckloadController extends Controller {
	
	//服务商管理平台  登录验证
	function check_load(){
		/*$ew["name"]=date("Y-m-d H:i:s",time());
		M("test")->add($ew);
		$this->ajaxReturn($_POST);*/
		$where["user_name"]=$_POST["name"];
		$a=M("jt_user_info")->where($where)->find();
	
		if($a["user_psw"]==md5($_POST["psw"])){
			
			cookie("user_name",$a["user_name"]);
			$data=array('status'=>1,'msg'=>'允许登录','program_id'=>$a["program_id"]);
		}else{
			$data=array('status'=>2,'msg'=>'密码错误');
		}
		$this->ajaxReturn($data);
	}
	
	//服务商验证cookie
	function check_cookie(){
		
		if($_COOKIE["user_name"]=$_GET["user_name"]){
			$data=array('status'=>1,'msg'=>'状态已登录，可以继续操作');
		}else{
			$data=array('status'=>2,'msg'=>'状态未登录，禁止继续操作');
		}
		
		$this->ajaxReturn($data);
	}
}
?>