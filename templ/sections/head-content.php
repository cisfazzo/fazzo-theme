<?php
namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );

$display_description = get_theme_mod( 'display_description', 1 );

?>
<div id="sec_head_content" class="clear wrapper">
    <div id="wrap_head_content" class="wrap_cm wrapper">

		<?php if ( has_header_image() ) {
			$fazzo_head_image = get_header_image_tag();
			if ( ! empty( $fazzo_head_image ) ) { ?>
                <div id="head-image"><a href="<?php echo home_url(); ?>"><?php echo $fazzo_head_image; ?></a>
                </div>
			<?php }
		}
		if ( display_header_text() ) {
			if ( is_home() || is_front_page() ) {
				$fazzo_description = get_bloginfo( "description" );
			} else {
				$fazzo_description = single_post_title( "", false );
			} ?>
            <div id="head-text">
                <h1 id="head-title"><a href="<?php echo home_url(); ?>"><?php bloginfo( "name" ); ?></a></h1>
				<?php if ( ! empty( $fazzo_description ) && $display_description ) { ?>
                    <div id="head-description"><span><?php echo $fazzo_description; ?></span></div><?php } ?>
            </div><!-- head-text -->
		<?php } ?>

    </div>
</div>
