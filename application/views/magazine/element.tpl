{include file="header.tpl"}
<div class="main">
	<dl class="element_list e_index clearfix">
		<dt>
			<strong>爱发现</strong>
		</dt>
		<div id="container">
			{foreach from=$element_list item=item key=key}
			<dd class="item">
				<div class="cover" style="width:{$item.width}px;{if $item.thumbSize == '1x2'}height:{$item.height}px;{else}height:{$item.height-10}px;{/if}overflow:hidden;">
					<a href="#"><img src="{$item.image.180}" alt="宠爱日记" /></a>
					<div class="mouseover">
						<div class="bg"></div>
						<div class="content">
							<a href="#" class="read">阅读</a>
							<div class="more">
									<a href="#" class="share">分享</a>
									<a href="#" class="like">喜欢</a>
							</div>
						</div>
					</div>
				</div>
			</dd>
			{/foreach}
		</div>
	</dl>
{$page_list}
</div>
{include file="footer.tpl"}
