<?php
namespace Program\Controller;
use Think\Controller;
header('content-type:application:json;charset=utf8'); 
header('Access-Control-Allow-Origin:*'); 
//header('Access-Control-Allow-Methods:POST'); 
header('Access-Control-Allow-Headers:x-requested-with,content-type');

class GoodsShowController extends Controller {
//CommonController

    //显示商品列表 商品状态（1：在售、2：售罄、3：仓库中）

    //需要参数  小程序id 、商品状态
	public function goods_show(){
		$where=array(
			'program_id'=>$_GET["program_id"],
		
			'goods_state'=>$_GET["goods_state"]
		);
		//两个字段的模糊搜索  str=》id、名称    str_f=》分类
		 if(isset($_POST['str'])){
				$str=$_POST['str'];     //如果接收到搜索关键字,执行模糊查询 返回数据
				
				//模糊查询 id、名称、编号、条码、商户名称
				$where['_string']='
					(id like "%'.$str.'%")  
					OR (goods_title like "%'.$str.'%")
				';
				$list=M("goods")
				->field('id,sort,image,goods_title,goods_state,price_sell,fenlei_1,fenlei_2')
				->where($where)
				->select();//对id、名称的模糊搜索
		
			}else if(isset($_POST['str_f'])){
			//根据商品分类的id查询 商品列表	
			$list= M("goods")->query("
				select * from 
				goods 
				left outer join  
				( select * from attribute where id='".$_POST['str_f']."'"."  ) c 
				on goods.id=c.goods_id
				where goods.program_id='".$_GET["program_id"]."'"." and goods.id='".$_GET["goods_state"]."'"." 	
			");
			
			}else{
				$list=M("goods")
				->field('id,image,sort,goods_title,goods_state,price_sell,fenlei_1,fenlei_2')
				->where($where)
				->select();
			}
			
				for($i=0;$i<count($list);$i++){
					/*$a["goods_id"]=$list[$i]["id"];
					$b=M("goods_img")->where($a)->find();
					$list[$i]["image"]=$b["image"];*/
					
					$arr1102=explode(",",$list[$i]['image']);
			$list[$i]["image"]=$arr1102[0];
				}
		
		//获取商品属性      -------根据小程序id 查询小程序表 在里面得到小程序属于什么类的小程序，再查对应的属性表
		$shuxign_lei=M("muban")->where("program_id='".$_GET["program_id"]."'")->find();
		$shuxing_list=M("shuxing")->where("banbenleixing_type='".$shuxign_lei["muban_type"]."'")->select();
		
		$all=array('k1'=>$list,'k2'=>$shuxing_list);
		
		//dump($all);die;
		$this->ajaxReturn($all);
	}
	
	//商品添加、修改按钮
	public function goods_add(){
		//需要一个页面随机数 判断不重复插入数据 only_num
		if(empty($_POST["program_id"])){
			$this->ajaxReturn($data=array('status'=>11,'msg'=>'非法上传'));
		}
	
			$_POST["time_set"]=time();
			$y1=$_POST["canshu_title"];//参数名数组
			$y2=$_POST["canshu_con"];//参数值数组

				$upload = new \Think\Upload();// 实例化上传类
			  	$upload->maxSize   =  3145728 ;// 设置附件上传大小
			    $upload->exts      =  array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =   './Uploads/'; // 设置附件上传根目录
			    // 上传文件 
			    $info   =   $upload->upload();
			  
			    if($info){
			   		//有上传图片的地方进来
			   		if(!empty($info['image01'])){
			   		  $receive01['image']=$info['image01']['savepath'].$info['image01']['savename'];
			   		}
			   		if(!empty($info['image02'])){
	                $receive02['image']=$info['image02']['savepath'].$info['image02']['savename'];
					}
				   		if(!empty($info['image03'])){
					$receive03['image']=$info['image03']['savepath'].$info['image03']['savename'];
					}
				   		if(!empty($info['image04'])){
					$receive04['image']=$info['image04']['savepath'].$info['image04']['savename'];
					}
				   		if(!empty($info['image05'])){
					$receive05['image']=$info['image05']['savepath'].$info['image05']['savename'];
					}
			if(empty($_POST["id"])){
				//没有传递 id  执行添加操作
		
				$only=M("goods")->where("time_set='".$_POST["time_set"]."'")->find();
				if(empty($only)){
					
				//	$w=array('k1'=>$_POST,'K1'=>$receive01,'K2'=>$receive02,'K3'=>$receive03,'K4'=>$receive04,'K5'=>$receive05);
					//$this->ajaxReturn($w);
					if(M("goods")->add($_POST)){
						$set_img=M("goods")->where("time_set='".$_POST["time_set"]."'")->find();
					
						$receive01["goods_id"]=$set_img["id"];
							$receive01["img_input_name"]="image01";
							$receive01["program_id"]=$_POST["program_id"];
						$receive02["goods_id"]=$set_img["id"];
							$receive02["img_input_name"]="image02";
							$receive02["program_id"]=$_POST["program_id"];
						$receive03["goods_id"]=$set_img["id"];
							$receive03["img_input_name"]="image03";
							$receive03["program_id"]=$_POST["program_id"];
						$receive04["goods_id"]=$set_img["id"];
							$receive04["img_input_name"]="image04";
							$receive04["program_id"]=$_POST["program_id"];
						$receive05["goods_id"]=$set_img["id"];
							$receive05["img_input_name"]="image05";
							$receive05["program_id"]=$_POST["program_id"];
							
							for($o=0;$o<count($y1);$o++){
								$a1[$o]["goods_id"]=$set_img["id"];
								
								$a1[$o]["title"]=$y1[$o];
								$a1[$o]["content"]=$y2[$o];
								
								M("specifications")->add($a1[$o]);//商品参数
							}
						if(!empty($info['image01'])){
							M("goods_img")->add($receive01);
						}
						if(!empty($info['image02'])){
						M("goods_img")->add($receive02);
							}
						if(!empty($info['image03'])){
						M("goods_img")->add($receive03);
							}
						if(!empty($info['image04'])){
						M("goods_img")->add($receive04);
							}
						if(!empty($info['image05'])){
						M("goods_img")->add($receive05);
							}
					
					$this->ajaxReturn($data=array('status'=>1,'msg'=>'添加成功'));
					}else{
						$this->ajaxReturn($data=array('status'=>2,'msg'=>'添加失败'));
					}		
				}
	
			 }else{
			 	//传递了id 执行修改操作 
			 		$w["goods_id"]=$_POST["id"];
			 	
			 		$w1["goods_id"]=$_POST["id"];
			 			$w1["img_input_name"]="image01";
			 		$w2["goods_id"]=$_POST["id"];
			 			$w2["img_input_name"]="image02";
			 		$w3["goods_id"]=$_POST["id"];
			 			$w3["img_input_name"]="image03";
			 		$w4["goods_id"]=$_POST["id"];
			 			$w4["img_input_name"]="image04";
			 		$w5["goods_id"]=$_POST["id"];
			 			$w5["img_input_name"]="image05";
			 		if(M("goods")->where($w)->save($_POST)){
			 			
				for($o=0;$o<count($y1);$o++){
						$a12["goods_id"]=$_POST["id"];
								
						$a1[$o]["title"]=$y1[$o];
						$a1[$o]["content"]=$y2[$o];
								
						M("specifications")->where($a12)->save($a1[$o]);
					} 			
					if(!empty($info['image01'])){
								M("goods_img")->where($w1)->save($receive01);
							}
						if(!empty($info['image02'])){
							M("goods_img")->where($w2)->save($receive02);
							}
						if(!empty($info['image03'])){
							M("goods_img")->where($w3)->save($receive03);
							}
						if(!empty($info['image04'])){
						M("goods_img")->where($w4)->save($receive04);
							}
						if(!empty($info['image05'])){
						M("goods_img")->where($w5)->save($receive05);
							}
			 			
					
					
						
						
						$this->ajaxReturn($data=array('status'=>3,'msg'=>'修改成功'));
			 		}else{
			 			$this->ajaxReturn($data=array('status'=>4,'msg'=>'修改失败'));
			 		}
			 }
				//	M("store")->where("program_id='".$_POST['program_id']."'")->save($receive);
					$data=array('status'=>1,'msg'=>'修改成功');
			    }else{
			    	//没有上传图片的地方进来
			   		//没图片上传不存在添加操作，每个商品建立必须传入一张图片
			 		//传递了id 执行修改操作
			 	
			 		$w["goods_id"]=$_POST["id"];
			 		if(M("goods")->where($w)->save($_POST)){
			 			
			 			for($o=0;$o<count($y1);$o++){
						$a12["goods_id"]=$_POST["id"];
								
						$a1[$o]["title"]=$y1[$o];
						$a1[$o]["content"]=$y2[$o];
								
						M("specifications")->where($a12)->save($a1[$o]);
					} 
			 		
						$this->ajaxReturn($data=array('status'=>5,'msg'=>'修改成功'));
			 		}else{
			 			$this->ajaxReturn($data=array('status'=>6,'msg'=>'修改失败'));
			 		}
			 
                    $error=$upload->getError();
		    		$data=array("status" => -1, "msg" => "无图片上传",'error'=>$error);
			   }	
	}
	//商品修改页面内容获取    需要获得小程序id、商品id
	public function goods_up_list(){

		$a["program_id"]=$_GET["program_id"];
		
	
		//===============商品属性=======================================
		$shuxing=M("shuxing")->field('id,shuxing_name')->where("program_id='".$_GET["program_id"]."'" )->select();
		
		
		//===============商品分类=======================================
		$fl=M("attribute")->field('id,uid,title')->where("is_show=1 and program_id='".$_GET["program_id"]."'" )->select();
		$fenlei=$this->bq($fl);
		
		//===============商品默认标签组===================================
		$biaoqian=M("label")->where("program_id='".$_GET["program_id"]."'" )->field('id,label_name')->select();
		
		//===============商品基本信息=====================================
		if(!empty($_GET["goods_id"])){
			$a["id"]=$_GET["goods_id"];
			
			$list=M("goods")
			->where($a)
			->find();

			$where["goods_id"]=$list["id"];
			
			//查询商品图片
			$img=M("goods_img")
			->field('id,sort,image,img_input_name')
			->where($where)->order("sort")->select();
			$list["image_list"]=$img;
		}
		
		
		$e=array('k1'=> $shuxing,'k2'=>$fenlei,'k3'=>$biaoqian,'k4'=>$list);//分类列表、商品列表

		$this->ajaxReturn($e);
	}
	
	
	//商品  分类列表
	public function goods_fl(){
		$fl=M("attribute")
		->field('id,uid,title,image_1,is_show')
		->where("program_id='".$_GET["program_id"]."'" )
		->select();
		$fenlei=$this->bq($fl);
		
		
		$this->ajaxReturn($fenlei);
	}
	
	//商品分类页面打开
	public function fenlei_edit(){
		//三种情况   页面有一个上级分类的input， 如果是提交主分类，上级分类不显示，设置uid=0
		//如果是点击添加子分类，这个input显示的是上级分类的名称、  uid 的值是上级分类的id
		
		//如果是点击修改进来的，就正常渲染，没有其他的内容  用is_action 定位是点击修改进来还是点击添加进来 1：添加、2：修改
		//在添加操作里面  使用  is_up 表示是主级添加还是子级添加， 1：主级、2：子级
		if($_GET["is_action"]==1){
			//点击添加进来的
			if(empty($_GET["id"])){
				//是添加主级操作，设置uid=0 ，主级id input不显示
				$date["uid"]=0;
				$date["up_name"]=0;
			}else{
				//执行添加子级  uid=$_GET["id"]  input 显示主级名
				$date["uid"]=$_GET["id"];
				
				$zhuji_name=M("attribute")->where("id='".$_GET["id"]."'")->find();
				$date["up_name"]=$zhuji_name["title"];
			}
		}else{
			//点击修改进来的   带着id进来的，是主级就不显示 上级名称
			$date=M("attribute")->where("id='".$_GET["id"]."'")->find();
		
			if($date["uid"]!=0){
				$e=M("attribute")->where("id='".$date["uid"]."'")->find();
				$date["up_name"]=$e["title"];
			}else{
				$date["up_name"]=0;
			}
		}
		 $this->ajaxReturn($date);
	}
	//商品分类添加  提交
	public function edit_fl(){
		$date=array(
			'program_id'=>$_POST["program_id"],
			'sort'=>$_POST["sort"],
			'title'=>$_POST["title"],
			'uid'=>$_POST["uid"],
			'image_1'=>$_POST["image_1"],
			'miaoshu'=>$_POST["miaoshu"],
			'is_show'=>$_POST["is_show"]
		);
		$upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =  3145728 ;// 设置附件上传大小
			    $upload->exts      =  array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =   './Uploads/'; // 设置附件上传根目录
			    // 上传文件 
			    $info   =   $upload->upload();
			  
			if($info){
			    	//有图片上传
				if(empty($_POST["id"])){
							// 没有传递id 值， 执行添加操作
						
							$date['image_1']=$info['image_1']['savepath'].$info['image_1']['savename'];
				
							if(M("attribute")->add($date)){
								$dat=array('status'=>1,'msg'=>'添加成功');	
							}else{
								$dat=array('status'=>2,'msg'=>'添加失败');
							}
						}else{
						
							$date['image_1']=$info['image_1']['savepath'].$info['image_1']['savename'];
						
							//传递了id 值，执行修改操作
							if(M("attribute")->where("id='".$_POST["id"]."'")->save($date)){
								$dat=array('status'=>1.1,'msg'=>'修改成功');	
							}else{
								$dat=array('status'=>2.2,'msg'=>'修改失败');
							}
						}
			    }else{
			    	//没有图片上传
			    	
			    	if(empty($_POST["id"])){
							// 没有传递id 值， 执行添加操作
				
							if(M("attribute")->add($date)){
								$dat=array('status'=>10,'msg'=>'添加成功');	
							}else{
								$dat=array('status'=>20,'msg'=>'添加失败');
							}
						}else{
							//传递了id 值，执行修改操作
							
							if(M("attribute")->where("id='".$_POST["id"]."'")->save($date)){
								$dat=array('status'=>101,'msg'=>'修改成功');	
							}else{
								$dat=array('status'=>201,'msg'=>'修改失败');
							}
						}
                    $error=$upload->getError();
		       
			    }
		
		$this->ajaxReturn($dat);
		
	}
	
	//=================会员概述
	public function member_l(){
		//=================会员概述
	
/*	$aa["name"]=date("Y-m-d H:i:s",time()).rand(1,999);
	M("test")->add($aa);*/

		//今天 凌晨
		$q1=date('Y-m-d 00:00:00' , time());
		//昨天凌晨
		$q2=date('Y-m-d 00:00:00' , strtotime("-1 day"));
		//七天前凌晨
		$q3=date('Y-m-d 00:00:00' , strtotime("-7 day"));


		$a=$this->be(strtotime($q1),$_GET["program_id"]);

		$b=$this->be(strtotime($q2),$_GET["program_id"]);
		$c=$this->be(strtotime($q3),$_GET["program_id"]);

		$e=array('k1'=> $a,'k2'=>$b,'k3'=>$c);//会员数统计、今天、昨天、一周内

		$this->ajaxReturn($e);
	}
	function be($str,$program_id){
		$map['register_time'] = array(array('gt',$str),array('lt',time())) ;
		$map['program_id']=$program_id;
		$arr=M("members")->where($map)->count();
		return $arr;
	}
		//会员管理 --列表
	public function members_0(){
		
		$where=array(
			'program_id'=>$_GET["program_id"]
		);
		
		//昵称、姓名、手机号的模糊搜索  str=》昵称、姓名、手机号
		 if(isset($_POST['str'])){
				$str=$_POST['str'];     //如果接收到搜索关键字,执行模糊查询 返回数据
				//模糊查询 id、名称、编号、条码、商户名称
				$where['_string']='
					(nickname like "%'.$str.'%")  
					OR (realname like "%'.$str.'%")
					OR (tel like "%'.$str.'%")
				';
				$list=M("members")
				->field('id,head,nickname,level_id,group_id,register_time,blacklist')
				->where($where)
				->select();
		
			}else{
				$list=M("members")
				->field('id,head,nickname,level_id,group_id,register_time,blacklist')
				->where($where)
				->select();
		
			}
			
			for($i=0;$i<count($list);$i++){
				$a1=M("member_level")
				->field('member_level_name')
				->where("id='".$list[$i]["level_id"]."'")->find();
				$list[$i]["level_name"]=$a1["member_level_name"];//会员等级
				
				$a2=M("member_group")
				->field('member_group_name')
				->where("id='".$list[$i]["group_id"]."'")->find();
				$list[$i]["group_name"]=$a2["member_group_name"];//会员分组
			}

		$this->ajaxReturn($list);
	}
	
	//会员等级显示
	public function show_1(){
        $where=array(
            'program_id'=>$_GET["program_id"]
        );
		if(isset($_POST['str'])){
				$str=$_POST['str'];     //如果接收到搜索关键字,执行模糊查询 返回数据
				//模糊查询 id、名称、编号、条码、商户名称
				$where["state"]=$str;
				
				$list=M("member_level")
				->field('id,member_level,member_level_name,condition,state')
				->where($where)
				->select();
		
			}else{
				$list=M("member_level")
				->field('id,member_level,member_level_name,condition,state')
				->where($where)
				->select();
			}

		$this->ajaxReturn($list);	
	}
	//会员的分组显示
	public function show_2(){
	$where=array(
			'program_id'=>$_GET["program_id"]
		);
				$list=M("member_group")
				->field('id,member_group_name')
				->where($where)
				->select();
			
		$this->ajaxReturn($list);	
	}

//会员等级修改页面
    function edit_lever_show(){
	    //需要得到等级id、小程序id

        $where=array(
            'id'=>$_GET["id"],
            'program_id'=>$_GET["program_id"]
        );

       $lever= M("member_level")->where($where)->find();
        if($_GET["id"]==1){
            $lever["is_show_all"]=1;//只显示等级 名称和等级 折扣
        }else{
            $lever["is_show_all"]=2;
        }


        $this->ajaxReturn($lever);
    }
    
	//会员等级管理  add、delect、update（name）

//会员等级修改
	function edit_level(){
		//$_POST  小程序id、等级名称   program_id、member_level_name  
		
		if(empty($_POST["id"])){
			if(M("member_level")->add($_POST)){
				//添加
				$data=array("status"=>1,"msg"=>"添加成功");
			}else{
				$data=array("status"=>2,"msg"=>"添加失败");
			}
		}else{
			if(M("member_level")->where("id='".$_POST["id"]."'")->save($_POST)){
				//修改
				$data=array("status"=>3,"msg"=>"修改成功");
			}else{
				$data=array("status"=>4,"msg"=>"修改失败");
			}
		}
		$this->ajaxReturn($data);
	}
	


	//会员修改分组内容显示
    public function edit_fenzu_show(){
        $where=array(
            'id'=>$_GET["id"],
            'program_id'=>$_GET["program_id"]
        );

        $group= M("member_group")->where($where)->find();

        $this->ajaxReturn($group);
    }

	//会员分组管理 add、delect、update（name）
	function add_group(){
		//$_POST  小程序id、等级名称   program_id、member_level_name  

		if(empty($_POST["id"])){
			if(M("member_group")->add($_POST)){
				//添加
				$data=array("status"=>1,"msg"=>"添加成功");
			}else{
				$data=array("status"=>2,"msg"=>"添加失败");
			}
		}else{
			if(M("member_group")->where("id='".$_POST["id"]."'")->save($_POST)){
				//修改
				$data=array("status"=>3,"msg"=>"修改成功");
			}else{
				$data=array("status"=>4,"msg"=>"修改失败");
			}
		}
		$this->ajaxReturn($data);
	}
	
		//递归
	function bq($arr,$p=0){
		$ar=array();
		foreach($arr as $v){ if($v["uid"]==$p){ $v["child"]=$this->bq($arr,$v["id"]);	$ar[]=$v;}} return $ar;
	}
	//删除等级
	public function delete_1(){
        if(M("member_level")->delete($_GET["id"])) {
            $this->ajaxReturn(array("status"=>1,"msg"=>"删除成功"));
        } else {
            $this->ajaxReturn(array("status"=>2,"msg"=>"删除失败"));
        }
	}
		//删除分组
	public function delete_2(){
        if(M("member_group")->delete($_GET["id"])) {
            $this->ajaxReturn(array("status"=>1,"msg"=>"删除成功"));
        } else {
            $this->ajaxReturn(array("status"=>2,"msg"=>"删除失败"));
        }
	}

	//商品异步修改商品属性  1：启用、2：不启用	
	public function shuxing_ajax_1(){
		//post 商品id 商品属性值
		$where["id"]=$_POST["id"];
		$aa=M("goods")->where($where)->find();	
		if($aa["goods_subtitle01"]==1){
			$date["goods_subtitle01"]="2";
		}else{
			$date["goods_subtitle01"]="1";
		}
	if(M("goods")->where($where)->save($date)){
			$date=array("status"=>1,"msg"=>"成功");
		}else{
			$date=array("status"=>2,"msg"=>"失败");
		}
	
	  $this->ajaxReturn($date);			
	}
	public function shuxing_ajax_2(){
		//post 商品id 商品属性值
		
		$where["id"]=$_POST["id"];
		$aa=M("goods")->where($where)->find();	
		if($aa["goods_subtitle02"]==1){
		//if($_POST["goods_subtitle02"]==1){
			$date["goods_subtitle02"]="2";
		}else{
			$date["goods_subtitle02"]="1";
		}
		
		if(M("goods")->where($where)->save($date)){
			$date=array("status"=>1,"msg"=>"成功");
		}else{
			$date=array("status"=>2,"msg"=>"失败");
		}
	
	  $this->ajaxReturn($date);				
	}
	public function shuxing_ajax_3(){
		//post 商品id 商品属性值
		$where["id"]=$_POST["id"];
		$aa=M("goods")->where($where)->find();	
		if($aa["goods_subtitle03"]==1){
		//if($_POST["goods_subtitle03"]==1){
			$date["goods_subtitle03"]="2";
		}else{
			$date["goods_subtitle03"]="1";
		}
		
	if(M("goods")->where($where)->save($date)){
			$date=array("status"=>1,"msg"=>"成功");
		}else{
			$date=array("status"=>2,"msg"=>"失败");
		}
	
	  $this->ajaxReturn($date);		
	}
	public function shuxing_ajax_4(){
		//post 商品id 商品属性值
		$where["id"]=$_POST["id"];
		$aa=M("goods")->where($where)->find();	
		if($aa["goods_subtitle04"]==1){
		//if($_POST["goods_subtitle04"]==1){
			$date["goods_subtitle04"]="2";
		}else{
			$date["goods_subtitle04"]="1";
		}
		
			if(M("goods")->where($where)->save($date)){
			$date=array("status"=>1,"msg"=>"成功");
		}else{
			$date=array("status"=>2,"msg"=>"失败");
		}
	
	  $this->ajaxReturn($date);			
	}
	public function shuxing_ajax_5(){
		//post 商品id 商品属性值
		$where["id"]=$_POST["id"];
		$aa=M("goods")->where($where)->find();	
		if($aa["goods_subtitle05"]==1){
		//if($_POST["goods_subtitle05"]==1){
			$date["goods_subtitle05"]="2";
		}else{
			$date["goods_subtitle05"]="1";
		}
	if(M("goods")->where($where)->save($date)){
			$date=array("status"=>1,"msg"=>"成功");
		}else{
			$date=array("status"=>2,"msg"=>"失败");
		}
	
	  $this->ajaxReturn($date);			
	}
	
	//异步修改商品是否在售、下架
	public function xianshi(){
		//post 商品id 改变商品是否显示 goods_state  商品状态（1：在售、2：售罄、3：仓库中）
		$where["id"]=$_POST["id"];
		$aa=M("goods")->where($where)->find();	
		if($aa["goods_state"]==1){
	
			$date["goods_state"]="3";
		}else if($aa["goods_state"]==3){
			$date["goods_state"]="1";
		}
		
		if(M("goods")->where($where)->save($date)){
			$date=array("status"=>1,"msg"=>"成功");
		}else{
			$date=array("status"=>2,"msg"=>"失败");
		}
	
	  $this->ajaxReturn($date);			
	}

}

?>