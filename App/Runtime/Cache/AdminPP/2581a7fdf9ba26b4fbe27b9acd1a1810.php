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
			<li ><a href="<?php echo U('Gold/index');?>"><i class="icon icon-shopping-cart"></i> 
				<span>实时金价</span></a></li>	
			<li ><a href="<?php echo U('Gold/self_price');?>"><i class="icon icon-shopping-cart"></i> 
				<span>价格调控</span></a></li>	

				<!--收藏订单-->
			<li class="submenu open">
				<a href="<?php echo U('Gold/shoucang_order');?>"><i class="icon icon-th-list"></i> 
					<span>收藏订单</span> <span class="label">2</span></a>
				<ul>
					<li><a href="<?php echo U('Gold/shoucang_order');?>">
						<span>收藏买入订单<span style="color:red;"></span></span>
					</a></li>
					<li><a href="<?php echo U('Gold/shoucang_order_2');?>">
						<span>收藏卖出订单<span style="color:red;"></span></span>
					</a></li>
					
				</ul>
			</li>
		</ul>

</div>



		
<div id="content">
	<div id="content-header">
		<h1>实时金价</h1>
	</div>
	<div id="breadcrumb">
		<a href="<?php echo U('Index/index');?>" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 首页</a>
		<a href="#" class="current">实时金价</a>
	</div>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
					<div class="widget-title">
						<span class="icon">
							<i class="icon-th"></i>
						</span>
						<h5>实时金价</h5>
						<h5 id="time"><?php echo ($list["16"]["Date"]); ?></h5>
					</div>
					<div class="widget-content nopadding">
						<table class="table table-bordered table-striped">
							<thead>
							<tr>
								<th>商品</th>
								<th>回购</th>
								<th>销售</th>
							</tr>
							</thead>
							<tbody>
<!--								
								<tr>
									<td>黄金</td>
									<td id="a1_b"><?php echo ($list["16"]["BP1"]); ?></td>
									<td id="a1_s"><?php echo ($list["16"]["SP1"]); ?></td>
								</tr>
								<tr>
									<td>铂金</td>
									<td id="a2_b"><?php echo ($list["13"]["BP1"]); ?></td>
									<td id="a2_s"><?php echo ($list["13"]["SP1"]); ?></td>
								</tr>
								<tr>
									<td>钯金</td>
									<td id="a3_b"><?php echo ($list["14"]["BP1"]); ?></td>
									<td id="a3_s"><?php echo ($list["14"]["SP1"]); ?></td>
								</tr>
								<tr>
									<td>白银</td>
									<td id="a4_b"><?php echo ($list["15"]["BP1"]); ?></td>
									<td id="a4_s"><?php echo ($list["15"]["SP1"]); ?></td>
								</tr>
								-->
								<tr>
									<td>黄金</td>
									<td id="a1_b"><?php echo ($list["11"]["BP1"]); ?></td>
									<td id="a1_s"><?php echo ($list["11"]["SP1"]); ?></td>
								</tr>
								<tr>
									<td>白银</td>
									<td id="a4_b"><?php echo ($list["8"]["BP1"]); ?></td>
									<td id="a4_s"><?php echo ($list["8"]["SP1"]); ?></td>
								</tr>
							</tbody>
						</table>
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
	var that = this;
	var aa=1
	ajax_l()

    function ajax_l(){
	    if(aa<999999999){
			setTimeout(function () { 
				ajax_u()
				aa++
				ajax_l()
			}, 3000);
		}
    }
    
    function ajax_u(){
    	$.post('/adp.php/Gold/ajax',{},function(date){
	  	$("#time").text(date[0].Date)
//	  
//	  	if(date[16].BP1>$("#a1_b").text()){ $("#a1_b").css("color","red") }else if(date[16].BP1==$("#a1_b").text()){$("#a1_b").css("color","black") }else{ $("#a1_b").css("color","green") }
//	  	if(date[16].SP1>$("#a1_s").text()){ $("#a1_s").css("color","red") }else if(date[16].SP1==$("#a1_s").text()){$("#a1_s").css("color","black") }else{ $("#a1_s").css("color","green") }
//       	$("#a1_b").text(date[16].BP1)
//       	$("#a1_s").text(date[16].SP1)
//       	
//      if(date[13].BP1>$("#a2_b").text()){ $("#a2_b").css("color","red") }else if(date[13].BP1==$("#a2_b").text()){$("#a2_b").css("color","black") }else{ $("#a2_b").css("color","green") }
//	  	if(date[13].SP1>$("#a2_s").text()){ $("#a2_s").css("color","red") }else if(date[13].SP1==$("#a2_s").text()){$("#a2_s").css("color","black") }else{ $("#a2_s").css("color","green") }
//       	$("#a2_b").text(date[13].BP1)
//       	$("#a2_s").text(date[13].SP1)
//      
//      if(date[14].BP1>$("#a3_b").text()){ $("#a3_b").css("color","red") }else if(date[14].BP1==$("#a3_b").text()){$("#a3_b").css("color","black") }else{ $("#a3_b").css("color","green") }
//	  	if(date[14].SP1>$("#a3_s").text()){ $("#a3_s").css("color","red") }else if(date[14].SP1==$("#a3_s").text()){$("#a3_s").css("color","black") }else{ $("#a3_s").css("color","green") }
//       	$("#a3_b").text(date[14].BP1)
//       	$("#a3_s").text(date[14].SP1)
//      
//      if(date[15].BP1>$("#a4_b").text()){ $("#a4_b").css("color","red") }else if(date[15].BP1==$("#a4_b").text()){$("#a4_b").css("color","black") }else{ $("#a4_b").css("color","green") }
//	  	if(date[15].SP1>$("#a4_s").text()){ $("#a4_s").css("color","red") }else if(date[15].SP1==$("#a4_s").text()){$("#a4_s").css("color","black") }else{ $("#a4_s").css("color","green") }
//       	$("#a4_b").text(date[15].BP1)
//       	$("#a4_s").text(date[15].SP1)
//       	

	  	if(date[11].BP1>$("#a1_b").text()){ $("#a1_b").css("color","red") }else if(date[11].BP1==$("#a1_b").text()){$("#a1_b").css("color","black") }else{ $("#a1_b").css("color","green") }
	  	if(date[11].SP1>$("#a1_s").text()){ $("#a1_s").css("color","red") }else if(date[11].SP1==$("#a1_s").text()){$("#a1_s").css("color","black") }else{ $("#a1_s").css("color","green") }
         	$("#a1_b").text(date[11].BP1)
         	$("#a1_s").text(date[11].SP1)
        if(date[8].BP1>$("#a4_b").text()){ $("#a4_b").css("color","red") }else if(date[8].BP1==$("#a4_b").text()){$("#a4_b").css("color","black") }else{ $("#a4_b").css("color","green") }
	  	if(date[8].SP1>$("#a4_s").text()){ $("#a4_s").css("color","red") }else if(date[8].SP1==$("#a4_s").text()){$("#a4_s").css("color","black") }else{ $("#a4_s").css("color","green") }
         	$("#a4_b").text(date[8].BP1)
         	$("#a4_s").text(date[8].SP1)
	    },'json');
    }
    	
	
</script>