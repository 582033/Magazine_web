<h3>留言板</h3>
<form id="comment" class="comment_sub" action="/magazine/refresh_comment?type=magazine&object_id={$magazine.id}&start=0&limit={$limit}" method="post">
	<div class="reply-comment">
		<a href="#" class="close-reply">x</a>
		<p>回复<a href="#" class="author"></a><span class="comment-content"></span></p>
		<input type="hidden" name="parent_id" />
	</div>
	<img src="{if $user_info}{$user_info.image}!50{else}/sta/images/userhear_def.gif{/if}" alt="{$user_info.nickname|default:'用户'}" />
	<textarea class="text" name="conment"></textarea>
	<button type="button" id="add">发布</button>
</form>
<dl id="comments" class="clearfix">
	{include file="magazine/lib/comments.tpl"}
</dl>
