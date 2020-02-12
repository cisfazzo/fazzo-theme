<?php

namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );

?>
    <div id="sec_content" class="wrapper">
        <div class="wrap_cm wrapper row-flex">
	<?php

get_template_part( 'templ/sections/content', "nav" );
get_template_part( 'templ/sections/content', "output-before" );