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

	<?php if($head_menu == 1): ?><ul>
			<li ><a href="<?php echo U('Members/index');?>"><i class="icon icon-shopping-cart"></i>
				<span>会员概述</span></a></li>
			<li><a href="<?php echo U('Members/members');?>"><i class="icon icon-shopping-cart"></i>
				<span>会员管理</span></a></li>
			<li><a href="<?php echo U('Members/members_lever');?>"><i class="icon icon-shopping-cart"></i>
				<span><?php if($program_id == JT201808090855119076): ?>会员卡<?php else: ?>会员等级<?php endif; ?></span></a></li>
			<!--<li><a href="<?php echo U('Members/members_group');?>"><i class="icon icon-shopping-cart"></i>
				<span>会员分组</span></a></li>-->
			<?php if(($program_id == JT201711101339052665) or ($program_id == JT201709011821539094)): ?><li><a href="<?php echo U('Members/members_account');?>"><i class="icon icon-shopping-cart"></i>
				<span>会员账号管理</span></a></li><?php endif; ?>
			<?php if(($program_id == JT201806151732369242)): ?><li><a href="<?php echo U('Members/ad_add');?>"><i class="icon icon-shopping-cart"></i>
				<span>资料登记广告</span></a></li><?php endif; ?>
			<?php if(($program_id == JT201810111844206577) | ($program_id == JT201710101645145951)): ?><!--<li><a href="<?php echo U('Members/gold_vip');?>"><i class="icon icon-shopping-cart"></i>
				<span>黄金会员审核</span></a></li>-->
			<!--<li><a href="<?php echo U('Members/order_vip');?>"><i class="icon icon-shopping-cart"></i>
				<span>会员购买订单</span></a></li>-->
				<!--提现申请-->
				<li class="submenu open">
					<a href="<?php echo U('Members/cash_ing');?>"><i class="icon icon-th-list"></i> 
						<span>提现申请</span> <span class="label">4</span></a>
					<ul>
						<li><a href="<?php echo U('Members/cash_ing');?>">
							<span>待审核的</span>
						</a></li>
						<li><a href="<?php echo U('Members/cash_git');?>">
							<span>待打款的</span>
						</a></li>
						<li><a href="<?php echo U('Members/cash_done');?>">
							<span>已打款的</span>
						</a></li>
						<li><a href="<?php echo U('Members/cash_none');?>">
							<span>无效的</span>
						</a></li>
					</ul>
				</li><?php endif; ?>
			
			<?php if($head_menu == 5): ?><li ><a href="<?php echo U('Members/cash_ing');?>"><i class="icon icon-shopping-cart"></i>
					<span>待审核的</span></a></li>
				<li><a href="<?php echo U('Members/cash_git');?>"><i class="icon icon-shopping-cart"></i>
					<span>待打款的</span></a></li>
				<li><a href="<?php echo U('Members/cash_done');?>"><i class="icon icon-shopping-cart"></i>
					<span>已打款的</span></a></li>
				<li><a href="<?php echo U('Members/cash_none');?>"><i class="icon icon-shopping-cart"></i>
					<span>无效的</span></a></li>

				<li><a href="<?php echo U('Members/integral_set');?>"><i class="icon icon-shopping-cart"></i>
					<span>会员积分充值设置</span></a></li><?php endif; ?>

		</ul><?php endif; ?>

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
</style>
<div id="content">
	<div id="content-header">
		<h1>会员概述</h1>
	</div>
	<div id="breadcrumb">
		<a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 会员</a>
		<a href="#" class="current">会员概述</a>


	</div>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
					<div class="widget-title">
								<span class="icon">
									<i class="icon-th"></i>
								</span>
						<h5>会员概述</h5>
					</div>
					<div class="widget-content nopadding">
						<div class="row-fluid">
					<div class="span12 center" style="text-align: center;">					
						<ul class="stat-boxes" style="width:100%;">
							<li style="width:20%;">
								<div class="left peity_bar_good"><span>2,4,9,7,12,10,1</span>+0%</div>
								<div class="right" style="width:60%;">
									<strong><?php echo ($today); ?></strong>
									今日新增会员
								</div>
							</li>
							
							<li style="width:20%;">
								<div class="left peity_bar_bad"><span>3,5,9,7,12,20,10</span>+0%</div>
								<div class="right" style="width:60%;">
									<strong><?php echo ($yesterday); ?></strong>
									昨日新增会员
								</div>
							</li>
							<li style="width:20%;">
								<div class="left peity_line_good"><span>12,6,9,23,14,10,17</span>+0%</div>
								<div class="right" style="width:60%;">
									<strong><?php echo ($in_weeken); ?></strong>
									过去七天新增会员
								</div>
							</li>
						
						</ul>
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