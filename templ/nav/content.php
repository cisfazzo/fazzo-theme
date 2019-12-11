<?php
namespace fazzo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<header class="clearfix navbar-light">

	<nav class="navbar navbar-offcanvas navbar-offcanvas-touch navbar-expand-sm" id="meta-content-nav">
        <button type="button"
                class="navbar-toggler navbar-toggle offcanvas-toggle bg-light"
                data-toggle="offcanvas" data-target="#meta-content-nav"
                aria-controls="meta-content-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon"></span>
        </button>
		<div class="container-fluid">
			<?php
			wp_nav_menu( [
				"theme_location" => "meta-content-nav",
				'menu'           => "meta-content-nav",
				'depth'          => 2,
				"container"      => false,
				"menu_class"     => "navbar-nav mr-auto",
				"fallback_cb"    => "fazzo_nav_walker::fallback",
				"walker"         => new fazzo_nav_walker(),
			] );
			?>
		</div><!-- container-fluid -->
	</nav><!-- meta-content-nav -->
</header>