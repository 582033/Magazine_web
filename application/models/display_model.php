<?php
class Display_model extends CI_Model {

	function Display_model() {
		parent::__construct();
	}

	function mag_read_url($magazine_id, $page_id=NULL) { //{{{
			if (strlen($magazine_id) <= 3){
				$prefix = $magazine_id;
			}else{
				$prefix = substr($magazine_id, 0, 3);
			}

		$url =  $this->config->item('pub_host') . "/$prefix/$magazine_id/web/";
		if ($page_id) $url = "$url#$page_id";
		return $url;
	} //}}}

	function process_element($element) {
		$nelement = $element;
		$nelement['mag_read_url'] = $this->mag_read_url($element['magId'], $element['page']);
		return $nelement;
	}
	function process_elements($elements) {
		$nelements = array();
		foreach ($elements as $item) {
			$nelements[] = $this->process_element($item);
		}
		return $nelements;
	}
}
