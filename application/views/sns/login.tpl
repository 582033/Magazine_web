{include file='header.tpl'}
<div class="main">
	<div class="commonform">
		<div class="title">绑定已有帐号</div>
<p class="error">{if $errormessage} {$errormessage} {/if}</p>
<form name="form" action="/index.php/sns/bind" method="POST">
<p class="p"><label>用户邮箱:</label><input type="text" name="username"><span class="perror"></span></p>
<p class="p"><label>密码:</label><input type="password" name="passwd"><span class="perror"></span></p>
<input type="hidden" name="new" value="0">
<input type="hidden" name="snsid" value="{$snsid}">
<input type="hidden" name="apptype" value="{$apptype}">
<input type="hidden" name="status" value="{$status}">
<p class="p"><label>&nbsp;</label><input class="subbtn" type="submit" value="绑 定"> <a class="btnra" href="/index.php/sns/bind?new=1&snsid={$snsid}&apptype={$apptype}&status={$status}">绑定新账号</a></p>
</form>
	</div>
</div>
{literal}
<script>
$(function(){
	var $user = $('input[name="username"]');
	var $pwd = $('input[name="passwd"]');
	var $cpwd = $('input[name="confirm_passwd"]');
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
{include file='footer_big.tpl'}