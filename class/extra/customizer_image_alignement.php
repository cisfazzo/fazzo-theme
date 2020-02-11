<?php

namespace fazzo;

use Exception;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );

if ( ! class_exists( '\fazzo\customizer_image_alignement' ) && class_exists( '\WP_Customize_Control' ) ) {

	class customizer_image_alignement extends \WP_Customize_Control {

		public $type = 'image_alignement';

		public function __construct( $manager, $id, $args = array() ) {
			parent::__construct( $manager, $id, $args );

			add_action( 'admin_menu', array( $this, 'init' ) );
		}


		/**
		 * Set up the hooks for the Custom Background admin page.
		 *
		 * @since 3.0.0
		 */
		public function init() {
			$page = add_theme_page( __( 'Background' ), __( 'Background' ), 'edit_theme_options', 'custom-background', array(
				$this,
				'admin_page'
			) );
			if ( ! $page ) {
				return;
			}
			add_action( "load-{$page}", array( $this, 'take_action' ), 49 );
		}


		/**
		 * Execute custom background modification.
		 *
		 * @since 3.0.0
		 */
		public function take_action() {
			if ( empty( $_POST ) ) {
				return;
			}

			if ( isset( $_POST['background-position'] ) ) {
				check_admin_referer( 'custom-background' );

				$position = explode( ' ', $_POST['background-position'] );

				if ( in_array( $position[0], array( 'left', 'center', 'right' ), true ) ) {
					$position_x = $position[0];
				} else {
					$position_x = 'left';
				}

				if ( in_array( $position[1], array( 'top', 'center', 'bottom' ), true ) ) {
					$position_y = $position[1];
				} else {
					$position_y = 'top';
				}

				set_theme_mod( 'background_position_x', $position_x );
				set_theme_mod( 'background_position_y', $position_y );
			}
		}


		/**
		 * Render the control's content.
		 */
		public function render_content() {

			$background_position = sprintf(
				'%s %s',
				get_theme_mod( $this->id . '_x', fazzo::$customizer_elements[ $this->id . '_position_x' ] ),
				get_theme_mod( $this->id . '_y', fazzo::$customizer_elements[ $this->id . '_position_y' ] )
			);

			?>
            <div class="wrap" id="<?php echo $this->id; ?>-wrapper">

                <table class="form-table" role="presentation">
                    <tbody>
                    <input name="background-preset" type="hidden" value="custom">

					<?php
					$background_position_options = array(
						array(
							'left top'   => array(
								'label' => __( 'Top Left' ),
								'icon'  => 'dashicons dashicons-arrow-left-alt',
							),
							'center top' => array(
								'label' => __( 'Top' ),
								'icon'  => 'dashicons dashicons-arrow-up-alt',
							),
							'right top'  => array(
								'label' => __( 'Top Right' ),
								'icon'  => 'dashicons dashicons-arrow-right-alt',
							),
						),
						array(
							'left center'   => array(
								'label' => __( 'Left' ),
								'icon'  => 'dashicons dashicons-arrow-left-alt',
							),
							'center center' => array(
								'label' => __( 'Center' ),
								'icon'  => 'background-position-center-icon',
							),
							'right center'  => array(
								'label' => __( 'Right' ),
								'icon'  => 'dashicons dashicons-arrow-right-alt',
							),
						),
						array(
							'left bottom'   => array(
								'label' => __( 'Bottom Left' ),
								'icon'  => 'dashicons dashicons-arrow-left-alt',
							),
							'center bottom' => array(
								'label' => __( 'Bottom' ),
								'icon'  => 'dashicons dashicons-arrow-down-alt',
							),
							'right bottom'  => array(
								'label' => __( 'Bottom Right' ),
								'icon'  => 'dashicons dashicons-arrow-right-alt',
							),
						),
					);

					?>
                    <tr>
                        <th scope="row"><?php _e( 'Image Position' ); ?></th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text"><span><?php _e( 'Image Position' ); ?></span>
                                </legend>
                                <div class="background-position-control">
									<?php foreach ( $background_position_options as $group ) : ?>
                                        <div class="button-group">
											<?php foreach ( $group as $value => $input ) : ?>
                                                <label>
                                                    <input class="screen-reader-text" name="background-position"
                                                           type="radio"
                                                           value="<?php echo esc_attr( $value ); ?>"<?php checked( $value, $background_position ); ?>>
                                                    <span class="button display-options position fazzo-back-pos"><span
                                                                class="<?php echo esc_attr( $input['icon'] ); ?>"
                                                                aria-hidden="true"></span></span>
                                                    <span class="screen-reader-text"><?php echo $input['label']; ?></span>
                                                </label>
											<?php endforeach; ?>
                                        </div>
									<?php endforeach; ?>
                                </div>
                            </fieldset>
                        </td>
                    </tr>
                    </tbody>
                </table>

				<?php
				wp_nonce_field( 'custom-background' );
				?>

            </div>
			<?php
		}


	}

}

