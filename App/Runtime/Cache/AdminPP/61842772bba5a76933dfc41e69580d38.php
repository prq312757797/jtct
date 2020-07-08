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



		
<style>
	.feilei{
		margin-bottom: 4px;
		padding: 8px 35px 8px 14px;
		color: #468847;
		background-color: #dff0d8;
		border-color: #d6e9c6;
	}
	.feilei_2{
		margin-bottom: 4px;
		padding: 8px 35px 8px 14px;
		color: #468847;
		background-color: #e6e6e5;
		padding-left: 33px;
		border-color: #d6e9c6;
	}
	.function{
    padding: 6px;
    float: right;
    margin-right: 1%;
    margin-top: 1px;
	}
</style>
<div id="content">
	<div id="content-header">
		<h1>商品分类</h1>
	</div>
	<div id="breadcrumb">
		<a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 商品</a>
		<a href="#" class="current">商品分类</a>

		<button class="btn function" >分类级别：二级</button>
		<button class="btn function" id="btnExpand"><span>折叠所有</span><input type="hidden" value="1"></button>
		
		<a href="fenlei_add" class="add_button"><button class="btn" >添加新分类</button></a>
	</div>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
					<div class="widget-title">
								<span class="icon">
									<i class="icon-th"></i>
								</span>
						<h5>商品分类</h5>
					</div>
					<?php if(is_array($fenlei)): foreach($fenlei as $key=>$v): ?><div class="widget-content nopadding">
						
							<div class="feilei">
								<strong><i class="icon-minus is_show_child"></i> [ID: <?php echo ($v["id"]); ?>] <?php echo ($v["title"]); ?></strong>
							
								
									<?php if(($program_id == JT201808090855119076) |$program_id == JT201806151732369242|$program_id == JT201810111844206577): ?><a class="btn btn-default" style="float: right; margin-top: -5px;"  title="删除" alt="删除"  onclick="if(confirm('主营分类无法删除')==false)return false;"><i class="icon icon-trash"></i> </a>									
									
									<?php else: ?>
										<a class="btn btn-default" style="float: right; margin-top: -5px;"  title="删除" alt="删除"  href="fenlei_delete/id/<?php echo ($v['id']); ?>"><i class="icon icon-trash"></i> </a><?php endif; ?>
									<a class="btn btn-default" style="float: right; margin-top: -5px;"  title="添加" alt="添加" href="fenlei_add02/id/<?php echo ($v['id']); ?>" ><i class="icon icon-plus"></i></a>
									<a class="btn btn-default" style="float: right; margin-top: -5px;"  title="修改" alt="修改" href="fenlei_edit/id/<?php echo ($v['id']); ?>" ><i class="icon icon-list-alt"></i></a>


								<?php if($v["is_show"] == 1): ?><span class="peng_is_ok peng_ok" style="float: right;margin-right: 12px;">上架</span><?php endif; ?>
								<?php if($v["is_show"] == 2): ?><span class="peng_is_ok peng_not" style="float: right;margin-right: 12px;">下架</span><?php endif; ?>
							</div>
							<?php if(is_array($v['child'])): foreach($v['child'] as $k=>$vo): ?><div class="feilei_2 show02" >
								<input type="hidden" value="2">
								<!--<?php echo ($v['child'][$k]['image_1']); ?>-->
								<?php if(!empty($vo['image_1'])): ?><!--<img src="/Uploads/<?php echo ($vo["image_1"]); ?>" style="width:30px;height:30px;">--><?php endif; ?>
								<strong>[ID: <?php echo ($vo["id"]); ?>] <?php echo ($vo["title"]); ?>  </strong>
								<a class="btn btn-default" style="float: right; margin-top: -5px;"  title="删除" alt="删除" href="fenlei_delete02/id/<?php echo ($vo['id']); ?>" onclick="if(confirm('确认删除吗？')==false)return false;"><i class="icon icon-trash"></i> </a>
								<a class="btn btn-default" style="float: right; margin-top: -5px;"  title="修改" alt="修改" href="fenlei_edit/id/<?php echo ($vo['id']); ?>" ><i class="icon icon-list-alt"></i></a>
								<?php if($v["is_show"] == 1): ?><span class="peng_is_ok peng_ok" style="float: right;margin-right: 51px;">上架</span><?php endif; ?>
								<?php if($v["is_show"] == 2): ?><span class="peng_is_ok peng_not" style="float: right;margin-right: 51px;">下架</span><?php endif; ?>
							</div><?php endforeach; endif; ?>
						</div><?php endforeach; endif; ?>
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
	//点击主分类控制是否显示子分类
	$(".is_show_child").click(function(){
		
		var change=$(this).parents('div.nopadding').children('div.show02');
		var change_num=change.children('input').val();
		if(change_num==1){
			change.css("display","block");
			change.children('input').val("2");
		}else if(change_num==2){
			change.css("display","none");
			change.children('input').val("1");
			
		}
	
	})
	
	//控制所有子类 展开 关闭
	$("#btnExpand").click(function(){
		var action_all=$(this).children('input').val();

		if(action_all=="1"){
		
			$(".show02").css("display","none");
			$(".show02").children('input').val("1");
			
			$(this).children('span').text("显示所有");
			$(this).children('input').val("2");
			
		}else {
		
			$(".show02").css("display","block");
			$(".show02").children('input').val("2");
			
			
			$(this).children('span').text("折叠所有");
			$(this).children('input').val("1");
			
		}
		
	})
</script>