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
		
			<li ><a href="<?php echo U('Orderktvroom/index');?>"><i class="icon icon-shopping-cart"></i>
				<span>订单概述</span></a></li>
			<li><a href="<?php echo U('Orderktvroom/allder_fukuan');?>"><i class="icon icon-shopping-cart"></i>
				<span>待付款</span></a></li>
			<li><a href="<?php echo U('Orderktvroom/allder_fahuo');?>"><i class="icon icon-shopping-cart"></i>
				<span>未使用</span></a></li>
			<!--<li><a href="<?php echo U('Orderktvroom/allder_shouhuo');?>"><i class="icon icon-shopping-cart"></i>
				<span>待收货</span></a></li>
			<li><a href="<?php echo U('Orderktvroom/allder_pingjia');?>"><i class="icon icon-shopping-cart"></i>
				<span>待评价</span></a></li>-->
			<li><a href="<?php echo U('Orderktvroom/allder_wancehgn');?>"><i class="icon icon-shopping-cart"></i>
				<span>已完成</span></a></li>
			<li><a href="<?php echo U('Orderktvroom/allder_tuikuan');?>"><i class="icon icon-shopping-cart"></i>
				<span>待退款</span></a></li>
			<li><a href="<?php echo U('Orderktvroom/allder_tuikuandone');?>"><i class="icon icon-shopping-cart"></i>
				<span>已退款</span></a></li>
			<li><a href="<?php echo U('Orderktvroom/allder_close');?>"><i class="icon icon-shopping-cart"></i>
				<span>已关闭</span></a></li>
			
			<li><a href="<?php echo U('Orderktvroom/order_all');?>"><i class="icon icon-shopping-cart"></i>
				<span><?php if($program_id == JT201806151732369242): ?>全部订单(发货订单)<?php else: ?>全部订单<?php endif; ?></span></a></li>
			
			<?php if($program_id == JT201806151732369242): ?><li><a href="<?php echo U('Orderktvroom/order_hexiao');?>"><i class="icon icon-shopping-cart"></i>
				<span>核销消费订单</span></a></li><?php endif; ?>
			<!--

			<li><a href="<?php echo U('Order/weiquan_beg');?>"><i class="icon icon-shopping-cart"></i>
				<span>维权申请</span></a></li>
			<li><a href="<?php echo U('Order/weiquan_over');?>"><i class="icon icon-shopping-cart"></i>
				<span>维权完成</span></a></li>
			<li><a href="<?php echo U('Order/fahuo');?>"><i class="icon icon-shopping-cart"></i>
				<span>批量发货</span></a></li>

				-->
		</ul>


</div>
<style>
	.bottom_u{
		margin-bottom: 1px;
		margin-top: -10px;
	}
	.bottom_d{
		margin-bottom: 1px;
		margin-top: 2px;
	}
	td{
		border-bottom: 1px solid #ddd;
	}
</style>
<div id="content">
	<div id="content-header">
		<h1>订单管理</h1>
	</div>
	<div id="breadcrumb">
		<a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 订单管理</a>
		<a href="#" class="current">待发货</a>
	<button id="search_button_order_num" class="btn" style="float: right;margin-top: 3px;margin-left: -3px;margin-right: 22px;" >搜索</button>
		<input type="text" placeholder="订单号码" value="<?php echo ($his_str); ?>" id="search_str" style="float: right;margin-top: 3px;" onBlur="this.value=ignoreSpaces(this.value);">
	
	</div>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
					<div class="widget-title">
								<span class="icon">
									<i class="icon-th"></i>
								</span>
						<h5>订单管理</h5>
					</div>
					<div class="widget-content nopadding">
						<table class="table table-bordered table-striped">
							<thead>
							<tr>
								<th style="width:5%;">商品</th>
								<th style="width:5%;"></th>
								<th style="width:5%;">单价/数量</th>
								<th style="width:5%;">买家</th>
								<th style="width:5%;">支付/配送</th>
								<th style="width:5%;">价格</th>
								<th style="width:5%;">下单时间</th>
								<th style="width:5%;">付款时间</th>
								<th style="width:9%;">操作</th>
							</tr>
							</thead>
							<tbody>
							<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(is_array($vo[info])): $k = 0; $__LIST__ = $vo[info];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub): $mod = ($k % 2 );++$k; if($k == 1): ?><tr>
											<td style="border: 1px;"><div style="width: 184%;font-weight: 600;">订单编号:  <?php echo ($vo["order_num"]); ?></div></td>
												<td></td>
											<?php if(!empty($vo[sh_name])): ?><td style="border: 1px;"><div style="width: 184%;font-weight: 600;text-align: left;">商户：<?php echo ($vo["sh_name"]); ?></div></td><?php endif; ?>
										</tr><?php endif; ?>
									<tr>
										<td><img src="/Uploads/<?php echo ($sub["image"]); ?>" style="width:50px;height:50px;border:1px solid #ccc; padding:1px;"></td>
										<td><?php echo ($sub["goods_title"]); ?></td>
										<td <?php if($k != 1): ?>style="border-right: 1px solid #ddd;"<?php endif; ?>>
										<?php if($sub["is_use_guige"] == 2): echo ($sub["guige_price"]); ?>	<?php else: echo ($sub["price_sell"]); endif; ?>
										<br>x<?php echo ($sub["buy_num"]); ?>
										<br>
										<?php if($vo["is_change_price"] == 1): ?><span style="color:red;">(改价)</span><?php echo ($vo["change_price"]); endif; ?>
										</td>
										<?php if($k == 1): ?><td> <?php echo ($vo["nickname"]); ?> <br/><?php echo ($vo["tel"]); ?> </td>

											<td><!--交易状态(1：待付款、2：待发货、3：待收货、4：待评价、5：退换/售后、6：已关闭、7：已完成-->
												<label class="label label-default">
													<?php if($vo["state"] == 1): ?>未支付<?php endif; ?>
													<?php if($vo["state"] == 2): ?>待发货<?php endif; ?>
												</label>
												<br>
												<span style="margin-top:5px;display:block;">快递</span>
											</td>
											<td>
												￥<?php echo ($vo["price_all_a"]); ?><br/>
												<?php if($vo['pay_method'] == 2): ?><text style="color:red;">积分支付</text><?php endif; ?>
												<?php if($vo['pay_method'] == 3): ?><text style="color:red;">消费券支付</text><?php endif; ?>
											</td>
											<td>
												<?php echo (date("Y-m-d",$vo["time_build"])); ?><br><?php echo (date("H:i:s",$vo["time_build"])); ?>
											</td>
											<td>
												<?php echo (date("Y-m-d",$vo["time_fukuan"])); ?><br><?php echo (date("H:i:s",$vo["time_fukuan"])); ?>
											</td>
											<td>
												<a class="btn btn-danger bottom_u" style="color:white;"  title="关闭订单" alt="关闭订单" href="/adp.php/Orderktvroom/close_order?id=<?php echo ($vo["id"]); ?>" onclick="if(confirm('确认关闭订单吗？')==false)return false;">关闭订单</a>
												
												<a class="btn btn-danger bottom_u change_price" style="color:white;"  href="javascript:"   a="<?php echo ($vo["order_num"]); ?>" b="<?php echo ($vo["price_all_a"]); ?>">订单改价</a>
												
												<a class="btn btn-danger bottom_d order_fahuo" style="color:white;"   href="javascript:"   a="<?php echo ($vo["order_num"]); ?>" b="<?php echo ($vo["price_all_a"]); ?>">确认发货</a>
											
												
												<a class="btn btn-danger bottom_d" style="color:white;"  title="查看详情" alt="查看详情" href="order_con?order_num=<?php echo ($vo["order_num"]); ?>" >查看详情</a>
												
											</td><?php endif; ?>
									</tr><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>

							</tbody>
						</table>
						<div class="pages self_css"> <?php echo ($pages); ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


		<style>
			.modal_text{
				text-align: center;
			    color: #555555;
			    font-size: 28px;
			    font-weight: normal;
			}
			
		</style>
		<!-- 按钮触发模态框 -->
<a id="add-event" style="display:none;" data-toggle="modal" href="#modal-add-event" class="btn btn-success btn-mini"><i class="icon-plus icon-white"></i> 6666666666</a>

		<div class="modal hide" id="modal-add-event">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3> 提示</h3>
			</div>
			<div class="modal-body">
				<h4  id="myModalLabel" class="modal_text" ></h4>
				
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">关闭</a>
					<!--<a href="#" id="add-event-submit" class="btn btn-primary">确定</a>-->
			</div>
		</div> 
		<style>
			.modal_text{
				text-align: center;
			    color: #555555;
			    font-size: 28px;
			    font-weight: normal;
			}
			.modal_label{
				width: 21%;
			    float: left;
			    text-align: center;
			    height: 30px;
			    line-height: 41px;
			}
		</style>

		<!-- 按钮触发模态框 -->
<a id="add-event_2" style="display:none;" data-toggle="modal" href="#modal-add-event_2" class="btn btn-success btn-mini"><i class="icon-plus icon-white"></i> </a>
		<div class="modal hide" id="modal-add-event_2">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3> 订单改价</h3>
			</div>
			<div class="modal-body">
			
				<div class="control-group">
					<label class="control-label modal_label">交易单号：</label>
					<div class="controls">
						 <input type="text" id="order_num12138" readonly class="form-control w70 mt5">
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label modal_label">商品原价：</label>
					<div class="controls">
						 <input type="text" id="price_old" readonly class="form-control w70 mt5">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label modal_label">修改价格：</label>
					<div class="controls">
						 <input type="text" id="change_price" class="form-control w70 mt5">
					</div>
				</div>
				
			</div>
			<input type="hidden" value="" id="openid" name="openid"> 
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">取消</a>
			
				<input type="submit" value="确认" class="btn btn-primary " id="div_submit">
			</div>
		</div>

			
			  
		<style>
			.modal_text{
				text-align: center;
			    color: #555555;
			    font-size: 28px;
			    font-weight: normal;
			}
			.modal_label{
				width: 21%;
			    float: left;
			    text-align: center;
			    height: 30px;
			    line-height: 41px;
			}
		</style>

		<!-- 按钮触发模态框 -->
<a id="add-event_fahuo" style="display:none;" data-toggle="modal" href="#modal-add-event_fahuo" class="btn btn-success btn-mini"><i class="icon-plus icon-white"></i> </a>
		<div class="modal hide" id="modal-add-event_fahuo">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3> 订单发货</h3>
			</div>
			<div class="modal-body">
			
				<div class="control-group">
					<label class="control-label modal_label">交易单号：</label>
					<div class="controls">
						 <input type="text" id="order_num12138_fahuo" readonly class="form-control w70 mt5">
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label modal_label">收货姓名：</label>
					<div class="controls">
						 <input type="text" id="shouhuo_man" readonly class="form-control w70 mt5">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label modal_label">联系电话：</label>
					<div class="controls">
						 <input type="text" id="shouhuo_phone" readonly class="form-control w70 mt5">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label modal_label">收货地址：</label>
					<div class="controls">
						 <input type="text" id="man_address" readonly class="form-control w70 mt5">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label modal_label">快递公司：</label>
					<div class="controls">
						<select class="form-control" id="express_id" name="express_id" style="width:72%;">
						    <option>选择快递公司</option>
							<?php if(is_array($kuaidi)): foreach($kuaidi as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["name"]); ?></option><?php endforeach; endif; ?>
					    </select>	
					</div>
				</div>
				<div class="control-group">
					<label class="control-label modal_label">快递单号：</label>
					<div class="controls">
						 <input type="text" id="express_num"  class="form-control w70 mt5">
					</div>
				</div>
	
			</div>
			<input type="hidden" value="" id="openid" name="openid"> 
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">取消</a>
				<input type="submit" value="确认" class="btn btn-primary " id="div_submit_fahuo">
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
    //消除input里面的空格
	function ignoreSpaces(string) {
	    var temp = "";
	    string = '' + string;
	    splitstring = string.split(" ");
	    for(i = 0; i < splitstring.length; i++)
	            temp += splitstring[i];
	    return temp;
	}
    var myURL_input = document.URL;
    domain_input = myURL_input.split('?');
    console.log(myURL_input)
    console.log(domain_input[0])

	//搜索  --子商户名称
	$("#search_button").click(function(){
	  location.href=domain_input[0]+'?str='+$("#search_str").val();
	});
	
	//搜索  --会员昵称搜索
	$("#search_button_members").click(function(){
	  location.href=domain_input[0]+'?str='+$("#search_str").val();
	});
	
	//搜索  --能量KTV管理员
	$("#search_button_ktvmanager").click(function(){
	  location.href=domain_input[0]+'?str='+$("#search_str").val();
	});
	
	//搜索  --能量KTV订单监测
	$("#search_button_order_ing").click(function(){
	  location.href=domain_input[0]+'?str='+$("#search_str").val();
	});
	
	//搜索  --商品名称搜索
	$("#search_button_goods").click(function(){
		console.log(111111)
	  location.href=domain_input[0]+'?str='+$("#search_str").val();
	});
	
	
	//搜索  --子商户管理员候选人
	$("#search_button_dsh_manerger").click(function(){
 	var a=domain_input[0].split("?shop_id=")
 
 	var b=domain_input[1].split("&")
	
   	var c=b[0].split("shop_id=")

	if(b[1]=="change_state=1"){

 		console.log(a[0]+'?shop_id='+c[1]+'&change_state=1&str='+$("#search_str").val())
//		return false
	    location.href=a[0]+'?shop_id='+c[1]+'&change_state=1&str='+$("#search_str").val()
	}else{

 		console.log(a[0]+'?shop_id='+c[1]+'&change_state=0&str='+$("#search_str").val())
//		return false
	    location.href=a[0]+'?shop_id='+c[1]+'&change_state=0&str='+$("#search_str").val()
	}
 	console.log(domain_input[0])
 	console.log(a[0]+'?shop_id='+c[1]+'&str='+$("#search_str").val())
 

	});
	
	//订单号码
	$("#search_button_order_num").click(function(){

if(myURL_input.indexOf("?")>-1){
	console.log("有问号")
	
	location.href=domain_input[0]+'?str='+$("#search_str").val()
}else{
	location.href=myURL_input+'?str='+$("#search_str").val()
}

	console.log(a[0]+'?str='+$("#search_str").val())
//	    location.href=a[0]+'?shop_id='+c[1]+'&change_state=1&str='+$("#search_str").val()
	});
	
	
	//导出
	$("#csv_button").click(function(){
		console.log(222)
	  location.href=domain_input[0]+'?csv=1'+'&date_1='+$("#st").val()+'&date_2='+$("#et").val();
	});
</script>

<script>

$(".edit_remark").click(function(){
	$("#add-event_1").click();	
	$("#text_remark").text($(this).attr("a"))
})
	
$(".change_price").click(function(){
	$("#add-event_2").click();	
	$("#order_num12138").val($(this).attr("a"))
	$("#price_old").val($(this).attr("b"))
})
	
$(".order_fahuo").click(function(){
	var that=this;	
	$.post('/adp.php/Order/ajax_kuaidi',{'order_num':$(this).attr("a")},function(order_form){	
	
		$("#order_num").val(order_form.order_num);
		$("#shouhuo_man").val(order_form.man_shouhuo);
		$("#shouhuo_phone").val(order_form.man_shouhuo);
		$("#man_address").val(order_form.man_address);

    },'json');
	
	$("#add-event_fahuo").click();	
	$("#order_num12138_fahuo").val($(this).attr("a"))
	$("#price_old_fahuo").val($(this).attr("b"))
})
</script>
<script>
	$("#div_submit").click(function(){
		if(!$("#change_price").val()){
			alert("请填写修改价格");
			return false;
		}

		$.post('/adpp.php/Order/change_price',{'order_num':$("#order_num12138").val(),'price':$("#change_price").val()},function(date){	
			if(date==1){
				$("#add-event_2").click();	
				$("#myModalLabel").text("设置成功")
				$("#add-event").click();
				setTimeout(function(){
					window.location.reload();
				},2000);
			}else{
				$("#myModalLabel").text("设置失败")
					$("#add-event").click();
			}
        },'json');
	})

</script>	
<script>
	//发货数据
	$("#div_submit_fahuo").click(function(){
		if($("#express_id").val()=="选择快递公司"){
			alert("选择快递公司");
			return false;
		}
		if($("#express_id").val()!=0){
			if(!$("#express_num").val()){
			alert("运单号不能为空");
			return false;
		}
		}
		
		$.post('/adp.php/Order/ajax_kd_submit',{'order_num':$("#order_num12138_fahuo").val(),'express_id':$("#express_id").val(),'express_num':$("#express_num").val()},function(date){	
			if(date==1){

				alert("发货成功");
			//	window.location.reload();
				window.location.href='/adp.php/Order/allder_shouhuo';
			}else{
				alert("发货失败");
			}
        },'json');
	})
</script>