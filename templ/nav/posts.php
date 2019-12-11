<?php
namespace fazzo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_nav_display = get_theme_mod( 'post_nav_display', fazzo::$customizer_defaults["post_nav_display"] );

if($post_nav_display) {
?>
<nav class="post-navigation leftright" role="navigation">
	<div class="left post-link-nav">
		<span><?php previous_post_link(); ?></span>
	</div>
	<div class="right post-link-nav">
		<span><?php next_post_link(); ?></span>
	</div>
</nav>
<?php }