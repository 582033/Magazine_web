<div id="apply_author" class="dialog apply_author">
 	<div class="main">
		<form id="apply_author_form" name="apply_author_form" onsubmit="return applyAuthor(this)" action="/user/applyAuthor/apply" method="POST">
				<legend>请输入你的邀请码</legend>
				<p class="err_msg"></p>
				<p><input type="text" name="code" class="code" /></p>
				<p><button type="submit">提交</button></p>
 		</form>
 	</div>
 	<div class="apply_ok" style="display:none">
		<div class="good_icon"></div>
		<span>恭喜你成为1001夜作者</span>
 	</div>
 </div>
