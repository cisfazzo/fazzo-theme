<?php
namespace fazzo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
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
* Textdomain für Übersetzungen
* string
*/
if ( ! defined( 'FAZZO_THEME_TXT' ) ) {
	define( 'FAZZO_THEME_TXT', "fazzotheme" );
}

//Füge Klassen hinzu:
require_once( FAZZO_THEME_ROOT . "/class/fazzo.php" );


add_action( 'init', array('fazzo\functions', 'store_current_menu_depth') );

/*
* Starte die Hauptklasse
*/
$fazzo_theme = fazzo::instance();

/*
* Wird true, wenn Posts vorhanden
*/
$fazzo_have_posts = false;


function test()
{
    $tmp = functions::get_all_registered_menus();
    var_dump($tmp);
}

//add_action('after_setup_theme', 'fazzo\test');