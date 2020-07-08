<?php
namespace HProgram\Controller;
use Think\Controller;
class WxpayController extends Controller{
	
	
	
	function get_user_info(){
		$code=$_POST['code'];

			$params = array(
            'appid'      => $_POST['appid'],
        	'secret'  	 => $_POST['secret'],
            'js_code'    => $code,
            'grant_type' => 'authorization_code',
		 );	
 		$url = 'https://api.weixin.qq.com/sns/jscode2session';
        $xml = $this->http_request($url,$params);
	
        $this->ajaxReturn($xml);
        
        
	}
	

	/*
	 * 保存个人信息
	 * program_id    openid    nickname  headimgurl
	 * */
	function save_man_info(){
		$dat["nickname"]=$_GET["nickname"];
		$dat["head"]=$_GET["head"];
	
		if(M("h_members")->where("openid='".$_GET["openid"]."'"."and program_id='".$_GET["program_id"]."'")->save($dat)){
			$date=array('state'=>1,'msg'=>'信息存入成功');
		}else{
			$date=array('state'=>-1,'msg'=>'信息存入失败');
		}
		$this->ajaxReturn($date);	 
	}
	
	public function index01(){
		/*$code="011huTDZ1UpBAY0af1FZ1FyUDZ1huTDT";
    	$appid="wx31d64bf834fd4c52";
    	$secret="26f991ff129c4efafb4c322ba98a56d6";*/
    	$code=$_POST['code'];
    	$appid=$_POST['appid'];
    	$secret=$_POST['appsecret'];
    	
    	$get_token_url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$secret.'&js_code='.$code.'&grant_type=authorization_code';
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$get_token_url);
		curl_setopt($ch,CURLOPT_HEADER,0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		$res = curl_exec($ch);  
		curl_close($ch);  

		echo $res;
		exit();
    }
	
	//分割函数
	 function chaifen($source){
        return explode(',',$source);
    }
	/* 小程序报名，生成订单 */
    public function make_order(){
    	
   		if($_POST){
			if(I('POST.program_id')=="JT201806151732369242"){
    		//百业联盟的二维码微信支付 from_id
    		if($_POST["pay_state"]=="qdcode_pay"){
    			$a0823=M("dsh_qdcode_chage")->field("dsh_qdcode_chage.state,dsh_qdcode_chage.order_price,assistant_add.shop_id")
				->join("left join assistant_add on assistant_add.openid=dsh_qdcode_chage.openid_ass")
				->where("dsh_qdcode_chage.order_num='".$_POST["order_num"]."'")->find();
				
				$pay_man=M("members")->field("id,fx_uid,fx_state")->where("openid='".$_POST["openid"]."'"." and program_id='".$_POST["program_id"]."'")->find();
				if($pay_man["fx_state"]==2){
					//已经是分销商了
//					$save_from_id["from_id"]=$_POST["from_id"];
					$save_from_id["from_id"]=$pay_man["fx_uid"];
				}
				
				
				// 不做分销内购，自己购买不算佣金给自己
				$members0823=M("members")
				->field('
					members.id as members_id,members.fx_lever_id,
					fx_lever.id as fx_lever_id,fx_lever.bl_lever_1,fx_lever.bl_lever_2,fx_lever.bl_lever_3')
				->where("members.id='".$save_from_id["from_id"]."'")
				->join('left join fx_lever ON fx_lever.id=members.fx_lever_id')
				->find();
				
				
				$save_from_id["dfx_price01"]=$a0823["order_price"]*$members0823["bl_lever_1"]*0.01;
				$save_from_id["dfx_price02"]=$a0823["order_price"]*$members0823["bl_lever_2"]*0.01;
				$save_from_id["dfx_price03"]=$a0823["order_price"]*$members0823["bl_lever_3"]*0.01;
				if($a0823["state"]==1){
					$this->ajaxReturn(array("state"=>-11,"msg"=>"支付失败，勿重复支付"));
				}		
				M("dsh_qdcode_chage")->where("order_num='".$_POST["order_num"]."'")->save($save_from_id);
				$_POST["data_total"]=$a0823["order_price"];
    		}
    		
			
    		}	
		}
	
        if($_POST){
        	$data['program_id']	 = I('POST.program_id');
            $data['openid']		 = I('POST.openid');
//          $data_total			 = I('POST.data_total');
 			$data_total			 = $_POST["data_total"];
//          $data['crsNo']		 = date('YmdHis',time());
    		$data['crsNo'] 		 = I('POST.order_num');
    		$data['pay_state']	 = I('POST.pay_state');
    		 
//	 	$order_form=M("order_form")->where("order_num='".$data['crsNo']."'")->find();
//  	if(!empty($order_form)){
//	    	$save["real_price"]=$data_total;
//	  		M("order_form")->where("order_num='".$data['crsNo']."'")->save($save);
//	    }
	
        $this->insertID = $insertId;
        $this->data_total = $data_total*100;    //订单总金额，单位 分
        /* 调用微信【统一下单】 */
        $this->pay($data_total*100,$data['openid'],$data['crsNo'],$data['program_id'],$data['pay_state']);
            
        }
    }
    
    /* 首先在服务器端调用微信【统一下单】接口，返回prepay_id和sign签名等信息给前端，前端调用微信支付接口 */
    private function Pay($total_fee,$openid,$order_id,$program_id,$pay_state){
        if(empty($total_fee)){
            echo json_encode(array('state'=>0,'Msg'=>'金额有误'));exit;
        }
        if(empty($openid)){
            echo json_encode(array('state'=>0,'Msg'=>'登录失效，请重新登录(openid参数有误)'));exit;
        }
        if(empty($order_id)){
            echo json_encode(array('state'=>0,'Msg'=>'自定义订单有误'));exit;
        }
  
        //商户支付信息
        $program_id			= M("user_info")->where("program_id='".$program_id."'")->find();
        $appid 				= $program_id["appid"];
        $body 				= '自己填';
// 		$mch_id				= '1490465072';
//		$appid				= 'wx22d43e5e8dc5955f';
//      $KEY 				= '051A9911DE7B5BBC610B76F4EDA834A0';
 		$mch_id 			= $program_id["shanghu_num"];
        $KEY 				= $program_id["pay_key"];
        $nonce_str 			= rand(1111111111,9999999999).",".$pay_state;//随机字符串
        $notify_url 		= 'https://sz800800.cn/index.php/Wxpay/xiao_notify_url';  //支付完成回调地址url,不能带参数
        $out_trade_no 		= $order_id;//商户订单号
        $spbill_create_ip 	= $_SERVER['SERVER_ADDR'];
        $trade_type 		= 'JSAPI';//交易类型 默认JSAPI
    
        //这里是按照顺序的 因为下面的签名是按照(字典序)顺序 排序错误 肯定出错
        $post['appid'] 				= $appid;
        $post['body'] 				= $body;
        $post['mch_id'] 			= $mch_id;
        $post['nonce_str']			= $nonce_str;//随机字符串
        $post['notify_url'] 		= $notify_url;
        $post['openid'] 			= $openid;
        $post['out_trade_no']		= $out_trade_no;
        $post['spbill_create_ip']	= $spbill_create_ip;    //服务器终端的ip
        $post['total_fee'] 			= intval($total_fee);          //总金额 最低为一分钱 必须是整数
        $post['trade_type'] 		= $trade_type;
        $sign = $this->MakeSign($post,$KEY);              //签名
        $this->sign = $sign;
    
        $post_xml = '<xml>
               <appid>'.$appid.'</appid>
               <body>'.$body.'</body>
               <mch_id>'.$mch_id.'</mch_id>
               <nonce_str>'.$nonce_str.'</nonce_str>
               <notify_url>'.$notify_url.'</notify_url>
               <openid>'.$openid.'</openid>
               <out_trade_no>'.$out_trade_no.'</out_trade_no>
               <spbill_create_ip>'.$spbill_create_ip.'</spbill_create_ip>
               <total_fee>'.$total_fee.'</total_fee>
               <trade_type>'.$trade_type.'</trade_type>
               <sign>'.$sign.'</sign>
            </xml> ';
    
        //统一下单接口prepay_id
        $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
        $xml = $this->http_request($url,$post_xml);     //POST方式请求http
        $array = $this->xml2array($xml);               //将【统一下单】api返回xml数据转换成数组，全要大写
        if($array['RETURN_CODE'] == 'SUCCESS' && $array['RESULT_CODE'] == 'SUCCESS'){
            $time = time();
            $tmp='';                            //临时数组用于签名
            $tmp['appId'] = $appid;
            $tmp['nonceStr'] = $nonce_str;
            $tmp['package'] = 'prepay_id='.$array['PREPAY_ID'];
            $tmp['signType'] = 'MD5';
            $tmp['timeStamp'] = "$time";
    
            $data['state'] = 1;
            $data['timeStamp'] = "$time";           //时间戳
            $data['nonceStr'] = $nonce_str;         //随机字符串
            $data['signType'] = 'MD5';              //签名算法，暂支持 MD5
            $data['package'] = 'prepay_id='.$array['PREPAY_ID'];   //统一下单接口返回的 prepay_id 参数值，提交格式如：prepay_id=*
            $data['paySign'] = $this->MakeSign($tmp,$KEY);       //签名,具体签名方案参见微信公众号支付帮助文档;
            $data['out_trade_no'] = $out_trade_no;
    
        }else{
            $data['state'] = 0;
            $data['text'] = "错误";
            $data['RETURN_CODE'] = $array['RETURN_CODE'];
            $data['RETURN_MSG'] = $array['RETURN_MSG'];
        }
        echo json_encode($data);
    }
    
     /**
     * 生成签名, $KEY就是支付key
     * @return 签名
     */
    public function MakeSign( $params,$KEY){
        //签名步骤一：按字典序排序数组参数
        ksort($params);
        $string = $this->ToUrlParams($params);  //参数进行拼接key=value&k=v
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=".$KEY;
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }
    /**
     * 将参数拼接为url: key=value&key=value
     * @param $params
     * @return string
     */
    public function ToUrlParams( $params ){
        $string = '';
        if( !empty($params) ){
            $array = array();
            foreach( $params as $key => $value ){
                $array[] = $key.'='.$value;
            }
            $string = implode("&",$array);
        }
        return $string;
    }
    
    /**
     * 调用接口， $data是数组参数
     * @return 签名
     */
    
    public function http_request($url,$data = null,$headers=array())
    {
        $curl = curl_init();
        if( count($headers) >= 1 ){
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
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
    
    //获取xml里面数据，转换成array
    private function xml2array($xml){
        $p = xml_parser_create();
        xml_parse_into_struct($p, $xml, $vals, $index);
        xml_parser_free($p);
        $data = "";
        foreach ($index as $key=>$value) {
            if($key == 'xml' || $key == 'XML') continue;
            $tag = $vals[$value[0]]['tag'];
            $value = $vals[$value[0]]['value'];
            $data[$tag] = $value;
        }
        return $data;
    }
    
    /**
     * 将xml转为array
     * @param string $xml
     * return array
     */
    public function xml_to_array($xml){
        if(!$xml){
            return false;
        }
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $data;
    }
    
    function post_data(){
		$receipt = $_REQUEST;
		if($receipt==null){
		$receipt = file_get_contents("php://input");
		if($receipt == null){
		$receipt = $GLOBALS['HTTP_RAW_POST_DATA'];
		}
		}
		return $receipt;
	}
 /* 微信支付完成，回调地址url方法  xiao_notify_url() */
    public function xiao_notify_url(){
    	
        $post 		= $this->post_data();    //接受POST数据XML个数
        $post_data 	= $this->xml_to_array($post);   //微信支付成功，返回回调地址url的数据：XML转数组Array
        $add["name"]="1111";
		$add["title"]=$post_data["out_trade_no"];
		M("test")->add($add);
//      $post_data["out_trade_no"]="JT20180508144007495225";
//      $post_data["nonce_str"]="1301597767,goods";
//$add["name"]=$post_data["out_trade_no"];
//$add["title"]=$post_data["total_fee"];
//M("test")->add($add);
    	
    	$state=explode(",",$post_data["nonce_str"]);

        $postSign = $post_data['sign'];
        unset($post_data['sign']);
        /* 微信官方提醒：
         *  商户系统对于支付结果通知的内容一定要做【签名验证】,
         *  并校验返回的【订单金额是否与商户侧的订单金额】一致，
         *  防止数据泄漏导致出现“假通知”，造成资金损失。
         */
        ksort($post_data);// 对数据进行排序
        $str = $this->ToUrlParams($post_data);//对数组数据拼接成key=value字符串
        $user_sign = strtoupper(md5($post_data));   //再次生成签名，与$postSign比较
        
        $where['crsNo'] = $post_data['out_trade_no'];
//      $order_status = M('home_order','xxf_witkey_')->where($where)->find();
        if($post_data['return_code']=='SUCCESS'&&$postSign){
			//支付成功后执行
			
			if($state[1]=="goods"){   
			
	    		//商品购买进入接口，回调处理订单
	    		$date["state"]		="2";
				$date["real_price"]	=$post_data["total_fee"]*0.01;
	    		$date["haved_end"]	="1";
	    		$date["time_fukuan"]=time();
				$group_order=M("order_form")->where("order_num='".$post_data["out_trade_no"]."'")->find();
				 	
				if($group_order["haved_end"]==1){
					if(empty($group_order["real_price"])){
						$daterealprice["state"]		="2";
						$daterealprice["real_price"]	=$post_data["total_fee"]*0.01;
						M("order_form")->where("group_order='".$group_order["group_order"]."'")->save($daterealprice);
					}
					
					
					$this->ajaxReturn("已经完成支付");
				} 	
				 	
				if(M("order_form")->where("group_order='".$group_order["group_order"]."'")->save($date)){
					if($group_order["program_id"]=="JT201802032149345468"){
						//易选购
						if($group_order["zhuanfa_id"]!=0){
							//是转发过来的 ，可以给转发上线打钱了
							$members_zhuanfa=M("members")->where("program_id='".$group_order["program_id"]."'"."and id='".$group_order["zhuanfa_id"]."'")->find();
							$where_forwarding["program_id"]=$group_order["program_id"];
							if($members_zhuanfa["vip_id"]!=0){
								$where_forwarding["is_vip"]="1";
							}else{
								$where_forwarding["is_vip"]="0";
							}
							$commission_per=M("members_forwarding")->where($where_forwarding)->find();
							M("members")->where("program_id='".$group_order["program_id"]."'"."and id='".$group_order["zhuanfa_id"]."'")->setInc("integral",$group_order["buy_price"]*0.01*$commission_per["commission_per"]);
						}
						
						if($group_order["is_pay_choose"]==2){
							//积分现金混合消费， 完成现金支付，将进行扣除积分操作 fx_yongjin_leiji
							M("members")->where("openid='".$group_order["openid"]."'"."and program_id='".$group_order["program_id"]."'")->setInc("integral",-$group_order["pay_integral"]);
						}else if($group_order["is_pay_choose"]==1){
							//现金支付，会得到积分返还
							$members0417=M("members")->where("openid='".$group_order["openid"]."'"."and program_id='".$group_order["program_id"]."'")->find();
							$cash_return=M("fx_goods_buy")->where("state=1 and program_id='".$group_order["program_id"]."'"."and lever_id='".$members0417["vip_id"]."'")->find();
						
							//积分返还给纯现金消费用户
							M("members")->where("openid='".$group_order["openid"]."'"."and program_id='".$group_order["program_id"]."'")->setInc("integral",$group_order["buy_price"]*0.01*$cash_return["cash_return"]);
						}
					}
					if($group_order["program_id"]=="JT201806151732369242"){
					//百业联盟，判断是否有积分消费，执行扣除积分操作	 执行使用消费券操作
						if($group_order["can_pay_integral_by"]==1){
							
							$members_integral=M("members")->field("integral,integral_song")->where("openid='".$group_order["openid"]."'"."and program_id='".$group_order["program_id"]."'")->find();
							if($members_integral["integral_song"]>$group_order["integralpay"]){
								$save_integral["integral_song"]=$members_integral["integral_song"]-$group_order["integralpay"];
							}else if($members_integral["integral_song"]<$group_order["integralpay"]){
								$save_integral["integral_song"]="0";
								$save_integral["integral"]=$members_integral["integral"]-($group_order["integralpay"]-$members_integral["integral_song"]);
							}
							M("members")->where("openid='".$group_order["openid"]."'"."and program_id='".$group_order["program_id"]."'")->save($save_integral);						
						}
						
							$coupon_dsh_record=M("coupon_dsh_record")->field("coupon_num")->where("state=0 and program_id='".$group_order["program_id"]."'"."and openid='".$group_order["openid"]."'")->order("id asc")->find();
	
							$save["state"]		=2;
							$save["time_fukuan"]=time();
							$save["coupon_num"]	=$coupon_dsh_record["coupon_num"];
							
							
							$save_2["state"]	=1;
							$save_2["time_used"]=time();
							$save["order_num"]	=$post_data["out_trade_no"];
							M("order_form")->where("order_num='".$post_data["out_trade_no"]."'")->save($save);
							M("coupon_dsh_record")->where("program_id='".$group_order["program_id"]."'"."and coupon_num='".$coupon_dsh_record["coupon_num"]."'")->save($save_2);
							
						
						
					}
					
					$order=M("order")->where("group_order='".$group_order["group_order"]."'")->select();
					for($r=0;$r<count($order);$r++){
						
						if($order[$r]["program_id"]=="JT201808090855119076"){
							//能量ktv 在线酒水购买，库存减少
								$goods_kc[$r]=M("goods")->field("ktv_kucun")->where("id='".$order[$r]["goods_id"]."'")->find();
								$goods_kcarr[$r]=json_decode($goods_kc[$r]["ktv_kucun"],true);
								foreach($goods_kcarr[$r] as $k[$r]=>$v[$r]){ 
									if($k[$r]==3){
										$goods_kcarr[$r][$k[$r]]=$v[$r]-$order[$r]["buy_num"];
									}
								}
								$save[$r]["ktv_kucun"]=json_encode($goods_kcarr[$r]);
								M("goods")->where("id='".$order[$r]["goods_id"]."'")->save($save[$r]);
							}
						
						//对每个订单的分销佣金进行分配====================================================================== fx_yongjin_leiji
						if($order[$r]["program_id"]=="JT201712021113483120"){
							//判断是不是蔡氏养生
							$members0116_1[$r]=M("members")->where("id='".$order[$r]["daili_uid_csys"]."'")->find();//上级	
							if($r==0){
								$date02["dfx_id"]=$order[$r]["daili_uid_csys"];
								M("order_form")->where("group_order='".$group_order["group_order"]."'")->save($date02);
							}	
								
							M("members")->where("id='".$order[$r]["daili_uid_csys"]."'")->setInc('fx_yongjin_leiji',$order[$r]['dfx_price01']);//一级佣金发放
							
							if($members0116_1[$r]["daili_uid_csys"]!=0){
								M("members")->where("id='".$members0116_1[$r]["daili_uid_csys"]."'")->setInc('fx_yongjin_leiji',$order[$r]['dfx_price02']);//2级佣金发放
							}
						}else{
							if($order[$r]["dfx_id"]!=0){								
							if($r==0){
								//订单的第一条数据
								$date02["dfx_id"]=$order[$r]["dfx_id"];
								M("order_form")->where("group_order='".$group_order["group_order"]."'")->save($date02);
							}			
							
								$members1223_1[$r]=M("members")->field("id,fx_uid")->where("id='".$order[$r]["dfx_id"]."'")->find();
						
								M("members")->where("id='".$order[$r]["dfx_id"]."'")->setInc('fx_yongjin_leiji',$order[$r]['dfx_price01']);//一级佣金发放
								
								
								if($members1223_1[$r]["fx_uid"]!=0){
									$members1223_2[$r]=M("members")->field("id,fx_uid")->where("id='".$members1223_1[$r]["fx_uid"]."'")->find();
									M("members")->where("id='".$members1223_1[$r]["fx_uid"]."'")->setInc('fx_yongjin_leiji',$order[$r]['dfx_price02']);//2级佣金发放
								
								}
								if($members1223_2[$r]["fx_uid"]!=0){
									$members1223_3[$r]=M("members")->where("id='".$members1223_2[$r]["fx_uid"]."'")->find();
									M("members")->where("id='".$members1223_2[$r]["fx_uid"]."'")->setInc('fx_yongjin_leiji',$order[$r]['dfx_price02']);//3级佣金发放
								
								}
							}
						}
		
						//找到对应商品，销量增加
						M("goods")->where("id='".$order[$r]["goods_id"]."'")->setInc("sell_num",$order[$r]["buy_num"]);
						//库存减少		
						if($order[$r]["is_use_guige"]==2){
							//启用规格，减少对应规格的库存
							$str1211=explode(",",$order[$r]["str_num"]);
							for($t=0;$t<count($str1211);$t++){
								if($order[$r]["guige_key"]==$t){
									$str1211[$t]=$str1211[$t]-$order[$r]["buy_num"];
								}
							}
							$arr1211["str_num"]=implode(",",$str1211);
							M("goods")->where("id='".$order[$r]["goods_id"]."'")->save($arr1211);
						}else{
							M("goods")->where("id='".$order[$r]["goods_id"]."'")->setInc("number",-$order[$r]["buy_num"]);
						}
					}		
				}
	    	}else if($state[1]=="car_order"){
	    		$date["state"]		="2";
				$date["time_pay"]	=time();
				$one_change=M("car_order")->where("order_num='".$post_data["out_trade_no"]."'")->find();
				if($one_change["state"]==1){
					M("car_order")->where("order_num='".$post_data["out_trade_no"]."'")->save($date);
				}
	    	}else if($state[1]=="dsh_pay_order"){
	    		$check_pay=M("record_total")->field("state")->where("order_num='".$post_data["out_trade_no"]."'")->find();
	    		if($check_pay["state"]==1){
	    			$save_0["state"]	="2";
	    			$save_0["time_pay"]	=time();
	    			$save_0["price"]	=$post_data["total_fee"]*0.01;
	    			
					$save_1["pay_state"]="2";
					M("record_total")->where("order_num='".$post_data["out_trade_no"]."'")->save($save_0);
					
					M("user_info_dsh")->where("order_num='".$post_data["out_trade_no"]."'")->save($save_1);
	    		}
	    		
	    	}else if($state[1]=="chongzhi"){
				$date["state"]="2";
				$date["time_pay"]=time();
				$date["real_price"]=$post_data["total_fee"]*0.01;
				$a=M("jt03_zx_record_cz")->field("id,openid,price,state")->where("order_num='".$post_data["out_trade_no"]."'")->find();	
				if($a["state"]==1){
					M("jt03_zx_record_cz")->where("order_num='".$post_data["out_trade_no"]."'")->save($date);
					M("members")->where("openid='".$a["openid"]."'")->setInc('integral',$a["price"]);
				}

	    	}else if($state[1]=="qdcode_pay"){
	    		//百业联盟是扫码微信支付
	    		
	    		
	    		
	    		$a0823=M("dsh_qdcode_chage")->field("dsh_qdcode_chage.state,dsh_qdcode_chage.order_price,dsh_qdcode_chage.from_id,dsh_qdcode_chage.dfx_price01,dsh_qdcode_chage.dfx_price02,dsh_qdcode_chage.dfx_price03,assistant_add.shop_id")
				->join("left join assistant_add on assistant_add.openid=dsh_qdcode_chage.openid_ass")
				->where("dsh_qdcode_chage.order_num='".$post_data["out_trade_no"]."'")->find();
	    		
	    		if($a0823["state"]==1){
					$this->ajaxReturn("已经完成支付");
				} 	
	    		
	    		$save["openid_cus"]	=$post_data["openid"];
				$save["time_pay"]	=time();
				$save["state"]		=1;
				$save["shop_id"]	=$a0823["shop_id"];
				
				M("dsh_qdcode_chage")->where("order_num='".$post_data["out_trade_no"]."'")->save($save);
				
				
//				分销佣金发放
				$members1223_1=M("members")->field("id,fx_uid")->where("id='".$a0823["from_id"]."'")->find();
						
				M("members")->where("id='".$a0823["from_id"]."'")->setInc('fx_yongjin_leiji',$a0823['dfx_price01']);//一级佣金发放
				
				
				if($members1223_1["fx_uid"]!=0){
					$members1223_2=M("members")->field("id,fx_uid")->where("id='".$members1223_1["fx_uid"]."'")->find();
					M("members")->where("id='".$members1223_1["fx_uid"]."'")->setInc('fx_yongjin_leiji',$a0823['dfx_price02']);//2级佣金发放
				
				}
				if($members1223_2["fx_uid"]!=0){
					$members1223_3=M("members")->where("id='".$members1223_2["fx_uid"]."'")->find();
					M("members")->where("id='".$members1223_2["fx_uid"]."'")->setInc('fx_yongjin_leiji',$a0823['dfx_price02']);//3级佣金发放
				
				}
				
	    	}else if($state[1]=="ktv_pay"){
	    		
				$date["state"]="1";
				$date["time_pay"]=time();
				$date["real_price"]=$post_data["total_fee"]*0.01;
				$a=M("room_orderbooking")->field("id,openid,price,state")->where("order_num='".$post_data["out_trade_no"]."'")->find();	
				if($a["state"]==0){
					M("room_orderbooking")->where("order_num='".$post_data["out_trade_no"]."'")->save($date);
//					M("members")->where("openid='".$a["openid"]."'")->setInc('integral',$a["price"]);
				}

	    	}else if($state[1]=="vip_pay"){
	    		
				$date["state"]="1";
				$date["time_pay"]=time();
				$date["real_price"]=$post_data["total_fee"]*0.01;
				$a=M("vip_order")->field("id,openid,price,state,vip_id")->where("order_num='".$post_data["out_trade_no"]."'")->find();	
				
				$save["vip_card_id"]=$a["vip_id"];
				if($a["state"]==0){
					M("vip_order")->where("order_num='".$post_data["out_trade_no"]."'")->save($date);
					M("members")->where("openid='".$a["openid"]."'")->save($save);
				}

	    	}
			/*
            * 首先判断，订单是否已经更新为ok，因为微信会总共发送8次回调确认
            * 其次，订单已经为ok的，直接返回SUCCESS
            * 最后，订单没有为ok的，更新状态为ok，返回SUCCESS
            */
            if($order_status['order_status']=='ok'){
                $this->return_success();
            }else{
                $updata['order_status'] = 'ok';
                if(M('home_order','xxf_witkey_')->where($where)->save($updata)){
                    $this->return_success();
                }
            }
			
        }else{
            echo '微信支付失败';
        }
    }
    
    /*
     * 给微信发送确认订单金额和签名正确，SUCCESS信息 -xzz0521
     */
    private function return_success(){
        $return['return_code'] = 'SUCCESS';
        $return['return_msg'] = 'OK';
        $xml_post = '<xml>
                <return_code>'.$return['return_code'].'</return_code>
                <return_msg>'.$return['return_msg'].'</return_msg>
                </xml>';
        echo $xml_post;exit;
    }
}
?>