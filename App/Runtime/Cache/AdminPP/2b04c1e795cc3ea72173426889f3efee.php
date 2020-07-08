<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>跳转提示</title>
    <style type="text/css">
    *{ padding: 0; margin: 0; }
    body{ background: #fff; 
	      font-family: '微软雅黑'; 
	      color:#333; 
	     min-width:900px;
	     margin:0 auto;
	     height:650px;
	      font-size:6px; 
	      background:url("/Public/images/logo_2.png") no-repeat;
	      background-size: 100% 100%;
    }
    .message{
    	    width: 63%;
    height: 130px;
    border-radius: 4px;
    font-size: 20px;
        background: rgba(255, 255, 255, 0.6);
    position: fixed;
    top: 35%;
    left: 20%;
    	}
    	
    .foot{
    	    height: 40px;
    background: rgba(255, 255, 255, 0.4);
    text-align: center;
    font-size: 20px;
    line-height: 42px;
    border-radius: 6px;
    position: fixed;
    width: 100%;
    top: 76%;
        letter-spacing: 3px;
    color: #545050;
    }	
    .head{width: 100%;height: 30px;text-align: center;padding-top: 5px;}
    .content{height: 120px;width: 100%;}
    .success ,.error{text-align: center;margin-top: 10px;}
    .jump{text-align: center;margin-top: 20px;}
    </style>
    </head>
    <body>
    	<div id="" style="width:90%;    position: fixed;
    top: 12%;
    left: 5%;">
    		<img src="/Public/images/logo_1.png"/ style="width:42%;height:100px;">
    	</div>
	    <div class="message">
		  <!--  <div class="head"><span>提示信息:</span></div>-->
		    <div class="content">
			    <?php if(isset($message)) {?>
			    <p class="success" style="font-size:27px;color:#b2666a;"> <?php echo($message); ?></p>
			    <?php }else{?>
			    <p class="error" style="    font-size: 27px;color:#b2666a;">
			    	<img src="/Public/images/no_1.png"/ style="width:40px;height:40px; position: relative;top: 11px;">
			    	<?php echo($error); ?></p>
			    <?php }?>
			    <p class="detail"></p>
			    <p class="jump">
				    <a id="href" href="<?php echo($jumpUrl); ?>" style="text-decoration:none;color:#813D4A;    letter-spacing: 1px;">点击返回上一页  【首页】 <b id="wait"><?php echo($waitSecond); ?></b>(秒)</a>
				    <br />
				  <!--  等待时间： <b id="wait"><?php echo($waitSecond); ?></b>-->
		        </p>
		    </div>
	    </div>
	    <div class="foot" >
	    	2017版权所有 互联网生态圈营销中心
	    </div>
    <script type="text/javascript">
    (function(){
    var wait = document.getElementById('wait'),href = document.getElementById('href').href;
    var interval = setInterval(function(){
    var time = --wait.innerHTML;
    if(time <= 0) {
    location.href = href;
    clearInterval(interval);
    };
    }, 1000);
    })();
    </script>
    </body>
    </html>