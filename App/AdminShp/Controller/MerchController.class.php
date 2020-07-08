<?php
namespace AdminShp\Controller;
use Think\Controller;
class MerchController extends CommonController {
//多商品概述
//申请中
//驳回
//待入驻
//入驻中    
//暂停中      
//即将到期
//多商户分组
//多商户分类
//数据 订单统计
//数据 多商户统计
//提现 待确认
//提现 待打款
//提现 已打款
//提现 无效的
//结算订单  待确认
//结算订单  待结算
//结算订单  已结算
//结算订单  创建结算清单
//基础设置
    //多商品概述
    public function index(){

    	$this->display();
	}
    //========================多商户管理=========================================
    //申请中
    public function apply_ing(){
//当前状态（1：待审核、2：待入驻（邀请）、3：审核通过（正常）、4:审核拒绝、5：上级禁止、6：服务到期禁止）
 		$a=$tist->list=$this->get_orderlist(1);
 		//dump(M("user_info_dsh")->_sql());
 		//dump($a);die;
        $this->display();
    }
    //驳回
    public function apply_reject(){
//当前状态（1：待审核、2：待入驻（邀请）、3：审核通过（正常）、4:审核拒绝、5：上级禁止、6：服务到期禁止）
 		$tist->list=$this->get_orderlist(4);
        $this->display();
    }
    //待入驻
    public function in_wait(){
    //当前状态（1：待审核、2：待入驻（邀请）、3：审核通过（正常）、4:审核拒绝、5：上级禁止、6：服务到期禁止）
 		$tist->list=$this->get_orderlist(2);
        $this->display();
    }
    //入驻中
    public function in_ing(){
//当前状态（1：待审核、2：待入驻（邀请）、3：审核通过（正常）、4:审核拒绝、5：上级禁止、6：服务到期禁止）
 		$tist->list=$this->get_orderlist(3);
        $this->display();
    }
    //暂停中
    public function in_stop(){
//当前状态（1：待审核、2：待入驻（邀请）、3：审核通过（正常）、4:审核拒绝、5：上级禁止、6：服务到期禁止）
 		$tist->list=$this->get_orderlist(5);
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
    //多商户分类
    public function merch_fenlei(){

        $this->display();
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
    
    $this->program_id=$_COOKIE["program_id"];
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
    	id,sort,sh_name,linkman,tel,time_add,time_over,state,main_project
		';
		$list=$this->list=M("user_info_dsh")
		->field($field)
		->where($where)
		->select();
		return $list;
	}
    /**手机端商户申请通过*/
   public function sh_agree(){
  		$save["state"]="3";
        if(M('user_info_dsh')->where("id='".$_GET['id']."'")->save($save)) {
            $this->success('审核成功');
        }else {
            $this->error('审核失败');
        }
   }
    /**手机端商户申请详情*/
   public function apply_con(){
   	echo "维护中";
   }
    /**删除多商户*/
    public function sh_delete(){
        $user_id = $_GET['id'];
        if(M('user_info_dsh')->delete($user_id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
    //添加商户
    function add_sh(){
    $a=$this->time_over=date("Y-m-d 23:59:59",strtotime("1 year"));
    	$this->display();
    }
    
     //添加商户
    function edit_sh(){   	
 $a= $this->info=M('user_info_dsh')->where("id='".$_GET["id"]."'")->find();

    	$this->display('add_sh');
    }
   //添加修改按钮 
    function runAdd_merch(){
    	//邀请商户，添加商户    多商户的商户和 服务商的商户是直接关系，和服务商无关
    	
    	$receive=I();
    	//获取上级商户id
    	$shagnhu=M("user_info")->where("name='".$_COOKIE["name_p"]."'")->find();
    	$receive["user_id"]=$shagnhu["id"];			//商户账号
		$receive["program_id"]=$_COOKIE["program_id"];  //小程序id
	
			$upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =     3145728 ;// 设置附件上传大小
			    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
			    // 上传文件 
			    $info   =   $upload->upload();
			    
		 if(empty($_GET['id'])) {
		 	//未接收id ，执行添加操作------------------------------------
			 if($info){
			 	//有上传图片==========================================
                $receive['logo']=$info['image']['savepath'].$info['image']['savename'];
				   
				  	$receive["time_add"]=time();//添加时间
				  	$receive["time_over"]=strtotime($_POST["time_over_f"]);//到期时间
					
					$receive["state"]="2";//邀请入驻
				    if(M('user_info_dsh')->add($receive)){
				    	$this->success('添加成功',U('Merch/apply_ing'));
				    }else{
				    	$this->error('添加失败');	
				    }
			    }else{
			    //无上传图片==========================================	
			    	$this->error('无上传图片');	
                	$error=$upload->getError();
		    		$data=array("status" => -1, "msg" => "图片上传失败",'error'=>$error);
			    }
            
        }
        else {
        	//接收id ，执行修改操作-------------------------------------------
			if($info){
//有上传图片=================================================================
                  $receive['logo']=$info['image']['savepath'].$info['image']['savename'];
				     if(M('user_info_dsh')->where(array('id'=>$_GET['id']))->save($receive)){
				    	$this->success('修改成功',U('Merch/apply_ing'));
				    }else{
				    	$this->error('修改失败');	
				    }
			    }else{
//无上传图片==================================================================
			  if(M('user_info_dsh')->where(array('id'=>$_GET['id']))->save($receive)){
			    	$this->success('修改成功',U('Merch/apply_ing'));
			    }else{
			    	$this->error('修改失败');	
			    }
			}
       }
    	
    	
    	
    	
    }
}