<?php
namespace AdminP\Controller;
use Think\Controller;
class SetController extends CommonController {
    //基础设置
    public function index(){
	   $data= $this->data=M("store")
	//	->field('program_title,wellcome,integral_proportion,video_image,program_id,program_logo,abstract,program_img_over,video')
		->where("program_id='".$_COOKIE["program_id"]."'")
		->find();
		
	
    	$this->display();
	}
	//修改基础设置
	public function index_save(){
		$rec=I('post.');
	
	$upload = new \Think\Upload();// 实例化上传类
		    $upload->maxSize   =     3145728 ;// 设置附件上传大小
		    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
		    // 上传文件 
		    $info   =   $upload->upload();
		
		    if($info){
		    	//有图片  wellcome
		    	if(!empty($info['program_logo'])){
		    		$rec['program_logo']=$info['program_logo']['savepath'].$info['program_logo']['savename'];
		    	}
		    	if(!empty($info['wellcome'])){
		    		$rec['wellcome']=$info['wellcome']['savepath'].$info['wellcome']['savename'];
		    	}
				if(!empty($info['video_image'])){
		    		$rec['video_image']=$info['video_image']['savepath'].$info['video_image']['savename'];
		    	}
		    	$old=M('store')->where("program_id='".$_COOKIE["program_id"]."'")->find();
		    
		    	
		    	if(M('store')->where("program_id='".$_COOKIE["program_id"]."'")->save($rec)){
		    		if(!empty($rec['program_logo'])){
		    			unlink('./Uploads/'.$old['program_logo']);
		    		}
		    		if(!empty($rec['wellcome'])){
		    			unlink('./Uploads/'.$old['wellcome']);
		    		}
		    		//unlink('./Uploads/'.$old['wellcome']);
		    		$this->success('操作成功',U('index'));
		    	}else{
		    		$this->error('操作失败1');
		    	}
		    }else{
		    //	没有图片	
		    	
		    if(M('store')->where("program_id='".$_COOKIE["program_id"]."'")->save($rec)){
		    		$this->success('修改成功',U('index'));
		    	}else{
		    		$this->error('修改失败');
		    	}
		    
		    	//$this->error($upload->getError());
		    }	
		/*if(!empty($_FILES['file']['tmp_name'])){
			
		}else{
			
		}*/
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
	
	
	//平台联系
	function man_contect(){
		$this->list=M("man_contect")->where("program_id='".$_COOKIE["program_id"]."'")->order("time_set desc")->select();
	
		$this->display();
	}
	
	//平台联系详情
	function man_contect_con(){
		$this->info=M("man_contect")->where("id='".$_GET["id"]."'")->find();
		
		$this->display();
	}
	//删除平台联系详情
	function man_contect_del(){
		$user_id = $_GET['id'];
		$a= M('man_contect')->where("id='".$_GET['id']."'")->find();
	    if(M('man_contect')->delete($user_id)) {
	       $this->success('删除成功');
	    }else {
	        $this->error('删除失败');
	    }
	}
	
}