<?php
namespace AdminP\Controller;
use Think\Controller;
class TestController extends CommonController {
    public function index(){
	//	echo "<h1 style='text-align:center;'>这个是用来测试post提交数据的！！！</h1>";
		//echo "<hr>";
			



			dump(md5(132));die;
		$this->display();
	}
	
}