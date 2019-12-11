<?php
namespace fazzo;

if ( is_active_sidebar( 'fazzo-sidebar-head' ) ) {
	ob_start();
	dynamic_sidebar( 'fazzo-sidebar-head' );
	$sidebar = ob_get_clean();
	if ( $sidebar ) {
		echo "<div id='fazzo-sidebar-head'>\n";
		echo $sidebar;
		echo "</div><!-- fazzo-sidebar-head -->\n";
	}
}