<?php
use app\library\Inc;
?>
<div class="action">
	<span class="title"><?php echo $Menus['Ctitle'];?></span>
	<div class="actionM">
		<div id="Menus">
<?php foreach ($Menus['action'] as $val){
	$url = $val['ico']=='ico-list'?self::getUrl(CONTROLLER):'';
?>
			<a href="<?php echo $url;?>" id="<?php echo $val['ico'];?>"><em class="<?php echo $val['ico'];?>"></em><span><?php echo $val['name'];?></span></a>
<?php }?>
		</div>
	</div>
</div>
<table class="table_list">
	<tr class="title">
		<td width="20"><a href="#" id="checkboxY"></a><a href="#" id="checkboxN"></a></td>
		<td width="60">ID</td>
		<td width="80">用户名</td>
		<td>邮箱</td>
		<td>手机号码</td>
		<td>部门</td>
		<td>职位</td>
		<td>姓名</td>
		<td width="120">注册时间</td>
		<td width="40">状态</td>
		<td width="40">权限</td>
	</tr>
	<tbody id="listBG">
<?php foreach ($List['data'] as $val){?>
	<tr>
		<td id="Checkbox"><input type="checkbox" value="<?php echo $val->id;?>" /></td>
		<td><?php echo $val->id;?></td>
		<td><b><?php echo Inc::keyHH($val->uname,@$_GET['uname']);?></b></td>
		<td><?php echo $val->email;?></td>
		<td><?php echo $val->tel;?></td>
		<td><?php echo Inc::keyHH($val->department,@$_GET['department']);?></td>
		<td><?php echo Inc::keyHH($val->position,@$_GET['position']);?></td>
		<td><?php echo Inc::keyHH($val->name,@$_GET['name']);?></td>
		<td><?php echo $val->rtime;?></td>
		<td><?php echo $val->state=='1'?'<span class="green">正常</span>':'<span class="red">禁用</span>';?></td>
		<td><a href="" title="<?php echo $val->perm;?>" onclick="editPerm('<?php echo $val->id;?>','<?php echo $val->perm;?>');return false;">编辑</a></td>
	</tr>
<?php }?>
	</tbody>
</table>
<div class="page"><?php echo $List['page'];?></div>