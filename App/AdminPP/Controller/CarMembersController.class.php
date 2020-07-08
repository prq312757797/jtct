<?php
namespace AdminPP\Controller;
use Think\Controller;
class CarMembersController extends CommonController {
	
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
			
			$sql  =" SELECT  * ";
			$sql .=" FROM members ";
			$sql .=" WHERE program_id ='".$_COOKIE["program_id"]."'";
			
			if(isset($_GET['str'])){
				$str="%".$_GET['str']."%";
				$sql .=" and ( nickname like'".$str."'"." or openid like '".$str."'"." ) ";	
			}

			$list = M("members") -> query($sql);
			
			$total =count($list);
			
		    $per = 10;
			$page = new \Component\Page($total, $per); 	
			$sql .=$page->limit;
		
		    $list = D("members") -> query($sql);
		    $pagelist = $page -> fpage();
			
			$this->list=$list;
			$this->pages =$pagelist;
		$this->display();
	}
			//司机管理
	public function driver(){
		$list=$this->list_common($str=$_GET["str"],$state=1);
	
		$this->list=$list[0];
		$this->pages =$list[1];
		
		
		$a=M("car_manerger")->where("state=1 and state_register=1 and program_id='".$_COOKIE["program_id"]."'")->count();
		$this->count_register=$a;
		$this->display();
	}
	//签约单位
	public function signing(){
			$list=$this->list_common($str=$_GET["str"],$state=3);

			$this->list=$list[0];
			$this->pages =$list[1];
			$a=M("car_manerger")->where("state=3 and state_register=1 and program_id='".$_COOKIE["program_id"]."'")->count();
			$this->count_register=$a;
		$this->display();
	}
	//合作单位
	public function cooperation(){
			$list=$this->list_common($str=$_GET["str"],$state=2);
			$this->list=$list[0];
			$this->pages =$list[1];
		
			$a=M("car_manerger")->where("state=2 and state_register=1 and program_id='".$_COOKIE["program_id"]."'")->count();
			$this->count_register=$a;
		$this->display();
	}
	
	function list_common($str,$state){
	
			$sql  =" SELECT  * ";
			$sql .=" FROM car_manerger ";
			$sql .=" WHERE state_register=2 and program_id ='".$_COOKIE["program_id"]."'";
			$sql .=" and state ='".$state."'";
			if($state==1){
				$sql .=" and is_tired =1 ";
			}
			
			if(isset($_GET['str'])){
				$str="%".$str."%";
				$sql .=" and ( name like'".$str."'"." or openid like '".$str."'"." ) ";	
			}
			$list = M("car_manerger") -> query($sql);
			$total =count($list);
		    $per = 10;
			$page = new \Component\Page($total, $per); 	
			$sql .=$page->limit;
		
		    $list = D("car_manerger") -> query($sql);
		    $pagelist = $page -> fpage();

		    $return[0]=$list;
			$return[1]=$pagelist;
	
		    return $return;
		
		
	}
		//审核接口
	public function audit_list(){
		$where["program_id"]=$_COOKIE["program_id"];
		$where["state_register"]=1;
		$where["state"]=$_GET["state"];//所属状态（1：个人司机、2：合作单位、3：长期签约客户）
		$a=$this->list=M("car_manerger")->where($where)->select();
		
		//dump($a);dump(M("car_manerger")->_sql());die;
		
		$this->state=$_GET["state"];
		$this->display();
	}
	
	function say_yes(){
		$save["state_register"]=2;
	$save["time_agree"]=time();
		 if(M('car_manerger')->where("id='".$_GET["id"]."'")->save($save)) {
		 	if($_GET["state"]==1)  $this->success('操作成功',U('driver'));
	        if($_GET["state"]==2)  $this->success('操作成功',U('cooperation'));
	        if($_GET["state"]==3)  $this->success('操作成功',U('signing'));
	        } else {
	            $this->error('操作失败');
	        }
	}
	  function say_no(){
		$save["state_register"]=3;
		$save["time_sayno"]=time();
		 if(M('car_manerger')->where("id='".$_GET["id"]."'")->save($save)) {
	        if($_GET["state"]==1)  $this->success('操作成功',U('driver'));
	        if($_GET["state"]==2)  $this->success('操作成功',U('cooperation'));
	        if($_GET["state"]==3)  $this->success('操作成功',U('signing'));
	        } else {
	            $this->error('操作失败');
	        }
	}
   	//详情
	public function members_con(){
		$list=M("members")->where("id='".$_GET["id"]."'")->find();

		$this->info=$list;
		$this->display();
	}
	
	function car_members_con(){
		$list=M("car_manerger")->where("id='".$_GET["id"]."'")->find();
		
		$list["integral"]=$list["integral_buy"]+$list["integral_song"];
		
		$this->info=$list;

		//积分充值记录
		$record=$this->record=M("jt03_zx_record_cz")->where("program_id='".$_COOKIE["program_id"]."'"."and car_manerger_id='".$_GET["id"]."'")->order("time desc")->select();
	//	dump($record);dump(M("jt03_zx_record_cz")->_sql());die;
		$this->display();
	}

//积分充值
function integral_chongzhi(){
	$save["integral_song"]=$_POST["integral_song"];
	
	$record["program_id"]=$_COOKIE["program_id"];
	$record["openid"]="admin";
	$record["order_num"]="JT".date("YmdHis",time()).rand(1111,9999);
	$record["record"]=$_POST["integral_song"];
	$record["price"]="0";
	$record["time"]=time();
	$record["car_manerger_id"]=$_GET["id"];
	
	if(M("car_manerger")->where("id='".$_GET["id"]."'")->setInc('integral_song', $_POST["integral_song"])){
		M("jt03_zx_record_cz")->add($record);
				$this->success('充值成功');
		}else{
			$this->error('充值失败');	
		}
}
	//修改密码
	function change_psw(){
$a=M("car_manerger")->where("id='".$_GET["id"]."'")->find();
		$save["psw"]=md5($_POST["psw"]);
		if(M("car_manerger")->where("id='".$_GET["id"]."'")->save($save)){
			if($a["state"]==1){
					$this->success('修改成功',U('driver'));
			}else if($a["state"]==2){
					$this->success('修改成功',U('cooperation'));
			}else if($a["state"]==3){
					$this->success('修改成功',U('signing'));
			}
		
		}else{
			$this->error('修改失败');	
		}
	}
	
	function car_man_delete(){
		if(M("car_manerger")->where("id='".$_GET["id"]."'")->delete()){
				$this->success('删除成功');
		}else{
			$this->error('删除失败');	
		}
	}
}