<?php

namespace fazzo;

use Exception;

$dir_root = dirname( __FILE__ ) . "/../../";
require_once( $dir_root . "security.php" );

if ( ! class_exists( '\fazzo\customizer_script' ) ) {
	/**
	 * Funktionsklasse
	 * @since 1.0.0
	 */
	class customizer_script {
		/**
		 * Die ID
		 * @since  1.0.0
		 * @access public
		 * @var string
		 */
		public $id = null;

		/**
		 * PHP constructor.
		 * @since  1.0.0
		 * @access public
		 */
		public function __construct( $id ) {

			$this->id = $id;
			add_action( 'customize_controls_enqueue_scripts', [ $this, "customizer_image_alignement" ] );
		}

		/**
		 * Customizer Control enqueue Scripts and Styles
		 * @return void
		 * @since  1.0.0
		 * @access public
		 */
		public function customizer_image_alignement() {

			$id = $this->id;

			wp_register_script( 'fazzo-theme-' . $this->id, get_template_directory_uri() . '/js/customizer_image_alignement.js', [
				'jquery',
				'customize-preview',
			], fazzo::version, true );


			$translation_array = array(
				'publish' => __( "Publish", "fazzotheme" ),
			);

			wp_localize_script( 'fazzo-theme-' . $this->id, 'trans', $translation_array );

			wp_enqueue_script( 'fazzo-theme-' . $this->id );

			$js_content = <<<JS
jQuery(document).ready(function($) {
    
    $("#customize-control-{$this->id}_position_x").css("display", "none");
    $("#customize-control-{$this->id}_position_y").css("display", "none");

    $("#{$this->id}_position-wrapper .fazzo-back-pos").click(function() {
        $( ".background-position-control input" ).attr('checked', false);
        $(this).prev( "input" ).attr('checked', true);
        
        var value = $(this).prev( "input" ).val();
        var arr = value.split(" ");

        $("#_customize-input-{$this->id}_position_x").val(arr[0]);
        $("#_customize-input-{$this->id}_position_x").trigger("change");
        $("#_customize-input-{$this->id}_position_y").val(arr[1]);
        $("#_customize-input-{$this->id}_position_y").trigger("change");



    });
});


JS;
			wp_add_inline_script( 'fazzo-theme-' . $this->id, $js_content, 'after' );


		}


	}
}