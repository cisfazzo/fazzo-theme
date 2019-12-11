<?php
namespace fazzo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

    <article>
            <header>
                <h1><?php _e( 'Oops! That page can&rsquo;t be found.', FAZZO_THEME_TXT ); ?></h1>
            </header>
            <div class="article-wrapper">
                <p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', FAZZO_THEME_TXT ); ?></p>
                <div class="content-search-wrapper">
					<?php get_search_form(); ?>
                </div><!-- content-search-wrapper -->
            </div><!-- article-wrapper -->
    </article>

<?php
get_footer();
