<?php

namespace fazzo;

use Exception;

$dir_root = dirname(__FILE__) . "/../";
require_once($dir_root . "security.php");


$fazzo_require_subdirs = ["widgets", "customizer", "extra"];

foreach ($fazzo_require_subdirs as $fazzo_require_subdir) {

    $path = dirname(__FILE__) . "/" . $fazzo_require_subdir . "/";
    if (is_dir($path)) {
        $files = scandir($path);
        if (!empty($files) && is_array($files)) {
            foreach ($files as $filename) {
                $path = dirname(__FILE__) . "/" . $fazzo_require_subdir . '/' . $filename;

                if (is_file($path)) {

                    require_once $path;
                }
            }
        }
    }
}

// Aktionen, wenn das Plugin aktiviert, bzw. deaktiviert wird:
register_activation_hook(__FILE__, ['fazzo', 'activation']);
register_deactivation_hook(__FILE__, ['fazzo', 'deactivation']);

if (!class_exists('\fazzo\fazzo')) {

    /*
     * FAZZO-Theme-Haupt-Klasse
     */

    class fazzo
    {

        /**
         * Name der Variable unter der die Einstellungen des Plugins gespeichert werden.
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
        const version = '0.0.0';

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
        const wp_version = '5.2.3';

        /**
         * Optionen des Plugins
         * @since  1.0.0
         * @access public
         * @var array
         */
        public static $options;

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
        public static function instance()
        {
            if (null == self::$instance) {
                self::$instance = new self;
            }

            return self::$instance;
        }

        /**
         * Customizer Default Werte
         * @since  1.0.0
         * @access public
         * @var array
         * @static
         */
        public static $customizer_defaults = [
            "head_full_wrapper_display" => true,
            "head_top_right_wrapper_display" => true,
            "head_middle_full_wrapper_display" => true,
            "head_description_display" => true,
            "post_nav_display" => true,

            "fazzo_background_color" => "#fefefe",
            "fazzo_background_opacity" => 0.6,
            "fazzo_background_image" => "",

            "fazzo_main_menu_color" => "#CCCCCC",
            "fazzo_main_menu_color2" => "#333333",
            "fazzo_main_menu_border_color" => "#dddddd",
            "fazzo_main_menu_opacity" => "1",
        ];

        /**
         * PHP constructor.
         * @since  1.0.0
         * @access public
         */
        private function __construct()
        {
            // Sprachdateien werden eingebunden:
            self::load_textdomain();

            // Erhalte die Einstellungen zum Plugin:
            self::get_options();

            // Aktualisierung des Plugins (ggf):
            self::update_plugin();

            // Customizer
            add_action('customize_preview_init', [$this, 'customizer_preview']);
            add_action('customize_register', [$this, 'customizer_register']);
            add_action('wp_head', [$this, 'customizer_css']);

            // Enable Builtin Options
            add_theme_support("post-thumbnails");
            add_theme_support("custom-header");
            add_theme_support('title-tag');
            add_theme_support('html5', [
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
            ]);
            add_theme_support('post-formats', [
                'image',
                'video',
                'gallery',
                'audio',
            ]);
            add_theme_support('customize-selective-refresh-widgets');

            // Menüs des Themes
            add_action("after_setup_theme", [$this, "register_menus"]);

            // Sidebars aktivieren
            add_action('widgets_init', [$this, 'register_sidebars']);

            // Scripte einbinden
            add_action("admin_enqueue_scripts", [$this, "load_admin_scripts"]);
            add_action("wp_enqueue_scripts", [$this, "load_frontend_scripts"]);

            // Nav Link CSS Manipulation
            add_filter('next_posts_link_attributes', [$this, 'nav_link_attributes']);
            add_filter('previous_posts_link_attributes', [$this, "nav_link_attributes"]);

            // Excerpt Manipulation
            add_filter('excerpt_length', [$this, 'new_excerpt_length']);
            add_filter('excerpt_more', [$this, 'new_excerpt_more']);

            // Shortcode
            add_shortcode('fazzo-year', [$this, "shortcode_year"]);
            add_shortcode('fazzo-title', [$this, "shortcode_blog_title"]);
            add_shortcode('fazzo-description', [$this, "shortcode_blog_description"]);

            // additional image sizes
            add_image_size('fazzo-featured-image', 9999, 330);
            add_image_size('fazzo-nav-image', 9999, 20);

            // Custom Widgets
            add_action('widgets_init', [$this, 'register_widgets']);

            // Zeige diese Optionsseite nur an, wenn der User die Rechte dazu hat:
            if (current_user_can('manage_options')) {
                // Zeige Optionsseite an
                add_action('admin_menu', [$this, 'settings_page']);
            }

	        // Metaboxen
	        add_action( "add_meta_boxes", [ $this, "register_meta_boxes" ] );


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
        public static function activation($network_wide)
        {
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
        public static function deactivation($network_wide)
        {
            self::delete_options();
        }

        /**
         * Einbindung der Sprachdateien
         * @return void
         * @since  1.0.0
         * @access protected
         * @static
         */
        protected static function load_textdomain()
        {
            load_plugin_textdomain(FAZZO_THEME_TXT, false, sprintf('%s/lang/', dirname(plugin_basename(__FILE__))));
        }


        /**
         * Überprüft die minimal erforderliche PHP- u. WP-Version
         * @return void
         * @since  1.0.0
         * @access protected
         * @static
         */
        protected static function check_system_requirements()
        {
            $error = '';

            if (version_compare(PHP_VERSION, self::php_version, '<')) {
                $error = sprintf(__('FAZZO-Theme: Your server is running PHP version %s. Please upgrade at least to PHP version %s.', FAZZO_THEME_TXT), PHP_VERSION, self::wp_version);
            }

            if (version_compare($GLOBALS['wp_version'], self::wp_version, '<')) {
                $error = sprintf(__('FAZZO-Theme: Your Wordpress version is %s. Please upgrade at least to Wordpress version %s.', FAZZO_THEME_TXT), $GLOBALS['wp_version'], self::wp_version);
            }

            if (!empty($error)) {
                deactivate_plugins(plugin_basename(__FILE__), false, true);
                wp_die($error);
            }
        }


        /**
         * Aktualisiere Plugin, wenn nötig
         * @return void
         * @since  1.0.0
         * @access protected
         * @static
         */
        private static function update_plugin()
        {
            $version_stored = get_option(static::version_option_name, '0');

            if (version_compare($version_stored, static::version, '<')) {
                // Führe Update durch:
                update_option(static::version_option_name, static::version);
            }
        }

        /**
         * Löscht alle Einstellungen
         * @return void
         * @since  1.0.0
         * @access protected
         * @static
         */
        protected static function delete_options()
        {
            delete_option(static::option_name);
            delete_option(self::version_option_name);
        }


        /**
         * Setzt die Einstellungen und Eigenschaften, mit Berücksichtung auf Default Einstellungen
         * @return void
         * @since  1.0.0
         * @access protected
         * @static
         */
        protected static function get_options()
        {

            $defaults = static::default_options();

            $options = get_option(static::option_name);
            if ($options === false) {
                $options = [];
            }

            functions::parse_args_multidim($options, $defaults);

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
        private static function default_options()
        {
            // Multidimensionales Array ist möglich:
            $options = ["load_bootstrap" => 1];
            $options = ["paged_menu" => 0];

            return $options;
        }

        /**
         * Setzt die Eigenschaften der Klasse
         * @return void
         * @since  1.0.0
         * @access protected
         * @static
         */
        protected static function set_class_properties()
        {

            if (isset(static::$options["customizer_default_values"]) && !empty(static::$options["customizer_default_values"])) {
                static::$customizer_defaults = static::$options["customizer_default_values"];
            }
        }


        /**
         * Die Menü Positionen des Themes bekannt geben
         * @return void
         * @since  1.0.0
         * @access public
         */
        public function register_menus()
        {
            register_nav_menu("meta-bottom-nav", "Bottom-Menu");
            register_nav_menu("meta-content-nav", "Content-Menu");
            register_nav_menu("meta-frontpage-nav", "Frontpage-Menu");
            register_nav_menu("meta-head-nav", "Head-Menu");
            register_nav_menu("meta-top-nav", "Top-Menu");
        }


        /**
         * Sidebars für die Startseite aktivieren
         * @return void
         * @since  1.0.0
         * @access public
         */
        public function register_sidebars()
        {

            // Bottom

            register_sidebar([
                'name' => __('Bottom A', FAZZO_THEME_TXT),
                'id' => 'fazzo-sidebar-bottom-a',
                'description' => __('Bottom Sidebar', FAZZO_THEME_TXT),
                'before_widget' => '<div id="%1$s" class="widget sidebar-bottom %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h1 class="widget-title">',
                'after_title' => '</h1>',
            ]);

            register_sidebar([
                'name' => __('Bottom B', FAZZO_THEME_TXT),
                'id' => 'fazzo-sidebar-bottom-b',
                'description' => __('Bottom Sidebar', FAZZO_THEME_TXT),
                'before_widget' => '<div id="%1$s" class="widget sidebar-bottom %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h1 class="widget-title">',
                'after_title' => '</h1>',
            ]);

            register_sidebar([
                'name' => __('Bottom C', FAZZO_THEME_TXT),
                'id' => 'fazzo-sidebar-bottom-c',
                'description' => __('Bottom Sidebar', FAZZO_THEME_TXT),
                'before_widget' => '<div id="%1$s" class="widget sidebar-bottom %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h1 class="widget-title">',
                'after_title' => '</h1>',
            ]);

            // Content

            register_sidebar([
                'name' => __('Content', FAZZO_THEME_TXT),
                'id' => 'fazzo-sidebar-content',
                'description' => __('Content Sidebar', FAZZO_THEME_TXT),
                'before_widget' => '<div id="%1$s" class="widget sidebar-content %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h1 class="widget-title">',
                'after_title' => '</h1>',
            ]);


            // Frontpage

            register_sidebar([
                'name' => __('Frontpage', FAZZO_THEME_TXT),
                'id' => 'fazzo-sidebar-frontpage',
                'description' => __('Frontpage Sidebar', FAZZO_THEME_TXT),
                'before_widget' => '<div id="%1$s" class="widget sidebar-frontpage %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h1 class="widget-title">',
                'after_title' => '</h1>',
            ]);


            // Head

            register_sidebar([
                'name' => __('Head', FAZZO_THEME_TXT),
                'id' => 'fazzo-sidebar-head',
                'description' => __('Head Sidebar', FAZZO_THEME_TXT),
                'before_widget' => '<div id="%1$s" class="widget sidebar-head %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h1 class="widget-title">',
                'after_title' => '</h1>',
            ]);


            // Top

            register_sidebar([
                'name' => __('Top', FAZZO_THEME_TXT),
                'id' => 'fazzo-sidebar-top',
                'description' => __('Top Sidebar', FAZZO_THEME_TXT),
                'before_widget' => '<div id="%1$s" class="widget sidebar-top %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h1 class="widget-title">',
                'after_title' => '</h1>',
            ]);


        }


        /**
         * Scripte und CSS laden - Admin Bereich
         * @return void
         * @since  1.0.0
         * @access public
         */
        public function load_admin_scripts()
        {
	        // Add the wordpress color picker
	        wp_enqueue_style( 'wp-color-picker' );
	        wp_enqueue_script( 'wp-color-picker');
	        wp_enqueue_script( "fazzo-admin-js", get_template_directory_uri() . "/js/admin.js", ["wp-color-picker"], static::version, true );
        }


        /**
         * Scripte und CSS laden - Frontend Bereich
         * @return void
         * @since  1.0.0
         * @access public
         */
        public function load_frontend_scripts()
        {
            if (!is_customize_preview()) {
                wp_enqueue_script("fazzo-jquery", get_template_directory_uri() . "/ext/jquery/jquery-3.4.1.min.js", [], "3.4.1", true);
            }

            wp_enqueue_script("fazzo-jquery-ui-js", get_template_directory_uri() . "/ext/jquery/jquery-ui-1.12.1.custom/jquery-ui.min.js", ["fazzo-jquery"], "1.12.1", true);
            //wp_enqueue_script( "fazzo-jquery-migrate-js", get_template_directory_uri() . "/ext/jquery/migrate/jquery-migrate-1.4.1.min.js", [ "fazzo-jquery" ], "1.12.1", true );


            wp_enqueue_script("fazzo-popmotion", get_template_directory_uri() . "/ext/popmotion/popmotion.global.min.js", ["fazzo-jquery"], static::version, true);

            if (functions::is_true(static::$options["load_bootstrap"])) {
                wp_enqueue_script("fazzo-popper", get_template_directory_uri() . "/ext/bootstrap/popper-1.14.7/popper.min.js", ["fazzo-jquery"], "1.14.7", true);
                wp_enqueue_script("fazzo-bootstrap-js", get_template_directory_uri() . "/ext/bootstrap/bootstrap-4.3.1-dist/js/bootstrap.min.js", ["fazzo-popper"], "4.4.1", true);
                //wp_enqueue_script( "fazzo-offcanvas-js", get_template_directory_uri() . "/ext/bootstrap/offcanvas-2.5.2/dist/js/bootstrap.offcanvas.min.js", [ "fazzo-bootstrap-js" ], "2.5.2", true );
                wp_enqueue_script("fazzo-js", get_template_directory_uri() . "/js/page.js", ["fazzo-bootstrap-js"], static::version, true);
            } else {
                wp_enqueue_script("fazzo-js", get_template_directory_uri() . "/js/page.js", ["fazzo-jquery"], static::version, true);
            }


            wp_enqueue_style("fazzo-font-awesome", get_template_directory_uri() . "/ext/fonts/fontawesome-free-5.9.0-web/css/all.min.css", [], "5.9.0", 'all');
            wp_enqueue_style("fazzo-jquery-ui-css", get_template_directory_uri() . "/ext/jquery/jquery-ui-1.12.1.custom/jquery-ui.min.css", ["fazzo-font-awesome"], '1.12.1', 'all');

            if (functions::is_true(static::$options["load_bootstrap"])) {
                wp_enqueue_style("fazzo-bootstrap-css", get_template_directory_uri() . "/ext/bootstrap/bootstrap-4.3.1-dist/css/bootstrap.min.css", ["fazzo-jquery-ui-css"], '4.4.1', 'all');
                //wp_enqueue_style( "fazzo-offcanvas-css", get_template_directory_uri() . "/ext/bootstrap/offcanvas-2.5.2/dist/css/bootstrap.offcanvas.min.css", [ "fazzo-bootstrap-css" ], '2.5.2', 'all' );
                wp_enqueue_style("fazzo-style", get_template_directory_uri() . "/css/style.css", ["fazzo-bootstrap-css"], static::version, 'all');
            } else {
                wp_enqueue_style("fazzo-style", get_template_directory_uri() . "/css/style.css", ["fazzo-jquery-ui-css"], static::version, 'all');
            }

            wp_enqueue_style("fazzo-print", get_template_directory_uri() . "/css/print.css", ["fazzo-style"], static::version, 'print');

        }


        /**
         * CSS Klasse für die Navigation durch Seiten setzen
         * @return string
         * @since  1.0.0
         * @access public
         */
        public function nav_link_attributes()
        {
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
        public function new_excerpt_length($length)
        {
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
        public function new_excerpt_more($more)
        {
            global $post;
            $fade_out = "...";
            $content = "";
            $content .= " <a href='" . get_permalink($post->ID) . "' class='read-more-link'>$fade_out <span class='read-more'></span><span class='read-more-hover' style='display:none;'> </span></a>";

            return $content;
        }


        /**
         * Shortcode: Aktuelles Jahr anzeigen
         *
         * @param array $atts Attribute
         * @param string $content Inhalt
         * @param string $tag Tags
         *
         * @return string
         * @since  1.0.0
         * @access public
         *
         */
        public function shortcode_year($atts = [], $content = null, $tag = '')
        {
            return date("Y");
        }

        /**
         * Shortcode: Blog Titel anzeigen
         *
         * @param array $atts Attribute
         * @param string $content Inhalt
         * @param string $tag Tags
         *
         * @return string
         * @since  1.0.0
         * @access public
         *
         */
        public function shortcode_blog_title($atts = [], $content = null, $tag = '')
        {
            return get_bloginfo("name");
        }

        /**
         * Shortcode: Beschreibung anzeigen
         *
         * @param array $atts Attribute
         * @param string $content Inhalt
         * @param string $tag Tags
         *
         * @return string
         * @since  1.0.0
         * @access public
         *
         */
        public function shortcode_blog_description($atts = [], $content = null, $tag = '')
        {
            return get_bloginfo("description");
        }


        /**
         * Registriere neue Widgets
         * @return void
         * @since  1.0.0
         * @access public
         */
        public function register_widgets()
        {
            //register_widget( 'fazzo_widget_tax_menu' );
        }


        /**
         * Dummy Funktion
         * @return void
         * @since  1.0.0
         * @access public
         */
        public function dummy_callback()
        {
        }

        /**
         * Speichert die Plugin Optionen und frischt die Klassen Eigenschaften auf
         * @return void
         * @since  1.0.0
         * @access protected
         * @static
         */
        protected static function save_options()
        {
            update_option(static::option_name, static::$options);

            // Initialisiere Eigenschaften
            static::set_class_properties();
        }


        /**
         * Bindet das Navigationstemplate ein
         * @return void
         * @since  1.0.0
         * @access public
         */
        public static function get_comments_navigation()
        {
            if (get_comment_pages_count() > 1 && get_option('page_comments')) {

                get_template_part('templ/nav', 'comments');

            }
        }

        /**
         * Bindet das Navigationstemplate ein
         * @return void
         * @since  1.0.0
         * @access public
         */
        public function get_posts_navigation()
        {
            if (get_comment_pages_count() > 1 && get_option('page_comments')) {

                get_template_part('templ/nav', 'posts');

            }
        }

        /**
         * Füge eine Optionsseite hinzu
         * @return void
         * @since  1.0.0
         * @access public
         */
        public function settings_page()
        {
            // Argumente:
            $menu_slug = 'lnt';
            $parent_slug = "admin.php?page=" . $menu_slug;
            $page_title = esc_html__('Page Config', FAZZO_THEME_TXT);
            $menu_title = esc_html__('Config', FAZZO_THEME_TXT);
            $capability = 'manage_options';
            $post_type = "toplevel";
            $function = [$this, 'settings_page_display'];

            $icon_url = 'dashicons-networking';
            $position = 80;

            // Definiere Einstellungen zu dieser Seite für spätere Verwendung:
            define('FAZZO_SETTINGS_PAGE', $parent_slug);
            define('FAZZO_SETTINGS_HOOK', $post_type . '_page_' . $menu_slug);
            define('FAZZO_SETTINGS_SLUG', $menu_slug);

            // Füge Seite hinzug
            add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);
        }

        /**
         * Ausgabe der Optionsseite, welche auch die gesendeten Formulardaten speichert
         * @return void
         * @since  1.0.0
         * @access public
         */
        public function settings_page_display()
        {
            // Security:
            $nonce_name = "fazzo_configuration_nonce";
            $nonce_input_key = "fazzo-configuration-nonce";
            $nonce_value = wp_create_nonce($nonce_name);
            $form_action_url = admin_url(FAZZO_SETTINGS_PAGE);

            // Speichern
            if (functions::validate_nonce($nonce_input_key, $nonce_name)) {
                if (isset($_POST['todo']) && $_POST['todo'] == "config") {

                    static::$options['load_bootstrap'] = intval($_POST['load_bootstrap']);
                    static::$options['paged_menu'] = intval($_POST['paged_menu']);
                    static::save_options();
                }
            }

            // Zeige das Template:
            require_once(FAZZO_THEME_ROOT . "/class/templ/settings.php");
        }

	    /**
	     * Registriere Meta Boxen
	     * @return void
	     * @since  1.0.0
	     * @access public
	     */
	    public function register_meta_boxes() {

		    $screens = [ 'post', 'pages' ];
		    foreach ( $screens as $screen ) {
			    add_meta_box(
				    'fazzo_meta_box_css',               // Unique ID
				    'CSS',                             // Box title
				    [$this,	"display_meta_boxes_css",],    // Content callback, must be of type callable
				    $screen,                                  // Post type
				    'side', 'default'
			    );
		    }

	    }

	    /**
	     * Zeige CSS Meta Box
	     * @return void
	     * @since  1.0.0
	     * @access public
	     */
	    public function display_meta_boxes_css( $post, $metabox ) {

		    $val = "";
		    echo '<input type="text" name="cpa_settings_options[background]" value="' . $val . '" class="color-field" >';

	    }


        /**
         * Customizer Preview
         * @return void
         * @since  1.0.0
         * @access public
         */
        public function customizer_preview()
        {
            wp_enqueue_script('fazzo-theme-customizer-js', get_template_directory_uri() . '/js/customizer.js', [
                'jquery',
                'customize-preview',
            ], static::version, true);

            wp_enqueue_style("fazzo-theme-customizer-css", get_template_directory_uri() . "/css/customizer.css", [], static::version, 'all');
        }


        /**
         * Customizer
         * @return void
         * @since  1.0.0
         * @access public
         */
        public function customizer_register($wp_customize)
        {


            $wp_customize->add_panel('fazzo_style', [
                'priority' => 665,
                'capability' => 'edit_theme_options',
                'theme_supports' => '',
                'title' => __('Homepage Style', FAZZO_THEME_TXT),
                'description' => "",
            ]);

            $wp_customize->add_section('fazzo_background_style', [
                'priority' => 665,
                'capability' => 'edit_theme_options',
                'theme_supports' => '',
                'title' => __('Background', FAZZO_THEME_TXT),
                'description' => "",
                'panel' => 'fazzo_style',
            ]);

            $wp_customize->add_setting('fazzo_background_color', [
                'default' => static::$customizer_defaults["fazzo_background_color"],
                'transport' => 'postMessage',
            ]);

            $wp_customize->add_control(new \WP_Customize_Color_Control($wp_customize, 'fazzo_background_color', [
                'label' => __('Background Color', FAZZO_THEME_TXT),
                'section' => 'fazzo_background_style',
                'settings' => 'fazzo_background_color',
            ]));

            $wp_customize->add_setting('fazzo_background_opacity', [
                'default' => static::$customizer_defaults["fazzo_background_opacity"],
                'transport' => 'postMessage',
            ]);

            $wp_customize->add_control(new \WP_Customize_Control($wp_customize, 'fazzo_background_opacity', [
                'label' => __('Background Color Opacity', FAZZO_THEME_TXT),
                'section' => 'fazzo_background_style',
                'settings' => 'fazzo_background_opacity',
                'type' => 'text',
            ]));

            $wp_customize->add_setting('fazzo_background_image', [
                'default' => "",
                'transport' => 'refresh',
            ]);

            $wp_customize->add_control(new \WP_Customize_Media_Control($wp_customize, 'fazzo_background_image', [
                'label' => __('Background Image Layer 1', FAZZO_THEME_TXT),
                'section' => 'fazzo_background_style',
                'mime_type' => 'image',
                'settings' => 'fazzo_background_image',
            ]));

            $wp_customize->add_setting('fazzo_background_image2', [
                'default' => "",
                'transport' => 'refresh',
            ]);

            $wp_customize->add_control(new \WP_Customize_Media_Control($wp_customize, 'fazzo_background_image2', [
                'label' => __('Background Image Layer 2', FAZZO_THEME_TXT),
                'section' => 'fazzo_background_style',
                'mime_type' => 'image',
                'settings' => 'fazzo_background_image2',
            ]));

            $wp_customize->add_setting('fazzo_head_background_image', [
                'default' => "",
                'transport' => 'refresh',
            ]);

            $wp_customize->add_control(new \WP_Customize_Media_Control($wp_customize, 'fazzo_head_background_image', [
                'label' => __('Background Image Head', FAZZO_THEME_TXT),
                'section' => 'fazzo_background_style',
                'mime_type' => 'image',
                'settings' => 'fazzo_head_background_image',
            ]));


            $wp_customize->add_section('fazzo_main_menu_style', [
                'priority' => 665,
                'capability' => 'edit_theme_options',
                'theme_supports' => '',
                'title' => __('Main Menu', FAZZO_THEME_TXT),
                'description' => "",
                'panel' => 'fazzo_style',
            ]);

            $wp_customize->add_setting('fazzo_main_menu_color', [
                'default' => static::$customizer_defaults["fazzo_main_menu_color"],
                'transport' => 'postMessage',
            ]);

            $wp_customize->add_control(new \WP_Customize_Color_Control($wp_customize, 'fazzo_main_menu_color', [
                'label' => __('Background Color', FAZZO_THEME_TXT),
                'section' => 'fazzo_main_menu_style',
                'settings' => 'fazzo_main_menu_color',
            ]));

            $wp_customize->add_setting('fazzo_main_menu_color2', [
                'default' => static::$customizer_defaults["fazzo_main_menu_color2"],
                'transport' => 'postMessage',
            ]);

            $wp_customize->add_control(new \WP_Customize_Color_Control($wp_customize, 'fazzo_main_menu_color2', [
                'label' => __('Background Color 2', FAZZO_THEME_TXT),
                'section' => 'fazzo_main_menu_style',
                'settings' => 'fazzo_main_menu_color2',
            ]));

            $wp_customize->add_setting('fazzo_main_menu_border_color', [
                'default' => static::$customizer_defaults["fazzo_main_menu_border_color"],
                'transport' => 'postMessage',
            ]);

            $wp_customize->add_control(new \WP_Customize_Color_Control($wp_customize, 'fazzo_main_menu_border_color', [
                'label' => __('Border Color', FAZZO_THEME_TXT),
                'section' => 'fazzo_main_menu_style',
                'settings' => 'fazzo_main_menu_border_color',
            ]));


            $wp_customize->add_setting('fazzo_main_menu_opacity', [
                'default' => static::$customizer_defaults["fazzo_main_menu_opacity"],
                'transport' => 'postMessage',
            ]);

            $wp_customize->add_control(new \WP_Customize_Control($wp_customize, 'fazzo_main_menu_opacity', [
                'label' => __('Background Opacity', FAZZO_THEME_TXT),
                'section' => 'fazzo_main_menu_style',
                'settings' => 'fazzo_main_menu_opacity',
                'type' => 'text',
            ]));


            $wp_customize->add_panel('fazzo_elements', [
                'priority' => 666,
                'capability' => 'edit_theme_options',
                'theme_supports' => '',
                'title' => __('Homepage Elements', FAZZO_THEME_TXT),
                'description' => "",
            ]);

            // Show/Hide Elements
            $wp_customize->add_section('head_full_wrapper_display', [
                'priority' => 666,
                'capability' => 'edit_theme_options',
                'theme_supports' => '',
                'title' => __('Show Elements of Head Area', FAZZO_THEME_TXT),
                'description' => "",
                'panel' => 'fazzo_elements',
            ]);

            $wp_customize->add_setting('head_full_wrapper_display', [
                'default' => static::$customizer_defaults["head_full_wrapper_display"],
                'transport' => 'refresh',
            ]);

            $wp_customize->add_control(new \WP_Customize_Control($wp_customize, 'head_full_wrapper_display', [
                'label' => __('Show Head Area?', FAZZO_THEME_TXT),
                'section' => 'head_full_wrapper_display',
                'settings' => 'head_full_wrapper_display',
                'type' => 'radio',
                'choices' => [
                    true => __('Yes', FAZZO_THEME_TXT),
                    false => __('No', FAZZO_THEME_TXT),
                ],
            ]));


            $wp_customize->add_setting('head_top_right_wrapper_display', [
                'default' => static::$customizer_defaults["head_top_right_wrapper_display"],
                'transport' => 'refresh',
            ]);

            $wp_customize->add_control(new \WP_Customize_Control($wp_customize, 'head_top_right_wrapper_display', [
                'label' => __('Show Search?', FAZZO_THEME_TXT),
                'section' => 'head_full_wrapper_display',
                'settings' => 'head_top_right_wrapper_display',
                'type' => 'radio',
                'choices' => [
                    true => __('Yes', FAZZO_THEME_TXT),
                    false => __('No', FAZZO_THEME_TXT),
                ],
            ]));

            $wp_customize->add_setting('head_middle_full_wrapper_display', [
                'default' => static::$customizer_defaults["head_middle_full_wrapper_display"],
                'transport' => 'refresh',
            ]);

            $wp_customize->add_control(new \WP_Customize_Control($wp_customize, 'head_middle_full_wrapper_display', [
                'label' => __('Head Middle Show?', FAZZO_THEME_TXT),
                'section' => 'head_full_wrapper_display',
                'settings' => 'head_middle_full_wrapper_display',
                'type' => 'radio',
                'choices' => [
                    true => __('Yes', FAZZO_THEME_TXT),
                    false => __('No', FAZZO_THEME_TXT),
                ],
            ]));

            $wp_customize->add_setting('head_description_display', [
                'default' => static::$customizer_defaults["head_description_display"],
                'transport' => 'refresh',
            ]);

            $wp_customize->add_control(new \WP_Customize_Control($wp_customize, 'head_description_display', [
                'label' => __('Description Show?', FAZZO_THEME_TXT),
                'section' => 'head_full_wrapper_display',
                'settings' => 'head_description_display',
                'type' => 'radio',
                'choices' => [
                    true => __('Yes', FAZZO_THEME_TXT),
                    false => __('No', FAZZO_THEME_TXT),
                ],
            ]));


            // Show/Hide Elements
            $wp_customize->add_section('content_full_wrapper_display', [
                'priority' => 666,
                'capability' => 'edit_theme_options',
                'theme_supports' => '',
                'title' => __('Show Elements of Content Area', FAZZO_THEME_TXT),
                'description' => "",
                'panel' => 'fazzo_elements',
            ]);

            $wp_customize->add_setting('post_nav_display', [
                'default' => static::$customizer_defaults["post_nav_display"],
                'transport' => 'refresh',
            ]);

            $wp_customize->add_control(new \WP_Customize_Control($wp_customize, 'post_nav_display', [
                'label' => __('Show Post Navigation?', FAZZO_THEME_TXT),
                'section' => 'content_full_wrapper_display',
                'settings' => 'post_nav_display',
                'type' => 'radio',
                'choices' => [
                    true => __('Yes', FAZZO_THEME_TXT),
                    false => __('No', FAZZO_THEME_TXT),
                ],
            ]));

        }

        /**
         * Customizer Preview
         * @return void
         * @since  1.0.0
         * @access public
         */
        public function customizer_css()
        {

            $css = "";
            $css_ar = [];
            $css_ar["body"] = [];
            $css_ar["html"] = [];


            $background_image2_id = get_theme_mod('fazzo_background_image2', "");
            if (!empty($background_image2_id)) {
                $background_image2_src = wp_get_attachment_image_src($background_image2_id, "full");
                if ($background_image2_src[0]) {
                    $css_ar["body"][] = "background: url('" . $background_image2_src[0] . "') top left repeat fixed;";
                }
            } else {
                $background_color_opacity = get_theme_mod('fazzo_background_opacity', static::$customizer_defaults["fazzo_background_opacity"]);

                $background_color = get_theme_mod('fazzo_background_color', static::$customizer_defaults["fazzo_background_color"]);
                $background_color_rgb = functions::get_rgb_from_hex($background_color);

                if ($background_color_rgb) {
                    $css_ar["body"][] = "background-color: rgba(" . $background_color_rgb["r"] . ", " . $background_color_rgb["g"] . ", " . $background_color_rgb["b"] . ", $background_color_opacity)";
                }
            }


            $background_image_id = get_post_thumbnail_id(functions::get_id_by_url());
            if ($background_image_id) {
                $background_image_src = wp_get_attachment_image_src($background_image_id, "full");
            }

            if (functions::is_false($background_image_src[0])) {
                $background_image_id = get_theme_mod('fazzo_background_image', "");
                if (!empty($background_image_id)) {
                    $background_image_src = wp_get_attachment_image_src($background_image_id, "full");

                }
            }

            if ($background_image_src[0]) {
                $css_ar["html"][] = "background: url('" . $background_image_src[0] . "') no-repeat center center fixed;";
                $css_ar["html"][] = "-webkit-background-size: cover;";
                $css_ar["html"][] = "-moz-background-size: cover;";
                $css_ar["html"][] = "-o-background-size: cover;";
                $css_ar["html"][] = "background-size: cover;";
            }


            $head_background_image_id = get_theme_mod('fazzo_head_background_image', "");
            if (!empty($head_background_image_id)) {
                $head_background_image_src = wp_get_attachment_image_src($head_background_image_id, "full");

            }
            if ($head_background_image_src[0]) {
                $css_ar["#head-full-wrapper"][] = "background: url('" . $head_background_image_src[0] . "') no-repeat center bottom;";
                //$css_ar["#head-full-wrapper"][] = "-webkit-background-size: cover;";
                //$css_ar["#head-full-wrapper"][] = "-moz-background-size: cover;";
                //$css_ar["#head-full-wrapper"][] = "-o-background-size: cover;";
                //$css_ar["#head-full-wrapper"][] = "background-size: cover;";
            }

            $main_menu_color = get_theme_mod('fazzo_main_menu_color', static::$customizer_defaults["fazzo_main_menu_color"]);
            $main_menu_color_rgb = functions::get_rgb_from_hex($main_menu_color);
            $main_menu_color2 = get_theme_mod('fazzo_main_menu_color2', static::$customizer_defaults["fazzo_main_menu_color2"]);
            $main_menu_color2_rgb = functions::get_rgb_from_hex($main_menu_color2);
            $main_menu_border_color = get_theme_mod('fazzo_main_menu_border_color', static::$customizer_defaults["fazzo_main_menu_border_color"]);
            $main_menu_border_color_rgb = functions::get_rgb_from_hex($main_menu_border_color);
            $main_menu_opacity = get_theme_mod('fazzo_main_menu_opacity', static::$customizer_defaults["fazzo_main_menu_opacity"]);

            if ($main_menu_color_rgb && $main_menu_color2_rgb) {
                $css_ar["#menu-frontpage"][] = $css_ar["#menu-content"][] = $css_ar["#bottom-nav-wrapper"][] = $css_ar["#head-top-left-wrapper"][] = $css_ar["#head-bottom-wrapper"][]
                    = "background: linear-gradient(0deg,  rgba(" . $main_menu_color2_rgb["r"] . ", " . $main_menu_color2_rgb["g"] . ", " . $main_menu_color2_rgb["b"] . ", 1) 0%, rgba(" . $main_menu_color_rgb["r"] . ", " . $main_menu_color_rgb["g"] . ", " . $main_menu_color_rgb["b"] . ", 1) 100%);";
                $css_ar["#menu-frontpage li:hover"][] = $css_ar["#menu-content li:hover"][] = $css_ar["#bottom-nav-wrapper nav ul li:hover"][] = $css_ar["#head-top-left-wrapper nav ul li:hover"][] = $css_ar["#meta-head-nav-wrapper nav ul li:hover"][] =
                $css_ar["#menu-frontpage li.hover"][] = $css_ar["#menu-content li.hover"][] = $css_ar["#bottom-nav-wrapper nav ul li.hover"][] = $css_ar["#head-top-left-wrapper nav ul li.hover"][] = $css_ar["#meta-head-nav-wrapper nav ul li.hover"][]
                    = "background: linear-gradient(0deg,  rgba(" . $main_menu_color_rgb["r"] . ", " . $main_menu_color_rgb["g"] . ", " . $main_menu_color_rgb["b"] . ", 1) 0%, rgba(" . $main_menu_color2_rgb["r"] . ", " . $main_menu_color2_rgb["g"] . ", " . $main_menu_color2_rgb["b"] . ", 1) 100%);";


            }
            if ($main_menu_border_color_rgb) {
                $css_ar["#head-bottom-wrapper"][] = $css_ar["#bottom-nav-wrapper"][]
                    = "border-top: 1px solid rgba(" . $main_menu_border_color_rgb["r"] . ", " . $main_menu_border_color_rgb["g"] . ", " . $main_menu_border_color_rgb["b"] . ",0.65);";
                $css_ar["#bottom-nav-wrapper"][] = $css_ar["#head-top-left-wrapper"][] = $css_ar["#head-bottom-wrapper"][]
                    = "border-bottom: 1px solid rgba(" . $main_menu_border_color_rgb["r"] . ", " . $main_menu_border_color_rgb["g"] . ", " . $main_menu_border_color_rgb["b"] . ", 1);";
                $css_ar["#menu-frontpage"][] = $css_ar["#menu-content"][]
                    = "border: 1px solid rgba(" . $main_menu_border_color_rgb["r"] . ", " . $main_menu_border_color_rgb["g"] . ", " . $main_menu_border_color_rgb["b"] . ", 1);";
                $css_ar["#menu-frontpage"][] = $css_ar["#menu-content"][]
                    = "border-left: none;";
            }
            if ($main_menu_opacity) {
                $css_ar["#menu-frontpage"][] = $css_ar["#menu-content"][] = $css_ar["#bottom-nav-wrapper"][] = $css_ar["#head-top-left-wrapper"][] = $css_ar["#head-bottom-wrapper"][]
                    = "opacity: " . $main_menu_opacity . ";";
            }

            foreach ($css_ar as $element => $rows) {
                $css .= $element . "\n{\n";
                foreach ($rows as $row) {
                    $css .= "\t" . $row . "\n";
                }
                $css .= "}\n";
            }


            $style = "<style>\n" . $css . "\n</style>\n";

            echo $style;

        }


    }
}