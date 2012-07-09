<div class="right_main">
	<dl class="mag_list clearfix">
		{foreach from=$magazine.items item=item}
		{include file="magazine/lib/magcover.tpl" cover_show_del=$is_me}
		{/foreach}
	</dl>
	{$page_list}
</div>
