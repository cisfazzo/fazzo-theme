<?php

namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );


if ( is_active_sidebar( 'fazzo-sidebar-bottom-a' ) ) {
	ob_start();
	dynamic_sidebar( 'fazzo-sidebar-bottom-a' );
	$sidebar = ob_get_clean();
	if ( $sidebar ) {
		echo "<div id='fazzo-sidebar-bottom-a' class='row-1'>\n";
		echo $sidebar;
		echo "</div><!-- fazzo-sidebar-bottom-a -->\n";
	}
}

if ( is_active_sidebar( 'fazzo-sidebar-bottom-b' ) ) {
	ob_start();
	dynamic_sidebar( 'fazzo-sidebar-bottom-b' );
	$sidebar = ob_get_clean();
	if ( $sidebar ) {
		echo "<div id='fazzo-sidebar-bottom-b' class='row-2'>\n";
		echo $sidebar;
		echo "</div><!-- fazzo-sidebar-bottom-b -->\n";
	}
}

if ( is_active_sidebar( 'fazzo-sidebar-bottom-c' ) ) {
	ob_start();
	dynamic_sidebar( 'fazzo-sidebar-bottom-c' );
	$sidebar = ob_get_clean();
	if ( $sidebar ) {
		echo "<div id='fazzo-sidebar-bottom-c' class='row-3'>\n";
		echo $sidebar;
		echo "</div><!-- fazzo-sidebar-bottom-c -->\n";
	}
}

