<?php
namespace Program\Controller;
use Think\Controller;
header('content-type:application:json;charset=utf8'); 
header('Access-Control-Allow-Origin:*'); 
//header('Access-Control-Allow-Methods:POST'); 
header('Access-Control-Allow-Headers:x-requested-with,content-type');
class CouponController extends Controller {
	
	//优惠券列表页
	function coupon(){
		if(empty($_POST["program_id"]) | empty($_POST["openid"])){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		$preferential=M("preferential")->where("program_id='".$_POST["program_id"]."'")->order("sort")->select();
	
		//得到优惠券列表，还要得到个人对优惠券领取情况
		for($i=0;$i<count($preferential);$i++){
			$a=M("preferential_record")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'"."and preferential_id='".$preferential["id"]."'")->find();
			$num_limit=1;//限制领取的数量
			if($a["num_have_get"]<$num_limit){
				$preferential[$i]["is_can_get"]="1";//可以再领
			}else{
				$preferential[$i]["is_can_get"]="2";//超出领取数量限制，不能领了
			}
		
		}
	
		$this->ajaxReturn($preferential);
	}
	
	
	//领取优惠券
	
	function get_coupon(){
		//$a=M("preferential")->where("program_id='".$_POST["program_id"]."'"."and id='".$_POST["id"]."'")->find();
		
		//判断领取资格
		$num_limit=1;//限制领取的数量
		
		$b=M("preferential_record")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'"."and preferential_id='".$_POST["id"]."'")->find();
		
		if($b["num_have_get"]<$num_limit ){
			
		}else{
			$this->ajaxReturn(array('state'=>1,'msg'=>"领过了，走开！"));
		}
		
		if(empty($b)){
			//1121...16.14 暂时领取的优惠券整体过期的
			$date["program_id"]=$_POST["program_id"];
			$date["preferential_id"]=$_POST["id"];
			$date["time_set"]=time();
			
			$date["openid"]=$_POST["openid"];
			$date["num"]="1";
			$date["num_have_get"]="1";//已经领取的数量
			
			if(M("preferential_record")->add($date)){
				M("preferential")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'"."and preferential_id='".$_POST["id"]."'")->setInc("num",-1); 
				$this->ajaxReturn(array('state'=>1,'msg'=>'领取成功'));
			}else{
				$this->ajaxReturn(array('state'=>-1,'msg'=>'领取失败'));
			}
		}else{
			if(M("preferential_record")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'"."and preferential_id='".$_POST["id"]."'")->setInc("num",1)){
				M("preferential_record")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'"."and preferential_id='".$_POST["id"]."'")->setInc("num_have_get",1); 
				M("preferential")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'"."and preferential_id='".$_POST["id"]."'")->setInc("num",-1); 
		
				$this->ajaxReturn(array('state'=>1.1,'msg'=>'领取成功'));
			}else{
				$this->ajaxReturn(array('state'=>-1.1,'msg'=>'领取失败'));
			}
		}

	} 
	
	//我的优惠券（立减的）
	function my_coupon(){ 
		
		$field='preferential_record.num as p_num,preferential_record.time_set,
		
		preferential.title,preferential.image,preferential.conditions,preferential.pre_price
		';
		$a=M("preferential_record")
		->field($field)
		->join('left join preferential ON preferential_record.preferential_id=preferential.id')
		->where("preferential_record.program_id='".$_GET["program_id"]."'"."and preferential_record.openid='".$_GET["openid"]."'")->select();
		
		$this->ajaxReturn($a);
	}
	
//我的优惠券（消费优惠券
	function my_coupon_xf(){ 
		
		$field='preferential_record.num as p_num,preferential_record.time_set,preferential_record.order_num,preferential_record.order_state,preferential_record.goods_id,
		preferential_record.price,
		
		preferential.id as preferential_0id,preferential.title,preferential.image,preferential.conditions,preferential.pre_price,preferential.pre_mode,preferential.use_Instructions
		';
		$a=M("preferential_record")
		->field($field)
		->join('left join preferential ON preferential_record.preferential_id=preferential.id')
		->where("preferential_record.program_id='".$_GET["program_id"]."'"."and preferential_record.openid='".$_GET["openid"]."'"."and preferential.pre_mode=2 and preferential_record.order_state !=1")
		->select();
		for($i=0;$i<count($a);$i++){
		
		$b=	M("goods")->field("goods_title,image")->where("id='".$a[$i]["goods_id"]."'")->find();
		
		$arr=explode(",",$b["image"]);
		
			$a[$i]["goods_title"]=$b["goods_title"];
			$a[$i]["goods_image"]=$arr[0];
		}

		for($i=0;$i<count($a);$i++){
			$b[$i]=M("preferential_code")->where("state=1 and order_num='".$a[$i]["order_num"]."'")->select();
		//	dump(count($b[$i]));
			if(count($b[$i])<1){
				
				$a[$i]["is_over"]="1";//没有可用的编码了
			}else{
				$a[$i]["is_over"]="2";
			}
		}

dump($a);die;
		$this->ajaxReturn($a);
	}
	
//查看 消费优惠券编码
function read_code(){
	$a=M("preferential_code")->where("program_id='".$_GET["program_id"]."'"."and order_num='".$_GET["order_num"]."'")->select();
	
	$this->ajaxReturn($a);
}


	//可购买优惠券列表
    function buy_coupon_list(){
        if(empty($_POST["program_id"]) | empty($_POST["openid"])){
            $this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
        }
        $preferential=M("preferential")->where("pre_mode=2 and program_id='".$_POST["program_id"]."'")->order("sort")->select();

        //得到优惠券列表，还要得到个人对优惠券领取情况
        for($i=0;$i<count($preferential);$i++){
            $a=M("preferential_record")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'"."and preferential_id='".$preferential["id"]."'")->find();
            
            $num_limit=$preferential["num_limit"];//限制领取的数量
            if($a["num_have_get"]<$num_limit){
                $preferential[$i]["is_can_get"]="1";//可以再领
            }else{
                $preferential[$i]["is_can_get"]="2";//超出领取数量限制，不能领了
            }

        }

        $this->ajaxReturn($preferential);
    }


//购买优惠券
    function coupon_submit(){
        //积分充值点击按钮必须先来这个借口，在积分充值记录表添加数据，然后直接跳转到微信充值接口

        $date["program_id"]=$_POST["program_id"];
        $date["preferential_id"]=$_POST["id"];
        $date["time_set"]=time();
        
       	$date["time_over"]=strtotime("+6 month",time());
    	$date["goods_id"]=$_POST["goods_id"];
        $date["order_num"]="JT".date("YmdHis",time()).rand(111111,999999);//生成订单号
        $date["order_state"]="1";//
        $date["openid"]=$_POST["openid"];
         $date["price"]=$_POST["price"];
        $date["num"]=$_POST["num"];
      //  $date["num_have_get"]=$_POST["num"];//已经领取的数量

$a=M("preferential")->where("id='".$_POST["id"]."'")->find();
	if($a["num"]<$_POST["num"]){
		  $data=array('status'=>3,'msg'=>'买多了，给你个再来的机会，原地不动');
	}
        if(M("preferential_record")->add($date)){
            $data=array('status'=>1,'msg'=>'订单创建成功，跳转到支付接口','order_num'=>$date["order_num"],'price'=>$_POST["price"]);
        }else{
            $data=array('status'=>2,'msg'=>'订单创建失败，原地不动');
        }
        $this->ajaxReturn($data);
    }
    
    function program_logo(){
    	$a=M("store")->field('program_logo')->where("program_id='".$_GET["program_id"]."'")->find();
  		 $this->ajaxReturn($a["program_logo"]);
   	 }
    
    //优惠券使用
    function coupon_use(){
    	if(empty($_POST["program_id"]) | empty($_POST["openid"])){
            $this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
        }
        $a=M("members")->where("openid='".$_POST["openid"]."'")->find();
        if($a["program_id"]!=$_POST["program_id"]){
        	$this->ajaxReturn(array("state" => -888, "msg" => "参数错误"));
        }
         if($a["is_mamager"]!=1){
        	$this->ajaxReturn(array("state" => -777, "msg" => "非管理员操作"));
        }
        
        $save["state"]="2";
        
        
         if(M("preferential_code")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'"."and coupon_code='".$_POST["coupon_code"]."'")->save($save)){
            $data=array('status'=>1,'msg'=>'使用成功');
        }else{
            $data=array('status'=>2,'msg'=>'使用失败');
        }
        $this->ajaxReturn($data);
        
    }

}
?>