{include file='header.tpl'}
<script type="text/javascript" src="/sta/js/jquery.cycle.all.js"></script>
<script type="text/javascript" src="/sta/js/gallery.js"></script>
<div class="main">
	<dl class="mag_list clearfix">
		<dt><strong>看杂志</strong> <a href="/mag" class="more">More</a></dt>
		<dd class="topic">
			<div class="slide_pic">
				<div id="magazine_gallery_container">
					{foreach from=$mag_gallery item=item key=key}
						<a href="/magazine/detail/{$item.id}"><img src="{$item.cover}" width="580" height="576" alt="描述" /></a>
					{/foreach}
				</div>
				<div class="tab">
					<div class="point">
						<a href="#" class="sel"></a>
						<a href="#"></a>
						<a href="#"></a>
						<a href="#"></a>
					</div>
				</div>
				<div class="slide_nav">
					<a href="javascript:void(0);" class="prev" id="prev1">上一个</a>
					<a href="javascript:void(0);" class="next" id="next1">下一个</a>
				</div>
			</div>
			{foreach from=$mag_gallery item=item key=key}
				<h2><a href="#">{$item.name}</a></h2>
				<p>
					<a href="#">{$item.intro|truncate:50}</a>
					<a href="/magazine/detail/{$item.id}" class="readmore">阅读+</a>
				</p>
			{/foreach}
		</dd>
		{foreach from=$mag_list item=item key=key}
		{include file="magazine/lib/magcover.tpl" cover_show_intro=true}
		{/foreach}
	</dl>

	<dl class="element_list clearfix">
		<dt><strong>爱发现</strong> <a href="/find" class="more">More</a></dt>
		<dd class="topic">
			<div class="slide_pic">
				<div id="element_gallery_container">
					{foreach from=$elem_gallery item=item key=key}
						<a href="{$pub_host}/{$item.read_mag_id}/{$item.magId}/web/#{$item.page}"><img src="{$item.image.180}" width="580" height="380" alt="描述" /></a>
					{/foreach}
				</div>
				<div class="tab">
					<div class="point">
						<a href="#" class="sel"></a>
						<a href="#"></a>
						<a href="#"></a>
						<a href="#"></a>
					</div>
				</div>
				<div class="slide_nav">
					<a href="javascript:void(0);" class="prev" id="prev2">上一个</a>
					<a href="javascript:void(0);" class="next" id="next2">下一个</a>
				</div>
			</div>
			{foreach from=$elem_gallery item=item key=key}
				<h2><a href="#">1那些年 让我们一见倾心的鞋子</a></h2>
			{/foreach}
		</dd>
		{foreach from=$elem_list item=item key=key}
		{if $key != 4}
		<dd>
			<div class="cover">
				<a href="#"><img src="{$item.image.128}" width='180px' height='180px' alt="宠爱日记" /></a>
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
			<h3><a href="{$pub_host}/{$item.read_mag_id}/{$item.magId}/web/#{$item.page}">宠爱日记</a></h3>
		</dd>
		{else}
		<dd class="col2">
			<div class="cover">
				<a href="{$pub_host}/{$item.read_mag_id}/{$item.magId}/web/#{$item.page}"><img src="{$item.image.128}" width='380px' height='180px' alt="宠爱日记" /></a>
				<div class="mouseover">
					<div class="bg"></div>
					<div class="content">
						<a href="{$pub_host}/{$item.read_mag_id}/{$item.magId}/web/#{$item.page}" class="read">阅读</a>
						<div class="more">
								<a href="#" class="share">分享</a>
								<a href="javascript:void(0);" id="element_{$item.id}" onclick="like('element','{$item.id}');"  class="like">{$item.likes}</a>
						</div>
						<div class="shareto">
							<div class="bg"></div>
						</div>
					</div>
				</div>
			</div>
			<h3><a href="{$pub_host}/{$item.read_mag_id}/{$item.magId}/web/#{$item.page}">鼠标滑过测试鼠标滑过测试鼠标滑过测试鼠标滑过测试鼠标滑过测试</a></h3>
		</dd>
		{/if}
		{/foreach}
	</dl>
</div>
{include file='share.tpl'}
{include file='footer_big.tpl'}
