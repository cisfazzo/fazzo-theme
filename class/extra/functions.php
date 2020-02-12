<?php

namespace fazzo;

use Exception;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );

if ( ! class_exists( '\fazzo\functions' ) ) {
	/**
	 * Funktionsklasse
	 * @since 1.0.0
	 */
	class functions {

		/**
		 * Encoding
		 * @since  1.0.0
		 * @access public
		 * @var string
		 * @static
		 */
		public static $encoding = "UTF-8";

		/**
		 * PHP constructor.
		 * @since  1.0.0
		 * @access public
		 */
		public function __construct() {
		}


		/**
		 * Prüft, ob Variable ein Array und leer
		 *
		 * @param array &$array Array
		 *
		 * @return bool
		 * @since  1.0.0
		 * @access public
		 * @static
		 *
		 */
		public static function is_empty_array( &$array ) {
			if ( is_array( $array ) && empty( $array ) ) {
				return true;
			}

			return false;
		}

		/**
		 * Prüft, ob Variable ein Object und nicht leer
		 *
		 * @param object &$object Objekt
		 *
		 * @return bool
		 * @since  1.0.0
		 * @access public
		 * @static
		 *
		 */
		public static function is_object_not_empty( &$object ) {
			if ( is_object( $object ) && ! empty( (array) $object ) ) {
				return true;
			}

			return false;
		}

		/**
		 * Prüft, ob größer als 0
		 *
		 * @param int &$int Zahl
		 *
		 * @return bool
		 * @since  1.0.0
		 * @access public
		 * @static
		 *
		 */
		public static function is_int_positive( &$int ) {
			if ( ! empty( $int ) && is_numeric( $int ) && is_int( $int ) && $int > 0 ) {
				return true;
			}

			return false;
		}

		/**
		 * Prüft, ob zwei Strings gleich sind
		 *
		 * @param string &$string1 String 1
		 * @param string &$string2 String 2
		 * @param bool $insensitive Groß- und Kleinschreibung berücksichtigen
		 *
		 * @return bool
		 * @since  1.0.0
		 * @access public
		 * @static
		 *
		 */
		public static function string_equal( &$string1, &$string2, $insensitive = false ) {
			if ( $insensitive ) {
				if ( strcasecmp( $string1, $string2 ) === 0 ) {
					return true;
				}
			} else {
				if ( strcmp( $string1, $string2 ) === 0 ) {
					return true;
				}

			}

			return false;
		}

		/**
		 * Prüft, ob Variable gesetzt ist
		 *
		 * @param mixed &$var Variable
		 *
		 * @return bool
		 * @since  1.0.0
		 * @access public
		 * @static
		 *
		 */
		public static function is_set( &$var ) {
			if ( isset( $var ) ) {
				return true;
			}

			return false;
		}

		/**
		 * Prüft, ob Variable leer ist
		 *
		 * @param mixed &$var Variable
		 *
		 * @return bool
		 * @since  1.0.0
		 * @access public
		 * @static
		 *
		 */
		public static function is_empty( &$var ) {
			if ( isset( $var ) && empty( $var ) ) {
				return true;
			}

			return false;
		}

		/**
		 * Prüft, ob Variable ein Array ist
		 *
		 * @param array &$array Array
		 *
		 * @return bool
		 * @since  1.0.0
		 * @access public
		 * @static
		 *
		 */
		public static function is_array( &$array ) {
			if ( isset( $array ) && is_array( $array ) ) {
				return true;
			}

			return false;
		}

		/**
		 * Parsed eine URL - Todo: Unfertig
		 *
		 * @param string $url URL
		 * @param string &$mode Modus
		 *
		 * @return bool
		 * @throws Exception
		 *
		 * @since  1.0.0
		 * @access public
		 * @static
		 */
		public static function parse_url( $url, &$mode = "php" ) {

			switch ( $mode ) {
				case "php":
					return $url;
					break;
				case "database":
				case "db":
				case "sql":
					// db
					return $url;
					break;
				case "link":
				case "a":
					// link
					return $url;
					break;
				case "addressbar":
				case "bar":
					// bar
					return $url;
					break;
				case "javascript":
				case "js":
					// js
					return $url;
					break;
				default:
					throw new Exception( "Switch Case - Invalid or missing case" );
					break;

			}
		}


		/**
		 * Funktioniert ähnlich wie wp_parse_args, um eine Default Konfiguration mit
		 * der ggf. bestehenden abzugleichen, aber mit Multidimensionalen Arrays
		 *
		 * @param mixed   &$custom Konfiguration
		 * @param mixed $default Konfiguration
		 * @param boolean $do_empty Auch leere Werte übernehmen?
		 *
		 * @return void
		 * @since  1.0.0
		 * @access public
		 * @static
		 *
		 */
		public static function parse_args_multidim( &$custom, $default, $do_empty = false ) {
			if ( ! static::is_empty_array( $default ) ) {
				foreach ( $default as $default_key => $default_value ) {
					if ( static::is_object_not_empty( $default[ $default_key ] ) ) {
						$default[ $default_key ] = static::convert_object_to_array( $default[ $default_key ] );
					}

					if ( ! static::is_set( $custom[ $default_key ] ) || ( $do_empty && static::is_empty( $custom[ $default_key ] ) ) ) {
						$custom[ $default_key ] = [];
						$custom[ $default_key ] = $default[ $default_key ];
					} else {
						if ( static::is_array( $custom[ $default_key ] ) && static::is_array( $default[ $default_key ] ) ) {
							static::parse_args_multidim( $custom[ $default_key ], $default[ $default_key ] );
						}
					}
				}
			}
		}


		/**
		 * Liefert die aktuelle URL
		 * @return string
		 * @throws Exception
		 * @since  1.0.0
		 * @access public
		 */
		public function get_current_url() {
			global $wp;
			$current_url = static::parse_url( home_url( add_query_arg( [], $wp->request ) ) );

			return $current_url;
		}

		/**
		 * Wandelt ein Objekt in ein Array um
		 *
		 * @param object $object Das Objekt
		 *
		 * @return array
		 * @since  1.0.0
		 * @access public
		 * @static
		 *
		 */
		public static function convert_object_to_array( $object ) {
			$array = json_decode( json_encode( $object ), true );

			return $array;
		}

		/**
		 * Wandelt einen String in Kleinbuchstaben um
		 *
		 * @param string $string Der String
		 *
		 * @return array
		 * @since  1.0.0
		 * @access public
		 * @static
		 *
		 */
		public static function lower_string( $string ) {
			return mb_strtolower( $string, static::$encoding );
		}


		/**
		 * Liefert den Slug zu einem Post Typ
		 *
		 * @param $post_type string Der Post Type
		 *
		 * @return string|boolean
		 * @since  1.0.0
		 * @access public
		 *
		 */
		public function get_slug( $post_type ) {
			// Thanks to https://wordpress.stackexchange.com/questions/67408/get-custom-post-type-slug-for-an-archive-page
			if ( $post_type ) {
				$post_type_data = get_post_type_object( $post_type );
				$post_type_slug = $post_type_data->rewrite['slug'];

				return $this->translate_slug( $post_type_slug );
			} else {
				return false;
			}
		}


		/**
		 * Übersetzt einen Slug
		 *
		 * @param $slug_original string Der Slug
		 *
		 * @return string|boolean
		 * @since  1.0.0
		 * @access public
		 *
		 */
		public function translate_slug( $slug_original ) {

			$slug_original_sanitized = static::lower_string( $slug_original );

			switch ( $slug_original_sanitized ) {
				default:
					$slug_translated = $slug_original;
					break;
			}

			return $slug_translated;

		}


		/**
		 * Liefert die RGB Werte zu einem HEX Farbencode
		 * Danke an: https://stackoverflow.com/a/15202130
		 *
		 * @param $hex string Der Hex Farbenwert
		 * @param $return_array bool Wenn Wert als Array zurück gegeben werden soll (default: false)
		 *
		 * @return array|string
		 * @since  1.0.0
		 * @access public
		 * @static
		 *
		 */
		static public function get_rgb_from_hex( $hex, $return_array = false ) {

			$format3 = $format6 = "";
			if ( strpos( $hex, "#" ) !== false ) {
				$format3 .= "#";
				$format6 .= "#";
			}
			$format3 .= "%1x%1x%1x";
			$format6 .= "%2x%2x%2x";
			( strlen( $hex ) === 4 ) ? list( $r, $g, $b ) = sscanf( $hex, $format3 ) : list( $r, $g, $b ) = sscanf( $hex, $format6 );

			if ( $return_array ) {
				return [ "r" => $r, "g" => $g, "b" => $b ];
			} else {
				return "$r,$g,$b";
			}
		}

		/**
		 * Returns an accessibility-friendly link to edit a post or page.
		 * This also gives us a little context about what exactly we're editing
		 * (post or page?) so that users understand a bit more where they are in terms
		 * of the template hierarchy and their content. Helpful when/if the single-page
		 * layout with multiple posts/pages shown gets confusing.
		 *
		 * @return void
		 * @since  1.0.0
		 * @access public
		 * @static
		 */
		static public function edit_link() {
			edit_post_link( sprintf( /* translators: %s: Name of current post */
				__( 'Edit <span class="screen-reader-text">"%s"</span>', "fazzotheme" ), get_the_title() ), '<span class="edit-link">', '</span>' );
		}

		/**
		 * Prints HTML with meta information for the current post-date/time and author.
		 *
		 * @param $return_content bool Wenn der Inhalt zurück gegeben werden soll und nicht ausgegeben
		 *
		 * @return mixed
		 * @since  1.0.0
		 * @access public
		 * @static
		 */
		static public function posted_on( $return_content = false ) {
			// Get the author name; wrap it in a link.
			$byline = sprintf( /* translators: %s: post author */
				__( 'by %s', "fazzotheme" ), '<span class="author vcard meta"><a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author() . '</a></span>' );

			$content = '<span class="posted-on meta">' . static::time( true ) . '</span><span class="byline meta"> ' . $byline . '</span>';

			if ( $return_content ) {
				return $content;
			} else {
				echo $content;
			}
		}

		/**
		 * Gets a nicely formatted string for the published date.
		 *
		 * @param $return_content bool Wenn der Inhalt zurück gegeben werden soll und nicht ausgegeben
		 *
		 * @return mixed
		 * @since  1.0.0
		 * @access public
		 * @static
		 */
		static public function time( $return_content = false ) {

			$time_string = "";

			$date_attr = get_the_date( DATE_W3C );
			$date      = get_the_date();

			$time_string .= "<time class=\"entry-date published\" datetime=\"" . $date_attr . "\">" . $date . "</time>";

			if ( get_the_modified_time( 'U' ) - get_the_time( 'U' ) > 86400 ) {
				$date_changed_attr = get_the_modified_date( DATE_W3C );
				$date_changed      = get_the_modified_date();

				$time_string .= " (" . __( 'Update', "fazzotheme" ) . " <time class=\"entry-date updated\" datetime=\"" . $date_changed_attr . "\">" . $date_changed . "</time>)";
			}


			if ( $return_content ) {
				return $time_string;
			} else {
				echo $time_string;
			}
		}

		/**
		 * Prints HTML with meta information for the categories, tags and comments.
		 *
		 * @param $return_content bool Wenn der Inhalt zurück gegeben werden soll und nicht ausgegeben
		 *
		 * @return mixed
		 * @since  1.0.0
		 * @access public
		 * @static
		 */
		static public function entry_footer( $return_content = false ) {

			$content = "";

			if ( static::categorized_blog() ) {
				$separate_meta   = __( ', ', "fazzotheme" );
				$categories_list = get_the_category_list( $separate_meta );
				$tags_list       = get_the_tag_list( '', $separate_meta );

				$category_size = sizeof( get_the_category() );
				if ( $category_size > 1 ) {
					$txt_cat  = __( 'Categories', "fazzotheme" ) . ": ";
					$txt_tags = __( 'Tags', "fazzotheme" ) . ": ";
				} elseif ( $category_size == 1 ) {
					$txt_cat  = __( 'Category', "fazzotheme" ) . ": ";
					$txt_tags = __( 'Tag', "fazzotheme" ) . ": ";
				} else {
					$txt_cat  = "";
					$txt_tags = "";
				}

				if ( 'post' === get_post_type() ) {

					if ( $categories_list ) {
						$content .= '<p class="cat-links meta">' . $txt_cat . $categories_list . '</p>';
					}

					if ( $tags_list && ! is_wp_error( $tags_list ) ) {
						$content .= '<p class="tags-links meta">' . $txt_tags . $tags_list . '</p>';
					}

				}
			}

			if ( ! empty( $content ) ) {
				$content = "<footer>" . $content . "</footer>";
			}

			if ( $return_content ) {
				return $content;
			} else {
				echo $content;
			}
		}

		/**
		 * Prints HTML with meta information for the time.
		 *
		 * @param $return_content bool Wenn der Inhalt zurück gegeben werden soll und nicht ausgegeben
		 *
		 * @return mixed
		 * @since  1.0.0
		 * @access public
		 * @static
		 */
		static public function entry_details( $return_content = false ) {

			$postet_on = static::posted_on( true );

			$content = '<p class="article-details">' . $postet_on . '</p>';

			if ( $return_content ) {
				return $content;
			} else {
				echo $content;
			}

		}


		/**
		 * Check if is really false
		 *
		 * @param mixed $mixed Mixed
		 * @param bool $identical Hard Match (optional, default: off)
		 *
		 * @return bool
		 * @since  1.0.0
		 * @access public
		 * @static
		 */
		public static function is_false( &$mixed, $identical = false ) {

			if ( ! isset( $mixed ) ) {
				return true;
			}


			if ( $identical ) {
				return ( $mixed === false );
			} else {
				return ( $mixed == false );
			}

		}

		/**
		 * Check if is (really) true
		 *
		 * @param mixed $mixed Mixed
		 * @param bool $identical Hard Match (optional, default: off)
		 *
		 * @return bool
		 * @since  1.0.0
		 * @access public
		 * @static
		 */
		public static function is_true( &$mixed, $identical = false ) {

			if ( ! isset( $mixed ) ) {
				return false;
			}

			if ( $identical ) {
				return ( $mixed === true );
			} else {
				return ( $mixed == true );
			}

		}

		/**
		 * Zähler
		 *
		 * @param mixed $mixed Mixed
		 *
		 * @return bool
		 * @throws Exception
		 * @since  1.0.0
		 * @access public
		 * @static
		 */
		public static function count( &$mixed ) {

			$count = count( $mixed );

			if ( ! is_numeric( $count ) ) {
				throw new Exception( "Count is not numeric" );
			} else {
				return $count;
			}

		}


		/**
		 * Returns true if a blog has more than 1 category.
		 * @return bool
		 * @throws Exception
		 * @since  1.0.0
		 * @access public
		 * @static
		 */
		public static function categorized_blog() {


			$categories = get_categories( [
				'fields'     => 'ids',
				'hide_empty' => 1,
				// We only need to know if there is more than one category.
				'number'     => 2,
			] );

			// Count the number of categories that are attached to the posts.
			$category_count = static::count( $categories );


			return $category_count > 1;
		}

		/**
		 * Returns attr Array for Responsive Class
		 * @return array
		 * @since  1.0.0
		 * @access public
		 * @static
		 */
		public static function attr_responsive() {
			return [ 'class' => 'img-fluid' ];
		}

		/**
		 * Returns post thumbnail src
		 * @return string
		 * @since  1.0.0
		 * @access public
		 * @static
		 */
		public static function post_thumbnail_url( $post = null, $size = "fazzo-featured-image" ) {
			if ( is_null( $post ) ) {
				$post = get_post();
			}
			if ( ! $post ) {
				return '';
			}

			$post_thumbnail_id = get_post_thumbnail_id( $post );
			$image_src         = wp_get_attachment_image_src( $post_thumbnail_id, $size );
			if ( isset( $image_src[0] ) ) {
				return $image_src[0];
			} else {
				return "";
			}
		}

		/**
		 * Display the archive title based on the queried object.
		 *
		 * @param string $before Optional. Content to prepend to the title. Default empty.
		 * @param string $after Optional. Content to append to the title. Default empty.
		 * @param $return_content bool Wenn der Inhalt zurück gegeben werden soll und nicht ausgegeben
		 *
		 * @return mixed
		 * @since 4.1.0
		 * @access public
		 * @static
		 * @see   get_the_archive_title()
		 *
		 */
		static public function the_archive_title( $before = '', $after = '', $return_content = false ) {
			$title = static::get_the_archive_title();

			if ( ! empty( $title ) ) {

				$content = $before . $title . $after;

				if ( $return_content ) {
					return $content;
				} else {
					echo $content;
				}
			}
		}

		/**
		 * Retrieve the archive title based on the queried object.
		 *
		 * @return string Archive title.
		 * @since 4.1.0
		 *
		 */
		static public function get_the_archive_title() {
			if ( is_category() ) {
				/* translators: Category archive title. 1: Category name */
				$title = single_cat_title( '', false );
			} elseif ( is_tag() ) {
				/* translators: Tag archive title. 1: Tag name */
				$title = single_tag_title( '', false );
			} elseif ( is_author() ) {
				/* translators: Author archive title. 1: Author name */
				$title = '<span class="vcard">' . get_the_author() . '</span>';
			} elseif ( is_year() ) {
				/* translators: Yearly archive title. 1: Year */
				$title = sprintf( __( 'Year: %s', "fazzotheme" ), get_the_date( _x( 'Y', 'yearly archives date format', "fazzotheme" ) ) );
			} elseif ( is_month() ) {
				/* translators: Monthly archive title. 1: Month name and year */
				$title = sprintf( __( 'Month: %s', "fazzotheme" ), get_the_date( _x( 'F Y', 'monthly archives date format', "fazzotheme" ) ) );
			} elseif ( is_day() ) {
				/* translators: Daily archive title. 1: Date */
				$title = sprintf( __( 'Day: %s', "fazzotheme" ), get_the_date( _x( 'F j, Y', 'daily archives date format', "fazzotheme" ) ) );
			} elseif ( is_tax( 'post_format' ) ) {
				if ( is_tax( 'post_format', 'post-format-aside' ) ) {
					$title = _x( 'Asides', 'post format archive title', "fazzotheme" );
				} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
					$title = _x( 'Galleries', 'post format archive title', "fazzotheme" );
				} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
					$title = _x( 'Images', 'post format archive title', "fazzotheme" );
				} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
					$title = _x( 'Videos', 'post format archive title', "fazzotheme" );
				} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
					$title = _x( 'Quotes', 'post format archive title', "fazzotheme" );
				} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
					$title = _x( 'Links', 'post format archive title', "fazzotheme" );
				} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
					$title = _x( 'Statuses', 'post format archive title', "fazzotheme" );
				} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
					$title = _x( 'Audio', 'post format archive title', "fazzotheme" );
				} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
					$title = _x( 'Chats', 'post format archive title', "fazzotheme" );
				}
			} elseif ( is_post_type_archive() ) {
				/* translators: Post type archive title. 1: Post type name */
				$title = sprintf( __( 'Archives: %s', "fazzotheme" ), post_type_archive_title( '', false ) );
			} elseif ( is_tax() ) {
				$tax = get_taxonomy( get_queried_object()->taxonomy );
				/* translators: Taxonomy term archive title. 1: Taxonomy singular name, 2: Current taxonomy term */
				$title = sprintf( __( '%1$s: %2$s', "fazzotheme" ), $tax->labels->singular_name, single_term_title( '', false ) );
			} else {
				$title = __( 'Archives', "fazzotheme" );
			}

			return apply_filters( 'get_the_archive_title', $title );
		}

		/**
		 * Validiert das Wordpress Nonce aus einem gesendeten HTML Form
		 *
		 * @param string $key POST Key des Nonce
		 * @param string $name_nonce Nonce Name
		 *
		 * @return bool
		 * @since  1.0.0
		 * @access public
		 * @static
		 *
		 */
		static public function validate_nonce( $key, $name_nonce ) {
			if ( ! isset( $_POST[ $key ] ) || ! wp_verify_nonce( $_POST[ $key ], $name_nonce ) ) {
				return false;
			} else {
				return true;
			}
		}

		/**
		 * Liefert die aktuelle ID zur URL
		 *
		 *
		 * @return int
		 * @since  1.0.0
		 * @access public
		 * @static
		 *
		 */
		static public function get_id_by_url() {
			$path       = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			$url        = 'http://' . $path;
			$current_id = url_to_postid( $url );
			if ( $current_id !== false ) {
				return $current_id;
			}
			$url        = 'https://' . $path;
			$current_id = url_to_postid( $url );

			return $current_id;

		}

		/**
		 * Liefert alle Elemente von einem Menü
		 *
		 * @param int|string|WP_Term $menu Menu ID, slug, name, or object.
		 * @param array $args
		 *
		 * @return false|array $items Array of menu items, otherwise false.
		 * @since  1.0.0
		 * @access public
		 * @static
		 *
		 */
		static public function get_nav_items( $menu, $args = [] ) {
			$menuLocations = get_nav_menu_locations();
			if ( functions::is_set( $menuLocations[ $menu ] ) ) {
				$nav_items = wp_get_nav_menu_items( $menuLocations[ $menu ], $args );
			} else {
				$nav_items = [];
			}

			return $nav_items;
		}


		/**
		 * Liefert alle User Menüs
		 *
		 * @param bool $hide_empty Sollen leere ausgelassen werden? (Optional, Default: true)
		 *
		 * @return mixed
		 * @since  1.0.0
		 * @access public
		 * @static
		 *
		 */
		static public function get_all_menus( $hide_empty = true ) {
			return get_terms( 'nav_menu', array( 'hide_empty' => $hide_empty ) );
		}

		/**
		 * Liefert alle angemeldeten Menüs
		 *
		 *
		 * @return mixed
		 * @since  1.0.0
		 * @access public
		 * @static
		 *
		 */
		static public function get_all_registered_menus() {
			return get_registered_nav_menus();
		}


		/**
		 * Liefert ein Nav Item zur Objekt ID
		 *
		 * @param $post_id int Die Post ID
		 *
		 * @return mixed
		 * @since  1.0.0
		 * @access public
		 * @static
		 *
		 */
		static public function get_nav_item_to_object_id( $post_id ) {
			if ( ! static::is_int_positive( $post_id ) ) {
				return false;
			}

			$locations = get_nav_menu_locations();
			foreach ( $locations as $location ) {
				$nav_items = wp_get_nav_menu_items( $location );
				foreach ( $nav_items as $nav_item ) {
					if ( $post_id === (int) $nav_item->object_id ) {
						return $nav_item;
					}
				}
			}

			return false;
		}


		/**
		 * Liefert Alle Nav Items zur Objekt ID
		 *
		 * @param $post_id int Die Post ID
		 *
		 * @return mixed
		 * @since  1.0.0
		 * @access public
		 * @static
		 *
		 */
		static public function get_nav_items_to_object_id( $post_id ) {


			if ( ! static::is_int_positive( $post_id ) ) {
				return false;
			}


			$locations = get_nav_menu_locations();
			foreach ( $locations as $location ) {
				$nav_items = wp_get_nav_menu_items( $location );
				foreach ( $nav_items as $nav_item ) {
					if ( $post_id === (int) $nav_item->object_id ) {

						return $nav_items;
					}
				}
			}

			return false;
		}


		/**
		 * Liefert die Tiefe zu einem Menüpunkt (Fehlerhaft bei identischen Subemnüpunkte in verschiedenen Menüs)
		 *
		 * @param $nav_item object Ein Navigationsitem
		 *
		 * @return int
		 * @since  1.0.0
		 * @access public
		 * @static
		 *
		 */
		static public function get_depth_by_nav_item( $nav_item ) {
			if ( ! static::is_object_not_empty( $nav_item ) ) {
				return false;
			}

			if ( isset( $nav_item->menu_item_parent ) ) {
				$depth = 0;
				if ( ! empty( $nav_item->menu_item_parent ) ) {
					$parent = $nav_item->menu_item_parent;
					while ( $parent ) {
						$post   = static::get_post( $parent );
						$parent = $post->post_parent;
						$depth ++;
					}
				}

				return $depth;
			} else {
				return 0;
			}
		}

		/**
		 * Speichert die Tiefe des Menüs im Cache
		 *
		 *
		 * @return void
		 * @since  1.0.0
		 * @access public
		 * @static
		 *
		 */
		public static function store_current_menu_depth() {

			$current_id = static::get_id_by_url();
			if ( $current_id === false ) {
				return;
			}

			$nav_item = static::get_nav_item_to_object_id( $current_id );

			$depth = static::get_depth_by_nav_item( $nav_item );

			if ( $depth !== false ) {
				set_transient( "fazzo_menu_depth", (int) $depth, DAY_IN_SECONDS );
			}

		}

		/**
		 * Liefert die aktuelle Tiefe des Menüs
		 *
		 * @param $transient bool Ob der Cache benutzt werden soll (Optional)
		 *
		 * @return int
		 * @since  1.0.0
		 * @access public
		 * @static
		 *
		 */
		public static function get_current_menu_depth( $transient = false ) {
			if ( $transient ) {
				static::store_current_menu_depth();

				return get_transient( "fazzo_menu_depth" );
			} else {
				$current_id = static::get_id_by_url();
				if ( $current_id === false ) {
					return 0;
				}

				$nav_item = static::get_nav_item_to_object_id( $current_id );

				$depth = static::get_depth_by_nav_item( $nav_item );
				if ( $depth !== false ) {
					return $depth;
				} else {
					return 0;
				}
			}
		}


		/**
		 * Liefert die Tiefe des Kindelements vom ausgewählten Element
		 *
		 * @return int
		 * @since  1.0.0
		 * @access public
		 * @static
		 *
		 */
		public static function get_menu_depth_of_child() {

			$current_id = static::get_id_by_url();
			if ( $current_id === false ) {
				return 0;
			}

			$nav_item = static::get_nav_item_to_object_id( $current_id );
			$depth    = static::get_depth_by_nav_item( $nav_item );

			$items = static::get_nav_items_to_object_id( $current_id );

			if ( static::is_array( $items ) ) {

				foreach ( $items as $item ) {
					if ( (int) $nav_item->ID == (int) $item->menu_item_parent ) {
						if ( $depth !== false ) {
							$depth += 1;
						}
						break;
					}
				}
			}

			if ( $depth !== false ) {
				return $depth;
			} else {
				return 0;
			}

		}


		/**
		 * Prüft, ob Navigations Item Kinderelemente hat
		 *
		 * @return $object_id int Die Objekt ID
		 * @since  1.0.0
		 * @access public
		 * @static
		 *
		 */
		public static function nav_item_has_childs( $object_id ) {


			if ( ! static::is_int_positive( $object_id ) ) {
				return false;
			}

			$nav_item  = static::get_nav_item_to_object_id( $object_id );
			$nav_items = static::get_nav_items_to_object_id( $object_id );

			if ( static::is_array( $nav_items ) ) {

				foreach ( $nav_items as $nav_item2 ) {


					if ( (int) $nav_item->ID == (int) $nav_item2->menu_item_parent ) {

						return true;
						break;
					}
				}
			}

			return false;

		}


		/**
		 * Liefert ein Post ELement über dessen ID
		 *
		 * @param $id int Post ID
		 *
		 * @return object
		 * @since  1.0.0
		 * @access public
		 * @static
		 *
		 */
		public static function get_post( $id ) {

			return get_post( (int) $id );
		}

		/**
		 * Entfernt Unterverzeichnisse aus URL
		 *
		 * @param $url string Die URL
		 * @param $depth int Die Tiefe, muss bei 1 beginnen
		 *
		 * @return string
		 * @since  1.0.0
		 * @access public
		 * @static
		 *
		 */
		public static function remove_url_last_path( $url ) {

			if ( ! static::url_validation( $url, true ) ) {
				return $url;
			}

			if ( static::url_validation( $url, true, true ) === 0 ) {
				$last = strrpos( $url, "/" );
				$url  = substr( $url, 0, $last );
				$last = strrpos( $url, "/" );
				$url  = substr( $url, 0, $last + 1 );
			}

			return $url;
		}

		/**
		 * Validiert eine URL
		 *
		 * @param $url string Die URL
		 * @param $slash_after_domain bool Ob der Domainname ein Slash als Suffix haben MUSS
		 * @param $has_domain_only bool Ob keine Unterverzeichnisse existieren, bei Erfolg true, Wenn Unterverzeichnisse 0 zurück, bei Fehler false
		 *
		 * @return bool|int
		 * @since  1.0.0
		 * @access public
		 * @static
		 *
		 */
		public static function url_validation( $url, $slash_after_domain = false, $has_domain_only = false ) {

			if ( $slash_after_domain ) {
				$count = 3;
			} else {
				$count = 2;
			}


			if ( $has_domain_only ) {
				if ( substr_count( $url, "/" ) == $count ) {

					return true;
				} else {
					if ( substr_count( $url, "/" ) > $count - 1 ) {
						return 0;
					} else {
						return false;
					}
				}
			} else {
				if ( substr_count( $url, "/" ) > $count - 1 ) {
					return true;
				} else {
					return false;
				}
			}

		}

		/**
		 * Gibt die Background Settings eines Posts zurück
		 *
		 * @param $post Object Ein Post Objekt
		 *
		 * @return bool|int
		 * @since  1.0.0
		 * @access public
		 * @static
		 *
		 */
		public static function get_background_style( $post ) {
			$options = get_post_meta( $post->ID, fazzo::option_name, true );
			if ( ! self::is_array( $options ) ) {
				$options = [];
			}
			if ( ! isset( $options["background_color"] ) || strlen( $options["background_color"] ) < 7 ) {
				$options["background_color"] = "#000000";
			}
			if ( ! isset( $options["background_transparent"] ) || ( $options["background_transparent"] != "0" && $options["background_transparent"] != "1" && $options["background_transparent"] !== false && $options["background_transparent"] !== true ) ) {
				$options["background_transparent"] = true;
			}
			$element_style = "";
			if ( empty( $options["background_transparent"] ) ) {
				$opacity       = fazzo::get_mod( "background_content_opacity" );
				$rgba          = "rgba(" . functions::get_rgb_from_hex( $options["background_color"] ) . "," . $opacity . ")";
				$element_style = "style=\"background-color: " . $rgba . "\"";
			}

			return $element_style;
		}

	}


}