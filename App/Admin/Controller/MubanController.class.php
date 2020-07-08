<?php
namespace Admin\Controller;
use Think\Controller;
class MubanController extends CommonController {

    //管理小程序模板---实际上就是管理小程序的功能
        public function index(){

		$preview=M("preview")->select();
		
		for($i=0;$i<count($preview);$i++){ 
			$arr[$i]=explode(",",$preview[$i]["function_id"]);
			for($k=0;$k<count($arr[$i]);$k++){
				$b=M("function_list")->where("id='".$arr[$i][$k]."'")->find();
				
				$arr_1[$k]=	$b["name"];
			}
			
			$preview[$i]["name_function"]=implode(",",$arr_1);
		}
		$this->preview=$preview;
		
		$this->display();
	}
	
	//添加小程序模板预览
	function preview_add(){
		
		$this->is_add=1;
		$this->display();
	}
	//修改小程序模板预览
	function preview_edit(){
	$preview=	M("preview")->where("id='".$_GET["id"]."'")->find();
	
	
		//遍历出功能
		$preview["arr"]=$arr=explode(",",$preview["function_id"]);
			for($k=0;$k<count($arr);$k++){
				$b=M("function_list")->where("id='".$arr[$k]."'")->find();
				
				$arr_1[$k]=	$b["name"];
			}
			
			$preview["name_function"]=implode(",",$arr_1);
		
		$this->info=$preview;
		
		//查询所有功能    function_state  1：版本功能模块、2：一般功能模块、3：数据渲染模块
	$function_list=M("function_list")->select();

	for($i=0;$i<count($function_list);$i++){
		if($function_list[$i]["function_state"]==1){
			$arr01[]=$function_list[$i];
		}else if($function_list[$i]["function_state"]==2){
			$arr02[]=$function_list[$i];
		}else if($function_list[$i]["function_state"]==3){
			$arr03[]=$function_list[$i];
		}
	}
	
	$this->arr01=$arr01;
	$this->arr02=$arr02;
	$this->arr03=$arr03;
	
		$this->is_add=2;
		$this->display('preview_add');
	}
	function run_preview_add(){
		$date=$_POST;
		
			$upload = new \Think\Upload();// 实例化上传类
			$upload->maxSize   =     3145728 ;// 设置附件上传大小
			$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			$upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
			//   上传文件 
			//   $info   =   $upload->upload(array($_FILES['image']));
			$info   =   $upload->upload();
		if($info){
			foreach($info as $k=>$v){
				$date['image'].=$info[$k]['savepath'].$info[$k]['savename'].",";
			}
				$date['image'] = substr($date['image'],0,strlen($date['image'])-1); //去掉最后一个逗号
			}
	//	dump($date);die;
		$date["function_id"]=implode(",",$date["function_list"]);
		if(empty($_GET["id"])){
			//执行添加操作=====================
			
			if(M("preview")->add($date)){
				 $this->success('添加成功',U('index'));
			}else{
				 $this->error('添加失败');
			}
		}else{
			//执行修改操作=====================
			if(M("preview")->where("id='".$_GET["id"]."'")->save($date)){
				 $this->success('修改成功',U('index'));
			}else{
				 $this->error('修改失败');
			}
		}
		
	}
	//删除小程序模板预览
	function preview_delete(){
		$a=M("preview")->where("id='".$_GET["id"]."'")->find();
		if(M("preview")->where("id='".$_GET["id"]."'")->delete()){
			$arr=explode(",",$a["image"]);
			for($i=0;$i<count($arr);$i++){
				unlink('./Uploads/'.$arr[$i]);
			}
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
	}
	
	 //分割函数
    function chaifen($source){
        return explode(',',$source);
    }
	
}