<?php

if(!function_exists('sts_blog_func')){
    add_shortcode( 'sts_blog', 'sts_blog_func' );

    function sts_blog_func(){
        ob_start();
        ?>
        <div class="sts-blog-categories">
            <ul class="sts-blog-categories__list">
                <li class="sts-blog-categories__item">
                    <a href="#" class="sts-blog-categories__link active">Todo</a>
                </li>
                <li class="sts-blog-categories__item">
                    <a href="#" class="sts-blog-categories__link">Category 1</a>
                </li>
                <li class="sts-blog-categories__item">
                    <a href="#" class="sts-blog-categories__link">Category 2</a>
                </li>
                <li class="sts-blog-categories__item">
                    <a href="#" class="sts-blog-categories__link">Category 1</a>
                </li>
            </ul>

            <div class="sts-blog-categories__form">
                <form action="">
                    <select name="" id="">
                        <option value="todo">Todo</option>
                        <option value="todo">Category 1</option>
                        <option value="todo">Category 2</option>
                    </select>
                </form>
            </div>
        </div>

        <section class="sts-blog-section">
            <div class="sts-blog-section__row">
                <div class="sts-blog-section__col">
                    <div class="sts-blog-section__item">
                        <figure class="sts-blog-section__item__fig">
                            <img src="https://picsum.photos/1920/1280" alt="" class="sts-blog-section__item__img">
                            <figcaption class="sts-blog-section__item__cap">
                                <span class="sts-blog-section__item__date">20 agosto de 2021</span>
                                <h2 class="sts-blog-section__item__title">Lorem ipsum dolor sit</h2>
                                <p class="sts-blog-section__item__desc">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Augue gravida nec massa...
                                </p>
                                <a href="#" class="sts-blog-section__item__more">
                                    LEER MÁS
                                </a>
                            </figcaption> 
                        </figure>
                    </div>
                </div>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }
}