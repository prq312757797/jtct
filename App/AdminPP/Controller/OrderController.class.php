<?php
namespace AdminPP\Controller;
use Think\Controller;
header("Content-type: text/html; charset=utf-8"); 
class OrderController extends CommonController {
	//订单概述
    public function index(){
		$field='count(id) AS num,sum(buy_price) AS sum';
		$nt=time();                      //当前时间
		$stampt=strtotime(date('Y-m-d'));//今天凌晨时间戳
		$stampy=strtotime(date("Y-m-d",strtotime("-1 day")));//昨天凌晨时间戳
		$stampw=strtotime(date("Y-m-d",strtotime("-1 week")));//一周前的凌晨时间戳
		$stampm=strtotime(date("Y-m-d",strtotime("last month")));//一月前的凌晨时间戳
		
		$where['program_id']=$_COOKIE["program_id"];
		$where['state']=array("in","2,3,4,7");
		$where['time_build']=array(array('EGT',$stampt),array('ELT',$nt));
		
		$where1['program_id']=$_COOKIE["program_id"];
		$where1['state']=array("in","2,3,4,7");
		$where1['time_build']=array(array('EGT',$stampy),array('ELT',$stampt));
		
		$where2['program_id']=$_COOKIE["program_id"];
		$where2['state']=array("in","2,3,4,7");
		$where2['time_build']=array(array('EGT',$stampw),array('ELT',$nt));
		
		$where3['program_id']=$_COOKIE["program_id"];
		$where3['state']=array("in","2,3,4,7");
		$where3['time_build']=array(array('EGT',$stampm),array('ELT',$nt));
		$t=M('order_form')->field($field)->where($where)->find();//今天订单;
		$y=M('order_form')->field($field)->where($where1)->find();//昨天订单;
	//	$y=M('order_form')->where($where1)->select();//昨天订单;
	//	DUMP($y);die;
		$w=M('order_form')->field($field)->where($where2)->find();//近七日订单;
		$m=M('order_form')->field($field)->where($where3)->find();//近一个月订单;
		
		$t['avg']=round($t['sum']/$t['num'],2);//人均消费
		$y['avg']=round($y['sum']/$y['num'],2);
		$w['avg']=round($w['sum']/$w['num'],2);
		$m['avg']=round($m['sum']/$m['num'],2);
		unset($where['time_build']);
	    $arr=array(
	       1=>'dfk',
	       2=>'dfh',
	       3=>'dsh',
	       4=>'dpj',
	       5=>'th/sh',
	       6=>'ygb',
	       7=>'ywc'
	    );
		for($i=1;$i<=7;$i++){
			if($i==4||$i==5){
				continue;
			}else{
				$f='count(id) AS g';
				$where['state']=$i;
				$dd=M('order_form')->field($f)->where($where)->find();
				$$arr[$i]=$dd['g'];
			}
		}
		
		$data=array('t'=>$t,'y'=>$y,'w'=>$w,'m'=>$m,'dfk'=>$dfk,'dfh'=>$dfh,'dsh'=>$dsh,'ygb'=>$ygb,'ywc'=>$ywc);
	    $this->assign('data',$data);
	    

    	$this->display();
	}
	
	//待付款
	public function allder_fukuan(){
		
        $list=$this->get_orderlist_n($state=1,$order_num=$_GET["str"]);
        $empty=empty($list)?1:0;
        $this->assign('empty',$empty);
		$this->his_str=$_GET["str"];
	//	$this->assign('list',$list);

		$this->list=$list["list"];
		$this->pages=$list["pages"];
if($_GET["csv"]==1){
			$this->csv_list($state='1',$date_1=$_GET["date_1"],$date_2=$_GET["date_2"]);
		}
		$this->display();
	}
	//待发货
	public function allder_fahuo(){
	
        $list=$this->get_orderlist_n($state=2,$order_num=$_GET["str"]);
        $empty=empty($list)?1:0;
        $this->assign('empty',$empty);
		$this->his_str=$_GET["str"];
		$this->list=$list["list"];
		
	
		$this->pages=$list["pages"];
		$b=json_encode($list);
		$this->json_data=$b;
		//获取发货物流信息
		$this->kuaidi=M("express")->order("sort")->select();
		if($_GET["csv"]==1){
			$this->csv_list($state='2',$date_1=$_GET["date_1"],$date_2=$_GET["date_2"]);
		}
		$this->display();
	}
	//待收货
	public function allder_shouhuo(){
	
         $list=$this->get_orderlist_n($state=3,$order_num=$_GET["str"]);
        $empty=empty($list)?1:0;
         $this->assign('empty',$empty);
		$this->his_str=$_GET["str"];
		$this->list=$list["list"];
		$this->pages=$list["pages"];
		
		//获取发货物流信息
		$this->kuaidi=M("express")->order("sort")->select();
		if($_GET["csv"]==1){
			$this->csv_list($state='3',$date_1=$_GET["date_1"],$date_2=$_GET["date_2"]);
		}
		$this->display();
	}
	//待收货
	public function allder_pingjia(){
	
         $list=$this->get_orderlist_n($state=4,$order_num=$_GET["str"]);
        $empty=empty($list)?1:0;
         $this->assign('empty',$empty);
		$this->his_str=$_GET["str"];
		$this->list=$list["list"];
		$this->pages=$list["pages"];
		
		//获取发货物流信息
		$this->kuaidi=M("express")->order("sort")->select();
		if($_GET["csv"]==1){
			$this->csv_list($state='4',$date_1=$_GET["date_1"],$date_2=$_GET["date_2"]);
		}
		$this->display();
	}
	//已完成
	public function allder_wancehgn(){
		
        $list=$this->get_orderlist_n($state=7,$order_num=$_GET["str"]);
        $empty=empty($list)?1:0;
         $this->assign('empty',$empty);
		$this->his_str=$_GET["str"];
		$this->list=$list["list"];
		$this->pages=$list["pages"];
		if($_GET["csv"]==1){
			$this->csv_list($state='7',$date_1=$_GET["date_1"],$date_2=$_GET["date_2"]);
		}
		$this->display();
	}
	//待退款
	public function allder_tuikuan(){
		
         $list=$this->get_orderlist_n($state=5,$order_num=$_GET["str"]);
        $empty=empty($list)?1:0;
         $this->assign('empty',$empty);
		$this->his_str=$_GET["str"];
		$this->list=$list["list"];
		$this->pages=$list["pages"];
		if($_GET["csv"]==1){
			$this->csv_list($state='5',$date_1=$_GET["date_1"],$date_2=$_GET["date_2"]);
		}
		$this->display();
	}
	//已关闭
	public function allder_close(){
	
        $list=$this->get_orderlist_n($state=6,$order_num=$_GET["str"]);
        $empty=empty($list)?1:0;
         $this->assign('empty',$empty);
		$this->his_str=$_GET["str"];
				$this->list=$list["list"];
		$this->pages=$list["pages"];
		
		if($_GET["csv"]==1){
			$this->csv_list($state='6',$date_1=$_GET["date_1"],$date_2=$_GET["date_2"]);
		}
		$this->display();
	}

	
	//全部订单
	public function order_all(){
        $list=$this->get_orderlist_n($state='',$order_num=$_GET["str"]);
      
        $empty=empty($list)?1:0;
         $this->assign('empty',$empty);
		$this->his_str=$_GET["str"];
		$this->list=$list["list"];
		$this->pages=$list["pages"];
		
		if($_GET["csv"]==1){
			$this->csv_list($state='',$date_1=$_GET["date_1"],$date_2=$_GET["date_2"]);
		}
		
		
		$this->display();
	}
	function csv_list($state,$date_1,$date_2){
		$csv_list=$this->csv_order($state,$date_1,$date_2);
			for($i=0;$i<count($csv_list);$i++){
				$csv[$i]["order_num"]		=$csv_list[$i]["order_num"];
				$csv[$i]["price_all_a"]		=$csv_list[$i]["price_all_a"];
				$csv[$i]["man_shouhuo"]		=$csv_list[$i]["man_shouhuo"];
				$csv[$i]["man_phone"]		=$csv_list[$i]["man_phone"];
				if($csv_list[$i]["state"]==1){
					$csv_list[$i]["state_t"]="待付款";
				}else if($csv_list[$i]["state"]==2){
					$csv_list[$i]["state_t"]="待发货";
				}else if($csv_list[$i]["state"]==3){
					$csv_list[$i]["state_t"]="待收货";
				}else if($csv_list[$i]["state"]==4){
					$csv_list[$i]["state_t"]="待评价";
				}else if($csv_list[$i]["state"]==5){
					$csv_list[$i]["state_t"]="退换/售后";
				}else if($csv_list[$i]["state"]==6){
					$csv_list[$i]["state_t"]="已关闭";
				}else if($csv_list[$i]["state"]==7){
					$csv_list[$i]["state_t"]="已完成";
				}
				$csv[$i]["state"]			=$csv_list[$i]["state_t"];
				
				$csv[$i]["time_build"]		=($csv_list[$i]["time_build"])?date("Y-m-d H:i:s",$csv_list[$i]["time_build"]):'';
				$csv[$i]["time_fukuan"]		=($csv_list[$i]["time_fukuan"])?date("Y-m-d H:i:s",$csv_list[$i]["time_fukuan"]):''; 
				$csv[$i]["time_wancheng"]	=($csv_list[$i]["time_wancheng"])?date("Y-m-d H:i:s",$csv_list[$i]["time_wancheng"]):''; 
				$csv[$i]["time_pass"]		=($csv_list[$i]["time_pass"])?date("Y-m-d H:i:s",$csv_list[$i]["time_pass"]):''; 
				$csv[$i]["time_fahuo"]		=($csv_list[$i]["time_fahuo"])?date("Y-m-d H:i:s",$csv_list[$i]["time_fahuo"]):''; 
				$csv[$i]["time_registe_tk"]	=($csv_list[$i]["time_registe_tk"])?date("Y-m-d H:i:s",$csv_list[$i]["time_registe_tk"]):''; 
				$csv[$i]["time_tk_dk"]		=($csv_list[$i]["time_tk_dk"])?date("Y-m-d H:i:s",$csv_list[$i]["time_tk_dk"]):''; 
				
				$goods_info[$i]=$this->csv_in($csv_list[$i]["info"]);
				$csv[$i]["goods_info"]=$goods_info[$i];
			}
			$this->export_csv($csv);	die;	
	}
	
	function csv_in($info){
		for($i=0;$i<count($info);$i++){
			if($info[$i]["is_use_guige"]==2){
				$price_sell[$i]=$info[$i]["guige_price"];
			}else{
				$price_sell[$i]=$info[$i]["price_sell"];
			}
			if($i==0){
				$date=$info[$i]["goods_title"].":".$price_sell[$i]."*".$info[$i]["buy_num"];
			}else{
				$date.="、".$info[$i]["goods_title"].":".$price_sell[$i]."*".$info[$i]["buy_num"];
			}
		}
		
		return $date;
	}
	
	//维权申请
	public function weiquan_beg(){
		echo 888;
		$this->display();
	}
	//维权完成
	public function weiquan_over(){
		echo 999;
		$this->display();
	}
	//批量发货
	public function fahuo(){
		echo 999;
		$this->display();
	}
	
	//关闭订单 ["state"]=6
	public function close_order(){
		$id=$_GET['id'];
		if(M('order_form')->where('id='.$id)->save(array('state'=>6))){
			if($_GET['act']){
				$this->success('操作成功',U('order_all'));
			}else{
				$this->success('操作成功',U('allder_fukuan'));
			}
		}else{
			$this->error('操作失败');
		}
	}
	
	//确认付款
	public function fukuan(){
		$id=$_GET['id'];
		$group_order=M('order_form')->where('id='.$id)->find();
		if(M('order_form')->where('id='.$id)->save(array('state'=>2))){
				$order=M("order")->where("group_order='".$group_order["group_order"]."'")->select();
				for($r=0;$r<count($order);$r++){
					
					if($order[$r]["dfx_id"]!=0){
						$members1223_1[$r]=M("members")->where("id='".$order[$r]["dfx_id"]."'")->find();		
						M("members")->where("id='".$order[$r]["dfx_id"]."'")->setInc('fx_yongjin_leiji',$order[$r]['dfx_price01']);//一级佣金发放
					
						if($members1223_1[$r]["dfx_id"]!=0){
							$members1223_2[$r]=M("members")->where("id='".$members1223_1[$r]["dfx_id"]."'")->find();
							M("members")->where("id='".$members1223_1[$r]["dfx_id"]."'")->setInc('fx_yongjin_leiji',$order[$r]['dfx_price02']);//2级佣金发放
						
						}
						if($members1223_2[$r]["dfx_id"]!=0){
							$members1223_3=M("members")->where("id='".$members1223_2[$r]["dfx_id"]."'")->find();
							M("members")->where("id='".$members1223_2[$r]["dfx_id"]."'")->setInc('fx_yongjin_leiji',$order[$r]['dfx_price02']);//3级佣金发放
						
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
			
			if($_GET['act']){
				$this->success('操作成功',U('order_all'));
			}else{
				$this->success('操作成功',U('allder_fukuan'));
			}
		}else{
			$this->error('操作失败');
		}
	}
	//确认发货
	public function fahuo_queren(){
		$id=$_GET['id'];
		if(M('order_form')->where('id='.$id)->save(array('state'=>3))){
			if($_GET['act']){
				$this->success('操作成功',U('order_all'));
			}else{
				$this->success('操作成功',U('allder_fahuo'));
			}
		}else{
			$this->error('操作失败');
		}
	}
	 
	//异步发货 打开页面  
	function ajax_kuaidi(){
$field='order_form.order_num,order_form.shouhuo_id,
	
			man_shouhuo.id as man_shouhuo_id,man_shouhuo.man_shouhuo,man_shouhuo.man_phone,man_shouhuo.man_address
	
		        ';

		$order_form=M("order_form")
		->field($field)
		->join('left join man_shouhuo ON man_shouhuo.id=order_form.shouhuo_id')
		->where("order_num='".$_POST["order_num"]."'")
		->find();
		$this->ajaxReturn($order_form);
	}
	
	//异步发货 内容提交
	function ajax_kd_submit(){
		$save["express_num"]=$_POST["express_num"];//快递单号   
		$save["express_id"]=$_POST["express_id"];
		$save["time_fahuo"]=time();
		$save["state"]="3";
		if(M("order_form")->where("order_num='".$_POST["order_num"]."'")->save($save)){
			$date="1";
		}else{
			$date="2";
		}
		$this->ajaxReturn($date);
	}

//异步查看物流信息
	function ajax_wuliu_con(){
		//得到订单号就可以连表查快递公司的编号，加上运单号就可以了
		$field='order_form.order_num,order_form.express_id,order_form.express_num,
	
			express.id as express_id,express.name,express.code

		        ';
		$wuliu=M("order_form")
		->field($field)
		->join('left join express ON express.id=order_form.express_id')
		->where("order_num='".$_POST["order_num"]."'")
		->find();
		
		$this->ajaxReturn($wuliu);
	}
	
	//确认收货
	public function shouhuo_queren(){
		$id=$_GET['id'];
		if(M('order_form')->where('id='.$id)->save(array('state'=>7))){
			if($_GET['act']){
				$this->success('操作成功',U('order_all'));
			}else{
				$this->success('操作成功',U('allder_shouhuo'));
			}
		}else{
			$this->error('操作失败');
		}
	}
	//取消发货
	public function del_fahuo(){
		$id=$_GET['id'];
		if(M('order_form')->where('id='.$id)->save(array('state'=>2))){
			if($_GET['act']){
				$this->success('操作成功',U('order_all'));
			}else{
				$this->success('操作成功',U('allder_fahuo'));
			}
		}else{
			$this->error('操作失败');
		}
	}
	//取消收货
	public function del_shouhuo(){
		$id=$_GET['id'];
		if(M('order_form')->where('id='.$id)->save(array('state'=>3))){
			if($_GET['act']){
				$this->success('操作成功',U('order_all'));
			}else{
				$this->success('操作成功',U('allder_fahuo'));
			}
		}else{
			$this->error('操作失败');
		}
	}
	//--------------------------price
	function get_orderlist($state=''){
        if($state!=''){
       		$where['order_form.state']=$state;
       	 	$whereall=array('state'=>$state,'program_id'=>$_COOKIE["program_id"]);	
        }else{
        	$whereall=array('program_id'=>$_COOKIE["program_id"]);
        }
		$where['order_form.program_id']=$_COOKIE["program_id"];
		$field='order_form.id,order_form.order_num,order_form.array_id,order_form.time_build,order_form.state,order_form.buy_price,
		       order_form.dsh_id,order_form.dfx_id,order_form.dfx_price01,order_form.dfx_price02,order_form.dfx_price03,
		       order_form.is_change_price,order_form.change_price,order_form.state_tuikuan,order_form.real_price,order_form.pirce_tuikuan,
		       user_info_dsh.id as user_info_dsh_id,user_info_dsh.sh_name,
		       
		        members.nickname,members.tel
		        
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
		 order.is_use_guige,order.guige_key02,order.guige_name02,order.guige_key,order.guige_price,
                order.guige_name,order.is_on_lever_price,order.members_price_discount,
		order.wholesale_discount,
		
		goods.id as goods_id_id,goods.goods_title,goods.price_sell,goods.image,goods.is_on_wholesale_discount  
		';
		$where1['order.program_id']=$_COOKIE["program_id"];

		for($i=0;$i<count($list);$i++){
			$where1['_string']='order.id in('.substr($list[$i]['array_id'],0,strlen($list[$i]['array_id'])-1).')';

			$list[$i]['info']=M('order')
			->group('order.id')
			->field($f)
			->join('goods ON order.goods_id=goods.id')

			->where($where1)
			->select();
			
			//单个订单的总价
			$list[$i]['price_all_a']=0;
			for($k=0;$k<count($list[$i]['info']);$k++){
				$arr1102=explode(",",$list[$i]['info'][$k]['image']);
				$list[$i]['info'][$k]["image"]=$arr1102[0];
				 //单个商品总价
					//$price_all[$k]=0;		
					$list[$i]['info'][$k]["price_all"]	=0;
			//启用规格========================	
			
					if($list[$i]['info'][$k]["is_use_guige"]==1){
						//不启用规格
						$goods_price1218= $list[$i]['info'][$k]["price_sell"];
					}else if($list[$i]['info'][$k]["is_use_guige"]==2){
						//启用规格
						$goods_price1218= $list[$i]['info'][$k]["guige_price"];	
					}
			//会员价==========================
					if($list[$i]['info'][$k]["is_on_lever_price"]==1){
						//启用会员价
						$goods_price1218=$goods_price1218*$list[$i]['info'][$k]["members_price_discount"];
					}else{
						//不启用会员价
						$goods_price1218;
					}
			//购买数量折扣=====================		info
					if($list[$i]['info'][$k]["is_on_wholesale_discount"]==1){
						//启用购买数量折扣
						
							$wholesale_discount[$i][$k]=M("wholesale_discount")->where("goods_id='".$list[$i]['info'][$k]['goods_id_id']."'")->select();
			
							for($q1216=0;$q1216<count($wholesale_discount[$i][$k]);$q1216++){
								$num_1=$list[$i]['info'][$k]["buy_num"];
								$num_2=$wholesale_discount[$i][$k][$q1216]["num_start"];
								$num_3=$wholesale_discount[$i][$k][$q1216]["num_end"];
								
								if(($num_1>$num_2 | $num_1==$num_2) & $num_1<$num_3){
									$wholesale_d[$i][$k]=	$wholesale_discount[$i][$k][$q1216]["discount"];
								}
							}				

					if(strpos($wholesale_d[$i][$k],"/")){
						
						$arr0115=explode("/",$wholesale_d[$i][$k]);
						$wholesale_d[$i][$k]=$arr0115[0]/$arr0115[1];
					}else{
						$wholesale_d[$i][$k];
					}	

						$goods_price1218=$goods_price1218*$wholesale_d[$i][$k];

						}else{
							//不启用购买数量折扣
							$goods_price1218;
						}
						//dump($goods_price1218);
						$list[$i]['info'][$k]["price_sell"]	=$goods_price1218;
					//	$list[$i]['info'][$k]["price_all"]+=$goods_price1218*$list[$i]['info'][$k]["buy_num"];
				$list[$i]['price_all_a']+=$goods_price1218*$list[$i]['info'][$k]["buy_num"];
				}

		}

		$list['sum']=M('order_form')
		->field('count(id) AS num,sum(buy_price) AS sum')
		->where($whereall)->find();

	//dump($list);die;

		return $list;

	}
	function get_orderlist_n($state='',$order_num){
      
$field='order_form.id,order_form.order_num,order_form.array_id,order_form.time_build,order_form.time_fukuan,order_form.time_wancheng,
		order_form.time_pass,order_form.time_fahuo,order_form.time_registe_tk,order_form.time_tk_dk,order_form.pay_method,
		order_form.state,order_form.buy_price,order_form.float_num,order_form.sh_zhekou,order_form.price_sh,
        order_form.dsh_id,order_form.dfx_id,order_form.dfx_price01,order_form.dfx_price02,order_form.dfx_price03,order_form.express_num,
        order_form.is_change_price,order_form.change_price,order_form.state_tuikuan,order_form.real_price,order_form.pirce_tuikuan,
        
        user_info_dsh.id as user_info_dsh_id,user_info_dsh.sh_name,
       
	    express.name as express_num_name,
	    man_shouhuo.man_shouhuo,man_shouhuo.man_phone,
	    
        members.nickname,members.tel
        ';

	
//		$sql  =" SELECT  ".$field;
		$sql .=" FROM order_form ";
		$sql .=" left join members ON order_form.openid=members.openid";
		$sql .=" left join user_info_dsh ON order_form.dsh_id=user_info_dsh.id";
		$sql .=" left join express ON express.id=order_form.express_id";
		$sql .=" left join man_shouhuo ON man_shouhuo.id=order_form.shouhuo_id";
		$sql .=" WHERE order_form.program_id ='".$_COOKIE["program_id"]."'";
		
		if($order_num){
			$sql .=" and order_form.order_num ='".$order_num."'";
		}
		 if($state!=''){
		 	$sql .=" and order_form.state ='".$state."'";
		 }
	
		$sql .=" order by order_form.time_build desc ";

	
		$sql_01=$sql;
		$sql_02=$sql;
		$sql_01  =" select count(order_form.id)" .$sql_01;
		$sql_02  =" SELECT  ".$field .$sql_02;
		$list = M("order_form") -> query($sql_01);
		$total =$list[0]["count(order_form.id)"];
	
	    $per = 5;
		$page = new \Component\Page($total, $per); 	
		$sql_02 .=$page->limit;

	    $list = D("order_form") -> query($sql_02);
		
	    $pagelist = $page -> fpage();

//$dos = array_map(create_function('$n', 'return $n["time_build"];'), $list);
//array_multisort($dos,SORT_DESC,$list);
//		
//dump($list);die;
		
		
		$f='order.id,order.buy_num,order.order_num,
		 order.is_use_guige,order.guige_key02,order.guige_name02,order.guige_key,order.guige_price,
                order.guige_name,order.is_on_lever_price,order.members_price_discount,
		order.wholesale_discount,
		
		goods.id as goods_id_id,goods.goods_title,goods.price_sell,goods.image,goods.is_on_wholesale_discount  
		';
		$where1['order.program_id']=$_COOKIE["program_id"];
	
		for($i=0;$i<count($list);$i++){
	$st_n=substr($list[$i]['array_id'],0,strlen($list[$i]['array_id'])-1);
	
			$where1['_string']='order.id in('.$st_n.')';
//$where1['_string']='order.id in('.substr($list[$i]['array_id'],0,strlen($list[$i]['array_id'])-1).')';
		

			$list[$i]['info']=M('order')
			->group('order.id')
			->field($f)
			->join('goods ON order.goods_id=goods.id')

			->where($where1)
			->select();
		
			//单个订单的总价
			$list[$i]['price_all_a']=0;
			for($k=0;$k<count($list[$i]['info']);$k++){
				$arr1102=explode(",",$list[$i]['info'][$k]['image']);
				$list[$i]['info'][$k]["image"]=$arr1102[0];
				 //单个商品总价
					//$price_all[$k]=0;		
					$list[$i]['info'][$k]["price_all"]	=0;
			//启用规格========================	
			
					if($list[$i]['info'][$k]["is_use_guige"]==1){
						//不启用规格
						$goods_price1218= $list[$i]['info'][$k]["price_sell"];
					}else if($list[$i]['info'][$k]["is_use_guige"]==2){
						//启用规格
						$goods_price1218= $list[$i]['info'][$k]["guige_price"];	
					}
			//会员价==========================
					if($list[$i]['info'][$k]["is_on_lever_price"]==1){
						//启用会员价
						$goods_price1218=$goods_price1218*$list[$i]['info'][$k]["members_price_discount"];
					}else{
						//不启用会员价
						$goods_price1218;
					}
			//购买数量折扣=====================		info
				
					if($list[$i]['info'][$k]["is_on_wholesale_discount"]==1){
						//启用购买数量折扣
						
							$wholesale_discount[$i][$k]=M("wholesale_discount")->where("goods_id='".$list[$i]['info'][$k]['goods_id_id']."'")->select();
			
							for($q1216=0;$q1216<count($wholesale_discount[$i][$k]);$q1216++){
								$num_1=$list[$i]['info'][$k]["buy_num"];
								$num_2=$wholesale_discount[$i][$k][$q1216]["num_start"];
								$num_3=$wholesale_discount[$i][$k][$q1216]["num_end"];
								
								if(($num_1>$num_2 | $num_1==$num_2) & $num_1<$num_3){
									$wholesale_d[$i][$k]=	$wholesale_discount[$i][$k][$q1216]["discount"];
								}
							}				

					if(strpos($wholesale_d[$i][$k],"/")){
						
						$arr0115=explode("/",$wholesale_d[$i][$k]);
						$wholesale_d[$i][$k]=$arr0115[0]/$arr0115[1];
					}else{
						$wholesale_d[$i][$k];
					}	

						$goods_price1218=$goods_price1218*$wholesale_d[$i][$k];

						}else{
							//不启用购买数量折扣
							$goods_price1218;
						}
						
					
						//dump($goods_price1218);
						$list[$i]['info'][$k]["price_sell"]	=$goods_price1218;
					//	$list[$i]['info'][$k]["price_all"]+=$goods_price1218*$list[$i]['info'][$k]["buy_num"];
				$list[$i]['price_all_a']+=$goods_price1218*$list[$i]['info'][$k]["buy_num"];
						
				}

		}

  if($state!=''){
       	 	$whereall=array('state'=>$state,'program_id'=>$_COOKIE["program_id"]);	
        }else{
        	$whereall=array('program_id'=>$_COOKIE["program_id"]);
        }
//		$list['sum']=M('order_form')
//		->field('count(id) AS num,sum(buy_price) AS sum')
//		->where($whereall)->find();

		$data["list"]=$list;
		$data["pages"]=$pagelist;
		return $data;

	}
	function csv_order($state,$date_1,$date_2){
      
$field='order_form.id,order_form.order_num,order_form.array_id,order_form.time_build,order_form.time_fukuan,order_form.time_wancheng,
		order_form.time_pass,order_form.time_fahuo,order_form.time_registe_tk,order_form.time_tk_dk,order_form.pay_method,
		order_form.state,order_form.buy_price,order_form.float_num,order_form.sh_zhekou,order_form.price_sh,
        order_form.dsh_id,order_form.dfx_id,order_form.dfx_price01,order_form.dfx_price02,order_form.dfx_price03,order_form.express_num,
        order_form.is_change_price,order_form.change_price,order_form.state_tuikuan,order_form.real_price,order_form.pirce_tuikuan,
        
        user_info_dsh.id as user_info_dsh_id,user_info_dsh.sh_name,
       
	    express.name as express_num_name,
	    man_shouhuo.man_shouhuo,man_shouhuo.man_phone,
	    
        members.nickname,members.tel
        ';

	
		$sql  =" SELECT  ".$field;
		$sql .=" FROM order_form ";
		$sql .=" left join members ON order_form.openid=members.openid";
		$sql .=" left join user_info_dsh ON order_form.dsh_id=user_info_dsh.id";
		$sql .=" left join express ON express.id=order_form.express_id";
		$sql .=" left join man_shouhuo ON man_shouhuo.id=order_form.shouhuo_id";
		$sql .=" WHERE order_form.program_id ='".$_COOKIE["program_id"]."'";

		if($state!=''){
			$sql .=" and order_form.state ='".$state."'";
		}
		if(strtotime($date_1)){ 
			$sql .=" and order_form.time_build >'".strtotime($date_1." 00:00:00")."'";
		}
		if(strtotime($date_2)){
			$sql .=" and order_form.time_build <'".strtotime($date_2." 23:59:59")."'";
		}
	
		$sql .=" order by order_form.time_build desc ";
		$list = M("order_form") -> query($sql);		
		
		

		
		$f='order.id,order.buy_num,order.order_num,
		 order.is_use_guige,order.guige_key02,order.guige_name02,order.guige_key,order.guige_price,
                order.guige_name,order.is_on_lever_price,order.members_price_discount,
		order.wholesale_discount,
		
		goods.id as goods_id_id,goods.goods_title,goods.price_sell,goods.image,goods.is_on_wholesale_discount  
		';
		$where1['order.program_id']=$_COOKIE["program_id"];
	
		for($i=0;$i<count($list);$i++){
		$st_n=substr($list[$i]['array_id'],0,strlen($list[$i]['array_id'])-1);
	
			$where1['_string']='order.id in('.$st_n.')';
			$list[$i]['info']=M('order')
			->group('order.id')
			->field($f)
			->join('goods ON order.goods_id=goods.id')
			->where($where1)
			->select();
		
			//单个订单的总价
			$list[$i]['price_all_a']=0;
			for($k=0;$k<count($list[$i]['info']);$k++){
				$arr1102=explode(",",$list[$i]['info'][$k]['image']);
				$list[$i]['info'][$k]["image"]=$arr1102[0];
				//$price_all[$k]=0;		
				$list[$i]['info'][$k]["price_all"]	=0;

				if($list[$i]['info'][$k]["is_use_guige"]==1){//不启用规格
					$goods_price1218= $list[$i]['info'][$k]["price_sell"];
				}else if($list[$i]['info'][$k]["is_use_guige"]==2){//启用规格						
					$goods_price1218= $list[$i]['info'][$k]["guige_price"];	
				}
				if($list[$i]['info'][$k]["is_on_lever_price"]==1){	//启用会员价					
					$goods_price1218=$goods_price1218*$list[$i]['info'][$k]["members_price_discount"];
				}else{//不启用会员价						
					$goods_price1218;
				}
				if($list[$i]['info'][$k]["is_on_wholesale_discount"]==1){
					//启用购买数量折扣
					$wholesale_discount[$i][$k]=M("wholesale_discount")->where("goods_id='".$list[$i]['info'][$k]['goods_id_id']."'")->select();
	
					for($q1216=0;$q1216<count($wholesale_discount[$i][$k]);$q1216++){
						$num_1=$list[$i]['info'][$k]["buy_num"];
						$num_2=$wholesale_discount[$i][$k][$q1216]["num_start"];
						$num_3=$wholesale_discount[$i][$k][$q1216]["num_end"];
						
						if(($num_1>$num_2 | $num_1==$num_2) & $num_1<$num_3){
							$wholesale_d[$i][$k]=	$wholesale_discount[$i][$k][$q1216]["discount"];
						}
					}				
					if(strpos($wholesale_d[$i][$k],"/")){
						
						$arr0115=explode("/",$wholesale_d[$i][$k]);
						$wholesale_d[$i][$k]=$arr0115[0]/$arr0115[1];
					}else{
						$wholesale_d[$i][$k];
					}	
					$goods_price1218=$goods_price1218*$wholesale_d[$i][$k];
				}else{//不启用购买数量折扣
					$goods_price1218;
				}
				$list[$i]['info'][$k]["price_sell"]	=$goods_price1218;
				$list[$i]['price_all_a']+=$goods_price1218*$list[$i]['info'][$k]["buy_num"];						
			}
		}

  		if($state!=''){
       	 	$whereall=array('state'=>$state,'program_id'=>$_COOKIE["program_id"]);	
        }else{
        	$whereall=array('program_id'=>$_COOKIE["program_id"]);
        }

		return $list;
		
	}
	//订单详情
	function order_con(){

		//根据订单号查询到订单信息 state 交易状态(1：待付款、2：待发货、3：待收货、4：待评价、5：退换/售后、6：已关闭、7：已完成 
        $field_order_form='
                order_form.id as order_form_id,order_form.order_num as order_form_order_num,
                order_form.openid as order_form_openid,order_form.shouhuo_id as order_form_shouhuo_id, order_form.remark,
                order_form.array_id,order_form.buy_price,order_form.state,order_form.is_change_price,order_form.change_price,order_form.real_price,
		        
		        members.id as members_id,members.openid as members_openid,members.nickname,
		         man_shouhuo.id as man_shouhuo_id,man_shouhuo.man_shouhuo,man_shouhuo.man_phone,man_shouhuo.man_area,man_shouhuo.man_address
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
            //   ->join('left join goods_img ON goods_img.goods_id=goods.id')
                ->where("order.id='".$chaifen[$p]."'")
                ->find();
                
                $arr1102=explode(",",$order[$p]['image']);
				$order[$p]["image"]=$arr1102[0];
			}
		$a["id_arr"]=$order;

		$this->order_con=$a;

		$this->display();
		
	}
	
//分割函数
	 function chaifen($source){
        return explode(',',$source);
    }
    
   //修改订单价格
	 function change_price(){
	 	$save["is_change_price"]=1;
        $save["change_price"]=$_POST["price"];
        
        if(M("order_form")->where("order_num='".$_POST["order_num"]."'")->save($save)){
			$date="1";
		}else{
			$date="2";
		}
		$this->ajaxReturn($date);
    } 
    
    //添加备注
function text_remark(){
		$save["remark"]=$_POST["remark"];
     
        
        if(M("order_form")->where("order_num='".$_POST["order_num"]."'")->save($save)){
			$date="1";
		}else{
			$date="2";
		}
		$this->ajaxReturn($date);
}


	//退款完成借口
	
	function tk_finish(){

		$save["state_tuikuan"]=1;
		$save["pirce_tuikuan"]=$_POST["pirce_tuikuan"];
		
		M("order_form")->where("order_num='".$_POST["order_num"]."'")->save($save);

		$date=1;
		$this->ajaxReturn($date);
	}
	// 核销订单列表
   function order_hexiao(){
// 		M("dsh_qdcode_chage")->where("program_id='".$_COOKIE["program_id"]."'")->select();

		$field="dsh_qdcode_chage.state,dsh_qdcode_chage.time_pay,dsh_qdcode_chage.order_price,dsh_qdcode_chage.order_num,dsh_qdcode_chage.state_hexiao,
		user_info_dsh.sh_name,	
		(case when discuss.star then discuss.star else 0 end) as star
		
		";
		$integral_search=M("dsh_qdcode_chage")->field($field)
		->join("left join user_info_dsh on user_info_dsh.id=dsh_qdcode_chage.shop_id")
		->join("left join discuss on discuss.order_num=dsh_qdcode_chage.order_num")
    	->where("dsh_qdcode_chage.state=1 and dsh_qdcode_chage.program_id='".$_COOKIE["program_id"]."'")
   		->order("dsh_qdcode_chage.time_pay desc")
    	->select();	
    	
    	$this->list=$integral_search;
    	
//  	dump($integral_search);die;
    	$this->display();
   }
   function action_hexiao(){
   		$save["state_hexiao"]="1";
     
        
        if(M("dsh_qdcode_chage")->where("order_num='".$_POST["order_num"]."'")->save($save)){
			$date="1";
		}else{
			$date="2";
		}
		$this->ajaxReturn($date);
   	
   }
   
    public function order_csv(){
    	

    
	$csvData = M('order_form')->order("id")->select();
	
	$this->export_csv($csvData);
	
	}
   /**
	 * 导出csv  开始
	 * */
	public function export_csv($csvData){
		$time = date('Y-m-d H:i:s', time());	
		
	
		$str = "订单号,总价,收货人,联系电话,订单状态,订单建立时间,订单付款时间,订单完成时间,订单取消时间,发货时间,申请退款时间,退款时间,商品信息\n";
			
		$str = iconv('utf-8', 'gb2312', $str);

		foreach ($csvData as $item) {
			$a1 = iconv('utf-8', 'gb2312', $item['order_num']);

			$a2 = iconv('utf-8', 'gb2312', $item['price_all_a']);
			$a3 = iconv('utf-8', 'gb2312', $item['man_shouhuo']);
			$a4 = iconv('utf-8', 'gb2312', $item['man_phone']);
			$a5 = iconv('utf-8', 'gb2312', $item['state']);
			$a6 = iconv('utf-8', 'gb2312', $item['time_build']);
			$a7 = iconv('utf-8', 'gb2312', $item['time_fukuan']);
			$a8 = iconv('utf-8', 'gb2312', $item['time_wancheng']);
			$a9 = iconv('utf-8', 'gb2312', $item['time_pass']);
			$a10 = iconv('utf-8', 'gb2312', $item['time_fahuo']);
			$a11 = iconv('utf-8', 'gb2312', $item['time_registe_tk']);
			$a12 = iconv('utf-8', 'gb2312', $item['time_tk_dk']);
			$a13 = iconv('utf-8', 'gb2312', $item['goods_info']);
			$str .= $a1 . "," . $a2 . "," . $a3 . "," . $a4 . "," . $a5 . "," . $a6 . "," . $a7 ."," . $a8 . "," . $a9 ."," . $a10 ."," . $a11 ."," . $a12 ."," . $a13 ."\n";
		}

		$jiange= " , , , , , , , , , , \n";//间隔
		$bottom_remark = iconv('utf-8', 'gb2312', "订单记录 \n");
		$filename = '下载于' . $time . '订单记录.csv';
		$this->export_filename($filename, $str);
		$this->export_filename($filename, $jiange);
		$this->export_filename($filename, $bottom_remark);
	}
	

	public function export_filename($filename,$data){
		header("Content-type:text/csv");
		header("Content-Disposition:attachment;filename=" . $filename);
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
		header('Expires:0');
		header('Pragma:public');
		echo $data;
	}
	/**
	 * 导出csv  结束
	 * */
}