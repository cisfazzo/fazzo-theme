<?php

namespace fazzo;

use Exception;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );

// Walker nav class
// Thanks to https://github.com/wp-bootstrap/wp-bootstrap-navwalker/blob/master/wp-bootstrap-navwalker.php

/**
 * WP Bootstrap Navwalker
 * @package WP-Bootstrap-Navwalker
 */
/*
 * Class Name: WP_Bootstrap_Navwalker
 * Plugin Name: WP Bootstrap Navwalker
 * Plugin URI:  https://github.com/wp-bootstrap/wp-bootstrap-navwalker
 * Description: A custom WordPress nav walker class to implement the Bootstrap 3 navigation style in a custom theme using the WordPress built in menu manager.
 * Author: Edward McIntyre - @twittem, WP Bootstrap
 * Version: 2.0.5
 * Author URI: https://github.com/wp-bootstrap
 * GitHub Plugin URI: https://github.com/wp-bootstrap/wp-bootstrap-navwalker
 * GitHub Branch: master
 * License: GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
*/

/* Check if Class Exists. */
if ( ! class_exists( '\fazzo\fazzo_nav_walker_paged' ) ) {
	/**
	 * WP_Bootstrap_Navwalker class.
	 * @extends Walker_Nav_Menu
	 */
	class fazzo_nav_walker_paged extends \Walker_Nav_Menu {


		/**
		 * Aktuelles Item
		 * @since  1.0.0
		 * @access private
		 * @var object
		 */
		private $curItem;

		/**
		 * Benutze die Tiefe für Paged Menü
		 * @since  1.0.0
		 * @access private
		 * @var int
		 */
		private $depth_paged = null;


		/**
		 * Ermittle oberste Post ID in der Navigation
		 *
		 * @param mixed $curItem Das Aktuelle Item als Post Object
		 *
		 * @return bool
		 * @since  1.0.0
		 * @access public
		 *
		 */
		public function fazzo_get_top_post_id( $curItem = null ) {

			$str_nav_menu_item = "nav_menu_item";

			if ( ! fazzo_functions::is_object_not_empty( $curItem ) ) {
				global $post;
				if ( fazzo_functions::is_object_not_empty( $post ) ) {
					$curItem = $post;
				}
			}

			$posts = [];
			if ( fazzo_functions::is_object_not_empty( $curItem ) && isset( $curItem->post_type ) ) {
				switch ( $curItem->post_type ) {
					case "nav_menu_item":
						if ( isset( $curItem->menu_item_parent ) && ! empty( $curItem->menu_item_parent ) ) {
							$menu_child = $curItem;
							while ( isset( $menu_child->menu_item_parent ) && fazzo_functions::is_int_positive( $menu_child->menu_item_parent ) ) {
								$menu_child = get_post( $menu_child->menu_item_parent );
							}
							$post = $menu_child;
							if ( isset( $post->ID ) && fazzo_functions::is_int_positive( $post->ID ) ) {
								if ( isset( $post->post_type ) && fazzo_functions::string_equal( $post->post_type, $str_nav_menu_item ) ) {
									$post_meta_object_id = get_post_meta( $post->ID, '_menu_item_object_id', true );
									if ( ! empty( $post_meta_object_id ) ) {
										return $post_meta_object_id;
									}
								} else {
									return $post->ID;
								}
							}
						}
						break;
					default:
						break;
				}

				if ( isset( $curItem->ID ) && fazzo_functions::is_int_positive( $curItem->ID ) ) {
					$posts = get_post_ancestors( $curItem->ID );
				}
			}

			if ( ! fazzo_functions::is_empty_array( $posts ) && fazzo_functions::is_int_positive( $posts[0] ) ) {
				return $posts[0];
			} else {
				return false;
			}
		}

		/**
		 * Start Level.
		 *
		 * @param mixed $output Passed by reference. Used to append additional content.
		 * @param int $depth (default: 0) Depth of page. Used for padding.
		 * @param array $args (default: array()) Arguments.
		 *
		 * @return void
		 * @see    Walker::start_lvl()
		 * @since  3.0.0
		 * @access public
		 *
		 */
		public function start_lvl( &$output, $depth = 0, $args = [] ) {
			return;

			$indent = str_repeat( "\t", $depth );


			$output .= "\n\n" . $indent . "<div class=\"dropdown-menu\" aria-labelledby=\"navbarDropdown" . $this->curItem->ID . "\"><div class='d-flex flex-row'><div class='dropdown-menu-items p-2'>\n";
		}

		/**
		 * End Level.
		 *
		 * @param mixed $output Passed by reference. Used to append additional content.
		 * @param int $depth (default: 0) Depth of page. Used for padding.
		 * @param array $args (default: array()) Arguments.
		 *
		 * @return void
		 * @see    Walker::end_lvl()
		 * @since  3.0.0
		 * @access public
		 *
		 */
		public function end_lvl( &$output, $depth = 0, $args = [] ) {
			return;
			$content      = "";
			$content      .= "\n</div>";
			$top_post_id  = $this->fazzo_get_top_post_id( $this->curItem );
			$top_post_img = get_the_post_thumbnail( $top_post_id, "full" );
			if ( ! empty( $top_post_img ) ) {
				$top_post_url = esc_url( get_permalink( $top_post_id ) );
				$content      .= "\n<div class='dropdown-menu-img p-2'><a href='$top_post_url'>$top_post_img</a></div>\n";
			}
			$content .= "\n</div></div>";
			$output  .= $content;
		}

		/**
		 * End Element.
		 *
		 * @param mixed $output Passed by reference. Used to append additional content.
		 * @param object $object The data object.
		 * @param int $depth (default: 0) Depth of page. Used for padding.
		 * @param array $args (default: array()) Arguments.
		 *
		 * @return void
		 * @since  3.0.0
		 * @access public
		 *
		 * @see    Walker::end_el()
		 */
		public function end_el( &$output, $object, $depth = 0, $args = [] ) {
			$content = "";
			if ( true || $depth == 0 ) {
				$content .= "\n</li>";
			}
			$output .= $content;
		}

		/**
		 * Start Element.
		 *
		 * @param mixed $output Passed by reference. Used to append additional content.
		 * @param mixed $item Menu item data object.
		 * @param int $depth (default: 0) Depth of menu item. Used for padding.
		 * @param array $args (default: array()) Arguments.
		 * @param int $id (default: 0) Menu item ID.
		 *
		 * @return void
		 * @see    Walker::start_el()
		 * @since  3.0.0
		 * @access public
		 *
		 */
		public function start_el( &$output, $item, $depth = 0, $args = [], $id = 0 ) {

			$str_divider         = "divider";
			$str_dropdown_header = "dropdown-header";
			$str_disabled        = "disabled";
			$str_href            = "href";
			$str_post_type_image = "fazzo_imagelink";
			$str_nav_image       = "fazzo-nav-image";


			$this->curItem = $item;




			if(!is_null($this->depth_paged) && $depth < $this->depth_paged)
				$this->depth_paged = -1;

			if(!is_null($this->depth_paged) && $this->depth_paged != $depth || $this->depth_paged == -1)
				return;

			if (($args->has_children) &&  in_array( 'current-menu-item', $item->classes ))  {

				$this->depth_paged = $depth+1;
				//var_dump($depth, $this->depth_paged, $tet);
				if(true || $depth != $this->depth_paged)
					$output = "";
			}





			if ( $depth) {
				$indent = str_repeat( "\t", $depth );
			}

			if ( fazzo_functions::string_equal( $item->attr_title, $str_divider, true ) && $depth == 1 ) {
				$output .= "\n" . $indent . '<li role="presentation" class="divider">';
			} elseif ( fazzo_functions::string_equal( $item->title, $str_divider, true ) && $depth == 1 ) {
				$output .= "\n" . $indent . '<li role="presentation" class="divider">';
			} elseif ( fazzo_functions::string_equal( $item->attr_title, $str_dropdown_header, true ) && $depth == 1 ) {
				$output .= "\n" . $indent . '<li role="presentation" class="dropdown-header">' . esc_attr( $item->title );
			} elseif ( fazzo_functions::string_equal( $item->attr_title, $str_disabled, true ) ) {
				$output .= "\n" . $indent . '<li role="presentation" class="disabled"><a href="#">' . esc_attr( $item->title ) . '</a>';
			} elseif($depth == $this->depth_paged) {

				$class_names = '';
				$value       = '';

				$classes = [];
				if ( ! empty( $item->classes ) ) {
					$classes = $item->classes;
				}
				$classes[] = 'menu-item-' . $item->ID;
				$classes[] = 'nav-item  hvr-pop';

				$ar_filter_classes     = array_filter( $classes );
				$wp_nav_menu_css_class = apply_filters( 'nav_menu_css_class', $ar_filter_classes, $item, $args );
				$class_names           = join( ' ', $wp_nav_menu_css_class );

				if ( $args->has_children ) {
					$class_names .= ' dropdown';
				}
				if ( in_array( 'current-menu-item', $classes ) ) {
					$class_names .= ' active';
				}


				if ( ! empty( $class_names ) ) {
					$class_names = ' class="' . esc_attr( $class_names ) . '"';
				}

				$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );
				if ( ! empty( $id ) ) {
					$id = ' id="' . esc_attr( $id ) . '"';
				}
				if ( true || $depth == 0 ) {
					$output .= "\n" . $indent . '<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement"' . $id . $value . $class_names . '>';
				}
				$atts          = [];
				$atts['title'] = "";
				if ( ! empty( $item->attr_title ) ) {
					$atts['title'] = $item->attr_title;
				} elseif ( empty( ! $item->title ) ) {
					$atts['title'] = strip_tags( $item->title );
				}
				$atts['target'] = "";
				if ( ! empty( $item->target ) ) {
					$atts['target'] = $item->target;
				}
				$atts['rel'] = "";
				if ( ! empty( $item->xfn ) ) {
					$atts['rel'] = $item->xfn;
				}
				// If item has_children add atts to a.
				if ( $args->has_children && $depth == 0 ) {
					$atts['class']         = 'nav-link dropdown-toggle';
					$atts['aria-haspopup'] = 'true';
					$atts['id']            = 'navbarDropdown' . $item->ID;
					$atts['role']          = 'button';
					$atts['data-toggle']   = 'dropdown';
					$atts['aria-expanded'] = 'false';
				} elseif ( $depth == 0 ) {
					$atts['class'] = 'nav-link';
				} else {
					$atts['class'] = 'dropdown-item';
				}

				$post = get_post( $item->object_id );
				if ( isset( $post->post_type ) && fazzo_functions::string_equal( $post->post_type, $str_post_type_image ) ) {
					$targeturl = get_post_meta( $item->object_id, 'srval_imagelink_url', true );
				}
				$atts['href'] = "#";
				if ( ! empty( $targeturl ) ) {
					$atts['href'] = $targeturl;
				} elseif ( ! empty( $item->url ) ) {
					$atts['href'] = $item->url;
				}

				$atts       = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );
				$attributes = '';
				foreach ( $atts as $attr => $value ) {
					if ( ! empty( $value ) ) {
						if ( fazzo_functions::string_equal( $attr, $str_href ) ) {
							$value = esc_url( $value );
						} else {
							$value = esc_attr( $value );
						}
						$attributes .= ' ' . $attr . '="' . $value . '"';
					}
				}
				$item_output = $args->before;
				/**
				 * Glyphicons/Font-Awesome
				 * ===========
				 * Since the the menu item is NOT a Divider or Header we check the see
				 * if there is a value in the attr_title property. If the attr_title
				 * property is NOT null we apply it as the class name for the glyphicon.
				 */
				if ( ! empty( $item->attr_title ) ) {
					$pos = strpos( esc_attr( $item->attr_title ), 'glyphicon' );
					if ( $pos !== false ) {
						$item_output .= '<a' . $attributes . '><span class="glyphicon ' . esc_attr( $item->attr_title ) . '" aria-hidden="true"></span>&nbsp;';
					} else {
						$item_output .= '<a' . $attributes . '><i class="fa ' . esc_attr( $item->attr_title ) . '" aria-hidden="true"></i>&nbsp;';
					}
				} else {
					$item_output .= '<a' . $attributes . '>';
				}
				$inside_found = false;


				$inside = "";
					$post_thumbnail_id = get_post_thumbnail_id( $item->object_id );
					if ( $post_thumbnail_id ) {
						$thisimage = wp_get_attachment_image_src( $post_thumbnail_id, $str_nav_image );
						if ( isset( $thisimage[0] ) && ! empty( $thisimage[0] ) ) {
							$imageurl     = $thisimage[0];
							$inside       .= '<img src="' . esc_url( $imageurl ) . '" alt=""> ';
							$inside_found = true;
						}
					}



					$inside .= apply_filters( 'the_title', $item->title, $item->ID );

				$item_output .= $args->link_before . $inside . $args->link_after;

				$item_output .= '</a>';
				$item_output .= $args->after;
				$output      .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
			}
		}


		/**
		 * Traverse elements to create list from elements.
		 * Display one element if the element doesn't have any children otherwise,
		 * display the element and its children. Will only traverse up to the max
		 * depth and no ignore elements under that depth.
		 * This method shouldn't be called directly, use the walk() method instead.
		 *
		 * @param mixed $element Data object.
		 * @param mixed $children_elements List of elements to continue traversing.
		 * @param mixed $max_depth Max depth to traverse.
		 * @param mixed $depth Depth of current element.
		 * @param mixed $args Arguments.
		 * @param mixed $output Passed by reference. Used to append additional content.
		 *
		 * @return null Null on failure with no changes to parameters.
		 * @since  2.5.0
		 * @access public
		 *
		 * @see    Walker::start_el()
		 */
		public
		function display_element(
			$element, &$children_elements, $max_depth, $depth, $args, &$output
		) {
			if ( ! $element ) {
				return;
			}
			$id_field = $this->db_fields['id'];
			// Display this element.
			if ( is_object( $args[0] ) ) {
				$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
			}
			parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
		}

		/**
		 * Menu Fallback
		 * =============
		 * If this function is assigned to the wp_nav_menu's fallback_cb variable
		 * and a menu has not been assigned to the theme location in the WordPress
		 * menu manager the function with display nothing to a non-logged in user,
		 * and will add a link to the WordPress menu manager if logged in as an admin.
		 *
		 * @param array $args passed from the wp_nav_menu function.
		 */
		public
		static function fallback(
			$args
		) {
			if ( current_user_can( 'edit_theme_options' ) ) {
				/* Get Arguments. */
				$container       = $args['container'];
				$container_id    = $args['container_id'];
				$container_class = $args['container_class'];
				$menu_class      = $args['menu_class'];
				$menu_id         = $args['menu_id'];
				if ( $container ) {
					echo '<' . esc_attr( $container );
					if ( $container_id ) {
						echo ' id="' . esc_attr( $container_id ) . '"';
					}
					if ( $container_class ) {
						echo ' class="' . sanitize_html_class( $container_class ) . '"';
					}
					echo '>';
				}
				echo '<ul';
				if ( $menu_id ) {
					echo ' id="' . esc_attr( $menu_id ) . '"';
				}
				if ( $menu_class ) {
					echo ' class="' . esc_attr( $menu_class ) . '"';
				}
				echo '>';
				echo '<li><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" title="">' . esc_attr( 'Add a menu', '' ) . '</a></li>';
				echo '</ul>';
				if ( $container ) {
					echo '</' . esc_attr( $container ) . '>';
				}
			}
		}
	}
}