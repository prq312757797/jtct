<?php
namespace HProgram\Controller;
use Think\Controller;
header('content-type:application:json;charset=utf8'); 
header('Access-Control-Allow-Origin:*'); 
//header('Access-Control-Allow-Methods:POST'); 
header('Access-Control-Allow-Headers:x-requested-with,content-type');


class DshController extends Controller {

	function dsh_chech_pay(){
		$a=M("h_admin")->field("is_on_charge_dsh,charge_dsh")->where("program_id='".$_GET["program_id"]."'")->find();
		if($a["is_on_charge_dsh"]==1){

			$date["state"]=1;
			$date["price"]=$a["charge_dsh"];
		}else{
			$date["state"]=2;
			$date["price"]=null;
		}
		$this->ajaxReturn($date);
	}
	
//	添加商户
	public function dsh_add(){

	
		if(empty($_POST["program_id"]) | empty($_POST["openid"])){
			$this->ajaxReturn(array('status'=>0,'msg'=>'缺少参数'));
		}
		
		$_POST["time_register"]=time();
		$_POST["state"]=1;
		
		if(M("h_user_info_dsh")->add($_POST)){
			$date=array('status'=>1,'msg'=>'审核提交成功');
		}else{
			$date=array('status'=>-1,'msg'=>'审核提交失败');
		}
		$this->ajaxReturn($date);
	}
	
//	商户列表
	function dsh_list(){
		if(empty($_GET["program_id"]) | empty($_GET["openid"])){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		
		$where["program_id"]=$_GET["program_id"];
		$where["openid"]	=$_GET["openid"];

		
		$sql  =" SELECT * FROM h_user_info_dsh ";
		$sql .=" WHERE program_id ='".$_GET["program_id"]."'";
		$sql .=" and openid ='".$_GET['openid']."'";
		$a = M("h_user_info_dsh") -> query($sql);

		$this->ajaxReturn($a);
	}
	/*-------------------------------------------海龙---------------------------------------------------------------*/

	public function dsh_index(){
		
	//需要小程序id，  子商户id

	$field00='user_info_dsh.id as dsj_id,user_info_dsh.sh_name as dsh_name,user_info_dsh.logo as dsh_logo,detailed_introduction';
	$a0=M("user_info_dsh")
	->field($field00)
	->where("user_info_dsh.program_id='".$_GET["program_id"]."'"." and user_info_dsh.id='".$_GET["id"]."'")
	->find();

	$field='
		goods.id as goods_g_id,image,goods.goods_title,goods.dsh_id,goods.price_sell,goods.goods_state,goods.price_own
		
	';

	$a1=M("goods")
	//	->field($field)
	//	->join('left join goods ON goods.dsh_id=user_info_dsh.id')
	//	->join('left join goods_img ON goods_img.goods_id=goods.id')
		->where("goods_state=1 and dsh_id='".$a0["dsj_id"]."'"." and program_id='".$_GET["program_id"]."'")
		->select();
		for($i=0;$i<count($a1);$i++){
			$arr1102=explode(",",$a1[$i]['image']);
			$a1[$i]["goods_img"]=$arr1102[0];
		}
	//商品收藏数
	for($i75_1=0;$i75_1<count($a1);$i75_1++){
		$arr_goods_id[]=$a1[$i75_1];
	}
	
//	$b=M("collection")->where("goods_id='".$a["goods_g_id"]."'")->count();	
	$b=0;
	$all_collection=M("collection")->where("program_id='".$_GET	["program_id"]."'")->select();	
	for($i75_2=0;$i75_2<count($all_collection);$i75_2++){
		
		$b+=in_array($all_collection[$i75_2]["goods_id"],$arr_goods_id)?"1":"0";
	}
	//商品总销量数
	$where_order["goods_id"]=$a["goods_g_id"];
	$where_order["order_num"]=array('neq','0');
	
	$order=M("order")->field("goods_id,order_num,buy_num")->where($where_order)->select();	
	for($i=0;$i<count($order);$i++){
		
	$where_done=M("order_form")->where("order_num='".$order[$i]["order_num"]."'")->find();
		if($where_done["state"]!="0"){
			$order01[]=$order[$i]["order_num"];
		}
	}
	
	$c=array_sum($order01);
	if(empty($c)){
		$c=0;
	}
	$d=M("store")->field('xieyi_con')->where("program_id='".$_GET["program_id"]."'")->find();
	
	$data=array('k1_1'=> $a0,'k1_2'=> $a1,'k2'=>$b,'k3'=>$c,'k4'=>$d);
//	dump($data);die;
	$this->ajaxReturn($data);
	}

//服务版版那个样子的多商户主页参数接口    （不同页面参数不一样了）

	function dsh_fu_index(){
		//需要program_id、dsh_id  手机坐标 sh_phone
		
		//商户基本信息
		$field00='id,sh_phone,sh_name,tel,fl_id,logo,province,city,district,linkman,main_project,detail_address,payment_method_id,sh_jd,sh_video,sh_image,is_use_video,detailed_introduction';
		$a0=M("user_info_dsh")
		->field($field00)
		->where("program_id='".$_GET["program_id"]."'"." and id='".$_GET["id"]."'"." and program_id='".$_GET["program_id"]."'")
		->find();
		
	

			$arr_pay=explode(",",$a0["payment_method_id"]);	
		//支付方式显示 detailed_introduction
		for($k=0;$k<count($arr_pay);$k++){
			$arr_pay_name[$k]=M("payment_method_dsh")->field('title')->where("id='".$arr_pay[$k]."'")->find();
		}
		for($r=0;$r<count($arr_pay_name);$r++){
			$str_pay_name.=$arr_pay_name[$r]["title"].",";
		}

		$str_pay_name = substr($str_pay_name,0,strlen($str_pay_name)-1); //去掉最后一个逗号

		$arr_pay_name=explode(",",$str_pay_name);
		$str_pay_name=implode(" ",$arr_pay_name);
		$a0["str_pay_name"]=$str_pay_name;
		
		
		
	$field='
	goods_title,id,price_sell,price_own,sell_num,image
	';
	if(empty($_GET["id"])){
		$_GET["id"]="9";
	}
	//商户商品信息
		$a1=M("goods")
		->field($field)
		->where("goods_state=1 and dsh_id='".$_GET["id"]."'")->select();
		
		for($i=0;$i<count($a1);$i++){
			$arr1102=explode(",",$a1[$i]['image']);
			$a1[$i]["goods_img"]=$arr1102[0];
			
		}

		//子商户商品统计
		$b=count($a1);
		
/*	
//推荐服务--得到现在的服务的分类，然后找到数据库里面有商品数据的其他分类的服务
	$attribute=	M("attribute")->where("is_show=1 and program_id='".$_GET["program_id"]."'")->select();
	
	for($i=0;$i<count($attribute);$i++){
		$arr[$i]=$attribute[$i]["id"];
	}
	$arr_str=implode(",",$arr);
	$arr_str=substr($arr_str,0,strlen($arr_str)-1);
	
	$where["fl_id"]=array("in",$arr_str);
	$where["program_id"]=$_GET["program_id"];
	$where["state"]="3";
	
	$user_info_dsh=M("user_info_dsh")->where($where)->select();

	for($i02=0;$i02<count($user_info_dsh);$i02++){
		$arr02[$i]=$attribute[$i02]["id"];
	}	
	
	M("goods")	*/
		
	//k1 商户基本信息		k2 商户商品信息		k3 子商户商品统计
	$data=array('k1'=> $a0,'k2'=> $a1,'k3'=> $b);
	//dump($data);die;
	$this->ajaxReturn($data);	
	}





	
	//子商户资格购买下单接口
	function dsh_build_order(){
		
		$date["order_num"]="JT".date("YmdHis",time()).rand(111111,999999);
		$date["pay_state"]="1";
		$date["state"]="1";
		$date["time_xd"]=time();
		
		$date["program_id"]=$_POST["program_id"];
		$date["openid"]=$_POST["openid"];
		$adds["title"]=$_POST["program_id"];
		$adds["name"]=$_POST["openid"];
		M("test")->add($adds);
		if(M("record_total")->add($date)){
			$this->ajaxReturn(array('status'=>1,'msg'=>'下单成功，可以带订单号去访问支付接口','order_num'=>$date["order_num"]));
		}else{
			$this->ajaxReturn(array('status'=>-1,'msg'=>'下单失败'));
		}
		
	}
	//确认提交了资料
	function sure_submit_data(){
		$save["is_submit_data"]="1";
		$save["submit_data_time"]=time();
		M("record_total")->where("order_num='".$_POST["order_num"]."'")->save($save);
	}
	
	//店铺简介
	public function profile(){
		//需要小程序id，子商户id
		$date=M("user_info_dsh")
		->field('sh_name,logo,introduce,sh_phone,detail_address,sh_jd,detail_address')
		->where("id='".$_GET["id"]."'")
		->find();
		$date[]=$date;
		$this->ajaxReturn($date);
	}
	
	//推荐商品
	public function dsh_tj(){
		//需要得到小程序id，多商户id，商品推荐属性
		$field='	
				goods.id as goods_g_id,goods.goods_title,goods.dsh_id,goods.price_sell,goods.goods_state,goods.price_own	
			';
		$where=array(
		'program_id'=>$_GET["program_id"],
		'dsh_id'=>$_GET["dsh_id"],
		'goods_subtitle03'=>"1",
		'goods_state'=>"1",
		);
		$goods=M('goods')
	//	->field($field)
		->where($where)->select();
		
		for($i=0;$i<count($goods);$i++){
			
		/*	$id["goods_id"]=$goods[$i]['id'];
			$dd=M("goods_img")->field('image')->where($id)->order("time_set")->find();//得到对应商品第一张图片
			$goods[$i]["image_first"]=$dd["image"];*/
			
			$arr1102=explode(",",$goods[$i]['image']);
			$goods[$i]["image_first"]=$arr1102[0];
		}
		$this->ajaxReturn($goods);
	}
	//新品商品
	public function dsh_xp(){
		//需要得到小程序id，多商户id，商品推荐属性
		$field='	
				goods.id as goods_g_id,goods.goods_title,goods.dsh_id,goods.price_sell,goods.goods_state,goods.price_own	
			';
		$where=array(
		'program_id'=>$_GET["program_id"],
		'dsh_id'=>$_GET["dsh_id"],
		'goods_subtitle02'=>"1",
		'goods_state'=>"1",
		);
		$goods=M('goods')
		//->field($field)
		->where($where)->select();
		
		for($i=0;$i<count($goods);$i++){
			
		/*	$id["goods_id"]=$goods[$i]['id'];
			$dd=M("goods_img")->field('image')->where($id)->order("time_set")->find();//得到对应商品第一张图片
			$goods[$i]["image_first"]=$dd["image"];*/
			
			$arr1102=explode(",",$goods[$i]['image']);
			$goods[$i]["image_first"]=$arr1102[0];
			
		}
		$this->ajaxReturn($goods);
	}
	//小程序多店铺入驻协议----单独的
	public function xieyi(){
		//需要小城id，得到协议标题和内容
		$a=M("store")->field('xieyi_con')->where("program_id='".$_GET["program_id"]."'")->find();
		$this->ajaxReturn($a);
	}
	//多商户地理位置距离计算接口
	//计算两个坐标的经纬度
	
	
	
	function getDistance($lat1, $lng1, $lat2, $lng2) { 
		$earthRadius = 6367000; //approximate radius of earth in meters 
		
		$lat1 = ($lat1 * pi() ) / 180; 
		$lng1 = ($lng1 * pi() ) / 180; 
		 
		$lat2 = ($lat2 * pi() ) / 180; 
		$lng2 = ($lng2 * pi() ) / 180; 
		 
		$calcLongitude = $lng2 - $lng1; 
		$calcLatitude = $lat2 - $lat1; 
		$stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2); 
		$stepTwo = 2 * asin(min(1, sqrt($stepOne))); 
		$calculatedDistance = $earthRadius * $stepTwo; 
		 
		return round($calculatedDistance); 
	} 
	
	function testdistance(){
		$a=$this->getDistance($lat1="22.821757", $lng1="113.790894", $lat2="23.200961", $lng2="113.027344");
		dump($a);
	}
	
	//添加评论接口
function discuss_add(){

	if(empty($_POST["program_id"]) | empty($_POST["openid"])){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
	
	$where["program_id"]=$_POST["program_id"];
	$where["openid"]=$_POST["openid"];

	$where["time_set"]=time();
	$where["content"]=$_POST["content"];
	
	if($_POST["discuss_state"]==1){
			$where["info_id"]=$_POST["info_id"];
	}else if($_POST["discuss_state"]==2){
		$where["goods_id"]=$_POST["goods_id"];
	}else if($_POST["discuss_state"]==3){
		$where["dsh_id"]=$_POST["dsh_id"];
	}
	

	if(M("discuss")->add($where)){
	
			$date=array('state'=>1,'msg'=>'评论成功 ');
		}else{
			$date=array('state'=>-1,'msg'=>'评论失败 ');
		}
	$this->ajaxReturn($date);
}
function discuss_star(){
	$where["program_id"]		=$_POST["program_id"];
	$where["openid"]			=$_POST["openid"];
	$where["time_set"]			=time();
	$where["star"]				=$_POST["key"];
	
	
	$where01["program_id"]		=$_POST["program_id"];
	$where01["openid"]			=$_POST["openid"];
	if(empty($_POST["order_num"])){
		$where["dsh_id"]		=$_POST["dsh_id"];
		$where01["dsh_id"]		=$_POST["dsh_id"];
	}else{
		$where["order_num"]		=$_POST["order_num"];
		$where01["order_num"]	=$_POST["order_num"];
	}
	
	$a=M("discuss")->where($where01)->find();
	if(!empty($a)){
		$date=array('state'=>-2,'msg'=>'已经评星过了 ');
	}else{
		if(M("discuss")->add($where)){
			$date=array('state'=>1,'msg'=>'评星成功 ');
		}else{
			$date=array('state'=>-1,'msg'=>'评星失败 ');
		}
	}
		
	$this->ajaxReturn($date);
}

//评论删除
function  discuss_delete(){
	if(M("discuss")->where("id='".$_POST["info_id"]."'")->delete()){
			$date=array('state'=>1.0,'msg'=>'评论删除成功 ');
		}else{
			$date=array('state'=>-1.0,'msg'=>'评论删除失败 ');
		}
	$this->ajaxReturn($date);
   }
	//子商户评论接口
	function dsh_discuss(){
			//评论
	$discuss=M("discuss")->where("program_id='".$_POST["program_id"]."'"." and dsh_id='".$_POST["dsh_id"]."'")->order("time_set desc")->select();
	
	for($i=0;$i<count($discuss);$i++){
		$where["openid"]=$discuss[$i]["openid"];

		$a=M("members")->where($where)->find();

		$discuss[$i]["discuss_head"]=$a["head"];
		$discuss[$i]["discuss_nickname"]=$a["nickname"];
		
		
	}
	
	$this->ajaxReturn($discuss);
	}
	
	//子商户活动接口
	function dsh_artical(){
		$a=M("artical_dsh")->where("dsh_id='".$_GET["dsh_id"]."'"."and program_id='".$_GET["program_id"]."'")->order("time_set desc")->select();
	
		$this->ajaxReturn($a);
	}
	
	//子商户最新促销（纯文章展示）
	function dsh_artical_con(){
		$a=M("artical_dsh")->where("dsh_id='".$_GET["dsh_id"]."'"."and program_id='".$_GET["program_id"]."'")->order("time_set desc")->find();
	
		$this->ajaxReturn($a);
	}
	
	function check_registe(){
		
		$where["program_id"]=$_GET["program_id"];
		$where["openid"]	=$_GET["openid"];
		$where["state"]		=array('neq',4);
		
		$a=M("user_info_dsh")->where($where)->find();

		if(empty($a)){
			$data=array("state"=>1,"msg"=>"未进行申请，可以申请");
		}else{
			if($a["state"]==1){
				$data=array("state"=>-1,"msg"=>"待审核");
			}else if($a["state"]==5){
				$data=array("state"=>-2,"msg"=>"上级禁止");
			}else if($a["state"]==6){
				$data=array("state"=>-3,"msg"=>"服务到期禁止");
			}
		}
		
		$this->ajaxReturn($data);
	}
	

	function dsh_all_list(){
		if(empty($_GET["program_id"])){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}

		$field="id,sh_name,time_register,state,time_register_sayno,logo";
		
		$sql  =" SELECT ".$field." FROM user_info_dsh ";
		$sql .=" WHERE program_id ='".$_GET["program_id"]."'";
		$sql .=" and state =3 ";
		$sql .=" order sort asc ";
		$a = M("user_info_dsh") -> query($sql);

		$this->ajaxReturn($a);
	}
	function check_dsh_info(){    
		$a=M("user_info_dsh")->field('sh_name')->where("program_id='".$_GET["program_id"]."'"."and id='".$_GET["id"]."'")->find();
	
		$this->ajaxReturn($a);
	}
	
	function assistant_list(){
	$field='
		assistant_add.id,assistant_add.name,assistant_add.tel,assistant_add.time_registe,time_stop,assistant_add.time_agree,assistant_add.shop_id,assistant_add.state,
		user_info_dsh.sh_name
	';
	$order_form=M("assistant_add")
	->field($field)
	->join('left join user_info_dsh ON user_info_dsh.id=assistant_add.shop_id')
	->where("user_info_dsh.program_id='".$_GET["program_id"]."'"."and user_info_dsh.openid='".$_GET["openid"]."'")
	->select();

	$this->ajaxReturn($order_form);
	}
	function assistant_listktv(){
	$field='
		assistant_add.id,assistant_add.name,assistant_add.tel,assistant_add.time_registe,
		time_stop,assistant_add.time_agree,assistant_add.shop_id,assistant_add.state

	';
	$order_form=M("assistant_add")
	->field($field)
	->where("assistant_add.program_id='".$_GET["program_id"]."'")
	->select();

	$this->ajaxReturn($order_form);
	}
	function assistant_say_yes(){
		if($_GET["state"]=="yes"){
			$save["state"]=1;
			$save["time_agree"]=time();
		}else if($_GET["state"]=="no"){
			$save["state"]=2;
			$save["time_say_no"]=time();
		}else if($_GET["state"]=="stop"){
			$save["state"]=3;
			$save["time_stop"]=time();
		}else if($_GET["state"]=="return"){
			$save["state"]=1;
		}
		if(M("assistant_add")->where("program_id='".$_GET["program_id"]."'"." and id='".$_GET["id"]."'")->save($save)){
			$data=array("state"=>1,"msg"=>"操作成功");
		}else{
			$data=array("state"=>-1,"msg"=>"操作失败");
		}
		$this->ajaxReturn($data);
	}
	/**
	 * 添加店员二维码
	 * */
	function assistant_add_code(){
		
		$a=M("user_info_dsh")->field("qcode_assistant")->where("program_id='".$_GET["program_id"]."'"."and id='".$_GET["dsh_id"]."'")->find();
		if(empty($a["qcode_assistant"])){
			$qdcode = A('Qdcode');
        	$b=$qdcode->qd_code_dsh_assistant($program_id=$_GET["program_id"],$dsh_id=$_GET["dsh_id"]);
        	$img=$b["qcode_assistant"];
		}else{
			$img=$a["qcode_assistant"];
		}
		$this->ajaxReturn($img);
	}
	
		/**
	 * 添加店员二维码
	 * */
	function assistant_add_codektv(){
		
		$a=M("store")->field("qcode_assistant")->where("program_id='".$_GET["program_id"]."'")->find();
		if(empty($a["qcode_assistant"])){
			$qdcode = A('Qdcode');
        	$b=$qdcode->qd_code_dsh_assistantktv($program_id=$_GET["program_id"]);
        	$img=$b["qcode_assistant"];
		}else{
			$img=$a["qcode_assistant"];
		}
		$this->ajaxReturn($img);
	}
	/**
	 * 店员设置消费金额页面
	 * 展示店员姓名电话，商户名称
	 * */
	function set_charge(){
		$a=M("assistant_add")->field("name,tel,shop_id")->where("openid='".$_GET["openid"]."'"."and program_id='".$_GET["program_id"]."'")->find();
		$b=M("user_info_dsh")->field("sh_name,logo")->where("id='".$a["shop_id"]."'")->find();
		$a["sh_name"]	=$b["sh_name"];
		$a["logo"]		=$b["logo"];
		$this->ajaxReturn($a);
	}
	
	
	/**
	 * 店员展示消费二维码前生成订单
	 * */
	function order_build_adcode(){
		
		$a=M("assistant_add")->field("name,tel")->where("openid='".$_GET["openid"]."'"."and program_id='".$_GET["program_id"]."'")->find();
	
		
		$add["openid_ass"]	=$_GET["openid"];
		$add["program_id"]	=$_GET["program_id"];
		$add["time_set"]	=time();
		$add["order_price"]	=$_GET["order_price"];
		$add["on_assname"]	=$a["name"];
		$add["on_asstel"]	=$a["tel"];
		
		$add["order_num"]	="JT".date("YmdHis",time()).rand(111111,999999);
		if(M("dsh_qdcode_chage")->add($add)){
			$data=array("state"=>1,"msg"=>"下单成功","order_num"=>$add["order_num"]);
		}else{
			$data=array("state"=>-1,"msg"=>"下单失败");
		}
		$this->ajaxReturn($data);
	}
	
	/**
	 * 客户扫码进入支付页面，确认支付信息
	 * 店名、下单时间、金额、店员姓名、联系方式
	 * */
	function pageshow_cus_pay(){

		$field="
		dsh_qdcode_chage.state,dsh_qdcode_chage.time_pay,dsh_qdcode_chage.order_num,dsh_qdcode_chage.order_price,
		user_info_dsh.sh_name,user_info_dsh.logo,
		assistant_add.name,assistant_add.tel
		";
		$a=M("dsh_qdcode_chage")->field($field)
		->join("left join assistant_add on assistant_add.openid=dsh_qdcode_chage.openid_ass")
		->join("left join user_info_dsh on user_info_dsh.id=assistant_add.shop_id")
    	->where("dsh_qdcode_chage.order_num='".$_POST["order_num"]."'"." and dsh_qdcode_chage.program_id='".$_POST["program_id"]."'")
   		->order("time_pay desc")
    	->find();		

		$b=M("members")->field("integral")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'")->find();
		$a["integral"]=$b["integral"];
		
  	 	$this->ajaxReturn($a);
	}
	
	/**
	 * 客户扫码点击确认支付
	 * */
	function page_cus_payed(){
		$a=M("dsh_qdcode_chage")->field("dsh_qdcode_chage.state,dsh_qdcode_chage.order_price,assistant_add.shop_id")
		->join("left join assistant_add on assistant_add.openid=dsh_qdcode_chage.openid_ass")
		->where("dsh_qdcode_chage.order_num='".$_POST["order_num"]."'")->find();
		
		if($a["state"]==1){
			$data=array("state"=>-1,"msg"=>"支付失败，勿重复支付");
		}
		
		$b=M("members")->field("integral")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'")->find();
		if($b["integral"]<$a["order_price"]){
			$data=array("state"=>-2,"msg"=>"支付失败，余额不足");
		}
		
		$save["openid_cus"]	=$_POST["openid"];
		$save["time_pay"]	=time();
		$save["state"]		=1;
		$save["shop_id"]	=$a["shop_id"];
		
		if(M("dsh_qdcode_chage")->where("order_num='".$_POST["order_num"]."'")->save($save)){
			M("members")->field("integral")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'")->setInc("integral",-$a["order_price"]);
			$data=array("state"=>1,"msg"=>"支付成功");
		}else{
			$data=array("state"=>-3,"msg"=>"支付失败，系统错误");
		}
		$this->ajaxReturn($data);
	}

	/**
	 * 判断是否支付成功
	 * */
	function check_pay(){
		$a=M("dsh_qdcode_chage")->field("state")->where("program_id='".$_GET["program_id"]."'"."and order_num='".$_GET["order_num"]."'")->find();
		if($a["state"]==1){
			$data=array("state"=>1,"msg"=>"支付完成");
		}else{
			$data=array("state"=>-1,"msg"=>"支付失败");
		}
		$this->ajaxReturn($data);
	}

	/**
	 * 子商户消费查询
	 * */
	
	function dsh_xf_search(){
		$field="dsh_qdcode_chage.state,dsh_qdcode_chage.time_pay,dsh_qdcode_chage.order_price,dsh_qdcode_chage.order_num,
		user_info_dsh.sh_name,	
		(case when discuss.star then discuss.star else 0 end) as star
		
		";
		$integral_search=M("dsh_qdcode_chage")->field($field)
		->join("left join user_info_dsh on user_info_dsh.id=dsh_qdcode_chage.shop_id")
		->join("left join discuss on discuss.order_num=dsh_qdcode_chage.order_num")
    	->where("dsh_qdcode_chage.state=1 and dsh_qdcode_chage.openid_cus='".$_POST["openid"]."'"." and dsh_qdcode_chage.program_id='".$_POST["program_id"]."'")
   		->order("dsh_qdcode_chage.time_pay desc")
    	->select();		

  	 	$this->ajaxReturn($integral_search);
	}
	
	/**
	 * 店员订单列表
	 * */
	
	function assistant_order_list(){
		$a=M("dsh_qdcode_chage")->field("order_num,order_price,time_set,time_pay")
		->where("state='".$_POST["state"]."'"." and program_id='".$_POST["program_id"]."'"."and openid_ass='".$_POST["openid"]."'")
		->order("time_set desc")->select();
		$this->ajaxReturn($a);
	}
	
	/**
	 * 店员资料编辑页面
	 * */
	function assistant_edit(){	
		$a=M("assistant_add")->field("name,tel")->where("openid='".$_GET["openid"]."'"."and program_id='".$_GET["program_id"]."'")->find();
		$this->ajaxReturn($a);
	}
	/**
	 * 店员资料编辑提交
	 * */
	function run_assistant_edit(){
		
		$save["name"]	=$_POST["name"];
		$save["tel"]	=$_POST["tel"];
		if(M("assistant_add")->where("openid='".$_POST["openid"]."'"."and program_id='".$_POST["program_id"]."'")->save($save)){
			$data=array("state"=>1,"msg"=>"操作成功");
		}else{
			$data=array("state"=>-1,"msg"=>"操作失败");
		}
		$this->ajaxReturn($data);
	}
	/**
	 * 多商户列表页
	 * */
	
	function dshall_list(){
//		$_GET['str']="餐厅";
		

		$sql  =" SELECT id,detail_address,logo,sh_name,sh_jd FROM user_info_dsh ";
		$sql .=" WHERE state=3 and program_id ='".$_GET['program_id']."'";

		if($_GET['str']){
			$_GET['str']="%".$_GET['str']."%";
			$sql .=" and sh_name like'".$_GET['str']."'";
		}
		$sql .=" order by sort asc";
		$info = M("user_info_dsh") -> query($sql);
		dump($sql); dump($info);die;
	}
	
//	百业联盟 查询子商户剩余发放消费券

	function check_dsh_coupon(){
		$data=M("user_info_dsh")->field("coupon_dsh_num")->where("program_id='".$_GET["program_id"]."'"."and id='".$_GET["dsh_id"]."'")->find();
		$this->ajaxReturn($data);
	}
//查询消费券领取使用记录
 	function check_dsh_coupon_record(){
 		$list=M("coupon_dsh_record")->where("get_state=1 and dsh_id='".$_GET["dsh_id"]."'"."and program_id='".$_GET["program_id"]."'")->order("time_get desc")->select();
 		
 		$this->ajaxReturn($list);
 	}
 	
// 	建立消费券信息（未领取）
	function build_coupon(){
		$add["program_id"]	=$_POST["program_id"];
		$add["dsh_id"]		=$_POST["dsh_id"];
		$add["state"]		="0";
		$add["get_state"]	="0";
		$add["time_set"]	=time();
		$add["openid_send"]	=$_POST["openid"];
		$add["coupon_num"]	="JT".time().rand("11","99");
		
		$coupon_dsh_price=M("store")->field("coupon_dsh_price")->where("program_id='".$_POST["program_id"]."'")->find();
		$add["onprice"]		=$coupon_dsh_price["coupon_dsh_price"];
		
		
		if(M("coupon_dsh_record")->add($add)){
			$data=array("state"=>1,"msg"=>"操作成功","coupon_num"=>$add["coupon_num"]);
		}else{
			$data=array("state"=>-1,"msg"=>"操作失败");
		}
		$this->ajaxReturn($data);
	}
 	
// 	领取消费券
	function coupon_dsh_get(){

		$save["openid"]		=$_POST["openid"];
		$save["get_state"]	="1";
		$save["time_get"]	=time();
		$a=M("coupon_dsh_record")->field("state,dsh_id")->where("program_id='".$_POST["program_id"]."'"."and coupon_num='".$_POST["coupon_num"]."'")->find();
		
		if($a["state"]==1){
			$data=array("state"=>-2,"msg"=>"请勿重复领取");
			$this->ajaxReturn($data);
		}
		if(M("coupon_dsh_record")->where("program_id='".$_POST["program_id"]."'"."and coupon_num='".$_POST["coupon_num"]."'")->save($save)){
			$data=array("state"=>1,"msg"=>"操作成功");
			
			M("user_info_dsh")->where("id='".$a["dsh_id"]."'")->setInc("coupon_dsh_num","-1");
			M("user_info_dsh")->where("id='".$a["dsh_id"]."'")->setInc("coupon_dsh_num_done","1");
		}else{
			$data=array("state"=>-1,"msg"=>"操作失败");
		}
		$this->ajaxReturn($data);
		
	}
	
//	我的消费券列表
	function my_coupon_list(){
		
		$field="
			coupon_dsh_record.id,coupon_dsh_record.coupon_num,coupon_dsh_record.openid,coupon_dsh_record.onprice,coupon_dsh_record.dsh_id,coupon_dsh_record.state,coupon_dsh_record.time_get,coupon_dsh_record.time_used,
			user_info_dsh.sh_name
		";
		$a=M("coupon_dsh_record")->field($field)
		->join("left join user_info_dsh on user_info_dsh.id=coupon_dsh_record.dsh_id")
		->where("coupon_dsh_record.program_id='".$_GET["program_id"]."'"." and coupon_dsh_record.openid='".$_GET["openid"]."'")->order("time_get desc")->select();
		
		$store=M("store")->field("id,base_price,coupon_dsh_price")->where("program_id='".$_GET["program_id"]."'")->find();
		
		$a[0]["coupon_price"]=$store["coupon_dsh_price"];
		$a[0]["coupon_usebase"]=$store["base_price"];
		$this->ajaxReturn($a);
	}
//	消费券支付选择列表
	function pay_coupon_list(){
		
		$a=M("coupon_dsh_record")->where("state =0 and program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->select();
		
		$this->ajaxReturn($a);
	}
	
//	商户搜索列表（百业联盟）
	function sh_fl_search(){
		if(empty($_GET["program_id"]) ){ $this->ajaxReturn(array("state" => -999, "msg" => "参数缺失")); }
		  	
		$a=M('attribute')->where("attribute_style=2 and program_id='".$_GET["program_id"]."'")->order("sort")->select();
		$this->ajaxReturn($a);
	}


	function sh_search(){
		if(empty($_GET["program_id"]) ){ $this->ajaxReturn(array("state" => -999, "msg" => "参数缺失")); }
		  	
		$user_info_dsh=M("user_info_dsh");
		$sql  =" SELECT id,detail_address,logo,sh_name,sh_jd,payment_method_id FROM user_info_dsh ";
		$sql .=" WHERE program_id ='".$_GET["program_id"]."'";
		$sql .=" and state =3";

		//名称模糊搜索
		if($_GET['str']){
			if($_GET['str']!="undefined"){

				$_GET['str']="%".$_GET['str']."%";
				$sql .=" and (sh_name like'".$_GET['str']."'";	
				$sql .=" or detail_address like'".$_GET['str']."'".")";	
			}
		}
		//名称模糊搜索 
		if($_GET['fl_id']){
			if($_GET['fl_id']!="undefined"){
				$sql .=" and fl_id ='".$_GET['fl_id']."'";	
		
			}
		}
		
		
	
	    $a = M("user_info_dsh") -> query($sql);

  	for($i=0;$i<count($a);$i++){

  		//坐标
  		$coordinate[$i]=explode(",",$a[$i]["sh_jd"]);
		$coordinate_phone=explode(",",$_GET["coordinate"]);

		$a[$i]["distance"]=$this->getDistance($lat1=$coordinate[$i][0], $lng1=$coordinate[$i][1], $lat2=$coordinate_phone[0], $lng2=$coordinate_phone[1]);
  	}

	$dos = array_map(create_function('$n', 'return $n["distance"];'), $a);
	array_multisort($dos,SORT_ASC,$a);
  	$this->ajaxReturn($a);
	}

}

?>