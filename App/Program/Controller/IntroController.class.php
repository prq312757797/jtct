<?php
namespace Program\Controller;
use Think\Controller;
header('content-type:application:json;charset=utf8'); 
header('Access-Control-Allow-Origin:*'); 
//header('Access-Control-Allow-Methods:POST'); 
header('Access-Control-Allow-Headers:x-requested-with,content-type');
//header("Content-Type:text/html;CharSet=UTF-8");
class IntroController extends Controller {
	
	//商城首页信息展示
	//需求参数 program_id
	//提供参数 商城信息array program_title商城标题 abstract 商城简介 program_logo商城logo
	//售罄数量 sell_out  代发货数量 ready_send
	public function index(){
		$Mysql=M('store');
		$id=I('program_id');
		$storeinfo=$Mysql->field('program_title,program_logo,abstract')
		->where(array('program_id'=>$id))
		->find();
		$arr=M('goods')
		->where(array('program_id'=>$id,'goods_state'=>2))
		->select();
		$goods_state['sell_out']=count($arr);
	    $field='order.id,order.order_gold,order.order_num,order.xiadan_time,members.nickname,goods_img.image';
	    $list=M('order')
	    ->group('goods_img.goods_id')
	    ->field($field)
	    ->join('LEFT JOIN members ON order.cus_id=members.id')
	    ->join('LEFT JOIN goods_img ON order.goods_id=goods_img.goods_id')
	    ->where(array('order.program_id'=>$id,'order.state'=>2))
	    ->select();
	    $goods_state['ready_send']=count($list);
	    $data=array('storeinfo'=>$storeinfo,'sell_out'=>$goods_state['sell_out'],
	    'ready_send'=>$goods_state['ready_send'],'data'=>$list);
//	    echo '<pre/>';
//	    print_r($data);
	    $this->ajaxReturn($data);
	}
	
	//幻灯片管理
	//需求参数 program_id
	//提供参数sort排序 title标题 url链接 显示隐藏is_show  id
	public function huand_list(){
		$Mysql=M('huandeng');
		$field='id,sort,title,url,is_show';
		$str1=isset($_POST['str1'])?$_POST['str1']:'';    //is_show  显示1 不显示2
		$str2=isset($_POST['str2'])?$_POST['str2']:'';    //title  标题 
		$where['program_id']=I('get.program_id');

		$where['_string']='(title like "%'.$str2.'%")  AND (is_show like "%'.$str1.'%")';
		$data=$Mysql->field($field)->where($where)->select();
		
		$this->ajaxReturn($data);
	}
	
	//幻灯片修改
	//需求参数id
	//提供参数$data 该幻灯片信息数组
	public function upd_huand(){
		$Mysql=M('huandeng');
//		$where['program_id']=I('get.program_id');
		$where['id']=I('get.id');
		$data=$Mysql->where($where)->find();
	    $this->ajaxReturn($data);
	}
	
	//幻灯片修改1
	//需求参数 id sort title url  img is_show  oldimg
	//提供参数$data
	public function upd_huand1(){
		$rec=I();
        $upload = new \Think\Upload();// 实例化上传类
	    $upload->maxSize   =     3145728 ;// 设置附件上传大小
	    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
	    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
	    $info   =   $upload->upload();
	    if($info){
	    	$rec['image']=$info['img']['savepath'].$info['img']['savename'];
	    	$Mysql=M('huandeng');
//	    	$where['program_id']=I('get.program_id');
		    $where['id']=I('get.id');
	    	$Mysql->where($where)->save($rec);
	    	unlink('./Uploads/'.$rec['oldimg']);    //删除原图
	    	$data=array('status'=>1,'msg'=>'修改成功');
	    }else{
	    	$error=$upload->getError();
	    	$data=array('status'=>-1,'msg'=>$error);
	    }
	    $this->ajaxReturn($data);
	}
	
	//添加新幻灯片
	//需求参数 program_id sort title image url is_show
	//提供参数$data
	public function add_huand(){
	    $rec=I('post.');
	    $rec['program_id']=I('program_id');
	    $Mysql=M('huandeng');
	    $row=$Mysql->where(array('title'=>$rec['title'],'program_id'=>$rec['program_id']))->find();
	    if($row){
	    	$data=array('status'=>2,'msg'=>'该标题已存在，可前往编辑');
	    }else{
	        $upload = new \Think\Upload();// 实例化上传类
		    $upload->maxSize   =     3145728 ;// 设置附件上传大小
		    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
		    $info   =   $upload->upload();
		    if($info){
		    	$rec['image']=$info['savepath'].$info['savename'];
			    $sql=$Mysql->add($rec);
			    if($sql){
			    	$data=array('status'=>1,'msg'=>'添加成功');	
			    }else{
			    	$data=array('status'=>-1,'msg'=>'操作失败	');	
			    }
		        	
		    }else{
		    	$error=$upload->getError();
	    	    $data=array('status'=>-1,'msg'=>$error);
		    }
	    }
	    $this->ajaxReturn($data);
	}
	
	
	//添加新幻灯片-----添加按钮 ---0830...17.30 重写   
	public function add_huand_2(){
		//得到小程序id  
			$receive=I();
			$upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =     3145728 ;// 设置附件上传大小
			    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
 			   // $upload->savePath  =     'agency_img'; // 设置附件上传（子）目录
//			    $upload->subName = 'idcard_img';
			    // 上传文件 
			    $info   =   $upload->upload();
			    if($info){
                    $receive['image']=$info['image02']['savepath'].$info['image02']['savename'];

			     if(M('huandeng')->add($receive)){
			    	$data=array('status'=>1,'msg'=>'添加成功');	
			    }else{
			    	$data=array('status'=>2,'msg'=>'添加失败');	
			    }
			    
			    }else{
			    	
                $error=$upload->getError();
		    	$data=array("status" => -1, "msg" => "图片上传失败",'error'=>$error);
			    }
			    
		$this->ajaxReturn($data);
	}
	//删除幻灯片
	//需求参数 id
	//提供参数$data
	public function del_huand(){
        $id=I('get.id');
        $Mysql=M('huandeng');
        $res=$Mysql->delete($id);
        if($res){
        	$img=$Mysql->field('image')->where(array('id'=>$id))->find();
        	unlink('./Uploads/'.$img['image']);
        	$data=array('status'=>1,'msg'=>'删除成功');
        }else{
        	$data=array('status'=>-1,'msg'=>'操作失败');
        }
        $this->ajaxReturn($data);
	}
    
    
    //幻灯片显示与隐藏
    //需求参数   幻灯片ID 当前状态is_show
    //提供参数
    public function show_huand(){
    	$show=I('is_show');
    	$id=I('id');
    	if(empty($id)){
    		$data=array('status'=>-2,'msg'=>'没有参数');
    		$this->ajaxReturn($data);
    		exit;
    	}
    	$M=M('huandeng');
    	if($show==1){
    		$show=2;
    	}else if($show==2){
    		$show=1;
    	}else{
    		$data=array('status'=>-3,'msg'=>'参数有误');
    		$this->ajaxReturn($data);
    		exit;
    	}
    	if(is_array($id)){
    		if($M->where('id in('.implode(',',$getid).')')->save(array('is_show'=>$show))){
    		$data=array('status'=>1,'msg'=>'操作成功');
    	}else{
    		$data=array('status'=>-1,'msg'=>'操作失败');
    		}
    	}else{
    		if($M->where('id='.$id)->save(array('is_show'=>$show))){
    		$data=array('status'=>1,'msg'=>'操作成功');
    	}else{
    		$data=array('status'=>-1,'msg'=>'操作失败');
    		}
    	}
    		$this->ajaxReturn($data);
    }
    //导航图列表
    //需求参数program_id
    //提供参数id,sort,title,url,image,is_show
    public function direction_list(){
    	$pid=I('get.program_id');
		$Mysql=M('direction');
		$field='id,sort,title,url,image,is_show';
		$str1=isset($_POST['str1'])?$_POST['str1']:'';    //is_show  显示1 不显示2
		$str2=isset($_POST['str2'])?$_POST['str2']:'';    //title  标题 
		$where['program_id']=$pid;
		$where['_string']='(title like "%'.$str2.'%")  AND (is_show like "%'.$str1.'%")';
		$data=$Mysql->field($field)->where($where)->select();
		$this->ajaxReturn($data);
    }
    
    //修改导航图
    //需求参数 id
    //提供参数$data;
    public function upd_direction(){
		$Mysql=M('direction');
//		$where['program_id']=I('get.program_id');
		$where['id']=I('get.id');
		$data=$Mysql->where($where)->find();
	    $this->ajaxReturn($data);
    }
    
    //修改导航图1
    //需求参数
    //提供参数
    public function upd_direction1(){
    	$rec=I('post.');
        $upload = new \Think\Upload();// 实例化上传类
	    $upload->maxSize   =     3145728 ;// 设置附件上传大小
	    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
	    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
	    $info   =   $upload->upload();
	    if($info){
	    	$rec['image']=$info['img']['savepath'].$info['img']['savename'];
	    	$Mysql=M('direction');
		    $where['id']=I('get.id');
	    	$Mysql->where($where)->save($rec);
	    	unlink('./Uploads/'.$rec['oldimg']);    //删除原图
	    	$data=array('status'=>1,'msg'=>'修改成功');
	    }else{
	    	$error=$upload->getError();
	    	$data=array('status'=>-1,'msg'=>$error);
	    }
	    $this->ajaxReturn($data);
    }
    
    //添加新导航图
	//需求参数 program_id sort title image url is_show
	//提供参数$data
	public function add_direction(){
	    $rec=I('post.');
	    $rec['program_id']=I('program_id');
        $Mysql=M('direction');
	    $row=$Mysql->where(array('title'=>$rec['title'],'program_id'=>$rec['program_id']))->find();
	    if($row){
	    	$data=array('status'=>2,'msg'=>'该标题已存在，可前往编辑');
	    }else{
	    	$upload = new \Think\Upload();// 实例化上传类
		    $upload->maxSize   =     3145728 ;// 设置附件上传大小
		    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
		    $info   =   $upload->upload();
		    if($info){
		    //	$rec['image']=$info['savepath'].$info['savename'];
		    	
		    	$rec['image']=$info['image01']['savepath'].$info['image01']['savename'];

			    $Mysql->add($rec);
		        $data=array('status'=>1,'msg'=>'添加成功');		
		    }else{
		    	$error=$upload->getError();
	    	    $data=array('status'=>-1,'msg'=>$error);
		    }
	    }
	    $this->ajaxReturn($data);
	}
	
	//删除导航图 
	//需求参数 id
	//提供参数$data
	public function del_direction(){
        $id=I('get.id');
        $Mysql=M('direction');
        $res=$Mysql->delete($id);
        if($res){
        	$img=$Mysql->field('image')->where(array('id'=>$id))->find();
        	unlink('./Uploads/'.$img['image']);
        	$data=array('status'=>1,'msg'=>'删除成功');
        }else{
        	$data=array('status'=>-1,'msg'=>'操作失败');
        }
        $this->ajaxReturn($data);
	}
	   //导航图显示与隐藏
    //需求参数  导航图ID 当前状态is_show
    //提供参数
    public function show_direction(){
    	$show=I('is_show');
    	$id=I('id');
    	if(empty($id)){
    		$data=array('status'=>-2,'msg'=>'没有参数');
    		$this->ajaxReturn($data);
    		exit;
    	}
    	$M=M('direction');
    	if($show==1){
    		$show=2;
    	}else if($show==2){
    		$show=1;
    	}else{
    		$data=array('status'=>-3,'msg'=>'参数有误');
    		$this->ajaxReturn($data);
    		exit;
    	}
    	if(is_array($id)){
    		if($M->where('id in('.implode(',',$getid).')')->save(array('is_show'=>$show))){
    		$data=array('status'=>1,'msg'=>'操作成功');
    	}else{
    		$data=array('status'=>-1,'msg'=>'操作失败');
    		}
    	}else{
    		if($M->where('id='.$id)->save(array('is_show'=>$show))){
    		$data=array('status'=>1,'msg'=>'操作成功');
    	}else{
    		$data=array('status'=>-1,'msg'=>'操作失败');
    		}
    	}
    		$this->ajaxReturn($data);
    }
	//
	//广告管理列表
	//需要参数program_id
	//提供参数  sort title url is_show 
	public function ad_list(){
		$str1=isset($_POST['str1'])?$_POST['str1']:'';    //is_show  显示1 不显示2
		$str2=isset($_POST['str2'])?$_POST['str2']:'';    //title  标题 
		$where['_string']='(title like "%'.$str2.'%")  AND (is_show like "%'.$str1.'%")';
		$where['program_id']=I('get.program_id');
		$Mysql=M('ad');
		$field='id,sort,title,url,is_show';
		$data=$Mysql->field($field)->where($where)->select();
		$this->ajaxReturn($data);
	}
	
	//修改广告图
	//需求参数id 
	//提供参数
	public function upd_ad(){
		$where['id']=I('get.id');
		$Mysql=M('ad');
		$data=$Mysql->where($where)->find();
	    $this->ajaxReturn($data);
	}
	
	//修改广告图1
	//需求参数 oldimg 
	//提供参数
	public function upd_ad1(){
		$rec=I('post.');
        $upload = new \Think\Upload();// 实例化上传类
	    $upload->maxSize   =     3145728 ;// 设置附件上传大小
	    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
	    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
	    $info   =   $upload->upload();
	    if($info){
	    	$rec['image']=$info['img']['savepath'].$info['img']['savename'];
	    	$Mysql=M('ad');
		    $where['id']=I('get.id');
	    	$Mysql->where($where)->save($rec);
	    	unlink('./Uploads/'.$rec['oldimg']);    //删除原图
	    	$data=array('status'=>1,'msg'=>'修改成功');
	    }else{
	    	$error=$upload->getError();
	    	$data=array('status'=>-1,'msg'=>$error);
	    }
	    $this->ajaxReturn($data);
	}
	
	//添加广告图
	//需求参数
	//提供参数
	public function add_ad(){
		$rec=I('post.');
	    $rec['program_id']=I('program_id');
	    $Mysql=M('ad');
	    $row=$Mysql->where(array('title'=>$rec['title'],'program_id'=>$rec['program_id']))->find();
	    if($row){
	    	$data=array('status'=>2,'msg'=>'该标题已存在，可前往编辑');
	    }else{
	    	$upload = new \Think\Upload();// 实例化上传类
		    $upload->maxSize   =     3145728 ;// 设置附件上传大小
		    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
		    $info   =   $upload->upload();
		    if($info){
		    	
		    	$rec['image']=$info['image01']['savepath'].$info['image01']['savename'];

			    $Mysql->add($rec);
		        $data=array('status'=>1,'msg'=>'添加成功');		
		    }else{
		    	$error=$upload->getError();
	    	    $data=array('status'=>-1,'msg'=>$error);
		    }
	    }
	    $this->ajaxReturn($data);
	}
	
	//删除广告图
	//需求参数id
	//提供参数
	public function del_ad(){
		$id=I('get.id');
        $Mysql=M('ad');
        $res=$Mysql->delete($id);
        if($res){
        	$img=$Mysql->field('image')->where(array('id'=>$id))->find();
        	unlink('./Uploads/'.$img['image']);
        	$data=array('status'=>1,'msg'=>'删除成功');
        }else{
        	$data=array('status'=>-1,'msg'=>'操作失败');
        }
        $this->ajaxReturn($data);
	}
    //广告显示与隐藏
    //需求参数  广告ID 当前状态is_show
    //提供参数
    public function show_ad(){
    	$show=I('is_show');
    	$id=I('id');
    	if(empty($id)){
    		$data=array('status'=>-2,'msg'=>'没有参数');
    		$this->ajaxReturn($data);
    		exit;
    	}
    	$M=M('ad');
    	if($show==1){
    		$show=2;
    	}else if($show==2){
    		$show=1;
    	}else{
    		$data=array('status'=>-3,'msg'=>'参数有误');
    		$this->ajaxReturn($data);
    		exit;
    	}
    	if(is_array($id)){
    		if($M->where('id in('.implode(',',$getid).')')->save(array('is_show'=>$show))){
    		$data=array('status'=>1,'msg'=>'操作成功');
    	}else{
    		$data=array('status'=>-1,'msg'=>'操作失败');
    		}
    	}else{
    		if($M->where('id='.$id)->save(array('is_show'=>$show))){
    		$data=array('status'=>1,'msg'=>'操作成功');
    	}else{
    		$data=array('status'=>-1,'msg'=>'操作失败');
    		}
    	}
    		$this->ajaxReturn($data);
    }
	
	//公告管理列表
	//需求参数 program_id  
	//提供参数id,sort,title,url,style,content
	public function notice_list(){
		$str1=isset($_POST['str1'])?$_POST['str1']:'';    //is_show  显示1 不显示2
		$str2=isset($_POST['str2'])?$_POST['str2']:'';    //title  标题 
		$where['_string']='(title like "%'.$str2.'%")  AND (style like "%'.$str1.'%")';
		$where['program_id']=I('get.program_id');
		$Mysql=M('notice');
		$field='id,sort,title,url,style,content';
		$data=$Mysql->field($field)->where($where)->select();
		$this->ajaxReturn($data);
	}
	
	//修改公告
	//需求参数id 
	//提供参数id,sort,title,url,style,content,image
	public function upd_notice(){
		$where['id']=I('get.id');
		$Mysql=M('notice');
		$data=$Mysql->where($where)->find();
	    $this->ajaxReturn($data);
	}
	
	//修改公告1
	//需求参数id,sort,title,url,style,content,oldimg
	//提供参数
	public function upd_notice1(){
		$rec=I('post.');
        $upload = new \Think\Upload();// 实例化上传类
	    $upload->maxSize   =     3145728 ;// 设置附件上传大小
	    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
	    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
	    $info   =   $upload->upload();
	    if($info){
	    	$rec['image']=$info['img']['savepath'].$info['img']['savename'];
	    	$Mysql=M('notice');
		    $where['id']=I('get.id');
	    	$Mysql->where($where)->save($rec);
	    	unlink('./Uploads/'.$rec['oldimg']);    //删除原图
	    	$data=array('status'=>1,'msg'=>'修改成功');
	    }else{
	    	$error=$upload->getError();
	    	$data=array('status'=>-1,'msg'=>$error);
	    }
	    $this->ajaxReturn($data);
	}
	
	//添加公告
	//需求参数 program_id 
	//提供参数
	public function add_notice(){
		$rec=I('post.');
	    $rec['program_id']=I('program_id');
	    $Mysql=M('notice');
	    $row=$Mysql->where(array('title'=>$rec['title'],'program_id'=>$rec['program_id']))->find();
	    if($row){
	    	$data=array('status'=>2,'msg'=>'该标题已存在，可前往编辑');
	    }else{
	    	$upload = new \Think\Upload();// 实例化上传类
		    $upload->maxSize   =     3145728 ;// 设置附件上传大小
		    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
		    $info   =   $upload->upload();
		    if($info){
		    	
		    	$rec['image']=$info['image01']['savepath'].$info['image01']['savename'];

		    	$Mysql->add($rec);
		        $data=array('status'=>1,'msg'=>'添加成功');		
		    }else{
		    	$error=$upload->getError();
	    	    $data=array('status'=>-1,'msg'=>$error);
		    }
	    }
	      $this->ajaxReturn($data);
	}
	
	//删除公告
	//需求参数id
	//提供参数
	public function del_notice(){
		$id=I('get.id');
        $Mysql=M('notice');
        $res=$Mysql->delete($id);
        if($res){
        	$img=$Mysql->field('image')->where(array('id'=>$id))->find();
        	unlink('./Uploads/'.$img['image']);
        	$data=array('status'=>1,'msg'=>'删除成功');
        }else{
        	$data=array('status'=>-1,'msg'=>'操作失败');
        }
        $this->ajaxReturn($data);
	}
	   //公告显示与隐藏
    //需求参数  公告ID 当前状态is_show
    //提供参数
    public function show_notice(){
    	$show=I('is_show');
    	$id=I('id');
    	if(empty($id)){
    		$data=array('status'=>-2,'msg'=>'没有参数');
    		$this->ajaxReturn($data);
    		exit;
    	}
    	$M=M('notice');
    	if($show==1){
    		$show=2;
    	}else if($show==2){
    		$show=1;
    	}else{
    		$data=array('status'=>-3,'msg'=>'参数有误');
    		$this->ajaxReturn($data);
    		exit;
    	}
    	if(is_array($id)){
    		if($M->where('id in('.implode(',',$getid).')')->save(array('style'=>$show))){
    			$data=array('status'=>1,'msg'=>'操作成功');
    		}else{
    		$data=array('status'=>-1,'msg'=>'操作失败');
    		}
    	}else{
    		if($M->where('id='.$id)->save(array('style'=>$show))){
    			$data=array('status'=>1,'msg'=>'操作成功');
    		}else{
    		$data=array('status'=>-1,'msg'=>'操作失败');
    		}
    	}
    		$this->ajaxReturn($data);
    }
    
    //首页推荐
         /*
          分类：1=>新上商品，2=>促销商品，3=>推荐商品，4=>热卖商品，5=>包邮商品
          */
    //需求参数 小程序ID program_id
    //提供参数recommend_id
    public function recommend_info(){
    	$where['program_id']=I('program_id');
    	$data=M('index_recommend')->field('recommend_id')->where($where)->select();
//  	print_r($list);
        $this->ajaxReturn($data);
    }
    
    //操作首页推荐
    //需求参数小程序ID program_id 推荐ID rid=array()
    //提供参数  操作状态信息    操作之后得到一推荐的 id rid
    public function recommend_handle(){
    	$M=M('index_recommend');
    	$pid=I('program_id');
//      $pid="JT201709011821539094";
        $rid=I('rid');
//      $rid=array(1,4,5);
        $time=time();
        $M->where(array('program_id'=>$pid))->delete();//删除所有$pid的推荐
        $str='insert into index_recommend (recommend_id,program_id,time) values ';
        for($i=0;$i<count($rid);$i++){
        	$str.="(".$rid[$i].",'".$pid."','".$time."'),";
        }
       if($M->execute(substr($str,0,strlen($str)-1))){
       	$data=array('status'=>1,'msg'=>'操作成功');
       }else{
       	$data=array('status'=>-1,'msg'=>'操作失败');
       }
       $data['rid']=$M
       ->field('recommend_id')
       ->where(array('program_id'=>$pid))
       ->select();
       $this->ajaxReturn($data);
    }
}
?>
