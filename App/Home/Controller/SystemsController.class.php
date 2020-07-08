<?php
namespace Home\Controller;
use Think\Controller;
class SystemsController extends Common02Controller {
/*	protected function _initialize() {
		$this->is_action03="1";
		
		$this->is_action01=null;
		$this->is_action02=null;
	}*/
    public function index(){
    
     $this->display();
    }
    
    //消费记录
    public function record_xf(){
    	
    	$agency=M("jt_user_info")->field('user_id,user_company')->where("user_name='".$_COOKIE["name_h"]."'")->find();
	
	/*	$where['deal_info.agency_id']=$agency["user_id"];
		    $field='deal_info.running_num,deal_info.deal_type,deal_info.deal_gold,deal_info.balance,deal_info.dj_balance,deal_info.deal_time,deal_info.state,
		    user_info.realname,qianyue.appmcheng';
			$list=M('deal_info')
			->field($field)
			->join('user_info ON deal_info.agency_id=user_info.id')
			->join('qianyue ON qianyue.program_id=deal_info.program_id')
			->where($where)
			->select();*/
			$goods = D("deal_info");
            $total = $goods->where(array('agency_id'=>$agency["user_id"]))->count();
            $per = 100;
            $page = new \Component\Page($total, $per); //autoload
            $sql = "select * from deal_info where agency_id='".$agency["user_id"]."'";
            
            $sql.=" order by time_set desc ".$page->limit;
            $info = $goods -> query($sql);
            $pagelist = $page -> fpage();
// user_id
				for($i=0;$i<count($info);$i++){
					$user=M("user_info")->where("id='".$info[$i]["user_id"]."'")->find();
					$info[$i]["user_name"]=$user["name"];
				}
//dump($info);die;
            $this -> assign('record_xf', $info);
            $this -> assign('pages', $pagelist);
			
			
			$this->title="消费记录";
/*
   [0] => array(18) {
    ["id"] => string(1) "2"
    ["running_num"] => string(1) "2"
    ["type"] => string(1) "2"
    ["user_realname"] => string(1) "2"
    ["balance"] => NULL
    ["dj_balance"] => NULL
    ["contract_id"] => string(1) "2"
    ["contract_img"] => string(1) "2"
    ["deal_gold"] => string(1) "2"
    ["deal_time"] => string(10) "1503034580"
    ["remark"] => string(1) "2"
    ["agency_id"] => string(1) "1"
    ["state"] => string(1) "1"
    ["deal_type"] => string(1) "2"
    ["deal_years"] => string(1) "2"
    ["program_id"] => string(1) "2"
    ["time_set"] => NULL
    ["user_id"] => NULL
  }**/
     $this->display();	
    }
    
    //充值记录
    public function record_cz(){
    	$agency=M("jt_user_info")->field('user_id,user_company')->where("user_name='".$_COOKIE["name_h"]."'")->find();
        $list=M('recharge_info')->where("user_agency_id=".$agency['user_id'])->select();
        $this->assign('list',$list);
        $this->assign('user_company',$agency['user_company']);
        $this->display();
    }
}