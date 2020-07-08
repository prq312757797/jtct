<?php
namespace Admin\Controller;
use Think\Controller;
class FormworkController extends CommonController {
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
		
		
		$this->display();
	}
	 public function add() {
        $this->display();
    }

    public function runAdd() {
        if(empty($_GET['user_id'])) {
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

    public function delete() {
        $user_id = $_GET['user_id'];
        if(M('jt_user_info')->delete($user_id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
	
	
	
}