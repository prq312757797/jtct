<?php
namespace Hl\Controller;
use Think\Controller;
class RoomController extends CommonController {
	

    public function index(){

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

    	$this->display();
	}
	

	public function room_list(){
		
		$where['program_id']=$_COOKIE["program_id"];
		$a=M('room_manager')->where($where)->order("sort")->select();
		for($i=0;$i<count($a);$i++){
			$b[$i]=M("attribute")->field("title")->where("id='".$a[$i]["fenlei_1"]."'")->find();
			$c[$i]=M("attribute")->field("title")->where("id='".$a[$i]["fenlei_2"]."'")->find();
			$a[$i]["fenlei_1_title"]=$b[$i]["title"];
			$a[$i]["fenlei_2_title"]=$c[$i]["title"];
		}
		
		$this->huandeng=$a;
	
		$this->display();
	}
	public function room_list_add(){
		

		//一级分类名
		$this->fenlei=M("attribute")
		->field('id,uid,title')
		->where("uid=0 and attribute_style=1 and dsh_id=0 and program_id='".$_COOKIE["program_id"]."'")->select();
	

		$this->display();
	}
	public function room_list_edit(){

		$info=M('room_manager')->where("id=".$_GET['id'])->find();
		//一级分类名
		$fenlei1611=M("attribute")->where("id='".$info["fenlei_1"]."'")->find();
		$info["fenlei_1_title"]=$fenlei1611["title"];
//二级分类名
		$fenlei1612=M("attribute")->where("id='".$info["fenlei_2"]."'")->find();
		$info["fenlei_2_title"]=$fenlei1612["title"];
	
		$a= $this->info=$info;
		
		//一级分类名 dsh_id
		$this->fenlei=M("attribute")
		->field('id,uid,title')
		->where("uid=0 and attribute_style=1 and dsh_id=0 and program_id='".$_COOKIE["program_id"]."'")->select();
	

		$this->display('room_list_add');
	}
	public function run_room_list_add(){
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

			     if(M('room_manager')->add($receive)){
			    	$this->success('添加成功',U('room_list'));
			    }else{
			    	$this->error('添加失败');	
			    }
			    
			    }else{
//			    	$this->error('无上传图片');	
//              	$error=$upload->getError();
//		    		$data=array("status" => -1, "msg" => "图片上传失败",'error'=>$error);
			    }
			    if($_POST["fenlei_1_title"]){
					$fenlei_1=M("attribute")->where("uid=0 and attribute_style=1 and title='".$_POST["fenlei_1_title"]."'"."and program_id='".$_COOKIE["program_id"]."'")->find();
					$receive["fenlei_1"]=$fenlei_1["id"];
				}
				if($_POST["fenlei_1_title"]){
					$fenlei_2=M("attribute")->where("uid !=0 and title='".$_POST["fenlei_2_title"]."'"."and program_id='".$_COOKIE["program_id"]."'")->find();
					$receive["fenlei_2"]=$fenlei_2["id"];
				}
				
			
		    	$receive["room_check_code"]="https://sz800800.cn/pg.php/Qdcode/room_check_code?program_id=JT201709182053243261&room_num=".$receive['room_num'];// 房台使用二维码
		    	$receive["onlinebeer_code"]="https://sz800800.cn/pg.php/Qdcode/onlinebeer_code?program_id=JT201709182053243261&room_num=".$receive['room_num'];//在线酒水二维码
		    	$receive["savebeer_code"]="https://sz800800.cn/pg.php/Qdcode/savebeer_code?program_id=JT201709182053243261&room_num=".$receive['room_num'];//存酒二维码
			    
			    if(empty($_GET['id'])) {
			    	
			    	if(M('room_manager')->add($receive)){
			   
				    	$this->success('添加成功',U('room_list'));
				    }else{
				    	$this->error('添加失败');	
				    }
			    }else{
			    	 if(M('room_manager')->where(array('id'=>$_GET['id']))->save($receive)){
				    	$this->success('修改成功',U('room_list'));
				    }else{
				    	$this->error('修改失败');	
				    }
			    }

	}
		public function room_list_delete(){	
	        if(M('room_manager')->where("id='".$_GET['id']."'")->delete()) {
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
		->where("dsh_id=0 and attribute_style=1 and is_show=1 and program_id='".$_COOKIE["program_id"]."'" )
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
			    	$this->success('添加成功',U('daohang'));
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
			    	$this->success('修改成功',U('daohang'));
			    }else{
			    	$this->error('修改失败');	
			    }
			    
			    }else{
			  if(M('direction')->where(array('id'=>$_GET['id']))->save($receive)){
			    	$this->success('修改成功',U('daohang'));
			    }else{
			    	$this->error('修改失败');	
			    }
			}
       }   
	}
	public function daohang_delete(){
			$user_id = $_GET['id'];
			$a=M('direction')->where("id='".$_GET['id']."'")->find();
	        if(M('direction')->delete($user_id)) {
	        		unlink('./Uploads/'.$a["image"]);
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
	//首页推荐
	public function index_re(){
			$a=M("index_recommend")->where("program_id='".$_COOKIE["program_id"]."'")->find();
		
		$arr=explode(",",$a["recommend_text"]);
			
		$this->index_recommend=$arr;
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
	
	//异步修改 开关
	function ajax_change_show(){
//修改显示与否   幻灯片  from_id=1    、广告  from_id=2、导航图标	 from_id=3	   分类 from_id=4   宜拖车分类 from_id=5
	
	if($_POST["from_id"]==1){
		$state=M("huandeng")->where("id='".$_POST["id"]."'")->find();//幻灯片
	}else if($_POST["from_id"]==2){
		$state=M("ad")->where("id='".$_POST["id"]."'")->find();//广告
	}else if($_POST["from_id"]==3){
		$state=M("direction")->where("id='".$_POST["id"]."'")->find();//导航图标
	}else if($_POST["from_id"]==4){
		$state=M("attribute")->where("id='".$_POST["id"]."'")->find();//分类
	}else if($_POST["from_id"]==5){
		$state=M("car_fenlei")->where("id='".$_POST["id"]."'")->find();//分类
	}
		//  is_show  显示与否(1:显示、2：不显示）
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
		$aa=$this->ad=M('artical')->field($field)->where($where)->order("sort")->select();

		$this->display();
	}
	public function artical_add(){
		
		$this->display();
	}
	public function artical_edit(){
		 $a= $this->info=M('artical')->where("id=".$_GET['id'])->find();
	
		$this->display('artical_add');
	}
	public function run_artical_add(){
		$receive=I();
		$receive["program_id"]=$_COOKIE["program_id"];

		 if(empty($_GET['id'])) {

			     if(M('artical')->add($receive)){
			    	$this->success('添加成功',U('IndexZiXun/artical'));
			    }else{
			    	$this->error('添加失败');	
			    } 
        }else {
			     if(M('artical')->where(array('id'=>$_GET['id']))->save($receive)){
			    	$this->success('修改成功',U('IndexZiXun/artical'));
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