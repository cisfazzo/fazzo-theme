<?php

namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );


$display_search = get_theme_mod( fazzo::$prefix . 'show_search', 1 );

if ( has_nav_menu( 'meta-top-nav' ) || is_active_sidebar( 'fazzo-sidebar-top' ) || $display_search ) {
	?>
    <div id="sec_head_meta" class="wrapper">
        <div class="wrap_cm wrapper row-flex">
			<?php if ( has_nav_menu( 'meta-top-nav' ) ) { ?>
                <div id="wrap_top_nav" class="block_line row-1 wrapper">
					<?php get_template_part( 'templ/nav/top' ); ?>
                </div>
			<?php }
			if ( is_active_sidebar( 'fazzo-sidebar-top' ) ) { ?>
                <div id="wrap_top_widget" class="block_line row-2 wrapper">
					<?php get_template_part( 'templ/sidebar/top' ); ?>
                </div>
			<?php }
			if ( $display_search ) {
				?>

                <div id="wrap_top_search" class="block_line row-3 wrapper">
					<?php get_search_form(); ?>
                </div>

			<?php } ?>
        </div>
    </div>
<?php }
