<?php

namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );


$content = "";

$content .= "<div class='wrap'>
			<h1 id='page-title'>" . esc_html__( 'Config', "fazzotheme" ) . "</h1>
			<hr>
			<form action='$form_action_url' method='post'>
			<input type='hidden' name='$nonce_input_key' id='$nonce_input_key' value='" . $nonce_value . "' />
			<input type='hidden' id='todo_settings' name='todo' value='config'>
			
			<p><span>" . __( "Load Bootstrap", "fazzotheme" ) . "</span> <select name='load_bootstrap'><option value='0'>" . __( "No", "fazzotheme" ) . "</option><option value='1'";
if ( static::$options['load_bootstrap'] ) {
	$content .= " selected=selected";
}
$content .= ">" . __( "Yes", "fazzotheme" ) . "</option></select></p>
			

			<p><span>" . __( "Use Paged Menu", "fazzotheme" ) . "</span> <select name='paged_menu'><option value='0'>" . __( "No", "fazzotheme" ) . "</option><option value='1'";
if ( static::$options['paged_menu'] ) {
	$content .= " selected=selected";
}
$content .= ">" . __( "Yes", "fazzotheme" ) . "</option></select></p>

			
			<input type='submit' value='" . __( "Save", "fazzotheme" ) . "'></form></div>\n";


echo $content;