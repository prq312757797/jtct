<?php
namespace AdminPP\Controller;
use Think\Controller;
class WarehouseController extends CommonController {
//	仓库管理
	
    public function canggui(){
    	$this->list=M("warehouse")->where("lever=1 and program_id='".$_COOKIE["program_id"]."'")->select();
    	
    	$this->list02=M("warehouse")->where("lever=2 and program_id='".$_COOKIE["program_id"]."'")->select();
    	$this->display();
	}

	public function canggui_add(){

		$this->display();
	}
	public function canggui_edit(){

		$a= $this->info=M('warehouse')->where("id=".$_GET['id'])->find();

		$this->display('canggui_add');
	}
	public function run_canggui_add(){
		$receive=I();
		$receive["program_id"]=$_COOKIE["program_id"];
			$upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =     3145728 ;// 设置附件上传大小
			    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录

			    // 上传文件 
			    $info   =   $upload->upload();
			    
			    if($info){
			    	$receive['image']=$info['image02']['savepath'].$info['image02']['savename'];
			    }else{
//			    	$this->error('无上传图片');	
//              	$error=$upload->getError();
//		    		$data=array("status" => -1, "msg" => "图片上传失败",'error'=>$error);
			    }
			    
			    if(empty($_GET['id'])){
			    	if(M('warehouse')->add($receive)){
				    	$this->success('添加成功',U('canggui'));
				    }else{
				    	$this->error('添加失败');	
				    }
			    }else{
			    	if(M('warehouse')->where(array('id'=>$_GET['id']))->save($receive)){
				    	$this->success('修改成功',U('canggui'));
				    }else{
				    	$this->error('修改失败');	
				    }
			    }
			    
	
	}
		public function canggui_delete(){
	        if(M('warehouse')->where("id='".$_GET['id']."'")->delete()) {    	

	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
		}
		
//	供应商	
	 public function gongying(){
    	$this->list=M("supplier")->where("program_id='".$_COOKIE["program_id"]."'")->select();
    	
    
    	$this->display();
	}

	public function gongying_add(){

		$this->display();
	}
	public function gongying_edit(){

		$a= $this->info=M('supplier')->where("id=".$_GET['id'])->find();

		$this->display('gongying_add');
	}
	public function run_gongying_add(){
		$receive=I();
		$receive["program_id"]=$_COOKIE["program_id"];
			$upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =     3145728 ;// 设置附件上传大小
			    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录

			    // 上传文件 
			    $info   =   $upload->upload();    
			    if($info){
			    	$receive['image']=$info['image02']['savepath'].$info['image02']['savename'];
			    }else{
//			    	$this->error('无上传图片');	
//              	$error=$upload->getError();
//		    		$data=array("status" => -1, "msg" => "图片上传失败",'error'=>$error);
			    }
			    if(empty($_GET['id'])){
			    	if(M('supplier')->add($receive)){
				    	$this->success('添加成功',U('gongying'));
				    }else{
				    	$this->error('添加失败');	
				    }
			    }else{
			    	if(M('supplier')->where(array('id'=>$_GET['id']))->save($receive)){
				    	$this->success('修改成功',U('gongying'));
				    }else{
				    	$this->error('修改失败');	
				    }
			    }
			    
	
	}
		public function gongying_delete(){
	        if(M('supplier')->where("id='".$_GET['id']."'")->delete()) {    	

	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
		}	
		
		
	//商品分类
	public function fenlei(){

		$fl=M("attribute")
		->field('id,uid,title,image_1,is_show,title_english')
		->where("dsh_id=0 and attribute_style=4 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$all_fenlei=$this->bq($fl);


		$this->fenlei=$all_fenlei;
	//$this->fenlei=$fl;
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
		
		$receive["attribute_style"]=4;
		$receive["program_id"]=$_COOKIE["program_id"];
			$upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =     3145728 ;// 设置附件上传大小
			    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录

			    // 上传文件 
			    $info   =   $upload->upload();
			     if($info){
                    $receive['image_1']=$info['image02']['savepath'].$info['image02']['savename'];
					
			    
			    }else{
//			    	$this->error('无上传图片');	
//              	$error=$upload->getError();
//		    		$data=array("status" => -1, "msg" => "图片上传失败",'error'=>$error);
			    }
			    if(empty($_GET['id'])){
			    	$receive["dsh_id"]=0;
					$receive["attribute_style"]=4;
				    if(M('attribute')->add($receive)){
				    	$this->success('添加成功.',U('fenlei'));
				    }else{
				    	$this->error('添加失败.');	
				    }
			    }else{
			    	if(M('attribute')->where(array('id'=>$_GET['id']))->save($receive)){
					//如果对一级分类进行隐藏，则对应的二级分类都要隐藏
			        	$a0926=M("attribute")->where("id='".$_GET["id"]."'")->find();	
			        	if($a0926["uid"]==0){
			        		$date0926["is_show"]="2";
			        		M("attribute")->where("uid='".$_GET["id"]."'")->save($date0926);
			        	}
				     	
				    	$this->success('修改成功..',U('fenlei'));
				    }else{
				    	$this->error('修改失败..');	
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
	 
	        	M('attribute')->where("uid='".$_GET['id']."'")->delete();
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
		

	//即时库存 库存列表 各种仓
	function w_0_all(){
		$where["program_id"]=$_COOKIE["program_id"];
		$where["ktv_kucun"]=array('exp','is not null');
		$a=M("goods")->field("id,fenlei_1,fenlei_2,goods_title,ktv_kucun,ktv_guige,ktv_danwei")->where($where)->select();
		
		for($i=0;$i<count($a);$i++){
			$fenlei_1_title[$i]=M("attribute")->field("title")->where("id='".$a[$i]["fenlei_1"]."'")->find();
			$fenlei_2_title[$i]=M("attribute")->field("title")->where("id='".$a[$i]["fenlei_2"]."'")->find();
			
			$a[$i]["fenlei_1_title"]=$fenlei_1_title[$i]["title"];
			$a[$i]["fenlei_2_title"]=$fenlei_2_title[$i]["title"];
			
			$a[$i]["ktv_kucun_arr"]=json_decode($a[$i]["ktv_kucun"],true);
			$a[$i]["warehouse"]=$this->warehouse_info($arr=$a[$i]["ktv_kucun_arr"]);
		}
//		dump($a);dump(M("goods")->_sql());die;
		$this->list=$a;
		$this->display();
	}
	function warehouse_info($arr){
		foreach($arr as $k=>$v){ 
				$arr_new["title"][]=$k;
				$arr_new["num"][]=$v;
			}
			
			for($i=0;$i<count($arr_new["title"]);$i++){
				$arr_end[$i]["title"]=$arr_new["title"][$i];
				$a[$i]=M("warehouse")->field("title,lever")->where("id='".$arr_new["title"][$i]."'")->find();
				$arr_end[$i]["warehouse"]=$a[$i]["title"];
				$arr_end[$i]["lever"]=$a[$i]["lever"];
				$arr_end[$i]["num"]=$arr_new["num"][$i];
			}
		return $arr_end;
	}
	
	function w_1_ruku(){
//		统计未审核入库单
		$count1=M("goods_into")->where("state=0 and action_state=1 and program_id='".$_COOKIE["program_id"]."'")->group("group_num")->select();
//		统计已审核入库单
		$count2=M("goods_into")->where("state=1 and action_state=1 and program_id='".$_COOKIE["program_id"]."'")->group("group_num")->select();

		$this->count_1=count($count1);
		$this->count_2=count($count2);
//		供应商
		$this->supplier=M("supplier")->where("program_id='".$_COOKIE["program_id"]."'")->select();
		
//		1级仓柜
		$this->warehouse=M("warehouse")->where("lever=1 and program_id='".$_COOKIE["program_id"]."'")->select();
		
//		分类
		$fl=M("attribute")
		->field('id,uid,title,image_1,is_show,title_english')
		->where("dsh_id=0 and attribute_style=4 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$this->fenlei=$this->bq($fl);

		$this->arr=array(1,2,3,4,5,6,7,8,9,10);
		$this->display();
	}
function ajax_goods_info(){
	$data=M("goods")->field("id,goods_title,ktv_kucun")->where("goods_baiye=1 and fenlei_2='".$_POST["fenlei_2"]."'")->select();
	for($i=0;$i<count($data);$i++){
		
		$b[$i]=json_decode($data[$i]["ktv_kucun"],true);
		foreach($b[$i] as $k=>$v){ 
			if($k==$_POST["warehouse01"]){//出仓数量
				$num[$i]=$v;
			}
		}
		$data[$i]["on_num"]=($num[$i]?$num[$i]:0);
//		if($num[$i]>0){
//			$data[]=$data[$i];
//		}	
	}
	
	$this->ajaxReturn($data);
}

function ajax_eq_warehouse(){
	$a=M("warehouse")->where("id='".$_POST["warehouse01_id"]."'")->find();
	
	$where["lever"]=$a["lever"];
	$where["id"]=array("neq",$a["id"]);
	$data=M("warehouse")->where($where)->select();
	
	$this->ajaxReturn($data);
}

	function com_goods_info($child_id){

		for($i=0;$i<count($child_id);$i++){
			$a[$i]=M("goods")->field("id,goods_title")->where("fenlei_2='".$child_id[$i]["id"]."'")->select();
				
			$child_id[$i]["goods_info"]=$a[$i];
		}
		
			return $child_id;
	}
	function goods_shenhe(){
		
		$this->text=$_GET["text"];
		
//		if($_GET["action_state"]==1){
//			$where["action_state"]=1;
//		}else if($_GET["action_state"]==2){
//			$where["action_state"]=2;
//		}else if($_GET["action_state"]==3){
//			$where["action_state"]=3;
//		}else if($_GET["action_state"]==4){
//			$where["action_state"]=4;
//		}else if($_GET["action_state"]==5){
//			$where["action_state"]=5;
//		}
		$where["action_state"]=$_GET["action_state"];
		$where["state"]=0;
		$where["program_id"]=$_COOKIE["program_id"];
	
		$list=M("goods_into")->where($where)->group("group_num")->select();
		
		for($i=0;$i<count($list);$i++){
			$a[$i]=M("goods_into")->where("group_num='".$list[$i]["group_num"]."'")->select();
			
			$a[$i]=$this->goods_into_info($val=$a[$i]);
			
			
			$list[$i]["count_num"]=count($a[$i]);
			$list[$i]["shenhe_info"]=$a[$i];
		}

		$this->list=$list;
		$this->display();
	}
	function goods_into_info($val){
		
		for($i=0;$i<count($val);$i++){
			$b[$i]=M("goods")->field("goods_title")->where("id='".$val[$i]["goods_id"]."'")->find();
			if($val[$i]["action_state"]==1){
				$c[$i]=M("supplier")->field("title")->where("id='".$val[$i]["supplier_id"]."'")->find();
				$val[$i]["supplier"]=$c[$i]["title"];
			}else if($val[$i]["action_state"]==2){
				
			}else if($val[$i]["action_state"]==3){
				
			}
			
			$d[$i]=M("warehouse")->field("title")->where("id='".$val[$i]["to_ck"]."'")->find();//出仓
			$e[$i]=M("warehouse")->field("title")->where("id='".$val[$i]["from_ck"]."'")->find();//入仓
			
			$val[$i]["warehouse"]=$d[$i]["title"];
			$val[$i]["warehouse_ru"]=$e[$i]["title"];
			$val[$i]["goods_title"]=$b[$i]["goods_title"];
		}
		return $val;
	}
	function goods_shenhe02(){
		$this->done=1;
		$this->text=$_GET["text"];
		
//		if($_GET["action_state"]==1){
//			$where["action_state"]=1;
//		}else if($_GET["action_state"]==2){
//			$where["action_state"]=2;
//		}
$where["action_state"]=$_GET["action_state"];
		$where["state"]=1;
		$where["program_id"]=$_COOKIE["program_id"];
		$list=M("goods_into")->where($where)->group("group_num")->select();

		for($i=0;$i<count($list);$i++){
			$a[$i]=M("goods_into")->where("group_num='".$list[$i]["group_num"]."'")->select();
			
			$a[$i]=$this->goods_into_info($val=$a[$i]);
			$list[$i]["count_num"]=count($a[$i]);
			$list[$i]["shenhe_info"]=$a[$i];
		}

		$this->list=$list;
		$this->display();
	}
	function shenhe(){
		
		if($_POST["ok_no"]=="ok"){
				$save["state"]=1;
				$save["time_shenhe"]=time();
			}else if($_POST["ok_no"]=="no"){
				$save["state"]=2;
				$save["time_none"]=time();
			}

			if(M("goods_into")->where("group_num='".$_POST["group_num"]."'")->save($save)){
				if($_POST["ok_no"]=="ok"){
					$a=M("goods_into")->where("group_num='".$_POST["group_num"]."'")->select();
					for($i=0;$i<count($a);$i++){
					
						$save02[$i]["ktv_kucun"]=$this->save_num_action($goods_id=$a[$i]["goods_id"],$ck_state=$a[$i]["action_state"],$from_ck=$a[$i]["from_ck"],$to_ck=$a[$i]["to_ck"],$add_num=$a[$i]["num"]);
						if($a[$i]["to_ck"]==3){//在线酒水上线
							$save02[$i]["goods_state"]=1;
							$save02[$i]["by_onlinebear"]=1;
						}
						M("goods")->where(("id='".$a[$i]["goods_id"]."'"))->save($save02[$i]);
					}
				}
				$data=1;
			}else{
				$data=0;
			}
	
		
		$this->ajaxReturn($data);
	}
	
	function save_num_action($goods_id,$ck_state,$from_ck,$to_ck,$add_num){
		$a=M("goods")->field("ktv_kucun")->where("id='".$goods_id."'")->find();
		$b=json_decode($a["ktv_kucun"],true);
		foreach($b as $k=>$v){ 
			$have_key[]=$k;
			}
			
//		$ck_state=3;
		if($ck_state==1 |$ck_state==6){//进入总库存 1：商品第一次进仓，商品补货进仓
//			$from_ck=0;
//			$to_ck=1;
//			$add_num=100;
		
			if(in_array($to_ck,$have_key)){//有数据
				foreach($b as $k=>$v){ 
					if($k==$to_ck){
						$b[$k]=$v+$add_num;
					}
				}
			}else{
				$b[$to_ck]=$add_num;
			}
			
		}else if($ck_state==2 | $ck_state==3| $ck_state==4){//调拨   两个仓之间呼唤
//			$from_ck=1;
//			$to_ck=22;
//			$add_num=11;
			
			if(in_array($to_ck,$have_key)){//有数据
				foreach($b as $k=>$v){	
					if($k==$from_ck){
						if($add_num>$v){
//							$this->ajaxReturn(array("state"=>-1,"msg"=>"调拨数量错误"));
							return -1;
						} 
						
						$b[$k]=$v-$add_num;
					}
					if($k==$to_ck){
						$b[$k]=$v+$add_num;
					}
				}
			}else{
				foreach($b as $k=>$v){ 
					if($k==$from_ck){
						$b[$k]=$v-$add_num;
					}
				}
				$b[$to_ck]=$add_num;
			}
		}else if($ck_state==5){
			
//			$from_ck=1;
//			$to_ck=0;
//			$add_num=5;
			foreach($b as $k=>$v){ 
			if($k==$from_ck){
			
				if($add_num>$v){
//					$this->ajaxReturn(array("state"=>-2,"msg"=>"退货数量错误"));
					return -2;
				} 
					$b[$k]=$v-$add_num;
				}
			}
		}
		
		$save=json_encode($b);
		
		return $save;
	}
	
	function run_ruku_add(){
		

		$group_num="JT".time().rand(1111,9999);
		$time=time();
		for($i=0;$i<count($_POST["a100"]);$i++){
			if($_GET["action_state"]=="ruku"){
//					入库单
					$action_state=1;				
					$add[$i]["supplier_id"]=$_POST["supplier"][$i];
					$add[$i]["to_ck"]=$_POST["warehouse"][$i];
					$add[$i]["from_ck"]=0;
			}else if($_GET["action_state"]=="chuku"){
//					出库单
					$action_state=2;
					$add[$i]["to_ck"]=$_POST["warehouse"][$i];
					$add[$i]["from_ck"]=$_POST["warehouse01"][$i];
			}else if($_GET["action_state"]=="diaobo"){
//					调拨单
					$action_state=3;
					$add[$i]["to_ck"]=$_POST["warehouse"][$i];
					$add[$i]["from_ck"]=$_POST["warehouse01"][$i];
			}else if($_GET["action_state"]=="tuiku"){
//					退库单
					$action_state=4;
					$add[$i]["from_ck"]=$_POST["warehouse"][$i];
					$add[$i]["to_ck"]=$_POST["warehouse01"][$i];
			}else if($_GET["action_state"]=="tuihuo"){
//					退库单
					$action_state=5;
					$add[$i]["from_ck"]=$_POST["warehouse"][$i];
					$add[$i]["to_ck"]=0;
			}else if($_GET["action_state"]=="zhibo"){
//					直拨单
					$action_state=6;
					$add[$i]["supplier_id"]=$_POST["supplier"][$i];
					$add[$i]["to_ck"]=$_POST["warehouse"][$i];
					$add[$i]["from_ck"]=0;
			}
			
			
			$add[$i]["program_id"]=$_COOKIE["program_id"];
			$add[$i]["goods_id"]=$_POST["goods"][$i];
			$add[$i]["num"]=$_POST["num"][$i];
			$add[$i]["time_set"]=$time;
			$add[$i]["state"]=0;
			$add[$i]["action_state"]=$action_state;//入库属性1：入库单、2：出库单
			$add[$i]["group_num"]=$group_num;
			
			
			M("goods_into")->add($add[$i]);
		}		
		 $this->success('添加成功');
	}
	function w_2_chuku(){
//		统计未审核出库单
		$count1=M("goods_into")->where("state=0 and action_state=2 and program_id='".$_COOKIE["program_id"]."'")->group("group_num")->select();
//		统计已审核出库单
		$count2=M("goods_into")->where("state=1 and action_state=2 and program_id='".$_COOKIE["program_id"]."'")->group("group_num")->select();

		$this->count_1=count($count1);
		$this->count_2=count($count2);
//		一级仓柜
		$this->warehouse01=M("warehouse")->where("lever=1 and program_id='".$_COOKIE["program_id"]."'")->select();
				
//		二级仓柜
		$this->warehouse=M("warehouse")->where("lever=2 and program_id='".$_COOKIE["program_id"]."'")->select();
		
//		分类
		$fl=M("attribute")
		->field('id,uid,title,image_1,is_show,title_english')
		->where("dsh_id=0 and attribute_style=4 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$this->fenlei=$this->bq($fl);

		$this->arr=array(1,2,3,4,5,6,7,8,9,10);
		$this->display();
	}
	function w_3_tuiku(){
//		统计未审核退库单
		$count1=M("goods_into")->where("state=0 and action_state=4 and program_id='".$_COOKIE["program_id"]."'")->group("group_num")->select();
//		统计已审核退库单
		$count2=M("goods_into")->where("state=1 and action_state=4 and program_id='".$_COOKIE["program_id"]."'")->group("group_num")->select();

		$this->count_1=count($count1);
		$this->count_2=count($count2);
//		一级仓柜
		$this->warehouse01=M("warehouse")->where("lever=1 and program_id='".$_COOKIE["program_id"]."'")->select();
				
//		二级仓柜
		$this->warehouse=M("warehouse")->where("lever=2 and program_id='".$_COOKIE["program_id"]."'")->select();
		
//		分类
		$fl=M("attribute")
		->field('id,uid,title,image_1,is_show,title_english')
		->where("dsh_id=0 and attribute_style=4 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$this->fenlei=$this->bq($fl);

		$this->arr=array(1,2,3,4,5,6,7,8,9,10);
		$this->display();
	}
	function w_4_diaobo(){
//		统计未审核调拨单
		$count1=M("goods_into")->where("state=0 and action_state=3 and program_id='".$_COOKIE["program_id"]."'")->group("group_num")->select();
//		统计已审核调拨单
		$count2=M("goods_into")->where("state=1 and action_state=3 and program_id='".$_COOKIE["program_id"]."'")->group("group_num")->select();

		$this->count_1=count($count1);
		$this->count_2=count($count2);
		
		//		分类
		$fl=M("attribute")
		->field('id,uid,title,image_1,is_show,title_english')
		->where("dsh_id=0 and attribute_style=4 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$this->fenlei=$this->bq($fl);
		
		//		非级仓柜
		$where["lever"]=array("neq",1);
		$where["program_id"]=$_COOKIE["program_id"];
		$a=$this->warehouse=M("warehouse")->where($where)->select();

		$this->arr=array(1,2,3,4,5,6,7,8,9,10);
		$this->display();
	}
	function w_5_baosun(){
		
	}
	function w_6_pandian(){
		
	}
	function w_7_tuihuo(){
//		统计未审核调拨单
		$count1=M("goods_into")->where("state=0 and action_state=5 and program_id='".$_COOKIE["program_id"]."'")->group("group_num")->select();
//		统计已审核调拨单
		$count2=M("goods_into")->where("state=1 and action_state=5 and program_id='".$_COOKIE["program_id"]."'")->group("group_num")->select();

		$this->count_1=count($count1);
		$this->count_2=count($count2);
        //		供应商
        $this->supplier=M("supplier")->where("program_id='".$_COOKIE["program_id"]."'")->select();
//		分类
		$fl=M("attribute")
		->field('id,uid,title,image_1,is_show,title_english')
		->where("dsh_id=0 and attribute_style=4 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$this->fenlei=$this->bq($fl);
		
//		一级仓柜
		$where["lever"]=array("eq",1);
		$where["program_id"]=$_COOKIE["program_id"];
		$a=$this->warehouse=M("warehouse")->where($where)->select();

		$this->arr=array(1,2,3,4,5,6,7,8,9,10);
		$this->display();
	}
	function w_8_zhibo(){
//		统计未审核入库单
		$count1=M("goods_into")->where("state=0 and action_state=6 and program_id='".$_COOKIE["program_id"]."'")->group("group_num")->select();
//		统计已审核入库单
		$count2=M("goods_into")->where("state=1 and action_state=6 and program_id='".$_COOKIE["program_id"]."'")->group("group_num")->select();

		$this->count_1=count($count1);
		$this->count_2=count($count2);
//		供应商
		$this->supplier=M("supplier")->where("program_id='".$_COOKIE["program_id"]."'")->select();
		
//		非1级仓柜
		$where["lever"]=array("neq",1);
		$where["program_id"]=$_COOKIE["program_id"];
		$a=$this->warehouse=M("warehouse")->where($where)->select();
		
//		分类
		$fl=M("attribute")
		->field('id,uid,title,image_1,is_show,title_english')
		->where("dsh_id=0 and attribute_style=4 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$this->fenlei=$this->bq($fl);

		$this->arr=array(1,2,3,4,5,6,7,8,9,10);
		$this->display();
	}
	function w_add_goods(){

		$this->arr=array(1,2,3,4,5,6,7,8,9,10);
		$this->str=array(1,2);
		$this->fenlei_1=M("attribute")->where("is_show=1 and attribute_style=4 and uid=0 and program_id='".$_COOKIE["program_id"]."'")->select();
		
		$fl=M("attribute")
		->field('id,uid,title,image_1,is_show,title_english')
		->where("dsh_id=0 and attribute_style=4 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$all_fenlei=$this->fenlei=$this->bq($fl);
		
		$this->supplier=M("supplier")->where("program_id='".$_COOKIE["program_id"]."'")->select();	

		$this->display();
	}
	//	商品总览
	public function w_all_goods(){
		$a=M("goods")->where("goods_baiye=1 and program_id='".$_COOKIE["program_id"]."'")->select();

		for($i=0;$i<count($a);$i++){
			
			$b[$i]=M("attribute")->where("id='".$a[$i]["fenlei_1"]."'")->find();
			$c[$i]=M("attribute")->where("id='".$a[$i]["fenlei_2"]."'")->find();
			
			$a[$i]["fenlei_1_title"]=$b[$i]["title"];
			$a[$i]["fenlei_2_title"]=$c[$i]["title"];
		}
	
		$this->list=$a;
		
		$fl=M("attribute")
		->field('id,uid,title,image_1,is_show,title_english')
		->where("dsh_id=0 and attribute_style=4 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$all_fenlei=$this->fenlei=$this->bq($fl);
		
	
		$this->display();
	}
	
//	及时库存
	public function w_onsave_goods(){
		$a=M("goods")->where("goods_baiye=1 and program_id='".$_COOKIE["program_id"]."'")->select();

		for($i=0;$i<count($a);$i++){
			
			$b[$i]=M("attribute")->where("id='".$a[$i]["fenlei_1"]."'")->find();
			$c[$i]=M("attribute")->where("id='".$a[$i]["fenlei_2"]."'")->find();
			
			$a[$i]["fenlei_1_title"]=$b[$i]["title"];
			$a[$i]["fenlei_2_title"]=$c[$i]["title"];
		}
	
		$this->list=$a;
		
		$fl=M("attribute")
		->field('id,uid,title,image_1,is_show,title_english')
		->where("dsh_id=0 and attribute_style=4 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$all_fenlei=$this->fenlei=$this->bq($fl);
		
	
		$this->display();
	}
	public function goods_add(){
		 //商品标签
		 $this->label=M("goods_label")->where("id")->select(); 
		 
		 //一级分类名 dsh_id
		$this->fenlei=M("attribute")
		->field('id,uid,title')
		->where("uid=0 and attribute_style=4 and dsh_id=0 and program_id='".$_COOKIE["program_id"]."'")->select();
		
		//遍历小程序的会员等级，设置不同会员的会员价
		
		
		$field=M("member_level")->where("program_id='".$_COOKIE["program_id"]."'")->select();
		
		for($i=0;$i<count($field);$i++){
			$member_price=M("member_price")->where("lever_id='".$field[$i]["id"]."'")->find();
			$field[$i]["price"]=$member_price["price"];
		}
		
		
		//判断这个小程序有没有买商品消费码的功能 
		$a=M("store")->where("program_id='".$_COOKIE["program_id"]."'")->find();
		if($a["is_on_shop_use"]==1){
			//是否开启商品交易到店使用功能
			$this->is_on_shop_use="1";
		}else{
			$this->is_on_shop_use="2";
		}
		
		$this->guige_num= 0;
		$this->preferential=M("preferential")->where("pre_mode=2 and program_id='".$_COOKIE["program_id"]."'")->select();
		
			//判断小程序设置
		$this->store=$a;

		
		$this->lever=$field;
		$this->display();
	}
	public function goods_edit(){
	
		$info=M('goods')->where("id=".$_GET['id'])->find();
		
		$kkkk=M("preferential")->where("id='".$info["preferential_id"]."'")->find();
		$info["preferential_title"]=$kkkk["title"];
//商品所有图片 
		$arr=explode(",",$info["image"]);
		$info["image"]=$arr;
			
//获得商品参数
		$canshu=M("specifications")->where("goods_id='".$_GET['id']."'")->find();		
		$this->canshu=	$arr=$this->str_to_arr($canshu["title"],$canshu["content"]);

 //商品标签
		$goods_label=M("goods_label")->where("id")->select(); 	 
		$arr_goods_label=explode(",",$info["goods_label"]);
		 for($o=0;$o<count($goods_label);$o++){
		 	if(in_array($goods_label[$o]["id"],$arr_goods_label)){
		 		$goods_label[$o]["is_choose"]=1;
		 	}else{
		 		$goods_label[$o]["is_choose"]=2;
		 	}
		 }
		
		$this->label=$goods_label;
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
		->where("uid=0 and is_show=1 and attribute_style=4 and program_id='".$_COOKIE["program_id"]."'")->select();

	if(!empty($info["str_guige"])){
		//遍历商品的规格
		$arr1128_1=explode(',',$info["str_img"]);
		$arr1128_2=explode(',',$info["str_guige"]);
		$arr1128_3=explode(',',$info["str_remark"]);
		$arr1128_4=explode(',',$info["str_price"]);
		$arr1128_5=explode(',',$info["str_num"]);
		
		$arr1128_6=explode(',',$info["str_guige02"]);
		for($q1=0;$q1<count($arr1128_1);$q1++){
			$arr1128[$q1]["img"]	=$arr1128_1[$q1];
			$arr1128[$q1]["guige"]	=$arr1128_2[$q1];
			$arr1128[$q1]["remark"]	=$arr1128_3[$q1];
			$arr1128[$q1]["price"]	=$arr1128_4[$q1];
			$arr1128[$q1]["num"]	=$arr1128_5[$q1];
		}	
		for($q2=0;$q2<count($arr1128_6);$q2++){
			$arr1207[$q2]["guige02"]=$arr1128_6[$q2];
		}
		
	
	
		$this->guige 	= $arr1128;
		$this->guige_num= count($arr1128);
		$this->guige02	= $arr1207;
	}else{
		$this->guige_num= 1;
	}
	
		
//遍历小程序的会员等级，设置不同会员的会员价
		$field=M("member_level")->where("program_id='".$_COOKIE["program_id"]."'")->select();
		
		for($i=0;$i<count($field);$i++){
			$member_price=M("member_price")->where("goods_id='".$_GET['id']."'"."and lever_id='".$field[$i]["id"]."'")->find();
			$field[$i]["price"]=$member_price["price"];
			$field[$i]["discount"]=$member_price["discount"];
		}
		$this->lever=$field;

		//调用批发价的数据
		$this->wholesale=M("wholesale_discount")->where("goods_id='".$_GET["id"]."'")->select();
		
		//判断这个小程序有没有买商品消费码的功能 
		$a=M("store")->where("program_id='".$_COOKIE["program_id"]."'")->find();
		if($a["is_on_shop_use"]==1){
			//是否开启商品交易到店使用功能
			$this->is_on_shop_use="1";
		}else{
			$this->is_on_shop_use="2";
		}
		$this->preferential=M("preferential")->where("pre_mode=2 and program_id='".$_COOKIE["program_id"]."'")->select();
		//判断小程序设置
		$this->store=$a;

		$this->is_edit="1";
		$this->display('goods_add');
	}
	public function goods_add_ktv(){
	

			
//获得商品参数
		$canshu=M("specifications")->where("goods_id='".$_GET['id']."'")->find();		
		$this->canshu=	$arr=$this->str_to_arr($canshu["title"],$canshu["content"]);
		
		//遍历商品分类
		$this->fenlei=M("attribute")
		->field('id,uid,title')
		->where("uid=0 and is_show=1 and attribute_style=4 and program_id='".$_COOKIE["program_id"]."'")->select();


		$this->preferential=M("preferential")->where("pre_mode=2 and program_id='".$_COOKIE["program_id"]."'")->select();
		//判断小程序设置
		$this->store=$a;

		$this->is_edit="1";
		$this->display('goods_ktv');
	}
	public function goods_edit_ktv(){
	
		$info=M('goods')->where("id=".$_GET['id'])->find();
		
		$kkkk=M("preferential")->where("id='".$info["preferential_id"]."'")->find();
		$info["preferential_title"]=$kkkk["title"];
//商品所有图片 
		$arr=explode(",",$info["image"]);
		$info["image"]=$arr[0];
	
			
//获得商品参数
		$canshu=M("specifications")->where("goods_id='".$_GET['id']."'")->find();		
		$this->canshu=	$arr=$this->str_to_arr($canshu["title"],$canshu["content"]);
		
//能量ktv商品内容列表
		$arr02=explode("^",$info["content_list"]);
		$this->content_list=	$arr02;		
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
		->where("uid=0 and is_show=1 and attribute_style=4 and program_id='".$_COOKIE["program_id"]."'")->select();


		$this->preferential=M("preferential")->where("pre_mode=2 and program_id='".$_COOKIE["program_id"]."'")->select();
		//判断小程序设置
		$this->store=$a;

		$this->is_edit="1";
		$this->display('goods_ktv');
	}

	//异步获得子类
	public function ajax_fenlei_2(){
		//需要主类 id
		$where01["uid"]="0";
		$where01["attribute_style"]="4";
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

		for($i=0;$i<count($_POST["a100"]);$i++){
			$add[$i]["program_id"]=$_COOKIE["program_id"];
			$add[$i]["fenlei_1"]=$_POST["a10"][$i];
			$add[$i]["fenlei_2"]=$_POST["a100"][$i];
			$add[$i]["goods_title"]=$_POST["a11"][$i];
			$add[$i]["goods_baiye"]=1;
			
			$add[$i]["ktv_guige"]=$_POST["a12"][$i];
			$add[$i]["ktv_danwei"]=$_POST["a13"][$i];
			M("goods")->add($add[$i]);
		}		
		 $this->success('添加成功');
	}

	 //异步删除图片
	public function ajax_delete_img(){
		//得到那条  好消息 的id、和对应的图片的位置键值，对数据的字符串进行删减
		
		$info=M('goods')->where("id='".$_POST["id"]."'")->find();
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
		if(M("goods")->where("id='".$_POST["id"]."'")->save($str_new)){
			
			unlink('./Uploads/'.$arr[$_POST["key"]]);
			
			$date="1";//保存并删除旧图片成功
		}else{
			$date="2";//操作失败
		}
		$this->ajaxReturn($date);
	}
	
	 //异步删除规格
	public function ajax_delete_guige(){
	//得到商品id，得到商品规格的key值，
		//state  =1;删除一级规格内容、=2删除二级规格内容
		$info=M('goods')->where("id='".$_POST["id"]."'")->find();
		
		if($_POST["state"]==1){
			$arr01=explode(",",$info["str_img"]);//字符串转换成数组    
			$arr02=explode(",",$info["str_guige"]);
			$arr03=explode(",",$info["str_remark"]);
			$arr04=explode(",",$info["str_num"]);
			$arr05=explode(",",$info["str_price"]);
			for($i=0;$i<count($arr01);$i++){ 
				if($i != $_POST["key"]){
					$arr_new01[]=$arr01[$i];
					$arr_new02[]=$arr02[$i];
					$arr_new03[]=$arr03[$i];
					$arr_new04[]=$arr04[$i];
					$arr_new05[]=$arr05[$i];
				}
			}
			$str_new["str_img"]		=implode(",",$arr_new01);//数组转换成 字符串   这个就是新的需要存的数据
			$str_new["str_guige"]	=implode(",",$arr_new02);
			$str_new["str_remark"]	=implode(",",$arr_new03);
			$str_new["str_num"]		=implode(",",$arr_new04);
			$str_new["str_price"]	=implode(",",$arr_new05);
			if($str_new==","){
				$str_new=null;
			}
		}else if($_POST["state"]==2){
			$arr011=explode(",",$info["str_guige02"]);//字符串转换成数组    
			for($i=0;$i<count($arr01);$i++){ 
				if($i != $_POST["key"]){
					$arr_new011[]=$arr011[$i];
				}
			}
			$str_new["str_guige02"]=implode(",",$arr_new011);//数组转换成 字符串   这个就是新的需要存的数据
			if($str_new==","){
				$str_new=null;
			}
		}
		if(M("goods")->where("id='".$_POST["id"]."'")->save($str_new)){
			unlink('./Uploads/'.$arr01[$_POST["key"]]);
			$date="1";//保存并删除旧图片成功
		}else{
			$date="2";//操作失败
		}
		$this->ajaxReturn($date);
	}
	//删除商品
		public function goods_delete(){
				 $user_id = $_GET['id'];
	        if(M('goods')->delete($user_id)) {
	        	
	        	$a=M('goods')->where("id='".$_GET["id"]."'")->find();

	        		$arr=explode(",",$a["image"]);
					for($i=0;$i<count($arr);$i++){
						unlink('./Uploads/'.$arr[$i]);
					}
	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
		}
		function goods_deletektv(){
			 if(M('goods')->where("id='".$_POST["id"]."'")->delete()) {
	        	
	           $data=1;
	        } else {
	             $data=0;
	        }
	        $this->ajaxReturn($data);
		}
		
		function goods_savektv(){	
		
//			if(M('goods')->where("id='".$_POST["id"]."'")->save($_POST)) {
//	           $data=1;
//	        } else {
//	             $data=0;w_1_ruku
//	        }
M('goods')->where("id='".$_POST["id"]."'")->save($_POST);
 $data=1;
	        $this->ajaxReturn($data);
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
	
	
	
	//精品商品管理
	
	function jingpin(){
		//广告
		
	$image=	$this->image=$image=M("store")->field('image_jingpin')->where("program_id='".$_COOKIE["program_id"]."'")->find();
  		

  		//精品商品列表
  		$where["program_id"]=$_COOKIE["program_id"];
  		$where["is_jingpin"]="1";
  		
  		$this->goods=$goods=M("goods")->where($where)->select();

  		$this->display();
	}
	
	//精品广告图保存
	function jingpin_save(){
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =  3145728 ;// 设置附件上传大小
		$upload->exts      =  array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath  =   './Uploads/'; // 设置附件上传根目录
		 // 上传文件 
		$info   =   $upload->upload();
		if($info){
                $receive['image_jingpin']=$info['image_jingpin']['savepath'].$info['image_jingpin']['savename'];	    
				
				if(M('store')->where("program_id='".$_COOKIE["program_id"]."'")->save($receive)){
				    	$this->success('操作成功',U('jingpin'));
				    }else{
				    	$this->error('操作失败');	
				    }
			    
			}else{
			    	$this->error('无上传图片');	
                	$error=$upload->getError();
		    		$data=array("status" => -1, "msg" => "图片上传失败",'error'=>$error);
			
			}	    
	}
	//异步修改商品是否加精品
	function ajax_jingpin(){
		$state=M("goods")->where("id='".$_POST["id"]."'")->find();
	
			if($state["is_jingpin"]==1){
				$val["is_jingpin"]="2";
			}else if($state["is_jingpin"]==2){
				$val["is_jingpin"]="1";
			}
			
			if(M("goods")->where("id='".$_POST["id"]."'")->save($val)){
					$date="1";
			}else{
					$date="2";
			}
			$this->ajaxReturn($date);
	}
		//异步修改商品是否可以使用消费码
	function change_state(){
		$state=M("goods")->where("id='".$_POST["id"]."'")->find();
	
			if($state["is_use_consumption_num"]==1){
				$val["is_use_consumption_num"]="0";
			}else if($state["is_use_consumption_num"]==0){
				$val["is_use_consumption_num"]="1";
			}
			
			if(M("goods")->where("id='".$_POST["id"]."'")->save($val)){
					$date="1";
			}else{
					$date="2";
			}
			$this->ajaxReturn($date);
	}
	//代理商品价格管理
	function price_daili(){
		$this->list=M("fx_lever_independent")->where("program_id='".$_COOKIE["program_id"]."'")->select();
		
		$this->display();
	}
	  //异步修改分销金额
    function ajax_change_text(){
		if($_POST["style"]==1){
				$save[$_POST["text_name"]]=$_POST["text_val"];
				if(M("fx_lever_independent")->where("id='".$_POST["id"]."'")->save($save)){
						$date="1";
					}else{
						$date="2";
					}
			
		}
		$this->ajaxReturn($date);
		
	}
	
	//删除批发价格信息
	function delete_pifa(){
		
		
		if(M("wholesale_discount")->where("id='".$_POST["id"]."'")->delete()){
					$date="1";
			}else{
					$date="2";
			}
			$this->ajaxReturn($date);
	}
	
//	已售商品汇总
	function goods_havedsell(){
		
//		$where["state"]=array("in","2,3,4,7");
		$where["id"]=array("in","2890,2900,2906");
		$where["program_id"]=$_COOKIE["program_id"];
		$a=M("order_form")->field("id,state,array_id,order_num,time_fukuan,buy_price,pay_method")->where($where)->select();

		$num="-1";
		for($i=0;$i<count($a);$i++){
			$a[$i]["array_id"] = substr($a[$i]["array_id"],0,strlen($a[$i]["array_id"])-1);
			
			$b[$i]["goods_info"]=$this->goods_buylist($a[$i]["array_id"]);
			
			if(count($b[$i]["goods_info"])==1){
				$arr[$num+1]=$b[$i]["goods_info"][0];
				$arr[$num+1]["time_fukuan"]=$a[$i]["time_fukuan"];
				
				$arr_goods_id[$num+1]=$b[$i]["goods_info"][0]["goods_id"];
				$num+=1;
			}else{
				for($i2=0;$i2<count($b[$i]["goods_info"]);$i2++){
					$arr[$num+1]=$b[$i]["goods_info"][$i2];
					$arr[$num+1]["time_fukuan"]=$a[$i]["time_fukuan"];
					
					$arr_goods_id[$num+1]=$b[$i]["goods_info"][$i2]["goods_id"];
					$num+=1;
				}
			}
		}
		$arr_goods_id_new	= array_unique($arr_goods_id);//数组去重复
	
		$arr_goods_id_new	=explode(",",implode(",",$arr_goods_id_new));
		
		$count_goods_id		= array_count_values ($arr_goods_id);//统计重复值出现次数的数组

		for($i2=0;$i2<count($arr_goods_id_new);$i2++){
			$arr_new[]=$this->for_arr_new($arr,$arr_goods_id_new[$i2],$count_goods_id);
		}
	
		$this->count_goods_id	=$count_goods_id;
		$this->goods_sell_list	=$arr_new;
		
		$this->display();
	}
	function for_arr_new($arr,$arr_goods_id_new){
	
		for($i3=0;$i3<count($arr);$i3++){
			$str_image[$i3]=explode(",",$arr[$i3]["image"]);
			$arr[$i3]["image"]=$str_image[$i3][0];
			
			if($arr[$i3]["goods_id"]==$arr_goods_id_new){
				$arr_new=$arr[$i3];
				break;
			}
		}
		return $arr_new;
	}
	
	function goods_buylist($order_strid){
		
		$arr=explode(",",$order_strid);
		$field="order.id,order.goods_id,order.buy_num,goods.goods_title,goods.image,goods.price_sell";
		
		for($i=0;$i<count($arr);$i++){
			$a[$i]=M("order")->field($field)
			->join("left join goods on goods.id = order.goods_id")
			->where("order.id='".$arr[$i]."'")->find();
		}
		return $a;
		
	}
	
}