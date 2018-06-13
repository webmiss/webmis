$(function () {

	/* 全选 */
	$.webmis.checkbox({'y':'#checkboxY',n:'#checkboxN','el':'#Checkbox'});
	/* 隔行换色 */
	$('#listBG').webmis('oddColor');

	/* 搜索 */
	$('#ico-search').click(function(){
		// 创建窗口
		$.webmis.win({title:'搜索',width:420,height:280});
		// ajax
		$.get($base_url+'SysAdmins/search'+$get_url,function(data){
			$.webmis.load(data);
		});
		return false;
	});

	/* 添加 */
	$('#ico-add').click(function(){
		// 创建窗口
		$.webmis.win({title:'添加',width:620,height:490});
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
		$.webmis.win({title:'编辑',width:620,height:440});
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
	// 检测用户名
	var isUname = function(name,value){
		var res=1;
		$.ajax({
			type:"POST",
			url:$base_url+'SysAdmins/isUname',
			async:false,
			data:{'name':name,'val':value},
			dataType:'json',
			success: function(data){
				if(data.state == 'y'){res=0;}
			}
		});
		return res==0?false:true;
	}
	// 用户名校验
	$.validator.addMethod("uname", function(value, element){
		var res=1;
		var uname = /^[a-zA-Z][a-zA-Z0-9\_\@\-\*\&]{3,15}$/;
		if(uname.test(value)){
			if(!isUname('uname',value)){
				$.extend($.validator.messages, {'uname':'<em></em>已存在！'});
				res = 0;
			}
		}else{
			$.extend($.validator.messages, {'uname':'<em></em>英文开头4~16位字符'});
			res = 0;
		}
		// 结果
		return res==0?false:true;
	}, "<em></em>提示信息！");
	// 邮箱
	$.validator.addMethod("email", function(value, element){
		var res=1;
		var email =  /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if(email.test(value)){
			if(!isUname('email',value)){
				$.extend($.validator.messages, {'email':'<em></em>已存在！'});
				res = 0;
			}
		}else{
			$.extend($.validator.messages, {'email':'<em></em>请输入邮箱'});
			res = 0;
		}
		// 结果
		return res==0?false:true;
	}, "<em></em>提示信息！");
	// 手机号码
	$.validator.addMethod("tel", function(value, element){
		var res=1;
		var tel = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
		if(tel.test(value)){
			if(!isUname('tel',value)){
				$.extend($.validator.messages, {'tel':'<em></em>已存在！'});
				res = 0;
			}
		}else{
			$.extend($.validator.messages, {'tel':'<em></em>请输入手机号码'});
			res = 0;
		}
		// 结果
		return res==0?false:true;
	}, "<em></em>提示信息！");
	// 密码校验
	$.validator.addMethod("passwd", function(value, element){
		var passwd = /^[a-zA-Z][a-zA-Z0-9\_\@\-\*\&]{5,15}$/;
		return this.optional(element) || passwd.test(value);
	}, "<em></em>英文开头6~16位字符");
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
			var perm='';
			// 一级菜单
			$('#One input:checked').each(function(){
				perm += $(this).val()+':0 ';
			});
			// 二级菜单
			$('#Two input:checked').each(function(){
				perm += $(this).val()+':0 ';
			});
			// 三级菜单
			$('#Three:checked').each(function(){
				var a=0;
				$('#Action_'+$(this).val()+' input:checked').each(function(){
					a += parseInt($(this).val());
				});
				perm += $(this).val()+':'+a+' ';
			});
			// 提交权限
			$.post($base_url+'SysAdmins/permData',{'id':id,'perm':perm},function(data){
				if(data.state=='y'){
					$.webmis.close(data.url+$get_url);
				}else{
					$('#MsgText').html('<span class="err"><em></em>'+data.msg+'</span>');
				}
			},'json');
		});
	});
}