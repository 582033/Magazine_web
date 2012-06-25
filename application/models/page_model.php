<?php class page_model {

	function page_list ($uri, $limit, $total, $page) {	//{{{
		$total_page = $total % $limit == '0' ? floor($total / $limit) : floor($total / $limit) +1 ;
		$min = $this->get_min($page, $total_page);
		$max = $this->get_max($page, $total_page);
		$page_list =  "
			<div class='pagearea'>
				<ul class='pagenav clearfix'>";
		for ($i = $min; $i <= $max; $i++) {
			if ($page == $i)
				$page_list .= "<li><a href='$uri/$i' class='sel'> $i </a></li>";
			else
				$page_list .= "<li><a href='$uri/$i'> $i </a></li>";
		}
		$page_list .= "
				</ul>
				<form>
					<p class='page_no'>
						<input type='text' value='$page' /> | $total_page 页 <button type='submit' style='display:none'>跳转</button>
					</p>
				</form>
			</div>";
		return $page_list;
	}	//}}}

	function get_min($page, $total_page) {	//取最小页{{{
		if ($total_page > 10) {
			$min = $page - 4;
			if ($total_page - $min > 10) {
				$min = $total_page - 10;
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
