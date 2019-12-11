<?php
namespace fazzo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<nav class="comment-navigation leftright" role="navigation">
    <div class="left post-link-nav">
        <span><?php previous_comments_link( esc_html__( 'Older Comments', FAZZO_THEME_TXT ) ) ?></span>
    </div>
    <div class="right post-link-nav">
        <span><?php next_comments_link( esc_html__( 'Newer Comments', FAZZO_THEME_TXT ) ) ?></span>
    </div>
</nav>