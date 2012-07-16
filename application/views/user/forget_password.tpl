{include file="header.tpl"}
<div class="occupying_by_30"></div>
<div class="forget_password">
	<div class="occupying_by_30"></div>
	<div class="container">
		<div class="title">忘记密码</div>
		<div class="occupying_by_30"></div>
		<div class="main">
			<form action="/user/forget_password" name="forget_pwd" method="post">
				<p class="email_address">邮箱地址：</p>
				<div class="main_body">
					<input type="text" name="email" class="email" /><div class="return_msg"></div>
					<div class="occupying_by_5"></div>
					<div class="description">请输入您注册用的邮箱地址，系统会将您重置密码的链接发送到您注册用的邮箱中</div>
				</div>
				<div class="occupying_by_20"></div>
				<button class="find" /><img src="/sta/images/find_password.png"></button>
				<div class="error_msg"></div>
			</form>
		</div>
	</div>
</div>
<div class="occupying_by_30"></div>
{include file="footer.tpl"}
{literal}
<script>
function send_email($type){
		if ($("form[name='forget_pwd']").find("input").val().length == 0){
			$("form[name='forget_pwd'] div.error_msg").text('邮箱不能为空');
		}
		else {
			if ($type == "focusout"){
				$("form[name='forget_pwd'] div.error_msg").text('');
				$("form[name='forget_pwd'] button.submit").attr("disabled", false);
			}
			else {
				var options = {
					dataType : 'json',
					success: function(result) {
						if (result == 'true'){
							showMsgbox('已经向您填写的邮箱中发送确认邮件，请登录邮箱，点击确认链接，完成密码修改', '/');
						}else if (result == 'false'){
							$("form[name='forget_pwd'] div.return_msg").text("邮箱错误，请检查您填写的邮箱");
						}else if (result == 'error'){
							$("form[name='forget_pwd'] div.return_msg").text("发送失败，请稍后重试");
						}
					}
				};
				$("[name='forget_pwd']").ajaxSubmit(options);
			}
		}
}
$(function(){
	$("form[name='forget_pwd']").find(":input").focusout(function(){
		send_email("focusout");
	});
	$("form[name='forget_pwd']").find(":input").focus(function(){
		$("form[name='forget_pwd'] div.return_msg p").text('');
	});
	$("button.find").click(function(){
		send_email("click");
		return false;
	});
});
</script>
{/literal}
