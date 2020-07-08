<?php
namespace HProgram\Controller;
use Think\Controller;
use Think\DB;
header('content-type:application:json;charset=utf8'); 
header('Access-Control-Allow-Origin:*'); 
header('Access-Control-Allow-Headers:x-requested-with,content-type');
header("Content-Type:text/html;CharSet=UTF-8");
class PersonController extends Controller {


 //子商户基本信息
      function dsz_info_ml_new(){
      	$is_dsh=M("h_user_info_dsh")->field("id,sh_name,sh_account,sh_psw_show,is_lines,state")->where("program_id='".$_GET["program_id"]."'"." and id='".$_GET["id"]."'")->find();

	    $is_dsh["user_info"]=1;	 	
		$this->ajaxReturn($is_dsh);
      } 
      
      
	/*-------------------------------------------海龙---------------------------------------------------------------*/

    public function person(){
      	$pid=I('program_id');

        $members=M("h_members")->where("openid='".$_GET["openid"]."'"." and program_id='".$_GET["program_id"]."'")->find();	
//会员等级
	    $a1209 =M("h_member_level")->where("id='".$members["level_id"]."'")->find();
	    $member_lever=$a1209["member_level_name"];
	   
     	$dfk=0;//1	待付款
      	$dfh=0;//2：待发货
      	$dsh=0;//3：待收货
      	$dpj=0;//4：待评价
      	$thsh=0;//5：退换/售后
      	$list=M('h_order_form')->field("id,state")->where(array('program_id'=>$pid,'openid'=>I('openid')))->select();
	     
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
		$data=array(	
	      	'dfk'			=>$dfk,
	      	'dfh'			=>$dfh,
	      	'dsh'			=>$dsh,
	      	'dpj'			=>$dpj,
	      	'thsh'			=>$thsh,
	
	      	'member_info'	=>$members,
      	);
        $this->ajaxReturn($data);
    }
      
//子商户基本信息
    function dsz_info_ml(){
      	$is_dsh=M("user_info_dsh")->field("sh_name,sh_psw_show")->where("program_id='".$_GET["program_id"]."'"." and openid='".$_GET["openid"]."'")->find();
	     
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
	->field('id,order_num,array_id,state,real_price,buy_price,time_build,state_tuikuan,pirce_tuikuan,pay_method,can_pay_integral_by,integralpay,used_dsh_coupon')
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
	


	
}
?>