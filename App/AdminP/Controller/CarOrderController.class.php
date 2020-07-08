<?php
namespace AdminP\Controller;
use Think\Controller;
class CarOrderController extends CommonController {

//订单概述	
public function index(){
		$field='count(id) AS num,sum(price) AS sum';
		$nt=time();                      //当前时间
		$stamp_today=strtotime(date('Y-m-d'));//今天凌晨时间戳
		$stamp_yestoday=strtotime(date("Y-m-d",strtotime("-1 day")));//昨天凌晨时间戳
		$stamp_week_ago=strtotime(date("Y-m-d",strtotime("-1 week")));//一周前的凌晨时间戳
		$stamp_month_ago=strtotime(date("Y-m-d",strtotime("last month")));//一月前的凌晨时间戳
	
		$where['program_id']=$_COOKIE["program_id"];
		$where['state']="2";
		$where['time_pay']=array(array('EGT',$stamp_today),array('ELT',$nt));
		
		$where1['program_id']=$_COOKIE["program_id"];
		$where1['state']="2";
		$where1['time_pay']=array(array('EGT',$stamp_yestoday),array('ELT',$stamp_today));
		
		$where2['program_id']=$_COOKIE["program_id"];
		$where2['state']="2";
		$where2['time_pay']=array(array('EGT',$stamp_week_ago),array('ELT',$nt));
		
		$where3['program_id']=$_COOKIE["program_id"];
		$where3['state']="2";
		$where3['time_pay']=array(array('EGT',$stamp_month_ago),array('ELT',$nt));
		
		$today=M('car_order')->field($field)->where($where)->find();//今天订单;
		$yestoday=M('car_order')->field($field)->where($where1)->find();//昨天订单;
		$weed_ago=M('car_order')->field($field)->where($where2)->find();//近七日订单;
		$mounth_ago=M('car_order')->field($field)->where($where3)->find();//近一个月订单;	
		//dump($t);dump(M('car_order')->_sql());die;
		
		$data=array('k1'=>$today,'k2'=>$yestoday,'k3'=>$weed_ago,'k4'=>$mounth_ago);
	    $this->assign('data',$data);
		
    	$this->display();

}
//全部订单	
public function order_all(){
//	$a=M("car_order")->where("program_id='".$_COOKIE["program_id"]."'")->order("time_pay desc")->select();
//	$a=$this->list_common($a);
//	$this->list=$a;
	
	$sql  =" SELECT * ";
	$sql .=" FROM car_order ";
	$sql .=" WHERE  program_id ='".$_COOKIE["program_id"]."'";
	$sql .=" ORDER BY time_xd desc ";
	
	$a = M("car_order") -> query($sql);

	$total =count($a);
    $per = 10;
	$page = new \Component\Page($total, $per); 	
	$sql .=$page->limit;

    $a = D("car_order") -> query($sql);
    $pagelist = $page -> fpage();
	$a=$this->list_common($a);
	
	$this ->pages = $pagelist;
	$this ->list  =$a;
	
	if($_GET["csv"]==1){
		$csvData = $a;	
	 	$this->export_csv($csvData);
	}ELSE{
			$this->display();
	}
	
}
//待付款	
public function order_paying(){

	$sql  =" SELECT * ";
	$sql .=" FROM car_order ";
	$sql .=" WHERE state=1 and order_num !='0' and program_id ='".$_COOKIE["program_id"]."'";
	$sql .=" ORDER BY time_xd desc ";
	
	$a = M("car_order") -> query($sql);

	$total =count($a);
    $per = 10;
	$page = new \Component\Page($total, $per); 	
	$sql .=$page->limit;

    $a = D("car_order") -> query($sql);
    $pagelist = $page -> fpage();

	$a=$this->list_common($a);
	
	$this ->pages = $pagelist;
	$this ->list  =$a;
	
	if($_GET["csv"]==1){
		$csvData = $a;	
	 	$this->export_csv($csvData);
	}ELSE{
			$this->display();
	}
}
//已付款
public function order_payed(){

	
	$sql  =" SELECT * ";
	$sql .=" FROM car_order ";
	$sql .=" WHERE state=2 and order_num !='0' and program_id ='".$_COOKIE["program_id"]."'";
	$sql .=" ORDER BY time_pay desc ";
	
	$a = M("car_order") -> query($sql);

	$total =count($a);
    $per = 10;
	$page = new \Component\Page($total, $per); 	
	$sql .=$page->limit;

    $a = D("car_order") -> query($sql);
    $pagelist = $page -> fpage();

	$a=$this->list_common($a);
	
	$this ->pages = $pagelist;
	$this ->list  =$a;
	
	
	if($_GET["csv"]==1){
		$csvData = $a;	
	 	$this->export_csv($csvData);
	}ELSE{
			$this->display();
	}
}
//已完成
public function order_done(){
	
	
//	$a=M("car_order")->where("state=4 and program_id='".$_COOKIE["program_id"]."'")->order("time_pay desc")->select();
//	$a=$this->list_common($a);
//	$this->list=$a;
	
	$sql  =" SELECT * ";
	$sql .=" FROM car_order ";
	$sql .=" WHERE state=4 and order_num !='0' and program_id ='".$_COOKIE["program_id"]."'";
	$sql .=" ORDER BY time_pay desc ";
	
	$a = M("car_order") -> query($sql);

	$total =count($a);
    $per = 10;
	$page = new \Component\Page($total, $per); 	
	$sql .=$page->limit;

    $a = D("car_order") -> query($sql);
    $pagelist = $page -> fpage();

	$a=$this->list_common($a);
	
	$this ->pages = $pagelist;
	$this ->list  =$a;
	
	if($_GET["csv"]==1){
		$csvData = $a;	
	 	$this->export_csv($csvData);
	}ELSE{
			$this->display();
	}
}
	//已取消
public function order_none(){
	
//	$where["state"]=3;
//	$where["program_id"]=$_COOKIE["program_id"];
//	$where["order_num"]=array("neq","0");
//
//	$a=M("car_order")->where($where)->order("time_xd desc")->select();
//		$a=$this->list_common($a);
//	$this->list=$a;
	
	$sql  =" SELECT * ";
	$sql .=" FROM car_order ";
	$sql .=" WHERE state=5 and order_num !='0' and program_id ='".$_COOKIE["program_id"]."'";
	$sql .=" ORDER BY time_xd desc ";
	
	$a = M("car_order") -> query($sql);

	$total =count($a);
    $per = 10;
	$page = new \Component\Page($total, $per); 	
	$sql .=$page->limit;

    $a = D("car_order") -> query($sql);
    $pagelist = $page -> fpage();

	$a=$this->list_common($a);
	
	$this ->pages = $pagelist;
	$this ->list  =$a;
	
	$this->program_id=$_COOKIE["program_id"];
	
	if($_GET["csv"]==1){
		$csvData = $a;	
	 	$this->export_csv($csvData);
	}ELSE{
			$this->display();
	}
}

function list_common($a){
	for($i=0;$i<count($a);$i++){
		//车型信息
		$b=M("car_allcar")->where("id='".$a[$i]["car_id"]."'"."and program_id='".$_COOKIE["program_id"]."'")->find();
		$b_arr=explode(",",$b["image"]);
		$a[$i]["car_image"]=$b_arr[0];//车型图片
		$a[$i]["car_title"]=$b["title"];//车型名称
		
		//服务地址管理
		$c=M("car_address")->where("id='".$a[$i]["fw_id"]."'"."and program_id='".$_COOKIE["program_id"]."'")->find();
		$a[$i]["fw_name"]=$c["linkman"];//服务联系人
		$a[$i]["fw_tel"]=$c["tel"];//服务联系电话
		
		//服务司机  
		$d=M("car_manerger")->where("id='".$a[$i]["driver_id_on"]."'")->find();
		$a[$i]["driver"]=$d["name"];//司机
	}
	return $a;
}

//订单详情
function order_con(){
	$a=M("car_order")->where("order_num='".$_GET["order_num"]."'")->find();
	//订单备注
	$where["id"]=array("in",$a["extra_need_id"]);
	$order_remark=M("car_extra_need")->where($where)->select();
	$a["order_remark"]=$order_remark;
	
	//车型信息
	$b=M("car_allcar")->where("id='".$a["car_id"]."'"."and program_id='".$_COOKIE["program_id"]."'")->find();
	$b_arr=explode(",",$b["image"]);
	$a["car_image"]=$b_arr[0];//车型图片
	$a["car_title"]=$b["title"];//车型名称
		
	//服务地址管理
	$c=M("car_address")->where("id='".$a["fw_id"]."'"."and program_id='".$_COOKIE["program_id"]."'")->find();
	$a["linkman"]=$c["linkman"];//服务联系人
	$a["tel"]=$c["tel"];//服务联系电话
	$a["address"]=$c["address"];//地址
	$a["address_end_text"]=$c["address_end_text"];//地址
	$a["coordinate"]=$c["coordinate"];//坐标

//dump($c);dump($a);dump(M("car_address")->_sql());die;
	$this->order_con=$a;
	$this->display();
}

//添加备注
function text_remark(){
		$save["remark"]=$_POST["remark"];
     
        
        if(M("car_order")->where("order_num='".$_POST["order_num"]."'")->save($save)){
			$date="1";
		}else{
			$date="2";
		}
		$this->ajaxReturn($date);
}
//修改订单价格
	 function change_price(){
	 	$save["is_change_price"]=1;
        $save["change_price"]=$_POST["price"];
        
        if(M("car_order")->where("order_num='".$_POST["order_num"]."'")->save($save)){
			$date="1";
		}else{
			$date="2";
		}
		$this->ajaxReturn($date);
    } 

	//关闭订单 ["state"]=3
	public function close_order(){
		$id=$_GET["id"];
		$a=M('car_order')->where('id='.$id)->find();
		
		if($a["state"]==1){
			//未付款订单直接取消
			$save["state"]=3;
		}else if($a["state"]==2){
			//已付款，不仅取消，还设置退款需求
			$save["state"]=3;
			$save["state_tuikuan"]=2;//申请退款
			
		}
		if($a["driver_id_on"]!=0){
			$save0118["server_state"]=0;
			M("car_manerger")->where("id='".$a["driver_id_on"]."'")->save($save0118);//释放司机
		}
		
		if(M('car_order')->where('id='.$id)->save($save)){
			
			$this->success('操作成功',U('order_payed'));
		}else{
			$this->error('操作失败');
		}
	}
	//确认付款
	public function fukuan(){
		$id=$_GET['id'];
		$save["state"]=2;
		$save["time_pay"]=time();
		$save["is_admin_pay"]=1;
		if(M('car_order')->where('id='.$id)->save($save)){
			$this->success('操作成功',U('order_payed'));
		}else{
			$this->error('操作失败');
		}
	}
	
	
	
	//订单取消原因管理
	function order_cancel(){
		$this->list=M("car_cancel_reason")->where("program_id='".$_COOKIE["program_id"]."'")->select();
		$this->display();
	}

	function order_cancel_add(){
		$this->display();
	}
	function order_cancel_edit(){
			$this->info=M("car_cancel_reason")->where("id='".$_GET["id"]."'")->find();
		$this->display('order_cancel_add');
	}
	function order_cancel_runadd(){
		if(empty($_GET["id"])){
			//执行添加
			$_POST["program_id"]=$_COOKIE["program_id"];
			if(M("car_cancel_reason")->add($_POST)){
					$this->success('操作成功',U('order_cancel'));
			}else{
				$this->error('操作失败');
			}
		}else{
			//执行 修改
			if(M("car_cancel_reason")->where("id='".$_GET["id"]."'")->save($_POST)){
					$this->success('操作成功',U('order_cancel'));
			}else{
				$this->error('操作失败');
			}
		}
	}
	function order_cancel_delete(){
		$where["id"]=$_GET["id"];
		if(M('car_cancel_reason')->where($where)->delete()){
			$this->success('操作成功');
		}else{
			$this->error('操作失败');
		}
	}
	
	//订单绑定司机
	function tied_driver(){
		$a=M("car_manerger")->where("state=1 and state_register=2 and server_state!=1 and program_id='".$_COOKIE["program_id"]."'")->select();
//	dump($a);dump(M("car_manerger")->_sql());die;
		$b=M('car_order')->where("order_num='".$_GET["order_num"]."'")->find();
	
		for($i=0;$i<count($a);$i++){
			//显示司机所属车场
			$car_parking[$i]=$this->car_parking=M("car_parking")->where("id='".$a[$i]["parking_id"]."'")->find();
			$a[$i]["car_parking_address"]=$car_parking[$i]["address"];
			$a[$i]["car_parking_id"]=$car_parking[$i]["id"];
			
			if($a[$i]["parking_id"]==$b["id"]){
				$a[$i]["is_onparking"]=1;//司机属于这个车场的
			}else{
				$a[$i]["is_onparking"]=2;
			}
		}
		
		$this->list=$a;
		
		//订单号
		$this->order_num=$_GET["order_num"];
		
		$this->display('driver');
	}
	
	function teid(){
		$save["driver_id_on"]=$_GET["id"];
		$save["is_get_driver"]=1;
		$save["time_tired"]=time();
		$save02["server_state"]=1;//服务状态（0：空闲、1：出车，2：待接单）
		$save03["server_state"]=0;
		
		$a=M("car_order")->where("order_num='".$_GET["order_num"]."'")->find();
		if(M('car_order')->where("order_num='".$_GET["order_num"]."'")->save($save)){
			M("car_manerger")->where("id='".$a["driver_id_on"]."'")->save($save03);//释放司机
			M("car_manerger")->where("id='".$_GET["id"]."'")->save($save02);
			
			$this->success('操作成功',U('order_payed'));
		}else{
			$this->error('操作失败');
		}
	}
	
	
	//额外需求==============================================================================================
	public function car_extra_need(){

		$fl=M("car_extra_need")
		
		->where("program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$all_fenlei=$this->info=$fl;

		$this->display();
	}
		//添加额外需求
	public function car_extra_need_add(){
		
		$this->display();
	}


	
	public function car_extra_need_edit(){
		$a= $this->info=M('car_extra_need')->where("id=".$_GET['id'])->find();
		$this->display('car_extra_need_add');
	}
	
	public function run_car_extra_need_add(){

		  if(empty($_GET["id"])){
		  	//执行添加
		  	$_POST["program_id"]=$_COOKIE["program_id"];
		;
		  	if(M("car_extra_need")->add($_POST)){
					$this->success('添加成功',U('car_extra_need'));
				}else{
				    $this->error('添加失败');	
				}
		  }else{
		  	//执行修改
		  	if(M("car_extra_need")->where("id='".$_GET["id"]."'")->save($_POST)){
					$this->success('修改成功',U('car_extra_need'));
				}else{
				    $this->error('修改失败');	
				}
		  	
		  }
	}
	
	
	//额外需求删除
		public function car_extra_need_delete(){
			$user_id =$_GET['id'];
	        if(M('car_extra_need')->delete($user_id)) {
	        	//删除主类图片
	        
	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
		}
		
		/**
	 * 导出csv  开始
	 * */
	public function export_csv($csvData){
		$time = date('Y-m-d H:i:s', time());	

		for($i=0;$i<count($csvData);$i++){
		
	$car_allcar[$i]=M("car_allcar")->where("id='".$csvData[$i]["car_id"]."'")->find();				//车种信息		
	$car_manerger_2[$i]=M("car_manerger")->where("id='".$csvData[$i]["driver_id_on"]."'")->find();  //司机信息
	$car_parking[$i]=M("car_parking")->where("id='".$car_manerger_2[$i]["parking_id"]."'")->find();	//车场信息
	$car_address[$i]=M("car_address")->where("id='".$csvData[$i]["fw_id"]."'")->find();			    //服务信息
				
			$csvData_1[$i]["id"]			=$csvData[$i]["id"];					//------car_order
			$csvData_1[$i]["order_num"]		=$csvData[$i]["order_num"];				//------car_order
			
			
			$csvData_1[$i]["account"]		=$csvData[$i]["account"];					//下单账号
			$csvData_1[$i]["name"]			=$car_address[$i]["linkman"];			//------car_address
			$csvData_1[$i]["linktel"]		=$car_address[$i]["tel"];				//------car_address
			$csvData_1[$i]["price"]			=$csvData[$i]["price"];					//------car_order
			$csvData_1[$i]["car_title"]		=$car_allcar[$i]["title"];				//------car_allcar
			

			$csvData_1[$i]["driver"]		=$car_manerger_2[$i]["name"];          //------car_manerger 司机
			$csvData_1[$i]["driver_tel"]	=$car_manerger_2[$i]["linktel"];       //------car_manerger 司机
			$csvData_1[$i]["car_num"]		=$car_manerger_2[$i]["car_num"];       //------car_manerger 司机

			$csvData_1[$i]["driver_parking"]=$car_parking[$i]["address"];      		//------car_parking 车场位置

			$csvData_1[$i]["server_address_1"]=$car_address[$i]["address"];				//------car_address
			$csvData_1[$i]["server_address_2"]=$car_address[$i]["address_end_text"];	//------car_address
			$csvData_1[$i]["zb_1"]			=$car_address[$i]["coordinate_start"];		//------car_address
			$csvData_1[$i]["zb_2"]			=$car_address[$i]["coordinate_end"];		//------car_address
			
			$csvData_1[$i]["state"]			=$csvData[$i]["id"];							//------car_order
			
			$csvData_1[$i]["time_xd"]		=(empty($csvData[$i]["time_xd"]))?null:date("Y-m-d H:i:s",$csvData[$i]["time_xd"]);	//------car_order
			$csvData_1[$i]["time_pay"]		=(empty($csvData[$i]["time_pay"]))?null:date("Y-m-d H:i:s",$csvData[$i]["time_pay"]);	//------car_order
			$csvData_1[$i]["time_pass"]		=(empty($csvData[$i]["time_pass"]))?null:date("Y-m-d H:i:s",$csvData[$i]["time_pass"]);	//------car_order
			$csvData_1[$i]["time_tuikuan"]	=(empty($csvData[$i]["time_tuikuan"]))?null:date("Y-m-d H:i:s",$csvData[$i]["time_tuikuan"]);//------car_order
			$csvData_1[$i]["time_tired"]	=(empty($csvData[$i]["time_tired"]))?null:date("Y-m-d H:i:s",$csvData[$i]["time_tired"]);//------car_order
			$csvData_1[$i]["time_done"]		=(empty($csvData[$i]["time_done"]))?null:date("Y-m-d H:i:s",$csvData[$i]["time_done"]);	//------car_order
			$csvData_1[$i]["remark_list"]	=$csvData[$i]["id"];							//------car_order
			$csvData_1[$i]["remark_self"]	=$csvData[$i]["extra_need_custom"];				//------car_order
		}




		$str = "平台编号,订单编号,下单账号,联系人,联系电话,订单价格,订单车种,订单司机,订单司机联系方式,订单车牌号,订单发车地,服务地址（起点）,服务地址（终点）,起点坐标,终点坐标,订单状态,下单时间,付款时间,订单取消时间,订单退款时间,分配司机时间,完成时间,订单备注,订单自定义备注\n";
		$str = iconv('utf-8', 'gb2312', $str);
		foreach ($csvData_1 as $item) {
			$question = iconv('utf-8', 'gb2312', $item['id']);

			$a_1  = iconv('utf-8', 'gb2312', $item['order_num']);
			$a_2  = iconv('utf-8', 'gb2312', $item['account']);
			$a_3  = iconv('utf-8', 'gb2312', $item['name']);
			$a_5  = iconv('utf-8', 'gb2312', $item['linktel']);
			$a_6  = iconv('utf-8', 'gb2312', $item['price']);
			$a_7  = iconv('utf-8', 'gb2312', $item['car_title']);
			$a_8  = iconv('utf-8', 'gb2312', $item['driver']);
			$a_9  = iconv('utf-8', 'gb2312', $item['driver_tel']);
			$a_10 = iconv('utf-8', 'gb2312', $item['car_num']);
			$a_11 = iconv('utf-8', 'gb2312', $item['driver_parking']);
			$a_12 = iconv('utf-8', 'gb2312', $item['server_address_1']);
			$a_13 = iconv('utf-8', 'gb2312', $item['server_address_2']);
			$a_14 = iconv('utf-8', 'gb2312', $item['zb_1']);
			$a_15 = iconv('utf-8', 'gb2312', $item['zb_2']);
			$a_16 = iconv('utf-8', 'gb2312', $item['state']);
			$a_17 = iconv('utf-8', 'gb2312', $item['time_xd']);
			$a_18 = iconv('utf-8', 'gb2312', $item['time_pay']);
			$a_19 = iconv('utf-8', 'gb2312', $item['time_pass']);
			$a_20 = iconv('utf-8', 'gb2312', $item['time_tuikuan']);
			$a_21 = iconv('utf-8', 'gb2312', $item['time_tired']);
			$a_22 = iconv('utf-8', 'gb2312', $item['time_done']);
			$a_23 = iconv('utf-8', 'gb2312', $item['remark_list']);
			$a_24 = iconv('utf-8', 'gb2312', $item['remark_self']);
			

			$str .= $question . "," . $a_1 . "," . $a_2 . "," . $a_3 . "," . $a_5 . "," . $a_6 . "," . $a_7 . "," . $a_8 . "," . $a_9 . "," . $a_10 . "," . $a_11 . "," . $a_12 . "," . $a_13 . "," . $a_14 . "," . $a_15 . "," . $a_16 . "," . $a_17 . "," . $a_18 . "," . $a_19 . "," . $a_20 . "," . $a_21 . "," . $a_22 . "," . $a_23 . "," . $a_24  ;
			$str .="\n";
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