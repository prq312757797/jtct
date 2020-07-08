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
		<h1>调拨单</h1>
	</div>
	<div id="breadcrumb">
		<a href="<?php echo U('Index/index');?>" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 首页</a>
		<a href="<?php echo U('Warehouse/canggui');?>" class="tip-bottom">仓柜管理</a>
		<a href="#" class="current">调拨单</a>
	</div>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
					<div class="widget-title">
								<span class="icon">
									<i class="icon-align-justify"></i>
								</span>
						<h5>调拨单  <span style="color:#ccc;font-size:12px;">同级仓柜之间商品调配，调出仓柜库存减少，调入仓柜库存增加</span></h5>
					</div>
					<div class="widget-content nopadding">
			
		
<script>
	function action_12(item){
	
			$(".child_"+$(item).attr("k")).css("display","none")
			$(".child_"+$(item).attr("k")).each(function(){    
                $(this).children("select").attr("name","")
            })

			$("#id_"+$(item).attr("k")+"_"+$("#id_"+$(item).attr("k")).find("option:selected").val()).css("display","block")
			$("#id_"+$(item).attr("k")+"_"+$("#id_"+$(item).attr("k")).find("option:selected").val()).children("select").attr("name","a100[]")
		
	}
	function action_122(item){

			$(".child_goodsinfo_"+$(item).attr("k")+"_"+$(item).find("option:selected").val()).each(function(){    
                $(this).children("select").attr("name","")
            })

		var k=$(item).attr("k")
		var c_id=$(item).find("option:selected").val()
		
		$(".child_goodsinfo_"+k+"_"+c_id).css("display","none")
		console.log("child_goodsinfo_"+k+"_"+c_id)
		console.log("choosegoodid_"+k+"_"+c_id)



$("#choosegoodid_"+k+"_"+c_id).css("display","block")
$("#choosegoodid_"+k+"_"+c_id).children("select").attr("name","a1000[]")
//			$("#choosegoodid_"+$(item).attr("k")+"_"+$("#id_"+$(item).attr("k")+"_"+$(item).find("option:selected").val())).css("display","block")
//			$("#choosegoodid_"+$(item).attr("k")+"_"+$("#id_"+$(item).attr("k")+"_"+$(item).find("option:selected").val())).find("option:selected").val()).children("select").attr("name","a1000[]")
//	
	}
	function action_123(item){
		
		var key_1=$(item).attr("k")
		$.post('/adp.php/Warehouse/ajax_goods_info', {
					'fenlei_2': $(item).find("option:selected").val(),'warehouse01':$("#warehouse_"+key_1).find("option:selected").val()
				}, function(date) {
					var obj = eval(date);
					var dh = '';
				
					dh += ' <option>  ';
					dh += '商品名称';
					dh += ' </option>  ';
					for(var i = 0; i < obj.length; i++) {
						dh += ' <option  value="' + obj[i].id + '">  ';
						dh += obj[i].goods_title;
						dh += '('+obj[i].on_num+')';
						dh += ' </option>  ';
						document.getElementById('muban_b_'+key_1).innerHTML = dh;
					}
					}, 'json');
	}
		function action_warehouse(item){
		
		var key_1=$(item).attr("k")
		$.post('/adp.php/Warehouse/ajax_eq_warehouse', {
					'warehouse01_id': $(item).find("option:selected").val()
				}, function(date) {
					var obj = eval(date);
					var dh = '';
				
					dh += ' <option>  ';
					dh += '入仓柜选择';
					dh += ' </option>  ';
					for(var i = 0; i < obj.length; i++) {
						dh += ' <option  value="' + obj[i].id + '">  ';
						dh += obj[i].title;
						dh += ' </option>  ';
						document.getElementById('warehouse02_'+key_1).innerHTML = dh;
					}
					}, 'json');
	}
</script>

						<table class="table table-bordered table-striped" style="    border-top: 1px solid #ccc;">
							<thead>
							<tr>
								<th style="width:10%;">出仓柜</th>
								<th style="width:10%;">入仓柜</th>
								<th style="width:10%;">大类</th>
								<th style="width:10%;">小类</th>
								<th style="width:10%;">物品名称</th>
								
								<th style="width:10%;">数量</th>
							
								
							</tr>
							</thead>
							<form action="<?php echo U('Warehouse/run_ruku_add',array('id'=>$info['id'],'action_state'=>'diaobo'));?>" method="post" enctype="multipart/form-data" class="form-horizontal" />
							
							<tbody>
							<?php if(is_array($arr)): foreach($arr as $key=>$arr): ?><tr>
									<td><!--出仓柜-->
										
										<select name="warehouse01[]" class="w100" id="warehouse_<?php echo ($arr); ?>" onchange="action_warehouse(this)"  k="<?php echo ($arr); ?>">
											<option ></option>
											<?php if(is_array($warehouse)): foreach($warehouse as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["title"]); ?></option><?php endforeach; endif; ?>
										</select>
									</td>
									<td><!--入仓柜-->
									
										<select name="warehouse[]" class="w100"   id="warehouse02_<?php echo ($arr); ?>">
											<option ></option>
										</select>
									</td>
									<td><!--大类-->
										
										<select name="a10[]" class="w100" onchange="action_12(this)"  k="<?php echo ($arr); ?>" id="id_<?php echo ($arr); ?>" >
											<option ></option>
											<?php if(is_array($fenlei)): foreach($fenlei as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["title"]); ?></option><?php endforeach; endif; ?>
										</select>
									</td>
									<td><!--小类     choosegoodid_1_1475 choosegoodid_1_1475-->
										
										<?php if(is_array($fenlei)): foreach($fenlei as $key=>$v): ?><div id="id_<?php echo ($arr); ?>_<?php echo ($v["id"]); ?>" class="child_<?php echo ($arr); ?>" style="display:none;">
												<select name="" class="w100"  a="<?php echo ($arr); ?>_<?php echo ($v["id"]); ?>" onchange="action_123(this)"  k="<?php echo ($arr); ?>" id="id_<?php echo ($arr); ?>_<?php echo ($v['id']); ?>">
													<option ></option>
													<?php if(is_array($v['child'])): foreach($v['child'] as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["title"]); ?></option><?php endforeach; endif; ?>
												</select>
											</div><?php endforeach; endif; ?>
									</td>
									<td><!--小类所属商品-->
								
										<select name="goods[]" class="w100"   id="muban_b_<?php echo ($arr); ?>">
											<option ></option>
										</select>
									</td>
									<td><input type="text" class="w93" name="num[]" value=""/></td>
								
			
								
								</tr><?php endforeach; endif; ?>
	
							</tbody>
							
								<div class="form-actions"  style=" padding: 6px 50px 4px;">
									<button type="submit" style="float: right;  " class="btn btn-primary">提交调拨</button>
									<a href="goods_shenhe?text=调拨单&action_state=3" style="float: right; margin-right: 13px; " class="btn btn-primary">待审核调拨单<span style="color:red;">（<?php echo ($count_1); ?>）</span></a>
									<a href="goods_shenhe02?text=调拨单&action_state=3" style="float: right; margin-right: 13px; " class="btn btn-primary">已审核调拨单<span style="color:red;">（<?php echo ($count_2); ?>）</span></a>
								</div>
							
							</form>
							
						</table>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<!--原来的 modal 框位置-->
	<style>
   *{padding:0px; margin:0px;}
	a{text-decoration: none;}
	#myModal .modal-body {padding: 10px 15px;}
		#myModal .tab-pane {margin-top: 5px; min-height: 350px; max-height: 350px; overflow-y: auto;}
		#myModal .page-header {padding: 5px 0; margin-bottom: 8px;}
		#myModal .page-header h4 {margin: 0;}
		#myModal .btn {margin-bottom: 3px;}
		#myModal .modal-dialog {width: 880px;}
		#myModal .line {border-bottom: 1px dashed #ddd; color: #999; height: 36px; line-height: 36px;}
		#myModal .line .icon {height: 35px; width: 30px; position: relative; float: left;}
		#myModal .line .icon.icon-1:before {content: ""; width: 10px; height: 10px; border: 1px dashed #ccc; position: absolute; top: 12px; left: 10px;}
		#myModal .line .icon.icon-2 {width: 50px;}
		#myModal .line .icon.icon-2:before {content: ""; width: 10px; height: 10px; border-left: 1px dashed #ccc; border-bottom: 1px dashed #ccc; position: absolute; top: 12px; left: 20px;}
		#myModal .line .icon.icon-3 {width: 60px;}
		#myModal .line .icon.icon-3:before {content: ""; width: 10px; height: 10px; border-left: 1px dashed #ccc; border-bottom: 1px dashed #ccc; position: absolute; top: 12px; left: 30px;}
		#myModal .line .btn-sm {float: right; margin-top: 5px; margin-right: 5px; height: 24px; line-height: 24px; padding: 0 10px;}
		#myModal .line .text {display: block;}
		#myModal .line .label-sm {padding: 2px 5px;}
		#myModal .line.good {height: 60px; padding: 4px 0;}
		#myModal .line.good .image {height: 50px; width: 50px; border: 1px solid #ccc; float: left;}
		#myModal .line.good .image img {height: 100%; width: 100%;}
		#myModal .line.good .text {padding-left: 60px; height: 52px;}
		#myModal .line.good .text p {padding: 0; margin: 0;}
		#myModal .line.good .text .name {font-size: 15px; line-height: 32px; height: 28px;}
		#myModal .line.good .text .price {font-size: 12px; line-height: 18px; height: 18px;}
		#myModal .line.good .btn-sm {height: 32px; padding: 5px 10px; line-height: 22px; margin-top: 9px;}
		#myModal .tip {line-height: 250px; text-align: center;}
		#myModal .nav-tabs > li > a {padding: 8px 20px;}
</style>
	  <!--选择链接的modal---------------------------------开始-------->   
	<div class="modal fade w58" id="myModal" aria-hidden="false" style="display:none;    left: 36%;">
	<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">选择链接</h4>
        </div>
        <div class="modal-body">
        	<ul class="nav nav-tabs" id="selectUrlTab">
<?php if($program_id != JT201711081030423109): ?><li class="active"><a href="#sut_shop">商城</a></li>
				<li class=""><a href="#sut_good">商品</a></li>
				<li class=""><a href="#sut_cate">商品分类</a></li><?php endif; ?>				
<?php if($program_id == JT201711081030423109): ?><li class=""><a href="#sut_fenlei_dsh">行业分类</a></li><?php endif; ?>				
				<li class=""><a href="#sut_merch">合作商户</a></li>
<?php if($head_menu == 1): ?><!--商城版-->
					<li class=""><a href="#sut_artical">文章选择</a></li>
				<!--<li class=""><a href="#sut_fenxiao">分销系统</a></li>--><?php endif; ?>
				<?php if($head_menu == 5): ?><!--资讯版-->
					<li class=""><a href="#sut_artical">文章选择</a></li><?php endif; ?>
				<?php if($head_menu == 6): ?><!--服务版--><?php endif; ?>

				<!--<li class=""><a href="#sut_coupon">优惠券</a></li>	-->								
			</ul>
			<div class="tab-content ">
<!--diyend-->
				<div class="tab-pane  <?php if($program_id != JT201711081030423109): ?>active<?php endif; ?>" id="sut_shop">					
					<div class="page-header">
						<h4> 商城页面</h4></div>				
						<nav data-href="" class="btn btn-default btn-sm choose_007"  value="<?php echo ($url_search["index"]); ?>" title="商城首页">商城首页</nav>
					<nav data-href="" class="btn btn-default btn-sm choose_007"  value="<?php echo ($url_search["fenleidaohang"]); ?>" title="分类导航">分类导航</nav>
					<nav data-href="" class="btn btn-default btn-sm choose_007"  value="<?php echo ($url_search["quanbushagnpin"]); ?>" title="全部商品">全部商品</nav>
					<nav data-href="" class="btn btn-default btn-sm choose_007"  value="<?php echo ($url_search["gouwuche"]); ?>" title="购物车">购物车</nav>
					<nav data-href="" class="btn btn-default btn-sm choose_007"  value="<?php echo ($url_search["duodian_register"]); ?>" title="购物车">多店申请页面</nav>
		
					
					<nav data-href="" class="btn btn-default btn-sm choose_007"  value="<?php echo ($url_search["lianxidianhua"]); ?>" title="联系电话">联系电话</nav>
					<?php if($program_id == JT201806151732369242): ?><nav data-href="" class="btn btn-default btn-sm choose_007"  value="../artical/artical_list" title="方案列表">方案列表</nav><?php endif; ?>
					<div class="page-header">
						<h4><i class="fa fa-folder-open-o"></i> 会员中心</h4>
					</div>
					<nav data-href="" class="btn btn-default btn-sm choose_007" value="<?php echo ($url_search["huiyuanzhongxin"]); ?>" title="会员中心">会员中心</nav>
					<nav data-href="" class="btn btn-default btn-sm choose_007" value="<?php echo ($url_search["dingdan_all"]); ?>" title="我的订单(全部)">我的订单(全部)</nav>
					<nav data-href="" class="btn btn-default btn-sm choose_007" value="<?php echo ($url_search["dingdan_dfk"]); ?>" title="待付款订单">待付款订单</nav>
					<nav data-href="" class="btn btn-default btn-sm choose_007" value="<?php echo ($url_search["dingdan_dfh"]); ?>" title="待发货订单">待发货订单</nav>
					<nav data-href="" class="btn btn-default btn-sm choose_007" value="<?php echo ($url_search["dingdan_dsh"]); ?>" title="待收货订单">待收货订单</nav>
					<nav data-href="" class="btn btn-default btn-sm choose_007" value="<?php echo ($url_search["dingdan_ywc"]); ?>" title="已完成订单">已完成订单</nav>
					<nav data-href="" class="btn btn-default btn-sm choose_007" value="<?php echo ($url_search["shoucang"]); ?>" title="我的收藏">我的收藏</nav>
					<nav data-href="" class="btn btn-default btn-sm choose_007" value="<?php echo ($url_search["about_us"]); ?>" title="关于我们">关于我们</nav>
					<nav data-href="" class="btn btn-default btn-sm choose_007"  value="<?php echo ($url_search["user_address"]); ?>" title="用户地址展示">用户地址展示</nav>
			
			
					<div class="page-header">
						<h4><i class="fa fa-folder-open-o"></i> 分销中心</h4>
					</div>
					<nav data-href="" class="btn btn-default btn-sm choose_007" value="<?php echo ($url_search["fenxiaozhongxin"]); ?>" title="分销中心">分销中心</nav>
					<nav data-href="" class="btn btn-default btn-sm choose_007" value="<?php echo ($url_search["fx_erweima"]); ?>" title="推广二维码">推广二维码</nav>
					<nav data-href="" class="btn btn-default btn-sm choose_007" value="<?php echo ($url_search["fx_yongjin"]); ?>" title="分销佣金">分销佣金</nav>
					<nav data-href="" class="btn btn-default btn-sm choose_007" value="<?php echo ($url_search["fx_shangxiaji"]); ?>" title="分销上下线">分销上下线</nav>
					<nav data-href="" class="btn btn-default btn-sm choose_007" value="<?php echo ($url_search["fx_tixian"]); ?>" title="分销提现页面">分销提现页面</nav>
					
		<!--			<div class="page-header">
						<h4><i class="fa fa-folder-open-o"></i> 优惠券</h4>
					</div>
					<nav data-href="" class="btn btn-default btn-sm" title="领取优惠券">领取优惠券</nav>
					<nav data-href="" class="btn btn-default btn-sm" title="我的优惠券">我的优惠券</nav>
			-->	
				</div>
					
				<div class="tab-pane" id="sut_good">
					<div class="input-group"  style="width: 86%;">
						<input type="text" placeholder="请输入商品名称进行搜索" id="select-good-kw" value="" class="form-control search_title">
						<span class="input-group-addon btn btn-default select-btn "  id="search"  data-type="good"  style="top: 0px;left: 107%;">搜索</span>
					</div>
					<div id="select-good-list"  style="margin-top: 12px;">
					<!--	<li><img src="/Uploads/2017-09-01/59a936cf44aa2.jpg">12</li>
					-->
					
					<!--<div class="line" style="height: 55px;line-height: 55px;">
						<nav title="选择" class="btn btn-default btn-sm" data-href="">选择</nav>
						<div class="text"><img style="width:25px;height:25px;" src="/Uploads/2017-09-01/59a936cf44aa2.jpg">123</div>
					</div>-->
					
					</div>
				</div>
				<div class="tab-pane" id="sut_merch">
					<div class="input-group" style="width: 86%;">
						<input type="text" placeholder="请输入商户名称进行搜索" value="" class="form-control search_merch_title">
						<span class="input-group-addon btn btn-default select-btn "  id="search_merch"  data-type="good" style="top: 0px;left: 107%;position: absolute;z-index: 25;">搜索</span>
					</div>
					<div id="select-merch-list" style="margin-top: 12px;">
			
					</div>
				</div>
<!--商品分类-->
				<div class="tab-pane" id="sut_cate">
					<?php if(is_array($fenlei)): foreach($fenlei as $key=>$v): ?><div class="line">
								<div class="icon icon-1"></div>
								<?php if($program_id == JT201710231803407137): ?><nav title="选择" class="btn btn-default btn-sm choose_007" value="<?php echo ($url_search["fenlei_search_only"]); echo ($v["id"]); ?>">选择.</nav>
									<?php else: ?>
									<nav title="选择" class="btn btn-default btn-sm choose_007" value="<?php echo ($url_search["fenlei_search"]); echo ($v["id"]); ?>">选择..</nav><?php endif; ?>
									
							<div class="text"><?php echo ($v["title"]); ?></div>
							</div>
						<?php if(is_array($v['child'])): foreach($v['child'] as $key=>$vo): ?><div class="line">
								<div class="icon icon-2"></div>
								<nav title="选择" class="btn btn-default btn-sm choose_007" value="<?php echo ($url_search["fenlei_shangpin"]); echo ($vo["id"]); ?>">选择</nav>
								<div class="text"><?php echo ($vo["title"]); ?></div>
							</div><?php endforeach; endif; endforeach; endif; ?>
					
				</div>	
<!--商品分类-->
				<div class="tab-pane <?php if($program_id == JT201711081030423109): ?>active<?php endif; ?>" id="sut_fenlei_dsh">
					<?php if(is_array($fenlei_dsh)): foreach($fenlei_dsh as $key=>$v): ?><div class="line">
								<div class="icon icon-1"></div>
								<?php if($program_id == JT201710231803407137): ?><nav title="选择" class="btn btn-default btn-sm choose_007" value="<?php echo ($url_search["fenlei_search_only"]); echo ($v["id"]); ?>">选择.</nav>
									<?php else: ?>
									<nav title="选择" class="btn btn-default btn-sm choose_007" value="<?php echo ($url_search["fenlei_search"]); echo ($v["id"]); ?>">选择..</nav><?php endif; ?>
									
							<div class="text"><?php echo ($v["title"]); ?></div>
							</div>
						<?php if(is_array($v['child'])): foreach($v['child'] as $key=>$vo): ?><div class="line">
								<div class="icon icon-2"></div>
								<nav title="选择" class="btn btn-default btn-sm choose_007" value="<?php echo ($url_search["fenlei_shangpin"]); echo ($vo["id"]); ?>">选择</nav>
								<div class="text"><?php echo ($vo["title"]); ?></div>
							</div><?php endforeach; endif; endforeach; endif; ?>
					
				</div>	
				<div class="tab-pane" id="sut_artical">
					<?php if(is_array($artical)): foreach($artical as $key=>$v): ?><div class="line">
								<div class="icon icon-1"></div>
								<nav title="选择" class="btn btn-default btn-sm choose_007" value="../product/detail2?artical_id=<?php echo ($v["id"]); ?>">选择</nav>
								<div class="text"><?php echo ($v["title"]); ?></div>
							</div><?php endforeach; endif; ?>
					
				</div>	
				<!--优惠券   开始--------------->
				<!--<div class="tab-pane" id="sut_coupon">
					<div class="input-group">
						<input type="text" placeholder="请输入优惠券名称进行搜索" id="select-coupon-kw" value="" class="form-control">
						<span class="input-group-addon btn btn-default select-btn" data-type="coupon">搜索</span>
					</div> 
					<div id="select-coupon-list"></div>
				</div>-->
				<!--优惠券   结束--------------->
            </div>
	        <div class="modal-footer">
	            <button data-dismiss="modal" class="btn btn-default" id="guanbi" type="button">关闭</button>
	        </div>
	    </div>
        <script>
        	$(function(){
        		$("#myModal").find('#selectUrlTab a').click(function(e) {
					$('#tab').val($(this).attr('href'));
					e.preventDefault();
					$(this).tab('show');
				});
        	});
        </script>
        
        <!--选择链接的modal---------------huandeng_add.html------------------结束-------->
    <script>
	var aaaa = []
	var that = this
	$(".choose_007").click(function(){

		$("#url_value").val($(this).attr("value"));
		$("#guanbi").click();
	})

        $("#search").click(function(){
        	
        	if(!$(".search_title").val()){
        		alert("请填写商品名称");
        		return false;
        	}
        //	 console.log($(".search_title").val());	 	
   $.post('/adp.php/Index/self_url_goods',{'title':$(".search_title").val()},function(data){
	    	
	    	var obj=eval(data);
			var dh='';
	        for (var i=0;i<obj.length;i++){  
	         console.log(i);
				dh+=' <div class="line" style="height: 55px;line-height: 55px;">  ';		
	       		dh+=' <nav title="选择" class="btn btn-default btn-sm choose_007 " style="margin-top: 20px;" id="'+obj[i].id +'" onclick="f2(this)" value=" ' +obj[i].id + ' " data-href="">选择</nav> ';
	       		dh+=' <div class="text">  ';
	       		dh+=' <img style="width:25px;height:25px;" src="https://sz800800.cn/Uploads/' +obj[i].image + ' ">  ';
	       		dh+=  obj[i].goods_title  ;
	       		dh+=' </div>  ';
	       		dh+=' </div>  ';
	         }
	         document.getElementById('select-good-list').innerHTML=dh;
	        },'json');
        })
    
     	  	//子商户名称搜索
        	$("#search_merch").click(function(){
        	if(!$(".search_merch_title").val()){
        		alert("请填写商户名称");
        		return false;
        	}
        	 	
   $.post('/adp.php/Index/self_url_merch',{'title':$(".search_merch_title").val()},function(data){
	    	var obj=eval(data);
			var dh='';
	        for (var i=0;i<obj.length;i++){  
	         console.log(i);
				dh+=' <div class="line" style="height: 55px;line-height: 55px;">  ';		
	       		dh+=' <nav title="选择" class="btn btn-default btn-sm choose_007 " style="margin-top: 20px;" id="'+obj[i].id +'" onclick="f2_m(this)" value=" ' +obj[i].id + ' " data-href="">选择</nav> ';
	       		dh+=' <div class="text">  ';
	       		dh+=' <img style="width:25px;height:25px;" src="https://sz800800.cn/Uploads/' +obj[i].logo + ' ">  ';
	       		dh+=  obj[i].sh_name  ;
	       		dh+=' </div>  ';
	       		dh+=' </div>  ';
	        //22aa
	         }
	         document.getElementById('select-merch-list').innerHTML=dh;
	        },'json');
        })
            function f2_m(item){
      
	       	$("#url_value").val("../shop_store/store?id="+item.id);
			$("#guanbi").click();	
        }
        function f2(item){
       		//alert(item.id);
	       	$("#url_value").val("../product/detail?productId="+item.id);
			$("#guanbi").click();	
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

	<script>
//		$(".action").click(function(){
//
//			for (var i=1;i<3;i++){
//					$(".child_"+$(this).attr("k")).css("display","none")
//					$("#id_"+$(this).attr("k")+"_"+$(this).attr("a")).css("display","block")
//			}
//			
//		})
		function ac2tion(item){
//					console.log($(item).attr("a"))
console.log($("#id_"+$(item).attr("k")).find("option:selected").val())
//			for (var i=1;i<3;i++){
//				$(".child_"+$(item).attr("k")).css("display","none")
//				$("#id_"+$(item).attr("k")+"_"+$("#id_"+$(item).attr("k")).find("option:selected").val()).css("display","block")
//			}
		}
	</script>