<?php
namespace HProgram\Controller;
use Think\Controller;
header('content-type:application:json;charset=utf8'); 
header('Access-Control-Allow-Origin:*'); 
//header('Access-Control-Allow-Methods:POST'); 
header('Access-Control-Allow-Headers:x-requested-with,content-type');
class CommonController extends Controller {
    	protected function _initialize() {
    
    
    if($_COOKIE["program_id"]=$_GET["program_id"]){
			$data=array('status'=>1,'msg'=>'状态已登录，可以继续操作');
			
		}else{
			$data=array('status'=>2,'msg'=>'状态未登录，禁止继续操作');
			$this->ajaxReturn($data);
		}
		
		
		if(!isset($_SESSION['is_load'])) {
			//$this->redirect('Login/index');
		}
	
	}
	
}