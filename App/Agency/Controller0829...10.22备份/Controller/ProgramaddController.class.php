<?php
namespace Agency\Controller;
use Think\Controller;
header('content-type:application:json;charset=utf8'); 
header('Access-Control-Allow-Origin:*');  
header('Access-Control-Allow-Headers:x-requested-with,content-type');
class ProgramaddController extends Controller {
	
	//小程序添加审核  页面显示
	public function program_show(){
		//显示小程序模板分类
		$muban_l=M("muban_l")->field('id,name')->select();
		
		//商户信息表
		$shagnhu=M("user_info")->field('id,name,psw')->where("agency_id='".$_GET["id"]."'")->select();
		
		
		$this->ajaxReturn($muban_l);

	}
	//根据模板种类  ajax得到对应模板版本
	public function program_b(){
		$a["muban_type"]=$_POST["id"];
		$muban=M("muban")
		->field('id,program_id,muban_name,muban_type,price,action')
		->where($a)
		->select();
		
		$this->ajaxReturn($muban);
	}
	
	
	//小程序添加审核  页面添加
	public function program_add(){
		$upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =  3145728 ;// 设置附件上传大小
			    $upload->exts      =  array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =   './Uploads/'; // 设置附件上传根目录
			    // 上传文件 
			    $info   =   $upload->upload();
			  
			    if($info){
			    	//有图片上传
			    	
                    $_POST['contract_img']=$info['contract_img01']['savepath'].$info['contract_img01']['savename'];

					if(M("qianyue")->save($_POST)){				
						$data=array('status'=>1,'msg'=>'添加成功');

					}else{
						$data=array('status'=>2,'msg'=>'添加失败');
					}
					
			    }else{
			    	//没有图片上传	
                    $error=$upload->getError();
		    		$data=array("status" => -1, "msg" => "未上传图片",'error'=>$error);
			    
			    }
		
		
		
		
		
		
		
		
		$this->ajaxReturn($dat);
		
	}
}
?>