<link rel="stylesheet" type="text/css" href="/sta/styles/reset.css"/>
<link rel="stylesheet" type="text/css" href="/sta/styles/global.css"/>
<script src="/sta/js/thickbox.js"></script>
<script src="/sta/js/jquery-1.7.2.min.js"></script>

{if !$commend_author}
<div class="dialog login">
 	<div class="bg"></div>
 	<div class="main">
		<form name="form" action="/user/signin" method="POST" enctype="multipart/form-data">
 			<fieldset>
 			<legend>登录1001夜</legend>
 			<p>
 				<label for="dialog_login_Email">Email地址</label><input type="text" name="username" id="dialog_login_Email" />
 				<span><!--class正确为right，错误为error-->请输入您的常用Email地址</span>
 			</p>
 			<p><label for="dialog_login_Pass">密码</label><input type="text" name="passwd" id="dialog_login_Pass" /></p>
 			<p><button type="submit">登录</button></p>
 			</fieldset>
 		</form>
 		<dl>
 			<dd class="right"><a href="#">注册1001夜</a></dd>
 			<dt>您还可以使用以下帐号登录</dt>
 			<dd><a href="#"><img src="/sta/images/login_qq.jpg" alt="用QQ帐号登录" /></a></dd>
 			<dd><a href="#"><img src="/sta/images/login_weibo.jpg" alt="用微博帐号登录" /></a></dd>
 			<dd></dd>
 		</dl>
 	</div>
 	<a href="javascript:void(0);" class="close">关闭</a>
 </div>
{/if}
 
{if $commend_author}
{/if}
