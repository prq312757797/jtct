<?php
namespace AdminPP\Controller;
use Think\Controller;
class PlanController extends CommonController {
		
    public function i2ndex(){

	

    	$this->display();
	}
	
	public function order(){

		$where['program_id']=$_COOKIE["program_id"];
		$where['state']=1;

		$aa=M('artical_order')->where($where)->order("time_pay desc")->select();
		
		for($i=0;$i<count($aa);$i++){
			
			$b[$i]=M("members")->where("program_id='".$_COOKIE["program_id"]."'"."and openid='".$aa[$i]["openid"]."'")->find();
			$aa[$i]["nickname"]=$b[$i]["nickname"];
			$aa[$i]["head"]=$b[$i]["head"];
		
			$c[$i]=M("artical")->where("id='".$aa[$i]["artical_id"]."'")->find();
			$aa[$i]["title"]=$c[$i]["title"];
		}
		$this->list=$aa;

		$this->display();
	}
//文章管理============================
	
	public function index(){

		$where['program_id']=$_COOKIE["program_id"];
		$where['state']=3;

		$aa=$this->ad=M('artical')->where($where)->order("sort")->select();

		$this->display();
	}

	
	public function artical_add(){

		$this->fenlei=M("attribute")->where("attribute_style=3 and program_id='".$_COOKIE["program_id"]."'")->order("sort")->select();

		$this->display();
	}
	public function artical_edit(){

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
			$receive["state"]=3;
			$receive["time_set"]=time();
		     if(M('artical')->add($receive)){
		     	$this->success('添加成功',U('Plan/index'));
		    	
		    }else{
		    	$this->error('添加失败');	
		    } 
        }else{
        
		     if(M('artical')->where(array('id'=>$_GET['id']))->save($receive)){
		    	$this->success('修改成功',U('Plan/index'));
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
	
	
}