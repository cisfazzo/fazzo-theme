<?php

namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );

if ( ( is_home() || is_front_page() ) && is_active_sidebar( 'fazzo-sidebar-frontpage' ) ) {

	?>
    <div id="wrap_content_widget" class="block_line row-3 wrapper">
		<?php get_template_part( 'templ/sidebar/frontpage' ); ?>
    </div>
<?php } elseif ( ! ( is_home() || is_front_page() ) && is_active_sidebar( 'fazzo-sidebar-content' ) ) {

	?>
    <div id="wrap_content_widget" class="block_line row-3 wrapper">
		<?php get_template_part( 'templ/sidebar/content' ); ?>
    </div>
<?php }
