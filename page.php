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