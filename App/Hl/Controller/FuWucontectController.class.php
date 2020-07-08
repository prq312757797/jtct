<?php
namespace Hl\Controller;
use Think\Controller;
class FuWucontectController extends CommonController {
	
	//生活服务版的我的联系，就展示作用，删除，添加都没有
    public function index(){
	

	 $goods = D("man_contect");
            $total = $goods->count();
            $per = 10;
            $page = new \Component\Page($total, $per); //autoload
            $sql = "select * from man_contect where program_id='".$_COOKIE["program_id"]."'"." order by time_set desc ".$page->limit;
            $info = $goods -> query($sql);
            $pagelist = $page -> fpage();
            
       	$this -> assign('info', $info);
     	$this -> assign('pages', $pagelist);
    	$this->display();
	}
	
	//联系页面的广告图片设置
	function img_contect(){
	$this->data=	M("store")->field('zx_info_list_img')->where("program_id='".$_COOKIE["program_id"]."'")->find();
	$this->display();
	}
	
	//添加图片
	function index_save(){
				$upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =  3145728 ;// 设置附件上传大小
			    $upload->exts      =  array('jpg', 'gif', 'png', 'jpeg','mp4');// 设置附件上传类型
			    $upload->rootPath  =   './Uploads/'; // 设置附件上传根目录
			    // 上传文件 
			    $info   =   $upload->upload();
	
			    if($info){
			    	
			    		$img["zx_info_list_img"]=$info['zx_info_list_img']['savepath'].$info['zx_info_list_img']['savename'];
			    	
			    		if(M("store")->where("program_id='".$_COOKIE["program_id"]."'")->save($img)){
								$this->success('设置成功',U('img_contect'));
					        } else {
					            $this->error('设置失败');
					        }
			    	}else{
			    			 $this->error('未上传图片');
			    	}	
	}
	
	//删除对应的我的联系
	function delete(){
		if(M("man_contect")->where("id='".$_GET["id"]."'")->delete()){
		  $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
	}
	
	
}