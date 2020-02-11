<?php

namespace fazzo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

if ( have_posts() ) {
	$fazzo_have_posts = true;

	?>
    <p><?php

	$search_results_for = get_search_query();

	if ( ! empty( $search_results_for ) ) {
		echo "<h1>" . __( 'Search Results for', FAZZO_THEME_TXT ) . " " . $search_results_for . '</h1>';
	} else {
		echo "<h1>" . __( 'Search Results', FAZZO_THEME_TXT ) . '</h1>';
	}

	?></p><?php

	while ( have_posts() ) {
		the_post();
		switch ( $post->post_type ) {
			case "page":
				get_template_part( 'templ/page/page' );
				break;
			case "post":
				get_template_part( 'templ/post/post', get_post_format() );
				break;
			default:
				// Nothing
				break;

		}
	};
} else {
	?>
    <p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords', FAZZO_THEME_TXT ); ?></p><?php
}

get_footer();