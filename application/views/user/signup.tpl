{if !$commend_author}
<div class="dialog reg">
	<div class="main">
		<form id="signup_form" name="form" action="/user/signup" onsubmit="return signup(this)" method="POST" enctype="multipart/form-data">
			<fieldset>
 			<legend>注册1001夜账号</legend>
			<p class="err_msg" style="display:none"></p>
			<p>
				<label for="dialog_reg_Email">Email地址</label><input type="text" name="username" class="username" id="dialog_reg_Email" />
				<span><!--class正确为right，错误为error-->请输入您的常用Email地址</span>
			</p>
			<p><label for="dialog_reg_Pass">设置密码</label><input type="password" name="passwd" class="passwd" id="dialog_reg_Pass" /></p>
			<p><label for="dialog_reg_RePass">重复密码</label><input type="password" name="re_passwd" class="re_passwd" id="dialog_reg_RePass" /></p>
			<p><button type="submit">马上注册成为会员</button></p>
			</fieldset>
		</form>
		<dl>
			<dd><a href="/user/signin" class="thickbox signin">您已经拥有账号请直接登录</a></dd>
			<dt>您还可以使用以下帐号登录</dt>
 			<dd><a href="/sns/redirect?snsid=qq&apptype=web&op=1"><img src="/sta/images/login_qq.jpg" alt="用QQ帐号登录" /></a></dd>
 			<dd><a href="/sns/redirect?snsid=sina&apptype=web&op=1"><img src="/sta/images/login_weibo.jpg" alt="用微博帐号登录" /></a></dd>
			<dd></dd>
		</dl>
	</div>
</div>
{else}
<!--登录后显示的内容`-->
{/if}
