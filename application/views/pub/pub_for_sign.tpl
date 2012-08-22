<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=8" />
		<meta property="wb:webmaster" content="1c5a1d0fe7c84888" />
		<meta name="msapplication-window" content="width=1550;height=768" />
		<meta name="keywords" content="1001夜,旅游,杂志,阅读,旅游攻略,游记,自助游,电子杂志,国内旅游,国外旅游,旅游图片,做杂志,精品内容,目的地,期刊" />
		<meta name="description" content="1001夜是一款集高质阅读、多媒体杂志制作工具、发行平台、数据统计于一身的互动阅读平台。享受全新阅读体验，尽享实用的移动旅游攻略。" />
		<link rel="stylesheet" type="text/css" href="/sta/styles/reset.css"/>
		<link rel="stylesheet" type="text/css" href="/sta/styles/global.css"/>
		<link rel="stylesheet" type="text/css" href="/sta/styles/main.css"/>
		<link rel="stylesheet" type="text/css" href="/sta/colorbox/colorbox.css"/>
		<title>{$title}</title>
		<script type="text/javascript" src="http://sta.in1001.com/lib/jquery/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="http://sta.in1001.com/lib/jquery/jquery.cookie.js"></script>
		<script type="text/javascript" src="http://sta.in1001.com/lib/jquery/jquery.form.js"></script>
		<script type="text/javascript" src="http://sta.in1001.com/lib/jquery/jquery.colorbox.js"></script>
		<script type="text/javascript" src="/sta/js/main.js"></script>
		<script type="text/javascript" src="/sta/js/magazine.js"></script>
		<script type="text/javascript" src="/sta/js/check.js"></script>
		<!--[if IE 6]>
		<script src="/sta/js/belatedPNG_0.0.8a-min.js"></script>
		<script type="text/javascript">
			DD_belatedPNG.fix('.read,.more a,.userinfo p a,.edit');
			DD_belatedPNG.fix('.light,.downbtn'); // for soft page
		</script>
		<![endif]-->
		<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-20568933-8']);
			_gaq.push(['_trackPageview']);

			(function() {
			 var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			 ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			 var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			 })();
		{literal}
		document.domain = 'in1001.com';
		function finish() {
			parent.$.colorbox.close();
		}
		$(function(){
			$a = $('.signswitch a');
			$a.bind('click',function(){window.location=this.href;return false;}); 
			$('.box-snslogin').each(function(){this.href=this.href+"&return="+encodeURIComponent('/magazine/pub_for_sign?close=true')});
			$('.box-snslogin').click(function(){return false;});
			$loginForm = $('.login form');
			$regForm = $('.reg form');
			if ($loginForm.length==1) {
				$a.attr('href','/magazine/pub_for_sign?do=up');
				$loginForm.get(0).onsubmit = function(){return signin(this,finish)};
			}
			if ($regForm.length==1) {
				$a.attr('href','/magazine/pub_for_sign?do=in');
				$regForm.get(0).onsubmit = function(){return signup(this,finish)};
			}
		});
		{/literal}
		</script>
	</head>
	<body{if isset($pageid)} id="{$pageid}"{/if}>
{if $close}
	{literal}
	<script>$(function(){finish();})</script>
	{/literal}
{else if $do=='in'}
	{include file='user/signinbox.tpl'}
{else if $do=='up'}
	{include file='user/signupbox.tpl'}
{/if}
	</body>
</html>

