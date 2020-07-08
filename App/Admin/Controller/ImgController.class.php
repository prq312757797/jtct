<?php
namespace Admin\Controller;
use Think\Controller;
class ImgController extends Controller {
    public function index(){

				
				
		$this->display();
	}
	
	function img(){
		echo 11;
		//  dump($_FILES);die;
		$upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =     3145728 ;// 设置附件上传大小
			    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录

			    // 上传文件 
			 //   $info   =   $upload->upload(array($_FILES['image']));
			    $info   =   $upload->upload();
			  dump($info);die;
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
			  //dump($info);die;
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
				( select attribute.id as attribute_id,attribute.title as attribute_title from attribute where attribute_style='1' and title like '%".$str_f."%'"."  ) c 
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