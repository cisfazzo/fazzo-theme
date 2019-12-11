<?php
namespace fazzo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php if ( has_nav_menu( 'meta-bottom-nav' ) ) { ?>
	<div id="footer-top-full-wrapper">
		<div class="container" id="footer-top-wrapper">
			<div class="row">
				<div id="bottom-nav-wrapper" class="col<?php echo $GLOBALS["fazzo_breakpoint"]; ?>-12">
					<?php
					get_template_part( 'templ/nav/bottom' );
					?>
				</div><!-- bottom-nav-wrapper -->
			</div><!-- row -->
		</div><!-- bottom-wrapper -->
	</div><!-- bottom-full-wrapper -->
<?php } ?>
