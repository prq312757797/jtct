<?php
namespace AdminSh\Controller;
use Think\Controller;
class SetController extends CommonController {
    //基础设置
    public function index(){
	$fenlei=$this->fenlei=M("attribute")
		->field('id,uid,title')
		->where("uid=0 and attribute_style=2 and dsh_id=0 and program_id='".$_COOKIE["program_id"]."'")->select();
		
		
		$data= M('user_info_dsh')
		->where(array('id'=>$_COOKIE["admin_dsh_id"]))
		->find();

	//分类
		$b=M("attribute")->where("id='".$data["fl_id"]."'")->find();
		$data["fl_title"]=$b["title"];
	
	//支付方式	
		$pay_id["id"]=array("in",$data["payment_method_id"]);
		if(!empty($data["payment_method_id"])){
			$c=M("payment_method_dsh")->where($pay_id)->select();
		}
		
		$c_str='';
		for($c_1=0;$c_1<count($c);$c_1++){
			$c_str .="<div class=\"choose_css\">".$c[$c_1]["title"]."<\/div><input name=\"pay_list_id[]\" value=\"".$c[$c_1]["id"]."\" type=\"hidden\">";
		}
		
		
		$data["payment_method_title"]=$c;
		$data["payment_method_div"]=$c_str;	
		

	//支付方式列表
		$wherepay["program_id"]=$_COOKIE["program_id"];
		if(!empty($data["payment_method_id"])){
		$wherepay["id"]=array("notin",$data["payment_method_id"]);
		}
		$payment_method=M("payment_method_dsh")->where($wherepay)->order("sort")->select();

		$this->payment_method=$payment_method;


		$this->data=$data;

    	$this->display();
	}
	//修改基础设置
	public function index_save(){
		$rec=I('post.');
		
		sort($rec["pay_list_id"]);
    	$rec["payment_method_id"]=implode(",",$rec["pay_list_id"]);
		
	$upload = new \Think\Upload();// 实例化上传类
		    $upload->maxSize   =     3145728 ;// 设置附件上传大小
		    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
		    // 上传文件 
		    $info   =   $upload->upload();
		
		    if($info){
		    	//有图片  wellcome
		    	if(!empty($info['logo'])){
		    		$rec['logo']=$info['logo']['savepath'].$info['logo']['savename'];
		    	}
		    	

		    	$old=M('user_info_dsh')->where("id='".$_COOKIE["admin_dsh_id"]."'")->find();
		    
		    	
		    	if(M('user_info_dsh')->where("id='".$_COOKIE["admin_dsh_id"]."'")->save($rec)){
		    		if(!empty($rec['program_logo'])){
		    			unlink('./Uploads/'.$old['logo']);
		    		}
		    		
		    		//unlink('./Uploads/'.$old['wellcome']);
		    		$this->success('操作成功',U('index'));
		    	}else{
		    		$this->error('操作失败1');
		    	}
		    }else{
		    //	没有图片	
		    if(M('user_info_dsh')->where("id='".$_COOKIE["admin_dsh_id"]."'")->save($rec)){
		    		$this->success('修改成功',U('index'));
		    	}else{
		    		$this->error('修改失败');
		    	}
		    
		  
		    }	
		
	}
	//商城状态
	public function set_store(){

		$this->display();
	}
	//交易设置
	public function set_deal(){
		echo 333;
		$this->display();
	}
	//支付证书
	public function set_pay(){
		echo 444;
		$this->display();
	}
	//公众号模板消息设置
	public function set_noice(){
		echo 555;
		$this->display();
	}
	//打印机管理
	public function mamager_print(){
		echo 666;
		$this->display();
	}
	//打印机模板库
	public function set_print_modal(){
		echo 777;
		$this->display();
	}
	//打印设置
	public function set_print(){
		echo 888;
		$this->display();
	}
	//会员设置
	public function set_members(){
		echo 999;
		$this->display();
	}
	//联系方式
	public function contect(){
		$M=M("store");	
		$data=$M
		->field('linkman,phone_ask,program_id,cs_phone,cs_qq,cs_wx,cs_mail,address_jd,address_wd,address,abstract')
		->where("program_id='".$_COOKIE["program_id"]."'")
		->find();
		
		$this->assign('data',$data);
		$this->display();
	}
	
	//联系方式修改$this->success('修改成功',U('daohang'));
	public function contect_save(){
		$M=M("store");
		$save=I('post.');
		if($M->where("program_id='".$_COOKIE['program_id']."'")->save($save)){
		    $this->success('修改成功',U('contect'));
		}else{
		    $this->error('修改失败');
		}
	}
	    //子商户支付方式
    function ajax_pay(){

    	$a= M('user_info_dsh')->where("id='".$_POST["dsh_id"]."'")->find();
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
    	$a=M("user_info_dsh")->where("id='".$_POST["dsh_id"]."'")->find();
    	
    	$arr=explode(",",$a["payment_method_id"]);
    	for($i=0;$i<count($a);$i++){
    		if($arr[$i] != $_POST["pay_id"]){
    			$arr_new[]=$arr[$i];
    		}
    	}
    	$save["payment_method_id"]=implode(",",$arr_new);
    	if(M("user_info_dsh")->where("id='".$_POST["dsh_id"]."'")->save($save)){
    		$date=array("state"=>1,"msg"=>"删除成功");
    	}else{
    		$date=array("state"=>-1,"msg"=>"删除失败");
    	}
    		$this->ajaxReturn($date);
    }
}