{include file="header.tpl"}
<style type="text/css">
  #map_canvas { height: 600px; width:100%; }
</style>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyClCYHH9Q3VOWt7Iajyx5bKVI4wV7Y189o&sensor=false"></script>
<script type="text/javascript" src="/sta/js/google_map.js"></script>
<link rel="stylesheet" type="text/css" href="/sta/styles/foot.css"/>
<script type="text/javascript">
	$(function(){
		 initialize();
	})
</script>
<div class="foot_container">
	<div class="contact_us_container"><!-- 联系我们 -->
		<div class="title_l">联系我们</div>
		<div class="contact">
			<div class="left">
				<ul>
					<li><span class="bold">商务合作请联系：</span>Chanryma</li>
					<li>Email：qlma@eee168.com  （请于周一至周五9：00-18：00联系）</li>
					<li>QQ：1148812977</li>
				</ul>
			</div>
			<div class="right">
				<ul>
					<li><span class="bold">品牌/推广合作请联系：</span>Winnie</li>
					<li>Mobile：13264193687</li>
					<li>Email：xbai@eee168.com  （请于周一至周五9：00-18：00联系）</li>
					<li>QQ：276565136 </li>
				</ul>
			</div>
		</div>
		<div class="subtitle">北京乐投信息技术有限公司</div>
		<ul class="info">
			<li>电话：010-64981756</li>
			<li>传真：010-64811949</li>
			<li>地址：北京市朝阳区安苑路15号邮电新闻大厦西办公区9层</li>
			<li>邮编：100029</li>
		</ul>
		<div class="little_title traffic_line">交通路线</div>
		<ul class="line">
			<li>公交：18路、409路、430路、125路等，安苑路站或惠新苑站下车即到</li>
			<li>地铁5号线惠新西街北口站下车，C口出，南行300米至安苑路口西行50米</li>
			<li>地铁10号线惠新西街南口站下车，B口出，北行500米至安苑路口西行50米</li>
		</ul>
		<div id="map_canvas"></div>
	</div><!-- end 联系我们 -->
</div>
{include file="footer.tpl"}
