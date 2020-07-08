<?php
namespace AdminP\Controller;
use Think\Controller;
class CarManagerController extends CommonController {
	//车种管理==============================================================================================
public function index(){
	//对这字种类进行管理
	
	//$a=M("car_allcar")->where("program_id='".$_COOKIE["program_id"]."'")->order("sort")->select();

        $total = D("car_allcar")->where("program_id='".$_COOKIE["program_id"]."'")->count();
        $per = 10;
        $page = new \Component\Page($total, $per); 
	 	$sql = "select * from car_allcar  where program_id='".$_COOKIE["program_id"]."'";

		$sql .=" order by sort asc ";
        $sql .=$page->limit;
        $a = D("car_allcar") -> query($sql);
        $pagelist = $page -> fpage();
		
	for($i=0;$i<count($a);$i++){
		$arr[$i]=explode(",",$a[$i]["image"]);
		$a[$i]["image"]=$arr[$i][0];
	}	
		
	$this->info	=$a;
	$this->pages= $pagelist;
	$this->display();
}
//添加车种
	function car_add(){
			//分类列表
   		$this->fenlei=M("car_fenlei")->where("is_show=1 and program_id='".$_COOKIE["program_id"]."'")->select();
		
		//计价列表
		$this->price=M("car_charges")->where(" program_id='".$_COOKIE["program_id"]."'")->select();
	
		$this->display();	
	}
	//修改车种
   function car_edit(){
   	
   		$a=M("car_allcar")->where("id='".$_GET["id"]."'")->find();
   		
   		//商品图片 fenlei_1_title
   		
		$a["image"]=explode(",",$a["image"]);
   	
   	//商品参数  
  	$canshu=array();

  	for($i=0;$i<count(explode(",",$a["canshu_name"]));$i++){
  	
  		$canshu[$i]["canshu_n"]=explode(",",$a["canshu_name"])[$i];
  		$canshu[$i]["canshu_v"]=explode(",",$a["canshu_val"])[$i];
  	}
   		$this->info_canshu=$canshu;
   		
   	//车辆分类 
   		$b=M("car_fenlei")->where("id='".$a["fenlei_id"]."'")->find();
   		$a["fenlei_1_title"]=$b["title"];
   		
   	//车辆计价选择
		$b=M("car_charges")->where("id='".$a["price_id"]."'")->find();
   		$a["price_title"]=$b["title"];
   		$a["price_start"]=$b["price_start"];
   		$a["basis_miles"]=$b["basis_miles"];
   		$a["per_price"]=$b["per_price"];
   		$a["ct_per_price"]=$b["ct_per_price"];

   		//分类列表
   		$this->fenlei=M("car_fenlei")->where("is_show=1 and program_id='".$_COOKIE["program_id"]."'")->select();
		
		//计价列表
		$this->price=M("car_charges")->where(" program_id='".$_COOKIE["program_id"]."'")->select();
		
		$this->info=$a;
		$this->display('car_add');
   }
   //执行添加、修改
   function car_runadd(){
   				$upload = new \Think\Upload();// 实例化上传类
			  	$upload->maxSize   =  3145728 ;// 设置附件上传大小
			    $upload->exts      =  array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =   './Uploads/'; // 设置附件上传根目录
			    // 上传文件 
			    $info   =   $upload->upload();
	
			    if($info){
			    		//有上传图片的地方进来
			    	foreach($info as $k=>$v){
			    		if($info[$k]['key']=="image"){
			    			$date['image'].=$info[$k]['savepath'].$info[$k]['savename'].",";
			    		}else if($info[$k]['key']=="img"){
			    			$date['img'].=$info[$k]['savepath'].$info[$k]['savename'].",";
			    		}
						
					}
						$_POST['image'] = substr($date['image'],0,strlen($date['image'])-1); //去掉最后一个逗号

						$_POST['str_img'] = substr($date['img'],0,strlen($date['img'])-1); //去掉最后一个逗号
				}else{
					if(empty($_GET["id"])){
						$this->error('无上传图片');	
	                	$error=$upload->getError();
			    		$data=array("status" => -1, "msg" => "图片上传失败",'error'=>$error);
					}
				}
				
			$_POST["canshu_name"]=implode(",",$_POST["canshu_name"]);//车辆参数名
			$_POST["canshu_val"]=implode(",",$_POST["canshu_val"]);//车辆参数值

 			$_POST["program_id"]=$_COOKIE["program_id"];
			if(empty($_GET["id"])){
				//执行添加
				if(M("car_allcar")->add($_POST)){
						$this->success('添加成功',U('index'));
				    }else{
				    	$this->error('添加失败');	
				    }
				
			}else{
				//执行修改 
				$kk=M("car_allcar")->where("id='".$_GET["id"]."'")->find();
			
					if(!empty($kk["image"])){
						if(!empty($_POST['image'])){
							$_POST['image']=$kk["image"].",".$_POST['image'];
						}	
					}
				 		
					if(M("car_allcar")->where("id='".$_GET["id"]."'")->save($_POST)){
			 			$this->success('修改成功.',U('index'));
				    }else{
				    	$this->error('修改失败.');	
				    }
				
			}
	}	
	
   //删除车种
   function car_delete(){
   		 $user_id = $_GET['id'];
	        if(M('car_allcar')->delete($user_id)) {
	        	$a=M('car_allcar')->where("id='".$_GET["id"]."'")->find();
	        		$arr=explode(",",$a["image"]);
					for($i=0;$i<count($arr);$i++){
						unlink('./Uploads/'.$arr[$i]);
					}
	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
   }
	//车辆异步上下架
	function ajax_change_ok(){
	$state=M("car_allcar")->where("id='".$_POST["id"]."'")->find();
		//  goods_state  商品状态（1：在售、2：售罄、3：仓库中、4：回收站）
			if($state["is_show"]==1){
				$val["is_show"]="2";
			}else if($state["is_show"]==2){
				$val["is_show"]="1";
			}
			
			if(M("car_allcar")->where("id='".$_POST["id"]."'")->save($val)){
					$date="1";
			}else{
					$date="2";
			}
			$this->ajaxReturn($date);
	}
		//车辆异步s设置推荐
	function ajax_change_tj(){
	$state=M("car_allcar")->where("id='".$_POST["id"]."'")->find();
		// is_recommended 是否设置推荐（1：是、2：否（默认）
			if($state["is_recommended"]==1){
				$val["is_recommended"]="2";
			}else if($state["is_recommended"]==2){
				$val["is_recommended"]="1";
			}
			
			if(M("car_allcar")->where("id='".$_POST["id"]."'")->save($val)){
					$date="1";
			}else{
					$date="2";
			}
			$this->ajaxReturn($date);
	}
	
	//车种分类==============================================================================================
	public function fenlei(){

		$fl=M("car_fenlei")
		
		->where("program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$all_fenlei=$this->fenlei=$fl;

		$this->display();
	}
	
	public function fenlei_add(){
		
		$this->display();
	}

	public function fenlei_edit(){
		$a= $this->info=M('car_fenlei')->where("id=".$_GET['id'])->find();
		$this->display('fenlei_add');
	}
	
	public function run_fenlei_add(){
		  if(empty($_GET["id"])){
		  	//执行添加
		  	$_POST["program_id"]=$_COOKIE["program_id"];
		  	if(M("car_fenlei")->add($_POST)){
					$this->success('添加成功',U('fenlei'));
				}else{
				    $this->error('添加失败');	
				}
		  }else{
		  	//执行修改
		  	if(M("car_fenlei")->where("id='".$_GET["id"]."'")->save($_POST)){
					$this->success('修改成功',U('fenlei'));
				}else{
				    $this->error('修改失败');	
				}
		  	
		  }
	}
	
	
	//分类删除
		public function fenlei_delete(){
			$user_id =$_GET['id'];
	        if(M('car_fenlei')->delete($user_id)) {
	        	//删除主类图片
	        
	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
		}
		
	//收费标准==============================================================================================
	public function charges(){

		$fl=M("car_charges")
		
		->where("program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$all_fenlei=$this->info=$fl;

		$this->display();
	}
		//添加收费标准
	public function charges_add(){
		
		$this->display();
	}


	
	public function charges_edit(){
		$a= $this->info=M('car_charges')->where("id=".$_GET['id'])->find();
		$this->display('charges_add');
	}
	
	public function run_charges_add(){

		  if(empty($_GET["id"])){
		  	//执行添加
		  	$_POST["program_id"]=$_COOKIE["program_id"];
		;
		  	if(M("car_charges")->add($_POST)){
					$this->success('添加成功',U('charges'));
				}else{
				    $this->error('添加失败');	
				}
		  }else{
		  	//执行修改
		  	if(M("car_charges")->where("id='".$_GET["id"]."'")->save($_POST)){
					$this->success('修改成功',U('charges'));
				}else{
				    $this->error('修改失败');	
				}
		  	
		  }
	}
	
	
	//收费标准删除
		public function charges_delete(){
			$user_id =$_GET['id'];
	        if(M('car_charges')->delete($user_id)) {
	        	//删除主类图片
	        
	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
		}	
		
		//车场管理==============================================================================================
	public function car_parking(){

		$fl=M("car_parking")
		
		->where("program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$all_fenlei=$this->list=$fl;

		$this->display();
	}
	
	public function car_parking_add(){
		
		$this->display();
	}

	public function car_parking_edit(){
		$a= $this->info=M('car_parking')->where("id=".$_GET['id'])->find();
		$this->display('car_parking_add');
	}
	
	public function run_car_parking_add(){
		  if(empty($_GET["id"])){
		  	//执行添加
		  	$_POST["program_id"]=$_COOKIE["program_id"];
		  	if(M("car_parking")->add($_POST)){
					$this->success('添加成功',U('car_parking'));
				}else{
				    $this->error('添加失败');	
				}
		  }else{
		  	//执行修改
		  	if(M("car_parking")->where("id='".$_GET["id"]."'")->save($_POST)){
					$this->success('修改成功',U('car_parking'));
				}else{
				    $this->error('修改失败');	
				}
		  	
		  }
	}
	
	
	//车场删除
		public function car_parking_delete(){
			$user_id =$_GET['id'];
	        if(M('car_parking')->delete($user_id)) {
	        	//删除主类图片
	        
	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
		}
			//异步修改列表页 内容
	function ajax_change_text(){
		//style   1:车种管理表、2:车种分类管理表、3：计价管理表、
		if($_POST["style"]==1){
				$save[$_POST["text_name"]]=$_POST["text_val"];
				if(M("car_allcar")->where("id='".$_POST["id"]."'")->save($save)){
						$date="1";
					}else{
						$date="2";
					}
			
		}else if($_POST["style"]==2){
			
		}else if($_POST["style"]==3){
			$save[$_POST["text_name"]]=$_POST["text_val"];
				if(M("car_charges")->where("id='".$_POST["id"]."'")->save($save)){
						$date="1";
					}else{
						$date="2";
					}
		}

		$this->ajaxReturn($date);
		
	}
		 //异步删除图片
	public function ajax_delete_img(){
		//得到那条  好消息 的id、和对应的图片的位置键值，对数据的字符串进行删减
		
		$info=M('car_allcar')->where("id='".$_POST["id"]."'")->find();
		$arr=explode(",",$info["image"]);//字符串转换成数组
		for($i=0;$i<count($arr);$i++){
			if($i != $_POST["key"]){
				$arr_new[]=$arr[$i];
			}
		}
		$str_new["image"]=implode(",",$arr_new);//数组转换成 字符串   这个就是新的需要存的数据
		if($str_new==","){
			$str_new=null;
		}
		if(M("car_allcar")->where("id='".$_POST["id"]."'")->save($str_new)){
			
			unlink('./Uploads/'.$arr[$_POST["key"]]);
			
			$date="1";//保存并删除旧图片成功
		}else{
			$date="2";//操作失败
		}
		$this->ajaxReturn($date);
	}
	
	
}