<?php
namespace AdminSh\Controller;
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
		$where['dsh_id']=$_COOKIE["admin_dsh_id"];
		$where['time_build']=array(array('EGT',$stampt),array('ELT',$nt));
		
		$where1['program_id']=$_COOKIE["program_id"];
		$where1['dsh_id']=$_COOKIE["admin_dsh_id"];
		$where1['time_build']=array(array('EGT',$stampy),array('ELT',$stampt));
		
		$where2['program_id']=$_COOKIE["program_id"];
		$where2['dsh_id']=$_COOKIE["admin_dsh_id"];
		$where2['time_build']=array(array('EGT',$stampw),array('ELT',$nt));
		
		$where3['program_id']=$_COOKIE["program_id"];
		$where3['dsh_id']=$_COOKIE["admin_dsh_id"];
		$where3['time_build']=array(array('EGT',$stampm),array('ELT',$nt));
		$t=M('order_form')->field($field)->where($where)->find();//今天订单;
		$y=M('order_form')->field($field)->where($where1)->find();//昨天订单;
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
//	dump($data);
    	$this->display();
	}
	
	//待付款
	public function allder_fukuan(){
		$state=1;
        $list=$this->get_orderlist($state);
        $empty=empty($list)?1:0;
        $this->assign('empty',$empty);
		$this->assign('list',$list);
		
		
		$this->display();
	}
	//待发货
	public function allder_fahuo(){
		$state=2;
        $list=$this->get_orderlist($state);
        $empty=empty($list)?1:0;
        $this->assign('empty',$empty);
		$this->assign('list',$list);
		$this->display();
	}
	//待收货
	public function allder_shouhuo(){
		$state=3;
         $list=$this->get_orderlist($state);
        $empty=empty($list)?1:0;
        $this->assign('empty',$empty);
		$this->assign('list',$list);
		$this->display();
	}
	//已完成
	public function allder_wancehgn(){
		$state=7;
        $list=$this->get_orderlist($state);
        $empty=empty($list)?1:0;
        $this->assign('empty',$empty);
		$this->assign('list',$list);
		$this->display();
	}
	//已关闭
	public function allder_close(){
		$state=6;
         $list=$this->get_orderlist($state);
        $empty=empty($list)?1:0;
        $this->assign('empty',$empty);
		$this->assign('list',$list);
		$this->display();
	}
	//全部订单
	public function order_all(){
        $list=$this->get_orderlist($state);
        $empty=empty($list)?1:0;
        $this->assign('empty',$empty);
		$this->assign('list',$list);
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
	
	//关闭订单
	public function close_order(){
		$id=$_GET['id'];
		if(M('gzh_order_form')->where('id='.$id)->save(array('state'=>6))){
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
		if(M('gzh_order_form')->where('id='.$id)->save(array('state'=>2))){
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
		if(M('gzh_order_form')->where('id='.$id)->save(array('state'=>3))){
			if($_GET['act']){
				$this->success('操作成功',U('order_all'));
			}else{
				$this->success('操作成功',U('allder_fahuo'));
			}
		}else{
			$this->error('操作失败');
		}
	}
	//确认收货
	public function shouhuo_queren(){
		$id=$_GET['id'];
		if(M('gzh_order_form')->where('id='.$id)->save(array('state'=>7))){
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
		if(M('gzh_order_form')->where('id='.$id)->save(array('state'=>2))){
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
		if(M('gzh_order_form')->where('id='.$id)->save(array('state'=>3))){
			if($_GET['act']){
				$this->success('操作成功',U('order_all'));
			}else{
				$this->success('操作成功',U('allder_fahuo'));
			}
		}else{
			$this->error('操作失败');
		}
	}
	//--------------------------
	function get_orderlist($state=''){
        if($state!=''){
	        $where['gzh_order_form.state']=$state;
	        $whereall=array('state'=>$state,'gzh_id'=>$_COOKIE["gzh_id"]);	
	        }else{
	        $whereall=array('gzh_id'=>$_COOKIE["gzh_id"]);
	        }
		$where['gzh_order_form.gzh_id']=$_COOKIE["gzh_id"];
		$where['gzh_order_form.dsh_id']=$_COOKIE["admin_dsh_id"];
		
		$field='gzh_order_form.id,gzh_order_form.order_num,gzh_order_form.array_id,gzh_order_form.time_build,
		gzh_order_form.state,gzh_order_form.buy_price,gzh_order_form.dsh_id,
		        gzh_members.nickname,gzh_members.tel';
		$list=M('gzh_order_form')
		->group('gzh_order_form.id')
		->field($field)
		->join('gzh_members ON gzh_order_form.openid=gzh_members.openid')
		->where($where)
		->select();
		
		$f='gzh_order.id,gzh_order.buy_num,gzh_order.order_num,gzh_order.dsh_id,
		gzh_goods.goods_title,gzh_goods.price_sell,gzh_goods.image';
		$where1['gzh_order.gzh_id']=$_COOKIE["gzh_id"];
		$where1['gzh_order.dsh_id']=$_COOKIE["admin_dsh_id"];

		for($i=0;$i<count($list);$i++){
			$where1['_string']='gzh_order.id in('.substr($list[$i]['array_id'],0,strlen($list[$i]['array_id'])-1).')';

			$list[$i]['info']=M('gzh_order')
			->group('gzh_order.id')
			->field($f)
			->join('gzh_goods ON gzh_order.goods_id=gzh_goods.id')

			->where($where1)
			->select();
		}
		$list['sum']=M('gzh_order_form')
		->field('count(id) AS num,sum(buy_price) AS sum')
		->where($whereall)->find();

		return $list;

	}
	
	
	//订单详情
	function order_con(){

		//根据订单号查询到订单信息 state 交易状态(1：待付款、2：待发货、3：待收货、4：待评价、5：退换/售后、6：已关闭、7：已完成
        $field_order_form='
                gzh_order_form.id as order_form_id,gzh_order_form.order_num as order_form_order_num,
                gzh_order_form.openid as order_form_openid,gzh_order_form.shouhuo_id as order_form_shouhuo_id,
                gzh_order_form.array_id,gzh_order_form.buy_price,gzh_order_form.state,
		        
		        gzh_members.id as members_id,gzh_members.openid as members_openid,
		         gzh_man_shouhuo.id as man_shouhuo_id,gzh_man_shouhuo.man_shouhuo,gzh_man_shouhuo.man_phone,gzh_man_shouhuo.man_address
		        ';
		$a=M("order_form")
            ->field($field_order_form)
            ->join('gzh_members ON gzh_members.openid=gzh_order_form.openid')
            ->join('gzh_man_shouhuo ON gzh_man_shouhuo.id=gzh_order_form.shouhuo_id')
            ->where("gzh_order_num='".$_GET["order_num"]."'")
            ->find();
		//  订单下单的人信息


		//	订单里面的商品信息
		$chaifen=$this->chaifen($a["array_id"]);
		array_pop($chaifen);//删除数组中的最后一个元素

        //根据预购买表数组id  得到对应商品的信息，附加到该订单上
		for($p=0;$p<count($chaifen);$p++){
            $field_order='
                gzh_order.id as order_id,gzh_order.goods_id,gzh_order.buy_num as order_buy_num,
		        gzh_goods.id as goods_id,gzh_goods.goods_title,gzh_goods.price_sell,gzh_goods.image
		      
		        ';
                 $order[$p]=M("gzh_order")
               ->field($field_order)
               ->join('gzh_goods ON gzh_order.goods_id=gzh_goods.id')
             
                ->where("gzh_order.id='".$chaifen[$p]."'")
                ->find();
			}
		$a["id_arr"]=$order;

		$this->order_con=$a;

		$this->display();
		
	}
	
//分割函数
	 function chaifen($source){
        return explode(',',$source);
    }
}