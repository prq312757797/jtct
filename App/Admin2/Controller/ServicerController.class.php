<?php
namespace Admin\Controller;
use Think\Controller;
class ServicerController extends CommonController {
    public function index(){
	//	$a= $this->user_info=M('jt_user_info')->select();
	
		

		$goods = D("jt_user_info");
            $total = $goods->count();
            $per = 10;
            $page = new \Component\Page($total, $per); //autoload
            $sql = "select * from jt_user_info ".$page->limit;
            $info = $goods -> query($sql);
            $pagelist = $page -> fpage();

            $this -> assign('user_info', $info);
            $this -> assign('pages', $pagelist);
		
			$this->show_add=1;//显示添加功能
			$this->title="";
		$this->display();
	}
	 public function add() {
        $this->display();
    }

    public function runAdd() {
        if(empty($_GET['user_id'])) {
			
			$_POST["add_time"]=time();
            if(M('jt_user_info')->add($_POST)) {
                $this->success('添加成功',U('index'));
            } else {
                $this->error('添加失败');
            }
        }
        else {
            M('jt_user_info')->where(array('user_id'=>$_GET['user_id']))->save($_POST);
            
			
			$this->success('修改成功',U('index'));
        }
    }

    public function edit() {
		
       $a= $this->info=M('jt_user_info')->where('user_id='.$_GET['user_id'])->find();
		
		//dump($a);
       $this->display('add');
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
	
}