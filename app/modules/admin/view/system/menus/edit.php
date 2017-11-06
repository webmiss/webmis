<form action="<?php echo $this->getUrl('SysMenus/editData');?>" method="post" id="Form">
<table class="table_add">
	<tr>
		<td class="tright" width="90"></td>
		<td id="textVal"><span class="c2">请认真填写以下表单！</span></td>
	</tr>
	<tr>
		<td class="tright">FID:</td>
		<td>
			<input type="text" id="menus_fid" name="fid" value="<?php echo $edit->fid;?>" class="input" style="width: 60px;" />
			<div id="menusClass">&nbsp;</div>
		</td>
	</tr>
	<tr>
		<td class="tright">标题:</td>
		<td>
			<input type="text" name="title" value="<?php echo $edit->title;?>" class="input" style="width: 70%;" rangelength="[2,12]" required />
		</td>
	</tr>
	<tr>
		<td class="tright">控制器:</td>
		<td>
			<input type="text" name="url" value="<?php echo $edit->url;?>" class="input" style="width: 40%;" />
		</td>
	</tr>
	<tr>
		<td class="tright">权限:</td>
		<td id="PermVal">
<?php foreach($perm as $val){
	$checked = intval($edit->perm)&intval($val->perm)?'checked':'';
?>
			<input type="checkbox" class="Checkbox" value="<?php echo $val->perm;?>" <?php echo $checked;?>/><span class="inputText"><?php echo $val->name;?></span>
<?php }?>
			<input type="hidden" id="menusPerm" name="perm" value="<?php echo $edit->perm;?>" />
		</td>
	</tr>
	<tr>
		<td class="tright">图标样式:</td>
		<td>
			<input type="text" name="ico" value="<?php echo $edit->ico;?>" class="input" style="width: 40%;" />
		</td>
	</tr>
	<tr>
		<td class="tright">排序:</td>
		<td>
			<input type="text" name="sort" value="<?php echo $edit->sort;?>" class="input" style="width: 30%;" />
		</td>
	</tr>
	<tr>
		<td class="tright">备注:</td>
		<td>
			<textarea name="remark" style="width: 90%; height: 60px;"><?php echo $edit->remark;?></textarea>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td class="sub">
			<input type="submit" value="编辑" class="webmis_bottom" />
			<input type="hidden" name="id" value="<?php echo $edit->id;?>" />
		</td>
	</tr>
</table>
</form>