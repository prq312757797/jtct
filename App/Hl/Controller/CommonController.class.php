<?php
namespace Hl\Controller;
use Think\Controller;
class CommonController extends Controller {
    	protected function _initialize() {

	//如果是服务商进来 效果等同商户登录，可以使用商户信息登录，反正也看不到
		if($_GET["shanghu_id"]){		
			$a=M("h_admin")->where("id='".$_GET["shanghu_id"]."'")->find();			
			cookie('program_id', $a['program_id']);			
		}
	if( empty($_COOKIE['program_id'])) {
		
			$this->redirect('Login/index');
		}
		$this->program_id=$_COOKIE["program_id"];
		
		$this->apply_ing	=$this->count_dsh(1);
		$this->in_wait  	=$this->count_dsh(2);
		$this->in_ing  		=$this->count_dsh(3);
		$this->apply_reject =$this->count_dsh(4);
		$this->in_stop		=$this->count_dsh(5);
	

	}

	   //公用根据状态不同查询值
    function count_dsh($state=''){
     	$where["program_id"]=$_COOKIE["program_id"];
    	$where["state"]=$state;
    	$field='
    	id,sort,sh_name,linkman,tel,time_add,time_over,state,main_project
		';
		$list=$this->list=M("h_user_info_dsh")->field($field)->where($where)->count();
		return $list;
	}
}