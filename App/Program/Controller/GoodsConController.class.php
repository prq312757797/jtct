<?php
namespace Program\Controller;
use Think\Controller;
header('content-type:application:json;charset=utf8'); 
header('Access-Control-Allow-Origin:*'); 
//header('Access-Control-Allow-Methods:POST'); 
header('Access-Control-Allow-Headers:x-requested-with,content-type');


class 	GoodsConController extends Controller {
	
	//手机端商品收藏ajax
	public function collection01(){
		//post 商品id 、用户个人标识  
		if(empty($_POST["openid"])){
			$data=array("status"=>9,"msg"=>"非授权用户请先授权再进行本操作");
		}else{
			
			//判断小程序类型、商城版的是 goods_id   资讯版的是 zx_info_id
			$qianyue=M("qianyue")->where("program_id='".$_POST["program_id"]."'")->find();
			if($qianyue["muban_type"]==1){
				//商城版的+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
					$where=array(
						'cus_openid'=>$_POST["openid"],
						'program_id'=>$_POST["program_id"],
						'goods_id'=>$_POST["goods_id"],
					);
				}else if($qianyue["muban_type"]==5){
			//资讯版的+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
					$where=array(
						'cus_openid'=>$_POST["openid"],
						'program_id'=>$_POST["program_id"],
						'zx_info_id'=>$_POST["zx_info_id"],
					);
				}
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
					if(!empty($_POST["goods_id"])){
						$where=array(
							'cus_openid'=>$_POST["openid"],
							'program_id'=>$_POST["program_id"],
							'goods_id'=>$_POST["goods_id"],
						);
					}
					if(!empty($_POST["zx_info_id"])){
						$where=array(
						'cus_openid'=>$_POST["openid"],
						'program_id'=>$_POST["program_id"],
						'zx_info_id'=>$_POST["zx_info_id"],
						
						);
					}
				
				}
			$shavd=M("collection")->where($where)->find();
				if(empty($shavd)){
				//未被收藏----》执行添加操作
				
				if($qianyue["muban_type"]==1){
				//商城版的+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
					$where01=array(
						'cus_openid'=>$_POST["openid"],
						'program_id'=>$_POST["program_id"],
						'goods_id'=>$_POST["goods_id"],
						'time_collection'=>time()
					);
				}else if($qianyue["muban_type"]==5){
				//资讯版的+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
					$where01=array(
						'cus_openid'=>$_POST["openid"],
						'program_id'=>$_POST["program_id"],
						'zx_info_id'=>$_POST["zx_info_id"],
						'time_collection'=>time()
					);
				
				}
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
				
					if(!empty($_POST["goods_id"])){
						$where01=array(
							'cus_openid'=>$_POST["openid"],
							'program_id'=>$_POST["program_id"],
							'goods_id'=>$_POST["goods_id"],
						);
					}
					if(!empty($_POST["zx_info_id"])){
						$where01=array(
						'cus_openid'=>$_POST["openid"],
						'program_id'=>$_POST["program_id"],
						'zx_info_id'=>$_POST["zx_info_id"],
						'time_collection'=>time()
						);
					}
					
				 }
				
				
				if(M("collection")->add($where01)){
					$data=array("status"=>1,"msg"=>"收藏成功");
				}else{
					$data=array("status"=>2,"msg"=>"收藏失败");
				}
			}else{
				//已经被收藏 ---》执行取消收藏操作  俗称删数据
				if(M("collection")->where($where)->delete()){
					$data=array("status"=>3,"msg"=>"取消收藏成功");
				}else{
					$data=array("status"=>4,"msg"=>"取消收藏失败");
				}
			}
		}
		
	
	  $this->ajaxReturn($data);			
	}
	
	
	
	// 密码酒  活动专区商品  可兑换商品列表
	function goods_activity(){
		
		$a=M("goods")->where("goods_state=1 and  is_use_consumption_num=1 and program_id='".$_GET["program_id"]."'")->select();
	//dump(M("goods")->_sql());die;.$_GET
		for($i=0;$i<count($a);$i++){
			$arr1102=explode(",",$a[$i]['image']);
			$a[$i]["image_first"]=$arr1102[0];
		}
		$this->ajaxReturn($a);	
	}
}

?>