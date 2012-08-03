	<script src="/sta/js/cut_str.js"></script>	
	<script>
		$("[name='appc_mag']").submit(function(){
			options = {
				success:function(){
					window.location.href="/user/me/unpublished";
					return false;
				}
			};
			$("[name='appc_mag']").ajaxSubmit(options);
			return false;
		});
		$(function(){
			var max = 280;
			var tips = $("#tips");
			var tips_default = tips.text();
			var area = $("textarea");
			String.prototype.len = function(){ 
				return this.replace(/[^\x00-\xff]/g, "xx").length; 
			}
			msg = function(){
				lng = area.val().len();	
				if (lng <= max){
					tips.text("还可输入"+Math.floor((max - lng)/2)+"字");	
				}
				else {
					area.val(cut_str(area.val(), max));
				}
			}
			area.keyup(msg);
			area.blur(msg);
			area.focusout(function(){
				tips.text(tips_default);
			});	
		});
	</script>
	<div style="margin:20px; line-height:30px">
		<form name="appc_mag" action="/user/appc_mag" method="POST">
				<p class="error_msg"></p>
				<input type="hidden" name="mag_id" value="{$mag_id}">
				<p><label>名称:</label><input type="text" name="name" value="{$mag_info.name}"></p>
				<p><label>类型:</label><select name="mag_category">{html_options values=$mag_category output=$mag_category selected=$mag_info['cate']}</select></p>
				<p><label>tag:</label><input type="text" name="tag" value="{$mag_info.tag}"></p>
				<div id="tips" style="width:300px;float:right;color:#c4c4c4;size:12px">最多输入140字</div>
				<p><label>内容:</label><textarea rows="5" cols="45" name="description">{$mag_info.intro}</textarea></p>
				<button class="btn_set submit" type="submit"><span>发布杂志</span></button>
		</form>
		<div class="pub_request"></div>
	</div>
