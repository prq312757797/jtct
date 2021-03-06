<?php
namespace Hl\Controller;
use Think\Controller;
class SupermarketController extends CommonController {

    public function index(){
    	//当前状态（1：待审核、2：待入驻（邀请）、3：审核通过（正常）、4:审核拒绝、5：上级禁止、6：服务到期禁止）
$a1=0;//入驻申请中
$a2=0;//入驻申请驳回
$a3=0;//待入驻商户
$a4=0;//入驻中商户
$a5=0;//暂停中商户

	$count=M("h_user_info_dsh")->field('state')->where("program_id='".$_COOKIE["program_id"]."'")->select();
	for($i=0;$i<count($count);$i++){
		if($count[$i]["state"]==1){
			$a1++;
		}else if($count[$i]["state"]==2){
			$a3++;
		}else if($count[$i]["state"]==3){
			$a4++;
		}else if($count[$i]["state"]==4){
			$a2++;
		}else if($count[$i]["state"]==5){
			$a5++;
		}else if($count[$i]["state"]==6){
			$a5++;
		}
	}
$this->count=$arr=array('k1'=>$a1,'k2'=>$a2,'k3'=>$a3,'k4'=>$a4,'k5'=>$a5);


    	$this->display();
	}
    //========================多商户管理=========================================
    //申请中
    public function apply_ing(){
//当前状态（1：待审核、2：待入驻（邀请）、3：审核通过（正常）、4:审核拒绝、5：上级禁止、6：服务到期禁止）
// 		$a=$tist->list=$this->get_orderlist(1);

 	 	$a=$this->get_orderlist_new($state="1",$str=$_GET["str"]);
		$this->list=$a["list"];
		$this->pages=$a["pagelist"];
		
	
		if($_GET["str"]) $this->his_str=$_GET["str"];
 	
        $this->display();
    }
    //驳回
    public function apply_reject(){
//当前状态（1：待审核、2：待入驻（邀请）、3：审核通过（正常）、4:审核拒绝、5：上级禁止、6：服务到期禁止）
// 		$tist->list=$this->get_orderlist(4);
 	 	$a=$this->get_orderlist_new($state="4",$str=$_GET["str"]);
		$this->list=$a["list"];
		$this->pages=$a["pagelist"];
		if($_GET["str"]) $this->his_str=$_GET["str"];
        $this->display();
    }
    //待入驻
    public function in_wait(){
    //当前状态（1：待审核、2：待入驻（邀请）、3：审核通过（正常）、4:审核拒绝、5：上级禁止、6：服务到期禁止）
// 		$tist->list=$this->get_orderlist(2);
 	 	$a=$this->get_orderlist_new($state="2",$str=$_GET["str"]);
		$this->list=$a["list"];
		$this->pages=$a["pagelist"];
		if($_GET["str"]) $this->his_str=$_GET["str"];
        $this->display();
    }
    //入驻中
    public function in_ing(){
//当前状态（1：待审核、2：待入驻（邀请）、3：审核通过（正常）、4:审核拒绝、5：上级禁止、6：服务到期禁止）

 		$a=$this->get_orderlist_new($state="3",$str=$_GET["str"]);

		$this->list=$a["list"];
		$this->pages=$a["pagelist"];
		
		if($_GET["str"]) $this->his_str=$_GET["str"];

        $this->display();
    }
    //暂停中
    public function in_stop(){
//当前状态（1：待审核、2：待入驻（邀请）、3：审核通过（正常）、4:审核拒绝、5：上级禁止、6：服务到期禁止）
// 		$tist->list=$this->get_orderlist(5);
		$a=$this->get_orderlist_new($state="5",$str=$_GET["str"]);
		$this->list=$a["list"];
		$this->pages=$a["pagelist"];
		if($_GET["str"]) $this->his_str=$_GET["str"];
        $this->display();
    }
//推荐中商户
 public function index_re(){
//当前状态（1：待审核、2：待入驻（邀请）、3：审核通过（正常）、4:审核拒绝、5：上级禁止、6：服务到期禁止）
//		$a=$this->get_orderlist_new($state="3",$str=$_GET["str"]);
//		$this->list=$a["list"];
//		$this->pages=$a["pagelist"];
		if($_GET["str"]) $this->his_str=$_GET["str"];
		
		$field='
		id,sort,sh_name,linkman,tel,time_add,time_over,state,main_project,is_recommend,time_register
		';
		
		$a=M("h_user_info_dsh")->field($field)->where("is_recommend=1 and program_id='".$_COOKIE["program_id"]."'")->select();

		$this->list=$a;
//		dump($a);die;
        $this->display();
    }
    //即将到期
    public function in_stop_soon(){

        $this->display();
    }
    
    //多商户分组
    public function merch_group(){

        $this->display();
    }
    //多商户分类===================================================
    public function merch_fenlei(){
//attribute_style  分类类型（1：商品分类、2：多商户分类）
		$this->info=$fl=M("attribute")
		->field('id,uid,title,image_1,is_show,sort')
		->where("dsh_id=0 and attribute_style=2 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$this->count=count($fl);
		$this->display();
    }
    public function merch_fenlei_add(){

        $this->display();
    }
    
//添加子分类
//	public function fenlei_add02(){
//		$this->add_child=$_GET["id"];
//		
//		$this->display('merch_fenlei_add');
//	}
	
	public function merch_fenlei_edit(){
		 $a= $this->info=M('attribute')->where("id=".$_GET['id'])->find();
	
		$this->display('merch_fenlei_add');
	}
	
	public function run_merch_fenlei_add(){
		$receive=I();
		$receive["program_id"]=$_COOKIE["program_id"];
		$upload = new \Think\Upload();// 实例化上传类
	    $upload->maxSize   =     3145728 ;// 设置附件上传大小
	    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
	    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录

	    // 上传文件 
	    $info   =   $upload->upload();	
	    
	    if($info){
	    	$receive['image_1']=$info['image02']['savepath'].$info['image02']['savename'];
	    }else{
	    	
	    }
	    
	    if(empty($_GET['id'])){
	    	$receive["attribute_style"]="2";
			$receive["dsh_id"]=0;
		     if(M('attribute')->add($receive)){
		    	$this->success('添加成功',U('merch_fenlei'));
		    }else{
		    	$this->error('添加失败');	
		    }
	    }else{
	    	 if(M('attribute')->where(array('id'=>$_GET['id']))->save($receive)){
		//如果对一级分类进行隐藏，则对应的二级分类都要隐藏
		        	$a0926=M("attribute")->where("id='".$_GET["id"]."'")->find();	
		        	if($a0926["uid"]==0){
		        		$date0926["is_show"]="2";
		        		M("attribute")->where("uid='".$_GET["id"]."'")->save($date0926);
		        	}
			     	
			    	$this->success('修改成功.',U('merch_fenlei'));
			    }else{
			    	$this->error('修改失败.');	
			    }
	    }
	}
	
	//分类删除
		public function merch_fenlei_delete(){
				 $user_id =$_GET['id'];
			$d_zhu_img=M('attribute')->where("id='".$_GET['id']."'")->find();
	        $d_zi_img=M('attribute')->where("uid='".$_GET['id']."'")->select();
	        	
	        if(M('attribute')->delete($user_id)) {
	        	//删除主类图片
	        	unlink('./Uploads/'.$d_zhu_img["image_1"]);
	        	
	        	
	        	//删除 所属 子类 图片
	        	for($i=0;$i<count($d_zi_img);$i++){
	        		unlink('./Uploads/'.$d_zi_img[$i]["image_1"]);
	        	}
	        	
	        	//删除 所属 子类  数据
	        	$all["uid"]=$_GET['id'];
	        	M('attribute')->delete($all);
	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
		}
		
	//多商户支付方式管理	=================================================
		function merch_pay_set(){
			$a=$this->list=M("payment_method_dsh")->where("program_id='".$_COOKIE["program_id"]."'")->select();
	
		
			$this->display();
		}
		
		function merch_pay_set_add(){
			
			$this->display();
		}
		
		function merch_pay_set_edit(){
			$this->info=M("payment_method_dsh")->where("id='".$_GET["id"]."'")->find();
			$this->display('merch_pay_set_add');
		}
		function merch_pay_set_runadd(){
			if(empty($_GET["id"])){
				//执行添加
				$_POST["program_id"]=$_COOKIE["program_id"];
				 if(M('payment_method_dsh')->add($_POST)){
				    	$this->success('添加成功',U('merch_pay_set'));
				    }else{
				    	$this->error('添加失败');	
				    }
				
			}else{
				//执行修改
				 if(M('payment_method_dsh')->where("id='".$_GET["id"]."'")->save($_POST)){
				    	$this->success('修改成功',U('merch_pay_set'));
				    }else{
				    	$this->error('修改失败');	
				    }
			}
			
		}
		function merch_pay_set_delete(){
			if(M('payment_method_dsh')->where("id='".$_GET["id"]."'")->delete()){	
				$this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
		}
		
	//多商户区域管理	=================================================
		function merch_area_set(){
			
			$this->list=M("merch_area_dsh")->where("program_id='".$_COOKIE["program_id"]."'")->select();
			$this->display();
		}
		
		function merch_area_set_add(){
			
			$this->display();
		}
		
		function merch_area_set_edit(){
			$this->info=M("merch_area_dsh")->where("id='".$_GET["id"]."'")->find();
			$this->display('merch_area_set_add');
		}
		function merch_area_set_runadd(){
			if(empty($_GET["id"])){
				//执行添加
				$_POST["program_id"]=$_COOKIE["program_id"];
				 if(M('merch_area_dsh')->add($_POST)){
				    	$this->success('添加成功',U('merch_area_set'));
				    }else{
				    	$this->error('添加失败');	
				    }
				
			}else{
				//执行修改
				 if(M('merch_area_dsh')->where("id='".$_GET["id"]."'")->save($_POST)){
				    	$this->success('修改成功',U('merch_area_set'));
				    }else{
				    	$this->error('修改失败');	
				    }
			}
		}
		function merch_area_set_delete(){
			if(M('merch_area_dsh')->where("id='".$_GET["id"]."'")->delete()){	
				$this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
		}	
    //========================数据=========================================
    //数据 订单统计
    public function order_count(){

        $this->display();
    }
    //数据 多商户统计
    public function merch_count(){

        $this->display();
    }
    //========================数据=========================================
    //提现 待确认
    public function cash_appay(){

        $this->display();
    }
    //提现 待打款
    public function cash_pay(){

        $this->display();
    }
    //提现 已打款
    public function cash_pay_done(){

        $this->display();
    }
    //提现 无效的
    public function cash_none(){

        $this->display();
    }
    //========================结算订单=========================================
    //结算订单  待确认
    public function m_merch_appay(){

        $this->display();
    }
    //结算订单  待结算
    public function m_merch_wite(){

        $this->display();
    }
    //结算订单  已结算
    public function m_merch_done(){

        $this->display();
    }
    //结算订单  创建结算清单
    public function m_merch_build(){

        $this->display();
    }
    //基础设置
    public function merch_set(){
   
   	$this->info=M("store")->where("program_id='".$_COOKIE["program_id"]."'")->find();
 
   	$user_info= M("user_info")->where("name='".$_COOKIE["name_p"]."'")->find();
    $this->ownid=$user_info["id"];
    $this->display();
    }
    //提交协议  
    function xieyi_submit(){
		if(M("store")->where("program_id='".$_COOKIE["program_id"]."'")->save($_POST)){
			 $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }
    
    //公用根据状态不同查询值
    function get_orderlist($state=''){
     	$where["program_id"]=$_COOKIE["program_id"];
    	$where["state"]=$state;
    	
    	$field='
    	id,sort,sh_name,linkman,tel,time_add,time_over,state,main_project,is_recommend,time_register
		';
		$list=$this->list=M("h_user_info_dsh")
		->field($field)
		->where($where)
		->order("sort asc")
		->select();

		return $list;
	}

    function get_orderlist_new($state,$str){
		$field='
		h_user_info_dsh.id,h_user_info_dsh.sort,h_user_info_dsh.sh_name,h_user_info_dsh.linkman,h_user_info_dsh.tel,
		h_user_info_dsh.time_add,h_user_info_dsh.time_over,h_user_info_dsh.state,h_user_info_dsh.main_project,h_user_info_dsh.is_recommend,
		h_user_info_dsh.openid,h_user_info_dsh.time_register,
		
		(case when h_user_info_dsh.openid is not null then b.nickname else -1 end) as name_1


		';
		$sql  =" SELECT  ".$field; 
		$sql .=" FROM h_user_info_dsh ";
		$sql .=" left join h_members as b ON b.openid=h_user_info_dsh.openid ";
	
		$sql .=" WHERE h_user_info_dsh.dsh_state=2 and h_user_info_dsh.program_id ='".$_COOKIE["program_id"]."'";
		$sql .=" and h_user_info_dsh.state = '".$state."'";
		
		if(!empty($str)){
			$sqlstr="%".$str."%";
			$sql .=" and sh_name like'".$sqlstr."'";
		}
		$list = M("h_user_info_dsh") -> query($sql);

		$total =count($list);
		$sql .=" ORDER BY time_add desc ";
		

		
	    $per = 20;
		$page = new \Component\Page($total, $per); 	
		$sql .=$page->limit;
	
	    $date["list"] = D("h_user_info_dsh") -> query($sql);
	    $date["pagelist"] = $page -> fpage();
	
		return $date;
	}
    /**手机端商户申请通过*/
   public function sh_agree(){
  		$save["state"]="3";
  		
        if(M('h_user_info_dsh')->where("id='".$_GET['id']."'")->save($save)) {
            $this->success('审核成功');
        }else {
            $this->error('审核失败');
        }
   }
       /**邀请入驻商户申请通过*/
   public function sh_agree_in(){
  		$save["state"]="3";
		$save["time_add"]=time();
		$save["time_over"]=strtotime("+1 year");
		
  		$a=M('h_user_info_dsh')->where("id='".$_GET['id']."'")->find();
  		$save["sh_account"]		=$a["sh_name"];
  		$save["sh_psw"]			=md5('123465');
  		$save["sh_psw_show"]	="123465";
  		$save["sh_zhekou"]	="100";
  		
  	
//		$store=M("store")->field("coupon_dsh_first_sent")->where("program_id='".$_COOKIE["program_id"]."'")->find();
//		$save["coupon_dsh_num"]	=$store["coupon_dsh_first_sent"];
  		
        if(M('h_user_info_dsh')->where("id='".$_GET['id']."'")->save($save)) {
            $this->success('审核成功');
        }else {
            $this->error('审核失败');
        }
   }
   

// 	发放消费券 （百业联盟
	function send_coupon(){
		$save["coupon_dsh_num"]	=$_POST["send_coupon_num"];
		
		if(M('h_user_info_dsh')->where("id='".$_POST['dsh_id']."'")->save($save)) {
            $data=array("state"=>1,"msg"=>"发放成功");
        }else {
            $data=array("state"=>-1,"msg"=>"发放失败");
        }
        $this->ajaxReturn($data);
	}
   
         /**邀请入驻商户申请拒绝*/
   public function sh_agree_say_no(){
  		$save["state"]="4";
		$save["time_register_sayno"]=time();
  		
        if(M('h_user_info_dsh')->where("id='".$_GET['id']."'")->save($save)) {
            $this->success('拒绝成功');
        }else {
            $this->error('拒绝失败');
        }
   }
    /**手机端商户申请详情*/
   public function apply_con(){
   	echo "维护中";
   }
    /**暂停*/
	  public function sh_stop_used(){
	  	$save["state"]="5";
        if(M('h_user_info_dsh')->where("id='".$_GET['id']."'")->save($save)) {
            $this->success('暂停成功');
        }else {
            $this->error('暂停失败');
        }
	  }
   
	   /**暂停的号恢复*/
	  public function sh_back_used(){
	  	$save["state"]="3";
        if(M('h_user_info_dsh')->where("id='".$_GET['id']."'")->save($save)) {
            $this->success('恢复成功');
        }else {
            $this->error('恢复失败');
        }
	  }
    /**删除多商户*/
    public function sh_delete(){
    	
    	
        $user_id = $_GET['id'];
        if(M('h_user_info_dsh')->delete($user_id)) {
            $this->success('删除成功');
            
            //数据删除0925...20.40
        } else {
            $this->error('删除失败');
        }
    }
    
    //商户修改密码
    public function change_psw(){
    	   $date["sh_psw"]=md5($_POST["sh_psw"]);
    	   $date["sh_psw_show"]=$_POST["sh_psw"];
        if(M('h_user_info_dsh')->where("id='".$_GET["id"]."'")->save($date)) {
            $this->success('修改成功');
        } else {
            $this->error('修改失败');
        }
    }
    //添加商户
    function add_sh(){
    	$fenlei=$this->fenlei=M("attribute")
		->field('id,uid,title')
		->where("uid=0 and attribute_style=2 and dsh_id=0 and program_id='".$_COOKIE["program_id"]."'")->select();

    	$a=$this->time_over=date("Y-m-d 23:59:59",strtotime("1 year"));
    
//  
//  	//支付方式列表
//		$this->payment_method=M("payment_method_dsh")->where("program_id='".$_COOKIE["program_id"]."'")->order("sort")->select();
//		
//		//区域选择列表
//		$this->merch_area=M("merch_area_dsh")->where("program_id='".$_COOKIE["program_id"]."'")->order("sort")->select();
//	
    	$this->display();
    }
    
     //添加商户
    function edit_sh(){   	
    	$fenlei=$this->fenlei=M("h_attribute")
		->field('id,uid,title')
		->where("uid=0 and attribute_style=2 and dsh_id=0 and program_id='".$_COOKIE["program_id"]."'")->select();

    	$this->is_edit="1";
 		$a= M('h_user_info_dsh')->where("id='".$_GET["id"]."'")->find();
	
		//分类
		$b=M("h_attribute")->where("id='".$a["fl_id"]."'")->find();
		$a["fl_title"]=$b["title"];
		
		//支付方式
	
		$pay_id["id"]=array("in",$a["payment_method_id"]);
		if(!empty($a["payment_method_id"])){
			$c=M("payment_method_dsh")->where($pay_id)->select();
		}
		
		$c_str='';
		for($c_1=0;$c_1<count($c);$c_1++){
			$c_str .="<div class=\"choose_css\">".$c[$c_1]["title"]."<\/div><input name=\"pay_list_id[]\" value=\"".$c[$c_1]["id"]."\" type=\"hidden\">";
		}
		
		
		$a["payment_method_title"]=$c;
		$a["payment_method_div"]=$c_str;
		
		//区域选择
		$d=M("merch_area_dsh")->where("id='".$a["merch_area_id"]."'")->find();
		$a["merch_area_title"]=$d["title"];
		
		$this->info=$a;
		
		
		//支付方式列表
		$wherepay["program_id"]=$_COOKIE["program_id"];
		if(!empty($a["payment_method_id"])){
		$wherepay["id"]=array("notin",$a["payment_method_id"]);
		}
		$payment_method=M("payment_method_dsh")->where($wherepay)->order("sort")->select();

		$this->payment_method=$payment_method;
		//区域选择列表
		$this->merch_area=M("merch_area_dsh")->where("program_id='".$_COOKIE["program_id"]."'")->order("sort")->select();
	
		
    	$this->display('add_sh');
    }
    
    //子商户支付方式
    function ajax_pay(){

    	$a= M('h_user_info_dsh')->where("id='".$_POST["dsh_id"]."'")->find();
    	if(!empty($a["payment_method_id"])){
    		$pay_id["id"]=array("in",$a["payment_method_id"]);
			$c=M("payment_method_dsh")->where($pay_id)->select();
			$c_str='';
			for($c_1=0;$c_1<count($c);$c_1++){
				$c_str .="<div class=\"choose_css\">".$c[$c_1]["title"]."</div><input name=\"pay_list_id[]\" value=\"".$c[$c_1]["id"]."\" type=\"hidden\">";
			}
   }else{
   	$c_str="";
   }
    	
		$this->ajaxReturn($c_str);
    }
    
    //删除支付方式
    function ajax_del_pay(){
    	$a=M("h_user_info_dsh")->where("id='".$_POST["dsh_id"]."'")->find();
    	
    	$arr=explode(",",$a["payment_method_id"]);
    	for($i=0;$i<count($a);$i++){
    		if($arr[$i] != $_POST["pay_id"]){
    			$arr_new[]=$arr[$i];
    		}
    	}
    	$save["payment_method_id"]=implode(",",$arr_new);
    	if(M("h_user_info_dsh")->where("id='".$_POST["dsh_id"]."'")->save($save)){
    		$date=array("state"=>1,"msg"=>"删除成功");
    	}else{
    		$date=array("state"=>-1,"msg"=>"删除失败");
    	}
    		$this->ajaxReturn($date);
    }
   //添加修改按钮 
    function runAdd_merch(){
    	//邀请商户，添加商户    多商户的商户和 服务商的商户是直接关系，和服务商无关
    	$receive=I();
  	
		$upload = new \Think\Upload();// 实例化上传类
	    $upload->maxSize   =     3145728 ;// 设置附件上传大小
	    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
	    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
	    // 上传文件 
	    $info   =   $upload->upload();
			    
		if($info){
			$receive['logo']=$info['image']['savepath'].$info['image']['savename'];
		}else{
//			if(empty($_GET["id"])){
//				$this->error('无上传图片');	
//          	$error=$upload->getError();
//	    		$data=array("status" => -1, "msg" => "图片上传失败",'error'=>$error);
//			}
		}    
		
		if(empty($_GET["id"])){
			$receive["time_add"]=time();//添加时间
		  	$receive["time_over"]=strtotime($_POST["time_over_f"]);//到期时间
			
	
			
			$receive["sh_psw"]=md5($receive["sh_psw"]);
			$receive["sh_psw_show"]=$receive["sh_psw"];
			$receive["dsh_state"]=2;
			$receive["program_id"]=$_COOKIE["program_id"];

		    if(M("h_user_info_dsh")->add($receive)){
		    	$this->success('添加成功',U('Supermarket/in_ing'));
		    }else{
		    	$this->error('添加失败');	
		    }
		}else{
	
			if(M("h_user_info_dsh")->where(array('id'=>$_GET['id']))->save($receive)){
		    	$this->success('修改成功',U('Supermarket/in_ing'));
		    }else{
		    	$this->error('修改失败');	
		    }
		}	
    }
    //递归
	function bq($arr,$p=0){ $ar=array(); foreach($arr as $v){ if($v["uid"]==$p){ $v["child"]=$this->bq($arr,$v["id"]);$ar[]=$v;}} return $ar;}
	
    //一点一码
    function qdcode(){
    	if(empty($_GET["id"])){
    		$this->error('参数错误');
    	}
    	//看看服务器有没有这个二维码
    	$is_qdcode=M("h_user_info_dsh")->where("id='".$_GET["id"]."'")->find();
    	
    		if(!empty($is_qdcode["qd_code"])){
	    			unlink('./'.$is_qdcode["qd_code"]);
	    			
	    	}
    		$a=$this->test($program_id=$_COOKIE["program_id"],$dsh_id=$_GET["id"]);//存入物理图片
    		if($a){
    			$save["qd_code"]=substr($a, 2);
    	
	    		M("h_user_info_dsh")->where("id='".$_GET["id"]."'")->save($save);
	    		
	    		$url=$save["qd_code"];

	    		$file_name="二维码.jpg";
	    		if(!empty($url)){
	    			$this->downfile($url,$file_name);//下载服务器图片
	    		}else{
	    			$this->error('生成二维码错误');
	    		}	
    		}else{
    			$this->error('生成二维码错误');
    		}
    }

        //http  header 下载文件
    function downfile($fileurl,$file_name){
        $filename=$fileurl;
        $file  =  fopen($filename, "rb");
        Header( "Content-type:  application/octet-stream ");
        Header( "Accept-Ranges:  bytes ");
        Header( "Content-Disposition:  attachment;  filename= ".$file_name);
        $contents = "";
        while (!feof($file)) {
            $contents .= fread($file, 8192);
        }
        echo $contents;
        fclose($file);
    }
    //保存二维码
    function test($program_id,$dsh_id) {
        $url = 'http://sz800800.cn/pg.php/Qdcode/qd_code_dsh?program_id='.$program_id.'&dsh_id='.$dsh_id;

        $header = array("Connection: Keep-Alive", "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8", "Pragma: no-cache", "Accept-Language: zh-Hans-CN,zh-Hans;q=0.8,en-US;q=0.5,en;q=0.3", "User-Agent: Mozilla/5.0 (Windows NT 5.1; rv:29.0) Gecko/20100101 Firefox/29.0");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, $v);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');

        $content = curl_exec($ch);
        $curlinfo = curl_getinfo($ch);
      //  echo "string";
      //  print_r($curlinfo);
//关闭连接
        curl_close($ch);

        if ($curlinfo['http_code'] == 200) {
            if ($curlinfo['content_type'] == 'image/jpeg') {
                $exf = '.jpg';
            } else if ($curlinfo['content_type'] == 'image/png') {
                $exf = '.png';
            } else if ($curlinfo['content_type'] == 'image/gif') {
                $exf = '.gif';
            }
//存放图片的路径及图片名称  *****这里注意 你的文件夹是否有创建文件的权限 chomd -R 777 mywenjian

      //         $filename = date("YmdHis") . uniqid() . $exf;//这里默认是当前文件夹，可以加路径的 可以改为 $filepath = '../'.$filename
                 $filename = date("YmdHis") . uniqid() . ".jpg";//这里默认是当前文件夹，可以加路径的 可以改为 $filepath = '../'.$filename
             $filepath = './qdcode/'.$filename;

            //   $res = file_put_contents($filename, $content);//同样这里就可以改为$res = file_put_contents($filepath, $content);
              $res = file_put_contents($filepath, $content);
        }
        return $filepath;
    }
    
    function artical_index(){
    //	$this->ad=M('artical_dsh')->where("index_show=1 and program_id='".$_COOKIE["program_id"]."'")->select();
    	$where["artical_dsh.index_show"]="1";
    	$where["artical_dsh.program_id"]=$_COOKIE["program_id"];
    	
    	$this->ad=$this->artical_com($where);
    	$this->display();
    }
    function artical_registe(){
    //	$this->ad=M('artical_dsh')->where("index_show=0 and program_id='".$_COOKIE["program_id"]."'")->select();
    	
    	$where["artical_dsh.index_show"]="2";
    	$where["artical_dsh.program_id"]=$_COOKIE["program_id"];
    	
    	$a=$this->ad=$this->artical_com($where);
 //  	dump(M("artical_dsh")->_sql());dump($a);die;
    	$this->display();
    }
    function artical_com($where){
    	
    	$field='artical_dsh.id,artical_dsh.program_id,artical_dsh.title,artical_dsh.sort,artical_dsh.content,artical_dsh.index_sort,
    	artical_dsh.is_show,artical_dsh.time_set,artical_dsh.user_id,artical_dsh.dsh_id,artical_dsh.image,artical_dsh.index_show,
    	
		user_info_dsh.sh_name 
		';
		$thisad=M("artical_dsh")
		->field($field)
		->join('left join user_info_dsh ON user_info_dsh.id=artical_dsh.dsh_id')
		->where($where)
		->order("sort")
		->select();
		
		return $thisad;
    }
    //文章详情
    function artical_con(){
    	$this->info=M("artical_dsh")->where("id='".$_GET["id"]."'")->find();
    	$this->display();
    }
    
    
    function artical_agree(){
    	
    	$save["index_show"]="1";
    if(M("artical_dsh")->where("id='".$_GET["id"]."'")->save($save)){
    		
    $this->success('设置成功',U('Merch/artical_index'));
		}else{
		$this->error('失败');	
	 }
    }
    
    function artical_say_no(){
    	  	$save["index_show"]="3";
    if(M("artical_dsh")->where("id='".$_GET["id"]."'")->save($save)){
    		
    $this->success('设置成功',U('Merch/artical_registe'));
		}else{
		$this->error('失败');	
	 }
    }
    
    public function artical_add(){
		//0505子商户只能发布一个文章
		if($_COOKIE["program_id"]=="JT201711081030423109"){
			$where['program_id']=$_COOKIE["program_id"];
			$where['dsh_id']=$_COOKIE["admin_dsh_id"];
			$a=M('artical_dsh')->where($where)->find();
			if(!empty($a)){
				$this->error('子商户只允许发布一个最新促销');	
			}
		}
		$this->display();
	}
	public function artical_edit(){
		 $a= $this->info=M('artical_dsh')->where("id=".$_GET['id'])->find();
	
		$this->display('artical_add');
	}
	public function run_artical_add(){
		$receive=I();
		$receive["program_id"]=$_COOKIE["program_id"];
		
		
		$upload = new \Think\Upload();// 实例化上传类
			$upload->maxSize   =     3145728 ;// 设置附件上传大小
			$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath  =     './Uploads/'; // 设置附件上传根目录

		// 上传文件 
		$info   =   $upload->upload();
		 if($info){
             $receive['image']=$info['image']['savepath'].$info['image']['savename'];

			    }else{
			    	if(empty($_GET["id"])){
			    		$this->error('无上传图片');	
                	$error=$upload->getError();
		    		$data=array("status" => -1, "msg" => "图片上传失败",'error'=>$error);
			    	}
			    	
			    }

		 if(empty($_GET['id'])) {
		$receive['dsh_id']=0;
		$receive['time_set']=time();
		
			$receive['index_show']=1;
		
		 if(M('artical_dsh')->add($receive)){
			    	$this->success('添加成功',U('Merch/artical_index'));
			    }else{
			    	$this->error('添加失败');	
			    } 
        }else {
			    if(M('artical_dsh')->where(array('id'=>$_GET['id']))->save($receive)){
			    	$this->success('修改成功',U('Merch/artical_index'));
			    }else{
			    	$this->error('修改失败');	
			    }

			}
       }   
	
		public function artical_delete(){
		
			$user_id = $_GET['id'];
	
	        if(M('artical_dsh')->delete($user_id)) {
	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
		}
		
		//子商户入驻支付记录
		function merch_pay_record(){
//			M("record_total")

			$sql .=" FROM record_total ";
			$sql .=" WHERE state=2 and program_id ='".$_COOKIE["program_id"]."'";
			$sql .=" ORDER BY time_pay desc ";
		
			$sql_01=$sql;
			$sql_02=$sql;
			$sql_01  =" select count(id)" .$sql_01;
			$sql_02  =" SELECT  * " .$sql_02;
			$list = M("record_total") -> query($sql_01);
			$total =$list[0]["count(id)"];
		
		   	$per = 10;
			$page = new \Component\Page($total, $per); 	

			$sql_02 .=$page->limit;
			$list = D("record_total") -> query($sql_02);
			$pagelist = $page -> fpage();
			
			$this ->pages = $pagelist;
			
			for($i=0;$i<count($list);$i++){
				$b[$i]=M("h_user_info_dsh")->field("sh_name")->where("order_num='".$list[$i]["order_num"]."'")->find();
				$list[$i]["sh_name"]=$b[$i]["sh_name"];
			}
			$this ->list  =$list;
			
			
			$this->display();
		}
		/*
		 *店员      始
		 * */
		
		
		
		function assistant_common($state){
			
			
		$field='
			assistant_add.id,assistant_add.tel,assistant_add.time_registe,assistant_add.time_agree,assistant_add.name,
			assistant_add.time_say_no,assistant_add.state,
			user_info_dsh.sh_name
		';
		$a=M("assistant_add")
		->field($field)
		->join('left join user_info_dsh ON user_info_dsh.id=assistant_add.shop_id')
		->where("assistant_add.state='".$state."'"." and assistant_add.program_id='".$_COOKIE["program_id"]."'")
		->order("time_registe desc")
		->select();
		
		return $a;
		}
		function assistant_is(){
			

			
			$a=$this->assistant_common($state=0);
			$this->list=$a;
	
			$this->display();
		}
		function assistant_ing(){
	
//			$this->list=M("assistant_add")->where("state=1 and program_id='".$_COOKIE["program_id"]."'")->select();	
			$this->list=$this->assistant_common($state=1);	
			$this->display();
		}
		function assistant_stop(){
//			$this->list=M("assistant_add")->where("state=2 and program_id='".$_COOKIE["program_id"]."'")->select();	
			$this->list=$this->assistant_common($state=2);
			$this->display();
		}
		function assistant_con(){
			$this->info=M("assistant_add")->where("id='".$_GET["id"]."'")->find();		
			
			$this->display();
		}
		function assistant_agree(){
			$save["state"]=1;
			$save["time_agree"]=time();
			
			if(M('assistant_add')->where("id='".$_GET['id']."'")->save($save)){
		    	$this->success('操作成功',U('Merch/assistant_ing'));
		    }else{
		    	$this->error('操作失败');	
		    }	
		}
		function assistant_say_yes(){
			$save["state"]=1;
			$save["time_agree"]=time();
	
			if(M('assistant_add')->where("id='".$_GET['id']."'")->save($save)){
		    	$this->success('操作成功',U('Merch/assistant_ing'));
		    }else{
		    	$this->error('操作失败');	
		    }	
		}
		function assistant_astop(){
			$save["state"]=2;
			$save["time_stop"]=time();
	
			if(M('assistant_add')->where("id='".$_GET['id']."'")->save($save)){
		    	$this->success('操作成功',U('Merch/assistant_ing'));
		    }else{
		    	$this->error('操作失败');	
		    }	
		}
		//拒绝
		function assistant_say_no(){
			$save["state"]=3;
			$save["time_say_no"]=3;
			
			if(M('assistant_add')->where("id='".$_GET['id']."'")->save($save)){
		    	$this->success('操作成功',U('Merch/assistant_ing'));
		    }else{
		    	$this->error('操作失败');	
		    }	
		}
		function assistant_del(){

			if(M('assistant_add')->where("id='".$_GET['id']."'")->delete()){
		    	$this->success('操作成功');
		    }else{
		    	$this->error('操作失败');	
		    }	
		}

		
		/*
		 *店员      终
		 * */
		
		/**
		 * 设置子商户管理员    始
		 * */
		function manager_list(){
//			dump($_GET);die;
			if($_GET["is_hmanager"]==1){
				$field='
					members.id,members.nickname,members.head,members.openid	
				';	
				$sql .=" FROM members ";
				$sql .=" WHERE members.program_id ='".$_COOKIE["program_id"]."'"."and members.nickname <>'undefined'";
		
			}else{
				$field='
					members.id,members.nickname,members.head,members.openid,
					user_info_dsh.sh_name
				';	
				$sql .=" FROM members ";
				$sql .=" left join user_info_dsh ON user_info_dsh.openid_manager=members.openid";
				$sql .=" WHERE members.program_id ='".$_COOKIE["program_id"]."'"."and members.nickname <>'undefined'";
				$sql .=" and members.openid <> ( select (case when openid_manager then openid_manager else 0 end) from user_info_dsh where  id ='".$_GET["shop_id"]."'".")";
			}
			if($_GET["str"]){
				$get_str="%".$_GET['str']."%";
				$sql .=" and nickname like'".$get_str."'";
			}
			
		$sql_01=$sql;
		$sql_02=$sql;
		
		$sql_01  =" select count(members.id)" .$sql_01;
		$sql_02  =" SELECT  ".$field  .$sql_02;
//		dump($sql_01);dump($sql_02);die;
		$list = M("members") -> query($sql_01);

		$total =$list[0]["count(members.id)"];
	
	   	$per = 10;
		$page = new \Component\Page($total, $per); 	
		$sql_02 .=$page->limit;
		$list = D("members") -> query($sql_02);
		$pagelist = $page -> fpage();

		$this ->pages = $pagelist;
		$this ->list  =$list;
		$this ->shop_id  =$_GET["shop_id"];
		
		if($_GET["is_hmanager"]==1) $this ->is_hmanager  =1;

		if($_GET["change_state"]==1){
			$this->change_state=1;
		}
		
		$this->display();
		}
		
		function manager_set(){
	
			$save["openid_manager"]=$_GET["openid"];
			$save["time_set_manager"]=time();
			if(M("h_user_info_dsh")->where("program_id='".$_COOKIE["program_id"]."'"."and id='".$_GET["shop_id"]."'")->save($save)){
				
				$this->success('操作成功',U('Merch/in_ing'));
		    }else{
		    	$this->error('操作失败');	
		    }	
		}
		/**
		 * 设置子商户管理员    终
		 * */
		public function ad_add(){

		 $a= $this->info=M('ad')->where("id=564")->find();

		$this->display();
	}
	
	
	//	商品模块   0
	 function goods_commem_0127($str,$goods_state,$str_f){
		if(isset($str)){
			$where['_string']='
				(id like "%'.$str.'%")  
				OR (goods_title like "%'.$str.'%")
			';
		}
		if($goods_state==0){
			$where["goods_state"]=array("in","1,3");//只显示上架和下架的
		}else{
			$where["goods_state"]=$goods_state;
		}
		$where["program_id"]=$_COOKIE["program_id"];
		$where["goods_baiye"]=0;
		$where["attribute_style02"]=4;
        $total = D("h_goods")->where($where)->count();
        $per = 6;
      
        $page = new \Component\Page($total, $per); 
        $sql = "select * from h_goods  where  attribute_style02=4 and  program_id='".$_COOKIE["program_id"]."'";
        if(isset($str)){
        	$sql.=" and (goods_title like '"."%".$str."%"."'"." or id like '"."%".$str."%"."'".")";
        }
        if($goods_state==0){
			$sql.=" and goods_state in (1,3) ";
		}else{
			$sql.=" and goods_state='".$goods_state."'";
		}
		$sql .=" order by sort asc ";
        $sql .=$page->limit;

        $info = D("h_goods") -> query($sql);
        $pagelist = $page -> fpage();
        
        	for($i=0;$i<count($info);$i++){
					//商品图片
					$arr1102=explode(",",$info[$i]['image']);
					$info[$i]["image"]=$arr1102[0];

				//查找商品是哪个子商户的 dsh_id
				$info[$i]["sh_name"]=M("h_user_info_dsh")->field('sh_name')->where("id='".$info[$i]['dsh_id']."'")->find();
					
				}
        
        $a[0]=$info;
        $a[1]=$pagelist;
        return $a;
	}
	//出售中
	public function selling(){
		$this->his_str=$_GET["str"];
		$a=$this->goods_commem_0127($str=$_GET["str"],$goods_state=0,$str_f=$_GET["str_f"]);
		$info=$a[0];$pagelist=$a[1];
        $this -> assign('goods', $info);
        $this -> assign('pages', $pagelist);
        
		$this->program_id=$_COOKIE["program_id"];
		
		$this->display();
	}
	

	//售罄
	public function haved_selled(){

		 $a=$this->goods_commem_0127($str=$_GET["str"],$goods_state=2,$str_f=$_GET["str_f"]);
		$info=$a[0];$pagelist=$a[1];
        $this -> assign('goods', $info);
        $this -> assign('pages', $pagelist);
        
 
		
		$this->display();
	}
	//仓库中
	public function cangku(){

		 $a=$this->goods_commem_0127($str=$_GET["str"],$goods_state=3,$str_f=$_GET["str_f"]);
		$info=$a[0];$pagelist=$a[1];
        $this -> assign('goods', $info);
        $this -> assign('pages', $pagelist);
	
		$this->display();
	}
	//回收站
	public function huishou(){

		 $a=$this->goods_commem_0127($str=$_GET["str"],$goods_state=4,$str_f=$_GET["str_f"]);
		$info=$a[0];$pagelist=$a[1];
        $this -> assign('goods', $info);
        $this -> assign('pages', $pagelist);
		
		$this->display();
	}
	
	public function goods_add(){

		 //一级分类名 dsh_id
		$this->fenlei=M("h_attribute")
		->field('id,uid,title')
		->where("uid=0 and attribute_style=1 and attribute_style02=4 and dsh_id=0 and program_id='".$_COOKIE["program_id"]."'")->select();
		

		$this->display("goods_ktv");
	}
	public function goods_edit(){
	
		$info=M('h_goods')->where("id=".$_GET['id'])->find();

//获得商品参数
		$canshu=M("h_specifications")->where("goods_id='".$_GET['id']."'")->find();		
		$this->canshu=	$arr=$this->str_to_arr($canshu["title"],$canshu["content"]);


//一级分类名
		$fenlei1611=M("h_attribute")->where("id='".$info["fenlei_1"]."'")->find();
		$info["fenlei_1_title"]=$fenlei1611["title"];

//二级分类名
		$fenlei1612=M("h_attribute")->where("id='".$info["fenlei_2"]."'")->find();
		$info["fenlei_2_title"]=$fenlei1612["title"];
	
		 $this->info=$info;
		//遍历商品分类
		$this->fenlei=M("h_attribute")
		->field('id,uid,title')
		->where("uid=0 and is_show=1 and attribute_style=1 and attribute_style02=4 and program_id='".$_COOKIE["program_id"]."'")->select();

	if(!empty($info["str_guige"])){
		//遍历商品的规格
		$arr1128_1=explode(',',$info["str_img"]);
		$arr1128_2=explode(',',$info["str_guige"]);
		$arr1128_3=explode(',',$info["str_remark"]);
		$arr1128_4=explode(',',$info["str_price"]);
		$arr1128_5=explode(',',$info["str_num"]);
		
		$arr1128_6=explode(',',$info["str_guige02"]);
		for($q1=0;$q1<count($arr1128_1);$q1++){
			$arr1128[$q1]["img"]	=$arr1128_1[$q1];
			$arr1128[$q1]["guige"]	=$arr1128_2[$q1];
			$arr1128[$q1]["remark"]	=$arr1128_3[$q1];
			$arr1128[$q1]["price"]	=$arr1128_4[$q1];
			$arr1128[$q1]["num"]	=$arr1128_5[$q1];
		}	
		for($q2=0;$q2<count($arr1128_6);$q2++){
			$arr1207[$q2]["guige02"]=$arr1128_6[$q2];
		}

		$this->guige 	= $arr1128;
		$this->guige_num= count($arr1128);
		$this->guige02	= $arr1207;
	}else{
		$this->guige_num= 1;
	}


		$this->is_edit="1";
		$this->display('goods_ktv');
	}
	
	public function run_goods_add(){


		if($_POST["goods_subtitle"])$_POST["good_attribute"]	= $_POST["goods_subtitle"];	
		
		$_POST["program_id"]		= $_COOKIE["program_id"];
		
		if($_POST["fenlei_1_title"]){
			$fenlei_1=M("h_attribute")->where("uid=0 and attribute_style=1 and attribute_style02=2 and title='".$_POST["fenlei_1_title"]."'"."and program_id='".$_COOKIE["program_id"]."'")->find();
			$_POST["fenlei_1"]=$fenlei_1["id"];
		}

		$fenlei_2=M("attribute")->where("uid !=0 and title='".$_POST["fenlei_2_title"]."'")->find();
		$_POST["fenlei_2"]=$fenlei_2["id"];


		if($_POST["canshu_title"]) $str1026["title"]	= implode(",",$_POST["canshu_title"]);//参数名数组	
		if($_POST["canshu_con"]) $str1026["content"]  	= implode(",",$_POST["canshu_con"]);//参数值数组	
		
		if($_POST["content_list_str"]) $_POST["content_list"]= implode("^",$_POST["content_list_str"]);//参数名数组	
	
		if($_POST["guige"])		$_POST["str_guige"]  	= implode(",",$_POST["guige"]);//1128 商品规格
		if($_POST["price"])		$_POST["str_price"]  	= implode(",",$_POST["price"]);//1128 商品规格
		if($_POST["num"])		$_POST["str_num"]  		= implode(",",$_POST["num"]);//1128 商品规格
		if($_POST["remark"])	$_POST["str_remark"]  	= implode(",",$_POST["remark"]);//1128 商品规格
		if($_POST["guige02"])	$_POST["str_guige02"]  	= implode(",",$_POST["guige02"]);//1128 商品规格

	
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =  3145728 ;// 设置附件上传大小
		$upload->exts      =  array('jpg', 'gif', 'png', 'jpeg','mp4');// 设置附件上传类型
		$upload->rootPath  =   './Uploads/'; // 设置附件上传根目录
		// 上传文件 
		$info   =   $upload->upload();

//		$check_imgchange=0;
//		for($n=0;$n<count($_POST["changeimg_key"]);$n++){
//			$check_imgchange+=$_POST["changeimg_key"][$n];
//		}
//		if($check_imgchange>count($info)){
//			//有图片未上传	
//			foreach($info as $k0627=>$v0627){
//				unlink('./Uploads/'.$info[$k0627]["savepath"].$info[$k0627]["savename"]);
//			}
//
//			$this->error('规格必须上传图片');	
//		}
		

		if($info){
//有上传图片的地方进来
//		foreach($info as $k=>$v){
//			if($info[$k]['key']=="image"){
//			    $date['image'].=$info[$k]['savepath'].$info[$k]['savename'].",";
//			}else if($info[$k]['key']=="img"){
//			    $date['img'].=$info[$k]['savepath'].$info[$k]['savename'].",";
//			}
//		}			
//		$arr_0302=explode(".",$info["goods_video"]['savename']);
//			if($arr_0302[1]=="mp4"){
//				$_POST["goods_video"]=$info["goods_video"]['savepath'].$info["goods_video"]['savename'];
//			}
//					
//			$_POST['image']   		= substr($date['image'],0,strlen($date['image'])-1); 	//去掉最后一个逗号
//			
//			if($check_imgchange==0){
//				//无规格图修改
//				$_POST['str_img'] 	= substr($date['img'],0,strlen($date['img'])-1); 		//去掉最后一个逗号
//			}else{
//				$guige_img			=substr($date['img'],0,strlen($date['img'])-1);
//				$guige_img_arr		=explode(",",$guige_img);
//				
//				$old_guige_img=M("h_goods")->field("str_img")->where("id='".$_GET["id"]."'")->find();
//
//				$old_guige_img_arr	=explode(",",$old_guige_img["str_img"]);
//				
//				if( count($_POST["changeimg_key"]) > count($old_guige_img_arr) ) {
//					for( $count_dif=0;$count_dif<(count($_POST["changeimg_key"]) - count($old_guige_img_arr) );$count_dif++){ $old_guige_img_arr[]=""; }
//				}
//				
//				$change_key=0;
//				for($guige=0;$guige<count($_POST["changeimg_key"]);$guige++){
//					if($_POST["changeimg_key"][$guige]==1){
//						$old_guige_img_del_arr[$guige]=$old_guige_img_arr[$guige];
//						$old_guige_img_arr[$guige]=$guige_img_arr[$change_key];
//						$change_key++;
//					}
//				}
//				$old_guige_img_del_str	=implode(",",$old_guige_img_del_arr);
//				$new_guige_img_str		=implode(",",$old_guige_img_arr);
//
//				$_POST['str_img'] 		= $new_guige_img_str;
//			}
			 $_POST['image']=$info['image']['savepath'].$info['image']['savename'];		
		}else{
			//无上传文件 
				
		}

		$_POST["time_update"]=time();
		if(empty($_GET["id"])){
			$_POST["attribute_style02"]=4;
			//执行添加
			$_POST["time_set"]			= time();
			$only=M("h_goods")->where("time_set='".$_POST["time_set"]."'")->find();
			if(empty($only)){
				if(empty($_POST['image'])) $this->error('必须上传商品图片');
				if(M("h_goods")->add($_POST)){
					$set_img=M("h_goods")->where("time_set='".$_POST["time_set"]."'")->find();
//1026...22.24 多条数据改写成一条
						$str1026["goods_id"]=$set_img["id"];
						M("h_specifications")->add($str1026);//商品参数
					$this->success('添加成功',U('selling'));
			    }else{
			    	$this->error('添加失败');	
			    }
			}
		}else{
			//执行修改
	 		$goods1103=M("h_goods")->where("id='".$_GET["id"]."'")->find();	

//	 			if(!empty($goods1103["image"]) ){
//	 			$_POST["image"]=(empty($_POST["image"]))?$goods1103["image"]:$goods1103["image"].",".$_POST["image"];
//	 		}	
	 		
	 		
//			
//	 		if(!empty($goods1103["str_img"])){
//	 			if($check_imgchange==0){
//	 				$_POST["str_img"]=(empty($_POST["str_img"]))?$goods1103["str_img"]:$goods1103["str_img"].",".$_POST["str_img"];
//	 			}
//	 		}		
	
	 		if(M("h_goods")->where("id='".$_GET["id"]."'")->save($_POST)){

			//删除这个商品的全部参数，然后重新赋值  1026...22.27改写
				if($check_imgchange!=0){
					$old_guige_img_delarr=explode(",",$old_guige_img_del_str);
					for($del_guige=0;$del_guige<count($old_guige_img_delarr);$del_guige++){
						unlink('./Uploads/'.$old_guige_img_delarr[$del_guige]);
					}
				}
		
		 		$is_null1107=M("h_specifications")->where("goods_id='".$_GET["id"]."'")->find();
		 				$str1026["goods_id"]=$_GET["id"];
		 		if(empty($is_null1107)){
		 		
		 			M("h_specifications")->add($str1026);
		 		}else{
		 			
		 			M("h_specifications")->where("goods_id='".$_GET["id"]."'")->save($str1026);
		 			
		 		}
		 		
	 			$this->success('修改成功',U('selling'));
		    }else{
		    	$this->error('修改失败');	
		    }
		}
	
//1128...14.15  增加了新的模块：商品规格-----先把东西存入规格表，然后根据页面传递过来的唯一标识参数，找到那个id，然后写入商品的表里面

		
	}
	
	 //异步删除图片
	public function ajax_delete_img(){
		//得到那条  好消息 的id、和对应的图片的位置键值，对数据的字符串进行删减
		
		$info=M('h_goods')->where("id='".$_POST["id"]."'")->find();
		
		$arr=explode(",",$info["image"]);//字符串转换成数组
		for($i=0;$i<count($arr);$i++){
			if($i != $_POST["key"]){
				$arr_new[]=$arr[$i];
			}
		}
		$str_new["image"]=implode(",",$arr_new);//数组转换成 字符串   这个就是新的需要存的数据
		if($str_new==","){
			$str_new=null;
		}
		if(M("h_goods")->where("id='".$_POST["id"]."'")->save($str_new)){
			
			unlink('./Uploads/'.$arr[$_POST["key"]]);
			
			$date="1";//保存并删除旧图片成功
		}else{
			$date="2";//操作失败
		}
		$this->ajaxReturn($date);
	}
	
	 //异步删除规格
	public function ajax_delete_guige(){
	//得到商品id，得到商品规格的key值，
		//state  =1;删除一级规格内容、=2删除二级规格内容
		$info=M('h_goods')->where("id='".$_POST["id"]."'")->find();
		
		if($_POST["state"]==1){
			$arr01=explode(",",$info["str_img"]);//字符串转换成数组    
			$arr02=explode(",",$info["str_guige"]);
			$arr03=explode(",",$info["str_remark"]);
			$arr04=explode(",",$info["str_num"]);
			$arr05=explode(",",$info["str_price"]);
			for($i=0;$i<count($arr01);$i++){ 
				if($i != $_POST["key"]){
					$arr_new01[]=$arr01[$i];
					$arr_new02[]=$arr02[$i];
					$arr_new03[]=$arr03[$i];
					$arr_new04[]=$arr04[$i];
					$arr_new05[]=$arr05[$i];
				}
			}
			$str_new["str_img"]		=implode(",",$arr_new01);//数组转换成 字符串   这个就是新的需要存的数据
			$str_new["str_guige"]	=implode(",",$arr_new02);
			$str_new["str_remark"]	=implode(",",$arr_new03);
			$str_new["str_num"]		=implode(",",$arr_new04);
			$str_new["str_price"]	=implode(",",$arr_new05);
			if($str_new==","){
				$str_new=null;
			}
		}else if($_POST["state"]==2){
			$arr011=explode(",",$info["str_guige02"]);//字符串转换成数组    
			for($i=0;$i<count($arr01);$i++){ 
				if($i != $_POST["key"]){
					$arr_new011[]=$arr011[$i];
				}
			}
			$str_new["str_guige02"]=implode(",",$arr_new011);//数组转换成 字符串   这个就是新的需要存的数据
			if($str_new==","){
				$str_new=null;
			}
		}
		if(M("h_goods")->where("id='".$_POST["id"]."'")->save($str_new)){
			unlink('./Uploads/'.$arr01[$_POST["key"]]);
			$date="1";//保存并删除旧图片成功
		}else{
			$date="2";//操作失败
		}
		$this->ajaxReturn($date);
	}
	//删除商品
		public function goods_delete(){
				 $user_id = $_GET['id'];
	        if(M('h_goods')->delete($user_id)) {
	        	
	        	$a=M('h_goods')->where("id='".$_GET["id"]."'")->find();

	        		$arr=explode(",",$a["image"]);
					for($i=0;$i<count($arr);$i++){
						unlink('./Uploads/'.$arr[$i]);
					}
	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
		}
		
		public function goods_huishou(){
			$date["goods_state"]="4";
			if(M('h_goods')->where("id='".$_GET["id"]."'")->save($date)) {
	            $this->success('回收成功');
	        } else {
	            $this->error('回收失败');
	        }
		}
		public function goods_huishou_back(){
			$date["goods_state"]="3";
			if(M('h_goods')->where("id='".$_GET["id"]."'")->save($date)) {
	            $this->success('回收成功');
	        } else {
	            $this->error('回收失败');
	        }
		}

	//商品分类
	public function fenlei(){

		$fl=M("h_attribute")
		->field('id,uid,title,image_1,is_show,title_english,sort')
		->where("dsh_id=0 and attribute_style=1 and attribute_style02=4 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$all_fenlei=$this->fenlei=$this->bq($fl);

	//$this->fenlei=$fl;
		$this->display();
	}
	
	public function fenlei_add(){
		
		$this->display();
	}
	//添加子分类
	public function fenlei_add02(){
		$this->add_child=$_GET["id"];
		
		$this->display('fenlei_add');
	}
	
	public function fenlei_edit(){
		 $a= $this->info=M('h_attribute')->where("id=".$_GET['id'])->find();
	
		$this->display('fenlei_add');
	}
	
	public function run_fenlei_add(){
		$receive=I();
		$receive["program_id"]=$_COOKIE["program_id"];
			$upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =     3145728 ;// 设置附件上传大小
			    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录

			    // 上传文件 
			    $info   =   $upload->upload();
			    
			    if($info){
			    	 $receive['image_1']=$info['image02']['savepath'].$info['image02']['savename'];
			    }
			    
			    if(empty($_GET['id'])){
			    	$receive["dsh_id"]=0;
					$receive["attribute_style"]=1;
					$receive["attribute_style02"]=4;
					
				    if(M('h_attribute')->add($receive)){
				    	$this->success('添加成功.',U('fenlei'));
				    }else{
				    	$this->error('添加失败.');	
				    }
			    }else{
			    	  if(M('h_attribute')->where(array('id'=>$_GET['id']))->save($receive)){
			//如果对一级分类进行隐藏，则对应的二级分类都要隐藏
			        	$a0926=M("h_attribute")->where("id='".$_GET["id"]."'")->find();	
			        	if($a0926["uid"]==0){
			        		$date0926["is_show"]="2";
			        		M("h_attribute")->where("uid='".$_GET["id"]."'")->save($date0926);
			        	}
					    	$this->success('修改成功..',U('fenlei'));
					    }else{
					    	$this->error('修改失败..');	
					    }
			    }
			    
		 
	}
	
	
	//分类删除
		public function fenlei_delete(){
				 $user_id =$_GET['id'];
			$d_zhu_img=M('h_attribute')->where("id='".$_GET['id']."'")->find();
	        $d_zi_img=M('h_attribute')->where("uid='".$_GET['id']."'")->select();
	        	
	        if(M('h_attribute')->delete($user_id)) {
	        	//删除主类图片
	        	unlink('./Uploads/'.$d_zhu_img["image_1"]);
	        	
	        	
	        	//删除 所属 子类 图片
	        	for($i=0;$i<count($d_zi_img);$i++){
	        		unlink('./Uploads/'.$d_zi_img[$i]["image_1"]);
	        	}
	        	
	        	//删除 所属 子类  数据
	 
	        	M('h_attribute')->where("uid='".$_GET['id']."'")->delete();
	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
		}
		public function fenlei_delete02(){		
				$d_img=M('h_attribute')->where("id='".$_GET['id']."'")->find();
				 $user_id = $_GET['id'];
	        if(M('h_attribute')->delete($user_id)) {
	        	//删除对应子类图片
	        	
	        	unlink('./Uploads/'.$d_img["image_1"]);

	           $this->success('删除成功');
	        } else {
	           $this->error('删除失败');
	        }
		}
		
		
			//商品异步上下架
	function ajax_change_ok(){
	$state=M("h_goods")->field("goods_state")->where("id='".$_POST["id"]."'")->find();

		//  goods_state  商品状态（1：在售、2：售罄、3：仓库中、4：回收站）
			if($state["goods_state"]==1){
				$val["goods_state"]="3";
			}else if($state["goods_state"]==3){
				$val["goods_state"]="1";
			}
			
			if(M("h_goods")->where("id='".$_POST["id"]."'")->save($val)){
					$date="1";
			}else{
					$date="2";
			}
			$this->ajaxReturn($date);
	}
		
//		批量上传 0
		  function fileupload(){
  
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");


        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            exit; // finish preflight CORS requests here
        }

        if ( !empty($_REQUEST[ 'debug' ]) ) {
            $random = rand(0, intval($_REQUEST[ 'debug' ]) );
            if ( $random === 0 ) {
                header("HTTP/1.0 500 Internal Server Error");
                exit;
            }
        }

// header("HTTP/1.0 500 Internal Server Error");
// exit;


// 5 minutes execution time  5分钟执行时间
        @set_time_limit(5 * 60);

// Uncomment this one to fake upload time
        usleep(5000);

// Settings
// $targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
        $riqi = date("Y-m-d",time());
        $path = "./Uploads/".$riqi;
        if (!file_exists($path)){
            mkdir($path);
        }

        $targetDir = 'upload_tmp';
        $uploadDir = $path;//上传文件存储路径

        $cleanupTargetDir = true; // Remove old files
        $maxFileAge = 5 * 3600; // Temp file age in seconds


// Create target dir
        if (!file_exists($targetDir)) {
            @mkdir($targetDir);
        }

// Create target dir
        if (!file_exists($uploadDir)) {
            @mkdir($uploadDir);
        }

// Get a file name
        if (isset($_REQUEST["name"])) {
            //   $fileName = $_REQUEST["name"];

            $type001=substr(strrchr($_REQUEST["name"], '.'), 1);
            $ls_yzm=rand(10000,99999);
            $_REQUEST["name"]=date("Ymd",time()).$ls_yzm.'.'.$type001;
            $fileName = $_REQUEST["name"];

            //拼接存储
            $goods=M("h_goods")->where("id='".$_GET["goods_id"]."'")->find();
	            $goods_arr=explode(",",$goods["image"]);
	            $save["image"]=date("Y-m-d",time())."/".$fileName;
	            if(empty($goods_arr)){
	                M("h_goods")->where("id='".$_GET["goods_id"]."'")->save($save);
	            }else{
	                if(in_array($save["image"],$goods_arr)){
	
	                }else{
	                    $save0215["image"]=$goods["image"].",".$save["image"];
	                    M("h_goods")->where("id='".$_GET["goods_id"]."'")->save($save0215);
	                }
	            }
            
          

            $oldPath="./upload/".$fileName;
            $newPath="./Uploads/".date("Y-m-d",time())."/".$fileName;
            copy($oldPath, $newPath);//文件移动
            unlink($oldPath);

        } elseif (!empty($_FILES)) {
            $fileName = $_FILES["file"]["name"];
        } else {
            $fileName = uniqid("file_");
        }

        $md5File = @file('md5list.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $md5File = $md5File ? $md5File : array();

        if (isset($_REQUEST["md5"]) && array_search($_REQUEST["md5"], $md5File ) !== FALSE ) {
            die('{"jsonrpc" : "2.0", "result" : null, "id" : "id", "exist": 1}');
        }

        $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
        $uploadPath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;

// Chunking might be enabled   组块可能会启用
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 1;


// Rmove old temp filees   Rmove旧的临时文件
        if ($cleanupTargetDir) {
            if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
            }

            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

                // If temp file is current file proceed to the next
                if ($tmpfilePath == "{$filePath}_{$chunk}.part" || $tmpfilePath == "{$filePath}_{$chunk}.parttmp") {
                    continue;
                }

                // Remove temp file if it is older than the max age and is not the current file
                if (preg_match('/\.(part|parttmp)$/', $file) && (@filemtime($tmpfilePath) < time() - $maxFileAge)) {
                    @unlink($tmpfilePath);
                }
            }
            closedir($dir);
        }


// Open temp file      打开临时文件
        if (!$out = @fopen("{$filePath}_{$chunk}.parttmp", "wb")) {
            die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }

        if (!empty($_FILES)) {
            if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
            }

            // Read binary input stream and append it to temp file
            if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        } else {
            if (!$in = @fopen("php://input", "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        }
        /* 4096*/
        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }

        @fclose($out);
        @fclose($in);

        rename("{$filePath}_{$chunk}.parttmp", "{$filePath}_{$chunk}.part");

        $index = 0;
        $done = true;
        for( $index = 0; $index < $chunks; $index++ ) {
            if ( !file_exists("{$filePath}_{$index}.part") ) {
                $done = false;
                break;
            }
        }
        if ( $done ) {
            if (!$out = @fopen($uploadPath, "wb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
            }

            if ( flock($out, LOCK_EX) ) {
                for( $index = 0; $index < $chunks; $index++ ) {
                    if (!$in = @fopen("{$filePath}_{$index}.part", "rb")) {
                        break;
                    }

                    while ($buff = fread($in, 4096)) {
                        fwrite($out, $buff);
                    }

                    @fclose($in);
                    @unlink("{$filePath}_{$index}.part");
                }

                flock($out, LOCK_UN);
            }
            @fclose($out);
        }

// Return Success JSON-RPC response
        die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
    }

//		批量上传 1


//	商品模块   1
}