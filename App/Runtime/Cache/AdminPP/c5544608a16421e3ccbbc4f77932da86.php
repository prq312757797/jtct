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
					
			<?php if($program_id == JT201808090855119076): ?><li><a href="<?php echo U('Goods/fenlei');?>"><i class="icon icon-shopping-cart"></i> 
					<span>房台套餐分类</span></a></li>
				<?php else: ?>
				<li><a href="<?php echo U('Goods/fenlei');?>"><i class="icon icon-shopping-cart"></i> 
					<span>分类</span></a></li><?php endif; ?>		
			
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
   <style>
   	.con{
   		/*padding:40px;
*/   	}
   	  	.p_laber{
   	
   	}
   	.more_content_list{
   		    border: 1px solid;
    padding: 3px;
    width: 100px;
    text-align: center;
    margin-left: 7%;
    float: left;
    border-radius: 4px;
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
			                		<!--能量ktv商品详情  简化-->	
									<div class="widget-title">
										<span class="icon">
											<i class="icon-align-justify"></i>									
										</span>
										<ul class="nav nav-tabs"style="height:60px;width:100%;">
											<li class="active">
												<a data-toggle="tab" href="#tab-01" aria-expanded="true"> 商品编辑</a>
											</li>
											<?php if(!empty($info)): ?><li class="">
												<a data-toggle="tab" href="#tab-02" aria-expanded="false">商品图片</a>
											</li><?php endif; ?>
											<li class="">
												<a data-toggle="tab" href="#tab-04" aria-expanded="true"> 详情</a>
											</li>
											<li class="">
												<a data-toggle="tab" href="#tab-06" aria-expanded="false">参数</a>
											</li>	
										</ul>
									</div>
			
									<div class="form-horizontal">
										<div class="tab-content">	
											<div id="tab-01" class="tab-pane active">
											<form action="<?php echo U('Goods/run_goods_add',array('id'=>$info['id']));?>" method="post" enctype="multipart/form-data" class="form-horizontal" />
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
															<input type="text"  name="goods_title" value="<?php echo ($info["goods_title"]); ?>"/>
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
													<!--套餐欢唱时间-->
													<div class="control-group">
														<label class="control-label">欢唱时长(小时)：</label>
														<div class="controls">
															<input type="text"  name="goods_time" value="<?php echo ($info["goods_time"]); ?>"/>
															<span class="help-block" ></span>
														</div>
													</div>
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
													<!--商品价格-->
													<div class="control-group">
														<label class="control-label">商品价格：</label>
														<div class="controls">
															<div class="input-group">
																<span class="input-group-addon">售价</span>
																<input type="text" name="price_sell"  value="<?php echo ($info["price_sell"]); ?>" id="price_sell" class="form-control " >
																<!--<span class="input-group-addon">原价</span>
																<input type="text" name="price_own" value="<?php echo ($info["price_own"]); ?>" id="price_own" class="form-control valid "  aria-invalid="false">
																<span class="input-group-addon">成本价</span>
																<input type="text" name="cost" value="<?php echo ($info["cost"]); ?>" id="cost" class="form-control " >
		-->
															</div>
															<span class="help-block" ></span>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label">续钟价格：</label>
														<div class="controls">
															<div class="input-group">
																<span class="input-group-addon">售价</span>
																<input type="text" name="price_sell_x"  value="<?php echo ($info["price_sell_x"]); ?>" id="price_sell_x" class="form-control " >
																<!--<span class="input-group-addon">原价</span>
																<input type="text" name="price_own" value="<?php echo ($info["price_own"]); ?>" id="price_own" class="form-control valid "  aria-invalid="false">
																<span class="input-group-addon">成本价</span>
																<input type="text" name="cost" value="<?php echo ($info["cost"]); ?>" id="cost" class="form-control " >
		-->
															</div>
															<span class="help-block" ></span>
														</div>
													</div>
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
													<!--<div class="control-group">
														<label class="control-label">详情介绍</label>
														<div class="controls">
															<textarea rows="6" name="goods_content" id="goods_content" ><?php echo ($info["goods_content"]); ?></textarea>
														<span class="help-block"></span>
														</div>
													</div>-->
<script>
		function action_12(item){
	
			$(".fenlei2").css("display","none")
			$("#xx_"+$(item).find("option:selected").val()).css("display","block")
		}
		function action_123(item){
			$.post('/adp.php/Warehouse/ajax_goods_info', {
				'fenlei_2': $(item).find("option:selected").val(),'warehouse01':3
			}, function(date) {
				var obj = eval(date);
				var dh = '';
			
				dh += ' <option>  ';
				dh += '选择商品';
				dh += ' </option>  ';
				for(var i = 0; i < obj.length; i++) {
					dh += ' <option  value="' + obj[i].id + '">  ';
					dh += obj[i].goods_title;
					dh += '('+obj[i].on_num+')';
					dh += ' </option>  ';
					document.getElementById('muban_b').innerHTML = dh;
				}

	
				}, 'json');
			}
</script>
<!--是否绑定库存商品-->
													<div class="control-group">
														<label class="control-label">是否绑定库存商品：</label>
														<?php if(empty($info)): ?><div class="controls">
																<label class="radio-inline is_show">
																	<input type="radio" name="ison_tie_goods" value="1" > 启用
																</label>
																<label class="radio-inline is_show">
																	<input type="radio" name="ison_tie_goods" value="0" checked="checked"> 关闭
																</label>
															</div>
															<?php else: ?>
															<?php if($info["ison_tie_goods"] == 1): ?><div class="controls">
																	<label class="radio-inline is_show">
																		<input type="radio" name="ison_tie_goods" value="1" checked="checked"> 启用
																	</label>
																	<label class="radio-inline is_show">
																		<input type="radio" name="ison_tie_goods" value="0"> 关闭
																	</label>
																</div><?php endif; ?>
															<?php if($info["ison_tie_goods"] == 0): ?><div class="controls">
																	<label class="radio-inline is_show">
																		<input type="radio" name="ison_tie_goods" value="1" > 启用
																	</label>
																	<label class="radio-inline is_show">
																		<input type="radio" name="ison_tie_goods" value="0" checked="checked"> 关闭
																	</label>
																</div><?php endif; endif; ?>
													</div>
<!--绑定库存商品-->
													<div class="control-group">
														<label class="control-label">绑定库存商品：</label>
														<div class="controls">
															<div class="controls input_select ml0 w20">
																<select onchange="action_12(this)" >
																	<option >大类</option>
																	<?php if(is_array($fenlei)): foreach($fenlei as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["title"]); ?></option><?php endforeach; endif; ?>
																</select>
															</div>
															<?php if(is_array($fenlei)): foreach($fenlei as $k=>$v): ?><div class="controls  input_select ml12 w20 fenlei2" id="xx_<?php echo ($v["id"]); ?>" style="display:none;">
																<select class="w100" onchange="action_123(this)" >
																	<option >小类</option>
																	<?php if(is_array($v['child'])): foreach($v['child'] as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["title"]); ?></option><?php endforeach; endif; ?>
																</select>
															</div><?php endforeach; endif; ?>
															<div class="controls  input_select ml12 w20" >
																<select name="tie_goods_id"  id="muban_b">
																	<option ></option>
																	
																</select>
															</div>
															<div class="controls  input_select ml12 w20" >
																<input type="number" name="tie_goods_num" value=""/>
															</div>
															<span class="help-block" ></span>
														</div>
													</div>		
<!--已绑定库存-->
<?php if(!empty($info['ktv_tie_goods_id'])): ?><div class="control-group">
														<label class="control-label">已绑定库存商品：</label>
														<div class="controls">
															<input type="text" style="width:10%;float:Left;" readonly value="<?php echo ($info["tie_goods_title"]); ?>"/>
															<input type="number" style="width:10%;float:Left;"  name="ktv_tie_goods_num" value="<?php echo ($info["ktv_tie_goods_num"]); ?>"/>
														</div>
													</div><?php endif; ?>											

<!--参数-->
													<!--<div class="widget-content nopadding">
														<div class="control-group">
															<div id="more_content_list" class="btn btn-primary more_content_list">更多详情参数</div>
																<div style="line-height: 33px;height: 12px;text-indent: 14px;">
									    							<span class="help-block" >第一条参数应为绑定酒水，会根据库存数是否显示</span>
																</div>
															<?php if(empty($content_list)): ?><div class="canshu_total">
																	<div class="canshu_name " style="width:60%;">
																		<input type="text" name="content_list_str[]"   class="form-control" placeholder="请输入详情参数">
																	</div>
															
																	<div class="col-sm-1">
																		
																	</div>
																</div>
															<?php else: ?>
															<?php if(is_array($content_list)): foreach($content_list as $key=>$v): ?><div class="canshu_total">
																	<div class="canshu_name "style="width:60%;">
																		<input type="text" name="content_list_str[]"  value="<?php echo ($v); ?>" class="form-control" placeholder="请输入详情参数">
																	</div>
															
																	<div class="col-sm-1">
																		<span  onclick="delet_canshu(this)" style="line-height: 54px;">X</span>
																	</div>
																</div><?php endforeach; endif; endif; ?>
															<div id="muban_b_0"></div>
														</div>
														
													</div>-->
													
													<!--参数-->
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
											
											
											
										</div>
									</div>
								</div>
							</div>
						</div>						
					</div>
				</div>
				
			</div>
	</div>
	

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
	var val=1;
   	var val_1=val-1;
   		
	 $("#more_content_list").click(function(){

   		var dh = '';

		
		dh += ' <div class="canshu_total">  ';
		dh += ' 	<div class="canshu_name" style="width:60%;">  ';	
		dh += ' 		<input type="text" name="content_list_str[]"  value="" class="form-control" placeholder="请输入详情参数">  ';
		dh += ' 	</div>  ';

		dh += ' 	<div class="col-sm-1">  ';
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