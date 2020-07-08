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
				<li ><a href="<?php echo U('Distribution/index');?>"><i class="icon icon-shopping-cart"></i>
					<span>分销商管理</span></a></li>
				<!--<li ><a href="<?php echo U('Distribution/fx_trend');?>"><i class="icon icon-shopping-cart"></i>
					<span>分销商增长趋势</span></a></li>-->
				<li><a href="<?php echo U('Distribution/fx_lever');?>"><i class="icon icon-shopping-cart"></i>
					<span>分销佣金管理</span></a></li>
				<li><a href="<?php echo U('Distribution/fx_order');?>"><i class="icon icon-shopping-cart"></i>
					<span>分销订单</span></a></li>

				<?php if($program_id == JT201712021113483120): ?><li><a href="<?php echo U('Distribution/man_contect');?>"><i class="icon icon-shopping-cart"></i>
						<span>代理关系管理</span></a></li><?php endif; ?>

		<!--		<li ><a href="<?php echo U('Distribution/index');?>"><i class="icon icon-shopping-cart"></i>
					<span>分销商统计</span></a></li>
				<li><a href="<?php echo U('Distribution/contect');?>"><i class="icon icon-shopping-cart"></i>
					<span>分销关系</span></a></li>-->

				<!--提现申请-->
				<li class="submenu open">
					<a href="<?php echo U('Distribution/cash_ing');?>"><i class="icon icon-th-list"></i> 
						<span>提现申请</span> <span class="label">4</span></a>
					<ul>
						<li><a href="<?php echo U('Distribution/cash_ing');?>">
							<span>待审核的</span>
						</a></li>
						<li><a href="<?php echo U('Distribution/cash_git');?>">
							<span>待打款的</span>
						</a></li>
						<li><a href="<?php echo U('Distribution/cash_done');?>">
							<span>已打款的</span>
						</a></li>
						<li><a href="<?php echo U('Distribution/cash_none');?>">
							<span>无效的</span>
						</a></li>
					</ul>
				</li>

				<li><a href="<?php echo U('Distribution/cash_set');?>"><i class="icon icon-shopping-cart"></i>
					<span>基础设置</span></a></li>

		<!--		<li><a href="<?php echo U('Distribution/shanxuan');?>"><i class="icon icon-shopping-cart"></i>
					<span>联系方式</span></a></li>
				<li><a href="<?php echo U('Distribution/biaoqian');?>"><i class="icon icon-shopping-cart"></i>
					<span>平台联系</span></a></li>-->

			</ul>


		</div>
<div id="content">
	<div id="content-header">
		<h1>分销佣金设置管理</h1>
	</div>
	<div id="breadcrumb">
		<a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 分销系统</a>
		<a href="#" class="current">分销佣金管理</a>

		<a href="fx_lever_add" class="add_button"><button class="btn" >+添加新等级</button></a>
	</div>
	<div class="container-fluid">
<?php if($program_id == JT201712021113483120): ?><!--蔡氏养生发展下线分销-->		
		<div class="text_t pd_35 pt_5" style="    color: #a94442;background-color: #f2dede;border-color: #ebccd1;padding: 9px;margin-bottom: -16px;border: 1px solid transparent;border-radius: 4px;">
   			 提示: 点击金额进行编辑，点击金额以外内容，完成编辑。
		</div><?php endif; ?>		
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
					<div class="widget-title">
								<span class="icon">
									<i class="icon-th"></i>
								</span>
						<h5>分销佣金设置管理</h5>
					</div>
					<div class="widget-content nopadding">
<?php if($program_id == JT201712021113483120): ?><!--蔡氏养生发展下线分销-->
	<!--蔡氏养生发展下线分销-->
<style>
	td{
		    border: 1px solid;
		    padding: 17px 24px;
		    text-align: center;
		    width: 6%;
	}
	.sort_text{
		width: 80px;text-align: center;    margin-left: auto;margin-right: auto;
	}
</style>
<table style="margin-top:2px;">
	<tr > 
		<td style="font-size:18px;">一级分销佣金（元）</td>
		<td>初级代理消费</td>
		<td>中级代理消费</td>
		<td>高级代理消费</td>
	</tr>
	<tr> 
		<td>初级代理</td>
		<td>
			<a  href="javascript:;" val="<?php echo ($list["0"]["id"]); ?>" text_name="price_fy" class="edit_text"><?php echo ($list["0"]["price_fy"]); ?></a>
		 	<input type="text" class="sort_text" value="<?php echo ($list["0"]["price_fy"]); ?>" style="display:none;">
		</td>
		<td>
			<a  href="javascript:;" val="<?php echo ($list["1"]["id"]); ?>" text_name="price_fy" class="edit_text"><?php echo ($list["1"]["price_fy"]); ?></a>
		 	<input type="text" class="sort_text" value="<?php echo ($list["1"]["price_fy"]); ?>" style="display:none;" >
		</td>
		<td>
			<a  href="javascript:;" val="<?php echo ($list["2"]["id"]); ?>" text_name="price_fy" class="edit_text"><?php echo ($list["2"]["price_fy"]); ?></a>
		 	<input type="text" class="sort_text" value="<?php echo ($list["2"]["price_fy"]); ?>" style="display:none;" >
		</td>
	</tr>
	<tr> 
		<td>中级代理</td>
		<td>
			<a  href="javascript:;" val="<?php echo ($list["3"]["id"]); ?>" text_name="price_fy" class="edit_text"><?php echo ($list["3"]["price_fy"]); ?></a>
		 	<input type="text" class="sort_text" value="<?php echo ($list["3"]["price_fy"]); ?>" style="display:none;" >
		</td>
		<td>
			<a  href="javascript:;" val="<?php echo ($list["4"]["id"]); ?>" text_name="price_fy" class="edit_text"><?php echo ($list["4"]["price_fy"]); ?></a>
		 	<input type="text" class="sort_text" value="<?php echo ($list["4"]["price_fy"]); ?>" style="display:none;" >
		</td>
		<td>
			<a  href="javascript:;" val="<?php echo ($list["5"]["id"]); ?>" text_name="price_fy" class="edit_text"><?php echo ($list["5"]["price_fy"]); ?></a>
		 	<input type="text" class="sort_text" value="<?php echo ($list["5"]["price_fy"]); ?>" style="display:none;" >
		</td>
	</tr>
	<tr> 
		<td>高级代理</td>
		<td>
			<a  href="javascript:;" val="<?php echo ($list["6"]["id"]); ?>" text_name="price_fy" class="edit_text"><?php echo ($list["6"]["price_fy"]); ?></a>
		 	<input type="text" class="sort_text" value="<?php echo ($list["6"]["price_fy"]); ?>" style="display:none;" >
		</td>
		<td>
			<a  href="javascript:;" val="<?php echo ($list["7"]["id"]); ?>" text_name="price_fy" class="edit_text"><?php echo ($list["7"]["price_fy"]); ?></a>
		 	<input type="text" class="sort_text" value="<?php echo ($list["7"]["price_fy"]); ?>" style="display:none;" >
		</td>
		<td>
			<a  href="javascript:;" val="<?php echo ($list["8"]["id"]); ?>" text_name="price_fy" class="edit_text"><?php echo ($list["8"]["price_fy"]); ?></a>
		 	<input type="text" class="sort_text" value="<?php echo ($list["8"]["price_fy"]); ?>" style="display:none;" >
		</td>
	</tr>
</table>

<table style="margin-top:12px;">
	<tr> 
		<td style="font-size:18px;">二级分销佣金（元）</td>
		<td>初级代理消费</td>
		<td>中级代理消费</td>
		<td>高级代理消费</td>
	</tr>
	<tr> 
		<td>初级代理</td>
		<td>
			<a  href="javascript:;" val="<?php echo ($list["9"]["id"]); ?>" text_name="price_fy" class="edit_text"><?php echo ($list["9"]["price_fy"]); ?></a>
		 	<input type="text" class="sort_text" value="<?php echo ($list["9"]["price_fy"]); ?>" style="display:none;" >
		</td>
		<td>
			<a  href="javascript:;" val="<?php echo ($list["10"]["id"]); ?>" text_name="price_fy" class="edit_text"><?php echo ($list["10"]["price_fy"]); ?></a>
		 	<input type="text" class="sort_text" value="<?php echo ($list["10"]["price_fy"]); ?>" style="display:none;" >
		</td>
		<td>
			<a  href="javascript:;" val="<?php echo ($list["11"]["id"]); ?>" text_name="price_fy" class="edit_text"><?php echo ($list["11"]["price_fy"]); ?></a>
		 	<input type="text" class="sort_text" value="<?php echo ($list["11"]["price_fy"]); ?>" style="display:none;" >
		</td>
	</tr>
	<tr> 
		<td>中级代理</td>
		<td>
			<a  href="javascript:;" val="<?php echo ($list["12"]["id"]); ?>" text_name="price_fy" class="edit_text"><?php echo ($list["12"]["price_fy"]); ?></a>
		 	<input type="text" class="sort_text" value="<?php echo ($list["12"]["price_fy"]); ?>" style="display:none;" >
		</td>
		<td>
			<a  href="javascript:;" val="<?php echo ($list["13"]["id"]); ?>" text_name="price_fy" class="edit_text"><?php echo ($list["13"]["price_fy"]); ?></a>
		 	<input type="text" class="sort_text" value="<?php echo ($list["13"]["price_fy"]); ?>" style="display:none;" >
		</td>
		<td>
			<a  href="javascript:;" val="<?php echo ($list["14"]["id"]); ?>" text_name="price_fy" class="edit_text"><?php echo ($list["14"]["price_fy"]); ?></a>
		 	<input type="text" class="sort_text" value="<?php echo ($list["14"]["price_fy"]); ?>" style="display:none;" >
		</td>
	</tr>
	<tr> 
		<td>高级代理</td>
		<td>
			<a  href="javascript:;" val="<?php echo ($list["15"]["id"]); ?>" text_name="price_fy" class="edit_text"><?php echo ($list["15"]["price_fy"]); ?></a>
		 	<input type="text" class="sort_text" value="<?php echo ($list["15"]["price_fy"]); ?>" style="display:none;" >
		</td>
		<td>
			<a  href="javascript:;" val="<?php echo ($list["16"]["id"]); ?>" text_name="price_fy" class="edit_text"><?php echo ($list["16"]["price_fy"]); ?></a>
		 	<input type="text" class="sort_text" value="<?php echo ($list["16"]["price_fy"]); ?>" style="display:none;" >
		</td>
		<td>
			<a  href="javascript:;" val="<?php echo ($list["17"]["id"]); ?>" text_name="price_fy" class="edit_text"><?php echo ($list["17"]["price_fy"]); ?></a>
		 	<input type="text" class="sort_text" value="<?php echo ($list["17"]["price_fy"]); ?>" style="display:none;" >
		</td>
	</tr>
</table>

	
	<?php else: ?>
							<table class="table table-bordered table-striped">
							<thead>
							<tr>
								<th>等级名称</th>
								<th>一级佣金比例</th>
								<th>二级佣金比例</th>
								<th>升级条件</th>
								<th>操作</th>
							</tr>
							</thead>
							<tbody>
							<?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
									<td><?php echo ($v["title"]); ?></td>
									<td><?php echo ($v["bl_lever_1"]); ?></td>
									<td><?php echo ($v["bl_lever_2"]); ?></td>
									<td><?php echo ($v["默认等级"]); ?></td>
									
									<td>
										<button class="btn btn-default">
											<a  title="编辑" alt="编辑" href="fx_lever_edit/id/<?php echo ($v['id']); ?>" >编辑</a>
										</button>
	<?php if(($program_id != JT201803151807521312) and $program_id != JT201710101645145951): if($v["cannot_d"] != 1): ?><button class="btn btn-danger">
												
													<a style="color:white;"  title="删除" alt="删除" href="fx_lever_delete/id/<?php echo ($v['id']); ?>" onclick="if(confirm('确认删除吗？')==false)return false;">删除</a>
													
											</button><?php endif; endif; ?>
									</td>
								</tr><?php endforeach; endif; ?>
							</tbody>
						</table><?php endif; ?>
						
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

	//异步列表页的内容     ==============================================

	$(".edit_text").click(function(){
		var self_input=$(this).parent('td').children('input')
		var that=this

		$(this).css("display","none");
		self_input.css("display","block");
		self_input.focus();
		self_input.blur(function(){
			//异步修改排序
			$(that).text(self_input.val());
			$(that).css("display","block");
			self_input.css("display","none");
			 $.post('/adp.php/Distribution/ajax_change_text',{'style':1,'text_name':$(that).attr("text_name"),'id':$(that).attr("val"),'text_val':self_input.val()},function(date){
	        if(date==1){
//	        	alert("成功");
//	        	location.reload();
					$("#myModalLabel").text("修改成功")
					$("#add-event").click();
	        }else{
	        	
	        }
        },'json');
		});
	})
</script>