<?php
namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );
?>

<?php if ( has_nav_menu( 'meta-bottom-nav' ) ) { ?>
    <div id="sec_foot_nav" class="wrapper">
        <div id="wrap_foot_nav" class="wrap_cm wrapper">
			<?php
			get_template_part( 'templ/nav/bottom' );
			?>
        </div>
    </div>
<?php } ?>
