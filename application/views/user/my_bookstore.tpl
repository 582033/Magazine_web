<div class="right_main">
	<dl class="mag_list clearfix">
		{if $is_me}
		<dt><a href="#" class="sel">已发布的杂志<span>(12)</span></a>　|　<a href="#">未发布的杂志<span>(12)</span></a></dt>
		{/if}
		{foreach from=$bookstore.items item=item}
		{include file="magazine/lib/magcover.tpl"}
		{/foreach}
	</dl>
	{$page_list}
</div>
