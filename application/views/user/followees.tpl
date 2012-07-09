	<div class="right_main">
		<div class="msg_list clearfix">
			<div class="my_follow_list">
				{foreach from=$followees['items'] item=item}
				<dl class="clearfix">
					<dt><a href="#"><img src="{$item.image}" alt="{$item.nickname}" /></a></dt>
					<dd>
						<strong><a href="#">{$item.nickname}</a></strong>
						<p><a href="#">关注</a> | <a href="#">发现</a> | <a href="#">作品{$item.magazines}</a></p>
						<span><a href="#">取消关注</a></span>
					</dd>
				</dl>
				{/foreach}	
			</div>
			{$page_list}		
		</div>
	</div>
</div>
