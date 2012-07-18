<script>
	$("[name='pub_mag']").submit(function(){
		options = {
			success:function(){
				window.location.href="/user/me/published";
				return false;
			}
		};
		$("[name='pub_mag']").ajaxSubmit(options);
		return false;
	});
</script>	
	<form name="pub_mag" action="/user/pub_mag" method="POST">
			<p class="error_msg"></p>
			<input type="hidden" name="mag_id" value="{$mag_id}">
			<p><label>名称:</lable><input type="text" name="name" value="{$mag_info.name}"></p>
			<p><label>类型:</label><select>{html_options values=$mag_category output=$mag_category selected=$mag_info['cate']}</select></p>
			<p><label>tag:</label><input type="text" name="tag" value="{$mag_info.tag}"></p>
			<p><label>内容:</label><textarea row="3" cols="20" name="description">{$mag_info.intro}</textarea></p>
			<p><button type="submit">发布</button></p>
		<button class="btn_set submit" type="submit"><span>完成</span></button>
	</form>
	<div class="pub_request"></div>
