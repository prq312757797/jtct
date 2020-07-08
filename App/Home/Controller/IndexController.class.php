<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {
	
/*	protected function _initialize() {
		$this->is_action01="1";
		
		$this->is_action02=null;
		$this->is_action03=null;
	}*/
	
    public function index(){
	
    	$this->is_action01="1";
		
		$this->is_action02=null;
		$this->is_action03=null;
    	
    	$agency=$this->agency=M("jt_user_info")
    	->field('user_name,user_company')
    	->where("user_name='".$_COOKIE["name_h"]."'")
    	->find();
    	
    	$this->display();
    }
    
    //修改 密码
     function change_psw(){
     	
     	if(empty($_POST["psw_old"])|empty($_POST["psw_new_1"])|empty($_POST["psw_new_2"])) $this->error('请输入完整内容!');
     	
     	$agency=M("jt_user_info")
    	->where("user_name='".$_COOKIE["name_h"]."'")
    	->find();
    	if(md5($_POST["psw_old"])!=$agency["user_psw"]) $this->error('原密码输入错误!');
    	
    	if($_POST["psw_new_1"]!=$_POST["psw_new_2"]) $this->error('两次密码输入错误!');
    	
    	$change["user_psw"]=md5($_POST["psw_new_1"]);
    	 
    	if(M("jt_user_info")->where("user_name='".$_COOKIE["name_h"]."'")->save($change)){
    		$this->success('操作成功',U('index'));
    	} else{
    		$this->error('操作失败!');
    	}
    }
    //修改交易密码
    function change_psw_deal(){
    	//user_zfpsw
if(empty($_POST["user_zfpsw_old"])|empty($_POST["user_zfpsw_new_1"])|empty($_POST["user_zfpsw_new_2"])) $this->error('请输入完整内容!');
    
    	$agency=M("jt_user_info")
    	->where("user_name='".$_COOKIE["name_h"]."'")
    	->find();
    	if(md5($_POST["user_zfpsw_old"])!=$agency["user_zfpsw"]) $this->error('原密码输入错误!');
    	
    	if($_POST["user_zfpsw_new_1"]!=$_POST["user_zfpsw_new_2"]) $this->error('两次密码输入错误!');
    	
    	$change["user_zfpsw"]=md5($_POST["user_zfpsw_new_1"]);
    	 
    	if(M("jt_user_info")->where("user_name='".$_COOKIE["name_h"]."'")->save($change)){
    		$this->success('操作成功',U('index'));
    	} else{
    		$this->error('操作失败!');
    	}
    }
}