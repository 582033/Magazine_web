{include file='header.tpl'}
<div class="main">
	<div class="commonform">
		<div class="title">创建绑定帐号</div>
<p class="error">{if $errormessage} {$errormessage} {/if}</p>
<form name="form" action="/index.php/sns/bind" method="POST">
<p class="p"><label>用户邮箱:</label><input class="busername" type="text" name="username"><span class="perror"></span><br><span class="description">请输入常用邮箱</span></p>
<p class="p"><label>密码:</label><input class="bpasswd" type="password" name="passwd"><span class="perror"></span><br><span class="description">密码长度6-16位</span></p>
<p class="p"><label>确认密码:</label><input class="cpasswd" type="password" name="confirm_passwd"><span class="perror"></span></p>
<input type="hidden" name="new" value="1">
<input type="hidden" name="snsid" value="{$snsid}">
<input type="hidden" name="apptype" value="{$apptype}">
<input type="hidden" name="status" value="{$status}">
<p class="p"><label>&nbsp;</label><input class="subbtn" type="submit" value="绑 定"> <a class="btnra" href="/index.php/sns/bind?new=0&snsid={$snsid}&apptype={$apptype}&status={$status}">绑定已有账号</a></p>
</form>
</div>
</div>
{literal}
<script>
$(function(){
	var $user = $('input.busername');
	var $pwd = $('input.bpasswd');
	var $cpwd = $('input.cpasswd');
	$user.focusout(function(){checkUser()});
	$pwd.focusout(function(){checkPwd()});
	$cpwd.focusout(function(){checkPwd()});
	checkUser = function() {
		if (isEmpty($user.val())) {
			$user.next().text(window.errMessage['userempty']);
			return false;
		}
		if (!checkEmail($user.val())) {
			$user.next().text(window.errMessage['erremail']);
			return false;
		}
		$user.next().text('');
		return true;
	};
	checkPwd = function() {
		if (isEmpty($pwd.val())) {
			$pwd.next().text(window.errMessage['pwdempty']);
			return false;
		}
		if($pwd.val().length<6 || $pwd.val().length>16) {
			$pwd.next().text(window.errMessage['pwdlength']);
			return false;
		}
		if($pwd.val() != $cpwd.val()) {
			$pwd.next().text(window.errMessage['confirmpwd']);
			return false;
		}
		$pwd.next().text('');
		return true;
	}
	$('form').submit(function(){
		if(!checkUser()) return false;
		if(!checkPwd()) return false;
	});
})
</script>
{/literal}
{include file='footer.tpl'}