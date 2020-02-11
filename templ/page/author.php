<?php
namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );

$curauth = ( get_query_var( 'author_name' ) ) ? get_user_by( 'slug', get_query_var( 'author_name' ) ) : get_userdata( get_query_var( 'author' ) );

$authorname = "";

if ( ! empty( $curauth->first_name ) ) {
	$authorname = $curauth->first_name;
}

if ( ! empty( $curauth->last_name ) ) {
	if ( ! empty( $curauth->first_name ) ) {
		$authorname .= " ";
	}

	$authorname .= $curauth->last_name;
}

if ( empty( $authorname ) ) {
	$authorname = $curauth->display_name;
}

if ( empty( $authorname ) ) {
	$authorname = $curauth->nickname;
}

if ( empty( $curauth->description ) ) {
	$authordescription = "<p>" . __( "No further informations", MCC_THEME_TXT ) . "</p>";
} else {
	$authordescription = wpautop( $curauth->description, true );
}

$authoravatar = get_avatar( $curauth->ID, 256 );


?>
<article>
    <header>
        <h1><?php echo $authorname ?></h1>
    </header>
    <div class="article-wrapper row-flex">
		<?php if ( ! empty( $authoravatar ) ) { ?>
            <div class="row-1"><?php echo $authoravatar ?></div>
		<?php } ?>
        <div class="row-2"><?php echo $authordescription ?></div>


    </div><!-- article-wrapper -->
</article>