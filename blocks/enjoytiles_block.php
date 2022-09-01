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
        "name" => __("Enjoy Galerie Objekt", "enjoy"),
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
                'param_name' => 'content',
                "admin_label" => true,
            ),
            array(
                'type' => 'vc_link',
                'value' => '',
                'heading' => esc_html__( 'Verlinkung', 'enjoy' ),
                'param_name' => 'enjoy_tiles_link',
                "admin_label" => true,
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

add_shortcode( 'single_img', 'render_enjoy_tiles');
function render_enjoy_tiles( $atts, $content, $tag ) {
    //Code in the next steps
    ob_start();

    extract(shortcode_atts(array(
        'enjoy_tiles_background_image' => '',
        'enjoy_tiles_link' => '',
    ), $atts));

//    var_dump(vc_build_link($enjoy_tiles_link));
    ?>

    <a <?php if($enjoy_tiles_link): ?>href="<?= vc_build_link($enjoy_tiles_link)['url'] ?>" <?php endif; ?> class="enjoy-tile" data-aos="fade-up" style='background-image: url("<?= wp_get_attachment_image_url($enjoy_tiles_background_image, 'full ') ?>")'>

        <?php if(!$enjoy_tiles_background_image): ?>
            <div class="enjoy-tile-inner">
                <?= $content ?>
            </div>
        <?php endif; ?>


    </a>

    <?php

    return ob_get_clean();

}

add_shortcode( 'your_gallery', 'render_enjoy_tiles_wrapper');
function render_enjoy_tiles_wrapper( $atts, $content, $tag ) {
    //Code in the next steps
    ob_start();

    ?>

    <div class="enjoy-gallery-wrapper">
        <?= do_shortcode($content) ?>
    </div>
    
    <style>
        .enjoy-gallery-wrapper {
            display: flex;
            flex-wrap: wrap;
        }

        a.enjoy-tile.aos-init.aos-animate:hover {
            transform: scale(1.03);
        }

        .enjoy-tile {
            width: calc((100% / 4) - 30px);
            margin: 5px;
            background-color: rgba(182, 146, 90, 1);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            height: 400px;
            padding: 10px;
            transition: transform 0.3s;
            display: block;
        }



        .enjoy-tile-inner {
            width: calc(100% - 20px);
            height: calc(100% - 20px);
            border: 1px solid white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white !important;
            padding: 10px;
        }

        .enjoy-tile-inner h1,
        .enjoy-tile-inner h2,
        .enjoy-tile-inner h3,
        .enjoy-tile-inner h4,
        .enjoy-tile-inner h5, {
            color: white !important;
        }

        @media only screen and (max-width: 1025px){
            .enjoy-tile {
                width: calc((100% / 3) - 30px);
            }
        }

        @media only screen and (max-width: 778px){
            .enjoy-tile {
                width: calc((100% / 2) - 30px);
                height: 300px
            }
        }

    </style>

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        AOS.init();
    </script>

    <?php

    return ob_get_clean();

}

