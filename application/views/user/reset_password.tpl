{include file="header.tpl"}
<div class="occupying_by_20"></div>
<div class="reset_password">
	<div class="occupying_by_30"></div>
	<div class="container">
		<div class="title">密码重置</div>
		<div class="occupying_by_30"></div>
			<div class="main">
				<form name="reset_pwd" action="/user/reset_password" method="post">
					<div class="reset_pwd"><p class="reset_pwd">重置密码：</p><input type="password" name="reset_pwd" class="reset_pwd" /><p class="err_msg"></p></div>
					<div class="occupying_by_30"></div>
					<div class="pwd_sure"><p class="pwd_sure">确认密码：</p><input type="password" name="pwd_sure" class="pwd_sure" /><p class="err_msg"></p></div>
					<div class="occupying_by_30"></div>
					<button class="submit" /><img src="/sta/images/save_settings.png"></button>
				</form>
			</div>
	</div>
</div>
<div class="occupying_by_30"></div>
{include file="footer.tpl"}
{literal}
<script>
function judge($type){
		if ($("form[name='reset_pwd']").find("input").val().length < 6){
			$("form[name='reset_pwd'] div.error_msg").text('密码不足6位');
		}
		else if ($("input[name='reset_pwd']").val() != $("input[name='pwd_sure']").val()){
			$("form[name='reset_pwd'] div.error_msg").text('两次输入的密码不一致');
		}
		else {
			if ($type == "focusout"){
				$("form[name='reset_pwd'] div.error_msg").text('');
				$("form[name='reset_pwd'] button.submit").attr("disabled", false);
			}
			else {
				var options = {
					dataType : 'json',
					success: function(result) {
						alert(result);
						location.reload();
					}
				};
				$("[name='reset_pwd']").ajaxSubmit(options);
			}
		}
}
$(function(){
	$("form[name='reset_pwd']").find(":input").focusout(function(){
		judge("focusout");
	});
	$(".submit").click(function(){
		judge("click");
		return false;
	});
});
</script>
{/literal}
