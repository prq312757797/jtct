<?php
namespace Program\Controller;
use Think\Controller;
header('content-type:application:json;charset=utf8'); 
header('Access-Control-Allow-Origin:*'); 
//header('Access-Control-Allow-Methods:POST'); 
header("Content-type: text/html; charset=utf-8");
header('Access-Control-Allow-Headers:x-requested-with,content-type');


class IndexController extends Controller {
	
	function save_openid(){
		if(empty($_GET["openid"])){
			$this->ajaxReturn(array('status'=>-1,'msg'=>'未能获得用户信息'));
		}
		$is_member=M("members")->field("id,state_online")->where("openid='".$_GET["openid"]."'"."and program_id='".$_GET["program_id"]."'")->find();
		if(empty($is_member)){
			//如果没有openid 就返回一个提示
			if(!empty($_GET["openid"])){	
				$store1023=M("store")->field("id,integral_song")->where("program_id='".$_GET["program_id"]."'")->find();
				if(!empty($store1023["integral_song"])){
					$_GET["integral_song"]=$store1023["integral_song"];//初次进入怂500积分
				}
				$_GET["register_time"]=time();
			M("members")->add($_GET);		
			//存了个人信息之后就开始给个人默认等级、分组
			//会员设置默认等级（首次进入）
			$member_level=M("member_level")->field("id")->where("cannot_d=1 and program_id='".$_GET["program_id"]."'")->find();
			$save["level_id"]=$member_level["id"];
			
			//会员设置默认分组 （首次进入）
			$member_group=M("member_group")->field("id")->where("cannot_d=1 and program_id='".$_GET["program_id"]."'")->find();
			$save["group_id"]=$member_group["id"];
			
			M("members")->where("openid='".$_GET["openid"]."'"."and program_id='".$_GET["program_id"]."'")->save($save);
			$data=array("state"=>1,"msg"=>"信息录入成功");
			}
		}else{
			if($_GET["nickname"]=="undefined"){
				$data=array("state"=>-1,"msg"=>"信息缺失");
			}else{
				$dat["nickname"]=$_GET["nickname"];
				$dat["head"]=$_GET["head"];
				M("members")->where("openid='".$_GET["openid"]."'"."and program_id='".$_GET["program_id"]."'")->save($dat);
			
				$adtest["title"]=$_GET["nickname"];
				$adtest["name"]=date("Y-m-d H:i:s",time());
				M("test")->add($adtest);
			
				$data=array("state"=>1,"msg"=>"资料保全成功.");
			}
			
		}
		$this->ajaxReturn($data);
	}
	//手机端主页展示
	function index_show(){
		if(empty($_GET["program_id"])){
			$this->ajaxReturn(array("state" => -9999, "msg" => "参数缺失"));
		}
		//判断小程序的类型，看看小程序是不是正常使用的，顺便决定调用是什么东西 qianyue
		$qianyue=M("qianyue")->field("state,muban_type,function_id")->where("program_id='".$_GET["program_id"]."'")->find();
		
		if($qianyue["state"]==3){
			//小程序被禁止使用
			$this->ajaxReturn(array('status'=>-999,'msg'=>'小程序被禁用'));
		}

		if(empty($_GET["openid"])){
			$vioce=array('status'=>1,'msg'=>'未能获得用户信息');
		}
		$is_member=M("members")->field("id,state_online")->where("openid='".$_GET["openid"]."'"."and program_id='".$_GET["program_id"]."'")->find();
		if(empty($is_member)){
		//如果没有openid 就返回一个提示
		if(!empty($_GET["openid"])){	
			$store1023=M("store")->field("id,integral_song")->where("program_id='".$_GET["program_id"]."'")->find();
			if(!empty($store1023["integral_song"])){
				$_GET["integral_song"]=$store1023["integral_song"];//初次进入怂500积分
			}
			$_GET["register_time"]=time();
		M("members")->add($_GET);
				
		//存了个人信息之后就开始给个人默认等级、分组
		//会员设置默认等级（首次进入）
		$member_level=M("member_level")->field("id")->where("cannot_d=1 and program_id='".$_GET["program_id"]."'")->find();
		$save["level_id"]=$member_level["id"];
		
		//会员设置默认分组 （首次进入）
		$member_group=M("member_group")->field("id")->where("cannot_d=1 and program_id='".$_GET["program_id"]."'")->find();
		$save["group_id"]=$member_group["id"];
		
		M("members")->where("openid='".$_GET["openid"]."'"."and program_id='".$_GET["program_id"]."'")->save($save);

		}
	}else{
	//有了个人的信息，补全nickname、headimgurl
		if($_GET["nickname"]=="undefined"){
			$data=array("state"=>-1,"msg"=>"信息缺失");
		}else if(empty($_GET["nickname"])){
			$data=array("state"=>-2,"msg"=>"信息缺失.");
		} else{
			$dat["nickname"]=$_GET["nickname"];
			$dat["head"]=$_GET["head"];
			M("members")->where("openid='".$_GET["openid"]."'"."and program_id='".$_GET["program_id"]."'")->save($dat);
		
			$adtest["title"]=$_GET["nickname"];
			$adtest["name"]=date("Y-m-d H:i:s",time())."+111";
			M("test")->add($adtest);
		
			$data=array("state"=>1,"msg"=>"资料保全成功.");
		}

	}
		
		//需要判断小程序的版本，对应传递对应的数据
		if($qianyue["muban_type"]==1){
//这里是商城版需要的接口内容==========================================================================
//这里是商城版需要的接口内容==========================================================================
//这里是商城版需要的接口内容==========================================================================


//判断登录的人是不是分销商	
	$is_member0929=M("members")->field("id,fx_state,gold_shoucang,shouyi,silver_shoucang")->where("openid='".$_GET["openid"]."'"."and program_id='".$_GET["program_id"]."'")->find();

		if($is_member0929["fx_state"]==0){
			$fx_state["text"]="不是分销商";
		}else if($is_member0929["fx_state"]==1){
			$fx_state["text"]="分销商审核中";
		}else if($is_member0929["fx_state"]==2){
			$fx_state["text"]="分销商";
		}else if($is_member0929["fx_state"]==3){
			$fx_state["text"]="分销商禁用";
		}
		$fx_state["val"]=$is_member0929["fx_state"];

//判断有没有开通多商铺功能   user_info
		$user_info=M("user_info")->field("id,is_on_dsh")->where("program_id='".$_GET["program_id"]."'")->find();
		
		$where_com["is_show"]=1;
		$where_com["program_id"]=$_GET["program_id"];
		
		$a=M("huandeng")->field('id,url,image')->where($where_com)->order("sort")->select();//幻灯片


		$where_comad["is_show"]=1;
		$where_comad["program_id"]=$_GET["program_id"];
		$where_comad["is_special"]=0;
		$b_old=M("ad")->field('id,url,image,title')->where($where_comad)->order("sort")->select();//广告
		if($_GET["program_id"]=="JT201807211029434559"){
			for($i0911=0;$i0911<count($b_old);$i0911++){
				if($b_old[$i0911]["id"]!="546"){
					$b_new[]=$b_old[$i0911];
				}else{
					$ad_remen=$b_old[$i0911];
				}
			}
			$b=$b_new;
		}else{
			$b=$b_old;
		}
		
		
		$c=M("direction")->field('id,image,url,title,sort')->where($where_com)->order("sort")->select();//导航图标 

		$field_store='phone_ask,sh_jd,is_on_index_ad,index_ad_img,index_ad_showtime,address,program_title,is_show_indexfl,index_abstract,video,video_image,is_submit_contect,is_artical,fenlei_lever,is_on_showgoods,zx_info_list_img,is_double_huandeng,is_on_dsh';
		$g=M("store")->field($field_store)->where("program_id='".$_GET["program_id"]."'" )->find();//小程序视频

		$field_goods='id,sort,area_re,goods_video,index_choose,image,goods_title,sell_num,goods_shorttitle,good_attribute,price_sell,is_use_consumption_num,price_own,goods_subtitle,goods_subtitle01,goods_subtitle02,goods_subtitle03,goods_subtitle04,goods_subtitle05';
		$where_goods["goods_state"]=1;
		$where_goods["program_id"]=$_GET["program_id"];
		
		
		$e=M("goods")->field($field_goods)->where($where_goods)->order("sort")->select();//商品图片标题
		
		if($g["is_on_dsh"]==1){
			$data=M("user_info_dsh")
			->field('id,program_id,sort,sh_name,main_project,logo,introduce')
			->where("state=3 and  is_recommend=1 and  program_id='".$_GET["program_id"]."'")
			->order("sort")
			->select();
		}else{
			$data=false;
		}
		$dat=array();
//		$dat[is_on]=$data;//子商户信息 
		$dat["is_on"]=$data;//子商户信息

		if($_GET["program_id"]=="JT201810111844206577"){//珠宝小程序地域推送
			for($i0=0;$i0<count($e);$i0++){
				$arr_area_re[$i0]=explode(",",$e[$i0]["area_re"]);
				
				if(in_array($_GET["city"],$arr_area_re[$i0])){
					$goods_i0[]=$e[$i0];
				}
			}		
			
			$e=$goods_i0;
		}
			
		for($i=0;$i<count($e);$i++){
	
			$arr1102=explode(",",$e[$i]['image']);
			$e[$i]["image_first"]=$arr1102[0];
	
			if($e[$i]["goods_subtitle01"]==1) $f["f1"][$i]=$e[$i];//分组1、热卖
			if($e[$i]["goods_subtitle02"]==1) $f["f2"][$i]=$e[$i];//分组2、新品
			if($e[$i]["goods_subtitle03"]==1) $f["f3"][$i]=$e[$i];//分组3、推荐
			if($e[$i]["goods_subtitle04"]==1) $f["f4"][$i]=$e[$i];//分组4、促销
			if($e[$i]["goods_subtitle05"]==1) $f["f5"][$i]=$e[$i];//分组5、包邮
	
			if($e[$i]["goods_video"]!=0) $f["f6"][$i]=$e[$i];//分组6、商品上传视频
			
			if($e[$i]["is_use_consumption_num"]==1) $f["f7"][$i]=$e[$i];//是否能用消费码
			
			if($_GET["program_id"]=="JT201808090855119076"){
				if($e[$i]["index_choose"]==1) $f["index_booking"][$i]=$e[$i];//首页预定选择
			}
			
		}
			$f["f1"]=$this->arr_0_order($f["f1"]);
			$f["f2"]=$this->arr_0_order($f["f2"]);
			$f["f3"]=$this->arr_0_order($f["f3"]);
			$f["f4"]=$this->arr_0_order($f["f4"]);
			$f["f5"]=$this->arr_0_order($f["f5"]);
		
			if($_GET["program_id"]=="JT201808090855119076"){
				$f["index_booking"]=$this->arr_0_order($f["index_booking"]);
					
				$f["index_booking_all"]=$f["index_booking"];
				for($i=0;$i<count($f["index_booking"]);$i++){
					$arr_index[$i]=$f["index_booking"][$i]["goods_title"];
				}
			
				$f["index_booking"]=$arr_index;
				
			}
		
	
		$f1116=M("preferential")->where("program_id='".$_GET["program_id"]."'")->order("sort")->select();
		
	//1229  根据个人openid判断这个人还不是平台登录状态，是的话就显示价格，不是的话就提示需要注册才能看到价格
	$z1229=array();
	if($_GET["program_id"]=="JT201711101339052665"){
		if($is_member["state_online"]==2){
			$z1229=array('state'=>2,'msg'=>"账号不在线，不能看到价格");
		}else if($is_member["state_online"]==1){
				$z1229=array('state'=>1,'msg'=>"账号在线，能看到价格"."1122");
		}
	}

	//0330 鸡蛋，首页开始添加文章列表 artical
	$where_artical["is_show"]=1;
	$where_artical["program_id"]=$_GET["program_id"];
	
	if($_GET["program_id"]=="JT201807211029434559"){
		$where_artical["state"]=2;
	}else{
		$where_artical["state"]=1;
	}
	
	$artical=M("artical")->where($where_artical)->order("sort")->select();

	if($g["is_show_indexfl"]==1){
		//添衣服，增加首页显示商品分类  $_GET["program_id"]=="JT201805020920374826" or $_GET["program_id"]=="JT201807211029396429"
		$attribute=M("attribute")->field("id,title,title_english,image_1,is_index_recommend")->where("attribute_style=1 and uid=0 and is_show=1 and program_id='".$_GET["program_id"]."'")->order("sort")->select();
	}
	//商品推荐分类
	$index_recommend=M("index_recommend")->where("program_id='".$_GET["program_id"]."'")->find();

	$index_recommend_arr=array_filter(explode(",",$index_recommend["recommend_text"])); 
	//数据渲染啦++++++++++++++++++++++++++++++++++++++++++
	$d=array('k1'=> $a,'k2'=>$b,'k3'=>$c,'k4'=>$f,'k5'=>$vioce,'k6'=>$dat,'k7'=>$fx_state,'k8'=>$g,'k9'=>$f1116,'kk'=>$z1229,'artical'=>$artical,'diy_html'=>$diy_html,'attribute'=>$attribute,'index_recommend_arr'=>$index_recommend_arr,'data'=>$data);
	if($_GET["program_id"]=="JT201807211029434559"){
		//婚博会文章分类 attribute
		$attribute_artical=M("attribute")->field("id,sort,title")->where("attribute_style=3 and program_id='".$_GET["program_id"]."'")->order("sort")->select();
	
		for($i0818=0;$i0818<count($attribute_artical);$i0818++){
			$artica_showfenlei[$i0818]=M("artical")->field("id,title,image")->where("fenlei_1='".$attribute_artical[$i0818]["id"]."'")->select();
			$attribute_artical[$i0818]["artical_info"]=$artica_showfenlei[$i0818];
		}
	
		$d["attribute_artical"]=$attribute_artical;
		
		$d["ad_remen"]=$ad_remen;
		
	}

	if($_GET["program_id"]=="JT201810111844206577"){
		//珠宝金价控制数据
	
		$gold_control=M("gold_control")->select();
		
		$d["control_price"]=$gold_control;
		$d["man_info"]=$is_member0929;
		
	}

		}else if($qianyue["muban_type"]==5){
//这里是资讯 版需要的接口内容==========================================================================			
//这里是资讯 版需要的接口内容==========================================================================
//这里是资讯 版需要的接口内容==========================================================================		
		if($_GET["program_id"]=="JT201710160953394557"){//大创业平台
			$a=M("huandeng")->field('id,url,image')->where("is_show=1 and program_id='".$_GET["program_id"]."'" )->order("sort")->select();//幻灯片
		//$b=M("ad")->field('id,url,image,title')->where("is_show=1 and program_id='".$_GET["program_id"]."'")->order("sort")->select();//广告		
		$c=M("direction")->field('id,image,url,title,sort')->where("is_show=1 and program_id='".$_GET["program_id"]."'")->order("sort")->select();//导航图标
		$g=M("store")->field('video,video_image')->where("program_id='".$_GET["program_id"]."'" )->find();//小程序视频
		$field='
			jt03_zx_info.id,jt03_zx_info.title,jt03_zx_info.num,jt03_zx_info.state,jt03_zx_info.num_contect,jt03_zx_info.num_read,jt03_zx_info.time_agree,jt03_zx_info.image,jt03_zx_info.fenlei01,
			jt03_zx_info.sort,jt03_zx_info.style,jt03_zx_info.is_gongyi,jt03_zx_info.price,
			
			attribute.title as attribute_attribute
		';

		$zx_info=M("jt03_zx_info")->field($field)
		->join('left join attribute ON attribute.id=jt03_zx_info.fenlei01')
		->where("jt03_zx_info.state=2 and  jt03_zx_info.program_id='".$_GET["program_id"]."'")
		->order("jt03_zx_info.time_agree desc")->select();
		
			for($i=0;$i<count($zx_info);$i++){
				$time_lase=time()-$zx_info[$i]["time_agree"];
				if($time_lase<60 ){
					$zx_info[$i]["time_last"]=$time_lase."秒前";
				}else if($time_lase<3600){
					$zx_info[$i]["time_last"]=floor($time_lase/60)."分钟前";
				}else if($time_lase<86400){
					$zx_info[$i]["time_last"]=floor($time_lase/3600)."小时前";
				}else if($time_lase<2592000){
					$zx_info[$i]["time_last"]=floor($time_lase/86400)."天前";
				}

			
				if($zx_info[$i]["style"]==3){
					$f["f3"][$i]=$zx_info[$i];//1:采购信息、2：供应信息、3：平台好消息
				}
				if($zx_info[$i]["style"]==1){
				//	$f["f3"][$i]=$zx_info[$i];//1:采购信息、2：供应信息、3：平台好消息
					$f["f1"][$i]=$zx_info[$i];//1:采购信息、2：供应信息、3：平台好消息
				}
			
			}

	//数据渲染啦++++++++++++++++++++++++++++++++++++++++++
	
	//$a=幻灯、 $b=导航图标、 $f=信息、$g=视频
		$d=array('k1'=> $a,'k3'=>$c,'k4'=>$f,'k5'=>$g);
		}else{
		$a1118=M("ad")->field('id,url,image,title')->where("is_show=1 and program_id='".$_GET["program_id"]."'")->order("sort")->select();//广告
		
		$a111802=M("huandeng")->field('id,url,image,title')->where("is_show=1 and program_id='".$_GET["program_id"]."'")->order("sort")->select();//广告
	
		$artical=M("artical")->where("is_show=1 and program_id='".$_GET["program_id"]."'")->limit("0,5")->order("sort")->select();
		$b1213=M("direction")->field('id,image,url,title,sort')->where("is_show=1 and program_id='".$_GET["program_id"]."'")->order("sort")->select();//导航图标

		//新闻资讯
		$news=M("artical")->where("is_show=1 and program_id='".$_GET["program_id"]."'")->order("sort")->select();
//		$g=M("store")->field('video,video_image')->where("program_id='".$_GET["program_id"]."'" )->find();//小程序视频
		$g=M("store")->field('program_title,index_abstract,video,video_image,is_submit_contect,is_artical,fenlei_lever,is_on_showgoods,zx_info_list_img,is_double_huandeng')->where("program_id='".$_GET["program_id"]."'" )->find();//小程序视频
	
		$d=array('q1'=> $a1118,'q2'=> $a111802,'q3'=> $artical,'q4'=> $b1213,'q5'=> $g,'q6'=>$news);
	}
		

	}else if($qianyue["muban_type"]==6){
//这里是服务 版需要的接口内容==========================================================================			
//这里是服务 版需要的接口内容==========================================================================
//这里是服务 版需要的接口内容==========================================================================		
		
		$a=M("huandeng")->field('id,url,image')->where("is_show=1 and program_id='".$_GET["program_id"]."'" )->order("sort")->select();//幻灯片

		$b=M("ad")->field('id,url,image,title')->where("is_show=1 and program_id='".$_GET["program_id"]."'")->order("sort")->select();//广告
		
	//	$c=M("direction")->field('id,image,url,title,sort')->where("is_show=1 and program_id='".$_GET["program_id"]."'")->order("sort")->select();//导航图标

		$g=M("store")->field('video,video_image,fenlei_lever')->where("program_id='".$_GET["program_id"]."'" )->find();//小程序视频

		$field='
			id,sh_video,sh_image,sort,sh_name,sh_jd,logo,main_project,sh_jd,detail_address,main_project,payment_method_id
		';

		$sh_info=M("user_info_dsh")->field($field)
		->where("state=3 and is_recommend=1 and  program_id='".$_GET["program_id"]."'")
		->order("sort asc")->select();
				
		//根据传递过来的城市，给出这个城市的区域过去给前台选择
		$where0507['_string']='
			 (name like "%'.$_GET["now_city"].'%")
		';
		$where0507["type"]=2;
		$one_city=M("one_city")->where($where0507)->find();	
		$city_list=M("one_city")->where("pid='".$one_city["id"]."'")->select();	
			
	for($i=0;$i<count($sh_info);$i++){
		$first=implode(",",$sh_info[$i]["sh_image"]);
		$sh_info[$i]["sh_image"]=$first[0];
		//支付方式
		$pay_way_arr[$i]=explode(",",$sh_info[$i]["payment_method_id"]);

		for($k=0;$k<count($pay_way_arr[$i]);$k++){
			$arr_pay_name[$i][$k]=M("payment_method_dsh")->field('title')->where("id='".$pay_way_arr[$i][$k]."'")->find();
		}
		for($r=0;$r<count($arr_pay_name[$i]);$r++){
			$str_pay_name[$i].=$arr_pay_name[$i][$r]["title"].",";
		}

		$str_pay_name[$i] = substr($str_pay_name[$i],0,strlen($str_pay_name[$i])-1); //去掉最后一个逗号

		$sh_info[$i]["str_pay_name"]=$str_pay_name[$i];	
		$sh_info[$i]["arr_pay_name"]=explode(",",$sh_info[$i]["str_pay_name"]);
		//接收手机坐标
		$coordinate=explode(",",$sh_info[$i]["sh_jd"]);
		$coordinate_phone=explode(",",$_GET["coordinate"]);
		$sh_info[$i]["distance"]=$this->getDistance($lat1=$coordinate[0], $lng1=$coordinate[1], $lat2=$coordinate_phone[0], $lng2=$coordinate_phone[1]);
		
	}
	
	
		$zx_info_list_img=M("store")->field("zx_info_list_img")->where("program_id='".$_GET["program_id"]."'")->find();

		$artical=M("artical")->field('id,title,content')->where("is_show=1 and program_id='".$_GET["program_id"]."'")->order("sort")->select();
	
	//子商户支付方式
	$payment_method_dsh=M("payment_method_dsh")->where("program_id='".$_GET["program_id"]."'")->order("sort")->select();
	
	//子商户区域
	$merch_area_dsh=M("merch_area_dsh")->where("program_id='".$_GET["program_id"]."'")->order("sort")->select();
	
	 $attribute=M("attribute")->field('id,title')->where("is_show=1 and attribute_style=2 and program_id='".$_GET["program_id"]."'")->select();
	
	
	//$is_register=M("user_info_dsh")->where("program_id='".$_GET["program_id"]."'")->find();
	//数据渲染啦++++++++++++++++++++++++++++++++++++++++++
	//$a=幻灯、 $b=广告、 $f=附近商家、$g=视频  $zx_info_list_img=联系我们图  k7：公告文章 k8:支付方式 k9:城市区域  k10：行业分类
		$d=array('k1'=> $a,'k2'=>$b,'k4'=>$sh_info,'k5'=>$g,'k6'=>$zx_info_list_img,'k7'=>$artical,'k8'=>$payment_method_dsh,'k9'=>$merch_area_dsh,'k10'=>$attribute,'city_list'=>$city_list);

		}
//1117...11.38后台数据结构改版============================允许版本自由组合============================
	$function_arr=explode(",",$qianyue["function_id"]);

	$a=in_array("1",$function_arr)?"1":"2";//基础商城版
	$b=in_array("2",$function_arr)?"1":"2";//基础资讯版
	$c=in_array("3",$function_arr)?"1":"2";//基础服务版
	
	$f_11=in_array("11",$function_arr)?"1":"2";//首页显示视频
	//dump($a);dump($b);dump($c);die;
	if($a==1 & $b ==2 & $c==2){
//纯商城版
	}
	 if($a==2 & $b ==1 & $c==2){
//纯资讯版
	}
	 if($a==2 & $b ==2 & $c==1){
//纯服务版
	}
	if($a==1 & $b ==1 & $c==2){
//商城版   + 资讯版 


		$a1118=M("ad")->field('id,url,image,title')->where("is_show=1 and program_id='".$_GET["program_id"]."'")->order("sort")->select();//广告
		
		$a111802=M("huandeng")->field('id,url,image,title')->where("is_show=1 and program_id='".$_GET["program_id"]."'")->order("sort")->select();//广告
	
		$artical=M("artical")->where("is_show=1 and program_id='".$_GET["program_id"]."'")->limit("0,5")->order("sort")->select();
	
	if($_GET["program_id"]=="JT201711161127509059"){
		//爱神红娘有的内容
		$b=M("identity_info")->field('id,openid,profile,is_stars,sex,as_id,name,headimg,image,qinaming,is_recommend')->where("program_id='".$_GET["program_id"]."'")->select();
		
		for($i1117=0;$i1117<count($b);$i1117++){
			$b[$i1117]["img_arr"]=explode(",",$b[$i1117]["image"]);
			
			if($b[$i1117]["is_stars"]==1){
				$c22[]=$b[$i1117];//明星红娘
			}
			if($b[$i1117]["as_id"]==1 & $b[$i1117]["is_recommend"]==1){
				$d[]=$b[$i1117];//推荐媒婆						
			//	M("identity_info")->field('id,headimg')->where("meipo_id='".$b[$i1117]["id"]."'")->find();
			}
			if($b[$i1117]["as_id"]==2 & $b[$i1117]["is_recommend"]==1){
				if($b[$i1117]["sex"]==1){
					$e[]=$b[$i1117];//单身	男	推荐男神
				}else if($b[$i1117]["sex"]==2){
					$f[]=$b[$i1117];//单身	女	推荐女神
				}
			}
		}
//推荐红娘的下属
		for($y=0;$y<count($d);$y++){
			$info_d=M("identity_info")->field('id,openid,headimg')->where("meipo_openid='".$d[$y]["openid"]."'")->find();
			$d[$y]["xiaji"]=$info_d;
		}

//前四个 明星红娘
		for($k1117_1=0;$k1117_1<count($c22);$k1117_1++){
			if($k1117_1<4){
				$c1[$k1117_1]=$c22[$k1117_1];
			}
		}
//前四个 推荐媒婆		
		for($k1117_2=0;$k1117_2<count($d);$k1117_2++){
			if($k1117_2<4){
				$d1[$k1117_2]=$d[$k1117_2];
			}
		}
//前四个 推荐男神		
		for($k1117_3=0;$k1117_3<count($e);$k1117_3++){
			if($k1117_3<4){
				$e1[$k1117_3]=$e[$k1117_3];
			}
		}
//前四个 推荐女神		
		for($k1117_4=0;$k1117_4<count($f);$k1117_4++){
			if($k1117_4<4){
				$f1[$k1117_4]=$f[$k1117_4];
			}
		}
	}else{
		//非红娘小程序
		
		//导航图标
		$b1213=M("direction")->field('id,image,url,title,sort')->where("is_show=1 and program_id='".$_GET["program_id"]."'")->order("sort")->select();//导航图标

		//新闻资讯
		$news=M("jt03_zx_info")->where("is_show=1 and program_id='".$_GET["program_id"]."'")->order("sort")->select();
		
	}
	
	
	if($f_11==1){
		$g=M("store")->field('video,video_image')->where("program_id='".$_GET["program_id"]."'" )->find();//小程序视频
	}
		if($_GET["program_id"]=="JT201711161127509059"){
			$d=array('q1'=> $a1118,'q2'=> $c1,'q3'=> $d1,'q4'=> $e1,'q5'=> $f1,'q6'=> $g,'q7'=>$a111802,'q8'=>$artical);
		}else{
			$d=array('q1'=> $a1118,'q2'=> $a111802,'q3'=> $artical,'q4'=> $b1213,'q5'=> $g,'q6'=>$news);

		}
	}
	//dump($d);die;
		$this->ajaxReturn($d);
	}
	function address(){
		$add_latitude["program_id"]=$_GET["program_id"];
		$add_latitude["openid"]=$_GET["openid"];
		$add_latitude["time"]=time();
		$add_latitude["time_show"]=date("Y-m-d H:i:s",time());
		$add_latitude["latitude"]=$_GET["latitude"];
		
		M("latitude")->add($add_latitude);
	}
	//红娘判断身份页面
	function first_page(){
		if(empty($_GET["program_id"]) | empty($_GET["openid"])){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		
		//判断身份  
		$members=M("members")->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();
		
		$identity_info=M("identity_info")->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();
	//	dump($identity_info);die;
		if(empty($identity_info)){
			$this->ajaxReturn(array("state" => -1, "msg" => "平台无个人信息"));
		}else{
			$this->ajaxReturn(array("state" => 1, "msg" => "平台有个人信息",'as_id'=>$identity_info["as_id"]));
		}
	}
	//		//根据传递过来的城市，给出这个城市的区域过去给前台选择
function city_list(){
		$where0507['_string']='
					 (name like "%'.$_GET["now_city"].'%")
				';
				$where0507["type"]=2;
		$one_city=M("one_city")->where($where0507)->find();	

		$city_list=M("one_city")->where("pid='".$one_city["id"]."'")->select();	
		$this->ajaxReturn($city_list);
}
	
	//爱神红娘更多
	function aishen_list(){
		//更多明星红娘   更多女神    更多男神    更多红娘    more_style=1、2、3、4
		//$where["program"]=$_GET["program"];
		switch ($_GET["more_style"]){
			case 1:
				$where["is_stars"]="1";
			//	$where["as_id"]="1";   
				$where["is_date01_com"]="1"; 
				break;
			case 2:
				$where["is_stars"]="2";
			//	$where["as_id"]="2";
				$where["is_date02_com"]="1"; 
				$where["sex"]="2";
				break;	
			case 3:
				$where["is_stars"]="2";
				//	$where["as_id"]="2";
				$where["is_date02_com"]="1"; 
				$where["sex"]="1";
				break;	
			case 4:
				$where["is_stars"]="2";
				//	$where["as_id"]="2";
				$where["is_date01_com"]="1"; 
			
				break;		
		}
		$where["program_id"]=$_GET["program_id"];
		//$where["state"]="1";
	
		$a=M("identity_info")->field('id,openid,profile,as_id,name,headimg,image,qinaming')->where($where)->select();
		//dump($a);dump(M("identity_info")->_sql());die;
		$this->ajaxReturn($a);
	}
	
	//爱神红娘详情
	function as_info_con(){
		//红娘或者个人的信息、   红娘的有自己的推荐的人 的列表（男、女  有异步的需要）
		
		if($_GET["as_id"]==1){
			//红娘
			
			$field='id,name,headimg';				
		}else if($_GET["as_id"]==2){
			//单身
		
			$field='id,name,as_id,profile,age,constellation,address,work,sex,headimg,tel,image,qinaming,base_info,
			condition_maray,liking';	
		}
		$where["as_id"]=$_GET["as_id"];
		$where["program_id"]=$_GET["program_id"];
		$where["state"]="1";
		
		$a=M("identity_info")->where($where)->select();
		
		$this->ajaxReturn($a);
	}
	
	//展示商品详情
	public function goods_con(){
		//不同的小程序调用数据的结构不一样需要判断小程序的模板
			$qianyue=M("qianyue")->where("program_id='".$_GET["program_id"]."'")->find();
	
if($qianyue["muban_type"]==1){
//这里是商城 版需要的接口内容==========================================================================
//这里是商城 版需要的接口内容==========================================================================
//这里是商城 版需要的接口内容==========================================================================
	
	//获取商品id 展示商品详情  goods_label  dsh_id
		$where=array( 'program_id'=>$_GET["program_id"] , 'id'=>$_GET["id"] );

		$a=M("goods")
//		->field('id,is_use_coupon,server_man,is_video_free,server_phone,face_price,preferential_id,goods_xieyi,goods_label,goods_title,person_sell,goods_video,is_on_wholesale_discount,is_on_lever_price,str_guige,str_guige02,str_remark,str_price,str_img,str_num,image,good_attribute,price_sell,price_sell,goods_subtitle,goods_shorttitle,price_own,number,collect_num,is_fapiao,day_shouhuo,goods_content,is_use_guige,payment,bianma,tiaoma,zhongliang,sell_num,hzd_indicators_set,hzd_indicators_used,shatian_state')
		->where($where)
		->find();

		//是否被收藏
			$where02=array( 'goods_id'=>$a["id"] , 'cus_openid'=>$_GET["openid"] );
			$is_collect=M("collection")->where($where02)->find();
			if(!empty($is_collect)){
				$a["is_collect"]="1";//已经被收藏
			}else{
				$a["is_collect"]="3";//没有被收藏
			}
		$arr=explode(",",$a["image"]);
		for($i1102=0;$i1102<count($arr);$i1102++){
				$b[$i1102]["image"]=$arr[$i1102];//相册	
			}
			
	
		$arr_label=explode(",",$a["goods_label"]);
			
		for($i0324=0;$i0324<count($arr_label);$i0324++){
				$goods_label[$i0324]=M("goods_label")->where("id='".$arr_label[$i0324]."'")->find();
				$lable[$i0324]["lable"]=$goods_label[$i0324]["text"];//标签	
			}


		if($a["is_use_guige"]==2){
			//是否启用规格（1：不启用（默认）、2：启用）
			$arr01=explode(",",$a["str_img"]);
			$arr02=explode(",",$a["str_guige"]);
			$arr03=explode(",",$a["str_remark"]);	
			$arr04=explode(",",$a["str_price"]);
			$arr05=explode(",",$a["str_num"]);
			
			$arr06=explode(",",$a["str_guige02"]);
			
			$arr_zb=explode("&",$a["guige_json_price_cl"]);
//			for($zb_i=0;$zb_i<count($arr_zb);$zb_i++){
//				$guige_zb_cl[$zb_i]=json_decode($arr_zb[$zb_i],true);
//			}
			
			$new_kucun=0;
			for($i1129=0;$i1129<count($arr01);$i1129++){
				
				
				$b1129[$i1129]["arr_img"]=$arr01[$i1129];//规格图片	
				$b1129[$i1129]["arr_guige"]=$arr02[$i1129];//规格
				
				$b1129[$i1129]["arr_remark"]=$arr03[$i1129];//规格备注
				
				$b1129[$i1129]["arr_price"]=$arr04[$i1129];//规格价格
				
				$b1129[$i1129]["arr_num"]=$arr05[$i1129];//规格库存
				
				$b1129[$i1129]["guige_key"]=$i1129;//规格  键值
				
				$b1129[$i1129]["guige_cailiao"]=json_decode($arr_zb[$i1129],true);
				$new_kucun+=$arr05[$i1129];
			}
			for($i1207=0;$i1207<count($arr06);$i1207++){
				$b1207[$i1207]["arr_guige02"]=$arr06[$i1207];//二级规格名称
				
				$b1207[$i1207]["guige_key02"]=$i1207;//规格  键值
			}
			
			$a["number"]=$new_kucun;
			
		}
		//判断是不是显示折扣价格（优惠折扣） 满足数量减折扣
			if($a["is_on_wholesale_discount"]==1){
				$wholesale_discount=M("wholesale_discount")->field('num_start,num_end,discount')->where("state=1 and goods_id='".$_GET["id"]."'")->select();
				
			}

		//商品参数   

		$canshu=M("specifications")->where("goods_id='".$a["id"]."'")->find();		
		$c=$this->str_to_arr($canshu["title"],$canshu["content"]);
	

	
		$where0904["program_id"]=$_GET["program_id"];
		$where0904["cus_openid"]=$_GET["openid"];
		$where0904["order_num"]="0";
		
		$order_num=M("order")->field('buy_num')->where($where0904)->sum("buy_num");//得到购物车商品id数组
		
		//1130判断这个商品有没有设置多等级会员价
		$members=M("members")->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();
		
	if($_GET["program_id"]=="JT201807260907385777"){
		
		if($a["is_video_free"]==0){
			//0：收费、1：免费 
			$video_arr=explode(",",$members["video_arrstr"]);
			
			$show_video=in_array($a["id"],$video_arr)?"1":"0";//是否可以看视频
		}else{
			$show_video=1;
		}
		$video=M("video")->where("goods_id='".$a["id"]."'")->order("sort")->select();
			
	}
		
		if($a["is_on_lever_price"]==1){
			$a["is_member_price"]=1;//是否是会员价 1：是、2：否
			//开启了会员价
			$member_price=M("member_price")->where("program_id='".$_GET["program_id"]."'"." and goods_id='".$_GET["id"]."'")->select();

			for($r=0;$r<count($member_price);$r++){
				if($members["level_id"]==$member_price[$r]["lever_id"]){
				//	$a["price_sell"]=$a["price_sell"]*$member_price[$r]["discount"];
					//dump($member_price[$r]["discount"]);
					$a["members_discount"]=$member_price[$r]["discount"];//当前会员折扣
				}
			}
		}else{
			$a["is_member_price"]=2;//是否是会员价 1：是、2：否
		}
		
// 1222  商城版出现一个消费优惠券功能，判断小程序是否开启这功能，然后判断商品是否是打开这功能 is_on_shop_use
	$store=M("store")->where("program_id='".$_GET["program_id"]."'")->find();
	if($store["is_on_shop_use"]==1){
		//这个小程序开启了消费优惠券功能
		if($a["is_use_coupon"]==1){
			//这个商品是消费券形式的
			$preferential=M("preferential")->where("id='".$a["preferential_id"]."'")->find();
			$a["pre_price"]=$preferential["pre_price"];
		}
	}
	
	//1229  根据个人openid判断这个人还不是平台登录状态，是的话就显示价格，不是的话就提示需要注册才能看到价格
	if($_GET["program_id"]=="JT201711101339052665"){
		if($members["state_online"]==2){
			$z1229["state"]="2";
			$z1229["msg"]="账号不在线，不能看到价格";
		}else if($members["state_online"]==2){
			$z1229["state"]="1";
			$z1229["msg"]="账号不在线，不能看到价格";
		}
	}
	
	if($_GET["program_id"]=="JT201810111844206577"){
//		珠宝小程序商品价格
		$a["zb_cl_info"]=json_decode($a["json_price_cl"],true);

		if($a["is_use_guige"]==2){
//		启用规格
			$arr_zb=explode("&",$a["guige_json_price_cl"]);
			for($zb_i=0;$zb_i<count($arr_zb);$zb_i++){
				$guige_zb_cl[$zb_i]=json_decode($arr_zb[$zb_i],true);
			}
		}
		$a["guige_zb_cl_info"]=$guige_zb_cl;
//		dump($guige_zb_cl);die;
	}
	
	
	//0324 查找商品是否被购买过
	$where0324["goods_id"]=array('eq',$_GET["id"]);
	$where0324['order_num']=array('neq',"0");
	$where0324['cus_openid']=array('eq',$_GET["openid"]);
	
	$order0324=M("order")->where($where0324)->select();

	for($i0324=0;$i0324<count($order0324);$i0324++){
		
		$where0324_2['order_num']=array('eq',$order0324[$i0324]["order_num"]);
		$where0324_2['state']=array('in','2,3,4,5,7');
		$order_form0324[$i0324]=M("order_form")->where($where0324_2)->find();
		if($order_form0324[$i0324]) $order_form0324_1=$order_form0324[$i0324];
	
	}

	 if(empty($order_form0324_1)){
	 	$is_buy="weigoumai";//未购买
	 }else{
	 	$is_buy="yigoumai";//已购买
	 }
	 
	 if($a["dsh_id"]!=0){
	 	$user_info_dsh=M("user_info_dsh")->field("id,sh_name,logo,tel")->where("id='".$a["dsh_id"]."'")->find();
	 }
	 
	 //0331判断会员是不是分销商
	
	 ($members["fx_state"]==2)?$is_fx=1:$is_fx=0;
	 
		$z=array('k1'=> $a,'k2'=>$b,'k3'=>$c,'k4'=>$order_num,'k5'=>$where0904,'k6'=>$b1129,'k7'=>$b1207,'k8'=>$wholesale_discount,'k9','phone_ask'=>$store["phone_ask"],'lable'=>$lable,'is_buy'=>$is_buy,'is_fx'=>$is_fx,'user_info_dsh'=>$user_info_dsh);
	if($_GET["program_id"]=="JT201807260907385777"){
		$z["video"]=	$video;
		$z["show_video"]=$show_video;
	}
	if($_GET["program_id"]=="JT201810111844206577"){
		
		$z["member_info"]=$members;
	}
//	if($_GET["program_id"]=="JT201810111844206577"){//多米诺珠宝
//		$a["is_video_free"]
//	
//		$z["video"]=	$video;
//		$z["show_video"]=$show_video;
//	}

}else if($qianyue["muban_type"]==5){
//这里是资讯 版需要的接口内容==========================================================================	
//这里是资讯 版需要的接口内容==========================================================================	
//这里是资讯 版需要的接口内容==========================================================================	
	
			//获取商品id 展示商品详情
		$where=array( 'program_id'=>$_GET["program_id"] , 'id'=>$_GET["id"] );

		$a=M("goods")
		->field('id,goods_title,image,good_attribute,price_sell,price_sell,goods_subtitle,goods_shorttitle,price_own,number,collect_num,is_fapiao,day_shouhuo,goods_content,is_use_guige,payment,bianma,tiaoma,zhongliang')
		->where($where)
		->find();

		//是否被收藏
			$where02=array( 'goods_id'=>$a["id"] , 'cus_openid'=>$_GET["openid"] );
			$is_collect=M("collection")->where($where02)->find();
			if(!empty($is_collect)){
				$a["is_collect"]="1";//已经被收藏
			}else{
				$a["is_collect"]="3";//没有被收藏
			}
		$arr=explode(",",$a["image"]);
			
		for($i1102=0;$i1102<count($arr);$i1102++){
			$b[$i1102]["image"]=$arr[$i1102];
		}
	
		//商品参数   
			$where04=array(
				'goods_id'=>$a["id"],
			);
	
		$canshu=M("specifications")->where($where04)->find();		
		$c=$this->str_to_arr($canshu["title"],$canshu["content"]);
		//dump($c);dump($arr);die;
		
		$where0904["program_id"]=$_GET["program_id"];
		$where0904["cus_openid"]=$_GET["openid"];
		$where0904["order_num"]="0";
		
		$order_num=M("order")->field('buy_num')->where($where0904)->sum("buy_num");//得到购物车商品id数组

		$z=array('k1'=> $a,'k2'=>$b,'k3'=>$c,'k4'=>$order_num,'k5'=>$where0904);
			
	
}else if($qianyue["muban_type"]==6){
//这里是服务 版需要的接口内容==========================================================================	
//这里是服务 版需要的接口内容==========================================================================	
//这里是服务 版需要的接口内容==========================================================================	

		//获取商品id 展示商品详情  sell_num
		$where=array( 'program_id'=>$_GET["program_id"] , 'id'=>$_GET["id"] );

		$a=M("goods")
		->field('id,dsh_id,goods_title,sell_num,image,good_attribute,price_sell,price_sell,goods_subtitle,goods_shorttitle,price_own,number,collect_num,is_fapiao,day_shouhuo,goods_content,is_use_guige,payment,bianma,tiaoma,zhongliang')
		->where($where)
		->find();

		$arr=explode(",",$a["image"]);	
		for($i1102=0;$i1102<count($arr);$i1102++){
			$b[$i1102]["image"]=$arr[$i1102];
		}

		//需要这个商品的商户基本信息 
		$dsh=M("user_info_dsh")
		->field('id,sh_name,detail_address,tel,linkman,sh_jd')
		->where("id='".$a["dsh_id"]."'")->find();
		
		$coordinate=explode(",",$dsh["sh_jd"]);
		$coordinate_phone=explode(",",$_GET["coordinate"]);
		$dsh["distance"]=$this->getDistance($lat1=$coordinate[0], $lng1=$coordinate[1], $lat2=$coordinate_phone[0], $lng2=$coordinate_phone[1]);
		
		
	//标题、详细地址、电话、联系人、经纬度距离	
		
		$where0904["program_id"]=$_GET["program_id"];
		$where0904["cus_openid"]=$_GET["openid"];
		$where0904["order_num"]="0";
		
		$order_num=M("order")->field('buy_num')->where($where0904)->sum("buy_num");//得到购物车商品id数组
	$z=array('k1'=> $a,'k2'=>$b,'k3'=>$dsh,'k4'=>$order_num);
}else{
	


$function_arr=explode(",",$qianyue["function_id"]);

	$a=in_array("1",$function_arr)?"1":"2";//基础商城版
	$b=in_array("2",$function_arr)?"1":"2";//基础资讯版
	$c=in_array("3",$function_arr)?"1":"2";//基础服务版
	//dump($a);dump($b);dump($c);die;
	if($a==1 & $b ==2 & $c==2){
//纯商城版


	}
	 if($a==2 & $b ==1 & $c==2){
//纯资讯版
	}
	 if($a==2 & $b ==2 & $c==1){
//纯服务版
	}
	if($a==1 & $b ==1 & $c==2){
//商城版   + 资讯版 

//获取商品id 展示商品详情
		$where=array( 'program_id'=>$_GET["program_id"] , 'id'=>$_GET["id"] );

		$a=M("goods")
		->field('id,goods_title,image,good_attribute,price_sell,price_sell,goods_subtitle,goods_shorttitle,price_own,number,collect_num,is_fapiao,day_shouhuo,goods_content,is_use_guige,payment,bianma,tiaoma,zhongliang')
		->where($where)
		->find();

		if($a["is_on_lever_price"]==1){
			//开启了会员价
			$member_price=M("member_price")->where("program_id='".$_GET["program_id"]."'"." and goods_id='".$_GET["id"]."'")->select();
			
			$members=M("members")->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();
		
			for($r=0;$r<count($member_price);$r++){
				if($members["level_id"]==$member_price[$r]["lever_id"]){
					$a["price_sell"]=$member_price[$r]["price"];
					
				}
			}
		}
		//是否被收藏
			$where02=array( 'goods_id'=>$a["id"] , 'cus_openid'=>$_GET["openid"] );
			$is_collect=M("collection")->where($where02)->find();
			if(!empty($is_collect)){
				$a["is_collect"]="1";//已经被收藏
			}else{
				$a["is_collect"]="3";//没有被收藏
			}
		$arr=explode(",",$a["image"]);
		
		for($i1102=0;$i1102<count($arr);$i1102++){
			
			$b01[$i1102]["image"]=$arr[$i1102];
		}
	
		//商品参数   
			$where04=array(
				'goods_id'=>$a["id"],
			);
	
		$canshu=M("specifications")->where($where04)->find();		
		$c=$this->str_to_arr($canshu["title"],$canshu["content"]);
		//dump($c);dump($arr);die;
		
		$where0904["program_id"]=$_GET["program_id"];
		$where0904["cus_openid"]=$_GET["openid"];
		$where0904["order_num"]="0";
		
		$order_num=M("order")->field('buy_num')->where($where0904)->sum("buy_num");//得到购物车商品id数组

		$z=array('k1'=> $a,'k2'=>$b01,'k3'=>$c,'k4'=>$order_num,'k5'=>$where0904);
		
	}
}
		$this->ajaxReturn($z);
	}
	
	//商品分类列表
	public function goods_fl_list(){

		//商品分类列表  
	
		$a=M("attribute")->field('id,uid,title')->where("is_show=1 and attribute_style=1 and program_id='".$_GET["program_id"]."'" )->select();
		
		
		

	$b=$this->bq($a);//分类列表
		$where=array(
			'program_id'=>$_GET["program_id"],
			
			'uid'=>"0"
		);
		$c=M("attribute")->where($where)->order("sort")->find();//第一个分类
		
		$where02=array(
			'program_id'=>$_GET["program_id"],
			'goods_state'=>"1",
			'fenlei_1'=>$c["id"]
		);
		
		$d=M("goods")->field('id,goods_title,image,price_sell')->where($where02)->order("sort")->select();//属于第一个分类的所有商品
		
		for($i=0;$i<count($d);$i++){
			$arr1102=explode(",",$d[$i]['image']);
			$d[$i]["image_first"]=$arr1102[0];
			
		}
		$e=array('k1'=> $b,'k2'=>$d);//分类列表、商品列表
		$this->ajaxReturn($e);
	}
	//商品分类列表
	public function goods_fl_list_ktv(){

		//商品分类列表  
	
		$a=M("attribute")->field('id,uid,title')->where("is_show=1 and attribute_style=1 and uid=1422 and program_id='".$_GET["program_id"]."'" )->select();

		$b=$a;

		$where=array(
			'program_id'=>$_GET["program_id"],			
			'id'=>$b[0]["id"]
		);
//		$c=M("attribute")->where($where)->order("sort")->find();//第一个分类
//		dump($c);die;
		$where02=array(
			'program_id'=>$_GET["program_id"],
			'goods_state'=>"1",
			'fenlei_2'=>$b[0]["id"]
		);
		
		$d=M("goods")->field('id,goods_title,image,price_sell')->where($where02)->order("sort")->select();//属于第一个分类的所有商品

		for($i=0;$i<count($d);$i++){
			$arr1102=explode(",",$d[$i]['image']);
			$d[$i]["image_first"]=$arr1102[0];
			
		}
		$e=array('k1'=> $b,'k2'=>$d);//分类列表、商品列表
		$this->ajaxReturn($e);
	}
	//1212 二级分类
	function feilei_2(){



		$a=M("attribute")->field('id,uid,title,sort,image_1')->where("is_show=1 and attribute_style=1 and program_id='".$_GET["program_id"]."'" )->order("sort")->select();
		
		for($i=0;$i<count($a);$i++){
			if($a[$i]["uid"]==0){
				$c[]=$a[$i];
			}
		}
		$b=$this->bq($a);//分类列表
		
		$dos = array_map(create_function('$n', 'return $n["id"];'), $b);
		array_multisort($dos,SORT_ASC,$b);
		

		$this->ajaxReturn($b); 
	}
	//1212 二级分类的商品列表
	function goods_list(){
		//既然启用了二级分类，那商品都是二级分类下的了

//1213   state 查询条件分五种   
//		classification 	：分类、
//		price_up_dowm	：价格高低、
//		time_u			:上架时间、
//		num_say_yes		:好评、
//		price_area 		:售价区间
//		class_index		:首页推荐分类

		//  state  goods_title 商品标题模糊搜索        none  无分类进来的

		$sql  =" SELECT id,image,sort,goods_title,goods_state,price_sell,fenlei_1,fenlei_2 FROM goods ";
		$sql .=" WHERE goods_state=1 and program_id ='".$_POST["program_id"]."'";
		if($_POST["state"]=="classification"){
			//分类
			$sql .=" and fenlei_2 ='".$_POST["id"]."'";
			
		}else if($_POST["state"]=="price_up_dowm"){	

		}else if($_POST["state"]=="time_u"){
			
		}else if($_POST["state"]=="num_say_yes"){
			
		}else if($_POST["state"]=="price_area"){
			
		}else if($_POST["state"]=="goods_title"){
			$_POST['str']="%".$_POST['str']."%";
			$sql .=" and goods_title like'".$_POST['str']."'";
		}else if($_POST["state"]=="class_index"){
			if($_POST["class_index_id"]==1) $sql .=" and goods_subtitle01 =1";
			if($_POST["class_index_id"]==2) $sql .=" and goods_subtitle02 =1";
			if($_POST["class_index_id"]==3) $sql .=" and goods_subtitle03 =1";	
			if($_POST["class_index_id"]==4) $sql .=" and goods_subtitle04 =1";	
			if($_POST["class_index_id"]==5) $sql .=" and goods_subtitle05 =1";	
			
		}else if($_POST["state"]=="class"){
			$sql .=" and fenlei_1 ='".$_POST['class_id']."'";
	
		}else if($_POST["state"]=="none"){
			//纯粹商品列表，无分类
		}
		$sql .=" order by sort asc ";
		
		$d = M("goods") -> query($sql);
		
		for($i=0;$i<count($d);$i++){
			$arr1102=explode(",",$d[$i]['image']);
			$d[$i]["image_first"]=$arr1102[0];
			
			$attribute[$i]=M("attribute")->where("id='".$d[$i]["fenlei_1"]."'")->find();
			$d[$i]["attribute"]=$attribute[$i]["title"];
		}
		$this->ajaxReturn($d);
	}
	
	
	//ajax 传递商品分类id ，传递回去商品的内容数组
	public function goods_list_ajax(){

		$where=array(
		'fenlei_1'=>$_POST["fenlei_id"],
		'program_id'=>$_POST["program_id"],
		'goods_state'=>"1"
		);
		$a=M("goods")->field('id,image,goods_title,price_sell')->where($where)->select();
		
		for($i=0;$i<count($a);$i++){
			
			/*$id["goods_id"]=$a[$i]['id'];
			$dd=M("goods_img")->field('image')->where($id)->order("time_set")->find();//得到对应商品第一张图片
			$a[$i]["image_first"]=$dd["image"];*/
			
			$arr1102=explode(",",$a[$i]['image']);
			$a[$i]["image_first"]=$arr1102[0];
		}

		$this->ajaxReturn($a);
	}
	public function goods_list_ajax_ktv(){

		$where=array(
		'fenlei_2'=>$_POST["fenlei_id"],
		'program_id'=>$_POST["program_id"],
		'goods_state'=>"1"
		);
		$a=M("goods")->field('id,image,goods_title,price_sell')->where($where)->select();
		
		for($i=0;$i<count($a);$i++){			
			$arr1102=explode(",",$a[$i]['image']);
			$a[$i]["image_first"]=$arr1102[0];
		}

		$this->ajaxReturn($a);
	}
//0904...15.13     购物车列表页重写    购物车实际上就是订单表里面没有订单的数据
	
	//得到 客户的 openid 、小程序 program_id
	public function shopping_car02(){

		$where["program_id"]=$_GET["program_id"];
		$where["cus_openid"]=$_GET["openid"];
		$where["order_num"]=array('eq','0');
		
		$a=M("order")->field('id,goods_id,buy_num,is_use_guige,guige_key02,guige_name02,guige_key,guige_price,guige_name,is_on_lever_price,members_price_discount')->where($where)->select();//得到购物车商品id数组
		
		for($i=0;$i<count($a);$i++){
			$where02["id"]=$a[$i]["goods_id"];
			$goods=M("goods")->field('image,is_use_guige,str_num,number,goods_title,price_sell,goods_subtitle01,goods_subtitle02,goods_subtitle03,goods_subtitle04,goods_subtitle05')->where($where02)->find();
//1212  判断商品是不是使用规格

	if($goods["is_use_guige"]==2){
		//启用规格，库存数量就是规格数量总和
		$num_total=0;
		$arr1212=explode(",",$goods["str_num"]);
		for($u=0;$u<count($arr1212);$u++){
			$num_total+=$arr1212[$u];
		}
		$a[$i]["kucun"]=$num_total;
	}else{
		$a[$i]["kucun"]=$goods["number"];
	}


// 1:热卖、2:新品、3：推荐、4：促销、5：包邮
			if($goods["goods_subtitle01"]==1){
				$a[$i]["shuxing"]=1;
			}else if($goods["goods_subtitle02"]==1){
				$a[$i]["shuxing"]=2;
			}else if($goods["goods_subtitle03"]==1){
				$a[$i]["shuxing"]=3;
			}else if($goods["goods_subtitle04"]==1){
				$a[$i]["shuxing"]=4;
			}else if($goods["goods_subtitle05"]==1){
				$a[$i]["shuxing"]=5;
			}else{
				$a[$i]["shuxing"]=0;
			}

			/*$where03["goods_id"]=$a[$i]["goods_id"];
			$goodsimg=M("goods_img")->field('image')->where($where03)->find();//获取第一张图片
			*/
			$a[$i]["goods_title"]=$goods["goods_title"];
			$a[$i]["price_sell"]=$goods["price_sell"];
			
			//$a[$i]["image"]=$goodsimg["image"];
			
			$arr1102=explode(",",$goods['image']);
			$a[$i]["image"]=$arr1102[0];

			$a[$i]["selected"]=True;
		//$a[$i]["selected"]=False;
			
		}
		if(count($a)>0){
			$b["is_empty"]="2";//为2的时候不是空的
		}else{
			$b["is_empty"]="1";//为1的时候是空的
		}
		
		$c=array('k1'=>$a,'k2'=>$b);
		$this->ajaxReturn($c);
	}
	
	
	
	//客户点击添加商品到购物车中
	public function add_buy_car(){
		//$this->ajaxReturn($_POST);
		// 需要得到小程序id， 客户openid，商品 id ， 商品数量 buy_num  
		if(empty($_POST["program_id"])|empty($_POST["openid"])|empty($_POST["goods_id"])){
			$this->ajaxReturn(array('status'=>4,'msg'=>'数据不全'));
		}
		
		//根据传递过来的商品id，查找出商品是哪个子商户的，把子商户id加入欲购买表中
		$goods0925=M("goods")->field("dsh_id")->where("id='".$_POST["goods_id"]."'")->find();

//如果选中的是有规格的，那应该有  规格键值、规格的名称、规格价格


		/*$where=array(
		'program_id'=>$_POST["program_id"],
		'cus_openid'=>$_POST["openid"],
		'buy_num'=>"1",
		'order_num'=>"0",
		'goods_id'=>$_POST["goods_id"],
		'dsh_id'=>$goods0925["dsh_id"],
		
		'guige_key'=>$_POST["guige_key"],
		'guige_price'=>$_POST["guige_price"],
		'guige_name'=>$_POST["guige_name"],
		
		);*/
		$where["program_id"]=$_POST["program_id"];
		$where["cus_openid"]=$_POST["openid"];
		$where["buy_num"]="1";
		$where["order_num"]="0";
		$where["goods_id"]=$_POST["goods_id"];
		$where["dsh_id"]=$goods0925["dsh_id"];
		
		if($_POST["is_use_guige"]==2){
//是否启用规格（1：不启用（默认）、2：启用） guige_remark
			$where["is_use_guige"]=2;
			$where["guige_key"]=$_POST["guige_key"];
			$where["guige_price"]=$_POST["guige_price"];
			$where["guige_name"]=$_POST["guige_name"];
			$where["guige_remark"]=$_POST["guige_remark"];
			
			$where["guige_key02"]=$_POST["guige_key02"];
			$where["guige_name02"]=$_POST["guige_name02"];
		}else{
			$where["is_use_guige"]=1;
		}
		if($_POST["is_on_lever_price"]==1){
//是否开启会员价格折扣（1：开启、2：不开（默认）
$where["is_on_lever_price"]=1;
			$where["members_price_discount"]=$_POST["members_price_discount"];
		}else{
			$where["is_on_lever_price"]=2;
		}	

		$is_have=M("order")->where($where)->find();
		$where["only_num"]=time().rand(111,999);
	if($_POST["is_pay"]==1){
		//直接购买的
			if(M("order")->add($where)){
					$dd=M("order")->where("only_num='".$where["only_num"]."'")->find();
		      		$data=array('status'=>1,'msg'=>'添加成功','id'=>$dd["id"]);
		      	}else{
		      		$data=array('status'=>2,'msg'=>'添加失败');
		      	}
	
	}else{
//不直接购买的
		if(empty($is_have)){
			if(M("order")->add($where)){
					$dd=M("order")->where("only_num='".$where["only_num"]."'")->find();
		      		$data=array('status'=>1,'msg'=>'添加成功','id'=>$dd["id"]);
		      	}else{
		      		$data=array('status'=>2,'msg'=>'添加失败');
		      	}
		}else{
			$data=array('status'=>3,'msg'=>'已存在购物车内');
		}
	}

		$this->ajaxReturn($data);
	}
	//客户点击  直接购买    默认购物车中
	/*public function add_buy_car_1(){
		// 需要得到小程序id， 客户openid，商品 id ， 商品数量 buy_num  
		$where=array(
		'program_id'=>$_POST["program_id"],
		'cus_openid'=>$_POST["openid"],
		'buy_num'=>"1",
		'order_num'=>"0",
		'goods_id'=>$_POST["goods_id"]
		);
		$is_have=M("order")->where($where)->find();
		if(empty($is_have)){
			if(M("order")->add($where)){
		      		$data=array('status'=>1,'msg'=>'添加成功');
		      	}else{
		      		$data=array('status'=>2,'msg'=>'添加失败');
		      	}
		}else{
			$data=array('status'=>3,'msg'=>'已存在购物车内');
		}
		$this->ajaxReturn($data);
	}*/
	
	//购物车商品是动态变化的，每次前台修改数量，后台数据就必须保存
	public function goods_add01(){
		//需要参数   传递购物车表内  数据id
		
		//商品自增  1
		if(M("order")->where("id='".$_POST["id"]."'")->setInc('buy_num', 1)){
			$data=array('status'=>1,'msg'=>'设置成功');
		}else{
			$data=array('status'=>2,'msg'=>'设置失败');
		}
		$this->ajaxReturn($data);
	}
	
	public function goods_add2(){
		//商品自减  1
		
			//需要参数   传递购物车表内  数据id
		if(M("order")->where("id='".$_POST["id"]."'")->setInc('buy_num', -1)){
			$data=array('status'=>1,'msg'=>'设置成功');
		}else{
			$data=array('status'=>2,'msg'=>'设置失败');
		}
		$this->ajaxReturn($data);
	}
	//商品直接购买下拉框选数值
	public function goods_choose_num(){
			//需要参数   传递购物车表内  数据id
			$save["buy_num"]=$_POST["num"];
		if(M("order")->where("id='".$_POST["id"]."'")->save($save)){
			$data=array('status'=>1,'msg'=>'设置成功');
		}else{
			$data=array('status'=>2,'msg'=>'设置失败');
		}
		$this->ajaxReturn($data);
	}
	//移除购物车
	public function delete_buy_car(){
		//需要购物车id
		if(M("order")->where("id='".$_POST["id"]."'")->delete()){
			$data=array('status'=>1,'msg'=>'移除成功');
		}else{
			$data=array('status'=>2,'msg'=>'移除失败');
		}
		$this->ajaxReturn($data);
		
	}
	
	/*
	 * 订单结算  打开订单页面 (未生成订单号)
	 * 订单页面   需要参数  小程序id  个人 openid 选中购物车中商品id   array_id  integral_total
	 * 0417...15.03 易选购有个别商品可以使用积分现金混合支付，优选专区 goods_subtitle01   判断商品只有优选专区的，返回允许使用积分支付
	 * */

	public function build_order(){
		//得到默认收货地址
		$where["state"]="1";
		$where["is_used"]="1";
		$where["openid"]=$_GET["openid"];
		$where["program_id"]=$_GET["program_id"];
		
		$a=M("man_shouhuo")
		->field('id,man_shouhuo,man_phone,man_address')
		->where($where)
		->find();
//	$_GET["array_id"]=array(19,21);
//	购物车商品
		$where022['id']=array('in',$_GET["array_id"]);
		$b=M("order")->field('id,goods_id,buy_num,guige_key,guige_key02,guige_name02,guige_remark,guige_price,guige_name,is_use_guige,is_on_lever_price,members_price_discount')->where($where022)->select();//得到购物车商品id数组

		$goods_price=0;//商品总价
		$goods_payintegral=0;//商品支付积分
		$can_pay_integral=0;//易选购		商品是否可用积分支付判断
		$can_pay_integral_by=0;//百业联盟平台	商品是否可用积分支付判断
		
//		百业联盟平台  对子商户商品是否使用消费券   1：都是同一个商户商品（先做单个商品的），2：个人有未使用完的消费券		0710改，消费券针对全平台使用
		if($_GET["program_id"]=="JT201806151732369242"){
			if(count($b)==1){	
//				$goods_0806=M("goods")->field("dsh_id")->where("id='".$b[0]["goods_id"]."'")->find();
				$dsh_qdcode_chage0806=M("coupon_dsh_record")->field("coupon_num")->where("state =0 and openid='".$_GET["openid"]."'")->count();
				if($dsh_qdcode_chage0806>0){	
					$havecoupon_num=1;//有消费券
				}else{
					$havecoupon_num=0;//无消费券
				}
				$havecoupon_number=$dsh_qdcode_chage0806;
			}	
//			消费券单价
			$coupon_dsh_price=M("store")->field('coupon_dsh_price,base_price')->where("program_id='".$_GET["program_id"]."'")->find();
		}		
		
		for($i=0;$i<count($b);$i++){
			$where02["id"]=$b[$i]["goods_id"];
			$goods[$i]=M("goods")->field('id,cost,kezhong,fenlei_1,fenlei_2,price_sell_1,price_sell_2,json_price_cl,guige_json_price_cl,fenlei_zhekou,is_on_mixpay,image,goods_title,price_sell,integral_sell,goods_subtitle01,goods_subtitle02,goods_subtitle03,goods_subtitle04,goods_subtitle05,is_on_wholesale_discount')->where($where02)->find();
		
			if($_GET["program_id"]=="JT201802032149345468"){
//				易选购				
				if($goods[$i]["goods_subtitle01"]=="2"){
					$can_pay_integral=$can_pay_integral+1;
				}
			}
			if($_GET["program_id"]=="JT201806151732369242"){
//				百业联盟平台				
				if($goods[$i]["is_on_mixpay"]=="1"){
					$can_pay_integral_by=$can_pay_integral_by+1;
				}
			}

		if($goods[$i]["is_on_wholesale_discount"]==1){
			//是否开启批发价（1、开启、2：关闭(默认）
			//$wholesale_d	
			$wholesale_discount[$i]=M("wholesale_discount")->where("goods_id='".$goods[$i]["id"]."'")->select();

			for($q1216=0;$q1216<count($wholesale_discount[$i]);$q1216++){
				$num_1=$b[$i]["buy_num"];
				$num_2=$wholesale_discount[$i][$q1216]["num_start"];
				$num_3=$wholesale_discount[$i][$q1216]["num_end"];
				
				if(($num_1>$num_2 | $num_1==$num_2) & $num_1<$num_3){
					$wholesale_d=	$wholesale_discount[$i][$q1216]["discount"];
				}
			}
	
		}else{
			$wholesale_d="1";
		}
		
		if(strpos($wholesale_d,"/")){
			
			$arr0115=explode("/",$wholesale_d);
			$wholesale_d=$arr0115[0]/$arr0115[1];
		}else{
			$wholesale_d;
		}	

			if($b[$i]["is_use_guige"]==1){
			//不启用规格
				if($b[$i]["is_on_lever_price"]==1){
					//启用会员等级价格
					$goods_price +=$goods[$i]["price_sell"]*$b[$i]["buy_num"]*$b[$i]["members_price_discount"]*$wholesale_d;
					$b[$i]["price_sell"]=$goods[$i]["price_sell"]*$b[$i]["members_price_discount"]*$wholesale_d;//商品单价
				}else{
					//不启用等级价格
				//	dump($goods[$i]["price_sell"]*$b[$i]["buy_num"]);die;
					$goods_price +=$goods[$i]["price_sell"]*$b[$i]["buy_num"]*$wholesale_d;
					$b[$i]["price_sell"]=$goods[$i]["price_sell"]*$wholesale_d;//商品单价
				}
	
			}else{
			//启用规格
				if($b[$i]["is_on_lever_price"]==1){
					//启用会员等级价格
					$goods_price +=$b[$i]["guige_price"]*$b[$i]["buy_num"]*$b[$i]["members_price_discount"]*$wholesale_d;
					$b[$i]["price_sell"]=$b[$i]["guige_price"]*$b[$i]["members_price_discount"]*$wholesale_d;//商品单价
				}else{
					//不启用等级价格	
					$goods_price +=$b[$i]["guige_price"]*$b[$i]["buy_num"]*$wholesale_d;
					$b[$i]["price_sell"]=$b[$i]["guige_price"]*$wholesale_d;//商品单价
				}	
				
				
				$arr_zb[$i]=explode("&",$goods[$i]["guige_json_price_cl"]);
				

				$goods[$i]["guige_cailiao"]=json_decode($arr_zb[$i][$b[$i]["guige_key"]],true);

			
			}

			$goods_payintegral=$goods[$i]["integral_sell"]*$b[$i]["buy_num"];
			$arr1102=explode(",",$goods[$i]['image']);
			$b[$i]["image"]=$arr1102[0];
			
			$b[$i]["goods_title"]=$goods[$i]["goods_title"];	
			$b[$i]["cost"]=$goods[$i]["cost"];
			$b[$i]["fenlei_zhekou"]=$goods[$i]["fenlei_zhekou"];
			

			$b[$i]["kezhong"]=$goods[$i]["kezhong"];
			$b[$i]["price_sell_1"]=$goods[$i]["price_sell_1"];
			$b[$i]["price_sell_2"]=$goods[$i]["price_sell_2"];
			$b[$i]["json_price_cl"]=$goods[$i]["json_price_cl"];
			$b[$i]["guige_json_price_cl"]=$goods[$i]["guige_json_price_cl"];
			$b[$i]["fenlei_1"]=$goods[$i]["fenlei_1"];
			$b[$i]["fenlei_2"]=$goods[$i]["fenlei_2"];
			
			$b[$i]["guige_cailiao"]=$goods[$i]["guige_cailiao"];
		}
//dump($b);die;
		//调用个人优惠券 time_over
		$field='
		preferential_record.id as pre_id,preferential_record.num,preferential_record.preferential_id,

		preferential.title,preferential.image,preferential.conditions,preferential.pre_price	
		';
		$preferential=M("preferential_record")
		->field($field)
		->join('left join preferential ON preferential_record.preferential_id=preferential.id')
		->where("preferential_record.openid='".$_GET["openid"]."'"." and preferential_record.program_id='".$_GET["program_id"]."'")->group("preferential_id")->select();
	
		for($u=0;$u<count($preferential);$u++){
			if($preferential[$u]["num"]>0){
				$arr1116[]=$preferential[$u];
			}
		}
	    $members=M("members")->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();
    	$member_level=M("member_level")->where("id='".$members["level_id"]."'")->find();
    	$members["lever_info"]=$member_level;
    	
    	$lever_pay=M("fx_goods_buy")->where("program_id='".$_GET["program_id"]."'"."and lever_id='".$members["vip_id"]."'")->select();

        $members["integral_total"]=$members["integral"]+$members["integral_song"];
        $members["pey_way"]=$lever_pay;
           
//        订单改价过来的     回传订单改价的价格，不再享受任何折扣
     	if($_GET["order_num"]){
     		$change_price=M("order_form")->field("change_price")->where("order_num='".$_GET["order_num"]."'")->find();
     	}
              
              
		$c=array('k0'=>$goods_price,'k0_integralpay'=>$goods_payintegral,'k1'=>$a,'k2'=>$b,'k3'=>$arr1116,'k4'=>$members,'k5'=>$can_pay_integral,'change_price'=>$change_price["change_price"]);
		if($_GET["program_id"]=="JT201806151732369242"){
			$c["havecoupon_num"]	=$havecoupon_num;
			$c["havecoupon_number"]	=$havecoupon_number;//消费券剩余数量
			
			$c["coupon_dsh_price"]=$coupon_dsh_price["coupon_dsh_price"];
			$c["base_price"]		=$coupon_dsh_price["base_price"];
			$c["can_pay_integral_by"]=$can_pay_integral_by;//是否可用使用积分支付

		}	
		if($_GET["program_id"]=="JT201809281046283422"){
  //曼面山单丛茶   子商户购买商品享受折扣			
			$user_info_dsh=M("user_info_dsh")->field("sh_zhekou")->where("state=3 and openid='".$_GET["openid"]."'"."and program_id='".$_GET["program_id"]."'")->find();     
      		if($user_info_dsh){
      			$c["sh_zhekou"]		=$user_info_dsh["sh_zhekou"];
      		}else{
      			$c["sh_zhekou"]		=100;
      		}
      		
			
		}	
		if($_GET["program_id"]=="JT201710101645145951"){
//兰倩美容抵扣券	
			$rebate_record=M("rebate_record")->where("state=0 and openid='".$_GET["openid"]."'"."and program_id='".$_GET["program_id"]."'")->find();     
      	
      		if($rebate_record){
      			$c["dikou_price"]		=$rebate_record["price"];
      			$c["dikou_price_id"]		=$rebate_record["id"];
      		}else{
      			$c["dikou_price"]		=0;
      		}

		}	
		
		$this->ajaxReturn($c);
	}
	//订单页面管理 收货地址
	function order_choose_address(){

		$where=array(
			'openid'=>$_GET["openid"],
			'is_used'=>"1",
			'program_id'=>$_GET["program_id"],
		);
		 $list=M('man_shouhuo')
      	->field('id,man_shouhuo,man_phone,man_area,state')
      	->where($where)->select();

      	$this->ajaxReturn($list);
	}
	
	//订单提交  生成订单号-----------------------------------------------------------------------
	public function order_submin(){	
//是否使用优惠券   use_pre（1：使用、2：不适用） 优惠券id   preferential_id
		
	if(!empty($_POST["order_num12138"])){
		//去支付过来的  有订单号，有可能价格修改 from_id
	}
		
	$_POST["state"]="1";
	$_POST["xiadan_time"]=time();
	
	$se=$this->chaifen($_POST["array_id"]);	
	for($k=0;$k<count($se)-1;$k++){
			$get_arr_id[$k]=$se[$k];
	}

	$where022['id']=array('in',$get_arr_id);//预购买数组
//	implode(',',$getid)
//	$b=M("order")->field('id,order_num,goods_id,buy_num,dsh_id,guige_key,guige_price,guige_name,is_on_lever_price,members_price_discount')->where($where022)->select();//得到购物车商品id数组
	$b=M("order")->where($where022)->select();//得到购物车商品id数组
	//去支付的不能改变订单号 

	for($e=0;$e<count($b);$e++){
		$where020["id"]=$b[$e]["goods_id"];
		$goods0925=M("goods")->field('price_sell')->where($where020)->find();
		
		if($goods0925["is_on_wholesale_discount"]==1){
//			是否开启批发价（1、开启、2：关闭(默认）
//			$wholesale_d	
			$wholesale_discount=M("wholesale_discount")->where("goods_id='".$goods0925["id"]."'")->select();
			for($q1216=0;$q1216<count($wholesale_discount);$q1216){
				if(($b[$e]["buy_num"]>$wholesale_discount[$q1216]["num_start"] | $b[$e]["buy_num"]==$wholesale_discount[$q1216]["num_start"]) & $b[$e]["buy_num"]<$wholesale_discount[$q1216]["num_end"]){
					$wholesale_d=	$wholesale_discount[$q1216]["num_start"];
				}
			}	
		}else{
			$wholesale_d="1";
		}
		if(empty($b[$e]["guige_key"])){
			if($b[$e]["is_on_lever_price"]==1){
				//开启会员折扣价
				$b[$e]["price_sell"]=$goods0925["price_sell"]*$wholesale_d*$b[$e]["members_price_discount"];
			}else if($b[$e]["is_on_lever_price"]==2){
				$b[$e]["price_sell"]=$goods0925["price_sell"]*$wholesale_d;
			}
		}else{
			if($b[$e]["is_on_lever_price"]==1){
				//开启会员折扣价
				$b[$e]["price_sell"]=$b[$e]["guige_price"]*$wholesale_d*$b[$e]["members_price_discount"];
			}else if($b[$e]["is_on_lever_price"]==2){
				$b[$e]["price_sell"]=$b[$e]["guige_price"]*$wholesale_d;
			}
		}
	}
//	得到欲购买的表id，判断他们是属于哪个商户的，每一个商户生成一个订单号
	$ar=array();
	foreach($b as $v){
	    if(empty($ar) || !in_array($v,$ar)){
            $ar[$v['dsh_id']][$v['id']]=$v;
        }else{
            foreach($ar as $ka=>$va){
                if($ka==$v['dsh_id']){
                    $ar[$ka][$v['id']]=$v;
                }
            }
        }
	}
$group_order="jt".time().rand(1111,9999);//订单分组标识
	foreach($ar as $key=>$val){
//这里就是对应着每一个子商户账号的内容了++++++++++++++这里面是该商户内所有的选中的欲购买的内容，是数组    这些数组公用一个订单号++++++++++++++++++++++++++++++
	$dsh_id=$key;
	$goods_price=0;//商品总价

//	获得子店铺id，接下来是获得这个子店铺商品的数组（最后加逗号）
//	dump($q);//这样就得到了对应的子店铺的 id
	foreach($val as $k=>$v){
		$goods_price+=$v["price_sell"]*$v["buy_num"];  
	}
	if($_POST["use_pre"]==1){
		//使用优惠券
		$get_date["preferential_id"]=$_POST["preferential_id"];//使用优惠券id
		$a1116=M("preferential")->where("id='".$_POST["preferential_id"]."'")->find();
		
		$goods_price=$goods_price-$a1116["pre_price"];
		
		$q1116=M("preferential_record")->where("openid='".$_POST["openid"]."'"." and program_id='".$_POST["program_id"]."'"."and preferential_id='".$_POST["preferential_id"]."'")->find();
		
		if($q1116["num"]>0){
			M("preferential_record")->where("openid='".$_POST["openid"]."'"." and program_id='".$_POST["program_id"]."'"."and preferential_id='".$_POST["preferential_id"]."'")->setInc("num",-1);
		}		
	}
	foreach($val as $k1=>$v1){
	      $newArr[$key][$k1] = $k1;
	}
	$newArr[$key]["str"]= implode(",",$newArr[$key]).",";//得到预购商品数组++++++++++++++
//	echo $goods_price; echo "<hr>";
//	$newArr[$key]["str"] = substr($newArr[$key]["str"],0,strlen($newArr[$key]["str"])-1); //去掉最后一个逗号
	if(!empty($_POST["order_num12138"])){
		//去支付过来的  有订单号，有可能价格修改
		$_POST["order_num"]=$_POST["order_num12138"];
	}else{
		$_POST["order_num"]="JT".date("YmdHis",time()).rand(111111,999999);
	}

	$_POST["group_order"]=$group_order;
	$is_only["order_num"]=$_POST["order_num"];
	$bb=M("order")->where($is_only)->find();//用来判断是不是已经添加了
	//dump($_POST);dump($b);die;
if(1){
	$array_id["id"]=array('in',$newArr[$key]["str"]);	
	$is_order=M("order")->where($array_id)->select();
    $fx_info=M("fx_info")->where("program_id='".$_POST["program_id"]."'")->find();//小程序分销设置

		for($i=0;$i<count($is_order);$i++){
			if($is_order[$i]["order_num"] !=0 ){
				$data=array('status'=>6,'msg'=>'对不起，无法购买!您已经从购物车购买过此商品，如需再次购买，请先从购物车中删除');
				exit();
			}else{

				//对单个预购买进行分销判定
            if($fx_info["is_on_fenxiao"]==1){
                //判断是否开启分销、开了就执行，不开就没啥操作
                if($_POST["from_id"]==0){
					//正常进入 ---
					if($fx_info["is_globle_fenxiao"]==1){
						//开启全局分销，所有商品参与分销
					}else if($fx_info["is_globle_fenxiao"]==2){
						//关闭全局分销，指定商品才能有分销返点
					}
					if($fx_info["neigou"]==1){
						//分销内购（1开启2关闭）   内购打开的话，自己成为自己的购买者，该订单添加自己的id成为分销商id，添加1/2/3分销价格
						$members092818=M("members")->where("openid='".$_POST["openid"]."'"." and program_id='".$_POST["program_id"]."'")->find();		
						if($members092818["fx_state"]==2){
							//分销商自己从页面进来
							$order1211["dfx_id"]=$members092818["id"];//用来写在订单里的
							$where0928["members.id"]=$members092818["id"];//用来查询的 分销佣金比例的
						}else{
							//进来的不是分销商
							$order1211["dfx_id"]="0";
							$where0928["members.id"]="0";
						}
					}else{
						$order1211["dfx_id"]="0";//用来写在订单里的  
						$where0928["members.id"]="0";//用来查询的 分销佣金比例的  如果是零，之后就标识查不到这个会员
					}
				}else{
					//扫码进入分销商进入  产生的订单都是属于这个分销商的
			
					$order1211["dfx_id"]=$_POST["from_id"];
					$where0928["members.id"]=$_POST["from_id"];
				}
					 $members1211=M("members")
					->field('
					members.id as members_id,members.fx_lever_id,
					fx_lever.id as fx_lever_id,fx_lever.bl_lever_1,fx_lever.bl_lever_2,fx_lever.bl_lever_3')
					->where("members.id='".$where0928["members.id"]."'")
					->join('left join fx_lever ON fx_lever.id=members.fx_lever_id')
					->find();
			//	dump($members1211);dump(M("members")->_sql());die;
                if($fx_info["is_globle_fenxiao"]==1){
            
                    //开启全局分销，所有商品参与分销
                    //判断当前商品对应的会员等级分销是多少，没开会员等级分销的就调用全局分销比例============1211 取消
                  
                  // is_fenxiao 是否参与分销专区（1：参与、2：不参与(默认）
                  
                  //==================蔡氏养生的分销特殊处理==============================================================
                  if($_POST["program_id"]=="JT201712021113483120"){
                  
                  	//查询上级的代理等级（上两级）、消费等级、判断调用哪个分销佣金
                  	$buy_id=0;
                  	if($is_order[$i]["buy_num"]==5) $buy_id=1;
                  	if($is_order[$i]["buy_num"]==100) $buy_id=2;
                  	if($is_order[$i]["buy_num"]==1000) $buy_id=3;
                 
                  	if($buy_id!=0){
                  		$members0115=M("members")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'")->find();
               
		                  $fx_price_independent=M("fx_price_independent")->where("program_id='".$_POST["program_id"]."'")->select();//代理分销佣金表
		                  
		                  // $fx_buy_independent=M("fx_buy_independent")=M("program_id='".$_POST["program_id"]."'")->select();//购买等级表
		                     //  dump($members0115);die;
	                  if($members0115["daili_uid_csys"]!=0){
	                  	//一级代理
	                  	$members0115_1=M("members")->where("id='".$members0115["daili_uid_csys"]."'")->find();
	
	                  	for($i0115=0;$i0115<count($fx_price_independent);$i0115++){
	                  		if($fx_price_independent[$i0115]["fx_price_lever"]==1){
	                  			if($fx_price_independent[$i0115]["buy_id"]==$buy_id & $members0115_1["daili_lever_csys"]==$fx_price_independent[$i0115]["lever_id"]){
	                  				$order1211["dfx_price01"]=$fx_price_independent[$i0115]["price_fy"];//一级分销佣金
	                  			}
	                  		}
	                  	}
	                  }
		                 
		                  if($members0115_1["daili_uid_csys"]!=0){
		                  	//二级代理
		                  	$members0115_2=M("members")->where("id='".$members0115_1["daili_uid_csys"]."'")->find();
		                
		                    for($i0115_2=0;$i0115_2<count($fx_price_independent);$i0115_2++){
		                  		if($fx_price_independent[$i0115_2]["fx_price_lever"]==2){
		                  			if($fx_price_independent[$i0115_2]["buy_id"]==$buy_id & $members0115_2["daili_lever_csys"]==$fx_price_independent[$i0115_2]["lever_id"]){
		                  				$order1211["dfx_price02"]=$fx_price_independent[$i0115_2]["price_fy"];//二级分销佣金
		                  			}
		                  		}
		                  	}	
		                  }    
                  	}
                  }else{               
					$order1211["dfx_price01"]=$goods_price*$members1211["bl_lever_1"]*0.01;
					$order1211["dfx_price02"]=$goods_price*$members1211["bl_lever_2"]*0.01;
					$order1211["dfx_price03"]=$goods_price*$members1211["bl_lever_3"]*0.01;
                  }
                
                }else if($fx_info["is_globle_fenxiao"]==2){
                    //关闭全局分销，指定商品才能有分销返点 is_on_self_fx
                    
                     $goods1209= M("goods")->where("id='".$is_order[$i]["goods_id"]."'")->find(); 
                   		//该商品参与分销*/
                   		if($goods1209["is_on_self_fx"]==1){
                       	//使用单独商品的分销比例
                       	$order1211["dfx_price01"]=$goods_price*$goods1209["bl_lever_1"]*0.01;
						$order1211["dfx_price02"]=$goods_price*$goods1209["bl_lever_2"]*0.01;
						$order1211["dfx_price03"]=$goods_price*$goods1209["bl_lever_3"]*0.01;
						//	 dump(111);dump($order1211);die;
                       }else{
                       	//使用全局的分销比例
                       	$order1211["dfx_price01"]=$goods_price*$members1211["bl_lever_1"]*0.01;
						$order1211["dfx_price02"]=$goods_price*$members1211["bl_lever_2"]*0.01;
						$order1211["dfx_price03"]=$goods_price*$members1211["bl_lever_3"]*0.01;
						// dump(222);dump($order1211);die;
                       }
                }       

				M("order")->where("id='".$is_order[$i]["id"]."'")->save($order1211);
			}
			}
			
		}

//判断是不是分销商进来的、然后判断是不是有内销功能=====0928=======0928==========0928===========0928==========0928

	
	if(M("order")->where($array_id)->save($_POST)){
	
		$get_date["program_id"]=$_POST["program_id"];	//小程序id
		$get_date["order_num"]=$_POST["order_num"];		//订单号

        $get_date["group_order"]=$_POST["group_order"];


		$get_date["openid"]=$_POST["openid"];			//个人标识
		$get_date["array_id"]=$newArr[$key]["str"];		//购物车商品数组
	//	$get_date["array_id"]=$get_arr_id;				//购物车商品数组
		
		$get_date["dsh_id"]=$dsh_id;			  		//子商户id
		$get_date["shouhuo_id"]=$_POST["shouhuo_id"];	//收货地址id
		$get_date["remark"]=$_POST["remark"];			//备注
		$get_date["fapiao_taitou"]=$_POST["fapiao_taitou"];//发票抬头
		$get_date["buy_price"]=$goods_price;			//订单价格
		$get_date["time_build"]=time();					//订单创建时间
		
		if($_POST["use_pre"]==1){
			//使用优惠券
			$get_date["preferential_id"]=$_POST["preferential_id"];//使用优惠券id
		}
	$get_date["real_price"]=$_POST["real_price"];	
	$get_date["pay_integral"]=$_POST["pay_integral"];	
	$get_date["is_pay_choose"]=$_POST["is_pay_choose"];	
	
	$get_date["zhuanfa_id"]=$_POST["from_id"];	//分享  的上线  分为vip和一般人
		
		$is_have_v=M("order_form")->where("order_num='".$get_date["order_num"]."'")->find();
		if(1){
			
		if(!empty($_POST["order_num12138"])){
			//去支付过来的  有订单号，有可能价格修改
			M("order_form")->where("order_num='".$_POST["order_num12138"]."'")->save($get_date);
		}else{
			M("order_form")->add($get_date);
		}
				
			
				$data=array('status'=>1,'msg'=>'提交成功','roder_num'=>$_POST["order_num"]);
			}else{
				$data=array('status'=>2,'msg'=>'提交失败');
			}
		}else{
			$data=array('status'=>3,'msg'=>'请勿重复提交');
		}
	}
		
	//生成订单的商品减库存
		for($p=0;$p<count($b);$p++){
			$goods_num_d["id"]=$b[$p]["goods_id"];
			M("goods")->where($goods_num_d)->setInc('number', -$b[$p]["buy_num"]);
		}

		

	}
	
	$this->ajaxReturn($data);
	
	}

	/*
	 * 0625模板整理之后使用
	 * 订单提交  生成订单号-----------------------------------------------------------------------
	 * */
	public function order_submin_n(){	
		//是否使用优惠券   use_pre（1：使用、2：不适用） 优惠券id   preferential_id

		$_POST["state"]="1";
		$_POST["xiadan_time"]=time();
		
		$se=$this->chaifen($_POST["array_id"]);	
		for($k=0;$k<count($se)-1;$k++){
			$get_arr_id[$k]=$se[$k];
		}
		$where022['id']=array('in',$get_arr_id);//预购买数组
//	implode(',',$getid)
//	$b=M("order")->field('id,order_num,goods_id,buy_num,dsh_id,guige_key,guige_price,guige_name,is_on_lever_price,members_price_discount')->where($where022)->select();//得到购物车商品id数组
		$b=M("order")->where($where022)->select();//得到购物车商品id数组
//	去支付的不能改变订单号 
		for($e=0;$e<count($b);$e++){
				$where020["id"]=$b[$e]["goods_id"];
				$goods0925=M("goods")->where($where020)->find();
			
			if($goods0925["is_on_wholesale_discount"]==1){
					//是否开启批发价（1、开启、2：关闭(默认）
					//$wholesale_d	
					$wholesale_discount=M("wholesale_discount")->where("goods_id='".$goods0925["id"]."'")->select();
					for($q1216=0;$q1216<count($wholesale_discount);$q1216){
						if(($b[$e]["buy_num"]>$wholesale_discount[$q1216]["num_start"] | $b[$e]["buy_num"]==$wholesale_discount[$q1216]["num_start"]) & $b[$e]["buy_num"]<$wholesale_discount[$q1216]["num_end"]){
							$wholesale_d=	$wholesale_discount[$q1216]["num_start"];
						}
					}	
			}else{
				$wholesale_d="1";
			}
		
			if(empty($b[$e]["guige_key"])){
				if($b[$e]["is_on_lever_price"]==1){
					//开启会员折扣价
					$b[$e]["price_sell"]=$goods0925["price_sell"]*$wholesale_d*$b[$e]["members_price_discount"];
				}else if($b[$e]["is_on_lever_price"]==2){
					$b[$e]["price_sell"]=$goods0925["price_sell"]*$wholesale_d;
				}
				
			}else{
				if($b[$e]["is_on_lever_price"]==1){
					//开启会员折扣价
					$b[$e]["price_sell"]=$b[$e]["guige_price"]*$wholesale_d*$b[$e]["members_price_discount"];
				}else if($b[$e]["is_on_lever_price"]==2){
					$b[$e]["price_sell"]=$b[$e]["guige_price"]*$wholesale_d;
				}				
			}	
		}

//得到欲购买的表id，判断他们是属于哪个商户的，每一个商户生成一个订单号
		$ar=array();
		foreach($b as $v){
		    if(empty($ar) || !in_array($v,$ar)){
		            $ar[$v['dsh_id']][$v['id']]=$v;
		    }else{
	            foreach($ar as $ka=>$va){
	                if($ka==$v['dsh_id']){
	                    $ar[$ka][$v['id']]=$v;
	                }
	            }
		    }
		}
		$group_order="jt".time().rand(1111,9999);//订单分组标识
		foreach($ar as $key=>$val){
//这里就是对应着每一个子商户账号的内容了++++++++++++++这里面是该商户内所有的选中的欲购买的内容，是数组    这些数组公用一个订单号++++++++++++++++++++++++++++++

			$dsh_id=$key;
			$goods_price=0;//商品总价

//获得子店铺id，接下来是获得这个子店铺商品的数组（最后加逗号）
//dump($q);//这样就得到了对应的子店铺的 id
			foreach($val as $k=>$v){
				$goods_price+=$v["price_sell"]*$v["buy_num"];  
			}
			if($_POST["use_pre"]==1){
				//使用优惠券
					$get_date["preferential_id"]=$_POST["preferential_id"];//使用优惠券id
				$a1116=M("preferential")->where("id='".$_POST["preferential_id"]."'")->find();
				
				$goods_price=$goods_price-$a1116["pre_price"];
				
				$q1116=M("preferential_record")->where("openid='".$_POST["openid"]."'"." and program_id='".$_POST["program_id"]."'"."and preferential_id='".$_POST["preferential_id"]."'")->find();
				
				if($q1116["num"]>0){
					M("preferential_record")->where("openid='".$_POST["openid"]."'"." and program_id='".$_POST["program_id"]."'"."and preferential_id='".$_POST["preferential_id"]."'")->setInc("num",-1);
				}
					
			}
			foreach($val as $k1=>$v1){
			      $newArr[$key][$k1] = $k1;
			}
		
			$newArr[$key]["str"]= implode(",",$newArr[$key]).",";//得到预购商品数组++++++++++++++
//echo $goods_price; echo "<hr>";
//$newArr[$key]["str"] = substr($newArr[$key]["str"],0,strlen($newArr[$key]["str"])-1); //去掉最后一个逗号
//			if(!empty($_POST["order_num12138"])){
//				//去支付过来的  有订单号，有可能价格修改
//				$_POST["order_num"]=$_POST["order_num12138"];
//			}else{
//				$_POST["order_num"]="JT".date("YmdHis",time()).rand(111111,999999);
//			}
	
		$_POST["order_num"]="JT".date("YmdHis",time()).rand(111111,999999);
	
			$_POST["group_order"]=$group_order;
			$is_only["order_num"]=$_POST["order_num"];
			$bb=M("order")->where($is_only)->find();//用来判断是不是已经添加了


if(1){
	$array_id["id"]=array('in',$newArr[$key]["str"]);
	$is_order=M("order")->where($array_id)->select();
    $fx_info=M("fx_info")->where("program_id='".$_POST["program_id"]."'")->find();//小程序分销设置
    
   
		for($i=0;$i<count($is_order);$i++){
			if($is_order[$i]["order_num"] !=0 ){
				$data=array('status'=>6,'msg'=>'对不起，无法购买!您已经从购物车购买过此商品，如需再次购买，请先从购物车中删除');
				exit();
			}else{
				//对单个预购买进行分销判定
            if($fx_info["is_on_fenxiao"]==1){
                //判断是否开启分销、开了就执行，不开就没啥操作   0825 解决问题1：之前分销按照当前人上线的分销等级计算分销佣金，2：不是扫码进来的但是已经有分销关系的不会进行分销结算
                
                $members180825=M("members")->field("fx_state,fx_uid,fx_lever_id")->where("openid='".$_POST["openid"]."'"." and program_id='".$_POST["program_id"]."'")->find();
//              if($members180825["fx_state"]==2){
//              	//付款人是分销商，可以触发分销机制
//              	if($fx_info["is_globle_fenxiao"]==1){
//						//开启全局分销，所有商品参与分销
//					}else if($fx_info["is_globle_fenxiao"]==2){
//						//关闭全局分销，指定商品才能有分销返点
//					}
//					
//					$order1211["dfx_id"]	=$members180825["fx_uid"];
//					$where0928["members.id"]=$members180825["fx_uid"];
//              }else{
//              	//不是分销商，就算是扫码之后支付的，也没用，扫码只能用于建立分销关系
//              	$order1211["dfx_id"]	=$members180825["fx_uid"];
//					$where0928["members.id"]=$members180825["fx_uid"];
//              }

                $order1211["dfx_id"]	=$members180825["fx_uid"];//是0 就没上线，不是0就是有上线
				$where0928["members.id"]=$members180825["fx_uid"];
         
//              if($_POST["from_id"]==0){
//					//正常进入 ---
//					if($fx_info["is_globle_fenxiao"]==1){
//						//开启全局分销，所有商品参与分销
//					}else if($fx_info["is_globle_fenxiao"]==2){
//						//关闭全局分销，指定商品才能有分销返点
//					}
//					if($fx_info["neigou"]==1){
//						//分销内购（1开启2关闭）   内购打开的话，自己成为自己的购买者，该订单添加自己的id成为分销商id，添加1/2/3分销价格
//						$members092818=M("members")->where("openid='".$_POST["openid"]."'"." and program_id='".$_POST["program_id"]."'")->find();
//						
//						if($members092818["fx_state"]==2){
//							//分销商自己从页面进来
//							$order1211["dfx_id"]=$members092818["id"];//用来写在订单里的
//							$where0928["members.id"]=$members092818["id"];//用来查询的 分销佣金比例的
//						}else{
//							//进来的不是分销商
//							$order1211["dfx_id"]="0";
//							$where0928["members.id"]="0";
//						}
//			
//					}else{
//						$order1211["dfx_id"]="0";//用来写在订单里的  
//						$where0928["members.id"]="0";//用来查询的 分销佣金比例的  如果是零，之后就标识查不到这个会员
//					}
//				}else{
//					
//					//扫码进入分销商进入  产生的订单都是属于这个分销商的
//					$order1211["dfx_id"]	=$_POST["from_id"];
//					$where0928["members.id"]=$_POST["from_id"];
//				}
				
				//个人的分销等级，调用分销的比例
				if($members180825["fx_uid"]==0){
					if($_POST["from_id"]){
						$members1211=$this->member_fx_lever($members_id=$_POST["from_id"]);
					}
				}else{
					$members1211=$this->member_fx_lever($members_id=$where0928["members.id"]);
				}
				

                if($fx_info["is_globle_fenxiao"]==1){
       
                    //开启全局分销，所有商品参与分销
                    //判断当前商品对应的会员等级分销是多少，没开会员等级分销的就调用全局分销比例============1211 取消
                  
                  // is_fenxiao 是否参与分销专区（1：参与、2：不参与(默认）
                  
                  //==================蔡氏养生的分销特殊处理==============================================================
                  if($_POST["program_id"]=="JT201712021113483120"){
                  
                  	//查询上级的代理等级（上两级）、消费等级、判断调用哪个分销佣金
                  	$buy_id=0;
                  	if($is_order[$i]["buy_num"]==5) $buy_id=1;
                  	if($is_order[$i]["buy_num"]==100) $buy_id=2;
                  	if($is_order[$i]["buy_num"]==1000) $buy_id=3;
                 
                  	if($buy_id!=0){
                  		$members0115=M("members")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'")->find();
               
		                  $fx_price_independent=M("fx_price_independent")->where("program_id='".$_POST["program_id"]."'")->select();//代理分销佣金表
		                  
		                  // $fx_buy_independent=M("fx_buy_independent")=M("program_id='".$_POST["program_id"]."'")->select();//购买等级表
		                     //  dump($members0115);die;
		                  if($members0115["daili_uid_csys"]!=0){
		                  	//一级代理
		                  	$members0115_1=M("members")->where("id='".$members0115["daili_uid_csys"]."'")->find();
		
		                  	for($i0115=0;$i0115<count($fx_price_independent);$i0115++){
		                  		if($fx_price_independent[$i0115]["fx_price_lever"]==1){
		                  			if($fx_price_independent[$i0115]["buy_id"]==$buy_id & $members0115_1["daili_lever_csys"]==$fx_price_independent[$i0115]["lever_id"]){
		                  				$order1211["dfx_price01"]=$fx_price_independent[$i0115]["price_fy"];//一级分销佣金
		                  			}
		                  		}
		                  	}
		                  }
		                 
		                  if($members0115_1["daili_uid_csys"]!=0){
		                  	//二级代理
		                  	$members0115_2=M("members")->where("id='".$members0115_1["daili_uid_csys"]."'")->find();
		                
		                    for($i0115_2=0;$i0115_2<count($fx_price_independent);$i0115_2++){
		                  		if($fx_price_independent[$i0115_2]["fx_price_lever"]==2){
		                  			if($fx_price_independent[$i0115_2]["buy_id"]==$buy_id & $members0115_2["daili_lever_csys"]==$fx_price_independent[$i0115_2]["lever_id"]){
		                  				$order1211["dfx_price02"]=$fx_price_independent[$i0115_2]["price_fy"];//二级分销佣金
		                  			}
		                  		}
		                  	}	
		                  }
		                  
		                  
                  	}

                  }else{
					$order1211["dfx_price01"]=$goods_price*$members1211["bl_lever_1"]*0.01;
					$order1211["dfx_price02"]=$goods_price*$members1211["bl_lever_2"]*0.01;
					$order1211["dfx_price03"]=$goods_price*$members1211["bl_lever_3"]*0.01;
                  }
                
                }else if($fx_info["is_globle_fenxiao"]==2){
                
                    //关闭全局分销，指定商品才能有分销返点 is_on_self_fx
                    
                     $goods1209= M("goods")->where("id='".$is_order[$i]["goods_id"]."'")->find();
                     
                   		//该商品参与分销*/
                   		if($goods1209["is_on_self_fx"]==1){
                       	//使用单独商品的分销比例
                       	$order1211["dfx_price01"]=$goods_price*$goods1209["bl_lever_1"]*0.01;
						$order1211["dfx_price02"]=$goods_price*$goods1209["bl_lever_2"]*0.01;
						$order1211["dfx_price03"]=$goods_price*$goods1209["bl_lever_3"]*0.01;
						//	 dump(111);dump($order1211);die;
                       }else{
                       	//使用全局的分销比例
                       	$order1211["dfx_price01"]=$goods_price*$members1211["bl_lever_1"]*0.01;
						$order1211["dfx_price02"]=$goods_price*$members1211["bl_lever_2"]*0.01;
						$order1211["dfx_price03"]=$goods_price*$members1211["bl_lever_3"]*0.01;

                       }
                }       

				if($_POST["from_id"]){
					if($order1211["dfx_id"]==0){
						$order1211["dfx_id"]=$_POST["from_id"];
					}
				}
			
				M("order")->where("id='".$is_order[$i]["id"]."'")->save($order1211);
			}
			}
			
		}

//判断是不是分销商进来的、然后判断是不是有内销功能=====0928=======0928==========0928===========0928==========0928 dfx_id


	if(M("order")->where($array_id)->save($_POST)){

		if($_POST["program_id"]=="JT201710101645145951"){
			if($_POST["is_use_dikou"]!=0){
				$get_date["price_dikou_id"]=$_POST["is_use_dikou"];
				$rebate_record=M("rebate_record")->where("id='".$_POST["is_use_dikou"]."'")->find();
				
				$goods_price=$goods_price-$rebate_record["price"];
			}
		}

		$get_date["program_id"]			=$_POST["program_id"];	//小程序id
		$get_date["order_num"]			=$_POST["order_num"];		//订单号
        $get_date["group_order"]		=$_POST["group_order"];
		$get_date["openid"]				=$_POST["openid"];			//个人标识
		$get_date["array_id"]			=$newArr[$key]["str"];		//购物车商品数组
		$get_date["dsh_id"]				=$dsh_id;			  		//子商户id
		$get_date["shouhuo_id"]			=$_POST["shouhuo_id"];	//收货地址id
		$get_date["remark"]				=$_POST["remark"];			//备注
		$get_date["fapiao_taitou"]		=$_POST["fapiao_taitou"];//发票抬头
		$get_date["buy_price"]			=$goods_price;			//订单价格
		$get_date["time_build"]			=time();					//订单创建时间
		$get_date["pay_method"]			=$_POST["pay_method"];//支付方式：1：现金、2：积分、3：子商户消费券
		$get_date["price_sh"]			=$_POST["price_sh"];
		$get_date["sh_zhekou"]			=$_POST["sh_zhekou"];
		
		if($_POST["used_dsh_coupon"]){
			$get_date["used_dsh_coupon"]=$_POST["used_dsh_coupon"];
		}
		if($_POST["use_pre"]==1){
			//使用优惠券
			$get_date["preferential_id"]=$_POST["preferential_id"];//使用优惠券id
		}

		
		
//		$get_date["real_price"]			=$_POST["real_price"];	
		$get_date["pay_integral"]		=$_POST["pay_integral"];	
		$get_date["is_pay_choose"]		=$_POST["is_pay_choose"];
		if($_POST["can_pay_integral_by"]==1){
			$get_date["integralpay"]		=$_POST["integralpay"];	//需要支付的积分
			
		}
		$get_date["can_pay_integral_by"]	=$_POST["can_pay_integral_by"];	//1：需要支付积分 change_price
	
		$get_date["zhuanfa_id"]			=$_POST["from_id"];	//分享  的上线  分为vip和一般人
		
		$is_have_v=M("order_form")->where("order_num='".$get_date["order_num"]."'")->find();
		if(1){
			
//		if(!empty($_POST["order_num12138"])){
//			//去支付过来的  有订单号，有可能价格修改
//			M("order_form")->where("order_num='".$_POST["order_num12138"]."'")->save($get_date);
//		}else{
//			M("order_form")->add($get_date);
//		}
	if(!empty($_POST["order_num12138"])){
//		订单改价
			M("order_form")->where("order_num='".$_POST["order_num12138"]."'")->delete();

			$get_date["change_price"]		=$_POST["change_price"];
			$get_date["is_change_price"]	=1;
			
			
		}
		M("order_form")->add($get_date);
//去支付过来的  有订单号，有可能价格修改   0823订单号提交过一次就改了价格就不能再支付，舍弃之前的订单号，新建一个
				$data=array('status'=>1,'msg'=>'提交成功','roder_num'=>$_POST["order_num"]);
			}else{
				$data=array('status'=>2,'msg'=>'提交失败');
			}
		}else{
			$data=array('status'=>3,'msg'=>'请勿重复提交');
		}
	}
	//生成订单的商品减库存
		for($p=0;$p<count($b);$p++){
			$goods_num_d["id"]=$b[$p]["goods_id"];
			M("goods")->where($goods_num_d)->setInc('number', -$b[$p]["buy_num"]);
		}
	}
	
	$this->ajaxReturn($data);
	
	}
	
	
	public function order_submin_zhubao(){	
		$a=M("members")->where("openid='".$_POST["openid"]."'"."and program_id='".$_POST["program_id"]."'")->find();
		$gold_control=M("gold_control")->select();
		
		$_POST["state"]="1";
		$_POST["xiadan_time"]=time();
		
		$se=$this->chaifen($_POST["array_id"]);	
		for($k=0;$k<count($se)-1;$k++){ $get_arr_id[$k]=$se[$k]; }
		$where['id']=array('in',$get_arr_id);	//预购买数组
		$b=M("order")->where($where)->select();	//得到购物车商品id数组
		
		for($e=0;$e<count($b);$e++){
			$where_goods["id"]=$b[$e]["goods_id"];
			$goods[$e]=M("goods")->where($where_goods)->find();
		
			if ($a["level_id"] == 207) {
				//白银会员
			    $base_price = $goods[$e]["price_sell_1"];
			} else if ($a["level_id"]  == 208) {
				//黄金会员
			    if ($goods[$e]["fenlei_1"] == 1573) {
			      $base_price =$goods[$e]["price_sell_2"];
			    } else {
			      $base_price =$goods[$e]["price_sell_1"];
			    }
			}else{
			    $base_price =$goods[$e]["price_sell_2"];
			}	
			  
			$json_price_cl[$e]=json_decode($goods[$e]["json_price_cl"],true); 
			$price_cl[$e]=$this->json_to_price($json_price_cl[$e]);
	
			if(empty($b[$e]["guige_key"])){
			  	if ($goods[$e]["fenlei_1"] == 1572) {
			    	$b[$e]["price_sell"] = $base_price + $_POST["gold_sell"] * $goods[$e]["kezhong"]  + $gold_control[1]["control_price"];
			  	} else if ($goods[$e]["fenlei_1"] == 1573) {
			    	$b[$e]["price_sell"] = $base_price + $_POST["silver_sell"] * 0.001 * $goods[$e]["kezhong"] + $gold_control[3]["control_price"];
			  	} else {
			    	$b[$e]["price_sell"] = $base_price + $price_cl[$e] * 1;
			  	}
				
			}else{
				$arr_guige[$e]=explode("&",$goods[$e]["guige_json_price_cl"]);
				$on_choose_gg[$e]=json_decode($arr_guige[$e][$b[$e]["guige_key"]],true); 
				
				$price_cl[$e]=$this->json_to_price($on_choose_gg[$e]);
				
				if ($goods[$e]["fenlei_1"] == 1572) {
			    	$b[$e]["price_sell"] = $base_price + $_POST["gold_sell"] * $b[$e]["guige_remark"]  + $gold_control[1]["control_price"];
			  	} else if ($goods[$e]["fenlei_1"] == 1573) {
			    	$b[$e]["price_sell"] = $base_price + $_POST["silver_sell"] * 0.001 * $b[$e]["guige_remark"] + $gold_control[3]["control_price"];
			  	} else {
			    	$b[$e]["price_sell"] = $base_price + $price_cl[$e] * 1;
			  	}
					
			}	
		}

		$arr=$this->order_dsh($b);		
		$group_order="jt".time().rand(1111,9999);//订单分组标识
		$goods_price=0;//商品总价
		$fx_info=M("fx_info")->where("program_id='".$_POST["program_id"]."'")->find();//小程序分销设置
		foreach($arr as $k=>$v){
            $goods_price+=$v["price_sell"]*$v["buy_num"];  
            
            $_POST["order_num"]="JT".date("YmdHis",time()).rand(111111,999999);	
			$_POST["group_order"]=$group_order;
			
			foreach ($v as $vk=>$vv){
				if(empty($array_id)){
					$array_id=$vv["id"].",";
				}else{
					$array_id.=$vv["id"].",";
				}
				if($fx_info["is_globle_fenxiao"]==1){

                    $order1211["dfx_price01"]=$goods_price*$members1211["bl_lever_1"]*0.01;
					$order1211["dfx_price02"]=$goods_price*$members1211["bl_lever_2"]*0.01;
					$order1211["dfx_price03"]=$goods_price*$members1211["bl_lever_3"]*0.01;
       
                }else if($fx_info["is_globle_fenxiao"]==2){               
                    //关闭全局分销，指定商品才能有分销返点 is_on_self_fx
                     $goods1209= M("goods")->field("is_on_self_fx,bl_lever_1,bl_lever_2,bl_lever_3")->where("id='".$is_order[$i]["goods_id"]."'")->find();
                     
//                 		该商品参与分销
                   		if($goods1209["is_on_self_fx"]==1){
//                     	使用单独商品的分销比例
                       	$order1211["dfx_price01"]=$goods_price*$goods1209["bl_lever_1"]*0.01;
						$order1211["dfx_price02"]=$goods_price*$goods1209["bl_lever_2"]*0.01;
						$order1211["dfx_price03"]=$goods_price*$goods1209["bl_lever_3"]*0.01;
                       }else{
//                     	使用全局的分销比例
                       	$order1211["dfx_price01"]=$goods_price*$members1211["bl_lever_1"]*0.01;
						$order1211["dfx_price02"]=$goods_price*$members1211["bl_lever_2"]*0.01;
						$order1211["dfx_price03"]=$goods_price*$members1211["bl_lever_3"]*0.01;

                       }
                }       

				if($_POST["from_id"]){
					if($order1211["dfx_id"]==0){
						$order1211["dfx_id"]=$_POST["from_id"];
					}
				}
			
				M("order")->where("id='".$is_order[$i]["id"]."'")->save($order1211);
			}
			
		
			$where_array_id["id"]=array('in',$array_id);
			if(M("order")->where($where_array_id)->save($_POST)){

			$get_date["program_id"]			=$_POST["program_id"];	//小程序id
			$get_date["order_num"]			=$_POST["order_num"];		//订单号
	        $get_date["group_order"]		=$_POST["group_order"];
			$get_date["openid"]				=$_POST["openid"];			//个人标识
			$get_date["array_id"]			=$array_id;		//购物车商品数组
			$get_date["dsh_id"]				=$dsh_id;			  		//子商户id
			$get_date["shouhuo_id"]			=$_POST["shouhuo_id"];	//收货地址id
			$get_date["remark"]				=$_POST["remark"];			//备注
			$get_date["fapiao_taitou"]		=$_POST["fapiao_taitou"];//发票抬头
			$get_date["buy_price"]			=$goods_price;			//订单价格
			$get_date["time_build"]			=time();					//订单创建时间
			$get_date["pay_method"]			=$_POST["pay_method"];//支付方式：1：现金、2：积分、3：子商户消费券
			$get_date["price_sh"]			=$_POST["price_sh"];
			$get_date["sh_zhekou"]			=$_POST["sh_zhekou"];
				
			$get_date["gold_sell"]			=$_POST["gold_sell"];
			$get_date["silver_sell"]		=$_POST["silver_sell"];
			$get_date["dikou_gold"]			=$_POST["dikou_gold"];
			$get_date["dikou_silver"]		=$_POST["dikou_silver"];
			$get_date["price_show"]			=$_POST["price_show"];	
				
			$get_date["pay_integral"]		=$_POST["pay_integral"];	
			$get_date["is_pay_choose"]		=$_POST["is_pay_choose"];
			if($_POST["can_pay_integral_by"]==1){
				$get_date["integralpay"]		=$_POST["integralpay"];	//需要支付的积分				
			}
			$get_date["can_pay_integral_by"]	=$_POST["can_pay_integral_by"];	//1：需要支付积分 change_price
		
			$get_date["zhuanfa_id"]			=$_POST["from_id"];	//分享  的上线  分为vip和一般人
			
			$is_have_v=M("order_form")->where("order_num='".$get_date["order_num"]."'")->find();
		
			if(!empty($_POST["order_num12138"])){
//			订单改价
				M("order_form")->where("order_num='".$_POST["order_num12138"]."'")->delete();
				$get_date["change_price"]		=$_POST["change_price"];
				$get_date["is_change_price"]	=1;
								
			}
			M("order_form")->add($get_date);
					$data=array('status'=>1,'msg'=>'提交成功','roder_num'=>$_POST["order_num"]);
		
			}else{
				$data=array('status'=>3,'msg'=>'请勿重复提交');
			}
			
//			生成订单的商品减库存
			for($p=0;$p<count($b);$p++){
				$goods_num_d["id"]=$b[$p]["goods_id"];
				M("goods")->where($goods_num_d)->setInc('number', -$b[$p]["buy_num"]);
			}
		}
   
		$this->ajaxReturn($data);

	
	}
//	材料价总和
	function json_to_price($arr){
		$price=0;
		foreach($arr as $k=>$v){
			$price=$price+$v;
		}
		return $price;
	}
	function member_fx_lever($members_id){
		$a=M("members")
		->field('
		members.id as members_id,members.fx_lever_id,
		fx_lever.id as fx_lever_id,fx_lever.bl_lever_1,fx_lever.bl_lever_2,fx_lever.bl_lever_3')
		->where("members.id='".$members_id."'")
		->join('left join fx_lever ON fx_lever.id=members.fx_lever_id')
		->find();
		
		return $a;
	}
/*
 * 订单提交  生成订单号-----------------0625修正------------------------------------------------------
 * 
 */
 public function order_submin_nn(){	
/*
*统计价格，整体因素影响（后台改价、优惠券改价），个别因素影响（批发价、规格价、会员价）
*订单后续操作：一个订单编号=》多个子商户编号（唯一则为一致）
*分销佣金分配（单个商品分销佣金、总商品分销佣金）一致写入欲购买信息内，
*判断分销开启（1：后台是否开启分销功能、2：下单人是否为分销商、:3：是否带入分销标识：form_id
*商品数量（下单立减、支付立减），根据后台判断
* from_id openid program_id array_id shouhuo_id remark fapiao_taitou use_pre(1|0)(使用优惠券)  order_num12138 去支付过来的 
*/
	$_POST["state"]			="1";	//订单状态
	$_POST["xiadan_time"]	=time();//下单时间

	$where022['id']=array('in',$_POST["array_id"]);	//预购买数组
	$field="id,goods_id,buy_num,guige_key,is_on_lever_price,guige_price,dsh_id";
	$b=M("order")->field($field)->where($where022)->select();			//得到购物车商品id数组
	$price_total=0;
	for($e=0;$e<count($b);$e++){
		$where020[$e]["goods.id"]				=$b[$e]["goods_id"];
		$where020[$e]["members.program_id"]		=$_POST["program_id"];
		$where020[$e]["members.openid"]			=$_POST["openid"];
		$where020[$e]["member_price.program_id"]=$_POST["program_id"];
		$where020[$e]["member_price.goods_id"]	=$b[$e]["goods_id"];
		
		$field_goods="
			goods.id,goods.price_sell,goods.is_on_wholesale_discount,goods.is_on_lever_price,
			members.id as men_id,members.level_id,
			member_price.id as men_price_id,member_price.discount
		";
		$goods0925[$e]=M("goods")->field($field_goods)
		->join('left join members ON members.program_id=goods.program_id')
		->join('left join member_price ON member_price.program_id=goods.program_id')
		->where($where020[$e])
		->find();
dump(M("goods")->_sql());dump($goods0925[$e]);die;
		if($goods0925[$e]["is_on_wholesale_discount"]==1){
//是否开启批发折扣（1、开启
			$wholesale_discount[$e]=M("wholesale_discount")->where("goods_id='".$goods0925[$e]["id"]."'")->select();
			for($q1216=0;$q1216<count($wholesale_discount[$e]);$q1216){
				if(($b[$e]["buy_num"] > $wholesale_discount[$e][$q1216]["num_start"] | $b[$e]["buy_num"] == $wholesale_discount[$e][$q1216]["num_start"]) & $b[$e]["buy_num"] < $wholesale_discount[$e][$q1216]["num_end"]){
					$wholesale_d[$e] = $wholesale_discount[$e][$q1216]["discount"];
				}
			}	
		}else{
//是否开启批发折扣（2：关闭(默认）			
			$wholesale_d[$e]="1";
		}
//规格
		if(empty($b[$e]["guige_key"])){
//未选中规格			
			if($goods0925[$e]["is_on_lever_price"]==1){
//开启会员折扣价
				$b[$e]["price_sell"]=$goods0925[$e]["price_sell"]*$wholesale_d[$e]*$goods0925[$e]["discount"];
			}else if($goods0925[$e]["is_on_lever_price"]==2){
				$b[$e]["price_sell"]=$goods0925[$e]["price_sell"]*$wholesale_d[$e];
			}
		}else{
//规格购买			
			if($goods0925[$e]["is_on_lever_price"]==1){
//开启会员折扣价
				$b[$e]["price_sell"]=$b[$e]["guige_price"]*$wholesale_d[$e]*$goods0925[$e]["discount"];
			}else if($goods0925[$e]["is_on_lever_price"]==2){
				$b[$e]["price_sell"]=$b[$e]["guige_price"]*$wholesale_d[$e];
			}
		}
		
		$price_total+=$b[$e]["price_sell"];
	}


	if($_POST["use_pre"]==1){
		//preferential_id 使用优惠券id   pre_price：优惠立减金额
		$a1116=M("preferential")->field("pre_price")->where("id='".$_POST["preferential_id"]."'")->find();
		$price_total=$price_total-$a1116["pre_price"];
		
		$q1116=M("preferential_record")->where("openid='".$_POST["openid"]."'"." and program_id='".$_POST["program_id"]."'"."and preferential_id='".$_POST["preferential_id"]."'")->find();
		
		if($q1116["num"]>0){
			M("preferential_record")->where("openid='".$_POST["openid"]."'"." and program_id='".$_POST["program_id"]."'"."and preferential_id='".$_POST["preferential_id"]."'")->setInc("num",-1);
		}	
	}

} 


//积分支付订单 百业联盟
function pay_integral(){
	
	if(empty($_POST["program_id"]) | empty($_POST["openid"])){
			$this->ajaxReturn(array('state'=>-999,'msg'=>'参数错误 '));
	}
	$members=M("members")->field("integral,integral_song")->where("openid='".$_POST["openid"]."'"."and program_id='".$_POST["program_id"]."'")->find();
	if($_POST["data_total"]>($members["integral"]+$members["integral_song"])){
		$this->ajaxReturn(array('state'=>-2,'msg'=>'积分不足 '));
	}
	$save["state"]		=2;
	$save["time_fukuan"]=time();
	$save["pay_integral"]=$_POST["data_total"];
	
	if(M("order_form")->where("order_num='".$_POST["order_num"]."'")->save($save)){
		if($members["integral_song"]>$_POST["data_total"]){
			M("members")->where("openid='".$_POST["openid"]."'"."and program_id='".$_POST["program_id"]."'")->setInc("integral_song",-$_POST["data_total"]);
			$back=array("state"=>1,"msg"=>"成功");
		}else if($members["integral_song"]<$_POST["data_total"] & $members["integral_song"]>0) {
			$de_p=$_POST["data_total"]-$members["integral_song"];
			M("members")->where("openid='".$_POST["openid"]."'"."and program_id='".$_POST["program_id"]."'")->setInc("integral_song",-$members["integral_song"]);
			M("members")->where("openid='".$_POST["openid"]."'"."and program_id='".$_POST["program_id"]."'")->setInc("integral",-$de_p);
			$back=array("state"=>1,"msg"=>"成功");
		}else{
			M("members")->where("openid='".$_POST["openid"]."'"."and program_id='".$_POST["program_id"]."'")->setInc("integral",-$_POST["data_total"]);
			$back=array("state"=>1,"msg"=>"成功");
		}
		
	}else{
		$back=array("state"=>-1,"msg"=>"失败");
	}
$this->ajaxReturn($back);
	
}

//子商户消费券支付订单 百业联盟
function pay_coupon(){
	$coupon_dsh_record=M("coupon_dsh_record")->field("coupon_num")->where("state=0 and program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'")->order("id asc")->find();
	
	$save["state"]		=2;
	$save["time_fukuan"]=time();
	$save["coupon_num"]	=$coupon_dsh_record["coupon_num"];
	
	
	$save_2["state"]	=1;
	$save_2["time_used"]=time();
	$save["order_num"]	=$_POST["order_num"];
	
	
	if(M("order_form")->where("order_num='".$_POST["order_num"]."'")->save($save)){
		M("coupon_dsh_record")->where("program_id='".$_POST["program_id"]."'"."and coupon_num='".$coupon_dsh_record["coupon_num"]."'")->save($save_2);
		$back=array("state"=>1,"msg"=>"成功");
	}else{
		$back=array("state"=>-1,"msg"=>"失败");
	}
	$this->ajaxReturn($back);
}

	//付款完成修改订单状态
	public function wancheng(){
	
		//之前的商城版没有传递 小程序id过来，现在能传递，
		if(empty($_POST["program_id"])){
			//这里是之前的商城版的完成调用，1018...21.32
			//====================================================================================
			//====================================================================================
			//====================================================================================
			$date["state"]="2";
			$date["haved_end"]="1";
			$date["time_fukuan"]=time();
			$group_order=M("order_form")->where("order_num='".$_POST["order_num"]."'")->find();
		
			if($group_order["haved_end"]==1){
				$this->ajaxReturn(array('status'=>1,'msg'=>'付款完成.'));
			}
	
			if(M("order_form")->where("order_num='".$group_order["order_num"]."'")->save($date)){
				
					if($group_order["price_dikou_id"]!=0){
						
						$save_rebate_record["time_use"]=time();
						$save_rebate_record["state"]=1;
						$save_rebate_record["order_num"]=$_POST["order_num"];
						
						M("rebate_record")->where("id='".$group_order["price_dikou_id"]."'")->save($save_rebate_record);
						
					}
					if($group_order["program_id"]=="JT201810111844206577"){
							
//珠宝小程序						
						$members=M("members")->field("id,level_id,member_total_pay")->where("program_id='".$group_order["program_id"]."'"."and openid='".$group_order["openid"]."'")->find();
						$member_level=M("member_level")->where("id='".$members["level_id"]."'")->find();
						$member_level_2=M("member_level")->where("member_level=3")->find();
						
					
						if($member_level["member_level"]==2){
//						注册会员才能有消费金额的累计
							M("members")->where("program_id='".$group_order["program_id"]."'"."and openid='".$group_order["openid"]."'")->setInc("member_total_pay",$group_order["buy_price"]);
						}
						if($members["member_total_pay"]+$group_order["buy_price"]<500){
						
						}else{
							$members_save["level_id"]=$member_level_2["id"];
							M("members")->where("program_id='".$group_order["program_id"]."'"."and openid='".$group_order["openid"]."'")->save($members_save);
						}
						
					}
			if($group_order["program_id"]=="JT201802032149345468"){
				//易选购小程序
				if($group_order["zhuanfa_id"]!=0){
					//是转发过来的 ，可以给转发上线打钱了
					$members_zhuanfa=M("members")->where("program_id='".$group_order["program_id"]."'"."and id='".$group_order["zhuanfa_id"]."'")->find();
					
					$where_forwarding["program_id"]=$group_order["program_id"];
					if($members_zhuanfa["vip_id"]!=0){
						$where_forwarding["is_vip"]="1";
					}else{
						$where_forwarding["is_vip"]="0";
					}
					$commission_per=M("members_forwarding")->where($where_forwarding)->find();
					
					
					M("members")->where("program_id='".$group_order["program_id"]."'"."and id='".$group_order["zhuanfa_id"]."'")->setInc("integral",$group_order["buy_price"]*0.01*$commission_per["commission_per"]);
				}
				
				if($group_order["is_pay_choose"]==2){
					//积分现金混合消费， 完成现金支付，将进行扣除积分操作 fx_yongjin_leiji
					M("members")->where("openid='".$group_order["openid"]."'"."and program_id='".$group_order["program_id"]."'")->setInc("integral",-$group_order["pay_integral"]);
				}else if($group_order["is_pay_choose"]==1){
					//现金支付，会得到积分返还
					$members0417=M("members")->where("openid='".$group_order["openid"]."'"."and program_id='".$group_order["program_id"]."'")->find();
					
					$cash_return=M("fx_goods_buy")->where("state=1 and program_id='".$group_order["program_id"]."'"."and lever_id='".$members0417["vip_id"]."'")->find();
				
					//积分返还给纯现金消费用户
					M("members")->where("openid='".$group_order["openid"]."'"."and program_id='".$group_order["program_id"]."'")->setInc("integral",$group_order["buy_price"]*0.01*$cash_return["cash_return"]);
				}
			}
			if($group_order["program_id"]=="JT201806151732369242"){
			
			//百业联盟，判断是否有积分消费，执行扣除积分操作	
				if($group_order["can_pay_integral_by"]==1){
					
					$members_integral=M("members")->field("integral,integral_song")->where("openid='".$group_order["openid"]."'"."and program_id='".$group_order["program_id"]."'")->find();


					if($members_integral["integral_song"]>$group_order["integralpay"]){
						
						$save_integral["integral_song"]=$members_integral["integral_song"]-$group_order["integralpay"];

					}else if($members_integral["integral_song"]<$group_order["integralpay"]){
						
						$save_integral["integral_song"]="0";
						$save_integral["integral"]=$members_integral["integral"]-($group_order["integralpay"]-$members_integral["integral_song"]);
				
					}
					M("members")->where("openid='".$group_order["openid"]."'"."and program_id='".$group_order["program_id"]."'")->save($save_integral);						
				}
				
				$coupon_dsh_record=M("coupon_dsh_record")->field("coupon_num")->where("state=0 and program_id='".$group_order["program_id"]."'"."and openid='".$group_order["openid"]."'")->order("id asc")->find();

				$save["state"]		=2;
				$save["time_fukuan"]=time();
				$save["coupon_num"]	=$coupon_dsh_record["coupon_num"];
				
				
				$save_2["state"]	=1;
				$save_2["time_used"]=time();
				$save["order_num"]	=$post_data["out_trade_no"];
				M("order_form")->where("order_num='".$post_data["out_trade_no"]."'")->save($save);
				M("coupon_dsh_record")->where("program_id='".$group_order["program_id"]."'"."and coupon_num='".$coupon_dsh_record["coupon_num"]."'")->save($save_2);
							
				
			}
			$order=M("order")->where("group_order='".$group_order["group_order"]."'")->select();
		
			for($r=0;$r<count($order);$r++){
				//对每个订单的分销佣金进行分配====================================================================== fx_yongjin_leiji
				if($order[$r]["program_id"]=="JT201712021113483120"){
					//判断是是蔡氏养生
					$members0116_1[$r]=M("members")->where("id='".$order[$r]["daili_uid_csys"]."'")->find();//上级	
					if($r==0){
						$date02["dfx_id"]=$order[$r]["daili_uid_csys"];
						M("order_form")->where("group_order='".$group_order["group_order"]."'")->save($date02);
					}	
						
					M("members")->where("id='".$order[$r]["daili_uid_csys"]."'")->setInc('fx_yongjin_leiji',$order[$r]['dfx_price01']);//一级佣金发放
					
					if($members0116_1[$r]["daili_uid_csys"]!=0){
						M("members")->where("id='".$members0116_1[$r]["daili_uid_csys"]."'")->setInc('fx_yongjin_leiji',$order[$r]['dfx_price02']);//2级佣金发放
					}
				}else{
//					dump($order[$r]);die;
					if($order[$r]["dfx_id"]!=0){	
					if($r==0){
						//订单的第一条数据
						$date02["dfx_id"]=$order[$r]["dfx_id"];
						M("order_form")->where("group_order='".$group_order["group_order"]."'")->save($date02);
					}			
					
						$members1223_1[$r]=M("members")->field("id,fx_uid")->where("id='".$order[$r]["dfx_id"]."'")->find();
//				dump($members1223_1[$r]);dump(M("members")->_sql());die;
						M("members")->where("id='".$order[$r]["dfx_id"]."'")->setInc('fx_yongjin_leiji',$order[$r]['dfx_price01']);//一级佣金发放
					
						if($members1223_1[$r]["fx_uid"]!=0){
							$members1223_2[$r]=M("members")->field("id,fx_uid")->where("id='".$members1223_1[$r]["fx_uid"]."'")->find();
							M("members")->where("id='".$members1223_1[$r]["fx_uid"]."'")->setInc('fx_yongjin_leiji',$order[$r]['dfx_price02']);//2级佣金发放
						
						}
						if($members1223_2[$r]["fx_uid"]!=0){
							$members1223_3[$r]=M("members")->where("id='".$members1223_2[$r]["fx_uid"]."'")->find();
							M("members")->where("id='".$members1223_2[$r]["fx_uid"]."'")->setInc('fx_yongjin_leiji',$order[$r]['dfx_price02']);//3级佣金发放
						
						}
					}
				}
	
			//找到对应商品，销量增加
			M("goods")->where("id='".$order[$r]["goods_id"]."'")->setInc("sell_num",$order[$r]["buy_num"]);

			//库存减少		
				if($order[$r]["is_use_guige"]==2){
					//启用规格，减少对应规格的库存
					$str1211=explode(",",$order[$r]["str_num"]);
					for($t=0;$t<count($str1211);$t++){
						if($order[$r]["guige_key"]==$t){
							$str1211[$t]=$str1211[$t]-$order[$r]["buy_num"];
						}
					}
					$arr1211["str_num"]=implode(",",$str1211);
					M("goods")->where("id='".$order[$r]["goods_id"]."'")->save($arr1211);
				}else{
					M("goods")->where("id='".$order[$r]["goods_id"]."'")->setInc("number",-$order[$r]["buy_num"]);
				}
			}	

					$data=array('status'=>1,'msg'=>'付款完成.');
				}else{
					$data=array('status'=>2,'msg'=>'付款失败.');
				}
			
		}else{
		$qianyue=M("qianyue")->where("program_id='".$_POST["program_id"]."'")->find();
		
		if($qianyue["muban_type"]==1){
			//商城版====================================================================
			
				$date["state"]="2";
				$group_order=M("order_form")->where("order_num='".$_POST["order_num"]."'")->find();
			if(M("order_form")->where("group_order='".$group_order["group_order"]."'")->save($date)){
				
		
			$order=M("order")->where("group_order='".$group_order["group_order"]."'")->select();
			
			for($r=0;$r<count($order);$r++){
				if($order[$r]["dfx_id"]!=0){
				//	echo 1123;die;
						$members1223_1=M("members")->where("id='".$order[$r]["dfx_id"]."'")->find();		
						M("members")->where("id='".$order[$r]["dfx_id"]."'")->setInc('fx_yongjin_leiji',$order[$r]['dfx_price01']);//一级佣金发放
					
					if($members1223_1["dfx_id"]!=0){
						$members1223_2=M("members")->where("id='".$members1223_1["fx_uid"]."'")->find();
						M("members")->where("id='".$members1223_1["fx_uid"]."'")->setInc('fx_yongjin_leiji',$order[$r]['dfx_price02']);//2级佣金发放
					
					}
					if($members1223_2["dfx_id"]!=0){
						$members1223_3=M("members")->where("id='".$members1223_2["fx_uid"]."'")->find();
						M("members")->where("id='".$members1223_2["fx_uid"]."'")->setInc('fx_yongjin_leiji',$order[$r]['dfx_price02']);//3级佣金发放
					
					}
				}
	
	
			//找到对应商品，销量增加
			M("goods")->where("id='".$order[$r]["goods_id"]."'")->setInc("sell_num",$order[$r]["buy_num"]);
			
			
			//库存减少
				if($order[$r]["is_use_guige"]==2){
					//启用规格，减少对应规格的库存
					$str1211=explode(",",$order[$r]["str_num"]);
					for($t=0;$t<count($str1211);$t++){
						if($order[$r]["guige_key"]==$t){
							$str1211[$t]=$str1211[$t]-$order[$r]["buy_num"];
						}
					}
					$arr1211["str_num"]=implode(",",$str1211);
					M("goods")->where("id='".$order[$r]["goods_id"]."'")->save($arr1211);
				}else{
					M("goods")->where("id='".$order[$r]["goods_id"]."'")->setInc("number",-$order[$r]["buy_num"]);
				}
			}	
			
					$data=array('status'=>1,'msg'=>'付款完成');
				}else{
					$data=array('status'=>2,'msg'=>'付款失败');
				}
			
		}
		if($qianyue["muban_type"]==5){
			//这里是资讯版的内容    完成付款，修改付款状态，并且给那个用户添加积分
			
			
			$jt03_zx_record_cz=M("jt03_zx_record_cz")->where("order_num='".$_POST["order_num"]."'")->find();
			$date1019["state"]="2";
			if(M("jt03_zx_record_cz")->where("order_num='".$_POST["order_num"]."'")->save($date1019)){
				//添加积分

				M("members")->where("openid='".$jt03_zx_record_cz["openid"]."'"." and program_id='".$_POST["program_id"]."'")
				->setInc("integral",$jt03_zx_record_cz["record"]);
					
					$data=array('status'=>1,'msg'=>'付款完成');
				}else{
					$data=array('status'=>2,'msg'=>'付款失败');
				}		
		}
		
		}
		
		$this->ajaxReturn($data);
	}
	
	function wancheng_ktv(){
			$date["state"]="1";
			$date["time_pay"]=time();

			$a=M("room_orderbooking")->field("id,openid,price,state")->where("order_num='".$_POST["order_num"]."'")->find();	
			
			
			if($a["state"]==1){
				$this->ajaxReturn(array('status'=>1,'msg'=>'付款完成'));
			}else{
				if(M("room_orderbooking")->where("order_num='".$_POST["order_num"]."'")->save($date)){
                //分销佣金发放
                $fx_1=M("members")->field("fx_uid")->where("id='".$a["fx_uid"]."'")->find();
                M("members")->where("id='".$a["fx_uid"]."'")->setInc("fx_yongjin_leiji",$a["dfx_price01"]);

                if($fx_1["fx_uid"]!=0){
                    $fx_2=M("members")->field("id,fx_uid")->where("id='".$fx_1["fx_uid"]."'")->find();
                    M("members")->where("id='".$fx_1["fx_uid"]."'")->setInc('fx_yongjin_leiji',$a['dfx_price02']);//2级佣金发放
                }
                if($fx_2["fx_uid"]!=0){
                    M("members")->where("id='".$fx_2["fx_uid"]."'")->setInc('fx_yongjin_leiji',$a['dfx_price03']);//2级佣金发放

                }
					$data=array('status'=>1,'msg'=>'付款完成');
				}else{
					$data=array('status'=>2,'msg'=>'付款失败');
				}	
			}
			$this->ajaxReturn($data);
	}
	function wancheng_shoucang(){
			$date["state"]="1";
			$date["time_pay"]=time();
			
			$a=M("record_shoucang")->field("id,openid,price,state,artical_id")->where("order_num='".$_POST["order_num"]."'")->find();	
			$date["real_price"]=$a["onprice"]*$a["num"];
			if($a["state"]==0){
				$this->ajaxReturn(array('status'=>1,'msg'=>'付款完成'));
			}else{
				if(M("room_orderbooking")->where("order_num='".$_POST["order_num"]."'")->save($date)){
					if($a["state"]==0){
						M("record_shoucang")->where("order_num='".$_POST["order_num"]."'")->save($date);
						if($a["goods_id"]==1){
							
							M("members")->where("program_id='".$a["program_id"]."'"."and openid='".$a["openid"]."'")->setInc("gold_shoucang",$a["num"]);
						}else if($a["goods_id"]==2){
							M("members")->where("program_id='".$a["program_id"]."'"."and openid='".$a["openid"]."'")->setInc("silver_shoucang",$a["num"]);
						}
						
					}
					$data=array('status'=>1,'msg'=>'付款完成');
				}else{
					$data=array('status'=>2,'msg'=>'付款失败');
				}	
			}

			$this->ajaxReturn($data);
	}
	function wancheng_ktvvip(){
		$date["state"]="1";
		$date["time_pay"]=time();

		$a=M("vip_order")->field("id,openid,price,state,vip_id")->where("order_num='".$_POST["order_num"]."'")->find();	
		$save["vip_card_id"]=$a["vip_id"];
		
		if($a["state"]==1){
			$this->ajaxReturn(array('status'=>1,'msg'=>'付款完成'));
		}else{
			if(M("vip_order")->where("order_num='".$_POST["order_num"]."'")->save($date)){
				M("members")->where("openid='".$a["openid"]."'")->save($save);
				$data=array('status'=>1,'msg'=>'付款完成');
			}else{
				$data=array('status'=>2,'msg'=>'付款失败');
			}	
		}
		$this->ajaxReturn($data);
	}
		function wancheng_artical(){
		$date["state"]="1";
		$date["time_pay"]=time();

		$a=M("artical_order")->field("id,openid,price,state,artical_id")->where("order_num='".$_POST["order_num"]."'")->find();	
		$save["artical_id"]=$a["artical_id"];
		
		if($a["state"]==1){
			$this->ajaxReturn(array('status'=>1,'msg'=>'付款完成'));
		}else{
			if(M("artical_order")->where("order_num='".$_POST["order_num"]."'")->save($date)){
				M("members")->where("openid='".$a["openid"]."'")->save($save);
				$data=array('status'=>1,'msg'=>'付款完成');
			}else{
				$data=array('status'=>2,'msg'=>'付款失败');
			}	
		}
		$this->ajaxReturn($data);
	}
	function wancheng_member_lever(){
		$date["state"]="1";
		$date["time_pay"]=time();

		$a=M("vip_order")->field("id,openid,price,state,vip_id")->where("order_num='".$_POST["order_num"]."'")->find();	
		$save["level_id"]=$a["vip_id"];
		
		if($a["state"]==1){
			$this->ajaxReturn(array('status'=>1,'msg'=>'付款完成'));
		}else{
			if(M("vip_order")->where("order_num='".$_POST["order_num"]."'")->save($date)){
				M("members")->where("openid='".$a["openid"]."'")->save($save);
				$data=array('status'=>1,'msg'=>'付款完成');
			}else{
				$data=array('status'=>2,'msg'=>'付款失败');
			}	
		}
		$this->ajaxReturn($data);
	}
    function wancheng_ktv_xuzhong(){
        $date["state"]="1";
        $date["time_pay"]=time();

        $a=M("room_xz_order")->field("id,state,order_num_room_order,xuzhong_houre")->where("order_num='".$_POST["order_num"]."'")->find();

        $b=M("room_orderbooking")->where("order_num='".$a["order_num_room_order"]."'")->find();

        $date2["time_done"]=$b["time_done"]+3600*$a["xuzhong_houre"];

        $date["time_done_old"]=$b["time_done"];
        $date["time_done_new"]=$date2["time_done"];
        if($a["state"]==1){
            $this->ajaxReturn(array('status'=>1,'msg'=>'付款完成'));
        }else{
            if(M("room_xz_order")->where("order_num='".$_POST["order_num"]."'")->save($date)){
                M("room_orderbooking")->where("order_num='".$a["order_num_room_order"]."'")->save($date2);
                $data=array('status'=>1,'msg'=>'付款完成');
            }else{
                $data=array('status'=>2,'msg'=>'付款失败');
            }
        }
        $this->ajaxReturn($data);
    }
		//百业联盟扫码微信支付
	function wancheng_qdcode_pay(){
			$a=M("dsh_qdcode_chage")->field("dsh_qdcode_chage.state,dsh_qdcode_chage.order_price,dsh_qdcode_chage.from_id,dsh_qdcode_chage.dfx_price01,dsh_qdcode_chage.dfx_price02,dsh_qdcode_chage.dfx_price03,assistant_add.shop_id")
			->join("left join assistant_add on assistant_add.openid=dsh_qdcode_chage.openid_ass")
			->where("dsh_qdcode_chage.order_num='".$_POST["order_num"]."'")->find();
			
			if($a["state"]==1){
				$this->ajaxReturn(array('status'=>1,'msg'=>'付款完成.'));
			}

			$save["openid_cus"]	=$_POST["openid"];
			$save["time_pay"]	=time();
			$save["state"]		=1;
			$save["shop_id"]	=$a["shop_id"];

			if(M("dsh_qdcode_chage")->where("order_num='".$_POST["order_num"]."'")->save($date)){
	//				分销佣金发放
				$members1223_1=M("members")->field("id,fx_uid")->where("id='".$a["from_id"]."'")->find();
						
				M("members")->where("id='".$a["from_id"]."'")->setInc('fx_yongjin_leiji',$a['dfx_price01']);//一级佣金发放
				
				
				if($members1223_1["fx_uid"]!=0){
					$members1223_2=M("members")->field("id,fx_uid")->where("id='".$members1223_1["fx_uid"]."'")->find();
					M("members")->where("id='".$members1223_1["fx_uid"]."'")->setInc('fx_yongjin_leiji',$a['dfx_price02']);//2级佣金发放
				
				}
				if($members1223_2["fx_uid"]!=0){
					$members1223_3=M("members")->where("id='".$members1223_2["fx_uid"]."'")->find();
					M("members")->where("id='".$members1223_2["fx_uid"]."'")->setInc('fx_yongjin_leiji',$a['dfx_price02']);//3级佣金发放
				
				}

				$data=array('status'=>1,'msg'=>'付款完成..');
			}else{
				$data=array('status'=>2,'msg'=>'付款失败..');
			}
	
		
		$this->ajaxReturn($data);
	}
	//消费券消费
	function wancheng_con(){
		$date["state"]="2";
		
		$_POST["str_cons_num"] = substr($_POST["str_cons_num"],0,strlen($_POST["str_cons_num"])-1); //去掉最后一个逗号
		$date["pay_consumption_num"]=$_POST["str_cons_num"];
		$group_order=M("order_form")->where("order_num='".$_POST["order_num"]."'")->find();
	
		if(M("order_form")->where("group_order='".$group_order["group_order"]."'")->save($date)){
			//消费码登记使用
			$arr=explode(",",$_POST["str_cons_num"]);
			for($i=0;$i<count($arr);$i++){
				$save["state"]="2";
				$save["time_used"]=time();
				M("consumption_vouchers")->where("id='".$arr[$i]."'")->save($save);
			}	
			$data=array('status'=>1,'msg'=>'付款完成');
			}else{
			$data=array('status'=>2,'msg'=>'付款失败');
		}
			$this->ajaxReturn($data);
	}

	//积分充值完成状态
	function wancheng02(){
		$date["state"]="2";
		
		//查询积分充值比例
		$a=M("store")
		->field("store.integral_proportion,jt03_zx_record_cz.openid,jt03_zx_record_cz.price")
		->join('left join jt03_zx_record_cz ON jt03_zx_record_cz.program_id=store.program_id')
		->where("jt03_zx_record_cz.order_num='".$_POST["order_num"]."'")
		->find();	
		//$a["integral_proportion"]

		if(M("jt03_zx_record_cz")->where("order_num='".$_POST["order_num"]."'")->save($date)){
			//付款完成就往个人的位置添加比例积分
			M("members")->where("openid='".$a["openid"]."'")->setInc('integral',$a["integral_proportion"]*$a["price"]);
			$data=array('status'=>1,'msg'=>'付款完成');
		}else{
			$data=array('status'=>2,'msg'=>'付款失败');
		}	
		$this->ajaxReturn($data);
	}
//	针对 pay_state="chongzhi"
	function wc_chongzhi(){
		$date["state"]="2";
		$date["time_pay"]=time();
		$a=M("jt03_zx_record_cz")->field("id,openid,price,state")->where("order_num='".$_POST["order_num"]."'")->find();	
		if($a["state"]==1){
			if(M("jt03_zx_record_cz")->where("order_num='".$_POST["order_num"]."'")->save($date)){
				//付款完成就往个人的位置添加比例积分
				M("members")->where("openid='".$a["openid"]."'")->setInc('integral',$a["price"]);
				$data=array('status'=>1,'msg'=>'付款完成');
			}else{
				$data=array('status'=>2,'msg'=>'付款失败');
			}
		}else if($a["state"]==2){
			$data=array('status'=>1,'msg'=>'付款完成');
		}	
		$this->ajaxReturn($data);
	}
	
	//购买VIP 接口  易选购      添加vip等级，添加分销等级、添加分销状态 分销上线uid
	function wancheng_vip(){
		$date["state"]="2";
		$a=M("jt03_zx_record_cz")->where("order_num='".$_POST["order_num"]."'")->find();
		
		$save["vip_id"]=$a["vip_id"];
		$save["fx_lever_id"]=$a["vip_id"];
		$save["fx_state"]="2";
		$save["fx_uid"]=$a["vip_uid"];
		$save["fx_time_agree"]=time();
		$save["fx_time_registe"]=$a["time"];
		$save["vip_leiji_pay"]=$a["leiji_buy_price"];
	
		//付款完成可以发放佣金了	
	
		if(M("jt03_zx_record_cz")->where("order_num='".$_POST["order_num"]."'")->save($date)){
			//付款完成就往个人的位置添加vip
			M("members")->where("program_id='".$a["program_id"]."'"."and openid='".$a["openid"]."'")->save($save);
			
		
		if($a["vip_uid"]!=0){
			$members01=M("members")->where("id='".$a["vip_uid"]."'")->find();
			M("members")->where("id='".$a["vip_uid"]."'")->setInc("fx_yongjin_leiji",$a["price_01"]);		//一级分销佣金
			if($members01["vip_uid"]!=0){
				M("members")->where("id='".$members01["fx_uid"]."'")->setInc("fx_yongjin_leiji",$a["price_02"]);//2级分销佣金	
			}
			
		}
		
		
			$data=array('status'=>1,'msg'=>'付款完成');
		}else{
			$data=array('status'=>2,'msg'=>'付款失败');
		}	
		$this->ajaxReturn($data);
	}
	//纯购买的完成接口    子商户购买：手机用户写了资料，然后点击提交，提示付款，付款，付款完成，（同时访问完成接口，然后把订单号加在原数据一并提交）
	function wancheng_total(){
		//order_from:1:子商户资格购买
		$a=M("record_total")->field("state")->where("order_num='".$_POST["order_num"]."'")->find();
		if($a["state"]==2){
			//已经自动回调完成
			$data=array('status'=>1,'msg'=>'付款完成.');
		}else{
			$date["state"]="2";
			if(M("record_total")->where("order_num='".$_POST["order_num"]."'")->save($date)){
				if($_POST["order_from"]=="1"){
					$save_1["pay_state"]="2";
					M("user_info_dsh")->where("order_num='".$_POST["order_num"]."'")->save($save_1);
				}
				$data=array('status'=>1,'msg'=>'付款完成');
			}else{
				$data=array('status'=>2,'msg'=>'付款失败');
			}	
		}
		
		$this->ajaxReturn($data);
		
	}
	
		//优惠券购买状态完成
	function wancheng_coupons(){

		$date["order_state"]="2";
		
$a=M("preferential_record")->where("order_num='".$_POST["order_num"]."'")->find();

		if(M("preferential_record")->where("order_num='".$_POST["order_num"]."'")->save($date)){
			//付款完成就往个人的位置添加比例积分.$_COOKIE
			$time=time();
			for($i=0;$i<$a["num"];$i++){
				$coupon[$i]["coupon_code"]=rand(111111111,999999999);
				$coupon[$i]["time_pay"]=$time;
				$coupon[$i]["program_id"]=$a["program_id"];
				$coupon[$i]["openid"]=$a["openid"];
				$coupon[$i]["order_num"]=$a["order_num"];
				$coupon[$i]["state"]="1";
		
				M("preferential_code")->add($coupon[$i]);
					$bm_arr[$i]=$coupon[$i]["coupon_code"];
			}
		
		
			M("preferential")->where("id='".$a["preferential_id"]."'")->setInc("num",-$a["num"]);
			
			
					$data=array('status'=>1,'msg'=>'付款完成','order_num'=>$_POST["order_num"],'bm_arr'=>$bm_arr);
				}else{
					$data=array('status'=>2,'msg'=>'付款失败');
				}	
				
					$this->ajaxReturn($data);
	}
	//取消订单
	function quxiao(){
		//得到订单编号，设置订单状态为取消就可以了
		$post_date["state"]="6";
		if(M("order_form")->where("id='".$_POST["id"]."'")->save($post_date)){
			$data=array('status'=>1,'msg'=>'取消成功');
		}else{
			$data=array('status'=>2,'msg'=>'取消失败');
		}		
		$this->ajaxReturn($data);
	}
	
		//取消订单
	function quxiao_0316(){
		//得到订单编号，设置订单状态为取消就可以了
		
//		if($_POST["order_staye"]==6) $post_date["state"]="6";//取消订单
//		if($_POST["order_staye"]==5) $post_date["state"]="5";//退款申请
		
		switch($_POST["order_staye"]) 
		{
			case 5:
			$post_date["state"]				="5";	//退款申请
			$post_date["state_tuikuan"]		="2";	//退款申请
			$post_date["time_registe_tk"]	=time();//申请时间
			 
			$msg_1='取消成功';
			$msg_2='取消失败';
			break;
			 
			case 6:
			$post_date["state"]				="6";//取消订单
			$post_date["time_pass"]			=time();//申请时间
			$msg_1='申请成功';
			$msg_2='申请失败';
			break;
		}
	
		if(M("order_form")->where("id='".$_POST["id"]."'")->save($post_date)){
			$data=array('status'=>1,'msg'=>$msg_1);
		}else{
			$data=array('status'=>2,'msg'=>$msg_2);
		}		
		$this->ajaxReturn($data);
	}
//	预约取消
		function quxiao_0731(){
		//得到订单编号，设置订单状态为取消就可以了
	
		$post_date["state"]="2";
		if(M("booking")->where("id='".$_POST["id"]."'")->save($post_date)){
			$data=array('status'=>1,'msg'=>$msg_1);
		}else{
			$data=array('status'=>2,'msg'=>$msg_2);
		}		
		$this->ajaxReturn($data);
	}
	//分割函数
	 function chaifen($source){
        return explode(',',$source);
    }
	
	//递归
	function bq($arr,$p=0){
		$ar=array();
		foreach($arr as $v){ if($v["uid"]==$p){ $v["child"]=$this->bq($arr,$v["id"]);	$ar[]=$v;}} return $ar;
	}
	
	
	
		//小程序管理平台  登录验证
	function check_load(){
		/*$ew["name"]=date("Y-m-d H:i:s",time());
		M("test")->add($ew);  program_id
		$this->ajaxReturn($_POST);*/
		
		$program_id["name"]=$_POST["name"];//小程序id
		
		$user_info=M("user_info")->field("id,program_id")->where($program_id)->find();
		if(empty($user_info['program_id'])){
				$data=array('status'=>3,'msg'=>'未绑定小程序，禁止登陆');
		
		}else if(!empty($_POST["name"]) & !empty($_POST["psw"])){
			//从muban 表调用小程序权限
			//启用状态（1：启用、2：超级管理员停用停用、3：服务商权限停用、4：模板到期停用）
			$is_nan_load_muban=M("muban")->where("program_id='".$_POST["program_id"]."'")->find();
			if($is_nan_load_muban["state"]==1){
				//正常
				$where["name"]=$_POST["name"];
				$a=M("user_info")->where($where)->find();
			
				if($a["psw"]==md5($_POST["psw"])){
					
					cookie("program_id",$a["program_id"]);
					$data=array('status'=>1,'msg'=>'允许登录','program_id'=>$a["program_id"]);
				}else{
					$data=array('status'=>2,'msg'=>'密码错误');
				}
			}else if($is_nan_load_muban["state"]==2){
				$data=array('status'=>6,'msg'=>'超级管理员停用停用');
			}else if($is_nan_load_muban["state"]==3){
				$data=array('status'=>7,'msg'=>'服务商权限停用');
			}else if($is_nan_load_muban["state"]==4){
				$data=array('status'=>8,'msg'=>'模板到期停用');
			}
	
		}else{
			$data=array('status'=>4,'msg'=>'请输入正确的账号密码，当前禁止登陆');
		}
		
		
		$this->ajaxReturn($data);
	}
	
	//0923...11.51  小程序手机端需要一个商品模糊查询功能
	function index_search(){
		//需要小程序id，商品名（模糊） str
	//(goods_title like "%'.$_POST['str'].'%")
	$where['_string']='
		
					(id like "%'.$_POST['str'].'%")  
					OR (goods_title like "%'.$_POST['str'].'%")
		
	';			
	$where["program_id"]=$_POST["program_id"];
	$where["dsh_id"]="0";
	$where["goods_state"]="1";
	$list=M("goods")
	->field('id,image,sort,goods_title,goods_state,price_sell,fenlei_1,fenlei_2')
	->where($where)
	->select();
		
		for($i=0;$i<count($list);$i++){
			/*$id["goods_id"]=$list[$i]['id'];
			$w=M("goods_img")->field('image')->where($id)->order("time_set")->find();//得到对应商品第一张图片
			$list[$i]["image_first"]=$w["image"];*/
			
			$arr1102=explode(",",$list[$i]['image']);
			$list[$i]["image_first"]=$arr1102[0];
		}
		$this->ajaxReturn($list);
	}
	//多内容搜索
	function more_search(){
		
		
		//style   1:商品名称模糊搜索、2:子商户名称搜索（子商户地址搜索）、子商户id搜索
		
		if($_POST["style"]==1){
			$where['_string']='
					(id like "%'.$_POST['str'].'%")  
					OR (goods_title like "%'.$_POST['str'].'%")
		
			';			
			$where["program_id"]=$_POST["program_id"];
		//	$where["dsh_id"]="0";
			$where["goods_state"]="1";
			$list=M("goods")
			->field('id,image,sort,goods_title,goods_state,price_sell,fenlei_1,fenlei_2')
			->where($where)
			->select();
				
				for($i=0;$i<count($list);$i++){
					$arr1102=explode(",",$list[$i]['image']);
					$list[$i]["image_first"]=$arr1102[0];
				}
			//	dump($list);dump(M("goods")->_sql());die;
				
		}else if($_POST["style"]==2){
			$where['_string']='
					(sh_name like "%'.$_POST['str'].'%")  
					OR (detail_address like "%'.$_POST['str'].'%")
				
			';	
			$where["program_id"]=$_POST["program_id"];
			$where["state"]="3";
			$list=M("user_info_dsh")
			->field('id,logo,sh_name,detail_address,tel,linkman,sh_jd,main_project')
			->where($where)
			->select();
			
			
	for($i=0;$i<count($list);$i++){
					//接收手机坐标
		
		$coordinate=explode(",",$list[$i]["sh_jd"]);
		$coordinate_phone=explode(",",$_POST["coordinate"]);
		$list[$i]["distance"]=$this->getDistance($lat1=$coordinate[0], $lng1=$coordinate[1], $lat2=$coordinate_phone[0], $lng2=$coordinate_phone[1]);
	
		//商户分类
		$attribute[$i]=M("attribute")->where("id='".$list[$i]["fl_id"]."'")->find();
		$list[$i]["fl_info"]=$attribute[$i];
		
		}
		
			
			
		}else if($_POST["style"]==3){
			//$attribute=M("attribute")->where("id='".$_POST["id"]."'")->find();
			
	
			$where["fl_id"]=$_POST["id"];
			$where["program_id"]=$_POST["program_id"];
			$where["state"]="3";
			$list=M("user_info_dsh")
			->field('id,logo,sh_name,detail_address,tel,linkman,sh_jd')
			->where($where)
			->select();
			
			for($i=0;$i<count($list);$i++){
					//接收手机坐标
		
		$coordinate=explode(",",$list[$i]["sh_jd"]);
		$coordinate_phone=explode(",",$_POST["coordinate"]);
		$list[$i]["distance"]=$this->getDistance($lat1=$coordinate[0], $lng1=$coordinate[1], $lat2=$coordinate_phone[0], $lng2=$coordinate_phone[1]);
	
		}
		}
		//dump($list);dump(M("user_info_dsh")->_sql());die;
		$this->ajaxReturn($list);
	}
	
	//小程序验证cookie
	function check_cookie(){
		
		if($_COOKIE["program_id"]=$_GET["program_id"]){
			$data=array('status'=>1,'msg'=>'状态已登录，可以继续操作');
			
		}else{
			$data=array('status'=>2,'msg'=>'状态未登录，禁止继续操作');
		}
		
		$this->ajaxReturn($data);
	}
	
	
	public function getUserInfo($code)
	{
		$appid = "wx4bb0aadc3a08b089";
		$appsecret = "3f70213f92f4cbd89f46b54e8f080035";

		//oauth2的方式获得openid
		$access_token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code";
		$access_token_json = $this->https_request($access_token_url);
		$access_token_array = json_decode($access_token_json, true);
		$openid = $access_token_array['openid'];
		$access_token = $access_token_array['access_token'];

		//全局access token获得用户基本信息
		$userinfo_url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid";
		$userinfo_json = $this->https_request($userinfo_url);
		$userinfo_array = json_decode($userinfo_json, true);
		return $userinfo_array;
	}

	public function https_request($url)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($curl);
		if (curl_errno($curl)) {return 'ERROR '.curl_error($curl);}
		curl_close($curl);
		return $data;
	}
	
	public function wellcome(){
		$data= M("store")
		->field('wellcome')
		->where("program_id='".$_GET["program_id"]."'")
		->find();
		$this->ajaxReturn($data["wellcome"]);
	}
	
	//1011...10.40 联系我们
	
	function man_contect(){
		//得到小程序id 、个人openid ，将信息存在 个人数据表中  man_contect
		
		
		if(empty($_POST["program_id"]) | empty($_POST["openid"])){
			$this->ajaxReturn(array('state'=>-999,'msg'=>'参数错误 '));
		}
		$date["program_id"]=$_POST["program_id"];
		$date["openid"]=$_POST["openid"];
		
		$date["realname"]=$_POST["realname"];
		$date["tel_contect"]=$_POST["tel_contect"];
		$date["sex"]=$_POST["sex"];
		
		$date["qq"]=$_POST["qq"];
		$date["weixin"]=$_POST["weixin"];
		$date["zixun_content"]=$_POST["zixun_content"];
		
		$date["booking_time"]=$_POST["booking_time"];
		$date["booking_room_id"]=$_POST["booking_room_id"];
		$date["time_set"]=time();
		if(M("man_contect")->add($date)){
			$data="1";//存数据成功
		}else{
			$data="2";//存数据失败
		}
		
		$this->ajaxReturn($data);
	}
	
	
	
	
	//计算两个坐标的经纬度
	function getDistance($lat1, $lng1, $lat2, $lng2) { 
		$earthRadius = 6367000; //approximate radius of earth in meters 
		//维度 lat   精度 lng
		
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
	
	function test_distance(){
		$a=$this->getDistance("39.983172", "116.308479", "39.996059", "116.353454");
		dump($a);
	}
	
	
	
	 public function http_request($url,$data = null,$headers=array())
    {
        $curl = curl_init();
        if( count($headers) >= 1 ){
        	curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:8.8.8.8', 'CLIENT-IP:123.207.42.92'));//IP 
        //    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
         curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:8.8.8.8', 'CLIENT-IP:123.207.42.92'));//IP 
       
   	 	//curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:8.8.8.8', 'CLIENT-IP:8.8.8.8'));//IP 
    		 curl_setopt($ch, CURLOPT_REFERER, "http://www.jb51.net/ ");   //来路 
	        curl_setopt($curl, CURLOPT_URL, $url);
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
	        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
	
	function arr_0_order($arr){
		$i=0;
		foreach($arr as $k=>$v){
			$arr_new[$i]=$v;
			$i++;
		}
		return $arr_new;
	}
	//文章展示接口 setInc
	
	function artical_show(){
		
		$where["id"]=$_GET["id"];	

		$artical=M("artical")->where($where)->find();
		
		if($_GET["program_id"]=="JT201806151732369242"){
			$a=M("members")->field("id,artical_id")->where("openid='".$_GET["openid"]."'"."and program_id='".$_GET["program_id"]."'")->find();
		
			$arr=explode(",",$a["artical_id"]);
			if(in_array($artical["id"],$arr)){
				$artical["haved_pay"]=1;
			}else{
				$artical["haved_pay"]=0;
			}
			
		}
		
		
		$this->ajaxReturn($artical);
	}
	
	function artical_list(){
		$where["is_show"]=1;
		$where["program_id"]=$_GET["program_id"];
		if($_GET["program_id"]=="JT201807211029434559"){
			$where["state"]=2;
		}else if($_GET["program_id"]=="JT201806151732369242"){
			$where["state"]=3;
		}else{
			$where["state"]=1;
		}
		
		$artical=M("artical")->where($where)->order("sort")->select();
		$this->ajaxReturn($artical);
	}

	//判断商城版的分类层级
	function check_fenlei_lever(){
		
		$a=M("store")->field("fenlei_lever")->where("program_id='".$_GET["program_id"]."'")->find();
		$this->ajaxReturn($a["fenlei_lever"]);
	}
	
	//提交预约信息
	function booking_submit(){
		$add["program_id"]	=$_POST["program_id"];
		$add["openid"]		=$_POST["openid"];
		$add["name"]		=$_POST["name"];
		$add["tel"]			=$_POST["tel"];
		$add["date_d"]		=$_POST["date_d"];
		$add["date_time"]	=$_POST["date_time"];
		$add["goods_id"]	=$_POST["goods_id"];
		$add["time_set"]	=time();
		$add["booking_num"]	=date("Ymd",time()).rand("1111","9999");
		if(M("booking")->add($add)){
			$data=array("state"=>1,"msg"=>"提交成功");
		}else{
			$data=array("state"=>-1,"msg"=>"提交成功");
		}
		$this->ajaxReturn($data);
	}
	function index_ad(){
		$a=M("store")->field("index_ad_img,index_ad_content,index_ad_showtime")->where("program_id='".$_GET["program_id"]."'")->find();
		$this->ajaxReturn($a);
	}
	
	function fl_goods(){
		$e=M("goods")
		->field('id,sort,goods_video,image,area_re,goods_title,sell_num,goods_shorttitle,good_attribute,price_sell,is_use_consumption_num,price_own,goods_subtitle,goods_subtitle01,goods_subtitle02,goods_subtitle03,goods_subtitle04,goods_subtitle05')
		->where("goods_state=1  and program_id='".$_GET["program_id"]."'"."and fenlei_1='".$_GET["fenlei_1"]."'")->order("sort")->select();

		for($i=0;$i<count($e);$i++){
	
			$arr1102=explode(",",$e[$i]['image']);
			$e[$i]["image_first"]=$arr1102[0];
	
		}
			if($_GET["program_id"]=="JT201810111844206577"){//珠宝小程序地域推送
			for($i0=0;$i0<count($e);$i0++){
				if($e[$i0]["area_re"]=="全国"){
					$goods_i0[]=$e[$i0];
				}else{
					$arr_area_re[$i0]=explode(",",$e[$i0]["area_re"]);
				
					if(in_array($_GET["city"],$arr_area_re[$i0])){
						$goods_i0[]=$e[$i0];		
					}
				}
				
			}					
			$e=$goods_i0;
		}
			
		$this->ajaxReturn($e);
	}
	function fl_goods_2(){
		$e=M("goods")
//		->field('id,sort,goods_video,image,area_re,goods_title,sell_num,goods_shorttitle,good_attribute,price_sell,is_use_consumption_num,price_own,goods_subtitle,goods_subtitle01,goods_subtitle02,goods_subtitle03,goods_subtitle04,goods_subtitle05')
		->where("goods_state=1  and program_id='".$_GET["program_id"]."'"."and fenlei_2='".$_GET["fenlei_2"]."'")->order("sort")->select();

		for($i=0;$i<count($e);$i++){
	
			$arr1102=explode(",",$e[$i]['image']);
			$e[$i]["image_first"]=$arr1102[0];
	
		}
			if($_GET["program_id"]=="JT201810111844206577"){//珠宝小程序地域推送
			for($i0=0;$i0<count($e);$i0++){
				if($e[$i0]["area_re"]=="全国"){
					$goods_i0[]=$e[$i0];
				}else{
					$arr_area_re[$i0]=explode(",",$e[$i0]["area_re"]);
				
					if(in_array($_GET["city"],$arr_area_re[$i0])){
						$goods_i0[]=$e[$i0];		
					}
				}
				
			}					
			$e=$goods_i0;
		}
			$members=M("members")->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();
			
			
			
		$z=array("goods_list"=>$e,"member_info"=>$members);	
		$this->ajaxReturn($z);
	}
	function fl_list(){
				
		$members=M("members")->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();
		$gaunzhu_fl_id=explode(",",$members["gaunzhu_fl_id"]);
		
		$a=M("attribute")->where("attribute_style=1 and is_show=1 and program_id='".$_GET["program_id"]."'")->select();
		for($i=0;$i<count($a);$i++){
			if(in_array($a[$i]["id"],$gaunzhu_fl_id)){
				$a[$i]["is_guanzhu"]=1;
			}else{
				$a[$i]["is_guanzhu"]=0;
			}
		}
		$list=$this->bq($a);
		for($i=0;$i<count($list);$i++){
			$list[$i]["height"]=43+intval(floor(count($list[$i]["child"])/2))*36+15;
			$list[$i]["num_child"]=count($list[$i]["child"]);
		}
		$this->ajaxReturn($list);

	}
//	二级分类商品列表
	function fenlei_2_list(){
		if($_GET["fenlei_2"]=="undefined"){
			$a=M("attribute")->where("uid='".$_GET["fenlei_1"]."'")->order("sort")->select();
		}else{
			$a0=M("attribute")->where("id='".$_GET["fenlei_2"]."'")->find();
			$a=M("attribute")->where("uid='".$a0["uid"]."'")->order("sort")->select();		
			
		}
			
		$field_goods='id,sort,price_sell_1,price_sell_2,fenlei_1,fenlei_2,area_re,kezhong,json_price_cl,guige_json_price_cl,kezhong,goods_video,image,goods_title,sell_num,goods_shorttitle,good_attribute,price_sell,is_use_consumption_num,price_own,goods_subtitle,goods_subtitle01,goods_subtitle02,goods_subtitle03,goods_subtitle04,goods_subtitle05';
		$where_goods["goods_state"]=1;
		$where_goods["program_id"]=$_GET["program_id"];
		$where_goods["fenlei_1"]=$_GET["fenlei_1"];
		if($_GET["fenlei_2"]=="undefined"){
			$where_goods["fenlei_2"]=$a[0]["id"];
		}else{
			$where_goods["fenlei_2"]=$_GET["fenlei_2"];
		}
		
		$b=M("goods")->field($field_goods)->where($where_goods)->select();
		for($i=0;$i<count($b);$i++){	
			$arr1102=explode(",",$b[$i]['image']);
			$b[$i]["image_first"]=$arr1102[0];
		}
		$members=M("members")->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();
		$z["f1"]=$b;
		$z=array("attribute"=>$a,'k4'=>$z,'member_info'=>$members);
	
		$this->ajaxReturn($z);
	}
	function audit_1(){
		$a=M("store")->field("is_audit")->where("program_id='".$_GET["program_id"]."'")->find();
		$b="https://sz800800.cn/Public/audit/index.png";
		if($a["is_audit"]==1){
			$this->ajaxReturn($b);
		}else{
			$this->ajaxReturn(1);
		}
	}
	function audit_2(){
		$a=M("store")->field("is_audit")->where("program_id='".$_GET["program_id"]."'")->find();
		$b="https://sz800800.cn/Public/audit/fl.png";
		if($a["is_audit"]==1){
			$this->ajaxReturn($b);
		}else{
			$this->ajaxReturn(1);
		}
	}
	function audit_3(){
		$a=M("store")->field("is_audit")->where("program_id='".$_GET["program_id"]."'")->find();
		$b="https://sz800800.cn/Public/audit/fx.png";
		if($a["is_audit"]==1){
			$this->ajaxReturn($b);
		}else{
			$this->ajaxReturn(1);
		}
	}
	function audit_4(){
		$a=M("store")->field("is_audit")->where("program_id='".$_GET["program_id"]."'")->find();
		$b="https://sz800800.cn/Public/audit/card.png";
		if($a["is_audit"]==1){
			$this->ajaxReturn($b);
		}else{
			$this->ajaxReturn(1);
		}
	}
	function audit_5(){
		$a=M("store")->field("is_audit")->where("program_id='".$_GET["program_id"]."'")->find();
		$b="https://sz800800.cn/Public/audit/mine.png";
		if($a["is_audit"]==1){
			$this->ajaxReturn($b);
		}else{
			$this->ajaxReturn(1);
		}
	}
	function zhubao_goods(){
		
		
		$field_goods='id,sort,price_sell_1,price_sell_2,fenlei_1,fenlei_2,area_re,kezhong,json_price_cl,guige_json_price_cl,kezhong,goods_video,image,goods_title,sell_num,goods_shorttitle,good_attribute,price_sell,is_use_consumption_num,price_own,goods_subtitle,goods_subtitle01,goods_subtitle02,goods_subtitle03,goods_subtitle04,goods_subtitle05';
		$where_goods["goods_state"]=1;
		$where_goods["program_id"]=$_GET["program_id"];
		
		if($_GET["str"]){
			$where_goods['_string']='
			(goods_title like "%'.$_GET["str"].'%")  

		';
		}
		
		$e=M("goods")->field($field_goods)->where($where_goods)->order("sort")->select();//商品图片标题

		if($_GET["program_id"]=="JT201810111844206577"){//珠宝小程序地域推送
			for($i0=0;$i0<count($e);$i0++){
				
				$arr_area_re[$i0]=explode(",",$e[$i0]["area_re"]);
				
				if(in_array($_GET["city"],$arr_area_re[$i0])){
					$goods_i0[]=$e[$i0];
					
				}

			}		
			
			$e=$goods_i0;

		}
			
		for($i=0;$i<count($e);$i++){
	
			$arr1102=explode(",",$e[$i]['image']);
			$e[$i]["image_first"]=$arr1102[0];
	
			if($e[$i]["goods_subtitle01"]==1) $f["f1"][$i]=$e[$i];//分组1、热卖
			if($e[$i]["goods_subtitle02"]==1) $f["f2"][$i]=$e[$i];//分组2、新品
			if($e[$i]["goods_subtitle03"]==1) $f["f3"][$i]=$e[$i];//分组3、推荐
			if($e[$i]["goods_subtitle04"]==1) $f["f4"][$i]=$e[$i];//分组4、促销
			if($e[$i]["goods_subtitle05"]==1) $f["f5"][$i]=$e[$i];//分组5、包邮
	
			if($e[$i]["goods_video"]!=0) $f["f6"][$i]=$e[$i];//分组6、商品上传视频
			
			if($e[$i]["is_use_consumption_num"]==1) $f["f7"][$i]=$e[$i];//是否能用消费码
		}
			$f["f1"]=$this->arr_0_order($f["f1"]);
			$f["f2"]=$this->arr_0_order($f["f2"]);
			$f["f3"]=$this->arr_0_order($f["f3"]);
			$f["f4"]=$this->arr_0_order($f["f4"]);
			$f["f5"]=$this->arr_0_order($f["f5"]);
			
			
			$attribute=M("attribute")->field("id,title,title_english,image_1,is_index_recommend")->where("attribute_style=1 and uid=0 and is_show=1 and program_id='".$_GET["program_id"]."'")->order("sort")->select();
			
			
			$members=M("members")->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();

			$d=array('k4'=>$f,'attribute'=>$attribute,'member_info'=>$members);
			
			
			$this->ajaxReturn($d);
	}
	
	function guanzhu(){
		$a=M("members")->where("openid='".$_GET["openid"]."'"."and program_id='".$_GET["program_id"]."'")->find();
		
		$gaunzhu_fl_id=explode(",",$a["gaunzhu_fl_id"]);
		if(in_array($_GET["fl_id"],$gaunzhu_fl_id)){
			for($i=0;$i<count($gaunzhu_fl_id);$i++){
				if($gaunzhu_fl_id[$i]!=$_GET["fl_id"]){
					$arr[$i]=$gaunzhu_fl_id[$i];
				}				
			}
			$save["gaunzhu_fl_id"]=implode(",",$arr);
		}else{
			if(empty($a["gaunzhu_fl_id"])){
				$save["gaunzhu_fl_id"]=$_GET["fl_id"];
			}else{
				$save["gaunzhu_fl_id"]=$a["gaunzhu_fl_id"].",".$_GET["fl_id"];
			}
		}
		if(M("members")->where("openid='".$_GET["openid"]."'"."and program_id='".$_GET["program_id"]."'")->save($save)){
			$data=array("state"=>1,"msg"=>"操作成功");
		}else{
			$data=array("state"=>-1,"msg"=>"操作失败");
		}
		$this->ajaxReturn($data);
	}
//	首页关注商品展示
	function guanzhu_goods(){
		$a=M("members")->where("openid='".$_GET["openid"]."'"."and program_id='".$_GET["program_id"]."'")->find();
		$gaunzhu_fl_id=explode(",",$a["gaunzhu_fl_id"]);
		$where_goods["goods_state"]=1;
		$where_goods["program_id"]=$_GET["program_id"];
		$where_goods["fenlei_1"]=array('neq','');
		$e=M("goods")->where($where_goods)->order("sort")->select();//商品图片标题
		
		for($i0=0;$i0<count($e);$i0++){				
			$arr_area_re[$i0]=explode(",",$e[$i0]["area_re"]);			
			if(in_array($_GET["city"],$arr_area_re[$i0])){
				$goods_i0[]=$e[$i0];				
			}
		}		
		$e=$goods_i0;
	
		for($i=0;$i<count($e);$i++){	
			$arr1102=explode(",",$e[$i]['image']);
			$e[$i]["image_first"]=$arr1102[0];	
			

			if(empty($guanzhu_1)){
				if($e[$i]["fenlei_1"]==$gaunzhu_fl_id[0]){
					$guanzhu_1=$e[$i];
				}
			}
			if(empty($guanzhu_2)){
				if($e[$i]["fenlei_1"]==$gaunzhu_fl_id[1]){
					$guanzhu_2=$e[$i];
				}
			}
			if(empty($guanzhu_3)){
				if($e[$i]["fenlei_1"]==$gaunzhu_fl_id[2]){
					$guanzhu_3=$e[$i];
				}
			}
			if(empty($guanzhu_4)){
				if($e[$i]["fenlei_1"]==$gaunzhu_fl_id[3]){
					$guanzhu_4=$e[$i];
				}
			}	
		}
	
		$z=array('guanzhu_1'=>$guanzhu_1,'guanzhu_2'=>$guanzhu_2,'guanzhu_3'=>$guanzhu_3,'guanzhu_4'=>$guanzhu_4);
//dump($gaunzhu_fl_id);dump($z);die;
		$this->ajaxReturn($z);
	}
	function order_dsh($b){
		$arr_sh_id=array();
		$arr=array();
		$key=0;
		
		foreach($b as $k=>$v){
			if(empty($arr_sh_id)){
				$arr_sh_id[$key]=$b[$k]["dsh_id"];
				$arr[$b[$k]["dsh_id"]][$b[$k]["id"]]=$b[$k];
				$key=1;
			}else{
		
				if(!in_array($b[$k]["dsh_id"],$arr_sh_id)){
					$arr_sh_id[$key]=$b[$k]["dsh_id"];
					$arr[$b[$k]["dsh_id"]][$b[$k]["id"]]=$b[$k];
					$key+=1;
				} else{
					$arr[$b[$k]["dsh_id"]][$b[$k]["id"]]=$b[$k];
				}
			}			
		}
		return $arr;
	}
}

?>