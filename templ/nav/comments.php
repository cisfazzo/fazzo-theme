<?php
namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );

?>
<nav class="comment-navigation row-flex">
    <div class="post-link-nav row-1">
        <span><?php previous_comments_link( esc_html__( 'Older Comments', "fazzotheme" ) ) ?></span>
    </div>
    <div class="post-link-nav row-2 text-right">
        <span><?php next_comments_link( esc_html__( 'Newer Comments', "fazzotheme" ) ) ?></span>
    </div>
</nav>