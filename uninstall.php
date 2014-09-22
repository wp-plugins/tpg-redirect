<?php
//if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit ();
}else {
	tpg_redirect_uninstall();
}

function tpg_redirect_uninstall() {
	$tpg_rd_opts = get_option("tpg_rd_opts");
	if ($tpg_rd_opts == false) {
		return;
	} else {
		delete_option('tpg_rd_opts');
	}
}


?>
