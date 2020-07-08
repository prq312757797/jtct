<?php
namespace AdminShp\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index(){
	
		$this->ownid=$_GET["ownid"];
		
		$this->display();
	}
	
	public function login(){
		
	//判断是商户登录还是子商户登录
	//商户登录之后判断小程序属于哪个模板类型=》根据类型执行页面跳转到哪个控制器，商铺版有很多里有很多栏目，单页版只有两个
	//确定模板类型之后要确定模板特色，看看那些东西要隐藏（多点分销diy）
	
	//子商户登录的就暂时弄能上传商品  商品字段加一个子商户id
	
		if (!$_POST) $this->error('请填写正确的账号密码!');
		if (empty($_GET["ownid"])) $this->error('登录错误!');
    	$name = I('name');
    	$admin_psw = I('psw','','md5');
 
     $where["user_info_dsh.sh_account"]=$name;
     $where["user_info_dsh.user_id"]=$_GET["ownid"];
     	


$a=M("user_info")->where("id='".$_GET["ownid"]."'")->find();
$user = M('user_info_dsh')->where("sh_account='".$name."'"."and program_id='".$a["program_id"]."'")->find();
	//dump($user);dump(M('user_info_dsh')->_sql());dump($admin_psw);die;
			if (!$user || $user['sh_psw'] != $admin_psw){
	    		$this->error('账号或密码错误!');
		    }
	    	if($a["is_on_dsh"] !=1){
	    		$this->error('多商户功能关闭!');
	    	}
	    	if($user["state"] !=3){
	    		$this->error('账号登录限制!');
	    	}
	    	
 
     	 	cookie('ownid', $_GET["ownid"]);
	    	cookie('admin_dsh', $name);
	    	cookie('admin_dsh_id', $user['id']);
	        cookie('program_id', $user['program_id']);
	    //有登录权限，这个时候要看看之后商户是的模板类型是哪个，商户版的就管理商户的，别的就管理别的
	
	    	$this->redirect('Index/index');
	  
	}
	
	 /**
    * 退出登陆
    */
    public function logout() {
      cookie('admin_dsh', null);
      cookie('program_id', null);
      cookie('admin_dsh_id', null);
     // cookie('admin_p', null);
        $this->redirect('Login/index?ownid='.$_GET["ownid"]);
    }
}