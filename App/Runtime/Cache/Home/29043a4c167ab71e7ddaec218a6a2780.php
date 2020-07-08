<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta content="IE=edge">
<title>互联网生态圈营销中心</title>
<link href="../../../Public/css_alogin/bootstrap.min.css" rel="stylesheet">
<link href="../../../Public/css_alogin/signin.css" rel="stylesheet">
</head>
<body>
<div class="signin">
	<div class="signin-head">服务商登录 :</div>
	<form class="form-signin" role="form" action="/index.php/Login/login" method="post">
		<input type="text" name="name" class="form-control" placeholder="请输入账号" required autofocus />
		<input type="password" name="psw" class="form-control" placeholder="请输入密码" required />
		<button class="btn btn-lg btn-warning btn-block" type="submit">登录</button>
		<label class="checkbox">
		  <input type="checkbox" value="remember-me"> 记住密码
		  
		</label>
		
	</form>
	<div style="text-align: center;">
		<a target="_blank" href="http://jt.sz800800.cn/index.php/Merchants/index.html" style="color:white;margin:50px ;font-size:16px;text-decoration:none;">点击查看公司官网:  http://jt.sz800800.cn</a>
	
	</div>
</div>

</body>
</html>