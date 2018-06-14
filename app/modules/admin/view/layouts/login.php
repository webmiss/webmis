<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="author" content="WebMIS" />
	<title>管理员控制台</title>
	<link rel="icon" type="image/png" href="/favicon.png" sizes="32x32" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="stylesheet" type="text/css" href="/webmis/webmis.css" />
	<link rel="stylesheet" type="text/css" href="/themes/admin/main.css" />
</head>
<body class="login_body">
	<!--[if lt IE 9]><div class="isIE"><p><b>浏览器版本过低</b><br>请使用IE9以上或chrome、firefox、safari等最新版浏览器！</p></div><![endif]-->
	<div class="login_ct">
		<h1>WebMIS</h1>
		<ul class="login_list">
			<li>
				<label class="login_input">
					<em class="user"></em>
					<input type="text" id="uname" placeholder="用户名/邮箱/手机号码" maxlength="32" value="<?php echo isset($_COOKIE["uname"])?$_COOKIE["uname"]:'';?>" />
				</label>
			</li>
			<li>
				<label class="login_input">
					<em class="passwd"></em>
					<input type="password" id="passwd" placeholder="请输入密码" maxlength="32" />
				</label>
			</li>
			<li class="login_vcode">
				<label class="login_input">
					<input type="text" id="vcode" placeholder="验证码" maxlength="4" />
					<img src="<?php echo self::getUrl('index/vcode');?>" id="clickVcode" class="login_vcode" alt="验证码" />
				</label>
				<label class="login_uname"><input type="checkbox" id="remember" checked="true">&nbsp;记住用户名</label>
			</li>
			<li>
				<label id="adminLogin" class="login_submit">登 录</label>
			</li>
		</ul>
		<div class="login_copy">Copyright © WebMIS All rights are reserved.</div>
	</div>
<div id="BaseURL" style="display: none;"><?php echo self::getUrl();?></div>
<script type="text/javascript" src="/webmis/plugin/jquery/jquery-3.min.js"></script>
<script type="text/javascript" src="/webmis/jquery.webmis.js"></script>
<script type="text/javascript" src="/themes/admin/login.js"></script>
</body>
</html>