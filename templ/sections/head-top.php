<?php
namespace fazzo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$display_search = get_theme_mod( 'head_top_right_wrapper_display', fazzo::$customizer_defaults["head_top_right_wrapper_display"] );

$min    = [];
$min[0] = 6;
$min[1] = 3;
$min[2] = 3;
$set    = [];
$set[0] = 9;
$set[1] = 9;
$set[2] = 3;
if ( has_nav_menu( 'meta-top-nav' ) && is_active_sidebar( 'fazzo-sidebar-top' ) ) {
	$set = $min;
	if ( ! $display_search ) {
		$set[0] = 9;
	}
} elseif ( ! has_nav_menu( 'meta-top-nav' ) && ! is_active_sidebar( 'fazzo-sidebar-top' ) ) {
	$set[2] = 12;
}

?>
<div id="head-top-full-wrapper">
    <div class="container" id="head-top-wrapper">
        <div class="row">

			<?php if ( has_nav_menu( 'meta-top-nav' ) ) { ?>
                <div id="head-top-left-wrapper" class="col<?php echo $GLOBALS["fazzo_breakpoint"] . "-" . $set[0]; ?>">
					<?php get_template_part( 'templ/nav/top' ); ?>
                </div><!-- top-nav-wrapper -->
			<?php }
			if ( is_active_sidebar( 'fazzo-sidebar-top' ) ) { ?>
                <div id="head-top-middle-wrapper"
                     class="col<?php echo $GLOBALS["fazzo_breakpoint"] . "-" . $set[1]; ?>">
					<?php get_template_part( 'templ/sidebar/top' ); ?>
                </div>
			<?php }
			if ( $display_search ) { ?>
                <div id="head-top-right-wrapper" class="col<?php echo $GLOBALS["fazzo_breakpoint"] . "-" . $set[2]; ?>">
                    <ul class="navbar-nav mr-auto">
                        <li>
							<?php get_search_form(); ?>
                        </li>
                    </ul>
                </div><!-- top-search-wrapper -->
			<?php } ?>
        </div><!-- row -->
    </div><!-- top-wrapper -->
</div><!-- top-full-wrapper -->
