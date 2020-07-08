<?php
namespace AdminSh\Controller;
use Think\Controller;
class InfoController extends CommonController {
   
		
	//文章管理============================
	
	public function artical(){

		$where['program_id']=$_COOKIE["program_id"];
		$where['dsh_id']=$_COOKIE["admin_dsh_id"];
		$field='id,title,sort,is_show,index_show';
		$aa=$this->ad=M('artical_dsh')->field($field)->where($where)->order("sort")->select();

		$this->display();
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
		$receive['dsh_id']=$_COOKIE["admin_dsh_id"];
		$receive['time_set']=time();
		
		
		 if(M('artical_dsh')->add($receive)){
			    	$this->success('添加成功',U('Info/artical'));
			    }else{
			    	$this->error('添加失败');	
			    } 
        }else {
			     if(M('artical_dsh')->where(array('id'=>$_GET['id']))->save($receive)){
			    	$this->success('修改成功',U('Info/artical'));
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
		
		//首页推送申请
		function artical_index_show(){
			    	$save["index_show"]="2";
    if(M("artical_dsh")->where("id='".$_GET["id"]."'")->save($save)){
    		
    $this->success('申请成功',U('Info/artical'));
		}else{
		$this->error('失败');	
	 }
		}
}