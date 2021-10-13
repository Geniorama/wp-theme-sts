<?php

require_once('helpers.php');

if(!function_exists('sts_blog_func')){
    add_shortcode( 'sts_blog', 'sts_blog_func' );

    function sts_blog_func(){
        

        $args = array(
            'posts_per_page' => -1,
            'hide_empty' => true
        );

        $query = new WP_Query($args);

        $categories = get_categories($query);

        if($query->have_posts()){
            ob_start();
            ?>
            <div class="sts-blog-categories">
                
                <ul class="sts-blog-categories__list">
                    
                    <li class="sts-blog-categories__item">
                        <a href="#" class="sts-blog-categories__link active" data-cat="todo">Todo</a>
                    </li>
                    <?php foreach($categories as $cat):?>
                        <li class="sts-blog-categories__item">
                            <a href="#" class="sts-blog-categories__link" data-cat="cat-<?php echo $cat->slug ?>"><?php echo $cat->name ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <form class="sts-blog-categories__form">
                    <select name="" id="sts-blog-cat-mobile" class="sts-blog-categories__select">
                        <option value="todo">Todo</option>
                        <?php foreach($categories as $cat):?>
                            <option value="cat-<?php echo $cat->slug ?>"><?php echo $cat->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>

            <section class="sts-blog-section">
                <div class="sts-blog-section__row">
                    <?php while($query->have_posts()): $query->the_post(); 
                        $cats_post = get_the_category();
                        
                        ?>
                        
                        <div class="sts-blog-section__col <?php 
                            foreach($cats_post as $cat_post){
                                echo "cat-" . $cat_post->slug . " ";
                            }

                            ?>">
                            <div class="sts-blog-section__item">
                                <figure class="sts-blog-section__item__fig">
                                    <?php the_post_thumbnail( 'medium', array('class' => 'sts-blog-section__item__img') );?>
                                    <figcaption class="sts-blog-section__item__cap">
                                        <span class="sts-blog-section__item__date"><?php echo get_the_date(); ?></span>
                                        <a href="<?php the_permalink(); ?>" class="sts-blog-section__item__title__link"><h2 class="sts-blog-section__item__title"><?php the_title(); ?></h2></a>
                                        <p class="sts-blog-section__item__desc">
                                            <?php echo get_excerpt(70) ?>
                                        </p>
                                        <a href="<?php the_permalink(); ?>" class="sts-blog-section__item__more">
                                            LEER MÁS
                                        </a>
                                    </figcaption> 
                                </figure>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

                <div class="sts-text-center">
                    <button type="button" class="sts-blog-load-more" id="sts-blog-load-more" data-load="todo">
                        CARGAR MÁS
                    </button>
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