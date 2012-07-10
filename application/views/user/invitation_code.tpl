<div id="apply_author" class="dialog apply_author reg">
<!--
 	<div class="bg"></div>
-->
 	<div class="main">
		<form id="apply_author_form" name="apply_author_form" onsubmit="return applyAuthor(this)" action="/user/applyAuthor/apply" method="POST" enctype="multipart/form-data">
			<dl>
				<legend>请输入邀请码</legend>
				<p><input type="text" name="code" class="code" /></p>
				<p><button type="submit">申请成为作者</button></p>
				<p class="err_msg"></p>
			</dl>
 		</form>
 	</div>
 	<div class="apply_ok" style="display:none">
		恭喜, 你已成为作者, 现在你可以下载<a href="/soft/pc">制作工具</a>开始你的1001夜之旅.
 	</div>
 	<a href="javascript:void(0)" onclick="self.parent.tb_remove()" class="close">关闭</a>
 </div>
