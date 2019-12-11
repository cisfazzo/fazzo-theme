<?php

namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );


$content = "";

$content .= "<div class='wrap'>
			<h1 id='page-title'>" . esc_html__( 'Config', FAZZO_THEME_TXT ) . "</h1>
			<hr>
			<form action='$form_action_url' method='post'>
			<input type='hidden' name='$nonce_input_key' id='$nonce_input_key' value='" . $nonce_value . "' />
			<input type='hidden' id='todo_settings' name='todo' value='config'>
			
			<p><span>".__("Load Bootstrap", FAZZO_THEME_TXT)."</span> <select name='load_bootstrap'><option value='0'>".__("No", FAZZO_THEME_TXT)."</option><option value='1'";
if(static::$options['load_bootstrap']) $content .= " selected=selected";
$content .= ">".__("Yes", FAZZO_THEME_TXT)."</option></select></p>
			

			<p><span>".__("Use Paged Menu", FAZZO_THEME_TXT)."</span> <select name='paged_menu'><option value='0'>".__("No", FAZZO_THEME_TXT)."</option><option value='1'";
if(static::$options['paged_menu']) $content .= " selected=selected";
$content .= ">".__("Yes", FAZZO_THEME_TXT)."</option></select></p>

			
			<input type='submit' value='" . __( "Save", FAZZO_THEME_TXT ) . "'></form></div>\n";


echo $content;