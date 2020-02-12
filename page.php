<?php

namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/";
require_once( $dir_root . "security.php" );

get_header();
if ( have_posts() ) {

	while ( have_posts() ) {
		the_post();
		get_template_part( 'templ/nav/pages' );
		get_template_part( 'templ/page/page' );
		get_template_part( 'templ/nav/pages' );
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	};
} else {
	get_template_part( 'templ/post/post', 'none' );
}
get_footer();