<?php
namespace AdminPnew\Controller;
use Think\Controller;
class MembersController extends CommonController {
  
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
				->field('id,member_level,member_level_name,condition,state,cannot_d')
				->where($where)
				->select();
		
			}else{
				$list=M("member_level")
				->field('id,member_level,member_level_name,condition,state,cannot_d')
				->where($where)
				->select();
			}
			
		//	dump($list);die;
		$this->member_level=$list;
		$this->display();
	}
	//添加等级
	function members_lever_add(){
		
		$this->display();
	}
	//编辑等级
		function members_lever_edit(){
				$this->info=M("member_level")->where("id='".$_GET["id"]."'")->find();
		$this->display('members_lever_add');
	}
	//执行添加
		function run_members_lever_add(){
		if(empty($_GET["id"])){
			$_POST["cannot_d"]=2;
			$_POST["program_id"]=$_COOKIE["program_id"];
			if(M("member_level")->add($_POST)){
				$this->success('添加成功',U('members_lever'));
			}else{
			    	$this->error('添加失败');	
			}
		}else{
			if(M("member_level")->where("id='".$_GET["id"]."'")->save($_POST)){
				$this->success('修改成功',U('members_lever'));
			}else{
			    	$this->error('修改失败');	
			}
		}

	}
	//删除会员等级
		function members_lever_delete(){
		if(M("member_level")->where("id='".$_GET["id"]."'")->delete()){
			
					$this->success('删除成功');
			}else{
			    $this->error('删除失败');	
			}

	}

	//会员分组
	public function members_group(){
	$where=array(
			'program_id'=>$_COOKIE["program_id"]
		);
				$list=M("member_group")
				->field('id,member_group_name,cannot_d')
				->where($where)
				->select();
				
				$this->member_group=$list;
				
			
		$this->display();
	}
	//添加分组
	function members_group_add(){
		$this->display();
	}
	//编辑分组
		function members_group_edit(){
			$this->info=M("member_group")->where("id='".$_GET["id"]."'")->find();
		$this->display('members_group_add');
	}

	
	//执行分组添加
	function run_members_group_add(){
		
		if(empty($_GET["id"])){
						$_POST["cannot_d"]=2;
						$_POST["program_id"]=$_COOKIE["program_id"];
			if(M("member_group")->add($_POST)){
				$this->success('添加成功',U('members_group'));
			}else{
			    	$this->error('添加失败');	
			}
		}else{
			if(M("member_group")->where("id='".$_GET["id"]."'")->save($_POST)){
				$this->success('修改成功',U('members_group'));
			}else{
			    	$this->error('修改失败');	
			}
		}
		
	}
	
	//删除分组
	function members_group_delete(){
		
		if(M("member_group")->where("id='".$_GET["id"]."'")->delete()){
			
					$this->success('删除成功');
			}else{
			    $this->error('删除失败');	
			}

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
	
	//会员提现申请
	
	 //待审核的
    public function cash_ing(){
//申请状态（1：待审核、2：审核通过（待打款）、3：审核拒绝、4：已打款、5：未知错误）    	
		$a=$this->info=$this->tixian(1);
       $this->count=count($a);
        $this->display();
    }
    //待打款的
    public function cash_git(){
//申请状态（1：待审核、2：审核通过（待打款）、3：审核拒绝、4：已打款、5：未知错误）  
		$a=$this->info=$this->tixian(2); 
		  $this->count=count($a);
        $this->display();
    }
    //已打款的
    public function cash_done(){
//申请状态（1：待审核、2：审核通过（待打款）、3：审核拒绝、4：已打款、5：未知错误）  
		$a=$this->info=$this->tixian(4);  
		  $this->count=count($a);
        $this->display();
    }
    //无效的
    public function cash_none(){
//申请状态（1：待审核、2：审核通过（待打款）、3：审核拒绝、4：已打款、5：未知错误）    
		$a=$this->info=$this->tixian(3);
		  $this->count=count($a);
        $this->display();
    }
    
    function tixian($state){
		$where["fx_tixian.program_id"]=$_COOKIE["program_id"];
		$where["fx_tixian.state"]=$state;
		
		$field='
		fx_tixian.order_num,fx_tixian.money_01,fx_tixian.state,fx_tixian.time_set,fx_tixian.id,
		
		members.nickname,members.head
		';
		$tixian=M("fx_tixian")
		->field($field)
		->join('left join members on members.openid=fx_tixian.openid')
		
		->where($where)
		->select();
		
		return $tixian;
	}
	
	//提现审核通过
	function cash_yes(){
		$save["state"]=$_GET["sta"];
		
		if($_GET["sta"]==2){
			$save["time_on"]=time();
		}
		switch ($_GET["sta"]){
			case 2:$save["time_on"]=time();break;
			case 3:$save["time_say_no"]=time();break;
			case 4:$save["time_git"]=time();break;
		}
		
		
		if(M("fx_tixian")->where("id='".$_GET["id"]."'")->save($save)){
		 					$this->success('操作成功',U('cash_ing'));
            } else {
                $this->error('操作失败');
            }
		
	}
//提现删除
function cash_del(){
		if(M("fx_tixian")->where("id='".$_GET["id"]."'")->delete()){
		 					$this->success('操作成功',U('cash_none'));
            } else {
                $this->error('操作失败');
            }
}
	
	
	
	//会员设置积分 快捷选项积分优惠
	function integral_set(){
		//就要小程序id， 积分优惠设置，以数组的形式存起来
		
		$integral_chongzhi_id=M("store")->field("integral_chongzhi_id")->where("program_id='".$_COOKIE["program_id"]."'")->find();

	
		if($integral_chongzhi_id["integral_chongzhi_id"] == 0 ){
			//没有设置积分优惠
			$this->show_message=2;//"未设置积分优惠";
	
		}else{
			
			
				$a=M("integral_chongzhi")->where("id='".$integral_chongzhi_id["integral_chongzhi_id"]."'")->find();
		//	$a["money"] 	$a["integral"]	 带逗号的字符串    一一对应的
		
	//	$a["money"]="1,2,3,4,5,6"	;
	//	$a["integral"]="11,22,33,44,55,66"	;
			
			$money=explode(",",$a["money"]);
				$integral=explode(",",$a["integral"]);
				
				for($i=0;$i<count($money);$i++){
						$arr[$i]=array(
							"money"=>$money[$i],
							"integral"=>$integral[$i]
					);
				}
				$this->intergral_id=$integral_chongzhi_id["integral_chongzhi_id"];
				$this->list=$arr;
				
		}
		$this->display();
	}
	//积分优惠提交
	function set_integral_submit(){
		$date["money"]=implode(",",$_POST["money"]);
		$date["integral"]=implode(",",$_POST["integral"]);
		
		$date["program_id"]=$_COOKIE["program_id"];
		
		$date["num"]=count($_POST["money"]);
if(!$_GET["id"]){

	//执行添加操作
		if(M("integral_chongzhi")->add($date)){
		
		$aa=M("integral_chongzhi")->where("program_id='".$_COOKIE["program_id"]."'")->find();
		$save["integral_chongzhi_id"]=$aa["id"];
		M("store")->where("program_id='".$_COOKIE["program_id"]."'")->save($save);
						$this->success('操作成功',U('integral_set'));
        } else {
                $this->error('操作失败');
    }
	}else{
		//执行修改操作
				if(M("integral_chongzhi")->where("id='".$_GET["id"]."'")->save($date)){
									$this->success('操作成功',U('integral_set'));
			       } else {
			                $this->error('操作失败');
			    }
			}
		}
	
	
		//单身管理
		function members_ds(){
		$a=	$this->info=$this->commen_hongniang($is_date0201_com=1);	
		
	//	dump($a);die;
		
			$this->display();
		}
			//红娘管理
		function members_hn(){
		$a=	$this->info=$this->commen_hongniang($is_date0201_com=2);
			
			$this->display();
		}
		
		//个人资料详情
		function aishenmembers_con(){
			$this->info=M("identity_info")->where("id='".$_GET["id"]."'")->find();
				$this->display();
		}
	
		function commen_hongniang($is_date0201_com){
			if($is_date0201_com==1){
					$arr=M("identity_info")->where("program_id='".$_COOKIE["program_id"]."'"." and is_date02_com=1")->select();
			
					for($i=0;$i<count($arr);$i++){
						//查媒婆
				if(!empty($arr[$i]["meipo_openid"])){
						$b=M("identity_info")->field('name')->where("program_id='".$_COOKIE["program_id"]."'"."and openid='".$arr[$i]["meipo_openid"]."'")->find();
							$arr[$i]["name_np"]=$b["name"];
						}else{
							$arr[$i]["name_np"]="无";
						}
						
						//查个人积分
					$a=M("members")->field('integral,integral_song')->where("program_id='".$_COOKIE["program_id"]."'"."and openid='".$arr[$i]["openid"]."'")->find();
				
					$arr[$i]["integral"]=$a["integral"]+$a["integral_song"];
				}
			}else if($is_date0201_com==2){
					$arr=M("identity_info")->where("program_id='".$_COOKIE["program_id"]."'"." and is_date01_com=1")->select();
					
					for($i=0;$i<count($arr);$i++){
				
						
						$a=M("members")->field('integral,integral_song')->where("program_id='".$_COOKIE["program_id"]."'"."and openid='".$arr[$i]["openid"]."'")->find();
						$arr[$i]["integral"]=$a["integral"]+$a["integral_song"];
					}
			}

			return $arr;
		}
		
		
		
			//异步设置会员属性  1：异步推荐 、2：异步明星 
	function ajax_change_state(){
		$state=M("identity_info")->where("id='".$_POST["id"]."'")->find();
	
	if($_POST["style_a"]==1){
		//异步设置是否推荐   is_recommend （1：是、2：否（默认）
		if($state["is_recommend"]==1){
				$val["is_recommend"]="2";
			}else if($state["is_recommend"]==2){
				$val["is_recommend"]="1";
			}
		
	}else if($_POST["style_a"]==2){
		//异步设置是否明星红娘   is_stars （1：是、2：否（默认）
		if($state["is_stars"]==1){
				$val["is_stars"]="2";
			}else if($state["is_stars"]==2){
				$val["is_stars"]="1";
			}
		
	}

			if(M("identity_info")->where("id='".$_POST["id"]."'")->save($val)){
					$date="1";
			}else{
					$date="2";
			}
			$this->ajaxReturn($date);
	}
	
	function say_yes(){
		$date["state"]="1";
		if(M("identity_info")->where("id='".$_GET["id"]."'")->save($date)){
				if($_GET["from"]==1){
						$this->success('操作成功',U('members_ds'));
				}else{
						$this->success('操作成功',U('members_hn'));
				}
								
			       } else {
			                $this->error('操作失败');
			    }
	}
	function say_no(){
	
	}
	
}