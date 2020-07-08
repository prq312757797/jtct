<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
	
		if($_SESSION["lever"]==1){
			$this->user_info=M('jt_admin_user')->order("admin_id") ->select();
		}else{
			$this->user_info=M('jt_admin_user')->where("admin_id=".$_SESSION["admin_id"])->select();
		}
		
	
			$this->show_add=1;//显示添加功能
			$this->title="";
			$this->lever=$_SESSION["lever"];//判断登录人层级身份
		
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
            if(M('jt_admin_user')->add($a)) {
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
            M('jt_admin_user')->where(array('admin_id'=>$_GET['admin_id']))->save($a);
            
			$this->success('修改成功',U('index'));
        }
    }

    public function edit() {
	
       $a= $this->info=M('jt_admin_user')->where("admin_id=".$_GET['admin_id'])->find();
		
		//dump($a);
       $this->display('add');
    }
	
	/*锁定*/
		public function lock(){
			 $admin_id = array(
			'admin_id'=> $_GET['admin_id'],
			'lock'=> "2"
			 );
		
        if(M('jt_admin_user')->save($admin_id)) {
            $this->success('锁定成功');
        } else {
            $this->error('锁定失败');
        }
			
		}
		/*解锁*/
		public function lockout(){
			 $admin_id = array(
			'admin_id'=> $_GET['admin_id'],
			'lock'=> "1"
			 );
			 
        if(M('jt_admin_user')->save($admin_id)) {
            $this->success('解锁成功');
        } else {
            $this->error('解锁失败');
        }
			
		}
	/**删除服务商*/
    public function delete() {
        $user_id = $_GET['user_id'];
        if(M('jt_user_info')->delete($user_id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
	/**删除消费记录*/
	public function delete2() {
        $user_id = $_GET['id'];
        if(M('deal_info')->delete($user_id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
	/**删除充值记录*/
	public function delete3() {
        $user_id = $_GET['id'];
        if(M('recharge_info')->delete($user_id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
	/**消费记录*/
	public function record_xf(){
		
		 $goods = D("deal_info");
            $total = $goods->where(array('user_agency_id'=>$_GET['user_id']))->count();
            $per = 10;
            $page = new \Component\Page($total, $per); //autoload
            $sql = "select * from deal_info where user_agency_id='".$_GET['user_id']."'".$page->limit;
            $info = $goods -> query($sql);
            $pagelist = $page -> fpage();

            $this -> assign('record_xf', $info);
            $this -> assign('pages', $pagelist);
			
			
			$this->title="消费记录";
		$this->display();
	}
	/**充值操作页面*/
		public function top_up(){
			$a=$this->info=M('jt_user_info')->where('user_id='.$_GET['user_id'])->find();
			
			$this->running_num=date("YmdHis",time()).rand(1,99);
			$this->title="充值";
			$this->man_action=$_SESSION["admin_name"];
			
		$this->display();
	}
	
	/**充值操作*/
		public function top_up_add(){
			
			if(is_numeric($_POST['price_add'])){
				//余额、添加金额、商户id、操作人、流水号
			$b=array(
				'user_agency_id'=>$_POST['user_id'],
				'running_num'=>$_POST['running_num'],
				'recharge_time'=> time(),
				'man_action'=>$_POST['man_action'],
				'content'=>$_POST['content'],
				'recharge_gold'=>$_POST['price_add']
			);
	
			//向服务商信息表修改 余额
			if(M('jt_user_info')->where('user_id='.$_POST['user_id'])->setInc('user_balance',$_POST['price_add'])){
				M('recharge_info')->add($b);
				$this->success('充值成功',U('index'));
			}else {
            $this->error('充值失败');
			}
        }else{
			 $this->error('请输入正确金额');
		}
		
			
			
		}
	
	/**充值记录*/
		public function record_cz(){
		 $goods = D("recharge_info");
            $total = $goods->where(array('user_agency_id'=>$_GET['user_id']))->count();
            $per = 10;
            $page = new \Component\Page($total, $per); //autoload
            $sql = "select * from recharge_info where user_agency_id='".$_GET['user_id']."'".$page->limit;
            $info = $goods -> query($sql);
            $pagelist = $page -> fpage();

            $this -> assign('record_cz', $info);
            $this -> assign('pages', $pagelist);
			
			$this->title="充值记录";
		$this->display();
	}
	function b($arr,$p=0){
		$ar=array();
		foreach($arr as $v){
			if($v["uid"]==$p){
				$v["child"]=$this->b($arr,$v["id"]);	
				$ar[]=$v;
			}
		}
		return $ar;
	}
	function a(){
		//两个表都待条件的连表查询
		$_GET["program_id"]='1';
		$_GET["goods_state"]='1';
		$_POST['str_f']=1;
	$list= M("goods")->query("
	select * from 
	goods 
	left outer join  
	( select * from attribute where id='".$_POST['str_f']."'"."  ) c  
	on goods.id=c.goods_id 
	where goods.program_id='".$_GET["program_id"]."'"." and goods.goods_state='".$_GET["goods_state"]."'"." 
	") ;
	
	echo M("goods")->_sql();
	dump($list);die;
		
		
	//测试原声sql 连表带条件查询
	 $list= M("goods")->query("select * from goods left outer join  ( select * from attribute where id='1' ) c on goods.id=c.goods_id");

	
	//测试多条件模糊查询
	$str="2";

	$where=array(
	'user_id'=>"15",
	'user_name'=>"123123",
	);
	$where['_string']='(user_realname like "%'.$str.'%")  
	OR (appMcheng like "%'.$str.'%")';
	$list=M('jt_user_info')->where($where)->select();
	echo M('jt_user_info')->_sql();		 
	dump($list);die;
	}
}