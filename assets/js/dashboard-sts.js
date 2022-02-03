console.log('Dashboard ready')

jQuery(function ($) {
	function showTab(tab, allTabs){
        $(allTabs).hide()
        $(tab).fadeIn()
    }

    $('.sts-tab-link').on('click', function(e){
        e.preventDefault()

        if($(this).hasClass('sts-has-submenu')){
            $('.sts-submenu-dashboard').slideToggle()
        } else {
            var dataTarget = $(this).attr('data-target')
            showTab(dataTarget, '.sts-dashboard-tab')
            $('.sts-slick-plan').slick('refresh')
        }
       
        $('.sts-tab-link').removeClass('active')
        $(this).addClass('active')
    })

    //Slick Plan Progress
    $('.sts-slick-plan').slick({
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        infinite: false,
        // fade: true,
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
});

