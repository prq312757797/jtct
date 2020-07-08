<?php
namespace AdminPP\Controller;
use Think\Controller;
class MembersZiXunController extends CommonController {
  
  	//会员概述
    public function index(){
	//今天 凌晨
		$q1=date('Y-m-d 00:00:00' , time());
		//昨天凌晨
		$q2=date('Y-m-d 00:00:00' , strtotime("-1 day"));
		//七天前凌晨
		$q3=date('Y-m-d 00:00:00' , strtotime("-7 day"));


		$this->today=$this->be(strtotime($q1),$_COOKIE["program_id"]);

		$this->yesterday=$this->be(strtotime($q2),$_COOKIE["program_id"]);
		$this->in_weeken=$this->be(strtotime($q3),$_COOKIE["program_id"]);


		/*$e=array('k1'=> $today,'k2'=>$yesterday,'k3'=>$in_weeken);//会员数统计、今天、昨天、一周内
    dump($e);die;*/
    	$this->display();
	}
	function be($str,$program_id){
		$map['register_time'] = array(array('gt',$str),array('lt',time())) ;
		$map['program_id']=$program_id;
		$arr=M("members")->where($map)->count();
		return $arr;
	}
	//会员管理
	public function members(){
	$where=array(
			'program_id'=>$_COOKIE["program_id"]
		);
		
		//昵称、姓名、手机号的模糊搜索  str=》昵称、姓名、手机号
		 if(isset($_POST['str'])){
				$str=$_POST['str'];     //如果接收到搜索关键字,执行模糊查询 返回数据
				//模糊查询 id、名称、编号、条码、商户名称
				$where['_string']='
					(nickname like "%'.$str.'%")  
					OR (realname like "%'.$str.'%")
					OR (tel like "%'.$str.'%")
				';
				$list=M("members")
				->field('id,head,nickname,level_id,group_id,register_time,blacklist')
				->where($where)
				->select();
		
			}else{
				$list=M("members")
				->field('id,head,nickname,openid,level_id,group_id,register_time,blacklist')
				->where($where)
				->select();
		
			}
			
			for($i=0;$i<count($list);$i++){
				//付款订单数  state>1
				$we["state"]=array(array('gt',1));
					$we["openid"]=$list["openid"];
				$list[$i]["deal_num"]=M("order_form")->where($we)->count();
				
				$a1=M("member_level")
				->field('member_level_name')
				->where("id='".$list[$i]["level_id"]."'")->find();
				$list[$i]["level_name"]=$a1["member_level_name"];//会员等级
				
				$a2=M("member_group")
				->field('member_group_name')
				->where("id='".$list[$i]["group_id"]."'")->find();
				$list[$i]["group_name"]=$a2["member_group_name"];//会员分组
			}
			$this->list=$list;
		//dump($list);
		$this->display();
	}
	
	//会员详情
	public function members_con(){
		
		
		$this->display();
	}
	//会员删除
	public function delete(){
				 $user_id = $_GET['id'];
	        if(M('members')->delete($user_id)) {
	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
		}
	
	//会员等级
	public function members_lever(){
		  $where=array(
            'program_id'=>$_COOKIE["program_id"]
        );
		if(isset($_POST['str'])){
				$str=$_POST['str'];     //如果接收到搜索关键字,执行模糊查询 返回数据
				//模糊查询 id、名称、编号、条码、商户名称
				$where["state"]=$str;
				
				$list=M("member_level")
				->field('id,member_level,member_level_name,condition,state')
				->where($where)
				->select();
		
			}else{
				$list=M("member_level")
				->field('id,member_level,member_level_name,condition,state')
				->where($where)
				->select();
			}
			
		//	dump($list);die;
		$this->member_level=$list;
		$this->display();
	}
	//会员分组
	public function members_group(){
	$where=array(
			'program_id'=>$_COOKIE["program_id"]
		);
				$list=M("member_group")
				->field('id,member_group_name')
				->where($where)
				->select();
				
				$this->member_group=$list;
				
			
		$this->display();
	}
	
	//会员异步修改会员状态
	function ajax_change_ok(){
		
	
		$state=M("members")->where("id='".$_POST["id"]."'")->find();
		//  blacklist  是否黑名单 0否1是
			if($state["blacklist"]==0){
				$val["blacklist"]="1";
			}else if($state["blacklist"]==1){
				$val["blacklist"]="0";
			}
			
			if(M("members")->where("id='".$_POST["id"]."'")->save($val)){
					$date="1";
			}else{
					$date="2";
			}
			$this->ajaxReturn($date);
	}
}