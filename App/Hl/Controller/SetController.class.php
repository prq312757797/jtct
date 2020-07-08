<?php
namespace Hl\Controller;
use Think\Controller;
class SetController extends CommonController {
    //基础设置
    public function index(){
	   $data= $this->data=M("h_store")
		->where("program_id='".$_COOKIE["program_id"]."'")
		->find();
		
	
    	$this->display();
	}
	//修改基础设置
	public function index_save(){
		
		$rec=I('post.');
		$upload = new \Think\Upload();// 实例化上传类
	    $upload->maxSize   =     3145728000 ;// 设置附件上传大小
	    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg','mp4');// 设置附件上传类型
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
	    	if(!empty($info['index_ad_img'])){
	    		$rec['index_ad_img']=$info['index_ad_img']['savepath'].$info['index_ad_img']['savename'];
	    	}
	    	if(!empty($info['app_video'])){
	    		$rec['video']=$info['app_video']['savepath'].$info['app_video']['savename'];
	    	}
	    	$old=M('store')->where("program_id='".$_COOKIE["program_id"]."'")->find();
	    
	    	
	    	if(M('h_store')->where("program_id='".$_COOKIE["program_id"]."'")->save($rec)){
	    		if(!empty($rec['program_logo'])){
	    			unlink('./Uploads/'.$old['program_logo']);
	    		}
	    		
	    		$this->success('操作成功',U('index'));
	    	}else{
	    		$this->error('操作失败1');
	    	}
	    	
	    }else{
	    //	没有图片	
	    	
	    if(M('h_store')->where("program_id='".$_COOKIE["program_id"]."'")->save($rec)){
		    
		    		$this->success('修改成功',U('index'));
	    		
	    	}else{
	    		$this->error('修改失败');
	    	}
	    
	    }	
	
	}
	
	//联系方式
	public function contect(){
		$M=M("h_store");	
		$data=$M
		->field('linkman,phone_ask,program_id,cs_phone,cs_qq,cs_wx,cs_mail,address_jd,address_wd,address,abstract')
		->where("program_id='".$_COOKIE["program_id"]."'")
		->find();
		
		$this->assign('data',$data);
		$this->display();
	}
	
	public function contect_save(){
		$M=M("h_store");
		$save=I('post.');
		if($M->where("program_id='".$_COOKIE['program_id']."'")->save($save)){
		    $this->success('修改成功',U('contect'));
		}else{
		    $this->error('修改失败');
		}
	}
	
	
	//平台联系
	function man_contect(){
		$this->list=M("h_man_contect")->where("program_id='".$_COOKIE["program_id"]."'")->order("time_set desc")->select();	
		$this->display();
	}
	
	//平台联系详情
	function man_contect_con(){
		$this->info=M("h_man_contect")->where("id='".$_GET["id"]."'")->find();		
		$this->display();
	}		
	function index_ad(){
		$this->info=M("h_store")->where("program_id='".$_COOKIE["program_id"]."'")->find();
		$this->display();
	}
	function my_indexedit(){
		$this->info=M("h_store")->where("program_id='".$_COOKIE["program_id"]."'")->find();
		$this->display();
	}
	function my_showlist(){
		$this->info=M("h_store")->where("program_id='".$_COOKIE["program_id"]."'")->find();
		$this->display();
	}
	function my_contect(){
		$this->info=M("h_store")->where("program_id='".$_COOKIE["program_id"]."'")->find();
		$this->display();
	}
	function my_aboutus(){
		$this->info=M("h_store")->where("program_id='".$_COOKIE["program_id"]."'")->find();
		$this->display();
	}
	
}