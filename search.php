<?php

namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/";
require_once( $dir_root . "security.php" );

get_header();

if ( have_posts() ) {

	$search_results_for = get_search_query();

	if ( ! empty( $search_results_for ) ) {
		echo "<header><h1>" . __( 'Search results for', "fazzotheme" ) . " " . $search_results_for . '</h1></header>';
	} else {
		echo "<header><h1>" . __( 'Search results', "fazzotheme" ) . '</h1></header>';
	}

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
    <article><p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords', "fazzotheme" ); ?></p></article><?php
}

get_footer();