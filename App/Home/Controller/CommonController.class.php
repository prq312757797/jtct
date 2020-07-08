<?php
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {
    	protected function _initialize() {
	 //cookie('name_p', null);
	 cookie('name_z', null);
	// cookie('admin_index', null);
	/*echo 123;
	dump($_COOKIE['name_h']);*/

		if(empty($_COOKIE['name_h'])) {
			$this->redirect('Login/index');
		}
		
	
	}
}