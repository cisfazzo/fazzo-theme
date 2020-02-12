<?php

namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );


if ( ( ! ( is_home() || is_front_page() ) ) && has_nav_menu( 'meta-content-nav' ) ) {

	?>
    <div id="wrap_content_nav" class="block_line row-1 wrapper">
		<?php get_template_part( 'templ/nav/content' ); ?>
    </div>
<?php } elseif ( ( is_home() || is_front_page() ) && has_nav_menu( 'meta-frontpage-nav' ) ) {

	?>
    <div id="wrap_content_nav" class="block_line row-1 wrapper">
		<?php get_template_part( 'templ/nav/frontpage' ); ?>
    </div>
<?php }


