<?php
namespace Hl\Controller;
use Think\Controller;
class SecondhandController extends CommonController {
	

    public function index(){

		$id=$_COOKIE["program_id"];
		
		//完成的订单数
		$a1=$this->order_form_1=M('order_form')->where("state=7 and program_id='".$_COOKIE["program_id"]."'")->count();

		//代发货
		$a2=$this->order_form_2=M('order_form')->where("state=2 and program_id='".$_COOKIE["program_id"]."'")->count();
		
		//退换/售后
		$a3=$this->order_form_5=M('order_form')->where("state=5 and program_id='".$_COOKIE["program_id"]."'")->count();
		//	dump($a1;dump($a2);dump($a3);die;
    	$this->display();
	}
	
	
	//首页推荐
	public function index_re(){
			$a=M("index_recommend")->where("program_id='".$_COOKIE["program_id"]."'")->find();
		
		$arr=explode(",",$a["recommend_text"]);
			
		$this->index_recommend=$arr;
		$this->display();
	}
	
	//自定义商品路径
	public function self_url_goods(){

		$where['_string']=' (goods_title like "%'.$_POST["title"].'%") ';
		$where["program_id"]=$_COOKIE["program_id"];
		$data=M("h_goods")->field('id,goods_title')->where($where)->select();

		for($i=0;$i<count($data);$i++){
			$a["goods_id"]=$data[$i]["id"];
			$b=M("h_goods_img")->where($a)->find();
			$data[$i]["image"]=$b["image"];
		}
		$this->ajaxReturn($data);	
	}
	//自定义商户路径
	public function self_url_merch(){
		//商品姓名搜索商品
		$where['_string']=' (sh_name like "%'.$_POST["title"].'%") ';
		$where["program_id"]=$_COOKIE["program_id"];
		$where["state"]=3;
		$data=M("h_user_info_dsh")->field('id,sh_name,logo')->where($where)->select();
		
		$this->ajaxReturn($data);	
	}
	//打开自定义选择页面
	public function choose_list(){
		//商品分类列表
		$fl=M("h_attribute")
		->field('id,uid,title,image_1,is_show')
		->where("dsh_id=0 and attribute_style=1 and is_show=1 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$all_fenlei=$this->fenlei=$this->bq($fl);
	
		$this->ajaxReturn($all_fenlei);
		
	}

	//递归
	function bq($arr,$p=0){ $ar=array(); foreach($arr as $v){ if($v["uid"]==$p){ $v["child"]=$this->bq($arr,$v["id"]);$ar[]=$v;}} return $ar;}
	
	//异步修改 开关
	function ajax_change_show(){
//修改显示与否   幻灯片  from_id=1    、广告  from_id=2、导航图标	 from_id=3	   分类 from_id=4   宜拖车分类 from_id=5

	switch ($_POST["from_id"]) {
    case 1:
       $state=M("h_huandeng")->field("is_show")->where("id='".$_POST["id"]."'")->find();//幻灯片
        break;
    case 2:
        $state=M("h_ad")->field("is_show")->where("id='".$_POST["id"]."'")->find();//广告
        break;
    case 3:
        $state=M("h_direction")->field("is_show")->where("id='".$_POST["id"]."'")->find();//导航图标
        break;
    case 4:
        $state=M("h_attribute")->field("is_show")->where("id='".$_POST["id"]."'")->find();//分类
        break;
    case 5:
        $state=M("h_car_fenlei")->field("is_show")->where("id='".$_POST["id"]."'")->find();//分类
        break;
}
		
	if($state["is_show"]==1){
		$val["is_show"]="2";
	}else if($state["is_show"]==2){
		$val["is_show"]="1";
	}
			
	if($_POST["from_id"]==1){
		if(M("h_huandeng")->where("id='".$_POST["id"]."'")->save($val)){
					$date="1";
			}else{
					$date="2";
			}
	}else if($_POST["from_id"]==2){
		if(M("h_ad")->where("id='".$_POST["id"]."'")->save($val)){
					$date="1";
			}else{
					$date="2";
			}
	}else if($_POST["from_id"]==3){
		if(M("h_direction")->where("id='".$_POST["id"]."'")->save($val)){
					$date="1";
			}else{
					$date="2";
			}
	}else if($_POST["from_id"]==4){
		if(M("h_attribute")->where("id='".$_POST["id"]."'")->save($val)){
					$date="1";
			}else{
					$date="2";
			}
	}else if($_POST["from_id"]==5){
		if(M("h_car_fenlei")->where("id='".$_POST["id"]."'")->save($val)){
					$date="1";
			}else{
					$date="2";
			}
	}
				
			
			
			$this->ajaxReturn($date);
	}
	
	//异步修改列表页 内容
	function ajax_change_text(){
//style   1:商品表内容、
	if($_POST["style"]==1){
		$save[$_POST["text_name"]]=$_POST["text_val"];
		if(M("h_goods")->where("id='".$_POST["id"]."'")->save($save)){
				$date="1";
			}else{
				$date="2";
			}
		}
	$this->ajaxReturn($date);	
	}
	
	//文章管理============================================================================
	public function artical(){

		$where['program_id']=$_COOKIE["program_id"];
		
		$field='id,title,sort,is_show';
		$aa=$this->ad=M('h_artical')->field($field)->where($where)->order("sort")->select();

		$this->display();
	}
	public function artical_add(){
		
		$this->display();
	}
	public function artical_edit(){
		 $a= $this->info=M('h_artical')->where("id=".$_GET['id'])->find();
	
		$this->display('artical_add');
	}
	public function run_artical_add(){
		$receive=I();
		$receive["program_id"]=$_COOKIE["program_id"];

		 if(empty($_GET['id'])) {

		     if(M('h_artical')->add($receive)){
		    	$this->success('添加成功',U('IndexZiXun/artical'));
		    }else{
		    	$this->error('添加失败');	
		    } 
        }else {
		     if(M('h_artical')->where(array('id'=>$_GET['id']))->save($receive)){
		    	$this->success('修改成功',U('IndexZiXun/artical'));
		    }else{
		    	$this->error('修改失败');	
		    }

			}
    }   
	
	public function artical_delete(){
		$user_id = $_GET['id'];

        if(M('h_artical')->delete($user_id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
	}
	function ajax_re(){
		$save["recommend_text"]=$_POST["con"];
		if(M("index_recommend")->where("program_id='".$_COOKIE["program_id"]."'")->save($save)){
			$date=array("state"=>1,"msg"=>"修改成功");
		}else{
			$date=array("state"=>-1,"msg"=>"修改失败");
		}
		$this->ajaxReturn($date);
	}
	
	
//	商品模块   0
	 function goods_commem_0127($str,$goods_state,$str_f){
		if(isset($str)){
			$where['_string']='
				(id like "%'.$str.'%")  
				OR (goods_title like "%'.$str.'%")
			';
		}
		if($goods_state==0){
			$where["goods_state"]=array("in","1,3");//只显示上架和下架的
		}else{
			$where["goods_state"]=$goods_state;
		}
		$where["program_id"]=$_COOKIE["program_id"];
		$where["goods_baiye"]=0;
		$where["attribute_style02"]=3;
        $total = D("h_goods")->where($where)->count();
        $per = 6;
      
        $page = new \Component\Page($total, $per); 
        $sql = "select * from h_goods  where  attribute_style02=3  and program_id='".$_COOKIE["program_id"]."'";
        if(isset($str)){
        	$sql.=" and (goods_title like '"."%".$str."%"."'"." or id like '"."%".$str."%"."'".")";
        }
        if($goods_state==0){
			$sql.=" and goods_state in (1,3) ";
		}else{
			$sql.=" and goods_state='".$goods_state."'";
		}
		$sql .=" order by sort asc ";
        $sql .=$page->limit;

        $info = D("h_goods") -> query($sql);
        $pagelist = $page -> fpage();
        
        	for($i=0;$i<count($info);$i++){
					//商品图片
					$arr1102=explode(",",$info[$i]['image']);
					$info[$i]["image"]=$arr1102[0];

				//查找商品是哪个子商户的 dsh_id
				$info[$i]["sh_name"]=M("h_user_info_dsh")->field('sh_name')->where("id='".$info[$i]['dsh_id']."'")->find();
					
				}
        
        $a[0]=$info;
        $a[1]=$pagelist;
        return $a;
	}
	//出售中
	public function selling(){
		$this->his_str=$_GET["str"];
		$a=$this->goods_commem_0127($str=$_GET["str"],$goods_state=0,$str_f=$_GET["str_f"]);
		$info=$a[0];$pagelist=$a[1];
        $this -> assign('goods', $info);
        $this -> assign('pages', $pagelist);
        
		$this->program_id=$_COOKIE["program_id"];
		
		$this->display();
	}
	

	//售罄
	public function haved_selled(){

		 $a=$this->goods_commem_0127($str=$_GET["str"],$goods_state=2,$str_f=$_GET["str_f"]);
		$info=$a[0];$pagelist=$a[1];
        $this -> assign('goods', $info);
        $this -> assign('pages', $pagelist);
        
 
		
		$this->display();
	}
	//仓库中
	public function cangku(){

		 $a=$this->goods_commem_0127($str=$_GET["str"],$goods_state=3,$str_f=$_GET["str_f"]);
		$info=$a[0];$pagelist=$a[1];
        $this -> assign('goods', $info);
        $this -> assign('pages', $pagelist);
	
		$this->display();
	}
	//回收站
	public function huishou(){

		 $a=$this->goods_commem_0127($str=$_GET["str"],$goods_state=4,$str_f=$_GET["str_f"]);
		$info=$a[0];$pagelist=$a[1];
        $this -> assign('goods', $info);
        $this -> assign('pages', $pagelist);
		
		$this->display();
	}
	
	public function goods_add(){

		 //一级分类名 dsh_id
		$this->fenlei=M("h_attribute")
		->field('id,uid,title')
		->where("uid=0 and attribute_style=1 and attribute_style02=2 and dsh_id=0 and program_id='".$_COOKIE["program_id"]."'")->select();
		

		$this->display();
	}
	public function goods_edit(){
	
		$info=M('h_goods')->where("id=".$_GET['id'])->find();
	

//商品所有图片 
		$arr=explode(",",$info["image"]);
		$info["image"]=$arr;
			
//获得商品参数
		$canshu=M("h_specifications")->where("goods_id='".$_GET['id']."'")->find();		
		$this->canshu=	$arr=$this->str_to_arr($canshu["title"],$canshu["content"]);


//一级分类名
		$fenlei1611=M("h_attribute")->where("id='".$info["fenlei_1"]."'")->find();
		$info["fenlei_1_title"]=$fenlei1611["title"];
//二级分类名
		$fenlei1612=M("h_attribute")->where("id='".$info["fenlei_2"]."'")->find();
		$info["fenlei_2_title"]=$fenlei1612["title"];
	
		 $this->info=$info;
		//遍历商品分类
		$this->fenlei=M("h_attribute")
		->field('id,uid,title')
		->where("uid=0 and is_show=1 and attribute_style=1 and attribute_style02=2 and program_id='".$_COOKIE["program_id"]."'")->select();

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


		$this->is_edit="1";
		$this->display('goods_add');
	}
	
	public function run_goods_add(){


		if($_POST["goods_subtitle"])$_POST["good_attribute"]	= $_POST["goods_subtitle"];	
		
		$_POST["program_id"]		= $_COOKIE["program_id"];
		
		if($_POST["fenlei_1_title"]){
			$fenlei_1=M("h_attribute")->where("uid=0 and attribute_style=1 and attribute_style02=2 and title='".$_POST["fenlei_1_title"]."'"."and program_id='".$_COOKIE["program_id"]."'")->find();
			$_POST["fenlei_1"]=$fenlei_1["id"];
		}
		
		$fenlei_2=M("attribute")->where("uid !=0 and title='".$_POST["fenlei_2_title"]."'")->find();
		$_POST["fenlei_2"]=$fenlei_2["id"];


		if($_POST["canshu_title"]) $str1026["title"]	= implode(",",$_POST["canshu_title"]);//参数名数组	
		if($_POST["canshu_con"]) $str1026["content"]  	= implode(",",$_POST["canshu_con"]);//参数值数组	
		
		if($_POST["content_list_str"]) $_POST["content_list"]= implode("^",$_POST["content_list_str"]);//参数名数组	
	
		if($_POST["guige"])		$_POST["str_guige"]  	= implode(",",$_POST["guige"]);//1128 商品规格
		if($_POST["price"])		$_POST["str_price"]  	= implode(",",$_POST["price"]);//1128 商品规格
		if($_POST["num"])		$_POST["str_num"]  		= implode(",",$_POST["num"]);//1128 商品规格
		if($_POST["remark"])	$_POST["str_remark"]  	= implode(",",$_POST["remark"]);//1128 商品规格
		if($_POST["guige02"])	$_POST["str_guige02"]  	= implode(",",$_POST["guige02"]);//1128 商品规格

	
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =  3145728 ;// 设置附件上传大小
		$upload->exts      =  array('jpg', 'gif', 'png', 'jpeg','mp4');// 设置附件上传类型
		$upload->rootPath  =   './Uploads/'; // 设置附件上传根目录
		// 上传文件 
		$info   =   $upload->upload();

		$check_imgchange=0;
		for($n=0;$n<count($_POST["changeimg_key"]);$n++){
			$check_imgchange+=$_POST["changeimg_key"][$n];
		}
		if($check_imgchange>count($info)){
			//有图片未上传	
			foreach($info as $k0627=>$v0627){
				unlink('./Uploads/'.$info[$k0627]["savepath"].$info[$k0627]["savename"]);
			}

			$this->error('规格必须上传图片');	
		}
		

		if($info){
//有上传图片的地方进来
		foreach($info as $k=>$v){
			if($info[$k]['key']=="image"){
			    $date['image'].=$info[$k]['savepath'].$info[$k]['savename'].",";
			}else if($info[$k]['key']=="img"){
			    $date['img'].=$info[$k]['savepath'].$info[$k]['savename'].",";
			}
		}			
		$arr_0302=explode(".",$info["goods_video"]['savename']);
			if($arr_0302[1]=="mp4"){
				$_POST["goods_video"]=$info["goods_video"]['savepath'].$info["goods_video"]['savename'];
			}
					
			$_POST['image']   		= substr($date['image'],0,strlen($date['image'])-1); 	//去掉最后一个逗号
			
			if($check_imgchange==0){
				//无规格图修改
				$_POST['str_img'] 	= substr($date['img'],0,strlen($date['img'])-1); 		//去掉最后一个逗号
			}else{
				$guige_img			=substr($date['img'],0,strlen($date['img'])-1);
				$guige_img_arr		=explode(",",$guige_img);
				
				$old_guige_img=M("h_goods")->field("str_img")->where("id='".$_GET["id"]."'")->find();
//				dump($old_guige_img);
				$old_guige_img_arr	=explode(",",$old_guige_img["str_img"]);
				
				if( count($_POST["changeimg_key"]) > count($old_guige_img_arr) ) {
					for( $count_dif=0;$count_dif<(count($_POST["changeimg_key"]) - count($old_guige_img_arr) );$count_dif++){ $old_guige_img_arr[]=""; }
				}
				
				$change_key=0;
				for($guige=0;$guige<count($_POST["changeimg_key"]);$guige++){
					if($_POST["changeimg_key"][$guige]==1){
						$old_guige_img_del_arr[$guige]=$old_guige_img_arr[$guige];
						$old_guige_img_arr[$guige]=$guige_img_arr[$change_key];
						$change_key++;
					}
				}
				$old_guige_img_del_str	=implode(",",$old_guige_img_del_arr);
				$new_guige_img_str		=implode(",",$old_guige_img_arr);
//				dump($new_guige_img_str);DIE;
				$_POST['str_img'] 		= $new_guige_img_str;
			}
			
		}else{
			//无上传文件 
				
		}

		$_POST["time_update"]=time();
		if(empty($_GET["id"])){
			$_POST["attribute_style02"]=2;
			//执行添加
			$_POST["time_set"]			= time();
			$only=M("h_goods")->where("time_set='".$_POST["time_set"]."'")->find();
			if(empty($only)){
				if(empty($_POST['image'])) $this->error('必须上传商品图片');
				if(M("h_goods")->add($_POST)){
					$set_img=M("h_goods")->where("time_set='".$_POST["time_set"]."'")->find();
//1026...22.24 多条数据改写成一条
						$str1026["goods_id"]=$set_img["id"];
						M("h_specifications")->add($str1026);//商品参数
					$this->success('添加成功',U('selling'));
			    }else{
			    	$this->error('添加失败');	
			    }
			}
		}else{
			//执行修改
	 		$goods1103=M("h_goods")->where("id='".$_GET["id"]."'")->find();	
	 		if($_COOKIE["program_id"] !="JT201808090855119076"){
	 			if(!empty($goods1103["image"]) ){
	 			$_POST["image"]=(empty($_POST["image"]))?$goods1103["image"]:$goods1103["image"].",".$_POST["image"];
	 		}	
	 		}
	 		
			
	 		if(!empty($goods1103["str_img"])){
	 			if($check_imgchange==0){
	 				$_POST["str_img"]=(empty($_POST["str_img"]))?$goods1103["str_img"]:$goods1103["str_img"].",".$_POST["str_img"];
	 			}
	 		}		
	
	 		if(M("h_goods")->where("id='".$_GET["id"]."'")->save($_POST)){

			//删除这个商品的全部参数，然后重新赋值  1026...22.27改写
				if($check_imgchange!=0){
					$old_guige_img_delarr=explode(",",$old_guige_img_del_str);
					for($del_guige=0;$del_guige<count($old_guige_img_delarr);$del_guige++){
						unlink('./Uploads/'.$old_guige_img_delarr[$del_guige]);
					}
				}
		
		 		$is_null1107=M("h_specifications")->where("goods_id='".$_GET["id"]."'")->find();
		 				$str1026["goods_id"]=$_GET["id"];
		 		if(empty($is_null1107)){
		 		
		 			M("h_specifications")->add($str1026);
		 		}else{
		 			
		 			M("h_specifications")->where("goods_id='".$_GET["id"]."'")->save($str1026);
		 			
		 		}
		 		
	 			$this->success('修改成功',U('selling'));
		    }else{
		    	$this->error('修改失败');	
		    }
		}
	
//1128...14.15  增加了新的模块：商品规格-----先把东西存入规格表，然后根据页面传递过来的唯一标识参数，找到那个id，然后写入商品的表里面

		
	}
	
	 //异步删除图片
	public function ajax_delete_img(){
		//得到那条  好消息 的id、和对应的图片的位置键值，对数据的字符串进行删减
		
		$info=M('h_goods')->where("id='".$_POST["id"]."'")->find();
		
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
		if(M("h_goods")->where("id='".$_POST["id"]."'")->save($str_new)){
			
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
		$info=M('h_goods')->where("id='".$_POST["id"]."'")->find();
		
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
		if(M("h_goods")->where("id='".$_POST["id"]."'")->save($str_new)){
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
	        if(M('h_goods')->delete($user_id)) {
	        	
	        	$a=M('h_goods')->where("id='".$_GET["id"]."'")->find();

	        		$arr=explode(",",$a["image"]);
					for($i=0;$i<count($arr);$i++){
						unlink('./Uploads/'.$arr[$i]);
					}
	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
		}
		
		public function goods_huishou(){
			$date["goods_state"]="4";
			if(M('h_goods')->where("id='".$_GET["id"]."'")->save($date)) {
	            $this->success('回收成功');
	        } else {
	            $this->error('回收失败');
	        }
		}
		public function goods_huishou_back(){
			$date["goods_state"]="3";
			if(M('h_goods')->where("id='".$_GET["id"]."'")->save($date)) {
	            $this->success('回收成功');
	        } else {
	            $this->error('回收失败');
	        }
		}

	//商品分类
	public function fenlei(){

		$fl=M("h_attribute")
		->field('id,uid,title,image_1,is_show,title_english,sort')
		->where("dsh_id=0 and attribute_style=1 and attribute_style02=3 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$all_fenlei=$this->fenlei=$this->bq($fl);

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
		 $a= $this->info=M('h_attribute')->where("id=".$_GET['id'])->find();
	
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
			    
			    if($info){
			    	 $receive['image_1']=$info['image02']['savepath'].$info['image02']['savename'];
			    }
			    
			    if(empty($_GET['id'])){
			    	$receive["dsh_id"]=0;
					$receive["attribute_style"]=1;
					$receive["attribute_style02"]=3;
					
				    if(M('h_attribute')->add($receive)){
				    	$this->success('添加成功.',U('fenlei'));
				    }else{
				    	$this->error('添加失败.');	
				    }
			    }else{
			    	  if(M('h_attribute')->where(array('id'=>$_GET['id']))->save($receive)){
			//如果对一级分类进行隐藏，则对应的二级分类都要隐藏
			        	$a0926=M("h_attribute")->where("id='".$_GET["id"]."'")->find();	
			        	if($a0926["uid"]==0){
			        		$date0926["is_show"]="3";
			        		M("h_attribute")->where("uid='".$_GET["id"]."'")->save($date0926);
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
			$d_zhu_img=M('h_attribute')->where("id='".$_GET['id']."'")->find();
	        $d_zi_img=M('h_attribute')->where("uid='".$_GET['id']."'")->select();
	        	
	        if(M('h_attribute')->delete($user_id)) {
	        	//删除主类图片
	        	unlink('./Uploads/'.$d_zhu_img["image_1"]);
	        	
	        	
	        	//删除 所属 子类 图片
	        	for($i=0;$i<count($d_zi_img);$i++){
	        		unlink('./Uploads/'.$d_zi_img[$i]["image_1"]);
	        	}
	        	
	        	//删除 所属 子类  数据
	 
	        	M('h_attribute')->where("uid='".$_GET['id']."'")->delete();
	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
		}
		public function fenlei_delete02(){		
				$d_img=M('h_attribute')->where("id='".$_GET['id']."'")->find();
				 $user_id = $_GET['id'];
	        if(M('h_attribute')->delete($user_id)) {
	        	//删除对应子类图片
	        	
	        	unlink('./Uploads/'.$d_img["image_1"]);

	           $this->success('删除成功');
	        } else {
	           $this->error('删除失败');
	        }
		}
		
		
			//商品异步上下架
	function ajax_change_ok(){
	$state=M("h_goods")->field("goods_state")->where("id='".$_POST["id"]."'")->find();

		//  goods_state  商品状态（1：在售、2：售罄、3：仓库中、4：回收站）
			if($state["goods_state"]==1){
				$val["goods_state"]="3";
			}else if($state["goods_state"]==3){
				$val["goods_state"]="1";
			}
			
			if(M("h_goods")->where("id='".$_POST["id"]."'")->save($val)){
					$date="1";
			}else{
					$date="2";
			}
			$this->ajaxReturn($date);
	}
		
//		批量上传 0
		  function fileupload(){
  
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");


        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            exit; // finish preflight CORS requests here
        }

        if ( !empty($_REQUEST[ 'debug' ]) ) {
            $random = rand(0, intval($_REQUEST[ 'debug' ]) );
            if ( $random === 0 ) {
                header("HTTP/1.0 500 Internal Server Error");
                exit;
            }
        }

// header("HTTP/1.0 500 Internal Server Error");
// exit;


// 5 minutes execution time  5分钟执行时间
        @set_time_limit(5 * 60);

// Uncomment this one to fake upload time
        usleep(5000);

// Settings
// $targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
        $riqi = date("Y-m-d",time());
        $path = "./Uploads/".$riqi;
        if (!file_exists($path)){
            mkdir($path);
        }

        $targetDir = 'upload_tmp';
        $uploadDir = $path;//上传文件存储路径

        $cleanupTargetDir = true; // Remove old files
        $maxFileAge = 5 * 3600; // Temp file age in seconds


// Create target dir
        if (!file_exists($targetDir)) {
            @mkdir($targetDir);
        }

// Create target dir
        if (!file_exists($uploadDir)) {
            @mkdir($uploadDir);
        }

// Get a file name
        if (isset($_REQUEST["name"])) {
            //   $fileName = $_REQUEST["name"];

            $type001=substr(strrchr($_REQUEST["name"], '.'), 1);
            $ls_yzm=rand(10000,99999);
            $_REQUEST["name"]=date("Ymd",time()).$ls_yzm.'.'.$type001;
            $fileName = $_REQUEST["name"];

            //拼接存储
            $goods=M("h_goods")->where("id='".$_GET["goods_id"]."'")->find();
	            $goods_arr=explode(",",$goods["image"]);
	            $save["image"]=date("Y-m-d",time())."/".$fileName;
	            if(empty($goods_arr)){
	                M("h_goods")->where("id='".$_GET["goods_id"]."'")->save($save);
	            }else{
	                if(in_array($save["image"],$goods_arr)){
	
	                }else{
	                    $save0215["image"]=$goods["image"].",".$save["image"];
	                    M("h_goods")->where("id='".$_GET["goods_id"]."'")->save($save0215);
	                }
	            }
            
          

            $oldPath="./upload/".$fileName;
            $newPath="./Uploads/".date("Y-m-d",time())."/".$fileName;
            copy($oldPath, $newPath);//文件移动
            unlink($oldPath);

        } elseif (!empty($_FILES)) {
            $fileName = $_FILES["file"]["name"];
        } else {
            $fileName = uniqid("file_");
        }

        $md5File = @file('md5list.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $md5File = $md5File ? $md5File : array();

        if (isset($_REQUEST["md5"]) && array_search($_REQUEST["md5"], $md5File ) !== FALSE ) {
            die('{"jsonrpc" : "2.0", "result" : null, "id" : "id", "exist": 1}');
        }

        $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
        $uploadPath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;

// Chunking might be enabled   组块可能会启用
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 1;


// Rmove old temp filees   Rmove旧的临时文件
        if ($cleanupTargetDir) {
            if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
            }

            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

                // If temp file is current file proceed to the next
                if ($tmpfilePath == "{$filePath}_{$chunk}.part" || $tmpfilePath == "{$filePath}_{$chunk}.parttmp") {
                    continue;
                }

                // Remove temp file if it is older than the max age and is not the current file
                if (preg_match('/\.(part|parttmp)$/', $file) && (@filemtime($tmpfilePath) < time() - $maxFileAge)) {
                    @unlink($tmpfilePath);
                }
            }
            closedir($dir);
        }


// Open temp file      打开临时文件
        if (!$out = @fopen("{$filePath}_{$chunk}.parttmp", "wb")) {
            die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }

        if (!empty($_FILES)) {
            if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
            }

            // Read binary input stream and append it to temp file
            if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        } else {
            if (!$in = @fopen("php://input", "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        }
        /* 4096*/
        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }

        @fclose($out);
        @fclose($in);

        rename("{$filePath}_{$chunk}.parttmp", "{$filePath}_{$chunk}.part");

        $index = 0;
        $done = true;
        for( $index = 0; $index < $chunks; $index++ ) {
            if ( !file_exists("{$filePath}_{$index}.part") ) {
                $done = false;
                break;
            }
        }
        if ( $done ) {
            if (!$out = @fopen($uploadPath, "wb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
            }

            if ( flock($out, LOCK_EX) ) {
                for( $index = 0; $index < $chunks; $index++ ) {
                    if (!$in = @fopen("{$filePath}_{$index}.part", "rb")) {
                        break;
                    }

                    while ($buff = fread($in, 4096)) {
                        fwrite($out, $buff);
                    }

                    @fclose($in);
                    @unlink("{$filePath}_{$index}.part");
                }

                flock($out, LOCK_UN);
            }
            @fclose($out);
        }

// Return Success JSON-RPC response
        die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
    }

//		批量上传 1


//	商品模块   1
	
}