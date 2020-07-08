<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>互联网生态圈营销中心</title>
		<meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="/Public/new0127/css/selfcss.css" />
		<link rel="stylesheet" href="/Public/new0127/css/bootstrap.min.css" />
		<link rel="stylesheet" href="/Public/new0127/css/bootstrap-responsive.min.css" />
		<link rel="stylesheet" href="/Public/new0127/css/fullcalendar.css" />	
		<link rel="stylesheet" href="/Public/new0127/css/unicorn.main.css" />
		<link rel="stylesheet" href="/Public/new0127/css/unicorn.grey.css" class="skin-color" />
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
	<body>
		<!-- 代码 开始 -->
		<div id="header"><h1><a href="#">互联网生态圈营销中心</a></h1></div>
        
		<div id="user-nav" class="w80 navbar navbar-inverse ">
            <!--================商城版==============开始==============-->
<!--
JT201808090855119076 ：能量ktv 
JT201807260907385777 ：家庭教育  <?php if($program_id == JT201807260907385777): ?>课程<?php else: ?>商品<?php endif; ?>
-->
            <?php if($head_menu == 1): ?><ul class="w100 nav btn-group ">
	                <li class="btn btn-inverse"><a title="" href="<?php echo U('Index/index');?>"><i class="icon icon-home"></i> 
	                	<span class="text">首页</span></a></li>
	                <?php if(($program_id != JT201808090855119076) & ($program_id != JT201807260907385777)): ?><li class="btn btn-inverse"><a title="" href="<?php echo U('Goods/selling');?>"><i class="icon icon-shopping-cart"></i>
	                	<span class="text">商品</span></a></li><?php endif; ?>	
	   				<?php if(($program_id == JT201807260907385777)): ?><li class="btn btn-inverse"><a title="" href="<?php echo U('Goods/selling');?>"><i class="icon icon-shopping-cart"></i>
	                	<span class="text">课程</span></a></li><?php endif; ?>
	                <?php if(($program_id == JT201806151732369242)): ?><!--百业联盟-->
	          	    	<li class="btn btn-inverse"><a title="" href="<?php echo U('Plan/index');?>"><i class="icon icon-shopping-cart"></i>
	                	<span class="text">方案管理</span></a></li><?php endif; ?>
	                
<?php if($program_id == JT201808090855119076): ?><li class="btn btn-inverse"><a title="" href="<?php echo U('Goods/selling');?>"><i class="icon icon-shopping-cart"></i>
	                	<span class="text">房台套餐</span></a></li>
	 				<li class="btn btn-inverse"><a title="" href="<?php echo U('Goodsbear/selling');?>"><i class="icon icon-shopping-cart"></i>
	                	<span class="text">在线酒水</span></a></li>	
	                <li class="btn btn-inverse"><a title="" href="<?php echo U('Goodsavec/selling');?>"><i class="icon icon-shopping-cart"></i>
	                	<span class="text">存酒管理</span></a></li>	
	                <li class="btn btn-inverse"><a title="" href="<?php echo U('Room/index');?>"><i class="icon icon-shopping-cart"></i>
	                	<span class="text">歌房</span></a></li>	
	                <li class="btn btn-inverse"><a title="" href="<?php echo U('Assistant/assistant_is');?>"><i class="icon icon-shopping-cart"></i>
	                	<span class="text">员工管理</span></a></li>	
	                <!--<li class="btn btn-inverse"><a title="" href="<?php echo U('Vip/index');?>"><i class="icon icon-shopping-cart"></i>
	                	<span class="text">会员管理</span></a></li>	-->
	                <li class="btn btn-inverse"><a title="" href="<?php echo U('Members/index');?>"><i class="icon icon-user"></i> 
	                	<span class="text">会员</span></a></li>
	                <li class="btn btn-inverse"><a title="" href="<?php echo U('Warehouse/canggui');?>"><i class="icon icon-user"></i> 
	                	<span class="text">仓库管理</span></a></li><?php endif; ?>	
<?php if($program_id != JT201808090855119076): ?><li class="btn btn-inverse"><a title="" href="<?php echo U('Members/index');?>"><i class="icon icon-user"></i> 
	                	<span class="text">会员</span></a></li><?php endif; ?>	          	   
<?php if($program_id == JT201710101645145951): ?><!--兰茜美容美甲-->
	                <li class="btn btn-inverse"><a title="" href="<?php echo U('Video/index');?>"><i class="icon icon-user"></i> 
	                	<span class="text">视频专区</span></a></li>
	                <li class="btn btn-inverse"><a title="" href="<?php echo U('Rebate/index');?>"><i class="icon icon-user"></i> 
	                	<span class="text">抵用券</span></a></li><?php endif; ?>	
<?php if($program_id == JT201810111844206577): ?><!--珠宝-->
	                <li class="btn btn-inverse"><a title="" href="<?php echo U('Gold/index');?>"><i class="icon icon-user"></i> 
	                	<span class="text">实时金价</span></a></li><?php endif; ?>	
	          	    <?php if(($program_id != JT201807211029526361) && ($program_id != JT201808090855119076)): ?><li class="btn btn-inverse"><a title="" href="<?php echo U('Order/index');?>"><i class="icon icon-list-alt"></i> 
	          	    	<span class="text">订单</span></a></li><?php endif; ?>
	          	    <?php if($program_id == JT201807211029526361): ?><li class="btn btn-inverse"><a title="" href="<?php echo U('Booking/index');?>"><i class="icon icon-list-alt"></i> 
	          	    	<span class="text">订单</span></a></li><?php endif; ?>	
	          	    <?php if($program_id == JT201808090855119076): ?><li class="btn btn-inverse"><a title="" href="<?php echo U('Orderktvroom/index');?>"><i class="icon icon-list-alt"></i> 
	          	    	<span class="text">房台套餐订单</span></a></li>
	          	    	<li class="btn btn-inverse"><a title="" href="<?php echo U('Orderktvonlinebeer/index');?>"><i class="icon icon-list-alt"></i> 
	          	    	<span class="text">在线酒水订单</span></a></li><?php endif; ?>
	          	    	
	          	<!--<?php if(($program_id != JT201709251030119718) and ($program_id != JT201711041549052325) and ($program_id != JT201710161553526657)): ?><li class="btn btn-inverse"><a title="" href="<?php echo U('Preferential/index');?>"><i class="icon icon-gift"></i> 
	          	    	<span class="text">营销</span></a></li><?php endif; ?> -->
	            <?php if($duodian == 1): ?><li class="btn btn-inverse"><a title="" href="<?php echo U('Merch/index');?>"><i class="icon icon-hdd"></i> 
	                	<span class="text">多商户</span></a></li><?php endif; ?>  
	            <?php if($fenxiao == 1): ?><li class="btn btn-inverse"><a title="" href="<?php echo U('Distribution/index');?>"><i class="icon icon-fullscreen"></i> 
	        	    	<span class="text">分销</span></a></li><?php endif; ?>
	            <?php if($store['is_submit_contect'] == 1): ?><li class="btn btn-inverse"><a title="" href="<?php echo U('FuWucontect/index');?>"><i class="icon icon-fullscreen"></i> 
	        	    	<span class="text">联系管理</span></a></li><?php endif; ?>
	         	   <li class="btn btn-inverse"><a title="" href="<?php echo U('Set/index');?>"><i class="icon  icon-asterisk"></i> 
	                	<span class="text">设置</span></a></li>
	                <li class="fl_r btn btn-inverse "><a title="" href="<?php echo U('Login/logout');?>"><i class="icon  icon-share-alt"></i> 
	                	<span class="text">退出</span></a></li>
	            </ul><?php endif; ?>
            <!--================商城版==============结束==============-->	
            
            <!--================资讯版==============开始==============-->
             <?php if($head_menu == 5): ?><ul class="w100 nav btn-group ">
	                <li class="btn btn-inverse"><a title="" href="<?php echo U('IndexZiXun/index');?>"><i class="icon icon-home"></i> 
	                	<span class="text">首页</span></a></li>
	            <?php if($program_id == JT201710160953394557): ?><!--大创业平台-->
	                <li class="btn btn-inverse"><a title="" href="<?php echo U('InfoZiXun/caigou');?>"><i class="icon icon-shopping-cart"></i>
	                	<span class="text">信息管理</span></a></li>
	            <?php else: ?>
	            	<li class="btn btn-inverse"><a title="" href="<?php echo U('Case/index');?>"><i class="icon icon-shopping-cart"></i>
	                	<span class="text">信息管理</span></a></li><?php endif; ?>    	
	                <li class="btn btn-inverse"><a title="" href="<?php echo U('Members/index');?>"><i class="icon icon-user"></i> 
	                	<span class="text">会员</span></a></li>
	            <?php if($duodian == 1): ?><li class="btn btn-inverse"><a title="" href="<?php echo U('Merch/index');?>"><i class="icon icon-hdd"></i> 
	                	<span class="text">多商户</span></a></li><?php endif; ?>  
	            <?php if($fenxiao == 1): ?><li class="btn btn-inverse"><a title="" href="<?php echo U('Distribution/index');?>"><i class="icon icon-fullscreen"></i> 
	        	    	<span class="text">分销</span></a></li><?php endif; ?>
	                <li class="btn btn-inverse"><a title="" href="<?php echo U('Set/index');?>"><i class="icon  icon-asterisk"></i> 
	                	<span class="text">设置</span></a></li>
	                <li class="fl_r btn btn-inverse "><a title="" href="<?php echo U('Login/logout');?>"><i class="icon  icon-share-alt"></i> 
	                	<span class="text">退出</span></a></li>
	            </ul><?php endif; ?>
            <!--================资讯版==============结束==============-->
            
            <!--================生活服务版==============开始==============-->
             <?php if($head_menu == 6): ?><ul class="w100 nav btn-group ">
                <li class="btn btn-inverse"><a title="" href="<?php echo U('IndexFuWu/index');?>"><i class="icon icon-home"></i> 
                	<span class="text">首页</span></a></li>
		     	<li class="btn btn-inverse"><a title="" href="<?php echo U('Goods/selling');?>"><i class="icon icon-shopping-cart"></i>
                	<span class="text">商品</span></a></li>
				<li class="btn btn-inverse"><a title="" href="<?php echo U('Order/index');?>"><i class="icon icon-list-alt"></i> 
          	    	<span class="text">订单</span></a></li>
                
                <li class="btn btn-inverse"><a title="" href="<?php echo U('FuWucontect/index');?>"><i class="icon icon-hdd"></i> 
                	<span class="text">联系管理</span></a></li>
<?php if($program_id != JT201711081030423109): ?><li class="btn btn-inverse"><a title="" href="<?php echo U('FuWuinfo/tiezi');?>"><i class="icon icon-fullscreen"></i> 
        	    	<span class="text">帖子</span></a></li>
                <li class="btn btn-inverse"><a title="" href="<?php echo U('Members/index');?>"><i class="icon icon-user"></i> 
                	<span class="text">会员</span></a></li>
		     	
          	    <li class="btn btn-inverse"><a title="" href="<?php echo U('FuWurendezvous/index');?>"><i class="icon icon-fullscreen"></i> 
        	    	<span class="text">预约</span></a></li>
        	    <li class="btn btn-inverse"><a title="" href="<?php echo U('Preferential/index');?>"><i class="icon icon-book"></i> 
                	<span class="text">营销</span></a></li><?php endif; ?>                  	
 
        	    <?php if($duodian == 1): ?><li class="btn btn-inverse"><a title="" href="<?php echo U('Merch/index');?>"><i class="icon icon-hdd"></i> 
	                	<span class="text">多商户</span></a></li><?php endif; ?>  
	            <?php if($fenxiao == 1): ?><li class="btn btn-inverse"><a title="" href="<?php echo U('Distribution/index');?>"><i class="icon icon-fullscreen"></i> 
	        	    	<span class="text">分销</span></a></li><?php endif; ?>	
                <li class="btn btn-inverse"><a title="" href="<?php echo U('Set/index');?>"><i class="icon  icon-asterisk"></i> 
                	<span class="text">设置</span></a></li>
                <li class="fl_r btn btn-inverse "><a title="" href="<?php echo U('Login/logout');?>"><i class="icon  icon-share-alt"></i> 
                	<span class="text">退出</span></a></li>
            </ul><?php endif; ?>
            <!--================生活服务版==============结束==============-->
            
            <!--================宜拖车==================开始==============-->
            <?php if($program_id == JT201712251106263726): ?><ul class="w100 nav btn-group ">
                <li class="btn btn-inverse"><a title="" href="<?php echo U('Index/index');?>"><i class="icon icon-home"></i> 
                	<span class="text">首页</span></a></li>
                <li class="btn btn-inverse"><a title="" href="<?php echo U('CarManager/index');?>"><i class="icon icon-shopping-cart"></i>
                	<span class="text">车辆管理</span></a></li>
                <li class="btn btn-inverse"><a title="" href="<?php echo U('CarMembers/index');?>"><i class="icon icon-user"></i> 
                	<span class="text">会员管理</span></a></li>
          	    <li class="btn btn-inverse"><a title="" href="<?php echo U('CarOrder/index');?>"><i class="icon icon-list-alt"></i> 
          	    	<span class="text">订单管理</span></a></li>
                <li class="btn btn-inverse"><a title="" href="<?php echo U('CarServers/car_num');?>"><i class="icon icon-book"></i> 
                	<span class="text">服务管理</span></a></li>
                <li class="btn btn-inverse"><a title="" href="<?php echo U('Carinfo/info_list');?>"><i class="icon icon-hdd"></i> 
                	<span class="text">平台资讯</span></a></li>
                <li class="btn btn-inverse"><a title="" href="<?php echo U('Set/index');?>"><i class="icon  icon-asterisk"></i> 
                	<span class="text">设置</span></a></li>
                <li class="fl_r btn btn-inverse "><a title="" href="<?php echo U('Login/logout');?>"><i class="icon  icon-share-alt"></i> 
                	<span class="text">退出</span></a></li>
            </ul><?php endif; ?><!--================宜拖车==============结束==============-->
            
            <!--================美牙管理培训中心==================开始==============-->
            <?php if($program_id == JT201805140917546604): ?><ul class="w100 nav btn-group ">
  
                <li class="btn btn-inverse"><a title="" href="<?php echo U('Set/my_indexedit');?>"><i class="icon  icon-asterisk"></i> 
                	<span class="text">设置</span></a></li>
                <li class="fl_r btn btn-inverse "><a title="" href="<?php echo U('Login/logout');?>"><i class="icon  icon-share-alt"></i> 
                	<span class="text">退出</span></a></li>
            </ul><?php endif; ?><!--================美牙管理培训中心==============结束==============-->
            
        </div>     
<div id="sidebar">

	 	<ul>
			<li ><a href="<?php echo U('Goods/selling');?>"><i class="icon icon-shopping-cart"></i> 
					<span>出售中</span></a></li>
			<li><a href="<?php echo U('Goods/haved_selled');?>"><i class="icon icon-shopping-cart"></i> 
					<span>已售罄</span></a></li>
			<li><a href="<?php echo U('Goods/cangku');?>"><i class="icon icon-shopping-cart"></i> 
					<span>仓库中</span></a></li>
			<li><a href="<?php echo U('Goods/huishou');?>"><i class="icon icon-shopping-cart"></i> 
					<span>回收站</span></a></li>
			<li><a href="<?php echo U('Goods/fenlei');?>"><i class="icon icon-shopping-cart"></i> 
					<span>分类</span></a></li>
			<?php if($program_id == JT201810111844206577): ?><li><a href="<?php echo U('Goods/fenlei_zhekou');?>"><i class="icon icon-shopping-cart"></i> 
					<span>批发价分类</span></a></li>	
			<li><a href="<?php echo U('Goods/goods_tuisong');?>"><i class="icon icon-shopping-cart"></i> 
					<span>商品推送审核</span></a></li><?php endif; ?>
		<!--<?php if($head_menu == 6): ?><li><a href="<?php echo U('Goods/jingpin');?>"><i class="icon icon-shopping-cart"></i> 
					<span>精品商品</span></a></li><?php endif; ?>	-->
		<?php if($program_id == JT201712021113483120): ?><li><a href="<?php echo U('Goods/price_daili');?>"><i class="icon icon-shopping-cart"></i> 
			<span>代理购买价管理</span></a></li><?php endif; ?>
		<?php if($program_id == JT201806151732369242): ?><li><a href="<?php echo U('Goods/goods_havedsell');?>"><i class="icon icon-shopping-cart"></i> 
			<span>已售商品汇总</span></a></li><?php endif; ?>
			<!--<li><a href="shanxuan"><i class="icon icon-th"></i> 
					<span>筛选区间</span></a></li>
			<li><a href="biaoqian"><i class="icon icon-th-list"></i> 
					<span>标签管理</span></a></li>-->
		</ul>

</div>



		
<script src="/Public/ys0925/jquery.js"></script>
<script src="/Public/ys0925/bootstrap.min.js"></script>


<link rel="stylesheet" type="text/css" href="/Public/imgupload/css/webuploader.css">
<link rel="stylesheet" type="text/css" href="/Public/imgupload/css/diyUpload.css">
<script type="text/javascript" src="/Public/imgupload/js/webuploader.html5only.min.js"></script>
<script type="text/javascript" src="/Public/imgupload/js/diyUpload.js"></script>
<!--百度编辑器-->
    	    <script type="text/javascript" charset="utf-8" src="/Public/ueditor/ueditor.config.js"></script>
	    <script type="text/javascript" charset="utf-8" src="/Public/ueditor/ueditor.all.min.js"> </script>
	    
	    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
	    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
	    <script type="text/javascript" charset="utf-8" src="/Public/ueditor/lang/zh-cn/zh-cn.js"></script>
  <script src="/Public/js/distpicker.data.js"></script>
<script src="/Public/js/distpicker.js"></script>
  <style>
   	
   	.con{
   		/*padding:40px;
*/   	}
   	  	.p_laber{
   	
   	}
<style>
.del_guige{

}
	*{ margin:0; padding:0;}
	#box{
		width: 100%;
		background: #FF9;
		padding-top: 7px;
		clear: both;
		border-radius: 12px;
	}
	#demo{
		width:81.5%;
		background:white;
		border-radius: 4px;
		border: 1px solid #ccc;

	}
</style>
<style>
        .fileinput-button {
            position: relative;
            display: inline-block;
            overflow: hidden;
        }

        .fileinput-button input{
            position:absolute;
            right: 0px;
            top: 0px;
            opacity: 0;
            -ms-filter: 'alpha(opacity=0)';
            font-size: 200px;
        }
    </style>
<div id="content">
			<div id="content-header">
				<h1>商品编辑</h1>
			</div>
			<div id="breadcrumb">
				<a href="<?php echo U('Goods/selling');?>" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 商品</a>
				<a href="<?php echo U('Goods/selling');?>" class="tip-bottom">商品管理</a>
				<a href="#" class="current">商品编辑</a>
			</div>
			<div class="container-fluid">
				<div class="row-fluid">
					<div class="span12">
						<div class="widget-box">
					<div class="tabs-container">
	                <div class="tabs">	
							<div class="widget-title">
								<span class="icon">
									<i class="icon-align-justify"></i>									
								</span>
<?php if($program_id != JT201807260907385777): ?><ul class="nav nav-tabs"style="height:60px;width:100%;">
									<li class="active">
										<a data-toggle="tab" href="#tab-01" aria-expanded="true"> 基本信息</a>
									</li>
									<?php if(!empty($info)): ?><li class="">
										<a data-toggle="tab" href="#tab-02" aria-expanded="false">商品图片</a>
									</li><?php endif; ?>
									<?php if(($program_id == JT201802032149345468) |($program_id == JT201807211029434559)|($program_id == JT201710101645145951)|($program_id == JT201810111844206577)): ?><!--易选购商品视频    婚博会    兰倩美容  	多米诺珠宝-->
									<li class="">
										<a data-toggle="tab" href="#tab-a002_video" aria-expanded="false">商品视频</a>
									</li><?php endif; ?>
									
									<li class="">
										<a data-toggle="tab" href="#tab-03" aria-expanded="false">规格</a>
									</li>	
									<li class="">
										<a data-toggle="tab" href="#tab-04" aria-expanded="true"> 详情</a>
									</li>
									<li class="">
										<a data-toggle="tab" href="#tab-05" aria-expanded="false">库存</a>
									</li>	
									<li class="">
										<a data-toggle="tab" href="#tab-06" aria-expanded="false">参数</a>
									</li>	
									<?php if(($program_id != JT201810111844206577) and ($program_id != JT201810111844206577)): if(!empty($info)): ?><li class="">
										<a data-toggle="tab" href="#tab-07" aria-expanded="true"> 会员价</a>
									</li>
									<li class="">
										<a data-toggle="tab" href="#tab-08" aria-expanded="false">批发折扣</a>
									</li><?php endif; ?>
									<li class="">
										<a data-toggle="tab" href="#tab-09" aria-expanded="false">分销设置</a>
									</li><?php endif; ?>
								</ul><?php endif; ?>
<?php if($program_id == JT201807260907385777): ?><!--家庭教育-->
						<ul class="nav nav-tabs"style="height:60px;width:100%;">
									<li class="active">
										<a data-toggle="tab" href="#tab-01" aria-expanded="true"> 基本信息</a>
									</li>
									<?php if(!empty($info)): ?><li class="">
										<a data-toggle="tab" href="#tab-02" aria-expanded="false">商品图片</a>
									</li><?php endif; ?>
						
									<li class="">
										<a data-toggle="tab" href="#tab-04" aria-expanded="true"> 详情</a>
									</li>
									<li class="">
										<a data-toggle="tab" href="#tab-05" aria-expanded="false">库存</a>
									</li>	
									<li class="">
										<a data-toggle="tab" href="#tab-010" aria-expanded="false">课程视频</a>
									</li>	
								</ul><?php endif; ?>								
							</div>
							<!--开始-->
					<!--<form action="<?php echo U('Goods/run_goods_add',array('id'=>$info['id']));?>" method="post" enctype="multipart/form-data" class="form-horizontal" />
				-->
				<div class="form-horizontal">
							<div class="tab-content">	
<!--============基本信息======================================================-->
<!--============基本信息======================================================-->	

									<div id="tab-01" class="tab-pane active">
										<form action="<?php echo U('Goods/run_goods_add',array('id'=>$info['id']));?>" onsubmit="return checkdatenull();" method="post" enctype="multipart/form-data" class="form-horizontal" />
									    <div class="widget-content nopadding">
											<!--排序-->
											<div class="control-group">
												<label class="control-label">排序：</label>
												<div class="controls">
													<input type="text"  name="sort" value="<?php  echo empty($info['sort'])?1:$info['sort'];?>"/>
													<span class="help-block">数字越小，排名越靠前</span>
												</div>
											</div>
											<!--商品副标题-->
											<div class="control-group">
												<label class="control-label">商品标题：</label>
												<div class="controls">
													<input type="text"  name="goods_title" id="goods_title" value="<?php echo ($info["goods_title"]); ?>"/>
													<span class="help-block" style="color:red;">此项必填</span>
												</div>
											</div>
											<!--商品副标题-->
											<div class="control-group">
												<label class="control-label">商品副标题：</label>
												<div class="controls">
													<input type="text"  name="goods_subtitle" value="<?php echo ($info["goods_subtitle"]); ?>"/>
													<span class="help-block" ></span>
												</div>
											</div>
<?php if($program_id == JT201810111844206577): ?><!--克重（克）-->
											<div class="control-group">
												<label class="control-label">克重（克）：</label>
												<div class="controls">
													<input type="text"  name="kezhong" id="kezhong" value="<?php echo ($info["kezhong"]); ?>"/>
													<span class="help-block" ></span>
												</div>
											</div>
											<!--库存-->
											<div class="control-group">
												<label class="control-label">库存：</label>
												<div class="controls">
													<input type="text"  name="number"id="number" value="<?php echo empty($info['number'])?10:$info['sort']; echo ($info["number"]); ?>"/>
													<span class="help-block" ></span>
												</div>
											</div>
											<!--商品推送-->
											
									        <div class="control-group">
												<label class="control-label">商品推送：</label>
												<div class="controls">
													<input type="text"  name="area_re" readonly value="<?php echo ($info["area_re"]); ?>"/>
													<span class="help-block" ></span>
												</div>
												<div class="controls edit_address_02">
														<div data-toggle="distpicker">				           
													        <select name="" id="province1" class="edit_province"></select>
													        <select name="" id="city1" class="edit_city"></select>
													        <!--<select name="" id="district1" class="edit_district"></select> -->
													        <a href="javascript:" id="sure_choose"   class="btn btn-default" type="button">确定推送</a>
															<a href="javascript:" id="clear_none"   class="btn btn-default" type="button">清空推送</a>
											        		<a href="javascript:" id="national"   class="btn btn-default" type="button">推送全国</a>
														</div>	
													</div>
												<input type="hidden"  id="goods_id" value="<?php echo ($info["id"]); ?>"/>
												</div>
									            	<script>
									    
									            		
									            		$("#sure_choose").click(function(){
							                     		 	$.post('/adp.php/Goods/ajax_area_re',{'goods_id':$("#goods_id").val(),'area_re':$("#city1").find("option:selected").text()},function(state){
																if(state==1){
																	window.location.reload();
																}else if(state==2){
																	alert("该城市已推送")
																}else if(state==-1){
																	alert("修改失败")
																}
													        },'json');
								                     		
								                     	})  
								                     	
									            		$("#clear_none").click(function(){
							                     		 	$.post('/adp.php/Goods/ajax_clear_none',{'goods_id':$("#goods_id").val()},function(state){
																if(state==1){
																	window.location.reload();
																}else{
																	alert("修改失败")
																}
													        },'json');
								                     		
								                     	}) 
								                     	$("#national").click(function(){
							                     		 	$.post('/adp.php/Goods/ajax_national',{'goods_id':$("#goods_id").val()},function(state){
																if(state==1){
																	window.location.reload();
																}else{
																	alert("修改失败")
																}
													        },'json');
								                     		
								                     	}) 
									            	</script><?php endif; ?>
<?php if($program_id == JT201807260907385777): ?><!--视频是否免费-->
											<div class="control-group">
												<label class="control-label">视频是否免费：</label>
												<?php if(empty($info)): ?><div class="controls">
														<label class="radio-inline is_show">
															<input type="radio" name="is_video_free" value="1" > 收费
														</label>
														<label class="radio-inline is_show">
															<input type="radio" name="is_video_free" value="0" checked="checked"> 免费
														</label>
													</div>
													<?php else: ?>
													<?php if($info["is_video_free"] == 1): ?><div class="controls">
															<label class="radio-inline is_show">
																<input type="radio" name="is_video_free" value="1" checked="checked"> 免费
															</label>
															<label class="radio-inline is_show">
																<input type="radio" name="is_video_free" value="0"> 收费
															</label>
														</div><?php endif; ?>
													<?php if($info["is_video_free"] == 0): ?><div class="controls">
															<label class="radio-inline is_show">
																<input type="radio" name="is_video_free" value="1" > 免费
															</label>
															<label class="radio-inline is_show">
																<input type="radio" name="is_video_free" value="0" checked="checked"> 收费
															</label>
														</div><?php endif; endif; ?>

											</div><?php endif; ?>											
											<?php if($program_id == JT201807211029526361): ?><!--商品副标题-->
												<div class="control-group">
													<label class="control-label">服务师傅：</label>
													<div class="controls">
														<input type="text"  name="server_man" value="<?php echo ($info["server_man"]); ?>"/>
														<span class="help-block" ></span>
													</div>
												</div><?php endif; ?>
											
											<!--商品短标题-->
											<?php if($program_id == JT201810111844206577): ?><div class="control-group">
													<label class="control-label">广告语：</label>
													<div class="controls">
														<input type="text"  name="goods_shorttitle" value="<?php echo ($info["goods_shorttitle"]); ?>"/>
														<span class="help-block" ></span>
													</div>
												</div><?php endif; ?>
											
											<!--商品分类-->
											<div class="control-group">
												<label class="control-label">商品分类：</label>
												<div class="controls">
													<div class="controls input_select ml0 w40">
														<select name="fenlei_1_title" class="w100" onchange="gradeChange()" id="city_area_select" >
															<?php if(empty($is_edit)): ?><option >请选择分类</option>
																<?php else: ?>
																<option><?php echo ($info["fenlei_1_title"]); ?></option><?php endif; ?>
															<?php if(is_array($fenlei)): foreach($fenlei as $key=>$v): ?><option ><?php echo ($v["title"]); ?></option><?php endforeach; endif; ?>
														</select>
													</div>
													<div class="controls  input_select ml12 w40">
														<select name="fenlei_2_title" class="w100" id="road_from_select" >
															<?php if(empty($is_edit)): ?><option>请选择子分类</option>
																<?php else: ?>
																<option><?php echo ($info["fenlei_2_title"]); ?></option><?php endif; ?>
														</select>
													</div>
													<span class="help-block" ></span>
												</div>
											</div>
											
											<!--批发价折扣-->
											<?php if($program_id == JT201810111844206577): ?><div class="control-group">
												<label class="control-label">批发价折品类：</label>
												<div class="controls">
													<div class="controls input_select ml0 w40">
														<select name="fenlei_zhekou" class="w100" onchange="gradeChange()" id="city_area_select" >
															<?php if(empty($is_edit)): ?><option >请选择分类</option>
																<?php else: ?>
																<option><?php echo ($info["fenlei_zhekou_title"]); ?></option><?php endif; ?>
															<?php if(is_array($fenlei_zhekou)): foreach($fenlei_zhekou as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["title"]); ?></option><?php endforeach; endif; ?>
														</select>
													</div>
												
													<span class="help-block" ></span>
												</div>
											</div><?php endif; ?>
											<!--商品图片-->
											<?php if(empty($info)): ?><div class="control-group ">
												<label class="control-label">商品图片</label>
												<div class="controls">
													<input type="text" value="<?php echo ($info['image']); ?>" id="image_name" />
													<span class="btn btn-success fileinput-button">
											            <span>上传</span>
											            <input type="file" name="image" id="doca"  onchange="javascript:setImagePreviews();">
											       </span>
					
													<div class="help-block bd_gray mt15 w81 b_r_4 max_h_165 " style="display:none;" id="image_area">
														<img class="h_92 p_1" src="" id="loc_img" />
													</div>
					
												</div>
											</div><?php endif; ?>
											<!--商品属性-->
											<!--<div class="control-group">
												<label class="control-label">商品属性：</label>
												<div class="controls">
														<label class="radio-inline is_show w5">
									                    <?php if($info["goods_subtitle01"] == 1): ?><input type="checkbox" name="good_attribute01" value="1" id="good_attribute" checked> 新品
															<?php else: ?>
															 <input type="checkbox" name="good_attribute01" value="1" id="good_attribute" > 新品<?php endif; ?>
														</label>
														<label class="radio-inline is_show w5">
									                    <?php if($info["goods_subtitle02"] == 1): ?><input type="checkbox" name="goods_subtitle02" value="1" id="good_attribute" checked> 热卖
															<?php else: ?>
															 <input type="checkbox" name="goods_subtitle02" value="1" id="good_attribute" > 热卖<?php endif; ?>
														</label>
														<label class="radio-inline is_show w5">
									                    <?php if($info["goods_subtitle03"] == 1): ?><input type="checkbox" name="goods_subtitle03" value="1" id="good_attribute" checked> 推荐
															<?php else: ?>
															 <input type="checkbox" name="goods_subtitle03" value="1" id="good_attribute" > 推荐<?php endif; ?>
														</label>
														<label class="radio-inline is_show w5">
									                    <?php if($info["goods_subtitle04"] == 1): ?><input type="checkbox" name="goods_subtitle04" value="1" id="good_attribute" checked> 促销
															<?php else: ?>
															 <input type="checkbox" name="goods_subtitle04" value="1" id="good_attribute" > 促销<?php endif; ?>
														</label>
														<label class="radio-inline is_show w5">
									                    <?php if($info["goods_subtitle05"] == 1): ?><input type="checkbox" name="goods_subtitle05" value="1" id="good_attribute" checked> 包邮
															<?php else: ?>
															 <input type="checkbox" name="goods_subtitle05" value="1" id="good_attribute" > 包邮<?php endif; ?>
														</label>
												</div>
											</div>-->
					
<?php if($store['is_booking_server'] == 1): ?><!--启用商品预定服务-->
<!--价格面议-->
											<div class="control-group">
												<label class="control-label">价格面议：</label>
												<?php if(empty($info)): ?><div class="controls">
														<label class="radio-inline is_show">
															<input type="radio" name="face_price" value="1" > 面议
														</label>
														<label class="radio-inline is_show">
															<input type="radio" name="face_price" value="0" checked="checked"> 实价
														</label>
													</div>
													<?php else: ?>
													<?php if($info["face_price"] == 1): ?><div class="controls">
															<label class="radio-inline is_show">
																<input type="radio" name="face_price" value="1" checked="checked"> 面议
															</label>
															<label class="radio-inline is_show">
																<input type="radio" name="face_price" value="0"> 实价
															</label>
														</div><?php endif; ?>
													<?php if($info["face_price"] == 0): ?><div class="controls">
															<label class="radio-inline is_show">
																<input type="radio" name="face_price" value="1" > 面议
															</label>
															<label class="radio-inline is_show">
																<input type="radio" name="face_price" value="0" checked="checked"> 实价
															</label>
														</div><?php endif; endif; ?>

											</div><?php endif; ?>
<?php if($program_id == JT201810111844206577): ?><!--商品价格-->
											<div class="control-group">
												<label class="control-label">商品价格：</label>
												<div class="controls">
													<div class="input-group">
														<span class="input-group-addon">游客基础工价</span>
														<input type="text" name="price_sell_1"id="price_sell_1"  value="<?php echo ($info["price_sell_1"]); ?>" class="form-control " >
														
													
													</div>
													<span class="help-block" ></span>
												</div>
												<div class="controls">
													<div class="input-group">
														
														<span class="input-group-addon">会员基础工价</span>
														<input type="text" name="price_sell_2"id="price_sell_2" value="<?php echo ($info["price_sell_2"]); ?>" i class="form-control " >

													</div>
													<span class="help-block" ></span>
												</div>
											</div>
	<!--材料价-->
											<div class="control-group">
												<label class="control-label">材料价：</label>
												<div class="controls">
													<div class="">
														<div class="canshu_name">
															<input type="text" name="price_cl_title[]"  value="<?php echo ($arr1["0"]); ?>" class="form-control" placeholder="材料名">
														</div>
														<div class="canshu_val">									
															<input type="text" name="price_cl[]"  		value="<?php echo ($arr2["0"]); ?>" class="form-control" placeholder="材料价">
														</div>
														
													</div>
													<div class="">
														<div class="canshu_name">
															<input type="text" name="price_cl_title[]"  value="<?php echo ($arr1["1"]); ?>" class="form-control" placeholder="材料名">
														</div>
														<div class="canshu_val">									
															<input type="text" name="price_cl[]"  		value="<?php echo ($arr2["1"]); ?>" class="form-control" placeholder="材料价">
														</div>
														
													</div>
													<div class="">
														<div class="canshu_name">
															<input type="text" name="price_cl_title[]"  value="<?php echo ($arr1["2"]); ?>" class="form-control" placeholder="材料名">
														</div>
														<div class="canshu_val">									
															<input type="text" name="price_cl[]"  		value="<?php echo ($arr2["2"]); ?>" class="form-control" placeholder="材料价">
														</div>
														
													</div>
												</div>
											</div>
	<?php else: ?>
		<!--商品价格-->
											<div class="control-group">
												<label class="control-label">商品价格：</label>
												<div class="controls">
													<div class="input-group">
														<span class="input-group-addon">售价</span>
														<input type="text" name="price_sell"  value="<?php echo ($info["price_sell"]); ?>" id="price_sell" class="form-control " >
														<span class="input-group-addon">原价</span>
														<input type="text" name="price_own" value="<?php echo ($info["price_own"]); ?>" id="price_own" class="form-control valid "  aria-invalid="false">
														<span class="input-group-addon">批发价</span>
														<input type="text" name="cost" value="<?php echo ($info["cost"]); ?>" id="cost" class="form-control " >

													</div>
													<span class="help-block" ></span>
												</div>
											</div><?php endif; ?>
<?php if($program_id != JT201810111844206577): ?><!--混合消费-->
											<div class="control-group">
												<label class="control-label">开启积分支付：</label>
												<?php if(empty($info)): ?><div class="controls">
														<label class="radio-inline is_show">
															<input type="radio" name="is_on_mixpay" value="1" > 开启
														</label>
														<label class="radio-inline is_show">
															<input type="radio" name="is_on_mixpay" value="0" checked="checked"> 关闭
														</label>
													</div>
													<?php else: ?>
													<?php if($info["is_on_mixpay"] == 1): ?><div class="controls">
															<label class="radio-inline is_show">
																<input type="radio" name="is_on_mixpay" value="1" checked="checked"> 开启
															</label>
															<label class="radio-inline is_show">
																<input type="radio" name="is_on_mixpay" value="0"> 关闭
															</label>
														</div><?php endif; ?>
													<?php if($info["is_on_mixpay"] == 0): ?><div class="controls">
															<label class="radio-inline is_show">
																<input type="radio" name="is_on_mixpay" value="1" > 开启
															</label>
															<label class="radio-inline is_show">
																<input type="radio" name="is_on_mixpay" value="0" checked="checked"> 关闭
															</label>
														</div><?php endif; endif; ?>

											</div>	
<!--已出售数-->
											<div class="control-group">
												<label class="control-label">支付积分：</label>
												<div class="controls">
													<input type="text"  name="integral_sell" value="<?php echo ($info["integral_sell"]); ?>"/> 件
													<span class="help-block" >商品购买需要支付的积分数量，开启混合消费后才能生效</span>
												</div>
											</div>											
											<!--已出售数-->
											<div class="control-group">
												<label class="control-label">已出售数：</label>
												<div class="controls">
													<input type="text"  name="sell_num" value="<?php echo ($info["sell_num"]); ?>"/> 件
													<span class="help-block" >商品支付成功后出售数量加一</span>
												</div>
											</div>
											<!--用户收藏数-->
											<div class="control-group">
												<label class="control-label">用户收藏数：</label>
												<div class="controls">
													<input type="text"  name="collect_num" value="<?php echo ($info["collect_num"]); ?>"/> 次
													<span class="help-block" >用户点击收藏后收藏数加一</span>
												</div>
											</div>
											<!--标签-->
											<div class="control-group">
												<label class="control-label">标签：</label>
												<div class="controls">

													<label class="radio-inline is_show "><input type="checkbox" name="quality" value="1"> 正品保证</label>
													<label class="radio-inline is_show "><input type="checkbox" name="seven" value="1"> 7天无理由退换</label>
													<label class="radio-inline is_show "><input type="checkbox" name="repair" value="1"> 保修</label>
													<span class="help-block"></span>

												</div>
											</div>
											<!--商品服务电话-->
											<div class="control-group">
												<label class="control-label">商品服务电话：</label>
												<div class="controls">
													<input type="text"  name="server_phone" value="<?php echo ($info["server_phone"]); ?>"/>
													<span class="help-block" ></span>
												</div>
											</div>
											<!--是否支持退换货-->
											<div class="control-group">
												<label class="control-label">是否支持退换货</label>
												<?php if(empty($info)): ?><div class="controls">
														<label class="radio-inline is_show">
															<input type="radio" name="is_tuihuan" value="1" > 否
														</label>
														<label class="radio-inline is_show">
															<input type="radio" name="is_tuihuan" value="0" checked="checked"> 是
														</label>
													</div>
													<?php else: ?>
													<?php if($info["is_tuihuan"] == 1): ?><div class="controls">
															<label class="radio-inline is_show">
																<input type="radio" name="is_tuihuan" value="1" checked="checked"> 否
															</label>
															<label class="radio-inline is_show">
																<input type="radio" name="is_tuihuan" value="0"> 是
															</label>
														</div><?php endif; ?>
													<?php if($info["is_tuihuan"] == 0): ?><div class="controls">
															<label class="radio-inline is_show">
																<input type="radio" name="is_tuihuan" value="1" > 否
															</label>
															<label class="radio-inline is_show">
																<input type="radio" name="is_tuihuan" value="0" checked="checked"> 是
															</label>
														</div><?php endif; endif; ?>

											</div><?php endif; ?>
											<!--是否上架-->
											<div class="control-group">
												<label class="control-label">上架：</label>
												<?php if(empty($info)): ?><div class="controls">
														<label class="radio-inline is_show">
															<input type="radio" name="goods_state" value="1" > 上架
														</label>
														<label class="radio-inline is_show">
															<input type="radio" name="goods_state" value="3" checked="checked"> 下架
														</label>
													</div>
													<?php else: ?>
													<?php if($info["goods_state"] == 1): ?><div class="controls">
															<label class="radio-inline is_show">
																<input type="radio" name="goods_state" value="1" checked="checked"> 上架
															</label>
															<label class="radio-inline is_show">
																<input type="radio" name="goods_state" value="3"> 下架
															</label>
														</div><?php endif; ?>
													<?php if($info["goods_state"] == 3): ?><div class="controls">
															<label class="radio-inline is_show">
																<input type="radio" name="goods_state" value="1" > 上架
															</label>
															<label class="radio-inline is_show">
																<input type="radio" name="goods_state" value="3" checked="checked"> 下架
															</label>
														</div><?php endif; endif; ?>

											</div>
											
											
											<!--确认收货时间-->
											<!--<div class="control-group">
												<label class="control-label">确认收货时间：</label>
												<div class="controls">
													<div class="input-group">
														<span class="input-group-addon">发货后</span>
														<input type="text" name="day_shouhuo"  value="<?php echo ($info["day_shouhuo"]); ?>" id="day_shouhuo" class="form-control " > 天
													</div>
													<span class="help-block" ></span>
												</div>
											</div>--> 


											<div class="form-actions">
													<button type="submit" class="btn btn-primary">保存</button>
											</div>
										</div>
										</form>
									</div>
<!--============商品图片======================================================-->
<!--============商品图片======================================================-->	

									<div id="tab-02" class="tab-pane">
									    <div class="widget-content nopadding">
									    	<?php if($program_id == JT201806151732369242): ?><div class="alert alert-error alert-block" style="    padding-left: 3%;">
												<a class="close" data-dismiss="alert" href="#">×</a>
												<h4 class="alert-heading">备注：</h4>
													1：第一张图片为首页展示图，其次都是商品详情内的轮播图<br/>		
													2：首页图片尺寸长：宽为115:105、非首页图比例为375:330		
													3：图片格式：'jpg', 'gif', 'png', 'jpeg'
											</div><?php endif; ?>
											<div class="control-group ">
												<label class="control-label">商品图片</label>

												<div class="controls">
													<?php if(!empty($info)): ?><div class="help-block bd_gray mt15 w81 b_r_4 max_h_165 "	>
													<?php if(is_array($info['image'])): $k = 0; $__LIST__ = array_slice($info['image'],0,4,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><img class="h_92 p_1 w20" src="/Uploads/<?php echo ($vo); ?>"  />
														<em class="delete_goods_img delete_img" a="<?php echo ($info['id']); ?>" b="<?php echo $a=$k-1; ?>">X</em><?php endforeach; endif; else: echo "" ;endif; ?>
													</div>
													<?php if(!empty($info['image'][4])): ?><div class="help-block bd_gray mt15 w81 b_r_4 max_h_165 "	>
														<?php if(is_array($info['image'])): $i = 0; $__LIST__ = array_slice($info['image'],4,4,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><img class="h_92 p_1 w20" src="/Uploads/<?php echo ($vo); ?>"  />
															<em class="delete_goods_img delete_img" a="<?php echo ($info['id']); ?>" b="<?php echo $a=$k-1; ?>">X</em><?php endforeach; endif; else: echo "" ;endif; ?>
													</div><?php endif; ?>
														<?php if(!empty($info['image'][8])): ?><div class="help-block bd_gray mt15 w81 b_r_4 max_h_165 "	>
															<?php if(is_array($info['image'])): $i = 0; $__LIST__ = array_slice($info['image'],8,4,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><img class="h_92 p_1 w20" src="/Uploads/<?php echo ($vo); ?>"  />
																<em class="delete_goods_img delete_img" a="<?php echo ($info['id']); ?>" b="<?php echo $a=$k-1; ?>">X</em><?php endforeach; endif; else: echo "" ;endif; ?>
														</div><?php endif; ?>

													<div id="demo" style="margin-top:12px;">
														<div id="as" ></div>
													</div>

														<script>
                                                            $('#as').diyUpload({
                                                                //   url:'/AA/fileupload',
                                                                //	if(1){
                                                                url:'/adp.php/Goodstest/fileupload?goods_id='+<?php echo ($info["id"]); ?>,
                                                                success:function( data ) {
                                                                    console.info( data );
                                                                },
                                                                error:function( err ) {
                                                                    console.info( err );
                                                                },
                                                                buttonText : '选择文件',
                                                                chunked:true,
                                                                // 分片大小
                                                                chunkSize:512 * 1024,
                                                                //最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
                                                                fileNumLimit:6,
                                                                fileSizeLimit:500000 * 1024,
                                                                fileSingleSizeLimit:1024 * 1024,
                                                                accept: {}
                                                            });
														</script>
													<?php else: ?>
													<form action="<?php echo U('Goods/run_goods_add',array('id'=>$info['id']));?>" method="post" enctype="multipart/form-data" class="form-horizontal" />
													<!--<input type="text" value="<?php echo ($info['image']); ?>" id="image_name" />
													<span class="btn btn-success fileinput-button">
										            <span>上传</span>
										          	     <input type="file" name="image" id="doca"  onchange="javascript:setImagePreviews();">
										    	    </span>

													<div class="help-block bd_gray mt15 w81 b_r_4 max_h_165 " style="display:none;" id="image_area">
														<img class="h_92 p_1" src="" id="loc_img" />
													</div>
														<div class="form-actions">
															<button type="submit" class="btn btn-primary">保存</button>
														</div>
													</form>--><?php endif; ?>

												</div>
											</div>
											<div class="form-actions">
													<a class="btn btn-primary" onclick="window.location.reload();">刷新</a>
											</div>
										</div>
									</div>
									
<!--============商品视频======================================================-->
<!--============商品视频======================================================-->									
									<div id="tab-a002_video" class="tab-pane">
										<form action="<?php echo U('Goods/run_goods_add',array('id'=>$info['id']));?>" method="post" enctype="multipart/form-data" class="form-horizontal" />
									    <div class="widget-content nopadding">
									    	<?php if($info['goods_video'] != 0): ?><div class="control-group">
												<label class="control-label">视频：</label>
												<div class="controls">
													<input type="text"  name="goods_video" value="https://sz800800.cn/Uploads/<?php echo ($info["goods_video"]); ?>"/>
													<span class="help-block" >商品视频介绍</span>
												</div>
											</div><?php endif; ?>
											<div class="control-group">
												<label class="control-label">上传视频：</label>
												<div class="controls">
													<input type="file"  name="goods_video"/>
								
												</div>
											</div>
											<div class="form-actions">
												<button type="submit" class="btn btn-primary">保存</button>
											</div>
										</div>
										</form>
									</div>									
<!--============规格======================================================-->
<!--============规格======================================================-->									
									<div id="tab-03" class="tab-pane">
										<form action="<?php echo U('Goods/run_goods_add',array('id'=>$info['id']));?>" method="post" enctype="multipart/form-data" class="form-horizontal" />
									    <div class="widget-content nopadding">
											<!--是否上架-->
											<div class="control-group">
												<label class="control-label">是否启用规格</label>
												<?php if(empty($info)): ?><div class="controls">
														<label class="radio-inline is_show">
															<input type="radio" name="is_use_guige" value="2" > 启用
														</label>
														<label class="radio-inline is_show">
															<input type="radio" name="is_use_guige" value="1" checked="checked"> 禁用
														</label>
													</div>
													<?php else: ?>
													<?php if($info["is_use_guige"] == 1): ?><div class="controls">
															<label class="radio-inline is_show">
																<input type="radio" name="is_use_guige" value="2" > 启用
															</label>
															<label class="radio-inline is_show">
																<input type="radio" name="is_use_guige" value="1" checked="checked"> 禁用
															</label>
														</div><?php endif; ?>
													<?php if($info["is_use_guige"] == 2): ?><div class="controls">
															<label class="radio-inline is_show">
																<input type="radio" name="is_use_guige" value="2" checked="checked"> 启用
															</label>
															<label class="radio-inline is_show">
																<input type="radio" name="is_use_guige" value="1" > 禁用
															</label>
														</div><?php endif; endif; ?>


											</div>
											<!--一级规格-->
											<div class="control-group">
												<div id="more_guige"  class="btn btn-primary more_guige" num="<?php echo ($guige_num); ?>">添加规格</div>
												<label class="control-label">商品规格：</label>

												<div class="controls" id="test123">
														<?php if(empty($guige)): ?><div class="" style="border: 1px solid #d0d0d0; padding: 20px;">
																规格 0 ：
															<div class="input-group">
																
																<input class="changeimg_key" name="changeimg_key[]" type="hidden" id="changeimg<?php echo ($k); ?>" value="1">
																<input style="position: absolute; left: 450px; height: 60px; width: 75px;" type="file"  name="img[]" id="guige_input0" onchange="guige_img(0)">
																<img style="position: absolute; left: 530px;top: -29px;" id="guige_img0" src=""/>
																<div style="width:50px;display: inline-block;">规格名: </div><input type="text" name="guige[]" placeholder="规格名"  id="sales" class="w32"  aria-invalid="false">
																<div style="width:40px;display: inline-block; margin-left: 20px;">价格: </div><input type="text" name="price[]" placeholder="价格"  id="sales" class="w32"  aria-invalid="false">
																<div style="height:6px;"> </div>
																<div style="width:50px;display: inline-block;">库存: </div><input type="text" name="num[]" placeholder="库存"  id="sales" class="w32"  aria-invalid="false">
																<div style="width:40px;display: inline-block; margin-left: 20px;">备注: </div><input type="text" name="remark[]" placeholder="备注"  id="sales" class="w32"  aria-invalid="false">
																<!--<input type="file"  name="img[]" id="image01" onchange="" style="clear: both;"> -->
																<!--<div><input  name="image2[]" type="file"></div>-->
															</div>
														</div>
														<?php else: ?>
														<?php if(is_array($guige)): foreach($guige as $k=>$v): ?><div class="" style="border: 1px solid #d0d0d0; padding: 20px;">
																规格 <?php echo ($k); ?> ：
																<!--<span style="background:#F2F2F2;height: 20px; line-height: 20px;" class="delete_guige " a="<?php echo ($info['id']); ?>" b="<?php echo ($k); ?>" c="1">删 除</span>-->
																<div class="btn btn-primary delete_guige" a="<?php echo ($info['id']); ?>" b="<?php echo ($k); ?>" c="1" style="position: relative;top:-2px;">删 除</div>
																<div class="input-group">
																	<input class="changeimg_key" name="changeimg_key[]" type="hidden" id="changeimg<?php echo ($k); ?>" value="0">
																	<input style="position: absolute; left: 450px; height: 60px; width: 75px;" type="file"  name="img[]" id="guige_input<?php echo ($k); ?>" onchange="guige_img(<?php echo ($k); ?>,1)">
																	<img style="position: absolute; left: 530px;top: -29px;" id="guige_img<?php echo ($k); ?>" src=""/>
																	<img style="position: absolute; left: 700px;width:110px;height:110px;top: -29px;"  src="/Uploads/<?php echo ($v["img"]); ?>"/>
																	<div style="width:50px;display: inline-block;">规格名: </div><input type="text" name="guige[]" placeholder="规格名" value="<?php echo ($v["guige"]); ?>" id="sales" class="w32"  aria-invalid="false">
																	<?php if($program_id != JT201810111844206577): ?><div style="width:40px;display: inline-block; margin-left: 20px;">价格: </div><input type="text" name="price[]" placeholder="价格" value="<?php echo ($v["price"]); ?>" id="sales" class="w32"  aria-invalid="false"><?php endif; ?>
																	<div style="height: 10px;"></div>
																	<div style="width:50px;display: inline-block;">库存: </div><input type="text" name="num[]" placeholder="库存" value="<?php echo ($v["num"]); ?>" id="sales" class="w32"  aria-invalid="false">
																	<div style="width:40px;display: inline-block; margin-left: 20px;"><?php if($program_id == JT201810111844206577): ?>克重<?php else: ?>备注<?php endif; ?>	: </div><input type="text" name="remark[]" placeholder="<?php if($program_id == JT201810111844206577): ?>克重<?php else: ?>备注<?php endif; ?>	" value="<?php echo ($v["remark"]); ?>" id="sales" class="w32"  aria-invalid="false">
																<?php if($program_id == JT201810111844206577): ?><div style="height: 10px;"></div>
																	<div style="width:50px;display: inline-block;">材料价: </div><input type="text" name="gg_price_cl_title_to_<?php echo ($k); ?>[]" placeholder="材料价名称" value="<?php echo ($v["json_cl"]["cl_arr_title"]["0"]); ?>" id="sales" class="w32"  aria-invalid="false">
																	<div style="width:40px;display: inline-block; margin-left: -30px;"> </div><input type="text" name="gg_price_cl_to_<?php echo ($k); ?>[]" placeholder="材料价价格" value="<?php echo ($v["json_cl"]["cl_arr_price"]["0"]); ?>" id="sales" class="w32"  aria-invalid="false">
																	
																	<div style="height: 10px;"></div>
																	<div style="width:50px;display: inline-block;"> </div><input type="text" name="gg_price_cl_title_to_<?php echo ($k); ?>[]" placeholder="材料价名称" value="<?php echo ($v["json_cl"]["cl_arr_title"]["1"]); ?>" id="sales" class="w32"  aria-invalid="false">
																	<div style="width:40px;display: inline-block; margin-left: -30px;"> </div><input type="text" name="gg_price_cl_to_<?php echo ($k); ?>[]" placeholder="材料价价格" value="<?php echo ($v["json_cl"]["cl_arr_price"]["1"]); ?>" id="sales" class="w32"  aria-invalid="false">
																
																	<div style="height: 10px;"></div>
																	<div style="width:50px;display: inline-block;"> </div><input type="text" name="gg_price_cl_title_to_<?php echo ($k); ?>[]" placeholder="材料价名称" value="<?php echo ($v["json_cl"]["cl_arr_title"]["2"]); ?>" id="sales" class="w32"  aria-invalid="false">
																	<div style="width:40px;display: inline-block; margin-left: -30px;"> </div><input type="text" name="gg_price_cl_to_<?php echo ($k); ?>[]" placeholder="材料价价格" value="<?php echo ($v["json_cl"]["cl_arr_price"]["2"]); ?>" id="sales" class="w32"  aria-invalid="false"><?php endif; ?>	
																
																</div>

															</div><?php endforeach; endif; endif; ?>
													<span class="help-block" ></span>
												</div>
											</div>
											<!--二级规格-->
											<div class="control-group">
												<div id="more_guige02"  class="btn btn-primary more_guige">添加规格</div>
												<label class="control-label">商品二级规格：</label>

												<div class="controls" id="test1234">
													<?php if(empty($guige02)): ?><div class="input-group">
															<input type="text" name="guige02[]" placeholder="参数名"  id="sales" class="w60"  aria-invalid="false">
														</div>

														<?php else: ?>
														<?php if(is_array($guige02)): foreach($guige02 as $k=>$v): ?><div class="input-group">
																<input type="text" name="guige02[]" placeholder="参数名" value="<?php echo ($v["guige02"]); ?>" id="sales" class="w60"  aria-invalid="false">
																<span  class="delete_guige" a="<?php echo ($info['id']); ?>" b="<?php echo ($k); ?>" c="2" style="background:#F2F2F2;height: 20px;margin-left: 30px; line-height: 20px;">删 除</span>
															</div><?php endforeach; endif; endif; ?>
													<span class="help-block" ></span>
												</div>
											</div>
											<div class="form-actions">
													<button type="submit" class="btn btn-primary">保存</button>
											</div>
										</div>
										</form>
									</div>
<!--============详情======================================================-->
<!--============详情======================================================-->									
									<div id="tab-04" class="tab-pane">
										<form action="<?php echo U('Goods/run_goods_add',array('id'=>$info['id']));?>" method="post" enctype="multipart/form-data" class="form-horizontal" />
									    <div class="widget-content nopadding">
											<div class="control-group">
												<label class="control-label">商品详情</label>
												<div class="controls">
													<textarea rows="6" name="goods_content" id="goods_content" ><?php echo ($info["goods_content"]); ?></textarea>
												<span class="help-block"></span>
												</div>
											</div>
											<div class="form-actions">
												<button type="submit" class="btn btn-primary">保存</button>
											</div>
										</div>
										</form>
									</div>
<!--============库存======================================================-->
<!--============库存======================================================-->									
									<div id="tab-05" class="tab-pane">
										<form action="<?php echo U('Goods/run_goods_add',array('id'=>$info['id']));?>" method="post" enctype="multipart/form-data" class="form-horizontal" />
									    <div class="widget-content nopadding">
											<div class="control-group">
												<label class="control-label">编码</label>
												<div class="controls">
													<input type="text"  name="bianma" value="<?php echo ($info["bianma"]); ?>"/>
													<span class="help-block"></span>
												</div>
												
												<label class="control-label">条码</label>
												<div class="controls">
													<input type="text"  name="tiaoma" value="<?php echo ($info["tiaoma"]); ?>"/>
													<span class="help-block"></span>
												</div>
												
												<label class="control-label">重量</label>
												<div class="controls">
													<input type="text"  name="zhongliang" value="<?php echo ($info["zhongliang"]); ?>"/>
													<span class="help-block"></span>
												</div>
												
												<label class="control-label">库存</label>
												<div class="controls">
													<input type="number"  name="number" value="<?php echo (empty($info['number']))?10:$info['number'];?>"/>
													<span class="help-block">商品的剩余数量, 如启用多规格，则此处设置无效.</span>
												</div>
												
								
												<div class="controls">
													<label class="radio-inline is_show">
														<input type="radio" name="kucun_change" value="1" <?php if($info['kucun_change'] == 1): ?>checked="checked"<?php endif; ?>"> 拍下减库存
													</label>
													<label class="radio-inline is_show">
														<input type="radio" name="kucun_change" value="2" <?php if($info['kucun_change'] == 2): ?>checked="checked"<?php endif; ?>> 付款减库存
													</label>
													<label class="radio-inline is_show">
														<input type="radio" name="kucun_change" value="3" <?php if($info['kucun_change'] == 3): ?>checked="checked"<?php endif; ?>> 永不减库存
													</label>
												</div>
											</div>
											
											<div class="form-actions">
													<button type="submit" class="btn btn-primary">保存</button>
											</div>
										</div>
										</form>
									</div>
<!--============参数======================================================-->
<!--============参数======================================================-->									
									<div id="tab-06" class="tab-pane">
										<form action="<?php echo U('Goods/run_goods_add',array('id'=>$info['id']));?>" method="post" enctype="multipart/form-data" class="form-horizontal" />
									    <div class="widget-content nopadding">
											<div class="control-group">
												<div id="more_img" style="border:1px solid;padding:3px;width:100px;text-align:center;margin-right:12px;float:right;border-radius:4px;" class="btn btn-primary">更多参数</div>
				
												<?php if(empty($canshu)): ?><div class="canshu_total">
														<div class="canshu_name">
															<input type="text" name="canshu_title[]"   class="form-control" placeholder="请输入参数名">
														</div>
														<div class="canshu_val">									
															<input type="text" name="canshu_con[]"   class="form-control" placeholder="请输入参数值">
														</div>
														<div class="col-sm-1">
															
														</div>
													</div>
												<?php else: ?>
												<?php if(is_array($canshu)): foreach($canshu as $key=>$v): ?><div class="canshu_total">
														<div class="canshu_name">
															<input type="text" name="canshu_title[]"  value="<?php echo ($v["title"]); ?>" class="form-control" placeholder="请输入参数名">
														</div>
														<div class="canshu_val">									
															<input type="text" name="canshu_con[]"  value="<?php echo ($v["content"]); ?>" class="form-control" placeholder="请输入参数值">
														</div>
														<div class="col-sm-1">
															<span  onclick="delet_canshu(this)" style="line-height: 54px;">X</span>
														</div>
													</div><?php endforeach; endif; endif; ?>
												<div id="muban_b_0"></div>
											</div>
											<div class="form-actions">
													<button type="submit" class="btn btn-primary">保存</button>
											</div>
										</div>
										</form>
									</div>
<!--============会员价======================================================-->
<!--============会员价======================================================-->									
									<div id="tab-07" class="tab-pane">
										<form action="<?php echo U('Goods/run_goods_add',array('id'=>$info['id']));?>" method="post" enctype="multipart/form-data" class="form-horizontal" />
									    <div class="widget-content nopadding">
											
											<div class="control-group">
												<label class="control-label">是否使用会员价</label>
												<?php if(empty($info)): ?><div class="controls">
														<label class="radio-inline is_show">
															<input type="radio" name="is_on_lever_price" value="1" > 启用
														</label>
														<label class="radio-inline is_show">
															<input type="radio" name="is_on_lever_price" value="2" checked="checked"> 禁用
														</label>
													</div>
													<?php else: ?>
													<?php if($info["is_on_lever_price"] == 1): ?><div class="controls">
															<label class="radio-inline is_show">
																<input type="radio" name="is_on_lever_price" value="1" checked="checked"> 启用
															</label>
															<label class="radio-inline is_show">
																<input type="radio" name="is_on_lever_price" value="2" > 禁用
															</label>
														</div><?php endif; ?>
													<?php if($info["is_on_lever_price"] == 2): ?><div class="controls">
															<label class="radio-inline is_show">
																<input type="radio" name="is_on_lever_price" value="1" > 启用
															</label>
															<label class="radio-inline is_show">
																<input type="radio" name="is_on_lever_price" value="2" checked="checked"> 禁用
															</label>
														</div><?php endif; endif; ?>
												
											
													<span class="help-block" ></span>
											</div>
											<?php if(is_array($lever)): foreach($lever as $key=>$v): ?><input name="lever_id[]" type="hidden" value="<?php echo ($v["id"]); ?>">
											<div class="control-group">
												<div class="controls">
													<div class="input-group">
														<span class="input-group-addon">等级</span>
														<input type="text"  readonly  value="<?php echo ($v["member_level_name"]); ?>"  class="form-control " >
														<span class="input-group-addon">折扣</span>
														<input type="text" name="discount[]" value="<?php echo ($v["discount"]); ?>" id="price_own" class="form-control valid discount"  aria-invalid="false">
														<span class="input-group-addon">会员价</span>
														<input type="text" name="price_mem[]" value="<?php echo ($v["price"]); ?>" id="cost" class="form-control price_mem" >

													</div>
													<span class="help-block" ></span>
												</div>
												</div><?php endforeach; endif; ?>
											<div class="form-actions">
													<button type="submit" class="btn btn-primary">保存</button>
											</div>
										</div>
										</form>
									</div>
<!--============批发折扣======================================================-->
<!--============批发折扣======================================================-->									
									<div id="tab-08" class="tab-pane">
										<form action="<?php echo U('Goods/run_goods_add',array('id'=>$info['id']));?>" method="post" enctype="multipart/form-data" class="form-horizontal" />
									    <div class="widget-content nopadding">
										
											<div class="control-group">
												<label class="control-label">是否使用批发折扣</label>
												<?php if(empty($info)): ?><div class="controls">
														<label class="radio-inline is_show">
															<input type="radio" name="is_on_wholesale_discount" value="1" > 启用
														</label>
														<label class="radio-inline is_show">
															<input type="radio" name="is_on_wholesale_discount" value="2" checked="checked"> 禁用
														</label>
													</div>
													<?php else: ?>
													<?php if($info["is_on_wholesale_discount"] == 1): ?><div class="controls">
															<label class="radio-inline is_show">
																<input type="radio" name="is_on_wholesale_discount" value="1" checked="checked"> 启用
															</label>
															<label class="radio-inline is_show">
																<input type="radio" name="is_on_wholesale_discount" value="2" > 禁用
															</label>
														</div><?php endif; ?>
													<?php if($info["is_on_wholesale_discount"] == 2): ?><div class="controls">
															<label class="radio-inline is_show">
																<input type="radio" name="is_on_wholesale_discount" value="1" > 启用
															</label>
															<label class="radio-inline is_show">
																<input type="radio" name="is_on_wholesale_discount" value="2" checked="checked"> 禁用
															</label>
														</div><?php endif; endif; ?>
		
													<span class="help-block" ></span>	
											</div>
											<div class="control-group" id="test456">
												<div id="more_wholesale"  class="btn btn-primary more_guige">更多批发价</div>
												<label class="control-label">商品批发价：</label>
										<?php if(empty($wholesale)): ?><div class="pifa_total">
													<span class="input-group-addon pifa_input" >起始件数(≥)</span>	
													<input  type="text" name="num_start[]"   id="num_start" class="form-control num_start pifa_input_2" >
													<span class="input-group-addon pifa_input" >结束件数(<)</span>									
													<input  type="text" name="num_end[]"   id="num_end" class="form-control num_end pifa_input_2" >
													
													<span class="input-group-addon pifa_input" >折扣</span>									
													<input  type="text" name="wholesale_discount[]"   id="wholesale_discount" class="form-control wholesale_discount12138 pifa_input_2" >
													
													<span class="input-group-addon pifa_input" >参考价</span>	
													<input  type="text" name="wholesale_price[]"    id="wholesale_price" class="form-control valid price_reference pifa_input_2"  aria-invalid="false" style="text-align:center;">
													<span class="input-group-addon" style="width:5px;"> 元  </span>	
													<span  onclick="delet_pifa(this)" a="<?php echo ($v["id"]); ?>" style="width:5px;" class="input-group-addon">X</span>
												</div>
										<?php else: ?>
												
										<?php if(is_array($wholesale)): foreach($wholesale as $key=>$v): ?><div class="pifa_total">
													<span class="input-group-addon pifa_input" >起始件数(≥)</span>	
													<input  type="text" name="num_start[]"  value="<?php echo ($v["num_start"]); ?>" id="num_start" class="form-control num_start pifa_input_2" >
													<span class="input-group-addon pifa_input" >结束件数(<)</span>									
													<input  type="text" name="num_end[]"  value="<?php echo ($v["num_end"]); ?>" id="num_end" class="form-control num_end pifa_input_2" >
													
													<span class="input-group-addon pifa_input" >折扣</span>									
													<input  type="text" name="wholesale_discount[]"  value="<?php echo ($v["discount"]); ?>" id="wholesale_discount" class="form-control wholesale_discount12138 pifa_input_2" >
													
													<span class="input-group-addon pifa_input" >参考价</span>	
													<input  type="text" name="wholesale_price[]"  value="<?php echo ($v["price"]); ?>"  id="wholesale_price" class="form-control valid price_reference pifa_input_2"  aria-invalid="false" style="text-align:center;">
													<span class="input-group-addon" style="width:5px;"> 元  </span>	
													<span  onclick="delet_pifa(this)" a="<?php echo ($v["id"]); ?>" style="width:5px;" class="input-group-addon">X</span>
												</div><?php endforeach; endif; endif; ?>
												
											</div>
											<div ></div>
											<div class="form-actions">
													<button type="submit" class="btn btn-primary">保存</button>
											</div>
										</div>
										</form>
									</div>
<!--============分销设置======================================================-->
<!--============分销设置======================================================-->									
									<div id="tab-09" class="tab-pane">
										<form action="<?php echo U('Goods/run_goods_add',array('id'=>$info['id']));?>" method="post" enctype="multipart/form-data" class="form-horizontal" />
									    <div class="widget-content nopadding">
											<div class="control-group">
												<label class="control-label">是否开启独立分销比例</label>
												<?php if(empty($info)): ?><div class="controls">
														<label class="radio-inline is_show">
															<input type="radio" name="is_on_self_fx" value="1" > 启用
														</label>
														<label class="radio-inline is_show">
															<input type="radio" name="is_on_self_fx" value="2" checked="checked"> 禁用
														</label>
													</div>
													<?php else: ?>
													<?php if($info["is_on_self_fx"] == 1): ?><div class="controls">
															<label class="radio-inline is_show">
																<input type="radio" name="is_on_self_fx" value="1" checked="checked"> 启用
															</label>
															<label class="radio-inline is_show">
																<input type="radio" name="is_on_self_fx" value="2" > 禁用
															</label>
														</div><?php endif; ?>
													<?php if($info["is_on_self_fx"] == 2): ?><div class="controls">
															<label class="radio-inline is_show">
																<input type="radio" name="is_on_self_fx" value="1" > 启用
															</label>
															<label class="radio-inline is_show">
																<input type="radio" name="is_on_self_fx" value="2" checked="checked"> 禁用
															</label>
														</div><?php endif; endif; ?>
											<span class="help-block" >分销系统的分销专区开启状态本设置才能生效</span>	
											</div>
											
											<div class="control-group">
												<label class="control-label">一级分销比例：</label>
												<div class="controls">
													<input type="text"  name="bl_lever_1" value="<?php echo ($info['bl_lever_1']); ?>" style="float:left;"/>
													<span class="input-group-addon " style="float:left;width: 2%;">%</span>	
													<span class="help-block" ></span>
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label">二级分销比例：</label>
												<div class="controls">
													<input type="text"  name="bl_lever_2" value="<?php echo ($info["bl_lever_2"]); ?>" style="float:left;"/>
													<span class="input-group-addon " style="float:left;width: 2%;">%</span>	
													<span class="help-block" ></span>
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label">三级分销比例：</label>
												<div class="controls">
													<input type="text"  name="bl_lever_3" value="<?php echo ($info["bl_lever_3"]); ?>" style="float:left;"/>
													<span class="input-group-addon " style="float:left;width: 2%;">%</span>	
													<span class="help-block" ></span>
												</div>
											</div>
											
											<div class="form-actions">
													<button type="submit" class="btn btn-primary">保存</button>
											</div>
										</div>
										</form>
									</div>	
<!--============课程视频======================================================-->
<!--============课程视频======================================================-->									
									<div id="tab-010" class="tab-pane">
										<div class="container-fluid">
											<div class="row-fluid">
												<div class="span12">
													<div class="widget-box">
														<div class="widget-title">
															<span class="icon">
																<i class="icon-th"></i>
															</span>
															<h5>视频管理</h5>
															<h5 style="    width: 12%;margin-top: -3px;">
																<a href="/adp.php/Goods/video_add?goods_id=<?php echo ($goods_id); ?>" class="add_button">
																	<button style="position: relative;top: -9px;" class="btn" >+添加视频</button>
																</a>
															</h5>
														</div>
														<div class="widget-content nopadding">
															<table class="table table-bordered table-striped">
																<thead>
																<tr>
																	<th>编号</th>
																	<th>排序</th>
																	<th>标题</th>
																	<th>是否发布</th>
																	<th>操作</th>
																</tr>
																</thead>
																<tbody>
																<?php if(is_array($video)): foreach($video as $key=>$v): ?><tr>
																		<td><?php echo ($v["id"]); ?></td>
																		<td><?php echo ($v["sort"]); ?></td>
																		<td><?php echo ($v["title"]); ?></td>
																	
																		<td>
																			<?php if($v["is_show"] == 1): ?><div class="peng_is_ok peng_ok">
																					<input type="hidden" value="<?php echo ($v["id"]); ?>">
																					<span>显示</span>
																				</div><?php endif; ?>
									
																			<?php if($v["is_show"] == 0): ?><div class="peng_is_ok peng_not">
																					<input type="hidden" value="<?php echo ($v["id"]); ?>">
																					<span>下架</span>
																				</div><?php endif; ?>
																		</td>
																		<td>
																			<a class="btn btn-default" title="编辑" alt="编辑" href="/adp.php/Goods/video_edit/id/<?php echo ($v['id']); ?>" >
																				编辑
																			</a>
																			<a class="btn btn-danger" style="color:white;"  title="删除" alt="删除" href="/adp.php/Goods/video_delete/id/<?php echo ($v['id']); ?>" onclick="if(confirm('确认删除吗？')==false)return false;">
																				删除
																			</a>	
																		</td>
																	</tr><?php endforeach; endif; ?>
																</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>									
									
									
									
									
									
									
									
								</div>
								<!--</form>--></div>
							</div>
						</div>
							<!--结束-->
						</div>						
					</div>
				</div>
				
			</div>
	</div>
	<input id="program_id" value="<?php echo ($program_id); ?>" type="hidden">
"	

			<script src="/Public/new0127/js/excanvas.min.js"></script>
            <script src="/Public/new0127/js/jquery.min.js"></script>
            <script src="/Public/new0127/js/jquery.ui.custom.js"></script>
            <script src="/Public/new0127/js/bootstrap.min.js"></script>
            <script src="/Public/new0127/js/jquery.flot.min.js"></script>
            <script src="/Public/new0127/js/jquery.flot.resize.min.js"></script>
            <script src="/Public/new0127/js/jquery.peity.min.js"></script>
            <script src="/Public/new0127/js/fullcalendar.min.js"></script>
            <script src="/Public/new0127/js/unicorn.js"></script>
            <script src="/Public/new0127/js/unicorn.dashboard.js"></script>
            
<script type="text/javascript" src="/Public/daterangerpicker/showdate.js"></script>
 
	</body>
</html> 
	<script>
	     //图片预览函数 ==================================================== 111
        function setImagePreviews(avalue) {
			var docObj=document.getElementById("doca");
			var imgObjPreview=document.getElementById("previewa");

		 var file = docObj.files[0];
		
		if (window.FileReader) {  
            var reader = new FileReader();  
            reader.readAsDataURL(file);  
            //监听文件读取结束后事件  
            reader.onloadend = function (e) {
                showXY(e.target.result,file.fileName);  
            }; 
        }  
        
        function showXY(source){  
		    var img = document.getElementById("loc_img");  
		    img.src = source;  
		    $("#image_area").css("display","block"); 
		} 
			return true;
		}
        //图片预览函数 ==================================================== 222
        function setImagePreviews_2(avalue) {
			var docObj_2=document.getElementById("doca_2");

		 var file = docObj_2.files[0];
		
		if (window.FileReader) {  
            var reader = new FileReader();  
            reader.readAsDataURL(file);  
            //监听文件读取结束后事件  
            reader.onloadend = function (e) {
                showXY_2(e.target.result,file.fileName);  
            }; 
        }  
        
        function showXY_2(source){  
		    var img = document.getElementById("loc_img_2");  
		    img.src = source;  
		    $("#image_area_2").css("display","block"); 
		} 
			return true;
		}
        
                //图片预览函数 ==================================================== 333
        function setImagePreviews_3(avalue) {
			var docObj_3=document.getElementById("doca_3");

		 var file = docObj_3.files[0];
		
		if (window.FileReader) {  
            var reader = new FileReader();  
            reader.readAsDataURL(file);  
            //监听文件读取结束后事件  
            reader.onloadend = function (e) {
                showXY_3(e.target.result,file.fileName);  
            }; 
        }  
        
        function showXY_3(source){  
		    var img = document.getElementById("loc_img_3");  
		    img.src = source;  
		    $("#image_area_3").css("display","block"); 
		} 
			return true;
		}
                //图片预览函数 ==================================================== 444
        function setImagePreviews_4(avalue) {
			var docObj_4=document.getElementById("doca_4");

		 var file = docObj_4.files[0];
		
		if (window.FileReader) {  
            var reader = new FileReader();  
            reader.readAsDataURL(file);  
            //监听文件读取结束后事件  
            reader.onloadend = function (e) {
                showXY_4(e.target.result,file.fileName);  
            }; 
        }  
        
        function showXY_4(source){  
		    var img = document.getElementById("loc_img_4");  
		    img.src = source;  
		    $("#image_area_4").css("display","block"); 
		} 
			return true;
		}
                //图片预览函数 ==================================================== 555
        function setImagePreviews_5(avalue) {
			var docObj_5=document.getElementById("doca_5");

		 var file = docObj_5.files[0];
		
		if (window.FileReader) {  
            var reader = new FileReader();  
            reader.readAsDataURL(file);  
            //监听文件读取结束后事件  
            reader.onloadend = function (e) {
                showXY_5(e.target.result,file.fileName);  
            }; 
        }  
        
        function showXY_5(source){  
		    var img = document.getElementById("loc_img_5");  
		    img.src = source;  
		    $("#image_area_5").css("display","block"); 
		} 
			return true;
		}


//有图片显示图片

	if($("#image_name").val()!=""){
		 $("#image_area").css("display","block");
		 $("#image_area").children("img#loc_img").attr("src","/Uploads/"+$("#image_name").val());
	}
	if($("#image_name_2").val()!=""){
		 $("#image_area_2").css("display","block");
		 $("#image_area_2").children("img#loc_img_2").attr("src","/Uploads/"+$("#image_name_2").val());
	}
	if($("#image_name_3").val()!=""){
		 $("#image_area_3").css("display","block");
		 $("#image_area_3").children("img#loc_img_3").attr("src","/Uploads/"+$("#image_name_3").val());
	}
	if($("#image_name_4").val()!=""){
		 $("#image_area_4").css("display","block");
		 $("#image_area_4").children("img#loc_img_4").attr("src","/Uploads/"+$("#image_name_4").val());
	}
	if($("#image_name_5").val()!=""){
		 $("#image_area_5").css("display","block");
		 $("#image_area_5").children("img#loc_img_5").attr("src","/Uploads/"+$("#image_name_5").val());
	}
	
	
</script>
<script>
	//删除图片
	$(".delete_img").click(function(){

		if(confirm("确定要删除图片吗？")==true){
			$.post('/adpp.php/Goods/ajax_delete_img',{'id':$(this).attr("a"),'key':$(this).attr("b")},function(date){
  				if(date==1){
  					window.location.reload();
  				}else{
  					alert('删除失败');
  				}
		    },'json');	
		} 	
	})
		
		
	</script>
	<script>
    //添加规格
    var val02=1;
    var val_102=val02-1;
    var num_add
 
    $("#more_guige").click(function(){
//		console.log($(this).attr("num"))
   	
   		 
   		console.log($(this).attr("num"))
        var dh = '';
//      dh += ' <input type=\"text\" name=\"qq\"    class=\"form-control\" placeholder=\"请输入参数名\">  ';
//      <input type="number" name="price[]" value="" id="sales" class="form-control valid"  aria-invalid="false">
        dh += '<div class="" style="border: 1px solid #d0d0d0; padding: 20px;">规格 '+$(this).attr("num")+' ：';
//      dh += '<span style="background:#F2F2F2;height: 20px; line-height: 20px;" class="delete_guige" a="<?php echo ($info['id']); ?>" b="'+val02+'" c="1">取消</span>';
        dh += '<div class="btn btn-primary delete_guige" a="<?php echo ($info['id']); ?>" b="'+$(this).attr("num")+'" c="1" style="position: relative;top:-2px;">取消</div>';
        
        dh += '<div class="input-group">';
        dh += '<input class="changeimg_key" name="changeimg_key[]" type="hidden"  value="1">';
        dh += '<input style="position: absolute; left: 450px; height: 60px; width: 75px;" type="file" value="" name="img[]" id="guige_input'+$(this).attr("num")+'" onchange="guige_img('+$(this).attr("num")+')">';
        dh += '<img style="position: absolute; left: 530px;top: -29px;" id="guige_img'+$(this).attr("num")+'" src=""/>';
        dh += '<div style="width:50px;display: inline-block;">规格名: </div><input type="text" name="guige[]" placeholder="规格名" value="" id="sales" class="w32"  aria-invalid="false">';
        dh += '<?php if($program_id != JT201810111844206577): ?>';
        dh += '<div style="width:40px;display: inline-block; margin-left: 20px;">价格: </div><input type="text" name="price[]" placeholder="价格" value="" id="sales" class="w32"  aria-invalid="false">';
        dh += '<?php endif; ?>';
        dh += '<div style="height: 10px;"></div><div style="width:50px;display: inline-block;">库存: </div><input type="text" name="num[]" placeholder="库存" value="" id="sales" class="w32"  aria-invalid="false"><div style="width:40px;display: inline-block; margin-left: 20px;"><?php if($program_id == JT201810111844206577): ?>克重<?php else: ?>备注<?php endif; ?>	: </div><input type="text" name="remark[]" placeholder="<?php if($program_id == JT201810111844206577): ?>克重<?php else: ?>备注<?php endif; ?>	" value="" id="sales" class="w32"  aria-invalid="false"></div>';
 
 		dh += '<?php if($program_id == JT201810111844206577): ?>';
 		dh += '<div style="height: 10px;"></div>';
		dh += '<div style="width:50px;display: inline-block;">材料价: </div><input type="text" name="gg_price_cl_title_to_'+$(this).attr("num")+'[]" placeholder="材料价名称" value="" id="sales" class="w32"  aria-invalid="false">';
		dh += '<div style="width:40px;display: inline-block; margin-left: -30px;"> </div><input type="text" name="gg_price_cl_to_'+$(this).attr("num")+'[]" placeholder="材料价价格" value="" id="sales" class="w32"  aria-invalid="false">';
		
		dh += '<div style="height: 10px;"></div>';
		dh += '<div style="width:50px;display: inline-block;"> </div><input type="text" name="gg_price_cl_title_to_'+$(this).attr("num")+'[]" placeholder="材料价名称" value="" id="sales" class="w32"  aria-invalid="false">';
		dh += '<div style="width:40px;display: inline-block; margin-left: -30px;"> </div><input type="text" name="gg_price_cl_to_'+$(this).attr("num")+'[]" placeholder="材料价价格" value="" id="sales" class="w32"  aria-invalid="false">';

		dh += '<div style="height: 10px;"></div>';
		dh += '<div style="width:50px;display: inline-block;"> </div><input type="text" name="gg_price_cl_title_to_'+$(this).attr("num")+'[]" placeholder="材料价名称" value="" id="sales" class="w32"  aria-invalid="false">';
		dh += '<div style="width:40px;display: inline-block; margin-left: -30px;"> </div><input type="text" name="gg_price_cl_to_'+$(this).attr("num")+'[]" placeholder="材料价价格" value="" id="sales" class="w32"  aria-invalid="false">';
		dh += '<?php endif; ?>';
//      document.getElementById('muban_b_'+val_102).innerHTML = dh;
        $('#test123').append(dh)
        if(val02<14){
            val02++;
            val_102++;
        }else{
            alert("限制15个参数");
        }
        
      $(this).attr("num",parseInt($(this).attr("num"))+parseInt(1))
    })
</script>
<script>
    //设置二级规格
    var val022=1;
    var val_1022=val022-1;
    $("#more_guige02").click(function(){
        var dh = '';
        //dh += ' <input type=\"text\" name=\"qq\"    class=\"form-control\" placeholder=\"请输入参数名\">  ';
        //<input type="number" name="price[]" value="" id="sales" class="form-control valid"  aria-invalid="false">
        dh += ' <div class="input-group">  ';
        dh += ' <input type="text" name="guige02[]" placeholder="规格名" value="" id="sales" class="w60"  aria-invalid="false">  ';
        dh += ' </div> ';

        //document.getElementById('muban_b_'+val_102).innerHTML = dh;
        $('#test1234').append(dh)
        if(val022<14){
            val022++;
            val_1022++;
        }else{
            alert("限制15个参数");
        }
    })
</script>
<script>
 //=======================================这里是规格上传图片预览===========================================
 function guige_img(e,n){
 	var guige_input_file	= document.getElementById('guige_input'+e);
 	var guige_img_show 		= document.getElementById('guige_img'+e);
 	if(n){
 		var change_imgkey	= document.getElementById('changeimg'+e);
		change_imgkey.value = '1';
 	}
 	

 	if(guige_input_file.files[0]){
		guige_img_show.style.display 	= 'block';
		guige_img_show.style.width	 	= '110px';
		guige_img_show.style.height 	= '110px'; 
		if(document.getElementById("guige_input_file")!=null){
			document.getElementById("guige_input_file").style.display = 'none';
		}	
		guige_img_show.src = window.URL.createObjectURL(guige_input_file.files[0]);
	}else{
		alert("上传错误！")
	}
	return true;
 }
    //删除规格
    $(".delete_guige").click(function(){
        if(confirm("确定要删除规格吗？")==true){
            $.post('/adp.php/Goods/ajax_delete_guige',{'id':$(this).attr("a"),'key':$(this).attr("b"),'state':$(this).attr("c")},function(date){
                if(date==1){
                   window.location.reload();
                }else{
                    alert('删除失败');
                }
            },'json');
        }
    })
</script>
	<script>
	var val=1;
   	var val_1=val-1;
   		
	 $("#more_img").click(function(){

   		var dh = '';

		
		dh += ' <div class="canshu_total">  ';
		dh += ' 	<div class="canshu_name">  ';	
		dh += ' 		<input type="text" name="canshu_title[]"  value="" class="form-control" placeholder="请输入参数名">  ';
		dh += ' 	</div>  ';
		dh += ' 	<div class="canshu_val">  ';
		dh += ' 		<input type="text" name="canshu_con[]"  value="" class="form-control" placeholder="请输入参数值">  ';
		dh += ' 	</div>  ';
		dh += ' 	<div class="col-sm-1">  ';
	//	dh += ' 		<span  onclick="delet_canshu(this)"  style="    line-height: 37px;">X</span>  ';
		dh += ' 	</div>  ';
		dh += ' </div>  ';
		dh += ' <div style="clear: both;" id="muban_b_'+val;
		dh += '"></div>';
		document.getElementById('muban_b_'+val_1).innerHTML = dh;
		if(val<14){
			val++;
			val_1++;	
		}else{
			alert("图片限制15个参数");
		}
   })
	 
//删除参数
	 
	 function delet_canshu(item){
	 	$(item).parents('div.col-sm-1').parents('div.canshu_total').remove();
	 }
	 </script>
	<script>
		//会员价输入折扣自动计算价格
		
		$(".discount").change(function(){
			var googs_price=$("#price_sell").val();

			$(this).parents("div.input-group").children("input.price_mem").val($(this).val()*googs_price);
		})
		
	</script>
	<script>
		//批发价填写数量的时候必须判断结束数量大于起始数量  最后判断同一个数不能存在全部的批发数量条件里
		$(".num_end").blur(function(){	
			var num_start=$(this).parents('div.pifa_total').children('input.num_start').val();
			
			
			if($(this).val()<num_start){
				alert("批发结束数量必须大于起始数量,请重新输入");
				$(this).val("");
			}else{
				
			}
		})
		
		
		//more_wholesale   更多批发价
		var val03=1;
   	var val_103=val03-1;
		$("#more_wholesale").click(function(){
var dh = '';
		
		dh += ' <div class="pifa_total">  ';				
		dh += ' <span class="input-group-addon pifa_input" >起始件数(≥)</span>  ';
		dh += ' <input  type="text" name="num_start[]"  value="" id="num_start" class="form-control num_start pifa_input_2" >  ';	
		dh += ' <span class="input-group-addon pifa_input" >结束件数(<)</span>  ';	
		dh +='  <input  type="text" name="num_end[]"  value="" id="num_end" class="form-control num_end pifa_input_2" > ';									
		dh += ' <span class="input-group-addon pifa_input" >折扣</span>  ';
		dh += ' <input  type="text" name="wholesale_discount[]"  value="" id="wholesale_discount" class="form-control wholesale_discount12138 pifa_input_2" >  ';
		dh += ' <span class="input-group-addon pifa_input" >参考价</span> ';
		
		dh += ' <input  type="text" name="wholesale_price[]"  value=""  id="wholesale_price" class="form-control valid price_reference pifa_input_2"  aria-invalid="false" style="text-align:center;"> ';
		dh += ' <span class="input-group-addon" style="width:5px;"> 元  </span> ';
//		dh += ' <span  onclick="delet_pifa(this)" a="<?php echo ($v["id"]); ?>" style="width:5px;" class="input-group-addon">X</span> ';
		dh += ' </div> ';
		//document.getElementById('muban_b_'+val_102).innerHTML = dh;
		$('#test456').append(dh)
		if(val03<14){
			val03++;
			val_103++;	
		}else{
			alert("限制15个参数");
		}
		})
		
		
		
function delet_pifa(item){
	 	var r=confirm("是否确定删除本条内容");
	 	var id_pifa=$(item).attr("a");

	  if (r==true){
			$.post('/adp.php/Goods/delete_pifa',{'id':id_pifa},function(date){
    	
       if(date==1){
       		alert("删除成功");
       		location.reload();
       }else{
       		alert("删除失败");
       }

        },'json');
	   }
	 }

//参考价计算  wholesale_discount
		$(".wholesale_discount12138").change(function(){
	
			var reference_price=$("#price_sell").val();

			$(this).parents("div.pifa_total").children("input.price_reference").val($(this).val()*reference_price);
		})
	</script>
<script>
	
//	表单不为空
        function checkdatenull() {
        	 alert($("#program_id").val());
        if(!$("#goods_title").val()){
            alert("请填写商品名称");
            $("#goods_title").focus();
            return false;
        }
        if($("#program_id").val()=='JT201810111844206577'){
        	 if(!$("#kezhong").val()){
	            alert("请填写商品克重");
	            $("#kezhong").focus();
	            return false;
	        }
	        if(!$("#number").val()){
	            alert("请填写库存数量");
	            $("#number").focus();
	            return false;
	        }
	        if(!$("#price_sell_1").val()){
	            alert("请填写游客基础工价");
	            $("#price_sell_1").focus();
	            return false;
	        }
	        if(!$("#price_sell_2").val()){
	            alert("请填写会员基础工价");
	            $("#price_sell_2").focus();
	            return false;
	        }
        }
       
        return true;
        }
	//商品分类选择
	 function gradeChange(){
	 	
    	var city_area=$("#city_area_select").find("option:selected").text();
    	if(city_area=="请选择分类"){
    		return false;
    	}
        $("#road_from_select").empty();
    
        $.post('/adpp.php/Goods/ajax_fenlei_2',{'title':city_area},function(arr_road){
    	
         for (var i=0;i<arr_road.length;i++){
                $("#road_from_select").append($("<option></option>").text(arr_road[i]));
            }

        },'json');
         
    }
</script>
<script type="text/javascript">
//====================================百度编辑器
    //实例化编辑器
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    var ue = UE.getEditor('goods_content');
</script>
</body>
</html>