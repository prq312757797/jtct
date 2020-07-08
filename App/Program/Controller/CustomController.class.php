<?php
namespace Program\Controller;
use Think\Controller;
header('content-type:application:json;charset=utf8'); 
header('Access-Control-Allow-Origin:*'); 
//header('Access-Control-Allow-Methods:POST'); 
header('Access-Control-Allow-Headers:x-requested-with,content-type');
class CustomController extends Controller {
	//定制小程序个别功能使用接口
	
	
    //禾之稻 支付欲购买并下单
	function hzd_order(){
		//传递商品id，program_id ，openid ,记录欲购买表,   
		//进来的时候判断有无记录    有记录的直接获得记录的id，访问order_from表，无记录，添加记录后访问order_from 表
		//访问order_from 表之后 回传order_num,前端直接触发支付

		$a=M("order")->where("cus_openid='".$_GET["openid"]."'"."and program_id='".$_GET["program_id"]."'")->find();

		if(empty($a)){

			$only_num=time().rand(111,999);	
			(empty($_GET["from_id"]))?0:$_GET["from_id"];
			
			//查找分销上线，判断上线的分销等级，（五星还是四星大使）调用不同的佣金比例，写入订单中应得佣金
			$members=M("members")->where("program_id='".$_GET["program_id"]."'"."and id='".$_GET["from_id"]."'")->find();//分销上线
			$fx_lever=M("fx_lever")->where("id='".$members["fx_lever_id"]."'")->find();
			
			//禾之稻  只有一级分销   bl_lever_1

			$add_01=array(
				"dfx_price01"=>$fx_lever["bl_lever_1"]*0.01*$_GET["price_pay"],
				"buy_price"=>$_GET["price_pay"],
				"buy_num"=>1,
				"goods_id"=>$_GET["goods_id"],
				"cus_openid"=>$_GET["openid"],
				"program_id"=>$_GET["program_id"],
				"dfx_id"=>$_GET["from_id"],
				
				"only_num"=>$only_num,
			);
			
			if(M("order")->add($add_01)){
				$b=M("order")->where("only_num='".$only_num."'")->find();
				$order_id=$b["id"];
			}
		}else{
			
			if($a["order_num"] != "0"){
				$a_1=M("order_form")->where("order_num='".$a["order_num"]."'")->find();
				
				if(in_array($a_1["state"], array(2,3,4,5,7))){
					$this->ajaxReturn(array("stata"=>"-66","msg"=>"已经买过了"));
				}else{
					
				M("order_form")->where("order_num='".$a["order_num"]."'")->delete();

					$order_id=$a["id"];
				}
			}else{
		
					$order_id=$a["id"];
			}

		}
				$add=array(
			//	group_order  //订单分组标识 buy_price
					"program_id"=>$_GET["program_id"],
					"openid"=>$_GET["openid"],
					"buy_price"=>$_GET["price_pay"],
					"time_build"=>time(),
					"array_id"=>$order_id.",",
					"group_order"=>"jt".time().rand(1111,9999),
					"order_num"=>"JT".date("YmdHis",time()).rand(111111,999999),
					"from_id"=>$_GET["from_id"]
				);
				if(M("order_form")->add($add)){
					$save01["from_id"]=$_GET["from_id"];
					$save01["order_num"]=$add["order_num"];
					$save01["group_order"]=$add["group_order"];
					M("order")->where("id='".$order_id."'")->save($save01);
					
				$this->ajaxReturn(array("stata"=>"1","msg"=>"已记录，可以购买","order_num"=>$add["order_num"]));
				
				}	

	}
	//检查不能重复购买
	function chech_repeat_registe(){
		$a=M("order_form")->field('state')->where("openid='".$_GET["openid"]."'"."and program_id='".$_GET["program_id"]."'")->find();
			if(empty($a)){
				$this->ajaxReturn(array("stata"=>"1.1","msg"=>"未购买过，可继续"));
			}else{
				if(in_array($a["state"], array(2,3,4,5,7))){
					$this->ajaxReturn(array("stata"=>"-1","msg"=>"已经买过了"));
				}else{
					$this->ajaxReturn(array("stata"=>"1","msg"=>"没付款，可以继续"));
				}
			}
			
	}
	
	//四星大使申请完成之后访问，试用一个大使指标
	function indicators_deduct(){
	
		if(M("goods")->where("id='".$_GET["goods_id"]."'")->setInc('hzd_indicators_used',"1")){
			$date=array("state"=>"1","msg"=>"指标扣除完成");
		}else{
			$date=array("state"=>"-1","msg"=>"指标扣除失败");
		}
		
		$this->ajaxReturn($date);
	}
	
     //美牙
     function my_data(){
 
     	if($_GET["page"]=="indexshow"){
     		$field="tel_name,index_edit";
     	}else if($_GET["page"]=="showlist"){
     		$field="tel_name,show_list";
     	}else if($_GET["page"]=="contectus"){
     		$field="tel_name,tel,sh_jd,detail_address,my_contect";
     	}else if($_GET["page"]=="aboutus"){
     		$field="tel_name,about_us";
     	}
		
     	$where["program_id"]=$_GET["program_id"];
		$a=M("store")->field($field)->where($where)->find();
		$this->ajaxReturn($a);
     }
    
// 	锡安洗衣
    function classification_list(){
    	$a=	M("attribute")->field("id,sort,title")->where("uid=0 and is_show=1 and  program_id='".$_GET["program_id"]."'")->order("sort")->select();
   		
   		for($i=0;$i<count($a);$i++){
   			$a[$i]["goods_info"]=$this->goods_info($program_id=$_GET["program_id"],$fenlei_1=$a[$i]["id"]);
   		
   		}
   		
   		$this->ajaxReturn($a);
    }
    function goods_info($program_id,$fenlei_1){
    	$a=M("goods")->field("id,goods_title,price_sell,price_own,image")->where("goods_state=1 and program_id='".$program_id."'"."and fenlei_1='".$fenlei_1."'")->select();
    	for($i=0;$i<count($a);$i++){
    		$arr_image=explode(",",$a[$i]["image"]);
    		$a[$i]["image"]=$arr_image[0];
    		$a[$i]["choose_state"]=false;
    		$a[$i]["base_choose_num"]="1";
    	}
    	return $a;
    }
//  检查库存
    function check_kucun($goods_id){
    	$a=M("goods")->where("id='".$goods_id."'")->find();
    	
    	$b["kucun_arr"]=json_decode($a["ktv_kucun"],true);
    	$can_sell=$this->com_goods_fl_list_n($arr=$b["kucun_arr"]);
				
		return $can_sell;
    }
    
//	添加洗衣内容
    function add_clothesdata(){
//	0:[goods_id: "2796", choose_num: 1, goods_title: "T恤", price_sell: "12.00"]
//	1:[goods_id: "2797", choose_num: 1, goods_title: "羊毛休闲衫 ", price_sell: "30.00"]
    	if(empty($_POST["program_id"]) | empty($_POST["openid"])){
			$this->ajaxReturn(array('state'=>-999,'msg'=>'参数错误 '));
		}

		$c1=json_decode($_POST["arr_data"],true);

		$choose_group="JT".time().rand("1111","9999");
		$group_order="jt".time().rand(1111,9999);//订单分组标识
		
		$float_num=date("md",time()).rand(11111,99999);//打印流水
		$order_num="JT".date("YmdHis",time()).rand(111111,999999);
		
    	for($i=0;$i<count($c1);$i++){
    		$order[$i]["program_id"]	=$_POST["program_id"];
	    	$order[$i]["cus_openid"]	=$_POST["openid"];
	    	$order[$i]["buy_num"]		=$c1[$i]["choose_num"];
	    	$order[$i]["order_num"]		="0";
	    	$order[$i]["goods_id"]		=$c1[$i]["goods_id"];  	
	    	$order[$i]["buy_price"]		=$c1[$i]["price_sell"]; 
	    	$order[$i]["choose_group"]	=$choose_group;
            $order[$i]["zhekou"]=$_POST["zhekou"];
//====================================
//		分销佣金记录  扫码的会将佣金给到分销二维码的主人，不扫码的，判断有没有上线
            if($_POST["from_id"]!=0){

                $members=M("members")
                    ->field('
                members.id as members_id,members.fx_lever_id,
                fx_lever.id as fx_lever_id,fx_lever.bl_lever_1,fx_lever.bl_lever_2,fx_lever.bl_lever_3')
                    ->where("members.id='".$_POST["from_id"]."'")
                    ->join('left join fx_lever ON fx_lever.id=members.fx_lever_id')
                    ->find();
                $order[$i]["dfx_id"]=$_POST["from_id"];

                $have_fx=1;
            }else{
                $man_pay=M("members")->field("fx_uid")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'")->find();
                if($man_pay["fx_uid"]!=0){
                    $members=M("members")
                        ->field('
                    members.id as members_id,members.fx_lever_id,
                    fx_lever.id as fx_lever_id,fx_lever.bl_lever_1,fx_lever.bl_lever_2,fx_lever.bl_lever_3')
                        ->where("members.id='".$man_pay["fx_uid"]."'")
                        ->join('left join fx_lever ON fx_lever.id=members.fx_lever_id')
                        ->find();
                    $order[$i]["dfx_id"]=$man_pay["fx_uid"];
                    $have_fx=1;
                }else{
                    $have_fx=0;
                }


            }
            if($have_fx==1){
                if($order[$i]["zhekou"]){
                    $price=$order[$i]["zhekou"]*$c1[$i]["price_sell"]*$c1[$i]["choose_num"];
                }else{
                    $price=$c1[$i]["price_sell"]*$c1[$i]["choose_num"];
                }
                $order[$i]["dfx_price01"]=$price*$members["bl_lever_1"]*0.01;
                $order[$i]["dfx_price02"]=$price*$members["bl_lever_2"]*0.01;
                $order[$i]["dfx_price03"]=$price*$members["bl_lever_3"]*0.01;
            }

//====================================

//	    	$can_sell[$i]=$this->check_kucun($goods_id=$c1[$i]["goods_id"]);
//	    
//	    	if($can_sell[$i]==0){
//	    		$this->ajaxReturn(array('state'=>-88,'msg'=>'库存不足，下单失败 '));
//	    	}
//	    	if($can_sell[$i]<$c1[$i]["choose_num"]){
//	    			
//	    		$this->ajaxReturn(array('state'=>-88,'msg'=>'库存不足，下单失败 '));
//	    	}
	    	
	    	M("order")->add($order[$i]);   	
    	}
    	
    	$b=M("order")->field("id")->where("choose_group='".$choose_group."'")->select();
    	for($i2=0;$i2<count($b);$i2++){
    		$arr[]=$b[$i2]["id"];
    		$save_2["order_num"]=$order_num;
    		$save_2["group_order"]=$group_order;
    		M("order")->where("id='".$b[$i2]["id"]."'")->save($save_2);
    		}

		$order_form["array_id"]		=implode(",",$arr).",";
    	$order_form["state"]		="1";
		$order_form["xiadan_time"]	=time();
		$order_form["time_build"]	=time();
		
		$order_form["program_id"]	=$_POST["program_id"];		//小程序id
		$order_form["openid"]		=$_POST["openid"];
		$order_form["order_num"]	=$order_num;
		$order_form["choose_group"]	=$choose_group;				
		$order_form["shouhuo_id"]	=$_POST["shouhuo_id"];
		$order_form["server_date"]	=$_POST["server_date"];
		$order_form["buy_price"]	=$_POST["total_price"];
		$order_form["zhekou"]		=$_POST["zhekou"];
			
		$order_form["room_num"]		=$_POST["room_num"];
		$order_form["group_order"]	=$group_order;
		$order_form["float_num"]	=$float_num;
		
		
		if(M("order_form")->add($order_form)){
			$return_data=array("state"=>1,"msg"=>"订单提交成功","order_num"=>$order_form["order_num"]);
		}else{
			$return_data=array("state"=>-1,"msg"=>"订单提交失败");
		}
		$this->ajaxReturn($return_data);
		
    }
//  基本收货地址信息
	function defaul_info(){
//		$a=M("man_shouhuo")->where("state=1 and is_used=1 and program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();
//		$this->ajaxReturn($a);
//		
		$members=M("members")->field("members.vip_card_id,member_level.discount")
		->join("left join member_level on member_level.id=members.vip_card_id")
		->where("members.openid='".$_GET["openid"]."'"."and members.program_id='".$_GET["program_id"]."'")->find();

		if($members["vip_card_id"]!=0){
			$zhekou=$members["discount"]*0.1;
		}else{
			$zhekou=1;
		}
		
		$this->ajaxReturn($zhekou);
	}
	
	function com_room_list($ktv_tie_goods_id,$ktv_tie_goods_num){
		$a=M("goods")->field("ktv_kucun")->where("id='".$ktv_tie_goods_id."'")->find();//套餐绑定商品id	
		$b=json_decode($a["ktv_kucun"],true);
		
		foreach($b as $k=>$v){ 
			if($k==3){//在线酒水仓柜
				if($b[$k]<$ktv_tie_goods_num){
					$ck_ok=0;
				}else{
					$ck_ok=1;
				}
			}
		}
		return $ck_ok;
	}
	function com01_room_list($ktv_tie_goods_id,$ktv_tie_goods_num){
		$arr_1=explode(",",$ktv_tie_goods_id);
		$arr_2=explode(",",$ktv_tie_goods_num);	
		for($i=0;$i<count($arr_1);$i++){
			$goods[$i]=M("goods")->field("goods_title,ktv_guige,ktv_danwei")->where("id='".$arr_1[$i]."'")->find();
			$c[$i]["goods_title"]=$goods[$i]["goods_title"];
			$c[$i]["ktv_guige"]=$goods[$i]["ktv_guige"];
			$c[$i]["ktv_danwei"]=$goods[$i]["ktv_danwei"];
			
			$c[$i]["goods_id"]=$arr_1[$i];
			$c[$i]["check_num"]=$arr_2[$i];
			$c[$i]["ck_ok"]=$this->com02_room_list($arr_1[$i],$arr_2[$i]);
		}
		return $c;
	}
		function com02_room_list($ktv_tie_goods_id,$ktv_tie_goods_num){
		$a=M("goods")->field("ktv_kucun")->where("id='".$ktv_tie_goods_id."'")->find();//套餐绑定商品id	
		$b=json_decode($a["ktv_kucun"],true);
		
		foreach($b as $k=>$v){ 
			if($k==3){//在线酒水仓柜
				if($b[$k]<$ktv_tie_goods_num){
					$ck_ok=0;
				}else{
					$ck_ok=1;
				}
			}
		}
		return $ck_ok;
	}
//  能量KTV
	function room_list(){
		
		$a=M("attribute")->where("uid=1422 and program_id='".$_GET["program_id"]."'" )->select();
		$ontime_houre=date("H",time());
		$onday=date("Y/m/d",time());

		for($i=0;$i<count($a);$i++){
			$b[$i]=M("goods")->field("id,goods_title,price_own,price_sell,goods_content,content_list,ison_tie_goods,ktv_tie_goods_id,ktv_tie_goods_num")->where("goods_state=1 and fenlei_2='".$a[$i]["id"]."'")->select();
			
			for($k=0;$k<count($b[$i]);$k++){
				$b[$i][$k]["arr_content_list"]=explode("^",$b[$i][$k]["content_list"]);

				if($b[$i][$k]["ison_tie_goods"]==1){

					$b[$i][$k]["ck_goods_info"]=$this->com01_room_list($b[$i][$k]["ktv_tie_goods_id"],$b[$i][$k]["ktv_tie_goods_num"]);
				}
			}		
			$a[$i]["goods_info"]=$b[$i];
		
			$all_room_count=M("room_manager")->where("fenlei_2='".$a[$i]["id"]."'")->count();//歌房总数
			$where0911["program_id"]=$_GET["program_id"];
			$where0911["date_day"]=$_GET["date_chooose"];
			$where0911["date_timeperiod"]=$_GET["day_choose"];
			$where0911["fenlei_2"]=$a[$i]["id"];
			$where0911["state"]=array("in","1,2");
			
			$all_room_ordercount=M("room_orderbooking")->where($where0911)->count();
//			$a[$i]["room_count"]=$all_room_count-$all_room_ordercount;
			$get_day=date("Y/m/d",strtotime($_GET["date_chooose"]));
			
			if(intval($ontime_houre) >18  &$_GET["day_choose"]==1 &$onday==$get_day){
				//不能选一档
			$a[$i]["room_count"]=0;
			
			}else{
				$a[$i]["room_count"]=$all_room_count-$all_room_ordercount;
			}
		}
		
		//当日订房档期
//		$room_schedule=M("room_schedule")->where("program_id='".$_GET["program_id"]."'")->select();	
//		$onday_time=date("Y-m-d",strtotime(date("Y-m-d",time())));
//		$onday_timeget=date("Y-m-d",strtotime($_GET["date_chooose"]));
//		M("room_orderbooking")->where("program_id='".$_GET["program_id"]."'"."and date_day='".$onday_timeget."'"."and date_timeperiod='".$_GET["day_choose"]."'")->

		$this->ajaxReturn($a);
	}
	function room_schedule(){
		//当日订房档期
		$room_schedule=M("room_schedule")->where("program_id='".$_GET["program_id"]."'")->select();

		$this->ajaxReturn($room_schedule);
	}
	function ktv_order_add(){
		if($_POST["datearea_state"]==1){
			$datearea_text="周一到周五13:00-19:00";
		}else if($_POST["datearea_state"]==2){
			$datearea_text="周一到周五19:00-02:00";
		}else if($_POST["datearea_state"]==3){
			$datearea_text="周六周日13:00-19:00";
		}else if($_POST["datearea_state"]==4){
			$datearea_text="周六周日19:00-02:00";
		}
		
		$add["program_id"]			=$_POST["program_id"];
		$add["openid"]				=$_POST["openid"];
		$add["fenlei_2"]			=$_POST["fenlei_2"];
		$add["goods_id"]			=$_POST["goods_id"];
		$add["date_day"]			=$_POST["date_chooose"];
		$add["date_timeperiod"]		=$_POST["day_choose"];
		$add["price"]				=$_POST["price"];
		
		$add["datearea_state"]		=$_POST["datearea_state"];//时间区间代码   1：周一到周五12:00-19:00 2：周一到周五19:00-02:00 3：周六周日12:00-19:00 4：周六周日19:00-02:00
		$add["datearea_text"]		=$datearea_text;
		
		
		$add["willbay_order_num"]	="JT".date("YmdHis",time()).rand(111111,999999);
		$add["time_build"]			=time();

		if(M("room_orderbooking")->add($add)){
			$data=array("state"=>1,"msg"=>"操作成功","willbay_order_num"=>$add["willbay_order_num"]);
		}else{
			$data=array("state"=>-1,"msg"=>"操作失败");
		}
		
		$this->ajaxReturn($data);
	}
	
	function order_pay(){
		$a=M("room_orderbooking")->where("willbay_order_num='".$_GET["willbay_order_num"]."'")->find();
		$b=M("goods")->where("id='".$a["goods_id"]."'")->find();
		$a["goods_title"]=$b["goods_title"];
		
		$members=M("members")->field("members.vip_card_id,member_level.discount")
		->join("left join member_level on member_level.id=members.vip_card_id")
		->where("members.openid='".$a["openid"]."'"."and members.program_id='".$a["program_id"]."'")->find();

		$a["zhekou"]=$members["discount"]*0.1;
		
		$weekarray=array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");

		$a["xignqi"]=$weekarray[date("w",strtotime($a["time_build"]))];
		$a["date_day"]=date("Y-m-d",$a["time_build"]);

		$c=M("room_schedule")->where("lever='".$a["date_timeperiod"]."'")->find();
		$a["room_schedule_title"]=$c["title"];
		$a["room_schedule_time_area"]=$c["time_area"];
		
		$this->ajaxReturn($a);
	}
//	生政订单号
	function order_submin_ktv(){
		
		$save["order_num"]="JT".date("YmdHis",time()).rand(111111,999999);
		$num_code=rand(111111111,999999999);
		
		$a=M("room_orderbooking")->field("id")->where("num_code='".$num_code."'")->find();

        $b=M("room_orderbooking")->where("willbay_order_num='".$_GET["willbay_order_num"]."'")->find();
		if(empty($a)){
			$save["num_code"]=$num_code;
		}else{
			$save["num_code"]=rand(111111111,999999999);
		}
		$save["state"]=0;
		if($_GET["zhekou"]) $save["zhekou"]=$_GET["zhekou"];


//		分销佣金记录  扫码的会将佣金给到分销二维码的主人，不扫码的，判断有没有上线
        if($_GET["from_id"]!=0){

            $members=M("members")
            ->field('
                members.id as members_id,members.fx_lever_id,
                fx_lever.id as fx_lever_id,fx_lever.bl_lever_1,fx_lever.bl_lever_2,fx_lever.bl_lever_3')
            ->where("members.id='".$_GET["from_id"]."'")
            ->join('left join fx_lever ON fx_lever.id=members.fx_lever_id')
            ->find();
            $save["fx_uid"]=$_GET["from_id"];

            $have_fx=1;
        }else{
            $man_pay=M("members")->field("fx_uid")->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();
            if($man_pay["fx_uid"]!=0){
                $members=M("members")
                    ->field('
                    members.id as members_id,members.fx_lever_id,
                    fx_lever.id as fx_lever_id,fx_lever.bl_lever_1,fx_lever.bl_lever_2,fx_lever.bl_lever_3')
                    ->where("members.id='".$man_pay["fx_uid"]."'")
                    ->join('left join fx_lever ON fx_lever.id=members.fx_lever_id')
                    ->find();
                    $save["fx_uid"]=$man_pay["fx_uid"];
                $have_fx=1;
            }else{
                $have_fx=0;
            }


        }
        if($have_fx==1){
            if($save["zhekou"]){
                $price=$save["zhekou"]*$b["price"];
            }else{
                $price=$b["price"];
            }
            $save["dfx_price01"]=$price*$members["bl_lever_1"]*0.01;
            $save["dfx_price02"]=$price*$members["bl_lever_2"]*0.01;
            $save["dfx_price03"]=$price*$members["bl_lever_3"]*0.01;
        }

		if(M("room_orderbooking")->where("willbay_order_num='".$_GET["willbay_order_num"]."'")->save($save)){
			
			$data=array("state"=>1,"msg"=>"操作成功","order_num"=>$save["order_num"]);
		}else{
			$data=array("state"=>-1,"msg"=>"操作失败");
		}
		
		$this->ajaxReturn($data);
	}
	function only_num_code($num_code){
		$a=M("room_orderbooking")->field("id")->where("num_code='".$num_code."'")->find();
		if(empty($a)){
			$save["num_code"]=$num_code;
		}else{
			$save["num_code"]=$num_code;
		}
	}
	public function room_order_list(){

		$where=array(
			'program_id'=>$_GET["program_id"],
			'openid'=>$_GET["openid"],
			'state'=>$_GET["state"],
		);
		$a=M('room_orderbooking')->where($where)->order("time_build desc")->select();
//		订单状态(0:待付款、1：已付款待服务，2：到店分配歌房、3：退款、4：退款完成，5订单完成，6：订单取消

		for($i=0;$i<count($a);$i++){
			$b[$i]=M("goods")->field("image,goods_title")->where("id='".$a[$i]["goods_id"]."'")->find();
			
			$temp[$i]=explode(",",$b[$i]["image"]);
			$b[$i]["image"]=$temp[$i][0];
			$a[$i]["goods_info"]=$b[$i];
			
			$a[$i]["time_set"]=date("Y-m-d H:i:s",$a[$i]["time_set"]);
            $a[$i]["time_done"]=date("Y/m/d H:i:s",$a[$i]["time_done"]);
		}

        $this->ajaxReturn($a);
      }

      function order_con_ktv(){
          $a=M('room_orderbooking')->where("order_num='".$_GET["order_num"]."'")->find();

          $b=M("goods")->where("id='".$a["goods_id"]."'")->find();
          $arr1102=explode(",",$b['image']);
          $b["image"]=$arr1102[0];

          $c=M("assistant_add")->where("openid='".$a["openid_ass"]."'")->find();

          $a["godos_info"]=$b;

          $a["ass_info"]=$c;


          $shengyu=$a["time_done"]-time();
          if($shengyu>3600){
              $a["can_xuzhong"]=1;
              $a["can_xuzhong_houre"]=intval($shengyu/3600);
          }else{
              $a["can_xuzhong"]=0;
              $a["can_xuzhong_houre"]=0;
          }

          $this->ajaxReturn($a);
      }

      function room_order_list_using(){
      		$where=array(
			'program_id'=>$_GET["program_id"],
			'openid'=>$_GET["openid"],
			'state'=>1,
		);
		$a=M('room_orderbooking')->where($where)->order("time_build desc")->order("time_build desc")->select();
//		订单状态(0:待付款、1：已付款待服务，2：到店分配歌房、3：退款、4：退款完成，5订单完成，6：订单取消

		for($i=0;$i<count($a);$i++){
			$b[$i]=M("goods")->field("image,goods_title")->where("id='".$a[$i]["goods_id"]."'")->find();
			
			$temp[$i]=explode(",",$b[$i]["image"]);
			$b[$i]["image"]=$temp[$i][0];
			$a[$i]["goods_info"]=$b[$i];
			
			$a[$i]["time_set"]=date("Y-m-d H:i:s",$a[$i]["time_set"]);
            $a[$i]["time_done"]=date("Y/m/d H/i/s",$a[$i]["time_done"]);
		}
		
        $this->ajaxReturn($a);
      }
      
      function ktv_quxiao(){

		$save["state"]=6;
		$save["time_none"]=time();
		
		if(M("room_orderbooking")->where("order_num='".$_GET["order_num"]."'")->save($save)){
			
			$data=array("state"=>1,"msg"=>"操作成功");
		}else{
			$data=array("state"=>-1,"msg"=>"操作失败");
		}
		$this->ajaxReturn($data);
      }
//    订单退款
     function ktv_tuik(){

		$save["state"]=3;
		$save["time_tk"]=time();
		
		if(M("room_orderbooking")->where("order_num='".$_GET["order_num"]."'")->save($save)){
			
			$data=array("state"=>1,"msg"=>"操作成功");
		}else{
			$data=array("state"=>-1,"msg"=>"操作失败");
		}
		$this->ajaxReturn($data);
     }	
      
      //ktv订房二维码
      function qdcode_roomcheck(){
      	$a=M("room_orderbooking")->where("state =1 and program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->select();
      }
      
      //在线酒水列表页
	public function goods_fl_list(){
		//商品分类列表  
		$a=M("attribute")->field('id,uid,title')->where("is_show=1 and uid=0 and attribute_style=4 and program_id='".$_GET["program_id"]."'" )->select();
		for($i=0;$i<count($a);$i++){
			$where02[$i]=array(
				'program_id'=>$_GET["program_id"],
				'goods_state'=>"1",
				'fenlei_1'=>$a[$i]["id"]
			);
			$b[$i]=M("goods")->field('id,goods_title,image,price_sell')->where($where02[$i])->order("sort")->select();
			for($k[$i]=0;$k[$i]<count($b[$i]);$k[$i]++){
				$b[$i][$k[$i]]["choose_state"]=false;
				$b[$i][$k[$i]]["choose_num"]=1;
			}				
			$a[$i]["goods_info"]=$b[$i];
			$a[$i]["num"]=0;
		}
	
		$this->ajaxReturn($a);
	}
	
	
//在线酒水列表页
	public function goods_fl_list_n(){
		//商品分类列表  
		$a=M("attribute")->field('id,uid,title')->where("is_show=1 and uid=1459 and attribute_style=4 and program_id='".$_GET["program_id"]."'" )->select();


		for($i=0;$i<count($a);$i++){
			$where02[$i]=array(
				'program_id'=>$_GET["program_id"],
				'goods_state'=>"1",
				'fenlei_2'=>$a[$i]["id"],
				'goods_baiye'=>1
				
			);
			$b[$i]=M("goods")->field('id,goods_title,image,price_sell,ktv_kucun,fenlei_1')->where($where02[$i])->order("sort")->select();


			for($k[$i]=0;$k[$i]<count($b[$i]);$k[$i]++){
				$b[$i][$k[$i]]["choose_state"]=false;
				$b[$i][$k[$i]]["choose_num"]=1;
				
				$b[$i][$k[$i]]["kucun_arr"]=json_decode($b[$i][$k[$i]]["ktv_kucun"],true);
				
				$b[$i][$k[$i]]["can_sell"]=$this->com_goods_fl_list_n($arr=$b[$i][$k[$i]]["kucun_arr"]);
				
				if($b[$i][$k[$i]]["can_sell"]!=0){
					$x[$i][$k[$i]]=$b[$i][$k[$i]];
				}
			}				
//			$a[$i]["goods_info"]=$b[$i];


			$a[$i]["goods_info"]=$x[$i];
			$a[$i]["num"]=0;
//            if($i==1){
//                dump($a[$i]);die;
//            }
			$a[$i]["count_goods_info"]=count($x[$i]);
			
			if($a[$i]["count_goods_info"]>0){
				$z[]=$a[$i];
			}
		}

		$this->ajaxReturn($z);
	}
	
	function com_goods_fl_list_n($arr){
		foreach($arr as $k=>$v){ 
				if($k==3 & $v>0){
					$can_sell=$v;
				}else{
					$can_sell=0;
				}
			}
		return $can_sell;
	}
	
	
	 //在线酒水
	public function goods_flsave_list(){
		//商品分类列表  
		$a=M("attribute")->field('id,uid,title')->where("is_show=1 and uid=0 and attribute_style=5 and program_id='".$_GET["program_id"]."'" )->select();
		for($i=0;$i<count($a);$i++){
			$where02[$i]=array(
				'program_id'=>$_GET["program_id"],
				'goods_state'=>"1",
				'fenlei_1'=>$a[$i]["id"]
			);
			$b[$i]=M("goods")->field('id,goods_title,image,price_sell,open_save')->where($where02[$i])->order("sort")->select();
			for($k[$i]=0;$k[$i]<count($b[$i]);$k[$i]++){
				$b[$i][$k[$i]]["choose_state"]=false;
				$b[$i][$k[$i]]["choose_num"]=0;
			}	
			$a[$i]["goods_info"]=$b[$i];
			$a[$i]["num"]=0;
		}
		$this->ajaxReturn($a);

	}
		//递归
	function bq($arr,$p=0){
		$ar=array();
		foreach($arr as $v){ if($v["uid"]==$p){ $v["child"]=$this->bq($arr,$v["id"]);	$ar[]=$v;}} return $ar;
	}
	
	
	//存酒数据
	function beer_save(){
		if(empty($_POST["program_id"]) | empty($_POST["openid"])){
			$this->ajaxReturn(array('state'=>-999,'msg'=>'参数错误 '));
		}
		$c1=json_decode($_POST["arr_data"],true);
		$order_num="JT".date("YmdHis",time()).rand(111111,999999);
		
    	for($i=0;$i<count($c1);$i++){
    		$order[$i]["program_id"]	=$_POST["program_id"];
	    	$order[$i]["openid"]		=$_POST["openid"];
	    	$order[$i]["num"]			=$c1[$i]["choose_num"];
	    	$order[$i]["order_num"]		=$order_num;
	    	$order[$i]["goods_id"]		=$c1[$i]["goods_id"];  	
	    	$order[$i]["assistant_num"]	=$_POST["assistant_num"];
	    	$order[$i]["room_num"]		=$_POST["room_num"];
	    	
	    	$order[$i]["time_set"]	=time();
	    	M("beer_save")->add($order[$i]);   	
	    	
    	}
    	$return_data=array("state"=>1,"msg"=>"存酒成功");

		$this->ajaxReturn($return_data);
	}
		//取酒数据
	function beer_get(){
		if(empty($_POST["program_id"]) | empty($_POST["openid"])){
			$this->ajaxReturn(array('state'=>-999,'msg'=>'参数错误 '));
		}
		$c1=json_decode($_POST["arr_data"],true);
		$order_num_get="JT".date("YmdHis",time()).rand(111111,999999);

    	for($i=0;$i<count($c1);$i++){
	    	$str[$i]=implode("",$c1[$i]);    	
    	}
    	
    	for($k=0;$k<count($str);$k++){
	    	
	    	$save[$k]["time_getregiste"]=time();
	    	$save[$k]["state"]			=2;
	    	$save[$k]["assistant_num"]	=$_POST["assistant_num"];
	    	$save[$k]["room_num"]	=$_POST["room_num"];
	   		$save[$k]["order_num_get"]	=$order_num_get;
	   		
	    	M("beer_save")->where("id='".$str[$k]."'")->save($save[$k]);   	 	
		}
    	$return_data=array("state"=>1,"msg"=>"申请成功");

		$this->ajaxReturn($return_data);
	}
	//取酒完成
	function beer_get_done(){
		if(empty($_POST["program_id"]) | empty($_POST["openid"])){
			$this->ajaxReturn(array('state'=>-999,'msg'=>'参数错误 '));
		}
		$c1=json_decode($_POST["arr_data"],true);
    	for($i=0;$i<count($c1);$i++){
	    	$str[$i]=implode("",$c1[$i]);    	
    	}
    	for($k=0;$k<count($str);$k++){
	
	    	$save[$k]["time_done"]=time();
	    	$save[$k]["state"]	=3;

	    	M("beer_save")->where("id='".$str[$k]."'")->save($save[$k]);   	
		}
    	
    	$return_data=array("state"=>1,"msg"=>"申请成功");

		$this->ajaxReturn($return_data);
	}
	//在线酒水配单
	function online_beer_done(){
		if(empty($_POST["program_id"]) | empty($_POST["openid"])){
			$this->ajaxReturn(array('state'=>-999,'msg'=>'参数错误 '));
		}
		$c1=json_decode($_POST["arr_data"],true);
		
	
    	for($i=0;$i<count($c1);$i++){
    		$str[$i]=implode("",$c1[$i]);    	
    	}
    	for($k=0;$k<count($str);$k++){
			$save[$k]["time_wancheng"]=time();
	    	$save[$k]["state"]	=7;

	    	M("order_form")->where("id='".$str[$k]."'")->save($save[$k]);   	
		}
    		
    	$return_data=array("state"=>1,"msg"=>"申请成功");

		$this->ajaxReturn($return_data);
	}
    //房台套餐配单
    function fangtai_done(){
        if(empty($_POST["program_id"]) | empty($_POST["openid"])){
            $this->ajaxReturn(array('state'=>-999,'msg'=>'参数错误 '));
        }
        $c1=json_decode($_POST["arr_data"],true);


        for($i=0;$i<count($c1);$i++){
            $str[$i]=implode("",$c1[$i]);
        }
        for($k=0;$k<count($str);$k++){
            $save[$k]["peidan_time"]=time();
            $save[$k]["state_peisong"]=1;

            M("room_orderbooking")->where("id='".$str[$k]."'")->save($save[$k]);
        }


        $return_data=array("state"=>1,"msg"=>"成功");
        $this->ajaxReturn($return_data);
    }
	
	
	function beer_save_list(){
		
	if($_GET["state"]==1){
		$where["state"]=1;
	}else if($_GET["state"]==2){
		$where["state"]=2;
	}else if($_GET["state"]==3){
		$where["state"]=3;
	}else if($_GET["state"]==4){
		$where["state"]=4;//过期
	}
		$where["program_id"]=$_GET["program_id"];
		$where["openid"]	=$_GET["openid"];
		$a=M("beer_save")->where($where)->order("time_set desc")->select();
		for($i=0;$i<count($a);$i++){
			$b[$i]=M("goods")->where("id='".$a[$i]["goods_id"]."'")->find();
			$a[$i]["goods_title"]=$b[$i]["goods_title"];
			
			$a[$i]["time_set"]=date("Y-m-d",$a[$i]["time_set"]);
			$a[$i]["choosed"]=0;
		}
		
		$this->ajaxReturn($a);
	}
      	function beer_saveget_list(){
		
		$where['state']=array('in','2,3');

		$where["program_id"]=$_GET["program_id"];
		$where["openid"]	=$_GET["openid"];
		$a=M("beer_save")->where($where)->order("time_set desc")->select();
		

		for($i=0;$i<count($a);$i++){
			$b[$i]=M("goods")->where("id='".$a[$i]["goods_id"]."'")->find();
			$a[$i]["goods_title"]=$b[$i]["goods_title"];
			
			$a[$i]["time_set"]=date("Y-m-d",$a[$i]["time_set"]);
			$a[$i]["time_done"]=date("Y-m-d",$a[$i]["time_done"]);
			
			$a[$i]["choosed"]=0;
		}
		
		$this->ajaxReturn($a);
	}
	
//	ktv确定店员是否正常
	function check_assistant(){
		$where["program_id"]=$_GET["program_id"];
		$where["assistant_num"]=$_GET["assistant_num"];
		
		$a=M("assistant_add")->field("assistant_psw")->where($where)->find();
		if(empty($a)){
			$this->ajaxReturn(array("state"=>-1,"msg"=>"验证失败"));
		}
		if($a["assistant_psw"]==$_GET["assistant_psw"]){
			$return_data=array("state"=>1,"msg"=>"验证成功");
		}else{
			$return_data=array("state"=>-1,"msg"=>"验证失败");
		}
		$this->ajaxReturn($return_data);
	}

//	房台使用  1205
	function ft_user(){
		
		$a=M("room_orderbooking")->where("program_id='".$_GET["program_id"]."'"."and num_code='".$_GET["num_code"]."'")->find();

		if($a["state"]!=1){
			$this->ajaxReturn(array("state"=>-2,"msg"=>"无效消费码"));
		}
//        时间区间代码   1：周一到周五13:00-19:00 2：周一到周五19:00-02:00 3：周六周日13:00-19:00 4：周六周日19:00-02:00
        $date=date("Y-m-d",time());
        $date_week=$this-> get_week($date);
        $ontime_houre=date("H",time());


        if($a["datearea_state"]==1){

            if($date_week==0) $this->ajaxReturn(array("state"=>-4,"msg"=>"当前日期不可用","reason"=>$a));
            if($date_week==6) $this->ajaxReturn(array("state"=>-4,"msg"=>"当前日期不可用","reason"=>$a));

            if(intval($ontime_houre)<13) $this->ajaxReturn(array("state"=>-5,"msg"=>"当前时间不可用","reason"=>$a));
            if(intval($ontime_houre)>19) $this->ajaxReturn(array("state"=>-5,"msg"=>"当前时间不可用","reason"=>$a));

        }else if($a["datearea_state"]==2){
            if($date_week==0) $this->ajaxReturn(array("state"=>-4,"msg"=>"当前日期不可用","reason"=>$a));
            if($date_week==6 & intval($ontime_houre)>2) $this->ajaxReturn(array("state"=>-4,"msg"=>"当前日期不可用","reason"=>$a));
            if(intval($ontime_houre)<19 & intval($ontime_houre)>2) $this->ajaxReturn(array("state"=>-5,"msg"=>"当前时间不可用","reason"=>$a));


        }else if($a["datearea_state"]==3){
            if($date_week==1 | $date_week==2| $date_week==3| $date_week==4| $date_week==5){
                $this->ajaxReturn(array("state"=>-4,"msg"=>"当前日期不可用","reason"=>$a));
            }
            if(intval($ontime_houre)<13) $this->ajaxReturn(array("state"=>-5,"msg"=>"当前时间不可用","reason"=>$a));
            if(intval($ontime_houre)>19) $this->ajaxReturn(array("state"=>-5,"msg"=>"当前时间不可用","reason"=>$a));

        }else if($a["datearea_state"]==4){
            if($date_week==1 & intval($ontime_houre)>2) $this->ajaxReturn(array("state"=>-4,"msg"=>"当前日期不可用","reason"=>$a));
            if( $date_week==2| $date_week==3| $date_week==4| $date_week==5){
                $this->ajaxReturn(array("state"=>-4,"msg"=>"当前日期不可用","reason"=>$a));
            }
            if(intval($ontime_houre)<19 & intval($ontime_houre)>2) $this->ajaxReturn(array("state"=>-5,"msg"=>"当前时间不可用","reason"=>$a));
        }

		
//		$onday=strtotime(date("Y/m/d",time()));
//		$get_day=strtotime(date("Y/m/d",strtotime($a["date_day"])));
//		if($get_day<$onday){
//			$this->ajaxReturn(array("state"=>-3,"msg"=>"二维码已过期"));
//		}
//		if($onday==$get_day){
//			if($a["date_timeperiod"]==1 & intval($ontime_houre)>18 ){
//				$this->ajaxReturn(array("state"=>-3,"msg"=>"二维码已过期."));
//			}
//		}
//		$b=M("goods")->where("id='".$a["goods_id"]."'")->find();//房台套餐id
//		$c=M("goods")->where("id='".$b["ktv_tie_goods_id"]."'")->find();//套餐绑定商品id
//		$e=json_decode($c["ktv_kucun"],true);
//		foreach($e as $k=>$v){
//            if($k==3){//在线酒水仓柜
//                $e[$k]=$v-$b["ktv_tie_goods_num"];
//            }
//        }
//		$save01["ktv_kucun"]=json_encode($e);
//
//		$where["program_id"]=$_GET["program_id"];
//		$where["num_code"]=$_GET["num_code"];
//
//		$save["openid_ass"]=$_GET["openid"];
//		$save["state"]=2;
//		$save["time_done"]=time()+$b["goods_time"]*3600;
//
//		if(M("room_orderbooking")->where($where)->save($save)){
//			if($b["ison_tie_goods"]==1){
//				M("goods")->where("id='".$b["ktv_tie_goods_id"]."'")->save($save01);
//			}
//			$return_data=array("state"=>1,"msg"=>"验证成功");
//		}else{
//			$return_data=array("state"=>-1,"msg"=>"验证失败");
//		}
        $ass_info=M("assistant_add")->where("openid='".$_GET["openid"]."'")->find();
        $return_data=array("state"=>1,"msg"=>"验证成功","reason"=>$a,"ass_info"=>$ass_info);
		$this->ajaxReturn($return_data);
	}


    function ft_user_2(){
        $room=M("room_manager")->where("room_num='".$_GET["room_num"]."'")->find();

        if(empty($room)){
            $this->ajaxReturn(array("state"=>-6,"msg"=>"房号有误"));
        }
        if($room["state"]!=0){
            $this->ajaxReturn(array("state"=>-7,"msg"=>"房间非空闲状态","room_info"=>$room));
        }

        $a=M("room_orderbooking")->where("program_id='".$_GET["program_id"]."'"."and num_code='".$_GET["num_code"]."'")->find();
        $b=M("goods")->where("id='".$a["goods_id"]."'")->find();//房台套餐id
        $c=M("goods")->where("id='".$b["ktv_tie_goods_id"]."'")->find();//套餐绑定商品id


        if($a["state"]!=1){
            $this->ajaxReturn(array("state"=>-2,"msg"=>"无效二维码"));
        }


//        时间区间代码   1：周一到周五13:00-19:00 2：周一到周五19:00-02:00 3：周六周日13:00-19:00 4：周六周日19:00-02:00
        $date=date("Y-m-d",time());
        $date_week=$this-> get_week($date);
        $ontime_houre=date("H",time());


        if($a["datearea_state"]==1){


            if($date_week==0) $this->ajaxReturn(array("state"=>-4,"msg"=>"当前日期不可用","reason"=>$a));
            if($date_week==6) $this->ajaxReturn(array("state"=>-4,"msg"=>"当前日期不可用","reason"=>$a));

            if(intval($ontime_houre)<13) $this->ajaxReturn(array("state"=>-5,"msg"=>"当前时间不可用","reason"=>$a));
            if(intval($ontime_houre)>19) $this->ajaxReturn(array("state"=>-5,"msg"=>"当前时间不可用","reason"=>$a));

            $ontime=time();
            $end_time=date("Y-m-d 18:59:59",time());

            $time_remaining=strtotime($end_time)-$ontime;//剩余使用时间（秒数）

            //欢唱时间   $b["goods_time"]*3600

            if( $b["goods_time"]*3600<$time_remaining){
                $save["time_done"]=time()+$b["goods_time"]*3600;
            }else{
                $save["time_done"]=strtotime($end_time);
            }

        }else if($a["datearea_state"]==2){
            if($date_week==0) $this->ajaxReturn(array("state"=>-4,"msg"=>"当前日期不可用","reason"=>$a));
            if($date_week==6 & intval($ontime_houre)>2) $this->ajaxReturn(array("state"=>-4,"msg"=>"当前日期不可用","reason"=>$a));
            if(intval($ontime_houre)<19 & intval($ontime_houre)>2) $this->ajaxReturn(array("state"=>-5,"msg"=>"当前时间不可用","reason"=>$a));

            $ontime=time();
            if(intval($ontime_houre)>18){
                $end_time=strtotime(date("Y-m-d 23:59:59",time()))+2*3600;

                $time_remaining=$end_time-$ontime;//剩余使用时间（秒数）
            }
            if(intval($ontime_houre)<3){
                $end_time=strtotime(date("Y-m-d 01:59:59",time()));
                $time_remaining=strtotime(date("Y-m-d 01:59:59",time()))-$ontime;//剩余使用时间（秒数）


            }
            //欢唱时间   $b["goods_time"]*3600

            if( $b["goods_time"]*3600<$time_remaining){
                $save["time_done"]=time()+$b["goods_time"]*3600;
            }else{
                $save["time_done"]=$end_time;
            }

        }else if($a["datearea_state"]==3){
            if($date_week==1 | $date_week==2| $date_week==3| $date_week==4| $date_week==5){
                $this->ajaxReturn(array("state"=>-4,"msg"=>"当前日期不可用","reason"=>$a));
            }
            if(intval($ontime_houre)<13) $this->ajaxReturn(array("state"=>-5,"msg"=>"当前时间不可用","reason"=>$a));
            if(intval($ontime_houre)>19) $this->ajaxReturn(array("state"=>-5,"msg"=>"当前时间不可用","reason"=>$a));

            $ontime=time();
            $end_time=date("Y-m-d 18:59:59");

            $time_remaining=strtotime($end_time)-$ontime;//剩余使用时间（秒数）

            //欢唱时间   $b["goods_time"]*3600

            if( $b["goods_time"]*3600<$time_remaining){
                $save["time_done"]=time()+$b["goods_time"]*3600;
            }else{
                $save["time_done"]=strtotime($end_time);
            }
        }else if($a["datearea_state"]==4){
            if($date_week==1 & intval($ontime_houre)>2) $this->ajaxReturn(array("state"=>-4,"msg"=>"当前日期不可用","reason"=>$a));
            if( $date_week==2| $date_week==3| $date_week==4| $date_week==5){
                $this->ajaxReturn(array("state"=>-4,"msg"=>"当前日期不可用","reason"=>$a));
            }
            if(intval($ontime_houre)<19 & intval($ontime_houre)>2) $this->ajaxReturn(array("state"=>-5,"msg"=>"当前时间不可用","reason"=>$a));

            $ontime=time();
            if(intval($ontime_houre)>18){
                $end_time=strtotime(date("Y-m-d 23:59:59",time()))+2*3600;

                $time_remaining=$end_time-$ontime;//剩余使用时间（秒数）
            }
            if(intval($ontime_houre)<3){
                $end_time=strtotime(date("Y-m-d 01:59:59",time()));
                $time_remaining=strtotime(date("Y-m-d 01:59:59",time()))-$ontime;//剩余使用时间（秒数）
            }
            //欢唱时间   $b["goods_time"]*3600

            if( $b["goods_time"]*3600<$time_remaining){
                $save["time_done"]=time()+$b["goods_time"]*3600;
            }else{
                $save["time_done"]=$end_time;
            }
        }
        $e=json_decode($c["ktv_kucun"],true);
        foreach($e as $k=>$v){
            if($k==3){//在线酒水仓柜
                $e[$k]=$v-$b["ktv_tie_goods_num"];
            }
        }
        $save01["ktv_kucun"]=json_encode($e);

        $where["program_id"]=$_GET["program_id"];
        $where["num_code"]=$_GET["num_code"];

        $save["openid_ass"]=$_GET["openid"];
        $save["time_used"]=time();
        $save["state"]=2;

        $save["room_num"]=$_GET["room_num"];
        $save02["state"]=1;

        if(M("room_orderbooking")->where($where)->save($save)){

            M("room_manager")->where("room_num='".$_GET["room_num"]."'")->save($save02);

            if($b["ison_tie_goods"]==1){
                M("goods")->where("id='".$b["ktv_tie_goods_id"]."'")->save($save01);
            }
            $return_data=array("state"=>1,"msg"=>"验证成功");
        }else{
            $return_data=array("state"=>-1,"msg"=>"验证失败");
        }
        $this->ajaxReturn($return_data);
    }
	function aaa(){
	    $a="2018-12-04 00:24:07";
        $ontime_houre=date("H",strtotime($a));
//      $date=date("Y-m-d",time());
//	    $a=$this-> get_week($date);
        dump($date=date("Y-m-d H:i:s",time()));
        dump(intval($ontime_houre));
    }
    function   get_week($date){
        //强制转换日期格式
        $date_str=date('Y-m-d',strtotime($date));

        //封装成数组
        $arr=explode("-", $date_str);

        //参数赋值
        //年
        $year=$arr[0];
        //月，输出2位整型，不够2位右对齐
        $month=sprintf('%02d',$arr[1]);

        //日，输出2位整型，不够2位右对齐
        $day=sprintf('%02d',$arr[2]);

        //时分秒默认赋值为0；
        $hour = $minute = $second = 0;

        //转换成时间戳
        $strap = mktime($hour,$minute,$second,$month,$day,$year);

        //获取数字型星期几
        $number_wk=date("w",$strap);

        //自定义星期数组
        $weekArr=array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");

        //获取数字对应的星期
//        return $weekArr[$number_wk];
        return $number_wk;
    }


	function roomorder_info(){
		$a=M("room_orderbooking")->where("program_id='".$_GET["program_id"]."'"."and num_code='".$_GET["num_code"]."'")->find();

	$b=M("goods")->field("image,goods_title")->where("id='".$a["goods_id"]."'")->find();
			
			$temp=explode(",",$b["image"]);
			$b["image"]=$temp[0];
			$a["goods_info"]=$b;
			
			$a["time_set"]=date("Y-m-d H:i:s",$a["time_set"]);
			
		if($a["state"]!=1){
			$return_data=array("state"=>-1,"msg"=>"无效二维码");
			$this->ajaxReturn($return_data);
		}else{
			$this->ajaxReturn($a);
		}
	}
	
//	使用二维码核对使用房台订单   1205
	function use_num_code(){
		$a=M("room_orderbooking")->where("program_id='".$_GET["program_id"]."'"."and num_code='".$_GET["num_code"]."'")->find();


        if($a["state"]!=1){
            $this->ajaxReturn(array("state"=>-2,"msg"=>"无效二维码"));
        }
//        时间区间代码   1：周一到周五13:00-19:00 2：周一到周五19:00-02:00 3：周六周日13:00-19:00 4：周六周日19:00-02:00
        $date=date("Y-m-d",time());
        $date_week=$this-> get_week($date);
        $ontime_houre=date("H",time());


        if($a["datearea_state"]==1){

            if($date_week==0) $this->ajaxReturn(array("state"=>-4,"msg"=>"当前日期不可用","reason"=>$a));
            if($date_week==6) $this->ajaxReturn(array("state"=>-4,"msg"=>"当前日期不可用","reason"=>$a));

            if(intval($ontime_houre)<13) $this->ajaxReturn(array("state"=>-5,"msg"=>"当前时间不可用","reason"=>$a));
            if(intval($ontime_houre)>19) $this->ajaxReturn(array("state"=>-5,"msg"=>"当前时间不可用","reason"=>$a));

        }else if($a["datearea_state"]==2){
            if($date_week==0) $this->ajaxReturn(array("state"=>-4,"msg"=>"当前日期不可用","reason"=>$a));
            if($date_week==6 & intval($ontime_houre)>2) $this->ajaxReturn(array("state"=>-4,"msg"=>"当前日期不可用","reason"=>$a));
            if(intval($ontime_houre)<19 & intval($ontime_houre)>2) $this->ajaxReturn(array("state"=>-5,"msg"=>"当前时间不可用","reason"=>$a));


        }else if($a["datearea_state"]==3){
            if($date_week==1 | $date_week==2| $date_week==3| $date_week==4| $date_week==5){
                $this->ajaxReturn(array("state"=>-4,"msg"=>"当前日期不可用","reason"=>$a));
            }
            if(intval($ontime_houre)<13) $this->ajaxReturn(array("state"=>-5,"msg"=>"当前时间不可用","reason"=>$a));
            if(intval($ontime_houre)>19) $this->ajaxReturn(array("state"=>-5,"msg"=>"当前时间不可用","reason"=>$a));

        }else if($a["datearea_state"]==4){
            if($date_week==1 & intval($ontime_houre)>2) $this->ajaxReturn(array("state"=>-4,"msg"=>"当前日期不可用","reason"=>$a));
            if( $date_week==2| $date_week==3| $date_week==4| $date_week==5){
                $this->ajaxReturn(array("state"=>-4,"msg"=>"当前日期不可用","reason"=>$a));
            }
            if(intval($ontime_houre)<19 & intval($ontime_houre)>2) $this->ajaxReturn(array("state"=>-5,"msg"=>"当前时间不可用","reason"=>$a));
        }
		
//		if($a["state"]!=1){
//			$this->ajaxReturn(array("state"=>-2,"msg"=>"无效二维码"));
//		}
//
//		$ontime_houre=date("H",time());
//
//		$onday=strtotime(date("Y/m/d",time()));
//		$get_day=strtotime(date("Y/m/d",strtotime($a["date_day"])));
//		if($get_day<$onday){
//			$this->ajaxReturn(array("state"=>-3,"msg"=>"二维码已过期"));
//		}
//		if($onday==$get_day){
//			if($a["date_timeperiod"]==1 & intval($ontime_houre)>18 ){
//				$this->ajaxReturn(array("state"=>-3,"msg"=>"二维码已过期."));
//			}
//		}
//	$b=M("goods")->where("id='".$a["goods_id"]."'")->find();//房台套餐id
//		$c=M("goods")->where("id='".$b["ktv_tie_goods_id"]."'")->find();//套餐绑定商品id
//		$e=json_decode($c["ktv_kucun"],true);
//		foreach($e as $k=>$v){
//				if($k==3){//在线酒水仓柜
//					$e[$k]=$v-$b["ktv_tie_goods_num"];
//				}
//			}
//		$save01["ktv_kucun"]=json_encode($e);
//
//
//		$save["openid_ass"]=$_GET["openid"];
//		$save["state"]=5;
//		$save["time_done"]=time();
//
//		if(M("room_orderbooking")->where("program_id='".$_GET["program_id"]."'"."and num_code='".$_GET["num_code"]."'")->save($save)){
//			if($b["ison_tie_goods"]==1){
//				M("goods")->where("id='".$b["ktv_tie_goods_id"]."'")->save($save01);
//			}
//
//
//			$return_data=array("state"=>1,"msg"=>"使用成功");
//		}else{
//			$return_data=array("state"=>-1,"msg"=>"使用失败");
//		}
        $ass_info=M("assistant_add")->where("openid='".$_GET["openid"]."'")->find();
        $return_data=array("state"=>1,"msg"=>"验证成功","reason"=>$a,"ass_info"=>$ass_info);
		$this->ajaxReturn($return_data);
	}
	
	function order_ontime(){
		$a=M("room_orderbooking")->field("id")->where("state=2 and state_peisong=0 and  program_id='".$_GET["program_id"]."'")->count();
		
		$b=M("order_form")->field("id")->where("state=2 and  program_id='".$_GET["program_id"]."'")->count();
		
		$c=M("beer_save")->field("id")->where("state=2 and  program_id='".$_GET["program_id"]."'")->count();
		
		$z=array('room_orderbooking'=>$a,'order_form'=>$b,'beer_save'=>$c);
		$this->ajaxReturn($z);
	}
	//实时订单列表
	function order_ing_room(){

    	$a=M("room_orderbooking")->where("state=2 and state_peisong=0 and   program_id='".$_GET["program_id"]."'")->order("time_pay desc")->select();

		for($i=0;$i<count($a);$i++){
			$b[$i]=M("goods")->field("image,goods_title,ktv_tie_goods_id,ktv_tie_goods_num")->where("id='".$a[$i]["goods_id"]."'")->find();

			$temp[$i]=explode(",",$b[$i]["image"]);
			$b[$i]["image"]=$temp[$i][0];
			$a[$i]["goods_info"]=$b[$i];

			$a[$i]["time_pay"]=date("Y-m-d H:i:s",$a[$i]["time_pay"]);
            $a[$i]["time_used"]=date("Y-m-d H:i:s",$a[$i]["time_used"]);

            $c[$i]=M("goods")->field("goods_title")->where("id='".$b[$i]["ktv_tie_goods_id"]."'")->find();//套餐绑定商品id

            $a[$i]["tie_goods_title"]=$c[$i]["goods_title"];
            $a[$i]["tie_goods_num"]=$b[$i]["ktv_tie_goods_num"];
		}

		$this->ajaxReturn($a);
	}
	
	function order_ing_qujiu(){
		$a=M("beer_save")->where("state=2 and  program_id='".$_GET["program_id"]."'")->order("time_getregiste desc")->select();
		
		for($i=0;$i<count($a);$i++){
			$b[$i]=M("goods")->field("image,goods_title")->where("id='".$a[$i]["goods_id"]."'")->find();
			
			$temp[$i]=explode(",",$b[$i]["image"]);
			$b[$i]["image"]=$temp[$i][0];
			$a[$i]["goods_info"]=$b[$i];
			
			$a[$i]["time_getregiste"]=date("Y-m-d H:i:s",$a[$i]["time_getregiste"]);
		}
		$this->ajaxReturn($a);
	}

	function order_ing_jiushui(){
		$a=M("order_form")->where("state=2 and  program_id='".$_GET["program_id"]."'")->order("time_fukuan desc")->select();
		
		for($i=0;$i<count($a);$i++){
				
			$a[$i]["time_fukuan"]=date("Y-m-d H:i:s",$a[$i]["time_fukuan"]);
			
			
			$a[$i]["goods_info"]=$this->getgoods_info($array_id=$a[$i]["array_id"]);
		}
		$this->ajaxReturn($a);
	}
	
	function chaifen($source){ return explode(',',$source); }
	
	
	function getgoods_info($array_id){
		$chaifen=$this->chaifen($array_id);
		array_pop($chaifen);
		for($p=0;$p<count($chaifen);$p++){
			$a[$p]=M("order")->field("goods_id,buy_num")->where("id='".$chaifen[$p]."'")->find();
			
			$b[$p]=M("goods")->field('id,goods_title,price_sell')->where("id='".$a[$p]["goods_id"]."'")->find();
			$b[$p]["buy_num"]=$a[$p]["buy_num"];
			
		}
		return $b;
	}
	function order_list_jiushui(){
		
		if($_GET["state"]==0){
			$where["state"]=2;
		}else{
			$where["state"]=7;
		}
		
		$where["program_id"]=$_GET["program_id"];
		$where["openid"]=$_GET["openid"];
		$a=M("order_form")->where($where)->order("time_fukuan desc")->select();

		for($i=0;$i<count($a);$i++){
				
			$a[$i]["time_fukuan"]=date("Y-m-d H:i:s",$a[$i]["time_fukuan"]);

			$a[$i]["goods_info"]=$this->getgoods_info($array_id=$a[$i]["array_id"]);
		}
		$this->ajaxReturn($a);
	}
	function vip_list(){
		$a=M("member_level")->where(" state=1 and program_id='".$_GET["program_id"]."'")->order("member_level asc")->select();
	
		$b=M("members")->field("head,nickname,vip_card_id")->where("program_id='".$_GET["program_id"]."'"." and openid='".$_GET["openid"]."'")->find();

		$z=array("vip_info"=>$a,"man_info"=>$b);
		$this->ajaxReturn($z);
	}
	function vip_content(){
		$a=M("member_level")->where("id='".$_GET["id"]."'")->find();
		$this->ajaxReturn($a);
	}
//	生政订单号
	function order_submin_vip(){
		
		$add["order_num"]="JT".date("YmdHis",time()).rand(111111,999999);
		$add["state"]=0;
		
		$add["program_id"]			=$_POST["program_id"];
		$add["openid"]				=$_POST["openid"];

		$add["vip_id"]				=$_POST["vip_id"];
	
		$add["price"]				=$_POST["price"];
		$add["time_build"]			=time();

		if(M("vip_order")->add($add)){
			
			$data=array("state"=>1,"msg"=>"操作成功","order_num"=>$add["order_num"]);
		}else{
			$data=array("state"=>-1,"msg"=>"操作失败");
		}
		
		$this->ajaxReturn($data);
	}
	//ktv房间续钟

    function order_submin_room_xz(){
        $a=M('room_orderbooking')->where("order_num='".$_POST["order_num_room_order"]."'")->find();
        $shengyu=$a["time_done"]-time();

        if($shengyu>3600){
            $a["can_xuzhong"]=1;
            $a["can_xuzhong_houre"]=intval($shengyu/3600);
        }else{
            $a["can_xuzhong"]=0;
            $a["can_xuzhong_houre"]=0;
        }
        if($a["can_xuzhong"]==0){

            $this->ajaxReturn(array("state"=>-2,"msg"=>"套餐续钟无时间不"));
        }
        $add["order_num"]="JT".date("YmdHis",time()).rand(111111,999999);
        $add["state"]=0;

        $add["program_id"]			=$_POST["program_id"];
        $add["openid"]				=$_POST["openid"];

        $add["goods_id"]			=$_POST["goods_id"];
        $add["xuzhong_houre"]		=$_POST["xuzhong_houre"];
        $add["per_price"]			=$_POST["per_price"];
        $add["order_num_room_order"]=$_POST["order_num_room_order"];

        $add["time_build"]			=time();

        if(M("room_xz_order")->add($add)){

            $data=array("state"=>1,"msg"=>"操作成功","order_num"=>$add["order_num"]);
        }else{
            $data=array("state"=>-1,"msg"=>"操作失败");
        }

        $this->ajaxReturn($data);
    }
	//	生政订单号
	function order_submin_artical(){
		
		$add["order_num"]="JT".date("YmdHis",time()).rand(111111,999999);
		$add["state"]=0;
		
		$add["program_id"]			=$_POST["program_id"];
		$add["openid"]				=$_POST["openid"];

		$add["artical_id"]				=$_POST["artical_id"];
	
		$add["price"]				=$_POST["price"];
		$add["time_build"]			=time();
		
		if(M("artical_order")->add($add)){
			
			$data=array("state"=>1,"msg"=>"操作成功","order_num"=>$add["order_num"]);
		}else{
			$data=array("state"=>-1,"msg"=>"操作失败");
		}
		
		$this->ajaxReturn($data);
	}
	function video_list(){
		$a=M("video")->where("program_id='".$_GET["program_id"]."'")->order("sort")->select();
		$this->ajaxReturn($a);
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
    function account_registe(){
    //珠宝		百业
		if(empty($_POST["program_id"]) | empty($_POST["openid"])){
			$this->ajaxReturn(array('state'=>-999,'msg'=>'参数错误 '));
		}
		$date["program_id"]=$_POST["program_id"];
		$date["openid"]=$_POST["openid"];
		
		$date["address"]=$_POST["address"];
		$date["tel"]=$_POST["phone"];
		$date["idcard"]=$_POST["idcard"];
		$date["name"]=$_POST["name"];
		$date["psw"]=md5($_POST["psw"]);
		$date["registe_time"]=time();

		$where["program_id"]=$_POST["program_id"];
		$where["openid"]=$_POST["openid"];

		$a=M("account")->where($where)->find();
		if(!empty($a)){
			$data="3";//存数据失败
			$this->ajaxReturn($data);
		}
		if(M("account")->add($date)){
			
			$a=M("member_level")->where("member_level=2 and program_id='".$_POST["program_id"]."'")->find();
			
			$save["level_id"]=$a["id"];
			M("members")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'")->save($save);
			$data="1";//存数据成功
		}else{
			$data="2";//存数据失败
		}
		
		$this->ajaxReturn($data);
    }
    
  function account_load(){
    //珠宝		
		if(empty($_POST["program_id"]) | empty($_POST["openid"])){
			$this->ajaxReturn(array('state'=>-999,'msg'=>'参数错误 '));
		}
		$date["program_id"]=$_POST["program_id"];
		$date["openid"]=$_POST["openid"];		
		$date["tel"]=$_POST["phone"];
		
		$a=M("account")->where($date)->find();
	
		if(empty($a)){
			$data="-1";//登录失败
			$this->ajaxReturn($data);
		}
		if($a["psw"]==md5($_POST["psw"])){
			$data="1";//允许登录
		}else{
			$data="-1";//登录失败
		}
		
		$this->ajaxReturn($data);
    }
    
    function fenlei(){
    	$e=M("goods")->field('id,sort,goods_video,image,goods_title,sell_num,goods_shorttitle,good_attribute,price_sell,is_use_consumption_num,price_own,goods_subtitle,goods_subtitle01,goods_subtitle02,goods_subtitle03,goods_subtitle04,goods_subtitle05')->where("goods_state=1  and program_id='".$_GET["program_id"]."'" )->order("sort")->select();//商品图片标题
		
		for($i=0;$i<count($e);$i++){
	
			$arr1102=explode(",",$e[$i]['image']);
			$e[$i]["image_first"]=$arr1102[0];
	
			if($e[$i]["goods_subtitle01"]==1) $f["f1"][$i]=$e[$i];//分组1、热卖
		}
		$f["f1"]=$this->arr_0_order($f["f1"]);
		
		$attribute=M("attribute")->field("id,title,title_english,image_1,is_index_recommend")->where("attribute_style=1 and uid=0 and is_show=1 and program_id='".$_GET["program_id"]."'")->order("sort")->select();
		$d=array('k4'=>$f,'attribute'=>$attribute);
    
    	$this->ajaxReturn($d);
    }
    
//  珠宝商品收藏
	function order_shoucang(){
		  // deal_state 1: 买、2：卖
  		  // goods_id 1: 黄金、2：白银
		$add["program_id"]=$_POST["program_id"];
		$add["openid"]=$_POST["openid"];
		$add["goods_id"]=$_POST["goods_id"];
		$add["deal_state"]=$_POST["deal_state"];
		$add["num"]=$_POST["num"];
		$add["onprice"]=$_POST["onprice"];
		$add["order_state"]=0;
		$add["time_set"]=time();
		$add["order_num"]="JT".time().rand(1111,9999);
		
		$a=M("account")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'"."and tel='".$_POST["phone"]."'")->find();
		
		if(empty($a)){
			$this->ajaxReturn(array("state"=>-1,"msg"=>"账号不存在"));
		}
		if(md5($_POST["psw"])!=$a["psw"]){
			$this->ajaxReturn(array("state"=>-1,"msg"=>"密码错误"));
		}
		
		if($_POST["deal_state"]==2){
			$b=M("members")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'")->find();
			if($_POST["goods_id"]==1){
				$num_shoucang=$b["gold_shoucang"];
			}else if($_POST["goods_id"]==2){
				$num_shoucang=$b["silver_shoucang"];
			}
			
			
			if($num_shoucang<$_POST["num"]){
				$this->ajaxReturn(array("state"=>-1,"msg"=>"数量不足"));
			}
			$add["order_state"]=3;
			
			M("members")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'")->setInc("shouyi",$_POST["num"]*$_POST["onprice"]);
			if($_POST["goods_id"]==1){
				M("members")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'")->setInc("gold_shoucang",-$_POST["num"]);
			}else if($_POST["goods_id"]==2){
				M("members")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'")->setInc("silver_shoucang",$_POST["num"]);
			}
		}
		
		$only_num="JT".time().rand(11111,99999);
		$add["only_num"]=$only_num;
		if(M("record_shoucang")->add($add)){
	
			$data=array("state"=>1,"msg"=>"操作成功","order_num"=>$add["order_num"]);
		}else{
			$data=array("state"=>-1,"msg"=>"操作失败");
		}
		$this->ajaxReturn($data);
	}
	function shouyi(){ 
		$b=M("members")->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();

		$c=M("member_level")->where("id='".$b["level_id"]."'")->find();
		
		$b["lever_info"]=$c;
		
		$b["order_info"]=0;

		$this->ajaxReturn($b);
	}

	function rebate_info(){
		
		$a=M("rebate_record")->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->select();
		
		for($i=0;$i<count($a);$i++){
			$b[$i]=M("rebate")->where("id='".$a[$i]["rebate_id"]."'")->find();
			
			$a[$i]["rebate_info"]=$b[$i];
			
			if($a[$i]["time_get"]) $a[$i]["time_get"]=date("Y-m-d H:i:s",$a[$i]["time_get"]);
			if($a[$i]["time_over"]) $a[$i]["time_over"]=date("Y-m-d H:i:s",$a[$i]["time_over"]);
			if($a[$i]["time_use"]) $a[$i]["time_use"]=date("Y-m-d H:i:s",$a[$i]["time_use"]);
		}
		
		$this->ajaxReturn($a);
	}
	function mam_money_list(){
		
		$a=M("record_tuijian")->where("program_id='".$_GET["program_id"]."'"."and openid_up='".$_GET["openid"]."'")->order("time_register desc")->select();
	
		for($i=0;$i<count($a);$i++){
			$b[$i]=M("members")->where("program_id='".$_GET["program_id"]."'"."and openid='".$a["openid_dump"]."'")->find();
			
			$a[$i]["dump_info"]=$b[$i];
			if($a[$i]["time_register"]) $a[$i]["time_register"]=date("Y/m/d ",$a[$i]["time_register"]);
			if($a[$i]["time_pay"]) $a[$i]["time_pay"]=date("Y/m/d ",$a[$i]["time_pay"]);
		}
		$this->ajaxReturn($a);
	}
	//佣金体现申请
	function tixian_man_money(){

		$info=M("members")->where("openid='".$_POST["openid"]."'"." and program_id='".$_POST["program_id"]."'")->find();

		//必须要有openid 和小程序id 
		if(!empty($_POST["openid"]) | !empty($_POST["program_id"])){
		
			//总佣金    =打款佣金	+打款审核佣金+可体现佣金   number_format() 函数通过千位分组来格式化数字

			$info["can_tixian"]=intval($info["man_money"]);	
	
			

		if(intval($info["money_01"])>intval($info["man_money"])){
			$data=array("status"=>-2,"msg"=>"提现金额有误");
		}else{
				$date["openid"]=$_POST["openid"];
				$date["program_id"]=$_POST["program_id"];	
				$date["order_num"]="JT".date("YmdHis",time()).rand(111111,999999);				
				$date["time_set"]=time();	
				$date["tx_state"]=3;	
				$date["money_01"]=$_POST["money_01"];	
				if(M("fx_tixian")->add($date)){
					
					M("members")->where("openid='".$_POST["openid"]."'"."and program_id='".$_POST["program_id"]."'")->setInc('man_money_tx_ing',intval($_POST["money_01"]));
					M("members")->where("openid='".$_POST["openid"]."'"."and program_id='".$_POST["program_id"]."'")->setInc('man_money',-intval($_POST["money_01"]));					
					
					$data=array("status"=>1,"msg"=>"申请成功");
				}else{
					$data=array("status"=>2,"msg"=>"申请失败");
				}
			}
			
			
		}else{
			$data=array("status"=>-1,"msg"=>"基本信息丢失");
		}	
		
		$this->ajaxReturn($data);
	}
	
}
?>