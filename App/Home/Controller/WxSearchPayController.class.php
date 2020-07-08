<?php
namespace Home\Controller;
use Think\Controller;
class WxSearchPayController extends Controller{

	protected \$SSLCERT_PATH = '\certificate\JT201712251106263726\apiclient_cert.pem';//证书路径
  protected \$SSLKEY_PATH = '\certificate\JT201712251106263726\apiclient_key.pem';//证书路径
  protected \$opUserId = '1489419902';//商户号
function __construct($openid,$outTradeNo,$totalFee,$outRefundNo,$refundFee){
  //初始化退款类需要的变量
  $this->openid = $openid;//个人标识
  $this->transactionid=$outTradeNo;			//微信生成的订单号，在支付通知中有返回
  $this->outTradeNo = $outTradeNo;			//商户系统内部订单号
  $this->totalFee = $totalFee;					//订单总金额，单位为分，只能为整
  $this->outRefundNo = $outRefundNo;		//商户退款单号
  $this->refundFee = $refundFee;				//退款金额
  $this->createNoncestr() = md5(time());	//随机字符串
}
public function refund(){
  //对外暴露的退款接口
  $result = $this->wxrefundapi();
  return $result;
}
private function wxrefundapi(){
  //通过微信api进行退款流程
  $parma = array(
    'appid'=> $this->APPID,
    'mch_id'=> $this->MCHID,
    'nonce_str'=> $this->createNoncestr(),
    'out_refund_no'=> $this->outRefundNo,
    'out_trade_no'=> $this->outTradeNo,
    'transaction_id'=> $this->transactionid,
    'total_fee'=> $this->totalFee,
    'refund_fee'=> $this->refundFee,
    'op_user_id' => $this->opUserId,
  );
  $parma['sign'] = $this->getSign($parma);
  $xmldata = $this->arrayToXml($parma);
  $xmlresult = $this->postXmlSSLCurl($xmldata,'https://api.mch.weixin.qq.com/secapi/pay/refund');
  $result = $this->xmlToArray($xmlresult);
  return $result;
}


 function arrayToXml($data, $eIsArray=FALSE) {  
        if(!$eIsArray) {  
            $this->xml->openMemory();  
            $this->xml->startDocument($this->version, $this->encoding);  
            $this->xml->startElement($this->root);  
        }  
        foreach($data as $key => $value){  
            if(is_array($value)){  
                $this->xml->startElement($key);  
                $this->toXml($value, TRUE);  
                $this->xml->endElement();  
                continue;  
            }  
            $this->xml->writeElement($key, $value);  
        }  
        if(!$eIsArray) {  
            $this->xml->endElement();  
            return $this->xml->outputMemory(true);  
        }  
    } 
	//签名  就差随手礼
	function getSign($a){
		  $ref= strtoupper(md5(
		  "appid="."wx7d0bcc5c08145b44"
		  ."&mch_id="."1489419902"
		  ."&nonce_str=123456"
		  ."&op_user_id=646131"
      ."&out_refund_no=201608142308"
      ."&out_trade_no=860524080535541654"
      ."&refund_fee=1&total_fee=3"
      ."&key=suiji123"
      ));//sign加密MD5
	}

 /**
     * 生成签名, $KEY就是支付key   @return 签名
     */
    public function MakeSign( $params,$KEY){
       
        ksort($params); 												//签名步骤一：按字典序排序数组参数
        $string = $this->ToUrlParams($params);  //参数进行拼接key=value&k=v
        $string = $string . "&key=".$KEY;  			//签名步骤二：在string后加入KEY 
        $string = md5($string); 								//签名步骤三：MD5加密
        $result = strtoupper($string);					//签名步骤四：所有字符转为大写
        return $result;
    }
    /**
     * 将参数拼接为url: key=value&key=value    @param $params    @return string
     */
    public function ToUrlParams( $params ){
        $string = '';
        if( !empty($params) ){
            $array = array();
            foreach( $params as $key => $value ){
                $array[] = $key.'='.$value;
            }
            $string = implode("&",$array);
        }
        return $string;
    }

//需要使用证书的请求
function postXmlSSLCurl($xml,$url,$second=30){
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
  curl_setopt($ch,CURLOPT_SSLCERT, $this->SSLCERT_PATH);
  //默认格式为PEM，可以注释
  curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
  curl_setopt($ch,CURLOPT_SSLKEY, $this->SSLKEY_PATH);
  //post提交方式
  curl_setopt($ch,CURLOPT_POST, true);
  curl_setopt($ch,CURLOPT_POSTFIELDS,$xml);
  $data = curl_exec($ch);
  //返回结果
  if($data){
    curl_close($ch);
    return $data;
  }else {
    $error = curl_errno($ch);
    echo "curl出错，错误码:$error"."<br>";
    curl_close($ch);
    return false;
  }
}

}
?>