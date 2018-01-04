<style type="text/css">
.perm_body{padding: 15px;}
.perm{overflow: hidden; width: 100%; line-height: 16px; padding: 8px 0 2px 0;}
.perm span{float: left; display: inline-block;}
.perm input{width: 15px; height: 15px;}
.perm .text{padding: 0 4px 0 8px;}
.perm_action{background: #EFF4FA;}
.perm_an{width: 100%; padding: 20px 0; text-align: center;}
</style>
<div class="perm_body">
	<div id="MsgText"></div>
<?php
foreach($Menus as $m1){
	$ck1 = isset($permArr[$m1->id])?' checked':'';
?>
	<div id="One" class="perm">
		<span class="text"><input type="checkbox" value="<?php echo $m1->id;?>"<?php echo $ck1;?> /></span>
		<span><?php echo $m1->title;?></span>
	</div>
<?php
foreach($m1->menus as $m2){
	$ck2 = isset($permArr[$m2->id])?' checked':'';
?>
	<div id="Two" class="perm">
		<span class="text" style="margin-left: 1.5em;"><input type="checkbox" value="<?php echo $m2->id;?>"<?php echo $ck2;?> /></span>
		<span><?php echo $m2->title;?></span>
	</div>
<?php
foreach($m2->menus as $m3){
	$ck3 = isset($permArr[$m3->id])?' checked':'';
?>
	<div class="perm perm_action">
		<span class="text" style="margin-left: 3em;"><input type="checkbox" id="Three" value="<?php echo $m3->id;?>"<?php echo $ck3;?> /></span>
		<span><?php echo $m3->title;?></span>
		<span id="Action_<?php echo $m3->id;?>">
			<span>（</span>
<?php
foreach($Perm as $val){
	if(intval($m3->perm)&intval($val->perm)){
		$checked = isset($permArr[$m3->id])?' checked':'';
?>
			<span class="text"><input type="checkbox" value="<?php echo $val->perm;?>"<?php echo $checked;?> /></span>
			<span><?php echo $val->name;?></span>
<?php }}?>
		 	<span>&nbsp;&nbsp;）</span>
		</span>
	</div>
<?php }}}?>
</div>
<div class="perm_an">
	<label class="webmis_bottom">编辑权限<input type="submit" id="editPerm" class="noDisplay" /></label>
</div>