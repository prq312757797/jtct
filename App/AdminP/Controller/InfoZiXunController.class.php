<?php
namespace AdminP\Controller;
use Think\Controller;
class InfoZiXunController extends CommonController {
	
	
    public function index(){
		echo 123;
    	$this->display();
	}
	
	//采购信息     state 1:待审、2：已审、3：拒绝、、、   style  1:采购信息、2：供应信息、
	public function caigou(){
	
	
		$aa=$this->info=$this->get_info($state="2",$style="1",$str="",$str_f="",$is_gongyi="0");
		$this->count=count($aa);
		//	dump($aa);die;
		$this->display();
	}
	
	//供应信息     state 1:待审、2：已审、3：拒绝、、、   style  1:采购信息、2：供应信息、  
	public function gongying(){
	
	
		$aa=$this->info=$this->get_info($state="2",$style="2",$str="",$str_f="",$is_gongyi="0");
			$this->count=count($aa);
		$this->display();
	}
	
	//公益信息     state 1:待审、2：已审、3：拒绝、、、   style  1:采购信息、2：供应信息、3：平台好消息  
	public function gongyi(){
	
	
		$aa=$this->info=$this->get_info($state="2",$style=array('in','1,2'),$str="",$str_f="",$is_gongyi="1");
			$this->count=count($aa);
		$this->display();
	}
	//待审信息     state 1:待审、2：s已审、3：拒绝、、、   style  1:采购信息、2：供应信息、  
	public function shenhe(){
	
	
		$aa=$this->info=$this->get_info($state="1",$style=array('in','1,2'),$str="",$str_f="",$is_gongyi=array('in','0,1'));
	$this->count=count($aa);
		$this->display();
	}
	//已拒绝信息     state 1:待审、2：s已审、3：拒绝、、、   style  1:采购信息、2：供应信息、  
	public function say_no(){
	
	
		$aa=$this->info=$this->get_info($state="3",$style=array('in','1,2'),$str="",$str_f="",$is_gongyi=array('in','0,1'));
	$this->count=count($aa);
		$this->display();
	}
	
	
	
	//资讯删除
	function zx_delete(){
			 $user_id = $_GET['id'];
	        if(M('jt03_zx_info')->delete($user_id)) {
	        	M("jt03_zx_session")->where("id='".$_GET['id']."'")->delete();
	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
	}
	
	public function get_info($state,$style,$str,$str_f,$is_gongyi){
		$where["program_id"]=$_COOKIE["program_id"];
		$where["state"]=$state;	//只显示能正常的
		$where["style"]=$style;
		$where["is_gongyi"]=$is_gongyi;
		//两个字段的模糊搜索  str=》id、名称    str_f=》分类 
		 if(!empty($str)){
			//	$str=$_POST['str'];     //如果接收到搜索关键字,执行模糊查询 返回数据
				
				//模糊查询 id、名称、编号、条码、商户名称
				$where['_string']='
					(id like "%'.$str.'%")  
					OR (title like "%'.$str.'%")
				';
			
				if($state==1){
						$list=M("jt03_zx_info")
						->field('id,sort,title,tel,state,style,fenlei01,time_input,time_agree,is_gongyi')
						->where($where)->order("time_input desc")
						->select();//对id、名称的模糊搜索
					
				}else{
						$list=M("jt03_zx_info")
						->field('id,sort,title,tel,state,style,fenlei01,time_input,time_agree,is_gongyi')
						->where($where)->order("sort")
						->select();//对id、名称的模糊搜索
					
				}
				
				
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
				
				if($state==1){
					$list=M("jt03_zx_info")
					->field('id,sort,title,tel,state,openid,style,fenlei01,time_input,time_agree,is_gongyi')
					->where($where)
					->order("time_input  desc")	->select();	
				}else{
					$list=M("jt03_zx_info")
					->field('id,sort,title,tel,state,openid,style,fenlei01,time_input,time_agree,is_gongyi')
					->where($where)
					->order("time_agree desc")	->select();	
				}
				
				
			}
			for($i=0;$i<count($list);$i++){
				
				$members=M("members")->where("openid='".$list[$i]["openid"]."'")->find();
				
				$list[$i]["openid"]=$members["nickname"];
			}
			
			return $list;
	}
	
	//发布页面设置
	function info_set(){
		
		$a=$this->data=M("store")->field("zx_enter_img,zx_info_list_img")->where("program_id='".$_COOKIE["program_id"]."'")->find();
		
		$this->display();
	}
	//发布页面广告图片提交
	function info_set_submit(){
		
				$upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =  3145728 ;// 设置附件上传大小
			    $upload->exts      =  array('jpg', 'gif', 'png', 'jpeg','mp4');// 设置附件上传类型
			    $upload->rootPath  =   './Uploads/'; // 设置附件上传根目录
			    // 上传文件 
			    $info   =   $upload->upload();
	
			    if($info){
			    	if(!empty($info['zx_enter_img'])){
			    		$img["zx_enter_img"]=$info['zx_enter_img']['savepath'].$info['zx_enter_img']['savename'];
			    	
			    	}
			    	if(!empty($info['zx_info_list_img'])){
			    		$img["zx_info_list_img"]=$info['zx_info_list_img']['savepath'].$info['zx_info_list_img']['savename'];
			    	
			    	}
			    	 
			    	if(M("store")->where("program_id='".$_COOKIE["program_id"]."'")->save($img)){
			    		$this->success('上传成功');
			    	}else{
			    		$this->error('上传失败');
			    	}
				}else{
				 		$this->error('操作失败');
				}	
			 
	}
	//规则管理
	function rules(){
		
		$this->info=M("jt03_zx__rule")->where("program_id='".$_COOKIE["program_id"]."'")->find();
		
		$this->display();
	}
	//规则添加按钮
	function rules_submit(){
		
		$save["content"]=$_POST["content"];
		$a=M("jt03_zx__rule")->where("program_id='".$_COOKIE["program_id"]."'")->find();
		if(empty($a)){
			$save["program_id"]=$_COOKIE["program_id"];
			if(M("jt03_zx__rule")->add($save)){
			    		$this->success('设置成功',U('rules'));
			    	}else{
			    		$this->error('设置失败');
			    	}
		}else{
			if(M("jt03_zx__rule")->where("program_id='".$_COOKIE["program_id"]."'")->save($save)){
			    		$this->success('设置成功',U('rules'));
			    	}else{
			    		$this->error('设置失败');
			    	}
		}
		
		
	}
	//资讯审核通过
	function zx_agree(){
		$save["state"]="2";
	
		$save["time_agree"]=time();
		if(M("jt03_zx_info")->where("id='".$_GET["id"]."'")->save($save)){
			$this->success("操作成功",U('shenhe'));
		}else{
			$this->error("操作失败");
		}
	}
	
	//资讯审核拒绝
	function zx_say_no(){
		$save["state"]="3";
		$save["time_say_no"]=time();
		if(M("jt03_zx_info")->where("id='".$_GET["id"]."'")->save($save)){
			$this->success("操作成功",U('shenhe'));
		}else{
			$this->error("操作失败");
		}
	}
	

	
	//好消息      state 1:待审、2：已审、3：拒绝、、、   style  1:采购信息、2：供应信息、3：平台好消息  
	public function good_news(){

		$aa=$this->info=$this->get_info($state="2",$style="3",$str="",$str_f="",$is_gongyi="0");
		$this->count=count($aa);
		$this->display();
	}
	public function good_news_add(){
		
		$this->display();
	}
	public function good_news_edit(){
		$a=M('jt03_zx_info')->where("id=".$_GET['id'])->find();
	
		$a["arr"]=explode(",",$a["image"]);//将图片字符串转换成数组
		
		$this->info=$a;
	
		$this->display('good_news_add');
	}
	public function run_good_news_add(){
		$receive=I();
		//DUMP($receive);DIE;
		$receive["program_id"]=$_COOKIE["program_id"];
		    $upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =     3145728 ;// 设置附件上传大小
			    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录

			// 上传文件 
			//   $info   =   $upload->upload(array($_FILES['image']));
			     $info   =   $upload->upload();
	
			 if($info){
			 	//有图片===============================================================
			 	
			 	for($i=0;$i<count($info);$i++){
			 		$receive['image'].=$info[$i]['savepath'].$info[$i]['savename'].",";
			 	}
                  $receive['image'] = substr($receive['image'],0,strlen($receive['image'])-1); //去掉最后一个逗号
						 if(empty($_GET['id'])) {
								//执行添加操作==========================================	
								$receive['state']="2";//已审
								$receive['style']="3";//1:采购信息、2：供应信息、3：平台好消息
								$receive['time_input']=time();
								$receive['time_agree']=time();
								
								$receive['fenlei01']="0";
									     if(M('jt03_zx_info')->add($receive)){
									    	$this->success('添加成功',U('good_news'));
									    }else{
									    	$this->error('添加失败');	
									    }    
						        }else{
						        //执行修改操作==========================================	
						         		//修改图片需要得到原来的字符串，然后再拼接
						         		
						         	$old_info=M('jt03_zx_info')->where(array('id'=>$_GET['id']))->find();
						         	if(!empty($old_info["image"])){
						         		
						         		$receive['image']=$old_info["image"].",".$receive['image'];
						         	}
									  if(M('jt03_zx_info')->where(array('id'=>$_GET['id']))->save($receive)){
									    	$this->success('修改成功',U('good_news'));
									    }else{
									    	$this->error('修改失败');	
									    }
						      }   
			    }else{
			    	//无图片===============================================================
					    if(empty($_GET['id'])) {
						$receive['state']="2";//已审
								$receive['style']="3";//1:采购信息、2：供应信息、3：平台好消息
								$receive['time_input']=time();
								$receive['time_agree']=time();
								
								$receive['fenlei01']="0";
								dump($receive);die;
					     if(M('jt03_zx_info')->add($receive)){
					     		//执行添加操作==========================================	
								    	$this->success('添加成功',U('good_news'));
								    }else{
								    	$this->error('添加失败');	
								    }    
					        }else {
					        	//执行修改操作==========================================	
								  if(M('jt03_zx_info')->where(array('id'=>$_GET['id']))->save($receive)){
								    	$this->success('修改成功',U('good_news'));
								    }else{
								    	$this->error('修改失败');	
								    }
					      }   
			    }
	}
	//异步删除图片
	public function ajax_delete_img(){
		//得到那条  好消息 的id、和对应的图片的位置键值，对数据的字符串进行删减
		
		$info=M('jt03_zx_info')->where("id='".$_POST["id"]."'")->find();
		$arr=explode(",",$info["image"]);//字符串转换成数组
		for($i=0;$i<count($arr);$i++){
			if($i != $_POST["key"]){
				$arr_new[]=$arr[$i];
			}
		}
		$str_new["image"]=implode(",",$arr_new);//数组转换成 字符串   这个就是新的需要存的数据
		if($str_new==","){
			$str_new=null;
		}
		if(M("jt03_zx_info")->where("id='".$_POST["id"]."'")->save($str_new)){
			
			unlink('./Uploads/'.$arr[$_POST["key"]]);
			
			$date="1";//保存并删除旧图片成功
		}else{
			$date="2";//操作失败
		}
		$this->ajaxReturn($date);
	}
	
		public function good_news_delete(){
			$user_id = $_GET['id'];
			$info=M('jt03_zx_info')->where("id='".$_GET['id']."'")->find();
	        if(M('jt03_zx_info')->delete($user_id)) {
	        	
	        	$arr=explode(",",$info["image"]);
				for($i=0;$i<count($arr);$i++){
					unlink('./Uploads/'.$arr[$i]);
				}
	        	
	            $this->success('删除成功',U('good_news'));
	        } else {
	            $this->error('删除失败');
	        }
		}	
	
	//资讯行业分类
	public function fenlei(){

		$fl=M("attribute")
		->field('id,uid,title,image_1,is_show')
		->where("dsh_id=0 and program_id='".$_COOKIE["program_id"]."'" )
		->order("sort")
		->select();
		$all_fenlei=$this->fenlei=$this->bq($fl);

		$this->display();
	}
	
	public function fenlei_add(){
		
		$this->display();
	}
	//添加子分类
	public function fenlei_add02(){
		$this->add_child=$_GET["id"];
		
		$this->display('fenlei_add');
	}
	
	public function fenlei_edit(){
		$a= $this->info=M('attribute')->where("id=".$_GET['id'])->find();
	
		$this->display('fenlei_add');
	}
	
	public function run_fenlei_add(){
		$receive=I();
		$receive["program_id"]=$_COOKIE["program_id"];
			$upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =     3145728 ;// 设置附件上传大小
			    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录

			    // 上传文件 
			    $info   =   $upload->upload();
			    
		 if(empty($_GET['id'])) {
		 	//执行添加操作==================================
			 if($info){
                    $receive['image_1']=$info['image02']['savepath'].$info['image02']['savename'];
					//$receive["uid"]=0;dsh_id=0
					$receive["dsh_id"]=0;
				     if(M('attribute')->add($receive)){
				    	$this->success('添加成功',U('fenlei'));
				    }else{
				    	$this->error('添加失败');	
				    }
			    
			    }else{
			    	//$this->error('无上传图片');	
			    	if(M('attribute')->add($receive)){
				    	$this->success('添加成功',U('fenlei'));
				    }else{
				    	$this->error('添加失败');	
				    }
                //	$error=$upload->getError();
		    	//	$data=array("status" => -1, "msg" => "图片上传失败",'error'=>$error);
			    }
            
        }else {
        	//执行修改操作=====================================
       
        
			if($info){
                  $receive['image_1']=$info['image02']['savepath'].$info['image02']['savename'];

			     if(M('attribute')->where(array('id'=>$_GET['id']))->save($receive)){
		//如果对一级分类进行隐藏，则对应的二级分类都要隐藏
        	$a0926=M("attribute")->where("id='".$_GET["id"]."'")->find();	
        	if($a0926["uid"]==0){
        		$date0926["is_show"]="2";
        		M("attribute")->where("uid='".$_GET["id"]."'")->save($date0926);
        	}
			     	
			    	$this->success('修改成功2',U('fenlei'));
			    }else{
			    	$this->error('修改失败2');	
			    }
			    
			    }else{
			  if(M('attribute')->where(array('id'=>$_GET['id']))->save($receive)){
//如果对一级分类进行隐藏，则对应的二级分类都要隐藏
        /*	$a0926=M("attribute")->where("id='".$_GET["id"]."'")->find();	
        	if($a0926["uid"]==0){
        		$date0926["is_show"]="2";
        		M("attribute")->where("uid='".$_GET["id"]."'")->save($date0926);
        	}*/
			    	$this->success('修改成功02',U('fenlei'));
			    }else{
			    	$this->error('修改失败02');	
			    }
			}
       }   
	}
	
	
	//分类删除
		public function fenlei_delete(){
				 $user_id =$_GET['id'];
			$d_zhu_img=M('attribute')->where("id='".$_GET['id']."'")->find();
	        $d_zi_img=M('attribute')->where("uid='".$_GET['id']."'")->select();
	        	
	        if(M('attribute')->delete($user_id)) {
	        	//删除主类图片
	        	unlink('./Uploads/'.$d_zhu_img["image_1"]);
	        	
	        	
	        	//删除 所属 子类 图片
	        	for($i=0;$i<count($d_zi_img);$i++){
	        		unlink('./Uploads/'.$d_zi_img[$i]["image_1"]);
	        	}
	        	
	        	//删除 所属 子类  数据
	        	$all["uid"]=$_GET['id'];
	        	M('attribute')->delete($all);
	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
		}
		public function fenlei_delete02(){
			
			
				$d_img=M('attribute')->where("id='".$_GET['id']."'")->find();
				 $user_id = $_GET['id'];
	        if(M('attribute')->delete($user_id)) {
	        	//删除对应子类图片
	        	
	        	unlink('./Uploads/'.$d_img["image_1"]);
	        	
	       
	           $this->success('删除成功');
	        } else {
	           $this->error('删除失败');
	        }
		}
	//异步修改属性  =======开始
	//ajax_change_shuxing01
	public function ajax_change_shuxing01(){
		$where["program_id"]=$_COOKIE["program_id"];
		$where["id"]=$_POST["id"];
		
		
		
		$a=M("goods")->where($where)->find();
			
		if($a["goods_subtitle01"]==1){
			$date["goods_subtitle01"]="2";//（1：选中、2：不选）
		}else if(($a["goods_subtitle01"]==2)){
			$date["goods_subtitle01"]="1";//（1：选中、2：不选）
		}
		
		if(M("goods")->where($where)->save($date)){
			$ajax_back=$date["goods_subtitle01"];
		}else{
			$ajax_back=0;
		}
			$this->ajaxReturn($ajax_back);
	}
	//ajax_change_shuxing02
	public function ajax_change_shuxing02(){
		$where["program_id"]=$_COOKIE["program_id"];
		$where["id"]=$_POST["id"];
		
		$a=M("goods")->where($where)->find();
			
			
			if($a["goods_subtitle02"]==1){
				$date["goods_subtitle02"]="2";//（1：选中、2：不选）
			}else if(($a["goods_subtitle02"]==2)){
				$date["goods_subtitle02"]="1";//（1：选中、2：不选）
			}
	
		if(M("goods")->where($where)->save($date)){
			$ajax_back=$date["goods_subtitle02"];
		}else{
			$ajax_back=0;
		}
			$this->ajaxReturn($ajax_back);
	}
	//ajax_change_shuxing03
	public function ajax_change_shuxing03(){
		$where["program_id"]=$_COOKIE["program_id"];
		$where["id"]=$_POST["id"];
		
		$a=M("goods")->where($where)->find();
			
		if($a["goods_subtitle03"]==1){
			$date["goods_subtitle03"]="2";//（1：选中、2：不选）
		}else if(($a["goods_subtitle03"]==2)){
			$date["goods_subtitle03"]="1";//（1：选中、2：不选）
		}
		
		if(M("goods")->where($where)->save($date)){
			$ajax_back=$date["goods_subtitle03"];
		}else{
			$ajax_back=0;
		}
			$this->ajaxReturn($ajax_back);
	}
	//ajax_change_shuxing04
	public function ajax_change_shuxing04(){
		$where["program_id"]=$_COOKIE["program_id"];
		$where["id"]=$_POST["id"];
		
		$a=M("goods")->where($where)->find();
			
		if($a["goods_subtitle04"]==1){
			$date["goods_subtitle04"]="2";//（1：选中、2：不选）
		}else if(($a["goods_subtitle04"]==2)){
			$date["goods_subtitle04"]="1";//（1：选中、2：不选）
		}
		
		if(M("goods")->where($where)->save($date)){
			$ajax_back=$date["goods_subtitle04"];
		}else{
			$ajax_back=0;
		}
			$this->ajaxReturn($ajax_back);
	}
	//ajax_change_shuxing05
	public function ajax_change_shuxing05(){
		$where["program_id"]=$_COOKIE["program_id"];
		$where["id"]=$_POST["id"];
		
		$a=M("goods")->where($where)->find();
			
		if($a["goods_subtitle05"]==1){
			$date["goods_subtitle05"]="2";//（1：选中、2：不选）
		}else if(($a["goods_subtitle05"]==2)){
			$date["goods_subtitle05"]="1";//（1：选中、2：不选）
		}
		
		if(M("goods")->where($where)->save($date)){
			$ajax_back=$date["goods_subtitle05"];
		}else{
			$ajax_back=0;
		}
			$this->ajaxReturn($ajax_back);
	}
	
	
	//异步修改属性 =======结束
	
	
	public function goods_add(){
		 
		 //一级分类名 dsh_id
		 	$this->fenlei=M("attribute")
		->field('id,uid,title')
		->where("uid=0 and dsh_id=0 and program_id='".$_COOKIE["program_id"]."'")->select();
		$this->display();
	}
	
	
	//信息详情  caigou info_edit.html
	public function info_edit(){
		$this->info=$info=M('jt03_zx_info')->where("id=".$_GET['id'])->find();
		$this->display();
	}
	
	public function goods_edit(){
		$info=M('goods')->where("id=".$_GET['id'])->find();
		 
		 //商品所有图片
		 $id["goods_id"]=$_GET['id'];
		$goods_img=M("goods_img")->where($id)->order("time_set")->select();//得到对应商品第一张图片
			for($i=0;$i<count($goods_img);$i++){
				if($goods_img[$i]["img_input_name"]=="image01"){
					$this->image01=$goods_img[$i]["image"];
				}else if($goods_img[$i]["img_input_name"]=="image02"){
					$this->image02=$goods_img[$i]["image"];
				}else if($goods_img[$i]["img_input_name"]=="image03"){
					$this->image03=$goods_img[$i]["image"];
				}else if($goods_img[$i]["img_input_name"]=="image04"){
					$this->image04=$goods_img[$i]["image"];
				}else if($goods_img[$i]["img_input_name"]=="image05"){
					$this->image05=$goods_img[$i]["image"];
				}
			}
			
			//获得商品参数
			$canshu=$this->canshu=M("specifications")->where("goods_id='".$_GET['id']."'")->order("id")->select();
			
		
		 //一级分类名
		 	$fenlei1611=M("attribute")->where("id='".$info["fenlei_1"]."'")->find();
		 	$info["fenlei_1_title"]=$fenlei1611["title"];
		 	//二级分类名
		 	$fenlei1612=M("attribute")->where("id='".$info["fenlei_2"]."'")->find();
		 	$info["fenlei_2_title"]=$fenlei1612["title"];
		 
		 $this->info=$info;
		//遍历商品分类
		$this->fenlei=M("attribute")
		->field('id,uid,title')
		->where("uid=0 and program_id='".$_COOKIE["program_id"]."'")->select();

		$this->is_edit="1";
		$this->display('goods_add');
	}

	//异步获得子类
	public function ajax_fenlei_2(){
		//需要主类 id
		$where01["uid"]="0";
		$where01["title"]=$_POST["title"];
		$where01["program_id"]=$_COOKIE["program_id"];
		
		
		$a=M("attribute")->where($where01)->find();
		$b=M("attribute")->where("uid='".$a["id"]."'")->select();
		 for($i=0;$i<count($b);$i++){
            $arr_road[$i]=$b[$i]["title"];

        }
		$this->ajaxReturn($arr_road);
	}
	public function run_goods_add(){
			
			$_POST["time_set"]=time();
			$_POST["program_id"]=$_COOKIE["program_id"];
			
			$fenlei_1=M("attribute")->where("uid=0 and title='".$_POST["fenlei_1_title"]."'")->find();
			$_POST["fenlei_1"]=$fenlei_1["id"];
			
			$fenlei_2=M("attribute")->where(" title='".$_POST["fenlei_2_title"]."'")->find();
			$_POST["fenlei_2"]=$fenlei_2["id"];
			
	if(empty($_POST["good_attribute01"])){
		$_POST["goods_subtitle01"]="2";
	}else{
		$_POST["goods_subtitle01"]="1";
	}
	
	if(empty($_POST["good_attribute02"])){
		$_POST["goods_subtitle02"]="2";
	}else{
		$_POST["goods_subtitle02"]="1";
	}
	if(empty($_POST["good_attribute03"])){
		$_POST["goods_subtitle03"]="2";
	}else{
		$_POST["goods_subtitle03"]="1";
	}
	if(empty($_POST["good_attribute04"])){
		$_POST["goods_subtitle04"]="2";
	}else{
		$_POST["goods_subtitle04"]="1";
	}
	
	if(empty($_POST["good_attribute05"])){
		$_POST["goods_subtitle05"]="2";
	}else{
		$_POST["goods_subtitle05"]="1";
	}
			
		for($p=0;$p<count($_POST["canshu_title"]);$p++){
			if(!empty($_POST["canshu_title"][$p])){
				$y1[$p]=$_POST["canshu_title"][$p];//参数名数组	
				
			}
		}
		for($p2=0;$p2<count($_POST["canshu_con"]);$p2++){
			if(!empty($_POST["canshu_con"][$p2])){
				$y2[$p2]=$_POST["canshu_con"][$p2];//参数值数组	
			}
		}
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
			   		}else{
			   			$receive01['image']=null;
			   		}
			   		if(!empty($info['image02'])){
	                $receive02['image']=$info['image02']['savepath'].$info['image02']['savename'];
					}else{
			   			$receive02['image']=null;
			   		}
				   		if(!empty($info['image03'])){
					$receive03['image']=$info['image03']['savepath'].$info['image03']['savename'];
					}else{
			   			$receive03['image']=null;
			   		}
				   		if(!empty($info['image04'])){
					$receive04['image']=$info['image04']['savepath'].$info['image04']['savename'];
					}else{
			   			$receive04['image']=null;
			   		}
				   		if(!empty($info['image05'])){
					$receive05['image']=$info['image05']['savepath'].$info['image05']['savename'];
					}else{
			   			$receive05['image']=null;
			   		}
			if(empty($_GET["id"])){
				//没有传递 id  执行添加操作
		
				$only=M("goods")->where("time_set='".$_POST["time_set"]."'")->find();
				if(empty($only)){
			
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
									//将参数添加到参数表
								$a1[$o]["goods_id"]=$set_img["id"];
								
								$a1[$o]["title"]=$y1[$o];
								$a1[$o]["content"]=$y2[$o];
								
								M("specifications")->add($a1[$o]);//商品参数
							}
							M("goods_img")->add($receive01);
							M("goods_img")->add($receive02);
							M("goods_img")->add($receive03);
							M("goods_img")->add($receive04);
							M("goods_img")->add($receive05);
						/*if(!empty($info['image01'])){
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
							}*/
				
						$this->success('添加成功01',U('selling'));
				    }else{
				    	$this->error('添加失败01');	
				    }
				}
	
			 }else{
			 	//传递了id 执行修改操作 
			 		$w["id"]=$_GET["id"];
			 	
			 		$w1["goods_id"]=$_GET["id"];
			 			$w1["img_input_name"]="image01";
			 		$w2["goods_id"]=$_GET["id"];
			 			$w2["img_input_name"]="image02";
			 		$w3["goods_id"]=$_GET["id"];
			 			$w3["img_input_name"]="image03";
			 		$w4["goods_id"]=$_GET["id"];
			 			$w4["img_input_name"]="image04";
			 		$w5["goods_id"]=$_GET["id"];
			 			$w5["img_input_name"]="image05";
			 		if(M("goods")->where($w)->save($_POST)){
			 			
		//删除这个商品的全部参数，然后重新赋值
			 		M("specifications")->where("goods_id='".$_GET["id"]."'")->delete();
			 		 			
				for($o=0;$o<count($y1);$o++){
					
					//将参数添加到参数表
						$a12["goods_id"]=$_GET["id"];
								
						$a1[$o]["title"]=$y1[$o];
						$a1[$o]["content"]=$y2[$o];
						$a1[$o]["goods_id"]=$_GET["id"];		
						M("specifications")->add($a1[$o]);
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

						
			 		$this->success('修改成功01',U('selling'));
				    }else{
				    	$this->error('修改失败01');	
				    }
			 }
					$data=array('status'=>1,'msg'=>'修改成功');
			    }else{
			    	//没有上传图片的地方进来
			   		//没图片上传不存在添加操作，每个商品建立必须传入一张图片
			 		//传递了id 执行修改操作
	
			 	if(empty($_GET["id"])){
				//没有传递 id  执行添加操作
		
				$only=M("goods")->where("time_set='".$_POST["time_set"]."'")->find();
				if(empty($only)){
			
	
					if(M("goods")->add($_POST)){
						$set_img=M("goods")->where("time_set='".$_POST["time_set"]."'")->find();

							for($o=0;$o<count($y1);$o++){
									//将参数添加到参数表
								$a1[$o]["goods_id"]=$set_img["id"];
								
								$a1[$o]["title"]=$y1[$o];
								$a1[$o]["content"]=$y2 ;
								M("specifications")->add($a1[$o]);//商品参数
							}
		
						$this->success('添加成功02',U('selling'));
				    }else{
				    	$this->error('添加失败02');	
				    }
				}
	
			 }else{
			 	//传递了id 执行修改操作 
			 
			 		$w["id"]=$_GET["id"];
			 	
			 		$w1["goods_id"]=$_GET["id"];
			 			$w1["img_input_name"]="image01";
			 		$w2["goods_id"]=$_GET["id"];
			 			$w2["img_input_name"]="image02";
			 		$w3["goods_id"]=$_GET["id"];
			 			$w3["img_input_name"]="image03";
			 		$w4["goods_id"]=$_GET["id"];
			 			$w4["img_input_name"]="image04";
			 		$w5["goods_id"]=$_GET["id"];
			 			$w5["img_input_name"]="image05";
			 			
			 				//	dump($_POST);die;
			 	if(M("goods")->where($w)->save($_POST)){
			 		//删除这个商品的全部参数，然后重新赋值
			 		M("specifications")->where("goods_id='".$_GET["id"]."'")->delete();
			 		for($o4=0;$o4<count($y1);$o4++){
							//将参数添加到参数表
					
						$a123["goods_id"]=$_GET["id"];

						$a13["title"]=$y1[$o4];
						$a13["content"]=$y2[$o4];
						$a13["goods_id"]=$_GET["id"];
						
			 			M("specifications")->add($a13);
		
					} 			
				
			 		$this->success('修改成功02',U('selling'));
				    }else{
				    	$this->error('修改失败02');	
				    }
			 }
			 	 }
	}
	
		public function goods_delete(){
				 $user_id = $_GET['id'];
	        if(M('goods')->delete($user_id)) {
	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
		}
		
		public function goods_huishou(){
			$date["goods_state"]="4";
			if(M('goods')->where("id='".$_GET["id"]."'")->save($date)) {
	            $this->success('回收成功');
	        } else {
	            $this->error('回收失败');
	        }
		}
		public function goods_huishou_back(){
			$date["goods_state"]="3";
			if(M('goods')->where("id='".$_GET["id"]."'")->save($date)) {
	            $this->success('回收成功');
	        } else {
	            $this->error('回收失败');
	        }
		}
		//递归
	function bq($arr,$p=0){
		$ar=array();
		foreach($arr as $v){ 
				if($v["uid"]==$p){ 
					$v["child"]=$this->bq($arr,$v["id"]);
						$ar[]=$v;
						}
			} return $ar;
	}
	//筛选区间
	public function shanxuan(){
		echo 777;
		$this->display();
	}
	//标签管理
	public function biaoqian(){
		echo 888;
		$this->display();
	}
	
	//商品异步上下架
	function ajax_change_ok(){
	$state=M("goods")->where("id='".$_POST["id"]."'")->find();
		//  goods_state  商品状态（1：在售、2：售罄、3：仓库中、4：回收站）
			if($state["goods_state"]==1){
				$val["goods_state"]="3";
			}else if($state["goods_state"]==3){
				$val["goods_state"]="1";
			}
			
			if(M("goods")->where("id='".$_POST["id"]."'")->save($val)){
					$date="1";
			}else{
					$date="2";
			}
			$this->ajaxReturn($date);
	}
	
	//回收站商品恢复到仓库里
	function back_cangku(){
		$val["goods_state"]="3";
		
		if(M("goods")->where("id='".$_POST["id"]."'")->save($val)){
				$this->success('恢复成功',U('cangku'));
			}else{
				$this->error('恢复失败');
			}
	}
	//异步修改商品的排序
	function ajax_sort_goods(){
		$save["sort"]=$_POST["sort_val"];
		if(M("goods")->where("id='".$_POST["id"]."'")->save($save)){
				$date="1";
			}else{
				$date="2";
			}
		$this->ajaxReturn($date);
	}
	
}