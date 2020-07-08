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
        ->field('user_name,user_company,user_balance,dj_balance')
        ->where("user_name='".$_COOKIE["name_h"]."'")
        ->find();   
		$this->user_balance=$agency["user_balance"];
		$this->dj_balance=$agency["dj_balance"];
		   /* $where['jt_user_info.user_name']=$_COOKIE["name_h"];
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
			->where($where) qianyue_end_time
			->select(); */
		$where['jt_user_info.user_name']=$_COOKIE["name_h"];
		$where['qianyue.is_tired']="2";
		    $field='
		    jt_user_info.user_id,jt_user_info.user_company,
		
			user_info.id as shanghu_id,user_info.realname as shanghu_realname,user_info.tel as shanghu_tel,user_info.agency_id,
			
			qianyue.id as qianyue_id,qianyue.program_id as qianyue_program_id,qianyue.start_time as qianyue_start_time,
			qianyue.end_time as qianyue_end_time ,qianyue.appmcheng as qianyue_appmcheng,qianyue.add_time as qianyue_add_time,
			qianyue.is_tired as qianyue_is_tired,qianyue.beian_time as qianyue_beian_time,qianyue.function_id,
			
			store.program_id as store_program_id,store.program_logo
			'; 
	
		$list=M('qianyue')
			->field($field)
			->join('user_info ON qianyue.user_id=user_info.id')
			->join('jt_user_info ON qianyue.agency_id=jt_user_info.user_id')
			->join('left join store ON store.program_id=qianyue.program_id')
			->where($where)
			->order("qianyue.add_time desc")
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
    	$qianyue=M("qianyue")->where("program_id='".$_GET["program_id"]."'")->find();
    	
    	//得到商户id 	->field('id')
    	$a=M("user_info")->field('name')->where("id='".$qianyue["user_id"]."'")->find();
    	$qianyue["user_shagnhu_name"]=$a["name"];
		
		$this->store=M("store")->field("id,is_show_vedio,is_submit_contect,is_artical,fenlei_lever,in_on_guige,is_on_pifa,is_on_showgoods")->where("program_id='".$_GET["program_id"]."'")->find();

    	$this->shagnhu=$qianyue;
    	$this->display();
    }
    //修改参数按钮
    
    function PLcanshu_edit(){
    	
    	//保存商户更改的信息
    	//商户账号======================================================================
    	$save01["name"]=$_POST["name"];
    	$save02["appmcheng"]=$_POST["name"];
    	//商户号======================================================================
    	$save01["shanghu_num"]=$_POST["shanghu_num"];
		$save02["shanghu_num"]=$_POST["shanghu_num"];
		
		
    	//商户密码======================================================================
    	if(!empty($_POST["psw"])){
    		$save01["psw"]=md5($_POST["psw"]);
    		$save02["psw"]=md5($_POST["psw"]);
    	}
    	//商户appsecret
    	/*if(!empty($_POST["appsecret"])){
    		$save01["appsecret"]=md5($_POST["appsecret"]);
    	}*/
    	$save01["appsecret"]=$_POST["appsecret"];
    	$save02["appsecret"]=$_POST["appsecret"];
    	//商户支付密码======================================================================
    	/*if(!empty($_POST["pay_key"])){
    		$save01["pay_key"]=md5($_POST["pay_key"]);
    	}*/
    	$save01["pay_key"]=$_POST["pay_key"];
    	$save02["pay_key"]=$_POST["pay_key"];
    	//appmcheng  小程序名称======================================================================
    	$save02["appmcheng"]=$_POST["appmcheng"];
    	$save02["start_id"]=$_POST["start_id"];
    	
    	$save01["appid"]=$_POST["appid"];
    	$save02["appid"]=$_POST["appid"];
    	
    	$save02["upd_time"]=time();

    	if(M("qianyue")->where("program_id='".$_POST["program_id"]."'")->save($save02)){
		  	M("user_info")->where("id='".$_POST["shanghu_id"]."'")->save($save01);
				
			$this->success('操作成功',U('index'));
		}else{
			$this->error('操作失败');
		}
    
    }
    function PL_function_edit(){
    	$save["is_show_vedio"]		=$_POST["is_show_vedio"];
    	$save["is_submit_contect"]	=$_POST["is_submit_contect"];
		$save["is_artical"]			=$_POST["is_artical"];
		$save["fenlei_lever"]		=$_POST["fenlei_lever"];
		$save["in_on_guige"]		=$_POST["in_on_guige"];
		$save["is_on_pifa"]			=$_POST["is_on_pifa"];
		$save["is_on_showgoods"]	=$_POST["is_on_showgoods"];
		$save["is_double_huandeng"]	=$_POST["is_double_huandeng"];
		$save["is_booking_server"]	=$_POST["is_booking_server"];
		$save["is_show_indexfl"]	=$_POST["is_show_indexfl"];
		
    	if(M("store")->where("program_id='".$_POST["program_id"]."'")->save($save)){
		  
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
    
    
    //新的小程序基本信息页面
    function addprogram_new(){
    	$this->list01=$a=M("function_list")->where("function_state=1")->order("sort")->select();
    	$this->list02=$a=M("function_list")->where("function_state=2")->order("sort")->select();
    
    	
    	$this->display();	
    }
    
    
    //小程序添加：可选模板展示
    function addprogram(){
    	
    /*	$a=array(1,2,3);
    	$aw=implode(",",$a);
    	dump($aw);
    	die;*/
    //dump(explode(' ',"  1.0  版本价:1000.00 "));
	$a=M("qianyue")->field("id")->where("appmcheng='".$_POST["appmcheng"]."'")->find();
   if(!empty($a)){
   	$this->error('该小程序已存在',U('addprogram_info'));
   }
   
    	if(empty($_POST['appmcheng'])){
    		$this->error('请填写小程序名称',U('addprogram_info'));
    	}else{
    		$rec=I('post.');
    		session('pinfo',$rec);//将上一页填写的内容存入session
    	}
    	//获取模板类型名
    	$mlist=M("muban_l")->field('id,name')->where("state=1")->select();
    	$mblist=M('muban_b')->where("state=1")->select();
    	$this->assign('mlist',$mlist);
    	$this->assign('mblist',$mblist);
    	$this->display();
    }
    //异步获取版本信息
    function addprogram_ajax(){
		//根据模板分类名查询分类id
    	$muban_l=M("muban_l")->where("name='".$_POST["muban_l"]."'")->find();
    	
    	//根据分类id查询属于该分类的所有版本号
    	$muban_b=M("muban_b")->where("state=1 and lid='".$muban_l["id"]."'")->select();
    	
    	//根据分类id查询属于该分类的所有特色
    	$muban_t=M("muban_t")->where("state=1 and lid='".$muban_l["id"]."'")->select();
    	
    	$date=array('k1'=>$muban_b,'k2'=>$muban_t);
    	$this->ajaxReturn($date);
    }
    function addprogram_ajax02(){

    	//$this->ajaxReturn($_POST);
		//根据模板版本号名查找id
	
    	$muban_b=M("muban_b")->where("name='".$_POST["muban_b"]."'")->find();
    	//$this->ajaxReturn($muban_b);
    	//根据分类id查询属于该分类的所有风格
    	$date=M("muban_f")->where("state=1 and bid='".$muban_b["id"]."'")->select();
    	$this->ajaxReturn($date);
    }
    //小程序添加提交审核
    public function addprogram_submit(){
 
 
 
    	$user=M('user_info')->field('id,psw,agency_id')->where(array('name'=>$_POST['name']))->find();
    	$agency=M('jt_user_info')->field('user_id,user_balance')->where(array('user_name'=>$_COOKIE['name_h']))->find();
    	$psw=md5($_POST['psw']);

    	if(!$user||$user['psw']!=$psw){
    		$this->error('账号或密码错误');
    	}else{
    		 $where['user_id']=$user["id"];
			 $where['state']=array('in','2,3');
			 $wq=M("qianyue")->where($where)->find();
			// if(!empty($wq)){
			 if(0){
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
			    	
			    	//模板四个决定条件：模板类型、模板特色、模板型号、模板风格
			    	//模板特色是个数组 store
			    	
			    	$moban_tese=implode(",",$_POST["moban_tese_arr"]);//数组转换成字符串、explode 字符串转换成数组
				  
				    $add=array(
				 	      'appmcheng'=>session('pinfo.appmcheng'),
				 	      'start_id'=>session('pinfo.start_id'),
				 	      'appid'=>session('pinfo.appid'),
				 	      'appsecret'=>session('pinfo.appsecret'),
				 	      'payment'=>session('pinfo.payment'),
				 	      'shanghu_num'=>session('pinfo.shanghu_num'),
				 	      'paykey'=>session('pinfo.paykey'),
				 	      'beian_time'=>time(),
				 	      'end_time'=>strtotime("+1 year"),
				 	      'add_time'=>time(),
				 	      'upd_time'=>time(),
				 	      'state'=>2,
				 	      'contract_id'=>$_POST['contract_id'],
				 	      'contract_img'=>$img,
				 	      'remark'=>$_POST['remark'],
				 	      'year'=>$_POST['years'],
				 	      'muban_price'=>$_POST['price'],
				 	      'muban_type'=>$_POST['muban_lid'],
				 	      'muban_tese'=>$moban_tese,
				 	      'moban_fengge'=>$_POST['muban_fengge'],
				 	      'muban_b'=>$_POST['muban_bid'],
				 	      'user_id'=>$user['id'],
				 	      'agency_id'=>$agency['user_id'],
				 	      
				 	      'function_id'=>implode(",",$_POST["function_list"])
				 	);
				
				 	if(M('qianyue')->add($add)){
				 		//签约表添加申请记录
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
				 		//消费表添加消费记录
				 		M('deal_info')->add($dealadd);
				 		
				 		//服务商扣费
				 		M("jt_user_info")->where("user_name='".$_COOKIE['name_h']."'")->setInc('user_balance',-$_POST['price_add']);
				 		
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
    
    //异步获取小程序风格的图片
    function fengge_img_ajax(){
    	$muban_f=M("muban_f")->where("id='".$_POST["id"]."'")->find();
    	
   	$arr=explode(",",$muban_f["case_img"]);
    //$arr=$muban_f["case_img"];
    //dump($arr);die;
    	$this->ajaxReturn($arr);
    }
    
       //异步获取小程序风格的图片-----11.15.改版
    function ajax_preview(){
    	$a=M("preview")->where("function_id='".$_POST["str"]."'")->find();
    	
   		$arr=explode(",",$a["image"]);

    	$this->ajaxReturn($arr);
    } 
    
}