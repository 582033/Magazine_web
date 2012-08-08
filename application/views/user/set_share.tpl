	<div class="set_main share">
			<h2>绑定分享帐号</h2>
			<dl class="clearfix">
				<dt>已绑定帐号：</dt>
				{foreach from=$bindinfo item=item key=key}
				<dd><a href="javascript:void(0)"><img src="/sta/images/share/{$item.snsid}.gif" alt="新浪微博" /></a><span><input type="checkbox" name="unbundle" id="{$item.snsid}" /><label for="{$item.snsid}">取消同步</label></span></dd>
				{/foreach}
			</dl>
			
			<dl class="clearfix">
				<dt>未绑定帐号：</dt>
				{foreach from=$unbind item=item key=key}
				<dd><a class="bind-snslogin" href="/sns/redirect?snsid={$item}&apptype=web&op=2&session_id={$session_id}"><img src="/sta/images/share/{$item}.gif" alt="新浪微博" /></a></dd>				
				{/foreach}
			</dl>
	</div>
</div>
{literal}
<script type="text/javascript" >
$("document").ready(function(){
	if(typeof magSns != 'undefined') {
		magSns.init($('a.bind-snslogin'));
	}
    $(".share dl dd a").click(function(){
		if ( $(this).next().css("display") != "block"){
			$(this).next().css("display","block");
		}else{
			$(this).next().css("display","none");		
		}
	});
	$(".share dl.clearfix dd input[type='checkbox']").change(function(){
		if($(this).attr('checked') && confirm('确认')) {
			$.get(
				'/user/unbind',
				{snsid:$(this).attr('id')},
				function(data){
					if(data.status=='OK') {
						window.location='/user/me/set_share';
					}
				},
				'json'
			);
		}
	});
})
</script>
{/literal}
