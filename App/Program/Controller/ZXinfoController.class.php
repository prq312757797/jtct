<?php
namespace Program\Controller;
use Think\Controller;
header('content-type:application:json;charset=utf8'); 
header('Access-Control-Allow-Origin:*'); 
//header('Access-Control-Allow-Methods:POST'); 
header('Access-Control-Allow-Headers:x-requested-with,content-type');
class ZXinfoController extends Controller {
	
	//采购消息、供应消息、平台好消息
	function info_list(){
	//需要小程序id  program_id，和消息属性 style  fenlei_id

		$a=$this->zx_info($style=$_POST["style"],$is_gongyi=0,$program_id=$_POST["program_id"],$fenlei=$_POST["fenlei_id"]);


		$b=M("attribute")->field('id,title')->where("is_show =1 and program_id='".$_POST["program_id"]."'")->select();
		
		$d=M("store")->field("zx_info_list_img")->where("program_id='".$_POST["program_id"]."'")->find();
		
		$c=array('k1'=>$a,'k2'=>$b,'k3'=>$d);
	
		$this->ajaxReturn($c);
	}

	//公益消息
	function gongyi(){
		
		$a=$this->zx_info($style=array('in','1,2,3'),$is_gongyi=1,$program_id=$_POST["program_id"],$fenlei);
	//	dump(M("jt03_zx_info")->_sql());dump($a);die;
		$this->ajaxReturn($a);
	}
	
	//资讯信息接口 is_gongyi
	function zx_info($style,$is_gongyi,$program_id,$fenlei){
		
	$field='
			jt03_zx_info.id,jt03_zx_info.title,jt03_zx_info.num,jt03_zx_info.state,jt03_zx_info.num_contect,jt03_zx_info.num_read,jt03_zx_info.time_agree,jt03_zx_info.image,jt03_zx_info.fenlei01,
			jt03_zx_info.sort,jt03_zx_info.style,jt03_zx_info.area,jt03_zx_info.is_gongyi,
			
			attribute.title as attribute_attribute,
			
			members.head,members.nickname
		';
		$where["state"]=2;
		$where["jt03_zx_info.program_id"]=$program_id;
		$where["style"]=$style;
		$where["is_gongyi"]=$is_gongyi;
		if(!empty($fenlei)){
			$where["jt03_zx_info.fenlei01"]=$fenlei;
		}
	
		$zx_info=M("jt03_zx_info")
		->field($field)
		->join('left join attribute ON attribute.id=jt03_zx_info.fenlei01')
		->join('left join members ON members.openid=jt03_zx_info.openid')
		//->where("jt03_zx_info.state=2 and jt03_zx_info.program_id='".$program_id."'"."and jt03_zx_info.style='".$style."'"."and jt03_zx_info.is_gongyi='".$is_gongyi."'")
		->where($where)
		->order("jt03_zx_info.time_agree desc ")
		->select();
			for($i=0;$i<count($zx_info);$i++){
				$time_lase=time()-$zx_info[$i]["time_agree"];
				if($time_lase<60 ){
					$zx_info[$i]["time_last"]=$time_lase."秒前";
				}else if($time_lase<3600){
					$zx_info[$i]["time_last"]=floor($time_lase/60)."分钟前";
				}else if($time_lase<86400){
					$zx_info[$i]["time_last"]=floor($time_lase/3600)."小时前";
				}else if($time_lase<2592000){
					$zx_info[$i]["time_last"]=floor($time_lase/86400)."天前";
				}
			}
			return $zx_info;
	}	
	
	//资讯分类接口
	function fenlei(){
		//需要小程序id
	
		$a=M("attribute")->field('id,uid,title,sort')->where("is_show=1 and program_id='".$_GET["program_id"]."'" )->order("sort")->select();
	
		//$a[0]["id"]  //分类第一个
	//	DUMP($a);DIE;
		
		$field='
			jt03_zx_info.id ,jt03_zx_info.title,jt03_zx_info.num,jt03_zx_info.state,jt03_zx_info.num_contect,jt03_zx_info.num_read,jt03_zx_info.time_agree,jt03_zx_info.image,jt03_zx_info.fenlei01,
			jt03_zx_info.sort,jt03_zx_info.style,jt03_zx_info.is_gongyi,
			
			attribute.title as attribute_attribute
		';
		$info=M("jt03_zx_info")
		->field($field)
		->join('left join attribute ON attribute.id=jt03_zx_info.fenlei01')
		->where("jt03_zx_info.state=2 and jt03_zx_info.fenlei01='".$a[0]["id"]."'"." and jt03_zx_info.program_id='".$_GET["program_id"]."'")
		->order("jt03_zx_info.time_agree desc")
		->select();
	
	//dump(M("jt03_zx_info")->_sql());dump($info);die;
		$z=array('k1'=>$a,'k2'=>$info);
		$this->ajaxReturn($z);
	}
	
	//分类异步接口
	function ajax_fenlei(){

		$field='
			jt03_zx_info.id,jt03_zx_info.title,jt03_zx_info.num,jt03_zx_info.state,jt03_zx_info.num_contect,jt03_zx_info.num_read,jt03_zx_info.time_agree,jt03_zx_info.image,jt03_zx_info.fenlei01,
			jt03_zx_info.sort,jt03_zx_info.style,jt03_zx_info.is_gongyi,
			
			attribute.title as attribute_attribute
		';
		$info=M("jt03_zx_info")
		->field($field)
		->join('left join attribute ON attribute.id=jt03_zx_info.fenlei01')
		->where("state=2 and jt03_zx_info.fenlei01='".$_POST["id"]."'"." and jt03_zx_info.program_id='".$_POST["program_id"]."'")
		->order("jt03_zx_info.time_agree desc")
		->select();
		
		$this->ajaxReturn($info);
	}
	
	
	//资讯标题模糊搜索
	
	function title_search(){
			$field='
			jt03_zx_info.title,jt03_zx_info.num,jt03_zx_info.state,jt03_zx_info.num_contect,jt03_zx_info.num_read,jt03_zx_info.time_agree,jt03_zx_info.image,jt03_zx_info.fenlei01,
			jt03_zx_info.sort,jt03_zx_info.is_gongyi,jt03_zx_info.style

		';
//is_gongyi  是否是公益(0：不是(默认）、1：是）
		$where["jt03_zx_info.state"]=2;
		$where["jt03_zx_info.program_id"]=$_POST["program_id"];

		$where['_string']='
					(jt03_zx_info.title like "%'.$_POST["str"].'%")  
				';

		$zx_info=M("jt03_zx_info")
		->field($field)
		->join('left join attribute ON attribute.id=jt03_zx_info.fenlei01')
		->where($where)
		->order("jt03_zx_info.time_agree")
		->select();
		
		$this->ajaxReturn($zx_info);
	}


	//信息详情
	function info_con(){
		M("jt03_zx_info")->where("id='".$_GET["id"]."'")->setInc("num_read",1);
		
		//只要得到信息的id 就可以了
		$field='jt03_zx_info.id,jt03_zx_info.openid,jt03_zx_info.title,tel,num,price,integral_tel,fenlei01,integral_contect,time_delivery,
		time_over,area,image,num_read,num_contect,content,state,style,is_gongyi,
		
		attribute.title as attribute_attribute
		';
		$info_con=M("jt03_zx_info")
		->field($field)
		->join('left join attribute ON attribute.id=jt03_zx_info.fenlei01')
		->where("jt03_zx_info.id='".$_GET["id"]."'")
		->find();
		//dump($_GET["openid"]);dump($info_con);dump(M('jt03_zx_info')->_sql());die;
		if($_GET["openid"]==$info_con["openid"]){
			//进来的人是这个消息的拥有者
			$info_con["is_owner"]="1";
		}else{
			$info_con["is_owner"]="2";
		}
		
		
		
		$this->ajaxReturn($info_con);
		
	}
	
	//点击查看联系电话 提示需要积分、（如果已经付过钱了就直接看）     采购的查看电话和留言都要积分，
	function integral_tel(){
		//查询信息购买记录表，需要这个人的openid， program_id  state(state=1:查看电话、state=3：要发布留言)

	$qianyue=M("qianyue")->where("program_id='".$_POST["program_id"]."'")->find();
//	dump($_POST["program_id"]);
//	dump($qianyue);die;
	if($qianyue["muban_type"]==1){
//商城版=================		
	$info=M("goods")->where("id='".$_POST["goods_id"]."'")->find();

		$where["openid"]=$_POST["openid"];
		$where["program_id"]=$_POST["program_id"];
		$where["goods_id"]=$_POST["goods_id"];
		$where["state"]=$_POST["state"];//$_PSOT["state"]  state=1:查看电话、state=3：要发布留言
		$haved_pay=M("jt03_zx_record_xf")->where($where)->find();

		if(empty($haved_pay)){
					
					//没有买电话或者留言资格的都会提示
					$date=array('status'=>-1,'msg'=>'该信息未被当前用户购买，弹出询问是否购买modal');
				}else{
						
					if($_POST["state"]==1){
							$date=array('status'=>1,'msg'=>'信息已购买，弹出联     系方式层 ');
						}else if($_POST["state"]==3){
							$date=array('status'=>2,'msg'=>'信息已购买，弹出联     打开留言页面');
						}
			}

	}else if($qianyue["muban_type"]==5){
//资讯版=================			
$info=M("jt03_zx_info")->where("id='".$_POST["zx_info_id"]."'")->find();
		
		if($info["style"]==1){
			//采购信息查看电话需要积分
			
				$where["openid"]=$_POST["openid"];
				$where["program_id"]=$_POST["program_id"];
				$where["zx_info_id"]=$_POST["zx_info_id"];
				$where["state"]=$_POST["state"];//$_PSOT["state"]  state=1:查看电话、state=3：要发布留言
				$haved_pay=M("jt03_zx_record_xf")->where($where)->find();
		//	dump($haved_pay);dump(M("jt03_zx_record_xf")->_sql());die;
				if(empty($haved_pay)){
					
					//没有买电话或者留言资格的都会提示
					$date=array('status'=>-1,'msg'=>'该信息未被当前用户购买，弹出询问是否购买modal');
				}else{
						M("jt03_zx_info")->where("id='".$_POST["zx_info_id"]."'")->setInc("num_contect",1);
					if($_POST["state"]==1){
							$date=array('status'=>1,'msg'=>'信息已购买，弹出联     系方式层 ');
						}else if($_POST["state"]==3){
							$date=array('status'=>2,'msg'=>'信息已购买，弹出联     打开留言页面');
						}
			}
			
		}else if($info["style"]==2){
			//供应信息查看电话不需要积分
				M("jt03_zx_info")->where("id='".$_POST["zx_info_id"]."'")->setInc("num_contect",1);
			if($_POST["state"]==1){
				$date=array('status'=>1,'msg'=>'信息已购买，弹出联     系方式层 ');
			}else if($_POST["state"]==3){
				$date=array('status'=>2,'msg'=>'信息已购买，弹出联     打开留言页面');
			}
			
			
		}else if($info["style"]==3){
			//平台好消息   购买的是一次性的电话
		M("jt03_zx_info")->where("id='".$_POST["zx_info_id"]."'")->setInc("num_contect",1);
			if($_POST["state"]==1){
				$date=array('status'=>1,'msg'=>'信息已购买，弹出联     系方式层 ');
			}else if($_POST["state"]==3){
				$date=array('status'=>2,'msg'=>'信息已购买，弹出联     打开留言页面');
			}
		}
	}else if($qianyue["muban_type"]==6){
//服务版=================			

	}
		

		$this->ajaxReturn($date);
	}
		
	//确认购买发布者手机号    购买发消息资格
	function make_sure_pay_01(){
		//需要得到购买者的 openid,program_id,zx_info_id,state=1:查看电话，3：获得留言资格
	//	$info=M("jt03_zx_info")->where("id='".$_POST["zx_info_id"]."'")->find();//需要得到要扣多少积分
		
		$info["integral_tel"]=10;//查看电话积分
		$info["integral_contect"]=10;//留言资格积分
		
		//再看看这个人的积分够不够，不够就返回提示积分不足，打断继续的操作
		$members=M("members")->where("openid='".$_POST["openid"]."'"." and  program_id='".$_POST["program_id"]."'")->find();
		
		if($_POST["state"]==1){
			$integral=$info["integral_tel"];
		}else if($_POST["state"]==3){
			$integral=$info["integral_contect"];
		}
		//dump($integral);dump($menbers["integral"]);dump($members);die;
			$integral_total=$members["integral"]+$members["integral_song"];
		if(	$integral_total<$integral){
			$this->ajaxReturn(array('state'=>-1,'msg'=>'用户积分不足'));
		}else{
			//积分够了，可以写入购买记录并且扣积分了
			$can_pay["openid"]=$_POST["openid"];
			$can_pay["program_id"]=$_POST["program_id"];
			$can_pay["zx_info_id"]=$_POST["zx_info_id"];
			$can_pay["state"]=$_POST["state"];
			
			
			$can_pay["time"]=time();
			$can_pay["record"]=$integral;
			
			if(M("jt03_zx_record_xf")->add($can_pay)){
				if($members["integral_song"]>$integral or $members["integral_song"]==$integral){
					M("members")->where("openid='".$_POST["openid"]."'"."and  program_id='".$_POST["program_id"]."'")->setInc('integral_song',-$integral);
				
				}else if($members["integral_song"]<$integral or $members["integral_song"]>0){
					$end_c=$integral-$members["integral_song"];
					M("members")->where("openid='".$_POST["openid"]."'"."and  program_id='".$_POST["program_id"]."'")->setInc('integral_song',-$members["integral_song"]);
					M("members")->where("openid='".$_POST["openid"]."'"."and  program_id='".$_POST["program_id"]."'")->setInc('integral',-$end_c);
				}else if($members["integral_song"]<0 or $members["integral"]>$integral){
					M("members")->where("openid='".$_POST["openid"]."'"."and  program_id='".$_POST["program_id"]."'")->setInc('integral',-$integral);
				}
					$this->ajaxReturn(array('state'=>1,'msg'=>'购买成功'));
			}else{
				$this->ajaxReturn(array('state'=>2,'msg'=>'购买失败'));
			}
		}
	}

	//资讯发布页面
	function info_set(){
		//需要小程序id
		$store=M("store")->field('zx_enter_img')->where("program_id='".$_POST["program_id"]."'")->find();
		
		$attribute=M("attribute")->where("is_show=1 and program_id='".$_POST["program_id"]."'")->select();
		
		$str="JT".rand(1111111111,99999999999);
		$z=array('k1'=> $store,'k2'=>$attribute,'k3'=>$str);
		
		$this->ajaxReturn($z);
	}
	
	//资讯提交按钮
	function info_submit(){	
		$receive=$_POST;
		if(empty($receive["openid"])){
			$this->ajaxReturn(array('state'=>-999,'msg'=>'openid缺失'));
		}
		if(empty($receive["program_id"])){
			$this->ajaxReturn(array('state'=>-999,'msg'=>'program_id缺失'));
		}
			$integral_contect=10;//发布需要积分
			
		$members=M("members")->where("openid='".$_POST["openid"]."'"." and  program_id='".$_POST["program_id"]."'")->find();
		//发布供应需要消耗积分
		$integral_total=$members["integral"]+$members["integral_song"];
		if($receive["style"]==2){
			if(	$integral_total<$integral_contect){
				$this->ajaxReturn(array('state'=>-1,'msg'=>'用户积分不足'));
			}
		}		
		 $upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =     3145728 ;// 设置附件上传大小
			    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录

			// 上传文件 //  style1:采购信息、2：供应信息、3：平台好消息
			     $info   =   $upload->upload();
			 if($info){
				$receive['image']=$info["image"]['savepath'].$info["image"]['savename'];
				$receive['state']="1";//待审
				$receive['time_input']=time();			
				//1025...23.33 建立临时数据表，传好了就等待拼接
				$receive["on_time"]=time().rand("1111","9999");
				if(M('jt03_zx_info_copy')->add($receive)){ 
				
							$this->ajaxReturn(array('state'=>1,'msg'=>'成功'));
							    }else{
							$this->ajaxReturn(array('state'=>-1,'msg'=>'失败'));
					}	
		
			 }else{
			 	//无图片===============================================================
			 	
			 	if(M('jt03_zx_info')->add($receive)){
						$this->ajaxReturn(array('state'=>1,'msg'=>'成功'));
					}else{
						$this->ajaxReturn(array('state'=>-1,'msg'=>'失败'));
					}	
			 }
	}
	
	//临时表数据拼接之后加入正式信息表
	function temp_info($only_num){
		$only_num=M("jt03_zx_info")->where("only_num='".$only_num."'")->find();	
					
		$only_num01=M("jt03_zx_info_copy")
					->field("image,only_num")
					->where("only_num='".$only_num."'")->select();
						if(empty($only_num)){
								M("jt03_zx_info")->add($only_num01[0]);
						}else{
							for($i=1;$i<count($only_num01);$i++){
									$save01["image"]=$only_num["image"].",".$only_num01[$i]['image'];		
									M("jt03_zx_info")->where("only_num='".$receive['only_num']."'")->save($save01);
							}
						
		}
		return 1;
	}
	
	//执行信息正式数据添加
	function info_set_ready(){
		$only_num=M("jt03_zx_info")->where("only_num='".$_POST["only_num"]."'")->find();	
					
		$field='program_id,openid,object,title,tel,num,state,style,price,fenlei01,fenlei02,integral_tel,
		integral_contect,time_delivery,time_over,time_input,time_say_no,time_agree,area,image,num_read,
		num_contect,content,sort,is_gongyi,only_num,input_info_num
		';			
		$only_num01=M("jt03_zx_info_copy")
					->field($field)
					->where("only_num='".$_POST["only_num"]."'")->select();
			
		if(empty($only_num)){
			if(M("jt03_zx_info")->add($only_num01[0])){
				
				$only_num02=M("jt03_zx_info")->where("only_num='".$_POST["only_num"]."'")->find();	
				
				for($i=0;$i<count($only_num01);$i++){
					$save01["image"].=$only_num01[$i]['image'].",";		
				}	
				
				$save01['image'] = substr($save01['image'],0,strlen($save01['image'])-1);
				M("jt03_zx_info")->where("only_num='".$_POST["only_num"]."'")->save($save01);	
								
				//个人扣积分
			$members=	M("members")->where("program_id='".$_POST['program_id']."'"."and openid='".$_POST['openid']."'")->find();						

				$integral_contect=10;
						if($only_num01[0]["style"]==2){
								if($members["integral_song"]>$integral_contect or $members["integral_song"]==$integral_contect){
									M("members")->where("openid='".$_POST["openid"]."'"."and  program_id='".$_POST["program_id"]."'")->setInc('integral_song',-$integral_contect);
								
								}else if($members["integral_song"]<$integral_contect or $members["integral_song"]>0){
									$end_c=$integral_contect-$members["integral_song"];
									M("members")->where("openid='".$_POST["openid"]."'"."and  program_id='".$_POST["program_id"]."'")->setInc('integral_song',-$members["integral_song"]);
									M("members")->where("openid='".$_POST["openid"]."'"."and  program_id='".$_POST["program_id"]."'")->setInc('integral',-$end_c);
								}else if($members["integral_song"]<0 or $members["integral"]>$integral_contect){
									M("members")->where("openid='".$_POST["openid"]."'"."and  program_id='".$_POST["program_id"]."'")->setInc('integral',-$integral_contect);
								}
							}
				
									
						$this->ajaxReturn(array('state'=>1,'msg'=>'成功'));
					}else{
						$this->ajaxReturn(array('state'=>-1,'msg'=>'失败'));
			}							
		}
	}
	
	//资讯删除  数据删除、物理图片删除
	function info_delete(){
		//需要那条信息的id  个人openid（验证身份）
		$info=M("jt03_zx_info")->where("id='".$_POST["id"]."'"." and openid='".$_POST["opneid"]."'")->find();
		if(M("jt03_zx_info")->where("id='".$_POST["id"]."'"." and openid='".$_POST["opneid"]."'")->delete()){		
				$arr=explode(",",$info["image"]);
				for($i=0;$i<count($arr);$i++){
					unlink('./Uploads/'.$arr[$i]);
				}
		
				$this->ajaxReturn(array('state'=>1,'msg'=>'成功'));
			}else{
				$this->ajaxReturn(array('state'=>-1,'msg'=>'失败'));
			}			
		
		
	}
	
	//资讯对话页面
	function session_page(){
		//能打开这个页面的，有两个入口，1：信息详情、2：个人中心的个人聊天，都能得到这三个数据
		//能打开这个页面的，就说明自己要不是查看者，要不就是信息发布者，
		// program_id  openid  zx_info_id  openid_talk 
		
		//头部项目信息
		$field='
			jt03_zx_info.title,num,fenlei01,time_agree,jt03_zx_info.openid,
		
			attribute.title as attribute_attribute,
			
			members.head,members.nickname
		';
		$info=M("jt03_zx_info")
		->field($field)
		->join('left join attribute ON attribute.id=jt03_zx_info.fenlei01')
		->join('left join members ON members.openid=jt03_zx_info.openid')
		->where("jt03_zx_info.id='".$_POST["zx_info_id"]."'")
		->find();
	
		if($info["openid"]==$_POST["openid"]){
			//属于自己的内容 ，在手机端显示在右边===============================

			//现在进来的就是这个消息的发布者，所以主要就是回复 content_from=1 的就是当前人的  
			//content_from=1  的消息在右边
			$session=$this->session_con($program_id=$_POST["program_id"],$openid_open=null,$openid_owner=$_POST["openid"],$zx_info_id=$_POST["zx_info_id"],$content_from=1,$openid_talk=$_POST["openid_talk"]);
			
		}else{
			//现在进来的就是这个消息的查看者  content_from=2 的就是当前人的
			//content_from=2  的消息在右边
			$session=$this->session_con($program_id=$_POST["program_id"],$openid_open=$_POST["openid"],$openid_owner=null,$zx_info_id=$_POST["zx_info_id"],$content_from=2,$openid_talk=$_POST["openid_talk"]);
			
		}

		$z=array('k1'=>$info,'k2'=>$session);
	//	dump($z);dump(M("jt03_zx_session")->_sql());
	//	die;
		$this->ajaxReturn($z);
		
	}
	function session_con($program_id,$openid_open,$openid_owner,$zx_info_id,$content_from,$openid_talk){
			//对话框内容  $content_from 等于多少，多少就在右边
				//  content_from  内容来源：1：信息发布者、2：信息查看者   openid_owner:信息拥有者    openid_open：信息查看者
				
				
				if($openid_owner==null){
					//查看者进来的
					$field02='
					jt03_zx_session.id,	jt03_zx_session.time,jt03_zx_session.content,jt03_zx_session.content_from,openid_owner,openid_open,
				
					members.nickname as nickname_open,members.head as head_open

				';
					$session=M("jt03_zx_session")
					->field($field02)
					->join('members ON members.openid=jt03_zx_session.openid_open ')
					->where("jt03_zx_session.program_id='".$program_id."'"." and jt03_zx_session.zx_info_id='".$zx_info_id."'"." and jt03_zx_session.openid_open='".$openid_open."'"." and jt03_zx_session.openid_owner='".$openid_talk."'")	
					->order("jt03_zx_session.time desc")
					->select();
					
					
					for($u=0;$u<count($session);$u++){
						$openid_open=M("members")->where("openid='".$session[$u]["openid_owner"]."'")->find();
						$session[$u]["nickname_owner"]=$openid_open["nickname"];
						$session[$u]["head_owner"]=$openid_open["head"];
					}
					
					//dump(11);dump($session);
				}
				if($openid_open==null){
					//信息拥有者进来的
					$field02='
				jt03_zx_session.id,	jt03_zx_session.time,jt03_zx_session.content,jt03_zx_session.content_from,openid_owner,openid_open,
				
					members.nickname as nickname_owner,members.head as head_owner

				';
					$session=M("jt03_zx_session")
					->field($field02)
					->join('members ON members.openid=jt03_zx_session.openid_owner ')
					->where("jt03_zx_session.program_id='".$program_id."'"." and jt03_zx_session.zx_info_id='".$zx_info_id."'"." and jt03_zx_session.openid_owner='".$openid_owner."'"." and jt03_zx_session.openid_open='".$openid_talk."'")	
					->order("jt03_zx_session.time desc")
					->select();
					
					for($u=0;$u<count($session);$u++){
						$openid_open=M("members")->where("openid='".$session[$u]["openid_open"]."'")->find();
						$session[$u]["nickname_open"]=$openid_open["nickname"];
						$session[$u]["head_open"]=$openid_open["head"];
					}
				//	dump(22);dump($session);
				}
			
				for($i=0;$i<count($session);$i++){

			
					
			$man_self;//当前人的信息
			$man_talk;//和当前人对话的人
					
					if($content_from==1){
						//信息是拥有者的
						if($session[$i]["content_from"]==$content_from){
							$session[$i]["show_rignt"]="是自己的内容，显示在右边，右边渲染 nickname_owner，head_owner";
							$session[$i]["is_show_right"]="1";
						}else{
							$session[$i]["show_rignt"]="不是自己的内容，显示在左边，左边渲染 nickname_open，head_open";
							$session[$i]["is_show_right"]="2";
						}
					}else{
						//信息是查看者的
						if($session[$i]["content_from"]==$content_from){
							$session[$i]["show_rignt"]="是自己的内容，显示在右边，右边渲染 nickname_open，head_open";
							$session[$i]["is_show_right"]="1";
						}else{
							$session[$i]["show_rignt"]="不是自己的内容，显示在左边，左边渲染 nickname_owner，head_owner";
							$session[$i]["is_show_right"]="2";
						}
					}
				}
			return $session;
		
	}
	
	
	//异步显示最最新信息的接口  每隔一段时间（1秒）------------暂时不做1019...17.24
/*	function ajax_session(){
		//program_id openid zx_info_id  还需要最后一条显示了的信息的id
		//先判断请求接口的人和这个消息的关系，来确定消息到底返回去显示左边还是右边
		
		$info=M("jt03_zx_info")->where("id='".$_POST["openid"]."'")->find();
		
		if($info["openid"]==$_POST["openid"]){
			//进来的人是信息拥有者  
			M("jt03_zx_session")->where()->find();
			
		}else{
			//进来的人是信息查看着者 
		}	
		
	}*/
	
	//对话框内容提交
    function session_submit(){
        //opneid program_id content  zx_info_id openid_talk 必须是纯文字 和 纯图片图片就一张一张来

        $receive=I();

if(empty($_POST["openid"])){
	$this->ajaxReturn(array('state'=>-999,'msg'=>'openid 缺失'));
}
if(empty($_POST["program_id"])){
	$this->ajaxReturn(array('state'=>-888,'msg'=>'program_id 缺失'));
}
        $info=M("jt03_zx_info")->where("id='".$_POST["zx_info_id"]."'")->find();
        if($info["openid"]=="0"){
            //openid 是零的就是平台好消息
            $receive["openid_owner"]="0";//信息所有人的openid
        }else{
            $receive["openid_owner"]=$info["openid"]; //信息所有人的openid
        }
        
        if($_POST["openid"]==$info["openid"]){
        	$receive["openid_open"]=$_POST["openid_talk"];//查看人openid
        }else{
        	 $receive["openid_open"]=$_POST["openid"];//查看人openid
        }
       
        $receive["time"]=time();                 //  提交时间

        $receive["time_del"]=time()+2592000;    //一个月之后，消息设置删除

        if($_POST["openid"]==$info["openid"]){
            //当前openid 就是发布信息的openid  所以现在发消息的来源就是本人发的
            $receive["content_from"]="1";//1：信息发布者、2：信息查看者
        }else{
            $receive["content_from"]="2";//1：信息发布者、2：信息查看者 
        }

        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录

        // 上传文件 //  style1:采购信息、2：供应信息、3：平台好消息
        $info   =   $upload->upload();
        if($info){
            //有图片  单独存一张图片===============================================================

                $receive['content']=$info["content"]['savepath'].$info["content"]['savename'];
                $receive['time']=time();
        }else{
            //没有图片===============================================================

        }
        if(M("jt03_zx_session")->add($receive)){
            $date=array('state'=>1,'msg'=>'添加成功');
        }else{
            $date=array('state'=>-1,'msg'=>'添加失败');
        }
        $this->ajaxReturn($date);
    }
    
    //我的消息列表页
    function my_session(){
    	//program_id  openid   我的消息列表页实际上就是项目的列表页 
    	
/*$condition['jt03_zx_session.openid_owner'] = $_POST["openid"];
$condition['jt03_zx_session.openid_open'] = $_POST["openid"];
$condition['_logic'] = 'OR';
*/	
	//自己的信息的对话 content_from
	
	$condition['program_id'] = $_POST["program_id"];
$condition['_query'] = "openid_owner=".$_POST["openid"]."&openid_open=".$_POST["openid"]."&_logic=or";
	
 $info_1=M("jt03_zx_session")->where($condition)->group('zx_info_id,openid_owner,openid_open')->order("time desc")->select();
//dump(M("jt03_zx_session")->_sql());
 
 	for($i=0;$i<count($info_1);$i++){
 		
 		$field='jt03_zx_info.id,jt03_zx_info.title,fenlei01,
		
		attribute.title as attribute_attribute,
		
		members.head,members.nickname
		';
		$info_con=M("jt03_zx_info")
		->field($field)
		->join('left join attribute ON attribute.id=jt03_zx_info.fenlei01')
		->join('left join members ON members.openid=jt03_zx_info.openid')
		->where("jt03_zx_info.id='".$info_1[$i]["zx_info_id"]."'")->find();

 		$info_1[$i]["info"]=$info_con;//消息的基本信息
 		
 		if($info_1[$i]["openid_owner"]==$_POST["openid"]){
 			//如果消息是这个人的，会有一个对话人头像

			$info_1[$i]["talk_info"]=M("members")->field('head,nickname')->where("program_id='".$_POST["program_id"]."'"."and openid='".$info_1[$i]["openid_open"]."'")->find();
 		}else{
 			//这个消息不是这个人的
 			if($info_1[$i]["openid_owner"]!="0"){
 				//得到对话人的头像昵称
 				$info_1[$i]["talk_info"]=M("members")->field('head,nickname')->where("program_id='".$_POST["program_id"]."'"."and openid='".$info_1[$i]["openid_owner"]."'")->find();
 			
 			}else{
 				$info_1[$i]["talk_info"]="平台管理员";
 			}
 		
 		}
 	}

    	$z=array('k1'=>$info_1);
//dump($z);die;
    	$this->ajaxReturn($z);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
}
?>