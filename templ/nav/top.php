<?php
namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );

?>

<nav class="navbar navbar-expand<?php echo $GLOBALS["fazzo_breakpoint"]; ?>">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#meta-top-nav"
            aria-controls="meta-top-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="meta-top-nav">
		<?php

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

		?>
    </div><!-- container-fluid -->
</nav><!-- meta-top-nav -->
