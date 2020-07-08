<?php
namespace Hl\Controller;
use Think\Controller;
class IndexZiXunController extends CommonController {
		//小程序基本信息
		//幻灯片
		//导航图标
		//广告
		
		
		//小程序基本信息
    public function index(){

		$id=$_COOKIE["program_id"];

		$this->storeinfo=M('store')
		->field('program_title,program_logo,abstract')
		->where(array('program_id'=>$id))
		->find();
		
		//采购信息
		$a1=$this->order_form_1=M('jt03_zx_info')->where("state=2 and style=1 and is_gongyi=0 and program_id='".$_COOKIE["program_id"]."'")->count();

		//供应信息
		$a2=$this->order_form_2=M('jt03_zx_info')->where("state=2 and style=2 and is_gongyi=0 and program_id='".$_COOKIE["program_id"]."'")->count();
		
		//公益信息
		$where_gy["state"]=2;
		$where_gy["is_gongyi"]=1;
		$where_gy["program_id"]=$_COOKIE["program_id"];
		$where_gy["style"]=array('in','1,2');
		$a3=$this->order_form_5=M('jt03_zx_info')->where($where_gy)->count();
	
		//平台好消息
		$a4=$this->order_form_6=M('jt03_zx_info')->where("state=2 and style=3 and is_gongyi=0 and program_id='".$_COOKIE["program_id"]."'")->count();



    	$this->display();
	}
	
	//幻灯片========================================================
	public function huandeng(){
		$Mysql=M('huandeng');
		$field='id,sort,title,url,is_show';
		$str1=isset($_POST['str1'])?$_POST['str1']:'';    //is_show  显示1 不显示2
		$str2=isset($_POST['str2'])?$_POST['str2']:'';    //title  标题 
		$where['program_id']=$_COOKIE["program_id"];

		$where['_string']='(title like "%'.$str2.'%")  AND (is_show like "%'.$str1.'%")';
		$this->huandeng=$Mysql->field($field)->where($where)->order("sort")->select();
		
	
		$this->display();
	}
	public function huandeng_add(){
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
		->where("dsh_id=0 and is_show=1 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$all_fenlei=$this->fenlei=$this->bq($fl);
	
	
			//文章
		$f2=$this->artical=M("artical")
		->field('id,title,is_show')
		->where(" is_show=1 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		//dump($all_fenlei);die;
		
		$this->display();
	}
	public function huandeng_edit(){
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
				
		 $a= $this->info=M('huandeng')->where("id=".$_GET['id'])->find();
			//dump($a);die;
			
			//分类选择
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
		
		$this->display('huandeng_add');
	}
	public function run_huandeng_add(){
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

			     if(M('huandeng')->add($receive)){
			    	$this->success('添加成功',U('IndexZiXun/huandeng'));
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

			     if(M('huandeng')->where(array('id'=>$_GET['id']))->save($receive)){
			    	$this->success('修改成功',U('IndexZiXun/huandeng'));
			    }else{
			    	$this->error('修改失败');	
			    }
			    
			    }else{
			  if(M('huandeng')->where(array('id'=>$_GET['id']))->save($receive)){
			    	$this->success('修改成功2',U('IndexZiXun/huandeng'));
			    }else{
			    	$this->error('修改失败');	
			    }
			}
       }   
	}
		public function huandneg_delete(){
				 $user_id = $_GET['id'];
	        if(M('huandeng')->delete($user_id)) {
	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
		}
		
	//导航图标=================================================
	public function daohang(){
	
		$Mysql=M('direction');
		$field='id,sort,title,url,image,is_show';
		$str1=isset($_POST['str1'])?$_POST['str1']:'';    //is_show  显示1 不显示2
		$str2=isset($_POST['str2'])?$_POST['str2']:'';    //title  标题 
		$where['program_id']=$_COOKIE["program_id"];
		$where['_string']='(title like "%'.$str2.'%")  AND (is_show like "%'.$str1.'%")';
		$a=$this->daohang=$Mysql->field($field)->where($where)->order("sort")->select();

		$this->display();
	}
	public function daohang_add(){
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
		->where("dsh_id=0 and is_show=1 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$all_fenlei=$this->fenlei=$this->bq($fl);
		
				//文章
		$f2=$this->artical=M("artical")
		->field('id,title,is_show')
		->where(" is_show=1 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$this->display();
	}
	public function daohang_edit(){
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
		
		 $a= $this->info=M('direction')->where("id=".$_GET['id'])->find();
	
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
		$this->display('daohang_add');
	}
	public function run_daohang_add(){
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

			     if(M('direction')->add($receive)){
			    	$this->success('添加成功',U('IndexZiXun/daohang'));
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

			     if(M('direction')->where(array('id'=>$_GET['id']))->save($receive)){
			    	$this->success('修改成功',U('IndexZiXun/daohang'));
			    }else{
			    	$this->error('修改失败');	
			    }
			    
			    }else{
			  if(M('direction')->where(array('id'=>$_GET['id']))->save($receive)){
			    	$this->success('修改成功',U('IndexZiXun/daohang'));
			    }else{
			    	$this->error('修改失败');	
			    }
			}
       }   
	}
		public function daohang_delete(){
			$user_id = $_GET['id'];
	        if(M('direction')->delete($user_id)) {
	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
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
		->where("dsh_id=0 and is_show=1 and program_id='".$_COOKIE["program_id"]."'" )
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
			    	$this->success('添加成功',U('IndexZiXun/ad'));
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
			    	$this->success('修改成功',U('IndexZiXun/ad'));
			    }else{
			    	$this->error('修改失败');	
			    }
			    
			    }else{
			  if(M('ad')->where(array('id'=>$_GET['id']))->save($receive)){
			    	$this->success('修改成功',U('IndexZiXun/ad'));
			    }else{
			    	$this->error('修改失败');	
			    }
			}
       }   
	}
		public function ad_delete(){
		
			$user_id = $_GET['id'];
	
	        if(M('ad')->delete($user_id)) {
	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
		}
	
		
	//首页推荐
	public function index_re(){
	
		$this->display();
	}
	//配送方式
	public function peisong(){
		echo 666;
		$this->display();
	}
	//公告管理
	public function gonggao(){
		echo 777;
		$this->display();
	}
	//评价管理
	public function pingjia(){
		echo 888;
		$this->display();
	}
	//退货地址管理
	public function tuihuo_add(){
		echo 999;
		$this->display();
	}
	
	
	//广告、公告、导航图标=====自定义跳转路径
	
	//自定义商品路径
	public function self_url_goods(){
		//商品姓名搜索商品
			
// 	$where['_string']='(title like "%'.$str2.'%")  AND (is_show like "%'.$str1.'%")';
		$where['_string']=' (goods_title like "%'.$_POST["title"].'%") ';
		$where["program_id"]=$_COOKIE["program_id"];
		$data=M("goods")->field('id,goods_title')->where($where)->select();
		//dump($where);DIE;

		for($i=0;$i<count($data);$i++){
					$a["goods_id"]=$data[$i]["id"];
					$b=M("goods_img")->where($a)->find();
					$data[$i]["image"]=$b["image"];
				}
		//$this->goods=$goods;	
		$this->ajaxReturn($data);	
	}
	
	//打开自定义选择页面
	public function choose_list(){
		//商品分类列表
		$fl=M("attribute")
		->field('id,uid,title,image_1,is_show')
		->where("dsh_id=0 and is_show=1 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$all_fenlei=$this->fenlei=$this->bq($fl);
	
	$this->ajaxReturn($all_fenlei);
		//$this->display();
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
	
	//首页视频
	function video(){
		echo 123;
	}
	
	
	//文章管理============================
	
	public function artical(){

		$where['program_id']=$_COOKIE["program_id"];
		$where['state']=1;
		$field='id,title,sort,is_show,cannot_del';
		$aa=$this->ad=M('artical')->field($field)->where($where)->order("sort")->select();

		$this->display();
	}
	public function artical02(){

		$where['program_id']=$_COOKIE["program_id"];
		$where['state']=2;
		$field='id,title,sort,is_show';
		$aa=$this->ad=M('artical')->field($field)->where($where)->order("sort")->select();

		$this->display();
	}
	
	public function artical_add(){

		$this->fenlei=M("attribute")->where("attribute_style=3 and program_id='".$_COOKIE["program_id"]."'")->order("sort")->select();
		
		if($_GET["state"]) $this->state=$_GET["state"];
		$this->display();
	}
	public function artical_edit(){
		if($_GET["state"]) $this->state=$_GET["state"];
		$a=M('artical')->where("id=".$_GET['id'])->find();
		$fenlei=M("attribute")->field("id,title,sort")->where("attribute_style=3 and program_id='".$_COOKIE["program_id"]."'")->order("sort")->select();
		
		for($i=0;$i<count($fenlei);$i++){
			if($a["fenlei_1"]==$fenlei[$i]["id"]){
				$a["fenlei_1_title"]=$fenlei[$i]["title"];
			}
		}
	
	 	$this->info=$a;
		$this->fenlei=$fenlei;
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
	    	 $receive['image']=$info['image02']['savepath'].$info['image02']['savename'];
	    }
			
		if(empty($_GET['id'])) {
			$receive["time_set"]=time();
		     if(M('artical')->add($receive)){
		     	if($receive["state"]==1){
		     		$this->success('添加成功',U('IndexZiXun/artical'));
		     	}else{
		     		$this->success('添加成功.',U('IndexZiXun/artical02'));
		     	}
		    	
		    }else{
		    	$this->error('添加失败');	
		    } 
        }else{
        
		     if(M('artical')->where(array('id'=>$_GET['id']))->save($receive)){
		    	
		    	
		    	if($receive["state"]==1){
		     		$this->success('修改成功',U('IndexZiXun/artical'));
		     	}else{
		     		$this->success('修改成功.',U('IndexZiXun/artical02'));
		     	}
		    }else{
		    	$this->error('修改失败');	
		    }

		}
    }  
	
	public function artical_delete(){
		$user_id = $_GET['id'];
        if(M('artical')->delete($user_id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
	}
	
//	资讯分类
	function artical_fenlei(){
		$this->list=M("attribute")->where("attribute_style=3 and program_id='".$_COOKIE["program_id"]."'")->order("sort")->select();
		
		$this->display();
	}
	
	function artical_fenlei_add(){

		$this->display();
	}
	function artical_fenlei_edit(){
		$this->info=M("attribute")->where("id='".$_GET["id"]."'")->find();
		$this->display("artical_fenlei_add");
	}
	function artical_fenlei_runadd(){
		$receive=I();
		if(empty($_GET['id'])) {
			$receive["attribute_style"]="3";
			$receive["program_id"]=$_COOKIE["program_id"];
		     if(M('attribute')->add($receive)){
		    	$this->success('添加成功',U('IndexZiXun/artical_fenlei'));
		    }else{
		    	$this->error('添加失败');	
		    } 
        }else{
		     if(M('attribute')->where(array('id'=>$_GET['id']))->save($receive)){
		    	$this->success('修改成功',U('IndexZiXun/artical_fenlei'));
		    }else{
		    	$this->error('修改失败');	
		    }

		}
	
	}
	function artical_fenlei_delete(){

		if(M('attribute')->where("id='".$_GET["id"]."'")->delete()) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }

		$this->display();
	}
	
}