<?php
namespace Hl\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index(){

	if(empty($_GET)){
			$this->title="用户登录";
		}else{
			$this->title="子商户登录";
			$this->is_child="1";
		}
		$this->display();
	}
	
	public function login(){

		if (!$_POST) $this->error('页面不存在!');
    	$name = I('name');
    	$admin_psw = I('psw','','md5');
 
    	if(empty($_POST["is_child"])){
    		//商户登录
    		$user = M('h_admin')->where(array('name' => $name))->find();
		
			if (!$user || $user['psw'] != $admin_psw){
	    		$this->error('账号或密码错误!');
		   }
	    	if ($user['lock']=='0') $this->error('用户已锁定');

	        cookie('program_id', $user['program_id']);
	        $this->program_id=$_COOKIE["program_id"];

		 	$this->redirect('Index/index');
		 	
    	}else{
    		echo "子商户即将登录";die;
    		//子商户即将登录
    	}
	}
	
	 /**
    * 退出登陆
    */
    public function logout() {
   
      	cookie('program_id', null);

        $this->redirect('Login/index');
    }
}