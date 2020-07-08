<?php
namespace Program\Controller;
use Think\Controller;
header('content-type:application:json;charset=utf8'); 
header('Access-Control-Allow-Origin:*'); 
//header('Access-Control-Allow-Methods:POST'); 
header('Access-Control-Allow-Headers:x-requested-with,content-type');
class QdcodeController extends Controller {
	
	//访问小程序获取二维码图片试试，听说是二进制图片

	//获取微信小程序二维码============================================================================================================
	//获取微信小程序二维码============================================================================================================
	//获取微信小程序二维码============================================================================================================
//	public function qd_code($yourAppid,$yourSecret){
	public function qd_code(){
	//$yourAppid="wx31d64bf834fd4c52";
	//$yourSecret="59be388e1ebeecd6fdbdfca4b7003294";//form_id	
	$yourAppid		=$_GET["appid"];
	$yourSecret		=$_GET["secret"];
	$aa				=$_GET["openid"];

//首次打开分销中心二维码，得到图片并存起来
	$where["openid"]		=$_GET["openid"];
	$where["program_id"]	=$_GET["program_id"];
	$members=M("members")->where($where)->find();
		
 	$save["qd_code"]="https://sz800800.cn/pg.php/Qdcode/qd_code?appid=" . $_GET["appid"] . "&secret=". $_GET["secret"] ."&openid=".$_GET["openid"]."&program_id=".$_GET["program_id"];        
 	M("members")->where($where)->save($save);
 
	$arr = array(
		'path' => '/pages/index/index?from_id='.$members["id"],
		'width' => 430,
		'scene' => 0
	);
	$path = json_encode($arr);
//$path='{"path":"/pages/index/index?from_id=11","width":430,"scene":0}';	
//$post_data='{"path":"/pages/index/index?from_id=11","width":430,"scene":0}';
	$post_data=$path;
// $url="https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=".$access_token;
	$url="https://api.weixin.qq.com/wxa/getwxacode?access_token=".$this->get_accessToken($yourAppid,$yourSecret);	  
	$result=$this->api_notice_increment($url,$post_data);

	echo $result; 
	}
	public function qd_code_null(){	
	$yourAppid=$_GET["appid"];
	$yourSecret=$_GET["secret"];


		$arr = array(
			 'path' => '/pages/index/register4/register4?go_state=2',
			 'width' => 430,
			 'scene' => 0
			);
	//	pages/index/register5/register5
	//  pages/index/register4/register4
	$path = json_encode($arr);
	 $post_data=$path;
	   $url="https://api.weixin.qq.com/wxa/getwxacode?access_token=".$this->get_accessToken($yourAppid,$yourSecret);
	   $result=$this->api_notice_increment($url,$post_data);

	   echo $result;
	 
	}

	//禾之稻   消费券二维码============================================================================================================
	//禾之稻   消费券二维码============================================================================================================
	//禾之稻   消费券二维码============================================================================================================		
	public function qd_code_vouchers(){


//	$yourAppid="wx48f9afe8d2ef41ec";
//	$yourSecret="63e43565d3d780dbcb3e809249e03178";//form_id
if(empty($_GET["program_id"])  ){
	$this->ajaxReturn(array('state'=>'-1','msg'=>'参数缺失'));
}

$qianyue=M("qianyue")->field('appid,appsecret')->where("program_id='".$_GET["program_id"]."'")->find();		
	$yourAppid=$qianyue["appid"];
	$yourSecret=$qianyue["appsecret"];


$members=M("members")->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();


if(empty($_GET["consumption_num"])){
	//无编码、生成消费码   http://127.0.0.1/jtct/pg.php/Qdcode/qd_code_vouchers?program_id=JT201711031347219168&openid=uGWXTOMbK1WlXZ8yx0As&price_id=1
	if( empty($_GET["price_id"]) | empty($_GET["openid"])){
	$this->ajaxReturn(array('state'=>'-2','msg'=>'参数缺失02'));
}
	$coupon["consumption_num"]=rand(111111111,999999999);
	$coupon["program_id"]=$_GET["program_id"];
	$coupon["openid_set"]=$_GET["openid"];
	$coupon["time_set"]=time();
	$coupon["merchants_id"]=$members["mamager_belong_id"];
	$coupon["price_id"]=$_GET["price_id"];
	$coupon["remark_set"]=$_GET["remark_set"];
	$coupon["consumption_img"]="https://sz800800.cn/pg.php/Qdcode/qd_code_vouchers?consumption_num=" . $coupon["consumption_num"]."&program_id=" .$_GET["program_id"]; 
	
	if(M("consumption_vouchers")->add($coupon)){
	//生成了一个消费编码
/*		$arr = array(
			 'path' => '/pages/index/index?consumption_num='.$coupon["consumption_num"],
			 'width' => 430,
			 'scene' => 0
			);
		
		$path = json_encode($arr);
	    $post_data=$path;
	    $url="https://api.weixin.qq.com/wxa/getwxacode?access_token=".$this->get_accessToken($yourAppid,$yourSecret);
	    $result=$this->api_notice_increment($url,$post_data);

	    echo $result;*/
	   
	$this->ajaxReturn($coupon["consumption_img"]);
	}
}else{
	//有编码，查看消费码    http://127.0.0.1/jtct/pg.php/Qdcode/qd_code_vouchers?consumption_num=664415147&program_id=JT201711031347219168
		$arr = array(
			 'path' => '/pages/index/index?consumption_num='.$_GET["consumption_num"],
			 'width' => 430,
			 'scene' => 0
			);
		
		$path = json_encode($arr);
	    $post_data=$path;
	    $url="https://api.weixin.qq.com/wxa/getwxacode?access_token=".$this->get_accessToken($yourAppid,$yourSecret);
	    $result=$this->api_notice_increment($url,$post_data);

	    echo $result;
}

	}
//	coupon 优惠券                             vouchers 抵用券
		public function qd_code_vouchers_1(){
		if(empty($_GET["program_id"])  ){
			$this->ajaxReturn(array('state'=>'-1','msg'=>'参数缺失'));
		}
		
		$qianyue=M("qianyue")->field('appid,appsecret')->where("program_id='".$_GET["program_id"]."'")->find();		
			$yourAppid=$qianyue["appid"];
			$yourSecret=$qianyue["appsecret"];
		
			$members=M("members")->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();

			if(empty($_GET["consumption_num"])){
			if( empty($_GET["price_id"]) | empty($_GET["openid"])){
				$this->ajaxReturn(array('state'=>'-2','msg'=>'参数缺失02'));
			}
				$coupon["consumption_num"]	=rand(111111111,999999999);
				$coupon["program_id"]		=$_GET["program_id"];
				$coupon["openid_set"]		=$_GET["openid"];
				$coupon["time_set"]			=time();
				$coupon["merchants_id"]		=$members["mamager_belong_id"];
				$coupon["price_id"]			=$_GET["price_id"];
				$coupon["remark_set"]		=$_GET["remark_set"];
					
				$arr = array(
				 'path' => '/pages/index/index?consumption_num='.$coupon["consumption_num"],
				 'width' => 430,
				 'scene' => 0
				);	
				
				$a=M("consumption_vouchers")->where("program_id='".$_GET["program_id"]."'"."and consumption_num='".$coupon["consumption_num"]."'")->find();
			
			$path 			= json_encode($arr);
			$post_data		=$path;
			$url			="https://api.weixin.qq.com/wxa/getwxacode?access_token=".$this->get_accessToken($yourAppid,$yourSecret);
			$result			=$this->api_notice_increment($url,$post_data);	
			    
			$imgDir 		= './qdcode/';
		    $filename 		= md5(time().mt_rand(10, 99)).".png"; //新图片名称
		    $newFilePath 	= $imgDir.$filename;
		    $data 			= $result;
		    $newFile 		= fopen($newFilePath,"w"); //打开文件准备写入
		    fwrite($newFile,$data); //写入二进制流到文件
		    fclose($newFile); //关闭文件
		
			$coupon["consumption_img"]=$filename; 
			if(empty($a)){
					if(M("consumption_vouchers")->add($coupon)){
						$this->ajaxReturn($coupon["consumption_img"]);
					}else{
						$this->ajaxReturn(array('state'=>'-3','msg'=>'写入失败'));
					}
				}else{
					$this->ajaxReturn(array('state'=>'-4','msg'=>'重复写入失败'));
				}
			
			
			}else{
				$arr = array(
				 'path' => '/pages/index/index?consumption_num='.$_GET["consumption_num"],
				 'width' => 430,
				 'scene' => 0
				);	
				
			$a=M("consumption_vouchers")->where("program_id='".$_GET["program_id"]."'"."and consumption_num='".$_GET["consumption_num"]."'")->find();
			
			$path = json_encode($arr);
			$post_data=$path;
			$url="https://api.weixin.qq.com/wxa/getwxacode?access_token=".$this->get_accessToken($yourAppid,$yourSecret);
			$result=$this->api_notice_increment($url,$post_data);	
			    
			$imgDir = './qdcode/';
		    $filename = md5(time().mt_rand(10, 99)).".png"; //新图片名称
		    $newFilePath = $imgDir.$filename;
		    $data = $result;
		    $newFile = fopen($newFilePath,"w"); //打开文件准备写入
		    fwrite($newFile,$data); //写入二进制流到文件
		    fclose($newFile); //关闭文件
		
			$coupon["consumption_img"]=$filename; 
		
		
			if(!empty($a)){
					if(M("consumption_vouchers")->where("id='".$a["id"]."'")->save($coupon)){
						$this->ajaxReturn(array("consumption_img"=>$coupon["consumption_img"],"consumption_num"=>$_GET["consumption_num"]));
					}else{
						$this->ajaxReturn(array('state'=>'-3','msg'=>'写入失败'));
					}
				}else{
					$this->ajaxReturn(array('state'=>'-4','msg'=>'重复写入失败'));
				}
			}

	}


	//多店铺二维码  一店一码============================================================================================================
	//多店铺二维码  一店一码============================================================================================================
	//多店铺二维码  一店一码============================================================================================================		
	public function qd_code_dsh(){
//传递基本参数，然后就能弄一点一码了，其实直接保存这个接口地址就行了
//	$yourAppid="wx31d64bf834fd4c52";
//	$yourSecret="59be388e1ebeecd6fdbdfca4b7003294";//form_id
	$qianyue=M("qianyue")->field('appid,appsecret')->where("program_id='".$_GET["program_id"]."'")->find();		
	$yourAppid=$qianyue["appid"];
	$yourSecret=$qianyue["appsecret"];
//多店二维码需要带多店铺的id
	$arr = array(
		 'path' => '/pages/index/index?dsh_id='.$_GET["dsh_id"],
		 'width' => 430,
		 'scene' => 0
		);
		
	$path = json_encode($arr);
//	$path='{"path":"/pages/index/index?from_id=11","width":430,"scene":0}';	
//  $post_data='{"path":"/pages/index/index?from_id=11","width":430,"scene":0}';
	$post_data=$path;
//  $url="https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=".$access_token;
    $url="https://api.weixin.qq.com/wxa/getwxacode?access_token=".$this->get_accessToken($yourAppid,$yourSecret);
    $result=$this->api_notice_increment($url,$post_data);
	echo $result;
	}
	
//一店一码  跳转到子商户主页
	public function qd_code_dsh02(){
//传递基本参数，然后就能弄一点一码了，其实直接保存这个接口地址就行了

	$qianyue=M("qianyue")->field('appid,appsecret')->where("program_id='".$_GET["program_id"]."'")->find();		
	$yourAppid=$qianyue["appid"];
	$yourSecret=$qianyue["appsecret"];
//多店二维码需要带多店铺的id
	$arr = array(
		 'path' => '/pages/shop_store/store?id='.$_GET["dsh_id"],
		 'width' => 430,
		 'scene' => 0
		);
		
	$path = json_encode($arr);

	$post_data=$path;
    $url="https://api.weixin.qq.com/wxa/getwxacode?access_token=".$this->get_accessToken($yourAppid,$yourSecret);
    $result=$this->api_notice_increment($url,$post_data);
	echo $result;
	}
	
	/**
	 * 店员收费二维码  积分支付
	 * 接收店员id，客户扫码带着店员id消费金额进入消费页面，
	 * */
	public function qd_code_dsh_charge(){
		$qianyue=M("qianyue")->field('appid,appsecret')->where("program_id='".$_GET["program_id"]."'")->find();		
		$yourAppid=$qianyue["appid"];
		$yourSecret=$qianyue["appsecret"];
		$arr = array(
			 'path' => '/pages/user/codepay/codepay_cus?order_num='.$_GET["order_num"],
			 'width' => 430,
			 'scene' => 0
			);
		$path = json_encode($arr);
		$post_data=$path;
	    $url="https://api.weixin.qq.com/wxa/getwxacode?access_token=".$this->get_accessToken($yourAppid,$yourSecret);
	    $result=$this->api_notice_increment($url,$post_data);
		echo $result;
	}
		/**
	 * 店员收费二维码  微信支付
	 * 接收店员id，客户扫码带着店员id消费金额进入消费页面，
	 * */
	public function qd_code_dsh_charge_cash(){
		$qianyue=M("qianyue")->field('appid,appsecret')->where("program_id='".$_GET["program_id"]."'")->find();		
		$yourAppid=$qianyue["appid"];
		$yourSecret=$qianyue["appsecret"];
		$arr = array(
			 'path' => '/pages/user/codepay/codepay_cus_cash?order_num='.$_GET["order_num"],
			 'width' => 430,
			 'scene' => 0
			);
		$path = json_encode($arr);
		$post_data=$path;
	    $url="https://api.weixin.qq.com/wxa/getwxacode?access_token=".$this->get_accessToken($yourAppid,$yourSecret);
	    $result=$this->api_notice_increment($url,$post_data);
		echo $result;
	}
	
/**
	 * 房台使用二维码
	 * 
	 * */
	public function room_check_code(){
		$qianyue=M("qianyue")->field('appid,appsecret')->where("program_id='".$_GET["program_id"]."'")->find();		
		$yourAppid=$qianyue["appid"];
		$yourSecret=$qianyue["appsecret"];
		
		$arr = array(
			 'path' => '/pages/user/code/qdcode_room?num_code='.$_GET["num_code"],
			 'width' => 430,
			 'scene' => 0
			);
		$path = json_encode($arr);
		$post_data=$path;
	    $url="https://api.weixin.qq.com/wxa/getwxacode?access_token=".$this->get_accessToken($yourAppid,$yourSecret);
	    $result=$this->api_notice_increment($url,$post_data);
		echo $result;
	}
	
	
	/**
	 * 在线酒水二维码
	 * */
	function onlinebeer_code(){
		
		$qianyue=M("qianyue")->field('appid,appsecret')->where("program_id='".$_GET["program_id"]."'")->find();		
		$yourAppid=$qianyue["appid"];
		$yourSecret=$qianyue["appsecret"];
		
		$arr = array(
			 'path' => '/pages/bookingroom/online_goods?room_num='.$_GET["room_num"],
			 'width' => 430,
			 'scene' => 0
			);
		$path = json_encode($arr);
		$post_data=$path;
	    $url="https://api.weixin.qq.com/wxa/getwxacode?access_token=".$this->get_accessToken($yourAppid,$yourSecret);
	    $result=$this->api_notice_increment($url,$post_data);
		echo $result;
	}
	
	/**
	 * 存酒二维码
	 * */
	function savebeer_code(){
		
		$qianyue=M("qianyue")->field('appid,appsecret')->where("program_id='".$_GET["program_id"]."'")->find();		
		$yourAppid=$qianyue["appid"];
		$yourSecret=$qianyue["appsecret"];
		
		$arr = array(
			 'path' => '/pages/bookingroom/beer_save?room_num='.$_GET["room_num"],
			 'width' => 430,
			 'scene' => 0
			);
		$path = json_encode($arr);
		$post_data=$path;
	    $url="https://api.weixin.qq.com/wxa/getwxacode?access_token=".$this->get_accessToken($yourAppid,$yourSecret);
	    $result=$this->api_notice_increment($url,$post_data);
		echo $result;
	}
/**
	 * 服务页二维码
	 * */
	function serverpage_code(){
		
		$qianyue=M("qianyue")->field('appid,appsecret')->where("program_id='".$_GET["program_id"]."'")->find();		
		$yourAppid=$qianyue["appid"];
		$yourSecret=$qianyue["appsecret"];
		
		$arr = array(
			 'path' => '/pages/bookingroom/serverpage?room_num='.$_GET["room_num"],
			 'width' => 430,
			 'scene' => 0
			);
		$path = json_encode($arr);
		$post_data=$path;
	    $url="https://api.weixin.qq.com/wxa/getwxacode?access_token=".$this->get_accessToken($yourAppid,$yourSecret);
	    $result=$this->api_notice_increment($url,$post_data);
		echo $result;
	}
	
	
//	子商户店员申请  pages/user/assistant_add  百业联盟
	public function qd_code_dsh_assistant($program_id,$dsh_id){

	$qianyue=M("qianyue")->field('appid,appsecret')->where("program_id='".$program_id."'")->find();		
	$yourAppid=$qianyue["appid"];
	$yourSecret=$qianyue["appsecret"];
	$arr = array(
		 'path'  => '/pages/user/assistant_add?shop_id='.$dsh_id,
		 'width' => 430,
		 'scene' => 0
		);	
	$path = json_encode($arr);
	$post_data=$path;
    $url="https://api.weixin.qq.com/wxa/getwxacode?access_token=".$this->get_accessToken($yourAppid,$yourSecret);
    $result=$this->api_notice_increment($url,$post_data);
    
    $a=M("user_info_dsh")->field("id")->where("program_id='".$program_id."'"."and id='".$dsh_id."'")->find();
    $imgDir 		= './qdcode/qcode_assistant/';
    $filename 		= md5(time().mt_rand(10, 99)).".png"; //新图片名称
    $newFilePath 	= $imgDir.$filename;
    $data 			= $result;
    $newFile 		= fopen($newFilePath,"w"); 	//打开文件准备写入
    fwrite($newFile,$data); 					//写入二进制流到文件
    fclose($newFile); 							//关闭文件

	$image["qcode_assistant"]=$filename;
	if(!empty($a)){
			if(M("user_info_dsh")->where("id='".$dsh_id."'")->save($image)){
				$this->ajaxReturn(array("qcode_assistant"=>$image["qcode_assistant"]));
			}else{
				$this->ajaxReturn(array('state'=>'-3','msg'=>'写入失败'));
			}
		}else{
			$this->ajaxReturn(array('state'=>'-4','msg'=>'重复写入失败'));
		}
	}
	
//	子商户店员申请  pages/user/assistant_add  能量KTV
	public function qd_code_dsh_assistantktv($program_id){

	$qianyue=M("qianyue")->field('appid,appsecret')->where("program_id='".$program_id."'")->find();		
	$yourAppid=$qianyue["appid"];
	$yourSecret=$qianyue["appsecret"];
	$arr = array(
		 'path'  => '/pages/user/assistant_add',
		 'width' => 430,
		 'scene' => 0
		);	
	$path = json_encode($arr);
	$post_data=$path;
    $url="https://api.weixin.qq.com/wxa/getwxacode?access_token=".$this->get_accessToken($yourAppid,$yourSecret);
    $result=$this->api_notice_increment($url,$post_data);
    
    $a=M("store")->field("id")->where("program_id='".$program_id."'")->find();
    $imgDir 		= './qdcode/qcode_assistant/';
    $filename 		= md5(time().mt_rand(10, 99)).".png"; //新图片名称
    $newFilePath 	= $imgDir.$filename;
    $data 			= $result;
    $newFile 		= fopen($newFilePath,"w"); 	//打开文件准备写入
    fwrite($newFile,$data); 					//写入二进制流到文件
    fclose($newFile); 							//关闭文件

	$image["qcode_assistant"]=$filename;
	if(!empty($a)){
			if(M("store")->where("program_id='".$program_id."'")->save($image)){
				$this->ajaxReturn(array("qcode_assistant"=>$image["qcode_assistant"]));
			}else{
				$this->ajaxReturn(array('state'=>'-3','msg'=>'写入失败'));
			}
		}else{
			$this->ajaxReturn(array('state'=>'-4','msg'=>'重复写入失败'));
		}
	}

	//媒婆二维码  提供媒婆openid 小程序id============================================================================================================
	//媒婆二维码  提供媒婆openid 小程序id============================================================================================================	
	//媒婆二维码  提供媒婆openid 小程序id============================================================================================================		
	public function qd_code_meipo(){

//	$yourAppid="wx31d64bf834fd4c52";
//	$yourSecret="59be388e1ebeecd6fdbdfca4b7003294";//form_id

	$qianyue=M("qianyue")->field('appid,appsecret')->where("program_id='".$_GET["program_id"]."'")->find();		
	$yourAppid=$qianyue["appid"];
	$yourSecret=$qianyue["appsecret"];

//保存媒婆二维码
		$where["openid"]=$_GET["openid"];
		$where["program_id"]=$_GET["program_id"];
	 	$save["qd_code_meipo"]="https://sz800800.cn/pg.php/Qdcode/qd_code_meipo?openid=".$_GET["openid"]."&program_id=".$_GET["program_id"];        
	 	M("members")->where($where)->save($save);
	 	
		$arr = array(
			 'path' => '/pages/login/lunh?openid_mp='.$_GET["openid"],
			 'width' => 430,
			 'scene' => 0
			);
		
		$path = json_encode($arr);
		$post_data=$path;
	    $url="https://api.weixin.qq.com/wxa/getwxacode?access_token=".$this->get_accessToken($yourAppid,$yourSecret);
	  
	   $result=$this->api_notice_increment($url,$post_data);

	   echo $result;
	 
	}
	
	function api_notice_increment($url, $data){
	    $ch = curl_init();
	    $header = "Accept-Charset: utf-8";
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
	    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $tmpInfo = curl_exec($ch);
	    //     var_dump($tmpInfo);
	    //    exit;
	    if (curl_errno($ch)) {
	      return false;
	    }else{
	      // var_dump($tmpInfo);
	      return $tmpInfo;
	    }
	  }


    /* 调用微信api，获取access_token，有效期7200s -xzz0704 */
    public function get_accessToken($yourAppid,$yourSecret){
    	
    
        /* 在有效期，直接返回access_token */
       // if(S('access_token')){
       	if(0){
            return S('access_token');
        }
        /* 不在有效期，重新发送请求，获取access_token */
        else{
          // $url = 'https://api.weixin.qq.com/cgi-bin/token?appid='.$yourAppid.'&secret='.$yourSecret.'&grant_type=client_credential';
         //	$result = $this->curl_get_https("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx31d64bf834fd4c52&secret=59be388e1ebeecd6fdbdfca4b7003294");
			$result = $this->curl_get_https("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$yourAppid."&secret=".$yourSecret);
		
           //   $result =$this->curl_get_https("https://api.weixin.qq.com/cgi-bin/token?appid='.$yourAppid.'&secret='.$yourSecret.'&grant_type=client_credential");　　　　//就是一个普通的get方式调用https接口的请求，我就不写出来了，自己找去。
            $res = json_decode($result,true);   //json字符串转数组
            
            if($res){
                S('access_token',$res['access_token'],7100);
                return S('access_token');
            }else{
                return 'api return error';
            }
        }
    }
    
    function curl_get_https($url){
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
    $tmpInfo = curl_exec($curl);     //返回api的json对象
    //关闭URL请求
    curl_close($curl);
    return $tmpInfo;    //返回json对象
}


	//领取消费码
	function get_code(){
		if(empty($_GET["openid"]) | empty($_GET["program_id"])){
			
			$data=array("status"=>-1,"msg"=>"基本信息丢失");
			
		}else{
			$save["openid"]=$_GET["openid"];
			$save["time_get"]=time();
		
			
			
			if(M("consumption_vouchers")->where("program_id='".$_GET["program_id"]."'"."and consumption_num='".$_GET["consumption_num"]."'")->save($save)){
				$data=array("status"=>1,"msg"=>"领取成功");
			}else{
				$data=array("status"=>-2,"msg"=>"领取失败");
			}

		}
		$this->ajaxReturn($data);
	}
	
	
	//判断消费码是否已被领取
	function chech_code_used(){
		if(empty($_GET["program_id"])){
			
			$data=array("state"=>-1,"msg"=>"基本信息丢失");
			
		}else{
			$a=M("consumption_vouchers")->where("program_id='".$_GET["program_id"]."'"."and consumption_num='".$_GET["consumption_num"]."'")->find();
		//	dump($a);dump(M("consumption_vouchers")->_sql());die;
			if(empty($a)){
				$data=array("state"=>-99,"msg"=>"编码错误");
			}else{
				if($a["openid"]=="0"){
					
					$data=array("state"=>1,"msg"=>"未被领取");
				}else{
							
					$data=array("state"=>-2,"msg"=>"已被领取");
				}
			}

			
			
		}
		$this->ajaxReturn($data);
	}
	
	//查看自己的消费码
	function my_consumption(){
		$a=M("consumption_vouchers")->where(" program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->select();
		
		$this->ajaxReturn($a);
	}
	
}
?>