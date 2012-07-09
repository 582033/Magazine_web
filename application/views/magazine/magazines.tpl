{include file='header.tpl'}
<div class="main">
	<dl class="mag_list m_index clearfix">
		<dd class="menu">
			<ul>
				<li><a href="/mag_list/tour_reader" {if $tag == 'tour_reader'}class="sel"{/if} id="tour_reader">旅游攻略</a></li>
				<li><a href="/mag_list/foreign" {if $tag == 'foreign'}class="sel"{/if} id="foreign">出境游</a></li>
				<li><a href="/mag_list/domestic" {if $tag == 'domestic'}class="sel"{/if} id="domestic">国内游</a></li>
			</ul>
		{foreach from=$items item=item key=key}
		{include file="magazine/lib/magcover.tpl"}
		{/foreach}
	</dl>
{$page_list}
</div>
{include file='footer.tpl'}
{include file='share.tpl'}
