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
		 * Ein Prefix
		 * @since  1.0.0
		 * @access public
		 * @var string
		 */
		public $prefix = "";

		/**
		 * Customizer Capability
		 * @since  1.0.0
		 * @access public
		 * @var string
		 */
		public $capability = "edit_theme_options";

		/**
		 * Prioritäten Counter
		 * @since  1.0.0
		 * @access public
		 * @var int
		 */
		public $priority_panel = 665;

		/**
		 * Prioritäten Counter
		 * @since  1.0.0
		 * @access public
		 * @var int
		 */
		public $priority_section = 1;

		/**
		 * Customizer Theme Supports
		 * @since  1.0.0
		 * @access public
		 * @var string
		 */
		public $theme_supports = "";

		/**
		 * Ein Customizer Objekt
		 * @since  1.0.0
		 * @access public
		 * @var object
		 */
		public $wp_customize;

		/**
		 * Besser Übersetzung für Customizer Funktion
		 * @since  1.0.0
		 * @access public
		 * @var array
		 */
		public $transport = [ "reload" => "refresh", "instant" => "postMessage" ];

		/**
		 * PHP constructor.
		 * @since  1.0.0
		 * @access public
		 */
		public function __construct( $wp_customize ) {

			$this->wp_customize = $wp_customize;
			$this->prefix       = fazzo::$prefix;
		}

		public function add_panel( $id, $title, $description = "" ) {
			$id = $this->prefix . $id;
			$this->wp_customize->add_panel( $id, [
				'title'          => $title,
				'description'    => $description,
				'priority'       => $this->priority_panel,
				'capability'     => $this->capability,
				'theme_supports' => $this->theme_supports,
			] );
			$this->priority_panel ++;

			return $id;
		}

		public function add_section( $id, $to_id, $title, $description = "" ) {
			$id = $this->prefix . $id;
			$this->wp_customize->add_section( $id, [
				'title'          => $title,
				'description'    => $description,
				'panel'          => $to_id,
				'priority'       => $this->priority_section,
				'capability'     => $this->capability,
				'theme_supports' => $this->theme_supports,
			] );
			$this->priority_section ++;

			return $id;
		}

		public function add_control( $type, $id, $to_id, $title, $js = "", $array = [] ) {
			$id = $this->prefix . $id;

			switch ( $type ) {
				case "image":
					$this->wp_customize->add_setting( $id, [
						"default"   => fazzo::$customizer_elements[ $id ],
						"transport" => $this->transport["reload"],
					] );
					$this->wp_customize->add_setting( $id . "_size", [
						"default"   => fazzo::$customizer_elements[ $id . "_size" ],
						"transport" => $this->transport["instant"],
					] );
					$this->wp_customize->add_setting( $id . "_repeat", [
						"default"   => fazzo::$customizer_elements[ $id . "_repeat" ],
						"transport" => $this->transport["instant"],
					] );
					$this->wp_customize->add_setting( $id . "_scroll", [
						"default"   => fazzo::$customizer_elements[ $id . "_scroll" ],
						"transport" => $this->transport["instant"],
					] );
					$this->wp_customize->add_setting( $id . "_position_x", [
						"default"   => fazzo::$customizer_elements[ $id . "_position_x" ],
						"transport" => $this->transport["instant"],
					] );
					$this->wp_customize->add_setting( $id . "_position_y", [
						"default"   => fazzo::$customizer_elements[ $id . "_position_y" ],
						"transport" => $this->transport["instant"],
					] );
					break;
				default:
					$this->wp_customize->add_setting( $id, [
						"default"   => fazzo::$customizer_elements[ $id ],
						"transport" => $this->transport["instant"],
					] );
					break;
			}

			switch ( $type ) {
				case "text":
					$this->wp_customize->add_control( new \WP_Customize_Control( $this->wp_customize, $id,
						[
							'section'  => $to_id,
							'label'    => $title,
							'type'     => 'text',
							'settings' => $id,
						] ) );
					break;
				case "checkbox":
					$this->wp_customize->add_control( new \WP_Customize_Control( $this->wp_customize, $id,
						[
							'section'  => $to_id,
							'label'    => $title,
							'type'     => 'checkbox',
							'settings' => $id,
						] ) );
					break;
				case "select":
					$this->wp_customize->add_control( new \WP_Customize_Control( $this->wp_customize, $id,
						[
							'section'  => $to_id,
							'label'    => $title,
							'type'     => 'select',
							'settings' => $id,
							'choices'  => $array,
						] ) );
					break;
				case "image":
					$this->wp_customize->add_control( new \WP_Customize_Media_Control( $this->wp_customize, $id,
						[
							'section'   => $to_id,
							'label'     => $title,
							'mime_type' => 'image',
							'settings'  => $id,
						] ) );
					$this->wp_customize->add_control( new customizer_image_alignement( $this->wp_customize, $id . "_position",
						[
							'section'   => $to_id,
							'label'     => $title,
							'mime_type' => 'image',
							'settings'  => [ $id . "_position_x", $id . "_position_y" ],
						] ) );
					$this->wp_customize->add_control( new \WP_Customize_Control( $this->wp_customize, $id . "_size",
						[
							'section'  => $to_id,
							'label'    => __( 'Image Size', FAZZO_THEME_TXT ),
							'type'     => 'select',
							'settings' => $id . "_size",
							'choices'  => [
								'auto auto' => __( 'Original', FAZZO_THEME_TXT ),
								'cover'     => __( 'Screen Fits', FAZZO_THEME_TXT ),
								'contain'   => __( 'Full Screen', FAZZO_THEME_TXT ),
							],
						] ) );
					$this->wp_customize->add_control( new \WP_Customize_Control( $this->wp_customize, $id . "_repeat",
						[
							'section'  => $to_id,
							'label'    => __( 'Image Repeat', FAZZO_THEME_TXT ),
							'type'     => 'checkbox',
							'settings' => $id . "_repeat",
						] ) );
					$this->wp_customize->add_control( new \WP_Customize_Control( $this->wp_customize, $id . "_scroll",
						[
							'section'  => $to_id,
							'label'    => __( 'Image Scroll', FAZZO_THEME_TXT ),
							'type'     => 'checkbox',
							'settings' => $id . "_scroll",
						] ) );
					break;
				case "color":
					$this->wp_customize->add_control( new \WP_Customize_Color_Control( $this->wp_customize, $id,
						[
							'section'  => $to_id,
							'label'    => $title,
							'settings' => $id,
						] ) );
					break;
				default:
					// Do nothing
					break;
			}

			return $id;
		}


	}
}