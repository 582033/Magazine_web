{include file='header.tpl'}
<script type="text/javascript" src="/sta/js/jquery.cycle.all.js"></script>
<script type="text/javascript" src="/sta/js/gallery.js"></script>
<script type="text/javascript" src="/sta/js/magazine_main.js"></script>
<div class="main">
	<dl class="mag_list m_topic clearfix">
		<dt><strong><span><a href="#">看杂志</a></span></strong></dt>
		<dd class="topic">
			<div class="slide_pic">
				<div id="magazine_gallery_container">
				{foreach from=$mag_gallery item=item key=key}
					<a href="/magazine/detail/{$item.id}"><img src="{$item.cover}" width="980" height="280" alt="{$item.id}" /></a>
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
			<h2 style="display:block;"><a href="/magazine/detail/{$item.id}">{$item.intro}</a></h2>
			{/foreach}
		</dd>
		<dd class="info clearfix">
		
			<ul class="clearfix">
				<li class="text_list">
					<dl>
						<dt>
							<a href="#">那些年，我们一见倾心的鞋子</a>
						</dt>
						<dd>
							<a href="#">描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述</a>
							<a href="#" class="readmore">阅读+</a>
						</dd>
					</dl>
					<dl>
						<dt>
							<a href="#">那些年，我们一见倾心的鞋子</a>
						</dt>
						<dd>
							<a href="#">描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述</a>
							<a href="#" class="readmore">阅读+</a>
						</dd>
					</dl>
					<dl class="last">
						<dt>
							<a href="#">那些年，我们一见倾心的鞋子</a>
						</dt>
						<dd>
							<a href="#">描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述</a>
							<a href="#" class="readmore">阅读+</a>
						</dd>
					</dl>
				</li>
				<li>
					<dl>
						{include file="magazine/lib/magcover.tpl"}
					</dl>
				</li>
			</ul>
		
		</dd>
	</dl>
	
	<dl class="mag_list m_index clearfix">
	<dd class="menu">
			<ul>
				<li><a class="sel" id="tour_reader">旅游攻略</a></li>
				<li><a id="foreign">出境游</a></li>
				<li><a id="domestic">国内游</a></li>
			</ul>
		</dd>
		<dt><a href="/mag_list/tour_reader/1" class="more">More</a></dt>
		{foreach from=$tour_reader item=item key=key}
		{include file="magazine/lib/magcover.tpl" dd_class="tour_reader"}
		{/foreach}
		{foreach from=$foreign item=item key=key}
		{include file="magazine/lib/magcover.tpl" dd_class="foreign" dd_style="display:none"}
		{/foreach}
		{foreach from=$domestic item=item key=key}
		{include file="magazine/lib/magcover.tpl" dd_class="domestic" dd_style="display:none"}
		{/foreach}
</dl>

	
</div>
{include file="footer.tpl"}
{include file='share.tpl'}
