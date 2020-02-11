<?php
namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );

?>
<nav class="navbar navbar-expand<?php echo $GLOBALS["fazzo_breakpoint"]; ?>">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#meta-bottom-nav"
            aria-controls="meta-bottom-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="meta-bottom-nav">
		<?php


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

		?>

    </div><!-- meta-bottom-nav -->
</nav>