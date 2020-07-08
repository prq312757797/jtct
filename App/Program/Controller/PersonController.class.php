<?php
namespace Program\Controller;
use Think\Controller;
use Think\DB;
header('content-type:application:json;charset=utf8'); 
header('Access-Control-Allow-Origin:*'); 
//header('Access-Control-Allow-Methods:POST'); 
header('Access-Control-Allow-Headers:x-requested-with,content-type');
header("Content-Type:text/html;CharSet=UTF-8");
class PersonController extends Controller {
     
     function test(){
     	$qianyue=M("qianyue")->where("program_id='".$_GET["program_id"]."'")->find();
          if($qianyue["muban_type"]==1) {
//这里是商城版需要的接口内容==========================================================================
         
          }else if($qianyue["muban_type"]==5){
//这里是资讯 版需要的接口内容==========================================================================
     		}
     		
     	$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =     3145728 ;// 设置附件上传大小
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath  =     './Uploads/'; // 设置附件上传根目录

		// 上传文件 
		$info   =   $upload->upload();	
     		if($info){
                  //  $receive['image']=$info['image']['savepath'].$info['image']['savename'];
          		  foreach($info as $k=>$v){
			    		if($info[$k]['key']=="image"){
			    			$date['image'].=$info[$k]['savepath'].$info[$k]['savename'].",";
			    		}else if($info[$k]['key']=="img"){
			    			$date['img'].=$info[$k]['savepath'].$info[$k]['savename'].",";
			    		}
						
					}
            $add["title"]="111111";
            $add["name"]=$date['image'];
            M("test")->add($add);
            }
     }
     /*
	  * 小程序前台个人中心页面信息展示
	  * 需求参数小程序ID  会员openid
	  * 提供参数   members会员头像head 会员昵称nickname  order代付款、代发货、待收货、待评价、退换/售后订单数
	  * 1待付款、2：待发货、3：待收货、4：待评价、5：退换/售后、6：已关闭、7：已完成：
	  * */

      public function person(){
      	$pid=I('program_id');
      		
      	$where['openid']=I('openid');
      	$where['program_id']=I('program_id');
      	$info=M('members')->field('head,nickname,tel')->where($where)->find();

      //如果有手机号的话，页面显示解绑手机号，如果没有，就是点击跳转到填写手机号绑定页面
      if(empty($info["tel"])){
      	$info["is_show_tire"]="1";//1：绑定手机点击会跳转
      }else{
      	$info["is_show_tire"]="2";//2：页面显示解绑手机，点击出发ajax 解绑函数 is_ktv_order_ing
      }	
      $members=M("members")->field("id,gold_shoucang,man_money,shouyi,rebate_state,silver_shoucang,is_ktv_manager,member_total_pay,is_ktv_assistant,is_ktv_order_ing,vip_id,integral,integral_song,level_id,is_mamager,openid,head,nickname")->where("openid='".$_GET["openid"]."'"." and program_id='".$_GET["program_id"]."'")->find();	
	  
	  $fx_lever_independent=M("fx_lever_independent")->where("id='".$members["vip_id"]."'")->find();
	  $members["vip_name"]=$fx_lever_independent["lever_title"];
	  $integral=$members["integral"]+$members["integral_song"];
//会员等级
	   $a1209 =M("member_level")->where("id='".$members["level_id"]."'")->find();
	   $member_lever=$a1209["member_level_name"];
	   $member_lever_l=$a1209["member_level"];
	   //是否是后台设定管理员
	   if($members["is_mamager"]==1){ $is_mamager="1"; }else{ $is_mamager="2"; }

//		判断是否服务员
		$assistant_add=M("assistant_add")->field("state")->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();
		if(empty($assistant_add)){
			$members["is_ktv_assistant"]=0;
		}else{
			if($assistant_add["state"]==1){
				$members["is_ktv_assistant"]=1;
			}else{
				$members["is_ktv_assistant"]=0;
			}
		}
		

       $qianyue=M("qianyue")->where("program_id='".$_GET["program_id"]."'")->find();
          if($qianyue["muban_type"]==1) {
//=====================================这里是商城版需要的接口内容==========================================
//================================================================================================
//================================================================================================
//对订单做统计
	        $dfk=0;//1	待付款
	      	$dfh=0;//2：待发货
	      	$dsh=0;//3：待收货
	      	$dpj=0;//4：待评价
	      	$thsh=0;//5：退换/售后
	      	$list=M('order_form')->field("id,state")->where(array('program_id'=>$pid,'openid'=>I('openid')))->select();
	     
	      	for($i=0;$i<count($list);$i++){
	      		switch($list[$i]['state']){
	      			case 1:$dfk=++$dfk;break;
	      			case 2:$dfh=++$dfh;break;
	      			case 3:$dsh=++$dsh;break;
	      			case 4:$dpj=++$dpj;break;
	      			case 5:$thsh=++$thsh;break;
	      			default:break;
	      		}
	      	}
	      	
//	      	家私维修
			if(I('program_id')=="JT201807211029526361"){
				$dcl_js=0;//0：待处理
		      	$dwc_js=0;//1：已完成
		      	$dqx_js=0;//2：已取消
		      	$list_js=M('booking')->field("id,state")->where(array('program_id'=>$pid,'openid'=>I('openid')))->select();	     
		    
		      	for($i_js=0;$i_js<count($list_js);$i_js++){
		      		switch($list_js[$i_js]['state']){
		      			case 0:$dcl_js=++$dcl_js;break;
		      			case 1:$dwc_js=++$dwc_js;break;
		      			case 2:$dqx_js=++$dqx_js;break;	
		      			default:break;
		      		}
		      	}
			}
//	      	百业联盟消费券
			if(I('program_id')=="JT201806151732369242"){
				$coupon_dsh_record=M("coupon_dsh_record")->field("id")->where("program_id='".I('program_id')."'"."and openid='".I('openid')."'")->find();
		      	if(!empty($coupon_dsh_record)){
		      		$haved_coupon=1;
		      	}else{
		      		$haved_coupon=0;
		      	}
		 
			}		

			$user_info_dsh=M("user_info_dsh")->where(array('program_id'=>$pid,'openid'=>I('openid')))->find();

			if(empty($user_info_dsh)){
				$dah=array('status'=>0,'msg'=>'未提交审核');
			}else{
				if($user_info_dsh["state"]==1){
					$dah=array('status'=>1,'msg'=>'待审');
				}else if($user_info_dsh["state"]==3){
					$dah=array('status'=>3,'msg'=>'审核通过');
				}else if($user_info_dsh["state"]==4){
					$dah=array('status'=>4,'msg'=>'审核拒绝');
				}	
			}
			$store180307=M("store")->field('phone_ask')->where("program_id='".$_GET["program_id"]."'")->find();
		
			if($_GET["program_id"]=="JT201806151732369242"){
				//百业联盟
				$sql_1="select count(id) from user_info_dsh where openid='".$_GET["openid"]."'"."or openid_manager='".$_GET["openid"]."'";			
				$is_manager = M("user_info_dsh") -> query($sql_1);
				
				$identity_manager	=0;
				$identity_assistant	=0;
				$identity_customer	=1;
				
				if($is_manager[0]["count(id)"]>0){
					$identity="manager";
					$identity_manager=1;
				}
		
				$sql_2="select count(id) from assistant_add where openid='".$_GET["openid"]."'";			
				$is_assistant = M("assistant_add") -> query($sql_2);
				if($is_assistant[0]["count(id)"]>0){
					$identity="assistant";
					$identity_assistant=1;
				}
				
				
			}
		
		
	    	$data=array(
		      	'muban_state'	=>'old',
		      	'dfk'			=>$dfk,'dfh'=>$dfh,
		      	'dsh'			=>$dsh,'dpj'=>$dpj,
		      	'thsh'			=>$thsh,'head'=>$info['head'],
		      	'nickname'		=>$info['nickname'],
		      	'is_show_tire'	=>$info['is_show_tire'],
		      	'duoshagnhu'	=>$dah,
		      	'member_lever'	=>$member_lever,
		      	'member_lever_l'=>$member_lever_l,
		      	'is_mamager'	=>$is_mamager,
		      	'phone_ask'		=>$store180307["phone_ask"],
		      	'integral'		=>$integral,
		      	'member_info'	=>$members,
		      	'identity'		=>$identity,
		      	'identity_manager'	=>$identity_manager,
		      	'identity_assistant'=>$identity_assistant,
		      	'identity_customer'	=>$identity_customer,
	      	);
	      
	     if(I('program_id')=="JT201807211029526361"){
	     	$data["dcl_js"]=$dcl_js;
	     	$data["dwc_js"]=$dwc_js;
	     	$data["dqx_js"]=$dqx_js;
	     }
	     if(I('program_id')=="JT201810111844206577"){
	     	$member_level=M("member_level")->where("member_level=4 and program_id='".I('program_id')."'")->find();
	     	$data["member_level_info"]=$member_level["price"];
	     	$data["member_level_id"]=$member_level["id"];
	     }
	      if(I('program_id')=="JT201806151732369242"){
	     	$data["haved_coupon"]=$haved_coupon;

	     }

        }else if($qianyue["muban_type"]==5){
//这里是资讯 版需要的接口内容==========================================================================
//这里是资讯 版需要的接口内容==========================================================================
//这里是资讯 版需要的接口内容==========================================================================
	
	     	$a=0;//个人积分统计    总数
	     	$b=0;//我的消息    条数
	     	$c=0;//我的收藏    条数
	     	$d=0;//系统通知    条数
	     	$e=0;//积分充值（无）
	     	$f=0;//积分充值记录    条数
	     		
	     	$a=$members["integral"]+$members["integral_song"];
	     		
	     	//$b=M("jt03_zx_info")->where("openid='".$_GET["openid"]."'"." and program_id='".$_GET["program_id"]."'")->count();	
		
			//我的消息---我是发帖人
			$b_count_1=M("jt03_zx_session")->where("openid_owner='".$_GET["openid"]."'"." and program_id='".$_GET["program_id"]."'")->group("zx_info_id")->count();
			
			//我的消息---我是提问的
			$b_count_2=M("jt03_zx_session")->where("openid_open='".$_GET["openid"]."'"." and program_id='".$_GET["program_id"]."'")->group("zx_info_id")->count();
			$b=$b_count_1+$b_count_2;
			
			$c=M("collection")->where("cus_openid='".$_GET["openid"]."'"." and program_id='".$_GET["program_id"]."'")->count();
		
			$f=M("jt03_zx_record_cz")->where("state=2 and openid='".$_GET["openid"]."'"." and program_id='".$_GET["program_id"]."'")->count();
	     
	     
	     
	     
	     	$data=array('muban_state'=>'old','k1'=>$a,'k2'=>$b,'k3'=>$c,'k4'=>$d,'k5'=>$f,'head'=>$info['head'],'nickname'=>$info['nickname'],'is_show_tire'=>$info['is_show_tire'],'member_lever'=>$member_lever);
	
	     	}else if($qianyue["muban_type"]==6){
//这里是服务 版需要的接口内容==========================================================================
//这里是服务 版需要的接口内容==========================================================================
//这里是服务 版需要的接口内容==========================================================================

			$dfk=0;//1	待付款
	      	$dfh=0;//2：待发货
	      	$dsh=0;//3：待收货
	      	$dpj=0;//4：待评价
	      	$thsh=0;//5：退换/售后
	      	$list=M('order_form')->field("id,state")->where(array('program_id'=>$pid,'openid'=>I('openid')))->select();
	     
	      	for($i=0;$i<count($list);$i++){
	      		switch($list[$i]['state']){
	      			case 1:$dfk=++$dfk;break;
	      			case 2:$dfh=++$dfh;break;
	      			case 3:$dsh=++$dsh;break;
	      			case 4:$dpj=++$dpj;break;
	      			case 5:$thsh=++$thsh;break;
	      			default:break;
	      		}
	      	}

			//只需要判断这个是不是多商户，多商户状态  当前状态（1：待审核、2：待入驻（邀请）、3：审核通过（正常）、4:审核拒绝、5：上级禁止、6：服务到期禁止）
			
			$is_dsh=M("user_info_dsh")->field("id,state")->where("program_id='".$_GET["program_id"]."'"." and openid='".$_GET["openid"]."'")->find();
	     		
	     	$data=array('muban_state'=>'old','k1'=>$is_dsh,'msg'=>"1：待审核、2：待入驻（邀请）、3：审核通过（正常）、4:审核拒绝、5：上级禁止、6：服务到期禁止",'member_lever'=>$member_lever);
		    	$data=array(
		
		      	'dfk'			=>$dfk,'dfh'=>$dfh,
		      	'dsh'			=>$dsh,'dpj'=>$dpj,
		      	'thsh'			=>$thsh,'head'=>$info['head'],
		      	'nickname'		=>$info['nickname'],
		      	'is_show_tire'	=>$info['is_show_tire'],

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
		
		 //对订单做统计
         
        $dfk=0;//1	待付款
      	$dfh=0;//2：待发货
      	$dsh=0;//3：待收货
      	$dpj=0;//4：待评价
      	$thsh=0;//5：退换/售后
      	$list=M('order_form')->where(array('program_id'=>$pid,'openid'=>I('openid')))->select();
     
      	for($i=0;$i<count($list);$i++){
      		switch($list[$i]['state']){
      			case 1:$dfk=++$dfk;break;
      			case 2:$dfh=++$dfh;break;
      			case 3:$dsh=++$dsh;break;
      			case 4:$dpj=++$dpj;break;
      			case 5:$thsh=++$thsh;break;
      			default:break;
      		}
      	}
		$user_info_dsh=M("user_info_dsh")->where(array('program_id'=>$pid,'openid'=>I('openid')))->find();
		//$user_info_dsh=M("user_info_dsh")->where(array('program_id'=>$pid,'state'=>"3"))->find();
		
		if(empty($user_info_dsh)){
			$dah=array('status'=>0,'msg'=>'未提交审核');
		}else{
			if($user_info_dsh["state"]==1){
				$dah=array('status'=>1,'msg'=>'待审');
			}else if($user_info_dsh["state"]==3){
				$dah=array('status'=>2,'msg'=>'审核通过');
			}else if($user_info_dsh["state"]==4){
				$dah=array('status'=>3,'msg'=>'审核拒绝');
			}	
		}
	
      	$data=array('muban_state'=>'new','dfk'=>$dfk,'dfh'=>$dfh,'dsh'=>$dsh,'dpj'=>$dpj,'thsh'=>$thsh,'head'=>$info['head'],'nickname'=>$info['nickname'],'is_show_tire'=>$info['is_show_tire'],'duoshagnhu'=>$dah,'member_lever'=>$member_lever);
     
		
	}
	

        $this->ajaxReturn($data);
      }
      
      //子商户基本信息
      function dsz_info_ml(){
      	$is_dsh=M("user_info_dsh")->field("sh_name,sh_psw_show")->where("program_id='".$_GET["program_id"]."'"." and openid='".$_GET["openid"]."'")->find();
	    
	    
	    $user_info=M("user_info")->field("id")->where("program_id='".$_GET["program_id"]."'")->find(); 	
	    $is_dsh["user_info"]=$user_info["id"];	 	
			$this->ajaxReturn($is_dsh);
      }
      
           //子商户基本信息
      function dsz_info_ml_new(){
      	$is_dsh=M("user_info_dsh")->field("id,sh_name,sh_account,sh_psw_show,is_lines,state,qcode_assistant")->where("program_id='".$_GET["program_id"]."'"." and id='".$_GET["id"]."'")->find();

		if(empty($is_dsh["qcode_assistant"])){
			
		}
	    $user_info=M("user_info")->field("id")->where("program_id='".$_GET["program_id"]."'")->find(); 	
	    $is_dsh["user_info"]=$user_info["id"];	 	
		$this->ajaxReturn($is_dsh);
      } 
      
      //一部修改额度
      function dsz_is_lines(){
     $a= M("user_info_dsh")->field("is_lines")->where("id='".$_GET["id"]."'")->find();
if($a["is_lines"]==1){
	$date["is_lines"]=0;
}else{
	$date["is_lines"]=1;
}

		if(M("user_info_dsh")->where("id='".$_GET["id"]."'")->save($date)){
			$data="1";//存数据成功
		}else{
			$data="2";//存数据失败
		}
		
		$this->ajaxReturn($data);
      }
      
      
      //个人中心订单展示
      //需求参数 会员ID 小程序ID 订单状态state
      //提供参数订单编号order_num  商品名  goods_title 商品图片 image  单价buy_price  数量 buy_num  总价  order_gold
      public function order_list(){

		$where=array(
			'program_id'=>$_GET["program_id"],
			'openid'=>$_GET["openid"],
			'state'=>$_GET["state"]+1,
		);
	$a=M('order_form')
	->field('id,order_num,array_id,is_change_price,change_price,state,real_price,buy_price,time_build,state_tuikuan,pirce_tuikuan,pay_method,can_pay_integral_by,integralpay,used_dsh_coupon')
	->where($where)
	->order("time_build desc")
	->select();
	
	for($i=0;$i<count($a);$i++){
			if($a[$i]["state"]==1){
				$a[$i]["state_val"]="0";
			}else if($a[$i]["state"]==2){
				$a[$i]["state_val"]="1";
			}else if($a[$i]["state"]==3){
				$a[$i]["state_val"]="2";
			}else if($a[$i]["state"]==4){
				$a[$i]["state_val"]="3";
			}else if($a[$i]["state"]==5){
				$a[$i]["state_val"]="4";
			}else if($a[$i]["state"]==6){
				$a[$i]["state_val"]="5";
			}else if($a[$i]["state"]==7){
				$a[$i]["state_val"]="6";
			}
//交易状态(1：待付款、2：待发货、3：待收货、4：待评价、5：退换/售后、6：已关闭、7：已完成

		$chaifen=$this->chaifen($a[$i]["array_id"]);
			array_pop($chaifen);
			
			for($p=0;$p<count($chaifen);$p++){
				//购物车 符合条件是某条数据
				$chaifen007[$p]["goods_order_id"]=$chaifen[$p];
				$where01["id"]=$chaifen[$p];
				$order33=M("order")->field('goods_id,buy_num,is_use_guige,guige_key02,guige_name02,guige_key,guige_price,guige_name,is_on_lever_price,members_price_discount')->where($where01)->find();
				
				//商品
				$where02["id"]						=$order33["goods_id"];
				$chaifen007[$p]["buy_num"]			=$order33["buy_num"];
				$chaifen007[$p]["is_use_guige"]		=$order33["is_use_guige"];
				$chaifen007[$p]["guige_key02"]		=$order33["guige_key02"];
				$chaifen007[$p]["guige_name02"]		=$order33["guige_name02"];
				$chaifen007[$p]["guige_key"]		=$order33["guige_key"];
				$chaifen007[$p]["guige_price"]		=$order33["guige_price"];
				$chaifen007[$p]["guige_name"]		=$order33["guige_name"];
				$chaifen007[$p]["is_on_lever_price"]=$order33["is_on_lever_price"];
				$chaifen007[$p]["members_price_discount"]	=$order33["members_price_discount"];
		
				$order330=M("goods")->field('id,goods_title,image,price_sell,integral_sell')->where($where02)->find();
				$chaifen007[$p]["goods_id"]		=$order330["id"];
				$chaifen007[$p]["goods_title"]	=$order330["goods_title"];
				$chaifen007[$p]["price_sell"]	=$order330["price_sell"];
				$chaifen007[$p]["integral_sell"]	=$order330["integral_sell"];
				$arr1102=explode(",",$order330['image']);
			$chaifen007[$p]["image"]=$arr1102[0];
				
			}
			
			$a[$i]["id_arr"]=$chaifen007;
	   }
	  // dump($a);die;
        $this->ajaxReturn($a);
      }
      
    public function booking_list(){

	$where["booking.program_id"]=$_GET["program_id"];
	$where["booking.openid"]	=$_GET["openid"];
	$where["booking.state"]		=$_GET["state"];
	$field="booking.id,booking.booking_num,booking.goods_id,booking.state,booking.time_set,booking.time_done,
	booking.timt_none,booking.date_d,booking.date_time,booking.name,booking.tel,
	
	goods.goods_title,goods.server_phone,goods.server_man,goods.image
	";
	$a=M('booking')
	->field($field)
	->join("left join goods on goods.id=booking.goods_id")
	->where($where)
	->order("booking.time_set desc")
	->select();
	
	for($i=0;$i<count($a);$i++){
		$arr_image[$i]=explode(",",$a[$i]["image"]);
		$a[$i]["first_image"]=$arr_image[$i][0];
	}
	
        $this->ajaxReturn($a);
      }
      //我的收藏
      //需求参数小程序ID 会员ID
      //提供参数商品名     单价    销量    商品图片
      public function collect_list(){

   /*
      	$where['collection.program_id']=I('program_id');
      	$where['collection.cus_openid']=I('openid');
      	$field='collection.id,goods.goods_title,goods.price_sell,goods.sell_num,goods_img.image,goods_img.goods_id';
      	$list=M('collection')
    	->field($field)
      	->group('goods_img.goods_id')
      	->join('LEFT JOIN goods ON collection.goods_id=goods.id')
      	->join('LEFT JOIN goods_img ON collection.goods_id=goods_img.goods_id')
      	->where($where)
      	->select();*/
      	  $qianyue=M("qianyue")->where("program_id='".I('program_id')."'")->find();
          if($qianyue["muban_type"]==1) {
//这里是商城版需要的接口内容==========================================================================
              $where['collection.program_id']=I('program_id');
              $where['collection.cus_openid']=I('openid');
              $field='
              collection.id,collection.goods_id,
              
              goods.goods_title,goods.price_sell,goods.sell_num,goods.image
              
            
              ';
              //  goods_img.image,goods_img.goods_id
              $list=M('collection')
                  ->field($field)
                 // ->group('goods_img.goods_id')
                  ->join('LEFT JOIN goods ON collection.goods_id=goods.id')
                 // ->join('LEFT JOIN goods_img ON collection.goods_id=goods_img.goods_id')
                  ->where($where)
                  ->select();
                  
                   for($i1102=0;$i1102<count($list);$i1102++){
                	$arr1102=explode(",",$list[$i1102]['image']);
					$list[$i1102]["image"]=$arr1102[0];
              	  }  

          }else if($qianyue["muban_type"]==5){
//这里是资讯 版需要的接口内容==========================================================================
              $where['collection.program_id']=I('program_id');
              $where['collection.cus_openid']=I('openid');
              $field='
              collection.id as collection_id,collection.zx_info_id,collection.time_collection,
              
             jt03_zx_info.id as jt03_zx_info_id,jt03_zx_info.title,jt03_zx_info.num,jt03_zx_info.state,jt03_zx_info.num_contect,jt03_zx_info.num_read,jt03_zx_info.time_agree,jt03_zx_info.image,jt03_zx_info.fenlei01,
			jt03_zx_info.sort,jt03_zx_info.style,
			
			attribute.title as attribute_attribute
              ';
              $list=M('collection')
                  ->field($field)
                  ->join('left join jt03_zx_info ON jt03_zx_info.id=collection.zx_info_id')
                  ->join('left join attribute ON attribute.id=jt03_zx_info.fenlei01')
                  ->where($where)
                  ->select();

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
					
					if($_POST["state"]=="goods"){
						 $where['collection.program_id']=I('program_id');
              $where['collection.cus_openid']=I('openid');
              $field='
              collection.id,collection.goods_id,
              
              goods.goods_title,goods.price_sell,goods.sell_num,goods.image
              
            
              ';
              //  goods_img.image,goods_img.goods_id
              $list=M('collection')
                  ->field($field)
                 // ->group('goods_img.goods_id')
                  ->join('LEFT JOIN goods ON collection.goods_id=goods.id')
                 // ->join('LEFT JOIN goods_img ON collection.goods_id=goods_img.goods_id')
                  ->where($where)
                  ->select();
                  
                   for($i1102=0;$i1102<count($list);$i1102++){
                	$arr1102=explode(",",$list[$i1102]['image']);
					$list[$i1102]["image"]=$arr1102[0];
              	  }  
					}
					if($_POST["state"]=="zx_info"){
					$where['collection.program_id']=I('program_id');
              $where['collection.cus_openid']=I('openid');
              $field='
              collection.id as collection_id,collection.zx_info_id,collection.time_collection,
              
             jt03_zx_info.id as jt03_zx_info_id,jt03_zx_info.title,jt03_zx_info.num,jt03_zx_info.state,jt03_zx_info.num_contect,jt03_zx_info.num_read,jt03_zx_info.time_agree,jt03_zx_info.image,jt03_zx_info.fenlei01,
			jt03_zx_info.sort,jt03_zx_info.style,
			
			attribute.title as attribute_attribute
              ';
              $list=M('collection')
                  ->field($field)
                  ->join('left join jt03_zx_info ON jt03_zx_info.id=collection.zx_info_id')
                  ->join('left join attribute ON attribute.id=jt03_zx_info.fenlei01')
                  ->where($where)
                  ->select();
					}
				
				}

      	$this->ajaxReturn($list);
      }
      
      
      //收藏编辑移除
      //需求参数 收藏id
      //提供参数
      public function collect_del(){
      	$id=I('id');
      	if(is_array($id)){
      	    $where='id in('.implode(',',$id).')';	
      	}else{
      		//$where='id='.$id;
      		$where["id"]=$id;
      	}
   
      	if(M('collection')->where($where)->delete()){
      		$data=array('status'=>1,'msg'=>'成功移除');
      	}else{
      		$data=array('status'=>-1,'msg'=>'操作失败');
      	}
      	
      //	dump(M('collection')->_sql());die;
      	$this->ajaxReturn($data);
      }
      
      //地址管理地址展示
      //需求参数 小程序ID 会员openid、      program_id   openid
      //提供参数  姓名 电话man_shouhuo man_phone  man_area区域地址   是否默认
      public function address(){
      	$where=I();
      $where["is_used"]="1";
      	$list=M('man_shouhuo')
      	->field('id,man_shouhuo,man_phone,man_area,state')
      	->where($where)->select();

      	$this->ajaxReturn($list);
      }
      
      //地址管理编辑页面信息
      //需求参数 收货ID id
      //提供参数 姓名电话地区详细地址
      public function address_info(){
      	$where['id']=I('id');
      	$data=M('man_shouhuo')->where($where)->find();

      	$this->ajaxReturn($data);
      }
      
      //地址编辑提交
      //需求参数 收货ID id   man_shouhuo  man_phone man_area man_address
      //提供参数
      public function address_sv(){
      	$save=I();
      	$where['id']=I('id');
      	$sql=M('man_shouhuo')->where($where)->save($save);
      	if($sql){
      		$data=array('status'=>1,'msg'=>'操作成功');
      	}else{
      		$data=array('status'=>-1,'msg'=>'操作失败');
      	}
      	$this->ajaxReturn($data);
      }
      
      //删除地址
      //需求参数 收货ID id
      //提供参数
      public function address_del(){
      	if(M('man_shouhuo')->delete($_POST["id"])){
      		$data=array('status'=>1,'msg'=>'操作成功');
      	}else{
      		$data=array('status'=>-1,'msg'=>'操作失败');
      	}
      	
      /*	$where=I();
      	
      	$delete["is_used"]="2";
      	$sql=M('man_shouhuo')->where($where)->save($delete);
      	if($sql){
      		$data=array('status'=>1,'msg'=>'操作成功');
      	}else{
      		$data=array('status'=>-1,'msg'=>'操作失败');
      	}*/
      	$this->ajaxReturn($data);
      }
      
      //添加地址
      //需求参数小程序ID 会员 openid program_id  
      // 收货人姓名、收货人手机号、所在地区、详细地址     man_shouhuo、man_phone、man_address、
      
      //提供参数
      public function address_add(){
      	$save=I();
      	
      	if(empty($save["program_id"]) | empty($save["openid"])){
      		$this->ajaxReturn(array('status'=>-2,'msg'=>'参数错误'));
      	}
      //	$save['man_area']=json_encode($save['man_area']);
      	
      	//dump($save);die;
      	$save["only_num"]=time().rand(111,999);
      	$is_have=M("man_shouhuo")->where("only_num='".$save["only_num"]."'")->find();
      	if(empty($is_have)){
      		
      		$where0918["program_id"]=$save["program_id"];
      		$where0918["openid"]=$save["openid"];
      		
      		$b=M("man_shouhuo")->where($where0918)->find();//判断这个人有没有地址记录
	      		if(empty($b)){
	      			$save["state"]="1";
	      		}
		      	if(M('man_shouhuo')->add($save)){
		
		     
		      		$data=array('status'=>1,'msg'=>'添加成功');
		      	}else{
		      		$data=array('status'=>-1,'msg'=>'添加失败');
		      	}
      	}else{
      		$data=array('status'=>2,'msg'=>'请勿重复添加');
      	}
      	
      	
      	$this->ajaxReturn($data);
      }
      
      
          	//分割函数
	 function chaifen($source){
        return explode(',',$source);
    }
  
      //设置默认地址
      //需求参数 收货ID
      //提供参数
      public function set_default(){
      	
      	//openid program_id
      	$M=M('man_shouhuo');
      	$where=I();
	$where["is_used"]="1";
      	$info=$M
      	->field('id,program_id,member_id,state,openid')
      	->where($where)
      	->find();//得到那条对应的收货数据
      	$arr=$M->field('id')->where(array('program_id'=>$info['program_id'],'openid'=>$info['openid']))->select();
      	for($i=0;$i<count($arr);$i++){
      		$getid["id"]=$arr[$i]['id'];
      		M('man_shouhuo')->where($getid)->save(array('state'=>0));
      	}
      	 	
      //	$M->where('id in('.implode(',',$getid).')')->save(array('state'=>0));
      	$sql=$M->where($where)->save(array('state'=>1));
      	if($sql){
      		$data=array('status'=>1,'msg'=>'设置默认成功');
      	}else{
      		$data=array('status'=>-1,'msg'=>'设置失败');
      	}	
      	$this->ajaxReturn($data);
      }
      
      //关于我们
      //需求参数小程序ID program_id
      //提供参数 商城简介abstract  服务热线phone_ask 微信cs_wx QQcs_qq 邮箱cs_mail 联系人 linkman 地址address
      public function aboutus(){

    
      	$field='abstract,linkman,phone_ask,cs_qq,cs_wx,cs_mail,address';
      	$info=M('store')->field($field)->where("program_id='".$_GET["program_id"]."'")->find();


    	$this->ajaxReturn($info);
      }
      
      //0904...10.32 个人中心绑定手机页面
      public function tire_phpone(){
     //post  openid、realname、tel 、         1020...program_id

     	if(M("members")->where("openid='".$_GET["openid"]."'")->save($_GET)){
     		$data=array('status'=>1,'msg'=>'添加成功');
     	}else{
     		$data=array('status'=>2,'msg'=>'添加失败','date'=>$_GET);
     	}
  		$this->ajaxReturn($data);
      }
      
      
    public function register_phone(){
		$_GET["time_register"]=time();		
		if(M("register_record")->add($_GET)){			
			$_GET["rebate_state"]=1;
			M("members")->where("openid='".$_GET["openid"]."'")->save($_GET);
			$data=array('status'=>1,'msg'=>'操作成功');
		}else{
			$data=array('status'=>-1,'msg'=>'操作失败','date'=>$_GET);
		}
	
  		$this->ajaxReturn($data);
      }
      
//    兰倩美容领取抵扣券
   public function get_rebate(){
		$add["time_get"]=time();
		$add["rebate_id"]=1;
		$add["program_id"]=$_POST["program_id"];
		$add["openid"]=$_POST["openid"];
		
		$save["rebate_state"]=2;
		$store=M("store")->where("program_id='".$_POST["program_id"]."'")->find();
		if($store["tuijian_money"]==0){
			$this->ajaxReturn(array('status'=>-1,'msg'=>'抵扣券功能关闭'));
		}
		$rebate=M("rebate")->where("id=1")->find();
		$add["price"]=$rebate["price_base"];
		if(M("rebate_record")->add($add)){		
			
			M("members")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'")->setInc("man_money",$store["tuijian_money"]);
							
			$data=array('status'=>1,'msg'=>'操作成功');
		}else{
			$data=array('status'=>-1,'msg'=>'操作失败');
		}
	
  		$this->ajaxReturn($data);
    }
      //0904...10.32 个人中心解除绑定手机页面
    public function tire_out_phpone(){
    	$change["tel"]="";
  	  if(M("members")->where("openid='".$_POST["openid"]."'")->save($change)){
     		$data=array('status'=>1,'msg'=>'解绑成功');
     	}else{
     		$data=array('status'=>2,'msg'=>'解绑失败');
     	} 	
     	
     	$this->ajaxReturn($data);
   }
  
    //积分充值页面
		function integral_cz(){
			//需要小程序id，后台提供积分充值比例，和订单号
			
			$store=M("store")->where("program_id='".$_POST["program_id"]."'")->find();
			
			$a=$store["integral_proportion"];//积分充值比例
			
			//如果这个小程序没有设置积分快捷选择的优惠的话，就对用原始的数据，如果设置了就调用设置的数据
			if($store["integral_chongzhi_id"]==0){
				$price_record=array(
					'p_5'=>5,
					'p_10'=>10,
					'p_20'=>20,
					'p_50'=>50,
					'p_100'=>100,
					'p_200'=>200,
					
					'p_r_5'=>$a*5,
					'p_r_10'=>$a*10,
					'p_r_20'=>$a*20,
					'p_r_50'=>$a*50,
					'p_r_100'=>$a*100,
					'p_r_200'=>$a*200
				);
			}else{
				$integral_chongzhi=M("integral_chongzhi")->where("id='".$store["integral_chongzhi_id"]."'")->find();
				
				$money=explode(",",$integral_chongzhi["money"]);
				$integral=explode(",",$integral_chongzhi["integral"]);
			
			//积分快捷选择列表
			$price_record=array(
					'p_5'=>$money[0],
					'p_10'=>$money[1],
					'p_20'=>$money[2],
					'p_50'=>$money[3],
					'p_100'=>$money[4],
					'p_200'=>$money[5],
					
					'p_r_5'=>$integral[0],
					'p_r_10'=>$integral[1],
					'p_r_20'=>$integral[2],
					'p_r_50'=>$integral[3],
					'p_r_100'=>$integral[4],
					'p_r_200'=>$integral[5]
				);
			
			}
			
			
			
			$b="JT".date("YmdHis",time()).rand(111111,999999);//生成订单号
			
			$members=M("members")->where("openid='".$_POST["openid"]."'"." and program_id='".$_POST["program_id"]."'")->find();
			
			$c=$members["integral"]+$members["integral_song"];//当前积分
			
			$d=array('k1'=> $a,'k2'=>$b,'k3'=>$c,'k4'=>$price_record);

			$this->ajaxReturn($d);
		}    
		
	//	易选购vip购买页面
	
	function vip_buy(){
		//分销等级
		$a=M("fx_lever_independent")->field('id,condition_price,lever_title')->where("program_id='".$_POST["program_id"]."'")->select();
		
		//当前用户信息
		$b=M("members")->field("vip_id")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'")->find();
		$a["vip_id"]=$b["vip_id"];
		
		//上级信息
		$c=M("members")->where("program_id='".$_POST["program_id"]."'"."and id='".$_POST["from_id"]."'")->find();
		
		//判断上级是不是vip  转发的也能够得到 from_id
		
		if($c["vip_id"]!=0){
			$a["uid_nickname"]=$c["nickname"];
			$a["uid_head"]=$c["head"];
			$a["uid"]=$_POST["from_id"];
		}else{
			$a["uid"]="0";
		}

		$this->ajaxReturn($a);
	}
		
	//积分充值提交
	function integral_submit(){
		//积分充值点击按钮必须先来这个借口，在积分充值记录表添加数据，然后直接跳转到微信充值接口
		
		$date["state"]		="1";
		$date["time"]		=time();
		$date["program_id"]	=$_POST["program_id"];
		$date["openid"]		=$_POST["openid"];
//		$date["order_num"]	=$_POST["order_num"];
		$date["order_num"]	="JT".date("YmdHis",time()).rand(111111,999999);
		$date["price"]		=$_POST["price"];
		if(!empty($_POST["record"])) $date["record"]=$_POST["record"];
		if(!empty($_POST["vip_id"])) $date["vip_id"]=$_POST["vip_id"];
		if(!empty($_POST["vip_buy_repeat"])) $date["vip_buy_repeat"]=$_POST["vip_buy_repeat"];// 初级购买，升级购买   1： buy_first  / 2：buy_leaverup
		if(!empty($_POST["vip_id_old"])) $date["vip_id_old"]=$_POST["vip_id_old"];// 旧的vip等级

		$members=M("members")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'")->find();
		
		//查询传递的分销上级id，如果这个人不是vip，则重置传递的值
		$members_from_id=M("members")->where("program_id='".$_POST["program_id"]."'"."and id='".$_POST["from_id"]."'")->find();
		if($members_from_id["vip_id"]==0) $_POST["from_id"]="0";
		
		//推荐佣金判断，第一次购买时候判断 from_id   第二次购买判断个人原本的上线，查询上线等级，对应出分销佣金比例，折算出实际支付金额的分销佣金
		
		if(!empty($_POST["vip_buy_repeat"])){
			//二次购买  --填写之前的分销上级，填写累计已支付金额
			$fx_lever_independent=M("fx_lever_independent")->where("id='".$_POST["vip_id_old"]."'")->find();
			$pay_price=$_POST["price"]-$fx_lever_independent["condition_price"];

			$date["vip_uid"]=$members["fx_uid"];//之前分销上级	
		}else{
			//初次购买
			if(!empty($_POST["from_id"])) $date["vip_uid"]=$_POST["from_id"];// 易选购分销uid
			
			//分销佣金
			$members01=M("members")->where("id='".$date["vip_uid"]."'"."and program_id='".$_POST["program_id"]."'")->find();//一级上线uid
			$fx_price_independent01=M("fx_price_independent")->where("fx_price_lever=1 and lever_id='".$members01["vip_id"]."'"."and buy_id='".$_POST["vip_id"]."'")->find();//一级分销佣金
		
				
			$members02=M("members")->where("id='".$members01["fx_uid"]."'"."and program_id='".$_POST["program_id"]."'")->find();//二级上线uid
			$fx_price_independent02=M("fx_price_independent")->where("fx_price_lever=2 and lever_id='".$members02["vip_id"]."'"."and buy_id='".$_POST["vip_id"]."'")->find();//二级分销佣金
		
			$date["price_01"]	=$fx_price_independent01["price_fy"];
			$date["price_02"]	=$fx_price_independent02["price_fy"];
			$pay_price			=$_POST["price"];
		}
		$date["leiji_buy_price"]=$members["vip_leiji_pay"]+$pay_price;//之前分销上级

		if(M("jt03_zx_record_cz")->add($date)){
				$data=array('status'=>1,'msg'=>'订单创建成功，跳转到支付接口','order_num'=>$date["order_num"],'price'=>$pay_price);
	     	}else{
	     		$data=array('status'=>2,'msg'=>'订单创建失败，原地不动');
	     	} 	
		$this->ajaxReturn($data);
	}
    //积分充值记录查看
    function integral_cz_search(){
//需要小程序id 、个人openid
    	
    $members=M("members")->where("openid='".$_POST["openid"]."'"." and program_id='".$_POST["program_id"]."'")->find();	
    $totla=$members["integral"]+$members["integral_song"];
    	
    $integral_search=M("jt03_zx_record_cz")
    ->where(" state=2 and openid='".$_POST["openid"]."'"." and program_id='".$_POST["program_id"]."'")
    ->order("time desc")
    ->select();
   
   $z=array('k1'=>$totla,'k2'=>$integral_search);
  	 $this->ajaxReturn($z);
   
    }

	//查看消费记录
	function integral_xf_search(){		
	 	$members=M("members")->where("openid='".$_POST["openid"]."'"." and program_id='".$_POST["program_id"]."'")->find();	
    	$totla=$members["integral"]+$members["integral_song"];	
		$integral_search=M("jt03_zx_record_xf")
    	->where(" openid='".$_POST["openid"]."'"." and program_id='".$_POST["program_id"]."'")
   		->order("time desc")
    	->select();	
			  
		$z=array('k1'=>$totla,'k2'=>$integral_search);
  	 	$this->ajaxReturn($z);
	}
	
	//我的积分
	function my_integral(){
		$members=M("members")->where("program_id='".$_POST["program_id"]."'"." and openid='".$_POST["openid"]."'")->find();
		
		$my_integral=$members["integral"]+$members["integral_song"];//总积分
		
		$my_integral_can=$members["integral"];//可体现积分
		
		$z=array('k1'=>$my_integral,'k2'=>$my_integral_can);
		
		$this->ajaxReturn($z);
	}

		//积分提现页面
		
		function integral_html(){
			//openid program_id 
			//显示个人可以提现的金额
			
		$members=M("members")->where("program_id='".$_POST["program_id"]."'"." and openid='".$_POST["openid"]."'")->find();
			
		$my_integral=$members["integral"]+$members["integral_song"];//总积分
		
		$my_integral_can=$members["integral"];//可体现积分
		
		$my_integral_cash=$members["integral_cash"];//冻结积分 
			
		$z=array('k1'=>$my_integral,'k2'=>$my_integral_can,'k3'=>$my_integral_cash);
		
		$this->ajaxReturn($z);
		}

	//积分提现
	function integral_cash(){
		//实际上就是把积分冻结，然后将申请去审核
		//申请状态（1：待审核、2：审核通过（待打款）、3：审核拒绝、4：已打款、5：未知错误）
		
		$members=M("members")->where("openid='".$_POST["openid"]."'"." and program_id='".$_POST["program_id"]."'")->find();
		
		/*$a=array('l1'=>$_POST["money_01"],'l2'=>$members["integral"]);
		$this->ajaxReturn($a);*/
		//判断可以提现的积分是不是对的
		if($_POST["money_01"]*10>$members["integral"]){
			//提交的金额对应的积分超过了现有的可体现积分
			$this->ajaxReturn(array('status'=>-999,'msg'=>'提交的金额对应的积分超过了现有的可体现积分,拒绝体现'));
		}
		
		$date["state"]=1;
		$date["time_set"]=time();
		$date["order_num"]="JT".date("YmdHis",time()).rand(111111,999999);//生成订单号
				
		$date["program_id"]=$_POST["program_id"];
		$date["openid"]=$_POST["openid"];
		$date["money_01"]=$_POST["money_01"];//申请金额
	
	//需要限制个人在一定时间内
	
	
		if(M("fx_tixian")->add($date)){
			
			$save["integral_cash"]=$_POST["money_01"]*10;

			M("members")
			->where("openid='".$_POST["openid"]."'"." and program_id='".$_POST["program_id"]."'")
			->setInc("integral",-$save["integral_cash"]);
			
				M("members")
				->where("openid='".$_POST["openid"]."'"." and program_id='".$_POST["program_id"]."'")
				->setInc("integral_cash",$save["integral_cash"]);
				$data=array('status'=>1,'msg'=>'提现申请提交成功');
			

		}else{
			$data=array('status'=>2,'msg'=>'提现申请提交失败');
		}
		$this->ajaxReturn($data);
	}


//爱神红娘个人中心
	function as_person(){

			//个人信息
			$identity_info=M("identity_info")
			->field('id,name,qinaming,headimg,as_id,state')
			->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();
		
		if($identity_info["as_id"]==1){
			//进来身份为红娘

			//单身团数
			$a=M("bachelorhood_team")->where("program_id='".$_GET["program_id"]."'"." and own_openid='".$_GET["openid"]."'")->count();
			
			//粉丝数
			$b=M("attention")->where("state=1 and program_id='".$_GET["program_id"]."'" ." and openid_attentioned='".$_GET["openid"]."'")->count();
			
	$date=array('k1'=>$identity_info,'k2'=>$a,'k3'=>$b);
			$this->ajaxReturn($date);
		}else if($identity_info["as_id"]==2){
			//进来身份为单身汪   姓名、头像、个性签名、他喜欢的人、喜欢他的人、互相喜欢的人（关注） 
			
			
			$a=0;//他喜欢的人
			$b=0;//喜欢他的人 
			$c=0;//互相喜欢的人
			
		$all=M("attention")->where("state=2 and program_id='".$_GET["program_id"]."'")->select();
			for($i=0;$i<count($all);$i++){
				if($all[$i]["opneid_attentioning"]==$_GET["openid"]){
					$a+=1;
				}
				if($all[$i]["openid_attentioned"]==$_GET["openid"]){
					$b+=1;
				}
				$attention01=M("attention")->where("program_id='".$_GET["program_id"]."'"."and opneid_attentioning='".$_GET["openid"]."'")->find();	
				$attention02=M("attention")->where("program_id='".$_GET["program_id"]."'"."and openid_attentioned='".$attention01["openid_attentioned"]."'")->find();
				if($attention02["opneid_attentioning"]==$_GET["openid"]){
					$c+=1;
				}
				
				$attention010=M("attention")->where("program_id='".$_GET["program_id"]."'"."and openid_attentioned='".$_GET["openid"]."'")->find();	
				$attention020=M("attention")->where("program_id='".$_GET["program_id"]."'"."and opneid_attentioning='".$attention01["openid_attentioned"]."'")->find();
				if($attention020["openid_attentioned"]==$_GET["openid"]){
					$c+=1;
				}
			
			}
			
		$members=M("members")->where("openid='".$_GET["openid"]."'"." and program_id='".$_GET["program_id"]."'")->find();	
	  

	   $a1209 =M("member_level")->where("id='".$members["level_id"]."'")->find();
	   $member_lever=$a1209["member_level_name"];
			$date=array('k1'=>$identity_info,'k2'=>$a,'k3'=>$b,'k4'=>$c,'member_lever'=>$member_lever);
			$this->ajaxReturn($date);
		}
	}

	//用户注册接口
	function register(){
			if(empty($_POST["program_id"]) & empty($_POST["openid"])){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		
		//用户注册，有账号密码，登录状态才能看到商品价格
		$date["state_audit"]="1";//审核状态（1：待审、2：通过、3：拒绝）
		$date["register_account"]=$_POST["register_account"];
		$date["register_psw"]=md5($_POST["register_psw"]);
		$date["register_name"]=$_POST["register_name"];
		$date["register_tel"]=$_POST["register_tel"];
		$date["register_idnum"]=$_POST["register_idnum"];
		
		$date["state_online"]="2";//是否在线（1：在线、2：不在线）
		$date["register_acount_time"]=time();//账号注册时间
		
		
		
		if(M("members")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'")->save($date)){
			$data=array('status'=>1,'msg'=>'申请提交成功');
		}else{
			$data=array('status'=>-1,'msg'=>'申请提交失败');
		}
		$this->ajaxReturn($data);
	}
	
	//异步检测账号唯一接口
	function only_account(){
		if(empty($_GET["program_id"])){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		$a=M("members")->where("program_id='".$_GET["program_id"]."'"."and register_account='".$_GET["register_account"]."'")->find();
		
		if(empty($a)){
			$this->ajaxReturn(array('status'=>1,'msg'=>'可以使用'));
		}else{
			$this->ajaxReturn(array('status'=>-1,'msg'=>'已经存在该账号'));
		}
	}
	
	//查询账号审核结果接口
	function search_registe(){
		if(empty($_GET["program_id"]) & empty($_GET["openid"])){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		
		//审核结果查询
		$a=M("members")->where("program_id='".$_GET["program_id"]."'"."and openid='".$_GET["openid"]."'")->find();
		//审核状态（1：待审、2：通过、3：拒绝）
		if($a["state_audit"]==1){
			$this->ajaxReturn(array('status'=>1,'msg'=>'待审'));
		}else if($a["state_audit"]==2){
			$this->ajaxReturn(array('status'=>2,'msg'=>'通过'));
		}else if($a["state_audit"]==3){
			$this->ajaxReturn(array('status'=>3,'msg'=>'拒绝'));
		}
	}
	
	//登录访问接口
	function onload(){
		
		if(empty($_POST["program_id"]) & empty($_POST["openid"])){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		
		$a=M("members")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'"."and register_account='".$_POST["register_account"]."'")->find();
		if(empty($a)){
			$this->ajaxReturn(array("state" => -666, "msg" => "与本微信号绑定的账号不存在"));
		}
		
		if($a["state_audit"]!=2){
			$this->ajaxReturn(array("state" => -777, "msg" => "账号异常"));
		}
		
		if(md5($_POST["register_psw"])!=$a["register_psw"] | $_POST["register_psw"]!=$a["register_account"]){
			$this->ajaxReturn(array('status'=>-888,'msg'=>'账号或密码错误'));
		}
		if(md5($_POST["register_psw"])==$a["register_psw"] & $_POST["register_psw"]==$a["register_account"]){
			$date["state_online"]="2";//是否在线（1：在线、2：不在线）
			M("members")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'")->save($date);
			$this->ajaxReturn(array('status'=>1,'msg'=>'登录成功'));
		}else{
			$this->ajaxReturn(array('status'=>-1,'msg'=>'登录失败'));
		}
	}
//退出访问接口
function load_out(){
		if(empty($_POST["program_id"]) & empty($_POST["openid"])){
			$this->ajaxReturn(array("state" => -999, "msg" => "参数缺失"));
		}
		$date["state_online"]="1";//是否在线（1：在线、2：不在线）
		
		if(M("members")->where("program_id='".$_POST["program_id"]."'"."and openid='".$_POST["openid"]."'")->save($date)){
			
			$this->ajaxReturn(array('status'=>1,'msg'=>'退出成功'));
		}else{
			$this->ajaxReturn(array('status'=>-1,'msg'=>'退出失败'));
		}
}

//学历列表
function schooling_record(){
	$a=M("schooling_record")->where("program_id='".$_GET["program_id"]."'")->select();
	
	$this->ajaxReturn($a);
}
//店员添加	
function assistant_add(){

	
	if(empty($_POST["program_id"]) & empty($_POST["openid"])){
			$this->ajaxReturn(array("status" => -999, "msg" => "参数缺失"));
		}
	$add=$_POST;
	
	$aa=M("members")->field("is_ktv_assistant")->where("program_id='".$add["program_id"]."'"."and openid='".$add["openid"]."'")->find();
	
	if($aa["is_ktv_assistant"]!=0){
		$this->ajaxReturn(array("status" => -8, "msg" => "勿重复申请"));
	}
	
	if($add["program_id"]=="JT201808090855119076"){
		$a=M("assistant_add")->field("id")->where("program_id='".$add["program_id"]."'"."and assistant_num='".$add["assistant_num"]."'")->find();
		if(!empty($a)){
			$this->ajaxReturn(array('status'=>-2,'msg'=>'账号已存在'));
		}
	}
	
	$add["time_registe"]=time();
	if(M("assistant_add")->add($add)){	
		$this->ajaxReturn(array('status'=>1,'msg'=>'添加成功'));
	}else{
		$this->ajaxReturn(array('status'=>-1,'msg'=>'添加失败'));
	}
}


function is_self_info(){
	$a=M("members")->field("realname,tel,sex_text,address,hangye,aihao")->where("program_id='".$_POST["program_id"]."'"." and openid='".$_POST["openid"]."'")->find();
	$this->ajaxReturn($a);
//	if(empty($a)){
//		$this->ajaxReturn(array('status'=>-1,'msg'=>'无资料'));
//	}else{
//		$this->ajaxReturn(array('status'=>1,'msg'=>'有资料'));
//	}

}
function self_info_add(){
	$save["realname"]=$_POST["realname"];
	$save["tel"]=$_POST["tel"];
	$save["sex_text"]=$_POST["sex_text"];
	$save["address"]=$_POST["address"];
	$save["hangye"]=$_POST["hangye"];
	$save["aihao"]=$_POST["aihao"];
	
	
	if(M("members")->where("program_id='".$_POST["program_id"]."'"." and openid='".$_POST["openid"]."'")->save($save)){
		
		$this->ajaxReturn(array('status'=>1,'msg'=>'添加成功'));
	}else{
		$this->ajaxReturn(array('status'=>-1,'msg'=>'添加失败'));
	}
}
	
}
?>