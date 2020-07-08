<?php
namespace Hl\Controller;
use Think\Controller;
class CarinfoController extends CommonController {
	 public function info_list(){
		$where["program_id"]=$_COOKIE["program_id"];
	
		//两个字段的模糊搜索  str=》id、名称    str_f=》分类 
		if(!empty($str)){
			//模糊查询  标题 或者id
			$where['_string']='
				(id like "%'.$str.'%")  
				OR (title like "%'.$str.'%")
			';
			$list=M("jt03_zx_info")->where($where)->order("time_input desc")->select();//对id、名称的模糊搜索

		}else if(!empty($str_f)){
			//根据商品分类的id查询 商品列表	 
			$list= M("jt03_zx_info")->query("
				select * from 
				jt03_zx_info 
				left outer join  
				( select attribute.id as attribute_id,attribute.title as attribute_title from attribute where title like '%".$str_f."%'"."  ) c 
				on jt03_zx_info.fenlei01=c.attribute_id
				where jt03_zx_info.program_id='".$_COOKIE["program_id"]."'"." and jt03_zx_info.state='".$state."'"." and jt03_zx_info.style='".$style."'"."	and jt03_zx_info.is_gongyi='".$is_gongyi."'"."
			");				
		}else{			
			$list=M("jt03_zx_info")->where($where)->order("time_input  desc")->select();	
		}
		
	$aa=$this->info=$list;
    	$this->display();
	}
	
	public function info_list_add(){

    	$this->display();
	}
	
	public function info_list_edit(){
		$this->info=M("jt03_zx_info")->where("id='".$_GET["id"]."'")->find();
    	$this->display('info_list_add');
	}
	//资讯删除
	function zx_delete(){
			 $user_id = $_GET['id'];
			 $a=M('jt03_zx_info')->where("id='".$_GET['id']."'")->find();
	        if(M('jt03_zx_info')->delete($user_id)) {
	        		unlink('./Uploads/'.$a["image"]);
	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
	}
		//多图资讯的写入接口
	public function run_good_news_add(){
		$receive=I();

		$receive["program_id"]=$_COOKIE["program_id"];
		    $upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =     3145728 ;// 设置附件上传大小
			    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
			// 上传文件 
			     $info   =   $upload->upload();
	
			 if($info){
			 	//有图片===============================================================
			 	
				 	for($i=0;$i<count($info);$i++){
				 		$receive['image'].=$info[$i]['savepath'].$info[$i]['savename'].",";
				 	}
				 	
	                $receive['image'] = substr($receive['image'],0,strlen($receive['image'])-1); //去掉最后一个逗号
							  
			    }else{
			    	//无图片===============================================================
					    if(empty($_GET['id'])){
					    	$this->error('无上传图片');	
		                	$error=$upload->getError();
				    		$data=array("status" => -1, "msg" => "图片上传失败",'error'=>$error);
					    }
			    }
			     if(empty($_GET['id'])) {
						//执行添加操作==========================================	
		
						$receive['time_input']=time();

						$receive['program_id']=$_COOKIE["program_id"];		
						
						if(M('jt03_zx_info')->add($receive)){
							
							$this->success('添加成功',U('info_list'));
							
						}else{
							$this->error('添加失败');	
						}    
				}else{
						//执行修改操作==========================================	
						//修改图片需要得到原来的字符串，然后再拼接	
						$old_info=M('jt03_zx_info')->where(array('id'=>$_GET['id']))->find();
			
						 if(M('jt03_zx_info')->where(array('id'=>$_GET['id']))->save($receive)){
						 	
						 	unlink('./Uploads/'.$old_info["image"]);//删除旧图片
						
							$this->success('修改成功',U('info_list'));
			    	
						}else{
							$this->error('修改失败');	
					 }
				} 
	}
}