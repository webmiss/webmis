<form action="<?php echo self::getUrl('SysMenus/addData');?>" method="post" id="Form">
<table class="table_add">
	<tr>
		<td class="tright" width="90"></td>
		<td id="textVal"><span class="c2">请认真填写以下表单！</span></td>
	</tr>
	<tr>
		<td class="tright">FID:</td>
		<td>
			<div id="menusClass">&nbsp;</div>
			<input type="hidden" id="menus_fid" name="fid" value="0" class="input" style="width: 30%;" />
		</td>
	</tr>
	<tr>
		<td class="tright">标题:</td>
		<td>
			<input type="text" name="title" class="input" style="width: 70%;" rangelength="[2,12]" required />
		</td>
	</tr>
	<tr>
		<td class="tright">控制器:</td>
		<td>
			<input type="text" name="url" class="input" style="width: 40%;" />
		</td>
	</tr>
	<tr>
		<td class="tright">权限:</td>
		<td id="PermVal">
<?php foreach($perm as $val){?>
			<input type="checkbox" class="Checkbox" value="<?php echo $val->perm;?>" /><span class="inputText"><?php echo $val->name;?></span>
<?php }?>
			<input type="hidden" id="menusPerm" name="perm" value="0" />
		</td>
	</tr>
	<tr>
		<td class="tright">图标样式:</td>
		<td>
			<input type="text" name="ico" class="input" style="width: 40%;" />
		</td>
	</tr>
	<tr>
		<td class="tright">排序:</td>
		<td>
			<input type="text" name="sort" class="input" style="width: 30%;" />
		</td>
	</tr>
	<tr>
		<td class="tright">备注:</td>
		<td>
			<textarea name="remark" style="width: 90%; height: 60px;"></textarea>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td class="sub">
			<label class="webmis_bottom">添加<input type="submit" class="noDisplay" /></label>
		</td>
	</tr>
</table>
</form>