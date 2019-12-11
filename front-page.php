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
		get_template_part( 'templ/page/front-page');
	};
} else {
	get_template_part( 'templ/post/post', 'none' );
}
get_footer();