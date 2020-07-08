<?php
namespace Agency\Controller;
use Think\Controller;
header('content-type:application:json;charset=utf8'); 
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST,GET'); 
header('Access-Control-Allow-Headers:x-requested-with,content-type');
class IndexController extends Controller {
	
	//服务商客户及小程序列表首页
	//需求参数 服务商id 搜索关键字str
	//提供参数 签约信息 appmcheng  start_time end_time  program_id  服务商公司名company  balance dj_balance 客户信息name tel    
	//涉及数据表 agency_info  user_info  qianyue   
	public function index(){
		$U=M('user_info');
		$id=I('id');
        $where['user_info.agency_id']=$id;
        $field='user_info.realname,user_info.tel,qianyue.id AS program_id,qianyue.appmcheng,qianyue.start_time,qianyue.end_time';
        $list=$U
        ->field($field)
        ->join('qianyue ON user_info.agency_id=qianyue.agency_id')
        ->where($where)
        ->select();
        $A=M('agency_info');
        $balance=$A->field('balance,dj_balance')->where(array('id'=>$id))->find();
        $list['balance']=$balance['balance'];
        $list['dj_balance']=$balance['dj_balance'];
        echo '<pre/>';
//      print_r($balance);
//      print_r($list);
        $this->ajaxReturn($list);
	}
	
	//首页搜索功能
	//需求参数 str id 
	//提供参数appmcheng  start_time end_time program_id    balance dj_balance 客户信息name tel  
	public function index_search(){
		$U=M('user_info');
		$id=I('id');
		$str=I('str');
        $where['user_info.agency_id']=$id;
        $field='user_info.realname,user_info.tel,qianyue.id AS program_id,qianyue.appmcheng,qianyue.start_time,qianyue.end_time';
        $where['_string']='(user_info.realname like "%'.$str.'%")  OR (qianyue.appmcheng like "%'.$str.'%")';
        $list=$U
        ->field($field)
        ->join('qianyue ON user_info.agency_id=qianyue.agency_id')
        ->where($where)
        ->select();
        $A=M('agency_info');
        $balance=$A->field('balance,dj_balance')->where(array('id'=>$id))->find();
        $list['balance']=$balance['balance'];
        $list['dj_balance']=$balance['dj_balance'];
//      echo '<pre/>';
//      print_r($balance);
//      print_r($list);
        $this->ajaxReturn($data);
	}
	
	//小程序签约信息展示
	//需求参数    小程序id
	//提供参数  appmcheng start_time beian_time contract_id contract_img remark
	public function qiany_list(){
        $Q=M('qianyue');
//      $where['id']=I('get.id');
        $where['id']=I('id');
        $field='appmcheng,start_time,beian_time,contract_id,contract_img,remark,state';
        $d=$Q->field($field)->where($where)->find();
//       echo '<pre/>';
//      print_r($d);
        $this->ajaxReturn($data);
	}
	
	//小程序签约信息提交
	//需求参数 小程序id  appmcheng start_time,beian_time,contract_id,contract_img,remark,state
	//提供参数 data
	public function qiany_sv(){
		$Q=M('qianyue');
		$rec=I('post.');
		$where['id']=$rec['id'];
		$sql=$Q->where($where)->save($rec);
		if($sql){
			$data=array('status'=>1,'msg'=>'操作成功');
		}else{
			$data=array('status'=>-1,'msg'=>'操作失败');
		}
		$this->ajaxReturn($data);
	}
	
	//首页参数编辑页面信息展示
	//需求参数 小程序ID
	//提供参数 
	public function program_info(){
		$Q=M('qianyue');
		$id=I('get.id');
		$where['qianyue.id']=$id;
//      $where['qianyue.id']=1;
		$field='user_info.name,qianyue.appmcheng,qianyue.start_id,
		qianyue.appid,qianyue.appsecret,qianyue.payment,qianyue.shanghu_num,qianyue.paykey';
		$i=$Q
		->field($field)
		->join('user_info ON qianyue.user_id=user_info.id')
		->where($where)
		->find();
		$P=M('user_psw');
		$psw=$P->field('psw')->where(array('user_id'=>$id))->find();
		$i['psw']=$psw['psw'];
//		print_r($i);
		$this->ajaxReturn($i);
//		echo md5('123');
	}
	
	//首页参数编辑页面信息提交
	//需求参数 小程序ID
	//提供参数
	public function program_sv(){
		$rec=I();
		$id=$rec['id'];
		$psw=$rec['psw'];
		$rec['psw']=md5($rec['psw']);
		$where['id']=$id;
		$Q=M('qianyue');
		$sql1=$Q->where($where)->save($rec);
		$UP=M('user_psw');//存原密码表
		$sql2=$UP->where(array('user.id'=>$id))->save(array('psw'=>$psw));
		if($sql1&&$sql2){
			$data=array('status'=>1,'msg'=>'操作成功');
		}else{
			$data='no';
		}
		$this->ajaxReturn($data);
	}
}
?>