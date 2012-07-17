{include file="header.tpl"}
<script type="text/javascript" >
function play(){
      allSrc=$(".slidescreen img");
      if ( typeof(i) == "undefined" || i == null || i>=allSrc.length ){
              i=0;
      }
      allSrc.css("display","none");
      allSrc[i].style.display="block";
      i++;
}
$(function(){
      setInterval("play()", 2000);
      play();
})
</script>
 <div class="down">
 	<dl class="client_down">
 		<dt {if $type == 'pc'}class="sel"{else} onclick="location.href='/soft/pc'" onmouseover="this.style.cursor='hand'"{/if}>1001+制作工具下载</dt>
		{if $type == 'pc'}
 		<dd class="pc">
 			<div class="intro">
				<div class="intro_text">
					<p>
						“1001+”是一款令人惊奇的数字多媒体制作工具，无需编程、无使用门槛，快速制作数字杂志、书籍、图册、宣传物等个性化数字读物，并自动生成iOS、Android等移动设备应用，广泛适用于企业、机构、个人。
					</p>
					<p>
						你需要拥有<font style="color:#000;font-weight:bold;">邀请码</font>，且完成<font style="color:#000;font-weight:bold;">登陆</font>后，才可以下载试用。
					</p>
				</div>
				{if isset($user_info) && $user_info.role == 1}
				<a class="downbtn" href="http://58.30.78.70:84/LetouMagazine_20120709.rar" style="display:none;">下载</a>
				{else}
 				<a class="downbtn thickbox" href="/user/applyAuthor/invitation" style="display:none;">下载</a>
				{/if}
 			</div>
 			<ul>
 				<li class="n1">
 					<strong>多媒体互动</strong>
 					支持文字、图片、链接、音乐、视频、动画…等多媒体互动表现形式。
 				</li>
 				<li class="n2">
 					<strong>一站式&nbsp;多平台</strong>
 					一次制作，完美适配主流系统（Web/iOS/Android），全面覆盖用户终端（PC/平板电脑/手机、SmartTV）。
 				</li>
 				<li class="n3">
 					<strong>可视化制作，所见即所得</strong>
 					丰富的个性化模板，首创美图文字智能自动排版、独有360度旋转等多种效果，拖放间，轻松成就精彩。
 				</li>
 				<li class="n4">
 					<strong>发布共享</strong>
 					 1001夜平台为精彩作品提供全方位的传播和推广。
 				</li>
 			</ul>
 		</dd>
		{/if}
 		<dt {if $type == 'android'}class="sel"{else}onclick="location.href='/soft/android'" onmouseover="this.style.cursor='hand'"{/if}>Android客户端下载</dt>
		{if $type == 'android'}
 		<dd class="android" style="display:block">
 			<div class="intro">
				<div class="intro_text">
					<p>云中漫步，云同步手机、平板、PC电脑的阅读记录、个人信息，移动随心，支持在线浏览和下载阅读。</p>
				</div>

				<a href="http://d.in1001.com/apk/magazine_bookshelf.apk" class="downbtn">下载Android客户端</a>
 				<div class="slidescreen">
 					<img src="/sta/images/appscreen/1.jpg" alt="截图1" />
 					<img src="/sta/images/appscreen/2.jpg" alt="截图2" />
 					<img src="/sta/images/appscreen/3.jpg" alt="截图3" />
 					<img src="/sta/images/appscreen/4.jpg" alt="截图4" />
 					<img src="/sta/images/appscreen/5.jpg" alt="截图5" />
 					<img src="/sta/images/appscreen/6.jpg" alt="截图6" />
 				</div>
 				<div class="light"></div>
 			</div>
 			<ul>
 				<li class="n1">
 					<strong>剥离繁复的品质阅读</strong>
 					"1001夜"提供杂志及精华部分的品质阅读，只需一点点好奇心的探索，您会发现无数的好看。
 				</li>
 				<li class="n2">
 					<strong>酷炫个性的立体阅读</strong>
 					结合图片、文字、影像、声音的立体阅读，冲击感官，体会阅读的张力。
 				</li>
 				<li class="n3">
 					<strong>随身而动的移动阅读</strong>
 					信息时代的移动阅读，移动设备的阅读服务，让您随时随地阅读精彩。
 				</li>
 				<li class="n4">
 					<strong>率性自然的分享阅读</strong>
 					不同于纸张，数字化使分享变得简单快捷。阅读本身是一件愉悦之事，分享， 赋予阅读更多快乐。
 				</li>
 			</ul>
 		</dd>
		{/if}
 	</dl>
 </div>
{include file="footer.tpl"}
