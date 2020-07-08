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
			<li><a href="<?php echo U('Goods/fenlei');?>"><i class="icon icon-shopping-cart"></i> 
					<span>分类</span></a></li>
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
		<h1>商品分类管理</h1>
	</div>
	<div id="breadcrumb">
		<a href="<?php echo U('Goods/selling');?>" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>商品</a>
		<a href="<?php echo U('Goods/fenlei');?>" class="tip-bottom">商品分类</a>
		<a href="#" class="current">商品分类管理</a>
	</div>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
					<div class="widget-title">
								<span class="icon">
									<i class="icon-align-justify"></i>
								</span>
						<h5>商品分类管理</h5>
					</div>
					<div class="widget-content nopadding">
						<form action="<?php echo U('Goods/run_fenlei_add',array('id'=>$info['id']));?>" method="post" enctype="multipart/form-data" class="form-horizontal" />
						<?php if(empty($add_child)): if(empty($info['id'])): ?><input type="hidden" name="uid" value="0">
							<?php else: ?>
								<input type="hidden" name="uid" value="<?php echo ($info['uid']); ?>"><?php endif; ?>  
						<?php else: ?>
		                	<input type="hidden" name="uid" value="<?php echo ($add_child); ?>"><?php endif; ?> 
								
						<div class="control-group">
							<label class="control-label">排序</label>
							<div class="controls">
								<input type="text"  name="sort" value="<?php  echo empty($info['sort'])?1:$info['sort'];?>"/>
								<span class="help-block">数字越小，排名越靠前</span>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label">分类名称</label>
							<div class="controls">
								<input type="text" name="title" value="<?php echo ($info['title']); ?>" />
								<span class="help-block">商品分类名称</span>
							</div>
						</div>
<?php if($program_id == JT201805020920374826): ?><div class="control-group">
							<label class="control-label">英文名称</label>
							<div class="controls">
								<input type="text" name="title_english" value="<?php echo ($info['title_english']); ?>" />
								<span class="help-block"></span>
							</div>
						</div><?php endif; ?>
<?php if($program_id != JT201810111844206577): ?><div class="control-group ">
							<label class="control-label">分类图片</label>
							<div class="controls">
								<input type="text" value="<?php echo ($info['image_1']); ?>" id="image_name" />
								<span class="btn btn-success fileinput-button">
										            <span>上传</span>
										            <input type="file" name="image02" id="doca"  onchange="javascript:setImagePreviews();">
										       </span>

								<div class="help-block bd_gray mt15 w81 b_r_4 max_h_165 " style="display:none;" id="image_area">
									<img class="h_92 p_1" src="" id="loc_img" />
								</div>

							</div>
						</div>
						<div class="control-group">
							<label class="control-label">分类描述</label>
							<div class="controls">
								<textarea type="text" name="miaoshu"  ><?php echo ($info['title']); ?></textarea>
								<span class="help-block">分类描述</span>
							</div>
						</div>
						<!--首页推荐展示-->
						<div class="control-group">
							<label class="control-label">首页推荐展示</label>
							<?php if(empty($info)): ?><div class="controls">
									<label class="radio-inline is_index_recommend">
										<input type="radio" name="is_index_recommend" value="1" checked=""> 启用
									</label>
									<label class="radio-inline is_index_recommend">
										<input type="radio" name="is_index_recommend" value="2"> 禁用
									</label>
								</div>
								<?php else: ?>
								<?php if($info["is_index_recommend"] == 1): ?><div class="controls">
										<label class="radio-inline is_show">
											<input type="radio" name="is_index_recommend" value="1" checked=""> 启用
										</label>
										<label class="radio-inline is_show">
											<input type="radio" name="is_index_recommend" value="2"> 禁用
										</label>
									</div><?php endif; ?>
								<?php if($info["is_index_recommend"] == 2): ?><div class="controls">
										<label class="radio-inline is_show">
											<input type="radio" name="is_index_recommend" value="1" > 启用
										</label>
										<label class="radio-inline is_show">
											<input type="radio" name="is_index_recommend" value="2" checked=""> 禁用
										</label>
									</div><?php endif; endif; ?>

						</div><?php endif; ?>

						
						<div class="control-group">
							<label class="control-label">状态</label>
							<?php if(empty($info)): ?><div class="controls">
									<label class="radio-inline is_show">
										<input type="radio" name="is_show" value="1" checked=""> 显示
									</label>
									<label class="radio-inline is_show">
										<input type="radio" name="is_show" value="2"> 隐藏
									</label>
								</div>
								<?php else: ?>
								<?php if($info["is_show"] == 1): ?><div class="controls">
										<label class="radio-inline is_show">
											<input type="radio" name="is_show" value="1" checked=""> 显示
										</label>
										<label class="radio-inline is_show">
											<input type="radio" name="is_show" value="2"> 隐藏
										</label>
									</div><?php endif; ?>
								<?php if($info["is_show"] == 2): ?><div class="controls">
										<label class="radio-inline is_show">
											<input type="radio" name="is_show" value="1" > 显示
										</label>
										<label class="radio-inline is_show">
											<input type="radio" name="is_show" value="2" checked=""> 隐藏
										</label>
									</div><?php endif; endif; ?>

						</div>
						
						
						<div class="form-actions">
							<button type="submit" class="btn btn-primary">保存</button>
						</div>
						</form>
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