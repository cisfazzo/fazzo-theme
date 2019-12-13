<?php
namespace fazzo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( has_nav_menu( 'meta-frontpage-nav' )&& ( is_home() || is_front_page() ) )  {	?>
    <div id="content-top-wrapper">
		<?php
		get_template_part( 'templ/nav/frontpage' );
		?>
    </div><!-- meta-content-nav-wrapper (content)-->
	<?php }



