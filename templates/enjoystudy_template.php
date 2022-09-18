<?php

$the_query = new WP_Query( array(
    'post_type' => 'tour-item',
    'meta_query' => array(
        'relation'		=> 'AND',
        array(
            'key'	 	=> 'ist_studienreise',
            'value'	  	=> true,
            'compare' 	=> '=',
        ),
        array(
            'key'	  	=> 'from',
            'value'	  	=> date("Ymd"),
            'compare' 	=> '>=',
        )
    ),
    'meta_key'			=> 'from',
    'orderby'			=> 'meta_value',
    'order'				=> 'ASC'
) );

?>
<div class="studienreise-block">
    <?php if ( $the_query->have_posts() ) : ?>

        <?php $current_month = ""; ?>

        <!-- the loop -->
        <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

            <?php

            $post_id = get_the_ID();

            $tour_from_as_string = get_field("from");
            $tour_from_as_date = DateTime::createFromFormat("Ymd", $tour_from_as_string);

            $formatter = new IntlDateFormatter('de_DE', IntlDateFormatter::SHORT, IntlDateFormatter::SHORT);
            $formatter->setPattern('MMMM yyyy');

            if($current_month != $formatter->format($tour_from_as_date) ) {

                $current_month = $formatter->format($tour_from_as_date);
                
                echo "<h2 class='current-month'>".$current_month."</h2>";

            }

            $formatter->setPattern("dd. MM. yyyy");
            $from_string = $formatter->format( DateTime::createFromFormat("Ymd", get_field("from")) );
            $to_string = $formatter->format( DateTime::createFromFormat("Ymd", get_field("to")) );
            ?>

            


            <div class="row">
                <div class="col-12 col-md-4 tour-preview-image">
                    <?= get_the_post_thumbnail() ?>
                </div>

                <div class="col-12 col-md-5">
                    <a href="<?= get_the_permalink() ?>">
                        <h3 class="tour-name"><?php the_title(); ?> <small><?php if(isset(get_post_meta($post_id, "eltd_tours_price")[0])) echo "€ " . get_post_meta($post_id, "eltd_tours_price")[0] ?>,- </small> </h3>
                        <div class="tour-date"><?= $from_string; ?> - <?= $to_string; ?></div>
                        <p class="tour-abstract"><?= get_the_excerpt(); ?></p>
                    </a>
                </div>

                <div class="col-12 col-md-3 guide">
                    <?= wp_get_attachment_image( get_field("tour_guide"), array(200, 200), false, array('class' => 'mx-auto d-block guide-photo')); ?>
                    <h3 class="text-center guide-name"><?= get_field("name") ?></h3>
                </div>
            </div>



        <?php endwhile; ?>
        <!-- end of the loop -->

        <?php wp_reset_postdata(); ?>

    <?php else : ?>
    <p><?php _e( 'Sorry, no posts dfdasdsdfa your criteria.' ); ?></p>
    <?php endif; ?>

</div>

<?php wp_reset_postdata(); ?>
