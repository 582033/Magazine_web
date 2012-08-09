{include file="header.tpl"}
<div class="occupying_by_30"></div>
<div class="forget_password">
	<div class="occupying_by_30"></div>
	<div class="container">
		<div class="title">忘记密码</div>
		<div class="occupying_by_30"></div>
		<div class="main" id="send">
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
		<div class="main" id="resend">
				<div class="access_msg" style="font-size:15px;margin-bottom:10px"></div>
				<div style="font-size:15px;">没有收到?请<input type="submit" id="general_button" value="v重新发送"></div>
		</div>
	</div>
</div>
<div class="occupying_by_30"></div>
{include file="footer.tpl"}
{literal}
<script>
	var secs = 10;
	function jishi () {
		setInterval("update()", 1000);
	}
	function update() {
		if (secs > 0) {
			$("#general_button").attr("disabled","disabled");
			$("#general_button").val("重新发送(" + secs-- + ")");
		} 
		else {
			$("#general_button").removeAttr("disabled");
			$("#general_button").val("重新发送");
		}
	}
	function send_email($type){
			var email = $("form[name='forget_pwd']").find("input").val();
			if (email.length == 0){
				$("form[name='forget_pwd'] div.error_msg").text('邮箱不能为空'); } else {
				if ($type == "focusout"){
					$("form[name='forget_pwd'] div.error_msg").text('');
					$("form[name='forget_pwd'] button.submit").attr("disabled", false);
				}
				else {
					var options = {
						dataType : 'json',
						success: function(result) {
							if (result == 'true'){
								$("#resend").show();
								$("#send").hide();
								$(".access_msg").html("已经成功将'找回密码'邮件发送至您的邮箱<b>"+ email +"</b>。请查看邮件，重新设置密码！");
								jishi();
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
		$("#resend").hide();
		$("#send").show();
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
		$("#general_button").click(function(){
			window.location.reload();
			return false;
		});
	});
</script>
{/literal}
