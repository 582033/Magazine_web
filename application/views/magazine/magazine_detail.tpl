{include file="header.tpl"}
<script src="http://sta.in1001.com/lib/jquery/jquery.jscrollpane.min.js"></script>
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
			<p id="user_{$magazine.author.id}" class="auther">
				作者：<a href="/user/{$magazine.author.id}">{$magazine.author.nickname}</a>
				<a  href="javascript:void(0);" class="follow unfollowed">
					<img src="/sta/images/ico_plus.gif" alt="加关注" class="fellow_item" onclick="like('user','{$magazine.author.id}');" />
					&nbsp;<span class="fellow_item" onclick="like('user','{$magazine.author.id}');">加关注</span>
				</a>
				<a  href="javascript:void(0);" class="follow followed">
					<img src="/sta/images/ico_minus.gif" alt="已关注" class="fellow_item" onclick="cancelLike('user','{$magazine.author.id}');" />
					&nbsp;<span class="fellow_item" onclick="cancelLike('user','{$magazine.author.id}');">已关注</span>
				</a>
			</p>
			<p>上传：{$magazine.publishedAt}</p>
			<p class="tag">TAG：{foreach from=$magazine['tag'] item=item}<a href="/mag_list/tag/{$item}">{$item}</a>&nbsp;&nbsp;{/foreach}</p>
			<p class="intro_txt" style="height:77px;"><strong>简介：</strong>
				{$magazine.intro}
			</p>
			<div class="shareto">
				<span class="share">分享到:</span>
				<!-- Baidu Button BEGIN -->
					<div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare" data="{literal}{url:'http://www.in1001.com/magazine/detail/{/literal}{$magazine.id}'{literal}}{/literal}">
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
							'bdText':'{$magazine.name} {$magazine.intro|truncate:30|escape}......',
							'bdPopTitle':'',
							'bdPic':'{$magazine.cover}',
							'searchPic':0,
							'review':'normal'
						}
						document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + new Date().getHours();
					</script>
				<!-- Baidu Button END -->
			</div>
			<div style="clear:both;"></div>
			<p class="readonline">
				<a onclick="_gaq.push(['_trackEvent', '杂志', '阅读', '{$magazine.name}', 5]);" href="{$pub_host}/{$magazine.id|truncate:3:''}/{$magazine.id}/web" target="_blank"><img src="/sta/images/btn_readonline.jpg" alt="在线阅读" /></a>
			</p>
			<p class="info" id="magazine_{$magazine.id}">
				<span class="view"><a href="javascript:void(0)" title="阅读">阅读</a>{$magazine.views}</span>
				<span class="like unliked"><a href="javascript:void(0)" onclick="like('magazine', '{$magazine.id}')" title="喜欢">喜欢</a><span class="favs">{$magazine.likes}</span></span>
				<span class="like liked"><a href="javascript:void(0)" title="已经喜欢" onclick="like('magazine', '{$magazine.id}')">已经喜欢</a><span class="favs">{$magazine.likes}</span></span>
			</p>
		</div>

		<dl class="preview">
			<dt>精彩内容预览</dt>
			<dd class="scrollbar">
					<ul>
						{foreach from=$magazine.pageThumbs item=item key=key}
						<li><a href="{$pub_host}/{$magazine.id|truncate:3:''}/{$magazine.id}/web/#p{$key+1}"><img src="{$item}" alt="page 16" width="104px" height="160px" style="overflow:hidden;" /></a></li>
						{/foreach}
					</ul>
			</dd>
		</dl>

		<div class="comment_preview">
			{include file="magazine/lib/main-comments.tpl" limit=5}
			<p class="more_comment"{if !$hasMoreComments} style="display:none"{/if}>
				<a href="/magazine/{$magazine.id}/comments">查看全部留言</a>
			</p>
		</div>

	</div>

	<div class="sidebar_right">
		<div class="topic">
			<a href="/soft/pc"><img src="/sta/images/soft_logo.jpg" width=230 height=180 alt="预览" /></a>
		</div>
		<dl class="mag_topic">
			<dt>推荐的杂志</dt>
			{foreach from=$recommendation item=item}
			<dd><a href="/magazine/detail/{$item.id}" title="{$item.name}"><img src="{$item.cover}" alt="{$item.name}" width="106px" height="162px" /></a></dd>
			{/foreach}
		</dl>
		<dl class="mag_topic">
			<dt>猜你喜欢</dt>
			{foreach from=$maylike item=item}
			<dd><a href="/magazine/detail/{$item.id}" title="{$item.name}"><img src="{$item.cover}" alt="{$item.name}" width="106px" height="162px" /></a></dd>
			{/foreach}
		</dl>
	</div>
</div>
{include file="footer.tpl"}
