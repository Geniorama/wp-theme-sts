
// Inicializando AOS
AOS.init();

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
    $('.sts-card-service').on('click', (e)=>(e.preventDefault()));
    
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

    $('.sts-blog-section__col').slice(0, 9).show();
    
    $("#sts-blog-load-more").on("click", function(e){
    e.preventDefault();

    var dataLoad = $(this).attr('data-load')

    if(dataLoad != 'todo'){
        $("."+dataLoad+":hidden").slice(0, 3).slideDown();
        if($(("."+dataLoad+":hidden").length == 0)) {
            $(this).text("No hay más contenido").addClass("noContent");
        }
    } else {
        $(".sts-blog-section__col:hidden").slice(0, 3).slideDown();
        if($(".sts-blog-section__col:hidden").length == 0) {
            $(this).text("No hay más contenido").addClass("noContent");
        }
    }
    
    
    });

    $('.sts-blog-categories__link').on('click', function(e){
        var dataCat = $(this).attr('data-cat')
        $('.sts-blog-categories__link').removeClass('active')
        $(this).addClass('active')

        if(dataCat == "todo"){
            $(".sts-blog-section__col").hide();
            $(".sts-blog-section__col").slice(0, 9).fadeIn();

            if($(".sts-blog-section__col:hidden").length == 0) {
                $('#sts-blog-load-more').text("No hay más contenido").addClass("noContent");
            } else {
                $('#sts-blog-load-more').text("CARGAR MÁS").removeClass("noContent");
            }

            if($(".sts-blog-section__col:visible").length < 9){
                $('#sts-blog-load-more').hide()
            } else {
                $('#sts-blog-load-more').show()
            }
        } else {
            $("#sts-blog-load-more").attr('data-load', dataCat)
            $(".sts-blog-section__col").hide();
            $("." + dataCat).slice(0, 9).fadeIn();

            if($("."+dataCat+":visible").length < 9){
                $('#sts-blog-load-more').hide()
            } else {
                $('#sts-blog-load-more').show()
            }
    
            if($("."+dataCat+":hidden").length == 0) {
                $('#sts-blog-load-more').text("No hay más contenido").addClass("noContent");
            } else {
                $('#sts-blog-load-more').text("CARGAR MÁS").removeClass("noContent");
            }
        }

       
    })
});