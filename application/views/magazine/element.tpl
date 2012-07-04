{include file="header.tpl"}
<div class="main">
	<dl class="element_list e_index clearfix">
		<dt>
			<strong>爱发现</strong>
		</dt>
		<div id="container">
			{foreach from=$element_list item=item key=key}
			<dd class="item">
				<div class="cover" style="width:{$item.width}px;height:{$item.height}px;">
					<a href="#"><img src="{$item.image.180}" alt="{$item.magId}" /></a>
					<div class="mouseover">
						<div class="bg"></div>
						<div class="content">
							<a href="{$pub_host}/{$item.read_mag_id}/{$item.magId}/web/#{$item.page}" class="read">阅读</a>
							<div class="more">
									<a href="#" class="share">分享</a>
									<a href="javascript:void(0);" id="element_{$item.id}" onclick="like('element','{$item.id}');" class="like">{$item.likes}</a>
							</div>
							<div class="shareto">
								<div class="bg"></div>
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
<script type="text/javascript" src="/sta/js/jquery.masonry.min.js"></script>
<script type="text/javascript" src="/sta/js/element.js"></script>
<script type="text/javascript" src="/sta/js/jquery.infinitescroll.min.js"></script>
<script type="text/javascript" src="/sta/js/like.js"></script>
{include file="footer.tpl"}
{include file='share.tpl'}
