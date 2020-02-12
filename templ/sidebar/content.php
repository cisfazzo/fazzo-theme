<?php

namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );

if ( is_active_sidebar( 'fazzo-sidebar-content' ) ) {
	ob_start();
	dynamic_sidebar( 'fazzo-sidebar-content' );
	$sidebar = ob_get_clean();
	if ( $sidebar ) {
		echo "<div id='fazzo-sidebar-content'>\n";
		echo $sidebar;
		echo "</div><!-- fazzo-sidebar-content -->\n";
	}
}
