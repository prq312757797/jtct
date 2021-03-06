<?php
namespace AdminP\Controller;
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
//	dump($data);DIE;
    	$this->display();
	}
	
	//待付款
	public function allder_fukuan(){
		
        $list=$this->get_orderlist_n($state=1);
        $empty=empty($list)?1:0;
        $this->assign('empty',$empty);
		
	//	$this->assign('list',$list);
		$this->list=$list["list"];
		$this->pages=$list["pages"];

		$this->display();
	}
	//待发货
	public function allder_fahuo(){
	
        $list=$this->get_orderlist_n($state=2);
        $empty=empty($list)?1:0;
        $this->assign('empty',$empty);
			$this->list=$list["list"];
		$this->pages=$list["pages"];
		
		//获取发货物流信息
		$this->kuaidi=M("express")->order("sort")->select();
		
		$this->display();
	}
	//待收货
	public function allder_shouhuo(){
	
         $list=$this->get_orderlist_n($state=3);
        $empty=empty($list)?1:0;
        $this->assign('empty',$empty);
		$this->list=$list["list"];
		$this->pages=$list["pages"];
		$this->display();
	}
	//已完成
	public function allder_wancehgn(){
		
        $list=$this->get_orderlist_n($state=7);
        $empty=empty($list)?1:0;
        $this->assign('empty',$empty);
		$this->list=$list["list"];
		$this->pages=$list["pages"];
		$this->display();
	}
	//待退款
	public function allder_tuikuan(){
		
         $list=$this->get_orderlist_n($state=5);
        $empty=empty($list)?1:0;
        $this->assign('empty',$empty);
		$this->list=$list["list"];
		$this->pages=$list["pages"];
		
		$this->display();
	}
	//已关闭
	public function allder_close(){
	
        $list=$this->get_orderlist_n($state=6);
        $empty=empty($list)?1:0;
        $this->assign('empty',$empty);
				$this->list=$list["list"];
		$this->pages=$list["pages"];
		$this->display();
	}

	
	//全部订单
	public function order_all(){
        $list=$this->get_orderlist_n();
      
        $empty=empty($list)?1:0;
        $this->assign('empty',$empty);
		$this->list=$list["list"];
		$this->pages=$list["pages"];
		
		
		$this->display();
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
	function get_orderlist_n($state=''){
      
	$field='order_form.id,order_form.order_num,order_form.array_id,order_form.time_build,order_form.state,order_form.buy_price,
	       order_form.dsh_id,order_form.dfx_id,order_form.dfx_price01,order_form.dfx_price02,order_form.dfx_price03,
	       order_form.is_change_price,order_form.change_price,order_form.state_tuikuan,order_form.real_price,order_form.pirce_tuikuan,
	       user_info_dsh.id as user_info_dsh_id,user_info_dsh.sh_name,
	       
	        members.nickname,members.tel
	        
	        ';

	
	$sql  =" SELECT  ".$field;
	$sql .=" FROM order_form ";
	$sql .=" left join members ON order_form.openid=members.openid";
	$sql .=" left join user_info_dsh ON order_form.dsh_id=user_info_dsh.id";
	$sql .=" WHERE order_form.program_id ='".$_COOKIE["program_id"]."'";
	 if($state!=''){
	 	$sql .=" and order_form.state ='".$state."'";
	 }

//	$sql .=" GROUP BY order_form.id ";
	$sql .=" order by order_form.time_build desc ";

		//$list = M("order_form") -> query($sql);
		//$total =count($list);
		$total =100;

	    $per = 5;
		$page = new \Component\Page($total, $per); 	
		$sql .=$page->limit;

	    $list = D("order_form") -> query($sql);
	    $pagelist = $page -> fpage();
//dump($list);
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
	
	//订单详情
	function order_con(){

		//根据订单号查询到订单信息 state 交易状态(1：待付款、2：待发货、3：待收货、4：待评价、5：退换/售后、6：已关闭、7：已完成
        $field_order_form='
                order_form.id as order_form_id,order_form.order_num as order_form_order_num,
                order_form.openid as order_form_openid,order_form.shouhuo_id as order_form_shouhuo_id, order_form.remark,
                order_form.array_id,order_form.buy_price,order_form.state,order_form.is_change_price,order_form.change_price,
		        
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
}