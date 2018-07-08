<form action="" method="get">
<table class="table_add">
	<tr>
		<td class="tright" width="90">用户名:</td>
		<td>
			<input type="text" name="uname" class="input" style="width: 30%;" value="<?php echo @$_GET['uname'];?>" />
		</td>
	</tr>
	<tr>
		<td class="tright">姓名:</td>
		<td>
			<input type="text" name="name" class="input" style="width: 80%;" value="<?php echo @$_GET['name'];?>" />
		</td>
	</tr>
	<tr>
		<td class="tright">部门:</td>
		<td>
			<input type="text" name="department" class="input" style="width: 80%;" value="<?php echo @$_GET['department'];?>" />
		</td>
	</tr>
	<tr>
		<td class="tright">职称:</td>
		<td>
			<input type="text" name="position" class="input" style="width: 80%;" value="<?php echo @$_GET['position'];?>" />
		</td>
	</tr>
	<td>&nbsp;</td>
		<td class="sub">
			<label class="webmis_bottom">搜索<input type="submit" name="search" value="" class="noDisplay" /></label>
		</td>
	</tr>
</table>
</form>