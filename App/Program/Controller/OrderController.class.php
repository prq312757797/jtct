<?php
namespace Program\Controller;
use Think\Controller;
header('content-type:application:json;charset=utf8'); 
header('Access-Control-Allow-Origin:*'); 
//header('Access-Control-Allow-Methods:POST'); 
header('Access-Control-Allow-Headers:x-requested-with,content-type');
header("Content-Type:text/html;CharSet=UTF-8");
class OrderController extends Controller {
	
	

    public function order_type(){
    	$pid=I('id');
        $start=I('start');
        $end=I('end');
        $v1=I('value1');
    	$v2=I('value2');
        $str=I('str'); 
        $page=isset($_GET['page'])?$_GET['page']:1;
        $state=I('state');
        $order=M('order');
    	$where['order.program_id']=$pid;
//  	$where['order.state']=$state;
//  	$where['goods.program_id']=$pid;
//  	$where['man_shouhuo.program_id']=$pid;
//  	$where['members.program_id']=$pid;
    	$start=strtotime(date($start));
    	$end=strtotime(date($end));
    	if(!empty($v2)&&!empty($state)){
    	    $where['_string']='('.$v2.' like "%'.$str.'%") AND (order.state like '.$state.')';	
    	}else if(!empty($v2)&&empty($state)){
    		$where['_string']='('.$v2.' like "%'.$str.'%")';	
    	}else if(empty($v2)&&!empty($state)){
    		$where['_string']='(order.state like '.$state.')';
    	}
    	if(!empty($v1)){
    		$where[$v1]=array(array('EGT',$start),array('ELT',$end));
    	}
        $field='order.id,order.order_num,order.buy_price,order.buy_num,order.payment,order.order_gold,order.shouhuo_id,
    	order.xiadan_time,order.state,goods.goods_title,goods.bianma,members.nickname,man_shouhuo.man_shouhuo,man_shouhuo.man_phone,goods_img.image,goods_img.goods_id';
    	$list=$order
    	->field($field)
    	->group('goods_img.goods_id')
    	->join('LEFT JOIN goods ON order.goods_id=goods.id')
    	->join('LEFT JOIN members ON order.cus_id=members.id')
    	->join('LEFT JOIN man_shouhuo ON order.cus_id=man_shouhuo.member_id AND order.shouhuo_id=man_shouhuo.id')
        ->join('LEFT JOIN goods_img ON order.goods_id=goods_img.goods_id')
    	->where($where)
//  	->limit(($page-1)*10,$page*10)
    	->select();
//  	$G=M('goods_img');
//    	$num=$G->field('count(id) AS num')->where(array('goods_id'=>$list[0]['goods_id']))->find();
//      print_r($num);
        $count=count($list);
        for($i=0;$i<$count;$i++){
    		$arr[]=$list[$i]['order_gold'];
    	}
//      for($i=0;$i<$count;$i++){
////      	$arr[]=$list[$i]['order_gold'];
//      	if($i%$num['num']!=0){
//      		unset($list[$i]);
//      	}
//      }
//  	$num=count($list);
    	$sum=array_sum($arr);
    	$d=array('num'=>$count,'sum'=>$sum,'list'=>$list);
    	$this->ajaxReturn($d);
//  	echo '<pre/>';
//  	print_r($d);
//  	echo $order->getLastSql();

    }
    
    //确认发货
    //需求参数 收货地址id 
    //提供参数 收货人姓名 电话  地址 man_shouhuo man_phone man_address
    public function addsend(){
    	$M=M('man_shouhuo');
    	$where['id']=I('get.id');
    	$field='man_shouhuo,man_phone,man_address';
    	$info=$M
    	->field($field)
    	->where($where)
    	->find();
    	$this->ajaxReturn($info);
    }
    
    //确认发货1
    //需求参数 订单id  kuaidi_id  kuaidi_num
    //
    public function addsend1(){
    	$M=M('order');
    	$save=I('post.');
    	$where['id']=I('id');
    	$sql=$M
    	->where($where)
    	->save($save);
    	if($sql){
    		$d=array('status'=>1,'操作成功');
    	}else{
    		$d=array('status'=>-1,'操作失败');
    	}
    	$this->ajaxReturn($d);
    }
    
     //关闭订单
     //需求参数 订单id 
     //提供参数$data
     public function gb_order(){
     	$where['id']=I('get.id');
     	$O=M('order');
     	$sql=$O->where($where)->save(array('state'=>6));
     	if($sql){
     		$data=array('status'=>1,'msg'=>'操作成功');
     	}else{
     		$data=array('status'=>-1,'msg'=>'操作失败');
     	}
     	$this->ajaxReturn($data);
     }
     
     //订单查看详情

     public function order_detail(){    	
     	//1106
     	//根据订单号查询到订单信息 state 交易状态(1：待付款、2：待发货、3：待收货、4：待评价、5：退换/售后、6：已关闭、7：已完成
        $field_order_form='
            order_form.id as order_form_id,order_form.order_num as order_form_order_num,
            order_form.openid as order_form_openid,order_form.shouhuo_id as order_form_shouhuo_id,
            order_form.array_id,order_form.buy_price,order_form.state,
	        order_form.time_build,order_form.time_fukuan,order_form.time_wancheng,order_form.time_pass,order_form.time_fahuo,order_form.time_registe_tk,order_form.time_tk_dk,
	        members.id as members_id,members.openid as members_openid,members.nickname,
	        man_shouhuo.id as man_shouhuo_id,man_shouhuo.man_shouhuo,man_shouhuo.man_phone,man_shouhuo.man_address
	        ';
		$a=M("order_form")
            ->field($field_order_form)
            ->join('members ON members.openid=order_form.openid')
            ->join('man_shouhuo ON man_shouhuo.id=order_form.shouhuo_id')
            ->where("order_num='".$_GET["order_num"]."'")
            ->find();
		//  订单下单的人信息

		//	订单里面的商品信息
		$chaifen=$this->chaifen($a["array_id"]);
		array_pop($chaifen);//删除数组中的最后一个元素

        //根据预购买表数组id  得到对应商品的信息，附加到该订单上
		for($p=0;$p<count($chaifen);$p++){
            $field_order='
                order.id as order_id,order.goods_id,order.buy_num as order_buy_num,
                order.is_use_guige,order.guige_key02,order.guige_name02,order.guige_key,order.guige_price,
                order.guige_name,order.is_on_lever_price,order.members_price_discount,
                
		        goods.id as goods_id,goods.goods_title,goods.price_sell,goods.image
		       
		        ';
                 $order[$p]=M("order")
               ->field($field_order)
               ->join('goods ON order.goods_id=goods.id')
          
                ->where("order.id='".$chaifen[$p]."'")
                ->find();
                
                $arr1102=explode(",",$order[$p]['image']);
				$order[$p]["image"]=$arr1102[0];
			}
		$a["id_arr"]=$order;
   	//dump($order);die;
     	$this->ajaxReturn($a);

     }
     //分割函数
	 function chaifen($source){
        return explode(',',$source);
    }
     //备注内容
     //需要参数 订单ID
     //提供参数  remark  订单ID
     public function getremark(){
     	$where['id']=I('id');
     	$O=M('order');
     	$d=$O->field('id,remark')->where($where)->find();
     	if($d['remark']==''){
     		$d['remark']='卖家备注';
     	}
//   	echo $d['remark'];
     	$this->ajaxReturn($d);
     }
     
     
     
     //备注提交
     //需要参数 订单ID
     //提供参数
     public function saveremark(){
     	$where['id']=I('id');
     	$r=I('remark');
     	$sql=M('order')->where($where)->save(array('remark'=>$r));
     	if($sql){
     		$d=array('status'=>1,'msg'=>'操作成功');
     	}else{
     		$d=array('status'=>-1,'msg'=>'操作失败');
     	}
//   	print_r($d);
     	$this->ajaxReturn($d);
     }
     
     
    //商品确认收货接口
    
    function goods_shouhuo(){
		if(empty($_POST["program_id"])){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		$date["state"]="4";
	    	
	    if(M("order_form")->where("order_num='".$_POST["order_num"]."'"."and program_id='".$_POST["program_id"]."'")->save($date)){
 			$this->ajaxReturn(array('status'=>1,'msg'=>'确认成功'));
 		}else{
 			$this->ajaxReturn(array('status'=>-1,'msg'=>'确认失败'));
 		}
    }
    
    //商品评价接口 
    function appraise(){
    	if(empty($_POST["program_id"]) | empty($_POST["openid"])){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
    	$a=M("appraise")->where("program_id='".$_POST["program_id"]."'"."and only_num='".$_POST["only_num"]."'"."and goods_id='".$_POST["goods_id"]."'"."and openid='".$_POST["openid"]."'")->find();
     
	 $date=array(
	 	'program_id'=>$_POST["program_id"],
	 	'only_num'=>$_POST["only_num"],
	 	'goods_id'=>$_POST["goods_id"],
	 	'openid'=>$_POST["openid"],
	 	'state'=>1,
	 	'time_set'=>time(),
	 	'content'=>$_POST["content"]
	 	
	 );
		 if(empty($a)){
		 		if(M("appraise")->add($date)){
		 			$this->ajaxReturn(array('status'=>1,'msg'=>'提交成功'));
		 		}else{
		 			$this->ajaxReturn(array('status'=>-1,'msg'=>'提交失败'));
		 		}
		 }else{
		 		$this->ajaxReturn(array('status'=>-11,'msg'=>'请勿重复提交'));
		 }
	     
	}
     	//订单实际支付价格
	function order_realprice(){
		//order_state 来源类型 、order_num  订单号    price 订单支付价格  program_id 小程序ID
		//order_state: goods_buy   integral_buy   dsh_buy  
		
		switch($_GET["order_state"]){
			case "goods_buy":
				$save["real_price"]=$_GET["price"];
				if(M("order_form")->where("order_num='".$_GET["order_num"]."'")->save($save)){
					$data=array('state'=>1,'msg'=>"保存成功");
				}else{
					$data=array('state'=>-1,'msg'=>"保存失败");
				}
			break;
			
			case "integral_buy":
				$date=2;
			break;
			
			case "dsh_buy":
				$date=3;
			break;	
		}
		$this->ajaxReturn($data);
	}
	
	
	//判断是否能使用消费码
	
	function chech_is_use_con(){
		$_GET["array_id"] = substr($_GET["array_id"],0,strlen($_GET["array_id"])-1); //去掉最后一个逗号
		
		$arr=explode(",",$_GET["array_id"]);
				
		if(empty($arr[1])){
			
			
			$b=M("order")->where("id='".$arr[0]."'")->find();
			//只有一个商品
			$a=M("goods")->where("id='".$b["goods_id"]."'")->find();
	
			if($a["is_use_consumption_num"]==1){
				$data=array('state'=>1,'msg'=>"可以使用");
			}else{
				$data=array('state'=>-1,'msg'=>"无法使用");
			}
			
		}else{
			$data=array('state'=>-2,'msg'=>"仅支持单商品消费");
		}
		
		$this->ajaxReturn($data);
	}

}
?>