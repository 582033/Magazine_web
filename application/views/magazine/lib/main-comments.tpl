<h3>留言板</h3>
<form id="comment" class="comment_sub" action="/magazine/refresh_comment?type=magazine&object_id={$magazine.id}&start=0&limit={$limit}" method="post">
	<div class="reply-comment">
		<a href="#" class="close-reply">x</a>
		<p>回复<a href="#" class="author"></a><span class="comment-content"></span></p>
		<input type="hidden" name="parent_id" />
	</div>
	<img class="avatar" src="/sta/images/userhear_def.gif" alt="用户" />
	<textarea class="text" name="comment"></textarea>
	<button type="button" id="add">发布</button>
</form>
{include file="magazine/lib/comments.tpl"}
