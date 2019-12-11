<?php
namespace fazzo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>


</div><!-- content-middle-wrapper -->
<?php
if ( ( is_home() || is_front_page() ) && is_active_sidebar( 'fazzo-sidebar-frontpage' ) ) {

	?>
	<div id="content-right-wrapper" class="col<?php echo $GLOBALS["fazzo_breakpoint"]."-".$GLOBALS['fazzo_set'][2]; ?>">
        <div id="content-right-wrapper-frontpage">
		<?php get_template_part( 'templ/sidebar/frontpage' ); ?>
        </div>
	</div><!-- content-sidebar-wrapper (frontpage) -->
<?php } elseif (!( is_home() || is_front_page() ) && is_active_sidebar( 'fazzo-sidebar-content' ) ) {

	?>
	<div id="content-right-wrapper" class="col<?php echo $GLOBALS["fazzo_breakpoint"]."-".$GLOBALS['fazzo_set'][2]; ?>">
		<?php get_template_part( 'templ/sidebar/content' ); ?>
	</div><!-- content-sidebar-wrapper (content) -->
<?php }
