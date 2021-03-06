<?php if (!defined('THINK_PATH')) exit();?><!--<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta content="IE=edge">
<title>互联网生态圈营销中心</title>
<link href="/Public/css_alogin/bootstrap.min.css" rel="stylesheet">
<link href="/Public/css_alogin/signin.css" rel="stylesheet">
</head>
<body>
<div class="signin">
	<div class="signin-head"><?php echo ($title); ?>:</div>
	<form class="form-signin" role="form" action="<?php echo U('login/login');?>" method="post">
		<input type="hidden" value="<?php echo ($is_child); ?>" name="is_child">
		
		<input type="text" name="name" class="form-control" placeholder="请输入账号" required autofocus />
		<input type="password" name="psw" class="form-control" placeholder="请输入密码" required />
		<button class="btn btn-lg btn-warning btn-block" type="submit">登录</button>
		<label class="checkbox">
		  <input type="checkbox" value="remember-me"> 记住密码
		</label>
	</form>
</div>

</body>
</html>-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>互联网生态圈营销中心</title>
		<meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="/Public/new0127/css/bootstrap.min.css" />
		<link rel="stylesheet" href="/Public/new0127/css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="/Public/new0127/css/unicorn.login.css" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
    <body>
        <div id="logo">
            <img src="/Public/new0127/img/logo.png" alt="" />
        </div>
        <div id="loginbox">            
            <form id="loginform" method="post" class="form-vertical" action="<?php echo U('login/login');?>" >
				<p><?php echo ($title); ?></p>
                <div class="control-group">
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-user"></i></span>
                            <input name="name" type="text" placeholder="用户名" />
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-lock"></i></span>
                            <input name="psw" type="password" placeholder="密码" />
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <span class="pull-left"><a href="#" class="flip-link" id="to-recover">忘记密码</a></span>
                    <span class="pull-right"><input type="submit" class="btn btn-inverse" value="登录" />
                    
                    </span>
                </div>
            </form>
            <form id="recoverform" action="#" class="form-vertical" />
				<p>输入您的邮箱地址，我们将会回复你如何修改密码.</p>
				<div class="control-group">
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-envelope"></i></span><input type="text" placeholder="邮箱地址" />
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <span class="pull-left"><a href="#" class="flip-link" id="to-login">&lt; 返回登陆</a></span>
                    <span class="pull-right"><input type="submit" class="btn btn-inverse" value="Recover" /></span>
                </div>
            </form>
        </div>
        
        <script src="/Public/new0127/js/jquery.min.js"></script>  
        <script src="/Public/new0127/js/unicorn.login.js"></script> 
    </body>
</html>