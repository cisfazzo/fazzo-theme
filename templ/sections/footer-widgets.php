<?php
namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );
?>

<?php if ( is_active_sidebar( 'fazzo-sidebar-bottom-a' ) || is_active_sidebar( 'fazzo-sidebar-bottom-b' ) || is_active_sidebar( 'fazzo-sidebar-bottom-c' ) ) { ?>
    <div id="wrap_foot_widget" class="wrap_cm wrapper row-flex">
		<?php
		get_template_part( 'templ/sidebar/bottom' );
		?>
    </div>
<?php } ?>

