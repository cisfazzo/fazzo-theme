<?php
namespace fazzo;

$count = 0;
$max   = 12;
if ( is_active_sidebar( 'fazzo-sidebar-bottom-a' ) ) {
	$count ++;
}
if ( is_active_sidebar( 'fazzo-sidebar-bottom-b' ) ) {
	$count ++;
}
if ( is_active_sidebar( 'fazzo-sidebar-bottom-c' ) ) {
	$count ++;
}
if ( ! empty( $count ) ) {
	$sidebar_bottom_col = $max / $count;
} else {
	$sidebar_bottom_col = $max;
}

if ( is_active_sidebar( 'fazzo-sidebar-bottom-a' ) ) {
	ob_start();
	dynamic_sidebar( 'fazzo-sidebar-bottom-a' );
	$sidebar = ob_get_clean();
	if ( $sidebar ) {
		echo "<div id='footer-middle-sidebar-a-wrapper' class='footer-middle-sidebar-wrapper col" .$GLOBALS["fazzo_breakpoint"]."-".$sidebar_bottom_col ."'>\n";
		echo "<div id='fazzo-sidebar-bottom-a'>\n";
		echo $sidebar;
		echo "</div><!-- fazzo-sidebar-content -->\n";
		echo "</div><!-- bottom-sidebar-a-wrapper -->\n";
	}
}

if ( is_active_sidebar( 'fazzo-sidebar-bottom-b' ) ) {
	ob_start();
	dynamic_sidebar( 'fazzo-sidebar-bottom-b' );
	$sidebar = ob_get_clean();
	if ( $sidebar ) {
		echo "<div id='footer-middle-sidebar-b-wrapper' class='footer-middle-sidebar-wrapper col" .$GLOBALS["fazzo_breakpoint"]. "-".$sidebar_bottom_col ."'>\n";
		echo "<div id='fazzo-sidebar-bottom-b'>\n";
		echo $sidebar;
		echo "</div><!-- fazzo-sidebar-content -->\n";
		echo "</div><!-- bottom-sidebar-b-wrapper -->\n";
	}
}

if ( is_active_sidebar( 'fazzo-sidebar-bottom-c' ) ) {
	ob_start();
	dynamic_sidebar( 'fazzo-sidebar-bottom-c' );
	$sidebar = ob_get_clean();
	if ( $sidebar ) {
		echo "<div id='footer-middle-sidebar-c-wrapper' class='footer-middle-sidebar-wrapper col". $GLOBALS["fazzo_breakpoint"]."-". $sidebar_bottom_col ."'>\n";
		echo "<div id='fazzo-sidebar-bottom-c'>\n";
		echo $sidebar;
		echo "</div><!-- fazzo-sidebar-content -->\n";
		echo "</div><!-- bottom-sidebar-c-wrapper -->\n";
	}
}