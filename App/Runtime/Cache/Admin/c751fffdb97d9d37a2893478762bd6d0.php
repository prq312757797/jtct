<?php if (!defined('THINK_PATH')) exit();?><iframe frameborder="0" scrolling="scrolling" src="myifrm.html" name="myifrm" id="myifrm" style="height: auto;width: 433px;">
</iframe>
 <script type="text/javascript" src="/Public/js/ajaxfileupload.js"></script>
  <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/js/jquery.js"></script>
 
 <style>
 	input{width:60%;}
 </style>

<div id="qq" style="border:1px solid;padding:3px;width:100px;text-align:center;margin-left:12px;border-radius:4px;">更多图片</div>
<hr>
 <swiper><div style='width:150px;border:1px solid red;text-align:center;margin-left:10%;'>产品推荐</div></swiper>

<!--<swiper style="display:block;height:150px;" indicator-dots="true" autoplay="true" interval="5000" duration="1000">
      <swiper-item >
            <image src="http://sz800800.cn/Uploads/2018-01-22/5a658bbd31203.png"  width="100%" />

      </swiper-item>
         <swiper-item >
            <image src="http://sz800800.cn/Uploads/2018-03-15/5aaa17b739385.jpg"  width="100%" />
      </swiper-item>
    </swiper>-->
<hr>
<?php if(is_array($flash)): foreach($flash as $key=>$v): echo ($v["sr"]); ?><br /><?php endforeach; endif; ?>

<a href="aws?url=http://www.baidu.com/img/baidu_logo.gif">下  \r载</a> 

<img  src="/Public/images/timg.gif"  style="clear:both;width:500px;height:300px;float: right;margin: 6px;"/>
<!--<input type="radio" value="" name="muban_fengge" checked="false"  class="muban_fengge"  price="" id="1" >111
<input type="radio" value="" name="muban_fengge" checked="false" class="muban_fengge" price="" id="2" >222

<div class="muban_fengge">123</div> https://sz800800.cn    -->
<form  id="qq" action="/pg.php/index/order_submin_zhubao" enctype="multipart/form-data" method="post" >
	

<div >
	URL:<input value="/pg.php/Dfx/tixian" type="text">
	
		<!--<div><input  name="order_num" type="text" value="JT20181103145239215223"></div>array_id-->
<!--<br/>	
	<<div><input  name="program_id" type="text" value="admin"></div>program_id
<br/>
	<div><input  name="only_num" type="text" value="15408107293823"></div>array_id
<br/>-->
	
	<div><input  name="order_num" type="text" value="JT20180823004816789116"></div>order_num
<br/>	
	<div><input  name="program_id" type="text" value="JT201710101645145951"></div><program_id></program_id>from_id
<br/>
	<div><input  name="openid" type="text" value="oyuRG4zVOgrfba5Oetqz5B97KYGo"></div>openid
<br/>
	<<div><input  name="from_id" type="text" value="0"></div>program_id
<br/>
	<div><input  name="array_id" type="text" value="10810,"></div>array_id
<br/>	
	<<div><input  name="shouhuo_id" type="text" value="1215"></div>program_id
<br/>
	<div><input  name="remark" type="text" value=""></div>array_id
<br/>
	<div><input  name="fapiao_taitou" type="text" value=""></div>program_id
	
	<<div><input  name="gold_sell" type="text" value="273.18"></div>program_id
<br/>
	<div><input  name="silver_sell" type="text" value="3524"></div>array_id
<br/>
	<div><input  name="price_show" type="text" value="104.86"></div>program_id	
=============================================================================================================
=============================================================================================================
=============================================================================================================
<!--URL:<input value="/Wxpay/make_order" type="text">
	<div><input  name="openid" type="text" value="og1Ol5IclfDXyunWamQt4SCjbEeg"></div>order_num
<br/>	
	<div><input  name="program_id" type="text" value="JT201806151732369242"></div><program_id></program_id>from_id
<br/>
	<div><input  name="pay_state" type="text" value="goods"></div>openid
<br/>
	<div><input  name="order_num" type="text" value="JT20180823232637853162"></div>program_id
<br/>	
	<div><input  name="from_id" type="text" value="50429"></div>program_id
<br/>	
	<div><input  name="data_total" type="text" value="0.01"></div>data_total -->
	
	<!--<div><input  name="program_id" type="text" value="JT201808090855119076"></div>openid
<br/>
	<div><input  name="openid" type="text" value="obv5r5bzAix3KtpqZvxIgsp4WhOA"></div>program_id
<br/>	
	<div><input  name="arr_data" type="text" value="[{"0":"1"}]"></div>program_id
<br/>	
	<div><input  name="array_id[]" type="text" value="1"></div>array_id
	<br/>
	<div><input  name="assistant_num" type="text" value="1"></div>array_id
	<br/-->
	
<!--
	<div><input  name="csv" type="file"></div><br/>-->
<!--	<div><input  name="image[]" type="file"></div><br/>
-->

	<button class="button" type="submit">测试开始</button>
</form>
<div id="q1">11</div>
<a class="num" >1</a>
<a class="num" >2</a>
<a class="num" >3</a>
<script>
 $("#q1").click(function(){
     var sum = +on_page + +1;
     $(".num").each(function(){
         if( $(this).text()==sum){
             //  alert($(this).text());
             $(this).click();

         }
     })
    })
 </script>
	<!--<span data-input="#advlink" data-toggle="modal" data-target="#myModal" class="input-group-addon btn btn-default">选择链接</span>
	    
	  -->  
	  <table style="width:475px;text-align:center;">
		<thead>
		<tr>
			<th style="width:25%;">详细</th>
			<th style="width:15%;">大单</th>
			<th style="width:15%;">中单</th>
			<th style="width:15%;">小单</th>
		</tr>
		</thead>
		<tbody>
			<tr  style="color:red;">
				<td>流入（万元）</td>
				<td id="date_1"> -</td>
				<td id="date_2"> -</td>
				<td id="date_3"> -</td>
			</tr>
			<tr style="color:green;">
				<td >流出（万元）</td>
				<td id="date_4"> -</td>
				<td id="date_5"> -</td>
				<td id="date_6"> -</td>
			</tr>
		</tbody>
	</table>
	<div style="display:flex;width:475px;margin-left: 32px;">
		<div style="width:45%;color:red;">	总流入：	<span id="zlr">-</span>	</div>
		<div style="width:45%;color:green;">总流出：	<span id="zlc">-</span>	</div>
		<div style="width:45%;">			净 额：	<span id="je">-</span>	</div>
	</div>
	
	  <div style="width:100px;height:100px;border:1px solid red;" id="id2">
   	123123
   </div>   
 <input id="input_id" value="1232" type="hidden">
<script>
	$("#id2").click(function(){
		$.get('/adz.php/test/ajax_float',{"num":"600048"},function(arr){	
			$("#zlr").text(arr[1].zlr)
			$("#zlc").text(arr[1].zlc)
			$("#je").text(arr[1].je)
			if(arr[1].je>0){
				$("#je").css("color","red")
			}else{
				$("#je").css("color","green")
			}
			
			
			$("#date_1").text(arr[0][5].sr)
			$("#date_2").text(arr[0][4].sr)
			$("#date_3").text(arr[0][3].sr)
			$("#date_4").text(arr[0][2].sr)
			$("#date_5").text(arr[0][1].sr)
			$("#date_6").text(arr[0][0].sr)
			console.log(arr)

		},'json');
	})
</script>

<script type="text/javascript">
//手机边框预览
$(document).ready(function(){

	$("h2").append('<em></em>')
	$(".thumbs a").click(function(){
	
		var largePath = $(this).attr("href");
		var largeAlt = $(this).attr("title");
		
		$("#largeImg").attr({ src: largePath, alt: largeAlt });
		
		$("h2 em").html(" (" + largeAlt + ")"); return false;
	});
	
});
</script>
<script>
	$(".muban_fengge").click(function(){
		if ($(this).attr("checked")) {
                    alert($(this).attr("id"));
                }
	})

	var val=1;
   	var val_1=val-1;
   		
	 $("#qq").click(function(){
	 	console.log(val);
	 	console.log(val_1);
   		var dh = '';

   		dh += ' <div><input  name="content[]" type="file"></div><br/>  ';
   		dh += ' <div id="muban_b_'+val;
		dh += '"></div> ';			
		document.getElementById('muban_b_'+val_1).innerHTML = dh;
		if(val<7){
		val++;
		val_1++;	
		}
		
   })
	 
	
</script>