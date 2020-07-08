<?php
namespace AdminPP\Controller;
use Think\Controller;
class IndexOnepageController extends CommonController {
    public function index(){
		$id=$_COOKIE["program_id"];
		
		//小程序基本信息
		$field='store.program_title,store.onepage_img_base,store.onepage_img_qdcode,store.onepage_tel,
		
		qianyue.muban_b,qianyue.appid
		';
		
		$storeinfo=$this->storeinfo=M("store")
		->field($field)
		->join('left join qianyue ON qianyue.program_id=store.program_id')
		->where("store.program_id='".$_COOKIE["program_id"]."'")
		->find();

	
    	$this->display();
	}
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
	    	if(!empty($info['onepage_img_base'])){
	    		$rec['onepage_img_base']=$info['onepage_img_base']['savepath'].$info['onepage_img_base']['savename'];
	    	}
	    	if(!empty($info['onepage_img_qdcode'])){
	    		$rec['onepage_img_qdcode']=$info['onepage_img_qdcode']['savepath'].$info['onepage_img_qdcode']['savename'];
	    	}
	
			
	    	$old=M('store')->where("program_id='".$_COOKIE["program_id"]."'")->find();
	    
	    	
	    	if(M('store')->where("program_id='".$_COOKIE["program_id"]."'")->save($rec)){
	    		if(!empty($rec['onepage_img_base'])){
	    			unlink('./Uploads/'.$old['onepage_img_base']);
	    		}
	    		if(!empty($rec['onepage_img_qdcode'])){
	    			unlink('./Uploads/'.$old['onepage_img_qdcode']);
	    		}

	    		$this->success('修改成功',U('index'));
	    	}else{
	    		$this->error('修改失败');
	    	}
	    }else{
	    //	没有图片		
	    if(M('store')->where("program_id='".$_COOKIE["program_id"]."'")->save($rec)){
		    	$this->success('修改成功.',U('index'));
	    	}else{
	    		$this->error('修改失败.');
	    	}
	    }	
	
	}
	
}