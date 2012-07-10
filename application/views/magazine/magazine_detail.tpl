{include file="header.tpl"}
<script src="/sta/js/jquery.jscrollpane.min.js"></script>
<div class="current">
	{include file="magazine/lib/nav.tpl" navs=$navs}
</div>

<div class="main mag_preview clearfix">
	<div class="left_main">
		<div class="cover">
			<img src="{$magazine.cover}" alt="{$magazine.name}" />
		</div>
		<div class="intro">
			<h2>{$magazine.name}</h2>
			<p class="auther">作者：<a href="/user/{$magazine.author.id}">{$magazine.author.nickname}</a> <a  href="javascript:void(0);" class="follow"><img src="/sta/images/ico_plus.gif" alt="加关注" class="fellow_item" onclick="like('user','{$magazine.author.id}');" />&nbsp;<span class="fellow_item" onclick="like('user','{$magazine.author.id}');">加关注</span></a></p>
			<p>上传：{$magazine.publishedAt}</p>
			<p class="tag">TAG：{foreach from=$magazine['tag'] item=item}<a href="/mag_list/tag/{$item}">{$item}</a>&nbsp;&nbsp;{/foreach}</p>
			<p class="intro_txt" style="height:77px;"><strong>简介：</strong>
				{$magazine.intro}
			</p>
			<div style="height:35px;">
				<!-- Baidu Button BEGIN -->
					<div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare">
						<a class="bds_tsina" style="margin-left:5px;"></a>
						<a class="bds_renren" style="margin-left:10px;"></a>
						<a class="bds_tqq" style="margin-left:10px;"></a>
						<a class="bds_douban" style="margin-left:10px;"></a>
						<a class="bds_hi" style="margin-left:10px;"></a>
						<a class="bds_kaixin001" style="margin-left:10px;"></a>
				<!--		<span class="bds_more">更多</span>-->
					</div>
					<script type="text/javascript" id="bdshare_js" data="type=tools&amp;mini=1" ></script>
					<script type="text/javascript" id="bdshell_js"></script>
					<script type="text/javascript">
						var bds_config = {
							'bdDes':'',
							'bdText':'{$magazine.name} {$magazine.intro|truncate:30|escape}......http://www.in1001.com/magazine/detail/{$magazine.id}',
							'bdPopTitle':'',
							'bdPic':'{$magazine.cover}',
							'searchPic':0,//'0为抓取，1为不抓取，默认为0，目前只针对新浪微博'
						}
						document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + new Date().getHours();
					</script>
				<!-- Baidu Button END -->
			</div>
			<div style="clear:both;"></div>
			<p class="readonline">
				<a href="{$pub_host}/{$magazine.id|truncate:3}/{$magazine.id}/web"><img src="/sta/images/btn_readonline.jpg" alt="在线阅读" /></a>
			</p>
			<p class="info">
				<span class="view"><a href="javascript:void(0)" title="阅读">阅读</a>{$magazine.views}</span>
				<span class="like"><a href="javascript:void(0)" id="magazine_{$magazine.id}" onclick="detail_like('{$magazine.id}');" title="喜欢">喜欢</a><span>{$magazine.likes}</span></span>
				<span class="liked" style="display:none;"><a href="javascript:void(0)" title="已经喜欢" onclick="detail_liked('{$magazine.id}');">已经喜欢</a><span id="new_likes">{$magazine.likes}</span></span>
			</p>
		</div>

		<dl class="preview">
			<dt>精彩内容预览</dt>
			<dd class="scrollbar">
					<ul>
						{foreach from=$magazine.pageThumbs item=item key=key}
						<li><a href="{$pub_host}/{$magazine.id|truncate:3}/{$magazine.id}/web/#p{$key+1}"><img src="{$item}" alt="page 16" width="104px" height="160px" style="overflow:hidden;" /></a></li>
						{/foreach}
					</ul>
			</dd>
		</dl>



		<div class="comment_preview">
			<h3>留言板</h3>
			<form id="comment" class="comment_sub" action="/magazine/refresh_comment?object_id={$magazine.id}&start=0&limit=5" method="post">
				<img src="/sta/images/userhear_def.gif" alt="用户头像" />
				<textarea class="text" name="conment"></textarea>
				<button type="button" id="add">发布</button>
			</form>
			{include file="magazine/lib/comments.tpl"}
			<p class="more_comment">
				<a href="/magazine/{$magazine.id}/comments">查看全部留言</a>
			</p>
		</div>

	</div>

	<div class="sidebar_right">
		<div class="topic">
			<a href="/soft/android"><img src="/sta/images/temp/230x180.jpg" alt="预览" /></a>
		</div>
		<dl class="mag_topic">
			<dt>推荐的杂志</dt>
			{foreach from=$recommendation item=item}
			<dd><a href="/magazine/detail/{$item.id}" title="{$item.name}"><img src="{$item.cover}" alt="{$item.name}" /></a></dd>
			{/foreach}
		</dl>
		<dl class="mag_topic">
			<dt>猜你喜欢</dt>
			{foreach from=$maylike item=item}
			<dd><a href="/magazine/detail/{$item.id}" title="{$item.name}"><img src="{$item.cover}" alt="{$item.name}" /></a></dd>
			{/foreach}
		</dl>
	</div>
</div>
{include file="footer.tpl"}
