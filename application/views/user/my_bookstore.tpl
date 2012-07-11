<div class="right_main">
	<dl class="mag_list clearfix">
		{if $is_me}
		<dt><a href="/user/me/published" {if $type=='published'}class="sel"{/if}>已发布的杂志<span>({$bookstore[0].pub_total})</span></a>　|　<a href="/user/me/unpublished" {if $type=='unpublished'}class="sel"{/if}>未发布的杂志<span>({$bookstore[0].unpub_total})</span></a></dt>
		{/if}
		{foreach from=$bookstore.items item=item}
		{include file="magazine/lib/magcover.tpl" cover_show_status=$is_me}
		{/foreach}
	</dl>
	{$page_list}
</div>
