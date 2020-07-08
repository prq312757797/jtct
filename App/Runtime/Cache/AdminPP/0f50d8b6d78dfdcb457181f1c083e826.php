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
			<li ><a href="<?php echo U('Warehouse/canggui');?>"><i class="icon icon-shopping-cart"></i> 
					<span>仓柜管理</span></a></li>
			<li><a href="<?php echo U('Warehouse/gongying');?>"><i class="icon icon-shopping-cart"></i> 
					<span>供应商管理</span></a></li>
			<li><a href="<?php echo U('Warehouse/fenlei');?>"><i class="icon icon-shopping-cart"></i> 
					<span>分类管理</span></a></li>
			<!--<li><a href="<?php echo U('Warehouse/huishou');?>"><i class="icon icon-shopping-cart"></i> 
					<span>操作管理</span></a></li>-->
			<li class="submenu open">
					<a href="<?php echo U('Warehouse/w_0_all');?>"><i class="icon icon-th-list"></i> 
						<span>操作管理</span> <span class="label">7</span></a>
					<ul>
						<li><a href="<?php echo U('Warehouse/w_0_all');?>">
							<span>即时库存<span style="color:red;">  </span></span>
						</a></li>
						<li><a href="<?php echo U('Warehouse/w_1_ruku');?>">
							<span>入库单<span style="color:red;">  </span></span>
						</a></li>
						<li><a href="<?php echo U('Warehouse/w_2_chuku');?>">
							<span>出库单<span style="color:red;">  </span></span>
						</a></li>
						<li><a href="<?php echo U('Warehouse/w_3_tuiku');?>">
							<span>退库单<span style="color:red;">  </span></span>
						</a></li>
						<li><a href="<?php echo U('Warehouse/w_4_diaobo');?>">
							<span>调拨单<span style="color:red;"> </span></span>
						</a></li>
						<!--<li><a href="<?php echo U('Warehouse/w_5_baosun');?>">
							<span>报损单<span style="color:red;">  </span></span>
						</a></li>
						<li><a href="<?php echo U('Warehouse/w_6_pandian');?>">
							<span>盘点单<span style="color:red;">  </span></span>
						</a></li>-->
						<li><a href="<?php echo U('Warehouse/w_7_tuihuo');?>">
							<span>退货单<span style="color:red;">  </span></span>
						</a></li>
						<li><a href="<?php echo U('Warehouse/w_8_zhibo');?>">
							<span>直拨单<span style="color:red;"> </span></span>
						</a></li>
					</ul>
				</li>
				<li><a href="<?php echo U('Warehouse/w_all_goods');?>"><i class="icon icon-shopping-cart"></i> 
					<span>商品总览</span></a></li>
				<li><a href="<?php echo U('Warehouse/w_add_goods');?>"><i class="icon icon-shopping-cart"></i> 
					<span>商品添加</span></a></li>

		</ul>

</div>



		
<script src="/Public/ys0925/jquery.js"></script>
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
	.w93{
		width:93%!important;
	}
		input[type="text"]{
    margin-bottom: 5px;
	}
	td{
		padding:0!important;	
		line-height: 30px!important;
	}
	.f30{
		font-size: 30px;
	}
</style>

<div id="content">
	<div id="content-header">
		<h1>已审核<?php echo ($text); ?></h1>
	</div>
	<div id="breadcrumb">
		<a href="<?php echo U('Index/index');?>" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 首页</a>
		<a href="<?php echo U('Warehouse/canggui');?>" class="tip-bottom">仓柜管理</a>
		<a href="#" class="current">已审核<?php echo ($text); ?></a>
	</div>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
					<div class="widget-title">
								<span class="icon">
									<i class="icon-align-justify"></i>
								</span>
						<h5>已审核<?php echo ($text); ?></h5>
					<?php if(is_array($l2ist)): foreach($l2ist as $key=>$v): if(is_array($v['shenhe_info'])): foreach($v['shenhe_info'] as $key0=>$v0): ?>--<?php echo ($v0["goods_id"]); ?>--<?php endforeach; endif; endforeach; endif; ?>
					</div>
					<div class="widget-content nopadding">
						<table class="table table-bordered table-striped" style="    border-top: 1px solid #ccc;">
							<thead>
							<tr>
								
								<th style="width:10%;">单号</th>
								<th style="width:10%;">表单类型</th>
								<th style="width:10%;">条目数</th>
								<th style="width:10%;">提交时间</th>
								<th style="width:10%;">审核时间</th>
								<!--<th style="width:10%;">操作</th>-->
							</tr>
							</thead>
							
							<tbody>
							<?php if(is_array($list)): foreach($list as $key=>$v): ?><tr class="list_click" ky=<?php echo ($key); ?>>
									<td><?php echo ($v["group_num"]); ?></td>
									<td>
										<?php if($v['action_state'] == 1): ?>入库单<?php endif; ?>	
										<?php if($v['action_state'] == 2): ?>出库单<?php endif; ?>
										<?php if($v['action_state'] == 3): ?>调拨单<?php endif; ?>
										<?php if($v['action_state'] == 4): ?>退库单<?php endif; ?>
										<?php if($v['action_state'] == 5): ?>退货单<?php endif; ?>
										<?php if($v['action_state'] == 6): ?>直拨单<?php endif; ?>
									</td>
									<td><?php echo ($v["count_num"]); ?></td>
									<td><?php  echo date("Y-m-d H:i:s",$v['time_set']);?></td>
									<td><?php  echo date("Y-m-d H:i:s",$v['time_shenhe']);?></td>
									<!--<td>
										<div class="btn btn-primary">通过审核</div>
										<div class="btn btn-primary">拒绝审核</div>
									</td>-->
								</tr><?php endforeach; endif; ?>
	
							</tbody>

						</table>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<!--原来的 modal 框位置-->



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
			.modal{
				    left: 35%!important;
				   width: 78%!important;
			}
		</style>

		<!-- 按钮触发模态框 -->
<a id="add-event_goods_into" style="display:none;" data-toggle="modal" href="#modal-add-event_goods_into" class="btn btn-success btn-mini"><i class="icon-plus icon-white"></i> </a>
		<div class="modal hide" id="modal-add-event_goods_into">
	
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3> 表单列表</h3>
			</div>
			<div class="modal-body">
				<?php if(is_array($list)): foreach($list as $ky=>$v): ?><table class="table table-bordered table-striped tr_shenhe_info" style="display:none; border-top: 1px solid #ccc;" id="tr_shenhe_info_<?php echo ($ky); ?>" >
					<thead>
					<tr>
						<?php if($v['action_state'] == 1): ?><th style="width:10%;">供应商</th>
							<th style="width:10%;">入仓</th><?php endif; ?>	
						<?php if($v['action_state'] == 2): ?><th style="width:10%;">入仓</th><?php endif; ?>
						<?php if($v['action_state'] == 3): ?><th style="width:10%;">出仓</th>
							<th style="width:10%;">入仓</th><?php endif; ?>	
						<?php if($v['action_state'] == 4): ?><th style="width:10%;">出仓</th>
							<th style="width:10%;">入仓</th><?php endif; ?>	
						<?php if($v['action_state'] == 5): ?><th style="width:10%;">出仓</th><?php endif; ?>	
						<?php if($v['action_state'] == 6): ?><th style="width:10%;">入仓</th><?php endif; ?>	
						
					
						<th style="width:10%;">商品名称</th>
						<th style="width:10%;">数量</th>
						<th style="width:10%;">提交时间</th>
					</tr>
					</thead>

					<tbody > 
						<?php if(is_array($v['shenhe_info'])): foreach($v['shenhe_info'] as $key0=>$v0): ?><tr >
							<?php if($v['action_state'] == 1): ?><td><?php echo ($v0["supplier"]); ?></td>
								<td><?php echo ($v0["warehouse"]); ?></td><?php endif; ?>	
							<?php if($v['action_state'] == 2): ?><td><?php echo ($v0["warehouse"]); ?></td><?php endif; ?>	
							<?php if($v['action_state'] == 3): ?><td><?php echo ($v0["warehouse_ru"]); ?></td>
								<td><?php echo ($v0["warehouse"]); ?></td><?php endif; ?>	
							<?php if($v['action_state'] == 4): ?><td><?php echo ($v0["warehouse_ru"]); ?></td>
								<td><?php echo ($v0["warehouse"]); ?></td><?php endif; ?>	
							<?php if($v['action_state'] == 5): ?><td><?php echo ($v0["warehouse_ru"]); ?></td><?php endif; ?>	
							<?php if($v['action_state'] == 6): ?><td><?php echo ($v0["warehouse"]); ?></td><?php endif; ?>
							<td><?php echo ($v0["goods_title"]); ?></td>
							<td><?php echo ($v0["num"]); ?></td>
							<td><?php echo date("Y-m-d H:i:s",$v0['time_set']); ?></td>
						</tr><?php endforeach; endif; ?>
					</tbody>
			
				</table><?php endforeach; endif; ?>
			</div>
		
			<div class="modal-footer">
				<input type="hidden" id="action_state" value="<?php echo ($v['action_state']); ?>">
				<a href="#" class="btn" data-dismiss="modal">关闭</a>
				<?php if(empty($done)): if(is_array($list)): foreach($list as $ky=>$v): ?><input type="submit" value="通过审核" class="btn btn-primary submit_show only_class_<?php echo ($ky); ?> div_submit_shenhe" sid="<?php echo ($v["group_num"]); ?>" state="ok"  style="display:none;float: right;">
					<input type="submit" value="拒绝审核" class="btn btn-primary submit_show only_class_<?php echo ($ky); ?> div_submit_shenhe" sid="<?php echo ($v["group_num"]); ?>" state="no"  style="display:none;float: right;"><?php endforeach; endif; endif; ?>
			</div>
		</div>

			
			 
	<script>
	$(".list_click").click(function(){
	//	alert($(this).attr("ky"))
		$("#add-event_goods_into").click();	
		$(".tr_shenhe_info").css("display","none")
		$("#tr_shenhe_info_"+$(this).attr("ky")).css("display","block")
	
	
		$(".submit_show").css("display","none")
		$(".only_class_"+$(this).attr("ky")).css("display","block")
		
	})

//	审核操作
$(".div_submit_shenhe").click(function(){
	console.log($(this).attr("sid"))
	console.log($(this).attr("state"))
	
			var data={
			'state':1,
			'group_num':$(this).attr("sid"),
			'ok_no':$(this).attr("state"),

		}
	$.post('/adp.php/Warehouse/shenhe',data,function(data){
	        if(data==1){
	        	alert("操作成功");
	        	location.reload()
	        }else{
	        	alert("操作失败");
	        }
        },'json');
})
	</script>