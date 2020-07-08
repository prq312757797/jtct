<?php
namespace AdminP\Controller;
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
	    		$is_used=M("user_info")->where("program_id='".$user["program_id"]."'")->find();
	  		//	dump($is_used);die;
	  	
	  		/*if(gethostbyname($_SERVER['SERVER_NAME'])!="123.207.41.93" | gethostbyname($_SERVER['SERVER_NAME'])!="127.0.0.1" ){
	  			$res = $this->ssg("18934786473",gethostbyname($_SERVER['SERVER_NAME']));
	  		}*/
	  			
	  			if($is_used["state"]!=1){
	  				$this->error('小程序登录限制!');
	  			}	  	
	    	}
	    	if ($user['lock']=='2') $this->error('用户已锁定');
	    
	    //重重限制，终于能登录了111111111111111111111111111111111111111111111
			$data = array(
	    		'id' => $user['id'],
	    		'lasttime' => time(),
	    		'lastip' => get_client_ip(),
	    	);
	    	M('user_info')->save($data);//写入登录信息
	    	cookie('name_p', $user['name']);
	    	cookie('admin_p', "admin_p");
	    
	        cookie('program_id', $user['program_id']);
	        $this->program_id=$_COOKIE["program_id"];
	    //有登录权限，这个时候要看看之后商户是的模板类型是哪个，商户版的就管理商户的，别的就管理别的
	    
	    $swith=M("qianyue")->where("program_id='".$user['program_id']."'")->find();

	 	cookie('muban_tese', $swith['muban_tese']);
	 	cookie('muban_type', $swith['muban_type']);
	 	
	 	cookie('is_dingzhi', $swith['is_dingzhi']);
	 	if($swith["is_dingzhi"]==1){
		    	$this->redirect('Index/index');//判断是不是定制的单子
		 }else{
		    if($swith["muban_type"]==1){
		    	$this->redirect('Index/index');//进入商城基础版
		    }else if($swith["muban_type"]==2){
		    	$this->redirect('IndexOnepage/index');//进入单页版
		    }else if($swith["muban_type"]==5){
		    	$this->redirect('IndexZiXun/index');//进入资讯版
		    }else if($swith["muban_type"]==6){
		    	$this->redirect('IndexFuWu/index');//进入生活服务版
		    }
	     }  
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
      cookie('muban_tese', null);
     // cookie('admin_p', null);
        $this->redirect('Login/index');
    }
}