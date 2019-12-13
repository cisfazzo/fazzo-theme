<?php
namespace fazzo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tmp_width = 100;
$tmp_diff = 23;

if ( is_active_sidebar( 'fazzo-sidebar-frontpage' ) && ( is_home() || is_front_page() )  ) {
    $tmp_width -= $tmp_diff;
}

if ( is_active_sidebar( 'fazzo-sidebar-content' ) && !( is_home() || is_front_page() )  ) {
	$tmp_width -= $tmp_diff;
}

if ( has_nav_menu( 'meta-content-nav' )&& !( is_home() || is_front_page() ) )  {
	$tmp_width -= $tmp_diff;
}

?>
            <div id="content-middle-wrapper" class="col<?php echo $GLOBALS["fazzo_breakpoint"]."-".$GLOBALS['fazzo_set'][1]; ?>" style="width:<?php echo $tmp_width; ?>%">


