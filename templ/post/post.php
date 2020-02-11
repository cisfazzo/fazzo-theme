<?php
namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );


$element_style = functions::get_background_style( $post );

?>
<article <?php echo $element_style ?> id="post-<?php the_ID(); ?>" <?php post_class( 'thumbnail-article' ); ?> >
	<?php if ( has_post_thumbnail() ) {
		$post_thumnail_url = functions::post_thumbnail_url( $post );
		?>
        <div class="thumbnail-background" style="background-image: url('<?php echo $post_thumnail_url; ?>');">
			<?php if ( ! is_single( $post ) ) { ?><a href="<?php the_permalink( $post ); ?>"
                                                     class="thumbnail-link"></a><?php } ?>
        </div><!-- thumbnail-background -->
	<?php } ?>

    <header>
		<?php if ( ! is_single() ) {
			the_title( '<h2><a href="' . get_the_permalink( $post ) . '">', '</a></h2>' );
		} else {
			the_title( '<h1>', '</h1>' );
		} ?>
		<?php functions::edit_link(); ?>
    </header>
	<?php
	functions::entry_details();
	?>
    <div class="article-wrapper">
		<?php
		if ( ! is_single( $post ) ) {
			the_excerpt();
		} else {
			the_content();
		}
		?>
    </div><!-- article-wrapper -->
	<?php
	functions::entry_footer();
	?>
</article>
