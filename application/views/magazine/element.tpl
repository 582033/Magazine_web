{include file="header.tpl"}
<div class="main">
	<div class="element_list e_index clearfix">
		<h3><span>爱发现</span></h3>
		<dl id="container">
			{if isset($element_ad)}
			{foreach from=$element_ad item=item key=key}
			{include file="magazine/lib/elemcover.tpl"}
			{/foreach}
			{/if}
			{foreach from=$element_list item=item key=key}
			{include file="magazine/lib/elemcover.tpl"}
			{/foreach}
		</dl>
	</div>
	{if isset($nextpage)}
	<div id="pagenav" style="display:none">
		<a href="{$nextpage}"></a>
	</div>
	{/if}
</div>
<script type="text/javascript" src="http://sta.in1001.com/lib/jquery/jquery.masonry.js"></script>
<script type="text/javascript" src="http://sta.in1001.com/lib/jquery/jquery.infinitescroll.js"></script>
<script type="text/javascript" src="/sta/js/element.js"></script>
{include file="footer.tpl"}
{include file='share.tpl'}
