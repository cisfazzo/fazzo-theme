<?php
namespace fazzo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div id="footer-bottom-wrapper-full">
    <div id="footer-bottom-wrapper" class="container">
        <div class="row">
            <div class="col<?php echo $GLOBALS["fazzo_breakpoint"]; ?>-12" id="footer-last-copyright">
				<?php echo __( "©", FAZZO_THEME_TXT ) . " " .date_i18n( "Y" )." ". __( "by", FAZZO_THEME_TXT ) . " " . get_bloginfo( "name" ); ?>
            </div><!-- footer-last-copyright -->
        </div><!-- row -->
    </div><!-- footer-last-wrapper -->
</div><!-- footer-last-wrapper-full -->
</div><!-- footer-full-wrapper -->
<?php wp_footer(); ?>
</body>
</html>