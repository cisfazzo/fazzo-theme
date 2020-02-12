<?php
namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/";
require_once( $dir_root . "security.php" );

$fazzo_unique_id = esc_attr( uniqid( 'search-form-' ) ); ?>

<form role="search" method="get" class="search-form" action="<?php

// Polylang Support (https://polylang.wordpress.com/documentation/documentation-for-developers/functions-reference/)
if ( function_exists( "pll_current_language" ) ) {
	$lang_dir = pll_current_language();
	if ( ! empty( $lang_dir ) ) {
		$lang_dir .= "/";
	}
	echo home_url( '/' ) . $lang_dir;
} else {
	echo home_url( '/' );
}

?>">
    <div class="search-button-wrapper">
        <i class="fa fa-search" id="search-collapse"></i>
        <input type="submit" class="search-submit form-control"
               value="<?php echo esc_attr_x( 'Search', 'submit button', FAZZO_THEME_TXT ) ?>"/>
    </div><!-- search-button-wrapper -->
    <label>
        <span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', FAZZO_THEME_TXT ) ?></span>
        <input class="form-control search-field"
               id="<?php echo $fazzo_unique_id; ?>"
               type="search"
               placeholder="<?php echo esc_attr_x( 'Type text &hellip;', 'placeholder', FAZZO_THEME_TXT ) ?>"
               value="<?php echo get_search_query() ?>"
               name="s"
               aria-label="Search"/>
    </label>

</form>