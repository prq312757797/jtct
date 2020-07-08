<?php
namespace AdminPP\Controller;
use Think\Controller;
class VideoController extends CommonController {
	

	public function index(){
		$where['program_id']=$_COOKIE["program_id"];

		$a=$this->list=M('video')->where($where)->order("sort")->select();
	
	
		$this->display();
	}
	public function video_add(){

		$this->display();
	}
	public function video_edit(){
	
		 $a= $this->info=M('video')->where("id=".$_GET['id'])->find();

		$this->display('video_add');
	}
	public function run_video_add(){
		$receive=I();
		$receive["program_id"]=$_COOKIE["program_id"];
			$upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =     3145728 ;// 设置附件上传大小
			    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg', 'mp4');// 设置附件上传类型
			    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录

			    // 上传文件 
			    $info   =   $upload->upload();
			   if($info){
				   	if($info['image02']){
				   	    $receive['videoimage']=$info['image02']['savepath'].$info['image02']['savename'];
				   	}
                   	if($info['video02']){
				   	    $receive['video']=$info['video02']['savepath'].$info['video02']['savename'];
				   	}

			    }else{
			    	if(empty($_GET["id"])){
			    		$this->error('无上传文件');	
	                	$error=$upload->getError();
			    		$data=array("status" => -1, "msg" => "图片上传失败",'error'=>$error);
			    	}
			    } 
  
			if(empty($_GET['id'])) {
	
				     if(M('video')->add($receive)){
				    	$this->success('添加成功',U('index'));
				    }else{
				    	$this->error('添加失败');	
				    }
	        }else{       
				     if(M('video')->where(array('id'=>$_GET['id']))->save($receive)){
				    	$this->success('修改成功',U('index'));
				    }else{
				    	$this->error('修改失败');	
				    }
				    
			}
       }   
	
		public function video_delete(){
				 $user_id = $_GET['id'];
				$a= M('video')->where("id='".$_GET['id']."'")->find();
	        if(M('video')->delete($user_id)) {
	        	
	        	unlink('./Uploads/'.$a["videoimage"]);
	        	unlink('./Uploads/'.$a["video"]);
	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
		}
		
	
	
}