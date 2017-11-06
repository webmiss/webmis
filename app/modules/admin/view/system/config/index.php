<?php $isWrite = is_writable(APP.'config.php');?>
<form action="<?php echo $this->getUrl('SysConfig/Data');?>" method="post" id="Form">
<table class="table_add">
	<tr>
		<td colspan="2"><h2><?php echo $Menus['Ctitle'];?></h2></td>
	</tr>
	<tr>
		<td class="tright" width="120">配置文件:</td>
		<td id="textVal">
			<div class="<?php echo $isWrite?'suc':'err';?>"><em></em><b><?php echo APP;?>config.php</b></div>
		</td>
	</tr>
	<?php if($isWrite){$i=0; foreach($Config['data'] as $key=>$val){?>
	<tr>
		<td class="tright"><?php echo $Config['title'][$i];?>:</td>
		<td>
			<input type="text" name="<?php echo $key?>" class="input" style="width: 240px;" value="<?php echo $val;?>" />
		</td>
	</tr>
	<?php $i++;}?>
	<tr>
		<td colspan="2"><h2>&nbsp;</h2></td>
	</tr>
	<tr>
		<td class="sub center" colspan="2">
			<input type="submit" id="Sub" value="保存设置"/>
			<br/><br/><br/>
		</td>
	</tr>
	<?php }?>
	</table>
	</form>