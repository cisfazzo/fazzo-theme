<?php
namespace fazzo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/*
 *
 * 			wp_nav_menu( [
				"theme_location" => "meta-top-nav",
				'menu'           => "meta-top-nav",
				'depth'          => 2,
				"container"      => false,
				"menu_class"     => "navbar-nav mr-auto collapse-hidden collapse-pack",
				"fallback_cb"    => "fazzo_nav_walker::fallback",
				"walker"         => new fazzo_nav_walker(),
			] );

			wp_nav_menu( [
				"theme_location" => "meta-content-nav",
				'menu'           => "meta-content-nav",
				'depth'          => 2,
				"container"      => false,
				"menu_class"     => "navbar-nav mr-auto collapse-hidden collapse-pack",
				"fallback_cb"    => "fazzo_nav_walker::fallback",
				"walker"         => new fazzo_nav_walker(),
			] );
			wp_nav_menu( [
				"theme_location" => "meta-bottom-nav",
				'menu'           => "meta-bottom-nav",
				'depth'          => 2,
				"container"      => false,
				"menu_class"     => "navbar-nav mr-auto collapse-hidden collapse-pack",
				"fallback_cb"    => "fazzo_nav_walker::fallback",
				"walker"         => new fazzo_nav_walker(),
			] );e
 *
 *
 *

 */
?>



            <nav class="navbar navbar-expand<?php echo $GLOBALS["fazzo_breakpoint"]; ?> navbar-light">
                <button class="navbar-toggler" type="button" data-toggle="offcanvas" data-target="#meta-head-nav" aria-controls="meta-head-nav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class=" offcanvas-collapse offcanvas-collapse<?php echo $GLOBALS["fazzo_breakpoint"]; ?> navbar-collapse" id="meta-head-nav">
			<?php

			$walker = '\fazzo\fazzo_nav_walker';
            if(isset(fazzo::$options["paged_menu"]) && fazzo::$options["paged_menu"])
            {
                $walker = '\fazzo\fazzo_nav_walker_paged';
            }

			wp_nav_menu( [
				"theme_location" => "meta-head-nav",
				'menu'           => "meta-head-nav",
				'depth'          => 10,
				"container"      => false,
				"menu_class"     => "navbar-nav mr-auto mt-2 mt".$GLOBALS["fazzo_breakpoint"]."-0",
				"fallback_cb"    => $walker."::fallback",
				"walker"         => new $walker,
			] );
			?>

                </div><!-- meta-head-nav -->
            </nav>
