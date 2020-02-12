<?php

namespace fazzo;

$dir_root = dirname( __FILE__ ) . "/";
require_once( $dir_root . "security.php" );

if ( ! isset( $content_width ) ) {
	$content_width = 1920;
}

/*
* Absoluter Pfad zum Theme
* string
*/
if ( ! defined( 'FAZZO_THEME_ROOT' ) ) {
	define( 'FAZZO_THEME_ROOT', dirname( __FILE__ ) );
}

/*
* URL Adresse zum Theme
* string
*/
if ( ! defined( 'FAZZO_THEME_URL' ) ) {
	define( 'FAZZO_THEME_URL', get_template_directory_uri() );
}


/*
* Füge Klassen hinzu
*/
require_once( FAZZO_THEME_ROOT . "/class/fazzo.php" );

/*
* Speichere die absolute Menütiefe
*/
add_action( 'init', array( 'fazzo\functions', 'store_current_menu_depth' ) );

/*
* Starte die Hauptklasse
*/
$fazzo_theme = fazzo::instance();
