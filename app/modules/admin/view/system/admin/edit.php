<form action="<?php echo self::getUrl('SysAdmins/editData');?>" method="post" id="Form">
<table class="table_add">
	<tr>
		<td class="tright" width="90"></td>
		<td id="textVal"><span class="c2">请认真填写以下表单！</span></td>
	</tr>
	<tr>
		<td class="tright">用户名:</td>
		<td>
			<?php echo $edit->uname;?>
		</td>
	</tr>
	<tr>
		<td class="tright">原密码:</td>
		<td>
			<input type="password" name="passwd1" class="input" style="width: 70%;" rangelength="[6,16]" passwd="true" />
		</td>
	</tr>
	<tr>
		<td class="tright">新密码:</td>
		<td>
			<input type="password" id="passwd" name="passwd" class="input" style="width: 70%;" rangelength="[6,16]" passwd="true" />
		</td>
	</tr>
	<tr>
		<td class="tright">确认密码:</td>
		<td>
			<input type="password" class="input" style="width: 70%;" rangelength="[6,16]" equalto="#passwd" />
		</td>
	</tr>
	<tr>
		<td colspan="2"><b>详细信息</b></td>
	</tr>
	<tr>
		<td class="tright">姓名:</td>
		<td>
			<input type="text" name="name" value="<?php echo $edit->name;?>" class="input" style="width: 30%;" />
		</td>
	</tr>
	<tr>
		<td class="tright">部门:</td>
		<td>
			<input type="text" name="department" value="<?php echo $edit->department;?>" class="input" style="width: 60%;" />
		</td>
	</tr>
	<tr>
		<td class="tright">职务:</td>
		<td>
			<input type="text" name="position" value="<?php echo $edit->position;?>" class="input" style="width: 60%;" />
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td class="sub">
			<label class="webmis_bottom">编辑<input type="submit" class="noDisplay" /></label>
			<input type="hidden" name="id" value="<?php echo $edit->id;?>" />
		</td>
	</tr>
</table>
</form>