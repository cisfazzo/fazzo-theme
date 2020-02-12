<?php

namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );

if ( has_nav_menu( 'meta-head-nav' ) ) { ?>
    <div id="sec_head_nav" class="wrapper">
        <div id="wrap_head_nav" class="wrap_cm wrapper">
			<?php
			get_template_part( 'templ/nav/head' );
			?>
        </div>
    </div>
<?php }
