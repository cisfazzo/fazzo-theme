<?php

namespace fazzo;

use Exception;

$dir_root = dirname( __FILE__ ) . "/../";
require_once( $dir_root . "security.php" );

require_once( $dir_root . "class/extra/functions.php" );
require_once( $dir_root . "class/extra/customizer.php" );
require_once( $dir_root . "class/extra/customizer_image_alignement.php" );
require_once( $dir_root . "class/extra/customizer_script.php" );
require_once( $dir_root . "class/extra/nav_paged.php" );
require_once( $dir_root . "class/extra/nav_walker.php" );


// Aktionen, wenn das Plugin aktiviert, bzw. deaktiviert wird:
register_activation_hook( __FILE__, [ 'fazzo', 'activation' ] );
register_deactivation_hook( __FILE__, [ 'fazzo', 'deactivation' ] );

if ( ! class_exists( '\fazzo\fazzo' ) ) {

	/*
	 * FAZZO-Theme-Haupt-Klasse
	 */

	class fazzo {

		/**
		 * Name der Variable unter der die Einstellungen des Plugins oder Posts/Pages gespeichert werden.
		 * @since  1.0.0
		 * @access public
		 * @var string
		 */
		const option_name = 'fazzo';

		/**
		 * Name der Variable zum Zwecke der Aktualisierung des Plugins.
		 * @since  1.0.0
		 * @access public
		 * @var string
		 */
		const version_option_name = 'fazzo_version';

		/**
		 * Version des Plugins
		 * @since  1.0.0
		 * @access public
		 * @var string
		 */
		const version = '1.1.2';

		/**
		 * Minimal erforderliche PHP-Version.
		 * @since  1.0.0
		 * @access public
		 * @var string
		 */
		const php_version = '7.2';

		/**
		 * Minimal erforderliche WordPress-Version.
		 * @since  1.0.0
		 * @access public
		 * @var string
		 */
		const wp_version = '5.3.2';

		/**
		 * Optionen des Plugins
		 * @since  1.0.0
		 * @access public
		 * @var array
		 */
		public static $options;

		/**
		 * Ein Prefix
		 * @since  1.0.0
		 * @access public
		 * @var array
		 */
		public static $prefix = "fazzo_";

		/**
		 * Bezieht sich auf eine einzige Instanz dieser Klasse.
		 * @since  1.0.0
		 * @access protected
		 * @var object
		 */
		protected static $instance = null;


		/**
		 * Erstellt und gibt eine Instanz der Klasse zurück.
		 * @return object
		 * @since  1.0.0
		 * @access public
		 * @static
		 */
		public static function instance() {
			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		/**
		 * Customizer CSS Elemente
		 * @since  1.0.0
		 * @access public
		 * @var array
		 * @static
		 */
		public static $customizer_elements = [];

		/**
		 * PHP constructor.
		 * @since  1.0.0
		 * @access public
		 */
		private function __construct() {

			// Customizer Default Values
			$prefix                      = static::$prefix;
			static::$customizer_elements = [

				$prefix . "background_body_image"            => "",
				$prefix . "background_body_image_position_x" => "center",
				$prefix . "background_body_image_position_y" => "center",
				$prefix . "background_body_image_size"       => "auto auto",
				$prefix . "background_body_image_repeat"     => 1,
				$prefix . "background_body_image_scroll"     => 1,

				$prefix . "background_color_top"                => "#ffffff",
				$prefix . "background_color_bottom"             => "#c4c4c4",
				$prefix . "background_color_top_transparent"    => 0,
				$prefix . "background_color_bottom_transparent" => 0,
				$prefix . "background_opacity"                  => "1",
				$prefix . "background_image"                    => "",
				$prefix . "background_image_position_x"         => "center",
				$prefix . "background_image_position_y"         => "center",
				$prefix . "background_image_size"               => "auto auto",
				$prefix . "background_image_repeat"             => 1,
				$prefix . "background_image_scroll"             => 1,

				$prefix . "background_head_color_top"                => "#f2f2f2",
				$prefix . "background_head_color_bottom"             => "#ffffff",
				$prefix . "background_head_color_top_transparent"    => 0,
				$prefix . "background_head_color_bottom_transparent" => 0,
				$prefix . "background_head_opacity"                  => "0.9",
				$prefix . "background_head_image"                    => "",
				$prefix . "background_head_image_position_x"         => "center",
				$prefix . "background_head_image_position_y"         => "center",
				$prefix . "background_head_image_size"               => "auto auto",
				$prefix . "background_head_image_repeat"             => 1,
				$prefix . "background_head_image_scroll"             => 1,

				$prefix . "background_nav_top_color_top"                => "#e5e5e5",
				$prefix . "background_nav_top_color_bottom"             => "#6592bf",
				$prefix . "background_nav_top_color_top_transparent"    => 0,
				$prefix . "background_nav_top_color_bottom_transparent" => 1,
				$prefix . "background_nav_top_opacity"                  => "0.2",
				$prefix . "background_nav_top_image"                    => "",
				$prefix . "background_nav_top_image_position_x"         => "center",
				$prefix . "background_nav_top_image_position_y"         => "center",
				$prefix . "background_nav_top_image_size"               => "auto auto",
				$prefix . "background_nav_top_image_repeat"             => 1,
				$prefix . "background_nav_top_image_scroll"             => 1,
				$prefix . "link_font_nav_top_color"                     => "#000000",
				$prefix . "link_hover_font_nav_top_color"               => "#1349dd",
				$prefix . "link_font_nav_top_color_transparent"         => 0,
				$prefix . "link_hover_font_nav_top_color_transparent"   => 0,
				$prefix . "border_nav_top_color"                        => "#636363",
				$prefix . "border_nav_top_color_transparent"            => 0,

				$prefix . "background_nav_top_hover_color_top"                => "#2677bf",
				$prefix . "background_nav_top_hover_color_bottom"             => "#6592bf",
				$prefix . "background_nav_top_hover_color_top_transparent"    => 0,
				$prefix . "background_nav_top_hover_color_bottom_transparent" => 0,
				$prefix . "background_nav_top_hover_opacity"                  => "0.1",
				$prefix . "background_nav_top_hover_image"                    => "",
				$prefix . "background_nav_top_hover_image_position_x"         => "center",
				$prefix . "background_nav_top_hover_image_position_y"         => "center",
				$prefix . "background_nav_top_hover_image_size"               => "auto auto",
				$prefix . "background_nav_top_hover_image_repeat"             => 1,
				$prefix . "background_nav_top_hover_image_scroll"             => 1,
				$prefix . "border_nav_top_hover_color"                        => "#8e8e8e",
				$prefix . "border_nav_top_hover_color_transparent"            => 0,

				$prefix . "link_font_content_head_color"                   => "#159af2",
				$prefix . "link_font_content_head_color_transparent"       => 0,
				$prefix . "link_hover_font_content_head_color"             => "#00a3f4",
				$prefix . "link_hover_font_content_head_color_transparent" => 0,

				$prefix . "font_content_head_description_color"               => "#a0a0a0",
				$prefix . "font_content_head_description_color_transparent"   => 0,
				$prefix . "border_content_head_description_color"             => "#bfbfbf",
				$prefix . "border_content_head_description_color_transparent" => 0,

				$prefix . "background_nav_head_color_top"                => "#e5e5e5",
				$prefix . "background_nav_head_color_bottom"             => "#000000",
				$prefix . "background_nav_head_color_top_transparent"    => 0,
				$prefix . "background_nav_head_color_bottom_transparent" => 1,
				$prefix . "background_nav_head_opacity"                  => "0.2",
				$prefix . "background_nav_head_image"                    => "",
				$prefix . "background_nav_head_image_position_x"         => "center",
				$prefix . "background_nav_head_image_position_y"         => "center",
				$prefix . "background_nav_head_image_size"               => "auto auto",
				$prefix . "background_nav_head_image_repeat"             => 1,
				$prefix . "background_nav_head_image_scroll"             => 1,
				$prefix . "link_font_nav_head_color"                     => "#000000",
				$prefix . "link_hover_font_nav_head_color"               => "#1349dd",
				$prefix . "link_font_nav_head_color_transparent"         => 0,
				$prefix . "link_hover_font_nav_head_color_transparent"   => 0,
				$prefix . "border_nav_head_color"                        => "#636363",
				$prefix . "border_nav_head_color_transparent"            => 0,

				$prefix . "background_nav_head_hover_color_top"                => "#2677bf",
				$prefix . "background_nav_head_hover_color_bottom"             => "#6592bf",
				$prefix . "background_nav_head_hover_color_top_transparent"    => 0,
				$prefix . "background_nav_head_hover_color_bottom_transparent" => 0,
				$prefix . "background_nav_head_hover_opacity"                  => "0.1",
				$prefix . "background_nav_head_hover_image"                    => "",
				$prefix . "background_nav_head_hover_image_position_x"         => "center",
				$prefix . "background_nav_head_hover_image_position_y"         => "center",
				$prefix . "background_nav_head_hover_image_size"               => "auto auto",
				$prefix . "background_nav_head_hover_image_repeat"             => 1,
				$prefix . "background_nav_head_hover_image_scroll"             => 1,
				$prefix . "border_nav_head_hover_color"                        => "#8e8e8e",
				$prefix . "border_nav_head_hover_color_transparent"            => 0,

				$prefix . "background_nav_head_dropdown_color_top"                => "#eaeaea",
				$prefix . "background_nav_head_dropdown_color_bottom"             => "#c9c9c9",
				$prefix . "background_nav_head_dropdown_color_top_transparent"    => 0,
				$prefix . "background_nav_head_dropdown_color_bottom_transparent" => 0,
				$prefix . "background_nav_head_dropdown_opacity"                  => "0.95",
				$prefix . "background_nav_head_dropdown_image"                    => "",
				$prefix . "background_nav_head_dropdown_image_position_x"         => "center",
				$prefix . "background_nav_head_dropdown_image_position_y"         => "center",
				$prefix . "background_nav_head_dropdown_image_size"               => "auto auto",
				$prefix . "background_nav_head_dropdown_image_repeat"             => 1,
				$prefix . "background_nav_head_dropdown_image_scroll"             => 1,
				$prefix . "link_font_nav_head_dropdown_color"                     => "#000000",
				$prefix . "link_hover_font_nav_head_dropdown_color"               => "#1349dd",
				$prefix . "link_font_nav_head_dropdown_color_transparent"         => 0,
				$prefix . "link_hover_font_nav_head_dropdown_color_transparent"   => 0,
				$prefix . "border_nav_head_dropdown_color"                        => "#636363",
				$prefix . "border_nav_head_dropdown_color_transparent"            => 0,

				$prefix . "background_nav_head_dropdown_hover_color_top"                => "#757575",
				$prefix . "background_nav_head_dropdown_hover_color_bottom"             => "#000000",
				$prefix . "background_nav_head_dropdown_hover_color_top_transparent"    => 0,
				$prefix . "background_nav_head_dropdown_hover_color_bottom_transparent" => 0,
				$prefix . "background_nav_head_dropdown_hover_opacity"                  => "0.8",
				$prefix . "background_nav_head_dropdown_hover_image"                    => "",
				$prefix . "background_nav_head_dropdown_hover_image_position_x"         => "center",
				$prefix . "background_nav_head_dropdown_hover_image_position_y"         => "center",
				$prefix . "background_nav_head_dropdown_hover_image_size"               => "auto auto",
				$prefix . "background_nav_head_dropdown_hover_image_repeat"             => 1,
				$prefix . "background_nav_head_dropdown_hover_image_scroll"             => 1,
				$prefix . "border_nav_head_dropdown_hover_color"                        => "#8e8e8e",
				$prefix . "border_nav_head_dropdown_hover_color_transparent"            => 0,

				$prefix . "background_nav_content_color_top"                => "#eaeaea",
				$prefix . "background_nav_content_color_bottom"             => "#c9c9c9",
				$prefix . "background_nav_content_color_top_transparent"    => 1,
				$prefix . "background_nav_content_color_bottom_transparent" => 1,
				$prefix . "background_nav_content_opacity"                  => "0.1",
				$prefix . "background_nav_content_image"                    => "",
				$prefix . "background_nav_content_image_position_x"         => "center",
				$prefix . "background_nav_content_image_position_y"         => "center",
				$prefix . "background_nav_content_image_size"               => "auto auto",
				$prefix . "background_nav_content_image_repeat"             => 1,
				$prefix . "background_nav_content_image_scroll"             => 1,
				$prefix . "link_font_nav_content_color"                     => "#000000",
				$prefix . "link_hover_font_nav_content_color"               => "#00a3f4",
				$prefix . "link_font_nav_content_color_transparent"         => 0,
				$prefix . "link_hover_font_nav_content_color_transparent"   => 0,
				$prefix . "border_nav_content_color"                        => "#000000",
				$prefix . "border_nav_content_color_transparent"            => 0,
				$prefix . "background_nav_content_dropdown_opacity"         => "1",

				$prefix . "background_nav_content_hover_color_top"                => "#2677bf",
				$prefix . "background_nav_content_hover_color_bottom"             => "#6592bf",
				$prefix . "background_nav_content_hover_color_top_transparent"    => 0,
				$prefix . "background_nav_content_hover_color_bottom_transparent" => 0,
				$prefix . "background_nav_content_hover_opacity"                  => "0.1",
				$prefix . "background_nav_content_hover_image"                    => "",
				$prefix . "background_nav_content_hover_image_position_x"         => "center",
				$prefix . "background_nav_content_hover_image_position_y"         => "center",
				$prefix . "background_nav_content_hover_image_size"               => "auto auto",
				$prefix . "background_nav_content_hover_image_repeat"             => 1,
				$prefix . "background_nav_content_hover_image_scroll"             => 1,
				$prefix . "border_nav_content_hover_color"                        => "#8e8e8e",
				$prefix . "border_nav_content_hover_color_transparent"            => 0,
				$prefix . "background_nav_content_hover_dropdown_opacity"         => "1",

				$prefix . "background_content_color_top"                => "#757575",
				$prefix . "background_content_color_bottom"             => "#000000",
				$prefix . "background_content_color_top_transparent"    => 1,
				$prefix . "background_content_color_bottom_transparent" => 1,
				$prefix . "background_content_opacity"                  => "0",
				$prefix . "background_content_image"                    => "",
				$prefix . "background_content_image_position_x"         => "center",
				$prefix . "background_content_image_position_y"         => "center",
				$prefix . "background_content_image_size"               => "auto auto",
				$prefix . "background_content_image_repeat"             => 1,
				$prefix . "background_content_image_scroll"             => 1,
				$prefix . "font_content_color"                          => "#000000",
				$prefix . "font_content_color_transparent"              => 0,
				$prefix . "link_font_content_color"                     => "#1349dd",
				$prefix . "link_hover_font_content_color"               => "#00a344",
				$prefix . "link_font_content_color_transparent"         => 0,
				$prefix . "link_hover_font_content_color_transparent"   => 0,
				$prefix . "border_content_color"                        => "#adadad",
				$prefix . "border_content_color_transparent"            => 0,

				$prefix . "background_widget_color_top"                => "#a3a3a3",
				$prefix . "background_widget_color_bottom"             => "#0a0a0a",
				$prefix . "background_widget_color_top_transparent"    => 1,
				$prefix . "background_widget_color_bottom_transparent" => 1,
				$prefix . "background_widget_opacity"                  => "0",
				$prefix . "background_widget_image"                    => "",
				$prefix . "background_widget_image_position_x"         => "center",
				$prefix . "background_widget_image_position_y"         => "center",
				$prefix . "background_widget_image_size"               => "auto auto",
				$prefix . "background_widget_image_repeat"             => 1,
				$prefix . "background_widget_image_scroll"             => 1,
				$prefix . "font_widget_color"                          => "#1d9176",
				$prefix . "font_widget_color_transparent"              => 0,
				$prefix . "link_font_widget_color"                     => "#1349dd",
				$prefix . "link_hover_font_widget_color"               => "#00a344",
				$prefix . "link_font_widget_color_transparent"         => 0,
				$prefix . "link_hover_font_widget_color_transparent"   => 0,
				$prefix . "border_widget_color"                        => "#e8e8e8",
				$prefix . "border_widget_color_transparent"            => 0,

				$prefix . "background_nav_footer_color_top"                => "#e5e5e5",
				$prefix . "background_nav_footer_color_bottom"             => "#0a0a0a",
				$prefix . "background_nav_footer_color_top_transparent"    => 0,
				$prefix . "background_nav_footer_color_bottom_transparent" => 1,
				$prefix . "background_nav_footer_opacity"                  => "0.2",
				$prefix . "background_nav_footer_image"                    => "",
				$prefix . "background_nav_footer_image_position_x"         => "center",
				$prefix . "background_nav_footer_image_position_y"         => "center",
				$prefix . "background_nav_footer_image_size"               => "auto auto",
				$prefix . "background_nav_footer_image_repeat"             => 1,
				$prefix . "background_nav_footer_image_scroll"             => 1,
				$prefix . "link_font_nav_footer_color"                     => "#000000",
				$prefix . "link_hover_font_nav_footer_color"               => "#1349dd",
				$prefix . "link_font_nav_footer_color_transparent"         => 0,
				$prefix . "link_hover_font_nav_footer_color_transparent"   => 0,
				$prefix . "border_nav_footer_color"                        => "#636363",
				$prefix . "border_nav_footer_color_transparent"            => 0,

				$prefix . "background_nav_footer_hover_color_top"                => "#2677bf",
				$prefix . "background_nav_footer_hover_color_bottom"             => "#6592bf",
				$prefix . "background_nav_footer_hover_color_top_transparent"    => 0,
				$prefix . "background_nav_footer_hover_color_bottom_transparent" => 0,
				$prefix . "background_nav_footer_hover_opacity"                  => "0.1",
				$prefix . "background_nav_footer_hover_image"                    => "",
				$prefix . "background_nav_footer_hover_image_position_x"         => "center",
				$prefix . "background_nav_footer_hover_image_position_y"         => "center",
				$prefix . "background_nav_footer_hover_image_size"               => "auto auto",
				$prefix . "background_nav_footer_hover_image_repeat"             => 1,
				$prefix . "background_nav_footer_hover_image_scroll"             => 1,
				$prefix . "border_nav_footer_hover_color"                        => "#000000",
				$prefix . "border_nav_footer_hover_color_transparent"            => 0,

				$prefix . "background_foot_text_color_top"                => "#666666",
				$prefix . "background_foot_text_color_bottom"             => "#000000",
				$prefix . "background_foot_text_color_top_transparent"    => 1,
				$prefix . "background_foot_text_color_bottom_transparent" => 1,
				$prefix . "background_foot_text_opacity"                  => "0.2",
				$prefix . "background_foot_text_image"                    => "",
				$prefix . "background_foot_text_image_position_x"         => "center",
				$prefix . "background_foot_text_image_position_y"         => "center",
				$prefix . "background_foot_text_image_size"               => "auto auto",
				$prefix . "background_foot_text_image_repeat"             => 1,
				$prefix . "background_foot_text_image_scroll"             => 1,
				$prefix . "font_foot_text_color"                          => "#000000",
				$prefix . "font_foot_text_color_transparent"              => 0,
				$prefix . "border_foot_text_color"                        => "#636363",
				$prefix . "border_foot_text_color_transparent"            => 0,
				$prefix . "foot_text_year"                                => "1975",

				$prefix . "head_height"    => "200px",
				$prefix . "content_height" => "400px",
				$prefix . "footer_height"  => "300px",

				$prefix . "top_padding_h"         => "6px",
				$prefix . "top_padding_v"         => "2px",
				$prefix . "main_nav_padding_h"    => "12px",
				$prefix . "main_nav_padding_v"    => "8px",
				$prefix . "footer_nav_padding_h"  => "6px",
				$prefix . "footer_nav_padding_v"  => "2px",
				$prefix . "footer_text_padding_v" => "0",

				$prefix . "top_font_size"                 => "0.8rem",
				$prefix . "head_content_header_font_size" => "3.5rem",
				$prefix . "head_content_font_size"        => "1rem",
				$prefix . "main_nav_font_size"            => "1rem",
				$prefix . "content_nav_font_size"         => "1rem",
				$prefix . "content_font_size"             => "1rem",
				$prefix . "content_h1_font_size"          => "2rem",
				$prefix . "content_h2_font_size"          => "1.75rem",
				$prefix . "content_h3_font_size"          => "1.5rem",
				$prefix . "foot_nav_font_size"            => "0.8rem",
				$prefix . "widget_font_size"              => "1rem",
				$prefix . "widget_header_font_size"       => "2rem",
				$prefix . "footer_text_font_size"         => "0.8rem",

				$prefix . "show_search"             => 1,
				$prefix . "add_space"               => 1,
				$prefix . "round_corners"           => 0,
				$prefix . "border_radius"           => "8px",
				$prefix . "center_content"          => 1,
				$prefix . "show_post_nav"           => 0,
				$prefix . "show_page_nav"           => 0,
				$prefix . "show_post_date"          => 1,
				$prefix . "show_author_link"        => 1,
				$prefix . "show_page_date"          => 1,
				$prefix . "show_categories"         => 1,
				$prefix . "show_edit_link"          => 0,
				$prefix . "disable_comments"        => 0,
				$prefix . "display_shadows"         => 0,
				$prefix . "display_article_shadows" => 0,
				$prefix . "display_widget_shadows"  => 0,
				$prefix . "display_content_nav_shadows"  => 0,

			];

			/* For debugging, reset default values for customizer:

			\remove_theme_mods();

			foreach ( static::$customizer_elements as $mod => $value ) {
				\set_theme_mod( $mod, $value );
			}
*/

			// Sprachdateien werden eingebunden:
			self::load_textdomain();

			// Erhalte die Einstellungen zum Plugin:
			self::get_options();

			// Aktualisierung des Plugins (ggf):
			self::update_plugin();

			// Customizer
			add_action( 'customize_preview_init', [ $this, 'customizer_preview_enqueue' ] );
			add_action( 'customize_controls_enqueue_scripts', [ $this, 'customizer_controls_enqueue' ] );
			add_action( 'customize_register', [ $this, 'customizer_register' ] );
			add_action( 'wp_head', [ $this, 'customizer_css' ] );

			// Enable Builtin Options
			add_theme_support( "post-thumbnails" );
			add_theme_support( "custom-header" );
			add_theme_support( 'title-tag' );
			add_theme_support( 'html5', [
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			] );
			add_theme_support( 'post-formats', [
				'image',
				'video',
				'gallery',
				'audio',
			] );
			add_theme_support( 'customize-selective-refresh-widgets' );
			add_theme_support( 'automatic-feed-links' );

			// Menüs des Themes
			add_action( "after_setup_theme", [ $this, "register_menus" ] );

			// Sidebars aktivieren
			add_action( 'widgets_init', [ $this, 'register_sidebars' ] );

			// Scripte einbinden
			add_action( "admin_enqueue_scripts", [ $this, "load_admin_scripts" ] );
			add_action( "wp_enqueue_scripts", [ $this, "load_frontend_scripts" ] );

			// Nav Link CSS Manipulation
			add_filter( 'next_posts_link_attributes', [ $this, 'nav_link_attributes' ] );
			add_filter( 'previous_posts_link_attributes', [ $this, "nav_link_attributes" ] );

			// Excerpt Manipulation
			add_filter( 'excerpt_length', [ $this, 'new_excerpt_length' ] );
			add_filter( 'excerpt_more', [ $this, 'new_excerpt_more' ] );

			// additional image sizes
			add_image_size( 'fazzo-featured-image', 9999, 330 );
			add_image_size( 'fazzo-nav-image', 9999, 20 );

			// Custom Widgets
			add_action( 'widgets_init', [ $this, 'register_widgets' ] );

			// Zeige diese Optionsseite nur an, wenn der User die Rechte dazu hat:
			if ( current_user_can( 'manage_options' ) ) {
				// Zeige Optionsseite an
				add_action( 'admin_menu', [ $this, 'settings_page' ] );
			}

			// Metaboxen
			add_action( "add_meta_boxes", [ $this, "register_meta_boxes" ] );

			// Funktionen beim Speichern
			add_action( 'save_post', [ $this, 'save_post' ] );

			// Editor Style Location
			add_action( 'admin_init', [ $this, 'add_editor_style' ] );
		}

		/**
		 * Aktionen bei Plugin Aktivierung
		 *
		 * @param $network_wide boolean Teilt mit, ob Netzwerkweit aktiviert werden soll
		 *
		 * @return void
		 * @since  1.0.0
		 * @access public
		 * @static
		 *
		 */
		public static function activation( $network_wide ) {
			// Sprachdateien werden eingebunden.
			self::load_textdomain();

			// Überprüft die minimal erforderliche PHP- u. WP-Version.
			self::check_system_requirements();

			// Aktualisierung des Plugins (ggf).
			self::update_plugin();
		}

		/**
		 * Aktionen bei Plugin Deaktivierung
		 *
		 * @param $network_wide boolean Teilt mit, ob Netzwerkweit aktiviert werden soll
		 *
		 * @return void
		 * @since  1.0.0
		 * @access public
		 * @static
		 *
		 */
		public static function deactivation( $network_wide ) {
			self::delete_options();
		}

		/**
		 * Einbindung der Sprachdateien
		 * @return void
		 * @since  1.0.0
		 * @access protected
		 * @static
		 */
		protected static function load_textdomain() {
			load_plugin_textdomain( "fazzotheme", false, sprintf( '%s/lang/', dirname( plugin_basename( __FILE__ ) ) ) );
		}


		/**
		 * Überprüft die minimal erforderliche PHP- u. WP-Version
		 * @return void
		 * @since  1.0.0
		 * @access protected
		 * @static
		 */
		protected static function check_system_requirements() {
			$error = '';

			if ( version_compare( PHP_VERSION, self::php_version, '<' ) ) {
				$error = sprintf( __( 'FAZZO-Theme: Your server is running PHP version %s. Please upgrade at least to PHP version %s.', "fazzotheme" ), PHP_VERSION, self::wp_version );
			}

			if ( version_compare( $GLOBALS['wp_version'], self::wp_version, '<' ) ) {
				$error = sprintf( __( 'FAZZO-Theme: Your Wordpress version is %s. Please upgrade at least to Wordpress version %s.', "fazzotheme" ), $GLOBALS['wp_version'], self::wp_version );
			}

			if ( ! empty( $error ) ) {
				deactivate_plugins( plugin_basename( __FILE__ ), false, true );
				wp_die( $error );
			}
		}


		/**
		 * Aktualisiere Plugin, wenn nötig
		 * @return void
		 * @since  1.0.0
		 * @access protected
		 * @static
		 */
		private static function update_plugin() {
			$version_stored = get_option( static::version_option_name, '0' );

			if ( version_compare( $version_stored, static::version, '<' ) ) {
				// Führe Update durch:
				update_option( static::version_option_name, static::version );
			}
		}

		/**
		 * Löscht alle Einstellungen
		 * @return void
		 * @since  1.0.0
		 * @access protected
		 * @static
		 */
		protected static function delete_options() {
			delete_option( static::option_name );
			delete_option( self::version_option_name );
			// Todo: Settings der einzelnen Pages/Posts löschen
		}


		/**
		 * Setzt die Einstellungen und Eigenschaften, mit Berücksichtung auf Default Einstellungen
		 * @return void
		 * @since  1.0.0
		 * @access protected
		 * @static
		 */
		protected static function get_options() {

			$defaults = static::default_options();

			$options = get_option( static::option_name );
			if ( $options === false ) {
				$options = [];
			}

			functions::parse_args_multidim( $options, $defaults );

			static::$options = $options;
			static::set_class_properties();
		}

		/**
		 * Standardeinstellungen definieren
		 * @return array
		 * @since  1.0.0
		 * @access protected
		 * @static
		 */
		private static function default_options() {
			// Multidimensionales Array ist möglich:
			$options = [ "load_bootstrap" => 1 ];
			$options = [ "paged_menu" => 0 ];

			return $options;
		}

		/**
		 * Setzt die Eigenschaften der Klasse
		 * @return void
		 * @since  1.0.0
		 * @access protected
		 * @static
		 */
		protected static function set_class_properties() {

		}


		/**
		 * Die Menü Positionen des Themes bekannt geben
		 * @return void
		 * @since  1.0.0
		 * @access public
		 */
		public function register_menus() {
			register_nav_menu( "meta-bottom-nav", "Bottom menu" );
			register_nav_menu( "meta-content-nav", "Content menu" );
			register_nav_menu( "meta-frontpage-nav", "Frontpage menu" );
			register_nav_menu( "meta-head-nav", "Main menu" );
			register_nav_menu( "meta-top-nav", "Top menu" );


		}


		/**
		 * Sidebars für die Startseite aktivieren
		 * @return void
		 * @since  1.0.0
		 * @access public
		 */
		public function register_sidebars() {

			// Bottom

			register_sidebar( [
				'name'          => __( 'Bottom A', "fazzotheme" ),
				'id'            => 'fazzo-sidebar-bottom-a',
				'description'   => __( 'Bottom sidebar', "fazzotheme" ),
				'before_widget' => '<div id="%1$s" class="widget sidebar-bottom %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h1 class="widget-title">',
				'after_title'   => '</h1>',
			] );

			register_sidebar( [
				'name'          => __( 'Bottom B', "fazzotheme" ),
				'id'            => 'fazzo-sidebar-bottom-b',
				'description'   => __( 'Bottom sidebar', "fazzotheme" ),
				'before_widget' => '<div id="%1$s" class="widget sidebar-bottom %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h1 class="widget-title">',
				'after_title'   => '</h1>',
			] );

			register_sidebar( [
				'name'          => __( 'Bottom C', "fazzotheme" ),
				'id'            => 'fazzo-sidebar-bottom-c',
				'description'   => __( 'Bottom sidebar', "fazzotheme" ),
				'before_widget' => '<div id="%1$s" class="widget sidebar-bottom %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h1 class="widget-title">',
				'after_title'   => '</h1>',
			] );

			// Content

			register_sidebar( [
				'name'          => __( 'Content', "fazzotheme" ),
				'id'            => 'fazzo-sidebar-content',
				'description'   => __( 'Content sidebar', "fazzotheme" ),
				'before_widget' => '<div id="%1$s" class="widget sidebar-content %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h1 class="widget-title">',
				'after_title'   => '</h1>',
			] );


			// Frontpage

			register_sidebar( [
				'name'          => __( 'Frontpage', "fazzotheme" ),
				'id'            => 'fazzo-sidebar-frontpage',
				'description'   => __( 'Frontpage sidebar', "fazzotheme" ),
				'before_widget' => '<div id="%1$s" class="widget sidebar-frontpage %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h1 class="widget-title">',
				'after_title'   => '</h1>',
			] );


			// Top

			register_sidebar( [
				'name'          => __( 'Top', "fazzotheme" ),
				'id'            => 'fazzo-sidebar-top',
				'description'   => __( 'Top sidebar', "fazzotheme" ),
				'before_widget' => '<div id="%1$s" class="widget sidebar-top %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h1 class="widget-title">',
				'after_title'   => '</h1>',
			] );


		}


		/**
		 * Scripte und CSS laden - Admin Bereich
		 * @return void
		 * @since  1.0.0
		 * @access public
		 */
		public function load_admin_scripts() {
			// Add the wordpress color picker
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_script( "fazzo-admin-js", get_template_directory_uri() . "/js/admin.js", [ "wp-color-picker" ], static::version, true );
			wp_localize_script( 'fazzo-admin-js', 'js_localize_fazzo', [
				'select_picture' => __( "Select picture", "fazzotheme" ),
			] );
		}


		/**
		 * Scripte und CSS laden - Frontend Bereich
		 * @return void
		 * @since  1.0.0
		 * @access public
		 */
		public function load_frontend_scripts() {
			if ( ! is_customize_preview() ) {
				wp_enqueue_script( "fazzo-jquery", get_template_directory_uri() . "/ext/jquery/jquery-3.4.1.min.js", [], "3.4.1", true );
			}

			wp_enqueue_script( "fazzo-jquery-ui-js", get_template_directory_uri() . "/ext/jquery/jquery-ui-1.12.1.custom/jquery-ui.min.js", [ "fazzo-jquery" ], "1.12.1", true );

			if ( functions::is_true( static::$options["load_bootstrap"] ) ) {
				wp_enqueue_script( "fazzo-popper", get_template_directory_uri() . "/ext/bootstrap/popper-1.14.7/popper.min.js", [ "fazzo-jquery" ], "1.14.7", true );
				wp_enqueue_script( "fazzo-bootstrap-js", get_template_directory_uri() . "/ext/bootstrap/bootstrap-4.3.1-dist/js/bootstrap.min.js", [ "fazzo-popper" ], "4.4.1", true );
				wp_enqueue_script( "fazzo-js", get_template_directory_uri() . "/js/page.js", [ "fazzo-bootstrap-js" ], static::version, true );
			} else {
				wp_enqueue_script( "fazzo-js", get_template_directory_uri() . "/js/page.js", [ "fazzo-jquery" ], static::version, true );
			}

			wp_enqueue_style( "fazzo-jquery-ui-css", get_template_directory_uri() . "/ext/jquery/jquery-ui-1.12.1.custom/jquery-ui.min.css", [], '1.12.1', 'all' );

			if ( functions::is_true( static::$options["load_bootstrap"] ) ) {
				wp_enqueue_style( "fazzo-bootstrap-css", get_template_directory_uri() . "/ext/bootstrap/bootstrap-4.3.1-dist/css/bootstrap.min.css", [ "fazzo-jquery-ui-css" ], '4.4.1', 'all' );
				wp_enqueue_style( "fazzo-style", get_template_directory_uri() . "/css/style.css", [ "fazzo-bootstrap-css" ], static::version, 'all' );
			} else {
				wp_enqueue_style( "fazzo-style", get_template_directory_uri() . "/css/style.css", [ "fazzo-jquery-ui-css" ], static::version, 'all' );
			}

			wp_enqueue_style( "fazzo-print", get_template_directory_uri() . "/css/print.css", [ "fazzo-style" ], static::version, 'print' );

		}

		/**
		 * Teile Wordpress das Stylesheet mit
		 * @return string
		 * @since  1.0.0
		 * @access public
		 */
		public function add_editor_style() {
			add_editor_style( get_template_directory_uri() . "/css/style.css" );
		}


		/**
		 * CSS Klasse für die Navigation durch Seiten setzen
		 * @return string
		 * @since  1.0.0
		 * @access public
		 */
		public function nav_link_attributes() {
			return 'class="wp-link-nav"';
		}


		/**
		 * Länge des Excerpts setzen
		 *
		 * @param $length int Die Wordpress Länge (Nicht genutzt)
		 *
		 * @return int
		 * @since  1.0.0
		 * @access public
		 *
		 */
		public function new_excerpt_length( $length ) {
			return 30;
		}

		/**
		 * "Excerpt more" string setzen
		 *
		 * @param $more string Wordpress More (Nicht genutzt)
		 *
		 * @return string
		 * @since  1.0.0
		 * @access public
		 *
		 */
		public function new_excerpt_more( $more ) {
			global $post;
			$fade_out = "...";
			$content  = "";
			$content  .= " <a href='" . get_permalink( $post->ID ) . "' class='read-more-link'>$fade_out <span class='read-more'></span><span class='read-more-hover' style='display:none;'> </span></a>";

			return $content;
		}


		/**
		 * Registriere neue Widgets
		 * @return void
		 * @since  1.0.0
		 * @access public
		 */
		public function register_widgets() {
			//register_widget();
		}


		/**
		 * Speichert die Plugin Optionen und frischt die Klassen Eigenschaften auf
		 * @return void
		 * @since  1.0.0
		 * @access protected
		 * @static
		 */
		protected static function save_options() {
			update_option( static::option_name, static::$options );

			// Initialisiere Eigenschaften
			static::set_class_properties();
		}


		/**
		 * Bindet das Navigationstemplate ein
		 * @return void
		 * @since  1.0.0
		 * @access public
		 */
		public static function get_comments_navigation() {
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) {

				get_template_part( 'templ/nav', 'comments' );

			}
		}


		/**
		 * Füge eine Optionsseite hinzu
		 * @return void
		 * @since  1.0.0
		 * @access public
		 */
		public function settings_page() {
			// Argumente:
			$menu_slug   = 'fazzo';
			$parent_slug = "admin.php?page=" . $menu_slug;
			$page_title  = esc_html__( 'Page config', "fazzotheme" );
			$menu_title  = esc_html__( 'Config', "fazzotheme" );
			$capability  = 'manage_options';
			$post_type   = "toplevel";
			$function    = [ $this, 'settings_page_display' ];
			$position    = 80;

			// Definiere Einstellungen zu dieser Seite für spätere Verwendung:
			define( 'FAZZO_SETTINGS_PAGE', $parent_slug );
			define( 'FAZZO_SETTINGS_HOOK', $post_type . '_page_' . $menu_slug );
			define( 'FAZZO_SETTINGS_SLUG', $menu_slug );

			// Füge Seite hinzug
			add_theme_page( $page_title, $menu_title, $capability, $menu_slug, $function, $position );
		}

		/**
		 * Ausgabe der Optionsseite, welche auch die gesendeten Formulardaten speichert
		 * @return void
		 * @since  1.0.0
		 * @access public
		 */
		public function settings_page_display() {
			// Security:
			$nonce_name      = "fazzo_configuration_nonce";
			$nonce_input_key = "fazzo-configuration-nonce";
			$nonce_value     = wp_create_nonce( $nonce_name );
			$form_action_url = admin_url( FAZZO_SETTINGS_PAGE );

			// Speichern
			if ( functions::validate_nonce( $nonce_input_key, $nonce_name ) ) {
				if ( isset( $_POST['todo'] ) && $_POST['todo'] == "config" ) {

					static::$options['load_bootstrap'] = intval( $_POST['load_bootstrap'] );
					static::$options['paged_menu']     = intval( $_POST['paged_menu'] );
					static::save_options();
				}
			}

			// Zeige das Template:
			require_once( FAZZO_THEME_ROOT . "/class/templ/settings.php" );
		}

		/**
		 * Registriere Meta Boxen
		 * @return void
		 * @since  1.0.0
		 * @access public
		 */
		public function register_meta_boxes() {

			$screens = [ 'post', 'page' ];
			foreach ( $screens as $screen ) {
				add_meta_box(
					'display_meta_boxes_options',               // Unique ID
					'Options',                             // Box title
					[ $this, "display_meta_boxes_options", ],    // Content callback, must be of type callable
					$screen,                                  // Post type
					'side', 'default'
				);
			}


		}

		/**
		 * Zeige Meta Box
		 *
		 * @param object $post Das Post Object
		 * @param object $metabox Die Metabox
		 *
		 * @access public
		 * @return void
		 * @since  1.0.0
		 */
		public function display_meta_boxes_options( $post, $metabox ) {

			$options = get_post_meta( $post->ID, static::option_name, true );
			if ( ! is_array( $options ) ) {
				$options = [];
			}

			if ( ! isset( $options["background_color"] ) || strlen( $options["background_color"] < 7 ) ) {
				$options["background_color"] = "#000000";
			}
			if ( ! isset( $options["background_transparent"] ) ) {
				$options["background_transparent"] = true;
			}

			$content = "";
			$content .= "<h3>Background</h3>";
			$content .= '<input type="text" name="fazzo_options[background_color]" value="' . $options["background_color"] . '" class="color-field" ><br />';
			$content .= '<input type="radio" name="fazzo_options[background_transparent]" value="1"';
			if ( ! empty( $options["background_transparent"] ) ) {
				$content .= 'checked="checked"';
			}
			$content .= '> Transparent <input type="radio" name="fazzo_options[background_transparent]" value="0"';
			if ( empty( $options["background_transparent"] ) ) {
				$content .= 'checked="checked"';
			}
			$content .= '> Farbig';

			if ( $post->post_type == "page" ) {

				if ( ! isset( $options["icon"] ) ) {
					$options["icon"] = false;
					$img_alt         = __( ' No picture ', "fazzotheme" );
				} else {
					$img_alt = __( ' Preview image ', "fazzotheme" );
				}

				$content .= "<br /><hr><h3>Icon</h3><p><img id=\"fazzo-image-preview\" src=\"" . $options["icon"] . "\" alt=\"" . $img_alt . "\"></p>";

				if ( empty( $options["icon"] ) ) {
					$content .= '<p><button type="button" class="button button-secondary" value="' . __( 'Upload image', "fazzotheme" ) . '" id="fazzo-upload-button">
		<span class="sunset-icon-button dashicons-before dashicons-format-image"></span> ' . __( 'Upload image', "fazzotheme" ) . '</button>
		<input type="hidden" id="fazzo-image" name="fazzo_options[icon]" value="" /></p>';
				} else {
					$content .= '<p><button type="button" class="button button-secondary" value="' . __( 'Replace image', "fazzotheme" ) . '" id="fazzo-upload-button">
		<span class="sunset-icon-button dashicons-before dashicons-format-image"></span> ' . __( 'Replace image', "fazzotheme" ) . '</button>
		<input type="hidden" id="fazzo-image" name="fazzo_options[icon]" value="' . $options["icon"] . '" /> 
		<button type="button" class="button button-secondary" value="' . __( 'Remove', "fazzotheme" ) . '" id="fazzo-remove-picture">
		<span class="sunset-icon-button dashicons-before dashicons-no"></span> ' . __( 'Remove', "fazzotheme" ) . '</button></p>';
				}
			}
			echo $content;

		}


		/**
		 * Wenn der Post gespeichert wird
		 *
		 * @param int $post_id Die ID des Posts
		 *
		 * @return void
		 * @since  1.0.0
		 * @access public
		 *
		 */
		public function save_post( $post_id ) {

			if ( array_key_exists( 'fazzo_options', $_POST ) ) {
				update_post_meta(
					$post_id,
					static::option_name,
					$_POST['fazzo_options']
				);
			}


		}

		/**
		 * Customizer Preview enqueue Scripts and Styles
		 * @return void
		 * @since  1.0.0
		 * @access public
		 */
		public function customizer_preview_enqueue() {

			wp_enqueue_script( 'fazzo-theme-customizer-pre-js', get_template_directory_uri() . '/js/customizer_preview.js', [
				'jquery',
				'customize-preview',
			], static::version, true );

			wp_enqueue_style( "fazzo-theme-customizer-css", get_template_directory_uri() . "/css/customizer.css", [], static::version, 'all' );
		}


		/**
		 * Customizer Control enqueue Scripts and Styles
		 * @return void
		 * @since  1.0.0
		 * @access public
		 */
		public function customizer_controls_enqueue() {

			wp_enqueue_script( 'fazzo-theme-customizer-con-js', get_template_directory_uri() . '/js/customizer_controls.js', [
				'jquery',
				'customize-preview',
			], static::version, true );

		}


		/**
		 * Customizer
		 * @return void
		 * @since  1.0.0
		 * @access public
		 */
		public function customizer_register( $wp_customize ) {

			$customizer_set = [];

			$customizer                            = new customizer( $wp_customize );
			$panel_style                           = $customizer->add_panel( "style", __( 'Change style', "fazzotheme" ), __( 'Set specific styles', "fazzotheme" ) );
			$section_background_style              = $customizer->add_section( "background_style", $panel_style, __( 'Site', "fazzotheme" ), __( 'Set specific site backgrounds', "fazzotheme" ) );
			$section_head_style                    = $customizer->add_section( "background_head_style", $panel_style, __( 'Head', "fazzotheme" ), __( 'Set specific head backgrounds', "fazzotheme" ) );
			$section_nav_top_style                 = $customizer->add_section( "nav_top_style", $panel_style, __( 'Head top', "fazzotheme" ), __( 'Set specific top styles', "fazzotheme" ) );
			$section_nav_top_style_hover           = $customizer->add_section( "nav_top_hover_style", $panel_style, __( 'Head top hover', "fazzotheme" ), __( 'Set specific top styles', "fazzotheme" ) );
			$section_head_content_style            = $customizer->add_section( "head_content_style", $panel_style, __( 'Head content', "fazzotheme" ), __( 'Set specific head content styles', "fazzotheme" ) );
			$section_nav_head_style                = $customizer->add_section( "nav_head_style", $panel_style, __( 'Head navigation', "fazzotheme" ), __( 'Set specific head navigation styles', "fazzotheme" ) );
			$section_nav_head_hover_style          = $customizer->add_section( "nav_head_hover_style", $panel_style, __( 'Head navigation hover', "fazzotheme" ), __( 'Set specific head navigation styles', "fazzotheme" ) );
			$section_nav_head_dropdown_style       = $customizer->add_section( "nav_head_dropdown_style", $panel_style, __( 'Head navigation dropdown', "fazzotheme" ), __( 'Set specific top styles', "fazzotheme" ) );
			$section_nav_head_dropdown_hover_style = $customizer->add_section( "nav_head_dropdown_hover_style", $panel_style, __( 'Head navigation dropdown hover', "fazzotheme" ), __( 'Set specific top styles', "fazzotheme" ) );
			$section_content_style                 = $customizer->add_section( "content_style", $panel_style, __( 'Content', "fazzotheme" ), __( 'Set specific content styles', "fazzotheme" ) );
			$section_nav_content_style             = $customizer->add_section( "nav_content_style", $panel_style, __( 'Content navigation', "fazzotheme" ), __( 'Set specific navigation content styles', "fazzotheme" ) );
			$section_nav_content_hover_style       = $customizer->add_section( "nav_content_hover_style", $panel_style, __( 'Content navigation hover', "fazzotheme" ), __( 'Set specific navigation content styles', "fazzotheme" ) );
			$section_nav_footer_style              = $customizer->add_section( "nav_footer_style", $panel_style, __( 'Footer navigation', "fazzotheme" ), __( 'Set specific navigation footer styles', "fazzotheme" ) );
			$section_nav_footer_hover_style        = $customizer->add_section( "nav_footer_hover_style", $panel_style, __( 'Footer navigation hover', "fazzotheme" ), __( 'Set specific navigation footer styles', "fazzotheme" ) );
			$section_text_footer_style             = $customizer->add_section( "text_footer_style", $panel_style, __( 'Footer', "fazzotheme" ), __( 'Set specific footer styles', "fazzotheme" ) );
			$section_widget_style                  = $customizer->add_section( "widget_style", $panel_style, __( 'Widgets', "fazzotheme" ), __( 'Set specific widget styles', "fazzotheme" ) );
			$section_sizes_spaces                  = $customizer->add_section( "sizes_spaces", $panel_style, __( 'Sizes and Spaces', "fazzotheme" ), __( 'Set specific sizes and spaces', "fazzotheme" ) );
			$section_settings                      = $customizer->add_section( "settings", $panel_style, __( 'Settings', "fazzotheme" ), __( 'Set specific settings', "fazzotheme" ) );

			// Background Site
			$customizer_collect            = [];
			$customizer_collect["element"] = "body";
			$customizer_collect["image"]   = $customizer->add_control( "image", "background_body_image", $section_background_style, __( 'Image layer 1', "fazzotheme" ) );
			$customizer_set[]              = $customizer_collect;

			$customizer_collect                 = [];
			$customizer_collect["element"]      = "#body_overlay";
			$customizer_collect["color_top"]    = $customizer->add_control( "color", "background_color_top", $section_background_style, __( 'Color top', "fazzotheme" ) );
			$customizer_collect["color_bottom"] = $customizer->add_control( "color", "background_color_bottom", $section_background_style, __( 'Color bottom', "fazzotheme" ) );
			$customizer_collect["opacity"]      = $customizer->add_control( "text", "background_opacity", $section_background_style, __( 'Opacity', "fazzotheme" ) );
			$customizer_collect["image"]        = $customizer->add_control( "image", "background_image", $section_background_style, __( 'Image layer 2', "fazzotheme" ) );
			$customizer_set[]                   = $customizer_collect;

			// Background Head
			$customizer_collect                 = [];
			$customizer_collect["element"]      = "#sec_head";
			$customizer_collect["color_top"]    = $customizer->add_control( "color", "background_head_color_top", $section_head_style, __( 'Color top', "fazzotheme" ) );
			$customizer_collect["color_bottom"] = $customizer->add_control( "color", "background_head_color_bottom", $section_head_style, __( 'Color bottom', "fazzotheme" ) );
			$customizer_collect["opacity"]      = $customizer->add_control( "text", "background_head_opacity", $section_head_style, __( 'Opacity', "fazzotheme" ) );
			$customizer_collect["image"]        = $customizer->add_control( "image", "background_head_image", $section_head_style, __( 'Image', "fazzotheme" ) );
			$customizer_set[]                   = $customizer_collect;

			// Head top
			$customizer_collect                          = [];
			$customizer_collect["element"]               = "#sec_head_meta";
			$customizer_collect["color_top"]             = $customizer->add_control( "color", "background_nav_top_color_top", $section_nav_top_style, __( 'Color top', "fazzotheme" ) );
			$customizer_collect["color_bottom"]          = $customizer->add_control( "color", "background_nav_top_color_bottom", $section_nav_top_style, __( 'Color bottom', "fazzotheme" ) );
			$customizer_collect["opacity"]               = $customizer->add_control( "text", "background_nav_top_opacity", $section_nav_top_style, __( 'Opacity', "fazzotheme" ) );
			$customizer_collect["link_font_color"]       = $customizer->add_control( "color", "link_font_nav_top_color", $section_nav_top_style, __( 'Link color', "fazzotheme" ) );
			$customizer_collect["link_hover_font_color"] = $customizer->add_control( "color", "link_hover_font_nav_top_color", $section_nav_top_style, __( 'Link hover color', "fazzotheme" ) );
			$customizer_collect["border_color"]          = $customizer->add_control( "color", "border_nav_top_color", $section_nav_top_style, __( 'Border color', "fazzotheme" ) );
			$customizer_collect["image"]                 = $customizer->add_control( "image", "background_nav_top_image", $section_nav_top_style, __( 'Image', "fazzotheme" ) );
			$customizer_set[]                            = $customizer_collect;

			// Head top hover
			$customizer_collect_hover                 = [];
			$customizer_collect_hover["element"]      = "#wrap_top_nav";
			$customizer_collect_hover["color_top"]    = $customizer->add_control( "color", "background_nav_top_hover_color_top", $section_nav_top_style_hover, __( 'Color top', "fazzotheme" ) );
			$customizer_collect_hover["color_bottom"] = $customizer->add_control( "color", "background_nav_top_hover_color_bottom", $section_nav_top_style_hover, __( 'Color bottom', "fazzotheme" ) );
			$customizer_collect_hover["opacity"]      = $customizer->add_control( "text", "background_nav_top_hover_opacity", $section_nav_top_style_hover, __( 'Opacity', "fazzotheme" ) );
			$customizer_collect_hover["border_color"] = $customizer->add_control( "color", "border_nav_top_hover_color", $section_nav_top_style_hover, __( 'Border color', "fazzotheme" ) );
			$customizer_collect_hover["image"]        = $customizer->add_control( "image", "background_nav_top_hover_image", $section_nav_top_style_hover, __( 'Image', "fazzotheme" ) );
			$customizer_set_hover[]                   = $customizer_collect_hover;

			// Head Content
			$customizer_collect                          = [];
			$customizer_collect["element"]               = "#head-title";
			$customizer_collect["link_font_color"]       = $customizer->add_control( "color", "link_font_content_head_color", $section_head_content_style, __( 'Link color', "fazzotheme" ) );
			$customizer_collect["link_hover_font_color"] = $customizer->add_control( "color", "link_hover_font_content_head_color", $section_head_content_style, __( 'Link hover color', "fazzotheme" ) );
			$customizer_set[]                            = $customizer_collect;
			$customizer_collect                          = [];
			$customizer_collect["element"]               = "#head-description span";
			$customizer_collect["font_color"]            = $customizer->add_control( "color", "font_content_head_description_color", $section_head_content_style, __( 'Font color', "fazzotheme" ) );
			$customizer_collect["border_color"]          = $customizer->add_control( "color", "border_content_head_description_color", $section_head_content_style, __( 'Border color', "fazzotheme" ) );
			$customizer_set[]                            = $customizer_collect;

			// Head Nav
			$customizer_collect                          = [];
			$customizer_collect["element"]               = "#sec_head_nav";
			$customizer_collect["color_top"]             = $customizer->add_control( "color", "background_nav_head_color_top", $section_nav_head_style, __( 'Color top', "fazzotheme" ) );
			$customizer_collect["color_bottom"]          = $customizer->add_control( "color", "background_nav_head_color_bottom", $section_nav_head_style, __( 'Color bottom', "fazzotheme" ) );
			$customizer_collect["opacity"]               = $customizer->add_control( "text", "background_nav_head_opacity", $section_nav_head_style, __( 'Opacity', "fazzotheme" ) );
			$customizer_collect["link_font_color"]       = $customizer->add_control( "color", "link_font_nav_head_color", $section_nav_head_style, __( 'Link color', "fazzotheme" ) );
			$customizer_collect["link_hover_font_color"] = $customizer->add_control( "color", "link_hover_font_nav_head_color", $section_nav_head_style, __( 'Link hover color', "fazzotheme" ) );
			$customizer_collect["border_color"]          = $customizer->add_control( "color", "border_nav_head_color", $section_nav_head_style, __( 'Border color', "fazzotheme" ) );
			$customizer_collect["image"]                 = $customizer->add_control( "image", "background_nav_head_image", $section_nav_head_style, __( 'Image', "fazzotheme" ) );
			$customizer_set[]                            = $customizer_collect;

			// Head Nav Hover
			$customizer_collect_hover                 = [];
			$customizer_collect_hover["element"]      = "#sec_head_nav";
			$customizer_collect_hover["color_top"]    = $customizer->add_control( "color", "background_nav_head_hover_color_top", $section_nav_head_hover_style, __( 'Color top', "fazzotheme" ) );
			$customizer_collect_hover["color_bottom"] = $customizer->add_control( "color", "background_nav_head_hover_color_bottom", $section_nav_head_hover_style, __( 'Color bottom', "fazzotheme" ) );
			$customizer_collect_hover["opacity"]      = $customizer->add_control( "text", "background_nav_head_hover_opacity", $section_nav_head_hover_style, __( 'Opacity', "fazzotheme" ) );
			$customizer_collect_hover["border_color"] = $customizer->add_control( "color", "border_nav_head_hover_color", $section_nav_head_hover_style, __( 'Border color', "fazzotheme" ) );
			$customizer_collect_hover["image"]        = $customizer->add_control( "image", "background_nav_head_hover_image", $section_nav_head_hover_style, __( 'Image', "fazzotheme" ) );
			$customizer_set_hover[]                   = $customizer_collect_hover;

			// Head Nav Dropdown
			$customizer_collect                          = [];
			$customizer_collect["element"]               = "#sec_head_nav .dropdown-menu";
			$customizer_collect["color_top"]             = $customizer->add_control( "color", "background_nav_head_dropdown_color_top", $section_nav_head_dropdown_style, __( 'Color top', "fazzotheme" ) );
			$customizer_collect["color_bottom"]          = $customizer->add_control( "color", "background_nav_head_dropdown_color_bottom", $section_nav_head_dropdown_style, __( 'Color bottom', "fazzotheme" ) );
			$customizer_collect["opacity"]               = $customizer->add_control( "text", "background_nav_head_dropdown_opacity", $section_nav_head_dropdown_style, __( 'Opacity', "fazzotheme" ) );
			$customizer_collect["link_font_color"]       = $customizer->add_control( "color", "link_font_nav_head_dropdown_color", $section_nav_head_dropdown_style, __( 'Link color', "fazzotheme" ) );
			$customizer_collect["link_hover_font_color"] = $customizer->add_control( "color", "link_hover_font_nav_head_dropdown_color", $section_nav_head_dropdown_style, __( 'Link hover color', "fazzotheme" ) );
			$customizer_collect["border_color"]          = $customizer->add_control( "color", "border_nav_head_dropdown_color", $section_nav_head_dropdown_style, __( 'Border color', "fazzotheme" ) );
			$customizer_collect["image"]                 = $customizer->add_control( "image", "background_nav_head_dropdown_image", $section_nav_head_dropdown_style, __( 'Image', "fazzotheme" ) );
			$customizer_set[]                            = $customizer_collect;

			// Head Nav Dropdown Hover
			$customizer_collect_hover                 = [];
			$customizer_collect_hover["element"]      = "#sec_head_nav .dropdown-menu";
			$customizer_collect_hover["color_top"]    = $customizer->add_control( "color", "background_nav_head_dropdown_hover_color_top", $section_nav_head_dropdown_hover_style, __( 'Color top', "fazzotheme" ) );
			$customizer_collect_hover["color_bottom"] = $customizer->add_control( "color", "background_nav_head_dropdown_hover_color_bottom", $section_nav_head_dropdown_hover_style, __( 'Color bottom', "fazzotheme" ) );
			$customizer_collect_hover["opacity"]      = $customizer->add_control( "text", "background_nav_head_dropdown_hover_opacity", $section_nav_head_dropdown_hover_style, __( 'Opacity', "fazzotheme" ) );
			$customizer_collect_hover["border_color"] = $customizer->add_control( "color", "border_nav_head_dropdown_hover_color", $section_nav_head_dropdown_hover_style, __( 'Border color', "fazzotheme" ) );
			$customizer_collect_hover["image"]        = $customizer->add_control( "image", "background_nav_head_dropdown_hover_image", $section_nav_head_dropdown_hover_style, __( 'Image', "fazzotheme" ) );
			$customizer_set_hover[]                   = $customizer_collect_hover;


			// Content Nav
			$customizer_collect                          = [];
			$customizer_collect["element"]               = "#wrap_content_nav";
			$customizer_collect["color_top"]             = $customizer->add_control( "color", "background_nav_content_color_top", $section_nav_content_style, __( 'Color top', "fazzotheme" ) );
			$customizer_collect["color_bottom"]          = $customizer->add_control( "color", "background_nav_content_color_bottom", $section_nav_content_style, __( 'Color bottom', "fazzotheme" ) );
			$customizer_collect["opacity"]               = $customizer->add_control( "text", "background_nav_content_opacity", $section_nav_content_style, __( 'Opacity', "fazzotheme" ) );
			$customizer_collect["link_font_color"]       = $customizer->add_control( "color", "link_font_nav_content_color", $section_nav_content_style, __( 'Link color', "fazzotheme" ) );
			$customizer_collect["link_hover_font_color"] = $customizer->add_control( "color", "link_hover_font_nav_content_color", $section_nav_content_style, __( 'Link hover color', "fazzotheme" ) );
			$customizer_collect["border_color"]          = $customizer->add_control( "color", "border_nav_content_color", $section_nav_content_style, __( 'Border color', "fazzotheme" ) );
			$customizer_collect["image"]                 = $customizer->add_control( "image", "background_nav_content_image", $section_nav_content_style, __( 'Image', "fazzotheme" ) );
			$customizer_set[]                            = $customizer_collect;

			// Content Nav Hover
			$customizer_collect_hover                 = [];
			$customizer_collect_hover["element"]      = "#wrap_content_nav";
			$customizer_collect_hover["color_top"]    = $customizer->add_control( "color", "background_nav_content_hover_color_top", $section_nav_content_hover_style, __( 'Color top', "fazzotheme" ) );
			$customizer_collect_hover["color_bottom"] = $customizer->add_control( "color", "background_nav_content_hover_color_bottom", $section_nav_content_hover_style, __( 'Color bottom', "fazzotheme" ) );
			$customizer_collect_hover["opacity"]      = $customizer->add_control( "text", "background_nav_content_hover_opacity", $section_nav_content_hover_style, __( 'Opacity', "fazzotheme" ) );
			$customizer_collect_hover["border_color"] = $customizer->add_control( "color", "border_nav_content_hover_color", $section_nav_content_hover_style, __( 'Border color', "fazzotheme" ) );
			$customizer_collect_hover["image"]        = $customizer->add_control( "image", "background_nav_content_hover_image", $section_nav_content_hover_style, __( 'Image', "fazzotheme" ) );
			$customizer_set_hover[]                   = $customizer_collect_hover;


			// Content
			$customizer_collect                          = [];
			$customizer_collect["element"]               = "article";
			$customizer_collect["color_top"]             = $customizer->add_control( "color", "background_content_color_top", $section_content_style, __( 'Color top', "fazzotheme" ) );
			$customizer_collect["color_bottom"]          = $customizer->add_control( "color", "background_content_color_bottom", $section_content_style, __( 'Color bottom', "fazzotheme" ) );
			$customizer_collect["opacity"]               = $customizer->add_control( "text", "background_content_opacity", $section_content_style, __( 'Opacity', "fazzotheme" ) );
			$customizer_collect["font_color"]            = $customizer->add_control( "color", "font_content_color", $section_content_style, __( 'Font color', "fazzotheme" ) );
			$customizer_collect["link_font_color"]       = $customizer->add_control( "color", "link_font_content_color", $section_content_style, __( 'Link color', "fazzotheme" ) );
			$customizer_collect["link_hover_font_color"] = $customizer->add_control( "color", "link_hover_font_content_color", $section_content_style, __( 'Link hover color', "fazzotheme" ) );
			$customizer_collect["border_color"]          = $customizer->add_control( "color", "border_content_color", $section_content_style, __( 'Border color', "fazzotheme" ) );
			$customizer_collect["image"]                 = $customizer->add_control( "image", "background_content_image", $section_content_style, __( 'Image', "fazzotheme" ) );
			$customizer_set[]                            = $customizer_collect;

			// Widgets
			$customizer_collect                          = [];
			$customizer_collect["element"]               = ".widget";
			$customizer_collect["color_top"]             = $customizer->add_control( "color", "background_widget_color_top", $section_widget_style, __( 'Color top', "fazzotheme" ) );
			$customizer_collect["color_bottom"]          = $customizer->add_control( "color", "background_widget_color_bottom", $section_widget_style, __( 'Color bottom', "fazzotheme" ) );
			$customizer_collect["opacity"]               = $customizer->add_control( "text", "background_widget_opacity", $section_widget_style, __( 'Opacity', "fazzotheme" ) );
			$customizer_collect["font_color"]            = $customizer->add_control( "color", "font_widget_color", $section_widget_style, __( 'Font color', "fazzotheme" ) );
			$customizer_collect["link_font_color"]       = $customizer->add_control( "color", "link_font_widget_color", $section_widget_style, __( 'Link color', "fazzotheme" ) );
			$customizer_collect["link_hover_font_color"] = $customizer->add_control( "color", "link_hover_font_widget_color", $section_widget_style, __( 'Link hover color', "fazzotheme" ) );
			$customizer_collect["border_color"]          = $customizer->add_control( "color", "border_widget_color", $section_widget_style, __( 'Border color', "fazzotheme" ) );
			$customizer_collect["image"]                 = $customizer->add_control( "image", "background_widget_image", $section_widget_style, __( 'Image', "fazzotheme" ) );
			$customizer_set[]                            = $customizer_collect;

			// Footer Nav
			$customizer_collect                          = [];
			$customizer_collect["element"]               = "#sec_foot_nav";
			$customizer_collect["color_top"]             = $customizer->add_control( "color", "background_nav_footer_color_top", $section_nav_footer_style, __( 'Color top', "fazzotheme" ) );
			$customizer_collect["color_bottom"]          = $customizer->add_control( "color", "background_nav_footer_color_bottom", $section_nav_footer_style, __( 'Color bottom', "fazzotheme" ) );
			$customizer_collect["opacity"]               = $customizer->add_control( "text", "background_nav_footer_opacity", $section_nav_footer_style, __( 'Opacity', "fazzotheme" ) );
			$customizer_collect["link_font_color"]       = $customizer->add_control( "color", "link_font_nav_footer_color", $section_nav_footer_style, __( 'Link color', "fazzotheme" ) );
			$customizer_collect["link_hover_font_color"] = $customizer->add_control( "color", "link_hover_font_nav_footer_color", $section_nav_footer_style, __( 'Link hover color', "fazzotheme" ) );
			$customizer_collect["border_color"]          = $customizer->add_control( "color", "border_nav_footer_color", $section_nav_footer_style, __( 'Border color', "fazzotheme" ) );
			$customizer_collect["image"]                 = $customizer->add_control( "image", "background_nav_footer_image", $section_nav_footer_style, __( 'Image', "fazzotheme" ) );
			$customizer_set[]                            = $customizer_collect;

			// Footer Nav Hover
			$customizer_collect_hover                 = [];
			$customizer_collect_hover["element"]      = "#sec_foot_nav";
			$customizer_collect_hover["color_top"]    = $customizer->add_control( "color", "background_nav_footer_hover_color_top", $section_nav_footer_hover_style, __( 'Color top', "fazzotheme" ) );
			$customizer_collect_hover["color_bottom"] = $customizer->add_control( "color", "background_nav_footer_hover_color_bottom", $section_nav_footer_hover_style, __( 'Color bottom', "fazzotheme" ) );
			$customizer_collect_hover["opacity"]      = $customizer->add_control( "text", "background_nav_footer_hover_opacity", $section_nav_footer_hover_style, __( 'Opacity', "fazzotheme" ) );
			$customizer_collect_hover["border_color"] = $customizer->add_control( "color", "border_nav_footer_hover_color", $section_nav_footer_hover_style, __( 'Border color', "fazzotheme" ) );
			$customizer_collect_hover["image"]        = $customizer->add_control( "image", "background_nav_footer_hover_image", $section_nav_footer_hover_style, __( 'Image', "fazzotheme" ) );
			$customizer_set_hover[]                   = $customizer_collect_hover;

			// Footer Text
			$customizer_collect                 = [];
			$customizer_collect["element"]      = "#sec_foot_text";
			$customizer_collect["color_top"]    = $customizer->add_control( "color", "background_foot_text_color_top", $section_text_footer_style, __( 'Color top', "fazzotheme" ) );
			$customizer_collect["color_bottom"] = $customizer->add_control( "color", "background_foot_text_color_bottom", $section_text_footer_style, __( 'Color bottom', "fazzotheme" ) );
			$customizer_collect["opacity"]      = $customizer->add_control( "text", "background_foot_text_opacity", $section_text_footer_style, __( 'Opacity', "fazzotheme" ) );
			$customizer_collect["font_color"]   = $customizer->add_control( "color", "font_foot_text_color", $section_text_footer_style, __( 'Font color', "fazzotheme" ) );
			$customizer_collect["border_color"] = $customizer->add_control( "color", "border_foot_text_color", $section_text_footer_style, __( 'Border color', "fazzotheme" ) );
			$customizer_collect["text_year"]    = $customizer->add_control( "text", "foot_text_year", $section_text_footer_style, __( 'Start year', "fazzotheme" ) );
			$customizer_collect["image"]        = $customizer->add_control( "image", "background_foot_text_image", $section_text_footer_style, __( 'Image', "fazzotheme" ) );
			$customizer_set[]                   = $customizer_collect;

			// Sizes / Spaces
			$customizer_collect              = [];
			$customizer_collect["element"]   = "#sec_head_content";
			$customizer_collect["height"]    = $customizer->add_control( "text", "head_height", $section_sizes_spaces, __( 'Head min. height', "fazzotheme" ) );
			$customizer_set[]                = $customizer_collect;
			$customizer_collect              = [];
			$customizer_collect["element"]   = "#wrap_content_output";
			$customizer_collect["height"]    = $customizer->add_control( "text", "content_height", $section_sizes_spaces, __( 'Content min. height', "fazzotheme" ) );
			$customizer_set[]                = $customizer_collect;
			$customizer_collect              = [];
			$customizer_collect["element"]   = "#wrap_foot_widget";
			$customizer_collect["height"]    = $customizer->add_control( "text", "footer_height", $section_sizes_spaces, __( 'Footer widget min. height', "fazzotheme" ) );
			$customizer_set[]                = $customizer_collect;
			$customizer_collect              = [];
			$customizer_collect["element"]   = "#menu-meta-top li a";
			$customizer_collect["padding_h"] = $customizer->add_control( "text", "top_padding_h", $section_sizes_spaces, __( 'Top navigation padding horiz', "fazzotheme" ) );
			$customizer_collect["padding_v"] = $customizer->add_control( "text", "top_padding_v", $section_sizes_spaces, __( 'Top navigation padding vert.', "fazzotheme" ) );
			$customizer_collect              = [];
			$customizer_set[]                = $customizer_collect;
			$customizer_collect["element"]   = "#meta-head-nav ul li a";
			$customizer_collect["padding_h"] = $customizer->add_control( "text", "main_nav_padding_h", $section_sizes_spaces, __( 'Main navigation padding horiz.', "fazzotheme" ) );
			$customizer_collect["padding_v"] = $customizer->add_control( "text", "main_nav_padding_v", $section_sizes_spaces, __( 'Main navigation padding vert.', "fazzotheme" ) );
			$customizer_collect              = [];
			$customizer_set[]                = $customizer_collect;
			$customizer_collect["element"]   = "#meta-bottom-nav ul li a";
			$customizer_collect["padding_h"] = $customizer->add_control( "text", "footer_nav_padding_h", $section_sizes_spaces, __( 'Footer navigation padding horiz.', "fazzotheme" ) );
			$customizer_collect["padding_v"] = $customizer->add_control( "text", "footer_nav_padding_v", $section_sizes_spaces, __( 'Footer navigation padding vert.', "fazzotheme" ) );
			$customizer_collect              = [];
			$customizer_set[]                = $customizer_collect;
			$customizer_collect["element"]   = "#wrap_foot_text";
			$customizer_collect["padding_v"] = $customizer->add_control( "text", "footer_text_padding_v", $section_sizes_spaces, __( 'Footer text padding vert.', "fazzotheme" ) );
			$customizer_set[]                = $customizer_collect;
			$customizer_collect              = [];
			// Todo: Padding Widgets

			$customizer_collect["element"]        = "#sec_head_meta";
			$customizer_collect["font_size_text"] = $customizer->add_control( "text", "top_font_size", $section_sizes_spaces, __( 'Top font size', "fazzotheme" ) );
			$customizer_set[]                     = $customizer_collect;
			$customizer_collect                   = [];
			$customizer_collect["element"]        = "#head-title";
			$customizer_collect["font_size_text"] = $customizer->add_control( "text", "head_content_header_font_size", $section_sizes_spaces, __( 'Head header font size', "fazzotheme" ) );
			$customizer_set[]                     = $customizer_collect;
			$customizer_collect                   = [];
			$customizer_collect["element"]        = "#head-description";
			$customizer_collect["font_size_text"] = $customizer->add_control( "text", "head_content_font_size", $section_sizes_spaces, __( 'Head text font size', "fazzotheme" ) );
			$customizer_set[]                     = $customizer_collect;
			$customizer_collect                   = [];
			$customizer_collect["element"]        = "#sec_head_nav";
			$customizer_collect["font_size_text"] = $customizer->add_control( "text", "main_nav_font_size", $section_sizes_spaces, __( 'Main navigation font size', "fazzotheme" ) );
			$customizer_set[]                     = $customizer_collect;
			$customizer_collect                   = [];
			$customizer_collect["element"]        = "#wrap_content_nav";
			$customizer_collect["font_size_text"] = $customizer->add_control( "text", "content_nav_font_size", $section_sizes_spaces, __( 'Content navigation font size', "fazzotheme" ) );
			$customizer_set[]                     = $customizer_collect;
			$customizer_collect                   = [];
			$customizer_collect["element"]        = "#wrap_content_output";
			$customizer_collect["font_size_text"] = $customizer->add_control( "text", "content_font_size", $section_sizes_spaces, __( 'Content font size', "fazzotheme" ) );
			$customizer_set[]                     = $customizer_collect;
			$customizer_collect                   = [];
			$customizer_collect["element"]        = "#wrap_content_output h1";
			$customizer_collect["font_size"]      = $customizer->add_control( "text", "content_h1_font_size", $section_sizes_spaces, __( 'Content header 1 font size', "fazzotheme" ) );
			$customizer_set[]                     = $customizer_collect;
			$customizer_collect                   = [];
			$customizer_collect["element"]        = "#wrap_content_output h2";
			$customizer_collect["font_size"]      = $customizer->add_control( "text", "content_h2_font_size", $section_sizes_spaces, __( 'Content header 2 font size', "fazzotheme" ) );
			$customizer_set[]                     = $customizer_collect;
			$customizer_collect                   = [];
			$customizer_collect["element"]        = "#wrap_content_output h3";
			$customizer_collect["font_size"]      = $customizer->add_control( "text", "content_h3_font_size", $section_sizes_spaces, __( 'Content header 3 font size', "fazzotheme" ) );
			$customizer_set[]                     = $customizer_collect;
			$customizer_collect                   = [];
			$customizer_collect["element"]        = "#wrap_foot_nav";
			$customizer_collect["font_size_text"] = $customizer->add_control( "text", "foot_nav_font_size", $section_sizes_spaces, __( 'Footer navigation font size', "fazzotheme" ) );
			$customizer_set[]                     = $customizer_collect;
			$customizer_collect                   = [];
			$customizer_collect["element"]        = ".widget";
			$customizer_collect["font_size_text"] = $customizer->add_control( "text", "widget_font_size", $section_sizes_spaces, __( 'Widget font size', "fazzotheme" ) );
			$customizer_set[]                     = $customizer_collect;
			$customizer_collect                   = [];
			$customizer_collect["element"]        = ".widget h1";
			$customizer_collect["font_size"]      = $customizer->add_control( "text", "widget_header_font_size", $section_sizes_spaces, __( 'Widget header font size', "fazzotheme" ) );
			$customizer_set[]                     = $customizer_collect;
			$customizer_collect                   = [];
			$customizer_collect["element"]        = "#wrap_foot_text";
			$customizer_collect["font_size"]      = $customizer->add_control( "text", "footer_text_font_size", $section_sizes_spaces, __( 'Footer text font size', "fazzotheme" ) );
			$customizer_set[]                     = $customizer_collect;
			$customizer_collect                   = [];

			// Settings
			$customizer_settings                            = [];
			$customizer_settings["show_search"]             = $customizer->add_control( "checkbox", "show_search", $section_settings, __( 'Search', "fazzotheme" ) );
			$customizer_settings["add_space"]               = $customizer->add_control( "checkbox", "add_space", $section_settings, __( 'Increase inner distance', "fazzotheme" ) );
			$customizer_settings["round_corners"]           = $customizer->add_control( "checkbox", "round_corners", $section_settings, __( 'Round borders', "fazzotheme" ) );
			$customizer_settings["border_radius"]           = $customizer->add_control( "text", "border_radius", $section_settings, __( 'Radius', "fazzotheme" ) );
			$customizer_settings["center_content"]          = $customizer->add_control( "checkbox", "center_content", $section_settings, __( 'Content centered', "fazzotheme" ) );
			$customizer_settings["show_post_nav"]           = $customizer->add_control( "checkbox", "show_post_nav", $section_settings, __( 'Show post navigation links', "fazzotheme" ) );
			$customizer_settings["show_page_nav"]           = $customizer->add_control( "checkbox", "show_page_nav", $section_settings, __( 'Show page navigation links', "fazzotheme" ) );
			$customizer_settings["show_post_date"]          = $customizer->add_control( "checkbox", "show_post_date", $section_settings, __( 'Show post date and author', "fazzotheme" ) );
			$customizer_settings["show_author_link"]        = $customizer->add_control( "checkbox", "show_author_link", $section_settings, __( 'Show author link', "fazzotheme" ) );
			$customizer_settings["show_page_date"]          = $customizer->add_control( "checkbox", "show_page_date", $section_settings, __( 'Show page date and author', "fazzotheme" ) );
			$customizer_settings["show_categories"]         = $customizer->add_control( "checkbox", "show_categories", $section_settings, __( 'Show categories', "fazzotheme" ) );
			$customizer_settings["show_edit_link"]          = $customizer->add_control( "checkbox", "show_edit_link", $section_settings, __( 'Show edit link', "fazzotheme" ) );
			$customizer_settings["disable_comments"]        = $customizer->add_control( "checkbox", "disable_comments", $section_settings, __( 'Disable Comments', "fazzotheme" ) );
			$customizer_settings["display_shadows"]         = $customizer->add_control( "checkbox", "display_shadows", $section_settings, __( 'Display shadows', "fazzotheme" ) );
			$customizer_settings["display_article_shadows"] = $customizer->add_control( "checkbox", "display_article_shadows", $section_settings, __( 'Display article shadows', "fazzotheme" ) );
			$customizer_settings["display_widget_shadows"]  = $customizer->add_control( "checkbox", "display_widget_shadows", $section_settings, __( 'Display widget shadows', "fazzotheme" ) );
			$customizer_settings["display_content_nav_shadows"]  = $customizer->add_control( "checkbox", "display_content_nav_shadows", $section_settings, __( 'Display content nav shadows', "fazzotheme" ) );

			$js_content = <<<JS

(function ($) {
    function fazzo_linear_gradient(background_image, background_opacity, background_color_top, background_color_bottom, element)
    {
                    var image = wp.customize(background_image).get();
                    if(image)
                        return;
                    var opacity = wp.customize(background_opacity).get();
                    var color_top = wp.customize(background_color_top).get();
                    var color_bottom = wp.customize(background_color_bottom).get();
                    var rgba_top = hexToRgbA(color_top, opacity);
                    var rgba_bottom = hexToRgbA(color_bottom, opacity);
                            
                    var transparent_top = wp.customize(background_color_top+'_transparent').get();
                    if(transparent_top)
                        var value_top = 'transparent';
                    else
                        var value_top = rgba_top;
                    var transparent_bottom = wp.customize(background_color_bottom+'_transparent').get();
                    if(transparent_bottom)
                        var value_bottom = 'transparent';
                    else
                        var value_bottom = rgba_bottom;
                    
                    $(element).css('background-image', 'linear-gradient(to bottom, '+value_top+' 50%, '+value_bottom+' 100%)');
                    $(element).css('background-repeat', 'no-repeat');
    }
    function fazzo_background_size(background_image, element)
    {
			    var size = wp.customize(background_image+'_size').get();
				$(element).css('background-size', size);
    }
    function fazzo_background_repeat(background_image, element)
    {
        		var repeat = wp.customize(background_image+'_repeat').get();
			    if(repeat)
			        repeat = 'repeat';
			    else
			        repeat = 'no-repeat';
				$(element).css('background-repeat', repeat);
    }
    function fazzo_background_attachment(background_image, element)
    {
			    var scroll = wp.customize(background_image+'_scroll').get();
			    if(scroll)
			        scroll = 'scroll';
			    else
			        scroll = 'fixed';
				$(element).css('background-attachment ', scroll);
    }    
    function fazzo_background_position(background_image, element)
    {
                var position_y = wp.customize(background_image+'_position_y').get();
                var position_x = wp.customize(background_image+'_position_x').get();
                $(element).css('background-position', position_x+" "+position_y);
    }    
    function fazzo_color_font(color, element)
    {
    			var transparent_color = wp.customize(color+'_transparent').get();    
    			if(transparent_color)
    			    var color = 'transparent';
    			else
        			var color = wp.customize(color).get();
                $(element).css('color', color);
    }  
    function fazzo_color_border(color, element, opacity)
    {
        		var transparent_color = wp.customize(color+'_transparent').get();    
    			if(transparent_color)
    			    var color = 'transparent';
    			else
    			{
        			
    				var color = wp.customize(color).get();
    				if(opacity != 'null')
    				{
    					var opacity = wp.customize(opacity).get();
    					color = hexToRgbA(color, opacity);
    				}
        		}
        		$(element).css('border-color', color);
    }  
    function fazzo_hide(status, element)
    {
        if(status)
    		$(element).css('display', 'none');
        else
            $(element).css('display', 'inline-block');
    }
    function fazzo_height(height, element)
    {
        		var height = wp.customize(height).get();    
        		$(element).css('min-height', height);
    }  
    
    function fazzo_padding_h(padding, element)
    {
        		var padding = wp.customize(padding).get();    
        		$(element).css('padding-left', padding);
        		$(element).css('padding-right', padding);
    }  
    function fazzo_padding_v(padding, element)
    {
        		var padding = wp.customize(padding).get();    
        		$(element).css('padding-top', padding);
        		$(element).css('padding-bottom', padding);
    }   
    function fazzo_font_size(size, element)
    {
        		var size = wp.customize(size).get();    
        		$(element).css('font-size', size);
    }  
    
        function fazzo_font_size_text(size, element)
    {
        		var size = wp.customize(size).get();    
        		$(element + ' p').css('font-size', size);
        		$(element + ' span').css('font-size', size);
        		$(element + ' a').css('font-size', size);
        		$(element + ' input').css('font-size', size);
        		$(element + ' label').css('font-size', size);
        		$(element + ' i').css('font-size', size);        		
    }  
			
JS;


			foreach ( $customizer_set as $cus_sec ) {

				if ( isset( $cus_sec["height"] ) ) {
					$js_content .= <<<JS
			// CODE FOR {$cus_sec["height"]}:
			wp.customize('{$cus_sec["height"]}', function (value) { value.bind(function (value_set) {
                fazzo_height('{$cus_sec["height"]}','{$cus_sec["element"]}');
			})})
JS;
				}

				if ( isset( $cus_sec["padding_v"] ) ) {
					$js_content .= <<<JS
			// CODE FOR {$cus_sec["padding_v"]}:
			wp.customize('{$cus_sec["padding_v"]}', function (value) { value.bind(function (value_set) {
                fazzo_padding_v('{$cus_sec["padding_v"]}','{$cus_sec["element"]}');
			})})
JS;
				}
				if ( isset( $cus_sec["padding_h"] ) ) {
					$js_content .= <<<JS
			// CODE FOR {$cus_sec["padding_h"]}:
			wp.customize('{$cus_sec["padding_h"]}', function (value) { value.bind(function (value_set) {
                fazzo_padding_h('{$cus_sec["padding_h"]}','{$cus_sec["element"]}');
			})})
JS;
				}

				if ( isset( $cus_sec["font_size"] ) ) {
					$js_content .= <<<JS
			// CODE FOR {$cus_sec["font_size"]}:
			wp.customize('{$cus_sec["font_size"]}', function (value) { value.bind(function (value_set) {
                fazzo_font_size('{$cus_sec["font_size"]}','{$cus_sec["element"]}');
			})})
JS;
				}

				if ( isset( $cus_sec["font_size_text"] ) ) {
					$js_content .= <<<JS
			// CODE FOR {$cus_sec["font_size_text"]}:
			wp.customize('{$cus_sec["font_size_text"]}', function (value) { value.bind(function (value_set) {
                fazzo_font_size_text('{$cus_sec["font_size_text"]}','{$cus_sec["element"]}');
			})})
JS;
				}

				if ( isset( $cus_sec["color_top"], $cus_sec["image"], $cus_sec["opacity"], $cus_sec["color_bottom"] ) ) {
					$js_content .= <<<JS
			// CODE FOR {$cus_sec["color_top"]}:
			wp.customize('{$cus_sec["color_top"]}', function (value) { value.bind(function (value_set) {
                fazzo_linear_gradient('{$cus_sec["image"]}','{$cus_sec["opacity"]}','{$cus_sec["color_top"]}','{$cus_sec["color_bottom"]}','{$cus_sec["element"]}');
			})})
			// CODE FOR {$cus_sec["color_top"]}_transparent:
			wp.customize('{$cus_sec["color_top"]}_transparent', function (value) { value.bind(function (value_set) {
			    fazzo_linear_gradient('{$cus_sec["image"]}','{$cus_sec["opacity"]}','{$cus_sec["color_top"]}','{$cus_sec["color_bottom"]}','{$cus_sec["element"]}');
			})})				
			// CODE FOR {$cus_sec["color_bottom"]}:
			wp.customize('{$cus_sec["color_bottom"]}', function (value) { value.bind(function (value_set) {
			    fazzo_linear_gradient('{$cus_sec["image"]}','{$cus_sec["opacity"]}','{$cus_sec["color_top"]}','{$cus_sec["color_bottom"]}','{$cus_sec["element"]}');
			})})
			// CODE FOR {$cus_sec["color_bottom"]}_transparent:
			wp.customize('{$cus_sec["color_bottom"]}_transparent', function (value) { value.bind(function (value_set) {
			    fazzo_linear_gradient('{$cus_sec["image"]}','{$cus_sec["opacity"]}','{$cus_sec["color_top"]}','{$cus_sec["color_bottom"]}','{$cus_sec["element"]}');
			})})		
			// CODE FOR {$cus_sec["opacity"]}:
			wp.customize('{$cus_sec["opacity"]}', function (value) { value.bind(function (value_set) {
			    fazzo_linear_gradient('{$cus_sec["image"]}','{$cus_sec["opacity"]}','{$cus_sec["color_top"]}','{$cus_sec["color_bottom"]}','{$cus_sec["element"]}');
JS;
					if ( isset( $cus_sec["border_color"] ) ) {
						$js_content .= <<<JS
			    fazzo_color_border('{$cus_sec["border_color"]}', '{$cus_sec["element"]}','{$cus_sec["opacity"]}');
			    fazzo_color_border('{$cus_sec["border_color"]}', '{$cus_sec["element"]} li','{$cus_sec["opacity"]}');
JS;
					}
					$js_content .= <<<JS
})})
JS;

				}


				if ( isset( $cus_sec["image"] ) ) {
					$js_content .= <<<JS
			// CODE FOR {$cus_sec["image"]}_size:
			wp.customize('{$cus_sec["image"]}_size', function (value) { value.bind(function (value_set) {
			    fazzo_background_size('{$cus_sec["image"]}', '{$cus_sec["element"]}');
			})})
			// CODE FOR {$cus_sec["image"]}_repeat:
			wp.customize('{$cus_sec["image"]}_repeat', function (value) { value.bind(function (value_set) {
			    fazzo_background_repeat('{$cus_sec["image"]}', '{$cus_sec["element"]}');
			})})
			// CODE FOR {$cus_sec["image"]}_scroll:
			wp.customize('{$cus_sec["image"]}_scroll', function (value) { value.bind(function (value_set) {
			    fazzo_background_attachment('{$cus_sec["image"]}', '{$cus_sec["element"]}');
			})})
			// CODE FOR {$cus_sec["image"]}_position_x:
			wp.customize('{$cus_sec["image"]}_position_x', function (value) { value.bind(function (value_set) {
			    fazzo_background_position('{$cus_sec["image"]}', '{$cus_sec["element"]}');
			})})
			// CODE FOR {$cus_sec["image"]}_position_y:
			wp.customize('{$cus_sec["image"]}_position_y', function (value) { value.bind(function (value_set) {
			    fazzo_background_position('{$cus_sec["image"]}', '{$cus_sec["element"]}');
			})})	
JS;
				}
				if ( isset( $cus_sec["font_color"] ) ) {
					$js_content .= <<<JS
			// CODE FOR {$cus_sec["font_color"]}:
			wp.customize('{$cus_sec["font_color"]}', function (value) { value.bind(function (value_set) {
			    fazzo_color_font('{$cus_sec["font_color"]}', '{$cus_sec["element"]}');
			})})	
			// CODE FOR {$cus_sec["font_color"]}_transparent:
			wp.customize('{$cus_sec["font_color"]}_transparent', function (value) { value.bind(function (value_set) {
			    fazzo_color_font('{$cus_sec["font_color"]}', '{$cus_sec["element"]}');
			})})	
JS;
				}

				if ( isset( $cus_sec["link_font_color"] ) ) {
					$js_content .= <<<JS
			// CODE FOR {$cus_sec["link_font_color"]}:
			wp.customize('{$cus_sec["link_font_color"]}', function (value) { value.bind(function (value_set) {
			    fazzo_color_font('{$cus_sec["link_font_color"]}', '{$cus_sec["element"]} a');
			})})	
			// CODE FOR {$cus_sec["link_font_color"]}_transparent:
			wp.customize('{$cus_sec["link_font_color"]}_transparent', function (value) { value.bind(function (value_set) {
			    fazzo_color_font('{$cus_sec["link_font_color"]}', '{$cus_sec["element"]} a');
			})})			
JS;
				}

				if ( isset( $cus_sec["link_hover_font_color"] ) ) {
					$js_content .= <<<JS
			// CODE FOR {$cus_sec["link_hover_font_color"]}:
			wp.customize('{$cus_sec["link_hover_font_color"]}', function (value) { value.bind(function (value_set) {
			    fazzo_color_font('{$cus_sec["link_hover_font_color"]}', '{$cus_sec["element"]} a:hover');
			})})	
			// CODE FOR {$cus_sec["link_hover_font_color"]}_transparent:
			wp.customize('{$cus_sec["link_hover_font_color"]}_transparent', function (value) { value.bind(function (value_set) {
			    fazzo_color_font('{$cus_sec["link_hover_font_color"]}', '{$cus_sec["element"]} a:hover');
			})})			
JS;
				}

				if ( isset( $cus_sec["border_color"] ) && isset( $cus_sec["opacity"] ) ) {
					$js_content .= <<<JS

			// CODE FOR {$cus_sec["border_color"]}:
			wp.customize('{$cus_sec["border_color"]}', function (value) { value.bind(function (value_set) {
			    fazzo_color_border('{$cus_sec["border_color"]}', '{$cus_sec["element"]}','{$cus_sec["opacity"]}');
			    fazzo_color_border('{$cus_sec["border_color"]}', '{$cus_sec["element"]} li','{$cus_sec["opacity"]}');
			})})	
			// CODE FOR {$cus_sec["border_color"]}_transparent:
			wp.customize('{$cus_sec["border_color"]}_transparent', function (value) { value.bind(function (value_set) {
			    fazzo_color_border('{$cus_sec["border_color"]}', '{$cus_sec["element"]}','{$cus_sec["opacity"]}');
			    fazzo_color_border('{$cus_sec["border_color"]}', '{$cus_sec["element"]} li','{$cus_sec["opacity"]}');
			})})				
JS;
				} elseif ( isset( $cus_sec["border_color"] ) ) {
					$js_content .= <<<JS

			// CODE FOR {$cus_sec["border_color"]}:
			wp.customize('{$cus_sec["border_color"]}', function (value) { value.bind(function (value_set) {
			    fazzo_color_border('{$cus_sec["border_color"]}', '{$cus_sec["element"]}','null');
			    fazzo_color_border('{$cus_sec["border_color"]}', '{$cus_sec["element"]} li','null');
			})})	
			// CODE FOR {$cus_sec["border_color"]}_transparent:
			wp.customize('{$cus_sec["border_color"]}_transparent', function (value) { value.bind(function (value_set) {
			    fazzo_color_border('{$cus_sec["border_color"]}', '{$cus_sec["element"]}','null');
			    fazzo_color_border('{$cus_sec["border_color"]}', '{$cus_sec["element"]} li','null');
			})})				
JS;
				}
			}

			$js_content .= <<<JS

})(jQuery);		

JS;
			wp_register_script( 'dummy-handle-footer', '', [ "fazzo-theme-customizer-pre-js" ], static ::version, true );
			wp_enqueue_script( 'dummy-handle-footer' );
			wp_add_inline_script( 'dummy-handle-footer', $js_content, 'after' );


		}

		/**
		 * Get Theme Mod
		 *
		 * @param string $id Der Keyname
		 *
		 * @return mixed
		 * @since  1.0.0
		 * @access public
		 */
		public
		static function get_mod(
			$id
		) {

			if ( ! isset( static::$customizer_elements[ static::$prefix . $id ] ) ) {
				return false;
			}

			return get_theme_mod( static::$prefix . $id, static::$customizer_elements[ static::$prefix . $id ] );
		}

		/**
		 * Customizer Live CSS generation
		 * @return void
		 * @since  1.0.0
		 * @access public
		 */
		public
		function customizer_css() {

			$prefix = static::$prefix;

			$style = "";

			$elements = [
				""      => "#body_overlay",
				"_body" => "body",
				"_head" => "#sec_head",

				"_nav_top"           => [ "#sec_head_meta", "#sec_head_meta .dropdown-menu" ],
				"_nav_head"          => "#sec_head_nav",
				"_nav_head_dropdown" => [ "#sec_head_nav .dropdown-menu" ],
				"_nav_content"       => [ "#wrap_content_nav", "#wrap_content_nav .dropdown-menu" ],
				"_nav_footer"        => [ "#sec_foot_nav", "#sec_foot_nav .dropdown-menu" ],

				"_content_head"             => "#head-title",
				"_content_head_description" => "#head-description span",
				"_foot_text"                => "#sec_foot_text",
				"_widget"                   => ".widget",
				"_content"                  => "article",
			];

			$elements_hover = [
				"_nav_top_hover"     => "#wrap_top_nav",
				"_nav_head_hover"    => "#sec_head_nav",
				"_nav_content_hover" => "#wrap_content_nav",
				"_nav_footer_hover"  => "#sec_foot_nav",
			];

			foreach ( $elements as $element => $css ) {

				$style .= customizer::live_css_font( "font" . $element, "color", $css );
				$style .= customizer::live_css_font( "font" . $element, "color", $css, "caption" );
				$style .= customizer::live_css_font( "link_font" . $element, "color", $css, "a" );
				$style .= customizer::live_css_font( "link_hover_font" . $element, "color", $css, "a:hover" );
				$style .= customizer::live_css_font( "link_hover_font" . $element, "color", $css, "li.active a" );
				$style .= customizer::live_css_font( "link_hover_font" . $element, "color", $css, "li.current-menu-ancestor a" );
				$style .= customizer::live_css_border( "border" . $element, "border-color", $css, "background" . $element );
				$style .= customizer::live_css_border( "border" . $element, "border-color", $css, "background" . $element, "li" );
				$style .= customizer::live_css_background( "background" . $element, $css );
			}

			foreach ( $elements_hover as $element => $css ) {
				$style .= customizer::live_css_border( "border" . $element, "border-color", $css, "background" . $element, "a:hover" );
				$style .= customizer::live_css_background( "background" . $element, $css, "a:hover" );
			}
			$style .= customizer::live_css_border( "border_nav_head_dropdown_hover", "border-color", "#sec_head_nav .dropdown-menu", "background" . $element, "li:hover" );
			$style .= customizer::live_css_background( "background_nav_head_dropdown_hover", "#sec_head_nav .dropdown-menu", "li:hover" );

			$style .= customizer::live_css_font( "font_content", "color", "#wrap_content_output h1" );
			$style .= customizer::live_css_font( "font_content", "color", "#wrap_content_output h2" );
			$style .= customizer::live_css_font( "font_content", "color", "#wrap_content_output h3" );

			$style .= customizer::live_css_font( "link_font_nav_top", "color", "#wrap_top_search", "i::before" );
			$style .= customizer::live_css_font( "link_font_nav_top", "color", "#wrap_top_search", "input" );
			$style .= customizer::live_css_font( "link_font_nav_top", "color", "#wrap_top_search", "input::placeholder" );
			$style .= customizer::live_css_font( "link_hover_font_nav_top", "color", "#wrap_top_search", ".search-button-wrapper:hover i::before" );
			$style .= customizer::live_css_background( "background_nav_head_dropdown", ".offcanvas-collapse", "", "576px" );
			$style .= customizer::live_css_height( "head_height", "#sec_head_content" );
			$style .= customizer::live_css_height( "content_height", "#wrap_content_output" );
			$style .= customizer::live_css_height( "footer_height", "#wrap_foot_widget" );

			$style .= customizer::live_css_padding_h( "top_padding_h", "#menu-meta-top li a" );
			$style .= customizer::live_css_padding_v( "top_padding_v", "#menu-meta-top li a" );
			$style .= customizer::live_css_padding_v( "top_padding_v", "#wrap_top_search input" );
			$style .= customizer::live_css_padding_v( "top_padding_v", "#wrap_top_search i" );
			$style .= customizer::live_css_padding_h( "main_nav_padding_h", "#meta-head-nav ul li a" );
			$style .= customizer::live_css_padding_v( "main_nav_padding_v", "#meta-head-nav ul li a" );
			$style .= customizer::live_css_padding_h( "footer_nav_padding_h", "#meta-bottom-nav ul li a" );
			$style .= customizer::live_css_padding_v( "footer_nav_padding_v", "#meta-bottom-nav ul li a" );
			$style .= customizer::live_css_padding_v( "footer_text_padding_v", "#wrap_foot_text" );

			$style .= customizer::live_css_font_size_text( "top_font_size", "#sec_head_meta" );
			$style .= customizer::live_css_font_size_text( "head_content_header_font_size", "#head-title" );
			$style .= customizer::live_css_font_size_text( "head_content_font_size", "#head-description" );
			$style .= customizer::live_css_font_size_text( "main_nav_font_size", "#sec_head_nav" );
			$style .= customizer::live_css_font_size_text( "content_nav_font_size", "#wrap_content_nav" );
			$style .= customizer::live_css_font_size_text( "foot_nav_font_size", "#wrap_foot_nav" );
			$style .= customizer::live_css_font_size_text( "content_font_size", "#wrap_content_output" );
			$style .= customizer::live_css_font_size( "content_h1_font_size", "#wrap_content_output h1" );
			$style .= customizer::live_css_font_size( "content_h2_font_size", "#wrap_content_output h2" );
			$style .= customizer::live_css_font_size( "content_h3_font_size", "#wrap_content_output h3" );
			$style .= customizer::live_css_font_size_text( "widget_font_size", ".widget" );
			$style .= customizer::live_css_font_size( "widget_header_font_size", ".widget h1" );
			$style .= customizer::live_css_font_size( "footer_text_font_size", "#wrap_foot_text" );

			if ( isset( static::$customizer_elements[ $prefix . "add_space" ] ) ) {
				if ( $this->get_mod( "add_space" ) ) {
					$style .= <<<CSS
article, .widget {
	padding: 12px;
}
.widget {
	margin-left: 12px;
	margin-right: 12px;
}
CSS;
				}
			}

			if ( isset( static::$customizer_elements[ $prefix . "display_shadows" ] ) && $this->get_mod( "display_shadows" ) ) {
				$style .= <<<CSS
#sec_head_nav, #sec_head_meta, #sec_foot_nav, #sec_foot_text {
  box-shadow: 0px 3px 14px 0px rgba(0,0,0,0.75);
}

CSS;

				if ( isset( static::$customizer_elements[ $prefix . "display_content_nav_shadows" ] ) && $this->get_mod( "display_content_nav_shadows" ) ) {
					$style .= <<<CSS
#wrap_content_nav {
  box-shadow: 3px 0px 14px 0px rgba(0,0,0,0.35), -3px 0px 14px 0px rgba(0,0,0,0.35);
}
CSS;
				}

				if ( isset( static::$customizer_elements[ $prefix . "display_article_shadows" ] ) && $this->get_mod( "display_article_shadows" ) ) {
					$style .= <<<CSS
article {
  box-shadow: 3px 0px 5px 0px rgba(0,0,0,0.2), -3px 0px 5px 0px rgba(0,0,0,0.2), 0px 3px 5px 0px rgba(0,0,0,0.2), 0px -3px 5px 0px rgba(0,0,0,0.2);
}
CSS;
				}
				if ( isset( static::$customizer_elements[ $prefix . "display_widget_shadows" ] ) && $this->get_mod( "display_widget_shadows" ) ) {
					$style .= <<<CSS
.widget {
  box-shadow: 3px 0px 5px 0px rgba(0,0,0,0.2), -3px 0px 5px 0px rgba(0,0,0,0.2), 0px 3px 5px 0px rgba(0,0,0,0.2), 0px -3px 5px 0px rgba(0,0,0,0.2);
}
CSS;
				}
				$style .= <<<CSS
#head-title {
  text-shadow: 2px 2px 2px rgba(0,0,0,0.6);
}
CSS;
				if ( isset( static::$customizer_elements[ $prefix . "round_corners" ] ) && $this->get_mod( "round_corners" ) ) {
					$style .= <<<CSS
#sec_head_nav, #sec_head_meta, #sec_foot_nav, #sec_foot_text{
  box-shadow: 3px 0px 5px 0px rgba(0,0,0,0.2), -3px 0px 5px 0px rgba(0,0,0,0.2), 0px 3px 5px 0px rgba(0,0,0,0.2), 0px -3px 5px 0px rgba(0,0,0,0.2);
}
CSS;
					if ( isset( static::$customizer_elements[ $prefix . "display_content_nav_shadows" ] ) && $this->get_mod( "display_content_nav_shadows" ) ) {
						$style .= <<<CSS
#wrap_content_nav {
  box-shadow: 3px 0px 5px 0px rgba(0,0,0,0.2), -3px 0px 5px 0px rgba(0,0,0,0.2), 0px 3px 5px 0px rgba(0,0,0,0.2), 0px -3px 5px 0px rgba(0,0,0,0.2);
}
CSS;
					}

					if ( isset( static::$customizer_elements[ $prefix . "display_article_shadows" ] ) && $this->get_mod( "display_article_shadows" ) ) {
						$style .= <<<CSS
article {
  box-shadow: 3px 0px 5px 0px rgba(0,0,0,0.2), -3px 0px 5px 0px rgba(0,0,0,0.2), 0px 3px 5px 0px rgba(0,0,0,0.2), 0px -3px 5px 0px rgba(0,0,0,0.2);
}
CSS;
					}
					if ( isset( static::$customizer_elements[ $prefix . "display_widget_shadows" ] ) && $this->get_mod( "display_widget_shadows" ) ) {
						$style .= <<<CSS
.widget {
  box-shadow: 3px 0px 5px 0px rgba(0,0,0,0.2), -3px 0px 5px 0px rgba(0,0,0,0.2), 0px 3px 5px 0px rgba(0,0,0,0.2), 0px -3px 5px 0px rgba(0,0,0,0.2);
}
CSS;
					}
				}
			}


			$_nav_content_border_color = customizer::live_border_color( "border_nav_content_color", "background_nav_content" );
			if ( $_nav_content_border_color ) {
				$style .= <<<CSS
#wrap_content_nav {
	border-left: 1px solid $_nav_content_border_color;
	border-right: 1px solid $_nav_content_border_color;
}
CSS;
			}

			$center_content = false;
			if ( isset( static::$customizer_elements[ $prefix . "center_content" ] ) ) {
				if ( $this->get_mod( "center_content" ) ) {
					$center_content = true;
					$style          .= <<<CSS

.wrap_cm {
  max-width: 900px;
}
CSS;
				}
			}

			if ( isset( static::$customizer_elements[ $prefix . "round_corners" ] ) ) {

				if ( $this->get_mod( "round_corners" ) ) {

					$border_radius = "12px";
					if ( isset( static::$customizer_elements[ $prefix . "border_radius" ] ) ) {
						$border_radius = $this->get_mod( "border_radius" );
					}

					$style .= <<<CSS

article, .widget, #sec_content img {
	border-radius: {$border_radius};
}
#wrap_content_nav, .dropdown-menu  {
	border-bottom-left-radius: {$border_radius};
	border-bottom-right-radius: {$border_radius};
}

article .thumbnail-background {
	border-top-left-radius: {$border_radius};
	border-top-right-radius: {$border_radius};
}

CSS;

					if ( $center_content || true ) {

						$_nav_top_border_color  = customizer::live_border_color( "border_nav_top_color", "background" . "_nav_top" );
						$_nav_head_border_color = customizer::live_border_color( "border_nav_head_color", "background" . "_nav_head" );

						$_nav_footer_border_color = customizer::live_border_color( "border_nav_footer_color", "background" . "_nav_footer" );
						$_foot_text_border_color  = customizer::live_border_color( "border_foot_text_color", "background" . "_foot_text" );

						$style .= <<<CSS

#sec_head_nav, #sec_foot_nav, #sec_head_meta, #sec_foot_text  {
	border-radius: {$border_radius};
}

#wrap_content_nav {
	margin-left: 6px;
	border-top-left-radius: {$border_radius};
	border-top-right-radius: {$border_radius};
	margin-top: 12px;
	margin-bottom: 12px;
	border-top: 1px solid {$_nav_content_border_color};
	border-bottom: 1px solid {$_nav_content_border_color};
}

#sec_head_meta, #sec_head_nav, #sec_foot_nav, #sec_foot_text, .widget {
	margin-left: 6px;
	margin-right: 6px;
}

#sec_head_meta, #sec_head_meta .dropdown-menu {
	border: 1px solid {$_nav_top_border_color};
}

#sec_head_nav, #sec_head_nav .dropdown-menu {
	border: 1px solid {$_nav_head_border_color};
}

#sec_head_nav .dropdown-menu a:last-child {
	border-bottom-left-radius: {$border_radius};
	border-bottom-right-radius: {$border_radius};
}

#wrap_content_nav li:first-child a {
	border-top-left-radius: {$border_radius};
	border-top-right-radius: {$border_radius};
}

#sec_foot_nav, #sec_foot_nav .dropdown-menu {
	border: 1px solid {$_nav_footer_border_color};
}

#sec_foot_text{
	border: 1px solid {$_foot_text_border_color};
}


#sec_foot_text {
	margin-bottom: 6px;
}

#sec_head_meta {
	margin-top: 6px;
}


CSS;


					}
				}


			}


			functions::minimize_string( $style );

			echo "<style>" . $style . "</style>";
		}
	}
}