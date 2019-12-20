<?php
namespace fazzo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//$display_description = get_theme_mod( 'head_description_display', fazzo::$customizer_defaults["head_description_display"] );
$display_description = true;

$min    = [];
$min[0] = 9;
$min[1] = 3;
$set    = [];
$set[0] = 12;
$set[1] = 0;
if ( is_active_sidebar( 'fazzo-sidebar-head' ) ) {
	$set = $min;
}

?>
<div id="head-middle-full-wrapper">
    <div class="container-fluid" id="head-middle-wrapper">
        <div class="row">
            <div class="col<?php echo $GLOBALS["fazzo_breakpoint"]."-".$set[0]; ?>" id="head-bloginfo-wrapper">
				<?php if ( ( is_home() || is_front_page() ) && has_header_image() ) {
					$fazzo_head_image = get_header_image_tag();
					if ( ! empty( $fazzo_head_image ) ) {
						?>
                        <div id="head-image"><a
                                    href="<?php echo get_option( 'home' ); ?>"><?php echo $fazzo_head_image; ?></a>
                        </div><!-- head-image -->
					<?php }
				}
				?>
				<?php if ( display_header_text() ) {
					if ( is_home() || is_front_page() ) {
						$fazzo_description = get_bloginfo( "description" );
					} else {
						$fazzo_description = single_post_title( "", false );
					} ?>
                    <div id="head-text">
                    <h1 id="head-title"><a href="<?php echo get_option( 'home' ); ?>"><?php bloginfo( "name" ); ?></a></h1>
					<?php if ( ! empty( $fazzo_description ) &&  $display_description) { ?>
                        <div id="head-description"><span><?php echo $fazzo_description; ?></span></div><?php } ?>
                    </div><!-- head-text -->
                <?php } ?>
            </div><!-- head-bloginfo-wrapper -->

            <?php if ( is_active_sidebar( 'fazzo-sidebar-head' ) ) { ?>
            <div id="head-sidebar-wrapper" class="col<?php echo $GLOBALS["fazzo_breakpoint"]."-".$set[1]; ?>">
		        <?php get_template_part( 'templ/sidebar/head' ); ?>
            </div><!-- head-sidebar-wrapper -->
            <?php } ?>

        </div>
    </div><!-- head-middle-wrapper -->
</div><!-- head-middle-full-wrapper -->
