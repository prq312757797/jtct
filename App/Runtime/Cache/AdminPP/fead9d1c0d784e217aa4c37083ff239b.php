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
		<h1>分销商管理</h1>
	</div>
	<div id="breadcrumb">
		<a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 分销系统</a>
		<a href="#" class="current">分销商管理</a>

	</div>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
					<div class="widget-title">
								<span class="icon">
									<i class="icon-th"></i>
								</span>
						<h5>分销商管理</h5>
					</div>
					<div class="widget-content nopadding">
						<table class="table table-bordered table-striped">
							<thead>
							<tr>
								<th><input type="checkbox"></th>
								<th >粉丝</th>
								<th>姓名 / 手机号码</th>
								<th>等级</th>
								<th>累计佣金 / 打款佣金</th>
								
								<th>上级分销商</th>
								<th>下级分销商</th>
								<th>注册时间</th>
								<?php if($program_id != JT201803151807521312): ?><th>审核时间</th>
								<?php else: ?>
								<th>沙田荣誉证书</th>
								<th>公益荣誉证书</th><?php endif; ?>
								<th>状态</th>
								<th>清除分销状态</th>
								<?php if($program_id == JT201803151807521312): ?><th>操作</th><?php endif; ?>
							</tr>
							</thead>
							<tbody>
							<?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
									<td><input value="<?php echo ($v["members_id"]); ?>" type="checkbox"></td>
									<td style="text-align:left!important;">
										<img src="<?php echo ($v["members_head"]); ?>" style="width:30px;height:30px;padding1px;border:1px solid #ccc">
				                          <?php echo ($v["members_nickname"]); ?>
									</td>
									<td>
										<?php echo ($v["realname"]); ?> / <?php echo ($v["tel"]); ?>
									</td>
									<td><?php echo ($v["fx_lever_title"]); ?></td>
									<td>0<br>0</td>
									<td>  <?php if($v['fx_uid'] == 0): ?>总店<?php else: ?>
										<?php echo ($v["up_nickname"]); ?><br>
										<a class="btn btn-default" title="修改" alt="修改"  href="gaishagnxian/id/<?php echo ($v['members_id']); ?>" onclick="if(confirm('确认更换该会员呢上线？')==false)return false;">
											点击更换
										</a><?php endif; ?> 
									</td>
									<td>  <?php echo ($v["child_count"]); ?> </td>
									<td>
										<?=date("Y-m-d",$v['fx_time_registe']);?><br> <?=date("H:i:s",$v['fx_time_registe']);?>
									</td>
									<td>
										<?php if($program_id != JT201803151807521312): if(!empty($v['fx_time_agree'])): ?><?=date("Y-m-d",$v['fx_time_agree']);?><br> <?=date("H:i:s",$v['fx_time_agree']); endif; ?>
											<?php else: ?>
											<?php if(empty($v['reward_info']['honor_image'])): ?>未发放
												<?php else: ?>
										
												<img src="/Uploads/<?php echo ($v['reward_info']['honor_image']); ?>" style="width:30px;height:30px;padding1px;border:1px solid #ccc"><?php endif; endif; ?>
									</td>
<!--									
									<td>
										<?php if($program_id == JT201803151807521312): if(empty($v['reward_info']['honor_image_welfare'])): ?>未发放
												<?php else: ?>
										
												<img src="/Uploads/<?php echo ($v['reward_info']['honor_image_welfare']); ?>" style="width:30px;height:30px;padding1px;border:1px solid #ccc"><?php endif; endif; ?>
									</td>-->
									<td>
			                            <?php if($v["fx_state"] == 1): ?><a class="btn btn-default" title="修改" alt="修改"  href="shenhe/id/<?php echo ($v['members_id']); ?>" onclick="if(confirm('确认通过审核吗？')==false)return false;">
												点击审核
											</a><?php endif; ?>
			                            <?php if($v["fx_state"] == 2): ?><span class="label label-success fx_state"  a="<?php echo ($v["members_id"]); ?>" b="<?php echo ($v["fx_state"]); ?>" data-toggle="ajaxSwitch" data-confirm="确认要取消审核?">
													  已审核
			                           		 </span><?php endif; ?>
			                            <?php if($v["fx_state"] == 3): ?><span class="label label-success fx_state" a="<?php echo ($v["members_id"]); ?>" b="<?php echo ($v["fx_state"]); ?>" data-toggle="ajaxSwitch" data-confirm="确认要取消审核?">
													  停用
			                           		 </span><?php endif; ?>
				                         
									</td>
									<td>
										
			                           	<a class="btn btn-default" title="修改" alt="修改" href="del_dfx_identy/id/<?php echo ($v['members_id']); ?>" >
											清除分销
										</a>
									</td>
									<?php if($program_id == JT201803151807521312): ?><td style="overflow:visible;">
											<div class="btn-group btn-group-sm">
												<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="javascript:;">操作 <span class="caret"></span></a>
												<ul class="dropdown-menu dropdown-menu-left" style="left:-75px;">
													<li><a href="javascript:" title="上传荣誉证书" onclick="show_modal(this)"   a="<?php echo ($v["members_openid"]); ?>">上传荣誉证书</a></li>
											</div>
										</td><?php endif; ?>
								</tr><?php endforeach; endif; ?>
							</tbody>
						</table>
						<div class="pages self_css" > <?php echo ($pages); ?> </div>
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
			.modal_label{
				width: 21%;
			    float: left;
			    text-align: center;
			    height: 30px;
			    line-height: 41px;
			}
		</style>

		<!-- 按钮触发模态框 -->
<a id="add-event" style="display:none;" data-toggle="modal" href="#modal-add-event" class="btn btn-success btn-mini"><i class="icon-plus icon-white"></i> 6666666666</a>
	<form  action="<?php echo U('Distribution/image_ajax');?>" enctype="multipart/form-data" method="post" >
		<div class="modal hide" id="modal-add-event">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3> 上传荣誉证书</h3>
			</div>
			<div class="modal-body">
				<div class="control-group">
					<label class="control-label modal_label">沙田荣誉证书：</label>
					<div class="controls">
						 <input type="file" name="image02" class="form-control">
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label modal_label">公益荣誉证书：</label>
					<div class="controls">
						 <input type="file" name="image03" class="form-control">
					</div>
				</div>
			</div>
			<input type="hidden" value="" id="openid" name="openid"> 
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">取消</a>
			
				<input type="submit" value="确认" class="btn btn-primary">
			</div>
		</div>
	</form>	
<script>

	function show_modal(item){
		$("#add-event").click();
		
		$("#openid").val($(item).attr("a"));
	}
</script> 


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