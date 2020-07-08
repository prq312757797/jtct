<?php
namespace AdminPnew\Controller;
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
		$where['time_build']=array(array('EGT',$stampt),array('ELT',$nt));
		
		$where1['program_id']=$_COOKIE["program_id"];
		$where1['time_build']=array(array('EGT',$stampy),array('ELT',$stampt));
		
		$where2['program_id']=$_COOKIE["program_id"];
		$where2['time_build']=array(array('EGT',$stampw),array('ELT',$nt));
		
		$where3['program_id']=$_COOKIE["program_id"];
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
		
		//获取发货物流信息
		$this->kuaidi=M("express")->order("sort")->select();
		
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
       
      // dump($list);die;	
      
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
		if(M('order_form')->where('id='.$id)->save(array('state'=>2))){
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
	//--------------------------
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
		goods.goods_title,goods.price_sell,goods.image
		';
		$where1['order.program_id']=$_COOKIE["program_id"];
//		$where1['order.order_num']=array('neq',0);
		for($i=0;$i<count($list);$i++){
			$where1['_string']='order.id in('.substr($list[$i]['array_id'],0,strlen($list[$i]['array_id'])-1).')';
//			$where1['order.order_num']=$list[$i]['order_num'];
			$list[$i]['info']=M('order')
			->group('order.id')
			->field($f)
			->join('goods ON order.goods_id=goods.id')
			//->join('goods_img ON order.goods_id=goods_img.goods_id')
//			->join('members ON order.cus_openid=members.openid')
			->where($where1)
			->select();
			
		
			for($k=0;$k<count($list[$i]['info']);$k++){
					$arr1102=explode(",",$list[$i]['info'][$k]['image']);
					$list[$i]['info'][$k]["image"]=$arr1102[0];
			}
	
		}
		$list['sum']=M('order_form')
		->field('count(id) AS num,sum(buy_price) AS sum')
		->where($whereall)->find();

		return $list;

	}
	
	
	//订单详情
	function order_con(){

		//根据订单号查询到订单信息 state 交易状态(1：待付款、2：待发货、3：待收货、4：待评价、5：退换/售后、6：已关闭、7：已完成
        $field_order_form='
                order_form.id as order_form_id,order_form.order_num as order_form_order_num,
                order_form.openid as order_form_openid,order_form.shouhuo_id as order_form_shouhuo_id,
                order_form.array_id,order_form.buy_price,order_form.state,
		        
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
		        goods.id as goods_id,goods.goods_title,goods.price_sell,goods.image
		       
		        ';
                 $order[$p]=M("order")
               ->field($field_order)
               ->join('goods ON order.goods_id=goods.id')
            //    ->join('left join goods_img ON goods_img.goods_id=goods.id')
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
}