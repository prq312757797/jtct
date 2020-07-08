<?php
namespace Agency\Model;
use Think\Model;
class DealInfoModel extends Model {
	
	//获取消费记录
	function deal_list(){
		$id=session('user.id');
		$list=$this->where(array('user_agency_id'=>$id))->select();
		return $list;
	}
}
?>