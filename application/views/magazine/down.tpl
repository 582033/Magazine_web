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
 		<dt {if $type == 'pc'}class="sel"{else} onclick="location.href='/soft/pc'" onmouseover="this.style.cursor='hand'"{/if}>PC工具下载</dt>
		{if $type == 'pc'}
 		<dd class="pc">
 			<div class="intro">
				<div class="intro_text">
					<p>
						"1001+"由"1001夜"出品，是一款令人惊奇的数字多媒体制作工具。任何人都能用它快速制作数字杂志、书籍、图册、宣传物等个性化数字读物。革命性颠覆在于：无需编程，即可产出适用于iOS、Android等移动智能系统的数字读物APPS。
					</p>
					<p>
						你需要拥有邀请码，且完成登陆后，才可以下载试用。
					</p>
				</div>
				{if isset($user_info) && $user_info.role == 1}
				<a class="downbtn" href="http://58.30.78.70:84/LetouMagazine_20120709.rar">下载</a>
				{else}
 				<a class="downbtn thickbox" href="/user/applyAuthor/invitation">下载</a>
				{/if}
 			</div>
 			<ul>
 				<li class="n1">
 					<strong>富媒体表现力</strong>
 					精彩模版，支持文字、图片、链接、音乐、视频、动画…… 等富媒体表现形式。
 				</li>
 				<li class="n2">
 					<strong>一站式多平台</strong>
 					一次制作，覆盖多平台（Web/IOS/Android）与多终端（PC/平板电脑/手机）。
 				</li>
 				<li class="n3">
 					<strong>卓越用户体验</strong>
 					可触摸、可倾听、可观看。享受栩栩如生的制作乐趣。
 				</li>
 				<li class="n4">
 					<strong>发布共享</strong>
 					如果您制作完毕并准备发布，"1001夜数字阅读平台"将协助推广个人作品，与更多人分享。
 				</li>
 			</ul>
 		</dd>
		{/if}
 		<dt {if $type == 'android'}class="sel"{else}onclick="location.href='/soft/android'" onmouseover="this.style.cursor='hand'"{/if}>Android客户端下载</dt>
		{if $type == 'android'}
 		<dd class="android" style="display:block">
 			<div class="intro">
				<div class="intro_text">
					<p>我们致力提供免费的“品质阅读”与“即时分享”。也在试图传递一种阅读新理念——不止满足于观看，更结合了倾听、触摸，将感性阅读与最佳的数字化结合。</p>
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
