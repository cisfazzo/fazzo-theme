<?php

namespace fazzo;

use Exception;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );

if ( ! class_exists( '\fazzo\nav_paged' ) ) {
	/**
	 * Menü mit Seitenfunktion
	 * @since 1.0.0
	 */
	class nav_paged {

		public $nav_items;
		public $nav_items_tree;
		public $nav_items_by_id;
		public $menu_order;
		public $current_depth;
		public $current_child_depth;
		public $parent_item;
		public $items_flat;
		public $output;
		public $current_parent;
		public $current_id;
		public $current_item;


		public function __construct( $menu, $args = [] ) {
			$this->nav_items = functions::get_nav_items( $menu, $args );
			if ( $this->nav_items ) {
				$this->current_id          = functions::get_id_by_url();
				$this->current_depth       = functions::get_current_menu_depth();
				$this->current_child_depth = functions::get_menu_depth_of_child();
				$this->current_item        = functions::get_nav_item_to_object_id( $this->current_id );


				//var_dump($this->current_item);

				if ( functions::is_object_not_empty( $this->current_item ) ) {
					if ( $this->current_depth != $this->current_child_depth ) {
						$this->current_parent = (int) $this->current_item->ID;
					} else {
						$this->current_parent = (int) $this->current_item->menu_item_parent;
					}
				}

				//var_dump($this->current_parent );

				$this->create_tree();
				$this->build_flat();
				$this->render();
				$this->output();
			}

		}

		public function create_tree() {
			$this->nav_items_tree  = [];
			$this->nav_items_by_id = [];
			$this->menu_order      = [];

			foreach ( $this->nav_items as $nav_item ) {

				$this->nav_items_by_id[ $nav_item->ID ] = $nav_item;

				if ( functions::is_empty( $nav_item->menu_item_parent ) ) {

					if ( ! functions::is_array( $this->nav_items_tree[0] ) ) {
						$this->nav_items_tree[0] = [];
					}
					if ( ! functions::is_array( $this->nav_items_tree[0][0] ) ) {
						$this->nav_items_tree[0][0] = [];
					}

					$this->nav_items_tree[0][0][ $nav_item->ID ] = $nav_item;

					$depth = 0;

				} else {

					$depth = functions::get_depth_by_nav_item( $nav_item );

					if ( $depth === false ) {
						continue;
					}

					if ( ! functions::is_array( $this->nav_items_tree[ $depth ] ) ) {
						$this->nav_items_tree[ $depth ] = [];
					}

					if ( ! functions::is_array( $this->nav_items_tree[ $depth ][ $nav_item->menu_item_parent ] ) ) {
						$this->nav_items_tree[ $depth ][ $nav_item->menu_item_parent ] = [];
					}

					$this->nav_items_tree[ $depth ][ $nav_item->menu_item_parent ][ $nav_item->ID ] = $nav_item;
				}

				if ( ! functions::is_array( $this->menu_order[ $depth ] ) ) {
					$this->menu_order[ $depth ] = [];
				}

				$this->menu_order[ $depth ][ $nav_item->menu_order ] = $nav_item->ID;
			}
		}

		public function build_flat() {

			$this->items_flat = [];

			$order = $this->menu_order[ $this->current_child_depth ];
			$items = $this->nav_items_tree[ $this->current_child_depth ];

			foreach ( $items as $parent => $item ) {
				if ( empty( $parent ) ) {
					$items = $items[0];
					break;
				} elseif ( $parent == $this->current_parent ) {
					$items = $items[ $parent ];
					break;
				}
			}

			if ( ! empty( $parent ) ) {
				$this->parent_item = $this->nav_items_by_id[ $parent ];

				$this->parent_item->url = functions::remove_url_last_path( $this->parent_item->url );

			} else {
				$this->parent_item = false;
			}

			if ( $this->parent_item ) {
				$this->items_flat[] = $this->parent_item;
			}

			foreach ( $order as $item_id ) {
				if ( isset( $items[ $item_id ] ) ) {
					$this->items_flat[] = $items[ $item_id ];
				}
			}


		}

		public function render() {
			$this->output = "";
			$classes      = "";
			if ( ! functions::is_empty_array( $this->items_flat ) ) {
				$this->output .= "<ul class='paged-menu'>";
				foreach ( $this->items_flat as $item ) {

					if ( functions::is_object_not_empty( $this->current_item ) && $this->current_item->ID == $item->ID ) {
						$classes .= " active";
					}
					if ( functions::nav_item_has_childs( (int) $item->object_id ) ) {
						$classes .= " dropdown";
					}

					if ( ! empty( $classes ) ) {
						$class = " class='" . $classes . "'";
					} else {
						$class = "";
					}

					$this->output .= "<li" . $class . "><a href='" . $item->url . "'><span>" . $item->title . "</span></a></li>";

					$classes = "";
				}
				$this->output .= "</ul>";
			}

		}

		public function output() {
			echo $this->output;
		}

	}

}