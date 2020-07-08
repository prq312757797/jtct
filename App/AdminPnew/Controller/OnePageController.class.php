<?php
namespace AdminPnew\Controller;
use Think\Controller;
class OnePageController extends CommonController {
    public function index(){
 $data= $this->info=M("store")
		->field('program_title,image_one_page,program_id,program_logo')
		->where("program_id='".$_COOKIE["program_id"]."'")
		->find();
		
    	$this->display();
	}
	
	public function one_page(){
	$rec=I('post.');
	$upload = new \Think\Upload();// 实例化上传类
		    $upload->maxSize   =     3145728 ;// 设置附件上传大小
		    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
		    // 上传文件 
		    $info   =   $upload->upload();
		
		    if($info){
		    	//有图片  wellcome
		    	if(!empty($info['image'])){
		    		$rec['image_one_page']=$info['image']['savepath'].$info['image']['savename'];
		    	}

		    	$old=M('store')->where("program_id='".$_COOKIE["program_id"]."'")->find();
		    
		    	
		    	if(M('store')->where("program_id='".$_COOKIE["program_id"]."'")->save($rec)){
		    		if(!empty($rec['image_one_page'])){
		    			unlink('./Uploads/'.$old['image_one_page']);
		    		}

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
		    
		    	
		    }	
	
	}
}