<?php
namespace Agency\Controller;
use Think\Controller;
header('content-type:application:json;charset=utf8'); 
header('Access-Control-Allow-Origin:*');  
header('Access-Control-Allow-Headers:x-requested-with,content-type');
class UserController extends Controller {
	
	//添加商户
	public function add_user(){
		$receive=I();
	    $Mysql=M('user_info');
		//name psw psw1 realname idcard tel mail
		if($receive['psw1']!=$receive['psw2']){
			$data=array('status'=>-1,'msg'=>'密码确认有误！请重新输入');
		}else{
			$sql=$Mysql->where(array('name'=>$receive['name']))->find();
			if($sql){
				$data=array('status'=>-1,'msg'=>'该用户名已存在');
			}else{
				$upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =     3145728 ;// 设置附件上传大小
			    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
 			   // $upload->savePath  =     'agency_img'; // 设置附件上传（子）目录
//			    $upload->subName = 'idcard_img';
			    // 上传文件 
			    $info   =   $upload->upload();
			    if($info){
                    $receive['idcardz']=$info['idcard1']['savepath'].$info['idcard1']['savename'];
			    	$receive['idcardf']=$info['idcard2']['savepath'].$info['idcard2']['savename'];
					$receive['type']=2;
					$receive['add_time']=time();
					$receive['psw']=md5($receive['psw1']);
					$Mysql->add($receive);
					$id=$Mysql->field('id')->where(array('name'=>$receive['name']))->find();
			        $UP=M('user_psw');
					$addarr=array('user_id'=>$id['id'],'psw'=>$receive['psw1']);
					$UP->add($addarr);
					$data=array('status'=>1,'msg'=>'添加用户成功');
			    }else{
                                          $error=$upload->getError();
		    	$data=array("status" => -1, "msg" => "图片上传失败",'error'=>$error);
			    }
			}
		}
//		$callback=$_GET["callback"];
//		echo $callback."(".json_encode($data).")";
        $this->ajaxReturn($data);
	}
	
	//客户管理页面信息列表 
	//需求参数 服务商ID
	//提供参数user_info.realname,qianyue.appmcheng,qianyue.state,qianyue.id AS program_id
	public function user_list(){
		$Mysql=M('user_info');
//	    $id=I('get.id');
		$where['user_info.agency_id']=I('get.id');
		$field='user_info.realname,qianyue.appmcheng,qianyue.state,qianyue.id AS program_id';
		$list=$Mysql
		->field($field)
		->join('qianyue ON user_info.id=qianyue.user_id')
		->where($where)
		->select();
//		echo '<pre/>';
//		print_r($list);
		$this->ajaxReturn($list);
	}
	//客户管理页面信息列表搜索
	//需求参数 服务商id str  start   end 
	//提供参数
	public function user_search(){
		$Mysql=M('user_info');
		$str=I('str');     
//		$start=I('start');
//		$end=I('end');
//		$stampt=strtotime(date($start));
//		$nt=strtotime(date($end));
		$where['user_info.agency_id']=I('id');
//		$where['user_info.lasttime']=array(array('EGT',$stampt),array('ELT',$nt));
		$where['_string']='(user_info.realname like "%'.$str.'%") OR (qianyue.appmcheng like "%'.$str.'%")';
		$field='user_info.realname,qianyue.appmcheng,qianyue.state,qianyue.id AS program_id,agency_info.company';
		$list=$Mysql
		->field($field)
		->join('qianyue ON user_info.id=qianyue.user_id')
		->join('agency_info ON user_info.agency_id=agency_info.id')
		->where($where)
		->select();
//		echo '<pre/>';
//		print_r($list);
	    $this->ajaxReturn($list);
	}
	//编辑客户
	//需求参数 小程序ID
	//提供参数用户id,name,tel,mail,idcard,idcardz,idcardf,lasttime,lastip
	public function upd_info(){
		$M=M('user_info');
		$where['program_id']=I('id');
		$field='id,name,tel,mail,idcard,idcardz,idcardf,lasttime,lastip';
		$d=$M->field($field)->where($where)->find();
//		echo '<pre/>';
//		print_r($d);
		$this->ajaxReturn($d);
	}
	
	//提交编辑客户信息
	//需求参数 用户id  原身份证正面 cardz原身份证反面cardf
	//提供参数
	public function upd_user(){
		$rec=I();
		$where['id']=I('id');
		$M=M('user_info');
		$upload = new \Think\Upload();// 实例化上传类
		    $upload->maxSize   =     3145728 ;// 设置附件上传大小
		    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
//			    $upload->savePath  =     'agency_img'; // 设置附件上传（子）目录
//		    $upload->subName = 'idcard_img';
		    // 上传文件 
		    $info   =   $upload->upload();
		    if($info){
		    	$rec['idcardz']=$info['idcard1']['savepath'].$info['idcard1']['savename'];
			    $rec['idcardf']=$info['idcard2']['savepath'].$info['idcard2']['savename'];
		        $M->where($where)->save($rec);
		        $file1='./Uploads/'.$rec['cardz'];
		        $file2='./Uploads/'.$rec['cardf'];
		        unlink($file1);
		        unlink($file2);
		        $data=array("status" => 1, "msg" => "操作成功");
		    }else{
		    	$data=array("status" => -1, "msg" => "图片上传失败");
		    }
		$this->ajaxReturn($data);
	}
	
	//小程序详细信息
	//需求参数 小程序ID
	//提供参数
	public function program_detail(){
		$U=M('user_info');
	    $where['qianyue.id']=I('id');
	    $field='user_info.realname,user_info.tel,user_info.mail,user_info.idcard,user_info.idcardz,user_info.idcardf,qianyue.model_id,qianyue.remark';
	    $i=$U
	    ->field($field)
	    ->join('qianyue ON user_info.id=qianyue.user_id')
	    ->where($where)
	    ->find();
//	    		echo '<pre/>';
//		print_r($i);
		$this->ajaxReturn($d);
	}
	
	//禁止启用
	//需求参数 id小程序  state 当前状态
	public function jinzhi(){
		$where['id']=I('id');
		$state=I('state');
		$Q=M('qianyue');
		if($state==1){
			$save['state']=-1;
			$Q->where($where)->save($save);
			$data=array('status'=>1,'msg'=>'已禁止','state'=>-1);
		}elseif($state=2){
			$data=array('status'=>-1,'msg'=>'正在审核中','state'=>2);
		}else{
			$save['state']=1;
			$Q->where($where)->save($save);
			$data=array('status'=>1,'msg'=>'已启用','state'=>1);
		}
		$this->ajaxReturn($data);
	}
}
?>