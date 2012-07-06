<dd class="item">
	<div class="cover">
		<a href="#"><img src="{$item.image.180.url}" width="{$width|default:180}" height="{$height|default:$item.image.180.height}" alt="{$item.magId}" /></a>
		<div class="mouseover">
			<div class="bg"></div>
			<div class="content">
				<a href="{$item.mag_read_url}" class="read">阅读</a>
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
	{if $cover_show_title}<h3><a href="{$item.mag_read_url}">宠爱日记</a></h3>{/if}
</dd>

