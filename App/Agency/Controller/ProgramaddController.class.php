<?php
namespace Agency\Controller;
use Think\Controller;
header('content-type:application:json;charset=utf8'); 
header('Access-Control-Allow-Origin:*');  
header('Access-Control-Allow-Headers:x-requested-with,content-type');
class ProgramaddController extends Controller {
	
	//服务商查看自己商户 的申请小程序进度的列表
	
	public function shenhe_resaule(){
		//需要服务商账号，
		
		$fuwushang=M("jt_user_info")->where("user_name='".$_GET["name"]."'")->find();
		
		$user_info=M('qianyue')
		->field('id,state,appmcheng,add_time,muban_price,agency_id,user_id,muban_type,muban_b')
		->where("agency_id='".$fuwushang["user_id"]."'")
		->order("add_time desc")
		->select();
		
		for($i=0;$i<count($user_info);$i++){
			$a["user_id"]=$user_info[$i]["agency_id"];
			$b=M("jt_user_info")->where($a)->find();
			$user_info[$i]["agency_name"]=$b["user_company"];//服务商公司
			
			$a2["id"]=$user_info[$i]["user_id"];
			$b=M("user_info")->where($a2)->find();
			$user_info[$i]["shagnhu_name"]=$b["name"];//商户账号
			
			$c["id"]=$user_info[$i]["muban_type"];
			$d=M("muban_l")->where($c)->find();
			$user_info[$i]["muban_name"]=$d["name"];//模板类型名称
			
			$c2["id"]=$user_info[$i]["muban_b"];
			$d=M("muban_b")->where($c2)->find();
			$user_info[$i]["muban_bb_name"]=$d["name"];//模板版本名称
		
		$user_info[$i]["add_time"]=date("Y-m-d H:i:s",$user_info[$i]["add_time"]);
		
		if($user_info[$i]["state"]==1){
			$user_info[$i]["state"]="已启用";
		}else if($user_info[$i]["state"]==2){
			$user_info[$i]["state"]="审核中";
		}else if($user_info[$i]["state"]==3){
			$user_info[$i]["state"]="已禁用";
		}else if($user_info[$i]["state"]==4){
			$user_info[$i]["state"]="已拒绝";
		}
		
		}

	//	dump($user_info);die;
		$this->ajaxReturn($user_info);
	}
	
	//小程序添加审核  页面显示
	public function program_show(){
		//显示小程序模板分类
		$k1=M("muban_l")->field('id,name')->select();

		//商户信息表
		//$is_can_show=M("jt_user_info")->where("user_name='".$_POST["user_name"]."'")->find();
			
	//if($is_can_show["user_balance"])
	/*	$a=M("jt_user_info")->where("user_name='".$_GET["user_name"]."'")->find();
		$shagnhu=M("user_info")->field('id,name,psw')->where("agency_id='".$a["user_id"]."'")->select();
	
	$e=array('k1'=> $muban_l,'k2'=>$shagnhu);//分类列表、商品列表
*/
		$this->ajaxReturn($k1);

	}
	//根据模板种类  ajax得到对应模板版本
	public function program_b(){

		$muban_l=M("muban_l")->where("name='".$_POST["name"]."'")->find();
		
		$a["lid"]=$muban_l["id"];
		$muban=M("muban_b")
		->field('id,name,price,remark')
		->where($a)
		->select();
		
	
		$this->ajaxReturn($muban);
	}
	
	//根据模板版本号  ajax得到对应模板版本价格
	public function program_b_p(){

		$muban_b=M("muban_b")->where("name='".$_POST["name"]."'")->find();

		$this->ajaxReturn($muban_b["price"]);
	}
		//判断商户账号密码  服务商账号，两个都正确执行添加
	function check_x(){
	
		$a1["name"]=$_POST["name"];
		$post_psw=$_POST["psw"];
		$post_fwc["user_name"]=$_POST["user_name"];
		
		$a3=M("jt_user_info")->where($post_fwc)->find();//当前服务商
		
		 $a2=M("user_info")->where($a1)->find();//当前商户
		 
		 //判断同一个商户有一条待审核的数据的时候不允许在添加 状态 -（1：启用、2：审核中、3：禁用、4：拒绝审核）
		
		  $is_in_info['user_id']=$a2["id"];
		 $is_in_info['state']=array('in','2,3');
		 $wq=M("qianyue")->where($is_in_info)->find();
		 if(!empty($wq)){
		 	$this->ajaxReturn(array('status'=>12,'msg'=>'商户已存在小程序记录，禁止再申请'));
		 }
		 
		 if($a2["psw"]!=md5($post_psw)){
		 	$data=array('status'=>4,'msg'=>'商户密码错误，不允许继续操作');
		 }else if($a3["user_id"]!=$a2["agency_id"]){
		 	$data=array('status'=>5,'msg'=>'不能管理非本服务商下的商户，不允许继续操作');
		 }else{
		 	
		 	if($a3["user_balance"]<$_POST["muban_price"]){
		 			$data=array('status'=>11,'msg'=>'余额不足禁止操作');
		 	}else{
		 			$data=array('status'=>1,'msg'=>'允许操作');
		 	}
		 

		 	/*
		 	 * 验证是否重复申请
		 	 *
		 	if(empty($a2["program_id"])){
		 		$data=array('status'=>1,'msg'=>'允许操作');
		 	}else{
		 		$data=array('status'=>2,'msg'=>'该商 户已经申请了小程序，禁止重复申请');
		 	}*/
		 	
		 }
		 
		 $this->ajaxReturn($data);
	}
	
	
	//小程序添加审核  页面添加
	public function program_add(){
		
	
		//传递过来的是模板类型的名称、模板版本名称
		$muban01=M("muban_l")->where("name='".$_POST["name_lx"]."'")->find();
		$_POST["muban_type"]=$muban01["id"];//获得选中模板类型id
		
		$muban02=M("muban_b")->where("name='".$_POST["name_bb"]."'")->find();
		$_POST["muban_b"]=$muban01["id"];//获得选中模板版本id
		
		$w1=M("user_info")->where("name='".$_POST["name"]."'")->find();
		$_POST["user_id"]=$w1["id"];//得到商户id
			    	
		$w2=M("jt_user_info")->where("user_name='".$_POST["user_name"]."'")->find();
		$_POST["agency_id"]=$w2["user_id"];//得到服务商id
	 	$_POST["muban_price"]=$_POST["price"];//得到服务商id
		$_POST["add_time"]=time();//添加时间
		
		// 扣费 服务商扣费
		$new_price=$w2["user_balance"]-$_POST["price"];//新余额
		
		$blanse["user_balance"]=$new_price;
		M("jt_user_info")
		->where("user_name='".$_POST["user_name"]."'")
		->save($blanse);
		$new_deal=array(
			'balance'=>$new_price,
			'deal_gold'=>$_POST["price"],
			//'type'=>"1",
			'agency_id'=>$w2["user_id"],
			'deal_time'=>time(),
			'user_id'=>$w1["id"],	
			'deal_type'=>"1"	
			'running_num'=>date("YmdHis",time()).rand(1,99)	
		);
		M('deal_info')->add($new_deal);
		
		
		$upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =  3145728 ;// 设置附件上传大小
			    $upload->exts      =  array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =   './Uploads/'; // 设置附件上传根目录
			    // 上传文件 
			    $info   =   $upload->upload();
			  
			    if($info){
			    	
			    	//有图片上传
			    	
                    $_POST['contract_img']=$info['contract_img01']['savepath'].$info['contract_img01']['savename'];

					if(M("qianyue")->add($_POST)){	
						
						
						//两个表虽然一样，但是只需要提交到签约表	
						//签约的商户账号、价格、商户账号得到商户id		
						$data=array('status'=>1,'msg'=>'添加成功');

					}else{
						$data=array('status'=>2,'msg'=>'添加失败');
					}
					
			    }else{
					
			    	
			    	if(M("qianyue")->add($_POST)){	
				//两个表虽然一样，但是只需要提交到签约表	
						//签约的商户账号、价格、商户账号得到商户id		
						$data=array('status'=>1.1,'msg'=>'添加成功');

					}else{
						$data=array('status'=>2.2,'msg'=>'添加失败');
					}
			    	//没有图片上传	
                  //  $error=$upload->getError();
		    		//$data=array("status" => -1, "msg" => "未上传图片",'error'=>$error);
			    
			    }

		$this->ajaxReturn($data);
		
	}
}
?>