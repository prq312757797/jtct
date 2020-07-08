<?php
namespace Program\Controller;
use Think\Controller;
header('content-type:application:json;charset=utf8'); 
header('Access-Control-Allow-Origin:*'); 
//header('Access-Control-Allow-Methods:POST'); 
header('Access-Control-Allow-Headers:x-requested-with,content-type');
class CaseController extends Controller {
	
	//案例列表    图文详情的内容  以及分类
    function case_list(){
    	$attribute=M("attribute")->field('id,title')->where("attribute_style=3 and is_show=1 and program_id='".$_GET["program_id"]."'")->order("sort")->select();
    	
    	$case_show=M("case_show")->field('id,title,image,subtitle')->where("fl_id='".$attribute["id"]."'")->order("sort")->select();
    	
    	$z=array('k1'=>$attribute,'k2'=>$case_show);
    	$this->ajaxReturn($z);
    }
    
    //异步案例列表
    function ajax_case_list(){
    	
    	$case_show=M("case_show")->field('id,title,image,subtitle')->where("fl_id='".$_GET["fl_id"]."'"."and program_id='".$_GET["program_id"]."'")->order("sort")->select();
    	$this->ajaxReturn($case_show);
    }
    
    //案例详情
    function case_con(){
    	
    	$case_show=M("case_show")->field('id,title,image,subtitle,editor,content,time_set,fl_id')->where("id='".$_GET["id"]."'")->find();
    	
    	//案例分类
    	$attribute=M("attribute")->field('id,title')->where("id='".$case_show["fl_id"]."'")->order("sort")->find();
    	
    	$z=array('k1'=>$case_show,'k2'=>$attribute);
    	
    	$this->ajaxReturn($z);
    }
    
    
    //新闻资讯列表
    function news_list(){
 		$news=M("jt03_zx_info")->field("id,title,subtitle,image")->where("is_show=1 and program_id='".$_GET["program_id"]."'")->order("sort")->select();	   	
  
  		$this->ajaxReturn($news);
    }
    	
    //新闻资讯详情
      function news_con(){
      	$news_con=M("jt03_zx_info")->field("id,title,subtitle,image,content,time_input")->where("id='".$_GET["id"]."'")->find();
    	
    	 $this->ajaxReturn($news_con);
      }
      //新闻资讯详情
      function news_con_2(){
      	$news_con=M("artical")->field("id,title,subtitle,image,content,time_set")->where("id='".$_GET["id"]."'")->find();
    	
    	 $this->ajaxReturn($news_con);
      }
    
    
    
    
    
    
}
?>