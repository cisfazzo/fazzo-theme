<?php
namespace fazzo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
<header class="clearfix navbar-light">
	<button type="button"
	        class="navbar-toggler navbar-toggle offcanvas-toggle bg-light"
	        data-toggle="offcanvas" data-target="#meta-bottom-nav"
	        aria-controls="meta-bottom-nav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="sr-only">Toggle navigation</span>
		<span class="navbar-toggler-icon"></span>
	</button>
	<nav class="navbar navbar-offcanvas navbar-offcanvas-touch navbar-expand-sm" id="meta-bottom-nav">
		<div class="container-fluid">
			<?php
			wp_nav_menu( [
				"theme_location" => "meta-bottom-nav",
				'menu'           => "meta-bottom-nav",
				'depth'          => 2,
				"container"      => false,
				"menu_class"     => "navbar-nav mr-auto",
				"fallback_cb"    => "nav_walker::fallback",
				"walker"         => new nav_walker(),
			] );
			?>
		</div><!-- container-fluid -->
	</nav><!-- meta-bottom-nav -->
</header>
*/

?>
<nav class="navbar navbar-expand<?php echo $GLOBALS["fazzo_breakpoint"]; ?> navbar-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#meta-bottom-nav" aria-controls="meta-bottom-nav" aria-expanded="false" aria-label="Toggle navigation">
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