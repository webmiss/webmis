<form action="<?php echo self::getUrl('SysMenusAction/addData');?>" method="post" id="Form">
<table class="table_add">
	<tr>
		<td class="tright" width="90"></td>
		<td id="textVal"><span class="c2">请认真填写以下表单！</span></td>
	</tr>
	<tr>
		<td class="tright">动作名称:</td>
		<td>
			<input type="text" name="name" class="input" style="width: 70%;" rangelength="[2,32]" required />
		</td>
	</tr>
	<tr>
		<td class="tright">权限值:</td>
		<td>
			<input type="text" id="action_perm" name="perm" class="input" style="width: 40%;" digits="true" maxlength="6" required />
		</td>
	</tr>
	<tr>
		<td class="tright">图标样式:</td>
		<td>
			<input type="text" name="ico" class="input" style="width: 40%;" rangelength="[2,24]" required />
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