<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="WebMIS" />
	<title>管理员控制台</title>
	<link rel="icon" type="image/png" href="favicon.png" sizes="32x32" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="format-detection" content="telephone=no">
	<meta name="msapplication-tap-highlight" content="no">
	<link rel="stylesheet" type="text/css" href="/webmis/webmis.css" />
	<link rel="stylesheet" type="text/css" href="/themes/admin/main.css" />
</head>

<body>
	<!--[if lt IE 9]><div class="isIE"><p><b>浏览器版本过低</b><br>请使用IE9以上或chrome、firefox、safari等最新版浏览器！</p></div><![endif]-->
<div class="body_login">
	<!--	Login -->
	<div class="login_body">
		<h1 id="webmisVersion" class="login_title">WebMIS</h1>
		<div class="login_ct">
			<dl class="login">
				<dt>用户名：</dt>
				<dd><input type="text" id="uname" class="login_input" placeholder="用户名/邮箱/手机号码" maxlength="32" value="<?php echo isset($_COOKIE["uname"])?$_COOKIE["uname"]:'';?>" /></dd>
				<dt>密码：</dt>
				<dd><input type="password" id="passwd" class="login_input" placeholder="请输入密码" maxlength="32" /></dd>
				<dt>验证码：</dt>
				<dd>
					<input type="text" id="vcode" class="login_input" style="float: left; width: 60px;" maxlength="4" /><img src="<?php echo self::getUrl('index/vcode');?>" id="clickVcode" class="login_vcode" alt="验证码" />
					<label class="login_uname"><input type="checkbox" id="remember" checked="true">&nbsp;记住用户名</label>
				</dd>
			</dl>
			<a href="" id="adminLogin" class="sub">登录</a>
		</div>
		<div class="login_copy">
			Copyright © WebMIS All rights are reserved.
		</div>
	</div>
</div>
<div id="BaseURL" style="display: none;"><?php echo self::getUrl();?></div>
<script type="text/javascript" src="/webmis/plugin/jquery/jquery-3.min.js"></script>
<script type="text/javascript" src="/webmis/jquery.webmis.js"></script>
<script type="text/javascript" src="/themes/admin/login.js"></script>
</body>
</html>