<?php
namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );

?>
<div id="sec_head" class="wrapper">
	<?php
	get_template_part( 'templ/sections/head', "top" );
	get_template_part( 'templ/sections/head', "content" );
	get_template_part( 'templ/sections/head', "nav" );
	?>
</div>
