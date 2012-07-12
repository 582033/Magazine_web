<h3>留言板</h3>
<form id="comment" class="comment_sub" action="/magazine/refresh_comment?type=magazine&object_id={$magazine.id}&start=0&limit={$limit}" method="post">
	<div class="reply-comment">
		<a href="#" class="close-reply">x</a>
		<p>回复<a href="#" class="author">用户foo</a><span class="comment-content">回复三位女权主义的口水战</span></p>
		<input type="hidden" name="parent_id" />
	</div>
	<img src="/sta/images/userhear_def.gif" alt="用户头像" />
	<textarea class="text" name="conment"></textarea>
	<button type="button" id="add">发布</button>
</form>
<dl id="comments" class="clearfix">
	{include file="magazine/lib/comments.tpl"}
</dl>


