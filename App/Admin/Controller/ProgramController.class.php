<?php
namespace Admin\Controller;
use Think\Controller;
class ProgramController extends CommonController {
    //页面加载
    public function index(){
      $a=  $this->user_info=M("mamage_p")->where(" is_show_new= 1")->order("time desc")->select();

		$this->display();
	}
	//添加
    function add(){
        $this->display();
    }
    //编辑
    function edit(){
    	
    	if($_GET["gengxin"]){
    		$this->gengxin="1";
    	}
    	
        $this->info=M("mamage_p")->where("id='".$_GET["id"]."'")->find();
        $this->display('add');
    }
    
    //删除
    function delete(){
    	$mamage_p=M("mamage_p")->where("id='".$_GET["id"]."'")->find();
        if(M("mamage_p")->where("id='".$_GET["id"]."'")->delete()){
        	
        	unlink('./Zip/'.$mamage_p["url"]);
        	
            $this->success('删除成功',U('Program/index'));
        }else{
            $this->error('删除失败');
        }
    }

	//历史版本查看
	function history(){
		$this->info=M("mamage_p")->where("program_id='".$_GET["program_id"]."'")->order("time desc")->select();

		$this->display();	
	}

	//文件上传
    public function img_upload(){
    	
    //	dump($_POST);die;
        $receive=I();
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     30145728 ;// 设置附件上传大小
        $upload->exts      =     array('zip','rar','7z','jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './Zip/'; // 设置附件上传根目录
        $info   =   $upload->upload();

        if($info){
            $receive["file_name"]=$info['url']['name'];
            $receive["time"]=time();
            $receive['url']=$info['url']['savepath'].$info['url']['savename'];
            $receive["is_show_new"]="1";
            //将原有的这个小程序id的记录都变成历史版本
            $save["is_show_new"]="2";
            M("mamage_p")->where("program_id='".$receive["program_id"]."'")->save($save);
            
            if(M('mamage_p')->add($receive)){
                $this->success('添加成功',U('Program/index'));
            }else{
                $this->error('添加失败');
            }
        }else{
            $this->error('无上传文件');
            $error=$upload->getError();
            $data=array("status" => -1, "msg" => "文件上传失败",'error'=>$error);
        }
    }
    //文件下载
        function load_zip(){
        $mamage_p=M("mamage_p")->where("id='".$_GET['id']."'")->find();
            $file_name=$mamage_p["file_name"];
            $url='./Zip/'.$mamage_p["url"];

            $save["time_last_download"]=time();
            M("mamage_p")->where("id='".$_GET['id']."'")->save($save);
           $this->downfile($url,$file_name);


        }
        //http  header 下载文件
    function downfile($fileurl,$file_name){
        $filename=$fileurl;
        $file  =  fopen($filename, "rb");
        Header( "Content-type:  application/octet-stream ");
        Header( "Accept-Ranges:  bytes ");
        Header( "Content-Disposition:  attachment;  filename= ".$file_name);
        $contents = "";
        while (!feof($file)) {
            $contents .= fread($file, 8192);
        }
        echo $contents;
        fclose($file);
    }

}