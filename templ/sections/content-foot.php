<?php
namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );


get_template_part( 'templ/sections/content', "output-after" );
get_template_part( 'templ/sections/content', "widget" );

?>        </div>
</div>