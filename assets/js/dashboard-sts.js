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
});

