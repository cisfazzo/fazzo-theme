<?php

namespace fazzo;

use Exception;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );

// ID(Name)/Titel/Description, Typ(Panel, Section), [Zugehörigkeit zu Panel]
// ID(Name)/Titel/Description, Typ(Select, Choice, Image, Text), Zugehörigkeit zu Section, Default_Value, CSS Element(e), Select_Array, Javascript
//          Rückgabewert: ID
// CSS Abhängigkeiten definieren() {}

// Create CSS
// Todo: die CSS Elemente, sinnvolle Sturktur zur sinnvollen Bearbeitung
// CSS:
//   Element(e): CSS Eigenschaft(en) (Mit Abhängigkeiten, Ausschließungen)
// z.B: body {background-image: linear-gradient(to bottom, rgba($rgb,$opacity) 50%, rgba($rgb2,$opacity) 100%);}
// $rgb2 von anderer Eingabe und opacity von anderer Eingabe
//  array(rgb_1 => this,
//



if ( ! class_exists( '\fazzo\customizer' ) ) {
	/**
	 * Funktionsklasse
	 * @since 1.0.0
	 */
	class customizer {

		/**
		 * PHP constructor.
		 * @since  1.0.0
		 * @access public
		 */
		public function __construct() {
		}

	}
}