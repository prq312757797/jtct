<?php
namespace Hl\Controller;
use Think\Controller;
class AssistantController extends CommonController {

  
		/*
		 *店员      始
		 * */
		
		
		
		function assistant_common($state){
			
			
		$field='
			assistant_add.id,assistant_add.tel,assistant_add.time_registe,assistant_add.time_agree,assistant_add.name,
			assistant_add.time_say_no,assistant_add.state,
			user_info_dsh.sh_name
		';
		$a=M("assistant_add")
		->field($field)
		->join('left join user_info_dsh ON user_info_dsh.id=assistant_add.shop_id')
		->where("assistant_add.state='".$state."'"." and assistant_add.program_id='".$_COOKIE["program_id"]."'")
		->order("time_registe desc")
		->select();
		
		return $a;
		}
		function assistant_is(){
			

			
			$a=$this->assistant_common($state=0);
			$this->list=$a;
	
			$this->display();
		}
		function assistant_ing(){
	
//			$this->list=M("assistant_add")->where("state=1 and program_id='".$_COOKIE["program_id"]."'")->select();	
			$this->list=$this->assistant_common($state=1);	
			$this->display();
		}
		function assistant_stop(){
//			$this->list=M("assistant_add")->where("state=2 and program_id='".$_COOKIE["program_id"]."'")->select();	
			$this->list=$this->assistant_common($state=2);
			$this->display();
		}
		function assistant_con(){
			$this->info=M("assistant_add")->where("id='".$_GET["id"]."'")->find();		
			
			$this->display();
		}
		function assistant_agree(){
			$save["state"]=1;
			$save["time_agree"]=time();
				$save02["is_ktv_assistant"]=1;
			$a=M('assistant_add')->field("openid")->where("id='".$_GET['id']."'")->find();

			if(M('assistant_add')->where("id='".$_GET['id']."'")->save($save)){
						M("members")->where("program_id='".$_COOKIE["program_id"]."'"."and openid='".$a["openid"]."'")->save($save02);
		    	$this->success('操作成功',U('Assistant/assistant_ing'));
		    }else{
		    	$this->error('操作失败');	
		    }	
		}
		function assistant_say_yes(){
			$save["state"]=1;
			$save["time_agree"]=time();
			
			$save02["is_ktv_assistant"]=1;
			$a=M('assistant_add')->field("openid")->where("id='".$_GET['id']."'")->find();

			if(M('assistant_add')->where("id='".$_GET['id']."'")->save($save)){
				
				
				M("members")->where("program_id='".$_COOKIE["program_id"]."'"."and openid='".$a["openid"]."'")->save($save02);
		    	$this->success('操作成功',U('Assistant/assistant_ing'));
		    }else{
		    	$this->error('操作失败');	
		    }	
		}
		function assistant_astop(){
			$save["state"]=2;
			$save["time_stop"]=time();
	
			$save02["is_ktv_assistant"]=2;
			$a=M('assistant_add')->field("openid")->where("id='".$_GET['id']."'")->find();
			if(M('assistant_add')->where("id='".$_GET['id']."'")->save($save)){
				
					M("members")->where("program_id='".$_COOKIE["program_id"]."'"."and openid='".$a["openid"]."'")->save($save02);
		    	$this->success('操作成功',U('Assistant/assistant_ing'));
		    }else{
		    	$this->error('操作失败');	
		    }	
		}
		//拒绝
		function assistant_say_no(){
			$save["state"]=3;
			$save["time_say_no"]=3;
			
			if(M('assistant_add')->where("id='".$_GET['id']."'")->save($save)){
		    	$this->success('操作成功',U('Assistant/assistant_ing'));
		    }else{
		    	$this->error('操作失败');	
		    }	
		}
		function assistant_del(){

			if(M('assistant_add')->where("id='".$_GET['id']."'")->delete()){
		    	$this->success('操作成功');
		    }else{
		    	$this->error('操作失败');	
		    }	
		}

		
		/*
		 *店员      终
		 * */
		
		
		
		function manager_list(){
	
			$field='
				members.id,members.nickname,members.head,members.openid,members.is_ktv_manager	
			';	
			$sql .=" FROM members ";
			$sql .=" WHERE members.program_id ='".$_COOKIE["program_id"]."'"."and members.nickname <>'undefined'";
		
		
			if($_GET["str"]){
				$get_str="%".$_GET['str']."%";
				$sql .=" and nickname like'".$get_str."'";
			}
			
		$sql_01=$sql;
		$sql_02=$sql;
		
		$sql_01  =" select count(members.id)" .$sql_01;
		$sql_02  =" SELECT  ".$field  .$sql_02;
		$list = M("members") -> query($sql_01);

		$total =$list[0]["count(members.id)"];
	
	   	$per = 10;
		$page = new \Component\Page($total, $per); 	
		$sql_02 .=$page->limit;
		$list = D("members") -> query($sql_02);
		$pagelist = $page -> fpage();

		$this ->pages = $pagelist;
		$this ->list  =$list;
		
		if($_GET["is_hmanager"]==1) $this ->is_hmanager  =1;

		if($_GET["change_state"]==1){
			$this->change_state=1;
		}
		
		$this->display();
		}
		
		function manager_set(){
	
			$save["is_ktv_manager"]=1;
			$save["time_set_manager"]=time();
			if(M("members")->where("program_id='".$_COOKIE["program_id"]."'"."and openid='".$_GET["openid"]."'")->save($save)){
				
				$this->success('操作成功',U('Assistant/manager_list'));
		    }else{
		    	$this->error('操作失败');	
		    }	
		}
		function manager_none(){
	
			$save["is_ktv_manager"]=0;
			$save["time_set_manager"]='';
			if(M("members")->where("program_id='".$_COOKIE["program_id"]."'"."and openid='".$_GET["openid"]."'")->save($save)){
				
				$this->success('操作成功',U('Assistant/manager_list'));
		    }else{
		    	$this->error('操作失败');	
		    }	
		}
		
		
		//订单提醒
		function order_ing(){
	
			$field='
				members.id,members.nickname,members.head,members.openid,members.is_ktv_order_ing
			';	
			$sql .=" FROM members ";
			$sql .=" WHERE members.program_id ='".$_COOKIE["program_id"]."'"."and members.nickname <>'undefined'";
		
		
			if($_GET["str"]){
				$get_str="%".$_GET['str']."%";
				$sql .=" and nickname like'".$get_str."'";
			}
			
		$sql_01=$sql;
		$sql_02=$sql;
		
		$sql_01  =" select count(members.id)" .$sql_01;
		$sql_02  =" SELECT  ".$field  .$sql_02;
		$list = M("members") -> query($sql_01);

		$total =$list[0]["count(members.id)"];
	
	   $per = 10;
		$page = new \Component\Page($total, $per); 	
		$sql_02 .=$page->limit;
		$list = D("members") -> query($sql_02);
		$pagelist = $page -> fpage();

		$this ->pages = $pagelist;
		$this ->list  =$list;


		
		$this->display();
		}
		
		function order_ing_set(){
	
			$save["is_ktv_order_ing"]=1;
			$save["time_set_order_ing"]=time();
			if(M("members")->where("program_id='".$_COOKIE["program_id"]."'"."and openid='".$_GET["openid"]."'")->save($save)){
				
				$this->success('操作成功',U('Assistant/manager_list'));
		    }else{
		    	$this->error('操作失败');	
		    }	
		}
		function order_ing_none(){
	
			$save["is_ktv_order_ing"]=0;
			$save["time_set_order_ing"]='';
			if(M("members")->where("program_id='".$_COOKIE["program_id"]."'"."and openid='".$_GET["openid"]."'")->save($save)){
				
				$this->success('操作成功',U('Assistant/manager_list'));
		    }else{
		    	$this->error('操作失败');	
		    }	
		}
}