<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends CommonController {
    public function index(){
		$agency=M("jt_user_info")->field('user_id,user_company')->where("user_name='".$_COOKIE["name_h"]."'")->find();
		/*$shanghu=M("user_info")->field('id,agency_id,realname')->where("agency_id='".$agency["user_id"]."'")->select();	
		for($i<count($shanghu);$i++){
			$qianyue=M("qianyue")->where("user_id='".$shanghu[$i]["id"]."'")->select();
		}
		
		dump($shanghu);die;*/
		$Mysql=M('user_info');
//	    $id=I('get.id');
		$where['user_info.agency_id']=$agency["user_id"];
		$field='user_info.name,user_info.realname,user_info.id as shanghu_id,qianyue.appmcheng,mail,qianyue.state,qianyue.program_id,qianyue.quick_notice,qianyue.mail_notice,jt_user_info.user_company';
		$list=$Mysql
		->field($field)
		->join('LEFT JOIN qianyue ON user_info.id=qianyue.user_id')
        ->join('jt_user_info ON user_info.agency_id=jt_user_info.user_id')
		->where($where)
		->order("user_info.add_time desc")
		->select();
		for($i=0;$i<count($list);$i++){
				$list[$i]['self_sort']=$i+1;
			}
		
		$this->shanghu=$list;
		//dump($list);die;
		$this->display();
	
    }
    
    function a09120116chognxie(){
    	 $where['jt_user_info.user_name']=$_COOKIE["name_h"];
		    $field=
		    'qianyue.id,qianyue.appmcheng,qianyue.SMS_num,qianyue.state,
		    qianyue.quick_notice,qianyue.mail_notice,qianyue.program_id,
		    qianyue.is_gongzhognhao,qianyue.agency_id,qianyue.user_id as shagnhu_id,
		   
		   user_info.id as shagnhu_id,user_info.agency_id as shagnhu_agency_id,user_info.realname as shagnhu_realname,
		   
		    jt_user_info.user_id,jt_user_info.user_company';
			$list=M('jt_user_info')
			//->field($field)
			->join('user_info ON user_info.agency_id=jt_user_info.user_id')
			->join('left join qianyue ON qianyue.user_id=user_info.id')
			->where($where)
			->select();
		
		//dump(M('jt_user_info')->_sql());
		foreach($list as $v=>$k){
			$list[$v]["self_sort"]=$v+1;
			
		/*	$shanghu=M("user_info")->where("id='".$list[$v]["shagnhu_id"]."'")->find();
			$list[$v]["shagnhu_name"]=$shanghu["realname"];
	*/	}

		$this->shanghu=$list;
		dump($list);die;
		$this->display();
		
    }
    
    //禁止按钮
    public function forbid(){
        	
    }
    
    function useradd(){
  
    	$this->display();
    }
    
    function add_user(){
    
    	$receive=I();
    	$angency=M("jt_user_info")->where("user_name='".$_COOKIE["name_h"]."'")->find();
    	$receive["agency_id"]=$angency["user_id"];
   
    	
	if(empty($_GET['id'])){
				//==========执行添加操作=====================================
				if($receive['psw1']!=$receive['psw2']) $this->error('两次密码输入不一致!');
 	   
 	    $Mysql=M('user_info');
			$Mysql0914=M('user_info')->where("name='".$receive['name']."'")->find();
			//dump($Mysql0914);die;
			if(!empty($Mysql0914)){
			//	$data=array('status'=>-1,'msg'=>'该用户名已存在');
				$this->error('该用商户账号已存在');
			}else{
				$upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =     3145728 ;// 设置附件上传大小
			    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
			    // 上传文件 
			    $info   =   $upload->upload();
			    if($info){
			    	
			 //   有图片==========执行添加操作==============
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
					
					$this->success('添加用户成功1',U('index'));
					//$data=array('status'=>1,'msg'=>'添加用户成功');
			    }else{
			//无图片==========执行添加操作==============
			    	$receive['type']=2;
					$receive['add_time']=time();
					$receive['psw']=md5($receive['psw1']);
					
					$Mysql->add($receive);//对商户表执行添加
					$id=$Mysql->field('id')->where(array('name'=>$receive['name']))->find();
			        $UP=M('user_psw');
					$addarr=array('user_id'=>$id['id'],'psw'=>$receive['psw1']);
					$UP->add($addarr);
			    //	$data=array('status'=>1.1,'msg'=>'添加用户成功');
			    		$this->success('添加用户成功1.1',U('index'));
             	    }
			}
				
			}else{
				//========执行修改操作=====================================

				$upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =     3145728 ;// 设置附件上传大小
			    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
			    // 上传文件 
			    $info   =   $upload->upload();
			    if($info){
			 //   有图片========执行修改操作=======
                    $receive['idcardz']=$info['idcard1']['savepath'].$info['idcard1']['savename'];
			    	$receive['idcardf']=$info['idcard2']['savepath'].$info['idcard2']['savename'];

					if(M('user_info')->where("id='".$_GET["id"]."'")->save($receive)){
						$this->success('修改成功1',U('index'));
					}else{
						 $this->error('修改失败');
					}
					
					
					
			   }else{
		//   无图片========执行修改操作=======
				
				    	if(M('user_info')->where("id='".$_GET["id"]."'")->save($receive)){
							$this->success('修改成功2',U('index'));
						}else{
							 $this->error('修改失败2');
						}	
             	    }
			
			}
	
		
    }
    
    //编辑客户
    function edit_user(){
    	$sh0912=$this->sh0912=M("user_info")->where("id='".$_GET["id"]."'")->find();
    	//dump($sh0912);die;
    	$this->is_edit="1";//编辑页面标识
    	$this->display('useradd');
    }
   //用户充值
   public function recharge(){
   	$id=$_GET['id'];
   	$name=M('user_info')->field('id,name,agency_id')->where('id='.$id)->find();
   	$muban=M('muban')->field('muban_type,muban_b')->where('shanghu_id='.$id)->find();
   	$price_xufei=M('muban_b')->field('price_xufei')->where(array('muban_b'=>$muban['muban_b'],'lid'=>$muban['muban_type']))->find();
   	$this->assign('price',$price_xufei['price_xufei']);
   	$this->assign('name',$name);
   	$this->display();
   }
   
   //充值提交
   public function recharge_save(){
   	$aid=$_GET['aid'];
   	$receive=I('post.');
   	$getpsw=md5($_POST['jypsw']);
   	$zfpsw=M('jt_user_info')->field('user_zfpsw,user_balance')->where('user_id='.$aid)->find();
    if($getpsw!=$zfpsw['user_zfpsw']){
    	$this->error('支付密码不正确');
    }else{
    	if($zfpsw['user_balance']<$receive['deal_gold']){
    		$this->error('余额不足');
    	}else{
			$upload = new \Think\Upload();// 实例化上传类
		    $upload->maxSize   =     3145728 ;// 设置附件上传大小
		    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
		    $info   =   $upload->upload();
		    if($info){
		    	$receive['agency_id']=$aid;
		    	$receive['contract_img']=$info["contract_img"]['savepath'].$info['contract_img']['savename'];
		    	$receive['running_num']='JT'.date("YmdHis").rand(10,99);
		    	$receive['balance']=$zfpsw['user_balance']-$receive['deal_gold'];
		    	$receive['deal_time']=time();
		    	$receive['deal_type']=2;
		    	$receive['user_id']=$_GET['uid'];
		    	if(M('deal_info')->add($receive)){
		    		$Q=M('qianyue');
	                $endt=$Q->field('end_time')->where(array('user_id'=>$_GET['uid']))->find();
	                $str=date('Y-m-d h:i:s',$endt['end_time']);
//	                echo $str.'<br/>';
	                $strend=substr($str,5,strlen($str)-3);
	                $str=substr($str,0,4);
	                $str=$str+$receive['deal_years'];
	                $getendt=strtotime($str.'-'.$strend);
//	                echo $strend.'<br/>';
//	                echo $str.'<br/>';
//                  echo   $endt['end_time'].'////'.$getendt;
			    	if($Q->where(array('user_id'=>$_GET['uid']))->save(array('end_time'=>$getendt))){
			    		$this->success('充值成功',U('index'));
			    	}else{
			    		$this->error('添加失败');
			    	}
		    	}
		    }
    	}
    }
   }
   //小程序按钮
   public function programinfo(){
   	$uid=$_GET['uid'];
   	$info1=M('user_info')->field('realname,tel,mail,idcard,idcardz,idcardf')->where('id='.$uid)->find();
   	$info2=M('muban')->field('muban_name')->where('shanghu_id='.$uid)->find();
   	$info3=M('qianyue')->field('contract_img,remark')->where('user_id='.$uid)->find();
   	$this->assign('info1',$info1);
    $this->assign('info2',$info2);
   	$this->assign('info3',$info3);
   	$this->display();
   }
}