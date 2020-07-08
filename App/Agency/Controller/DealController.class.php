<?php
namespace Agency\Controller;
use Think\Controller;
header('content-type:application:json;charset=utf8'); 
header('Access-Control-Allow-Origin:*'); 
//header('Access-Control-Allow-Methods:POST'); 
header('Access-Control-Allow-Headers:x-requested-with,content-type');
class DealController extends Controller {
	//消费记录列表
	//需求参数  服务商id
	//state 1审核中 2成功  3失败,已退款 
	public function deal_list(){
		    $Mysql=M('deal_info');
		    $where['deal_info.agency_id']=I('id');
		    $field='deal_info.running_num,deal_info.deal_type,deal_info.deal_gold,deal_info.balance,deal_info.dj_balance,deal_info.deal_time,deal_info.state,
		    user_info.realname,qianyue.appmcheng';
			$list=$Mysql
			->field($field)
			->join('user_info ON deal_info.agency_id=user_info.id')
			->join('qianyue ON qianyue.program_id=deal_info.program_id')
			->where($where)
			->select();

			$this->ajaxReturn($list);

	}
	
	//消费记录搜索
	//需求参数 服务商ID  name type  start end
	//提供参数
	public function deal_search(){
		$Mysql=M('deal_info');
		$start=I('start');
		$end=I('end');
		$type=I('type');
		$name=I('name');
		$stampt=strtotime(date($start));
		$nt=strtotime(date($end));
		$where['deal_info.agency_id']=I('id');
		$where['_string']='(user_info.realname like "%'.$name.'%")  OR (deal_info.deal_type like "%'.$type.'%")';
		$where['deal_info.deal_time']=array(array('EGT',$stampt),array('ELT',$nt));
	    $field='deal_info.running_num,deal_info.deal_type,deal_info.deal_gold,deal_info.balance,deal_info.dj_balance,deal_info.deal_time,deal_info.state,
	    user_info.realname,qianyue.appmcheng';
		$list=$Mysql
		->field($field)
		->join('user_info ON deal_info.program_id=user_info.program_id')
		->join('qianyue ON qianyue.program_id=deal_info.program_id')
		->where($where)
		->select();
		$this->ajaxReturn($list);
	}
	
	//添加消费记录
	//需求参数 name contract_id  contract_img deal_gold deal_type dealyears remark  小程序program_id  服务商ID agency_id
	public function add_deal(){
			$receive=I();
			$Mysql=M('jt_user_info');
			$balance=$Mysql->field('user_zfpsw,user_balance')->where(array('user_id'=>$receive['agency_id']))->find();
			$zfpsw=$balance['user_zfpsw'];
			$receive['zfpsw']=md5($receive['zfpsw']);
			if($receive['zfpsw']==$zfpsw){
			    if($balance['user_balance']<$receive['deal_gold']){
				   $data=array('status'=>-1,'msg'=>'余额不足，请先充值账户余额');
				   exit;
			}else{
				//图片上传
				$upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =     3145728 ;// 设置附件上传大小
			    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
//			    $upload->savePath  =     'agency_img'; // 设置附件上传（子）目录
//			    $upload->subName = 'contract_img';
			    // 上传文件 
			    $info   =   $upload->upload();
			    if($info){
			    	$receive['contract_img']=$info['savepath'].$info['savename'];
			    	$receive['running_num']='JT'.date("YmdHis").rand(10,99);
			    	$receive['balance']=$balance['user_balance']-$receive['deal_gold'];
			    	$receive['deal_time']=time();
			    	$receive['deal_type']=2;
			    	$Mysql1=M('deal_info');
			    	
			    	
			    	$sql=$Mysql1->add($receive);
			    	$Q=M('qianyue');
	                $endt=$Q->field('end_time')->where(array('program_id'=>$receive['program_id']))->find();
	                $getendt=strtotime(date(date('Y-m-d h:i:s',$endt['end_time']),strtotime("+".$receive['deal_years']." year")));
			    	$Q->where(array('program_id'=>$receive['program_id']))->save(array('end_time'=>$getendt));
			    	if($sql){
			            $data=array('status'=>1,'msg'=>'操作成功');
			    	}else{
			    		$data=array('status'=>-1,'msg'=>'操作失败，请重新尝试');
			    	}
			    }else{
			    	$receive['running_num']='JT'.date("YmdHis").rand(10,99);
			    	$receive['balance']=$balance['user_balance']-$receive['deal_gold'];
			    	$receive['deal_time']=time();
			    	$receive['deal_type']=2;
			    	$Mysql1=M('deal_info');
			    	
			    	$sql=$Mysql1->add($receive);
			    	$Q=M('qianyue');
	                $endt=$Q->field('end_time')->where(array('program_id'=>$receive['program_id']))->find();
	                $getendt=strtotime(date(date('Y-m-d h:i:s',$endt['end_time']),strtotime("+".$receive['deal_years']." year")));
			    	$Q->where(array('id'=>$receive['program_id']))->save(array('end_time'=>$getendt));
			    	
			    	
			    	
			    	$data=array('status'=>2,'msg'=>'图片上传失败');
			    }
			}
			}else{
				$data=array('status'=>-1,'msg'=>'支付密码不正确,请重新输入');
			}
		$this->ajaxReturn($data);
	}
	public function add_deal02(){
    	  //	$a = $this -> saveBase64Image($cc);
			$receive=I();

			$Mysql=M('jt_user_info');
			$balance=$Mysql->field('user_zfpsw,user_balance')->where(array('user_id'=>$receive['agency_id']))->find();
			$zfpsw=$balance['user_zfpsw'];
			$receive['zfpsw']=md5($receive['zfpsw']);
			if($receive['zfpsw']==$zfpsw){
				if($balance['user_balance']<$receive['deal_gold']){
					$data=array('status'=>-1,'msg'=>'余额不足，请先充值账户余额');
					exit;
				}else{
					//密码正确、余额充足

					$savepath=$this->saveBase64Image($receive["contract_img"]);
					$receive["contract_img"]=$savepath["url"];//base64转码图片
					
					$receive['running_num']='JT'.date("YmdHis").rand(10,99);
			    	$receive['balance']=$balance['user_balance']-$receive['deal_gold'];
			    	$receive['deal_time']=time();
			    	$receive['deal_type']=2;

			    	$Mysql1=M('deal_info');
			    	$sql=$Mysql1->add($receive);
			    	$Q=M('qianyue');
	                $endt=$Q->field('end_time')->where(array('program_id'=>$receive['program_id']))->find();
	                $getendt=strtotime(date(date('Y-m-d h:i:s',$endt['end_time']),strtotime("+".$receive['deal_years']." year")));
			    	$Q->where(array('program_id'=>$receive['program_id']))->save(array('end_time'=>$getendt));
			    	
			    	
			    	if($sql){
			            $data=array('status'=>1,'msg'=>'操作成功');
			    	}else{
			    		$data=array('status'=>-1,'msg'=>'操作失败，请重新尝试');
			    	}
				}
			}else{
				$data=array('status'=>-1,'msg'=>'支付密码不正确,请重新输入');
			}
		$this->ajaxReturn($data);
	}
	function saveBase64Image($base64_image_content){

		if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){

			//图片后缀
			$type = $result[2];

			//保存位置--图片名
			$image_name=date('His').str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT).".".$type;
			$image_url = "/selfheadimg"."/".date('Ymd')."/".$image_name;
			if(!is_dir(dirname('.'.$image_url))){
				mkdir(dirname('.'.$image_url));
				chmod(dirname('.'.$image_url), 0777);
				umask($oldumask);
			}
			//解码

			$decode=base64_decode(str_replace($result[1], '', $base64_image_content));
			if (file_put_contents('.'.$image_url, $decode)){
				$data['code']=0;
				$data['imageName']=$image_name;
				$data['url']=$image_url;
				$data['msg']='保存成功！';
			}else{
				$data['code']=1.1;
				$data['imgageName']='';
				$data['url']='';
				$data['msg']='图片保存失败！';
			}
		}else{
			$data['code']=2;
			$data['imgageName']='';
			$data['url']='';
			$data['msg']='base64图片格式有误！';
		}
		return $data;
	}
	public function test_1(){
		echo 1;
		/*$ew["name"]=date("Y-m-d H:i:s",time());
		M("test")->add($ew);*/
	}
}
?>