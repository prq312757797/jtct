<?php
namespace AdminSh\Controller;
use Think\Controller;
class CommonController extends Controller {
    	protected function _initialize() {
	
	// cookie('admin_p', null);
	cookie('name_z', null);
	// cookie('admin_index', null);
	
	//如果是服务商进来 效果等同商户登录，可以使用商户信息登录，反正也看不到
	
		if($_GET["shanghu_id"]){
			$a=M("user_info")->where("id='".$_GET["shanghu_id"]."'")->find();
			cookie('name_p', $a["name"]);
			cookie('program_id', $a['program_id']);
		}
$this->program_id=$_COOKIE['program_id'];
		//判断子商户功能  发布时商品、发布资讯
		$a=M("store")->where("program_id='".$_COOKIE["program_id"]."'")->find();
	
		if($a["is_sell_servers"]==1) $this->is_sell_servers=1;
		if($a["is_put_info"]==1) $this->is_put_info=1;

		$this->sh_account=$_COOKIE['admin_dsh'];
		$this->ownid=$_COOKIE['ownid'];
		if(empty($_COOKIE['admin_dsh'])) {
			$this->redirect('Login/index');
		}

	}
}