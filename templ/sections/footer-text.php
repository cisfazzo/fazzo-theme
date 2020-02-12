<?php
namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );

$start_year = get_theme_mod( fazzo::$prefix . "foot_text_year", date_i18n( "Y" ) );
if ( $start_year != date_i18n( "Y" ) ) {
	$start_year = " " . $start_year . " - ";
} else {
	$start_year = "";
}
?>

<div id="sec_foot_text" class="clear wrapper">
    <div id="wrap_foot_text" class="wrap_cm wrapper">
		<?php echo __( "©", "fazzotheme" ) . $start_year . " " . date_i18n( "Y" ) . " " . __( "by", "fazzotheme" ) . " " . get_bloginfo( "name" ); ?>
    </div>
</div>
