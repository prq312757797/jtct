<?php
namespace Admin\Controller;
use Think\Controller;
class WeihuController extends Controller {
    public function index(){
		$weihu=$this->weihu=M("weihu")->where("state=1")->select();
		
		
		$this->display();
	}
	
	function test0122(){
		echo 111;
		dump(222);
	}
	function ajax_weihu(){
		
		/*$a["name"]=$_POST["content"];
			$a["title"]=$_POST["tijiaoren"];
		M("test")->add($a);*/
		$date["content"]=$_POST["content"];
		$date["tichuren"]=$_POST["tijiaoren"];
		$date["time_tichu"]=date("Y-m-d H:i:s",time());
		
		if(M("weihu")->add($date)){
			$a="1";
		}else{
			$a="2";
		}
		$this->ajaxReturn($a);
	}
	function ajax_dafu(){
	
		$date["jishu"]=$_POST["tijiaoren"];
		$date["time_wancehng"]=date("Y-m-d H:i:s",time());
		$date["is_wancheng"]="1";
		
		if(M("weihu")->where("id='".$_POST["id"]."'")->save($date)){
			$a="1";
		}else{
			$a="2";
		}
		$this->ajaxReturn($a);
	}
	 public function delete() {
	 	
	 	$date["state"]="2";
    
        if(M('weihu')->where("id='".$_GET['id']."'")->save($date)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
	
}