{include file="header.tpl"}
<div class="main">
	<dl class="element_list e_index clearfix">
		<dt>
			<strong>爱发现</strong>
		</dt>
		<div id="container">
			{foreach from=$element_list item=item key=key}
			{include file="magazine/lib/elemcover.tpl"}
			{/foreach}
		</div>
	</dl>
{$page_list}
</div>
<script type="text/javascript" src="/sta/js/jquery.masonry.min.js"></script>
<script type="text/javascript" src="/sta/js/element.js"></script>
<script type="text/javascript" src="/sta/js/jquery.infinitescroll.min.js"></script>
<script type="text/javascript" src="/sta/js/like.js"></script>
{include file="footer.tpl"}
{include file='share.tpl'}
