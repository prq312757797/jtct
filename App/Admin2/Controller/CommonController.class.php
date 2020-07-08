<?php
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller {
    	protected function _initialize() {
	
	//$this->redirect('Login/index');
		if(!isset($_SESSION['admin_id'])) {
			$this->redirect('Login/index');
		}
		$notAuth=in_array(MODULE_NAME,explode(',',C('NOT_AUTH_MODULE')))||in_array(ACTION_NAME,explode(',',C('NOT_AUTH_ACTION')));
		if(C('USER_AUTH_ON')&&!$notAuth) {
			RBAC::AccessDecision()||$this->error('没有权限');
		}
		if(!(APP_NAME == 'admin' && CONTROLLER_NAME == 'Login')){
			//赋值当前菜单
	        if(method_exists($this,'_infoModule')){
	            $this->infoModule = $this->_infoModule();
	        }
    	}
	}
}