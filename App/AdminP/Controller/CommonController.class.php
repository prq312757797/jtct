<?php
namespace AdminP\Controller;
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
			
			$b=M("qianyue")->where("program_id='".$a['program_id']."'")->find();
			cookie('muban_tese', $b['muban_tese']);//模板特色
			
			cookie('muban_type', $b['muban_type']);//模板类型
			
			cookie('moban_fengge', $b['moban_fengge']);//模板风格   ---风格里面有风格特色
		}
		
		 $this->program_id=$_COOKIE["program_id"];
			// 1:商城版 2:单页版 5:资讯版   6:服务版 
			$this->head_menu=$_COOKIE["muban_type"];
	
		if($_COOKIE["muban_type"]==1){
//商城版===================================================================			
//商城版===================================================================		
			$date=explode(',',$_COOKIE["muban_tese"]);
			($date[1]) ? $duodian=1 : $duodian=2;
			($date[2]) ? $fenxiao=1 : $fenxiao=2;
			($date[3]) ? $diy=1 : $diy=2;
	
		
	
	
			$this->duodian=$duodian;	//多店标识
			$this->fenxiao=$fenxiao;	//分销标识
			$this->diy=$diy;			//Diy标识	
		}else if($_COOKIE["muban_type"]==2){
//单页版===================================================================			
//单页版===================================================================				
			
		}else if($_COOKIE["muban_type"]==5){
//资讯版===================================================================			
//资讯版===================================================================				
			
		}else if($_COOKIE["muban_type"]==6){
//服务版===================================================================			
//服务版===================================================================				
			$date=explode(',',$_COOKIE["muban_tese"]);
			($date[1]) ? $duodian=1 : $duodian=2;
			($date[2]) ? $fenxiao=1 : $fenxiao=2;
			($date[3]) ? $diy=1 : $diy=2;
	
	//判断多店属性，判断子商户是是不是有卖商品功能
	if($duodian==1){
		$store=M("store")->where("program_id='".$_COOKIE["program_id"]."'")->find();
		($store["is_sell_servers"]==1) ? $is_sell_servers=1 : $is_sell_servers=2;
		($store["is_put_info"]==1) ? $is_put_info=1 : $is_put_info=2;
		
		$this->is_sell_servers=$is_sell_servers;	//多店标识
			$this->is_put_info=$is_put_info;	//分销标识
	}
	
	
			$this->duodian=$duodian;	//多店标识
			$this->fenxiao=$fenxiao;	//分销标识
			//$this->diy=$diy;			//Diy标识	
		}
	
		if(empty($_COOKIE['name_p']) |empty($_COOKIE['program_id'])) {
			$this->redirect('Login/index');
		}
		
		$a11=$this->get_orderlist01(1);
		$a12=$this->get_orderlist01(2);
		$a13=$this->get_orderlist01(3);
		$a14=$this->get_orderlist01(4);
		$a15=$this->get_orderlist01(5);
		
		$this->apply_ing	=count($a11);
		$this->in_wait  	=count($a12);
		$this->in_ing  		=count($a13);
		$this->apply_reject =count($a14);
		$this->in_stop		=count($a15);

	}
	
	   //公用根据状态不同查询值
    function get_orderlist01($state=''){
     	$where["program_id"]=$_COOKIE["program_id"];
    	$where["state"]=$state;
    	
    	$field='
    	id,sort,sh_name,linkman,tel,time_add,time_over,state,main_project
		';
		$list=$this->list=M("user_info_dsh")
		->field($field)
		->where($where)
		->select();
		return $list;
	}
}