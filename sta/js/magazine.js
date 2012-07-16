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
		detail_resize();
		init_search();
		init_goto_page();
		init_comment();
		init_colorbox();
		init_user_center();
		switch ($('body').attr('id')) {
		case 'magazine_home':
			init_magazine_home();
			break;
		default:
			break;
		}
});


function init_user_center() { //{{{
	align_height();
	var $curnick = $('.follows span.curnick');
	$(".follows a").hover(
			function() {
				var h = $(this).parent().height();
				var pos = $(this).position();
				$(".follows .gray").height(h).show();
				$(this).css("z-index", "999");
				$curnick.width(153);
				var top = 0;
				if(pos.top > h - 60) { // the last line
					if (pos.top == 0) {
						top = 0;
						if (pos.left == 51) {
							$curnick.width(50);
						}
					}
					else {
						top = pos.top - 51;
					}
				}
				else {
					top = pos.top + 51;
				}
				$curnick.text($(this).find('span').text())
					.css('top', top)
					.show();
			},
		function(){
			$(".follows. .gray").hide();
			$curnick.hide();
			$(this).css("z-index","0");
		});
} //}}}
function init_colorbox() { // {{{
	$(document).on('cbox_closed', function(){
		if (!$.colorbox.element().attr('id') == 'msgbox') {
			window.location.reload();
		}
	});
	var opts = {
		overlayClose: false,
		fixed: true,
		opacity: 0.5
	};
	$(document).on('click', 'a.thickbox', function() {
		$(this).colorbox($.extend({}, opts, {open: true}));
		return false;
	});
} // }}}

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

function align_height() { //{{{
	var pageh = $(".main_left_line").height();
	if ($(".sidebar_left").height() < pageh){
		$(".sidebar_left").height(pageh - 1);
	}
	if ($(".right_main").height() < pageh){
		$(".mag_list").height(pageh);
	}

	page_height = $(".set_main").innerHeight(true);
	if ($(".set_menu").height() < page_height) {
		$(".set_menu").css("height", page_height+"px");
	}

} //}}}

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
	if (!$('input.agreement').is(':checked')) {
		return error('您必须同意1001夜法律声明');
	}

	var messages = {
		'USER_EXISTS': '用户名已存在'
	};
	var options = {
		dataType : 'json',
		success: function(result) {
			if (result.status == 'OK') {
				if ($form.data('return')) { // single signin page
					window.location.href = $form.data('return');
				}
				else { // signin popup
					$.colorbox.close();
				}
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
			text = title+' '+des+'......';
			break;
		case 2:
			if (id) url=id;
			text = title+' （来自 1001夜互动阅读平台）'+'......';
			break;
		default:
			return;
		}
		window.bds_config.bdText = text;
		window.bds_config.bdPic = img;
		$('#bdshare').attr('data','{url:"'+url+'"}');
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
});


function close_comment_reply() {
	var $replyc = $('#comment div.reply-comment').hide();
	$replyc.hide();
	$('input', $replyc).val('');
}
function init_comment() { //{{{
	$("#add").click(function (){
		var options = {
			dataType: 'html',
			success: function (result) {
				var $html = $(result);
				var total = $html.data('total');
				if (total > 5) { // for magazine detail page
					$('p.more_comment').show();
				}
				$("#comments").html($html.html());
				$("#comment textarea").val('');
				close_comment_reply();
			}
		};
		if (!$.trim($('#comment textarea').val())) return false;
		$("#comment").ajaxSubmit(options);
	});
	var $replyc = $('#comment div.reply-comment').hide();
	$('.close-reply', $replyc).click(close_comment_reply);
	$(document).on('click', '#comments .reply', function () {
		var content = $(this).parent().prev('dd').find('p.content').text();
		var authorUrl = $(this).parent().prev('dt').find('a').attr('href');
		var data = $(this).data();
		$('span.comment-content', $replyc).text(content);
		$('a.author', $replyc)
			.text(data.authorNickname)
			.attr('href', authorUrl);
		$('input', $replyc).val(data.commentId);
		$("#comment textarea").focus();
		$replyc.show();
	});
} //}}}

// vim: fdm=marker
