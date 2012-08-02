<h3>留言板</h3>
<form id="comment" class="comment_sub" action="/magazine/refresh_comment?type=magazine&object_id={$magazine.id}&start=0&limit={$limit}" method="post">
	<div class="reply-comment">
		<a href="#" class="close-reply">x</a>
		<p>回复<a href="#" class="author"></a><span class="comment-content"></span></p>
		<input type="hidden" name="parent_id" />
	</div>
	<img class="avatar" src="/sta/images/userhear_def.gif" alt="用户" />
	<span style="float:right;margin-bottom:2px;color:#c4c4c4" id="tips">您总共能输入140个字</span>
	<textarea class="text" name="comment"></textarea>
	<button type="button" id="add">发布</button>
</form>
<script src="/sta/js/cut_str.js"></script>
<script>
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
{include file="magazine/lib/comments.tpl"}
