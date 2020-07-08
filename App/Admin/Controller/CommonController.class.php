<?php
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller {
    	protected function _initialize() {
	// cookie('admin_p', null);
	// cookie('admin_z', null);
	// cookie('admin_index', null);
	
		if(empty($_COOKIE['admin_id']) ) {
		//if(($_SESSION['admin_id'])) {
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
    	
    	if($_COOKIE["lever"]==1){
    		$this->is_admin="1";//超级管理员，有全部权限
    	}else if($_COOKIE["lever"]==2){
    		$this->is_admin="2";//客服管理员，仅有小程序权限
    	}else if($_COOKIE["lever"]==3){
    		$this->is_admin="3";//上传管理
    	}
    	
    	
	}
}