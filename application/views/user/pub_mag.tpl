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
		<fieldset>
			<br>
			<input type="hidden" name="mag_id" value="{$mag_id}">
			<p>名称:<input type="text" name="name" value="{$mag_info.name}"></p><br>
			<p>类型:<select>{html_options values=$mag_category output=$mag_category selected=$mag_info['cate']}</select></p><br>
			<p>tag:<input type="text" name="tag" value="{$mag_info.tag}"></p><br>
			<p>内容:<textarea row="3" cols="20" name="description">{$mag_info.intro}</textarea></p><br>
			<p><button type="submit">发布</button></p>
		</fieldset>
	</form>
	<div class="pub_request"></div>
