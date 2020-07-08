<?php
namespace AdminPnew\Controller;
use Think\Controller;
class MerchController extends CommonController {
//多商品概述
//申请中
//驳回
//待入驻
//入驻中    
//暂停中      
//即将到期
//多商户分组
//多商户分类
//数据 订单统计
//数据 多商户统计
//提现 待确认
//提现 待打款
//提现 已打款
//提现 无效的
//结算订单  待确认
//结算订单  待结算
//结算订单  已结算
//结算订单  创建结算清单
//基础设置
    //多商品概述
    public function index(){
    	//当前状态（1：待审核、2：待入驻（邀请）、3：审核通过（正常）、4:审核拒绝、5：上级禁止、6：服务到期禁止）
$a1=0;//入驻申请中
$a2=0;//入驻申请驳回
$a3=0;//待入驻商户
$a4=0;//入驻中商户
$a5=0;//暂停中商户

	$count=M("user_info_dsh")->field('state')->where("program_id='".$_COOKIE["program_id"]."'")->select();
	for($i=0;$i<count($count);$i++){
		if($count[$i]["state"]==1){
			$a1++;
		}else if($count[$i]["state"]==2){
			$a3++;
		}else if($count[$i]["state"]==3){
			$a4++;
		}else if($count[$i]["state"]==4){
			$a2++;
		}else if($count[$i]["state"]==5){
			$a5++;
		}else if($count[$i]["state"]==6){
			$a5++;
		}
	}
$this->count=$arr=array('k1'=>$a1,'k2'=>$a2,'k3'=>$a3,'k4'=>$a4,'k5'=>$a5);


    	$this->display();
	}
    //========================多商户管理=========================================
    //申请中
    public function apply_ing(){
//当前状态（1：待审核、2：待入驻（邀请）、3：审核通过（正常）、4:审核拒绝、5：上级禁止、6：服务到期禁止）
 		$a=$tist->list=$this->get_orderlist(1);
 		//dump(M("user_info_dsh")->_sql());
 	
        $this->display();
    }
    //驳回
    public function apply_reject(){
//当前状态（1：待审核、2：待入驻（邀请）、3：审核通过（正常）、4:审核拒绝、5：上级禁止、6：服务到期禁止）
 		$tist->list=$this->get_orderlist(4);
        $this->display();
    }
    //待入驻
    public function in_wait(){
    //当前状态（1：待审核、2：待入驻（邀请）、3：审核通过（正常）、4:审核拒绝、5：上级禁止、6：服务到期禁止）
 		$tist->list=$this->get_orderlist(2);
        $this->display();
    }
    //入驻中
    public function in_ing(){
//当前状态（1：待审核、2：待入驻（邀请）、3：审核通过（正常）、4:审核拒绝、5：上级禁止、6：服务到期禁止）
 		$tist->list=$this->get_orderlist(3);
        $this->display();
    }
    //暂停中
    public function in_stop(){
//当前状态（1：待审核、2：待入驻（邀请）、3：审核通过（正常）、4:审核拒绝、5：上级禁止、6：服务到期禁止）
 		$tist->list=$this->get_orderlist(5);
        $this->display();
    }
    //即将到期
    public function in_stop_soon(){

        $this->display();
    }
    
    //多商户分组
    public function merch_group(){

        $this->display();
    }
    //多商户分类
    public function merch_fenlei(){
//attribute_style  分类类型（1：商品分类、2：多商户分类）
		$this->info=$fl=M("attribute")
		->field('id,uid,title,image_1,is_show,sort')
		->where("dsh_id=0 and attribute_style=2 and program_id='".$_COOKIE["program_id"]."'" )
		->select();
		$this->count=count($fl);
		$this->display();
    }
    public function merch_fenlei_add(){

        $this->display();
    }
    
    	//添加子分类
	public function fenlei_add02(){
		$this->add_child=$_GET["id"];
		
		$this->display('merch_fenlei_add');
	}
	
	public function merch_fenlei_edit(){
		 $a= $this->info=M('attribute')->where("id=".$_GET['id'])->find();
	
		$this->display('merch_fenlei_add');
	}
	
	public function run_merch_fenlei_add(){
		$receive=I();
		$receive["program_id"]=$_COOKIE["program_id"];
			$upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =     3145728 ;// 设置附件上传大小
			    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录

			    // 上传文件 
			    $info   =   $upload->upload();
			    
		 if(empty($_GET['id'])) {
		 	//执行添加操作==================================
			 if($info){
                    $receive['image_1']=$info['image02']['savepath'].$info['image02']['savename'];
				$receive["attribute_style"]="2";
					$receive["dsh_id"]=0;
				     if(M('attribute')->add($receive)){
				    	$this->success('添加成功',U('merch_fenlei'));
				    }else{
				    	$this->error('添加失败');	
				    }
			    
			    }else{
			    	/*$this->error('无上传图片');	
                	$error=$upload->getError();
		    		$data=array("status" => -1, "msg" => "图片上传失败",'error'=>$error);*/
		    		$receive["attribute_style"]="2";
					$receive["dsh_id"]=0;
				     if(M('attribute')->add($receive)){
				    	$this->success('添加成功',U('merch_fenlei'));
				    }else{
				    	$this->error('添加失败');	
				    }
			    }
            
        }else {
        	//执行修改操作=====================================
       
        
			if($info){
                  $receive['image_1']=$info['image02']['savepath'].$info['image02']['savename'];

			     if(M('attribute')->where(array('id'=>$_GET['id']))->save($receive)){
		//如果对一级分类进行隐藏，则对应的二级分类都要隐藏
		        	$a0926=M("attribute")->where("id='".$_GET["id"]."'")->find();	
		        	if($a0926["uid"]==0){
		        		$date0926["is_show"]="2";
		        		M("attribute")->where("uid='".$_GET["id"]."'")->save($date0926);
		        	}
			     	
			    	$this->success('修改成功2',U('merch_fenlei'));
			    }else{
			    	$this->error('修改失败2');	
			    }
			    
			    }else{
			  if(M('attribute')->where(array('id'=>$_GET['id']))->save($receive)){
//如果对一级分类进行隐藏，则对应的二级分类都要隐藏
        	$a0926=M("attribute")->where("id='".$_GET["id"]."'")->find();	
		        	if($a0926["uid"]==0){
		        		$date0926["is_show"]="2";
		        		M("attribute")->where("uid='".$_GET["id"]."'")->save($date0926);
		        	}
			    	$this->success('修改成功02',U('merch_fenlei'));
			    }else{
			    	$this->error('修改失败02');	
			    }
			}
       }   
	}
	
	//分类删除
		public function merch_fenlei_delete(){
				 $user_id =$_GET['id'];
			$d_zhu_img=M('attribute')->where("id='".$_GET['id']."'")->find();
	        $d_zi_img=M('attribute')->where("uid='".$_GET['id']."'")->select();
	        	
	        if(M('attribute')->delete($user_id)) {
	        	//删除主类图片
	        	unlink('./Uploads/'.$d_zhu_img["image_1"]);
	        	
	        	
	        	//删除 所属 子类 图片
	        	for($i=0;$i<count($d_zi_img);$i++){
	        		unlink('./Uploads/'.$d_zi_img[$i]["image_1"]);
	        	}
	        	
	        	//删除 所属 子类  数据
	        	$all["uid"]=$_GET['id'];
	        	M('attribute')->delete($all);
	            $this->success('删除成功');
	        } else {
	            $this->error('删除失败');
	        }
		}
    //========================数据=========================================
    //数据 订单统计
    public function order_count(){

        $this->display();
    }
    //数据 多商户统计
    public function merch_count(){

        $this->display();
    }
    //========================数据=========================================
    //提现 待确认
    public function cash_appay(){

        $this->display();
    }
    //提现 待打款
    public function cash_pay(){

        $this->display();
    }
    //提现 已打款
    public function cash_pay_done(){

        $this->display();
    }
    //提现 无效的
    public function cash_none(){

        $this->display();
    }
    //========================结算订单=========================================
    //结算订单  待确认
    public function m_merch_appay(){

        $this->display();
    }
    //结算订单  待结算
    public function m_merch_wite(){

        $this->display();
    }
    //结算订单  已结算
    public function m_merch_done(){

        $this->display();
    }
    //结算订单  创建结算清单
    public function m_merch_build(){

        $this->display();
    }
    //基础设置
    public function merch_set(){
   
   	$this->info=M("store")->where("program_id='".$_COOKIE["program_id"]."'")->find();
 
   $user_info= M("user_info")->where("name='".$_COOKIE["name_p"]."'")->find();
    $this->ownid=$user_info["id"];
    $this->display();
    }
    //提交协议  
    function xieyi_submit(){
    
		
		if(M("store")->where("program_id='".$_COOKIE["program_id"]."'")->save($_POST)){
			 $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
		    
    
    }
    
    //公用根据状态不同查询值
    function get_orderlist($state=''){
     	$where["program_id"]=$_COOKIE["program_id"];
    	$where["state"]=$state;
    	
    	$field='
    	id,sort,sh_name,linkman,tel,time_add,time_over,state,main_project
		';
		$list=$this->list=M("user_info_dsh")
		->field($field)
		->where($where)
		->select();
		return $list;
	}
    /**手机端商户申请通过*/
   public function sh_agree(){
  		$save["state"]="3";
        if(M('user_info_dsh')->where("id='".$_GET['id']."'")->save($save)) {
            $this->success('审核成功');
        }else {
            $this->error('审核失败');
        }
   }
       /**邀请入驻商户申请通过*/
   public function sh_agree_in(){
  		$save["state"]="3";
        if(M('user_info_dsh')->where("id='".$_GET['id']."'")->save($save)) {
            $this->success('审核成功');
        }else {
            $this->error('审核失败');
        }
   }
    /**手机端商户申请详情*/
   public function apply_con(){
   	echo "维护中";
   }
    /**暂停*/
	  public function sh_stop_used(){
	  	$save["state"]="5";
        if(M('user_info_dsh')->where("id='".$_GET['id']."'")->save($save)) {
            $this->success('暂停成功');
        }else {
            $this->error('暂停失败');
        }
	  }
   
	   /**暂停的号恢复*/
	  public function sh_back_used(){
	  	$save["state"]="3";
        if(M('user_info_dsh')->where("id='".$_GET['id']."'")->save($save)) {
            $this->success('恢复成功');
        }else {
            $this->error('恢复失败');
        }
	  }
    /**删除多商户*/
    public function sh_delete(){
    	
    	
        $user_id = $_GET['id'];
        if(M('user_info_dsh')->delete($user_id)) {
            $this->success('删除成功');
            
            //数据删除0925...20.40
        } else {
            $this->error('删除失败');
        }
    }
    
    //商户修改密码
    public function change_psw(){
    	   $date["sh_psw"]=md5($_POST["sh_psw"]);
    	   
        if(M('user_info_dsh')->where("id='".$_GET["id"]."'")->save($date)) {
            $this->success('修改成功');
        } else {
            $this->error('修改失败');
        }
    }
    //添加商户
    function add_sh(){
    	$fenlei=$this->fenlei=M("attribute")
		->field('id,uid,title')
		->where("uid=0 and attribute_style=2 and dsh_id=0 and program_id='".$_COOKIE["program_id"]."'")->select();
		
    //	dump($fenlei);dump(M("attribute")->_sql());die;
    $a=$this->time_over=date("Y-m-d 23:59:59",strtotime("1 year"));
    	$this->display();
    }
    
     //添加商户
    function edit_sh(){   	
    	$fenlei=$this->fenlei=M("attribute")
		->field('id,uid,title')
		->where("uid=0 and attribute_style=2 and dsh_id=0 and program_id='".$_COOKIE["program_id"]."'")->select();
		
    	
    	
    	$this->is_edit="1";
 		$a= M('user_info_dsh')->where("id='".$_GET["id"]."'")->find();
		
		$b=M("attribute")->where("id='".$a["fl_id"]."'")->find();
		$a["fl_title"]=$b["title"];
		$this->info=$a;
    	$this->display('add_sh');
    }
   //添加修改按钮 
    function runAdd_merch(){
    	//邀请商户，添加商户    多商户的商户和 服务商的商户是直接关系，和服务商无关
    	
    	$receive=I();
    	//获取上级商户id
    	$shagnhu=M("user_info")->where("name='".$_COOKIE["name_p"]."'")->find();
    	$receive["user_id"]=$shagnhu["id"];			//商户账号
		$receive["program_id"]=$_COOKIE["program_id"];  //小程序id
	
			$upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =     3145728 ;// 设置附件上传大小
			    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
			    // 上传文件 
			    $info   =   $upload->upload();
			    
		 if(empty($_GET['id'])) {
		 	//未接收id ，执行添加操作------------------------------------
			 if($info){
			 	//有上传图片==========================================
                $receive['logo']=$info['image']['savepath'].$info['image']['savename'];
				   
				  	$receive["time_add"]=time();//添加时间
				  	$receive["time_over"]=strtotime($_POST["time_over_f"]);//到期时间
					
					$receive["state"]="2";//邀请入驻
					
					$receive["sh_psw"]=md5($receive["sh_psw"]);
				    if(M('user_info_dsh')->add($receive)){
				    	$this->success('添加成功',U('Merch/apply_ing'));
				    }else{
				    	$this->error('添加失败');	
				    }
			    }else{
			    //无上传图片==========================================	
			    	$this->error('无上传图片');	
                	$error=$upload->getError();
		    		$data=array("status" => -1, "msg" => "图片上传失败",'error'=>$error);
			    }
            
        }
        else {
        	//接收id ，执行修改操作-------------------------------------------
			if($info){
//有上传图片=================================================================
                  $receive['logo']=$info['image']['savepath'].$info['image']['savename'];
				     if(M('user_info_dsh')->where(array('id'=>$_GET['id']))->save($receive)){
				    	$this->success('修改成功',U('Merch/apply_ing'));
				    }else{
				    	$this->error('修改失败');	
				    }
			    }else{
//无上传图片==================================================================
			  if(M('user_info_dsh')->where(array('id'=>$_GET['id']))->save($receive)){
			    	$this->success('修改成功',U('Merch/apply_ing'));
			    }else{
			    	$this->error('修改失败');	
			    }
			}
       }
    	
    	
    	
    	
    }
    
    //一点一码
    function qdcode(){
    	if(empty($_GET["id"])){
    		$this->error('参数错误');
    	}
    	//看看服务器有没有这个二维码
    	$is_qdcode=M("user_info_dsh")->where("id='".$_GET["id"]."'")->find();
    	
    		if(!empty($is_qdcode["qd_code"])){
	    			unlink('./'.$is_qdcode["qd_code"]);
	    			
	    		}
    	
    		$a=$this->test($program_id=$_COOKIE["program_id"],$dsh_id=$_GET["id"]);//存入物理图片
    		if($a){
    			$save["qd_code"]=substr($a, 2);
    	
	    		M("user_info_dsh")->where("id='".$_GET["id"]."'")->save($save);
	    		
	    		
	    		$url=$save["qd_code"];
	    		//dump($url);die;
	    		$file_name="二维码.jpg";
	    		if(!empty($url)){
	    			$this->downfile($url,$file_name);//下载服务器图片
	    		}else{
	    			$this->error('生成二维码错误');
	    		}
	    		
    		}else{
    			$this->error('生成二维码错误');
    		}
    		
    	
    	
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
    //保存二维码
    function test($program_id,$dsh_id) {
        $url = 'http://sz800800.cn/pg.php/Qdcode/qd_code_dsh?program_id='.$program_id.'&dsh_id='.$dsh_id;

        $header = array("Connection: Keep-Alive", "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8", "Pragma: no-cache", "Accept-Language: zh-Hans-CN,zh-Hans;q=0.8,en-US;q=0.5,en;q=0.3", "User-Agent: Mozilla/5.0 (Windows NT 5.1; rv:29.0) Gecko/20100101 Firefox/29.0");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, $v);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');

        $content = curl_exec($ch);
        $curlinfo = curl_getinfo($ch);
      //  echo "string";
      //  print_r($curlinfo);
//关闭连接
        curl_close($ch);

        if ($curlinfo['http_code'] == 200) {
            if ($curlinfo['content_type'] == 'image/jpeg') {
                $exf = '.jpg';
            } else if ($curlinfo['content_type'] == 'image/png') {
                $exf = '.png';
            } else if ($curlinfo['content_type'] == 'image/gif') {
                $exf = '.gif';
            }
//存放图片的路径及图片名称  *****这里注意 你的文件夹是否有创建文件的权限 chomd -R 777 mywenjian

      //         $filename = date("YmdHis") . uniqid() . $exf;//这里默认是当前文件夹，可以加路径的 可以改为 $filepath = '../'.$filename
                 $filename = date("YmdHis") . uniqid() . ".jpg";//这里默认是当前文件夹，可以加路径的 可以改为 $filepath = '../'.$filename
             $filepath = './qdcode/'.$filename;

            //   $res = file_put_contents($filename, $content);//同样这里就可以改为$res = file_put_contents($filepath, $content);
              $res = file_put_contents($filepath, $content);
        }
        return $filepath;
    }
}