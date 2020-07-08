<?php
namespace AdminPnew\Controller;
use Think\Controller;
header('content-type:application:json;charset=utf8'); 
header('Access-Control-Allow-Origin:*'); 
//header('Access-Control-Allow-Methods:POST'); 
header('Access-Control-Allow-Headers:x-requested-with,content-type');
header("Content-Type:text/html;CharSet=UTF-8");
class FenxController extends Controller {
	
	
	//--------分销等级管理-------------/
	/*
	 * 需求参数program_id
	 * 提供参数
	 */
	public function level_list(){
		$list=M('fx_lever')->where(array('program_id'=>$_GET['program_id']))->select();
//		print_r($list);
		$this->ajaxReturn($list);
	}
	//--------分销等级添加-------------/
	/*
	 * 需求参数program_id   等级名称title 一级比例bl_lever_1 二级比例bl_lever_2 三级比例bl_lever_3
	 *                      升级条件up_price
	 * 提供参数
	 */
	public function level_add(){
		$add=I();
		$add['program_id']=$_GET['program_id'];
		if(M('fx_lever')->where(array('program_id'=>$add['program_id']))->add($add)){
		    $data=array('status'=>1,'msg'=>'操作成功');	
		}else{
		    $data=array('status'=>1,'msg'=>'操作成功');
		}
		$this->ajaxReturn($data);
	}
	
	//--------分销等级修改-------------/
	/*
	 * 需求参数   分销等级id  等级名称 title   1级佣金比例  bl_lever_1  2级拥挤比例bl_lever_2
	 *                      3级佣金比例bl_lever_3 4升级条件up_price
	 * 提供参数
	 */
	public function level_upd1(){
		$save=I();
		if(M('fx_lever')->where('id='.$_GET['id'])->save($save)){
			$data=array('status'=>1,'msg'=>'操作成功');
		}else{
			$data=array('status'=>-1,'msg'=>'操作失败');
		}
		$this->ajaxReturn($data);
	}
	
	//--------分销等级修改信息展示-------------/
	/*
	 * 需求参数等级id
	 * 提供参数
	 */
	public function level_upd(){
		$data=M('fx_lever')->where('id='.$GET['id'])->find();
		$this->ajaxReturn($data);
	}
	//--------分销商管理信息展示-------------/
	/*
	 * 需求参数    小程序program_id
	 * 提供参数@field nickname昵称 head头像 realname姓名 tel电话  fx_lever_id等级  fx_time_registe申请时间 fx_time_agree审核时间
	 *                fx_state状态  fx_yongjin_leiji累计  fx_yongjin_dakuan打款  fx_uid分销商上级ID 
	 */
	public function fx_list(){
		if(isset($_POST['shenhe'])){
			$where['fx_state']=I('shenhe');
		}
		$where['program_id']=I('program_id');
		$where['fx_state']=array('neq',0);
		$str=I('str');
		$type=I('type');
		$field='id,nickname,head,realname,tel,fx_lever_id,blacklist,fx_time_registe,fx_time_agree,fx_state,
		fx_yongjin_leiji,fx_yongjin_dakuan,fx_uid';
		$where['_string']='(nickname like "%'.$str.'%")  OR (realname like "%'.$str.'%") OR (tel like "%'.$str.'%")';
		if($type==2){
			$idarr=M('members')->field('id')->where($where)->select();
			foreach($idarr as $v){
				$idarr1[]=$v['id'];
			}
			$list=M('members')->field($field)->where('fx_uid in('.implode(',',$idarr1).')')->select();
		}else{
			$list=M('members')
			->field($field)
			->where($where)
			->select();	
		}
		$all=M('members')
		->field($field)
		->where(array('program_id'=>$_GET['program_id'],'fx_state'=>array('neq',0)))
		->select();
        foreach($list as $k=>$v){
            $arr[$k]=$this->getTree($list,$v['id'],3);	
        }
		$data['list']=$list;
		$data['num']=$arr;
		$data['sum']=count($list);
//		print_r($data);
		$this->ajaxReturn($data);
	}
	
	function getTree($data, $pId,$n){
		if($n>0){
			$arr[$pId]=0;
			for($i=0;$i<count($data);$i++){
				if($data[$i]['fx_uid']==$pId){
					$arr[$pId]+=1;
					$num=$this->getTree($data,$data[$i]['id'],$n-1);
					$arr[$pId]=$arr[$pId]+$num;
				}
		}	
		}
		return $arr[$pId];
	}
	
	//--------分销等级管理审核状态设置-------------/
	/*
	 * 需求参数members_id   fx_state
	 * 提供参数
	 */
	public function shenhe(){
		$where['id']=I('members_id');
		if($_GET['fx_state']==1){
			$save['fx_state']=2;
		}elseif($_GET['fx_state']==2){
			$save['fx_state']=1;
		}
		if(isset($save['fx_state'])&&M('members')->where($where)->save($save)){
			$data=array('status'=>1,'msg'=>'操作成功');
		}else{
			$data=array('status'=>-1,'msg'=>'操作失败');
		}
		$this->ajaxReturn($data);
	}
	
    //--------分销等级管理黑名单状态设置-------------/
	/*
	 * 需求参数members_id  blacklist
	 * 提供参数
	 */
	public function blacklist(){
		$where['id']=I('members_id');
		if($_GET['blacklist']==0){
			$save['blacklist']=1;
		}elseif($_GET['blacklist']==1){
			$save['blacklist']=0;
		}
		if(isset($save['blacklist'])&&M('members')->where($where)->save($save)){
			$data=array('status'=>1,'msg'=>'操作成功');
		}else{
			$data=array('status'=>-1,'msg'=>'操作失败');
		}
		$this->ajaxReturn($data);
	}
}
?>