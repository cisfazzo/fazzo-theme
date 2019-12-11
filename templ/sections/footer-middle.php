<?php
namespace fazzo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php if ( is_active_sidebar( 'fazzo-sidebar-bottom-a' ) || is_active_sidebar( 'fazzo-sidebar-bottom-b' ) || is_active_sidebar( 'fazzo-sidebar-bottom-c' ) ) { ?>
    <div id="footer-middle-full-wrapper">
        <div class="container" id="footer-middle-wrapper">
            <div class="row">
				<?php
				get_template_part( 'templ/sidebar/bottom' );
				?>
            </div><!-- row -->
        </div><!-- footer-middle-wrapper -->
    </div><!-- footer-middle-full-wrapper -->
<?php } ?>

