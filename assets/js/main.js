
// Inicializando AOS
AOS.init();

/**
 * passed_object from functions php
 */

const homeUrl = passed_object.home_url
const childThemeUrl = passed_object.child_theme_url
const childThemeImg = childThemeUrl + "/assets/img"

console.log(childThemeUrl)

// Inicializando Parallax
const scenes = document.querySelectorAll('.sts-parallax');

if(screen.width > 900){
    scenes.forEach(scene => {
        const parallaxInstance = new Parallax(scene, {
            relativeInput: true,
            pointerEvents: true
        })
    });
}



jQuery(function ($) {
    const stickyHeader = (header, headerSticky, scrolly) => {
        $('.sts-slick-home').fadeIn(1000)
        window.onscroll = function() {
            let y = window.scrollY;
            if(y > scrolly){
                $(header).addClass(headerSticky)
            } else {
                $(header).removeClass(headerSticky)
            }
        };
    }
    // Header sticky
    stickyHeader('.header-elements__bottom', 'sts-header-sticky', 600)

    // Disable link card services
    // $('.sts-card-service').on('click', (e)=>(e.preventDefault()));
    //Slick Plan Progress
    $('.sts-slick-plan').slick({
        speed: 1500,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        infinite: false,
        prevArrow: "<button class='sts-section-info__buttons__btn custom-prev'>← Anterior</button>",
        nextArrow: "<button class='sts-section-info__buttons__btn custom-next'>Siguiente →</button>",
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    speed: 300
                }
            }
        ]
    });

    // Slick home principal
	$('.sts-slick-home').slick({
        speed: 1500,
        autoplay: true,
        arrows: false,
        dots: true,
        autoplaySpeed: 10000,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    speed: 300
                }
            }
        ]
    });

    // Slick about home
    $('.sts-slick-home-about').slick({
        speed: 500,
        autoplay: true,
        arrows: true,
        prevArrow: "<button type='button' class='custom-arrow-2 prev-arrow'>ANTERIOR</button>",
        nextArrow: "<button type='button' class='custom-arrow-2 next-arrow'>SIGUIENTE</button>",
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    speed: 300
                }
            }
        ]
    });

    // Slick About coach
    $('.sts-slick-about').slick({
        arrows: true,
        dots: false,
        prevArrow: '<button type="button" class="custom-arrow-about custom-arrow-about__prev"><i class="fas fa-chevron-left"></i></button>',
        nextArrow: '<button type="button" class="custom-arrow-about custom-arrow-about__next"><i class="fas fa-chevron-right"></i></button>',
        autoplay: true
    });

    // Init items blog
    if(screen.width > 992){
        $('.sts-blog-section__col').slice(0, 9).show();
        if($(".sts-blog-section__col:visible").length < 9){
            $('#sts-blog-load-more').hide()
        } else {
            $('#sts-blog-load-more').show()
        }
    } else {
        $('.sts-blog-section__col').slice(0, 6).show();

        if($(".sts-blog-section__col:visible").length < 6){
            $('#sts-blog-load-more').hide()
        } else {
            $('#sts-blog-load-more').show()
        }
    }


    // Load more items
    function loadMore(items) {
        if(screen.width > 992){
            $(`${items}:hidden`).slice(0, 3).slideDown();
        } else {
            $(`${items}:hidden`).slice(0, 2).slideDown();
        }
        
        if($(`${items}:hidden`).length == 0) {
            $('#sts-blog-load-more').hide()
        }
    }
    
    $("#sts-blog-load-more").on("click", function(e){
        e.preventDefault();

        var dataLoad = $(this).attr('data-load')

        if(dataLoad != 'todo'){
            const loaditems = "." + dataLoad
            loadMore(loaditems)
        } else {
            loadMore('.sts-blog-section__col')
        }
    });


    // Load categories items
    function loadCat(items){
        $(".sts-blog-section__col").hide();
        
        if(screen.width > 992){
            $(items).slice(0, 9).fadeIn();
            if($(`${items}:visible`).length < 9 || $(`${items}:hidden`).length == 0){
                $('#sts-blog-load-more').hide()
            } else {
                $('#sts-blog-load-more').show()
            }
        } else {
            $(items).slice(0, 6).fadeIn();
            if($(`${items}:visible`).length < 6 || $(`${items}:hidden`).length == 0){
                $('#sts-blog-load-more').hide()
            } else {
                $('#sts-blog-load-more').show()
            }
        }
    }

    // Categories Blog Desktop
    $('.sts-blog-categories__link').on('click', function(e){
        e.preventDefault()
        var dataCat = $(this).attr('data-cat')
        $('.sts-blog-categories__link').removeClass('active')
        $(this).addClass('active')
        $("#sts-blog-load-more").attr('data-load', dataCat)

        if(dataCat == "todo"){
            loadCat('.sts-blog-section__col')
        } else {
            const loaditems = "." + dataCat
            loadCat(loaditems)
        }       
    })


    $('.sts-blog-categories__form').on('change', function(e) {
        var dataCat = $('#sts-blog-cat-mobile').val()

        $("#sts-blog-load-more").attr('data-load', dataCat)

        if(dataCat == "todo"){
            loadCat('.sts-blog-section__col')
        } else {
            const loaditems = "." + dataCat
            loadCat(loaditems)
        }
    })

    $('.sts-slick-about__item__cont__col ul').addClass('sts-slick-about__item__cont__list')
    $('.sts-slick-about__item__cont__col ul li').each(function() {
        $(this).addClass('sts-slick-about__item__cont__list__item')
        const textItem = $(this).text()
        $(this).html(`
            <img src="${childThemeImg}/akar-icons_circle-check.svg" class="sts-slick-about__item__cont__list__icon">
            <span class="sts-slick-about__item__cont__list__text">${textItem}</span>
        `)
    })

    // Form login
    $('.woocommerce-form-login #username').attr('placeholder', 'Nombre usuario o correo electrónico');
    $('.woocommerce-form-login #password').attr('placeholder', 'Contraseña');

    // Form lost password
    $('.woocommerce-ResetPassword #user_login').attr('placeholder', 'Nombre usuario o correo electrónico');


    // Menu icons
    $('.sts-btn-menu-shop .ekit-menu-nav-link').html(`
        <span class="sts-menu-icon" style="margin-right: 5px;">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4.16602 5.83334H15.6577C15.8905 5.83335 16.1208 5.88215 16.3336 5.9766C16.5465 6.07104 16.7372 6.20904 16.8934 6.38169C17.0496 6.55434 17.168 6.75781 17.2408 6.97899C17.3135 7.20017 17.3392 7.43415 17.316 7.66584L16.816 12.6658C16.7749 13.0771 16.5824 13.4584 16.276 13.7357C15.9695 14.0131 15.571 14.1667 15.1577 14.1667H7.19935C6.81391 14.1668 6.44033 14.0334 6.14222 13.7891C5.84411 13.5447 5.6399 13.2046 5.56435 12.8267L4.16602 5.83334Z" stroke="#E3F401" stroke-width="2" stroke-linejoin="round"/>
            <path d="M4.16602 5.83333L3.49102 3.13083C3.44587 2.95063 3.34181 2.79067 3.19536 2.67638C3.0489 2.56209 2.86846 2.5 2.68268 2.5H1.66602" stroke="#E3F401" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M6.66602 17.5H8.33268" stroke="#E3F401" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M13.332 17.5H14.9987" stroke="#E3F401" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </span>
        Tienda
    `)

    // Open in new Tab
    $('.sts-btn-menu-shop .ekit-menu-nav-link').attr('target', '_blank')

    
});