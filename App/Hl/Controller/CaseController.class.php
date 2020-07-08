<?php
namespace Hl\Controller;
use Think\Controller;
class CaseController extends CommonController {
	
	
    public function index(){
		$this->info=M("case_show")->where("program_id='".$_COOKIE["program_id"]."'")->select();
	
    	$this->display();
	}
	function case_add(){
		//案例分类
		$this->fenlei=M("attribute")->where("attribute_style=3 and is_show=1 and program_id='".$_COOKIE["program_id"]."'")->select();   
	
		$this->display();
	}
	function case_edit(){
		//案例内容编辑
		$info=M("case_show")->where("id='".$_GET["id"]."'")->find();
		
		$a=M("attribute")->where("id='".$info["fl_id"]."'")->find();
		$info["fenlei_1_title"]=$a["title"];
		$this->info=$info;
		//案例分类
		$this->fenlei=M("attribute")->where("attribute_style=3 and is_show=1 and program_id='".$_COOKIE["program_id"]."'")->select();   
		$this->display('case_add');
	}
	
	function case_runadd(){
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
        		//执行添加
	        	$this->error('无上传图片');	
	                $error=$upload->getError();
			    	$data=array("status" => -1, "msg" => "图片上传失败",'error'=>$error);
      			}
        		
        }
        
       
        if(empty($_GET["id"])){
        	//执行添加
        	
        	$receive["time_set"]=time();
        	 if(M('case_show')->add($receive)){
				    	$this->success('添加成功',U('index'));
				    }else{
				    	$this->error('添加失败');	
				    }
        	
        }else{
        	//执行修改
        	 if(M('case_show')->where("id='".$_GET["id"]."'")->save($receive)){
				    	$this->success('修改成功',U('index'));
				    }else{
				    	$this->error('修改失败');	
				    }
        }    
            
	}
	function case_delete(){
	$a=M('case_show')->where("id='".$_GET["id"]."'")->find();
			if(M('case_show')->where("id='".$_GET["id"]."'")->delete()){
				
					//删除主类图片
	        	unlink('./Uploads/'.$a["image"]);
	           $this->success('删除成功');
	        } else {
	        	
	          $this->error('删除失败');
	        }
	}
	
	
	
	function fenlei(){
		
		$this->fenlei=M("attribute")->where("attribute_style=3 and program_id='".$_COOKIE["program_id"]."'")->select();
		$this->display();
	}
	function fenlei_add(){
		$this->display();
		
	}
	function fenlei_edit(){
		$this->info=M("attribute")->where("id='".$_GET["id"]."'")->find();
	
		$this->display('fenlei_add');
	}
	
	function run_fenlei_add(){
		$receive=I();
		if(empty($_GET["id"])){
        	//执行添加
        	
        	$_POST["attribute_style"]=3;
        		$_POST["uid"]=0;
        		$_POST["program_id"]=$_COOKIE["program_id"];
        	 if(M('attribute')->add($_POST)){
				    	$this->success('添加成功',U('fenlei'));
				    }else{
				    	$this->error('添加失败');	
				    }
        	
        }else{
        	//执行修改
       
        	 if(M('attribute')->where("id='".$_GET["id"]."'")->save($receive)){
        	 
				    	$this->success('修改成功',U('fenlei'));
				    }else{
				    	$this->error('修改失败');	
				    }
        }  
		
	}
	function fenlei_delete(){
		if(M('attribute')->where("id='".$_GET["id"]."'")->delete()) {
	           $this->success('删除成功');
	        } else {
	           $this->error('删除失败');
	        }
	}
	public function good_news(){
		$user = A('InfoZiXun');//InfoZiXunController.class.php
		$aa=$this->info=$user->get_info($state="2",$style="3",$str="",$str_f="",$is_gongyi="0");
		$this->count=count($aa);
		$this->display();
	}
	public function good_news_add(){
		
		$this->display();
	}
	public function good_news_edit(){
		$a=M('jt03_zx_info')->where("id=".$_GET['id'])->find();
	
		$a["arr"]=explode(",",$a["image"]);//将图片字符串转换成数组
		
		$this->info=$a;
	
		$this->display('good_news_add');
	}
}