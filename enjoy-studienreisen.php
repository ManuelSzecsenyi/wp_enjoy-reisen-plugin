<?php

/**
 * Plugin Name:     Enjoy Blocks
 * Plugin URI:      marginleft.at
 * Description:     Adds new blocks to the enjoy theme
 * Author:          Manuel Szecsenyi
 * Author URI:      marginleft.at
 * Text Domain:     enjoy-reisen
 * Domain Path:     /languages
 * Version:         1.2.0
 *
 * @package         Enjoy_Studienreisen
 */

if (!class_exists("EnjoyStudy_Plugin")) {
    class EnjoyStudy__Plugin
    {
        public function __construct() {
            add_action('wp_enqueue_scripts', array($this, 'add_styles') );

            $this->register_acf_fields();

        }


        function add_styles() {
            wp_register_style( 'enjoy-reisen-grid', plugins_url('css/bootstrap-grid.min.css', __FILE__) );
            wp_register_style( 'enjoy-reisen-util', plugins_url('css/bootstrap-utilities.min.css', __FILE__) );
            wp_register_style( 'enjoy-reisen-fontawesome-duotone', plugins_url('css/duotone.min.css', __FILE__) );
            wp_register_style( 'enjoy-reisen-fontawesome-solid', plugins_url('css/solid.min.css', __FILE__) );

            wp_enqueue_style( 'enjoy-reisen-grid' );
            wp_enqueue_style( 'enjoy-reisen-util' );
            wp_enqueue_style( 'enjoy-reisen-fontawesome-duotone' );
            wp_enqueue_style( 'enjoy-reisen-fontawesome-solid' );
        }

        function register_acf_fields() {
            include "acf/enjoy-study-fields.php";
        }
    }

    new EnjoyStudy__Plugin();
}


if (!class_exists("EnjoyStudy_Block")) {

    class EnjoyStudy_Block {

        //Initialize Component
        function __construct() {
            add_action( 'init', array( $this, 'create_shortcode' ), 999 );            
            add_shortcode( 'enjoystudy', array( $this, 'render_shortcode' ) );
            
            // add_shortcode( 'enjoytiles', array( $this, 'render_enjoy_tiles' ) );

        }        

        //Map Component
        public function create_shortcode() {
        
            if (function_exists("vc_map") ) {
                
                vc_map( array(
                    "name" => __("Enjoy Reisen Studienreisen"),
                    "base" => "enjoystudy",
                    "description" => "Zeigt Studienreisen sortiert nach Monat an",
                    "category" => __('Content')
                 ) );

                 vc_map( array(
                    "name" => __("Enjoy Reisen Kacheln"),
                    "base" => "enjoytiles_wrapper",
                    "description" => "Zeigt neue Bilder und Text Kacheln an",
                    "category" => __('Content'),
                    "as_parent" => array('only' => 'enjoytiles_tile'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
                    "content_element" => true,
                    "show_settings_on_create" => false,
                    "js_view" => 'VcColumnView'
                 ) );

                 vc_map( array(
                    "name" => __("Gallery Image", "my-text-domain"),
                    "base" => "enjoytiles_tile",
                    "content_element" => true,
                    "as_child" => array('only' => 'enjoytiles_wrapper'), // Use only|except attributes to limit parent (separate multiple values with comma)
                    "params" => array(
                        array(
                            'type' => 'loop',
                            'value' => '',
                            'heading' => esc_html__( 'Hintergrundbild', 'enjoy' ),
                            'param_name' => 'dasfeuub',
                        ),
                        array(
                            'type' => 'param_group',
                            'value' => '',
                            'heading' => esc_html__( 'Kacheln', 'enjoy' ),
                            'param_name' => 'services',
                            'params' => array(
                            array(
                                'type' => 'attach_image',
                                'value' => '',
                                'heading' => esc_html__( 'Hintergrundbild', 'enjoy' ),
                                'param_name' => 'enjoy_tiles_background_image',
                            ),
                            array(
                                'type' => 'textarea_html',
                                'value' => '',
                                'heading' => esc_html__( 'Text Overlay', 'enjoy' ),
                                'param_name' => 'enjoy_tiles_overlay_text',
                            ),
                            array(
                                'type' => 'vc_link',
                                'value' => '',
                                'heading' => esc_html__( 'Verlinkung', 'enjoy' ),
                                'param_name' => 'enjoy_tiles_link',
                            ),
                            )
                        ),
                    )
                 ) );

            }
            

        }

        //Render Component
        public function render_shortcode( $atts, $content, $tag ) {
            //Code in the next steps
            ob_start();

            include "templates/enjoystudy_template.php";

            return ob_get_clean();
        }

        public function render_enjoy_tiles( $atts, $content, $tag ) {
            //Code in the next steps
            ob_start();

            include "templates/enjoytiles_template.php";

            return ob_get_clean();

        }

    }

    new EnjoyStudy_Block();
}

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_enjoytiles_wrapper extends WPBakeryShortCodesContainer {

        function __construct() {
            add_action( 'init', array( $this, 'protechsaas_featured_block_mapping' ) );
            add_shortcode( 'enjoytiles_wrapper', array( $this, 'enjoytiles_wrapper_html' ) );
        }

        public function create_shortcode() {
        
            if (function_exists("vc_map") ) {

                 vc_map( array(
                    "name" => __("Enjoy Reisen Kacheln"),
                    "base" => "enjoytiles_wrapper",
                    "description" => "Zeigt neue Bilder und Text Kacheln an",
                    "category" => __('Content'),
                    "as_parent" => array('only' => 'enjoytiles_tile'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
                    "content_element" => true,
                    "show_settings_on_create" => false,
                    "js_view" => 'VcColumnView'
                 ) );

            }

        }

        public function enjoytiles_wrapper_html( $atts, $content, $tag ) {
            //Code in the next steps
            ob_start();

            include "templates/enjoytiles_template.php";

            return ob_get_clean();

        }
        

    }

    new WPBakeryShortCode_enjoytiles_wrapper();
}

if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_enjoytiles_tile  extends WPBakeryShortCode {
        //Initialize Component
        function __construct() {
            add_action( 'init', array( $this, 'create_shortcode' ), 999 );            
            add_shortcode( 'enjoytiles_tile', array( $this, 'render_shortcode' ) );
            
        }        

        //Map Component
        public function create_shortcode() {
        
            if (function_exists("vc_map") ) {

                 vc_map( array(
                    "name" => __("Gallery Image", "my-text-domain"),
                    "base" => "enjoytiles_tile",
                    "content_element" => true,
                    "as_child" => array('only' => 'enjoytiles_wrapper'), // Use only|except attributes to limit parent (separate multiple values with comma)
                    "params" => array(
                        array(
                            'type' => 'loop',
                            'value' => '',
                            'heading' => esc_html__( 'Hintergrundbild', 'enjoy' ),
                            'param_name' => 'dasfeuub',
                        ),
                        array(
                            'type' => 'param_group',
                            'value' => '',
                            'heading' => esc_html__( 'Kacheln', 'enjoy' ),
                            'param_name' => 'services',
                            'params' => array(
                            array(
                                'type' => 'attach_image',
                                'value' => '',
                                'heading' => esc_html__( 'Hintergrundbild', 'enjoy' ),
                                'param_name' => 'enjoy_tiles_background_image',
                            ),
                            array(
                                'type' => 'textarea_html',
                                'value' => '',
                                'heading' => esc_html__( 'Text Overlay', 'enjoy' ),
                                'param_name' => 'enjoy_tiles_overlay_text',
                            ),
                            array(
                                'type' => 'vc_link',
                                'value' => '',
                                'heading' => esc_html__( 'Verlinkung', 'enjoy' ),
                                'param_name' => 'enjoy_tiles_link',
                            ),
                            )
                        ),
                    )
                 ) );

            }
            

        }

        public function render_enjoy_tiles( $atts, $content, $tag ) {
            //Code in the next steps
            ob_start();

            include "templates/enjoytiles_template.php";

            return ob_get_clean();

        }

    }

    new WPBakeryShortCode_enjoytiles_tile();
}


include 'blocks/enjoytiles_block.php';



/**
 * https://kb.wpbakery.com/docs/inner-api/vc_map/
 * https://developer.wordpress.org/plugins/plugin-basics/best-practices/
 * https://www.sodawebmedia.com/blog/how-to-create-a-new-wpbakery-visual-composer-component/
 * 
 */