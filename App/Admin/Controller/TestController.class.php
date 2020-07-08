<?php
namespace Admin\Controller;
use Think\Controller;
class TestController extends Controller {

	function index(){

		$where["title"]=123;

		M("test")->add($where);
		dump($a);dump(M("test")->_sql());
//		$hwere['id']=array('in',"16,");//预购买数组
//		$a=M("ad")->where($hwere)->select();
//		
//		dump($a);dump(M("ad")->_sql());die;
//		$b=array(
//			"0"=>array("id"=>"1","dsh_id"=>"101","price_sell"=>"10","price_sell"=>"100","buy_num"=>"10"),
//			"1"=>array("id"=>"2","dsh_id"=>"101","price_sell"=>"20","price_sell"=>"200","buy_num"=>"20"),
//			"2"=>array("id"=>"3","dsh_id"=>"102","price_sell"=>"30","price_sell"=>"300","buy_num"=>"30"),
//			"3"=>array("id"=>"4","dsh_id"=>"0","price_sell"=>"40","price_sell"=>"400","buy_num"=>"40"),
//		);
//		$arr=$this->order_dsh($b);		
//		
//		$group_order="jt".time().rand(1111,9999); //订单分组标识
//		dump($arr);die;
//		
//		$goods_price=0;//商品总价
//		foreach($arr as $k=>$v){
//			$goods_price+=$v["price_sell"]*$v["buy_num"];  
//			
//			$_POST["order_num"]="JT".date("YmdHis",time()).rand(111111,999999);
//			$_POST["group_order"]=$group_order;
//		}
	

		$this->display();
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