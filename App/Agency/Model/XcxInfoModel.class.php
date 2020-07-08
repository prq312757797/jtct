<?php
namespace Agency\Model;
use Think\Model;
class XcxInfoModel extends Model {
	
	//获取小程序信息
	function get_xcx(){
		$id=session('user.id');
		$list=$this->where(array('user_agency_id'=>$id))->select();
		return $list;
	}
}
?>