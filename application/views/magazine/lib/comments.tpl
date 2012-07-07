<dl id="comments" class="clearfix">
	{foreach from=$comment item=item}
	<dt><a href="{$item.author.url}"><img src="{$item.author.image}" alt="用户头像" /></a></dt>
	<dd>
		<p class="info"><a href="{$item.author.url}" class="author">{$item.author.nickname}</a><span></span></p>
		<p>{$item.content}</p>
	</dd>
	<dd class="edit_reply"><a href="javascript:void(0)" class="reply" data-comment-id="{$item.id}" data-author-nickname="{$item.author.nickname}" data-author-id="{$item.author.id}">回复</a></dd>
	{/foreach}
</dl>

