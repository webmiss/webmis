/**
 * jQuery WebMIS 2017
 * Copyright (c) webmis.vip  All rights reserved.
 * Date: 2016-10-22
 */

var $base_url = '';	 // 网址
var $get_url = '';		// 搜索条件
var $app_url = '/webmis/';	// 插件路径

$(function(){

	// 获取网址
	$base_url = $('#BaseURL').text();
	// 获取条件
	$get_url = $('#GetUrl').text();
	// 插件完整路径
	var url = $base_url.split('/');
	$app_url = url[0]+$app_url;

	// 自动调整窗口
	var w='',h='';
	var winSize = function (){
		w = $('.webmis_win').width()/2;
		h = $('.webmis_win').height()/2;
		$('.webmis_win').css({'margin-left':'-'+w+'px','margin-top':'-'+h+'px'});
	}
	// 监听窗口大小
	$(window).resize(function(){
		winSize();	// 自动调整窗口
	});

	/* 插件 $.webmis */
	$.webmis={

		/* 自动加载 */
		'inc':function(options){
			var defaults = {files:'',dom:'body'};
			var options = $.extend(defaults,options);
			var file = options.files;
			var js = ''; var ext = '';
			for(var i=0; i<file.length;i++){
				ext = file[i].split('.');
				// JS
				if(ext[ext.length-1]=='js'){
					if($('script[src="'+file[i]+'"]').length==0){
						$(options.dom).append('<script src="'+file[i]+'"></script>');
					}
				// CSS
				}else if(ext[ext.length-1]=='css'){
					if($('link[href="'+file[i]+'"]').length==0){
						$(options.dom).append('<link rel="stylesheet" href="'+file[i]+'" />');
					}
				}
			}

		},

		/* 窗口插件 */
		'win':function(options){
			// 默认参数
			var defaults = {
				'title':'信息',
				'width':280,
				'height':160,
				'content':'<div class="webmis_win_load"></div>',
			}
			// 合并参数
			options = $.extend(defaults,options);
			// 创建窗口
			var html = '';
			html += '<div class="webmis_win_bg">';
			html += '	<div class="webmis_win" style="max-width: '+options.width+'px; max-height: '+options.height+'px;">';
			html += '		<div class="webmis_win_title"><b>'+options.title+'</b><em onclick="$.webmis.close(\'\')"></em></div>';
			html += '		<div class="webmis_win_ct">'+options.content+'</div>';
			html += '	</div>';
			html += '</div>';
			// 关闭窗口
			$.webmis.close('');
			// 添加内容
			$('body').prepend(html);
			// 动画
			$('.webmis_win_bg').fadeIn();
			$('.webmis_win').fadeToggle(300);
			// 调整窗口
			winSize();
			//ESC键关闭
			$(document).keydown(function(e){
				if(e.which == 27){$.webmis.close();}
			});
		},

		/* 加载内容 */
		'load':function(html){
			$('.webmis_win_ct').html(html);
			return false;
		},

		/* 关闭窗口 */
		'close':function(url){
			// 移除
			$('.webmis_win_bg').remove();
			// 跳转
			if(url!=undefined && url!=''){
				window.location.href = $base_url+url;
			}
			return false;
		},

		/* 选项卡 */
		'tabs':function(options){
			// 默认参数
			var defaults = {
				'el':'#Tab',
				'menus':['选项卡1','选项卡2','选项卡3']
			}
			// 合并参数
			var options = $.extend(defaults,options);

			var nav = options.menus;
			var html = '<span class="webmis_win_tabs">';
			var an = '';
			for(var i=0; i<nav.length; i++){
				if(i==0){an=' class="an"';}else{an='';}
				html += '<a'+an+'>'+nav[i]+'</a>'
			}
			html += '</span>';
			// 添加菜单
			$('.webmis_win_title b').after(html);
			// 点击切换
			$('.webmis_win_tabs a').click(function(){
				var num = $(this).index();
				$('body '+options.el).hide();			// 隐藏
				$('body '+options.el).eq(num).show();	// 显示
				// 按钮样式
				$('.webmis_win_tabs a').removeClass('an');
				 $(this).addClass('an');
			});
		},

		/* 联动菜单 */
		'getMeuns':function(options){
			var defaults = {'el':'','url':'','getVal':'','getValType':'','fid':'0','type':'get','dataType':'json'}
			var options = $.extend(defaults,options);
			// 项目
			var obj = $(options.el);
			var idArr = [];

			// 递归
			var getData = function(num,id){
				$.ajax({
					'url':options.url,
					'type':options.type,
					'data':{'fid':id},
					'dataType':options.dataType,
					'success':function(data){
						if(data==''){
							return false;
						}
						var html = '<select id="Menus_'+num+'" class="webmis_select">';
						html += '<option value="">请选择</option>';
						for(var i=0; i<data.length;i++){
							html += '<option value="'+data[i][0]+'">'+data[i][1]+'</option>';
						}
						html +='</select>';
						// 添加内容
						obj.append(html);

						// 监听下级菜单
						$('#Menus_'+num).change(function(){
							// 清除
							var index = $(this).index();
							var x=0;
							obj.find('select').each(function(){
								if($(this).index()>index){
									$(this).remove();
								}
							});
							// FID
							var id = $(this).val();
							// 赋值
							if(options.getValType){
								// ID数组
								idArr[num] = id;
								var val = options.getValType;
								for(var i=0; i<=index;i++){
									val += idArr[i]+options.getValType;
								}
								// 排除请选择
								if(id==''){val = val.substr(0,val.length-1);}
								$(options.getVal).val(val);
							}else{
								$(options.getVal).val(id);
							}
							// 回调
							getData(num+1,id);
						});
					}
				});
			}
			//调用
			getData(0,options.fid);
		},

		/* 全选、全不选 */
		'checkbox':function(options){
			var defaults = {'y':'','n':'','el':''}
			var options = $.extend(defaults,options);

			$(options.y).click(function(){
				$(this).hide();
				$('body '+options.el+' :checkbox').prop('checked',true);
				$(options.n).show().click(function(){
					$(this).hide();
					$(options.y).show();
					$('body '+options.el+' :checkbox').prop('checked',false);
					return false;
				});
				return false;
			});
		}

	}

	/* 插件 $().webmis */
	$.fn.webmis = function(effect,options){
		// 当前项目
		var obj = $(this);
		// 路由
		switch(effect){

			/* 获取Checkbox的值 */
			case 'getID':
				var defaults = {'type':'one'}
				options = $.extend(defaults,options);
				var id='';
				if(options.type=='one'){
					id = obj.find('input:checked').val();
				}else if(options.type=='json'){
					id = '['
					obj.find('input:checked').each(function(){
						id += '"'+$(this).val()+'",';
					});
					id = id.substr(0,id.length-1);
					if(id){id += ']';}
				}else{
					obj.find('input:checked').each(function(){
						id += $(this).val() + options.type;
					});
					id = id.substr(0,id.length-1);
				}
				// 是否选择
				if(id){
					return id;
				}else{
					$.webmis.win({'content':'<div class="webmis_info err"><em></em>请选择！</div>'});
					return false;
				}
			break;

			/* 隔行变色 */
			case 'oddColor':
				var defaults = {oddClass:'webmis_odd_bg1',overClass:'webmis_odd_bg2',clickClass:'webmis_odd_bg3'}
				options = $.extend(defaults, options);
				//隔行变色
				obj.children(':odd').addClass(options.oddClass);
				//鼠标经过样式变化处
				obj.children().hover(
					function () { 
						$(this).addClass(options.overClass);
					},
					function () { 
						$(this).removeClass(options.overClass);
					}
				).click(function(){
					var checkbox = $(this).find('input:checkbox');
					if(checkbox.prop('checked')==true){
						checkbox.prop('checked',false);
						$(this).removeClass(options.clickClass);
					}else{
						checkbox.prop('checked',true);
						$(this).addClass(options.clickClass);
					}
				});
			break;

		}
	}

});