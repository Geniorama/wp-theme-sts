
<ul class="sts-menu-dashboard">
    <?php 
        
        $data_products = do_shortcode( '[my_purchased_products]');
        $data_products_decode = json_decode($data_products);

        $ids_products = $data_products_decode->product_ids;

        $arr_ids= explode(",", $ids_products);
    ?>
    <div class="sts-menu-dashboard__top">
        <li class="sts-menu-dashboard__item">
            <a data-target="#tab-profile" class="sts-menu-dashboard__item__link active sts-tab-link" href="#">Mi perfil</a>
        </li>
        <li class="sts-menu-dashboard__item">
            <a data-target="#tab-scores" class="sts-menu-dashboard__item__link sts-tab-link" href="#">Personal Records</a>
        </li>

        <li class="sts-menu-dashboard__item">
            <a class="sts-menu-dashboard__item__link sts-tab-link sts-has-submenu" href="#">
                Mis planes
                <span class="sts-menu-dashboard__item__link__toggle">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z" fill="rgba(255,255,255,1)"/></svg>
                </span>
            </a>
            <ul class="sts-submenu-dashboard">
                <?php foreach($arr_ids as $item): ?>
                    <li>
                        <a data-target="#tab-plan-progress" href="#" class="sts-menu-dashboard__item__link sts-tab-link">
                            <?php 
                                $product_id = intval($item); 
                                echo get_the_title($product_id); 
                            ?>
                        </a>
                    </li>
                <?php endforeach; ?>    
            </ul>
        </li>
    </div>

    <div class="sts-menu-dashboard__bottom">
        <!-- <li class="sts-menu-dashboard__item">
            <a data-target="" class="sts-menu-dashboard__item__link" href="#">Editar perfil</a>
        </li> -->

        <li class="sts-menu-dashboard__item">
            <a class="sts-menu-dashboard__item__link" href="<?php echo wp_logout_url( site_url() ); ?>">Cerrar sesión</a>
        </li>
    </div>
</ul>