<?php
namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/";
require_once( $dir_root . "security.php" );

$GLOBALS["fazzo_breakpoint"] = "-sm";

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( "charset" ); ?>">
    <meta name="description" content="<?php bloginfo( "description" ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ): ?>
        <link rel="pingback" href="<?php bloginfo( "pingback_url" ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="body_overlay" class="wrap wrapper">

<?php
get_template_part( 'templ/sections/head' );
get_template_part( 'templ/sections/content', 'head' );

