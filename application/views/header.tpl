<DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=8" />
<meta name="msapplication-window" content="width=1550;height=768" />
<link rel="stylesheet" type="text/css" href="/sta/styles/reset.css"/>
<link rel="stylesheet" type="text/css" href="/sta/styles/global.css"/>
<link rel="stylesheet" type="text/css" href="/sta/styles/thickbox.css"/>
<title>{$title}</title>
<script type="text/javascript" src="/sta/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/sta/js/jquery.masonry.min.js"></script>
<script type="text/javascript" src="/sta/js/magazine.js"></script>
<script type="text/javascript" src="/sta/js/thickbox.js"></script>
<script type="text/javascript" src="/sta/js/jquery.jscrollpane.min.js"></script>
<!--[if IE 6]>
	<script src="/sta/j/belatedPNG_0.0.8a-min.js"></script>
	<script type="text/javascript">
		DD_belatedPNG.fix('.read,.more a,.userinfo p a,.edit');
	</script>
<![endif]-->
<div class="header">
 	<div class="container clearfix">
 		<a href="#" class="logo"><img src="/sta/images/logo.gif" alt="1001夜" /></a>
 		<ul class="menu">
 			<!--<li class="home"><a href="/home" class="sel">首页</a></li>-->
 			<li class="home"><a href="/home">首页</a></li>
 			<li class="mag"><a href="/mag">杂志</a></li>
 			<li class="find"><a href="/find">发现</a></li>
 			<li class="soft"><a href="/soft">软件</a></li>
 		</ul>
 		
 		<div class="rightcon">
 			<form class="search">
 				<input type="text" value="搜索" />
 				<button type="submit">搜索</button>
 			</form>
	{if isset($userdata['nickname']) && isset($userdata['id']) && isset($userdata['image'])}	
 			<div class="self_info">
 				<div class="user_info">
 					<span>
 					<a href="#">{$userdata.nickname}<img class="userhead_small" src="{$userdata.image}" width="24px" height="24px" /></a>
 					</span>
 					<div onmouseover="document.getElementById('userMenu').style.display='block'" onmouseout="document.getElementById('userMenu').style.display='none'"></div>
 				</div>
 				<div class="clearfix"></div>
 				<a href="#" class="msg_tip"><span>00</span></a>
 				<ul id="userMenu" onmouseover="document.getElementById('userMenu').style.display='block'" onmouseout="document.getElementById('userMenu').style.display='none'">
 					<li><a href="/user/set">账号设置</a></li>
 					<li><a href="/user/">我的收藏</a></li>
 					<li><a href="/user/set">我喜欢的</a></li>
 					<li><a href="/user/msg">站内消息</a></li>
 					<li><a href="/user/logout">退出账号</a></li>
 				</ul>
 			</div>
 		</div>
	{else}
 			<div class="log_reg">
 				<a href="/user/signon" class="reg">注册</a>
 				<a href="/user/signin" class="login" onmouseover="document.getElementById('loginTip').style.display='block'" onmouseout="document.getElementById('loginTip').style.display='none'">登录</a>
 				<form id="loginTip" class="clearfix" onmouseover="document.getElementById('loginTip').style.display='block'" onmouseout="document.getElementById('loginTip').style.display='none'">
 					<p><input type="text" name="username" value="Email地址" /></p>
 					<p><input type="password" name="passwd" value="密码" /></p>
 					<p><a href="#" class="findpass">忘记密码？</a>
 					<input type="checkbox" id="rem_me" class="clear" /><label for="rem_me">下次自动登录</label></p>
 					<p><button type="submit">立即登录</button></p>
 					<p>其他帐号登录：</p>
 					<p><span><a href="#">新浪微博账号登录</a> | <a href="#">QQ账号登录</a></span></p>
 				</form>
 			</div>
	{/if}
     </div>
 </div>
