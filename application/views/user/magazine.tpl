<div class="right_main">
	<dl class="mag_list clearfix">
		<dd class="menu">
		{include file='user/user_nav.tpl'}
		</dd>
		<dt> </dt>
		{foreach from=$magazine.items item=item}
		{include file="magazine/lib/magcover.tpl" cover_show_del=true}
		{/foreach}
	</dl>
	{$page_list}
</div>
