{include file="header.tpl"}
<div class="main">
	<dl class="element_list e_index clearfix">
		<dt><strong>爱发现</strong></dt>
		<div id="container">
		{foreach from=$element_list item=item key=key}
		<dd class="item">
			<div class="cover" style="width:{$item.width}px;height:{$item.height}px;overflow:hidden;">
				<a href="#"><img src="{$item.image.180}" alt="宠爱日记" /></a>
				<div class="mouseover">
					<div class="bg"></div>
					<div class="content">
						<a href="http://pub.1001s.cn/{$magazine.author.id}/{$magazine.id}/web" class="read">阅读</a>
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

<ul class="pagenav clearfix">
	<li><a href="#" class="sel">1</a></li>
	<li><a href="#">2</a></li>
	<li><a href="#">3</a></li>
	<li><a href="#">4</a></li>
	<li><a href="#">5</a></li>
	<li><a href="#">6</a></li>
	<li><a href="#">7</a></li>
	<li><a href="#">8</a></li>
	<li><a href="#">9</a></li>
	<li><a href="#">10</a></li>
</ul>
<form>
<p class="page_no">
	<input type="text" value="1" /> | 590页 <button type="submit" style="display:none">跳转</button>
</p>
</form>

</div>
{include file="footer.tpl"}
