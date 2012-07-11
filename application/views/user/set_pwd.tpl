<div class="set_main pwd">
	<div class="occupying_by_20"></div>
	<div class="modify_password">
		<div class="occupying_by_30"></div>
		<div class="container">
			<div class="title">密码修改</div>
			<div class="occupying_by_30"></div>
				<div class="main">
					<form action="/user/set_pwd" name="modify_pwd" method="post">
						<div class="old_pwd"><p class="old_pwd">原始密码：</p><input type="password" name="old_pwd" class="old_pwd" /></div>
						<div class="occupying_by_30"></div>
						<div class="reset_pwd"><p class="reset_pwd">重置密码：</p><input type="password" name="reset_pwd" class="reset_pwd" /></div>
						<div class="occupying_by_30"></div>
						<div class="pwd_sure"><p class="pwd_sure">确认密码：</p><input type="password" name="pwd_sure" class="pwd_sure" /></div>
						<div class="occupying_by_30"></div>
						<button class="btn_set submit" disabled="disabled"><span>完成</span></button>
						<div class="error_msg"></div>
					</form>
				</div>
		</div>
	</div>
	<div class="occupying_by_20"></div>
</div>
{literal}
<script>
function judge($type){
		if ($("form[name='modify_pwd']").find("input").val().length < 6){
			$("form[name='modify_pwd'] div.error_msg").text('密码不足6位');
		}
		else if ($("input[name='reset_pwd']").val() != $("input[name='pwd_sure']").val()){
			$("form[name='modify_pwd'] div.error_msg").text('两次输入的密码不一致');
		}
		else {
			if ($type == "focusout"){
				$("form[name='modify_pwd'] div.error_msg").text('');
				$("form[name='modify_pwd'] button.submit").attr("disabled", false);
			}
			else {
				var options = {
					dataType : 'json',
					success: function(result) {
						alert(result);
						if (result == '修改成功'){
							location.reload();
						}
					}
				};
				$("[name='modify_pwd']").ajaxSubmit(options);
			}
		}
}
$(function(){
	$("form[name='modify_pwd']").find(":input").focusout(function(){
		judge("focusout");
	});
	$(".submit").click(function(){
		judge("click");
		return false;
	});
});
</script>
{/literal}
