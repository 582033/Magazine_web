<div class="dialog login">
	<div class="main">
		<form name="form" action="/user/signin" method="POST" onsubmit="return signin(this)" data-return="{$return}">
			<fieldset>
				<legend>登录1001夜</legend>
				<p class="err_msg"></p>
				<p class="input">
					<label for="dialog_login_Email">Email地址</label><input type="text" name="username" class="username" id="dialog_login_Email" />
					<span><!--class正确为right，错误为error-->请输入您的常用Email地址</span>
				</p>
				<p class="input"><label for="dialog_login_Pass">密码</label><input type="password" name="passwd" class="passwd" id="dialog_login_Pass" /></p>
				<p><button type="submit">登录</button></p>
			</fieldset>
		</form>
		<dl>
			<dd class="right signswitch">
			{if $single_page}
				<a href="/user/signup{if isset($return)}?return={$return}{/if}" class="signup">注册1001夜</a>
			{else}	
				<a href="/user/signupbox" class="thickbox signup">注册1001夜</a>
			{/if}
			</dd>
			<dt>您还可以使用以下帐号登录</dt>
			<dd><a class="box-snslogin" href="/sns/redirect?snsid=qq&apptype=web&op=1"><img src="/sta/images/login_qq.jpg" alt="用QQ帐号登录" /></a></dd>
			<dd><a class="box-snslogin" href="/sns/redirect?snsid=sina&apptype=web&op=1"><img src="/sta/images/login_weibo.jpg" alt="用微博帐号登录" /></a></dd>
			<dd></dd>
		</dl>
	</div>
</div>
<script type="text/javascript">
$(function(){
	if(typeof magSns != 'undefined') {
		magSns.init($('a.box-snslogin'));
	}
})
</script>
