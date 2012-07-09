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
		switch ($('body').attr('id')) {
		case 'magazine_home':
			init_magazine_home();
			break;
		default:
			break;
		}
});

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

function signin(){	//执行登录{{{
	var options = {
		dataType : 'json',
		success:    function(result) {
			if (result.httpcode == '200') {
				self.parent.tb_remove();
				window.location="/";
			}
			else {
				$(".err_msg").html("<font color='red'>"+result+"</font>");
			}
		}
	};
	$('[name="form"]').ajaxForm(options);
}	//}}}

function signup(){	//注册{{{
	var $form = $('#signup_form');
	if ($('input.passwd', $form).val() != $('input.re_passwd', $form).val()) {
		$('p.err_msg', $form).text('密码不一致');
		return false;
	}

	var options = {
		dataType : 'json',
		success: function(result) {
			if (result == 'seccess') {
				self.parent.tb_remove();
				tb_show("/",false);
			}
			else {
				$(".err_msg").html(result);
			}
		}
	};

	$form.ajaxForm(options);
	return false;
} //}}}

$(function(){
	$(document).on('mouseenter mouseleave', '.element_list dd, .mag_list dd', function(e) {
		var show = e.type == 'mouseenter' ? true : false;
		$(this).find(".mouseover").toggle(show);
	});
	$(document).on('mouseenter mouseleave', '.mouseover .share', function(e) {
		if (e.type == 'mouseenter') {
			$bdshare = $('#bdshare').show();
			$share = $(this).parent().parent().find('.shareto');
			$bdshare.appendTo($share);
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
