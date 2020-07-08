<?php
namespace AdminP\Controller;
use Think\Controller;
class FuWurendezvousController extends CommonController {
	
	//预约管理   预约信息等同订单信息，能够查看，到了时间自动删除，电脑端查看手机端添加管理人员，也能查看
	
	
    public function index(){
		$arr=$this->commen($state=1);
		$this->info=$arr;
$image=	$this->image=$image=M("store")->field('image_fu_fenlei')->where("program_id='".$_COOKIE["program_id"]."'")->find();
  	
    	$this->display();
	}
	
	
	//历史预约
	public function history(){
		$arr=$this->commen($state=2);
		$this->info=$arr;

		$this->display();
	}
	//取消预约
	public function say_no(){
		$arr=$this->commen($state=3);
		$this->info=$arr;

		$this->display();
	}
	
	//公用函数
	
	function commen($state){
		$yuyue=M("jt04_fw_yuyue")->where("state='".$state."'". " and program_id='".$_COOKIE["program_id"]."'")->select();
		
			for($i=0;$i<count($yuyue);$i++){
			//商品名称
			$goods=M("goods")->where("id='".$yuyue[$i]["goods_id"]."'")->find();
			
			$yuyue[$i]["goods_name"]=$goods["goods_title"];
			
			
			if($yuyue[$i]["time_over"]<time()){
				//过期了  
				$save["state"]="2";
				M("jt04_fw_yuyue")->where("id='".$yuyue[$i]["id"]."'")->save($save);
			}else{
				$list[$i]=$yuyue[$i];
			}
		}
	
		$a=0;
		foreach($list as $v=>$k){
			$arr[$a]=$list[$v];	
			$a++;
		}
		return $arr;
	}

	//预约取消
	function yy_say_no(){
			 $user_id["state"] = "3";
			 
	        if(M('jt04_fw_yuyue')->where("id='".$_GET["id"]."'")->save($user_id)) {
	            $this->success('取消成功');
	        } else {
	            $this->error('取消失败');
	        }
	}
	
	//预约删除
	function yy_delete(){
			 $user_id = $_GET['id'];
	        if(M('jt04_fw_yuyue')->delete($user_id)) {
	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
	}
	
	//预约页面广告
	function yuyue_save(){
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =  3145728 ;// 设置附件上传大小
		$upload->exts      =  array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath  =   './Uploads/'; // 设置附件上传根目录
		 // 上传文件 
		$info   =   $upload->upload();
		if($info){
                $receive['image_fu_fenlei']=$info['image_fu_fenlei']['savepath'].$info['image_fu_fenlei']['savename'];	    
				
				if(M('store')->where("program_id='".$_COOKIE["program_id"]."'")->save($receive)){
				    	$this->success('操作成功',U('index'));
				    }else{
				    	$this->error('操作失败');	
				    }
			    
			}else{
			    	$this->error('无上传图片');	
                	$error=$upload->getError();
		    		$data=array("status" => -1, "msg" => "图片上传失败",'error'=>$error);
			
			}	 
	}

}