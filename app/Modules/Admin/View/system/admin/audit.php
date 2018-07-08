<form action="<?php echo self::getUrl('SysAdmins/auditData');?>" method="post" id="Form">
<table class="table_add">
	<tr>
		<td class="tright" width="80">状态:</td>
		<td>
			<select name="state">
				<option value="1">正常</option>
				<option value="2">禁用</option>
			</select>
		</td>
	</tr>
	<tr>
		<td class="sub center" colspan="2">
			<label class="webmis_bottom">确认<input type="submit" class="noDisplay" /></label>
			<input type="hidden" id="DelID" name="id" value="" />
		</td>
	</tr>
</table>
</form>