jQuery(document).ready(function($) {
    
    // 1. Scroll up logic
    function scrollUpShow() {
        // Заменили $(this) на $(window) для надежности
        if($(window).scrollTop() > 1700) {
            $('.scroll-arrow-up').addClass('is-active');
        } else {
            $('.scroll-arrow-up').removeClass('is-active');
        }
    }

    scrollUpShow();
    $(window).on('scroll', function() {
        scrollUpShow();
    });

    $('.scroll-arrow-up').on('click', function() {
        $('html, body').animate({ scrollTop: 0 }, { duration: 1200 });
    });

    $('.anchor-link').on('click', function() {
        var href = $(this).attr('href');
        if (href && $(href).length) { // Добавил проверку, что якорь существует
            $('html, body').animate({
                scrollTop: $(href).offset().top
            }, { duration: 1100 });
            $('.header-mobile').removeClass('is-active');
        }
    });

    // 2. Header & Mobile Menu
    var mobilemenu = $('.header-mobile');
    $('.hamburger').on('click', function() {
        mobilemenu.addClass('is-active');
    });
    $('.header-mobile-close').on('click', function() {
        mobilemenu.removeClass('is-active');
    });

    // Mobile submenu toggle (native JS)
    var elements = document.getElementsByClassName("menu-item-has-children");
    var toggleSubmenu = function(event) {
        event.stopPropagation();
        this.classList.toggle("show");
    };
    for (var i = 0; i < elements.length; i++) {
        elements[i].addEventListener('click', toggleSubmenu, false);
    }
	
    // 3. Banner Initialization (Swiper 12)
    // Проверяем наличие блока, чтобы не было ошибки в консоли на страницах без баннера
    if ($('.swiper-banner').length > 0) {
        const swiperBanner = new Swiper('.swiper-banner', {
            speed: 700,
            spaceBetween: 0,
            loop: true, // для бесконечной прокрутки
            navigation: {
                prevEl: '.swiper-button-prev',
                nextEl: '.swiper-button-next',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            },
        });
    }

});