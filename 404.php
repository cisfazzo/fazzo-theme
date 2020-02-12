<?php

namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/";
require_once( $dir_root . "security.php" );

get_header();
?>

    <article>
        <header>
            <h1><?php _e( "Oops! That page can't be found.", "fazzotheme" ); ?></h1>
        </header>
        <div class="article-wrapper">
            <p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', "fazzotheme" ); ?></p>
            <div class="content-search-wrapper">
				<?php get_search_form(); ?>
            </div><!-- content-search-wrapper -->
        </div><!-- article-wrapper -->
    </article>

	<?php
get_footer();
