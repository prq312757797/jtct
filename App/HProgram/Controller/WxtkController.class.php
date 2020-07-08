<?php
namespace HProgram\Controller;
use Think\Controller;
class WxtkController extends Controller{

/*  protected $SSLCERT_PATH = './certificate/JT201712251106263726/apiclient_cert.pem';//证书路径
  protected $SSLKEY_PATH = './certificate/JT201712251106263726/apiclient_key.pem';//证书路径
  protected $opUserId = '1489419902';//商户号
  protected $KEY = '2AF63EDD6BE95F86798D5629FBFC3AD5';//商户号*/


  /*
   * 生成随机字符串方法
   */
  protected function createNoncestr($length = 32 ){
     $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
     $str ="";
     for ( $i = 0; $i < $length; $i++ ) {
     $str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);
     }
     return $str;
     }

public function refund_111(){

  //对外暴露的退款接口
  $a=M("user_info")->where("program_id='".$_POST["program_id"]."'")->find();

  if($_POST["program_id"]=="JT201712251106263726"){
  	//宜拖车
 
  	 if($_POST["is_jifen"]=="1"){
   	   	  $b=M("jt03_zx_record_cz")->where("program_id='".$_POST["program_id"]."'"."and order_num='".$_POST["order_num"]."'")->find();
   	  }else{
   	  	 	$b=M("car_order")->where("program_id='".$_POST["program_id"]."'"."and order_num='".$_POST["order_num"]."'")->find();
   	   	
			}
  }else if($_POST["program_id"]=="JT201808090855119076"){
  	//能量KTV系统   房台套餐  tk_state:fangtai   jiushui   tuangou
 
  	  $b=M("room_orderbooking")->where("program_id='".$_POST["program_id"]."'"."and order_num='".$_POST["order_num"]."'")->find();
  }else{
 	      $b=M("order_form")->where("program_id='".$_POST["program_id"]."'"."and order_num='".$_POST["order_num"]."'")->find();
  }



  $KEY = $a["pay_key"];
  $SSLCERT_PATH = 'D:/phpStudy/WWW/jtct/certificate/'.$_POST["program_id"].'/apiclient_cert.pem';//证书路径
  $SSLKEY_PATH = 'D:/phpStudy/WWW/jtct/certificate/'.$_POST["program_id"].'/apiclient_key.pem';//证书路径
//./certificate
   $appid					=$a["appid"];							//appid 
// $appid					="wx7d0bcc5c08145b44";		
   $mch_id				=$a["shanghu_num"];				//商户号
// $mch_id				="1489419902";				
   $nonce_str			=md5(time());							//随机字符
   $out_refund_no	="JTtk".date("YmdHis",time()).rand(111111,999999); //退款单号
   $out_trade_no	=$_POST["order_num"];			//商户订单号
// $out_trade_no	="JT20180117094847732231";

//buy_state     1:商品购买 、2：积分购买
if($_POST["buy_state"]==1){
	if($_POST["program_id"]=="JT201712251106263726"){
   	   	 $total_fee=$b["price"]*100;				//订单交易额 
   }else if($_POST["program_id"]=="JT201808090855119076"){
   	   	 $total_fee=$b["real_price"]*100;				//订单交易额 
   }else{
   	   $total_fee=$b["real_price"]*100;				//订单交易额
   }
}else if($_POST["buy_state"]==2){
	$inter=M("jt03_zx_record_cz")->where("program_id='".$_POST["program_id"]."'"."and order_num='".$_POST["order_num"]."'")->find();
	$total_fee=$inter["price"]*100;
}
   
   
// $total_fee		="3";					
   $refund_fee	=$_POST["refund_fee"]*100;	//退款金额
// $refund_fee	="1";												//退款金额
   $op_user_id	=$a["shanghu_num"];					//操作人

 	 $result = $this->wxrefundapi_111($appid,$mch_id,$nonce_str,$out_refund_no,$out_trade_no,$total_fee,$refund_fee,$op_user_id,$KEY,$SSLCERT_PATH,$SSLKEY_PATH);


		$arr=array(
			"appid"								=>$appid,
			"mch_id商户号"					=>$mch_id,
			"once_str随机字符"				=>$nonce_str,
			"out_refund_no退款单号"	=>$out_refund_no,
			"out_trade_no商户订单号"	=>$out_trade_no,
			"total_fee总金额"				=>$total_fee,
			"refund_fee退款金额"			=>$refund_fee,
			"op_user_id操作人"			=>$op_user_id,
			"key支付秘钥"						=>$KEY,
			"SSLCERT_PATH"				=>$SSLCERT_PATH,
			"SSLKEY_PATH"					=>$SSLKEY_PATH
		);
		//dump($_POST);dump($arr);dump($result);die;
		//$result["result_code"]// FAIL/SUCCESS
		//$result["err_code_des"]//订单已全额退款  订单金额或退款金额与之前请求不一致，请核实后再试
		//return_msg   退款提示 
		//out_refund_no  退款订单号 
		//dump($result);die;


  if($result["result_code"]=="SUCCESS"){
  		
	  
	  if($_POST["program_id"]=="JT201712251106263726"){
	  	//宜拖车
   	  $save["state_tuikuan"]	=1;
  		$save["time_tuikuan"]		=time();
  		M("car_order")->where("program_id='".$_POST["program_id"]."'"."and order_num='".$_POST["order_num"]."'")->save($save);
		  M("car_order")->where("program_id='".$_POST["program_id"]."'"."and order_num='".$_POST["order_num"]."'")->setInc('pirce_tuikuan', $_POST["refund_fee"]);
		
			$add["program_id"]=$_POST["program_id"];
			$add["order_num"]=$_POST["order_num"];
			$add["price_tk"]=$_POST["refund_fee"];
			$add["out_refund_no"]=$out_refund_no;
			$add["time_tk"]=time();
			$add["state"]=1;
			
  		M("car_order_tuikuan")->add($add);
			$data=1;
   }else if($_POST["program_id"]=="JT201808090855119076"){
	  	//能量ktv   房台套餐
   	  $save["state_tk"]	=2;
   	  $save["state"]	=4;
  		$save["time_tk_done"]		=time();
//		$a=M("room_orderbooking")->where("program_id='".$_POST["program_id"]."'"."and order_num='".$_POST["order_num"]."'")->find();
//		dump($_POST);dump(M("room_orderbooking")->_sql());die;
  		M("room_orderbooking")->where("program_id='".$_POST["program_id"]."'"."and order_num='".$_POST["order_num"]."'")->save($save);
		  M("room_orderbooking")->where("program_id='".$_POST["program_id"]."'"."and order_num='".$_POST["order_num"]."'")->setInc('price_tk', $_POST["refund_fee"]);
		
			$add["program_id"]=$_POST["program_id"];
			$add["order_num"]=$_POST["order_num"];
			$add["price_tk"]=$_POST["refund_fee"];
			$add["out_refund_no"]=$out_refund_no;
			$add["time_tk"]=time();
			$add["state"]=1;
			
  		M("order_tuikuan")->add($add);
			$data=1;
   }else{
   		$save["state_tuikuan"]	=1;
			$save["state"]					=6;
  		$save["time_tk_dk"]			=time();
  		M("order_form")->where("program_id='".$_POST["program_id"]."'"."and order_num='".$_POST["order_num"]."'")->save($save);
		  M("order_form")->where("program_id='".$_POST["program_id"]."'"."and order_num='".$_POST["order_num"]."'")->setInc('pirce_tuikuan', $_POST["refund_fee"]);
   	
   	  $add["program_id"]=$_POST["program_id"];
			$add["order_num"]=$_POST["order_num"];
			$add["price_tk"]=$_POST["refund_fee"];
			$add["out_refund_no"]=$out_refund_no;
			$add["time_tk"]=time();
			$add["state"]=1;
			
  		M("order_tuikuan")->add($add);
  		$data=1;
   }
  		
  		
  }else if($result["result_code"]=="FAIL"){
  		$data=2;
  }
  $this->ajaxReturn($data);
  //return $result;
}

private function wxrefundapi_111($appid,$mch_id,$nonce_str,$out_refund_no,$out_trade_no,$total_fee,$refund_fee,$op_user_id,$KEY,$SSLCERT_PATH,$SSLKEY_PATH){
  //通过微信api进行退款流程

  $parma = array(
    'appid'=> $appid,
    'mch_id'=> $mch_id,
    'nonce_str'=> $nonce_str,
    'out_refund_no'=> $out_refund_no,
   'out_trade_no'=>$out_trade_no,
    'total_fee'=> $total_fee,
    'refund_fee'=> $refund_fee,
    'op_user_id' => $op_user_id,
  );
  $parma['sign'] = $this->getSign($parma,$KEY);
 
  $xmldata = $this->arrayToXml($parma);
  
  $xmlresult = $this->postXmlSSLCurl($xmldata,'https://api.mch.weixin.qq.com/secapi/pay/refund',$SSLCERT_PATH,$SSLKEY_PATH);
  $result = $this->xmlToArray($xmlresult);
 
  return $result;
}

//需要使用证书的请求
function postXmlSSLCurl($xml,$url,$SSLCERT_PATH,$SSLKEY_PATH,$second=30)
{
  $ch = curl_init();
  //超时时间
  curl_setopt($ch,CURLOPT_TIMEOUT,$second);
  //这里设置代理，如果有的话
  //curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
  //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
  curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
  //设置header
  curl_setopt($ch,CURLOPT_HEADER,FALSE);
  //要求结果为字符串且输出到屏幕上
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
  //设置证书
  //使用证书：cert 与 key 分别属于两个.pem文件
  //默认格式为PEM，可以注释
  curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
  curl_setopt($ch,CURLOPT_SSLCERT, $SSLCERT_PATH);
  //默认格式为PEM，可以注释
  curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
  curl_setopt($ch,CURLOPT_SSLKEY, $SSLKEY_PATH);
  //post提交方式
  curl_setopt($ch,CURLOPT_POST, true);
  curl_setopt($ch,CURLOPT_POSTFIELDS,$xml);
  $data = curl_exec($ch);

  //返回结果
  if($data){
    curl_close($ch);
    
    return $data;
  }
  else {
    $error = curl_errno($ch);
    echo "curl出错，错误码:$error"."<br>";
    curl_close($ch);
    return false;
  }
}

/*
   * 对要发送到微信统一下单接口的数据进行签名
   */
  protected function getSign($Obj,$KEY){
     foreach ($Obj as $k => $v){
     $Parameters[$k] = $v;
     }
     //签名步骤一：按字典序排序参数
     ksort($Parameters);
     $String = $this->formatBizQueryParaMap($Parameters, false);
    // dump($String);
     //签名步骤二：在string后加入KEY
     $String = $String."&key=".$KEY;
    //  dump($String);
     //签名步骤三：MD5加密
     $String = md5($String);
     //签名步骤四：所有字符转为大写
     $result_ = strtoupper($String);
     
     
     return $result_;
   }
   
     //数组转字符串方法
  protected function arrayToXml($arr){
    $xml = "<xml>";
    foreach ($arr as $key=>$val)
    {
      if (is_numeric($val)){
        $xml.="<".$key.">".$val."</".$key.">";
      }else{
         $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
      }
    }
    $xml.="</xml>";
    return $xml;
  }


 protected function xmlToArray($xml){
    $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    return $array_data;
  }
  
  /*
   *排序并格式化参数方法，签名时需要使用
   */
  protected function formatBizQueryParaMap($paraMap, $urlencode)
  {
    $buff = "";
    ksort($paraMap);
    foreach ($paraMap as $k => $v)
    {
      if($urlencode)
      {
        $v = urlencode($v);
      }
      //$buff .= strtolower($k) . "=" . $v . "&";
      $buff .= $k . "=" . $v . "&";
    }
    $reqPar;
    if (strlen($buff) > 0)
    {
      $reqPar = substr($buff, 0, strlen($buff)-1);
    }
    return $reqPar;
  }
  
  
}
?>