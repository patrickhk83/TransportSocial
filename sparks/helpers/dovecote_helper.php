<?php /** helpers/dovecote_helper.php */

function dovecote_timeline() {

	$ci = &get_instance();

	// construct feed
	$feed = $ci->dovecote->retrieve();
	
	$data = array(
		'items' => $feed->items()
	);

	$ci->load->view( 'dovecote_timeline', $data );
}

?>
