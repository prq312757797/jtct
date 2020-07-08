<?php
namespace Admin\Controller;
use Think\Controller;
class ServicerController extends CommonController {
    public function index(){
	//	$a= $this->user_info=M('jt_user_info')->select();
	

		$goods = D("jt_user_info");
            $total = $goods->count();
            $per = 10;
            $page = new \Component\Page($total, $per); //autoload
            $sql = "select * from jt_user_info ".$page->limit;
            $info = $goods -> query($sql);
            $pagelist = $page -> fpage();


			for($i=0;$i<count($info);$i++){
				//商户数量
				$info[$i]["count_sh"]=M("qianyue")->where("agency_id='".$info[$i]["user_id"]."'")->count();
				
				//消费记录
					$info[$i]["deal_info"]=M("deal_info")->where("agency_id='".$info[$i]["user_id"]."'")->count();
				//充值记录
					$info[$i]["recharge_info"]=M("recharge_info")->where("user_agency_id='".$info[$i]["user_id"]."'")->count();
			}
			
            $this -> assign('user_info', $info);
            $this -> assign('pages', $pagelist);
		
			$this->show_add=1;//显示添加功能
			
			
			
			$this->title="";
		$this->display();
	}
	 public function add() {
        $this->display();
    }
//测试 上传图片
 public function test() {
 	$dat["name"]=date("Y-m-d H:i:s",time());
 	M('test')->add($dat);
    $upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =  3145728 ;// 设置附件上传大小
			    $upload->exts      =  array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =   './Uploads/'; // 设置附件上传根目录
			    // 上传文件 
			    $info   =   $upload->upload();
			 
			    if($info){
			    	//有图片上传

					if(!empty($info['img'])){
						$date['name']=$info['img']['savepath'].$info['img']['savename'];
					}

					if(M('test')->add($date)) {
			             	$data=array("status" => 1, "msg" => "图片上传成功");
			  
			            } else {
			              	$data=array("status" => 2, "msg" => "图片上传失败");
			  
			            }
			    }else{
			    	//没有图片上传

			    	if(M('jt_user_info')->add($date)) {
			             $data=array("status" => 1.1, "msg" => "图片上传成功");
			            } else {
			             $data=array("status" => 2.2, "msg" => "图片上传失败");
			            }
                 }
                 $this->ajaxReturn($data);
    }

    public function runAdd() {
        if(empty($_GET['user_id'])) {
        	
			$upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =  3145728 ;// 设置附件上传大小
			    $upload->exts      =  array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =   './Uploads/'; // 设置附件上传根目录
			    // 上传文件 
			    $info   =   $upload->upload();
			  	$date["add_time"]=time();
				$date["user_psw"]=md5($_POST["user_psw"]);
				$date["user_name"]=$_POST["user_name"];
				$date["user_company"]=$_POST["user_company"];
				$date["user_tel"]=$_POST["user_tel"];
				$date["user_mail"]=$_POST["user_mail"];
				$date["user_idcard"]=$_POST["user_idcard"];
		
			    if($info){
			    	//有图片上传
			    	
                   if(!empty($info['user_idcardz'])){
			 		 $date['user_idcardz']=$info['user_idcardz']['savepath'].$info['user_idcardz']['savename'];    
					}
					if(!empty($info['user_idcardz'])){
					$date['user_idcardf']=$info['user_idcardf']['savepath'].$info['user_idcardf']['savename'];
					}
				
					if(M('jt_user_info')->add($date)) {
		
			                $this->success('添加成功',U('index'));
			            } else {
			                $this->error('添加失败');
			            }
			    }else{
			    	//没有图片上传
			 	$date["user_psw"]=md5($_POST["user_psw"]);
				$date["user_name"]=$_POST["user_name"];
				$date["user_company"]=$_POST["user_company"];
				$date["user_tel"]=$_POST["user_tel"];
				$date["user_mail"]=$_POST["user_mail"];
				$date["user_idcard"]=$_POST["user_idcard"];
			
			    	if(M('jt_user_info')->add($date)) {
			    	
			                $this->success('添加成功',U('index'));
			            } else {
			                $this->error('添加失败');
			            }
                    $error=$upload->getError();
		    		$data=array("status" => -1, "msg" => "图片上传失败",'error'=>$error);
			    }
       }else {
        	//修改
        	
        		$upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =  3145728 ;// 设置附件上传大小
			    $upload->exts      =  array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =   './Uploads/'; // 设置附件上传根目录
			    // 上传文件 
			    $info   =   $upload->upload();
			  	$date["user_name"]=$_POST["user_name"];
				$date["user_company"]=$_POST["user_company"];
				$date["user_tel"]=$_POST["user_tel"];
				$date["user_mail"]=$_POST["user_mail"];
				$date["user_idcard"]=$_POST["user_idcard"];
			  
			    if($info){
			    	//有图片上传
					if(!empty($info['user_idcardz'])){
						  $date['user_idcardz']=$info['user_idcardz']['savepath'].$info['user_idcardz']['savename'];    
					}
					if(!empty($info['user_idcardz'])){
						$date['user_idcardf']=$info['user_idcardf']['savepath'].$info['user_idcardf']['savename'];
					}
                  
		
					M('jt_user_info')->where(array('user_id'=>$_GET['user_id']))->save($date);
					$this->success('修改成功',U('index'));
			    }else{
			    	//没有图片上传
			    	$date["user_name"]=$_POST["user_name"];
				$date["user_company"]=$_POST["user_company"];
				$date["user_tel"]=$_POST["user_tel"];
				$date["user_mail"]=$_POST["user_mail"];
				$date["user_idcard"]=$_POST["user_idcard"];
				
			    	M('jt_user_info')->where(array('user_id'=>$_GET['user_id']))->save($date);
					$this->success('修改成功',U('index'));
                    $error=$upload->getError();
		    		$data=array("status" => -1, "msg" => "图片上传失败",'error'=>$error);
			    }
            
        }
    }

    public function edit() {
		
       $a= $this->info=M('jt_user_info')->where('user_id='.$_GET['user_id'])->find();
		
		//dump($a);
       $this->display('add');
    }
	/**删除服务商*/
    public function delete() {
        $user_id = $_GET['user_id'];
        if(M('jt_user_info')->delete($user_id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
	/**删除消费记录*/
	public function delete2() {
        $user_id = $_GET['id'];
        if(M('deal_info')->delete($user_id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
	/**删除充值记录*/
	public function delete3() {
        $user_id = $_GET['id'];
        if(M('recharge_info')->delete($user_id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
	/**消费记录*/
	public function record_xf(){
		
		 $goods = D("deal_info");
            $total = $goods->where(array('agency_id'=>$_GET['user_id']))->count();
            $per = 10;
            $page = new \Component\Page($total, $per); //autoload
            $sql = "select * from deal_info where agency_id='".$_GET['user_id']."'";
            
            $sql.=" order by time_set desc ".$page->limit;
            $info = $goods -> query($sql);
            $pagelist = $page -> fpage();

            $this -> assign('record_xf', $info);
            $this -> assign('pages', $pagelist);
			
			
			$this->title="消费记录";
		$this->display();
	}
	/**充值操作页面*/
		public function top_up(){
			$a=$this->info=M('jt_user_info')->where('user_id='.$_GET['user_id'])->find();
			
		
			$this->running_num=date("YmdHis",time()).rand(1,99);
			$this->title="充值";
			$this->man_action=$_COOKIE["admin_name"];
			
		$this->display();
	}
	
	/**充值操作*/
		public function top_up_add(){
			
			if(is_numeric($_POST['price_add'])){
				//余额、添加金额、商户id、操作人、流水号
			$b=array(
				'user_agency_id'=>$_POST['user_id'],
				'running_num'=>$_POST['running_num'],
				'recharge_time'=> time(),
				'man_action'=>$_POST['man_action'],
				'content'=>$_POST['content'],
				'recharge_gold'=>$_POST['price_add']
			);
	
			//向服务商信息表修改 余额
			if(M('jt_user_info')->where('user_id='.$_POST['user_id'])->setInc('user_balance',$_POST['price_add'])){
				M('recharge_info')->add($b);
				$this->success('充值成功',U('index'));
			}else {
            $this->error('充值失败');
			}
        }else{
			 $this->error('请输入正确金额');
		}
		
			
			
		}
	
	/**充值记录*/
		public function record_cz(){
		 $goods = D("recharge_info");
            $total = $goods->where(array('user_agency_id'=>$_GET['user_id']))->count();
            $per = 10;
            $page = new \Component\Page($total, $per); //autoload
            $sql = "select * from recharge_info where user_agency_id='".$_GET['user_id']."'" . " order by recharge_time desc " .$page->limit;
            $info = $goods -> query($sql);
            $pagelist = $page -> fpage();

			for($i=0;$i<count($info);$i++){
				$aa=$info[$i]["user_agency_id"];
				$b=M("jt_user_info")->where($aa)->find();
				$info[$i]["user_company"]=$b["user_company"];
			}
            $this -> assign('record_cz', $info);
            $this -> assign('pages', $pagelist);
			
			$this->title="充值记录";
		$this->display();
	}
	
	//查看所属商户
	public function shagnhu(){
		
		$goods = D("user_info");
            $total = $goods->where("agency_id='".$_GET["user_id"]."'")->count();
            $per = 10;
            $page = new \Component\Page($total, $per); //autoload
            $sql = "select * from user_info where agency_id='".$_GET["user_id"]."'".$page->limit;
            $info = $goods -> query($sql);
            $pagelist = $page -> fpage();

            $this -> assign('user_info', $info);
            $this -> assign('pages', $pagelist);
		
		
			$this->show_add=1;//显示添加功能
			$this->title="";

		
		$this->display();
	}
	
}