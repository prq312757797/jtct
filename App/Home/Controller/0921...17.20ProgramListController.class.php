<?php
namespace Home\Controller;
use Think\Controller;
header("Content-type: text/html; charset=utf-8");
class ProgramListController extends Common01Controller {
	
/*	protected function _initialize() {
		$this->is_action02="1";
		
		$this->is_action01=null;
		$this->is_action03=null;
	}*/
    public function index(){
    	  $agency=$this->agency=M("jt_user_info")
        ->field('user_name,user_company')
        ->where("user_name='".$_COOKIE["name_h"]."'")
        ->find();   
		
		    $where['jt_user_info.user_name']=$_COOKIE["name_h"];
		    $field=
		    'muban.id as muban_id,muban.shanghu_id as muban_shanghu_id,muban.program_id as muban_program_id,
		    jt_user_info.user_id,jt_user_info.user_company,
			user_info.id as shanghu_id,user_info.realname as shanghu_realname,user_info.tel as shanghu_tel,user_info.agency_id,
			
			qianyue.id as qianyue_id,qianyue.program_id as qianyue_program_id,qianyue.start_time as qianyue_start_time,qianyue.end_time as qianyue_end_time ,qianyue.appmcheng as qianyue_appmcheng'; 
	
		$list=M('muban')
			->field($field)
			->join('user_info ON muban.shanghu_id=user_info.id')
			->join('jt_user_info ON user_info.agency_id=jt_user_info.user_id')
			->join('qianyue ON qianyue.program_id=muban.program_id')
			->where($where)
			->select();
		
		foreach($list as $v=>$k){
			$list[$v]["id"]=$v;
		}


		$this->list=$list;
    	$this->display();
    
    }
    //签约信息
    function PLqianyue(){
    $this->qianyue=M("qianyue")->where("program_id='".$_GET["program_id"]."'")->find();
    	
    	
    $this->display();
    }
    //签约修改
    function PLqianyue_edit(){
    	$this->error("维护中....");
    }
    
    
    
    //参数编辑
    function PLcanshu(){
    	//dump($_GET);DIE;
    	$qianyue=M("qianyue")->where("program_id='".$_GET["program_id"]."'")->find();
    	
    	//得到商户id
    	$a=M("user_info")->where("id='".$qianyue["user_id"]."'")->find();
    	$qianyue["shagnhu_name"]=$a["name"];

    	$this->shagnhu=$qianyue;
    	$this->display();
    }
    //修改参数按钮
    
    function PLcanshu_edit(){
    	
    	//保存商户更改的信息
    	//商户账号
    	$save01["name"]=$_POST["name"];
    	//商户号
    	$save01["shanghu_num"]=$_POST["shanghu_num"];

    	//商户密码
    	if(!empty($_POST["psw"])){
    		$save01["psw"]=md5($_POST["psw"]);
    	}
    	//商户appsecret
    	if(!empty($_POST["appsecret"])){
    		$save01["appsecret"]=md5($_POST["appsecret"]);
    	}
    	//商户支付密码
    	if(!empty($_POST["pay_key"])){
    		$save01["pay_key"]=md5($_POST["pay_key"]);
    	}
    	
    	//appmcheng  小程序名称
    	$save02["appmcheng"]=$_POST["appmcheng"];
    	$save02["start_id"]=$_POST["start_id"];
    	$save02["appid"]=$_POST["appid"];
    	
    	if(M("qianyue")->where("program_id='".$_POST["program_id"]."'")->save($save02)){
    		  	M("user_info")->where("id='".$_POST["shanghu_id"]."'")->save($save01);
   					
  				$this->success('操作成功',U('index'));
			}else{
				$this->error('操作失败');
			}
    
    }
    
    //小程序基本信息
    function program_info(){
    	
    	$this->display();
    }
    
    //小程序添加：小程序基本信息填写
    public function addprogram_info(){
    	
    	$this->display();
    }
    //小程序添加：可选模板展示
    function addprogram(){
    	if(empty($_POST['appmcheng'])){
    		$this->error('请填写小程序名称',U('addprogram_info'));
    	}else{
    		$rec=I('post.');
    		session('pinfo',$rec);
//  		print_r(session('pinfo'));
    	}
    	$mlist=M("muban_l")->field('id,name')->where("state=1")->select();
    	$mblist=M('muban_b')->where("state=1")->select();
    	$this->assign('mlist',$mlist);
    	$this->assign('mblist',$mblist);
    	$this->display();
    }
    //小程序添加提交审核
    public function addprogram_submit(){
    	$user=M('user_info')->field('id,psw,agency_id')->where(array('name'=>$_POST['name']))->find();
    	$agency=M('jt_user_info')->field('user_id,user_balance')->where(array('user_name'=>$_COOKIE['name_h']))->find();
    	$psw=md5($_POST['psw']);
//  	echo '<pre/>';
//  	print_r($user);
//  	echo $psw;
//  	die;
    	if(!$user||$user['psw']!=$psw){
    		$this->error('账号或密码错误');
    	}else{
    		 $where['user_id']=$user["id"];
			 $where['state']=array('in','2,3');
			 $wq=M("qianyue")->where($where)->find();
			 if(!empty($wq)){
			 	$this->error('商户已存在小程序记录，禁止再申请');
			 }elseif($agency['user_id']!=$user['agency_id']){
			 	$this->error('不能管理非本服务商下的商户，不允许继续操作');
			 }elseif($agency["user_balance"]<$_POST["price"]){
		 			$this->error('余额不足禁止操作');
			 }else{
			 	$upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =  3145728 ;// 设置附件上传大小
			    $upload->exts      =  array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =   './Uploads/'; // 设置附件上传根目录
			    // 上传文件 
			    $info   =   $upload->upload();
			    if($info){
			    	$img=$info['contract_img']['savepath'].$info['contract_img']['savename'];
				    $add=array(
				 	      'appmcheng'=>session('pinfo.appmcheng'),
				 	      'start_id'=>session('pinfo.start_id'),
				 	      'appid'=>session('pinfo.appid'),
				 	      'appsecret'=>session('pinfo.appsecret'),
				 	      'payment'=>session('pinfo.payment'),
				 	      'shanghu_num'=>session('pinfo.shanghu_num'),
				 	      'paykey'=>session('pinfo.paykey'),
				 	      'beian_time'=>time(),
				 	      'add_time'=>time(),
				 	      'upd_time'=>time(),
				 	      'state'=>2,
				 	      'contract_id'=>$_POST['contract_id'],
				 	      'contract_img'=>$img,
				 	      'remark'=>$_POST['remark'],
				 	      'year'=>$_POST['years'],
				 	      'muban_price'=>$_POST['price'],
				 	      'muban_type'=>$_POST['muban_lid'],
				 	      'muban_b'=>$_POST['muban_bid'],
				 	      'user_id'=>$user['id'],
				 	      'agency_id'=>$agency['user_id']
				 	);
				 	if(M('qianyue')->add($add)){
				 		$dealadd=array(
				 		   'running_num'=>'JT'.date("YmdHis").rand(10,99),
				 		   'balance'=>($agency["user_balance"]-$_POST['price']),
				 		   'contract_id'=>$_POST['contract_id'],
				 	       'contract_img'=>$img,
				 	       'deal_gold'=>$_POST['price'],
				 	       'deal_time'=>time(),
				 	       'remark'=>$_POST['remark'],
				 	       'agency_id'=>$agency['user_id'],
				 	       'user_id'=>$user['id'],
				 	       'deal_type'=>1,
				 	       'deal_years'=>$_POST['years']
				 		);
				 		M('deal_info')->add($dealadd);
				 		
				 		$this->success('操作成功,小程序待审核中',U('User/index'));
				 unset($_SESSION['pinfo']);
				 }else{
				 		$this->error('操作失败');
				 	}	
			   }else{
			  	 	$this->error('必须上传合同附件');
			   }
			 }
    	}
    }
    
    //获取模板价格
    function get_price(){
    	if(!empty($_GET['muban_bid'])&&!empty($_GET['muban_lid'])){
    		$price=M('muban_b')->field('price')->where(array('id'=>$_GET['muban_bid'],'lid'=>$_GET['muban_lid']))->find();
    		$this->ajaxReturn($price);
    	}
    }
}