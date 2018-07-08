<form action="" method="get">
<table class="table_add">
	<tr>
		<td class="tright" width="90">ID:</td>
		<td>
			<input type="text" name="id" class="input" style="width: 30%;" value="<?php echo @$_GET['id'];?>" />
		</td>
	</tr>
	<tr>
		<td class="tright">名称:</td>
		<td>
			<input type="text" name="name" class="input" style="width: 80%;" value="<?php echo @$_GET['name'];?>" />
		</td>
	</tr>
	<td>&nbsp;</td>
		<td class="sub">
			<label class="webmis_bottom">搜索<input type="submit" name="search" value="" class="noDisplay" /></label>
		</td>
	</tr>
</table>
</form>