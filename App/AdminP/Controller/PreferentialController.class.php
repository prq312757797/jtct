<?php
namespace AdminP\Controller;
use Think\Controller;
class PreferentialController extends CommonController {

	//首页--- 满额立减
  public function index(){
  	
  	$preferential_list=M("preferential_list")->where("style=1 and program_id='".$_COOKIE["program_id"]."'")->find();
  	
  	$arr1=explode(",",$preferential_list["pre_money"]);
    $arr2=explode(",",$preferential_list["base_buy_money"]);

			for($q1=0;$q1<count($arr1);$q1++){
				$arr[$q1]["pre_money"]=$arr1[$q1];
				$arr[$q1]["base_buy_money"]=$arr2[$q1];
			}
		
  	$this->info=$arr;
  	$this->display();
  }
  	//满额立减
  public function pass_lijian(){
  	
  	$this->display();
  }
  //立减内容添加
  
  function pass_lijian_add(){
  	for($k=0;$k<count($_POST["pre_money"]);$k++){
		if(!empty($_POST["pre_money"][$k])){
			$arr01[]=$_POST["pre_money"][$k];
		}
		if(!empty($_POST["base_buy_money"][$k])){
			$arr02[]=$_POST["base_buy_money"][$k];
		}			
	}
	$date["pre_money"]=implode(",",$arr01);
	$date["base_buy_money"]=implode(",",$arr02);

  	//$date["pre_money"]=implode(",",$_POST["pre_money"]);
   // $date["base_buy_money"]=implode(",",$_POST["base_buy_money"]);
  	
  	$preferential_list=M("preferential_list")->where("program_id='".$_COOKIE["program_id"]."'")->find();
  	
  	if(empty($preferential_list)){
  		//执行添加
  		$date["sort"]="1";
  		$date["time_set"]=time();
  		$date["program_id"]=$_COOKIE["program_id"];
  		if(M("preferential_list")->add($date)){
  			$this->success('添加成功',U('index'));
		}else{
			$this->error('添加失败');	
		}
  	}else{
  		//执行修改
  		if(M("preferential_list")->where("program_id='".$_COOKIE["program_id"]."'")->save($date)){
  			$this->success('操作成功',U('index'));
		}else{
			$this->error('操作失败');	
		}
  	}
  	
  }
  //立减内容异步删除
  function delete_lijian(){

  	//存着的内容是数组，传回数组键值，然后将原有的内容对应键值的内容删除，形成新数组再保存
  	$preferential_list=M("preferential_list")->where("program_id='".$_COOKIE["program_id"]."'")->find();

  	$date["pre_money"]=explode(",",$preferential_list["pre_money"]);
    $date["base_buy_money"]=explode(",",$preferential_list["base_buy_money"]);
  	  	// dump($_POST["key"]);die;
  	for($i=0;$i<count($date["pre_money"]);$i++){
  		if($i != $_POST["key"]){
  			$arr01[$i]=$date["pre_money"][$i];
  			
  			$arr02[$i]=$date["base_buy_money"][$i];
  		}
  		
  	}
 
  	$date_new["pre_money"]=implode(",",$arr01);
    $date_new["base_buy_money"]=implode(",",$arr02);
   	// dump($date_new);die;
  	if(M("preferential_list")->where("program_id='".$_COOKIE["program_id"]."'")->save($date_new)){
  		//	$this->success('操作成功',U('index'));
  			$date="1";
		}else{
		//	$this->error('操作失败');	
			$date="2";
		}
		
		$this->ajaxReturn($date);
  }
  
  	//满额包邮
  public function pass_youhui(){
  	
  	$this->display();
  }
  	//优惠券管理
  public function manager(){
  	
  	$this->list=M("preferential")->where("program_id='".$_COOKIE["program_id"]."'")->select();
  	$this->display();
  }
  //添加优惠券
  public function manager_add(){
  	
  	$this->display();
  }
    //编辑优惠券 
  public function manager_edit(){
  	$this->info=M("preferential")->where("id='".$_GET["id"]."'")->find();
  	
  	$this->display('manager_add');
  }
    //执行添加优惠券
  public function run_manager_add(){
  	
  	$receive=$_POST;
  	$upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =     3145728 ;// 设置附件上传大小
			    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录

			    // 上传文件 
			    $info   =   $upload->upload();
	 			  if($info){
		    		//有图片=========================
		    	 		$receive['image']=$info['image']['savepath'].$info['image']['savename'];
					}else{
						 if(empty($_GET['id'])) {
						 	$this->error('无上传图片');	
						    $error=$upload->getError();
							$data=array("status" => -1, "msg" => "图片上传失败",'error'=>$error);
						 }	
					}
					$receive['program_id']=$_COOKIE["program_id"];
		    	 if(empty($_GET['id'])) {
		    	 //执行添加操作
		    	 	 	$receive['time_set']=time();
				    if(M('preferential')->add($receive)){
				    	$this->success('添加成功',U('manager'));
				    }else{
				    	$this->error('添加失败');	
				    }
		    	 }else{
		    	 //执行修改操作
		    	 	if(M('preferential')->where("id='".$_GET['id']."'")->save($receive)){
				    	$this->success('修改成功',U('manager'));
				    }else{
				    	$this->error('修改失败');	
				    }
		    	 }

  		
  }
  
  function manager_delete(){
  	$a=M('preferential')->where("id='".$_GET["id"]."'")->find();
  	if(M('preferential')->where("id='".$_GET["id"]."'")->delete()){
  			unlink('./Uploads/'.$a["image"]);
  		$this->success('删除成功');
	}else{
		$this->error('删除失败');	
	}
  }
  	//手动发送
  public function send(){
  $a=	$this->list=M("preferential")->where("program_id='".$_COOKIE["program_id"]."'")->select();
  

  	$this->display();
  }
  	//发放记录
  public function record(){
  	
  	$this->display();
  }
  
  //异步获取全部的openid
  function ajax_all_openid(){
  	
  	$a=M("members")->field('openid')->where("program_id='".$_COOKIE["program_id"]."'")->select();
 // 	M("test")->add(array('title'=>$a[0]["openid"]));
  	for($i=0;$i<count($a);$i++){
  		$arr[$i]=$a[$i]["openid"];
  	}
  	
  	
  $str=implode(",",$arr);
  $str_1["a"]=$str;
   $str_1["b"]=count($arr);
  
  	$this->ajaxReturn($str_1);
  }
  
  
  //异步执行添加个人优惠券
  function ajax_wr(){
  	$openid=explode(",",$_POST["openid"]);
  	$_POST["program_id"]=$_COOKIE["program_id"];

		if(M("preferential")->add($_POST)){
			$back="1";
		}else{
			$back="2";
		}
		
		$this->ajaxReturn($back);
  }
  
  function ajax_all_openid_send(){
  	$back="1";
  		$this->ajaxReturn($back);
  }
  //会员管理
	public function fw_mam(){

		
		//昵称、姓名、手机号的模糊搜索  str=》昵称、姓名、手机号
		 if(isset($_POST['str'])){
		 		$where=array(
			'program_id'=>$_COOKIE["program_id"]
		);
				$str=$_POST['str'];     //如果接收到搜索关键字,执行模糊查询 返回数据
				//模糊查询 id、名称、编号、条码、商户名称
				$where['_string']='
					(nickname like "%'.$str.'%")  
					OR (openid like "%'.$str.'%")
				
				';
				$where["is_mamager"]=0;
				$list=M("members")
				->field('id,head,nickname,openid,level_id,group_id,register_time,blacklist,is_mamager')
				->where($where)
				->select();
		
			}else{
		$where=array(
			'program_id'=>$_COOKIE["program_id"],
			'is_mamager'=>1
		);	
				$list=M("members")
				->field('id,head,nickname,openid,level_id,group_id,register_time,blacklist,is_mamager')
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
	//	dump($list);die;
		$this->display();
	}
	
	//设置管理员
	function set_mamager(){
		
		$a=M("members")->where("id='".$_GET["id"]."'")->find();
		if($a["is_mamager"]==1){
			$save["is_mamager"]="0";
		}else{
			$save["is_mamager"]="1";
		}
		
		if(M("members")->where("id='".$_GET["id"]."'")->save($save)){
			
			$this->success('设置成功');
		}else{
			$this->error('设置失败');	
		}
	}
}