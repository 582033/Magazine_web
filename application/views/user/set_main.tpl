{include file='header.tpl'}
<div class="current"><a href="/">首页</a> &gt; <a href="/user/me">我的主页</a> &gt; <a href="/user/me/{$user_set}" class="cur">{$user_set_name}</a></div>
<div class="main setting clearfix">
	<div class="set_menu">
		<ul>
			<li class="s_base {if $user_set == 'set_base'}sel{/if}">
				<a href="set_base">基本资料</a>
			</li>
			<li class="s_pwd {if $user_set == 'set_pwd'}sel{/if}">
				<a href="set_pwd">修改密码</a>
			</li>
			<li class="s_pic {if $user_set == 'set_headpic'}sel{/if}">
				<a href="set_headpic">头像设置</a>
			</li>
			<li class="s_tag {if $user_set == 'set_tag'}sel{/if}">
				<a href="set_tag">个人标签</a>
			</li>
			<li class="s_share {if $user_set == 'set_share'}sel{/if}">
				<a href="set_share">分享管理</a>
			</li>
<!--
			<li class="s_auther {if $user_set == 'set_auther'}sel{/if}">
				<a href=set_auther#">作者信息设置</a>
			</li>
-->
<!--
			<li class="s_ana {if $user_set == 'set_ana'}sel{/if}">
				<a href="set_ana">数据分析</a>
			</li>
-->
		</ul>
		{if $user_info.role == 0}
		<a href="/user/applyAuthor/invitation" class="btn_auther thickbox">申请成为作者</a>
		{/if}
	</div>
	{if $user_set == 'set_base'}{include file="user/set_base.tpl"}{/if}
	{if $user_set == 'set_headpic'}{include file="user/set_headpic.tpl"}{/if}
	{if $user_set == 'set_tag'}{include file="user/set_tag.tpl"}{/if}
	{if $user_set == 'set_auther'}{include file="user/set_auther.tpl"}{/if}
	{if $user_set == 'set_share'}{include file="user/set_share.tpl"}{/if}
	{if $user_set == 'set_pwd'}{include file="user/set_pwd.tpl"}{/if}
</div>
{include file='footer.tpl'}

