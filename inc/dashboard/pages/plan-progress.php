<div class="sts-content-dashboard__plan-progress">
    <div class="sts-section-title">
        <h2 class="sts-section-title__text">TRIATLON</h2>
        <div class="sts-section-title__icons">
            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/icono-natacion.svg" alt="">
            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/icono-ciclismo.svg" alt="">
            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/icono-atletismo.svg" alt="">
        </div>
    </div>
    <div class="sts-progress-bar">
        <h5 class="sts-progress-bar__title">
            Progreso total
        </h5>

        <div class="sts-progress-bar__load">
            <div class="sts-progress-bar__load__cont">
                <span class="sts-progress-bar__load__back"></span>
                <span class="sts-progress-bar__load__progress" data-progress="35"></span>
            </div>
            <span class="sts-progress-bar__load__number">35%</span>
        </div>


        <?php
            $ids_products = do_shortcode( '[my_purchased_products]');
            $arr_ids= explode(",", $ids_products);
            echo do_shortcode( '[sts_show_content ids_tax="'.$ids_products.'"]');
        ?>

        <section class="sts-section-video">
        <div style="padding:56.25% 0 0 0;position:relative;">
        <iframe src="https://player.vimeo.com/video/667727469?h=e85613ece8&color=ffffff&title=0&byline=0&portrait=0&badge=0" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>
        </section>

        <section class="sts-section-info">
            <h3 class="sts-section-info__title">
                Lección 1
            </h3>  
        </section>
        
    </div>
</div>