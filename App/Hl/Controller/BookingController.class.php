<?php
namespace Hl\Controller;
use Think\Controller;
header("Content-type: text/html; charset=utf-8"); 
class BookingController extends CommonController {
	//预定管理
    public function index(){
		
		$field="booking.id,booking.openid,booking.goods_id,booking.time_set,booking.time_done,booking.timt_none,booking.state,
		booking.date_d,booking.date_time,booking.name,booking.tel,
		
		goods.goods_title,goods.server_man,goods.server_phone
		";
		$this->list=M("booking")->field($field)
		->join("left join goods on goods.id = booking.goods_id")
		->where("booking.state=0 and booking.program_id='".$_COOKIE["program_id"]."'")->select();
    	$this->display();
	}

	    public function booking_done(){
		
		$field="booking.id,booking.openid,booking.goods_id,booking.time_set,booking.time_done,booking.timt_none,booking.state,
		booking.date_d,booking.date_time,booking.name,booking.tel,
		
		goods.goods_title,goods.server_man,goods.server_phone
		";
		$this->list=M("booking")->field($field)
		->join("left join goods on goods.id = booking.goods_id")
		->where("booking.state=1 and booking.program_id='".$_COOKIE["program_id"]."'")->select();
    	$this->display();
	}
	    public function booking_none(){
		
		$field="booking.id,booking.openid,booking.goods_id,booking.time_set,booking.time_done,booking.timt_none,booking.state,
		booking.date_d,booking.date_time,booking.name,booking.tel,
		
		goods.goods_title,goods.server_man,goods.server_phone
		";
		$this->list=M("booking")->field($field)
		->join("left join goods on goods.id = booking.goods_id")
		->where("booking.state=2 and booking.program_id='".$_COOKIE["program_id"]."'")->select();
    	$this->display();
	}
	
	function booking_edone(){
		
		$save["state"]="1";
		$save["time_done"]=time();
		
		if(M("booking")->where("id='".$_GET["id"]."'")->save($save)){
	    	$this->success('操作成功',U('booking_done'));
	    }else{
	    	$this->error('操作失败');	
	    }
	}
	function booking_enone(){
		$save["state"]="2";
		$save["timt_none"]=time();
		$save["admin_none"]="1";
		if(M("booking")->where("id='".$_GET["id"]."'")->save($save)){
	    	$this->success('操作成功',U('booking_done'));
	    }else{
	    	$this->error('操作失败');	
	    }
	}
}