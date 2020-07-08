<?php
namespace Program\Controller;
use Think\Controller;
header('content-type:application:json;charset=utf8'); 
header('Access-Control-Allow-Origin:*'); 
//header('Access-Control-Allow-Methods:POST'); 
header('Access-Control-Allow-Headers:x-requested-with,content-type');
class AishenController extends Controller {


	//基础信息提交页面
	function base_info(){
		//实际上就是给到行业信息
		$arr=M("job_list")->where("id")->select();
		
		$arr=$this->bq($arr);
		$this->ajaxReturn($arr);
	}
	//递归
	function bq($arr,$p=0){
		$ar=array();
		foreach($arr as $v){ if($v["uid"]==$p){ $v["child"]=$this->bq($arr,$v["id"]);	$ar[]=$v;}} return $ar;
	}
	
	
	//展示微信号和微信图片
	function show_wx_info(){
		if(empty($_GET["program_id"]) | empty($_GET["openid"])){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		
		$wx_info=M("members")->field('wx_img,weixin')->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();
	$this->ajaxReturn($wx_info);
	}
	//提交微信号、上传微信图片
	function upload_wx_info(){
		if(empty($_POST["program_id"]) | empty($_POST["openid"])){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		
		$receive["weixin"]=$_POST["weixin"];
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =     3145728 ;// 设置附件上传大小
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
	// 上传文件
		$info   =   $upload->upload();
		
		if($info){
			$receive['wx_img']=$info["wx_img"]['savepath'].$info["wx_img"]['savename'];
		}else{
			$this->ajaxReturn(array("state" => -1, "msg" => "图片获取失败"));
		}    
	
			if(M("members")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'")->save($receive)){
				$this->ajaxReturn(array("state" => 1, "msg" => "保存成功"));
			}else{
				$this->ajaxReturn(array("state" => -1, "msg" => "保存失败"));
			}
		
		
		
	}
	
	//单独上传个人头像
	function uplode_self_head(){
		if(empty($_POST["program_id"]) | empty($_POST["openid"])){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		
		$receive["weixin"]=$_POST["weixin"];
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =     3145728 ;// 设置附件上传大小
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
	// 上传文件
		$info   =   $upload->upload();
		
		if($info){
			$receive['headimg']=$info["headimg"]['savepath'].$info["headimg"]['savename'];		
		}else{
			$this->ajaxReturn(array("state" => -1, "msg" => "图片获取失败"));
		}   
		
		if(M("identity_info")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'")->save($receive)){
				$this->ajaxReturn(array("state" => 1, "msg" => "保存成功"));
			}else{
				$this->ajaxReturn(array("state" => -1, "msg" => "保存失败"));
			}
	}
	
	//基础信息提交按钮
	function base_info_submit(){
		
		if(empty($_POST["program_id"]) | empty($_POST["openid"])){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		$receive=$_POST;
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =     3145728 ;// 设置附件上传大小
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
	// 上传文件
		$info   =   $upload->upload();
	
		if($info){
			$receive['headimg']=$info["headimg"]['savepath'].$info["headimg"]['savename'];
		}else{
			if($receive["is_add"]==1){
				$this->ajaxReturn(array("state" => -1, "msg" => "图片上传失败"));
			} 
		}
		if($receive["as_id"]==1){
				$receive["is_date01_com"]=1;
			}else if($receive["as_id"]==2){
				$receive["is_date02_com"]=1;
			}
			$receive["as_id"]=$receive["as_id"];
				
		if($receive["is_add"]==1){
			//执行添加
			$receive["meipo_id"]="0";//我的媒婆 、0为无媒婆	   
			$receive["state"]="2";	//待审核   
			//身份单身  
			$receive["time_set"]=time();
			$receive02["last_as_id"]=$receive["as_id"];

			$is_have=M("identity_info")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'")->find();
		
			if(!empty($is_have)){
				$this->ajaxReturn(array("state" => -3, "msg" => "数据已存在"));
			}
			//dump($receive);die;
			if(M("identity_info")->add($receive)){
				M("members")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'")->save($receive02);
				
				$this->ajaxReturn(array("state" => 1, "msg" => "上传成功、待审核"));
			}else{
				$this->ajaxReturn(array("state" => -2, "msg" => "上传失败"));
			}
		}else if($receive["is_add"]==2){
			//执行修改
		//	dump($receive);die;
			if(M("identity_info")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'")->save($receive)){
				$this->ajaxReturn(array("state" => 1.1, "msg" => "修改成功、待审核"));
			}else{
				$this->ajaxReturn(array("state" => -2.2, "msg" => "修改失败"));
			}
		}
		
		
		
	
	}
	
	//关注、喜欢 state   类型 1：关注、2：互相喜欢
	function say_yes(){
		$date["program_id"]=$_POST["program_id"];
		$date["opneid_attentioning"]=$_POST["openiding"];
		$date["openid_attentioned"]=$_POST["openided"];
		$date["state"]=$_POST["state"];
			$date["time_set"]=time();	
		$a=M("attention")->where($date)->find();
		
		if(!empty($a)){
			$this->ajaxReturn(array("state" => -11, "msg" => "已经添加喜欢过了，别闹了"));
		}
		//看看有没有相互喜欢的
		$date02["program_id"]=$_POST["program_id"];
		$date02["openid_attentioned"]=$_POST["openiding"];
		$date02["opneid_attentioning"]=$_POST["openided"];
		$date02["state"]=$_POST["state"];
		$b=M("attention")->where($date02)->find();
		
		
		//判断两个人是不是同一个媒婆下的人，不是的话不给送礼物
		$c1=M("identity_info")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openiding"]."'")->find();
		$c2=M("identity_info")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openided"]."'")->find();
		
		/*if($c1["meipo_openid"]!=$c2["meipo_openid"]){
			$this->ajaxReturn(array("state" => -22, "msg" => "不是同一个媒婆下的人，赶紧变成同媒婆的人吧"));
		}*/
	
		if(M("attention")->add($date)){
			if(!empty($b)){
				M("identity_info")->where("program_id='".$_POST["program_id"]."'"."and openid='".$c1["openid"]."'")->setInc("num_qianxian","2");
			}
			$this->ajaxReturn(array("state" => 1, "msg" => "添加成功"));
		}else{
			$this->ajaxReturn(array("state" => -1, "msg" => "添加失败"));
		}
	}
	
	function say_no(){
		$date["program_id"]=$_POST["program_id"];
		$date["opneid_attentioning"]=$_POST["openiding"];
		$date["openid_attentioned"]=$_POST["openided"];
		$date["state"]=$_POST["state"];
		if(M("attention")->where($date)->delete()){
			$this->ajaxReturn(array("state" => 1, "msg" => "删除成功"));
		}else{
			$this->ajaxReturn(array("state" => -1, "msg" => "删除失败"));
		}
	}
	
	//媒婆详情
	function per_my_mp(){
			if(empty($_GET["program_id"]) | empty($_GET["openid"])){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		//媒婆详情
		$a=M("identity_info")->field('id,name,headimg,num_qianxian,openid,tel')->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["meipo_openid"]."'")->find();
	//dump($a);dump(M("identity_info")->_sql());die;
		//单身团统计 own_openid
		$b=M("bachelorhood_team")->where("program_id='".$_GET["program_id"]."'"."and own_openid='".$a["openid"]."'")->count();
		//(empty($b)) ? $is_01=1 : $is_01=2;
		
		
		//粉丝数统计
		$c=M("attention")->where("state=1 and program_id='".$_GET["program_id"]."'" ." and openid_attentioned='".$a["openid"]."'")->count();
		
	
		//名下单身的男统计
		$f=M("identity_info")->where("sex=1 and program_id='".$_GET["program_id"]."'"."and meipo_openid='".$a["openid"]."'")->count();
		
		//名下单身的女统计
		$g=M("identity_info")->where("sex=2 and program_id='".$_GET["program_id"]."'"."and meipo_openid='".$a["openid"]."'")->count();
		
		//推荐的单身
		$h=M("identity_info")->field('id,sex,name,headimg,address,age,height,educational,constellation')->where("program_id='".$_GET["program_id"]."'"."and meipo_openid='".$a["openid"]."'")->select();
		
	//相互喜欢  人数统计3
	//需要历史牵线人，这个k7不用了，但是也不删  1127
	$num_love_each=0;
		for($i=0;$i<count($h);$i++){
			$attention01=M("attention")->where("state=2 and program_id='".$_GET["program_id"]."'"."and opneid_attentioning='".$h[$i]["openid"]."'")->find();
			$attention02=M("attention")->where("state=2 and program_id='".$_GET["program_id"]."'"."and openid_attentioned='".$attention01["openid_attentioned"]."'")->find();
		
			if($attention02["opneid_attentioning"]==$h[$i]["openid"]){
				$num_love_each+=1;
			}
			
		}

		$z=array('k1'=>$a,'k2'=>$b,'k3'=>$c,'k4'=>$f,'k5'=>$g,'k6'=>$h,'k7'=>$num_love_each);
		$this->ajaxReturn($z);
	}
	
	//个人详情
	function individual_con(){
		
		if(empty($_GET["program_id"]) | empty($_GET["openid"])){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		$self_info=M("identity_info")->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();
	//dump($self_info);dump(M("identity_info")->_sql());die;
		$self_info["mp_info"]=M("identity_info")->field('id,name,headimg,qinaming')->where("program_id='".$_GET["program_id"]."'"."and openid='".$self_info["meipo_id"]."'")->find();
	
		$self_info["arr_image"]=explode(",",$self_info["image"]);
	
		$this->ajaxReturn($self_info);
	
	}
	
	
	
	
	//切换角色页面
	function change_role(){
		//这里需要判断这个人的资料是否完整
		
		
		//就得到这个人原本的身份，让页面打开的时候默认选择
		$identity_info=M("identity_info")->field('as_id,is_date01_com,is_date02_com')->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();
	
		if($identity_info["as_id"]==1){
			//当前身份是媒婆
			if($identity_info["is_date02_com"]==1){
				//单身资料已经有了
				$date=array('state'=>'1','as_id'=>"1",'msg'=>"当前身份是媒婆，单身身份资料已经有了，点击切换就直接换吧");
			}else{
				//无单身资料
				$date=array('state'=>'2','as_id'=>"1",'msg'=>"当前身份是媒婆，这逗比漏还没写单身资料，点击切换去补充资料");
			}
			
		}else if($identity_info["as_id"]==2){
			//当前身份是单身
			if($identity_info["is_date01_com"]==1){
				//媒婆资料已经有了
				$date=array('state'=>'3','as_id'=>"2",'msg'=>"当前身份是单身，媒婆身份资料已经有了，点击切换就直接换吧");	
			}else{
				//无媒婆资料
				$date=array('state'=>'4','as_id'=>"2",'msg'=>"当前身份是单身，媒婆身份资料还空着，点击提示是否确认开通媒婆身份");				
			}
			
		}
		
		$this->ajaxReturn($date);
	}
	
	//切换角色按钮
	function change_role_buttion(){
		//计较之后修改个人信息表里面的当前身份
		
		$date01["as_id"]=$_POST["as_id"];
		$date02["last_as_id"]=$_POST["as_id"];
		
	/*	if($_POST["as_id"]==1){
			$date01["is_date01_com"]="1";
		}*/
		
		if(M("identity_info")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'")->save($date01)){
			
			M("members")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'")->save($date01);
			$this->ajaxReturn(array("state" => 1, "msg" => "提交成功"));
		}else{
			$this->ajaxReturn(array("state" => -1, "msg" => "提交失败"));
		}
		
	}
	
	//系统通知  --后期将通知保存在缓存
	function systems_inform(){
		if(empty($_GET["program_id"]) | empty($_GET["openid"])){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		$a=M("systems_inform_record")->where("program_id='".$_GET["program_id"]."'"."and openid_get='".$_GET["openid"]."'")->select();
		for($i=0;$i<count($a);$i++){
			if(!empty($a[$i]["systems_inform_id"])){
				$b=M("systems_inform")->where("id='".$a[$i]["systems_inform_id"]."'")->find();
				$a[$i]["systems_inform_con"]=$b["content"];
			}	
		}
		$this->ajaxReturn($a);
	}
	
	//个人相册上传图片
	function upload_photo(){
		 $upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =     3145728 ;// 设置附件上传大小
			    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录

			// 上传文件
			     $info   =   $upload->upload();
			 if($info){
			 	$receive['image']=$info["image"]['savepath'].$info["image"]['savename'];
			 }
			 
			$receive["program_id"]=$_POST["program_id"];
			$receive["openid"]=$_POST["openid"];
			$receive["only_num"]=$_POST["only_num"];
			 	 
			if(M('image_ls')->add($receive)){ 
			 	$this->ajaxReturn(array('state'=>1,'msg'=>'成功'));
			}else{
				$this->ajaxReturn(array('state'=>-1,'msg'=>'失败'));
			}	
	}
	//正式上传
	function uploade_photo_r(){
		//$only_num=M("identity_info")->where("only_num='".$_POST["only_num"]."'")->find();	
		
		$only_num01=M("image_ls")->where("only_num='".$_POST["only_num"]."'")->select();
					
		$aa=M("identity_info")->where("program_id='".$only_num01[0]['program_id']."'"."and openid='".$only_num01[0]['openid']."'")->find();						


		for($i=0;$i<count($only_num01);$i++){			
			$bb.=$only_num01[$i]['image'].",";		
		}
		$bb = substr($bb,0,strlen($bb)-1);

			if(empty($aa["image"])){	
				$save01["image"]=$bb;
			}else{
				$save01["image"]=$aa["image"].",".$bb;
			}
				
		//	$save01['image'] = substr($save01['image'],0,strlen($save01['image'])-1);
			if(M("identity_info")->where("program_id='".$only_num01[0]['program_id']."'"."and openid='".$only_num01[0]['openid']."'")->save($save01)){
				M("image_ls")->where("only_num='".$_POST["only_num"]."'")->delete();
				
				$this->ajaxReturn(array('state'=>1,'msg'=>'成功'));
			}else{
				$this->ajaxReturn(array('state'=>-1,'msg'=>'失败'));
			}
	}
	//展示全部图片

	function show_all_photo(){
	//得到个人的opneid 然后就能展示图片

		$a=M("identity_info")->field('image')->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'")->find();
		//dump($a);die;	
		
		if(empty($a["image"])){
			$arr=null;
		}else{
			$arr=explode(",",$a["image"]);
		}
		
		$this->ajaxReturn($arr);
	}
	
	//异步删除个人相册中的图片
	function ajax_delete_photo(){
	
		$identity_info=M("identity_info")->field('image')->where("program_id='".$_POST["program_id"]."'"." and openid='".$_POST["openid"]."'")->find();
		
		$arr=explode(',',$identity_info["image"]);
		for($i=0;$i<count($arr);$i++){
			if($_POST["str_url"]!=$arr[$i]){
				$arr_new[]=$arr[$i];
			}
		}
		$str_new["image"]=implode(",",$arr_new);
//			dump($_POST);dump($arr);dump($arr_new);DUMP($str_new["image"]);DIE;
		if(M("identity_info")->where("program_id='".$_POST["program_id"]."'"."  and openid='".$_POST["openid"]."'")->save($str_new)){
				$this->ajaxReturn(array('state'=>1,'msg'=>'成功'));
			}else{
				$this->ajaxReturn(array('state'=>-1,'msg'=>'失败'));
			}
		
	}
	
	//积分购买鲜花页面
	function buy_flower_page(){
		$order_num="JT".date("YmdHis",time()).rand(111111,999999);//生成订单号
		
		$this->ajaxReturn($order_num);
	}
	//查询鲜花数量
	function num_flower(){
		if(empty($_GET["program_id"]) | empty($_GET["openid"])){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		
		$flowers=M("identity_info")->field('flowers')->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();
	$this->ajaxReturn($flowers);
	}
	
	//积分购买鲜花 按钮
	function buy_flowers_submit(){
		if(empty($_POST["program_id"]) | empty($_POST["openid"])){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		
		$where["program_id"]=$_POST["program_id"];
		$where["openid"]=$_POST["openid"];
		
		//post  program_id  openid  order_num flowers  record_to_flowers
		$a=M("jt03_zx_record_cz")->where("order_num='".$_POST["order_num"]."'")->find();
		if(!empty($a)){
			$this->ajaxReturn(array("state" => -888, "msg" => "不要重复提交玩"));
		}
		if(M("jt03_zx_record_cz")->where($where)->add($_POST)){	
			//个人积分减少，个人鲜花增加
			M("members")->where($where)->setInc("integral",-$_POST["record_to_flowers"]);
			
			M("identity_info")->where($where)->setInc("flowers",$_POST["flowers"]);
			$this->ajaxReturn(array('state'=>1,'msg'=>'成功'));
		}else{
			$this->ajaxReturn(array('state'=>-1,'msg'=>'失败'));
		}
	}
	
	//鲜花赠送
	function flower_send(){
		if(empty($_POST["program_id"])){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
	
		// program_id  openid_get  openid_give num  only_num     style 1：赠送积分、2：赠送礼物
		$_POST["time"]=time();

		$a=M("gift")->where("only_num='".$_POST["only_num"]."'")->find();
		if(!empty($a)){
			$this->ajaxReturn(array("state" => -888, "msg" => "不要重复提交玩"));
		}
		
		//判断赠送的人的积分和礼物数量够不够
			if($_POST["style"]==1){
				//赠送积分
			$ww1=M("members")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid_give"]."'")->find();
				if($_POST["num"]>$ww1["integral"]){
					$this->ajaxReturn(array("state" => -555, "msg" => "积分不足"));
				}
			}else if($_POST["style"]==2){
				//赠送礼物
			$ww2=M("identity_info")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid_give"]."'")->find();
				if($_POST["num"]>$ww2["flowers"]){
					$this->ajaxReturn(array("state" => -666, "msg" => "鲜花不足"));
				}
			}

		if(M("gift")->add($_POST)){
			
			if($_POST["style"]==1){
				//赠送积分
				
				M("members")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid_get"]."'")->setInc("integral",$_POST["num"]);
			
				M("members")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid_get"]."'")->setInc("integral_man_git",$_POST["num"]);
			
				M("members")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid_give"]."'")->setInc("integral",-$_POST["num"]);
		
		
			}else if($_POST["style"]==2){
				//赠送礼物
				
				M("identity_info")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid_get"]."'")->setInc("flowers",$_POST["num"]);
				M("identity_info")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid_give"]."'")->setInc("flowers",-$_POST["num"]);
		
			}
		
			$this->ajaxReturn(array('state'=>1,'msg'=>'成功'));
		}else{
			$this->ajaxReturn(array('state'=>-1,'msg'=>'失败'));
		}
	}
	
	
	//打赏红娘    1127....16.39  作废
	function reward(){
		//实际上就是积分赠送
		if(empty($_POST["program_id"])){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		
		// program_id  openid_get  openid_give num  only_num
		$_POST["time"]=time();
		$_POST["style"]="1";
		
		$a=M("gift")->where("only_num='".$_POST["only_num"]."'")->find();
		if(!empty($a)){
			$this->ajaxReturn(array("state" => -888, "msg" => "不要重复提交玩"));
		}


		if(M("gift")->add($_POST)){
			
			M("identity_info")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid_get"]."'")->setInc("flowers",$_POST["num"]);
			M("identity_info")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid_give"]."'")->setInc("flowers",-$_POST["num"]);
		
			$this->ajaxReturn(array('state'=>1,'msg'=>'成功'));
		}else{
			$this->ajaxReturn(array('state'=>-1,'msg'=>'失败'));
		}
	}
	
	//搜索红娘、单身
	function search_info(){
		// program_id   style 1:搜索 红娘、2:单身     str
		
		$where["program_id"]=$_POST["program_id"];
		if($_POST["style"]==1){
			
			$where["is_date01_com"]=1;
		}else if($_POST["style"]==2){
			$where["is_date02_com"]=1;
		}
		$where['_string']='	
			(name like "%'.$_POST["str"].'%")
		';
		
		$identity_info=M("identity_info")->where($where)->select();
		
		$this->ajaxReturn($identity_info);
		
	}
	
	//申请建立媒婆单身关系
	function apply_biuld(){
		//program_id   openid_ds  openid_mp  state=1(待审核)  style=1:单身申请    =2 媒婆邀请
		
		if($_POST["style"]==2){
			$a=M("identity_info")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid_ds"]."'")->find();
			if(!empty($a["meipo_openid"])){
				$this->ajaxReturn(array('state'=>-555,'msg'=>'这个人已经有媒婆了'));
			}
		}
		$_POST["time"]=time();
		$_POST["state"]="1";
		if(M("apply_list")->add($_POST)){
			$this->ajaxReturn(array('state'=>1,'msg'=>'成功'));
		}else{
			$this->ajaxReturn(array('state'=>-1,'msg'=>'失败'));
		}
	}
	//二维码建立媒婆单身关系  判断接口 
	function qdcode_apply(){
			if(empty($_GET["program_id"]) | empty($_GET["openid"])){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		
	//扫码去到单身注册写资料页面，页面首先判断，这个人在小程序里有没有资料，有，直接提示是否愿意成为该媒婆单身，没有，显示注册页面，点击“成为该媒婆单身“，直接无需审核直接成为团员
		
		$a=M("identity_info")->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();
	
	$b=M("identity_info")->field("name,openid,headimg")->where("program_id='".$_GET["program_id"]."'"."and openid='".$a["meipo_openid"]."'")->find();
	
		$c=M("identity_info")->field("name,openid,headimg")->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid_mp"]."'")->find();
		
		if(empty($b)){
		
			//没有媒婆
			if($a["is_date02_com"]=="1"){
			//已经有了单身资料，直接弹出确认成为该媒婆单身团员按钮
				$date=array('k1'=>0,'k2'=>0,'k3'=>0,'k4'=>$c);//k1:判断是否有媒婆（0：无，1：有）、k2：判断是不是要写单身基础资料（1:要写，0：不用了）、k3：有没有旧媒婆信息（0：没有、数组：有）
			}else{
				//没有单身资料，打开单身资料填写页面，并且得到直接无审核提交接口
				$date=array('k1'=>0,'k2'=>1,'k3'=>0,'k4'=>$c);
			}
		}else{
			//已经有了媒婆，提示媒婆信息，询问是否切换媒婆
			
			
			$date=array('k1'=>1,'k2'=>0,'k3'=>$b,'k4'=>$c);
		}
		
		$this->ajaxReturn($date);
	}
	
	//直接确认成为媒婆单身身份
	function directly_build(){
		//program_id   openid_ds  openid_mp
		
	if(empty($_POST["program_id"]) | empty($_POST["openid"])){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		if($_POST["k2"]==1){
			//要写单身资料
			$date=$_POST;
			$upload = new \Think\Upload();// 实例化上传类
			$upload->maxSize   =     3145728 ;// 设置附件上传大小
			$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			$upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
		// 上传文件
			$info   =   $upload->upload();
		
			if($info){
				$date['headimg']=$info["headimg"]['savepath'].$info["headimg"]['savename'];
			}else{
				$this->ajaxReturn(array("state" => -1, "msg" => "图片上传失败"));
			
			}
		}
		$add["style"]=2;
		$add["state"]=2;
		$add["time"]=time();
		$add["program_id"]=$_POST["program_id"];
		$add["openid_ds"]=$_POST["openid"];
		$add["openid_mp"]=$_POST["openid_mp"];
		
		$a=M("identity_info")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'")->find();
		if(empty($a)){
			//这个人还没有在平台有信息 is_date02_com
			$receive["meipo_openid"]="0";//我的媒婆 、0为无媒婆	   
			$receive["state"]="2";	//待审核   
			
			$receive["time_set"]=time();
			$receive["program_id"]=$_POST["program_id"];
			$receive["openid"]=$_POST["openid"];
			$receive["as_id"]="2";
			M("identity_info")->add($receive);
		}
		
		if(M("apply_list")->add($add)){
			$save1228["meipo_openid"]=$_POST["openid_mp"];
			$save1228["is_date02_com"]=1;
			M("identity_info")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'")->save($save1228);		
				$this->ajaxReturn(array('state'=>1,'msg'=>'成功'));
			}else{
				$this->ajaxReturn(array('state'=>-1,'msg'=>'失败'));
			}	
	}
	
	//申请（邀请）   列表
	function apply_list(){
		if(empty($_POST["program_id"]) | empty($_POST["openid"])){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
			//program_id   openid_ds  openid_mp  state=1(待审核)  style=1:单身申请    =2 媒婆邀请
		//自己是媒婆的话就能看到是申请列表、也能看到发出邀请列表=======自己是单身的话就能看到邀请列表，自己发出的申请列表
		
		$a=M("identity_info")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'")->find();
	
		if($a["as_id"]==1){
			//媒婆
			$b=M("apply_list")->where(" state=1  and program_id='".$_POST["program_id"]."'"."and openid_mp='".$_POST["openid"]."'")->select();
			//需要有单身狗的信息
			for($i01=0;$i01<count($b);$i01++){
				$b[$i01]["ds_info"]=M("identity_info")->field('openid,headimg,name,work_industry,work_con')->where("program_id='".$_POST["program_id"]."'"."and openid='".$b[$i01]["openid_ds"]."'")->find();
			}
			
			for($i=0;$i<count($b);$i++){
				if($b[$i]["style"]==1){
					//单身狗向这个媒婆提交的申请
					$b_1[]=$b[$i];
				}else if($b[$i]["style"]==2){
					//这个媒婆向别的单身狗提出的邀请
					$b_2[]=$b[$i];
				}
			}
		//	DUMP($b);die;
			$this->ajaxReturn(array('k1'=>$b_1,'k2'=>$b_2));
		}else if($a["as_id"]==2){
			//单身
			$c=M("apply_list")->where(" state=1  and program_id='".$_POST["program_id"]."'"." and openid_ds='".$_POST["openid"]."'")->select();
		
		//需要有媒婆的信息
			for($k01=0;$k01<count($c);$k01++){
				$c[$k01]["mp_info"]=M("identity_info")->field('openid,headimg,name,work_industry,work_con')->where("program_id='".$_POST["program_id"]."'"."and openid='".$c[$k01]["openid_ds"]."'")->find();
			}
	//	dump($c);dump(M("apply_list")->_sql());die;
			for($k=0;$k<count($c);$k++){
				if($c[$k]["style"]==1){
						//这只单身狗向媒婆提交的申请
						$c_1[]=$c[$k];
					}else if($c[$k]["style"]==2){
						//别的媒婆向别的这只单身狗提出的邀请
						$c_2[]=$c[$k];
					}
			}
			//DUMP($c);DIE;
		$this->ajaxReturn(array('k1'=>$c_1,'k2'=>$c_2));
		}

	}
	
	//申请（邀请）同意
	function apply_agree(){
		//得到那条申请（邀请）就行了
		$a=M("apply_list")->where("id='".$_POST["id"]."'")->find();
		
		if($_POST["state"]==2){
			if(M("apply_list")->where("id='".$_POST["id"]."'")->save(array("state"=>"2"))){
	
			M("identity_info")->where("program_id='".$_POST["program_id"]."'"."and openid='".$a["openid_ds"]."'")->save(array('meipo_openid'=>$a["openid_mp"]));	
				
				$this->ajaxReturn(array('state'=>1,'msg'=>'成功'));
			}else{
				$this->ajaxReturn(array('state'=>-1,'msg'=>'失败'));
			}
		}else if($_POST["state"]==3){
			if(M("apply_list")->where("id='".$_POST["id"]."'")->save(array("state"=>"3"))){
			//	M("identity_info")->where("program_id='".$_POST["program_id"]."'"."and openid='".$a["openid_ds"]."'")->save(array('meipo_openid'=>$a["openid_mp"]));	
				
				$this->ajaxReturn(array('state'=>1,'msg'=>'拒绝成功'));
			}else{
				$this->ajaxReturn(array('state'=>-1,'msg'=>'拒绝失败'));
			}
		}
		
	}
	
	//智能推荐
	function  recommend(){
		
		//首先根据地区推荐、然后根据职业、爱好、   is_date01_com       as_id  爱神红娘身份（1：媒婆、2：单身）
		$where["program_id"]=$_GET["program_id"];
		$where["openid"]=$_GET["openid"];
		
		$a=M("identity_info")->where($where)->find();
		
		if($a["as_id"]==1){
			//
			$this->ajaxReturn("媒婆身份就不用推荐了吧");
		}else if($a["as_id"]==2){
			//当前这个人的身份是单身
	 	
	 		$sql = " select * from identity_info ";
       		$sql .= " where sex <>'".$a["sex"]."'"." and openid <>'".$_GET["openid"]."'"."  and  is_date02_com ='1' and program_id='".$_GET["program_id"]."'";	

       		$count=M("identity_info")->query($sql);
       		
       		$num=rand(0,count($count)-1);
       		
       		$show=$count[$num];
       		$show["num"]=$num;
       		//dump($show);dump(M("identity_info")->_sql());die;
       		$show["meipo_info"]=M("identity_info")->field('id,name,openid,headimg,qinaming')->where("openid='".$show["meipo_openid"]."'")->find();
       		
    //  	dump($show);dump(M("identity_info")->_sql());die;
       		$this->ajaxReturn($show);
		}
	}
	
	//我的单身团
	function my_team_ds(){
		$a=M("identity_info")->where("program_id='".$_GET["program_id"]."'"."and meipo_openid='".$_GET["openid"]."'")->select();
	//	dump($a);die;
		$num_boy=0;//男孩数
		$num_girl=0;//女孩数
		for($i=0;$i<count($a);$i++){
			if($a[$i]["sex"]==1){
				//性别（1：男、2：女）
				//dump($a[$i]["id"]."111");
				$num_boy+=1;
				$arr_boy[]=$a[$i];//男孩数组
			}else if($a[$i]["sex"]==2){
				//	dump($a[$i]["id"]."222");
				$num_girl+=1;
				$arr_girl[]=$a[$i];//女孩数组
			}
		}
		//dump(array('k1'=>$num_boy,'k2'=>$num_girl,'k3'=>$arr_boy,'k4'=>$arr_girl));die;
		$this->ajaxReturn(array('k1'=>$num_boy,'k2'=>$num_girl,'k3'=>$arr_boy,'k4'=>$arr_girl));
	}
	
	//我的媒婆
		function my_mp(){
			
		if(empty($_GET["program_id"]) | empty($_GET["openid"])){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}	
		$identity_info=M("identity_info")->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();
		
		if($identity_info["meipo_openid"]==0){
			$a="无媒婆";
		}else{
			$a=M("identity_info")->field('id,openid,name,headimg,work_industry,work_con')->where("program_id='".$_GET["program_id"]."'"."and openid='".$identity_info["meipo_openid"]."'")->find();
	
		}
		
		$this->ajaxReturn($a);
	
	
	}
	
	
	//单身团动态（送鲜花记录）
	
	function my_dynamics(){
		
		
		$gift=M("gift")->where("style=2 and program_id='".$_GET["program_id"]."'")
	//->field($field)
	//	->join('left join identity_info ON identity_info.meipo_openid=gift.openid_give')
	//	->where("identity_info.meipo_openid='".$_GET["openid"]."'"."and identity_info.program_id='".$_GET["program_id"]."'")
		
		->select();
		
			
		for($i3=0;$i3<count($gift);$i3++){
			$gift[$i3]["info_get"]=M("identity_info")->field('name,openid,headimg')->where("program_id='".$_GET["program_id"]."'"."and openid='".$gift[$i3]["openid_give"]."'")->find();
			$gift[$i3]["info_give"]=M("identity_info")->field('name,openid,headimg')->where("program_id='".$_GET["program_id"]."'"."and openid='".$gift[$i3]["openid_get"]."'")->find();	
		}
		//	dump($gift);die;
		//收货人是这个媒婆的小弟
		for($i=0;$i<count($gift);$i++){
			$a=M("identity_info")->where("program_id='".$_GET["program_id"]."'"."and openid='".$gift[$i]["openid_get"]."'")->find();
			
			if($a["meipo_openid"]==$_GET["openid"]){
				$arr[]=$gift[$i];
			}
		}
	//song货人是这个媒婆的小弟
		for($i2=0;$i2<count($arr);$i2++){
			$a1=M("identity_info")->where("program_id='".$_GET["program_id"]."'"."and openid='".$arr[$i2]["openid_give"]."'")->find();
			
			//dump($a1);die;
			if($a1["meipo_openid"]==$_GET["openid"]){
				$arr02[]=$arr[$i2];
			}
		}
		
		
		
		$this->ajaxReturn($arr02);
	}
	
	
	//媒婆收益接口
	function mp_earnings(){
		//媒婆积分收入列表，积分收入总数
		$gift=M("gift")->where("program_id='".$_GET["program_id"]."'"."and openid_get='".$_GET["openid"]."'")->select();
		
		for($i=0;$i<count($gift);$i++){
			$k=M("identity_info")->field('name,openid')->where("program_id='".$_GET["program_id"]."'"."and openid='".$gift[$i]["openid_give"]."'")->find();
	$gift[$i]["give_name"]=$k["name"];
		}
		
		$integral_man_git=M("members")->field('integral_man_git')->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->select();
		
		
		$date=array("k1"=>$gift,"k2"=>$integral_man_git);
		$this->ajaxReturn($date);
	}
	
	
	//关注列表  、喜欢列表
	function attention_list(){
		//state   类型 1：关注、2：互相喜欢
		
		$where["program_id"]=$_GET["program_id"];
		$where["opneid_attentioning"]=$_GET["openid"];
		$where["state"]=$_GET["state"];
		
		$attention=M("attention")->where($where)->select();
		
		for($i=0;$i<count($attention);$i++){
			$identity_info=	M("identity_info")->field('name,headimg,openid')->where("program_id='".$_GET["program_id"]."'"."and openid='".$attention[$i]["openid_attentioned"]."'")->find();
		
			$attention[$i]["name_attentioned"]=$identity_info["name"];
			$attention[$i]["headimg_attentioned"]=$identity_info["headimg"];
			$attention[$i]["openid_attentioned"]=$identity_info["openid"];
		}
		$this->ajaxReturn($attention);
	}
	
	//帮助与反馈
	 function help_and_feedback(){
	 	$a=M("store")->field('help_and_feedback')->where("program_id='".$_GET["program_id"]."'")->find();
	 	
	 	$this->ajaxReturn($a);
	 }
	 
	 //爱神文章列表
	 function artical_list(){
		$artical=M("artical")->where("is_show=1 and program_id='".$_GET["program_id"]."'")->order("time_set desc")->select();
		
		$this->ajaxReturn($artical);
	 }
	 
}
?>