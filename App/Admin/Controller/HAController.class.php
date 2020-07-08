<?php
namespace Admin\Controller;
use Think\Controller;
class HAController extends Controller {
    public function index(){


		$this->display();
	}
	
	function a1102_21_58(){
		$arr1102=explode(",",$e[$i]['image']);
			$e[$i]["image_first"]=$arr1102[0];
		
		
			//$b=M("goods_img")->field('id,image')->where($where03)->select();//第一张是缩略图，之后是大图
		$arr=explode(",",$a["image"]);
			
		for($i1102=0;$i1102<count($arr);$i1102++){
			$b[$i1102]["image"]=$arr[$i1102];
		}
	
	}
	function a1102_2135(){
		//对商品表优化 舍弃 goods_img表
		$a=M("goods_img_copy")->group("goods_id")->select();


		for($i=0;$i<count($a);$i++){
			$where["goods_id"]=$a[$i]["goods_id"];
			
			$b=M("goods_img_copy")->where($where)->select();
			
		
			for($k=0;$k<count($b);$k++){
				if(!empty($b[$k]["image"])){
					$str01[$i].=$b[$k]["image"].",";
				}
			}
			
			 $c[$i]["image"] = substr($str01[$i],0,strlen($str01[$i])-1); //去掉最后一个逗号
			 
				
			M("goods_copy")->where("id='".$a[$i]["goods_id"]."'")->save($c[$i]);

	}
		
	}
	
	public function dd(){
		//对字符串图片转换成数组
				$a=M("jt03_zx_good_news")->select();
			for($i=0;$i<count($a);$i++){
				$a[$i]["arr"]=explode(",",$a[$i]["image"]);
			}
			dump($a);
			$this->aa=$a;
	}
	
	public function a1026_2202(){
		//把分开存储的数据变成一条数据存储
		
			/*$a=M("specifications_copy")->group("goods_id")->select();
		for($i=0;$i<count($a);$i++){
			$where["goods_id"]=$a[$i]["goods_id"];
			
			$b=M("specifications_copy")->where($where)->select();
			
			
			for($k=0;$k<count($b);$k++){
				$str01.=$b[$k]["title"].",";
				$str02.=$b[$k]["content"].",";
			}
			 $str01 = substr($str01,0,strlen($str01)-1); //去掉最后一个逗号
			 $str02 = substr($str02,0,strlen($str02)-1); //去掉最后一个逗号
			
			$save["goods_id"]=$a[$i]["goods_id"];
			$save["sort"]="1";
			$save["title"]=$str01;
			$save["content"]=$str02;
			$str01=null;
			$str02=null;
			M("specifications")->add($save);
		}
		dump($a);die;  //11111111111111111111*/
		$a=M("specifications_copy")->group("goods_id")->select();
		for($i=0;$i<count($a);$i++){
			$where["goods_id"]=$a[$i]["goods_id"];
			
			$b=M("specifications_copy")->where($where)->select();
			
			
			for($k=0;$k<count($b);$k++){
				$str01.=$b[$k]["title"].",";
				$str02.=$b[$k]["content"].",";
			}
			 $str01 = substr($str01,0,strlen($str01)-1); //去掉最后一个逗号
			 $str02 = substr($str02,0,strlen($str02)-1); //去掉最后一个逗号
			//dump($str01);dump($str02);die;
			$save["goods_id"]=$a[$i]["goods_id"];
			$save["sort"]="1";
			$save["title"]=$str01;
			$save["content"]=$str02;
			
			M("specifications")->add($save);
		}
		dump($a);die;
	}
		public function d2d(){
		//异步删除图片数据
		$a=M("jt03_zx_good_news")->select();
			for($i=0;$i<count($a);$i++){
				$a[$i]["arr"]=explode(",",$a[$i]["image"]);
			}
			dump($a);
			$this->aa=$a;
		
	}
	public function img_upload(){
		
		//$b = substr($b,0,strlen($b)-1); //去掉最后一个逗号
	//	dump($_FILES['image']);die;
				$upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =     3145728 ;// 设置附件上传大小
			    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录

			    // 上传文件 
			 //   $info   =   $upload->upload(array($_FILES['image']));
			    $info   =   $upload->upload();
		
			 if($info){
			 	for($i=0;$i<count($info);$i++){
			 		$receive['title'].=$info[$i]['savepath'].$info[$i]['savename'].",";
			 	}
			 	  $receive['title'] = substr($receive['title'],0,strlen($receive['title'])-1); //去掉最后一个逗号
				 dump($receive);die;
                    $receive['title']=$info['image']['savepath'].$info['image']['savename'];

			     if(M('test')->add($receive)){
			    	$this->success('添加成功',U('huandeng'));
			    }else{
			    	$this->error('添加失败');	
			    }
			    
			    }else{
			    	$this->error('无上传图片');	
                	$error=$upload->getError();
		    		$data=array("status" => -1, "msg" => "图片上传失败",'error'=>$error);
			    }
	}
	
	public function get_info($state,$style,$str,$str_f){
		$where["program_id"]=$_COOKIE["program_id"];
		$where["state"]=$state;	//只显示能正常的
		$where["style"]=$style;
		//两个字段的模糊搜索  str=》id、名称    str_f=》分类 
		 if(!empty($str)){
			//	$str=$_POST['str'];     //如果接收到搜索关键字,执行模糊查询 返回数据
				
				//模糊查询 id、名称、编号、条码、商户名称
				$where['_string']='
					(id like "%'.$str.'%")  
					OR (title like "%'.$str.'%")
				';
				$list=M("jt03_zx_info")
				->field('id,sort,title,tel,state,style,fenlei01,time_input,time_agree')
				->where($where)
				->order("sort")
				->select();//对id、名称的模糊搜索
				$list["www"]="1";
			}else if(!empty($str_f)){
			//根据商品分类的id查询 商品列表	
			$list= M("jt03_zx_info")->query("
				select * from 
				jt03_zx_info 
				left outer join  
				( select attribute.id as attribute_id,attribute.title as attribute_title from attribute where title like '%".$str_f."%'"."  ) c 
				on jt03_zx_info.fenlei01=c.attribute_id
				where jt03_zx_info.program_id='".$_COOKIE["program_id"]."'"." and jt03_zx_info.state='".$state."'"." and jt03_zx_info.style='".$style."'"."	
			");
					$list["www"]="2";
			}else{
				$list=M("jt03_zx_info")
				->field('id,sort,title,tel,state,style,fenlei01,time_input,time_agree')
				->where($where)
				->order("sort")
				->select();
						$list["www"]="3";
			}
			
			return $list;
	}
}