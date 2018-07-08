// 加载时运行
$(function(){

	// 点击登录
	$('#adminLogin').click(login);
	// 回车登录
	$(document).keypress(function(e){if(e.which==13){login();}});

	// 点击验证码
	var i=0;
	$('#clickVcode').click(function(){
		vCode(i);
		i++;
	});
});

// 刷新验证码
function vCode(i){
	$('#clickVcode').attr('src',$base_url+'index/vcode&v='+i);
}

// 登录
function login(){
	var uname = $('#uname').val();
	var passwd = $('#passwd').val();
	var vcode = $('#vcode').val();
	var remember = $('#remember:checked').val();
	// 是否记住用户名
	if(remember != undefined){
		remember = true;
	}else{
		remember = false;
	}
	// 判断用户名和密码是否空
	if(uname.length < 1 || passwd.length < 1){
		$.webmis.win({'content':'<div class="webmis_info err"><em></em>用户名和密码不能为空！</div>'});
		return false;
	}else if(vcode.length != 4){
		$.webmis.win({'content':'<div class="webmis_info err"><em></em>请填写验证码！</div>'});
		return false;
	}else{
		// Jquery的AJAX提交数据
		var i = 0;
		var d = {'uname':uname,'passwd':passwd,'vcode':vcode,'remember':remember};
		$.post($base_url+'index/login',d,function(data){
			// 返回结果
			if(data.status=='y'){
				// 跳转
				$.webmis.close(data.url);
			}else if(data.status=='v'){
				// 刷新验证码
				vCode(i);
				i++;
				$.webmis.win({'content':'<div class="webmis_info err"><em></em>'+data.msg+'</div>'});
			}else{
				$.webmis.win({'content':'<div class="webmis_info err"><em></em>'+data.msg+'</div>'});
			}
		},'json');
	}
	return false;
}