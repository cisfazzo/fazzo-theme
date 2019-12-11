<?php
namespace fazzo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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
<body <?php body_class(); ?> data-spy="scroll" data-target=".nav-scroll" data-offset="260">
<div id="body-wrapper">
    <div id="z-index-counter" style="position:relative;display:none;"></div>
    <div id="full-header-wrapper">

		<?php
		get_template_part( 'templ/sections/head' );
		get_template_part( 'templ/sections/content', 'start' );

