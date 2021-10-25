<?php

if(!function_exists('sts_slider_home_func')){
    add_shortcode( 'sts_slider_home', 'sts_slider_home_func' );
    function sts_slider_home_func(){
        $args = array(
            'post_type' => 'sts_slider',
            'posts_per_page' => -1,
            'order' => 'ASC'
        );

        $query = new WP_Query($args);

        if($query->have_posts()){
            ob_start();
            ?>
            <div class="sts-slick-home">
               <?php while($query->have_posts()): $query->the_post(); ?>
                <div class="sts-slick-home__item">
                    <?php 
                        $alineacion_contenido = get_field('orientacion_contenido');
                        
                        if($alineacion_contenido == "Centro"){
                            $alineacion_contenido = "";
                        } elseif($alineacion_contenido == "Izquierda"){
                            $alineacion_contenido = "content-left";
                        } elseif($alineacion_contenido == "Derecha"){
                            $alineacion_contenido = "content-right";
                        }
                    ?>
                    <figure class="sts-slick-home__fig sts-parallax <?php echo $alineacion_contenido; ?>">
                        <?php the_post_thumbnail( 'full', array('class'=>'sts-slick-home__img') ); ?>
                        
                        <figcaption class="sts-slick-home__cap" data-depth="0.2">
                            <?php
                                $titulo = get_field('titulo');
                            ?>
                            
                            <h2 class="sts-slick-home__cap__title ">
                                <!-- Texto 1 -->
                                <?php if(isset($titulo['texto_1'])): ?>
                                    <span class="sts-slick-home__cap__title__1"><?php echo $titulo['texto_1']; ?></span>
                                <?php endif; ?>
                                
                                <!-- Texto 2 -->
                                <?php if(isset($titulo['texto_2'])): ?>
                                    <span class="sts-slick-home__cap__title__2"><?php echo $titulo['texto_2']; ?></span>
                                <?php endif; ?>
                            </h2>
                            <div class="sts-slick-home__cap__desc ">
                                <?php the_field('descripcion'); ?>
                            </div>

                            <div class="sts-slick-home__buttons">
                                <!-- Botón Secundario -->
                                <?php 
                                    $boton_secundario = get_field('boton_secundario');
                                    if(isset($boton_secundario) && strlen($boton_secundario['texto_boton']) > 0){
                                        $link_btn_secundario = $boton_secundario['link_boton'];
                                        ?>  
                                            <a href="<?php echo $link_btn_secundario['url'] ?>" target="<?php echo $link_btn_secundario['target']; ?>" class="sts-slick-home__cta secondary">
                                                <span class="sts-slick-home__cta__text"><?php echo $boton_secundario['texto_boton']; ?></span>
                                            </a>
                                        <?php
                                    }
                                ?>

                                <!-- Botón Principal -->
                                <?php 
                                    $boton_principal = get_field('boton');
                                    if(isset($boton_principal) && strlen($boton_principal['texto_boton']) > 0){
                                        $link_btn_principal = $boton_principal['link_boton'];
                                        ?>
                                        <a href="<?php echo $link_btn_principal['url'] ?>"  target="<?php echo $link_btn_principal['target']; ?>" class="sts-slick-home__cta primary" >
                                            <span class="sts-slick-home__cta__text"><?php echo $boton_principal['texto_boton']; ?></span>
                                        </a>
                                        <?php
                                    }
                                ?>
                                
                            </div>
                        </figcaption>
                    </figure>
                </div>
               <?php endwhile; ?>
            </div>
            <?php
        } else {
            echo "No hay banners";
        }

        wp_reset_query();
        return ob_get_clean();
    }
}