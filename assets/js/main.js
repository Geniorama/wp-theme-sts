
// Inicializando AOS
AOS.init();

// Inicializando Parallax
const scenes = document.querySelectorAll('.sts-parallax');

scenes.forEach(scene => {
    const parallaxInstance = new Parallax(scene, {
        relativeInput: true,
        pointerEvents: true
    })
});



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
});