<?php
namespace AdminSh\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){

		
		
		//小程序基本信息
		$this->storeinfo=M('user_info_dsh')
		->field('sh_name,logo,introduce,main_project')
		->where(array('id'=>$_COOKIE["admin_dsh_id"]))
		->find();
		
		//完成的订单数
		$a1=$this->order_form_1=M('order_form')->where("state=7 and dsh_id='".$_COOKIE["admin_dsh_id"]."'"." and program_id='".$_COOKIE["program_id"]."'")->count();

		//代发货
		$a2=$this->order_form_2=M('order_form')->where("state=2 and dsh_id='".$_COOKIE["admin_dsh_id"]."'"." and program_id='".$_COOKIE["program_id"]."'")->count();
		
		//退换/售后
		$a3=$this->order_form_5=M('order_form')->where("state=5 and dsh_id='".$_COOKIE["admin_dsh_id"]."'"." and program_id='".$_COOKIE["program_id"]."'")->count();
		//	dump($a1;dump($a2);dump($a3);die;
    	$this->display();
	}
	
	
}