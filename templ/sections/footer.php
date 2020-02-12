<?php
namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );

?>
<div id="sec_foot" class="clear wrapper">
	<?php
	get_template_part( 'templ/sections/footer', "nav" );
	get_template_part( 'templ/sections/footer', "widgets" );
	get_template_part( 'templ/sections/footer', "text" );

	?></div>

<?php wp_footer(); ?>
</div>
</body>
</html>