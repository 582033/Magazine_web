<div class="set_main pwd">
	<div class="modify_password">
		<div class="container">
			<div class="title">修改密码</div>
			<div class="occupying_by_10"></div>
			<div class="main">
				<form action="/user/set_pwd" name="modify_pwd" onsubmit="return changePassword(this)" method="POST">
					<p class="error_msg"></p>
					<p><label for="old_pwd">原始密码：</label><input type="password" name="old_pwd" id="old_pwd" /></p>
					<p><label for="reset_pwd">重置密码：</label><input type="password" name="reset_pwd" id="reset_pwd" /></p>
					<p><label for="pwd_sure">确认密码：</label><input type="password" name="pwd_sure" id="pwd_sure" /></p>
					<button class="btn_set submit" type="submit"><span>完成</span></button>
				</form>
			</div>
		</div>
	</div>
</div>
