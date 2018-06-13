$(function () {

	/* 全选 */
	$.webmis.checkbox({'y':'#checkboxY',n:'#checkboxN','el':'#Checkbox'});
	/* 隔行换色 */
	$('#listBG').webmis('oddColor');

	/* 搜索 */
	$('#ico-search').click(function(){
		// 创建窗口
		$.webmis.win({title:'搜索',width:420,height:320});
		// ajax
		$.get($base_url+'SysMenus/search'+$get_url,function(data){
			$.webmis.load(data);
		});
		return false;
	});

	/* 添加 */
	$('#ico-add').click(function(){
		// 创建窗口
		$.webmis.win({title:'添加',width:620,height:460});
		// ajax
		$.get($base_url+'SysMenus/add',function(data){
			// 加载内容
			$.webmis.load(data);
			// 联动菜单
			Class();
			// 提交表单
			Form();
		});
		return false;
	});

	/* 编辑 */
	$('#ico-edit').click(function(){
		// 获取ID
		var id = $('#listBG').webmis('getID');
		if(!id){return false;}
		// 创建窗口
		$.webmis.win({title:'编辑',width:620,height:460});
		// 内容
		$.post($base_url+'SysMenus/edit',{'id':id},function(data){
			// 加载内容
			$.webmis.load(data);
			// 联动菜单
			Class();
			// 提交表单
			Form();
		});
		return false;
	});

	/* 删除 */
	$('#ico-del').click(function(){
		var id = $('#listBG').webmis('getID',{type:'json'});
		if(!id){return false;}
		// 创建窗口
		$.webmis.win({title:'删除',width:280,height:160});
		$.post($base_url+'SysMenus/del',{'id':id},function(data){
			$.webmis.load(data);
			// 赋值ID
			$('#DelID').val(id);
			// 提交表单
			Form();
		});
		return false;
	});
})

/* Form validation */
function Form(){
	// 触发提交
	formValidSub();
	// 获取权限值
	$('#PermVal input').click(function(){
		var perm=0;
		$('#PermVal input:checked').each(function(){
			perm += parseInt($(this).val());
		});
		$('#menusPerm').val(perm);
	});
}

// 联动菜单
function Class(){
	$.webmis.getMeuns({
		el:'#menusClass',
		getVal:'#menus_fid',
		url:$base_url+'SysMenus/getMenu',
		type:'post'
	});
};