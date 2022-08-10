<?php

add_action( 'init', 'enjoy_define_tiles_block', 999 );      

function enjoy_define_tiles_block() {

    /** Wrapper Element */
    vc_map( array(
        "name" => __("Enjoy Reisen Kacheln", "enjoy"),
        "description" => "Zeigt neue Bilder und Text Kacheln an",
        "category" => __('Content'),
        "base" => "your_gallery",
        "as_parent" => array('only' => 'single_img'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
        "content_element" => true,
        "show_settings_on_create" => false,
        "is_container" => true,
        "params" => array(),
        "js_view" => 'VcColumnView'
      ) );

      /** Child Element */
      vc_map( array(
        "name" => __("Gallery Image", "my-text-domain"),
        "base" => "single_img",
        "content_element" => true,
        "as_child" => array('only' => 'your_gallery'), // Use only|except attributes to limit parent (separate multiple values with comma)
        "params" => array(
            // add params same as with any other content element
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
      ) );

    //Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
    if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
        class WPBakeryShortCode_Your_Gallery extends WPBakeryShortCodesContainer {
        }
    }

    if ( class_exists( 'WPBakeryShortCode' ) ) {
        class WPBakeryShortCode_Single_Img extends WPBakeryShortCode {
        }
    }
}