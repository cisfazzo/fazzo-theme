<?php

namespace fazzo;

use Exception;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );


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

		/**
		 * Fügt ein Panel hinzu
		 *
		 * @param string $id Eindeutige ID
		 * @param string $title Titel
		 * @param string $description Beschreibung
		 *
		 * @return string
		 * @since  1.0.0
		 * @access public
		 */
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

		/**
		 * Fügt eine Sektion hinzu
		 *
		 * @param string $id Eindeutige ID
		 * @param string $to_id Übergeordnetes Panel
		 * @param string $title Titel
		 * @param string $description Beschreibung
		 *
		 * @return string
		 * @since  1.0.0
		 * @access public
		 */
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

		/**
		 * Fügt ein Kontroll Element hinzu
		 *
		 * @param string $type Typ (z.B. image, text)
		 * @param string $id Eindeutige ID
		 * @param string $to_id Übergeordnete Sektion
		 * @param string $title Titel
		 * @param null|string $transport Not for image, color, checkbox
		 * @param array $array Choices für Select Felder
		 *
		 * @return string
		 * @since  1.0.0
		 * @access public
		 */
		public function add_control( $type, $id, $to_id, $title, $transport = null, $array = [] ) {
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
				case "color":
					$this->wp_customize->add_setting( $id, [
						"default"   => fazzo::$customizer_elements[ $id ],
						"transport" => $this->transport["instant"],
					] );
					$this->wp_customize->add_setting( $id . "_transparent", [
						"default"   => fazzo::$customizer_elements[ $id . "_transparent" ],
						"transport" => $this->transport["instant"],
					] );
					break;
				case "checkbox":
					$this->wp_customize->add_setting( $id, [
						"default"   => fazzo::$customizer_elements[ $id ],
						"transport" => $this->transport["reload"],
					] );
					break;
				default:

					if(is_null($transport))
						$transport = $this->transport["instant"];

					$this->wp_customize->add_setting( $id, [
						"default"   => fazzo::$customizer_elements[ $id ],
						"transport" => $transport,
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
							'settings'  => $id,
						] ) );

					$this->wp_customize->add_control( new \WP_Customize_Control( $this->wp_customize, $id . "_position_x",
						[
							'section'  => $to_id,
							'label'    => "position_x",
							'type'     => 'text',
							'settings' => $id . "_position_x",
						] ) );
					$this->wp_customize->add_control( new \WP_Customize_Control( $this->wp_customize, $id . "_position_y",
						[
							'section'  => $to_id,
							'label'    => "position_y",
							'type'     => 'text',
							'settings' => $id . "_position_y",
						] ) );


					new customizer_script( $id );

					$this->wp_customize->add_control( new \WP_Customize_Control( $this->wp_customize, $id . "_size",
						[
							'section'  => $to_id,
							'label'    => __( 'Image Size', "fazzotheme" ),
							'type'     => 'select',
							'settings' => $id . "_size",
							'choices'  => [
								'auto auto' => __( 'Original', "fazzotheme" ),
								'cover'     => __( 'Screen Fits', "fazzotheme" ),
								'contain'   => __( 'Full Screen', "fazzotheme" ),
							],
						] ) );
					$this->wp_customize->add_control( new \WP_Customize_Control( $this->wp_customize, $id . "_repeat",
						[
							'section'  => $to_id,
							'label'    => __( 'Image Repeat', "fazzotheme" ),
							'type'     => 'checkbox',
							'settings' => $id . "_repeat",
						] ) );
					$this->wp_customize->add_control( new \WP_Customize_Control( $this->wp_customize, $id . "_scroll",
						[
							'section'  => $to_id,
							'label'    => __( 'Image Scroll', "fazzotheme" ),
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
					$this->wp_customize->add_control( new \WP_Customize_Control( $this->wp_customize, $id . "_transparent",
						[
							'section'  => $to_id,
							'label'    => $title . " " . __( "Transparent", "fazzotheme" ),
							'type'     => 'checkbox',
							'settings' => $id . "_transparent",
						] ) );
					break;
				default:
					// Do nothing
					break;
			}

			return $id;
		}


		/**
		 * Get Theme Mod
		 *
		 * @param string $id Das Element
		 *
		 * @return mixed
		 * @since  1.0.0
		 * @access public
		 */
		public static function get_mod( $id ) {

			if ( ! isset( fazzo::$customizer_elements[ fazzo::$prefix . $id ] ) ) {
				return false;
			}

			return get_theme_mod( fazzo::$prefix . $id, fazzo::$customizer_elements[ fazzo::$prefix . $id ] );
		}

		/**
		 * CSS Generierung für Schriftfarbe
		 *
		 * @param string $element Das Element
		 * @param string $property Die CSS Property
		 * @param string $css Das CSS Element
		 * @param string $css_suffix Suffic für CSS Element
		 *
		 * @return mixed
		 * @since  1.0.0
		 * @access public
		 */
		public static function live_css_font( $element, $property, $css, $css_suffix = "" ) {
			$style = "";
			if ( isset( fazzo::$customizer_elements[ fazzo::$prefix . $element . "_color" ] ) ) {
				$font_color             = false;
				$font_color_transparent = static::get_mod( $element . "_color_transparent" );
				if ( $font_color_transparent ) {
					$font_color = "transparent";
				} else {
					$font_color = static::get_mod( $element . "_color" );

				}
				if ( $font_color !== false ) {

					if ( is_array( $css ) ) {
						foreach ( $css as $css_el ) {
							$style .= <<<CSS

{$css_el} {$css_suffix}{
	{$property}: {$font_color};
}
CSS;

						}
					} else {

						$style .= <<<CSS

{$css} {$css_suffix}{
	{$property}: {$font_color};
}
CSS;
					}
				}
			}

			return $style;
		}


		/**
		 * CSS Generierung für Randfarbe (Komplex)
		 *
		 * @param string $element Das Element
		 * @param string $property Die CSS Property
		 * @param string $css Das CSS Element
		 * @param string $element_opacity Das Element, welches die Opacity beinhaltet
		 * @param string $css_suffix Suffic für CSS Element
		 *
		 * @return mixed
		 * @since  1.0.0
		 * @access public
		 */
		public static function live_css_border( $element, $property, $css, $element_opacity = false, $css_suffix = "" ) {
			$style = "";
			if ( isset( fazzo::$customizer_elements[ fazzo::$prefix . $element . "_color" ] ) ) {

				$font_color_transparent = static::get_mod( $element . "_color_transparent" );
				if ( $font_color_transparent ) {
					$font_color = "transparent";
				} else {

					$font_color = static::get_mod( $element . "_color" );

					if ( ! empty( $element_opacity ) ) {
						$opacity = static::get_mod( $element_opacity . "_opacity" );
						if ( ! empty( $opacity ) ) {
							$font_color = "rgba(" . functions::get_rgb_from_hex( $font_color ) . "," . $opacity . ")";
						}
					}


				}
				if ( $font_color !== false ) {

					if ( is_array( $css ) ) {
						foreach ( $css as $css_el ) {
							$style .= <<<CSS

{$css_el} {$css_suffix}{
	{$property}: {$font_color};
}
CSS;

						}
					} else {

						$style .= <<<CSS

{$css} {$css_suffix}{
	{$property}: {$font_color};
}
CSS;
					}
				}
			}

			return $style;
		}

		/**
		 * CSS Generierung für Randfarbe (Einfach)
		 *
		 * @param string $element Das Element
		 * @param string $element_opacity Das Element, welches die Opacity beinhaltet
		 *
		 * @return mixed
		 * @since  1.0.0
		 * @access public
		 */
		public static function live_border_color( $element, $element_opacity = false ) {
			$_nav_top_border_color = "transparent";
			$transparent           = false;
			if ( isset( fazzo::$customizer_elements[ fazzo::$prefix . $element . "_transparent" ] ) ) {
				$transparent = static::get_mod( $element . "_transparent" );
			}

			if ( empty( $transparent ) && isset( fazzo::$customizer_elements[ fazzo::$prefix . $element ] ) ) {

				$border_color = static::get_mod( $element );
				if ( $border_color !== false ) {

					if ( ! empty( $element_opacity ) ) {
						$opacity               = static::get_mod( $element_opacity . "_opacity" );
						$_nav_top_border_color = "rgba(" . functions::get_rgb_from_hex( $border_color ) . "," . $opacity . ")";
					} else {
						$_nav_top_border_color = $border_color;
					}
				}
			}

			return $_nav_top_border_color;
		}

		/**
		 * CSS Generierung für min. Höhe
		 *
		 * @param string $element Das Element
		 *
		 * @return mixed
		 * @since  1.0.0
		 * @access public
		 */
		public static function live_css_height( $element, $css ) {

			$height = static::get_mod( $element );
			$style = "";
			$style .= <<<CSS
{$css}  {
	min-height: {$height};
}
CSS;
			return $style;
		}

		/**
		 * CSS Generierung für Padding Vertical
		 *
		 * @param string $element Das Element
		 *
		 * @return mixed
		 * @since  1.0.0
		 * @access public
		 */
		public static function live_css_padding_v( $element, $css ) {

			$padding = static::get_mod( $element );
			$style = "";
			$style .= <<<CSS
{$css}  {
	padding-top: {$padding};
	padding-bottom: {$padding};
}
CSS;
			return $style;
		}

		/**
		 * CSS Generierung für Text Größe
		 *
		 * @param string $element Das Element
		 *
		 * @return mixed
		 * @since  1.0.0
		 * @access public
		 */
		public static function live_css_font_size( $element, $css ) {

			$font_size = static::get_mod( $element );
			$style = "";
			$style .= <<<CSS
{$css} {
	font-size: {$font_size};
}
CSS;
			return $style;
		}

		/**
		 * CSS Generierung für Text Größe ohne Überschriften
		 *
		 * @param string $element Das Element
		 *
		 * @return mixed
		 * @since  1.0.0
		 * @access public
		 */
		public static function live_css_font_size_text( $element, $css ) {

			$font_size = static::get_mod( $element );
			$style = "";
			$style .= <<<CSS
{$css} p {
	font-size: {$font_size};
}
{$css} a {
	font-size: {$font_size};
}
{$css} span {
	font-size: {$font_size};
}
{$css} input {
	font-size: {$font_size};
}
{$css} label {
	font-size: {$font_size};
}
{$css} i {
	font-size: {$font_size};
}
CSS;
			return $style;
		}


		/**
		 * CSS Generierung für Padding Horizontal
		 *
		 * @param string $element Das Element
		 *
		 * @return mixed
		 * @since  1.0.0
		 * @access public
		 */
		public static function live_css_padding_h( $element, $css ) {

			$padding = static::get_mod( $element );
			$style = "";
			$style .= <<<CSS
{$css}  {
	padding-left: {$padding};
	padding-right: {$padding};
}
CSS;
			return $style;
		}


		/**
		 * CSS Generierung für Hintergrundfarbe
		 *
		 * @param string $element Das Element
		 * @param string $css_suffix Suffic für CSS Element
		 * @param string $css Das CSS Element
		 * @param boolean|string $breakpoint CSS Media Query Breakpoint max-width
		 *
		 * @return mixed
		 * @since  1.0.0
		 * @access public
		 */
		public static function live_css_background( $element, $css, $css_suffix = "", $breakpoint = false ) {
			$style     = "";
			$image_src = [ 0 => false ];
			$css_pre   = "";
			$css_suf   = "";
			if ( ! empty( $breakpoint ) ) {
				$css_pre = "@media screen and (max-width: " . $breakpoint . ") {";
				$css_suf = "}";
			}
			if ( isset( fazzo::$customizer_elements[ fazzo::$prefix . $element . "_image" ] ) ) {
				$image_src = \wp_get_attachment_image_src( static::get_mod( $element . "_image" ), "full" );
			}
			if ( $image_src[0] ) {
				$image      = $image_src[0];
				$size       = static::get_mod( $element . "_image_size" );
				$repeat     = static::get_mod( $element . "_image_repeat" );
				$scroll     = static::get_mod( $element . "_image_scroll" );
				$position_x = static::get_mod( $element . "_image_position_x" );
				$position_y = static::get_mod( $element . "_image_position_y" );

				if ( ( $size || $repeat || $scroll || $position_x || $position_y ) === false ) {
					return "";
				}

				if ( $repeat ) {
					$repeat = "repeat";
				} else {
					$repeat = "no-repeat";
				}
				if ( $scroll ) {
					$scroll = "scroll";
				} else {
					$scroll = "fixed";
				}


				if ( is_array( $css ) ) {
					foreach ( $css as $css_el ) {
						$style .= <<<CSS
{$css_pre}
{$css_el} {$css_suffix} {
	background-image: url('{$image}');
	background-position: {$position_x} {$position_y};
	background-size: {$size};
	background-repeat: {$repeat};
	background-attachment : {$scroll};
}
{$css_suf}
CSS;
					}
				} else {
					$style .= <<<CSS
{$css_pre}
{$css} {$css_suffix} {
	background-image: url('{$image}');
	background-position: {$position_x} {$position_y};
	background-size: {$size};
	background-repeat: {$repeat};
	background-attachment : {$scroll};
}
{$css_suf}
CSS;
				}
			} elseif ( isset( fazzo::$customizer_elements[ fazzo::$prefix . $element . "_color_top" ] ) ) {
				$opacity                  = static::get_mod( $element . "_opacity" );
				$color_top                = static::get_mod( $element . "_color_top" );
				$color_top_transparent    = static::get_mod( $element . "_color_top_transparent" );
				$color_bottom             = static::get_mod( $element . "_color_bottom" );
				$color_bottom_transparent = static::get_mod( $element . "_color_bottom_transparent" );

				if ( ( $opacity || $color_top || $color_bottom ) === false ) {
					return "";
				}

				if ( $color_top_transparent === true ) {
					$rgba_top = "transparent";
				} else {

					$rgba_top = "rgba(" . functions::get_rgb_from_hex( $color_top ) . "," . $opacity . ")";
				}

				if ( $color_bottom_transparent === true ) {
					$rgba_bottom = "transparent";
				} else {
					$rgba_bottom = "rgba(" . functions::get_rgb_from_hex( $color_bottom ) . "," . $opacity . ")";
				}

				if ( is_array( $css ) ) {
					foreach ( $css as $css_el ) {
						$style .= <<<CSS
{$css_pre}
{$css_el} {$css_suffix} {
	background-image: linear-gradient(to bottom, {$rgba_top} 50%, {$rgba_bottom} 100%);
	background-repeat: no-repeat;
}
{$css_suf}
CSS;
					}
				} else {
					$style .= <<<CSS
{$css_pre}
{$css} {$css_suffix} {
	background-image: linear-gradient(to bottom, {$rgba_top} 50%, {$rgba_bottom} 100%);
	background-repeat: no-repeat;
}
{$css_suf}
CSS;
				}

			}

			return $style;
		}
	}


}

