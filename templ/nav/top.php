<?php
namespace fazzo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<header class="clearfix navbar-light">


    <nav class="navbar navbar-offcanvas navbar-offcanvas-touch navbar-expand-sm" id="meta-top-nav">
        <button type="button"
                class="navbar-toggler navbar-toggle offcanvas-toggle bg-light"
                data-toggle="offcanvas" data-target="#meta-top-nav"
                aria-controls="meta-top-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="container-fluid">
			<?php

			$walker = '\fazzo\fazzo_nav_walker';
			if(isset(fazzo::$options["paged_menu"]) && fazzo::$options["paged_menu"])
			{
				$walker = '\fazzo\fazzo_nav_walker_paged';
			}

			wp_nav_menu( [
				"theme_location" => "meta-top-nav",
				'menu'           => "meta-top-nav",
				'depth'          => 2,
				"container"      => false,
				"menu_class"     => "navbar-nav mr-auto",
				"fallback_cb"    => $walker."::fallback",
				"walker"         => new $walker,
			] );
			?>
        </div><!-- container-fluid -->
    </nav><!-- meta-top-nav -->
</header>