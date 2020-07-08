<?php
namespace Home\Controller;
use Think\Controller;
class Common02Controller extends CommonController {
    	protected function _initialize() {
		
		
			$this->is_action03="1";
		
		$this->is_action01=null;
		$this->is_action02=null;
		
		 cookie('name_z', null);
		if(empty($_COOKIE['name_h'])) {
			$this->redirect('Login/index');
		}
	
	}
}