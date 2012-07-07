{if !$commend_author}
<div class="dialog reg">
 	<div class="bg"></div>
 	<div class="main">
		<form name="form" action="/user/signup" method="POST" enctype="multipart/form-data">
		<dl>
 			<legend>绑定1001夜账号</legend>
 			<p><input type="text" name="username" id="dialog_reg_Email" /> &nbsp;Email地址</p>
			<p>请输入您的常用Email地址</p>
 			<p><input type="password" name="passwd" id="dialog_reg_Pass" /> &nbsp;密码</p>
 			<p><input type="password" name="re_passwd" id="dialog_reg_RePass" /> &nbsp;重复输入密码</p>
 			<p><button type="submit" onclick="signup()">马上注册成为会员</button></p>
			<p class="err_msg"></p>
 		</dl>
 		</form>
 		<dl>
 			<dd><a href="/user/signin?height=404&width=736&modal=true" class="thickbox">您已经拥有账号请直接登录</a></dd>
 			<dt>您还可以使用以下帐号登录</dt>
 			<dd><a href="/sns/redirect?snsid=qq&apptype=web&op=1"><img src="/sta/images/login_qq.jpg" alt="用QQ帐号登录" /></a></dd>
 			<dd><a href="/sns/redirect?snsid=sina&apptype=web&op=1"><img src="/sta/images/login_weibo.jpg" alt="用微博帐号登录" /></a></dd>
 			<dd></dd>
 		</dl>
 	</div>
 	<a href="javascript:void(0)" onclick="self.parent.tb_remove()" class="close">关闭</a>
 </div>
{/if}
 
{if $commend_author}
<!--登录后显示的内容`-->
{/if}
