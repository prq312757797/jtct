<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index(){
    //header('Location:http://www.jt.com/static/#/');

	$this->display();
    }
    
    public function login(){
    	if (!$_POST) $this->error('页面不存在!');
   
    	$admin_psw = I('psw','','md5');
		
		
    	$user = M('jt_user_info')->where(array('user_name' => $_POST["name"]))->find();
    
		if (!$user || $user['user_psw'] != $admin_psw){
    		$this->error('账号或密码错误!');
    	}
    
    
    //	if ($user['lock']=='2') $this->error('用户已锁定');

    	$data = array(
    		'user_id' => $user['id'],
    		'user_lasttime' => time(),
    		'user_lastip' => get_client_ip(),
    	);
    	M('jt_user_info')->save($data);//写入登录信息
    	cookie('name_h', $user['user_name']);
    
       $this->redirect('Index/index');
    	
    }
    
     /**
    * 退出登陆
    */
    public function logout() {
        cookie('name_h', null);
  		
        $this->redirect('Login/index');
    }
}