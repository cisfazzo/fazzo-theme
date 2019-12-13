<?php
namespace fazzo;

?><div id="content-full-wrapper">
    <div id="content-wrapper" class="container">
        <div class="row">
        <?php get_template_part( 'templ/sections/content', "top" ); ?>
        </div>

        <div class="row">

<?php


$min                      = [];
$min[0]                   = 3;
$min[1]                   = 6;
$min[2]                   = 3;
$GLOBALS['fazzo_set']     = [];
$GLOBALS['fazzo_set'] [0] = 3;
$GLOBALS['fazzo_set'] [1] = 9;
$GLOBALS['fazzo_set'] [2] = 3;

if ( is_home() || is_front_page() ) {
    if ( ! is_active_sidebar( 'fazzo-sidebar-frontpage' ) ) {
		$GLOBALS['fazzo_set'][1] = 12;
	}
} else {
	if ( has_nav_menu( 'meta-content-nav' ) && is_active_sidebar( 'fazzo-sidebar-content' ) ) {
		$GLOBALS['fazzo_set'] = $min;
	} elseif ( !has_nav_menu( 'meta-content-nav' ) && !is_active_sidebar( 'fazzo-sidebar-content' ) ) {
		$GLOBALS['fazzo_set'][1] = 12;
	}
}


get_template_part( 'templ/sections/content', "left" );
get_template_part( 'templ/sections/content', "middle" );