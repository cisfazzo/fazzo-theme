<?php

namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );

$post_nav_display = get_theme_mod( fazzo::$prefix .'show_post_nav', 1 );

if ( $post_nav_display ) {
	?>
    <nav class="post-navigation row-flex">
        <div class="post-link-nav row-1">
            <p><?php previous_post_link(); ?></p>
        </div>
        <div class="post-link-nav row-2 text-right">
            <p><?php next_post_link(); ?></p>
        </div>
    </nav>
<?php }