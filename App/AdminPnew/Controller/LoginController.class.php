<?php
namespace AdminPnew\Controller;
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
	//判断是商户登录还是子商户登录
	//商户登录之后判断小程序属于哪个模板类型=》根据类型执行页面跳转到哪个控制器，商铺版有很多里有很多栏目，单页版只有两个
	//确定模板类型之后要确定模板特色，看看那些东西要隐藏（多点分销diy）
	
	//子商户登录的就暂时弄能上传商品  商品字段加一个子商户id
	
		if (!$_POST) $this->error('页面不存在!');
    	$name = I('name');
    	$admin_psw = I('psw','','md5');
    
    	if(empty($_POST["is_child"])){
    			
    		//没有子标志   这个是商户本人进来啦=============================================
    		$user = M('user_info')->where(array('name' => $name))->find();
			if (!$user || $user['psw'] != $admin_psw){
	    		$this->error('账号或密码错误!');
		    }
		   
	    	if(empty($user["program_id"])){
	    		$this->error('未绑定小程序!');
	    	}else{
	  			if($user["state"]!=1){
	  				$this->error('小程序登录限制!');
	  			}	  	
	    	}
	    	if ($user['lock']=='2') $this->error('用户已锁定');
	    	
		    //重重限制，终于能登录了=================================================================
			$data = array(
	    		'id' => $user['id'],
	    		'lasttime' => time(),
	    		'lastip' => get_client_ip(),
	    	);
	    	M('user_info')->where("program_id='".$user['program_id']."'")->save($data);//写入登录信息
	    	cookie('name_p', $user['name']);
	   
	    
	        cookie('program_id', $user['program_id']);
		    //有登录权限，这个时候要看看之后商户是的模板类型是哪个，商户版的就管理商户的，别的就管理别的
		    
		    $swith=M("qianyue")->where("program_id='".$user['program_id']."'")->find();
	
		 	cookie('function_id', $swith['function_id']);

		    $this->redirect('Index/index');//
	          
    	}else{
    		echo "子商户即将登录";die;
    		//带有子商户标识，子商户即将登录============================================
    	}
	}
	
	 /**
    * 退出登陆
    */
    public function logout() {
      cookie('name_p', null);
      cookie('program_id', null);
      cookie('function_id', null);
     // cookie('admin_p', null);
      $this->redirect('Login/index');
    }
}