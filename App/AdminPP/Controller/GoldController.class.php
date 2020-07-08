<?php
namespace AdminPP\Controller;
use Think\Controller;
class GoldController extends CommonController {
    public function index(){
//		$url="http://www.yhjzb9999.com/get_price1.php";
$url="http://yp9999.cn/get_price.php";
		$result=$this->http_request($url);

		$result=json_decode($result,ture);

		$this->list=$result["ProductPriceList"];
		$this->display();
	}
	
    public function self_price(){
		$this->info=M("gold_control")->select();
		$this->display();
	}	
	public function ajax_change_text(){
		if(empty($_POST["text_val"])){
			$_POST["text_val"]=0;
		}
		$save["control_price"]=$_POST["text_val"];
		
		if(M("gold_control")->where("id='".$_POST["id"]."'")->save($save)){
			$data=1;
		}else{
			$data=-1;
		}
		$this->ajaxReturn($data);
	}
	public function ajax(){
//		$url="http://www.yhjzb9999.com/get_price1.php";
$url="http://yp9999.cn/get_price.php";


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
//  收藏订单列表  买入
	function shoucang_order(){
		$where["program_id"]=$_COOKIE["program_id"];
		$where["deal_state"]=1;
		$where["order_state"]=1;
	
		$a=M("record_shoucang")->where($where)->select();
		
		for($i=0;$i<count($a);$i++){
			$b[$i]=M("members")->where("program_id='".$_COOKIE["program_id"]."'"."and openid='".$a[$i]["openid"]."'")->find();
		
			$a[$i]["head"]=$b[$i]["head"];
			$a[$i]["nickname"]=$b[$i]["nickname"];
		}
	
		$this->list=$a;
		$this->display();
	}
//  收藏订单列表  卖出
	function shoucang_order_2(){
		$where["program_id"]=$_COOKIE["program_id"];
		$where["deal_state"]=2;
	
		$a=M("record_shoucang")->where($where)->select();
			for($i=0;$i<count($a);$i++){
			$b[$i]=M("members")->where("program_id='".$_COOKIE["program_id"]."'"."and openid='".$a[$i]["openid"]."'")->find();
			
			$a[$i]["head"]=$b[$i]["head"];
			$a[$i]["nickname"]=$b[$i]["nickname"];
		}
			$this->list=$a;
		$this->display();
	}	
}