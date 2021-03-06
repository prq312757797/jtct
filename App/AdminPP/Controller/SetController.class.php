<?php
namespace AdminPP\Controller;
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
		    
		    	
		    	if(M('store')->where("program_id='".$_COOKIE["program_id"]."'")->save($rec)){
		    		if(!empty($rec['program_logo'])){
		    			unlink('./Uploads/'.$old['program_logo']);
		    		}
		    		if(!empty($rec['wellcome'])){
		    			unlink('./Uploads/'.$old['wellcome']);
		    		}
		    		if(!empty($rec['video_image'])){
		    			unlink('./Uploads/'.$old['video_image']);
		    		}
		    		if(!empty($rec['index_ad_img'])){
		    			unlink('./Uploads/'.$old['index_ad_img']);
		    		}
		    		if(!empty($rec['video'])){
		    			unlink('./Uploads/'.$old['video']);
		    		}
		    		$this->success('操作成功',U('index'));
		    	}else{
		    		$this->error('操作失败1');
		    	}
		    	
		    }else{
		    //	没有图片	
		    	
		    if(M('store')->where("program_id='".$_COOKIE["program_id"]."'")->save($rec)){
			    	if($_COOKIE["program_id"]=="JT201805140917546604"){
			    		$this->success('修改成功',U('my_indexedit'));
			    	}else{
			    		$this->success('修改成功',U('index'));
			    	}
		    		
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
	
	
	//平台联系
	function man_contect(){
		$a=M("man_contect")->where("program_id='".$_COOKIE["program_id"]."'")->order("time_set desc")->select();
	
		if($_COOKIE["program_id"]=="JT201808090855119076"){
			for($i=0;$i<count($a);$i++){
				$b[$i]=M("goods")->where("id='".$a[$i]["booking_room_id"]."'")->find();
			
				$a[$i]["booking_room_title"]=$b[$i]["goods_title"];
			}
		}
	
		$this->list=$a;
		$this->display();
	}
		public function man_contect_del(){
			 $user_id = $_GET['id'];
			
        if(M('man_contect')->delete($user_id)) {
        	
        
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
	}
	//平台联系详情
	function man_contect_con(){
		$this->info=M("man_contect")->where("id='".$_GET["id"]."'")->find();
		
		$this->display();
	}
	
	
	function index_ad(){
		$this->info=M("store")->where("program_id='".$_COOKIE["program_id"]."'")->find();
		$this->display();
	}
	function my_indexedit(){
		$this->info=M("store")->where("program_id='".$_COOKIE["program_id"]."'")->find();
		$this->display();
	}
	function my_showlist(){
		$this->info=M("store")->where("program_id='".$_COOKIE["program_id"]."'")->find();
		$this->display();
	}
	function my_contect(){
		$this->info=M("store")->where("program_id='".$_COOKIE["program_id"]."'")->find();
		$this->display();
	}
	function my_aboutus(){
		$this->info=M("store")->where("program_id='".$_COOKIE["program_id"]."'")->find();
		$this->display();
	}
	
}