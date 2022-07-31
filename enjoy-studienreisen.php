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
            
            add_shortcode( 'enjoytiles', array( $this, 'render_enjoy_tiles' ) );

        }        

        //Map Component
        public function create_shortcode() {
        
            if (function_exists("vc_map") ) {
                
                vc_map( array(
                    "name" => __("Enjoy Reisen Studienreisen"),
                    "base" => "enjoystudy",
                    "description" => "Zeigt Studienreisen sortiert nach Monat an",
                    "category" => __('Content'),
//                    "params" => array(
//                       array(
//                          "type" => "textfield",
//                          "holder" => "div",
//                          "class" => "",
//                          "heading" => __("Text"),
//                          "param_name" => "foo",
//                          "value" => __("Default params value"),
//                          "description" => __("Description for foo param.")
//                       )
//                    )
                 ) );

                 vc_map( array(
                    "name" => __("Enjoy Reisen Kacheln"),
                    "base" => "enjoytiles",
                    "description" => "Zeigt neue Bilder und Text Kacheln an",
                    "category" => __('Content'),
//                    "params" => array(
//                       array(
//                          "type" => "textfield",
//                          "holder" => "div",
//                          "class" => "",
//                          "heading" => __("Text"),
//                          "param_name" => "foo",
//                          "value" => __("Default params value"),
//                          "description" => __("Description for foo param.")
//                       )
//                    )
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

            include "templates/enjoystudy_template.php";

            return ob_get_clean();

        }

    }

    new EnjoyStudy_Block();
}


/**
 * https://kb.wpbakery.com/docs/inner-api/vc_map/
 * https://developer.wordpress.org/plugins/plugin-basics/best-practices/
 * https://www.sodawebmedia.com/blog/how-to-create-a-new-wpbakery-visual-composer-component/
 * 
 */