<?php
namespace Admin\Controller;
use Think\Controller;
class AuditController extends CommonController {
    public function index(){
    	
	 $field='
        qianyue.id as qianyue_id,qianyue.appmcheng,qianyue.agency_id,qianyue.user_id,qianyue.muban_type,qianyue.muban_b,qianyue.moban_fengge,qianyue.muban_tese,
        qianyue.muban_price,qianyue.state as qianyue_state,qianyue.is_tired,qianyue.add_time as qianyue_add_time,
         
		jt_user_info.user_id as jt_user_info_user_id,jt_user_info.user_company,
		user_info.id as user_info_id,user_info.name as user_info_name,
		muban_l.id as muban_l_id,muban_l.name as muban_l_name,
		muban_b.id as muban_b_id,muban_b.name as muban_b_name,
		muban_f.id as muban_f_id,muban_f.name as muban_f_name
        ';	
	$sql="SELECT  ".$field;
	$sql .=" FROM qianyue ";
	$sql .=" INNER join jt_user_info ON jt_user_info.user_id	=qianyue.agency_id";
	$sql .=" INNER join user_info 	 ON user_info.id			=qianyue.user_id";
	$sql .=" INNER join muban_l 	 ON muban_l.id				=qianyue.muban_type";
	$sql .=" INNER join muban_b 	 ON muban_b.name			=qianyue.muban_b";
	$sql .=" left  join muban_f 	 ON muban_f.id				=qianyue.moban_fengge";
	$sql .=" ORDER BY qianyue.add_time desc";
	$user_info = M("qianyue") -> query($sql);
	

	
	
//      $field='
//      qianyue.id as qianyue_id,qianyue.appmcheng,qianyue.agency_id,qianyue.user_id,qianyue.muban_type,qianyue.muban_b,qianyue.moban_fengge,qianyue.muban_tese,
//       qianyue.muban_price,qianyue.state as qianyue_state,qianyue.is_tired,qianyue.add_time as qianyue_add_time,
//      
//       jt_user_info.user_id as jt_user_info_user_id,jt_user_info.user_company,
//       user_info.id as user_info_id,user_info.name as user_info_name,
//       muban_l.id as muban_l_id,muban_l.name as muban_l_name,
//       muban_b.id as muban_b_id,muban_b.name as muban_b_name,
//       muban_f.id as muban_f_id,muban_f.name as muban_f_name
//      ';
//      $user_info=M('qianyue')
//          ->field($field)
//          ->join('jt_user_info ON jt_user_info.user_id=qianyue.agency_id')
//          ->join('join muban_l ON muban_l.id=qianyue.muban_type')
//          ->join('join muban_b ON muban_b.name=qianyue.muban_b')
//          ->join('join user_info ON user_info.id=qianyue.user_id')
//          ->join('left join muban_f ON muban_f.id=qianyue.moban_fengge')
//          ->order("qianyue.add_time desc")
//          ->select();
//dump($user_info);die;

        for($i=0;$i<count($user_info);$i++){
            if($user_info[$i]["muban_type"]==1){
                $arr=$this->chaifen($user_info[$i]["muban_tese"]);
                $muban_t=M("muban_t")->where("lid=1")->order("id")->select();
                if($arr[1]==1){
                    $user_info[$i]["tese01"]=$muban_t[1]["name"];
                }
                if($arr[2]==1){
                    $user_info[$i]["tese02"]=$muban_t[2]["name"];
                }
                if($arr[3]==1){
                    $user_info[$i]["tese03"]=$muban_t[3]["name"];
                }
            }

        }
        
		$this->user_info=$user_info;
		$this->lever=$_COOKIE["lever"];//判断登录人层级身份
		
		$this->display();
	}
	 public function index0621(){
    	
        $field='
        qianyue.id as qianyue_id,qianyue.appmcheng,qianyue.agency_id,qianyue.user_id,qianyue.muban_type,qianyue.muban_b,qianyue.moban_fengge,qianyue.muban_tese,
         qianyue.muban_price,qianyue.state as qianyue_state,qianyue.is_tired,qianyue.add_time as qianyue_add_time,
        
         jt_user_info.user_id as jt_user_info_user_id,jt_user_info.user_company,
         user_info.id as user_info_id,user_info.name as user_info_name,
         muban_l.id as muban_l_id,muban_l.name as muban_l_name,
         muban_b.id as muban_b_id,muban_b.name as muban_b_name,
         muban_f.id as muban_f_id,muban_f.name as muban_f_name
        ';
        $user_info=M('qianyue')
            ->field($field)
            ->join('jt_user_info ON jt_user_info.user_id=qianyue.agency_id')
            ->join('join muban_l ON muban_l.id=qianyue.muban_type')
            ->join('join muban_b ON muban_b.name=qianyue.muban_b')
            ->join('join user_info ON user_info.id=qianyue.user_id')
            ->join('left join muban_f ON muban_f.id=qianyue.moban_fengge')
            ->order("qianyue.add_time desc")
            ->select();
			
dump(M('qianyue')->_sql());dump($user_info);die;
        for($i=0;$i<count($user_info);$i++){
            if($user_info[$i]["muban_type"]==1){
                $arr=$this->chaifen($user_info[$i]["muban_tese"]);
                $muban_t=M("muban_t")->where("lid=1")->order("id")->select();
                if($arr[1]==1){
                    $user_info[$i]["tese01"]=$muban_t[1]["name"];
                }
                if($arr[2]==1){
                    $user_info[$i]["tese02"]=$muban_t[2]["name"];
                }
                if($arr[3]==1){
                    $user_info[$i]["tese03"]=$muban_t[3]["name"];
                }
            }

        }
        
		$this->user_info=$user_info;
		$this->lever=$_COOKIE["lever"];//判断登录人层级身份
		
		$this->display();
	}
	//版本升级
	public function index_new(){
		   //提单流程优化 qianyue_state
		           $field='
        qianyue.id as qianyue_id,qianyue.appmcheng,qianyue.agency_id,qianyue.user_id,qianyue.muban_type,qianyue.muban_b,qianyue.moban_fengge,qianyue.muban_tese,
         qianyue.muban_price,qianyue.state as qianyue_state,qianyue.is_tired,qianyue.add_time as qianyue_add_time,qianyue.function_id,
        
         jt_user_info.user_id as jt_user_info_user_id,jt_user_info.user_company,
         user_info.id as user_info_id,user_info.name as user_info_name';
		   
		   
        $where1116["function_id"]=array('neq',"");
        $preview=M("qianyue")
        ->field($field)
         ->join('jt_user_info ON jt_user_info.user_id=qianyue.agency_id')
         ->join('join user_info ON user_info.id=qianyue.user_id')
        ->where($where1116)->order("qianyue.add_time desc")->select();
        
        for($i=0;$i<count($preview);$i++){ 
			$arr[$i]=explode(",",$preview[$i]["function_id"]);
			for($k=0;$k<count($arr[$i]);$k++){
				$b=M("function_list")->where("id='".$arr[$i][$k]."'")->find();
				
				$arr_1[$k]=	$b["name"];
			}
			
			$preview[$i]["name_function"]=implode(",",$arr_1);
		}
		//dump($preview);die;
		$this->preview=$preview;
		$this->display();
	}
	
	 public function add() {
        $this->display();
    }
	
    public function runAdd() {
        if(empty($_GET['admin_id'])) {
			$a=array(
			'admin_name'=>$_POST["admin_name"],
			'admin_psw'=>md5($_POST["admin_psw"])
			);
            if(M('qianyue')->add($a)) {
                $this->success('添加成功',U('index'));
            } else {
                $this->error('添加失败');
            }
        }
        else {
			$a=array(
			'admin_name'=>$_POST["admin_name"],
			'admin_psw'=>md5($_POST["admin_psw"])
			);
            M('qianyue')->where(array('id'=>$_GET['id']))->save($a);
            
			$this->success('修改成功',U('index'));
        }
    }

    public function edit() {
        $field='
        qianyue.id as qianyue_id,qianyue.appmcheng as qianyue_appmcheng,qianyue.start_id as qianyue_start_id,qianyue.appid as qianyue_appid,
        qianyue.appsecret as qianyue_appsecret,qianyue.payment as qianyue_payment,qianyue.shanghu_num as qianyue_shanghu_num,qianyue.paykey as qianyue_paykey,
        qianyue.user_id as qianyue_user_id,qianyue.agency_id as qianyue_agency_id,qianyue.beian_time as qianyue_beian_time,qianyue.add_time as qianyue_add_time,
        qianyue.upd_time as qianyue_upd_time,qianyue.state as qianyue_state,qianyue.contract_id as qianyue_contract_id,qianyue.contract_img as qianyue_contract_img,
        qianyue.remark as qianyue_remark,qianyue.program_id as qianyue_program_id,qianyue.muban_tese as qianyue_muban_tese,qianyue.muban_b as qianyue_muban_b,
      qianyue.muban_price as qianyue_muban_price, 
      jt_user_info.user_id as jt_user_info_user_id,jt_user_info.user_company as jt_user_info_user_company,
       
       muban_l.id as muban_l_id,muban_l.name as muban_l_name,
       
       muban_f.id as muban_f_id,muban_f.name as muban_f_name
        ';
        $user_info=M("qianyue")
            ->field($field)
             ->join('jt_user_info ON jt_user_info.user_id=qianyue.agency_id')
            ->join('join muban_l ON muban_l.id=qianyue.muban_type')
            ->join('left join muban_f ON muban_f.id=qianyue.moban_fengge')
            ->where("qianyue.id='".$_GET['id']."'")
            ->find();

        $chaifen=$this->chaifen($user_info["qianyue_muban_tese"]);
        for($p=0;$p<count($chaifen);$p++){
            $order[$p]=M("muban_t")
                ->where("muban_t.id='".$chaifen[$p]."'")
                ->find();
        }
        $user_info["id_arr"]=$order;


		$this->info=$user_info;

       $this->display('add');
    }
    //分割函数
    function chaifen($source){
        return explode(',',$source);
    }
	/*禁用*/
		public function lock(){
			 $admin_id = array(
			'id'=> $_GET['id'],
			'state'=> "3"
			 );
		
        if(M('qianyue')->save($admin_id)) {
            $this->success('锁定成功');
        } else {
            $this->error('锁定失败');
        }
			
		}
		/*通过审核*/
		public function lockout(){

//商户申请表写入绑定小程序模板状态
		$_POST["program_id"]=	"JT".date("YmdHis",time()).rand(1111,9999);

		$is_tired["is_tired"]="2";
		$is_tired["state"]="1";
		$is_tired["program_id"]=$_POST["program_id"];
	//	M("qianyue")->where("id='".$_GET["id"]."'")->save($is_tired);				 
			 
			 
        if(M("qianyue")->where("id='".$_GET["id"]."'")->save($is_tired)) {
//商城基本信息表添加小程序id
		$store["program_id"]=$_POST["program_id"];
		$store["program_title"]=$_POST["muban_name"];
		
		M("store")->add($store);
 	
//商户表写入小程序id state
		$shanghu_p["program_id"]=$_POST["program_id"];
		
		$shanghu_id=M("qianyue")->where("id='".$_GET["id"]."'")->find();
		
		$shanghu_p["appid"]=$shanghu_id["appid"];
		$shanghu_p["shanghu_num"]=$shanghu_id["shanghu_num"];
		$shanghu_p["pay_key"]=$shanghu_id["pay_key"];
		
		M("user_info")->where("id='".$shanghu_id["user_id"]."'")->save($shanghu_p);        
		
		
//会员默认等级  member_level_name
			$lever["program_id"]=$_POST["program_id"];
			$lever["member_level_name"]="默认等级";
			$lever["cannot_d"]="1";//1：不能删、2：可以删
			
			M("member_level")->add($lever);
			
//会员默认分组  member_group_name
			$group["program_id"]=$_POST["program_id"];
			$group["member_group_name"]="默认分组";
			$group["member_level"]="--";
			$group["cannot_d"]="1";//1：不能删、2：可以删
			M("member_group")->add($group);
//首页推荐
			$add_index_recommend["time"]=time();
			$add_index_recommend["program_id"]=$_POST["program_id"];
			$add_index_recommend["recommend_text"]="推荐新品,热卖商品,促销商品,新上商品,包邮商品";
			
			$haved_recommend=M("index_recommend")->where("program_id='".$_POST["program_id"]."'")->find();
			if(empty($haved_recommend)){
				M("index_recommend")->add($add_index_recommend);
			}			
	//添加了小程序id之后-添加分销商 默认等级   
			$fx_lever["program_id"]=$_POST["program_id"];
			$fx_lever["title"]="默认等级";
			$fx_lever["cannot_d"]="1";//1：不能删、2：可以删
			$fx_lever["bl_lever_1"]="10";
			$fx_lever["bl_lever_2"]="5";
			$fx_lever["bl_lever_3"]="0";
			
			M("fx_lever")->add($fx_lever);	
			
			$group["program_id"]=$_POST["program_id"];
			$group["title"]="其他";
			$group["is_show"]="1";
			$group["sort"]="1";
	
			M("attribute")->add($group);
			
					
			$arr=explode(",",$shanghu_id["function_id"]);
			if(in_array("1",$arr)){
//商城版  添加基础内容+=++++++++++++++++++++++++++++++++++++++++++++++++
	//添加了小程序id之后-添加分销商 默认等级   
			$fx_lever["program_id"]=$_POST["program_id"];
			$fx_lever["title"]="默认等级";
			$fx_lever["cannot_d"]="1";//1：不能删、2：可以删
			$fx_lever["bl_lever_1"]="10";
			$fx_lever["bl_lever_2"]="5";
			$fx_lever["bl_lever_3"]="0";
			
			M("fx_lever")->add($fx_lever);
	
	
			if(in_array("2",$arr)){
//资讯版  添加基础内容+=++++++++++++++++++++++++++++++++++++++++++++++++
//添加默认的分类  其他，设施不能删
				$group["program_id"]=$_POST["program_id"];
				$group["title"]="其他";
				$group["is_show"]="1";
				$group["sort"]="1";
		
				M("attribute")->add($group);
			}
           
	        }
	        $this->success('通过审核');
		}else {
            $this->error('审核失败');
        }
			
	}
		/*通过审核*/
		public function lockout_j(){
			 $admin_id = array(
			'id'=> $_GET['id'],
			'state'=> "4"
			 );
			 
	        if(M('qianyue')->save($admin_id)) {
	            $this->success('拒绝审核');
	        } else {
	            $this->error('审核失败');
	        }	
		}
		
		/**恢复*/
		public function lock_on_1(){
			 $admin_id = array(
			'id'=> $_GET['id'],
			'state'=> "1"
			 );
			 
        if(M('qianyue')->save($admin_id)) {
            $this->success('恢复成功');
        } else {
            $this->error('恢复失败');
        }
		}
	/**删除服务商*/
    public function delete() {
        $user_id = $_GET['id'];
        if(M('qianyue')->delete($user_id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }

}