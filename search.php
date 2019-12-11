<?php
namespace fazzo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

if ( have_posts() ) {
	$fazzo_have_posts = true;

	?>
    <p><?php printf( __( 'Search Results for: %s', FAZZO_THEME_TXT ), '<span>' . get_search_query() . '</span>' ); ?></p><?php

	while ( have_posts() ) {
		the_post();
		get_template_part( 'templ/post/post', get_post_format() );
	};
} else {
	?>
    <p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords', FAZZO_THEME_TXT ); ?></p><?php
	?>
    <div class="content-search-wrapper">
		<?php get_search_form(); ?>
    </div><!-- content-search-wrapper -->
	<?php
}

get_footer();