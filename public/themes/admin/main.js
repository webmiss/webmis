$(function () {
	// 导航滑动
	$.webmis.inc({files:[$app_url+'plugin/jquery/jquery.touchSwipe.min.js']});
	var nav = '#Nav';
	$(nav).swipe({
		swipeLeft: function() {
			var w = $(window).width();
			var li = $(nav+' li').width();
			var n = $(nav+' li').length;
			var t = li*(n+3);
			// 数据
			var translates = $(nav).css('transform');
			var left = parseFloat(translates.substring(7).split(',')[4]);
			left = left-li*2;
			// 限制
			if(-left+w > t){left = li*(n-5);}
			if(left>0){left=0;}else{left = parseInt(left);}
			// 滑动
			$(nav).addClass("addw").css('transform','translate('+left+'px)');
		},
		swipeRight: function() {
			var w = $(window).width();
			var li = $(nav+' li').width();
			var n = $(nav+' li').length;
			var t = li*(n+3);
			// 数据
			var translates = $(nav).css('transform');
			var right = parseFloat(translates.substring(7).split(',')[4]);
			right = right+li*2;
			// 限制
			if(-right+w > t){right = li*(n-5);}
			if(right>0){right=0;}else{right = parseInt(right);}
			// 滑动
			$(nav).addClass("addw").css('transform','translate('+right+'px)');
		}
	});
	// 手机菜单
	$('#Menu').click(function(){
		var obj = '.ct_left';
		var obj_bg = '.ct_left_bg';
		if($(obj).is(":hidden")){
			$(obj+','+obj_bg).show();
			// 点击隐藏
			$(obj_bg).click(function(){
				$(obj+','+obj_bg).hide();
				// 显示左侧菜单
				$(window).resize(function(){
					var w = $(window).width();
					if(w>768){$(obj).attr('style','');}
				});
			});
		}else{
			$(obj+','+obj_bg).hide();
		}
	});
	// 导航滑动
	var action = '#Menus';
	$(action).swipe({
		swipeLeft: function() {
			var w = $('.actionM').width();
			var li = $(action+' a').width()+16;
			var n = $(action+' a').length;
			var t = li*(n+3);
			// 数据
			var translates = $(action).css('transform');
			var left = parseFloat(translates.substring(7).split(',')[4]);
			left = left-li*2;
			// 限制
			if(-left+w > t){left = li*(n-5);}
			if(left>0){left=0;}else{left = parseInt(left);}
			// 滑动
			$(action).addClass("addw").css('transform','translate('+left+'px)');
		},
		swipeRight: function() {
			var w = $('.actionM').width();
			var li = $(action+' a').width()+16;
			var n = $(action+' a').length;
			var t = li*(n+3);
			// 数据
			var translates = $(action).css('transform');
			var right = parseFloat(translates.substring(7).split(',')[4]);
			right = right+li*2;
			// 限制
			if(-right+w > t){right = li*(n-5);}
			if(right>0){right=0;}else{right = parseInt(right);}
			// 滑动
			$(action).addClass("addw").css('transform','translate('+right+'px)');
		}
	});
	// 用户信息
	$('.top_link .icon.user').hover(function(){
		$(this).children(".info").show();
	},function(){
		$(this).children(".info").hide();
	});
});

/* 表单验证提交 */
function formValidSub(obj) {
	// Loading
	$.webmis.inc({files:[
		$app_url+'plugin/jquery/jquery.validate.min.js',
		$app_url + 'plugin/jquery/jquery.validate.zh.js',
		$app_url + 'plugin/jquery/jquery.form.min.js'
	]});
	// 校验
	if(obj==null){obj='#Form';}
	$(obj).validate({
		success: function(label) {
			label.html('<em class="suc"></em>').addClass("checked");
		},
		submitHandler: function(form){
			$(form).ajaxSubmit({
				dataType:'json', 
				success:function(data) {
					if(data.state=='y'){
						$.webmis.close(data.url+$get_url);
					}else{
						$('#textVal').html('<span class="err"><em></em>'+data.msg+'</span>');
					}
				}
			});
		}
	});
}