<?php
namespace AdminPnew\Controller;
use Think\Controller;
class FuWuinfoController extends CommonController {
	
	
    public function index(){
		echo 123;
    	$this->display();
	}
	
	
	//服务版信息表
	public function tiezi(){

		$aa=$this->info=$this->get_info();

		$this->display();
	}
	
	//服务版信息表
	public function tiezi_add(){

	$list	=M("jt04_fw_info")->where("id='".$_GET["id"]."'")->find();

	
				$members=M("members")->where("openid='".$list["openid"]."'")->find();
				$list["openid"]=$members["nickname"];
				
				$list["image"]=explode(",",$list["image"]);
			
			$this->info=$list;
		$this->display();
	}
	
	//资讯删除
	function zx_delete(){
			 $user_id = $_GET['id'];
	        if(M('jt03_zx_info')->delete($user_id)) {
	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
	}
	
	public function get_info(){
		$where["program_id"]=$_COOKIE["program_id"];
		//两个字段的模糊搜索  str=》id、名称   
		 if(!empty($str)){
			//	$str=$_POST['str'];     //如果接收到搜索关键字,执行模糊查询 返回数据
				$where['_string']='
					(id like "%'.$str.'%")  
					OR (title like "%'.$str.'%")
				';
				$list=M("jt04_fw_info")
					->field('id,title,openid,time_set,num_say_yes,num_write,content,image')
					->where($where)
					->order("time_set desc")
					->select();//对id、名称的模糊搜索	
			}else{
				$list=M("jt04_fw_info")
					->field('id,title,openid,time_set,num_say_yes,num_write,content,image')
					->where($where)
					->order("time_set  desc")
					->select();	
			}
			
			for($i=0;$i<count($list);$i++){
				$members=M("members")->where("openid='".$list[$i]["openid"]."'")->find();
				$list[$i]["openid"]=$members["nickname"];
				
				$list[$i]["image"]=explode(",",$list[$i]["image"]);
			}
			return $list;
	}

}