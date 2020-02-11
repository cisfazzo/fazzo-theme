<?php

namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );

?>
<header class="clearfix navbar-light">

    <nav class="navbar navbar-offcanvas navbar-offcanvas-touch navbar-expand-sm" id="meta-frontpage-nav">
        <button type="button"
                class="navbar-toggler navbar-toggle offcanvas-toggle bg-light"
                data-toggle="offcanvas" data-target="#meta-frontpage-nav"
                aria-controls="meta-frontpage-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="container-fluid">
			<?php

			$walker = '\fazzo\nav_walker';
			wp_nav_menu( [
				"theme_location" => "meta-frontpage-nav",
				'menu'           => "meta-frontpage-nav",
				'depth'          => 0,
				"container"      => false,
				"menu_class"     => "navbar-nav mr-auto",
				"fallback_cb"    => $walker . "::fallback",
				"walker"         => new $walker,
			] );

			?>
        </div><!-- container-fluid -->
    </nav><!-- meta-frontpage-nav -->
</header>


