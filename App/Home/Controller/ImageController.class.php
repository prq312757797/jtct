<?php
namespace Home\Controller;
use Think\Controller;
class ImageController extends Controller {
    public function index(){
    	
    	//dump(date("Y-m-d H:i:s","1505319580"));
		$this->display();
    }
}