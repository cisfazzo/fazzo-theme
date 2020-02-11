<?php

namespace fazzo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
if ( have_posts() ) {
	$fazzo_have_posts = true;
	while ( have_posts() ) {
		the_post();
		get_template_part( 'templ/nav/posts' );
		get_template_part( 'templ/post/post', get_post_format() );
		get_template_part( 'templ/nav/posts' );
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
	};
} else {
	get_template_part( 'templ/post/post', 'none' );
}
get_footer();
