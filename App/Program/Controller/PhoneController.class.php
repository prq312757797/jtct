<?php
namespace Program\Controller;
use Think\Controller;
header('content-type:application:json;charset=utf8'); 
header('Access-Control-Allow-Origin:*'); 
//header('Access-Control-Allow-Methods:POST'); 
header('Access-Control-Allow-Headers:x-requested-with,content-type');
class PhoneController extends Controller {
	
	public function phone_info_2(){
	
		$params = array(
            'appid'      => $_POST['appid'],
        	'secret'  	 => $_POST['secret'],
            'js_code'    => $_POST['code'],
            'grant_type' => 'authorization_code',
		 );	
		$url = 'https://api.weixin.qq.com/sns/jscode2session';
        $xml = $this->http_request($url,$params);
		$xml=json_decode($xml);     
        $sessionKey 	= $xml->session_key;
		$appid 			= $_POST["appid"];
		$iv 			= $_POST["iv"];	
		$encryptedData	= $_POST["encryptedData"];
		$errCode = $this->decryptData_phone_info($sessionKey,$appid,$iv,$encryptedData, $data );
		if ($errCode == 0) {
		    print($data . "\n");
		} else {
		    print($errCode . "\n");
		}
	}
	
	
	public function phone_phone_info(){
		$sessionKey 	= $_POST["sessionKey"];
		$appid 			= $_POST["appid"];
		$iv 			= $_POST["iv"];	
		$encryptedData	= $_POST["encryptedData"];
		$errCode = $this->decryptData_phone_info($sessionKey,$appid,$iv,$encryptedData, $data );
		if ($errCode == 0) {
		    print($data . "\n");
		} else {
		    print($errCode . "\n");
		}
	}
	
	public function decryptData_phone_info($sessionKey,$appid,$iv,$encryptedData,&$data ){			
		if (strlen($sessionKey) != 24) {
			return ErrorCode::$IllegalAesKey;
		}
		$aesKey=base64_decode($sessionKey);
		if (strlen($iv) != 24) {
			return ErrorCode::$IllegalIv;
		}
		$aesIV=base64_decode($iv);

		$aesCipher=base64_decode($encryptedData);

		$result=openssl_decrypt( $aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);

		$dataObj=json_decode( $result );
		if( $dataObj  == NULL )
		{
			return ErrorCode::$IllegalBuffer;
		}
		if( $dataObj->watermark->appid != $appid )
		{
			return ErrorCode::$IllegalBuffer;
		}
		$data = $result;
		return ErrorCode::$OK;
	}
	public function decryptData_phone_info_bf(&$data ){
		$sessionKey 	= 'r5RRJI/u46FEE5T+mFh+qQ==';
		$appid 			= 'wxd1419bbd26505e05';	
		$iv 			= 'XpLRtOX3R8jabvWMhR+FbA==';		
		$encryptedData	="lLjm2cENNXsMk+uvVg19JxgOUhRpvxqyoNw/Nvv56NK98+rtn2frAbpaGmDdWgo93FC3bHoipNeq3JTGd3cIBQ6xQdNMlTkpuKNJyq2j222AU4yxzTaQp4pD2o4kvkByp2n/U3sK4rLGg7x6oowX9joFO2UHpuZms2HsCbkxZ9di++rzfB+3TEvc+9CUxYedb5WgLPcrWK2oyrG6N39Kig==";
		
		if (strlen($sessionKey) != 24) {
			return ErrorCode::$IllegalAesKey;
		}
		$aesKey=base64_decode($sessionKey);
		if (strlen($iv) != 24) {
			return ErrorCode::$IllegalIv;
		}
		$aesIV=base64_decode($iv);

		$aesCipher=base64_decode($encryptedData);

		$result=openssl_decrypt( $aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);

		$dataObj=json_decode( $result );
		if( $dataObj  == NULL )
		{
			return ErrorCode::$IllegalBuffer;
		}
		if( $dataObj->watermark->appid != $appid )
		{
			return ErrorCode::$IllegalBuffer;
		}
		$data = $result;
		return ErrorCode::$OK;
	}
	 public function http_request($url,$data = null,$headers=array())
    {
        $curl = curl_init();
        if( count($headers) >= 1 ){
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
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
}	
	class ErrorCode{
		public static $OK = 0;
		public static $IllegalAesKey = -41001;
		public static $IllegalIv = -41002;
		public static $IllegalBuffer = -41003;
		public static $DecodeBase64Error = -41004;
	
	}
?>