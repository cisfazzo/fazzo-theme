<?php

namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/";
require_once( $dir_root . "security.php" );

get_header();

get_template_part( 'templ/page/author' );

get_footer();