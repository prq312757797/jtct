<?php
namespace AdminPP\Controller;
use Think\Controller;
class VipController extends CommonController {
	

    public function index(){

	
		if($_COOKIE["muban_type"]==2){
	    	$this->redirect('IndexOnepage/index');//进入单页版
	    }else if($_COOKIE["muban_type"]==5){
	    	$this->redirect('IndexZiXun/index');//进入资讯版
	    }else if($_COOKIE["muban_type"]==6){
	    	$this->redirect('IndexFuWu/index');//进入生活服务版
	    }

		$id=$_COOKIE["program_id"];
		if($_COOKIE["program_id"]=="JT201805140917546604"){
			//美牙小程序只有设置页面
			$this->redirect('Set/my_indexedit');
		}
		
		//小程序基本信息
		$this->storeinfo=M('store')
		->field('program_title,program_logo,abstract')
		->where(array('program_id'=>$id))
		->find();
		
		//完成的订单数
		$a1=$this->order_form_1=M('order_form')->where("state=7 and program_id='".$_COOKIE["program_id"]."'")->count();

		//代发货
		$a2=$this->order_form_2=M('order_form')->where("state=2 and program_id='".$_COOKIE["program_id"]."'")->count();
		
		//退换/售后
		$a3=$this->order_form_5=M('order_form')->where("state=5 and program_id='".$_COOKIE["program_id"]."'")->count();
		//	dump($a1;dump($a2);dump($a3);die;
    	$this->display();
	}
	
	
	//广告==========================================================
	public function ad(){
		$str1=isset($_POST['str1'])?$_POST['str1']:'';    //is_show  显示1 不显示2
		$str2=isset($_POST['str2'])?$_POST['str2']:'';    //title  标题 
		$where['_string']='(title like "%'.$str2.'%")  AND (is_show like "%'.$str1.'%")';
		$where['program_id']=$_COOKIE["program_id"];
		$Mysql=M('ad');
		$field='id,sort,title,url,is_show';
		$aa=$this->ad=$Mysql->field($field)->where($where)->order("sort")->select();
	
		$this->display();
	}
	public function ad_add(){
		//调用 自定义链接
		if($_COOKIE["muban_type"]==1){
//商城版=============================
		$this->url_search=	M("url_search")->where("id=1")->find();
		
		}else if($_COOKIE["muban_type"]==5){
//资讯版=============================		
		$this->url_search=	M("url_search")->where("id=1")->find();	
		
		}else if($_COOKIE["muban_type"]==6){
//服务版=============================			
		$this->url_search=	M("url_search")->where("id=2")->find();

		}
		
		$fl=M("attribute")
		->field('id,uid,title,image_1,is_show')
		->where("dsh_id=0 and attribute_style=1 and is_show=1 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$all_fenlei=$this->fenlei=$this->bq($fl);
		
				//文章
		$f2=$this->artical=M("artical")
		->field('id,title,is_show')
		->where(" is_show=1 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$this->display();
	}
	public function ad_edit(){
		//调用 自定义链接
		if($_COOKIE["muban_type"]==1){
//商城版=============================
		$this->url_search=	M("url_search")->where("id=1")->find();
		
		}else if($_COOKIE["muban_type"]==5){
//资讯版=============================		
		$this->url_search=	M("url_search")->where("id=1")->find();	
		
		}else if($_COOKIE["muban_type"]==6){
//服务版=============================			
		$this->url_search=	M("url_search")->where("id=2")->find();

		}
		
		 $a= $this->info=M('ad')->where("id=".$_GET['id'])->find();
	$fl=M("attribute")
		->field('id,uid,title,image_1,is_show')
		->where("dsh_id=0 and is_show=1 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$all_fenlei=$this->fenlei=$this->bq($fl);
		
				//文章
		$f2=$this->artical=M("artical")
		->field('id,title,is_show')
		->where(" is_show=1 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$this->display('ad_add');
	}
	public function run_ad_add(){
		$receive=I();
		$receive["program_id"]=$_COOKIE["program_id"];
			$upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =     3145728 ;// 设置附件上传大小
			    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录

			    // 上传文件 
			    $info   =   $upload->upload();
			    
		 if(empty($_GET['id'])) {
			 if($info){
                    $receive['image']=$info['image02']['savepath'].$info['image02']['savename'];

			     if(M('ad')->add($receive)){
			    	$this->success('添加成功',U('ad'));
			    }else{
			    	$this->error('添加失败');	
			    }
			    
			    }else{
			    	$this->error('无上传图片');	
                	$error=$upload->getError();
		    		$data=array("status" => -1, "msg" => "图片上传失败",'error'=>$error);
			    }
            
        }
        else {
			if($info){
                  $receive['image']=$info['image02']['savepath'].$info['image02']['savename'];

			     if(M('ad')->where(array('id'=>$_GET['id']))->save($receive)){
			    	$this->success('修改成功',U('ad'));
			    }else{
			    	$this->error('修改失败');	
			    }
			    
			    }else{
			  if(M('ad')->where(array('id'=>$_GET['id']))->save($receive)){
			    	$this->success('修改成功',U('ad'));
			    }else{
			    	$this->error('修改失败');	
			    }
			}
       }   
	}
		public function ad_delete(){
		$user_id= $_GET['id'];
			$user_id02["id"] = $_GET['id'];
			$a=M('ad')->where($user_id02)->find();
			
			if($a["can_del"]==1){
				 $this->error('该内容不可删除');
			}
	        if(M('ad')->delete($user_id)) {
	        		unlink('./Uploads/'.$a["image"]);
	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
		}
	
	
	//递归
	function bq($arr,$p=0){
		$ar=array();
		foreach($arr as $v){ 
				if($v["uid"]==$p){ 
					$v["child"]=$this->bq($arr,$v["id"]);
						$ar[]=$v;
						}
			} return $ar;
	}
	
	


	
}