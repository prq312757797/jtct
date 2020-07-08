<?php
namespace Agency\Controller;
use Think\Controller;
header('content-type:application:json;charset=utf8'); 
header('Access-Control-Allow-Origin:*'); 
header('Access-Control-Allow-Methods:POST'); 
header('Access-Control-Allow-Headers:x-requested-with,content-type');

class UpdpswController extends Controller {
	
	//修改服务商密码
	//需求参数 服务商ID
	//提供参数
	public function updpsw(){
				$receive=I();
				$Mysql=M('agency_info');
//				$data=$Mysql->update_psw($receive['name'],$receive['psw'],$receive['psw1'],$receive['psw2']);	
                $info=$Mysql->field('psw')->where(array('name'=>$receive['name']))->find();
        $psw=md5($receive['psw']);
        $ypsw=$info['psw'];
        if($psw!=$ypsw){
        	$data=array("status"=>-1,"msg"=>"原密码不正确");
        }else{
        	if($receive['psw1']!=$receive['psw2']){
        		$data=array("status"=>-1,"msg"=>"新密码二次确认不符");
        	}else{
        		$Mysql->where(array('name'=>$receive['name']))->save(array('psw'=>md5($receive['psw1'])));
        		$data=array("status"=>1,"msg"=>"修改成功");
        	}
        }     
		$this->ajaxReturn($data);
//		echo $callback."(".json_encode($data).")";
	}
	
	//
    //修改支付密码
    //需求参数 服务商ID
    public function updzfpsw(){
				$receive=I();
				$Mysql=M('agency_info');
//				$data=D('JtUserInfo')->update_zfpsw($receive['name'],$receive['psw'],$receive['psw1'],$receive['psw2']);
			    $info=$Mysql->field('zfpsw')->where(array('name'=>$receive['name']))->find();
			    $psw=md5($receive['psw']);
        		$ypsw=$info['zfpsw'];
		        if($psw!=$ypsw){
		        	$data=array("status"=>-1,"msg"=>"原密码不正确");
		        }else{
		        	if($receive['psw1']!=$receive['psw2']){
		        		$data=array("status"=>-1,"msg"=>"新密码二次确认不符");
		        	}else{
		        		$Mysql->where(array('name'=>$receive['name']))->save(array('zfpsw'=>md5($receive['psw1'])));
		        		$data=array("status"=>1,"msg"=>"修改成功");
		        	}
		        }     
		$this->ajaxReturn($data);
    }
}
?>