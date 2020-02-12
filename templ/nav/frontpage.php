<?php

namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );

?>
<header class="clearfix navbar-light">
    <nav class="navbar navbar-expand<?php echo $GLOBALS["fazzo_breakpoint"]; ?>" id="meta-frontpage-nav">
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


