<?php
namespace Agency\Controller;
use Think\Controller;
header("Content-Type:text/html;CharSet=UTF-8");
header("Access-Control-Allow-Origin:*");
header('Access-Control-Allow-Headers:x-requested-with,content-type');
class LoginController extends Controller {
	
	
	//服务商登录
	//需求参数  name   psw  POST传递
	//返回data
	public function login(){
	
	
		$receive=I();
		
		
		$time = time();
		$U=M('jt_user_info');
        $row= $U->where(array('user_name'=>$receive['name']))->find();
		if (!$row) {
            // 账号不存在
           $data=array("status" => -1, "msg" => "账号不存在");
           $this->ajaxReturn($data);
           exit;
       }
        $receive['psw'] =md5($receive['psw']);
        if ($row['user_psw'] !=$receive['psw']) {
            // 密码错误
            $data=array("status" => -1, "msg" => "密码错误");      
        } else {
            if ($row['status'] == 3 || $row['status'] == 4) {
                // 账号禁用
                $data=array("status" => -1, "msg" => "账号禁用");
            } else {
            	
                // 正常登陆
//              $this->where("`id` = {$row['id']}")->setInc("login_num");
                $date=date('ymdhis');
                $save = array("lasttime" => $time, "lastip" => $_SERVER['REMOTE_ADDR']);
                $U->where(array('user_id'=>$row['user_id']))->save($save);
//              setcookie("id",$row['id'],time()+24*3600*7,'/');
                $info=array('id'=>$row['user_id'],'company'=>$row['user_company']);
                $data=array("status" => 1, "msg" => "登陆成功",'userinfo'=>$info);
            }
		}
//		echo json_encode($data);
		$this->ajaxReturn($data);
//      $this->ajaxReturn($dat);
	}
	
	public function logout(){
//		if(I('act')='out'){
//			unset()
//		}
	}
	
	public function abc(){
//		echo md5(333);
		echo time();
	}
}
?>
