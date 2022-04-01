<?php

/**
 * Plugin Name:     Enjoy Studienreisen
 * Plugin URI:      marginleft.at
 * Description:     Adds Studienreisen Block to the enjoy theme
 * Author:          Manuel Szecsenyi
 * Author URI:      marginleft.at
 * Text Domain:     enjoy-studienreisen
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Enjoy_Studienreisen
 */

if (!class_exists("EnjoyStudy_Plugin")) {
    class EnjoyStudy__Plugin
    {
        public static function init() {

        }
    }
}


if (!class_exists("EnjoyStudy_Block")) {

    class EnjoyStudy_Block {

        //Initialize Component
        function __construct() {
            add_action( 'init', array( $this, 'create_shortcode' ), 999 );            
            add_shortcode( 'enjoystudy', array( $this, 'render_shortcode' ) );

        }        

        //Map Component
        public function create_shortcode() {
        
            vc_map( array(
                "name" => __("Enjoy Reisen Studienreisen"),
                "base" => "enjoystudy",
                "description" => "Zeigt Studienreisen sortiert nach Monat an",
                "category" => __('Content'),
                "params" => array(
                   array(
                      "type" => "textfield",
                      "holder" => "div",
                      "class" => "",
                      "heading" => __("Text"),
                      "param_name" => "foo",
                      "value" => __("Default params value"),
                      "description" => __("Description for foo param.")
                   )
                )
             ) );

        }

        //Render Component
        public function render_shortcode( $atts, $content, $tag ) {
            //Code in the next steps
            return "Hello world";
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