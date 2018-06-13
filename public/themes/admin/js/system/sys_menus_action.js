$(function () {

	/* 全选 */
	$.webmis.checkbox({'y':'#checkboxY',n:'#checkboxN','el':'#Checkbox'});
	/* 隔行换色 */
	$('#listBG').webmis('oddColor');

	/* 搜索 */
	$('#ico-search').click(function(){
		// 创建窗口
		$.webmis.win({title:'搜索',width:360,height:200});
		// ajax
		$.get($base_url+'SysMenusAction/search'+$get_url,function(data){
			$.webmis.load(data);
		});
		return false;
	});

	/* 添加 */
	$('#ico-add').click(function(){
		// 创建窗口
		$.webmis.win({title:'添加',width:420,height:260});
		// ajax
		$.get($base_url+'SysMenusAction/add',function(data){
			// 加载内容
			$.webmis.load(data);
			// 提交表单
			menusForm();
		});
		return false;
	});

	/* 编辑 */
	$('#ico-edit').click(function(){
		// 获取ID
		var id = $('#listBG').webmis('getID');
		if(!id){return false;}
		// 创建窗口
		$.webmis.win({title:'编辑',width:420,height:260});
		// 内容
		$.post($base_url+'SysMenusAction/edit',{'id':id},function(data){
			// 加载内容
			$.webmis.load(data);
			// 提交表单
			menusForm();
		});
		return false;
	});
	
	/* 删除 */
	$('#ico-del').click(function(){
		var id = $('#listBG').webmis('getID',{type:'json'});
		if(!id){return false;}
		// 创建窗口
		$.webmis.win({title:'删除',width:280,height:160});
		$.post($base_url+'SysMenusAction/del',{'id':id},function(data){
			$.webmis.load(data);
			// 赋值ID
			$('#DelID').val(id);
			// 提交表单
			menusForm();
		});
		return false;
	});
});

/* Form validation */
function menusForm(){
	// 触发提交
	formValidSub();
}