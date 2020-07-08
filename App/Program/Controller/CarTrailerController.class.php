<?php
namespace Program\Controller;
use Think\Controller;
header('content-type:application:json;charset=utf8'); 
header('Access-Control-Allow-Origin:*'); 
//header('Access-Control-Allow-Methods:POST'); 
header('Access-Control-Allow-Headers:x-requested-with,content-type');
class CarTrailerController extends Controller {
	//宜拖车接口
	//身份注册注册
	
	
	//注册---企业
	function register(){
		//program_id、openid
		//账号： account、密码：psw 、账号名称：name、头像：headimage、邮箱： mail、联系人：linkman、联系电话：linktel 、证件号：certificate_num、性别：sex、车牌号：car_num
		//idcard_positive：身份证正面、idcars_reverse 身份证反面
		//driver_license：驾驶证、driving_this：行驶本
		//state 所属状态（1：个人司机、2：合作单位、3：签约单位）
		
		//如果是司机进来的，账号就是 $_POST["openid"].$_POST["program_id"],密码就是MD5加密的		

		$receive=$_POST;
		$car_manerger=M("car_manerger")->where("program_id='".$receive["program_id"]."'"."and openid='".$receive["openid"]."'")->find();
		
		if(!empty($car_manerger)){
			if($car_manerger["state_register"]==1){
				//待审--不可申请
				$this->ajaxReturn(array('status'=>-777,'msg'=>'待审--该微信不可申请'));
			}if($car_manerger["state_register"]==2){
				//通过--不可申请
				$this->ajaxReturn(array('status'=>-666,'msg'=>'通过--该微信不可申请'));
			}
			// $car_manerger["state_register"]==3 拒绝--可以申请	
		}
	
		$upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =     3145728 ;// 设置附件上传大小
			    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录

			// 上传文件	//image_belong:  headimage idcard_positive idcars_reverse driver_license driving_this
			     $info   =   $upload->upload();
			 if($info){
			 	$receive['headimage']=$info["headimage"]['savepath'].$info["headimage"]['savename'];
			 	
			/* 	$receive['idcard_positive']=$info["idcard_positive"]['savepath'].$info["idcard_positive"]['savename'];
			 	$receive['idcars_reverse'] =$info["idcars_reverse"]['savepath'] .$info["idcars_reverse"]['savename'];
			 	$receive['driver_license'] =$info["driver_license"]['savepath'] .$info["driver_license"]['savename'];
			 	$receive['driving_this']   =$info["driving_this"]['savepath']   .$info["driving_this"]['savename'];
		*/
			 }else{
			 	$this->ajaxReturn(array('status'=>-888,'msg'=>'无上传图片'));
			 	/*	$receive["account"]=$_POST["openid"].$_POST["program_id"];
			 		$receive["psw"]=md5($_POST["openid"].$_POST["program_id"]);
			 		if(empty($info["idcard_positive"]) | empty($info["idcars_reverse"]) | empty($info["driver_license"]) | empty($info["driving_this"])){
			 			$this->ajaxReturn(array('status'=>-888,'msg'=>'图片未上传'));
			 		}*/
			 }
			 
			
			 $receive['psw']=md5($_POST["psw"]);
			 	$receive['time_register']=time();
			 $receive["state_register"]="1";
			if(M("car_manerger")->add($receive)){
				$this->ajaxReturn(array('status'=>1,'msg'=>'提交成功1'));
			}else{
				$this->ajaxReturn(array('status'=>-1,'msg'=>'提交失败'));
			}
	}
	
	//司机注册页面访问接口  选择车场
	function chooes_parking(){
		$a=M("car_parking")->field('id,address')->where("program_id='".$_GET["program_id"]."'")->order("sort")->select();
		
		$this->ajaxReturn($a);
	}	
//查看这个微信号是否注册过

		function check_registe(){
			$car_manerger=M("car_manerger")->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();
			
			if(!empty($car_manerger)){
				//所属状态（1：个人司机、2：合作单位、3：长期签约客户）
				if($car_manerger["state"]==1){
					$date["identy"]="个人司机";
				}else if($car_manerger["state"]==2){
					$date["identy"]="合作单位";
				}else if($car_manerger["state"]==3){
					$date["identy"]="长期签约客户";
				}
				
				
				//申请状态（1：待审核、2：审核完成、3：审核拒绝）
				if($car_manerger["state_register"]==1){
					//待审--不可申请
					$this->ajaxReturn(array('state'=>-1,'msg'=>'有待审申请'));
				}if($car_manerger["state_register"]==2){
					//通过--不可申请
					$this->ajaxReturn(array('state'=>-2,'msg'=>'有已通过申请'));
				}
			}else{
				$date["state"]="1";
				$date["msg"]="可以打开申请页";
				$date["identy"]="空白用户";
			}
			
			$this->ajaxReturn($date);
		}
	//注册---司机
	function register_1(){
		$receive=$_POST;
		if(empty($receive["openid"]) ){
			$this->ajaxReturn(array('state'=>-999,'msg'=>'参数缺失'));
		}
		if( empty($receive["program_id"])){
			$this->ajaxReturn(array('state'=>-999,'msg'=>'参数缺失'));
		}
		$car_manerger=M("car_manerger")->field("id,state_register")->where("program_id='".$receive["program_id"]."'"."and openid='".$receive["openid"]."'")->find();
		if(!empty($car_manerger)){
			if($car_manerger["state_register"]==1){
				//待审--不可申请
				$this->ajaxReturn(array('state'=>-777,'msg'=>'待审--该微信不可申请'));
			}if($car_manerger["state_register"]==2){
				//通过--不可申请
				$this->ajaxReturn(array('state'=>-666,'msg'=>'通过--该微信不可申请'));
			}
			// $car_manerger["state_register"]==3 拒绝--可以申请	
		}
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =     3145728 ;// 设置附件上传大小
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
		// 上传文件
		$info   =   $upload->upload();
		if($info){
			//有图片===============================================================
			$receive['image']=$info["image"]['savepath'].$info["image"]['savename'];
			$receive['time_register']=time();
		
			//image_belong:  headimage idcard_positive idcars_reverse driver_license driving_this
			// 建立临时数据表，传好了就等待拼接
		//	$receive["on_time"]=time().rand("1111","9999");
		$receive["state_register"]	="1";
		$receive['account']			=$receive["openid"].$receive["program_id"];
		$receive['psw']				=md5($receive["openid"].$receive["program_id"]);
		$receive["is_tired"]	="1";
			if(M('car_manerger_copy')->add($receive)){ 
				$this->ajaxReturn(array('state'=>1,'msg'=>'成功'));
			}else{
				$this->ajaxReturn(array('state'=>-1,'msg'=>'失败'));
			}	
		}else{
			//无图片===============================================================

			$this->ajaxReturn(array('status'=>-888,'msg'=>'无上传图片'));
		}
	}
	//临时表数据拼接之后加入正式信息表
	function temp_info(){
		$only_num_date=$_GET["only_num"];
	
		$only_num=M("car_manerger")->where("only_num='".$only_num_date."'")->find();			
		$only_num01=M("car_manerger_copy")->where("only_num='".$only_num_date."'")->select();
		//image_belong:  headimage idcard_positive idcars_reverse driver_license driving_this  headimage

		if(empty($only_num)){
			if(M("car_manerger")->add($only_num01[0])){
				for($i=0;$i<count($only_num01);$i++){
					if($only_num01[$i]['image_belong']=="headimage") $save01["headimage"]=$only_num01[$i]['image'];	 
						
					if($only_num01[$i]['image_belong']=="idcard_positive") $save01["idcard_positive"]=$only_num01[$i]['image'];
							
					if($only_num01[$i]['image_belong']=="idcars_reverse") $save01["idcars_reverse"]=$only_num01[$i]['image'];	
						
					if($only_num01[$i]['image_belong']=="driver_license") $save01["driver_license"]=$only_num01[$i]['image'];
								
					if($only_num01[$i]['image_belong']=="driving_this") $save01["driving_this"]=$only_num01[$i]['image'];
													
					
				}

				M("car_manerger")->where("only_num='".$only_num_date."'")->save($save01);
				$this->ajaxReturn(array('state'=>1,'msg'=>'成功'));
			}else{
				$this->ajaxReturn(array('state'=>-1,'msg'=>'失败'));
			}			
		}
	}
	
	
	//资料展示接口
	function info_show(){

		if(empty($_GET["online_code"])){
			$this->ajaxReturn(array('state'=>-111,'msg'=>'无登录码'));
		}else{
				$arr=explode(",",$_GET["online_code"]);
				$account=$arr[0];
		}
		//	$b_temp=M("car_manerger")->field('name,headimage,is_online')->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();
		$a=M("car_manerger")->where("state_register=2 and program_id='".$_GET["program_id"]."'"."and account='".$account."'")->find();
		
		//$b=M("car_parking")->field('id,address')->where("program_id='".$_GET["program_id"]."'")->order("sort")->select();
	
		$b=M("car_num")->where("id='".$a["tied_car_num_id"]."'")->find();
		
		$a["car_num_tied"]=$b["car_num"];

	
		$b=M("car_parking")->field('id,address')->where("id='".$a["parking_id"]."'")->find();
		$a["parking_info"]=$b;
		$this->ajaxReturn($a);
	}
	//修改资料接口
	function image_modify(){
		//只有在登录状态才能修改资料  $_GET["online_code"]
		
		if(empty($_POST["program_id"]) & empty($_POST["online_code"])){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =     3145728 ;// 设置附件上传大小
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
		// 上传文件
		$info   =   $upload->upload();
		if($info){
			$image['image']=$info["image"]['savepath'].$info["image"]['savename'];
		}else{
			$this->ajaxReturn(array('state'=>-888,'msg'=>'无图片'));
		}
		
		$arr=explode(",",$_POST["online_code"]);
		
		$where["program_id"]=$_POST["program_id"];
		$where["account"]=$arr[0];
		$where["psw"]=$arr[1];		
		
		$save[$_POST["image_belong"]]=$image['image'];
		$old=M("car_manerger")->where($where)->find();
		if(M("car_manerger")->where($where)->save($save)){
			
			unlink('./Uploads/'.$old[$_POST["image_belong"]]);
			$this->ajaxReturn(array('state'=>1,'msg'=>'修改成功'));
		}else{
			$this->ajaxReturn(array('state'=>-1,'msg'=>'修改失败'));
		}		
	}
	
	//资料修改修改
	function text_modify(){
		if(empty($_POST["program_id"]) & empty($_POST["online_code"])){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		
		$arr=explode(",",$_POST["online_code"]);
		
		$where["program_id"]=$_POST["program_id"];
		$where["account"]=$arr[0];
		$where["psw"]=$arr[1];		
		
		if(M("car_manerger")->where($where)->save($_POST)){
			$this->ajaxReturn(array('state'=>1,'msg'=>'修改成功'));
		}else{
			$this->ajaxReturn(array('state'=>-1,'msg'=>'修改失败'));
		}	
	}
	

	
	//首页
	function car_index(){
		//车种列表、对应车型列表
		//车种类（一维数组）
		
		$is_member=M("members")->where("openid='".$_GET["openid"]."'"."and program_id='".$_GET["program_id"]."'")->find();
		
			
		if(empty($is_member)){
		
//因为线下测试的使用的是不对应的appid，会出现没有openid情况，这个时候不打断，但是不能存数据库
		//如果没有openid 就返回一个提示

		if(!empty($_GET["openid"])){
			$_GET["register_time"]=time();
			M("members")->add($_GET);
		}
	}else{
	
			//有了个人的信息，补全nickname、headimgurl
		$dat["nickname"]=$_GET["nickname"];
		$dat["head"]=$_GET["head"];
		M("members")->where("openid='".$_GET["openid"]."'"."and program_id='".$_GET["program_id"]."'")->save($dat);
	}
		
	
		$a=M("car_fenlei")->where("is_show=1 and program_id='".$_GET["program_id"]."'")->order("sort desc")->select();
		
		$field_1='id,title,canshu_name,canshu_val,image,load_id,price_id,driver_id,fenlei_id,load_start,load_end';
			
		for($i=0;$i<count($a);$i++){
			//车型（二维数组）
		$a1[$i]=M("car_allcar")->field($field_1)->where("is_show=1 and fenlei_id='".$a[$i]["id"]."'")->select();
			$a[$i]["car_info"]=$a1[$i];

			for($k=0;$k<count($a1[$i]);$k++){
				//车型参数（三维数组）
				$arr_cs_name[$i][$k]=explode(",",$a1[$i][$k]["canshu_name"]);
				$arr_cs_val[$i][$k]=explode(",",$a1[$i][$k]["canshu_val"]);
				
				$a[$i]["car_info"][$k]["canshu_name"]=$arr_cs_name[$i][$k];
				$a[$i]["car_info"][$k]["canshu_val"]=$arr_cs_val[$i][$k];
				
				//车种图片
				$image[$i][$k]=explode(",",$a1[$i][$k]["image"]);
				$a[$i]["car_info"][$k]["image"]=$image[$i][$k][0];
				
				//车种价格计算
				$field_2='id,title,price_start,basis_miles,per_price,ct_per_price';
				$a1_1[$k]=M("car_charges")->field($field_2)->where("id='".$a1[$i][$k]["price_id"]."'")->find();
				
				//车种里程计算
				$d=M("store")->where("program_id='".$_GET["program_id"]."'")->find();
				$a1_1[$k]["per_distance"]=$d["base_distance"];
				
				$a[$i]["car_info"][$k]["price_arr"]=$a1_1[$k];
			}
		}
		
		$b=M("car_allcar")->field($field_1)->where(" is_show=1 and is_recommended=1 and program_id='".$_GET["program_id"]."'")->select();
		for($k=0;$k<count($b);$k++){
			//车种分类
			$car_fenlei=M("car_fenlei")->where("id='".$b[$k]["fenlei_id"]."'")->find();
			$b["feilei_info"]=$car_fenlei;
		}
		$z=array('k1'=>$a,'k2'=>$b);
	//dump($z);die;
		$this->ajaxReturn($z);
	}
	
	//个人登录接口
	function onload(){
//个人司机登录，账号就是 $_POST["openid"].$_POST["program_id"]，密码就是md5($_POST["openid"].$_POST["program_id"])
//online_state 1:个人司机，、2其他用户
		if($_GET["online_state"]==1){
			$account=	$_GET["openid"].$_GET["program_id"];
			$psw=		md5($_GET["openid"].$_GET["program_id"]);
		}else{
			$account=	$_GET["account"];
			$psw=		md5($_GET["psw"]);
		}

		$a=M("car_manerger")->where("state_register=2 and program_id='".$_GET["program_id"]."'"."and account='".$account."'")->find();
		
		if(empty($a)){
			$date=array('status'=>'-1.1','msg'=>'登录失败','why'=>'账号不存在');
		}else{
			
			if($a["state_register"]=="2"){
				if($a["psw"]==$psw){
					$online_code=$a["account"].",".$a["psw"];
					$date=array('status'=>'1','msg'=>'登录成功','why'=>'登录成功','online_code'=>$online_code);
				}else{
					$date=array('status'=>'-1.2','msg'=>'登录失败','why'=>'密码错误');
				}
			}else{
				$date=array('status'=>'-1.3','msg'=>'登录失败','why'=>'账号审核中');
			}
			
		}
		$this->ajaxReturn($date);
//		if($a["psw"]==$psw){
//			$save["is_online"]=1;
//			M("car_manerger")->where("state_register=2 and program_id='".$_GET["program_id"]."'"."and account='".$account."'")->save($save);
//			$online_code=$a["account"].",".$a["psw"];
//			$this->ajaxReturn(array('status'=>1,'msg'=>'登录成功','online_code'=>$online_code));
//		}else{
//			$this->ajaxReturn(array('status'=>-1,'msg'=>'登录失败'));
//		}
	}
	
	//查询账号审核结果接口
	function search_registe(){
		//情景1：初次申请的用户，数据库没有资料，申请的时候有一个待申请，无账号，返回的事等待审核
		
		//情景2：已经申请了的用户，手机有缓存的，调用缓存，有账号，没缓存的，就没账号

		if(empty($_GET["account"])){
			//查看这个人有没有提交过申请
			$a0414=M("car_manerger")->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();
			
			if(empty($a0414)){
				$date=array('status'=>"-1",'msg'=>"无提交资料");
			}else{
				if($a0414["state_register"]==1){
					$date=array('status'=>"1",'msg'=>"等待审核");
				}else if($a0414["state_register"]==2){
					$date=array('status'=>"2",'msg'=>"审核通过");
				}else if($a0414["state_register"]==3){
					$date=array('status'=>"3",'msg'=>"审核拒绝");
				}
			}
		}else{
			//online_state 1:个人司机，、2其他用户
			if($_GET["online_state"]==1){
				//司机用户   没账号密码的
				$account=	$_GET["openid"].$_GET["program_id"];
			}else{
				//企业用户
				$account=	$_GET["account"];
			}
			
			$a=M("car_manerger")->where("program_id='".$_GET["program_id"]."'"."and account='".$account."'")->find();
			
			if(empty($a)){
				$date=array('status'=>"-1",'msg'=>"无提交资料2");
			}else{
				if($a["state_register"]==1){
					$date=array('status'=>"1",'msg'=>"等待审核");
				}else if($a["state_register"]==2){
					$date=array('status'=>"2",'msg'=>"审核通过");
				}else if($a["state_register"]==3){
					$date=array('status'=>"3",'msg'=>"审核拒绝");
				}
			}
		}
		
		
		$this->ajaxReturn($date);
	

	}
	
function chech_load($c_online_code,$program_id){
		//传递回来的编码带有时间戳  不要时间戳
		//account+psw   online_code    program_id openid  
	$online_code=explode(",",$c_online_code);//[0]账号、[1]密码
	$a=M("car_manerger")->where("program_id='".$program_id."'"."and account='".$online_code[0]."'"."and psw='".$online_code[1]."'")->find();
	if(empty($a)){
			//账号或者密码错误
			$is_conline["state"]="2";//账号密码错误、一般只会是密码错误
		}else{
			$is_conline["state"]="1";//验证成功
			$is_conline["info"]=$a;
		}
		
		return $is_conline;
}
//已登录人信息
function load_user_info(){
	if(empty($_GET["online_code"]) | $_GET["online_code"]=="false"){
			$results["state"]="-999";//没有登录码
		}else{
			$arr=explode(",",$_GET["online_code"]);
			$account=	$arr[0];
			$psw=		$arr[1];

			$a=M("car_manerger")->field('name,headimage,is_online')->where("program_id='".$_GET["program_id"]."'"."and account='".$account."'"."and psw='".$psw."'")->find();
			if(empty($a)){
					//账号或者密码错误
					$results["state"]="2";//账号密码错误、一般只会是密码错误
				}else{
					$results["state"]="1";//验证成功
					$results["info"]=$a;
				}
				
		}
		$this->ajaxReturn($results);
}

		//判断个人是否登录  新
	function is_load_1(){
		
		if(empty($_GET["online_code"]) | $_GET["online_code"]=="false"){
			$results["state"]="-999";//没有登录码
			
		
		}else{
			$account=	$_GET["openid"].$_GET["program_id"];
			$psw=		md5($_GET["openid"].$_GET["program_id"]);

			$a=M("car_manerger")->where("program_id='".$_GET["program_id"]."'"."and account='".$account."'"."and psw='".$psw."'")->find();
			if(empty($a)){
					//账号或者密码错误
					$results["state"]="2";//账号密码错误、一般只会是密码错误
				}else{
					$results["state"]="1";//验证成功
					$results["info"]=$a;
				}
		//	$results=$this->chech_load($online_code,$_GET["program_id"]);	
		}
		
		$b_temp=M("car_manerger")->field('id,name,headimage')->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();
		if($results["state"]=="-999"){
			$b["id_state"]="0";				
			$b["msg"]="游客";	
			$this->ajaxReturn($b);
		}else if($results["state"]=="1" ){
			//正常登录
			$b["id_state"]="1";				
			$b["msg"]="已在平台注册";	
		
			if($results["info"]["state"]==1){
			
				$b["msg_state"]="个人司机";	
						
			}else if($results["info"]["state"]==2){		
				$b["msg_state"]="合作单位";			
			}else if($results["info"]["state"]==3){
				$b["msg_state"]="签约单位";			
			}
//				if($b_temp["is_online"]==1){
//					
//					$b["name"]=$b_temp["name"];
//					$b["headimage"]=$b_temp["headimage"];
//
//					$b["msg_is_online"]="已登录";		//0416 未使用
//				}else{
//					$b["msg_is_online"]="未登录登录";	//0416 未使用
//				}
			$b["name"]=$b_temp["name"];
			$b["headimage"]=$b_temp["headimage"];
	
			$this->ajaxReturn($b);
		}else if($results["info"]["state"]=="2"){
			//账号密码错误、一般只会是密码错误
			$this->ajaxReturn(array('status'=>"-999",'msg'=>"账号异常禁止登录"));
		}
	
	}
	
	
	//判断个人是否登录   旧
	function is_load(){
		//个人登录信息   ---全查询，显示部分
		$b_temp=M("car_manerger")->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();
		
		$b["state"]=$b_temp["state"];
		$b["is_online"]=$b_temp["is_online"];
		$b["state_register"]=$b_temp["state_register"];
		
		if(empty($b_temp)){
			$b["id_state"]="0";				
			$b["msg"]="游客";				
		}else{
				$b["id_state"]="1";				
				$b["msg"]="已在平台注册";	
			if($b_temp["state"]==1){
			
				$b["msg_state"]="个人司机";	
				if($b["is_online"]==1){
					
					$b["name"]=$b_temp["name"];
					$b["headimage"]=$b_temp["headimage"];

					$b["msg_is_online"]="已登录";	
				}else{
					$b["msg_is_online"]="未登录登录";	
				}		
			}else if($b_temp["state"]==2){
			
				$b["msg_state"]="合作单位";			
			}else if($b_temp["state"]==3){
				
				$b["msg_state"]="签约单位";			
			}
			
			if($b_temp["state_register"]==1){
			
				
				$b["msg_register"]="待审核";		
			}else if($b_temp["state_register"]==2){
			
				
				$b["msg_register"]="审核完成";	
			}else if($b_temp["state_register"]==3){
				
				
				$b["msg_register"]="审核拒绝";	
			}
				
		}
		$this->ajaxReturn($b);
	}
	
	//退出登录接口
	function load_out(){
		
		
		$arr=explode(",",$_GET["online_code"]);
		$save["is_online"]=2;
	
		$where["program_id"]=$_GET["program_id"];
		$where["account"]=$arr[0];
		$where["psw"]=$arr[1];
		if(M("car_manerger")->where($where)->save($save)){
			$this->ajaxReturn(array('status'=>"1",'msg'=>"退出成功"));
		}else{
			$this->ajaxReturn(array('status'=>"-1",'msg'=>"退出失败"));
		}		
		
		
	}
	
	//异步检测账号唯一接口
	function only_account(){
		$a=M("car_manerger")->where("program_id='".$_GET["program_id"]."'"."and account='".$_GET["account"]."'")->find();
		
		if(empty($a)){
			$this->ajaxReturn(array('status'=>1,'msg'=>'可以使用'));
		}else{
			$this->ajaxReturn(array('status'=>-1,'msg'=>'已经存在该账号'));
		}
	}
	
	
	//车型详情
	function car_con(){
		if(empty($_GET["program_id"]) ){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		$field_1='id,title,canshu_name,canshu_val,image,load_id,price_id,driver_id,fenlei_id,load_start,load_end';
		$a1=M("car_allcar")->field($field_1)->where("id='".$_GET["id"]."'"."and program_id='".$_GET["program_id"]."'")->find();
			
			//车型参数
		$a1["canshu_name"]=explode(",",$a1["canshu_name"]);
		$a1["canshu_val"]=explode(",",$a1["canshu_val"]);
						
			//车种图片
		
		$a1["image"]=explode(",",$a1["image"]);
				
			//车种价格计算
		$field_2='id,title,price_start,basis_miles,per_price,ct_per_price';
		$a1_1=M("car_charges")->field($field_2)->where("id='".$a1["price_id"]."'")->find();
					
		$a1["price_arr"]=$a1_1;
		
			//车种里程计算
		$d=M("store")->where("program_id='".$_GET["program_id"]."'")->find();
		$a1["per_distance"]=$d["base_distance"];
	$this->ajaxReturn($a1);
	}
	
//平台资讯列表
	function info_list(){
		if(empty($_GET["program_id"]) ){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		$a=	M("jt03_zx_info")->field('id,title,image,time_input')->where("is_show=1 and program_id='".$_GET["program_id"]."'")->order("sort desc")->select();

		$this->ajaxReturn($a);
	}

//资讯详情
function info_con(){
	if(empty($_GET["program_id"]) ){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
	
	$a=	M("jt03_zx_info")->field('id,title,image,time_input,content')->where("id='".$_GET["id"]."'"."and program_id='".$_GET["program_id"]."'")->find();
	
		$this->ajaxReturn($a);
}

//额外需求选择也
function car_extra_need(){
	$a=M("car_extra_need")->where("program_id='".$_GET["program_id"]."'")->order("sort")->select();
	
	$this->ajaxReturn($a);
}

//取消订单原因页
function car_cancel_reason(){
	$a=M("car_cancel_reason")->field('id,title')->where("program_id='".$_GET["program_id"]."'")->order("sort")->select();
	
		$this->ajaxReturn($a);
}

//生成价格

function price_build($distance,$program_id,$price_id){

	//$distance 距离、$program_id 小程序id、$price_id 计价规则id
	//$distance=54321;//单位：米
	$a=M("store")->field('base_distance')->where("program_id='".$program_id."'")->find();
	
	//距离比例

	$b=M("car_charges")->where("id='".$price_id."'")->find();
	
	$distance=$distance-$b["basis_miles"]*1000;//减去基础里程的距离
	$per=$distance/($a["base_distance"]*1000);
	$price=0;//最终价格
	
	
	$price=$b["price_start"];

	if(($distance*0.001)<($b["ct_miles"])){
		//短途里程
			if($distance>$b["basis_miles"]*1000){
				$price+=$b["per_price"]*intval($per);
			}
	}else{
	
		//长途里程
		$price+=($b["per_price"]+$b["ct_per_price"])*intval($per);
	}

//	dump($program_id);dump($a);dump($distance);
	return $price;
	
} 

//地址添加接口  绑定有两个内容  openid、account  有账号就用账号，没账号就绑定openid
function address_add(){
//program_id openid  online_code
//联系人 linkman  联系电话 tel 坐标 coordinate  具体地址 address  账号 account
	if(empty($_POST["online_code"])){
		//未登录状态
		$_POST["account"]=0;
	}else{
		//登录状态
		$arr=explode(",",$_POST["online_code"]);
		$_POST["account"]=$arr[0];
	}

	$_POST["only_num"]=time().rand(111,999);
	
	//服务地址计算---百度地图行车距离
//	$coo_1=explode(",",$_POST["coordinate_start"]);
//	$coo_2=explode(",",$_POST["coordinate_end"]);
//	
//	$coo_1_n=$coo_1[1].",".$coo_1[0];
//	$coo_2_n=$coo_2[1].",".$coo_2[0];
//	$distance=$this->count_distance_bd($from=$coo_1_n,$to=$coo_2_n);
//	$_POST["distance"]=$distance;
//$_POST["distance"]=$_POST["distance"];
	
$where["linkman"]=$_POST["linkman"];
$where["tel"]=$_POST["tel"];
$where["openid"]=$_POST["openid"];
$where["coordinate_start"]=$_POST["coordinate_start"];
$where["coordinate_end"]=$_POST["coordinate_end"];
$haved=M("car_address")->where($where)->find();
if(empty($haved)){
	if(M("car_address")->add($_POST)){
		$a=M("car_address")->where("only_num='".$_POST["only_num"]."'")->find();
		$this->ajaxReturn(array("state" => 1, "msg" => "成功", "fw_id" => $a["id"]));
	}
}else{
	$this->ajaxReturn(array("state" => 1, "msg" => "成功", "fw_id" => $haved["id"]));
}
	
}


//地址编辑
function address_edit(){
	$a=M("car_address")->where("program_id='".$_GET["program_id"]."'"."and id='".$_GET["id"]."'")->find();
	
	$this->ajaxReturn($a);
}
function address_save(){
	if(M("car_address")->where("program_id='".$_POST["program_id"]."'"."and id='".$_POST["id"]."'")->save($_POST)){
		$this->ajaxReturn(array("state" => 1, "msg" => "成功"));
	}else{
		$this->ajaxReturn(array("state" => -1, "msg" => "失败"));
	}
}
function address_delete(){
		$save["is_phone_show"]=0;
		if(M("car_address")->where("program_id='".$_GET["program_id"]."'"."and id='".$_GET["id"]."'")->save($save)){
			$this->ajaxReturn(array("state" => 1, "msg" => "成功"));
		}else{
			$this->ajaxReturn(array("state" => -1, "msg" => "失败"));
		}
	}
//服务地址列表
function address_list(){

	if(empty($_GET["online_code"])){
			//未登录状态
			$_GET["account"]=0;
			$a=M("car_address")->where("is_phone_show=1 and  program_id='".$_GET["program_id"]."'"." and openid='".$_GET["openid"]."'")->select();
	
		}else{
			//登录状态
			$arr=explode(",",$_GET["online_code"]);
			$account=$arr[0];
			$a=M("car_address")->where("is_phone_show=1 and  program_id='".$_GET["program_id"]."'"."and account='".$account."'")->select();
		}
	
		$this->ajaxReturn($a);
}


//异步展示选坐标之后的价格  直线路线价格计算

function distance_price(){
	if(empty($_GET["program_id"]) ){
		$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
	}
	$a=M("car_allcar")->where("id='".$_GET["car_id"]."'"."and program_id='".$_GET["program_id"]."'")->find();
	
	//计算距离
	$distance0112=$this->count_distance_bd($from=$_GET["coordinate_start"],$to=$_GET["coordinate_end"]);
	
	//得到价格
	$price=$this->price_build($distance=$distance0112,$program_id=$_GET["program_id"],$price_id=$a["price_id"]);//推荐价格

	$this->ajaxReturn($price);
}
function car_distance_price(){
	if(empty($_GET["program_id"]) ){
		$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
	}
	$a=M("car_allcar")->where("id='".$_GET["car_id"]."'"."and program_id='".$_GET["program_id"]."'")->find();
	
	//得到价格
	$price=$this->price_build($distance=$_GET["distance"],$program_id=$_GET["program_id"],$price_id=$a["price_id"]);//推荐价格

	$this->ajaxReturn($price);
}

//收费标准接口   
function charges_rule(){
	//根据机型展示对应机型的收费标准   
	if(empty($_GET["program_id"]) ){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		$field_1='id,title,canshu_name,canshu_val,image,load_id,price_id,driver_id,fenlei_id,load_start,load_end';
		$a1=M("car_allcar")->field($field_1)->where("id='".$_GET["id"]."'"."and program_id='".$_GET["program_id"]."'")->find();
			
			//车型参数
		$a1["canshu_name"]=explode(",",$a1["canshu_name"]);
		$a1["canshu_val"]=explode(",",$a1["canshu_val"]);
						
			//车种图片
		
		$a1["image"]=explode(",",$a1["image"]);
				
			//车种价格计算
		$field_2='id,title,price_start,basis_miles,per_price,ct_per_price,ct_miles';
		$a1_1=M("car_charges")->field($field_2)->where("id='".$a1["price_id"]."'")->find();
		
					//车种里程计算
		$d=M("store")->where("program_id='".$_GET["program_id"]."'")->find();
		$a1["per_distance"]=$d["base_distance"];

		//车基础计价单位
        $base_distance=M("store")->where("program_id='".$_GET["program_id"]."'")->find();
        $a1_1["base_distance"]=$base_distance["base_distance"];
        $a1["price_arr"]=$a1_1;
		
	$this->ajaxReturn($a1);	
}


//调用腾讯地图测行车距离
function count_distance($f,$t){

    	$from=$f;
    	$to=$t;
    	$key="4QQBZ-CY4CS-NWEOO-6NCTZ-5DMOF-IXFH5";
  		$url = "http://apis.map.qq.com/ws/distance/v1/?mode=driving&from=".$from."&to=".$to."&key=".$key;
		
		$hello = new IndexController();
		$result = $hello->http_request($url);
		$result=json_decode($result);

		$distance=$result->result->elements[0]->distance;
		if($distance==null){
			$distance="99999999";
		}
		return $distance;
	}
	
function test_distent(){
	$a=$this->count_distance_bd($from="22.658718,113.99987",$to="22.66481,113.9485");
	dump($a);die;
}
	//调用百度地图测行车距离
function count_distance_bd($from,$to){
//http://api.map.baidu.com/direction/v2/driving?origin=40.01116,116.339303&destination=39.936404,116.452562&ak=VPQ6NF9IHgm5w9tFTdeMRdL2bXb9iMIX&coord_type=wgs84
  //  $from="22.821757,113.790894";
 //   $to="23.200961,113.027344";
    	$key="VPQ6NF9IHgm5w9tFTdeMRdL2bXb9iMIX";
  		$url = "http://api.map.baidu.com/direction/v2/driving?origin=".$from."&destination=".$to."&ak=".$key."&coord_type=wgs84";
		
		$hello = new IndexController();
		$result = $hello->http_request($url);
	
		$result=json_decode($result);
		
		$distance=$result->result->routes[0]->distance;
	//dump($distance);
		return $distance;
	}
/*	function count_distance_bd123(){
   $from="22.554628,113.887171";
   $to="22.662460,113.980160";
    	$key="VPQ6NF9IHgm5w9tFTdeMRdL2bXb9iMIX";
  		$url = "http://api.map.baidu.com/direction/v2/driving?origin=".$from."&destination=".$to."&ak=".$key."&coord_type=wgs84";
		
		$hello = new IndexController();
		$result = $hello->http_request($url);
	
		$result=json_decode($result);
		
		$distance=$result->result->routes[0]->distance;
	dump($distance);
		return $distance;
	}
	function test0121(){
		 $distance=$this->count_distance_bd($from="22.554628,113.887171",$to="22.662460,113.980160");
		 dump($distance);
	}*/
	
	
	//下单流程  1：选择车型（提交生成订单，返回订单号）、2：输入地址（如果有地址就选地址，没地址就弹出编辑）
	//3:自动判断提交的位置最近的车场，并且判断有没有空闲的司机，然后列表展示订单预览
	//4：下单，：5：后台填写订单绑定的司机（分配任务）修改司机状态
		//订单生成接口
	function build_order(){
		//price：价格、state （1：待付款，、2：待服务、3：已取消、4：已完成）、car_id：车种id、extra_need_id：额外需求id car_allcar

		if(empty($_POST["online_code"])){
			//未登录状态
			$_POST["account"]=0;
		}else{
			//登录状态
			$arr=explode(",",$_POST["online_code"]);
			$_POST["account"]=$arr[0];
		}
		
		$_POST["state"]="1";
		$_POST["time_xd"]=time();
		$_POST["only_num"]=time().rand(111111,999999);
//		$_POST["order_num"]="jt".time().rand(111111,999999); 
		$_POST["order_num"]=0;
		//计算价格
        //车场位置列表(统计有效司机的人数)
        // 服务地址 fw_id
        $b=M("car_address")->where("id='".$_POST["fw_id"]."'")->find();// coordinate  服务位置选择
      //  $c=M("car_parking")->where("program_id='".$_POST["program_id"]."'")->select();
    	//得到选择的成型id  进而得到价格id
        $car_allcar=M("car_allcar")->where("id='".$_POST["car_id"]."'")->find();
    	
       /* for($i=0;$i<count($c);$i++){
            //统计每个车场有的空闲司机人数
            $count[$i]=M("car_manerger")->where("server_state=0 and parking_id='".$c[$i]["id"]."'")->count();

            $c[$i]["num_man"]= $count[$i];

            //计算每个车场距离这个服务地址的距离
            $distance[$i]=$this->count_distance_bd($c[$i]["lng_lat"],$b["coordinate"]);
            
            $c[$i]["distance"]= $distance[$i];
        }*/

   /* $sort = array(  
        'direction' => 'SORT_ASC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序  
        'field'     => 'distance',       //排序字段  
	);  
	$arrSort = array();  
	foreach($c AS $uniqid => $row){  
	    foreach($row AS $key=>$value){  
	        $arrSort[$key][$uniqid] = $value;  
	    }  
	}  
	

	if($sort['direction']){  
	    array_multisort($arrSort[$sort['field']], constant($sort['direction']), $c);  
	}  
 
        for($i_1=0;$i_1<count($c);$i_1++){
            //判断哪个车场被推荐   1：空闲司机人数不为零，2：服务地址最短
            if($c[$i_1]["num_man"]!=0){
                $c_1[$i_1]["recommended"]=$c[$i_1];//车场被推荐
            }
        }

     $c_1=array_values($c_1);

		$c_2=$c_1[0];*/

        $_POST["price"]=$this->price_build($distance=$b["distance"],$program_id=$_POST["program_id"],$price_id=$car_allcar["price_id"]);//推荐价格

		$_POST["distance"]=$b["distance"];
		
        if(M("car_order")->add($_POST)){
			$this->ajaxReturn(array('status'=>1,'msg'=>'提交成功','only_num'=>$_POST["only_num"]));
		}else{
			$this->ajaxReturn(array('status'=>-1,'msg'=>'提交失败'));
		}		
		
	}
	function build_order_n(){
		//price：价格、state （1：待分配，、2：待服务、3：服务完成，待付款，4：已付款 5：已取消）、car_id：车种id、extra_need_id：额外需求id car_allcar

		if(empty($_POST["online_code"])){
			//未登录状态
			$_POST["account"]=0;
		}else{
			//登录状态
			$arr=explode(",",$_POST["online_code"]);
			$_POST["account"]=$arr[0];
		}
		
		$_POST["state"]="1";
		$_POST["time_xd"]=time();
		$_POST["only_num"]=time().rand(111111,999999);
		$_POST["order_num"]="jt".time().rand(111111,999999); 
		//$_POST["order_num"]=0;
		//计算价格
        //车场位置列表(统计有效司机的人数)
        // 服务地址 fw_id
//      $b=M("car_address")->where("id='".$_POST["fw_id"]."'")->find();// coordinate  服务位置选择
//      $car_allcar=M("car_allcar")->where("id='".$_POST["car_id"]."'")->find();
//      $_POST["price"]=$this->price_build($distance=$b["distance"],$program_id=$_POST["program_id"],$price_id=$car_allcar["price_id"]);//推荐价格
//		$_POST["distance"]=$b["distance"];
		
        if(M("car_order")->add($_POST)){
			$this->ajaxReturn(array('status'=>1,'msg'=>'提交成功','order_num'=>$_POST["order_num"]));
		}else{
			$this->ajaxReturn(array('status'=>-1,'msg'=>'提交失败'));
		}		
		
	}
	//付款按钮
	function car_pay(){
		
		$date["only_num"]=$_GET["only_num"];
		$date["order_num"]="jt".time().rand(111111,999999);
		
		$a=M("car_order")->where("only_num='".$_GET["only_num"]."'")->find();
		$b=M("car_manerger")->where("account='".$a["account"]."'"."and program_id='".$a["program_id"]."'")->find();
	
		if($_GET["integral"]==1){
			if($b["state"]!=3){
				$this->ajaxReturn(array('status'=>-2,'msg'=>'非签约客户，不能使用积分支付'));
			}else{
				$integral=$b["integral_buy"]+$b["integral_song"];//当前积分 car_order
				
				if($integral<$a["price"]){
					$this->ajaxReturn(array('status'=>-3,'msg'=>'积分不足'));
				}
			}
		}
		if($_GET["integral"]==1){
			$date["pay_state"]=2;//积分支付
			$date["time_pay"]=time();
		}else{
			$date["pay_state"]=1;
		}
	
		if(M("car_order")->where("only_num='".$_GET["only_num"]."'")->save($date)){
		
			if($_GET["integral"]==1){
				//使用积分消费
			
				if($b["integral_song"]>$a["price"]  | $b["integral_song"]==$a["price"]){
					M("car_manerger")->where("account='".$a["account"]."'"."and program_id='".$a["program_id"]."'")->setInc('integral_song', -$a["price"]);
				
					$date0120["state"]="2";
					M("car_order")->where("only_num='".$_GET["only_num"]."'")->save($date0120);
				}else if($b["integral_song"]<$a["price"] ){
					$price_intergral=$a["price"]-$b["integral_song"];
					M("car_manerger")->where("account='".$a["account"]."'"."and program_id='".$a["program_id"]."'")->setInc('integral_buy', -$price_intergral);
					M("car_manerger")->where("account='".$a["account"]."'"."and program_id='".$a["program_id"]."'")->setInc('integral_buy', -$b["integral_song"]);
				
					$date0120["state"]="2";
					M("car_order")->where("only_num='".$_GET["only_num"]."'")->save($date0120);
				}
				
				$add0122["program_id"]=$a["program_id"];
				$add0122["account"]=$a["account"];
				$add0122["record"]=$a["price"];
				$add0122["time"]=time();
				$add0122["car_id"]=$a["car_id"];
				$add0122["order_num"]=$date["order_num"];
				M("jt03_zx_record_xf")->add($add0122);
				
				$this->ajaxReturn(array('status'=>1.1,'msg'=>'积分购买成功'));
			}else{
				$this->ajaxReturn(array('status'=>1,'msg'=>'成功，转向支付','order_num'=>$date["order_num"]));
			}
			
		}else{
			$this->ajaxReturn(array('status'=>-1,'msg'=>'失败'));
		}	
	}
	//付款按钮
	function car_pay_n(){
		
		$a=M("car_order")->where("order_num='".$_GET["order_num"]."'")->find();

		if($_GET["integral"]==1){
			if($a["account"]!=0){
			$b=M("car_manerger")->where("account='".$a["account"]."'"."and program_id='".$a["program_id"]."'")->find();
				
				if($b["state"]!=3){
					$this->ajaxReturn(array('status'=>-2,'msg'=>'非签约客户，不能使用积分支付'));
				}else{
					$integral=$b["integral_buy"]+$b["integral_song"];//当前积分 car_order
					
					if($integral<$a["price"]){
						$this->ajaxReturn(array('status'=>-3,'msg'=>'积分不足'));
					}
				}
			}else{
				$this->ajaxReturn(array('status'=>-2,'msg'=>'非签约客户，不能使用积分支付'));
			}
		}
		
		
		if($_GET["integral"]==1){
			$date["pay_state"]=2;//积分支付
			$date["time_pay"]=time();
			$date["time_choose_paystate"]=time();
		}else{
			$date["pay_state"]=1;
			$date["time_choose_paystate"]=time();
		}

		if(M("car_order")->where("order_num='".$_GET["order_num"]."'")->save($date)){
		
			if($_GET["integral"]==1){
				//使用积分消费
			
				if($b["integral_song"]>$a["price"]  | $b["integral_song"]==$a["price"]){
					M("car_manerger")->where("account='".$a["account"]."'"."and program_id='".$a["program_id"]."'")->setInc('integral_song', -$a["price"]);
				
					$date0120["state"]="2";
					M("car_order")->where("only_num='".$_GET["only_num"]."'")->save($date0120);
				}else if($b["integral_song"]<$a["price"] ){
					$price_intergral=$a["price"]-$b["integral_song"];
					M("car_manerger")->where("account='".$a["account"]."'"."and program_id='".$a["program_id"]."'")->setInc('integral_buy', -$price_intergral);
					M("car_manerger")->where("account='".$a["account"]."'"."and program_id='".$a["program_id"]."'")->setInc('integral_buy', -$b["integral_song"]);
				
					$date0120["state"]="2";
					M("car_order")->where("only_num='".$_GET["only_num"]."'")->save($date0120);
				}
				
				$add0122["program_id"]=$a["program_id"];
				$add0122["account"]=$a["account"];
				$add0122["record"]=$a["price"];
				$add0122["time"]=time();
				$add0122["car_id"]=$a["car_id"];
				$add0122["order_num"]=$date["order_num"];
				M("jt03_zx_record_xf")->add($add0122);
				
				$this->ajaxReturn(array('status'=>1.1,'msg'=>'积分购买成功'));
			}else{
				$this->ajaxReturn(array('status'=>1,'msg'=>'成功，转向支付','order_num'=>$_GET["order_num"]));
			}
			
		}else{
			$this->ajaxReturn(array('status'=>-1,'msg'=>'失败'));
		}	
	}
	
	//订单预览
	function order_preview(){
		if(empty($_GET["program_id"]) ){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		if(empty($_GET["online_code"])){
			//未登录状态
			$account=0;
		}else{
			//登录状态
			$arr=explode(",",$_GET["online_code"]);
			$account=$arr[0];
			
		$car_manerger=	M("car_manerger")->where("program_id='".$_GET["program_id"]."'"."and account='".$account."'")->find();
			
			if($car_manerger["state"]==3){
				$can_use_integral="1";
			}else{
				$can_use_integral="2";
			}
		}
	
		//判断全部车场对应车型的司机空闲人数

		//根据提交的位置坐标，计算和全部车场的距离，选择最短的
		$a=M("car_order")->where("only_num='".$_GET["only_num"]."'" ."and program_id='".$_GET["program_id"]."'")->find();

		//得到选择的成型id  进而得到价格id
        $car_allcar=M("car_allcar")->where("id='".$a["car_id"]."'")->find();
        //车型参数
        $a["canshu_name"]=explode(",",$car_allcar["canshu_name"]);
        $a["canshu_val"]=explode(",",$car_allcar["canshu_val"]);

        //车种图片
        $a["image"]=explode(",",$car_allcar["image"]);

		if(!empty($a["extra_need_id"])){
		//额外需求---改成订单备注 can_use_integral
		$where["id"]=array('in',$a["extra_need_id"]);
		
					//车种里程计算
		$d=M("store")->where("program_id='".$_GET["program_id"]."'")->find();
		$a["per_distance"]=$d["base_distance"];
		
		$a["extra_need"]=M("car_extra_need")->where($where)->select();
}
	
$a["can_use_integral"]=$can_use_integral;
        $this->ajaxReturn($a);
        }
        
       	//完成
	function wancheng(){
		$date["state"]		="2";
		$date["time_pay"]	=time();
		if(M("car_order")->where("order_num='".$_POST["order_num"]."'")->save($date)){
			$this->ajaxReturn(array('status'=>1,'msg'=>'成功'));
		}else{
			$this->ajaxReturn(array('status'=>-1,'msg'=>'失败'));
		}	
	}
	//订单列表
	function roder_list(){
		if(empty($_GET["program_id"]) ){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		if(empty($_GET["online_code"])  |$_GET["online_code"]=="false"){
			//未登录状态
			$account=0;
				if(!empty($_GET["state"])){
					$where["state"]=$_GET["state"];
				}
				$where["program_id"]=$_GET["program_id"];
				$where["openid"]=$_GET["openid"];
	
		}else{
			//登录状态
			$arr=explode(",",$_GET["online_code"]);
			$account=$arr[0];
			
				if(!empty($_GET["state"])){
					$where["state"]=$_GET["state"];
				}
				$where["program_id"]=$_GET["program_id"];
				$where["account"]=$account;
			
		}		
		$where["order_num"]=array("neq","0");
		$a=M("car_order")->field('id,order_num,state,car_id,driver_id_on,time_xd,time_tired,time_pay,time_done,time_pass,state_tuikuan,time_tuikuan')->where($where)->order("time_xd desc")->select();
	
		for($i=0;$i<count($a);$i++){
			//司机信息
			
			$b[$i]=M("car_manerger")->field('id,name,headimage,car_num')->where("id='".$a[$i]["driver_id_on"]."'")->find();
			$a[$i]["driver_info"]=$b[$i];
		
			//车型信息
			$c[$i]=M("car_allcar")->field('id,title')->where("id='".$a[$i]["car_id"]."'")->find();
			$a[$i]["car_info"]=$c[$i];
		}
			
		$this->ajaxReturn($a);
	} 
	
	//司机订单列表
	function driver_order_list(){
		if(empty($_GET["program_id"]) ){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		if(empty($_GET["online_code"])){
			//未登录状态
			$account=0;
				if(!empty($_GET["state"])){
					$where["state"]=$_GET["state"];
				}
				$where["program_id"]=$_GET["program_id"];
				$where["openid"]=$_GET["openid"];
	
		}else{
			//登录状态
			$arr=explode(",",$_GET["online_code"]);
			$account=$arr[0];
			
				if(!empty($_GET["state"])){
					$where["state"]=$_GET["state"];
				}
				$where["program_id"]=$_GET["program_id"];
				$where["account"]=$account;
			
		}
		
		$car_manerger=M("car_manerger")->where($where)->find();
		$a=M("car_order")->field('id,order_num,state,car_id,fw_id,driver_id_on,time_tired,time_pay,time_xd,time_done,time_pass,time_tuikuan')->where("driver_id_on='".$car_manerger["id"]."'")->select();

for($i=0;$i<count($a);$i++){
	//车型信息
			$c[$i]=M("car_allcar")->field('id,title')->where("id='".$a[$i]["car_id"]."'")->find();
			$a[$i]["car_info"]=$c[$i];
			
	//服务信息
		$d[$i]=M("car_address")->where("id='".$a[$i]["fw_id"]."'")->find();
		$a[$i]["server_info"]=$d[$i];	
		
}
			
		$this->ajaxReturn($a);
	}
	
	//订单取消接口
	function order_close(){
		$save["state"]="5";
		$save["time_pass"]=time();
		$save["order_pass_id"]=$_GET["order_pass_id"];
		$save["order_pass_text"]=$_GET["order_pass_text"];
		
		//判断这个订单之前付款了没
		$a=M("car_order")->where("order_num='".$_GET["order_num"]."'")->find();
		if($a["state"]==2 | $a["state"]==3){
				$save["state_tuikuan"]=2;//申请退款
			}
		if(M("car_order")->where("order_num='".$_GET["order_num"]."'")->save($save)){
			
			if($a["driver_id_on"]!=0){
				$save0118["server_state"]=0;//释放司机
				M("car_manerger")->where("id='".$a["driver_id_on"]."'")->save($save0118);
			}
			if($a["pay_state"]==2){
				//退回积分
				M("car_manerger")->where("account='".$a["account"]."'")->setInc("integral_song",$a["price"]);
			}
			$this->ajaxReturn(array("state" => 1, "msg" => "取消成功"));
		}else{
				$this->ajaxReturn(array("state" => -1, "msg" => "取消失败"));
		}
	}
	//订单详情
	function order_con(){
		if(empty($_GET["program_id"]) ){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		$a=M("car_order")->where("order_num='".$_GET["order_num"]."'")->find();
		
			//司机信息
			$b=M("car_manerger")->field('id,name,headimage,car_num,linktel')->where("id='".$a["driver_id_on"]."'")->find();
			$a["driver_info"]=$b;
			
			//车牌号信息
			$b_1=M("car_num")->where("driver_id='".$b["id"]."'")->find();
			$a["carnum_info"]=$b_1;
			
			//车型信息
			$c=M("car_allcar")->where("id='".$a["car_id"]."'")->find();
			$a["car_info"]=$c;
			
			//分类信息
			$c_1=M("car_fenlei")->where("id='".$c["fenlei_id"]."'")->find();
			$a["fenlei_info"]=$c_1;
			
			//出发地
			$d=M("car_parking")->where("id='".$b["parking_id"]."'")->find();
			$a["start_info"]=$d;
			
			//m目的地
			$e=M("car_address")->field('id,address,address_end_text,coordinate_start,coordinate_end,distance,linkman,tel')->where("id='".$a["fw_id"]."'")->find();
			$a["server_info"]=$e;
			
			//订单取消原因
			$where["id"]=array("in",$a["extra_need_id"]);
			$d=M("car_extra_need")->where($where)->select();
			$a["quxiao_info"]=$d;
			
			
		
			$this->ajaxReturn($a);	
	}
	
	//司机接单列表
	function get_order_list(){
		if(empty($_GET["program_id"]) & empty($_GET["online_code"])){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		if(empty($_GET["online_code"])){
			//未登录状态
				$account=0;
		}else{
			//登录状态
			$arr=explode(",",$_GET["online_code"]);
			
			$where["program_id"]=$_GET["program_id"];
			$where["account"]=$arr[0];
			$where["psw"]=$arr[1];
		}
		$a=M("car_manerger")->where($where)->find();
		if(empty($a)){
			$this->ajaxReturn(array("state" => -888, "msg" => "登录错误，请重新登录"));
		}
		
		$b=M("car_order")->where("is_get_driver=0 and driver_id_on='".$a["id"]."'")->select();

		$this->ajaxReturn($b);
	}
	
	//账号资料
	function account_con(){
		if(empty($_GET["program_id"]) & empty($_GET["online_code"])){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		if(empty($_GET["online_code"])){
			//未登录状态
				$account=0;
		}else{
			//登录状态
			$arr=explode(",",$_GET["online_code"]);
			
			$where["program_id"]=$_GET["program_id"];
			$where["account"]=$arr[0];
			$where["psw"]=$arr[1];
		}
		$a=M("car_manerger")->where($where)->find();
		$b=M("car_parking")->field('id,address')->where("program_id='".$_GET["program_id"]."'")->order("sort")->select();
		
		$z=array('k1'=>$a,'k2'=>$b);
		$this->ajaxReturn($z);
	}
	
	
	//价格明细
	function order_prict_con(){
		$a=M("car_order")->field("price,distance,car_id")->where("only_num='".$_GET["only_num"]."'"."and program_id='".$_GET["program_id"]."'")->find();
	
		//车种
		$b=M("car_allcar")->field('title,price_id')->where("id='".$a["car_id"]."'")->find();
	
		//收费标准
		$c=M("car_charges")->where("id='".$b["price_id"]."'")->find();
		
						//车种里程计算
		$d=M("store")->where("program_id='".$_GET["program_id"]."'")->find();
		$c["per_distance"]=$d["base_distance"];
		
		$z=array('k1'=>$a,'k2'=>$b,'k3'=>$c);
		$this->ajaxReturn($z);
	}
	
		//积分充值提交
	function integral_submit(){
		//积分充值点击按钮必须先来这个借口，在积分充值记录表添加数据，然后直接跳转到微信充值接口
		if(empty($_POST["online_code"])){
			//未登录状态
				$this->ajaxReturn(array('status'=>-88,'msg'=>'登录状态错误'));
		}else{
			//登录状态
			$arr=explode(",",$_POST["online_code"]);
			$date["account"]=$arr[0];
			//$date["psw"]=$arr[1];
		}

		$date["state"]="1";
		$date["time"]=time();
		$date["program_id"]=$_POST["program_id"];
		$date["openid"]=$_POST["openid"];
//		$date["order_num"]=$_POST["order_num"];
		$date["order_num"]="JT".date("YmdHis",time()).rand(111111,999999);
		$date["price"]=$_POST["price"];
		$date["record"]=$_POST["record"];
		
		if(M("jt03_zx_record_cz")->add($date)){
				$data=array('status'=>1,'msg'=>'订单创建成功，跳转到支付接口','order_num'=>$date["order_num"],'price'=>$_POST["price"]);
	     	}else{
	     		$data=array('status'=>2,'msg'=>'订单创建失败，原地不动');
	     	} 	
		$this->ajaxReturn($data);
	}
	    //积分充值记录查看
    function integral_cz_search(){
    	//需要小程序id 、个人openid
    	if(empty($_POST["online_code"])){
			//未登录状态
				$this->ajaxReturn(array('status'=>-88,'msg'=>'登录状态错误'));
		}else{
			//登录状态
			$arr=explode(",",$_POST["online_code"]);
			$date["account"]=$arr[0];
			//$date["psw"]=$arr[1];
		}
    $members=M("car_manerger")->where("account='".$date["account"]."'"." and program_id='".$_POST["program_id"]."'")->find();	
    	$totla=$members["integral_buy"]+$members["integral_song"];
    	
    $integral_search=M("jt03_zx_record_cz")
    ->where("state=2 and account='".$date["account"]."'"." and program_id='".$_POST["program_id"]."'")
    ->order("time desc")
    ->select();
   
   $z=array('k1'=>$totla,'k2'=>$integral_search);
  	 $this->ajaxReturn($z);
   
    }
    
    //积分消费记录查看
    function integral_xf(){
    	if(empty($_POST["online_code"])){
			//未登录状态
				$this->ajaxReturn(array('status'=>-88,'msg'=>'登录状态错误'));
		}else{
			//登录状态
			$arr=explode(",",$_POST["online_code"]);
			$date["account"]=$arr[0];
		
		}
		  $integral_xf=M("jt03_zx_record_xf")
    ->where("account='".$date["account"]."'"." and program_id='".$_POST["program_id"]."'")
    ->order("time desc")
    ->select();
    
    for($i=0;$i<count($integral_xf);$i++){
    	//订单详情
    	$car_order[$i]=M("car_order")->where("order_num='".$integral_xf[$i]["order_num"]."'")->find();
    	
    	//车型信息
    	$car_allcar[$i]=M("car_allcar")->where("id='".$car_order[$i]["car_id"]."'")->find();
    	$integral_xf[$i]["car_info"]=$car_allcar[$i];
    	//价格信息
    	$car_charges[$i]=M("car_charges")->where("id='".$car_allcar[$i]["price_id"]."'")->find();
    	$integral_xf[$i]["price_info"]=$car_charges[$i];
    	//服务地信息
    	$car_address[$i]=M("car_address")->where("id='".$car_order[$i]["fw_id"]."'")->find();
    	$integral_xf[$i]["server_info"]=$car_address[$i];
    }
    
     	 $this->ajaxReturn($integral_xf);
    }
    
	//积分充值完成
	function integral_wancheng(){
		if(empty($_POST["order_num"])){
			//未登录状态
				$this->ajaxReturn(array('status'=>-88,'msg'=>'参数错误'));
		}
		$date["state"]="2";
		
		//查询积分充值比例
		$a=M("store")
		->field("store.integral_proportion,store.program_id,jt03_zx_record_cz.openid,jt03_zx_record_cz.account,jt03_zx_record_cz.price")
		->join('left join jt03_zx_record_cz ON jt03_zx_record_cz.program_id=store.program_id')
		->where("jt03_zx_record_cz.order_num='".$_POST["order_num"]."'")
		->find();	

//DUMP($a);dump($a["integral_proportion"]*$a["price"]);DIE;
		if(M("jt03_zx_record_cz")->where("order_num='".$_POST["order_num"]."'")->save($date)){
			//付款完成就往个人的位置添加比例积分
			M("car_manerger")->where("account='".$a["account"]."'"."and program_id='".$a["program_id"]."'")->setInc('integral_buy',$a["integral_proportion"]*$a["price"]);
			$this->ajaxReturn(array('status'=>1,'msg'=>'成功'));
		}else{
			$this->ajaxReturn(array('status'=>-1,'msg'=>'失败'));
		}
	}
	
	
	//资料绑定接口
	function info_tied(){
		//后台录了资料，手机端使用绑定码，可以快捷将openid 等信息绑定到对应的资料上，完成资料共享
		
		if(empty($_POST["program_id"]) ){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		$where["program_id"]=$_POST["program_id"];
		$where["code_tied"]=$_POST["code_tied"];
		$a=M("car_manerger")->where($where)->find();
	
		$b=M("car_manerger")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'")->find();
		
		if(!empty($b)){
			$this->ajaxReturn(array("state" => -777, "msg" => "绑定失败，该温馨号已有注册信息"));
		}
		if($a["is_tired"]==1){
			$this->ajaxReturn(array('status'=>-888,'msg'=>'资料已经被绑定了'));
		}else{
			$save["openid"]=$_POST["openid"];
			$save["state_register"]=2;
			$save["state"]=1;
			$save["program_id"]=$_POST["program_id"];
			$save["account"]=$_POST["openid"].$_POST["program_id"];
			$save["psw"]=md5($_POST["openid"].$_POST["program_id"]);
			$save["is_tired"]=1;


			$online_code=$save["account"].",".$save["psw"];

			if(M("car_manerger")->where("id='".$a["id"]."'")->save($save)){
				$this->ajaxReturn(array('status'=>1,'msg'=>'绑定成功','online_code'=>$online_code));
			}else{
				$this->ajaxReturn(array('status'=>-1,'msg'=>'绑定失败'));
			}
			
		}
	}
	
	//确认订单
	function order_done(){
		$save["state"]="4";
		$save["time_done"]=time();
		$a=M("car_order")->field("id,driver_id_on")->where("order_num='".$_GET["order_num"]."'")->find();
		//$b=M("car_manerger")->where("id='".$a["driver_id_on"]."'")->find();
		$save02["server_state"]=0;
		if(M("car_order")->where("order_num='".$_GET["order_num"]."'")->save($save)){
			M("car_manerger")->where("id='".$a["driver_id_on"]."'")->save($save02);
				$this->ajaxReturn(array('status'=>1,'msg'=>'成功'));
			}else{
				$this->ajaxReturn(array('status'=>-1,'msg'=>'失败'));
			}
	}
        
}
?>