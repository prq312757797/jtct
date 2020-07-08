<?php
namespace Agency\Controller;
use Think\Controller;
header("Content-Type:text/html;CharSet=UTF-8");
header("Access-Control-Allow-Origin:*");
class RechargeController extends Controller {
	
	//充值记录
	//需求参数 服务商id
	public function recharge_list(){
		$where['user_agency_id']=I('id');
		$Mysql=M('recharge_info');
		$list=$Mysql
		->field('recharge_info.recharge_gold,recharge_info.recharge_time,
		recharge_info.content,recharge_info.state,jt_user_info.user_company')
		->join('jt_user_info ON recharge_info.user_agency_id=jt_user_info.admin_id')
		->where($where)
		->select();

		$this->ajaxReturn($list);
	}
	
	//充值记录搜索
	//需求参数 服务商ID  start  end
	
	public  function recharge_search(){
		$where['user_agency_id']=I('id');
		$Mysql=M('recharge_info');
		$start=I('start');
		$end=I('end');
		$stampt=strtotime(date($start));
		$nt=strtotime(date($end));
		$where['recharge_time']=array(array('EGT',$stampt),array('ELT',$nt));
		$list=$Mysql->field('recharge_gold,recharge_time,user_company,content,state')->where($where)->select();
//				echo '<pre/>';
//		print_r($list);
		$this->ajaxReturn($list);
//      echo date('Y-m-d h:i:s',1503106027);

	}
}
?>