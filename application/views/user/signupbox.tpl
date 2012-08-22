{if !$commend_author}
<div class="dialog reg">
	<div class="main">
		<form id="signup_form" name="form" action="/user/signup" onsubmit="return signup(this)" method="POST" data-return="{$return}">
			<fieldset>
 			<legend>注册1001夜账号</legend>
			<p class="err_msg" style="display:none"></p>
			<p class="input">
				<label for="dialog_reg_Email">Email地址</label><input type="text" name="username" class="username" id="dialog_reg_Email" value=""/>
				<span><!--class正确为right，错误为error-->请输入您的常用Email地址</span>
			</p>
			<p class="input"><label for="dialog_reg_Pass">设置密码</label><input type="password" name="passwd" class="passwd" id="dialog_reg_Pass" />
				<span><!--class正确为right，错误为error-->密码可以是6-16位字符、数字、符号，区分大小写</span>
				</p>
			<p class="input"><label for="dialog_reg_RePass">重复密码</label><input type="password" name="re_passwd" class="re_passwd" id="dialog_reg_RePass" /></p>
			<p class="agreement"><input type="checkbox" class="agreement" />我已阅读并同意<a href="/legal_statement" target="_BLANK">1001夜法律声明</a></p>
			<p><button type="submit">马上注册成为会员</button></p>
			</fieldset>
		</form>
		<dl>
			<dd class="signswitch">
			{if $single_page}
				<a href="/user/signin{if isset($return)}?return={$return}{/if}" class="signin">您已经拥有账号请直接登录</a>
			{else}
				<a href="/user/signinbox" class="thickbox signin">您已经拥有账号请直接登录</a>
			{/if}
			</dd>
			<dt>您还可以使用以下帐号登录</dt>
 			<dd><a class="box-snslogin" href="/sns/redirect?snsid=qq&apptype=web&op=1"><img src="/sta/images/login_qq.jpg" alt="用QQ帐号登录" /></a></dd>
 			<dd><a class="box-snslogin" href="/sns/redirect?snsid=sina&apptype=web&op=1"><img src="/sta/images/login_weibo.jpg" alt="用微博帐号登录" /></a></dd>
			<dd></dd>
		</dl>
	</div>
</div>
{else}
<!--登录后显示的内容`-->
{/if}
<script type="text/javascript">
	$(function(){
		if(typeof magSns != 'undefined') {
			magSns.init($('a.box-snslogin'));
		}
		var err_msg = function(content){
				$(".main").find(".err_msg").text(content).show();
		}
		$("input.passwd").keyup(function(){
			var passwd = $("#dialog_reg_Pass").val();
			var re_passwd = $("#dialog_reg_RePass").val();
			if (passwd.length < 6) {
				err_msg("密码长度不能小于6位");
				return false;
			}
			else if (passwd.length > 16) {
				err_msg("密码长度不能大于16位");
				return false;
			}
			else if (passwd !== re_passwd) {
				err_msg("密码不一致");
			}
			else {
				err_msg("");
				return true;
			}

		});
		$("input.re_passwd").keyup(function(){
			var passwd = $("#dialog_reg_Pass").val();
			var re_passwd = $("#dialog_reg_RePass").val();
			if (passwd !== re_passwd) {
				err_msg("密码不一致");
			}
			else {
				err_msg("");
				return true;
			}
		});
		$("#signup_form").find(":input").focusout(function(){
			var email = $("#dialog_reg_Email").val();
			var passwd = $("#dialog_reg_Pass").val();
			var re_passwd = $("#dialog_reg_RePass").val();
			var check_result = function(result){
				if(result.status == 'USER_EXISTS'){
					err_msg("用户名已存在");
				}
				else if (!email) {
					err_msg("Email不能为空");
					return false;
				}
				else if (!passwd) {
					err_msg("密码不能为空");
					return false;
				}
				else if (re_passwd.length < 6) {
					err_msg("密码长度不能小于6位");
					return false;
				}
				else if (re_passwd.length > 16) {
					err_msg("密码长度不能大于16位");
					return false;
				}
			}
			if (!checkEmail(email)) {
				err_msg("Email格式不正确");
				return false;
			}
			else {
				options = {
							type:"get",
							async:false,
							url:"http://api.in1001.com/v1/user/checkexists?username=" + email + "&callback=?",
							dataType : "jsonp",
							success:check_result,
					 };
				$.ajax(options);
			}
		});		
	});
</script>
