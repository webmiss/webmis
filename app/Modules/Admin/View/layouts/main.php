<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="WebMIS" />
	<title>管理员控制台</title>
	<link rel="icon" type="image/png" href="/favicon.png" sizes="32x32" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="stylesheet" type="text/css" href="/webmis/webmis.css" />
	<link rel="stylesheet" type="text/css" href="/themes/admin/main.css" />
	<script type="text/javascript" src="/webmis/plugin/jquery/jquery-3.min.js"></script>
	<script type="text/javascript" src="/webmis/jquery.webmis.js"></script>
	<script type="text/javascript" src="/themes/admin/main.js"></script>
<?php if(isset($LoadJS)){foreach($LoadJS as $val){?>
	<script type="text/javascript" src="/themes/admin/js/<?php echo $val;?>"></script>
<?php }}?>
</head>
<body class="top_bg">
	<div class="top_body">
		<a href="" class="top_logo"></a>
		<ul id="Nav" class="top_nav">
<?php
$MenusLeft=[];
// 一级菜单
foreach($Menus['Data'] as $val){
	if($val->id==$Menus['CID'][0]){
		// 其他菜单
		$MenusLeft = $val->menus;
		$an = 'nav_an1';
	}else{
		$an = 'nav_an2';
	}
?>
			<li><a href="<?php echo self::getUrl($val->url);?>" class="<?php echo $an;?>"><em class="<?php echo $val->ico;?>"></em><span><?php echo $val->title;?></span></a></li>
<?php }?>
		</ul>
		<div class="top_link">
			<span id="Menu" class="icon menu"><em></em></span>
			<span class="uname"><?php echo $Uinfo['uname'];?></span>
			<span class="icon user">
				<em></em>
				<span class="info">
					<span class="ct">
						部门: <?php echo $Uinfo['department'];?><br>
						职务: <?php echo $Uinfo['position'];?>
					</span>
					<a href="" class="btop">修改密码</a>
					<a href="<?php echo self::getUrl('index/logout');?>" class="btop center">注销</a>
				</span>
			</span>
		</div>
	</div>
	<div class="ct_body">
		<div class="ct_left">
			<div class="ct_top"></div>
<?php
foreach ($MenusLeft as $val1){
	$ico = $val1->ico?'<em class="'.$val1->ico.'"></em>':'';
?>
			<div class="left_title"><?php echo $ico;?><?php echo $val1->title;?></div>
			<ul class="left_list">
<?php
if(isset($val1->menus)){foreach ($val1->menus as $val2){
	$ico = $val2->ico?'<em class="'.$val2->ico.'"></em>':'';
	$an = isset($Menus['CID'][2])&&$val2->id==$Menus['CID'][2]?'left_an1':'left_an2';
?>
				<li><a href="<?php echo self::getUrl($val2->url);?>" class="<?php echo $an;?>"><?php echo $ico;?><span><?php echo $val2->title;?></span></a></li>
<?php }}?>
			</ul>
<?php }?>
		</div>
		<div class="ct_left_bg"></div>
		<div class="ct_right">
			<div class="ct_top"></div>
<?php include self::$getContent; ?>

		</div>
	</div>
<div id="BaseURL" style="display: none;"><?php echo self::getUrl();?></div>
<div id="GetUrl" style="display: none;"><?php echo isset($getUrl)?$getUrl:'';?></div>
</body>
</html>