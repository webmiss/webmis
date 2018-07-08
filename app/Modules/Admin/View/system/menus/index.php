<?php
use Webmis\Library\Inc;
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
		<td>FID</td>
		<td>名称</td>
		<td>控制器</td>
		<td >权限值</td>
		<td>图标</td>
		<td>创建时间</td>
		<td>排序</td>
		<td>备注</td>
	</tr>
	<tbody id="listBG">
<?php foreach ($List['data'] as $val){?>
	<tr>
		<td id="Checkbox"><input type="checkbox" value="<?php echo $val->id;?>" /></td>
		<td><?php echo $val->id;?></td>
		<td><?php echo $val->fid;?></td>
		<td><b><?php echo Inc::keyHH($val->title,@$_GET['title']);?></b></td>
		<td><?php echo $val->url;?></td>
		<td><?php echo $val->perm;?></td>
		<td><?php echo $val->ico;?></td>
		<td><?php echo $val->ctime;?></td>
		<td><?php echo $val->sort;?></td>
		<td class="tleft"><?php echo $val->remark;?></td>
	</tr>
<?php }?>
	</tbody>
</table>
<div class="page"><?php echo $List['page'];?></div>