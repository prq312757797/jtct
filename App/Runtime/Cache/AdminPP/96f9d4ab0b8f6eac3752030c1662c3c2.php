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
				<li ><a href="<?php echo U('Merch/index');?>"><i class="icon icon-shopping-cart"></i>
					<span>多商户概述</span></a></li>

				<!--入驻申请-->
				<li class="submenu open">
					<a href="<?php echo U('Merch/apply_ing');?>"><i class="icon icon-th-list"></i> 
						<span>入驻申请</span> <span class="label">2</span></a>
					<ul>
						<li><a href="<?php echo U('Merch/apply_ing');?>">
							<span>申请中<span style="color:red;"> ( <?php echo ($apply_ing); ?> ) </span></span>
						</a></li>
						<li><a href="<?php echo U('Merch/apply_reject');?>">
							<span>驳回<span style="color:red;"> ( <?php echo ($apply_reject); ?> ) </span></span>
						</a></li>
					</ul>
				</li>
				
				<!--多商户管理-->
				<li class="submenu open">
					<a href="<?php echo U('Merch/in_wait');?>"><i class="icon icon-th-list"></i> 
						<span>多商户管理</span> <span class="label">4</span></a>
					<ul>
						<li><a href="<?php echo U('Merch/in_wait');?>">
							<span>待入驻<span style="color:red;"> ( <?php echo ($in_wait); ?> ) </span></span>
						</a></li>
						<li><a href="<?php echo U('Merch/in_ing');?>">
							<span>入驻中<span style="color:red;"> ( <?php echo ($in_ing); ?> ) </span></span>
						</a></li>
						<li><a href="<?php echo U('Merch/in_stop');?>">
							<span>暂停中<span style="color:red;"> ( <?php echo ($in_stop); ?> ) </span></span>
						</a></li>
						<li><a href="<?php echo U('Merch/index_re');?>">
							<span>推荐中<span style="color:red;"> </span></span>
						</a></li>
					</ul>
				</li>
<!--店员管理-->
<?php if($program_id == JT201806151732369242): ?><li class="submenu open">
					<a href="<?php echo U('Merch/assistant_is');?>"><i class="icon icon-th-list"></i> 
						<span>店员管理</span> <span class="label">3</span></a>
					<ul>
						<li><a href="<?php echo U('Merch/assistant_is');?>">
							<span>申请中<span style="color:red;"> ( <?php echo ($assistant_is); ?> ) </span></span>
						</a></li>
						<li><a href="<?php echo U('Merch/assistant_ing');?>">
							<span>服务中<span style="color:red;"> ( <?php echo ($assistant_ing); ?> ) </span></span>
						</a></li>
						<li><a href="<?php echo U('Merch/assistant_stop');?>">
							<span>暂停中<span style="color:red;"> ( <?php echo ($assistant_stop); ?> ) </span></span>
						</a></li>
						
					</ul>
				</li><?php endif; ?>			
				<?php if(($program_id == JT201806151732369242)): ?><li><a href="<?php echo U('Merch/ad_add');?>"><i class="icon icon-shopping-cart"></i>
					<span>商户列表广告</span></a></li><?php endif; ?>
			<!--	<li><a href="<?php echo U('Merch/in_stop_soon');?>"><i class="icon icon-shopping-cart"></i>
					<span>即将到期</span></a></li>
				<li><a href="<?php echo U('Merch/merch_group');?>"><i class="icon icon-shopping-cart"></i>
					<span>多商户分组</span></a></li>   1031...9.07暂关-->

				<li><a href="<?php echo U('Merch/merch_fenlei');?>"><i class="icon icon-shopping-cart"></i>
					<span>多商户分类</span></a></li>
					<?php if($program_id == JT201711081030423109): ?><li><a href="<?php echo U('Merch/merch_pay_set');?>"><i class="icon icon-shopping-cart"></i>
					<span>多商户支付方式</span></a></li>
				<li><a href="<?php echo U('Merch/merch_pay_record');?>"><i class="icon icon-shopping-cart"></i>
					<span>入驻支付记录</span></a></li><?php endif; ?>
				<!--<li><a href="<?php echo U('Merch/merch_area_set');?>"><i class="icon icon-shopping-cart"></i>
					<span>多商户区域管理</span></a></li>-->


				<!--<li><a href="<?php echo U('Merch/order_count');?>"><i class="icon icon-shopping-cart"></i>
					<span>订单统计</span></a></li>
				<li><a href="<?php echo U('Merch/merch_count');?>"><i class="icon icon-shopping-cart"></i>
					<span>多商户统计</span></a></li>-->
<?php if($is_put_info == 1): ?><!--子商户活动-->
				<li class="submenu open">
					<a href="<?php echo U('Merch/artical_index');?>"><i class="icon icon-th-list"></i> 
						<span>子商户活动</span> <span class="label">2</span></a>
					<ul>
						<li><a href="<?php echo U('Merch/artical_index');?>">
							<span>首页推荐活动<span style="color:red;"> </span></span>
						</a></li>
						<li><a href="<?php echo U('Merch/artical_registe');?>">
							<span>首页推荐审核<span style="color:red;"> </span></span>
						</a></li>
					</ul>
				</li><?php endif; ?>
<?php if($program_id != JT201711081030423109): ?><!--提现申请-->
				<li class="submenu open">
					<a href="<?php echo U('Merch/cash_appay');?>"><i class="icon icon-th-list"></i> 
						<span>提现申请提现申请</span> <span class="label">3</span></a>
					<ul>
						<li><a href="<?php echo U('Merch/cash_appay');?>">
							<span>待确认<span style="color:red;"> </span></span>
						</a></li>
						<li><a href="<?php echo U('Merch/cash_pay');?>">
							<span>待打款<span style="color:red;"> </span></span>
						</a></li>
						<li><a href="<?php echo U('Merch/cash_pay_done');?>">
							<span>已打款<span style="color:red;"> </span></span>
						</a></li>
						<li><a href="<?php echo U('Merch/cash_none');?>">
							<span>无效的<span style="color:red;"> </span></span>
						</a></li>
					</ul>
				</li>


				<!--订单结算-->
				<!--<li><a href="<?php echo U('Merch/m_merch_appay');?>"><i class="icon icon-shopping-cart"></i>
					<span>待确认</span></a></li>
				<li><a href="<?php echo U('Merch/m_merch_wite');?>"><i class="icon icon-shopping-cart"></i>
					<span>待结算</span></a></li>
				<li><a href="<?php echo U('Merch/m_merch_done');?>"><i class="icon icon-shopping-cart"></i>
					<span>已结算</span></a>
				<li><a href="<?php echo U('Merch/m_merch_build');?>"><i class="icon icon-shopping-cart"></i>
					<span>创建结算清单</span></a></li>--><?php endif; ?>
				<!--基础设置-->
				<li><a href="<?php echo U('Merch/merch_set');?>"><i class="icon icon-shopping-cart"></i>
					<span>基础设置</span></a></li>

			<!--	<li><a href="<?php echo U('Merch/shanxuan');?>"><i class="icon icon-shopping-cart"></i>
					<span>筛选区间</span></a></li>
				<li><a href="<?php echo U('Merch/biaoqian');?>"><i class="icon icon-shopping-cart"></i>
					<span>标签管理</span></a></li>-->
			</ul>
		</div>
<style>
	.feilei{
		margin-bottom: 4px;
		padding: 8px 35px 8px 14px;
		color: #468847;
		background-color: #dff0d8;
		border-color: #d6e9c6;
	}
	.function{
		padding: 3px;
		float: right;
		margin-right: 1%;
		margin-top: 4px;
	}
	.title_self{
		width:100%!important;line-height: 43px!important;font-size: 18px!important;
	}
	.con_self{
		width:100%!important;
	}
</style>
<div id="content">
	<div id="content-header">
		<h1>多商户概述</h1>
	</div>
	<div id="breadcrumb">
		<a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 多商户系统</a>
		<a href="#" class="current">多商户概述</a>


	</div>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
					<div class="widget-title">
								<span class="icon">
									<i class="icon-th"></i>
								</span>
						<h5>多商户概述</h5>
					</div>
					<div class="widget-content nopadding">
						<div class="alert alert-error alert-block">
							<a class="close" data-dismiss="alert" href="#">×</a>
							<h4 class="alert-heading">多商户操作介绍</h4>
								1：子商户入驻有两个方式，后台录入和手机端申请<br/>
							<?php if($program_id == JT201806151732369242): ?>2：后台录入的子商户必须绑定商户管理员便于手机端管理商户<?php endif; ?>
							
							
						</div>
						<div class="row-fluid">
							<div class="span12 center" style="text-align: center;">					
								<ul class="stat-boxes" style="width:100%;">
									<li style="width:10%;    height: 60px;">
										<div class="right title_self" >入驻申请管理</div>
									</li>
									<li style="width:20%;">
										<div class="right con_self" >入驻申请中<strong><?php echo ($count['k1']); ?></strong></div>
									</li>
									<li style="width:20%;">
										<div class="right con_self">入驻申请驳回<strong><?php echo ($count['k2']); ?></strong></div>
									</li>
									<li style="width:20%;">
										<div class="right con_self">待入驻商户<strong><?php echo ($count['k3']); ?></strong></div>
									</li>
								</ul>
								
								<ul class="stat-boxes" style="width:100%;">
									<li style="width:10%;    height: 60px;">
										<div class="right title_self" >已入驻商户管理</div>
									</li>
									<li style="width:20%;">
										<div class="right con_self" >入驻中商户<strong><?php echo ($count['k4']); ?></strong></div>
									</li>
									<li style="width:20%;">
										<div class="right con_self">暂停中商户<strong><?php echo ($count['k5']); ?></strong></div>
									</li>
									<li style="width:20%;">
										<div class="right con_self">即将到期的商户<strong>0</strong></div>
									</li>
								</ul>
								
								<!--<ul class="stat-boxes" style="width:100%;">
									<li style="width:10%;    height: 60px;">
										<div class="right title_self" >已完成订单统计</div>
									</li>
									<li style="width:20%;">
										<div class="right con_self" >订单数<strong>0</strong></div>
									</li>
									<li style="width:20%;">
										<div class="right con_self">订单金额<strong>0</strong></div>
									</li>
								</ul>
								<ul class="stat-boxes" style="width:100%;">
									<li style="width:10%;    height: 60px;">
										<div class="right title_self" >总订单统计</div>
									</li>
									<li style="width:20%;">
										<div class="right con_self" >订单数<strong>0</strong></div>
									</li>
									<li style="width:20%;">
										<div class="right con_self">订单金额<strong>0</strong></div>
									</li>
								</ul>-->
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