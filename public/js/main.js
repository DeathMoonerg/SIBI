(function ($) {
    "use strict";

    // Initiate the wowjs
    new WOW().init();


    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();


    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.sticky-top').addClass('shadow-sm');
        } else {
            $('.sticky-top').removeClass('shadow-sm');
        }
    });
    
    
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Header carousel
    $(".header-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        items: 1,
        dots: true,
        loop: true,
        nav : true,
        navText : [
            '<i class="bi bi-chevron-left"></i>',
            '<i class="bi bi-chevron-right"></i>'
        ]
    });


    // Testimonials carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        margin: 24,
        dots: false,
        loop: true,
        nav : true,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ],
        responsive: {
            0:{
                items:1
            },
            992:{
                items:2
            }
        }
    });
    
    // Animasi Hover untuk Kelas
    $('.classes-item').hover(
        function() {
            $(this).find('.classes-text').animate({ padding: '25px 30px' }, 300);
        },
        function() {
            $(this).find('.classes-text').animate({ padding: '15px 20px' }, 300);
        }
    );

    // Efek Parallax pada Scroll
    $(window).scroll(function() {
        var scrollPos = $(window).scrollTop();
        $('.parallax-section').css({
            'background-position-y': (scrollPos * 0.2) + 'px'
        });
    });

    // Animasi untuk Tombol
    $('.btn-primary').hover(
        function() {
            $(this).animate({ paddingLeft: '25px', paddingRight: '25px' }, 200);
        },
        function() {
            $(this).animate({ paddingLeft: '20px', paddingRight: '20px' }, 200);
        }
    );
    
    // Counter Up Animation untuk Angka Statistik
    $('.counter').each(function () {
        $(this).prop('Counter', 0).animate({
            Counter: $(this).text()
        }, {
            duration: 2000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });
    
})(jQuery);