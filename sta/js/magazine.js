$.format = function (source, params) { //{{{
     if (arguments.length == 1)
         return function () {
             var args = $.makeArray(arguments);
             args.unshift(source);
             return $.format.apply(this, args);
         };
     if (arguments.length > 2 && params.constructor != Array) {
         params = $.makeArray(arguments).slice(1);
     }
     if (params.constructor != Array) {
         params = [params];
     }
     $.each(params, function (i, n) {
         source = source.replace(new RegExp("\\{" + i + "\\}", "g"), n);
     });
     return source;
 }; //}}}
 
$(function() {
		resize();
		detail_resize();
		init_search();
		init_goto_page();
		init_comment();
		init_colorbox();
		switch ($('body').attr('id')) {
		case 'magazine_home':
			init_magazine_home();
			break;
		default:
			break;
		}
});

function init_colorbox() {
	$(document).on('cbox_closed', function(){
		window.location.reload();
	});
	var opts = {
		overlayClose: false,
		fixed: true,
	};
	$(document).on('click', 'a.thickbox', function() {
		$(this).colorbox($.extend({}, opts, {open: true}));
		return false;
	});
}

function init_magazine_home() { //{{{
	var $mags = $('dl.mag_list');
	$('dd.menu a', $mags).click(function() {
		$('dd.menu a', $mags).removeClass('sel');
		$(this).addClass('sel');
		$('div.tabs > div', $mags).hide()
		$('div.' + this.id, $mags).show();
	});
} //}}}

function init_search() { // {{{
	$('#search_top,#search_big').each(function() {
		var $q = $(this).find('input[name="q"]');
		$q.blur(function() {
			if (!this.value) this.value = '请输入关键字';
			$(this).addClass('graytext');
			}).focus(function() {
				if (this.value == '请输入关键字') this.value = '';
				$(this).removeClass('graytext');
			});
		$(this).submit(function() {
			if ($q.val() == '' || $q.val() == '请输入关键字') return false;
			window.location.href = this.action + '/' + encodeURI($q.val());
			return false;
			});
		});
} //}}}

function init_goto_page() { // {{{
	$('div.pagearea form').submit(function() {
			$p = $(this).find('input[name="goto"]');
			var gotop = parseInt($p.val());
			var totalPage = parseInt($(this).find('.totalPage').text());
			if (!gotop || gotop > totalPage) return false;
			window.location.href = this.action + '/p/' + gotop;
			return false;
			});
} //}}}

function detail_resize(){ //{{{
	page_height = $(".main").height();
	if ($(".left_main").height()<page_height){
		$(".left_main").css("height",page_height+"px");
	}
	$(".scrollbar ul").css("width",$(".scrollbar li").outerWidth(true)*$(".scrollbar li").size()+"px");
	$(function(){
		$('.scrollbar').jScrollPane({
				autoReinitialise: true
			});
	})
} //}}}

function resize(){ //{{{
	page_height = $(".main_left_line").height();
	if ($(".sidebar_left").height()<page_height){
		$(".sidebar_left").css("height",$(".main_left_line").height()-1+"px");
	}
	if ($(".right_main").height()<page_height){
		$(".mag_list").css("height",$(".main_left_line").height()+"px");
	}
} //}}}

function signin(form) {	// {{{
	var $form = $(form);
	function error(msg) {
		$('.err_msg', $form).text(msg).show();
		return false;
	}
	var messages = {
		'AUTH_FAIL': '错误的用户名或密码'
	};
	var username = $('input.username', $form).val();
	if (!username) return error('Email不能为空');

	var options = {
		dataType : 'json',
		success: function(result) {
			if (result.status == 'OK') {
				$.colorbox.close();
			}
			else {
				error(messages[result.status] || result.status);
			}
		},
		error: function() {
				   error('未知错误');
		}

	};
	$form.ajaxSubmit(options);
	return false;
}	//}}}

function signup(form) {	// {{{
	var $form = $(form);
	function error(msg) {
		$('p.err_msg', $form).text(msg).show();
		return false;
	}
	var email = $('input.username', $form).val();
	var passwd = $('input.passwd', $form).val();
	var re_passwd = $('input.re_passwd', $form).val();
	if (!email) {
		return error('Email不能为空');
	}
	if (!checkEmail(email)) {
		return error('Email格式不正确');
	}
	if (!passwd) {
		return error('密码不能为空');
	}
	if (passwd != re_passwd) {
		return error('密码不一致');
	}

	var messages = {
		'USER_EXISTS': '用户名已存在'
	};
	var options = {
		dataType : 'json',
		success: function(result) {
			if (result.status == 'OK') {
				$.colorbox.close();
			}
			else {
				error(messages[result.status] || result.status);
			}
		}
	};

	$form.ajaxSubmit(options);
	return false;
} //}}}
function applyAuthor(form){	// {{{ 申请成为作者
	var $form = $(form);
	if (! $('input.code', $form).val()) {
		$('p.err_msg', $form).text('请输入邀请码');
		return false;
	}

	var options = {
		dataType : 'json',
		success: function(result) {
			if (result.status == 'OK') {
				$('#apply_author div.main').hide();
				$('#apply_author div.apply_ok').show();
				setTimeout(function() {$.colorbox.close()}, 3000);
			}
			else {
				$(".err_msg").html(result.message);
			}
		}
	};

	$form.ajaxSubmit(options);
	return false;
} //}}}

$(function(){
	var getShareConfig = function($share) {
		if (typeof window.bds_config=='undefined' || typeof window.bdShare =='undefined') return;
		var title=des=img=id='';
		var text = url = null;
		var urlPre = 'http://www.in1001.com';
		if ($share.data('title')) title=$share.data('title');
		if ($share.data('des')) des = $share.data('des');
		if ($share.data('img')) img = $share.data('img');
		if ($share.data('id')) id = $share.data('id');
		switch ($share.data('type')) {
		case 1:
			if (id) url=urlPre+'/magazine/detail/'+id;
			text = title+' '+des+'......'+url;
			break;
		case 2:
			if (id) url=id;
			text = title+' （来自 1001夜互动阅读平台）'+'......'+url;
			break;
		default:
			return;
		}
		window.bds_config.bdText = text;
		window.bds_config.bdPic = img;
		window.bdShare.fn.init();
	};
	$(document).on('mouseenter mouseleave', '.element_list dd, .mag_list dd', function(e) {
		var show = e.type == 'mouseenter' ? true : false;
		$(this).find(".mouseover").toggle(show);
	});
	$(document).on('mouseenter mouseleave', '.mouseover .share', function(e) {
		if (e.type == 'mouseenter') {
			$bdshare = $('#bdshare').show();
			$share = $(this).parent().parent().find('.shareto');
			$bdshare.appendTo($share);
			getShareConfig($(this));
			$share.show();
		}
		else {
			$share = $(this).parent().parent().find('.shareto');
			$share.hide();
		}
	});
	$(document).on('mouseenter mouseleave', '.mouseover .shareto', function(e) {
		var show = e.type == 'mouseenter' ? true : false;
		$(this).toggle(show);
	});

    $(".follows a").mouseenter(function(){
        $(".follows .gray").css("display","block");
        $(this).css("z-index","999");
        $(this).find("span").css("left","-"+$(this).position().left+"px");
        $(this).find("span").css("display","block");
		if($(this).position().top>150){
        	$(this).find("span").css("top","-35px");
        }
    });
    $(".follows a").mouseleave(function(){
        $(".gray").css("display","none");
        $(this).find("span").css("display","none");
        $(this).css("z-index","0");
    });
})


function init_comment() { //{{{
	$("#add").click(function (){
		var options = {
			dataType: 'json',
			success: function (result) {
				refresh_comments(result);
			},
		};
		$("#comment").ajaxSubmit(options);
	})

	$(document).on('click', '#comments .reply', function () {
		$("#comment .text").focus()
			.val("回复 " + $(this).data('authorNickname') + "：");
	});
} //}}}

function refresh_comments(result) { //{{{
	$("#list").html("");
	var div = "";
	var templ = "<dt><a href='{0}'><img src='{1}' alt='用户头像' /></a></dt><dd><p class='info'><a href='{0}' class='author'>{2}</a><span></span></p><p>{3}</p></dd><dd class='edit_reply'>" +
		'<a href="javascript:void(0)" class="reply" data-comment-id="{4}" data-author-nickname="{2}" data-author-id="{5}">回复</a></dd>';
	for(i=0; i<result.length; i++){
		var c = result[i];
		var  a = c.author;
		div += $.format(templ, a.url, a.image, a.nickname, c.content, c.id, a.id);
	}
	$("#comments").html(div);
	$(".text").val('');
} //}}}

// vim: fdm=marker
