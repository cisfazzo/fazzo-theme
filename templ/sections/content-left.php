<?php
namespace fazzo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( has_nav_menu( 'meta-frontpage-nav' ) && ( is_home() || is_front_page() ) ) { ?>
    <div id="content-left-wrapper" class="col<?php echo $GLOBALS["fazzo_breakpoint"]."-".$GLOBALS['fazzo_set'][0]; ?>">
        <div id="content-left-wrapper-frontpage">
			<?php
			get_template_part( 'templ/nav/frontpage' );
			?>
        </div><!-- meta-frontpage-nav-wrapper -->
    </div><!-- meta-content-nav-wrapper (frontpage)-->

<?php } elseif ( has_nav_menu( 'meta-content-nav' )&& !( is_home() || is_front_page() ) )  {	?>
    <div id="content-left-wrapper" class="col<?php echo $GLOBALS["fazzo_breakpoint"]."-".$GLOBALS['fazzo_set'][0]; ?>">
		<?php
		get_template_part( 'templ/nav/content' );
		?>
    </div><!-- meta-content-nav-wrapper (content)-->
	<?php }



