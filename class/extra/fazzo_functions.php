<?php

namespace fazzo;

use Exception;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );

if ( ! class_exists( '\fazzo\fazzo_functions' ) ) {
	/**
	 * Funktionsklasse
	 * @since 1.0.0
	 */
	class fazzo_functions {

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
			if ( is_array( $array ) ) {
				return true;
			}

			return false;
		}

		/**
		 * Prüft, ob Variable ein Array ist
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

					if ( ! static::is_set( $custom[ $default_key ] ) || ($do_empty && static::is_empty( $custom[ $default_key ] )) ) {
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
		 * Leeres Dummy Callback
		 * @return void
		 * @since  1.0.0
		 * @access public
		 */
		public function callback_dummy() {
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
		 *
		 * @return array
		 * @since  1.0.0
		 * @access public
		 * @static
		 *
		 */
		static public function get_rgb_from_hex( $hex ) {

			$format3 = $format6 = "";
			if(strpos($hex, "#") !== false)
			{
				$format3 .= "#";
				$format6 .= "#";
			}
			$format3 .= "%1x%1x%1x";
			$format6 .= "%2x%2x%2x";
			( strlen( $hex ) === 4 ) ? list( $r, $g, $b ) = sscanf( $hex, $format3) : list( $r, $g, $b ) = sscanf( $hex, $format6 );

			return [ "r" => $r, "g" => $g, "b" => $b ];
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
				__( 'Edit <span class="screen-reader-text">"%s"</span>', FAZZO_THEME_TXT ), get_the_title() ), '<span class="edit-link">', '</span>' );
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
				__( 'by %s', FAZZO_THEME_TXT ), '<span class="author vcard meta"><a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author() . '</a></span>' );

			$content = '<span class="posted-on meta">' . static::time() . '</span><span class="byline meta"> ' . $byline . '</span>';

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
			$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
			}
			$time_string = sprintf( $time_string, get_the_date( DATE_W3C ), get_the_date() );
			// Wrap the time string in a link, and preface it with 'Posted on'.
			$content = sprintf( /* translators: %s: post date */ __( '<span class="screen-reader-text">Posted on</span> %s', FAZZO_THEME_TXT ), $time_string );

			if ( $return_content ) {
				return $content;
			} else {
				echo $content;
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
			/* translators: used between list items, there is a space after the comma */
			$separate_meta = __( ', ', FAZZO_THEME_TXT );
			// Get Categories for posts.
			$categories_list = get_the_category_list( $separate_meta );
			// Get Tags for posts.
			$tags_list = get_the_tag_list( '', $separate_meta );
			// We don't want to output .entry-footer if it will be empty, so make sure its not.
			$content = "";
			if ( ( ( static::categorized_blog() && $categories_list ) || $tags_list ) || get_edit_post_link() ) {
				$content .= '<footer>';
				if ( 'post' === get_post_type() ) {
					if ( ( $categories_list && static::categorized_blog() ) || $tags_list ) {
						$content .= '<span class="cat-tag-links meta">';

						// Make sure there's more than one category before displaying.
						if ( $categories_list && static::categorized_blog() ) {
							$content .= '<span class="cat-links meta"><span class="screen-reader-text">' . __( 'Categories', FAZZO_THEME_TXT ) . '</span>' . $categories_list . '</span>';
						}

						if ( $tags_list && ! is_wp_error( $tags_list ) ) {
							$content .= '<span class="tags-links meta"><span class="screen-reader-text">' . __( 'Tags', FAZZO_THEME_TXT ) . '</span>' . $tags_list . '</span>';
						}
						$content .= '</span>';
					}
				}
				$content .= '</footer>';
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

			$content = '<div class="article-details">' . $postet_on . '</div>';

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
		 *
		 * @return bool
		 * @since  1.0.0
		 * @access public
		 * @static
		 */
		public static function is_false( &$mixed ) {

			return ( $mixed === false );

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

			// Allow viewing case of 0 or 1 categories in post preview.
			if ( is_preview() ) {
				return true;
			}

			$category_count = get_transient( 'fazzo_categories' );

			if ( static::is_false( $category_count ) ) {
				// Create an array of all the categories that are attached to posts.
				$categories = get_categories( [
					'fields'     => 'ids',
					'hide_empty' => 1,
					// We only need to know if there is more than one category.
					'number'     => 2,
				] );

				// Count the number of categories that are attached to the posts.
				$category_count = static::count( $categories );

				set_transient( 'fazzo_categories', $category_count );
			}

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
				$title = sprintf( __( 'Year: %s', FAZZO_THEME_TXT ), get_the_date( _x( 'Y', 'yearly archives date format', FAZZO_THEME_TXT ) ) );
			} elseif ( is_month() ) {
				/* translators: Monthly archive title. 1: Month name and year */
				$title = sprintf( __( 'Month: %s', FAZZO_THEME_TXT ), get_the_date( _x( 'F Y', 'monthly archives date format', FAZZO_THEME_TXT ) ) );
			} elseif ( is_day() ) {
				/* translators: Daily archive title. 1: Date */
				$title = sprintf( __( 'Day: %s', FAZZO_THEME_TXT ), get_the_date( _x( 'F j, Y', 'daily archives date format', FAZZO_THEME_TXT ) ) );
			} elseif ( is_tax( 'post_format' ) ) {
				if ( is_tax( 'post_format', 'post-format-aside' ) ) {
					$title = _x( 'Asides', 'post format archive title', FAZZO_THEME_TXT );
				} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
					$title = _x( 'Galleries', 'post format archive title', FAZZO_THEME_TXT );
				} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
					$title = _x( 'Images', 'post format archive title', FAZZO_THEME_TXT );
				} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
					$title = _x( 'Videos', 'post format archive title', FAZZO_THEME_TXT );
				} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
					$title = _x( 'Quotes', 'post format archive title', FAZZO_THEME_TXT );
				} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
					$title = _x( 'Links', 'post format archive title', FAZZO_THEME_TXT );
				} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
					$title = _x( 'Statuses', 'post format archive title', FAZZO_THEME_TXT );
				} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
					$title = _x( 'Audio', 'post format archive title', FAZZO_THEME_TXT );
				} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
					$title = _x( 'Chats', 'post format archive title', FAZZO_THEME_TXT );
				}
			} elseif ( is_post_type_archive() ) {
				/* translators: Post type archive title. 1: Post type name */
				$title = sprintf( __( 'Archives: %s', FAZZO_THEME_TXT ), post_type_archive_title( '', false ) );
			} elseif ( is_tax() ) {
				$tax = get_taxonomy( get_queried_object()->taxonomy );
				/* translators: Taxonomy term archive title. 1: Taxonomy singular name, 2: Current taxonomy term */
				$title = sprintf( __( '%1$s: %2$s', FAZZO_THEME_TXT ), $tax->labels->singular_name, single_term_title( '', false ) );
			} else {
				$title = __( 'Archives' );
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
	}
}