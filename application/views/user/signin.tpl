{if !$commend_author}
<div class="dialog login">
 	<div class="bg"></div>
 	<div class="main">
		<form name="form" action="/user/signin" method="POST" enctype="multipart/form-data">
 		<dl>
 			<legend>登录1001夜</legend>
			<p> <input type="text" name="username" id="dialog_login_Email" /> &nbsp;Email地址 </p>
			<p><!--class正确为right，错误为error-->请输入您的常用Email地址</p>
 			<p><input type="text" name="passwd" id="dialog_login_Pass" /> &nbsp;密码</p>
			<p>请输入您的1001夜密码</p>
 			<p><button type="submit">登录</button></p>
 		</dl>
 		</form>
 		<dl>
 			<dd class="right"><a href="#">注册1001夜</a></dd>
 			<dt>您还可以使用以下帐号登录</dt>
 			<dd><a href="#"><img src="/sta/images/login_qq.jpg" alt="用QQ帐号登录" /></a></dd>
 			<dd><a href="#"><img src="/sta/images/login_weibo.jpg" alt="用微博帐号登录" /></a></dd>
 			<dd></dd>
 		</dl>
 	</div>
 	<a href="javascript:parent.tb_remove();" class="close">关闭</a>
</div>
{/if}
 
{if $commend_author}
<!--登录后显示的内容`-->
{/if}
