<?php class page_model {
	
	function page_list ($uri, $limit, $total, $page, $style=null) {	//{{{
		$total_page = $total % $limit == '0' ? floor($total / $limit) : floor($total / $limit) +1;
		if ($total_page <= 1) return "";
		$min = $this->get_min($page, $total_page);
		$max = $this->get_max($page, $total_page);
		//echo $min."|".$max."|".$total_page;
		if (!$style) {
			$page_list =  "
				<div class='pagearea'>
					<ul class='pagenav clearfix'>";
			for ($i = $min; $i <= $max; $i++) {
				if ($page == $i)
					$page_list .= "<li><a href='$uri/p/$i' class='sel'> $i </a></li>";
				else
					$page_list .= "<li><a href='$uri/p/$i'> $i </a></li>";
			}
			$page_list .= <<<EOF
					</ul>
					<form action="$uri">
						<p class='page_no'>
							<input type='text' name="goto" value='$page' /> | <span class="totalPage">$total_page</span> 页 <button type='submit' style='display:none'>跳转</button>
						</p>
					</form>
				</div>
EOF;
		}
		else {
			$page_list =  "<p class='pagenav msg_pagenav'>";
			if ($page > 1) {
				$page_list .= "<a href='$uri/p/" . ($page-1) . "' class='prav'>上一页</a>";
			}
			for ($i = $min; $i <= $max; $i++) {
				if ($page == $i)
					$page_list .= "<a href='$uri/p/$i' class='sel'> $i </a>";
				else
					$page_list .= "<a href='$uri/p/$i'> $i </a>";
			}
			if ($page < $max) {
				$page_list .= "<a href='$uri/p/" . ($page+1) . "' class='next'>下一页</a>";
			}
			$page_list .= "</p>";
		}
		return $page_list;
	}	//}}}

	function get_min($page, $total_page) {	//取最小页{{{
		if ($total_page > 10) {
			$min = $page - 4;
			if ($min <= 0) {
				$min = 1;
			}
		}
		else{
			$min = 1;
		}
		return $min;
	}	//}}}

	function get_max($page, $total_page) {	//取最大页{{{
		if($total_page > 10) {
			$max = $page + 5;
			if ($max > $total_page) {
				$max = $total_page;
			}
			elseif ($max < 10) {
				$max = 10;
			}
		}
		else {
			$max = $total_page;
		}
		return $max;
	}	//}}}
}
