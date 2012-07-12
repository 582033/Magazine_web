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
	{foreach from=$comment item=item}
	<dt> <a href="{$item.author.url}"><img src="{$item.author.image}" alt="用户头像" /></a> </dt>
	<dd>
		<p class="info">
			<a href="{$item.author.url}" class="author">{$item.author.nickname}</a>
			{if $item.parent}
			回复<a class="author author2" href="{$item.parent.author.url}">{$item.parent.author.nickname}</a>
			{/if}
			<span class="time">({$item.createdAt})</span>
		</p>
		<p class="content">{$item.content}</p>
	</dd>
	<dd class="edit_reply"><a href="javascript:void(0)" class="reply" data-comment-id="{$item.id}" data-author-nickname="{$item.author.nickname}" data-author-id="{$item.author.id}">回复</a></dd>
	{/foreach}
</dl>

