<?php

if(!function_exists('sts_slider_coach_func')){
    add_shortcode( 'sts_slider_coach', 'sts_slider_coach_func' );

    function sts_slider_coach_func(){
        $args = array(
            'post_type' => 'sts_coach',
            'posts_per_page' => -1
        );

        $query = new WP_Query($args);

        if($query->have_posts()){
            ob_start();
            ?>
            <section class="sts-slider-about" id="sts-slider-about">
                <div class="sts-slick-about slick-theme">
                    <?php while($query->have_posts()): $query->the_post()?>
                    <div class="sts-slick-about__item">
                        <div class="sts-slick-about__item__cont">
                            <img src="<?php the_field('icono') ?>" alt="" class="sts-slick-about__item__cont__icon">
                            <h5 class="sts-slick-about__item__cont__pos"><?php the_field('posicion') ?></h5>
                            <h3 class="sts-slick-about__item__cont__name">
                                <?php the_title(); ?>
                            </h3>
        
                            <div class="sts-slick-about__item__cont__row">
                                <div class="sts-slick-about__item__cont__col col-1">
                                    <?php
                                        the_content();
                                    ?>
                                </div>
                                <div class="sts-slick-about__item__cont__col col-2">
                                    <?php the_post_thumbnail( 'full', array('class' => 'sts-slick-about__item__cont__photo') ) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </section>

            <?php
        } else {
            echo "No hay publicaciones";
        }

        wp_reset_query();

        return ob_get_clean();
    }

}