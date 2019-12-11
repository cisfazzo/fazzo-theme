<?php
namespace fazzo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( post_password_required() ) {
	return;
}

?><div class="comments-full-wrapper">
<?php if ( have_comments() ){ ?>
    <div class="comment-title">
		<?php
		printf( esc_html__( _nx( 'One comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', FAZZO_THEME_TXT ) ), number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
		?>
    </div><!-- comment-title -->
	<?php fazzo::get_comments_navigation(); ?>
    <ol class="comment-list">
		<?php
		$args = [
			'walker'            => null,
			'max_depth'         => '',
			'style'             => 'ol',
			'callback'          => null,
			'end-callback'      => null,
			'type'              => 'all',
			'reply_text'        => __( 'Reply', FAZZO_THEME_TXT ),
			'page'              => '',
			'per_page'          => '',
			'avatar_size'       => 64,
			'reverse_top_level' => null,
			'reverse_children'  => '',
			'format'            => 'html5',
			'short_ping'        => false,
			'echo'              => true,
		];
		wp_list_comments( $args );
		?>
    </ol><!-- comment-list -->
	<?php fazzo::get_comments_navigation();
	if ( ! comments_open() && get_comments_number() ) { ?>
        <div class="no-comments"><?php esc_html_e( 'Comments are closed.', FAZZO_THEME_TXT ); ?></div><!-- no-comments -->
	<?php }
	}
	$fields = [
		'author' => '<div class="form-group"><label for="author">' . __( 'Name', FAZZO_THEME_TXT ) . '</label> <span class="required">*</span> <input id="author" name="author" type="text" class="form-control" value="' . esc_attr( $commenter['comment_author'] ) . '" required="required" /></div>',
		'email'  => '<div class="form-group"><label for="email">' . __( 'Email', FAZZO_THEME_TXT ) . '</label> <span class="required">*</span><input id="email" name="email" class="form-control" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . '" required="required" /></div>',
		'url'    => '<div class="form-group last-field"><label for="url">' . __( 'Website', FAZZO_THEME_TXT ) . '</label><input id="url" name="url" class="form-control" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" /></div>',
	];

	$args = [
		'class_submit'  => 'btn btn-block btn-lg btn-primary',
		'label_submit'  => __( 'Submit Comment', FAZZO_THEME_TXT ),
		'comment_field' => '<div class="form-group"><label for="comment">' . _x( 'Comment', 'noun', FAZZO_THEME_TXT ) . '</label> <span class="required">*</span><textarea id="comment-textarea" class="form-control" name="comment" required="required"></textarea></div>',
		'fields'        => apply_filters( 'comment_form_default_fields', $fields ),
	];
	comment_form( $args );
	?>
</div><!-- comments-full-wrapper -->