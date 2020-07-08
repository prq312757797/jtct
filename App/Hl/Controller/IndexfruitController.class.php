<?php
namespace Hl\Controller;
use Think\Controller;
class IndexfruitController extends CommonController {
	

    public function index(){

		$id=$_COOKIE["program_id"];
		
		//完成的订单数
		$a1=$this->order_form_1=M('order_form')->where("state=7 and program_id='".$_COOKIE["program_id"]."'")->count();

		//代发货
		$a2=$this->order_form_2=M('order_form')->where("state=2 and program_id='".$_COOKIE["program_id"]."'")->count();
		
		//退换/售后
		$a3=$this->order_form_5=M('order_form')->where("state=5 and program_id='".$_COOKIE["program_id"]."'")->count();
		//	dump($a1;dump($a2);dump($a3);die;
    	$this->display();
	}
	
	//幻灯片 轮播图   0
	public function huandeng(){
		$Mysql=M('huandeng');
		$field='id,sort,title,url,is_show,image';
		$where['program_id']=$_COOKIE["program_id"];
		$where['state_show']=2;
		$where['_string']='(title like "%'.$str2.'%")  AND (is_show like "%'.$str1.'%")';
		$this->huandeng=M('h_huandeng')->field($field)->where($where)->order("sort")->select();
		$this->display();
	}
	public function huandeng_add(){
		//调用 自定义链接
		$this->url_search=	M("url_search")->where("id=1")->find();
	
		//商品分类列表
		$fl=M("h_attribute")
		->field('id,uid,title,image_1,is_show')
		->where("dsh_id=0 and attribute_style=1  and is_show=1 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$all_fenlei=$this->fenlei=$this->bq($fl);
	
		//文章
		$f2=$this->artical=M("h_artical")
		->field('id,title,is_show')
		->where(" is_show=1 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$this->display();
	}
	public function huandeng_edit(){
		//调用 自定义链接
		$z=$this->url_search=	M("url_search")->where("id=1")->find();
	
		$a= $this->info=M('h_huandeng')->where("id=".$_GET['id'])->find();
		
		$fl=M("h_attribute")
		->field('id,uid,title,image_1,is_show')
		->where("dsh_id=0 and attribute_style=1 and is_show=1 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$all_fenlei=$this->fenlei=$this->bq($fl);
	
	
		//文章
		$f2=$this->artical=M("h_artical")
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
	    if($info){
            $receive['image']=$info['image02']['savepath'].$info['image02']['savename'];
	    }else{
	    	 if(empty($_GET['id'])) {	
	    	 	$this->error('无上传图片');	
            	$error=$upload->getError();
	    		$data=array("status" => -1, "msg" => "图片上传失败",'error'=>$error);
	    	 } 	
	    }
	    
	    if(empty($_GET['id'])) {
	    	$receive['state_show']=2;
	    	if(M('h_huandeng')->add($receive)){
		    	$this->success('添加成功',U('huandeng'));
		    }else{
		    	$this->error('添加失败');	
		    }
	    }else{
	    	if(M('h_huandeng')->where(array('id'=>$_GET['id']))->save($receive)){
		    	$this->success('修改成功',U('huandeng'));
		    }else{
		    	$this->error('修改失败');	
		    }
	    }
		
	}
		public function huandneg_delete(){
				 $user_id = $_GET['id'];
				$a= M('h_huandeng')->where("id='".$_GET['id']."'")->find();
	        if(M('h_huandeng')->delete($user_id)) {
	        	
	        	unlink('./Uploads/'.$a["image"]);
	        	
	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
		}
		
	//导航图标  0
	public function daohang(){
	
		$Mysql=M('h_direction');
		$field='id,sort,title,url,image,is_show';
		$str1=isset($_POST['str1'])?$_POST['str1']:'';    //is_show  显示1 不显示2
		$str2=isset($_POST['str2'])?$_POST['str2']:'';    //title  标题 
		$where['program_id']=$_COOKIE["program_id"];
		$where['state_show']=2;
		$where['_string']='(title like "%'.$str2.'%")  AND (is_show like "%'.$str1.'%")';
		$a=$this->daohang=$Mysql->field($field)->where($where)->order("sort")->select();

		$this->display();
	}
	public function daohang_add(){
		//调用 自定义链接
		$this->url_search=	M("url_search")->where("id=1")->find();
		
		$fl=M("h_attribute")
		->field('id,uid,title,image_1,is_show')
		->where("dsh_id=0 and attribute_style=1 and is_show=1 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$all_fenlei=$this->fenlei=$this->bq($fl);
		
				//文章
		$f2=$this->artical=M("h_artical")
		->field('id,title,is_show')
		->where(" is_show=1 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$this->display();
	}
	public function daohang_edit(){
		//调用 自定义链接
		$this->url_search=	M("url_search")->where("id=1")->find();
		
		 $a= $this->info=M('h_direction')->where("id=".$_GET['id'])->find();
	
	$fl=M("h_attribute")
		->field('id,uid,title,image_1,is_show')
		->where("dsh_id=0 and attribute_style=1 and is_show=1 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$all_fenlei=$this->fenlei=$this->bq($fl);
		
		
				//文章
		$f2=$this->artical=M("h_artical")
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
	    if($info){
            $receive['image']=$info['image02']['savepath'].$info['image02']['savename'];
	    }else{
	    	 if(empty($_GET['id'])) {	
	    	 	$this->error('无上传图片');	
            	$error=$upload->getError();
	    		$data=array("status" => -1, "msg" => "图片上传失败",'error'=>$error);
	    	 } 	
	    }
	    
	    if(empty($_GET['id'])) {
	    	$receive['state_show']=2;
	    	if(M('h_direction')->add($receive)){
		    	$this->success('添加成功',U('daohang'));
		    }else{
		    	$this->error('添加失败');	
		    }
	    }else{
	    	if(M('h_direction')->where(array('id'=>$_GET['id']))->save($receive)){
		    	$this->success('修改成功',U('daohang'));
		    }else{
		    	$this->error('修改失败');	
		    }
	    }
			      
	}
	public function daohang_delete(){
			$user_id = $_GET['id'];
			$a=M('h_direction')->where("id='".$_GET['id']."'")->find();
	        if(M('h_direction')->delete($user_id)) {
	        		unlink('./Uploads/'.$a["image"]);
	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
		}
	//广告    0
	public function ad(){
		$str1=isset($_POST['str1'])?$_POST['str1']:'';    //is_show  显示1 不显示2
		$str2=isset($_POST['str2'])?$_POST['str2']:'';    //title  标题 
		$where['_string']='(title like "%'.$str2.'%")  AND (is_show like "%'.$str1.'%")';
		$where['program_id']=$_COOKIE["program_id"];
		$where['is_special']=0;
		$Mysql=M('h_ad');
		$field='id,sort,title,url,is_show,image,can_self_url';
		$aa=$this->ad=$Mysql->field($field)->where($where)->order("sort")->select();
	
		$this->display();
	}
	public function ad_add(){
		//调用 自定义链接
		$this->url_search=	M("url_search")->where("id=1")->find();
		
		$fl=M("h_attribute")
		->field('id,uid,title,image_1,is_show')
		->where("dsh_id=0 and attribute_style=1 and is_show=1 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$all_fenlei=$this->fenlei=$this->bq($fl);
		
		//文章
		$f2=$this->artical=M("h_artical")
		->field('id,title,is_show')
		->where(" is_show=1 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$this->display();
	}
	public function ad_edit(){
		//调用 自定义链接
		$this->url_search=	M("url_search")->where("id=1")->find();
		
		 $a= $this->info=M('h_ad')->where("id=".$_GET['id'])->find();
	$fl=M("h_attribute")
		->field('id,uid,title,image_1,is_show')
		->where("dsh_id=0 and is_show=1 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$all_fenlei=$this->fenlei=$this->bq($fl);
		
				//文章
		$f2=$this->artical=M("h_artical")
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
	    
	    if($info){
            $receive['image']=$info['image02']['savepath'].$info['image02']['savename'];
	    }else{
	    	 if(empty($_GET['id'])) {	
	    	 	$this->error('无上传图片');	
            	$error=$upload->getError();
	    		$data=array("status" => -1, "msg" => "图片上传失败",'error'=>$error);
	    	 } 	
	    }
	    
	    if(empty($_GET['id'])) {
	    	if(M('h_ad')->add($receive)){
		    	$this->success('添加成功',U('ad'));
		    }else{
		    	$this->error('添加失败');	
		    }
	    }else{
	    	if(M('h_ad')->where(array('id'=>$_GET['id']))->save($receive)){
		    	$this->success('修改成功',U('ad'));
		    }else{
		    	$this->error('修改失败');	
		    }
	    }
		 
	}
		public function ad_delete(){
			$user_id= $_GET['id'];
			$user_id02["id"] = $_GET['id'];
			$a=M('h_ad')->where($user_id02)->find();
			
			if($a["can_del"]==1){
				 $this->error('该内容不可删除');
			}
	        if(M('h_ad')->delete($user_id)) {
	        		unlink('./Uploads/'.$a["image"]);
	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
		}
	//首页推荐
	public function index_re(){
			$a=M("index_recommend")->where("program_id='".$_COOKIE["program_id"]."'")->find();
		
		$arr=explode(",",$a["recommend_text"]);
			
		$this->index_recommend=$arr;
		$this->display();
	}
	
	//自定义商品路径
	public function self_url_goods(){

		$where['_string']=' (goods_title like "%'.$_POST["title"].'%") ';
		$where["program_id"]=$_COOKIE["program_id"];
		$data=M("goods")->field('id,goods_title')->where($where)->select();

		for($i=0;$i<count($data);$i++){
			$a["goods_id"]=$data[$i]["id"];
			$b=M("goods_img")->where($a)->find();
			$data[$i]["image"]=$b["image"];
		}
		$this->ajaxReturn($data);	
	}
	//自定义商户路径
	public function self_url_merch(){
		//商品姓名搜索商品
		$where['_string']=' (sh_name like "%'.$_POST["title"].'%") ';
		$where["program_id"]=$_COOKIE["program_id"];
		$where["state"]=3;
		$data=M("user_info_dsh")->field('id,sh_name,logo')->where($where)->select();
		
		$this->ajaxReturn($data);	
	}
	//打开自定义选择页面
	public function choose_list(){
		//商品分类列表
		$fl=M("attribute")
		->field('id,uid,title,image_1,is_show')
		->where("dsh_id=0 and attribute_style=1 and is_show=1 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$all_fenlei=$this->fenlei=$this->bq($fl);
	
		$this->ajaxReturn($all_fenlei);
		
	}

	//递归
	function bq($arr,$p=0){ $ar=array(); foreach($arr as $v){ if($v["uid"]==$p){ $v["child"]=$this->bq($arr,$v["id"]);$ar[]=$v;}} return $ar;}
	
	//异步修改 开关
	function ajax_change_show(){
//修改显示与否   幻灯片  from_id=1    、广告  from_id=2、导航图标	 from_id=3	   分类 from_id=4   宜拖车分类 from_id=5

	switch ($_POST["from_id"]) {
    case 1:
       $state=M("huandeng")->field("is_show")->where("id='".$_POST["id"]."'")->find();//幻灯片
        break;
    case 2:
        $state=M("ad")->field("is_show")->where("id='".$_POST["id"]."'")->find();//广告
        break;
    case 3:
        $state=M("direction")->field("is_show")->where("id='".$_POST["id"]."'")->find();//导航图标
        break;
    case 4:
        $state=M("attribute")->field("is_show")->where("id='".$_POST["id"]."'")->find();//分类
        break;
    case 5:
        $state=M("car_fenlei")->field("is_show")->where("id='".$_POST["id"]."'")->find();//分类
        break;
}
		
	if($state["is_show"]==1){
		$val["is_show"]="2";
	}else if($state["is_show"]==2){
		$val["is_show"]="1";
	}
			
	if($_POST["from_id"]==1){
		if(M("huandeng")->where("id='".$_POST["id"]."'")->save($val)){
					$date="1";
			}else{
					$date="2";
			}
	}else if($_POST["from_id"]==2){
		if(M("ad")->where("id='".$_POST["id"]."'")->save($val)){
					$date="1";
			}else{
					$date="2";
			}
	}else if($_POST["from_id"]==3){
		if(M("direction")->where("id='".$_POST["id"]."'")->save($val)){
					$date="1";
			}else{
					$date="2";
			}
	}else if($_POST["from_id"]==4){
		if(M("attribute")->where("id='".$_POST["id"]."'")->save($val)){
					$date="1";
			}else{
					$date="2";
			}
	}else if($_POST["from_id"]==5){
		if(M("car_fenlei")->where("id='".$_POST["id"]."'")->save($val)){
					$date="1";
			}else{
					$date="2";
			}
	}
				
			
			
			$this->ajaxReturn($date);
	}
	
	//异步修改列表页 内容
	function ajax_change_text(){
//style   1:商品表内容、
	if($_POST["style"]==1){
		$save[$_POST["text_name"]]=$_POST["text_val"];
		if(M("goods")->where("id='".$_POST["id"]."'")->save($save)){
				$date="1";
			}else{
				$date="2";
			}
		}
	$this->ajaxReturn($date);	
	}
	
	//文章管理============================================================================
	public function artical(){

		$where['program_id']=$_COOKIE["program_id"];
		
		$field='id,title,sort,is_show';
		$aa=$this->ad=M('h_artical')->field($field)->where($where)->order("sort")->select();

		$this->display();
	}
	public function artical_add(){
		
		$this->display();
	}
	public function artical_edit(){
		 $a= $this->info=M('h_artical')->where("id=".$_GET['id'])->find();
	
		$this->display('artical_add');
	}
	public function run_artical_add(){
		$receive=I();
		$receive["program_id"]=$_COOKIE["program_id"];

		 if(empty($_GET['id'])) {

		     if(M('h_artical')->add($receive)){
		    	$this->success('添加成功',U('IndexZiXun/artical'));
		    }else{
		    	$this->error('添加失败');	
		    } 
        }else {
		     if(M('h_artical')->where(array('id'=>$_GET['id']))->save($receive)){
		    	$this->success('修改成功',U('IndexZiXun/artical'));
		    }else{
		    	$this->error('修改失败');	
		    }

			}
    }   
	
	public function artical_delete(){
		$user_id = $_GET['id'];

        if(M('h_artical')->delete($user_id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
	}
	function ajax_re(){
		$save["recommend_text"]=$_POST["con"];
		if(M("index_recommend")->where("program_id='".$_COOKIE["program_id"]."'")->save($save)){
			$date=array("state"=>1,"msg"=>"修改成功");
		}else{
			$date=array("state"=>-1,"msg"=>"修改失败");
		}
		$this->ajaxReturn($date);
	}
	
}