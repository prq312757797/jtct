<?php
namespace Admin\Controller;
use Think\Controller;
class MembersController extends CommonController {
    public function index(){
	
		if($_COOKIE["lever"]==1){
			$this->user_info=M('jt_admin_user')->order("admin_id") ->select();
		}else{
			$this->user_info=M('jt_admin_user')->where("admin_id=".$_COOKIE["admin_id"])->select();
		}
		
	
			$this->show_add=1;//显示添加功能
			$this->title="";
			$this->lever=$_COOKIE["lever"];//判断登录人层级身份
		
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
        $user_id = $_GET['admin_id'];
        if(M('jt_admin_user')->delete($user_id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }

}