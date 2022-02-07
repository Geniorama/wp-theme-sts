<?php

if(!function_exists('sts_flipcards_func')){
    add_shortcode( 'sts_flipcards', 'sts_flipcards_func' );

    function sts_flipcards_func(){
        $args = array(
            'post_type' => 'sts_services',
            'post_per_page' => -1,
            'order' => 'ASC'
        );

        $query = new WP_Query($args);

        if($query->have_posts()){
            ob_start();
            ?>
            <div class="sts-row-services">
                <?php while($query->have_posts()): $query->the_post();?>
                    <?php 
                        $icono = get_field('icono');
                        $icono_url = $icono['url'];

                        $link = get_field('link');
                        if(isset($link)){
                            $link_url = $link['url'];
                            $link_target = $link['target'];
                        }
                    ?>
                    <div class="sts-col-services">
                        <a href="<?php echo $link_url; ?>" class="sts-card-service" target="<?php echo $link_url; ?>">
                            <figure class="sts-card-service__fig">
                                <div class="sts-card-service__front" style="background-image: url('<?php the_post_thumbnail_url( 'full' ); ?>')">
                                    <img src="<?php echo $icono_url; ?>" alt="" class="sts-card-service__front__icon">
                                    <hr class="sts-card-service__front__divider">
                                    <h4 class="sts-card-service__front__title"><?php the_title(); ?></h4>
                                    <hr class="sts-card-service__front__divider">
                                </div>
                                <div class="sts-card-service__back">
                                    <h4 class="sts-card-service__back__title"><?php the_title(); ?></h4>
                                    <p class="sts-card-service__back__desc">
                                        <?php the_field('descripcion'); ?>
                                        <?php if(get_field('texto_del_boton')): ?>
                                            <button class="sts-card-service__back__desc__btn"><?php the_field('texto_del_boton') ?></button>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </figure>
                        </a>
                    </div>

                <?php endwhile; ?>
            </div>
            <?php
        } else {
            echo "No hay posts";
        }

        wp_reset_query();
        return ob_get_clean();
    }
}