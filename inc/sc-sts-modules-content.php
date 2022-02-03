<?php

add_shortcode( 'sts_show_content', 'sts_show_content_func' );

function sts_show_content_func($atts){
    $atts = shortcode_atts( array(
        'content' => '',
        'title' => ''
    ), 
    $atts, 
    'sts_show_content'
    );

    $args = array(
        'post_type' => 'sts_modules',
        'order' => 'ASC',
        'tax_query' => array(
            array(
                'taxonomy' => 'sts_cat_modules',
                'field'    => 'slug',
                'terms'    => $atts['content'],
            ),
        ),
    );

    $query = new WP_Query($args);

    if($query->have_posts()){
        ?>
        <div class="sts-content-dashboard__plan-progress">
            <div class="sts-section-title">
                <h2 class="sts-section-title__text"><?php echo $atts['title'] ?></h2>
                <div class="sts-section-title__icons">
                    <?php if($atts['content'] == "natacion" || $atts['content'] == "triatlon"): ?>
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/icono-natacion.svg" alt="">
                    <?php endif; ?>

                    <?php if($atts['content'] == "ciclismo" || $atts['content'] == "triatlon"): ?>
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/icono-ciclismo.svg" alt="">
                    <?php endif; ?>
                    
                    <?php if($atts['content'] == "atletismo" || $atts['content'] == "triatlon"): ?>
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/icono-atletismo.svg" alt="">
                    <?php endif; ?>
                    
                </div>
            </div>
            
        </div>
        <div class="sts-slick-plan">
        <?php while($query->have_posts()): $query->the_post()?>
        <div class="sts-item-slick">
           <div>
            <section class="sts-section-video">
                <div class='embed-container'>
                    
                    <?php 
                    if(get_field('tipo-video') == "Youtube"){
                        the_field('video_youtube'); 
                    } elseif (get_field('tipo-video') == "Vimeo") {
                        the_field('video_vimeo'); 
                    } else {
                        the_field('video_importar');
                    }
                    ?>
                </div>
                <script src="https://player.vimeo.com/api/player.js"></script>
            </section>
            <section class="sts-section-info">
                <h3 class="sts-section-info__title">
                    <?php the_title(); ?>
                </h3>
                <div class="sts-section-info__desc">
                    <?php the_content(); ?>
                </div>
            </section>
           </div>
        </div>
        <?php endwhile; ?>
        </div>
        <?php   
        wp_reset_postdata();
    } else{
        echo "No hay posts";
    }
}