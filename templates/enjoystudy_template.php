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

setlocale(LC_ALL, "de-DE");

?>

<?php if ( $the_query->have_posts() ) : ?>

    <?php $current_month = ""; ?>

    <!-- the loop -->
    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

        <?php

        $post_id = get_the_ID();

        $tour_from_as_string = get_field("from");
        $tour_from_as_date = DateTime::createFromFormat("Ymd", $tour_from_as_string);

        if($current_month != $tour_from_as_date->format("F Y")) {

            $current_month = $tour_from_as_date->format("F Y");

            echo "<h2 class='current-month'>".$current_month."</h2>";

        }

        ?>


        <div class="row">
            <div class="col-12 col-md-3">
                <?= get_the_post_thumbnail() ?>
            </div>

            <div class="col-12 col-md-7">
                <a href="<?= get_the_permalink() ?>">
                    <h3><?php the_title(); ?> <small><?= get_post_meta($post_id, "eltd_tours_price")[0] ?>,- </small> </h3>
                    <p><?= get_the_excerpt(); ?></p>
                </a>
            </div>

            <div class="col-12 col-md-2">
                <?= wp_get_attachment_image( get_field("tour_guide"), array(150, 150), false, array('class' => 'rounded-circle mx-auto d-block')); ?>
                <h3 class="text-center"><?= get_field("name") ?></h3>
            </div>
        </div>



    <?php endwhile; ?>
    <!-- end of the loop -->

    <?php wp_reset_postdata(); ?>

<?php else : ?>
 <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>



<?php wp_reset_postdata(); ?>