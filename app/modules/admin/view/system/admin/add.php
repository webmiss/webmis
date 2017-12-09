<form action="<?php echo self::getUrl('SysAdmins/addData');?>" method="post" id="Form">
<table class="table_add">
	<tr>
		<td class="tright" width="90"></td>
		<td id="textVal"><span class="c2">请认真填写以下表单！</span></td>
	</tr>
	<tr>
		<td class="tright">用户名:</td>
		<td>
			<input type="text" name="uname" class="input" style="width: 40%;" rangelength="[3,16]" uname="true" required />
		</td>
	</tr>
	<tr>
		<td class="tright">密码:</td>
		<td>
			<input type="password" id="passwd" name="passwd" class="input" style="width: 70%;" rangelength="[6,16]" passwd="true" required />
		</td>
	</tr>
	<tr>
		<td class="tright">确认密码:</td>
		<td>
			<input type="password" class="input" style="width: 70%;" rangelength="[6,16]" equalto="#passwd" required />
		</td>
	</tr>
	<tr>
		<td class="tright">邮箱:</td>
		<td>
			<input type="text" name="email" class="input" style="width: 70%;" rangelength="[6,32]" email="true" required />
		</td>
	</tr>
	<tr>
		<td class="tright">手机号码:</td>
		<td>
			<input type="text" name="tel" class="input" style="width: 70%;" maxlength="11" tel="true" required />
		</td>
	</tr>
	<tr>
		<td colspan="2"><b>详细信息</b></td>
	</tr>
	<tr>
		<td class="tright">姓名:</td>
		<td>
			<input type="text" name="name" class="input" style="width: 30%;" />
		</td>
	</tr>
	<tr>
		<td class="tright">部门:</td>
		<td>
			<input type="text" name="department" class="input" style="width: 60%;" />
		</td>
	</tr>
	<tr>
		<td class="tright">职务:</td>
		<td>
			<input type="text" name="position" class="input" style="width: 60%;" />
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