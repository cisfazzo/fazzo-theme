<?php

namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/";
require_once( $dir_root . "security.php" );

get_header();
if ( have_posts() ) {


	?>
    <header>
		<?php
		functions::the_archive_title( '<h1>', '</h1>' );
		the_archive_description( '<div class="description">', '</div>' );
		?>
    </header>
	<?php


	while ( have_posts() ) {
		the_post();
		get_template_part( 'templ/post/post', get_post_format() );
	};
} else {
	get_template_part( 'templ/post/post', 'none' );
}
get_footer();