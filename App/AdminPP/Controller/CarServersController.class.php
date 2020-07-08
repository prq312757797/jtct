<?php
namespace AdminPP\Controller;
use Think\Controller;
class CarServersController extends CommonController {
	//车种服务管理   车牌管理 car_num   司机管理 driver
	
	
	//车牌管理============================================================================
	
	public function car_num(){

		$where['program_id']=$_COOKIE["program_id"];
		
	
		$aa=M('car_num')->where($where)->order("sort")->select();
		
		for($i=0;$i<count($aa);$i++){
			
			
			$a[$i]=	M("car_allcar")->where("id='".$aa[$i]["car_id"]."'")->find();
			$aa[$i]["car_name"]=$a[$i]["title"];
			
			$b[$i]=	M("car_fenlei")->where("id='".$a[$i]["fenlei_id"]."'")->find();
			$aa[$i]["feilei_name"]=$b[$i]["title"];
			
			//绑定司机名
			$driver[$i]=M("car_manerger")->where("id='".$aa[$i]["driver_id"]."'")->find();
			$aa[$i]["driver_name"]=$driver[$i]["name"];
			
			//如果找不到对应司机，那就释放绑定
			if(empty($driver[$i])){
			$save["is_tire_driver"]=0;
			$save["time_tird"]=null;
			$save["driver_id"]=0;

			 M('car_num')->where("id='".$aa[$i]["id"]."'")->save($save);
			}
		}
	
		$this->ad=$aa;
		$this->display();
	}
	public function car_num_add(){
		$car_allcar=M("car_allcar")->where("is_show=1 and program_id='".$_COOKIE["program_id"]."'")->select();	
	
	for($i=0;$i<count($car_allcar);$i++){
		$a[$i]=	M("car_fenlei")->where("id='".$car_allcar[$i]["fenlei_id"]."'")->find();
		$car_allcar[$i]["feilei_name"]=$a[$i]["title"];
	}
		
	
		$this->car_id=$car_allcar;
		$this->display();
	}
	public function car_num_edit(){
		//车号信息
		 $a= M('car_num')->where("id=".$_GET['id'])->find();
	
	//车种信息
	$a1=	M("car_allcar")->where("id='".$a["car_id"]."'")->find();
			$a["car_name"]=$a1["title"];
			
			$b1=	M("car_fenlei")->where("id='".$a1["fenlei_id"]."'")->find();
			$a["feilei_name"]=$b1["title"];
	$this->info=$a;

	//车子分类列表
		$car_id=M("car_allcar")->where("is_show=1 and program_id='".$_COOKIE["program_id"]."'")->select();	
		
		
		$this->car_id=$car_id;
		$this->display('car_num_add');
	}
	public function run_car_num_add(){
		$receive=I();
		$receive["program_id"]=$_COOKIE["program_id"];

		 if(empty($_GET['id'])) {

			     if(M('car_num')->add($receive)){
			    	$this->success('添加成功',U('CarServers/car_num'));
			    }else{
			    	$this->error('添加失败');	
			    } 
        }else {
			     if(M('car_num')->where(array('id'=>$_GET['id']))->save($receive)){
			    	$this->success('修改成功',U('CarServers/car_num'));
			    }else{
			    	$this->error('修改失败');	
			    }

			}
       }   
	
		public function car_num_delete(){
		
			$user_id = $_GET['id'];
	
	        if(M('car_num')->where("id='".$_GET['id']."'")->delete()) {
	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
		}

//司机选择列表
		
		function driver_choose(){
			$car_num=$this->car_num=M("car_num")->where("id='".$_GET["car_num_id"]."'")->find();
			
			
			$where=array(
				'program_id'=>$_COOKIE["program_id"]
			);
		
		//昵称、姓名、手机号的模糊搜索  str=》昵称、姓名、手机号
		 if(isset($_POST['str'])){
				$str=$_POST['str'];     //如果接收到搜索关键字,执行模糊查询 返回数据
				//模糊查询 id、名称、编号、条码、商户名称
				$where['_string']='
					(name like "%'.$str.'%")  
					OR (linktel like "%'.$str.'%")
				';
				$where["is_admin_set"]=1;
				$where["tied_car_num_id"]=0;
			}else{
				$where["is_admin_set"]=1;
				$where["tied_car_num_id"]=0;
			}
			$aa=M("car_manerger")->where($where)->select();
			for($i=0;$i<count($aa);$i++){
				$b[$i]=M("car_num")->where("id='".$aa[$i]["tied_car_num_id"]."'")->find();
				
				$aa[$i]["car_num"]=$b[$i]["car_num"];
			}

			$this->ad=$aa;
			
			
			$this->display();
		}
//司机管理============================================================================
	
	public function driver(){
		$where['program_id']=$_COOKIE["program_id"];
		$where['is_admin_set']=1;

		$aa=M('car_manerger')->where($where)->order("time_admin_set desc")->select();

for($i=0;$i<count($aa);$i++){
	$b[$i]=M("car_num")->where("id='".$aa[$i]["tied_car_num_id"]."'")->find();
	
	$aa[$i]["car_num"]=$b[$i]["car_num"];
}

		$this->ad=$aa;

		$this->display();
	}
	public function driver_add(){
		//车场列表
		
		$this->list=M("car_parking")->where("program_id='".$_COOKIE["program_id"]."'")->order("sort")->select();
		
		
		//信息绑定码
		$this->code_tied="JT".time().rand(111,999);
		$this->display();
	}
	public function driver_edit(){
		 $a= M('car_manerger')->where("id=".$_GET['id'])->find();
		$z=M("car_parking")->where("id='".$a["parking_id"]."'")->find();
		$a["address"]=$z["address"];
		
		$this->info=$a;
	//车场列表
		$this->list=M("car_parking")->where("program_id='".$_COOKIE["program_id"]."'")->order("sort")->select();
		$this->display('driver_add');
	}
	public function run_driver_add(){
		$receive=I();
		$receive["program_id"]=$_COOKIE["program_id"];

		$upload = new \Think\Upload();// 实例化上传类
	    $upload->maxSize   =     3145728 ;// 设置附件上传大小
	    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
	    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
	    // 上传文件 
	    $info   =   $upload->upload();
	
	    if($info){
	    	if(!empty($info['headimage'])){
	    		$receive['headimage']=$info['headimage']['savepath'].$info['headimage']['savename'];
	    	}
	    	if(!empty($info['idcard_positive'])){
	    		$receive['idcard_positive']=$info['idcard_positive']['savepath'].$info['idcard_positive']['savename'];
	    	}
			if(!empty($info['idcars_reverse'])){
	    		$receive['idcars_reverse']=$info['idcars_reverse']['savepath'].$info['idcars_reverse']['savename'];
	    	}
			if(!empty($info['driver_license'])){
	    		$receive['driver_license']=$info['driver_license']['savepath'].$info['driver_license']['savename'];
	    	}
			if(!empty($info['driving_this'])){
	    		$receive['driving_this']=$info['driving_this']['savepath'].$info['driving_this']['savename'];
	    	}
	    }


		 if(empty($_GET['id'])) {
				$receive["time_admin_set"]=time();
				$receive["is_admin_set"]=1;
				$receive["state_register"]=2;
				$receive["state"]=1;
				$receive["time_register"]=time();
				$receive["time_agree"]=time();
			     if(M('car_manerger')->add($receive)){
			    	$this->success('添加成功',U('CarServers/driver'));
			    }else{
			    	$this->error('添加失败');	
			    } 
        }else {
			     if(M('car_manerger')->where(array('id'=>$_GET['id']))->save($receive)){
			    	$this->success('修改成功',U('CarServers/driver'));
			    }else{
			    	$this->error('修改失败');	
			    }

			}
       }   
	
		public function driver_delete(){
		
			$user_id = $_GET['id'];
	
	        if(M('car_manerger')->delete($user_id)) {
	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
		}
		
		
		//设置绑定
		function tied_on(){
			//对车牌状态改变，对司机个人添加信息
			
			$save["is_tire_driver"]=1;
			$save["time_tird"]=time();
			$save["driver_id"]=$_GET["id"];
			
			$a=M('car_num')->where("id='".$_GET["car_num_id"]."'")->find();
			
			 if(M('car_num')->where("id='".$_GET["car_num_id"]."'")->save($save)){
			 	
			 	if($a["driver_id"]!=0){
			 		$save02["tied_car_num_id"]=0;
			 		M('car_manerger')->where("id='".$a["driver_id"]."'")->save($save02);
			 	}
			 		$save03["tied_car_num_id"]=$_GET["car_num_id"];
				 	M('car_manerger')->where("id='".$_GET["id"]."'")->save($save03);
			 	

	            $this->success('绑定成功',U('CarServers/driver'));
	        } else {
	            $this->error('绑定失败');
	        }
		}
		
		//取消绑定
		function tied_out(){
			
			$save["tied_car_num_id"]=0;
			 if(M('car_manerger')->where("id='".$_GET["id"]."'")->save($save)) {
	            $this->success('取消绑定成功');
	        } else {
	            $this->error('取消绑定失败');
	        }
		}
		
		

}