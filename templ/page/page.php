<?php
namespace fazzo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'thumbnail-article' ); ?> >
		<?php if ( has_post_thumbnail() ) {
			$post_thumnail_url = fazzo_functions::post_thumbnail_url( $post );
			?>
            <div class="thumbnail-background" style="background-image: url('<?php echo $post_thumnail_url; ?>');">
				<?php if ( ! is_single() ) { ?><a href="<?php the_permalink( $post ); ?>"
                                                  class="thumbnail-link"></a><?php } ?>
            </div><!-- thumbnail-background -->
		<?php } ?>

        <header>
			<?php the_title( '<h1><a href="' . get_the_permalink( $post ) . '">', '</a></h1>' ); ?>
			<?php fazzo_functions::edit_link(); ?>
        </header>

        <div class="article-wrapper">
			<?php
			the_content();
			?>
        </div><!-- article-wrapper -->
		<?php
		fazzo_functions::entry_footer();
		?>
    </article>
<?php
get_template_part( 'templ/nav/pages' );
if ( comments_open() || get_comments_number() ) {
	comments_template();
}
