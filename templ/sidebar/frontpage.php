<?php
namespace fazzo;

if ( is_active_sidebar( 'fazzo-sidebar-frontpage' ) ) {
	ob_start();
	dynamic_sidebar( 'fazzo-sidebar-frontpage' );
	$sidebar = ob_get_clean();
	if ( $sidebar ) {
		echo "<div id='fazzo-sidebar-frontpage'>\n";
		echo $sidebar;
		echo "</div><!-- fazzo-sidebar-frontpage -->\n";
	}
}