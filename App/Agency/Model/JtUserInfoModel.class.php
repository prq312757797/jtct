<?php
namespace Agency\Model;
use Think\Model;
class JtUserInfoModel extends Model {
	
	//检测登录
    public function check_login($user_name,$user_psw){
    	$time = time();
        $row = $this->where(array('user_name'=>$user_name))->find();
        if (!$row) {
            // 账号不存在
           $data=array("status" => -1, "msg" => "账号不存在");
           return $data;
        }
        $user_psw =md5($user_psw);
//      echo '<pre/>';
//      print_r($row);
//      echo $password;
        if ($row['user_psw'] != $user_psw) {
            // 密码错误
            $data=array("status" => -1, "msg" => "密码错误");
            return $data;       
        } else {
            if ($row['status'] == 0) {
                // 账号禁用
                $data=array("status" => -1, "msg" => "账号禁用");
                return $data;
            } else {
                // 正常登陆
//              $this->where("`id` = {$row['id']}")->setInc("login_num");
                $save = array("user_lasttime" => $time, "user_lastip" => $_SERVER['REMOTE_ADDR']);
                $this->where("`user_id` = {$row['user_id']}")->save($save);
//              $auth = D("Group")->get_auth($row['group_id']);    // 获取权限
//              session("auth", $auth);
//              session("user.name", $row['user_name']);
//              session("user.id", $row['user_id']);
//              session("user.zfpsw", $row['user_zfpsw']);
//              session("user.company", $row['user_company']);
//              session('user.psw',$row['user_psw']);
                setcookie("user_id",$row['user_id'],time()+24*3600*7);
                $userinfo=array('user_id'=>$row['user_id'],'user_type'=>$row['user_type'],'user_company'=>$row['user_company']);
                $data=array("status" => 1, "msg" => "登陆成功",'userinfo'=>$userinfo);
                return $data;
            }
    }
    
    //修改服务商密码
     function update_psw($name,$psw,$newpsw1,$newpsw2){ 
     	if($name!=session('user.name')){
    		$data=array("status"=>-1,"msg"=>"账号不正确");
    		return $data;
    		}
    	$ypsw=session('user.psw');	
        $psw=md5($psw);
        if($psw!=$ypsw){
        	$data=array("status"=>-1,"msg"=>"原密码不正确");
        	return $data;
        }else{
        	if($newpsw1!=$newpsw2){
        		$data=array("status"=>-1,"msg"=>"新密码二次确认不符");
        		return $data;
        	}else{
        		$this->where("`user_id` = {$row['user_id']}")->save(array('user_psw'=>md5($newpsw1)));
        		$data=array("status"=>1,"msg"=>"修改成功");
        		return $data;
        	}
        }     
    } 
  
    function update_zfpsw($name,$psw,$newpsw1,$newpsw2){
    	if($name!=session('user.name')){
    		$data=array("status"=>-1,"msg"=>"账号不正确");
    		return $data;
    	}else{
    		$zfpsw=session('user.zfpsw');
    		$psw=md5($psw);
        if($psw!=$zfpsw){
        	$data=array("status"=>-1,"msg"=>"原支付密码不正确");
        	return $data;
        }else{
        	if($newpsw1!=$newpsw2){
        		$data=array("status"=>-1,"msg"=>"新密码二次确认不符");
        		return $data;
        	}else{
        		$this->where("`user_id` = {$row['user_id']}")->save(array('user_zfpsw'=>md5($newpsw1)));
        		$data=array("status"=>1,"msg"=>"修改成功");
        		return $data;
        	}
        }
    	}  
    }
    }
    
}
?>