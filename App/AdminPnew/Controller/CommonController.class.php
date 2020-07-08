<?php
namespace AdminPnew\Controller;
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
			cookie('function_id', $b['function_id']);//功能控制字符串

		}
		$this->program_id=$_COOKIE["program_id"];
		$arr=explode(",",$_COOKIE["function_id"]);
	
		(in_array("1", $arr)) ? $is_01=1 : $is_01=2;	//基础商城版
 		$this->is_01=$is_01;
 		
		(in_array("2", $arr)) ? $is_02=1 : $is_02=2;	//基础资讯版
		$this->is_02=$is_02;
		
		(in_array("3", $arr)) ? $is_03=1 : $is_03=2;	//基础服务版
		$this->is_03=$is_03;
		
		(in_array("4", $arr)) ? $is_04=1 : $is_04=2;	//多店铺功能
		$this->is_04=$is_04;
		
		(in_array("5", $arr)) ? $is_05=1 : $is_05=2;	//分销功能
		$this->is_05=$is_05;
		
		(in_array("6", $arr)) ? $is_06=1 : $is_06=2;	//优惠券
		$this->is_06=$is_06;
		
		(in_array("7", $arr)) ? $is_07=1 : $is_07=2;	//会员系统
		$this->is_07=$is_07;
		
		(in_array("8", $arr)) ? $is_08=1 : $is_08=2;	//积分系统
		$this->is_08=$is_08;
		
		(in_array("1", $arr)) ? $is_09=1 : $is_09=2;	//评论功能
		$this->is_09=$is_09;
		
		(in_array("10", $arr)) ? $is_10=1 : $is_10=2;	//会话功能
		$this->is_10=$is_10;
		
		(in_array("11", $arr)) ? $is_11=1 : $is_11=2;	//首页显示视频
		$this->is_11=$is_11;
		
		(in_array("12", $arr)) ? $is_12=1 : $is_12=2;	//首页显示分类
		$this->is_12=$is_12;
		
		(in_array("13", $arr)) ? $is_13=1 : $is_13=2;	//会员多身份信息交互
		$this->is_13=$is_13;

		(in_array("14", $arr)) ? $is_14=1 : $is_14=2;	//小程序欢迎页面
		$this->is_14=$is_14;
		
		(in_array("16", $arr)) ? $is_16=1 : $is_16=2;	//案例展示
		$this->is_16=$is_16;
		
		/*	// 1:商城版 2:单页版 5:资讯版   6:服务版 
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
	

			$this->duodian=$duodian;	//多店标识
			$this->fenxiao=$fenxiao;	//分销标识
			//$this->diy=$diy;			//Diy标识	
		}*/
	
		if(empty($_COOKIE['function_id']) |empty($_COOKIE['program_id'])) {
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