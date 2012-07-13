<dl id="comments" class="clearfix"{if $totalComments} data-total="{$totalComments}{/if}">
{foreach from=$comments item=item}
<dt> <a href="{$item.author.url}"><img src="{$item.author.image}!50" alt="用户头像" /></a> </dt>
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

