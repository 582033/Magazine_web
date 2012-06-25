 	<div class="right_main">
 		<dl class="element_list e_index clearfix">
 			<dd class="menu">
 				<ul>
 					<li><a href="#">消息中心</a></li>
 					<li><a href="#" class="sel">喜欢的发现</a></li>
 					<li><a href="#">喜欢的书</a></li>
 					<li><a href="#">我的作品</a></li>
 				</ul>
 			</dd>
 			<dt><a href="#" class="sel">全部发现<span>(12)</span></a>　|　<a href="#">发现的美图<span>(12)</span></a>　|　<a href="#">发现的视频<span>(12)</span></a></dt>
			{foreach from=$loved_element['items'] item=item}
 			<dd>
 				<div class="cover">
 					<a href="#"><img src="{$item.image.url}" alt="宠爱日记" /></a>
 					<div class="mouseover">
 						<div class="bg"></div>
 						<div class="content">
 							<a href="#" class="read">阅读</a>
 							<a href="#" class="del_mag">删除</a>
 							<div class="more">
 									<a href="javascript:void(0);" class="share">分享</a>
 									<a href="#" class="like">喜欢</a>
 							</div>
 							<div class="shareto">
 								<div class="bg"></div>
 								<ul>
 									<li><a href="#" class="s_qq">分享到QQ空间</a></li>
 									<li><a href="#" class="s_sina">分享到新浪微博</a></li>
 									<li><a href="#" class="s_renren">分享到人人网</a></li>
 									<li><a href="#" class="s_qt">分享到腾讯微博</a></li>
 									<li><a href="#" class="s_douban">分享到豆瓣</a></li>
 									<li><a href="#" class="s_baidu">分享到百度空间</a></li>
 									<li><a href="#" class="s_kaixin01">分享到开心网</a></li>
 								</ul>
 							</div>
 						</div>
 					</div>
 				</div>
 			</dd>
			{/foreach}	
		</dl>
	{$page_list}
 	</div>
