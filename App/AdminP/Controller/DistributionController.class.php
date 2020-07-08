<?php
namespace AdminP\Controller;
use Think\Controller;
class DistributionController extends CommonController {
    //分销商管理
    //分销商增长趋势
    //分销商等级
    //分销订单
    //分销商统计
    //分销关系
    //待审核的
    //待打款的
    //已打款的
    //无效的
    //基础设置


    //分销商管理
    public function index(){
    	
    	//进来就开始判断这个小程序的分销设置有没有
    	$a=M('fx_info')->where("program_id='".$_COOKIE["program_id"]."'")->find();
    	if(empty($a)){
    		$add["program_id"]=$_COOKIE["program_id"];
    		M('fx_info')->add($add);
    	}
    $field='
    	members.id as members_id,members.head as members_head,members.nickname as members_nickname,members.openid as members_openid,
    	members.fx_lever_id as members_fx_lever_id,members.group_id as members_group_id,members.register_time as members_register_time,
    	members.blacklist as members_blacklist,members.program_id as members_program_id,members.fx_time_registe,members.fx_time_agree,
    	members.fx_state,members.fx_uid,
    
    	fx_lever.id as fx_lever_id,fx_lever.program_id as fx_lever_program_id,fx_lever.title as fx_lever_title

    ';	
// 	$where=array(
//		'members.program_id'=>$_COOKIE["program_id"],
//		'members.fx_state'=>array("neq",'0')
//	); 	
//	$list=M("members")
//	->field($field)	
//	->join('left join fx_lever ON fx_lever.id=members.fx_lever_id')
//	->where($where)
//	->select();
	
	$sql  =" SELECT  ".$field;
	$sql .=" FROM members ";
	$sql .=" left join fx_lever ON fx_lever.id=members.fx_lever_id";
	$sql .=" WHERE members.program_id ='".$_COOKIE["program_id"]."'";
	$sql .=" and members.fx_state != 0 ";
	$sql .=" ORDER BY members.id asc ";
	
	$list = M("members") -> query($sql);
	
	$total =count($list);
	
    $per = 10;
	$page = new \Component\Page($total, $per); 
	
	$sql .=$page->limit;

    $list = D("members") -> query($sql);
    $pagelist = $page -> fpage();
	
	$all=$this->bq($list,0,4);//递归求得所有子级元素
	
	foreach($list as $k=>$v){
			$sum=$this->getTree($list,$v['members_id'],3);
			$list[$k]["child_count"]=$sum;
			
	if($_COOKIE["program_id"]=="JT201803151807521312"){
		$hzd_reward[$k]=M("hzd_earnings")->where("program_id='".$_COOKIE["program_id"]."'"."and openid='".$list[$k]["members_openid"]."'")->find();
	
	$list[$k]["reward_info"]=$hzd_reward[$k];
	}
		
        }

		$this ->pages = $pagelist;
		$this ->list  =$list;
    	$this ->display();
	}
	//分销统计
	function getTree($data,$pId,$n){
	//参数 ：数组、初始id、层级
		if($n>0){
			$arr["sum"][$pId]=0;
			for($i=0;$i<count($data);$i++){
				if($data[$i]['fx_uid']==$pId){
					$arr["sum"][$pId]+=1;
					$num=$this->getTree($data,$data[$i]['members_id'],$n-1);
					$arr["sum"][$pId]=$arr["sum"][$pId]+$num;
				}
			}	
		}
		return $arr["sum"][$pId];
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
	
	

   //分销商增长趋势
    public function fx_trend(){
echo  1;
        $this->display();
    }
    //分销商等级
    public function fx_lever(){
    	if($_COOKIE["program_id"]=="JT201712021113483120"){
    	    //蔡氏养生
    		$list=$this->list=M('fx_price_independent')->where(array('program_id'=>$_COOKIE['program_id']))->select();
    	}else if($_COOKIE["program_id"]=="JT201802032149345468"){
            //易选购
            $list=$this->list=M('fx_price_independent')->where(array('program_id'=>$_COOKIE['program_id']))->select();


        }else{
    		$list=$this->list=M('fx_lever')->where(array('program_id'=>$_COOKIE['program_id']))->select();
    	}

        $this->display();
    }
    
    //分销商等级编辑
    public function fx_lever_edit(){
    	
    	 $a= $this->list=M('fx_lever')->where("id=".$_GET['id'])->find();

    		$this->display('fx_lever_add');
    }
    //分销商等级添加
     public function fx_lever_add(){
     		
     	$this->display();
    }
    //分销商等级添加按钮
     public function fx_lever_run_add(){
   
     	  if(empty($_GET['id'])) {
		$_POST["program_id"]=$_COOKIE["program_id"];
		$_POST["cannot_d"]="2";
            if(M('fx_lever')->add($_POST)) {
                $this->success('添加成功',U('index'));
            } else {
                $this->error('添加失败');
            }
        }
        else {
            M('fx_lever')->where(array('id'=>$_GET['id']))->save($_POST);
            
			$this->success('修改成功',U('index'));
        }
     	
    }
    //分销商等级删除
     public function fx_lever_delete(){
     //	$user_id = $_GET['id'];
     	$where=array( 
     	"cannot_d"=>array('neq','1'),
     	"id"=>array('eq',$_GET['id'])
     	
     	);
        if(M('fx_lever')->where($where)->delete()) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
     	
    }
    
    //分销商黑名单
    function blacklist(){
    /*	$dae["title"]=$_POST["fx_state"];
    	$dae["name"]=$_POST["id"];
    	M("test")->add($dae);*/
    	if($_POST["fx_state"]==2){
    		$save["fx_state"]=3;//设置为黑名单
    	}else if($_POST["fx_state"]==3){
    		$save["fx_state"]=2;//恢复正常
    	}
    	if(M("members")->where("id='".$_POST["id"]."'")->save($save)){
    		$date="1";//修改成功
    	}else{
    			$date="2";//修改成功
    	}
    	$this->ajaxReturn($date);
    }
    
    //分销商删除
    function fx_delete(){
    	$save["fx_state"]=0;//删除
    	if(M("members")->where("id='".$_POST["id"]."'")->save($save)){
    		$date="1";//修改成功
    	}else{
    			$date="2";//修改成功
    	}
    	$this->ajaxReturn($date);
    }
    
    //分销订单
    public function fx_order(){
		$list=$this->get_orderlist_n($state,$dfx_id);//全部订单
		
		
		$this->list=$list["list"];
		$this->pages=$list["pages"];
        $this->display();
    }
    function get_orderlist($state='',$dfx_id){
        //分销订单进这里
        $where['order_form.dfx_id']=array('neq',0);
        $whereall=array('program_id'=>$_COOKIE["program_id"]);
		
		$where['order_form.program_id']=$_COOKIE["program_id"];
		$field='order_form.id,order_form.order_num,order_form.array_id,order_form.time_build,order_form.state,order_form.buy_price,
		       order_form.dsh_id,order_form.dfx_id,order_form.dfx_price01,order_form.dfx_price02,order_form.dfx_price03,
		       
			   count(order_form.id) AS num,sum(order_form.buy_price) AS sum,
			   
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
		goods.goods_title,goods.price_sell,
		goods_img.image';
		$where1['order.program_id']=$_COOKIE["program_id"];
		for($i=0;$i<count($list);$i++){
			$where1['_string']='order.id in('.substr($list[$i]['array_id'],0,strlen($list[$i]['array_id'])-1).')';
			$list[$i]['info']=M('order')
			->group('order.id')
			->field($f)
			->join('goods ON order.goods_id=goods.id')
			->join('goods_img ON order.goods_id=goods_img.goods_id')
			->where($where1)
			->select();
		}
		$list['sum']=M('order_form')
		->field('count(id) AS num,sum(buy_price) AS sum')
		->where($whereall)->find();
dump(M('order')->_sql());
		return $list;

	}
 function get_orderlist_n($state='',$dfx_id){
     
	
	$field='order_form.id,order_form.order_num,order_form.array_id,order_form.time_build,order_form.state,order_form.buy_price,
        order_form.dsh_id,order_form.dfx_id,order_form.dfx_price01,order_form.dfx_price02,order_form.dfx_price03,
       
        user_info_dsh.id as user_info_dsh_id,user_info_dsh.sh_name,
       
        members.nickname,members.tel
        ';
	
	$sql  =" SELECT  ".$field;
	$sql .=" FROM order_form ";
	$sql .=" INNER JOIN members ON order_form.openid=members.openid";
	$sql .=" left join user_info_dsh ON order_form.dsh_id=user_info_dsh.id";
	$sql .=" WHERE  order_form.dfx_id != 0 AND order_form.program_id ='".$_COOKIE["program_id"]."'";
	$sql .=" GROUP BY order_form.id ";
	$sql .=" ORDER BY order_form.time_build desc ";
	
		$list = M("order_form") -> query($sql);
		
		$total =count($list);
	    $per = 5;
		$page = new \Component\Page($total, $per); 	
		$sql .=$page->limit;

	    $list = D("order_form") -> query($sql);
	    $pagelist = $page -> fpage();

	$f='order.id,order.buy_num,order.order_num,order.goods_id,
		goods.goods_title,goods.price_sell
		';	
	$all=count($list);

	for($i=0;$i<$all;$i++){

		$sql_1  =" SELECT  ".$f;
		$sql_1 .=" FROM `order` ";
		$sql_1 .=" left join goods ON order.goods_id=goods.id ";
		$sql_1 .=" WHERE order.program_id ='".$_COOKIE["program_id"]."'";
		if(strlen($list[$i]['array_id'])!=0){
			$str[$i]=substr($list[$i]['array_id'],0,strlen($list[$i]['array_id'])-1);
			$sql_1 .=" and ( order.id in(".$str[$i].")) ";
			
			$list[$i]['info'] = M("order") -> query($sql_1);
			
		}
	}
		$list['sum']=M('order_form')
		->field('count(id) AS num,sum(buy_price) AS sum')
		->where("program_id='".$_COOKIE["program_id"]."'")->find();

		$data["list"]=$list;
		$data["pages"]=$pagelist;
		return $data;
	}

    //分销商统计
    public function fx_count(){

        $this->display();
    }
    //分销关系
    public function fx_relation(){

        $this->display();
    }
    //    提现申请=============================================================
  	 //待审核的
    public function cash_ing(){
//申请状态（1：待审核、2：审核通过（待打款）、3：审核拒绝、4：已打款、5：未知错误）    	
		$a=$this->info=$this->tixian(1);
       $this->count=count($a);
        $this->display();
    }
    //待打款的
    public function cash_git(){
//申请状态（1：待审核、2：审核通过（待打款）、3：审核拒绝、4：已打款、5：未知错误）  
		$a=$this->info=$this->tixian(2); 
		  $this->count=count($a);
        $this->display();
    }
    //已打款的
    public function cash_done(){
//申请状态（1：待审核、2：审核通过（待打款）、3：审核拒绝、4：已打款、5：未知错误）  
		$a=$this->info=$this->tixian(4);  
		  $this->count=count($a);
        $this->display();
    }
    //无效的
    public function cash_none(){
//申请状态（1：待审核、2：审核通过（待打款）、3：审核拒绝、4：已打款、5：未知错误）    
		$a=$this->info=$this->tixian(3);
		  $this->count=count($a);
        $this->display();
    }
    
    function tixian($state){
		$where["fx_tixian.program_id"]=$_COOKIE["program_id"];
		$where["fx_tixian.state"]=$state;
		
		$field='
		fx_tixian.order_num,fx_tixian.money_01,fx_tixian.state,fx_tixian.time_set,fx_tixian.id,time_give_money,
		
		members.nickname,members.head
		';
		$tixian=M("fx_tixian")
		->field($field)
		->join('left join members on members.openid=fx_tixian.openid')
		
		->where($where)
		->select();
		
		return $tixian;
	}
	
	//提现审核通过
	function cash_yes(){
		$save["state"]=$_GET["sta"];
		
		if($_GET["sta"]==2){
			$save["time_on"]=time();
		}
		switch ($_GET["sta"]){
			case 2:$save["time_on"]=time();break;
			case 3:$save["time_say_no"]=time();break;
			case 4:$save["time_git"]=time();break;
		}
		
		
		if(M("fx_tixian")->where("id='".$_GET["id"]."'")->save($save)){
		 					$this->success('操作成功',U('cash_ing'));
            } else {
                $this->error('操作失败');
            }
		
	}
//提现删除
function cash_del(){
		if(M("fx_tixian")->where("id='".$_GET["id"]."'")->delete()){
		 					$this->success('操作成功',U('cash_none'));
            } else {
                $this->error('操作失败');
            }
}
	

    //基础设置==============================================
    public function cash_set(){

		$this->list=M("fx_info")->where("program_id='".$_COOKIE["program_id"]."'")->find();
        $this->display();
    }
    function fx_save(){
    	$rec["neigou"]=$_POST["neigou"];
    	$rec["is_on_fenxiao"]=$_POST["is_on_fenxiao"];
    	$rec["is_globle_fenxiao"]=$_POST["is_globle_fenxiao"];
    	$a=M('fx_info')->where("program_id='".$_COOKIE["program_id"]."'")->find();
    	
    	if(empty($a)){
    	$rec["program_id"]=$_COOKIE["program_id"];
    	
	    	if(M('fx_info')->add($rec)){
			    		$this->success('修改成功',U('cash_set'));
			    	}else{
			    		$this->error('修改失败');
			    	}
    	}else{
    			if(M('fx_info')->where("program_id='".$_COOKIE["program_id"]."'")->save($rec)){
		    		$this->success('修改成功',U('cash_set'));
		    	}else{
		    		$this->error('修改失败');
		    	}
    	}

		    	//$this->error($upload->getError());
	}	
    
    //异步修改分销金额
    function ajax_change_text(){
        $save[$_POST["text_name"]]=$_POST["text_val"];
		if($_POST["style"]==1){

				if(M("fx_price_independent")->where("id='".$_POST["id"]."'")->save($save)){
						$date="1";
					}else{
						$date="2";
					}
			
		}else if($_POST["style"]==2){

            if(M("fx_goods_buy")->where("id='".$_POST["id"]."'")->save($save)){
                $date="1";
            }else{
                $date="2";
            }

        }
		$this->ajaxReturn($date);
		
	}
	
	//分销代理关系  分销等级
	function fx_daili(){
		$this->list=M("fx_lever_independent")->where("program_id='".$_COOKIE["program_id"]."'")->select();
		$this->display();
	}


	//分销消费优惠管理
    function fx_buy(){
   $list= $this->list=M("fx_goods_buy")->where("program_id='".$_COOKIE["program_id"]."'")->select();

        $this->display();
    }
    
    
    //分销提现异步获取数据
    function ajax_fukuan(){
    	$order_info=M("fx_tixian")->where("order_num='".$_POST["order_num"]."'")->find();
    	
    	$this->ajaxReturn($order_info);
    }
    
    //异步打款记录
    function cash_fukuan(){
    	$save["money_02"]=$_POST["price"];
    	$save["state"]=4;
    	$save["time_give_money"]=time();
    	
    	if(M("fx_tixian")->where("order_num='".$_POST["order_num"]."'")->save($save)){
    		$a=1;
    	}else{
    		$a=-1;
    	}
    	
    	$this->ajaxReturn($a);
    }
    
    
    function image_ajax(){
    $receive=I();
    	$upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =     3145728 ;// 设置附件上传大小
			    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录

			    // 上传文件 
			    $info   =   $upload->upload();
			    if($info){
			    	$receive['honor_image']=$info['image02']['savepath'].$info['image02']['savename'];
			    	$receive['honor_image_welfare']=$info['image03']['savepath'].$info['image03']['savename'];
			    }else{
			    	$this->error('无上传图片');	
                	$error=$upload->getError();
		    		$data=array("status" => -1, "msg" => "图片上传失败",'error'=>$error);
			    }
			
			if(M("hzd_earnings")->where("program_id='".$_COOKIE["program_id"]."'"." and openid='".$_POST["openid"]."'")->save($receive)){
			    	$this->success('成功',U('index'));
			    }else{
			    	$this->error('失败');	
			    }
    }
    
    
    //收益列表
    function fx_lever_shouyi(){
    	
    	$this->list=M("hzd_reward")->where("id")->select();
    	$this->display();
    	
    }
    
    	//异步修改
	function ajax_edit(){
		$save["condition_price"]=$_POST["text"];
		
		if(M("fx_lever_independent")->where("id='".$_POST["id"]."'")->save($save)){
				$date="1";
			}else{
				$date="2";
			}
		$this->ajaxReturn($date);
	}
	
	function angel_registe(){
		$where["program_id"]=$_COOKIE["program_id"];
		$where["registe_state"]="0";
		
		$list=M("fx_register")->where($where)->select();
		for($i=0;$i<count($list);$i++){
			$a[$i]=M("schooling_record")->where("id='".$list[$i]["schooling_record_id"]."'")->find();
			$list[$i]["schooling_record_title"]=$a[$i]["schooling_record"];
		}

		$this->list=$list;
		
		$this->display();
	}
	
	function apply_con(){
		$info=M("fx_register")->where("id='".$_GET["id"]."'")->find();
		
		$a=M("schooling_record")->where("id='".$info["schooling_record_id"]."'")->find();
			$info["schooling_record_title"]=$a["schooling_record"];
			
			$this->info=$info;
		$this->display();
	}
	
	function apply_agree(){
			$save["registe_state"]="1";
			$save["time_agree"]=time();
			
  		$a=M('fx_register')->where("id='".$_GET['id']."'")->find();
        if(M('fx_register')->where("id='".$_GET['id']."'")->save($save)) {
        	
        	$save_02["fx_state"]="2";
        	$save_02["fx_source"]="2";
        	$save_02["fx_time_registe"]=$a["time_registe"];
        	$save_02["fx_time_agree"]=$save["time_agree"];
        	$save_02["fx_lever_id"]="51";
        	
        	
        	M("members")->where("openid='".$a["openid"]."'"."and program_id='".$_COOKIE["program_id"]."'")->save($save_02);
            $this->success('操作成功',U('angel_registe'));
        }else {
            $this->error('操作失败');
        }
	}
	function apply_reject(){
			$save["registe_state"]="2";
  		
        if(M('fx_register')->where("id='".$_GET['id']."'")->save($save)) {
            $this->success('操作成功',U('angel_registe'));
        }else {
            $this->error('操作失败');
        }
	}
	
}