<?php
namespace Hl\Controller;
use Think\Controller;
class GoldController extends CommonController {
    public function index(){
		$url="http://www.yhjzb9999.com/get_price1.php";

		$result=$this->http_request($url);

		$result=json_decode($result,ture);
//		dump($result);die;
		$this->list=$result["ProductPriceList"];
		$this->display();
	}
	public function ajax(){
		$url="http://www.yhjzb9999.com/get_price1.php";

		$result=$this->http_request($url);

		$result=json_decode($result,ture);
		
		$this->ajaxReturn($result["ProductPriceList"]);
	}
	public function http_request($url,$data = null,$headers=array()){
        $curl = curl_init();
        if( count($headers) >= 1 ){
        	curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:8.8.8.8', 'CLIENT-IP:123.207.42.92'));//IP 
        } 
        $ip_set="CLIENT-IP:1".rand(1,9).rand(1,9).".20".rand(1,9).".4".rand(1,9).".9".rand(1,9);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("X-FORWARDED-FOR:".rand(1,9).".".rand(1,9).".".rand(1,9).".".rand(1,9), $ip_set));//IP 
     	curl_setopt($ch, CURLOPT_REFERER, "http://www.w1".rand(1,9).rand(1,9).".net/ ");   //来路 
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