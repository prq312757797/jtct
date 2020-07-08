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



		

<div id="content">
	<div id="content-header">
		<h1>商品管理</h1>
	</div>
	<div id="breadcrumb">
		<a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 商品</a>
		<a href="#" class="current">商品管理</a>
		<button id="search_button_goods" class="btn" style="float: right;margin-top: 3px;margin-left: -3px;margin-right: 22px;" >搜索</button>
		<input type="text" placeholder="商品名称" value="<?php echo ($his_str); ?>" id="search_str" style="float: right;margin-top: 3px;" onBlur="this.value=ignoreSpaces(this.value);">
		 <a href="/adp.php/Goods/goods_add_ktv" class="add_button"><button class="btn" >+添加商品</button></a>
	</div>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
					<div class="widget-title">
						<span class="icon">
							<i class="icon-th"></i>
						</span>
						<h5>商品管理</h5>
					</div>
					<div class="widget-content nopadding">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th style="width:5%;">编号</th>
									<th style="width:5%;">排序</th>
									<th style="width:10%;">商品名称</th>
									<th style="width:5%;">图片</th>
									<?php if($program_id == JT201810111844206577): ?><th style="width:10%;">工价</th>
						            	<th style="width:5%;">克重</th>
						            	<!--<th style="width:5%;">当前价格</th>  -->
						            	<?php else: ?>
						            	<th style="width:5%;">价格</th><?php endif; ?>
									
									
									<?php if($program_id == JT201806151732369242): ?><th style="width:5%;">需要积分</th><?php endif; ?>
						            <?php if($program_id != JT201808090855119076): ?><th style="width:5%;">库存</th>
									<th style="width:5%;">销量</th><?php endif; ?>
									<th style="width:5%;">状态</th>
									<?php if($program_id == JT201808090855119076): ?><th style="width:5%;">首页预约</th><?php endif; ?>
									<?php if($program_id == JT201810111844206577): ?><th style="width:5%;">城市推送</th><?php endif; ?>
									<th style="width:17%;">操作</th>
									<?php if($program_id == JT201803151807521312): ?><th style="width:5%;">个人零售是否开启</th>
										<th style="width:5%;">推荐入口商品</th><?php endif; ?>
						            <?php if($program_id == JT201711031347219168): ?><th style="width:5%;">设置消费码消费</th><?php endif; ?>
								</tr>
							</thead>
							<tbody>
								<?php if(is_array($goods)): foreach($goods as $key=>$v): ?><tr>
									<td class="l_h30"><?php echo ($v["id"]); ?></td>
									<td class="l_h30">
										<a  href="javascript:;" val="<?php echo ($v["id"]); ?>" text_name="sort" class="edit_text"><?php echo ($v["sort"]); ?></a>
					 					<input type="text" class="sort_text w40x" value="<?php echo ($v["sort"]); ?>" style="display:none;">
									</td>
									<td class="l_h30">
										<a  href="javascript:;" val="<?php echo ($v["id"]); ?>" text_name="goods_title" class="edit_text"><?php echo ($v["goods_title"]); ?></a>
									 	<input type="text" class="sort_text w120x" value="<?php echo ($v["goods_title"]); ?>" style="display:none;">
									</td>
									<td>
									 	<img style="width:55px;height:55px;" src="/Uploads/<?php echo ($v["image"]); ?>">
									</td>
								
									<?php if($program_id == JT201810111844206577): ?><td>
						            		游客工价：<?php echo ($v["price_sell_1"]); ?><br>会员工价：<?php echo ($v["price_sell_2"]); ?>
						            	</td>
						            	
						            	<td><?php echo ($v["kezhong"]); ?></td>
						            	<!--<td>
						            		<?php echo ($v['price_sell_1']*$v["kezhong"]); ?>
						            	</td>-->
						            	
						            	<?php else: ?>
						            	<td class="l_h30">
										  	<a  href="javascript:;" val="<?php echo ($v["id"]); ?>" text_name="price_sell" class="edit_text"><?php echo ($v["price_sell"]); ?></a>
										 	<input type="text" class="sort_text  w80x" value="<?php echo ($v["price_sell"]); ?>" style="display:none;">																						 
										</td><?php endif; ?>
									
									<?php if($program_id == JT201806151732369242): ?><td class="l_h30">
						            		<?php if($v['is_on_mixpay'] == 1): ?><a  href="javascript:;" val="<?php echo ($v["id"]); ?>" text_name="integral_sell" class="edit_text"><?php echo ($v["integral_sell"]); ?></a>
										 		<input type="text" class="sort_text  w80x" value="<?php echo ($v["integral_sell"]); ?>" style="display:none;">																						 
									
						            			<?php else: ?>
						            			关闭<?php endif; ?>
						            		
										  	</td><?php endif; ?>
						            <?php if($program_id != JT201808090855119076): ?><td class="l_h30">
									   	<a  href="javascript:;" val="<?php echo ($v["id"]); ?>" text_name="number" class="edit_text"><?php echo ($v["number"]); ?></a>
									 	<input type="text" class="sort_text  w50x" value="<?php echo ($v["number"]); ?>" style="display:none;">											
									</td>
									<td class="l_h30">
									  	<a  href="javascript:;" val="<?php echo ($v["id"]); ?>" text_name="sell_num" class="edit_text"><?php echo ($v["sell_num"]); ?></a>
									 	<input type="text" class="sort_text w50x" value="<?php echo ($v["sell_num"]); ?>" style="display:none;">
									</td><?php endif; ?>  
									  
									 <td class="l_h30">
									 	<?php if($v["goods_state"] == 1): ?><div class="peng_is_ok peng_ok" style="margin-top:15px;">
									 			<input type="hidden" value="<?php echo ($v["id"]); ?>">
									 			<span>上架</span>
									 		</div><?php endif; ?>
									 	<?php if($v["goods_state"] == 3): ?><div class="peng_is_ok peng_not"  style="margin-top:15px;">
									 			<input type="hidden" value="<?php echo ($v["id"]); ?>">
									 			<span>下架</span>
									 		</div><?php endif; ?>
									 </td>
									 <?php if($program_id == JT201808090855119076): ?><td class="l_h30">
									 	<?php if($v["index_choose"] == 1): ?><div class="peng_is_ok_2 peng_ok" style="margin-top:12px;border-radius: 3px;">
									 			<input type="hidden" value="<?php echo ($v["id"]); ?>">
									 			<span>已设置</span>
									 		</div><?php endif; ?>
									 	<?php if($v["index_choose"] == 0): ?><div class="peng_is_ok_2 peng_not"  style="margin-top:12px;border-radius: 3px;">
									 			<input type="hidden" value="<?php echo ($v["id"]); ?>">
									 			<span>已取消</span>
									 		</div><?php endif; ?>
									 </td><?php endif; ?>
									 <style>
									 	.area_re{
									 		border: 1px solid #ccc;
										    padding: 5px;
										    border-radius: 4px;
										    position: relative;
										    top: 8px;
										    left: 1px;
									 	}
									 </style>
									 
									 <?php if($program_id == JT201810111844206577): ?><td class="hover_show"id="<?php echo ($v["id"]); ?>">
						            		<?php if(empty($v['area_re'])): ?>未推送
						            			<?php else: ?>
						            			
						            			<div id="area_text_<?php echo ($v["id"]); ?>" style="display:block;color:green;">点击查看</div>
						            			<div id="area_re_<?php echo ($v["id"]); ?>" style="display:none"><?php echo ($v["area_re"]); ?></div><?php endif; ?>
						            	</td><?php endif; ?>

									<td>
										<li>
										<?php if($program_id == JT201808090855119076): ?><a class="btn btn-default"  title="修改" alt="修改" href="/adp.php/Goods/goods_edit_ktv/id/<?php echo ($v['id']); ?>" >修改</a>
		                            	
											<?php else: ?>
											<a class="btn btn-default"  title="修改" alt="修改" href="goods_edit/id/<?php echo ($v['id']); ?>" >修改</a><?php endif; ?>	
											
										<a   class="btn btn-info" style="color:white;" title="回收" alt="回收" href="goods_huishou/id/<?php echo ($v['id']); ?>" onclick="if(confirm('确认移到回收站吗？')==false)return false;">放回收站</a>
										<!--<?php if($head_menu == 6): ?><div class="btn btn-default make_jingpin" a="<?php echo ($v["id"]); ?>" >
			                            		<div  href="goods_edit/id/<?php echo ($v['id']); ?>" >
			                            			<?php if($v['is_jingpin'] == 2): ?><span style="color:red;">设置精品</span><?php endif; ?>
			                            			<?php if($v['is_jingpin'] == 1): ?>取消精品<?php endif; ?>
			                            	</a>
			                            	</div><?php endif; ?>-->
		                            	</li>
		                            	
		                            	
		                            		<li class="m_goods">
		                            		
			                            		<input class="own_id" type="hidden" value="<?php echo ($v["id"]); ?>">
			                            		<a <?php if($v["goods_subtitle01"] == 1): ?>style="color:red;"<?php endif; ?> class="attribute" a="1"><?php echo ($index_recommend[0]); ?></a>
												<a <?php if($v["goods_subtitle02"] == 1): ?>style="color:red;"<?php endif; ?> class="attribute" a="2"><?php echo ($index_recommend[1]); ?></a>
												<a <?php if($v["goods_subtitle03"] == 1): ?>style="color:red;"<?php endif; ?> class="attribute" a="3"><?php echo ($index_recommend[2]); ?></a>
												<a <?php if($v["goods_subtitle04"] == 1): ?>style="color:red;"<?php endif; ?> class="attribute" a="4"><?php echo ($index_recommend[3]); ?></a>
												<a <?php if($v["goods_subtitle05"] == 1): ?>style="color:red;"<?php endif; ?> class="attribute" a="5"><?php echo ($index_recommend[4]); ?></a>
							                    
			                            	</li>
		                           
		                            	
			                            </td>
			                             <?php if($program_id == JT201803151807521312): ?><td>
											 	<?php if($v["person_sell"] == 1): ?><span>已设置</span><?php endif; ?>
											 	<?php if($v["person_sell"] == 0): ?><span>取消</span><?php endif; ?>
											 </td>
											  <td>
											 	<?php if($v["fx_entrance"] == 1): ?><span>已设置</span><?php endif; ?>
											 	<?php if($v["fx_entrance"] == 0): ?><span>取消</span><?php endif; ?>
											 </td><?php endif; ?>
										  <?php if($program_id == JT201711031347219168): ?><td>
											 	<?php if($v["is_use_consumption_num"] == 1): ?><span id="<?php echo ($v["id"]); ?>" class="change_state">已设置</span><?php endif; ?>
											 	<?php if($v["is_use_consumption_num"] == 0): ?><span id="<?php echo ($v["id"]); ?>" class="change_state">取消</span><?php endif; ?>
											 </td><?php endif; ?>
									</tr><?php endforeach; endif; ?>	 
								</tbody>
							</table>	
						</div>
					</div>
				<div class="pages self_css"> <?php echo ($pages); ?></div>
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
	//一部修改商品展示属性
	
	$(".attribute").click(function(){
		var onw_id=$(this).parent('li.m_goods').children('input').val();
		var that = this;
		 $.post('/adp.php/Goods/ajax_com_shuxing',{'id':onw_id,'position':$(this).attr("a")},function(ajax_back){
			console.log(ajax_back);
			if(ajax_back==1){
				$(that).css("color","red");
			}else if(ajax_back==2){
				$(that).css("color","");
			}
        },'json');
	})
</script>	
 <script>
    	$(".hover_show").hover(function() {
           console.log(111)
           var id=$(this).attr("id")
           console.log(id)
           $("#area_text_"+id).css("display","none")
           $("#area_re_"+id).css("display","block")
        }, function() {
            console.log(222)
           var id=$(this).attr("id")
           console.log(id)
           $("#area_text_"+id).css("display","block")
           $("#area_re_"+id).css("display","none")
        });

</script>
<script>
	
		//异步修改商品是否可以使用消费券
	$(".change_state").click(function(){
	
		//alert($(this).attr("a"));
		$.post('/adp.php/Goods/change_state',{'id':$(this).attr("id")},function(date){
	        if(date==1){
	        	alert("设置成功");
	        	window.location.reload();
	        }else{
	        	alert("操作过于频繁");
	        }
        },'json');
	})
</script>
<script>

	//异步列表页的内容     ==============================================
	//style   1:商品表内容
	$(".edit_text").click(function(){
		var self_input=$(this).parents('td').children('input')
		var that=this

		$(this).css("display","none");
		self_input.css("display","block");
		self_input.focus();
		self_input.blur(function(){

			$(that).text(self_input.val());
			$(that).css("display","block");
			self_input.css("display","none");
		
			$.post('/adp.php/Index/ajax_change_text',{'style':1,'text_name':$(that).attr("text_name"),'id':$(that).attr("val"),'text_val':self_input.val()},function(date){
		        if(date==1){
		        	alert("成功");
		        }else{
		        	
		        }
	        },'json');
		});
	})
</script> 
<script>
	//商品ajax上下架
	$(".peng_is_ok").click(function(){
		var onw_id=$(this).children('input').val();
	
		var that = this;
		$.post('/adp.php/Goods/ajax_change_ok',{'id':onw_id},function(date){
	        if(date==1){
	        	if($(that).attr("class")=="peng_is_ok peng_ok"){
	        		$(that).attr("class","peng_is_ok peng_not");
	        		$(that).children('span').text("下架");
	        	}else if($(that).attr("class")=="peng_is_ok peng_not"){
	        		$(that).attr("class","peng_is_ok peng_ok");
	        		$(that).children('span').text("上架");
	        	}
	        }else if(date==3){
	        	alert("推送审核商品无法上架");
	        }else {
	        	alert("操作过于频繁");
	        }
        },'json');
	})
		//商品ajax设置首页预约
	$(".peng_is_ok_2").click(function(){
		var onw_id=$(this).children('input').val();
	
		var that = this;
		$.post('/adp.php/Goods/ajax_change_ok_2',{'id':onw_id},function(date){
	        if(date==1){
	        	if($(that).attr("class")=="peng_is_ok_2 peng_ok"){
	        		$(that).attr("class","peng_is_ok_2 peng_not");
	        		$(that).children('span').text("已取消");
	        	}else if($(that).attr("class")=="peng_is_ok_2 peng_not"){
	        		$(that).attr("class","peng_is_ok_2 peng_ok");
	        		$(that).children('span').text("已设置");
	        	}
	        }else if(date==3){
	        	alert("推送审核商品无法上架");
	        }else {
	        	alert("操作过于频繁");
	        }
        },'json');
	})
</script>