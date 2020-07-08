<?php
namespace AdminShp\Controller;
use Think\Controller;
class IndexOnepageController extends CommonController {
    public function index(){
		$id=$_COOKIE["program_id"];
		
		//小程序基本信息
		$this->storeinfo=M('store')
		->field('program_title,program_logo,abstract')
		->where(array('program_id'=>$id))
		->find();
		
		
    	$this->display();
	}
	
	
}