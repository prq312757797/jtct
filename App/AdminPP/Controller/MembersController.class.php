<?php
namespace AdminPP\Controller;
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

		$this->today=$this->be($str_gt=strtotime($q1),$str_lt=time(),$program_id=$_COOKIE["program_id"]);
		$this->yesterday=$this->be($str_gt=strtotime($q2),$str_lt=strtotime($q1),$program_id=$_COOKIE["program_id"]);
		$this->in_weeken=$this->be($str_gt=strtotime($q3),$str_lt=time(),$program_id=$_COOKIE["program_id"]);

    $this->display();
	}
	function be($str_gt,$str_lt,$program_id){
		$map['register_time'] = array(array('gt',$str_gt),array('lt',$str_lt)) ;
		$map['program_id']=$program_id;

		$arr=M("members")->where($map)->count();

		return $arr;
	}
	//会员管理
	public function members(){

		//昵称、姓名、手机号的模糊搜索  str=》昵称、姓名、手机号
		 if(isset($_GET['str'])){
		 		$where=array(
					'program_id'=>$_COOKIE["program_id"]
				);
				$str=$_GET['str'];     //如果接收到搜索关键字,执行模糊查询 返回数据
				//模糊查询 id、名称、编号、条码、商户名称
				$where['_string']='
					(nickname like "%'.$str.'%")  
				
				';
						
				if($_COOKIE["program_id"]=="JT201808090855119076"){
					$where['vip_id'] =array('neq',0);
				
				}

				$list=M("members")
				->field('id,head,nickname,openid,level_id,group_id,realname,register_time,blacklist,integral,fx_yongjin_leiji,fx_yongjin_dakuan')
				->where($where)
				->select();

			}else{
				$goods = D("members");
        $total = $goods->where("program_id='".$_COOKIE["program_id"]."'")->count();
        $per = 10;
        $page = new \Component\Page($total, $per); //autoload
        $sql = "select * from members where program_id='".$_COOKIE["program_id"]."'";
       if($_COOKIE["program_id"]=="JT201808090855119076"){
				 $sql .=" and vip_id <>0 ";
				}
        
        $sql .=$page->limit;
        $list = $goods -> query($sql);
        $pagelist = $page -> fpage();
			}
			
			for($i=0;$i<count($list);$i++){
					$we["state"]=array('in',"2,3,4,7");
					$we["openid"]=$list[$i]["openid"];
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

  	$this -> assign('pages', $pagelist);
		$this->display();
	}
	
	
	function gold_vip(){
		//昵称、姓名、手机号的模糊搜索  str=》昵称、姓名、手机号
		 if(isset($_GET['str'])){
		 		$where=array(
					'program_id'=>$_COOKIE["program_id"]
				);
				$str=$_GET['str'];     //如果接收到搜索关键字,执行模糊查询 返回数据
				//模糊查询 id、名称、编号、条码、商户名称
				$where['_string']='
					(nickname like "%'.$str.'%")  
				
				';
						
				if($_COOKIE["program_id"]=="JT201808090855119076"){
					$where['vip_id'] =array('neq',0);
				
				}

				$list=M("members")
				->field('id,head,nickname,openid,level_id,group_id,realname,register_time,blacklist,integral,fx_yongjin_leiji,fx_yongjin_dakuan')
				->where($where)
				->select();

			}else{
				$goods = D("members");
        $total = $goods->where("program_id='".$_COOKIE["program_id"]."'")->count();
        $per = 10;
        $page = new \Component\Page($total, $per); //autoload
        $sql = "select * from members where program_id='".$_COOKIE["program_id"]."'";
       if($_COOKIE["program_id"]=="JT201808090855119076"){
				 $sql .=" and vip_id <>0 ";
				}
        
        $sql .=$page->limit;
        $list = $goods -> query($sql);
        $pagelist = $page -> fpage();
			}
			
			for($i=0;$i<count($list);$i++){
					$we["state"]=array('in',"2,3,4,7");
					$we["openid"]=$list[$i]["openid"];
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

  	$this -> assign('pages', $pagelist);
		$this->display();
	}
	public function ad_add(){

		 $a= $this->info=M('ad')->where("id=563")->find();

		$this->display();
	}
	//会员详情
	public function members_con(){
		//会员基本信息
		$list=M("members")->where("id='".$_GET["id"]."'")->find();
				$a1=M("member_level")
				->field('member_level_name')
				->where("id='".$list["level_id"]."'")->find();
				$list["level_name"]=$a1["member_level_name"];//会员等级
				
				$a2=M("member_group")
				->field('member_group_name')
				->where("id='".$list["group_id"]."'")->find();
				$list["group_name"]=$a2["member_group_name"];//会员分组
		
			//会员成交记录统计
			$where["program_id"]=$_COOKIE["program_id"];
			$where["openid"]		=$list["openid"];
			$where["state"]=array('in',"2,3,4,7");
				
//			$this->price=	M("order_form")->where($where)->sum("buy_price");	
//			$this->count=M("order_form")->where($where)->count();	
//			会员订单列表
			$member_order_form=M("order_form")->where($where)->order("time_fukuan desc")->select();	
//			dump(M("order_form")->_sql());dump($member_order_form);die;
			$this->order_list=$member_order_form;
			$this->count=count($member_order_form);
			$this->price=array_sum(array_map(function($val){return $val['buy_price'];}, $member_order_form));
			//会员等级列表选择
			$this->lever_list=M("member_level")->where("program_id='".$_COOKIE["program_id"]."'")->select();

			$this->info=$list;
		$this->display();
	}
	
	//手动修改会员等级
	function change_lever(){
		$save["level_id"]=$_POST["lever_id"];
	 if(M('members')->where("id='".$_POST["id"]."'")->save($save)){
	            $this->success('操作成功');
	        } else {
	            $this->error('操作失败');
	        }
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
				->field('id,member_level,member_level_name,condition,discount,state,cannot_d,price')
				->where($where)
				->select();
		
			}else{
				$list=M("member_level")
				->field('id,member_level,member_level_name,condition,discount,state,cannot_d,price')
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

		$_POST["program_id"]=$_COOKIE["program_id"];
		$upload = new \Think\Upload();// 实例化上传类
    $upload->maxSize   =     3145728 ;// 设置附件上传大小
    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录

    // 上传文件 
    $info   =   $upload->upload();
			 if($info){
            $_POST['image']=$info['image02']['savepath'].$info['image02']['savename'];

			  }else{
			  	if($program_id=="JT201808090855119076"){
			  		if(empty($_GET["id"])){
				  		$this->error('无上传图片');	
	            $error=$upload->getError();
			    		$data=array("status" => -1, "msg" => "图片上传失败",'error'=>$error);
				  	}
			  	}
			  	
			  }

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
			
			M("member_price")->where("program_id='".$_COOKIE["program_id"]."'"."and lever_id='".$_GET["id"]."'")->delete();
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
		
		if($_COOKIE["program_id"]=="JT201810111844206577"){
				$where["fx_tixian.tx_state"]=2;
		}else if($_COOKIE["program_id"]=="JT201810111844206577"){
				$where["fx_tixian.tx_state"]=3;
		}
		
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
		       }else {
		                $this->error('操作失败');
		    }
		}
			
	}
	
	//会员账号密码管理
	function members_account(){
			$where["state_audit"]=2;
			$where["program_id"]=$_COOKIE["program_id"];
		
		if(empty($_POST["str"])){
				$a=M("members")->where($where)->select();
		}ELSE{
			$str=$_POST["str"];
			$where['_string']='
						(id like "%'.$str.'%")  
						OR (register_name like "%'.$str.'%")
						OR (nickname like "%'.$str.'%")
					';
					$a=M("members")->where($where)->select();
			}
		
		$this->list=$a;
		
		$b=M("members")->where("state_audit=1 and program_id='".$_COOKIE["program_id"]."'")->count();
		$this->count_register=$b;
		$this->display();
	}
	
	//会员账号密码审核列表
		function members_account_audit_list(){
			
				$where["state_audit"]=1;
			$where["program_id"]=$_COOKIE["program_id"];
		
		if(empty($_POST["str"])){
				$a=M("members")->where($where)->select();
		}ELSE{
			$str=$_POST["str"];
			$where['_string']='
						(id like "%'.$str.'%")  
						OR (register_name like "%'.$str.'%")
						OR (nickname like "%'.$str.'%")
					';
					$a=M("members")->where($where)->select();
		}
		
		$this->list=$a;
		$this->display();
	}
	
	//通过申请
	function account_pass(){
		$save["state_audit"]=2;
		$save["state_online"]=1;
		if(M("members")->where("id='".$_GET["id"]."'")->save($save)){
			
				$this->success('操作成功',U('members_account'));
		 }else{
		    $this->error('操作失败');
		}
	
	}
		//拒绝申请
	function account_say_no(){
		$save["state_audit"]=3;
		if(M("members")->where("id='".$_GET["id"]."'")->save($save)){
			
				$this->success('操作成功');
		 }else{
		    $this->error('操作失败');
		}
	
	}
	//账号详情
	function members_account_con(){
		$this->info=M("members")->where("id='".$_GET["id"]."'")->find();
		$this->display();
	}
	
	//会员转发佣金管理
	function members_zhuanfa(){
		$this->list=M("members_forwarding")->where("program_id='".$_COOKIE["program_id"]."'")->select();
			$this->display();
	}
	
	//异步修改
	function ajax_edit(){
		$save["commission_per"]=$_POST["text"];
		
		if(M("members_forwarding")->where("id='".$_POST["id"]."'")->save($save)){
				$date="1";
			}else{
				$date="2";
			}
		$this->ajaxReturn($date);
	}
	
	
}