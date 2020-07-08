<?php
namespace Program\Controller;
use Think\Controller;
header('content-type:application:json;charset=utf8'); 
header('Access-Control-Allow-Origin:*'); 
//header('Access-Control-Allow-Methods:POST'); 
header('Access-Control-Allow-Headers:x-requested-with,content-type');
class DfxController extends Controller {



/*
 * fx_state 分销商等级:默认为0（0：不是分销商、1：审核中、2：正式分销商、3：禁用）
 * 需要openid、program_id、from_id
 * 必须判断这个人是不是分销商，如果是分销商了就不需要再判断添加分销信息   
 * */

function is_show_register(){
		$members1019=M("members")->field("id,head,nickname,fx_state")->where("openid='".$_POST["openid"]."'"." and program_id='".$_POST["program_id"]."'")->find();
		
		if($members1019["fx_state"]==0){
			//不是分销商  打开申请页面
			if($_POST["from_id"]==0){
				$msg02="上级:总店";
				$msg03="总店";
			}else{
				$members_sj=M("members")->where("id='".$_POST["from_id"]."'"." and program_id='".$_POST["program_id"]."'")->find();
				$msg02="上级:".$members_sj["nickname"];
				$msg03=$members_sj["nickname"];
			}
			
			$data=array("status"=>1,"msg"=>"不是分销商","msg02"=>$msg02,"msg03"=>$msg03,"nickname"=>$members1019["nickname"],"head"=>$members1019["head"]);
			
		}else if($members1019["fx_state"]==1){
			//审核中 提示待审
			$data=array("status"=>2,"msg"=>"审核中");
			
		}else if($members1019["fx_state"]==2){
			//正式分销商
			$data=array("status"=>3,"msg"=>"正式分销商");
			
		}else if($members1019["fx_state"]==3){
			//禁用
			$data=array("status"=>4,"msg"=>"禁用");
			
		}
		$data["have_nickname"]=$members1019["nickname"];
	  $this->ajaxReturn($data);	
}

	/*
	 * 手机端申请分销资格
	 * 申请之前判断设个小程序分销系统的人是不是需要完善资料 -----0927...17.11 暂时不管资料问题
	 * */
	public function register(){

		$fx_info=M("fx_info")->where("program_id='".$_POST["program_id"]."'")->find();
		if($_POST["program_id"]=="JT201803151807521312"){
			//禾之稻  分销等级是无关联多分销佣金比例方式
			if($_POST["fx_source"]==2){
				//没付钱的
				$fx_lever["id"]="51";
			}else{
				$fx_lever["id"]="50";
			}
			
		}else{
			$fx_lever=M("fx_lever")->where("cannot_d=1 and program_id='".$_POST["program_id"]."'")->find();      
		}

		if($_POST["fx_source"]==2){
			$_POST["from_id"]=0;
		}
		//需要得到小程序id，openid、页面分销来源 from_id(0:总店、其他的就是已经是分销商的id)	
		$fx_state["fx_state"]	="1";//分销身份审核中
		$fx_state["fx_lever_id"]=$fx_lever["id"];   //分销等级
			
		if($_POST["from_id"]=="0"){
			$fx_state["fx_uid"]="0";					//分销上级
			
//			($_POST["fx_source"]==2)?$fx_state["fx_source"]=$_POST["fx_source"]:1;	
			if($_POST["fx_source"]==2){
				$fx_state["fx_source"]=$_POST["fx_source"];
			}else{
				$fx_state["fx_source"]="1";
			}
			if($_POST["program_id"]=="JT201712021113483120"){	
				$fx_state["daili_uid_csys"]="0";	
			}
		}else{

			$fx_state["fx_uid"]=$_POST["from_id"];
			
			if(empty($_POST["fx_source"])){
				$fx_state["fx_source"]="1"; 
			}
			if($_POST["program_id"]=="JT201712021113483120"){
				$fx_state["daili_uid_csys"]=$_POST["from_id"];
			}
		}
		$fx_state["fx_time_registe"]=time();
	
		if(M("members")->where("openid='".$_POST["openid"]."'"." and program_id='".$_POST["program_id"]."'")->save($fx_state)){
			if($fx_info["fenx_condition2"]==2){
				//分销不需要审核是
				$agree["fx_state"]="2";
				$agree["fx_time_agree"]=time();
				M("members")->where("openid='".$_POST["openid"]."'"." and program_id='".$_POST["program_id"]."'")->save($agree);
				
				$add04["program_id"]=$_POST["program_id"];
				$add04["openid"]=$_POST["openid"];
				$add04["time_registe"]=time();
				$add04["time_agree"]=time();
				$add04["registe_state"]="1";
				M("fx_register")->add($add04);
			}
			$data=array("status"=>1,"msg"=>"申请成功");
			//判断该小程序的分销流程需不需要审核，不审核直接通过
			
		}else{
			$data=array("status"=>2,"msg"=>"申请失败");
		}
        $this->ajaxReturn($data);
	}
	//需要提交文本的分销申请   禾之稻公益天使
	function fx_registe_text(){

		if(empty($_POST["program_id"]) | empty($_POST["program_id"])){
			$data=array("status"=>-999,"msg"=>"参数缺失");
		}
		
		
		$add=$_POST;

		$add["schooling_record_id"]=$_POST["picked_id"];
		$add["time_registe"]=time();
		$add["registe_state"]="1";
	
		
		if(M("fx_register")->add($add)){
			$data=array("status"=>1,"msg"=>"提交成功");
		}else{
			$data=array("status"=>-1,"msg"=>"提交失败");
		}
		   $this->ajaxReturn($data);
	}
	//禾之稻资料提交接口
	function registr_info(){
		if(empty($_POST["program_id"]) | empty($_POST["program_id"])){
			$data=array("status"=>-999,"msg"=>"参数缺失");
		}
		$save=$_POST;

		$save["realname"]=$_POST["realname"];
		$save["tel"]=$_POST["tel"];
$save["fx_info_up"]=1;
		
		if(M("members")->where("openid='".$_POST["openid"]."'"."and program_id='".$_POST["program_id"]."'")->save($save)){
			$data=array("status"=>1,"msg"=>"提交成功");
		}else{
			$data=array("status"=>-1,"msg"=>"提交失败");
		}
		   $this->ajaxReturn($data);
	}
	
	function check_fx_registe(){
		
		
		if(empty($_GET["program_id"]) | empty($_GET["program_id"])){
			$data=array("status"=>-999,"msg"=>"参数缺失");
		}
		$a=M("fx_register")->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();
		
		if(empty($a)){
			$data=array("status"=>3,"msg"=>"未提交");
		}else{
			if($a["registe_state"]==0) $data=array("status"=>0,"msg"=>"等待审核");
			if($a["registe_state"]==1) $data=array("status"=>1,"msg"=>"审核通过");
			if($a["registe_state"]==2) $data=array("status"=>2,"msg"=>"审核拒绝");
		}
		
		 $this->ajaxReturn($data);
	}
	
	//分销商个人中心
	function fx_index(){
		//需要小程序id，openid

		$field='
		members.id as members_id,members.openid as members_openid,members.fx_uid,members.fx_lever_id,members.vip_id,members.fx_yongjin_dakuan,members.fx_source,
		members.fx_yongjin_leiji,members.fx_yongjin_tx_ing,
		members.head,members.nickname,
		
		fx_lever.title as fx_lever_title,
		
		fx_lever_independent.lever_title as fx_lever_independent_title
  
		';
		$info=M("members")
		->field($field)	
		->join('left join fx_lever ON fx_lever.id=members.fx_lever_id')
		->join('left join fx_lever_independent ON fx_lever_independent.id=members.vip_id')
		->where("members.openid='".$_GET["openid"]."'"." and members.program_id='".$_GET["program_id"]."'")
		->find();

		//总佣金    =打款佣金	+打款审核佣金+可体现佣金
		$info["can_tixian"]=number_format($info["fx_yongjin_leiji"]-$info["fx_yongjin_dakuan"]-$info["fx_yongjin_tx_ing"],2);;
		
		
		 if($info["fx_uid"]!=0){
		 		$a=M("members")->where("id='".$info["fx_uid"]."'")->find();
				$info["up_name"]=$a["nickname"];//上级昵称
		 }else{
		 		$info["up_name"]="总店 ";//上级昵称
		 }
		 
		 
		//分销下级人数  （三级）
		$all_m=M("members")->where("program_id='".$_GET["program_id"]."'")->select();

		$sum=$this->getTree($all_m,$info['members_id'],3);//下线人数


		//体现条数
	
		$fx_tixiam=M("fx_tixian")->where("openid='".$_GET["openid"]."'"."and program_id='".$_GET["program_id"]."'")->select();
		
		$tixian=count($fx_tixiam);
		//分销订单条数
		
			//一级下线 
		$all=M("members")->where("program_id='".$_GET["program_id"]."'")->select();
		$b=$this->test($all,$info["members_id"],3);
	
		$b.=$info["members_id"];//如果开启内购，就不用去掉最后的逗号，就加上本身的id
		
		 $list01=$this->get_orderlist($b);
		 $fenxiao=count($list01);
	
	
		//分销指定商品开启分销入口
		$fx_goods=M("goods")->field('id,goods_title')->where("program_id='".$_GET["program_id"]."'"."and goods_state =1 and fx_entrance=1")->select();
	
		$z=array('k1'=>$info,'k2'=>$sum,'k3'=>$tixian,'k4'=>$fenxiao,'fx_goods'=>$fx_goods);
		//dump($z);die;
		$this->ajaxReturn($z);
		
		//$info =分销个人信息    $sum=销下级人数    $fenxiao分销订单条数
		
	}
	//分销订单    三级分销商以内
	function fx_order(){
		//得到小程序id ，个人 openid， 订单状态 $_GET["state"]  全部：留空、交易状态(1：待付款、2：待发货、3：待收货、4：待评价、5：退换/售后、6：已关闭、7：已完成
		$members=M("members")->where("openid='".$_GET["openid"]."'"." and program_id='".$_GET["program_id"]."'")->find();

		$all=M("members")->where("program_id='".$_GET["program_id"]."'")->select();
		$b=$this->test($all,$members["id"],3);
		//$b = substr($b,0,strlen($b)-1); //去掉最后一个逗号

		$b.=$members["id"];//如果开启内购，就不用去掉最后的逗号，就加上本身的id

		
		if($_GET["state"]==0){
			$_GET["state"]=null;
		}
		 $list=$this->get_orderlist($b,$_GET["state"]);
		 for($i=0;$i<count($list);$i++){
			if($list[$i]["state"]==1){
				$list[$i]["state_text"]="待付款";
			}else if($list[$i]["state"]==2){
				$list[$i]["state_text"]="待发货";
			}else if($list[$i]["state"]==3){
				$list[$i]["state_text"]="待收货";
			}else if($list[$i]["state"]==4){
				$list[$i]["state_text"]="待评价";
			}else if($list[$i]["state"]==5){
				$list[$i]["state_text"]="退换/售后";
			}else if($list[$i]["state"]==6){
				$list[$i]["state_text"]="已关闭";
			}else if($list[$i]["state"]==7){
				$list[$i]["state_text"]="已完成";
			}
		}

	$this->ajaxReturn($list);
	//	dump($list);die;
	}
    function fx_order_ktv(){
          $members=M("members")->where("openid='".$_GET["openid"]."'"." and program_id='".$_GET["program_id"]."'")->find();

        $all=M("members")->where("program_id='".$_GET["program_id"]."'")->select();
        $b=$this->test($all,$members["id"],3);
        //$b = substr($b,0,strlen($b)-1); //去掉最后一个逗号

        $b.=$members["id"];//如果开启内购，就不用去掉最后的逗号，就加上本身的id


        if($_GET["state"]==0){
            $_GET["state"]=null;
        }
        $list=$this->get_orderlist($b,$_GET["state"]);
        for($i=0;$i<count($list);$i++){
            if($list[$i]["state"]==1){
                $list[$i]["state_text"]="待付款";
            }else if($list[$i]["state"]==2){
                $list[$i]["state_text"]="待发货";
            }else if($list[$i]["state"]==3){
                $list[$i]["state_text"]="待收货";
            }else if($list[$i]["state"]==4){
                $list[$i]["state_text"]="待评价";
            }else if($list[$i]["state"]==5){
                $list[$i]["state_text"]="退换/售后";
            }else if($list[$i]["state"]==6){
                $list[$i]["state_text"]="已关闭";
            }else if($list[$i]["state"]==7){
                $list[$i]["state_text"]="已完成";
            }
        }

        $this->ajaxReturn($list);
        //	dump($list);die;
    }

    //分销佣金详情
	function fenxiao_yj(){
		//需要小程序id 和openid 
		
		$fenxiao_yj=M("members")->field('fx_yongjin_leiji,fx_yongjin_dakuan,fx_yongjin_tx_ing')->where("openid='".$_GET["openid"]."'"."and program_id='".$_GET["program_id"]."'")->find();
	
	
		//可提现佣金
		$fenxiao_yj["can_tixian"]=number_format($info["fx_yongjin_leiji"]-$info["fx_yongjin_dakuan"]-$info["fx_yongjin_tx_ing"],2);
	
		$this->ajaxReturn($fenxiao_yj);
	}
	
	//佣金体现申请
	function tixian(){
		//查看这个人的可提现佣金是多少  是
		
	//	$this->ajaxReturn($_POST);
		$info=M("members")->where("openid='".$_POST["openid"]."'"." and program_id='".$_POST["program_id"]."'")->find();

		//必须要有openid 和小程序id 
		if(!empty($_POST["openid"]) | !empty($_POST["program_id"])){
		
			//总佣金    =打款佣金	+打款审核佣金+可体现佣金   number_format() 函数通过千位分组来格式化数字
		if($_POST["state"]=="members_zhubao"){
			//会员佣金提现
			$info["can_tixian"]=intval($info["shouyi"]);	
		}else{
			$info["can_tixian"]=intval($info["fx_yongjin_leiji"]-$info["fx_yongjin_dakuan"]-$info["fx_yongjin_tx_ing"]);
		}
			

		if(intval($info["money_01"])>intval($info["shouyi"])){
			$data=array("status"=>-2,"msg"=>"提现金额有误");
		}else{
				$date["openid"]=$_POST["openid"];
				$date["program_id"]=$_POST["program_id"];	
				$date["order_num"]="JT".date("YmdHis",time()).rand(111111,999999);				
				$date["time_set"]=time();	
				if($_POST["state"]=="members_zhubao"){
					$date["tx_state"]=2;	
				}else{
					$date["tx_state"]=1;	
				}
				
				
				$date["money_01"]=$_POST["money_01"];
				if(M("fx_tixian")->add($date)){
					
					//佣金提现冻结
					if($_POST["state"]=="members_zhubao"){
						M("members")->where("openid='".$_POST["openid"]."'"."and program_id='".$_POST["program_id"]."'")->setInc('shouyi_tx_ing',intval($_POST["money_01"]));
						M("members")->where("openid='".$_POST["openid"]."'"."and program_id='".$_POST["program_id"]."'")->setInc('shouyi',-intval($_POST["money_01"]));					
					}else{
						M("members")->where("openid='".$_POST["openid"]."'"."and program_id='".$_POST["program_id"]."'")->setInc('fx_yongjin_tx_ing',intval($_POST["money_01"]));
					}
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
	
	//提现记录
	function tixian_record(){
		if(empty($_GET["openid"]) | empty($_GET["program_id"])){
			
			$data=array("status"=>-1,"msg"=>"基本信息丢失");
			
		}else{
			
			$where["program_id"]=$_GET["program_id"];
			$where["openid"]=$_GET["openid"];
			if($_GET["tx_state"]){
				$where["tx_state"]=$_GET["tx_state"];
			}
			
			$fx_tixian=M("fx_tixian")->where($where)->select();
			
			$members=M("members")->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();
			
			$data["can_tixian"]=number_format($members["fx_yongjin_leiji"]-$members["fx_yongjin_dakuan"]-$members["fx_yongjin_tx_ing"],2);
			if($_GET["tx_state"]==3){
				$data["can_tixian"]=number_format($members["man_money"],2);
			}else{
				$data["can_tixian"]=number_format($members["fx_yongjin_leiji"]-$members["fx_yongjin_dakuan"]-$members["fx_yongjin_tx_ing"],2);
			}
			
			$data["fx_tixian"]=$fx_tixian;
			$data["status"]=1;
			
			
		}
		
		$this->ajaxReturn($data);
	}
		//提现记录
	function tixian_record_2(){
		if(empty($_GET["openid"]) | empty($_GET["program_id"])){
			
			$data=array("status"=>-1,"msg"=>"基本信息丢失");
			
		}else{
			$fx_tixian=M("fx_tixian")->where("state =2 and program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->select();
			
			$members=M("members")->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();
			
			$data["can_tixian"]=number_format($members["fx_yongjin_leiji"]-$members["fx_yongjin_dakuan"]-$members["fx_yongjin_tx_ing"],2);
			
			$data["fx_tixian"]=$fx_tixian;
			$data["status"]=1;
			
			
		}
		
		$this->ajaxReturn($data);
	}
	//我的下线
	function offline(){
		$members=M("members")->where("openid='".$_GET["openid"]."'"."and program_id='".$_GET["program_id"]."'")->find();
		//只需要找到他的一级下线
		$all=M("members")
		->where("program_id='".$_GET["program_id"]."'")->select();
		

			$b1=$this->test02($all,$members["id"],1);// 一级id组 
				$b1 = substr($b1,0,strlen($b1)-1); 
			$b2=$this->test02($all,$members["id"],2);// 二级id组 
				$b2 = substr($b2,0,strlen($b2)-1); 	
			$b3=$this->test02($all,$members["id"],3);// 三级id组 
				$b3 = substr($b3,0,strlen($b3)-1); 
	
		//dump($b1);die;		
		//纯 一级 字符串
		$c1= explode(",", $b1); 
		
		//纯 二级 字符串
		$c2=explode(",", $b2); 
		
		//纯 三级 字符串
		$c3=explode(",", $b3); 
	
		for($p1=count($c1);$p1<count($c2);$p1++){
			$d1[]=$c2[$p1];
		}
		for($p2=count($c2);$p2<count($c3);$p2++){
			$d2[]=$c3[$p2];
		}
		
		$yiji_str=$b1;
		$erji=implode("," , $d1); 
		$sanji=implode("," , $d2); 
		
		
		$field='id,head,nickname,fx_time_agree,openid';
		//一级下级信息	
		if(!empty($yiji_str)){
			$where01["id"]=array('in',$yiji_str);
			$arr_yiji=M("members")->field($field)->where($where01)->select();
		
			$arr_yiji=$this->count_order($arr_yiji,$program_id=$_GET["program_id"]);

		}else{
			$arr_yiji="无数据";
		}

		//2级下级信息
		if(!empty($erji)){
			$where02["id"]=array('in',$erji);
			$arr_erji=M("members")->field($field)->where($where02)->select();
		}else{
			$arr_erji="无数据";
		}
		
		
		//3级下级信息
		if(!empty($sanji)){
			$where03["id"]=array('in',$sanji);
			$arr_sanji=M("members")->field($field)->where($where03)->select();
		}else{
			$arr_sanji="无数据";
		}	
		
	
		$date=array('k1'=>$arr_yiji,'k2'=>$arr_erji,'k3'=>$arr_sanji);

		$this->ajaxReturn($date);
	}

	//统计个人的订单数和订单金额总数
	function count_order($arr_yiji,$program_id){
		for($i=0;$i<count($arr_yiji);$i++){
				$order_form[$i]=M("order_form")->where("program_id='".$program_id."'"."and openid='".$arr_yiji[$i]["openid"]."'")->select();	
				$order_form_count[$i]=count($order_form[$i]);
				$order_form_sum[$i]=0;
				
				foreach($order_form[$i] as $k=>$v){
					$order_form_sum[$i]+=$order_form[$i][$k]["buy_price"];
				}
				
				$arr_yiji[$i]["form_count"]=$order_form_count[$i];
				$arr_yiji[$i]["form_sum"]=$order_form_sum[$i];
			}
			return $arr_yiji;
	}
	
	
	//分销回调  指定下级		
	function test02($data,$uid,$n){
	if($n>0){
		$id_arr;
			for($i=0;$i<count($data);$i++){
				if($data[$i]['fx_uid']==$uid){
					//目标会员的上级分销id 等于默认的人的id
					$id_arr.=$data[$i]['id'].",";
				$id_arr.=$this->test($data,$data[$i]['id'],$n-1);
				}
			}	
		}
		return $id_arr;
		
	}
	
	
	//分销回调  得到全部的 下级		
	function test($data,$uid,$n){
	if($n>0){
		$id_arr;
			for($i=0;$i<count($data);$i++){
				if($data[$i]['fx_uid']==$uid){
					//目标会员的上级分销id 等于默认的人的id
					$id_arr.=$data[$i]['id'].",";
				$id_arr.=$this->test($data,$data[$i]['id'],$n-1);
				}
			}	
		}
		return $id_arr;
	}	

	function get_orderlist($b,$state){
        if($state!=''){
       		$where['order_form.state']=$state;
       	 	$whereall=array('state'=>$state,'program_id'=>$_GET["program_id"]);	
        }else{
        	$whereall=array('program_id'=>$_GET["program_id"]);
        }
       	$where['order_form.dfx_id']=array('in',$b);
    //    $where['order_form.state']="1";
		$where['order_form.program_id']=$_GET["program_id"];
		$field='order_form.id,order_form.order_num,order_form.array_id,order_form.time_build,order_form.state,order_form.buy_price,
		       order_form.dsh_id,order_form.dfx_id,order_form.dfx_price01,order_form.dfx_price02,order_form.dfx_price03,
		       
		       user_info_dsh.id as user_info_dsh_id,user_info_dsh.sh_name,
		       
		        members.nickname,members.tel,members.head
		        
		        ';
		$list=M('order_form')
		->group('order_form.id')
		->field($field)
		->join('members ON order_form.openid=members.openid')
		->join('left join user_info_dsh ON order_form.dsh_id=user_info_dsh.id')
		->where($where)
		->order("order_form.time_build desc")
		
		->select();
	
		$f='order.id,order.buy_num,order.order_num,
		goods.goods_title,goods.price_sell,
		goods_img.image';
		$where1['order.program_id']=$_GET["program_id"];
//		$where1['order.order_num']=array('neq',0);
		for($i=0;$i<count($list);$i++){
			$where1['_string']='order.id in('.substr($list[$i]['array_id'],0,strlen($list[$i]['array_id'])-1).')';
//			$where1['order.order_num']=$list[$i]['order_num'];
			$list[$i]['info']=M('order')
			->group('order.id')
			->field($f)
			->join('goods ON order.goods_id=goods.id')
			->join('goods_img ON order.goods_id=goods_img.goods_id')
//			->join('members ON order.cus_openid=members.openid')
			->where($where1)
			->select();
		}
		/*$list['sum']=M('order_form')
		->field('count(id) AS num,sum(buy_price) AS sum')
		->where($whereall)->find();*/

		return $list;

	}
	//递归
	function bq($arr,$p,$n){	
		$ar=array();
		if($n>0){
			foreach($arr as $v){ 
					if($v["fx_uid"]==$p){ 
						$v["child"]=$this->bq($arr,$v["members_id"],$n-1);
						$ar[]=$v;
					}
				}
		}
			 return $ar;
	}
	
	//分销统计
	function getTree($data,$pId,$n){
	//参数 ：数组、初始id、层级 
		if($n>0){
			$arr["sum"][$pId]=0;
			for($i=0;$i<count($data);$i++){
				if($data[$i]['fx_uid']==$pId){
					$arr["sum"][$pId]+=1;
					$arr["sum"][$pId]+=$this->getTree($data,$data[$i]['id'],$n-1);
					//$arr["sum"][$pId]=$arr["sum"][$pId]+$num;
				}
			}	
		}
		return $arr["sum"][$pId];
	}
	
	function fx_single(){
		//单独单商品分销
		
		//产生交易、判断交易人分销等级，判断是否有上级，（最多两级）
		//得到交易人一级上级，判断消费属于哪个代理等级，  根据两个条件组合得到一级上级应得佣金，二级上级的佣金
		
	}
	
	//获取个人基本信息（头像、昵称
	function getmembersinfo(){
		
		$where["program_id"]=$_GET["program_id"];
		if($_GET["state"]=="id"){
			$where["id"]=$_GET["id"];
		}else if($_GET["state"]=="openid"){
			$where["openid"]=$_GET["openid"];
		}
		$info=M("members")->field('nickname,head')->where($where)->find();
		
		$this->ajaxReturn($info);
	}
	
	//禾之稻   认购沙米编号
	function shami_get(){
		
		if(empty($_GET["program_id"]) | empty($_GET["openid"])){
			$this->ajaxReturn(array('status'=>-999,'msg'=>'参数缺失'));
		}
		
		if($_GET["shatian_state"]==1){
			$state="A";
		}else if($_GET["shatian_state"]==2){
			$state="B";
		}
	
		
		
		$a=M("serial_number")->where("openid=0 and is_used=0 and program_id='".$_GET["program_id"]."'"."and state='".$state."'")->find();//查找第一个用到的
		$b=M("serial_number")->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'"."and state='".$state."'")->find();//查看看有没有这个人的
	//	dump($a);dump($b);dump(M("serial_number")->_sql());die;

		$save["openid"]=$_GET["openid"];
		$save["is_used"]=1;
		$save["time_set"]=time();	
		
		if(empty($b)){
			if(M("serial_number")->where("id='".$a["id"]."'")->save($save)){
				
				$add["program_id"]=$_GET["program_id"];
				$add["openid"]=$_GET["openid"];
				$add["time_set"]=time();

				if($state=="A")$add["reward_id"]="1";
				if($state=="B")$add["reward_id"]="2";
				$add["serial_number"]=$a["serial_number"];				
				
				M("hzd_earnings")->add($add);
				
				$data=array("state"=>1,"msg"=>"领号成功","num"=>$a["serial_number"]);
			}else{
				$data=array("state"=>-1,"msg"=>"领号失败");
			}
		}else{
			$data=array("state"=>-99,"msg"=>"无法认领");
		}
		
		$this->ajaxReturn($data);
	}
	
	//禾之稻   我的收益，就是看个人的的沙田编号，然后就是买了五年之约还是十年之约
	
	function my_shouyi(){
	$a=	M("members")->field('fx_state,fx_source,tel')->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();
	
	$b=M("serial_number")->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();
	
	$c=M("hzd_earnings")->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();
	$d=M("hzd_reward")->where("id='".$c["reward_id"]."'")->find();
	$c["reward"]=$d;	
	$c["fx_source"]=$a["fx_source"];//分销来源（1：正常申请来的，2，使用指标来的
	
	$c["tel"]=$a["tel"];
	
	$this->ajaxReturn($c);	
		
		
	}
	
	//openid 换 个人id  用来当做 from_id  from_id
	
	function openid_from_id(){
		$a=M("members")->field("id")->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();
		if(!empty($a)){
			$date=array();
		}
		$this->ajaxReturn($a);
	}
	
	function send_mes(){
		
		$a=M("members")->where("program_id='".$_GET["program_id"]."'"."and id='".$_GET["from_id"]."'")->find();
		$b=M("store")->where("program_id='".$_GET["program_id"]."'")->find();
		
		
		$res = $this->ssg($phone=$a["tel"],$content="【".$b["program_title"]."】您有一位好友已经确定支持平台公益事业！您的米券已生成。");
		
	}
	
	   public function ssg($phone,$content){
	   	 $statusStr = array(
            "0" => "短信发送成功",
            "-1" => "参数不全",
            "-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
            "30" => "密码错误",
            "40" => "账号不存在",
            "41" => "余额不足",
            "42" => "帐户已过期",
            "43" => "IP地址限制",
            "50" => "内容含有敏感词"
    );
        $smsapi = "http://www.smsbao.com/"; //短信网关
        $user = "xzsjwj"; //短信平台帐号
        $pass = md5("xzsjwj888"); //短信平台密码
//		$content="短信内容";//要发送的短信内容
//		$phone = "*****";
        $sendurl = $smsapi."sms?u=".$user."&p=".$pass."&m=".$phone."&c=".urlencode($content);
        $result =file_get_contents($sendurl) ;
        return $statusStr[$result];
       }
       
       //展示证书
       function show_certificate(){
       			if(empty($_POST["program_id"]) | empty($_POST["openid"])){
			$this->ajaxReturn(array('status'=>-999,'msg'=>'参数缺失'));
		}
       	$where["program_id"]=$_POST["program_id"];
       	$where["openid"]=$_POST["openid"];

       	$a=M("hzd_earnings")->field('honor_image,honor_image_welfare')->where($where)->find();
       	
      	$this->ajaxReturn($a);
       }
//     兰倩美容教师分销申请
       function teacher_register(){
	       	$where["program_id"]=$_GET["program_id"];
	       	$where["openid"]	=$_GET["openid"];
	      
       	
       		$save["fx_state"]=1;
	       	$save["fx_time_registe"]=time();
	       	$save["fx_uid"]=$_GET["from_id"];;
	  
	       	$save["realname"]	=$_GET["name"];
	       	$save["tel"]		=$_GET["tel"];
	       	$save["fx_lever_id"]	="55";
	
       		if(M("members")->where($where)->save($save)){
       			$data=array("state"=>1,"msg"=>"申请成功");
       		}else{
       			$data=array("state"=>-1,"msg"=>"申请失败");
       		}
       		
       		$this->ajaxReturn($data);
       }
}
?>