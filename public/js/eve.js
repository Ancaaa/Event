jQuery(document).ready(function($) {
    'use strict';

    /**
     * Google Maps markers hover
     */
    $('.map-search-item').on('mouseenter', function() {
        var id = $(this).data('marker-id');
        $('#marker-' + id).addClass('hover');
    });

    $('.map-search-item').on('mouseleave', function() {        
        var id = $(this).data('marker-id');
        $('#marker-' + id).removeClass('hover');
    });

    /**
     * ezMark
     */
    $('input[type=radio], input[type=checkbox]').ezMark();
    
    /**
     * Cover carousel
     */
     $('.product-gallery').owlCarousel({
        autoplay: false,
        autoHeight: true,
        loop: true,
        items: 3,  
        margin: 2,     
        nav: false,
        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        responsive: {
        0: {
            items: 1
        },
        544: {
            items: 2
        },
        768: {
            items: 3
        }
    }        
     });

    /**
     * Animations
     */
    $('body').addClass('loaded');

    /**
     * Blog masonry
     */    
    var container = $('.blog .posts');
    container.imagesLoaded(function() {
        container.masonry({
            itemSelector: '.type-post',
            percentPosition: true,
            gutter: 30
        });
    });

    /**
     * Hero animate
     */
    $('.hero').addClass('hero-animate');

    /**
     * Page navigation scroll
     */
    $('.page-navigation a').on('click', function(e) {
        e.preventDefault();

        var id = $(this).attr('href');

        $.scrollTo(id, 1200, {
            axis: 'y',
            offset: -80
        });
    });

    /**
     * Site navigation
     */
    $('.site-navigation-toggle').on('click', function(e) {
        $('.site-navigation').toggleClass('open');
    });

    /**
     * Scroll
     */
    $(window).scroll(function() {
        if ($(this).scrollTop() > 220){
            $('.header-sticky').addClass('active');
        }
        else{
            $('.header-sticky').removeClass('active');
        }
    });
});