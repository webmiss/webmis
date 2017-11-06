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
		$.get($base_url+'SysAdmins/search'+$get_url,function(data){
			$.webmis.load(data);
		});
		return false;
	});

	/* 添加 */
	$('#ico-add').click(function(){
		// 创建窗口
		$.webmis.win({title:'添加',width:620,height:540});
		// ajax
		$.get($base_url+'SysAdmins/add',function(data){
			// 加载内容
			$.webmis.load(data);
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
		$.webmis.win({title:'编辑',width:620,height:500});
		// 内容
		$.post($base_url+'SysAdmins/edit',{'id':id},function(data){
			// 加载内容
			$.webmis.load(data);
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
		$.post($base_url+'SysAdmins/del',{'id':id},function(data){
			$.webmis.load(data);
			// 赋值ID
			$('#DelID').val(id);
			// 提交表单
			Form();
		});
		return false;
	});

	/* 审核 */
	$('#ico-audit').click(function(){
		var id = $('#listBG').webmis('getID',{type:'json'});
		if(!id){return false;}
		// 创建窗口
		$.webmis.win({title:'审核',width:280,height:160});
		$.post($base_url+'SysAdmins/audit',{'id':id},function(data){
			$.webmis.load(data);
			// 赋值ID
			$('#DelID').val(id);
			// 提交表单
			Form();
		});
		return false;
	});

});

/* Form validation */
function Form(){
	// 触发提交
	formValidSub();
}

/* 编辑权限 */
function editPerm(id,perm){
	// 宽高
	$.webmis.win({title:'编辑权限',width:820,height:540});
	// Content
	$.post($base_url+'SysAdmins/perm',{'perm':perm},function(data){
		$.webmis.load(data);
		//提交
		$('#editPerm').click(function(){
			// 获取权限字符串
			var permval = getPerm();
			permData(id,permval)
		});
	});
	// 提交修改
	var permData = function (id,perm){
		$.post($base_url+'SysAdmins/permData',{'id':id,'perm':perm},function(data){
			if(data.state=='y'){
				$.webmis.close(data.url+$get_url);
			}else{
				$.webmis.win({'content':'<div class="webmis_info err"><em></em>'+data.msg+'</div>'});
			}
		},'json');
	}
	// 生成权限字符串
	var getPerm = function (){
		var perm = '';
		// 一级菜单
		$('#oneMenuPerm input:checked').each(function(){
			perm += $(this).val()+':0 ';
		});
		// 二级菜单
		$('#twoMenuPerm input:checked').each(function(){
			perm += $(this).val()+':0 ';
		});
		// 三级菜单
		$('#threeMenuPerm input[name=threeMenuPerm]:checked').each(function(){
			var id = $(this).val();
			var act = getAction(id);
			perm += id+':'+act+' ';
		});
		// 去除尾部空格
		if(perm){perm = perm.substr(0, perm.length-1);}
		return perm;
	}
	// 获取动作权限和
	var getAction = function (id){
		var perm=0;
		$('#actionPerm_'+id+' input:checked').each(function(){
			perm += parseInt($(this).val());
		});
		return perm;
	}
}