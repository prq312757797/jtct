<?php
namespace Program\Controller;
use Think\Controller;
header('content-type:application:json;charset=utf8'); 
header('Access-Control-Allow-Origin:*'); 
//header('Access-Control-Allow-Methods:POST'); 
header('Access-Control-Allow-Headers:x-requested-with,content-type');
class FWinfoController extends Controller {
	
//获得帖子内容
//帖子列表
//帖子内容
//添加帖子----附表添加数据
//临时表数据拼接之后加入正式信息表
//帖子删除----应该写在个人帖子管理页面的
//异步点赞接口
//添加评论接口
//评论删除


//获得帖子内容
function index_tiezi(){
	//获得小程序id 只获取五条，其他的就去真正的列表页
	$jt04_fw_info=M("jt04_fw_info")->where("program_id='".$_POST["program_id"]."'")->order("time_set desc")->limit("0,6")->select();
	
	for($i=0;$i<count($jt04_fw_info);$i++){
			$members=M("members")->where("openid='".$jt04_fw_info[$i]["openid"]."'")->find();
		
				$jt04_fw_info[$i]["head"]=$members["head"];
				$jt04_fw_info[$i]["nickname"]=$members["nickname"];
					$time_lase=time()-$jt04_fw_info[$i]["time_set"];
				if($time_lase<60 ){
					$jt04_fw_info[$i]["time_last"]=$time_lase."秒前";
				}else if($time_lase<3600){
					$jt04_fw_info[$i]["time_last"]=floor($time_lase/60)."分钟前";
				}else if($time_lase<86400){
					$jt04_fw_info[$i]["time_last"]=floor($time_lase/3600)."小时前";
				}else if($time_lase<2592000){
					$jt04_fw_info[$i]["time_last"]=floor($time_lase/86400)."天前";
				}	
				
			$where00["program_id"]=$_POST["program_id"];
			$where00["openid"]=$_POST["openid"];
			$where00["info_id"]=$jt04_fw_info[$i]["id"];
			
			$give_like=M("give_like")->where($where00)->find();
				if(empty($give_like)){
					$jt04_fw_info[$i]["is_say_yes"]=false;//没点赞
				}else{
					$jt04_fw_info[$i]["is_say_yes"]=true;//点赞了
				}		
			}

	$this->ajaxReturn($jt04_fw_info);
}

//帖子列表  首页异步用的
function tiezi_list(){
	$where["program_id"]=$_GET["program_id"];
	$where["id"]=array("lt",$_GET["id"]);
	
	$jt04_fw_info=M("jt04_fw_info")
	->where($where)
	->order("time_set desc")->limit("0,5")->select();
	
	for($i=0;$i<count($jt04_fw_info);$i++){
		$members=M("members")->where("openid='".$jt04_fw_info[$i]["openid"]."'")->find();
		
				$jt04_fw_info[$i]["head"]=$members["head"];
				$jt04_fw_info[$i]["nickname"]=$members["nickname"];

				$time_lase=time()-$jt04_fw_info[$i]["time_set"];
				if($time_lase<60 ){
					$jt04_fw_info[$i]["time_last"]=$time_lase."秒前";
				}else if($time_lase<3600){
					$jt04_fw_info[$i]["time_last"]=floor($time_lase/60)."分钟前";
				}else if($time_lase<86400){
					$jt04_fw_info[$i]["time_last"]=floor($time_lase/3600)."小时前";
				}else if($time_lase<2592000){
					$jt04_fw_info[$i]["time_last"]=floor($time_lase/86400)."天前";
				}		
			}
			
	//判断进来的人是否点赞了
		for($i=0;$i<count($jt04_fw_info);$i++){
			$where00["program_id"]=$_GET["program_id"];
			$where00["openid"]=$_GET["openid"];
			$where00["info_id"]=$jt04_fw_info[$i]["id"];
			
			$give_like=M("give_like")->where($where00)->find();
		if(empty($give_like)){
			$jt04_fw_info[$i]["is_say_yes"]=false;//没点赞
		}else{
			$jt04_fw_info[$i]["is_say_yes"]=true;//点赞了
		}	
	}
		
	$this->ajaxReturn($jt04_fw_info);	
}

//帖子内容

function tiezi_con(){
	M("jt04_fw_info")->where("id='".$_POST["info_id"]."'")->setInc("num_read",1);
	
	//帖子内容
	
	$jt04_fw_info=M("jt04_fw_info")->where("id='".$_POST["info_id"]."'")->find();
	

		$members=M("members")->where("openid='".$jt04_fw_info["openid"]."'")->find();
		
				$jt04_fw_info["head"]=$members["head"];
				$jt04_fw_info["nickname"]=$members["nickname"];

	
	//评论
	$discuss=M("discuss")->where("program_id='".$_POST["program_id"]."'"." and info_id='".$_POST["info_id"]."'")->select();
	
	for($i=0;$i<count($discuss);$i++){
		$where["openid"]=$discuss[$i]["openid"];
		
		$where01["openid"]=$discuss[$i]["openid_ask"];
		
		$a=M("members")->where($where)->find();
		$b=M("members")->where($where01)->find();
		
		$discuss[$i]["owner_head"]=$a["head"];
		$discuss[$i]["owner_nickname"]=$a["nickname"];
		
		$discuss[$i]["ask_head"]=$b["head"];
		$discuss[$i]["ask_nickname"]=$b["nickname"];
	}
	
	//判断进来的人是否点赞了
	$give_like=M("give_like")->where("program_id='".$_POST["program_id"]."'"." and openid='".$_POST["openid"]."'")->find();
	if(empty($give_like)){
		$is_give_like=false;//没点赞
	}else{
		$is_give_like=true;//点赞了
	}
	
	$date=array('k1'=>$jt04_fw_info,'k2'=>$discuss,'k3'=>$is_give_like);
	$this->ajaxReturn($date);	
}

//添加帖子----附表添加数据
function tiezi_add(){
	$receive=$_POST;
		if(empty($receive["openid"])){
			$this->ajaxReturn(array('state'=>-999,'msg'=>'openid缺失'));
		}
		if(empty($receive["program_id"])){
			$this->ajaxReturn(array('state'=>-999,'msg'=>'program_id缺失'));
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
				$receive['state']="1";//待审
				$receive['time_set']=time();

				//$receive["on_time"]=time().rand("1111","9999");
				if(M('jt04_fw_info_copy')->add($receive)){ 
							$this->ajaxReturn(array('state'=>1,'msg'=>'成功'));
							    }else{
							$this->ajaxReturn(array('state'=>-1,'msg'=>'失败'));
					}	
		
			 }else{
			 	//无图片===============================================================
			 	
			 	if(M('jt04_fw_info_copy')->add($receive)){
						$this->ajaxReturn(array('state'=>1,'msg'=>'成功'));
					}else{
						$this->ajaxReturn(array('state'=>-1,'msg'=>'失败'));
					}	
			 }
}

//临时表数据拼接之后加入正式信息表
	function temp_info(){
	
		$only_num=M("jt04_fw_info")->where("only_num='".$_GET["only_num"]."'")->find();	
	
		$only_num01=M("jt04_fw_info_copy")->where("only_num='".$_GET["only_num"]."'")->select();
		
						if(empty($only_num)){
								if(M("jt04_fw_info")->add($only_num01[0])){
									if(count($only_num01)>1){
										$only_num02=M("jt04_fw_info")->where("only_num='".$_GET["only_num"]."'")->find();
										
										for($i=0;$i<count($only_num01);$i++){
										//	$save01["image"]=$only_num02["image"].",".$only_num01[$i]['image'];		
											$save01["image"].=$only_num01[$i]['image'].",";		

											}
										$save01['image'] = substr($save01['image'],0,strlen($save01['image'])-1);
										if(M("jt04_fw_info")->where("only_num='".$_GET['only_num']."'")->save($save01)){
											$this->ajaxReturn("1");
										}else{
											$this->ajaxReturn("2");
										}
									
									}
								}
						}
		
	}

//帖子删除----应该写在个人帖子管理页面的
function tiezi_delete(){
$info=	M("jt04_fw_info")->where("id='".$_POST["info_id"]."'")->find();
	if(M("jt04_fw_info")->where("id='".$_POST["info_id"]."'")->delete()){
		
			$arr=explode(",",$info["image"]);
				for($i=0;$i<count($arr);$i++){
					unlink('./Uploads/'.$arr[$i]);
			}
		
			$date=array('state'=>1,'msg'=>'帖子删除成功');
		}else{
			$date=array('state'=>-1,'msg'=>'帖子删除失败 ');
		}
		$this->ajaxReturn($date);
}


//异步点赞接口
function give_like(){
	$where["program_id"]=$_POST["program_id"];
	$where["openid"]=$_POST["openid"];
	$where["info_id"]=$_POST["info_id"];
	
	$give_like=M("give_like")->where($where)->find();
	if(empty($give_like)){
		//这个人对这个信息没点赞  执行添加操作
		
		if(M("jt04_fw_info")->where("id='".$_POST["info_id"]."'")->setInc("num_say_yes",1)){
		
			$where["time_set"]=time();
			M("give_like")->add($where);
			
			$date=array('state'=>1,'msg'=>'点赞成功 ，页面点赞数加一');
		}else{
			$date=array('state'=>-1,'msg'=>'点赞失败 ');
		}
	}else{
		$date=array('state'=>2,'msg'=>'已经点赞过了 ');
		/*if(M("jt04_fw_info")->where("id='".$_POST["info_id"]."'")->setInc("num_say_yes",-1)){

			M("give_like")->where($where)->delete();
			$date=array('state'=>1.0,'msg'=>'取消点赞成功 ，页面点赞数减一');
		}else{
			$date=array('state'=>-1.0,'msg'=>'取消点赞失败 ');
		}*/
	}

	$this->ajaxReturn($date);
}

//添加评论接口
function discuss_add(){
	$is_owner=M("jt04_fw_info")->where("id='".$_POST["info_id"]."'")->find();
	
	
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
	
	if($is_owner["openid"]==$_POST["openid"]){
		//访问接口的人是帖子发布者
		$where["answer_or_ask"]="1";	//回答还是提问、（1：回答、2：提问）
	}else{
		$where["answer_or_ask"]="2";	//回答还是提问、（1：回答、2：提问）
	}

	if(M("discuss")->add($where)){
		M("jt04_fw_info")->where("id='".$_POST["info_id"]."'")->setInc("num_write",1);
			$date=array('state'=>1,'msg'=>'评论成功 ，页面评论数加一');
		}else{
			$date=array('state'=>-1,'msg'=>'评论失败 ');
		}
	$this->ajaxReturn($date);
}

//评论删除
function  discuss_delete(){
	if(M("discuss")->where("id='".$_POST["info_id"]."'")->delete()){
		M("jt04_fw_info")->where("id='".$_POST["info_id"]."'")->setInc("num_write",-1);
			$date=array('state'=>1.0,'msg'=>'评论删除成功 ，页面评论数减一');
		}else{
			$date=array('state'=>-1.0,'msg'=>'评论删除失败 ');
		}
	$this->ajaxReturn($date);
   }
   
   
   
   //预约页面打开判断显示页面
   function open_yy(){
   		if(empty($_POST["program_id"]) | empty($_POST["openid"])){
			$this->ajaxReturn(array('state'=>-999,'msg'=>'参数错误 '));
		}
   		//program_id、openid
   		$where["state"]="1";
   		$where["program_id"]=$_POST["program_id"];
   		$where["openid"]=$_POST["openid"];
   		$where["goods_id"]=$_POST["goods_id"];
   		
	$is_yy=M("jt04_fw_yuyue")->where($where)->find();
   		
   		if(empty($is_yy)){
   			$date=array('state'=>1,'msg'=>'这个人没预约过，打开预约提交页面');
   		}else{
   			$date=array('state'=>2,'msg'=>'这个人有预约了打开的是这个人的预约信息页面');
   		}
   		$this->ajaxReturn($date);
   }
   
   //个人预约信息展示页面
   function self_info_yy(){
   	//program_id  openid  goods_id
   			if(empty($_POST["program_id"]) | empty($_POST["openid"])){
			$this->ajaxReturn(array('state'=>-999,'msg'=>'参数错误 '));
		}
   		
   		$where["state"]="1";
   		$where["program_id"]=$_POST["program_id"];
   		$where["openid"]=$_POST["openid"];
   		$where["goods_id"]=$_POST["goods_id"];
   	
   		$is_yy=M("jt04_fw_yuyue")->where($where)->find();
   		
   		$goods=M("goods")->where("id='".$is_yy["goods_id"]."'")->find();
   		$is_yy["goods_name"]=$goods["goods_title"];
   	
   	$image=M("store")->field('image_fu_fenlei')->where("program_id='".$_COOKIE["program_id"]."'")->find();
  	
   	$is_yy["image_ad"]=$image["image_fu_fenlei"];
  	 	$this->ajaxReturn($is_yy);
   }

   
   //提交预约接口
   function submit_yy(){
   	
		if(empty($_POST["program_id"]) | empty($_POST["openid"])){
			$this->ajaxReturn(array('state'=>-999,'msg'=>'参数错误 '));
		}

		$_POST["state"]="1";
   		if(M("jt04_fw_yuyue")->add($_POST)){
   			$date=array('state'=>1.0,'msg'=>'添加成功');
		}else{
			$date=array('state'=>-1.0,'msg'=>'添加失败');
		}
			$this->ajaxReturn($date);
   }

   
   //服务版的个人中心那里的东西==========================================
   
   //我的预约列表页面
   function my_yy_list(){
   		if(empty($_POST["program_id"]) | empty($_POST["openid"])){
			$this->ajaxReturn(array('state'=>-999,'msg'=>'参数错误 '));
		} 
   		$is_yy=M("jt04_fw_yuyue")->where("state=1 and program_id='".$_POST["program_id"]."'"." and openid='".$_POST["openid"]."'")->select();
   	
   		$this->ajaxReturn($is_yy);
   		
   }
  //个人取消自己的预约
  
  	function self_sayno_yy(){
  			if(empty($_POST["program_id"]) | empty($_POST["openid"])){
			$this->ajaxReturn(array('state'=>-999,'msg'=>'参数错误 '));
		}
  		$save["state"]="3";
  		
  		$where["program_id"]=$_POST["program_id"];
  		$where["openid"]=$_POST["openid"];
  		$where["goods_id"]=$_POST["goods_id"];
  		
  		$save["time_say_no"]=time();
  		
  		if($is_yy=M("jt04_fw_yuyue")->where($where)->save($save)){
  			
  			$date=array('state'=>1.0,'msg'=>'取消成功');
		}else{
			$date=array('state'=>-1.0,'msg'=>'取消失败');
		}
  		
  		$this->ajaxReturn($date);
   	
  		
  	}
  
   //精品预约服务页面接口    0414  取消
  	function jingpin_yy(){
  		//program_id   
  			if(empty($_POST["program_id"]) ){
			$this->ajaxReturn(array('state'=>-999,'msg'=>'参数错误 '));
		}
  		//商品
  		$where["program_id"]=$_POST["program_id"];
  		$where["is_jingpin"]="1";
  		$where["goods_state"]="1";
  		
  		$goods=	M("goods")
  		->field('id,image,goods_title,price_sell')
  		->where($where)->limit(0,6)->select();
  	//	dump(M("goods")->_sql());
  		for($i=0;$i<count($goods);$i++){
  			$arr1102=explode(",",$goods[$i]['image']);
			$goods[$i]["image"]=$arr1102[0];
  		}
  			
  		
  		//广告
  		$image=M("store")->field('image_jingpin')->where("program_id='".$_POST["program_id"]."'")->find();
  		$z=array('k1'=>$goods,'k2'=>$image);
  		$this->ajaxReturn($z);
  	} 
  	
  	//最新促销活动  是文章
  	function new_activity(){
  		$artical_dsh=M("artical_dsh")->where("index_show=1 and program_id='".$_POST["program_id"]."'")->order("index_sort")->select();
  			
  		//广告
  		$image=M("store")->field('image_jingpin')->where("program_id='".$_POST["program_id"]."'")->find();
  			
  		$z=array('k1'=>$artical_dsh,'k2'=>$image);
  		$this->ajaxReturn($z);
  	}
  	
  	//服务活动详情
  	function artical_con(){
  		$artical_dsh=M("artical_dsh")->where("program_id='".$_GET["program_id"]."'"."and id='".$_GET["id"]."'")->find();
  		
  		
  		$dsh=M("user_info_dsh")
		->field('id,sh_name,detail_address,tel,linkman,sh_jd')
		->where("id='".$artical_dsh["dsh_id"]."'")->find();
		
		$coordinate=explode(",",$dsh["sh_jd"]);
		$coordinate_phone=explode(",",$_GET["coordinate"]);
		$dsh["distance"]=$this->getDistance($lat1=$coordinate[0], $lng1=$coordinate[1], $lat2=$coordinate_phone[0], $lng2=$coordinate_phone[1]);
		
  		$b["image"]=$artical_dsh["image"];
		
  		$z=array('k1'=> $artical_dsh,'k2'=>$b,'k3'=>$dsh);
  		$this->ajaxReturn($z);
  	}
  
  //精品商品异步加载
  function ajax_jingpin(){
  	if(empty($_GET["program_id"]) ){
			$this->ajaxReturn(array('state'=>-999,'msg'=>'参数错误 '));
		}
  	$where["program_id"]=$_GET["program_id"];
	$where["id"]=array("lt",$_GET["id"]);
	
	$goods=	M("goods")
  		->field('id,image,goods_title,price_sell')
  		->where($where)->limit(0,6)->select();
  		
  				for($i=0;$i<count($goods);$i++){
  			$arr1102=explode(",",$goods[$i]['image']);
			$goods[$i]["image"]=$arr1102[0];
  		}
  			
			
	$this->ajaxReturn($goods);		
  }
  
  
  //立即抢购
  function buy_now(){
  	//点击抢购生成订单、确认无误就提交支付
  	
  	
  }
  
  //服务版分类
  function fenlei(){
  	if(empty($_GET["program_id"])){
  		$this->ajaxReturn(array('state'=>'1','msg'=>"参数错误"));
  	}
  	
 	 $attribute=M("attribute")->field('id,title')->where("is_show=1 and attribute_style=2 and program_id='".$_GET["program_id"]."'")->select();
   //dump($attribute);die;
 	 $this->ajaxReturn($attribute);
  }
  //子商户条件搜索
  function dsh_search(){
  	
  	 // 1:行业分类  and 2:支付方式  3:区域搜索  4：是否有额度
  
  	if(empty($_GET["program_id"]) ){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
  	$where["program_id"]=$_GET["program_id"];
  	if($_GET["state"]==2){
  		//支付方式 搜索
  	//	$where["payment_method_id"]=$_GET["payment_method_id"];
  			
  		$where['_string']='
			(payment_method_id like "%'.$_GET["payment_method_id"].'%")  

	';			
  	}else if($_GET["state"]==3){
  		//区域搜索
  		$where["merch_area_id"]=$_GET["merch_area_id"];
  		
	
  	}else if($_GET["state"]==1){
  		//行业分类
  			
  		$where["fl_id"]=$_GET["fl_id"];
  		
  	}else if($_GET["state"]==4){
  		//是否有额度
  		
  		$where["is_lines"]="1";
  		
  	}else if($_GET["state"]==5){
  		//名称模糊搜索
  		
  		$where['_string']='
					(sh_name like "%'.$_GET['str'].'%")  
					OR (detail_address like "%'.$_GET['str'].'%")
				
			';	
  		
  	}
  	
  	$a=M("user_info_dsh")->where($where)->select();
  	
  	

  	for($i=0;$i<count($a);$i++){
  		//坐标
  		$coordinate[$i]=explode(",",$a[$i]["sh_jd"]);
		$coordinate_phone=explode(",",$_GET["coordinate"]);
		
		$user = A('Index');
		$a[$i]["distance"]=$user->getDistance($lat1=$coordinate[$i][0], $lng1=$coordinate[$i][1], $lat2=$coordinate_phone[0], $lng2=$coordinate_phone[1]);
		
	
		$arr_pay[$i]=explode(",",$a[$i]["payment_method_id"]);	
		//支付方式显示
		for($k=0;$k<count($arr_pay[$i]);$k++){
			$arr_pay_name[$i][$k]=M("payment_method_dsh")->field('title')->where("id='".$arr_pay[$i][$k]."'")->find();
			if($arr_pay_name[$i][$k]["id"]==$_GET["payment_method_id"]){
				$a[$i]["search_pay"]=$arr_pay_name[$i][$k]["title"];
			}
		}
		for($r=0;$r<count($arr_pay_name[$i]);$r++){
			$str_pay_name[$i].=$arr_pay_name[$i][$r]["title"].",";
		}

		$str_pay_name[$i] = substr($str_pay_name[$i],0,strlen($str_pay_name[$i])-1); //去掉最后一个逗号

		$a[$i]["str_pay_name"]=$str_pay_name[$i];
		
		$a[$i]["arr_pay_name"]=explode(",",$a[$i]["str_pay_name"]);
		
		
//		if($_GET["state"]==2){
//				$search_pay[$i]=M("payment_method_dsh")->where("id='".$_GET["payment_method_id"]."'")->find();
//				$a[$i]["search_pay"]=$search_pay[$i]["title"];
//		}	
  	}
 	//查出传递过来的支付方式，高亮显示
  	$this->ajaxReturn($a);
  }
  
  function dsh_search_new(){
  	
  	 // 1:行业分类  and 2:支付方式  3:区域搜索  4：是否有额度

  	if(empty($_GET["program_id"]) ){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		

  	$where["program_id"]=$_GET["program_id"];
  	if($_GET["state"]!=5){
  	//	$_GET["history_state"]="1,2,1";	//历史搜索state	字符串
  	//	$_GET["history_data"]="4,5";	//历史搜索data 	数据字符串
  		
  		$h_state_arr=explode(",",$_GET["history_state"]);
  		$h_data_arr=explode(",",$_GET["history_data"]);

  		
  		foreach($h_state_arr as $k0=>$v0){
  			if($h_state_arr[$k0]==1){ $where["fl_id"]=$h_data_arr[$k0]; }
  			if($h_state_arr[$k0]==2){ 
  				$where['_string']=' (payment_method_id like "%'.$h_data_arr[$k0].'%") ';
  				$is_payment_method=1;
  				$is_payment_method_date=$h_data_arr[$k0];
  				}
  			if($h_state_arr[$k0]==3){ 
  				$merch_area_arr_t[$k0]=explode("-",$h_data_arr[$k0]);
  				
  				if($merch_area_arr_t[$k0][2]!="全部"){
		  			$where['_string']='
		  			(province like "%'.$merch_area_arr_t[$k0][0].'%")	or
		  			(city like "%'.$merch_area_arr_t[$k0][1].'%")  or
						(district like "%'.$merch_area_arr_t[$k0][2].'%")  
					';	
		  		}else if($merch_area_arr_t[$k0][1]!="全部"){
		  			$where['_string']='
		  			(province like "%'.$merch_area_arr_t[$k0][0].'%")	or
						(city like "%'.$merch_area_arr_t[$k0][1].'%")  
					';	
		  		}else if($merch_area_arr_t[$k0][0]!="全部"){
		  			$where['_string']='
						(province like "%'.$merch_area_arr_t[$k0][0].'%")  
					';	
		  		}
		  		$is_address=1;
		  		$is_address_date=$h_data_arr[$k0];
  			}
  			if($h_state_arr[$k0]==4){ $where["is_lines"]=$h_data_arr[$k0]; }
  		}
  		
  		if($_GET["state"]==1){$where["fl_id"]=$_GET["fl_id"];}//行业分类	
		if($_GET["state"]==2){
			if($is_address==1){
				$merch_area_arr_t_date=explode("-",$is_address_date);
				
				if($merch_area_arr_t[$k0][2]!="全部"){
		  			$where['_string']='
		  			(province like "%'.$merch_area_arr_t[$k0][0].'%")	or
		  			(city like "%'.$merch_area_arr_t[$k0][1].'%")  or
						(district like "%'.$merch_area_arr_t[$k0][2].'%")  or 
						(payment_method_id like "%'.$is_payment_method_date.'%")
					';	
		  		}else if($merch_area_arr_t[$k0][1]!="全部"){
		  			$where['_string']='
		  			(province like "%'.$merch_area_arr_t[$k0][0].'%")	or
						(city like "%'.$merch_area_arr_t[$k0][1].'%")  or 
						(payment_method_id like "%'.$is_payment_method_date.'%")
					';	
		  		}else if($merch_area_arr_t[$k0][0]!="全部"){
		  			$where['_string']='
						(province like "%'.$merch_area_arr_t[$k0][0].'%")  or 
						(payment_method_id like "%'.$is_payment_method_date.'%")
					';	
		  		}
				
			}else{
				$where['_string']='
				(payment_method_id like "%'.$_GET["payment_method_id"].'%")  
			';	
			}
	  				
	  	}
	  	if($_GET["state"]==3){
	  //区域选择
				  if($is_payment_method==1){
				  		$merch_area_arr=json_decode($_GET["merch_area_arr"]);
				  		if($merch_area_arr[2]!="全部"){
				  			$where['_string']='
				  			(province like "%'.$merch_area_arr[0].'%")	or
				  			(city like "%'.$merch_area_arr[1].'%")  or
								(district like "%'.$merch_area_arr[2].'%") or 
								(payment_method_id like "%'.$is_payment_method_date.'%")
							';	
				  		}else if($merch_area_arr[1]!="全部"){
				  			$where['_string']='
				  			(province like "%'.$merch_area_arr[0].'%")	or
								(city like "%'.$merch_area_arr[1].'%")  or 
								(payment_method_id like "%'.$is_payment_method_date.'%")
							';	
				  		}else if($merch_area_arr[0]!="全部"){
				  			$where['_string']='
								(province like "%'.$merch_area_arr[0].'%")  or 
								(payment_method_id like "%'.$is_payment_method_date.'%")
							';	
				  		}
				  }else{
				  	  	$merch_area_arr=json_decode($_GET["merch_area_arr"]);
				  		if($merch_area_arr[2]!="全部"){
				  			$where['_string']='
				  			(province like "%'.$merch_area_arr[0].'%")	or
				  			(city like "%'.$merch_area_arr[1].'%")  or
								(district like "%'.$merch_area_arr[2].'%")  
							';	
				  		}else if($merch_area_arr[1]!="全部"){
				  			$where['_string']='
				  			(province like "%'.$merch_area_arr[0].'%")	or
								(city like "%'.$merch_area_arr[1].'%")  
							';	
				  		}else if($merch_area_arr[0]!="全部"){
				  			$where['_string']='
								(province like "%'.$merch_area_arr[0].'%")  
							';	
				  		}
				  }
	  	// json_decode($_GET["merch_area_arr"])[0]

	  		}//区域搜索
	  	if($_GET["state"]==4){$where["is_lines"]="1";}//是否有额度

  	}else if($_GET["state"]==5){
  		//名称模糊搜索
  		$where['_string']='
					(sh_name like "%'.$_GET['str'].'%")  
					OR (detail_address like "%'.$_GET['str'].'%")
			';	
  	}
  	 	  	
  	$a=M("user_info_dsh")->field("id,detail_address,logo,sh_name,sh_jd,payment_method_id")->where($where)->select();
dump($where);dump(M("user_info_dsh")->_sql());dump($a);die;
  	if($_GET["state"]==1){
  		$getdate=$_GET["fl_id"];
  	}else if($_GET["state"]==2){
  			$getdate=$_GET["payment_method_id"];
  		
  	}else if($_GET["state"]==3){
  			$getdate=implode("-",json_decode($_GET["merch_area_arr"]));
  	}else if($_GET["state"]==4){
  		$getdate=1;
  	}

 	if(empty($h_state_arr[0])){

 		$str_history_state	=$_GET["state"];
 		$str_history_data	=$getdate;
/* 			
  		$isadd_history="1";		//累加搜索
  		$datare_history="0";	//更新条件*/
  	}else{
  	
  		if(in_array($_GET["state"],$h_state_arr)){
  					
  			$str_history_state	=implode(",",$h_state_arr);
  			
  			foreach($h_state_arr as $k=>$v){
  				if($h_state_arr[$k]==$_GET["state"]){
  					$h_data_arr[$k]	=$getdate;
  				}
  			}
  			$str_history_data	=implode(",",$h_data_arr);
  			
  		}else{
  			$str_history_state	=implode(",",$h_state_arr).",".$_GET["state"];
  			$str_history_data	=implode(",",$h_data_arr).",".$getdate;

  		}

  	}

  	for($i=0;$i<count($a);$i++){
  		$a[$i]["str_history_state"]=$str_history_state;
  		$a[$i]["str_history_data"]=$str_history_data;
  		
//		$a[$i]["isadd_history"]=$isadd_history;
//		$a[$i]["datare_history"]=$datare_history;
  		//坐标

  		$coordinate[$i]=explode(",",$a[$i]["sh_jd"]);
		$coordinate_phone=explode(",",$_GET["coordinate"]);

		$a[$i]["distance"]=$this->getDistance($lat1=$coordinate[$i][0], $lng1=$coordinate[$i][1], $lat2=$coordinate_phone[0], $lng2=$coordinate_phone[1]);

		$arr_pay[$i]=explode(",",$a[$i]["payment_method_id"]);	
		//支付方式显示 str_pay_name
		for($k=0;$k<count($arr_pay[$i]);$k++){
			$arr_pay_name[$i][$k]=M("payment_method_dsh")->field('id,title')->where("id='".$arr_pay[$i][$k]."'")->find();
			if($arr_pay_name[$i][$k]["id"]==$_GET["payment_method_id"]){
				$a[$i]["search_pay"]=$arr_pay_name[$i][$k]["title"];
			}
		}
		for($r=0;$r<count($arr_pay_name[$i]);$r++){
			$str_pay_name[$i].=$arr_pay_name[$i][$r]["title"].",";
		}

		$str_pay_name[$i] = substr($str_pay_name[$i],0,strlen($str_pay_name[$i])-1); //去掉最后一个逗号

		$a[$i]["str_pay_name"]=$str_pay_name[$i];
		
		$a[$i]["arr_pay_name"]=explode(",",$a[$i]["str_pay_name"]);
		

  	}
 	//查出传递过来的支付方式，高亮显示

 	
  	$this->ajaxReturn($a);
  }
//子商户列表
function dsh_list(){
		$field='
			id,sh_video,sh_image,sort,sh_name,sh_jd,logo,main_project,sh_jd,detail_address,main_project,payment_method_id
		';

		$sh_info=M("user_info_dsh")
		->field($field)
		->where("state=3 and   program_id='".$_GET["program_id"]."'")
		->order("time_add desc")
		->select();
		
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
		
		$dos = array_map(create_function('$n', 'return $n["distance"];'), $sh_info);

		array_multisort($dos,SORT_ASC,$sh_info);
		
		$this->ajaxReturn($sh_info);
}
  function dsh_search_0504(){
  	 // state 1:行业分类   2:支付方式  3:区域搜索  4：是否有额度    5:名称模糊搜索 6:城市搜索   
  	if(empty($_GET["program_id"]) ){ $this->ajaxReturn(array("state" => -999, "msg" => "参数缺失")); }
		
	$user_info_dsh=M("user_info_dsh");
	$sql  =" SELECT id,detail_address,logo,sh_name,sh_jd,payment_method_id FROM user_info_dsh ";
	$sql .=" WHERE program_id ='".$_GET["program_id"]."'";
		$sql .=" and state =3";
	if($_GET["state"]!=5){
		if($_GET["state"]==1){
	  		$getdate	=$_GET["fl_id"];
	  		$realydate	=$_GET["fl_date"];
	  		
	  	}else if($_GET["state"]==2){
  			$getdate	=$_GET["payment_method_id"];
  			$realydate	=$_GET["pay_date"];
	  	}else if($_GET["state"]==3){
//	0426 是省市区    0507 只有区  改变省重置搜索条件
//  $getdate=implode("-",json_decode($_GET["merch_area_arr"])); str_history_data			
//	0426 是省市区    0507 只有区  改变省重置搜索条件 
  			$getdate	=$_GET["merch_area_arr"];
  			$realydate	=$_GET["merch_area_arr"];
	  	}else if($_GET["state"]==4){
  			$getdate=1;
  			$realydate="有";
	  	}
	 	$h_state_arr		=explode(",",$_GET["history_state"]);		//历史搜索键值
  		$h_data_arr			=explode(",",$_GET["history_data"]);		//历史搜索值
  		$h_rearlydata_arr	=explode(",",$_GET["history_rearlydata"]);	//历史真搜索值
  		 		
		foreach($h_state_arr as $k0=>$v0){
		if($h_state_arr[$k0]==1 & $_GET["state"]!=1){	$sql .=" and fl_id ='".$h_data_arr[$k0]."'"; }
		if($h_state_arr[$k0]==2 & $_GET["state"]!=2){ 
			$h_data_arr2[$k0]="%".$h_data_arr[$k0]."%";
			$sql .=" and payment_method_id like'".$h_data_arr2[$k0]."'";
			}
		if($h_state_arr[$k0]==3 & $_GET["state"]!=3){ 
  				//0426 是省市区    0507 只有区  改变省重置搜索条件
//				$merch_area_arr_t[$k0]=explode("-",$h_data_arr[$k0]);
//				if($merch_area_arr_t[$k0][2]!="全部"){
//					$merch_area_arr_t[$k0][2]="%".$merch_area_arr_t[$k0][2]."%";
//					$sql .=" and district like'".$merch_area_arr_t[$k0][2]."'";
//		  		}
//		  		 if($merch_area_arr_t[$k0][1]!="全部"){
//		  		 	$merch_area_arr_t[$k0][1]="%".$merch_area_arr_t[$k0][1]."%";
//		  		 	$sql .=" and city like'".$merch_area_arr_t[$k0][1]."'";
//		  		}
//		  		 if($merch_area_arr_t[$k0][0]!="全部"){
//		  			$merch_area_arr_t[$k0][0]="%".$merch_area_arr_t[$k0][0]."%";
//		  			$sql .=" and province like'".$merch_area_arr_t[$k0][0]."'";
//		  		}
				//0426 是省市区    0507 只有区  改变省重置搜索条件
				$h_data_arr2[$k0]="%".$h_data_arr[$k0]."%";
				$sql .=" and district like'".$h_data_arr2[$k0]."'";
  		}
  			if($h_state_arr[$k0]==4 & $_GET["state"]!=4){$sql .=" and is_lines ='".$h_data_arr[$k0]."'"; }
  		}
  		if($_GET["state"]==1){	$sql .=" and fl_id ='".$_GET["fl_id"]."'"; }//行业分类	
		if($_GET["state"]==2){
		//支付方式	
			$_GET["payment_method_id"]="%".$_GET["payment_method_id"]."%";
  			$sql .=" and payment_method_id like '".$_GET["payment_method_id"]."'";
	  				
	  	}
	  	if($_GET["state"]==3){
	 	//区域选择.
	 	//0426 是省市区    0507 只有区  改变省重置搜索条件
//		$merch_area_arr=json_decode($_GET["merch_area_arr"]);
//		if($merch_area_arr[2]!="全部"){
//			$merch_area_arr[2]="%".$merch_area_arr[2]."%";
//			$sql .=" and district like'".$merch_area_arr[2]."'";
//		}	 	
//		 if($merch_area_arr[1]!="全部"){
//		 	$merch_area_arr[1]="%".$merch_area_arr[1]."%";
//		 	$sql .=" and city like'".$merch_area_arr[1]."'";
//		}
//		 if($merch_area_arr[0]!="全部"){
//			$merch_area_arr[0]="%".$merch_area_arr[0]."%";
//			$sql .=" and province like'".$merch_area_arr[0]."'";
//		}
//0426 是省市区    0507 只有区  改变省重置搜索条件
		$merch_area_arr="%".$_GET["merch_area_arr"]."%";
		$sql .=" and district like'".$_GET["merch_area_arr"]."'";
	  	}//区域搜索
	  	if($_GET["state"]==4){$sql .=" and is_lines ='"."1"."'"; }//是否有额度	
	}else{
		//名称模糊搜索
		$_GET['str']="%".$_GET['str']."%";
		$sql .=" and (sh_name like'".$_GET['str']."'";	
		$sql .=" or detail_address like'".$_GET['str']."'".")";	
	}

	$user_info_dsh=M("user_info_dsh");
    $a = $user_info_dsh -> query($sql);


 	if($h_state_arr[0]=='undefined' | empty($h_state_arr[0])){
 		$str_history_state			=$_GET["state"];
 		$str_history_data			=$getdate;
 		$str_history_realydate		=$realydate;
  	}else{
  		if(in_array($_GET["state"],$h_state_arr)){		
  			$str_history_state	=implode(",",$h_state_arr);
  			foreach($h_state_arr as $k=>$v){
  				if($h_state_arr[$k]==$_GET["state"]){
  					$h_data_arr[$k]			=$getdate;
  					$h_rearlydata_arr[$k]	=$realydate;	
  				}
  			}
  			$str_history_data		=implode(",",$h_data_arr);
  			$str_history_realydate	=implode(",",$h_rearlydata_arr);
  		}else{	
  			$str_history_state		=implode(",",$h_state_arr).",".$_GET["state"];
  			$str_history_data		=implode(",",$h_data_arr).",".$getdate;
  			$str_history_realydate	=implode(",",$h_rearlydata_arr).",".$realydate;
  		}
  	}
  	$his_arr_1=explode(",",$str_history_state);
  	$his_arr_2=explode(",",$str_history_data);
  	for($i=0;$i<count($a);$i++){
  		$a[$i]["str_history_state"]=$str_history_state;
  		$a[$i]["str_history_data"]=$str_history_data;
  		$a[$i]["arr_history"]=$str_history_realydate;
  		//坐标
  		$coordinate[$i]=explode(",",$a[$i]["sh_jd"]);
		$coordinate_phone=explode(",",$_GET["coordinate"]);

		$a[$i]["distance"]=$this->getDistance($lat1=$coordinate[$i][0], $lng1=$coordinate[$i][1], $lat2=$coordinate_phone[0], $lng2=$coordinate_phone[1]);
		$arr_pay[$i]=explode(",",$a[$i]["payment_method_id"]);	
		//支付方式显示 str_pay_name
		for($k=0;$k<count($arr_pay[$i]);$k++){
			$arr_pay_name[$i][$k]=M("payment_method_dsh")->field('id,title')->where("id='".$arr_pay[$i][$k]."'")->find();
			if($arr_pay_name[$i][$k]["id"]==explode("%",$_GET["payment_method_id"])[1]){
				$a[$i]["search_pay"]=$arr_pay_name[$i][$k]["title"];
			}
		}
		for($r=0;$r<count($arr_pay_name[$i]);$r++){
			$str_pay_name[$i].=$arr_pay_name[$i][$r]["title"].",";
		}
		$str_pay_name[$i] = substr($str_pay_name[$i],0,strlen($str_pay_name[$i])-1); //去掉最后一个逗号
		$a[$i]["str_pay_name"]=$str_pay_name[$i];		
		$a[$i]["arr_pay_name"]=explode(",",$a[$i]["str_pay_name"]);		
  	}
 	//查出传递过来的支付方式，高亮显示
	$dos = array_map(create_function('$n', 'return $n["distance"];'), $a);
	array_multisort($dos,SORT_ASC,$a);
  	$this->ajaxReturn($a);
  }
  function dsh_search_onlycity(){
  	 // 只有城市搜索
  	if(empty($_GET["program_id"]) ){ $this->ajaxReturn(array("state" => -999, "msg" => "参数缺失")); }
		
	$user_info_dsh=M("user_info_dsh");
	$sql  =" SELECT id,detail_address,logo,sh_name,sh_jd,payment_method_id FROM user_info_dsh ";
	$sql .=" WHERE program_id ='".$_GET["program_id"]."'";
	$sql .=" and state =3";

	//城市模糊搜索
	$_GET['now_city']="%".$_GET['now_city']."%";
	$sql .=" and (city like'".$_GET['now_city']."'".")";		



	$user_info_dsh=M("user_info_dsh");
    $a = $user_info_dsh -> query($sql);
//dump($sql);dump($a);die;
  	for($i=0;$i<count($a);$i++){
  		//坐标
  		$coordinate[$i]		=explode(",",$a[$i]["sh_jd"]);
		$coordinate_phone	=explode(",",$_GET["coordinate"]);

		$a[$i]["distance"]=$this->getDistance($lat1=$coordinate[$i][0], $lng1=$coordinate[$i][1], $lat2=$coordinate_phone[0], $lng2=$coordinate_phone[1]);
		$arr_pay[$i]=explode(",",$a[$i]["payment_method_id"]);	
		//支付方式显示 
		for($k=0;$k<count($arr_pay[$i]);$k++){
			$arr_pay_name[$i][$k]=M("payment_method_dsh")->field('id,title')->where("id='".$arr_pay[$i][$k]."'")->find();
			if($arr_pay_name[$i][$k]["id"]==explode("%",$_GET["payment_method_id"])[1]){
				$a[$i]["search_pay"]=$arr_pay_name[$i][$k]["title"];
			}
		}
		for($r=0;$r<count($arr_pay_name[$i]);$r++){
			$str_pay_name[$i].=$arr_pay_name[$i][$r]["title"].",";
		}
		$str_pay_name[$i] = substr($str_pay_name[$i],0,strlen($str_pay_name[$i])-1); //去掉最后一个逗号
		$a[$i]["str_pay_name"]=$str_pay_name[$i];		
		$a[$i]["arr_pay_name"]=explode(",",$a[$i]["str_pay_name"]);		
  	}
 	//查出传递过来的支付方式，高亮显示
	$dos = array_map(create_function('$n', 'return $n["distance"];'), $a);
	array_multisort($dos,SORT_ASC,$a);
  	$this->ajaxReturn($a);
  }
  	function test_distance(){
		$a=$this->getDistance("22.609251", "114.183968", "22.55329", "113.88308");
		dump($a);
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
  function dsh_search_text(){
  	
  	$where['_string']='
					(detail_address like "%'.$_GET['merch_area_text_2'].'%")  
					and (detail_address like "%'.$_GET['merch_area_text_3'].'%")  
			';	
  	
  	$where["program_id"]=$_GET["program_id"];
  	$a=M("user_info_dsh")->where($where)->select();
 
  	for($i=0;$i<count($a);$i++){
  		
  		$coordinate[$i]=explode(",",$a[$i]["sh_jd"]);
		$coordinate_phone=explode(",",$_GET["coordinate"]);
		
		$user = A('Index');
		$a[$i]["distance"]=$user->getDistance($lat1=$coordinate[$i][0], $lng1=$coordinate[$i][1], $lat2=$coordinate_phone[0], $lng2=$coordinate_phone[1]);
		
  	}
  	
  	$this->ajaxReturn($a);
  }
}
?>