<dd class="item size{$thumbSize|default:$item.thumbSize}">
	<div class="cover">
		<a href="#"><img src="{$item.image.180}" alt="{$item.magId}" /></a>
		<div class="mouseover">
			<div class="bg"></div>
			<div class="content">
				<a href="{$pub_host}/{$item.read_mag_id}/{$item.magId}/web/#{$item.page}" class="read">阅读</a>
				{if $cover_show_del}<a href="javascript:void(0)" class="del_mag" onclick="cancelLike('element', '{$item.id}')">删除</a>{/if}
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
	{if $cover_show_title}<h3><a href="{$pub_host}/{$item.read_mag_id}/{$item.magId}/web/#{$item.page}">宠爱日记</a></h3>{/if}
</dd>

