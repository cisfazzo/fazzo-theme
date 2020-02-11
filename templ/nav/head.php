<?php
namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );

?>


<nav class="navbar navbar-expand<?php echo $GLOBALS["fazzo_breakpoint"]; ?> navbar-light">
    <button class="navbar-toggler" type="button" data-toggle="offcanvas" data-target="#meta-head-nav"
            aria-controls="meta-head-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class=" offcanvas-collapse offcanvas-collapse<?php echo $GLOBALS["fazzo_breakpoint"]; ?> navbar-collapse"
         id="meta-head-nav">

        <div id="wrap_top_nav_collapsed">
			<?php
			if ( has_nav_menu( 'meta-top-nav' ) ) {
				$walker = '\fazzo\nav_walker';
				wp_nav_menu( [
					"theme_location" => "meta-top-nav",
					'menu'           => "meta-top-nav",
					'depth'          => 0,
					"container"      => false,
					"menu_class"     => "navbar-nav mr-auto",
					"fallback_cb"    => $walker . "::fallback",
					"walker"         => new $walker,
				] );
			}
			?></div><?php

		if ( isset( fazzo::$options["paged_menu"] ) && fazzo::$options["paged_menu"] ) {
			new nav_paged( "meta-head-nav" );
		} else {
			$walker = '\fazzo\nav_walker';
			wp_nav_menu( [
				"theme_location" => "meta-head-nav",
				'menu'           => "meta-head-nav",
				'depth'          => 2,
				"container"      => false,
				"menu_class"     => "navbar-nav mr-auto mt-2 mt" . $GLOBALS["fazzo_breakpoint"] . "-0",
				"fallback_cb"    => $walker . "::fallback",
				"walker"         => new $walker,
			] );
		}

		?>
        <div id="sec_foot_nav_collapsed"><?php

			if ( has_nav_menu( 'meta-bottom-nav' ) ) {
				$walker = '\fazzo\nav_walker';
				wp_nav_menu( [
					"theme_location" => "meta-bottom-nav",
					'menu'           => "meta-bottom-nav",
					'depth'          => 0,
					"container"      => false,
					"menu_class"     => "navbar-nav mr-auto mt-2 mt" . $GLOBALS["fazzo_breakpoint"] . "-0",
					"fallback_cb"    => $walker . "::fallback",
					"walker"         => new $walker,
				] );
			}

			?>
        </div>
    </div><!-- meta-head-nav -->
</nav>
