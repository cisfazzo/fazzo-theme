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
        </div><!-- thumbnail-background -->
	<?php } ?>

    <header>
		<?php the_title( '<h1>', '</h1>' ); ?>
		<?php functions::edit_link(); ?>
    </header>
	<?php
	functions::entry_details();
	?>
    <div class="article-wrapper">
		<?php
		the_content( sprintf( __( 'Continue reading <span class="screen-reader-text">"%s"</span>', "fazzotheme" ), get_the_title() ) );
		?>
    </div><!-- article-wrapper -->
	<?php
	functions::entry_footer();
	?>
</article>
