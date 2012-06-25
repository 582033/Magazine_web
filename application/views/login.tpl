<script src="/sta/js/thickbox.js"></script>
<script src="/sta/js/jquery-1.7.2.min.js"></script>
 <form name="form" action="/magazine/login" method="POST" enctype="multipart/form-data">
username:<input type="text" name="username"><br />
password:<input type="text" name="passwd"><br />
<input type="submit">
</form>

 
<div class="dialog login" style="display:none;">
<div class="bg"></div>
<div class="main">
	<form>
		<fieldset>
		<legend>登录1001夜</legend>
		<p>
			<label for="dialog_login_Email">Email地址</label><input type="text" id="dialog_login_Email" />
			<span><!--class正确为right，错误为error-->请输入您的常用Email地址</span>
		</p>
		<p><label for="dialog_login_Pass">密码</label><input type="text" id="dialog_login_Pass" /></p>
		<p><button type="submit">登录</button></p>
		</fieldset>
	</form>
	<dl>
		<dd class="right"><a href="#">注册1001夜</a></dd>
		<dt>您还可以使用以下帐号登录</dt>
		<dd><a href="#"><img src="images/login_qq.jpg" alt="用QQ帐号登录" /></a></dd>
		<dd><a href="#"><img src="images/login_weibo.jpg" alt="用微博帐号登录" /></a></dd>
		<dd></dd>
	</dl>
</div>
<a href="javascript:void(0);" class="close">关闭</a>
</div>
