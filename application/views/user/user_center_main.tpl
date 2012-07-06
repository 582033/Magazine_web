{include file='header.tpl'}
    <div class="current"><a href="/home">首页</a> &gt; <a href="#" class="cur">个人中心</a></div>
    <div class="main main_left_line clearfix">
        {include file='user/sidebar_left.tpl'}
        {if $element}
            {include file='user/element.tpl'}
        {/if}
        {if $magazine}
            {include file='user/magazine.tpl'}
        {/if}
        {if $bookstore}
	    {include file='user/my_bookstore.tpl'}
        {/if}
        {if $msg_page}
	    {include file='user/show.tpl'}
        {/if}
        {if $followees}
	    {include file='user/followees.tpl'}
        {/if}

    </div>
{include file='footer.tpl'}

