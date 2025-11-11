(function($) {
    
    "use strict";

    /* ----- Preloader ----- */
    function preloaderLoad() {
        if($('.preloader').length){
            $('.preloader').delay(200).fadeOut(300);
        }
        $(".preloader_disabler").on('click', function() {
            $("#preloader").hide();
        });
    }

    /* ----- Navbar Scroll To Fixed ----- */
    function navbarScrollfixed() {
        $('.navbar-scrolltofixed').scrollToFixed();
        var summaries = $('.summary');
        summaries.each(function(i) {
            var summary = $(summaries[i]);
            var next = summaries[i + 1];
            summary.scrollToFixed({
                marginTop: $('.navbar-scrolltofixed').outerHeight(true) + 10,
                limit: function() {
                    var limit = 0;
                    if (next) {
                        limit = $(next).offset().top - $(this).outerHeight(true) - 10;
                    } else {
                        limit = $('.footer').offset().top - $(this).outerHeight(true) - 10;
                    }
                    return limit;
                },
                zIndex: 999
            });
        });
    }

    function mhome_slider() {
        //Function to animate slider captions 
        function doAnimations( elems ) {
            //Cache the animationend event in a variable
            var animEndEv = 'webkitAnimationEnd animationend';
            
            elems.each(function () {
                var $this = $(this),
                    $animationType = $this.data('animation');
                $this.addClass($animationType).one(animEndEv, function () {
                    $this.removeClass($animationType);
                });
            });
        }
        
        //Variables on page load 
        var $myCarousel = $('#sg-carousel'),
            $firstAnimatingElems = $myCarousel.find('.item:first').find("[data-animation ^= 'animated']");
            
        //Initialize carousel 
        $myCarousel.carousel();
        
        //Animate captions in first slide on page load 
        doAnimations($firstAnimatingElems);
        
        //Pause carousel  
        $myCarousel.carousel('pause');
        
        //Other slides to be animated on carousel slide event 
        $myCarousel.on('slide.bs.carousel', function (e) {
            var $animatingElems = $(e.relatedTarget).find("[data-animation ^= 'animated']");
            doAnimations($animatingElems);
        });
    }


    /* ----- Blog innerpage sidebar according ----- */
    var acc = document.getElementsByClassName("sw-accordion");
    var i;
    for (i = 0; i < acc.length; i++) {
      acc[i].onclick = function() {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.maxHeight){
          panel.style.maxHeight = null;
        } else {
          panel.style.maxHeight = panel.scrollHeight + "px";
        } 
      }
    }
    
    /* ----- fact-counter ----- */
    function counterNumber() {
        $('div.timer').counterUp({
            delay: 5,
            time: 2000
        });
    }
    

    /* ----- MASONRY ISOTOP GALLERY ----- */
    if ($('.masonry-gallery').length>0 || $('.masonry-grid').length>0 || $('.masonry-grid-fitrows').length>0) {
        $(window).on('load',function() {
            $('.masonry-gallery').fadeIn();
            var $container = $('.masonry-gallery').isotope({
                itemSelector: '.isotope-item',
                layoutMode: 'masonry',
                transitionDuration: '0.6s',
                filter: "*"
            });
            $('.masonry-grid').isotope({
                itemSelector: '.masonry-grid-item',
                layoutMode: 'masonry'
            });
            $('.masonry-grid-fitrows').isotope({
                itemSelector: '.masonry-grid-item',
                layoutMode: 'fitRows'
            });
            // filter items on button click
            $('.masonry-filter').on( 'click', 'li a', function() {
                var filterValue = $(this).attr('data-filter');
                $(".masonry-filter").find("a.active").removeClass("active");
                $(this).parent().addClass("active");
                $container.isotope({ filter: filterValue });
                return false;
            });
        });
    };

    /* ----- LighvtBox / Fancybox ----- */
    if($('.lightbox-image').length) {
      $('.lightbox-image').fancybox();
    }

    /* ----- MagnificPopup ----- */
    if (($(".popup-img").length > 0) || ($(".popup-iframe").length > 0) || ($(".popup-img-single").length > 0)) {
        $(".popup-img").magnificPopup({
            type:"image",
            gallery: {
                enabled: true,
            }
        });
        $(".popup-img-single").magnificPopup({
            type:"image",
            gallery: {
                enabled: false,
            }
        });
        $('.popup-iframe').magnificPopup({
            disableOn: 700,
            type: 'iframe',
            preloader: false,
            fixedContentPos: false
        });
        $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
          disableOn: 700,
          type: 'iframe',
          mainClass: 'mfp-fade',
          removalDelay: 160,
          preloader: false,
          fixedContentPos: false
        });
    };

    /* ----- Progress Bar ----- */
    if($('.progress-levels .progress-box .bar-fill').length){
        $(".progress-box .bar-fill").each(function() {
            var progressWidth = $(this).attr('data-percent');
            $(this).css('width',progressWidth+'%');
            $(this).children('.percent').html(progressWidth+'%');
        });
    }

    /* ----- Background Parallax ----- */
    var isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    };

    jQuery(document).on('ready',function(){
        jQuery(window).stellar({ 
            horizontalScrolling: false,
            hideDistantElements: true,
            verticalScrolling: !isMobile.any(),
            scrollProperty: 'scroll',
            responsive: true
        });          
    });

    /* ----- YTplayer ----- */
    if($('.player').length) {
        $(".player").mb_YTPlayer();
    }

    /* ----- Vimeo ----- */
    if($('#myvideo').length) {
        $("#myvideo").vimeo("play");
    }
    
    /* ----- fitVids ----- */
    if($('.body').length) {
        $('.body').fitVids();
    }

    /* ----- Project Box ----- */
    if($('.hover').length) {
        $(".hover").mouseleave(
          function() {
            $(this).removeClass("hover");
          }
        );
    }

    /* ----- Wow animation ----- */
    function wowAnimation() {
        var wow = new WOW({
            animateClass: 'animated',
            mobile: true, // trigger animations on mobile devices (default is true)
            offset:       0
        });
        wow.init();
    }

    /* ----- FLIP CLOCK ----- */
    function flip_Clock() {
        var clock;    
        var clock;
        clock = $('.clock').FlipClock({
            clockFace: 'DailyCounter',
            autoStart: false,
            callbacks: {
                stop: function() {
                    $('.message').html('The clock has stopped!')
                }
            }
        });
                
        clock.setTime(8220880);
        clock.setCountdown(true);
        clock.start();
    }

    /* ----- FULL CALENDAR ----- */
    if($('.calendar').length){
        $('.calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            defaultDate: '2018-05-22',
            navLinks: true, // can click day/week names to navigate views
            selectable: true,
            selectHelper: true,
            select: function(start, end) {
                var title = prompt('Event Title:');
                var eventData;
                if (title) {
                    eventData = {
                        title: title,
                        start: start,
                        end: end
                    };
                    $('.calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
                }
                $('.calendar').fullCalendar('unselect');
            },
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: [
                {
                    title: 'All Day Event',
                    start: '2018-05-01'
                },
                {
                    title: 'Long Event',
                    start: '2018-05-07',
                    end: '2018-05-10'
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: '2018-05-09T16:00:00'
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: '2018-05-16T16:00:00'
                },
                {
                    title: 'Conference',
                    start: '2018-05-11',
                    end: '2018-05-13'
                },
                {
                    title: 'Meeting',
                    start: '2018-05-12T10:30:00',
                    end: '2018-05-12T12:30:00'
                },
                {
                    title: 'Lunch',
                    start: '2018-05-12T12:00:00'
                },
                {
                    title: 'Meeting',
                    start: '2018-05-12T14:30:00'
                },
                {
                    title: 'Happy Hour',
                    start: '2018-05-12T17:30:00'
                },
                {
                    title: 'Dinner',
                    start: '2018-05-12T20:00:00'
                },
                {
                    title: 'Birthday Party',
                    start: '2018-05-13T07:00:00'
                },
                {
                    title: 'Click for Google',
                    url: 'http://google.com/',
                    start: '2018-05-28'
                }
            ]
        });        
    }

    if($('#calendar').length){
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'listDay,listWeek,month'
            },

            // customize the button names,
            // otherwise they'd all just say "list"
            views: {
                listDay: { buttonText: 'list day' },
                listWeek: { buttonText: 'list week' }
            },

            defaultView: 'listWeek',
            defaultDate: '2018-05-12',
            navLinks: true, // can click day/week names to navigate views
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: [
                {
                    title: 'All Day Event',
                    start: '2018-05-01'
                },
                {
                    title: 'Long Event',
                    start: '2018-05-07',
                    end: '2018-05-10'
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: '2018-05-09T16:00:00'
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: '2018-05-16T16:00:00'
                },
                {
                    title: 'Conference',
                    start: '2018-05-11',
                    end: '2018-05-13'
                },
                {
                    title: 'Meeting',
                    start: '2018-05-12T10:30:00',
                    end: '2018-05-12T12:30:00'
                },
                {
                    title: 'Lunch',
                    start: '2018-05-12T12:00:00'
                },
                {
                    title: 'Meeting',
                    start: '2018-05-12T14:30:00'
                },
                {
                    title: 'Happy Hour',
                    start: '2018-05-12T17:30:00'
                },
                {
                    title: 'Dinner',
                    start: '2018-05-12T20:00:00'
                },
                {
                    title: 'Birthday Party',
                    start: '2018-05-13T07:00:00'
                },
                {
                    title: 'Click for Google',
                    url: 'http://google.com/',
                    start: '2018-05-28'
                }
            ]
        });
    }

    /* ----- Countdown ----- */
    if($('#countdown').length){
        $('#countdown').timeTo({
            timeTo: new Date(new Date('Thu Dec 15 2017 09:00:00 GMT+0600 (Bangladesh Standard Time)')),
            displayDays: 2,
            theme: "white",
            displayCaptions: true,
            fontSize: 24,
            captionSize: 14
        });
    }
    if($('.countdown').length){
        $('.countdown').timeTo({
            timeTo: new Date(new Date('Thu Dec 15 2017 09:00:00 GMT+0600 (Bangladesh Standard Time)')),
            displayDays: 2,
            theme: "white",
            displayCaptions: true,
            fontSize: 60,
            captionSize: 24
        });
    }
    
    /* ----- Date & time Picker ----- */
    if($('.datepicker').length){
        $('.datepicker').datetimepicker();
    }

    /* ----- Home Maximage Slider ----- */
    if($('#maximage').length){
        $('#maximage').maximage({
            cycleOptions: {
                fx:'fade',
                speed: 500,
                timeout: 20000,
                prev: '#arrow_left',
                next: '#arrow_right'
            },
            onFirstImageLoaded: function(){
                jQuery('#cycle-loader').hide();
                jQuery('#maximage').fadeIn('fast');
            }
        });        
        // Helper function to Fill and Center the HTML5 Video
        jQuery('#html5video').maximage('maxcover');
            
        // To show it is dynamic html text
        jQuery('.in-slide-content').delay(2000).fadeIn();
    }

    /* ----- PG Slider ----- */
    if($('#js-main-slider').length){
        $('#js-main-slider').pogoSlider({
            autoplay: true,
            autoplayTimeout: 5000,
            displayProgess: true,
            preserveTargetSize: true,
            targetWidth: 1000,
            targetHeight: 300,
            responsive: true
        }).data('plugin_pogoSlider');
    }
    
    /* ----- FullPage Slider, Particles Script & Multiscroll ----- */
    if($('#particles2-effect').length){
        $("#particles2-effect").jParticle({
            background: "#023368",
            color: "#fff"
        });
    }
    if($('#fullpage').length){
        $('#fullpage').fullpage({
            navigation: true,
            navigationPosition: 'right',
            sectionsColor: ['#F0F2F4', '#fafafa', '#F0F2F4', 'whitesmoke', '#f9f9f9']
        });
    }
    if($('#myContainer').length){
        $('#myContainer').multiscroll({
            sectionsColor: ['#C63D0F', '#1BBC9B', '#7E8F7C'],
            anchors: ['first', 'second', 'third'],
            menu: '#menu',
            css3: true,
            paddingTop: '70px',
            paddingBottom: '70px'
        });
    }

    // Owl-main-slider-carousel
    if($('.main-slider2').length){
        $('.main-slider2').owlCarousel({
            animateIn: 'pulse',
            loop:true,
            margin:0,
            dots: false,
            nav:true,
            rtl:true,
            autoplayHoverPause:false,
            autoplay: false,
            autoHeight:true,
            smartSpeed: 2000,
            navText: [
              '<i class="fa fa-long-arrow-left"></i>',
              '<i class="fa fa-long-arrow-right"></i>'
            ],
            responsive: {
                0: {
                    items: 1,
                    center: false
                },
                480:{
                    items:1,
                    center: false
                },
                600: {
                    items: 1,
                    center: false
                },
                768: {
                    items: 1
                },
                992: {
                    items: 1
                },
                1200: {
                    items: 1
                }
            }
        })
    }

    /*  Owl-single-post-carousel  */
    if($('.blog-post-img-slider').length){
        $('.blog-post-img-slider').owlCarousel({
            loop:true,
            margin:5,
            dots: false,
            nav:true,
            autoplayHoverPause:true,
            autoplay: true,
            smartSpeed: 1200,
            navText: [
              '<i class="flaticon-left-arrow"></i>',
              '<i class="flaticon-right-arrow"></i>'
            ],
            responsive: {
                0: {
                    items: 1,
                    center: false
                },
                480:{
                    items:1,
                    center: false
                },
                600: {
                    items: 1,
                    center: false
                },
                768: {
                    items: 1
                },
                992: {
                    items: 1
                },
                1200: {
                    items: 1
                }
            }
        })
    }

    /*  Owl-single-post-carousel  */
    if($('.about-slider').length){
        $('.about-slider').owlCarousel({
            loop:true,
            margin:5,
            dots: false,
            nav:false,
            rtl:true,
            autoplayHoverPause:false,
            autoplay: true,
            smartSpeed: 1200,
            navText: [
              '<i class="flaticon-left-arrow"></i>',
              '<i class="flaticon-right-arrow"></i>'
            ],
            responsive: {
                0: {
                    items: 1,
                    center: false
                },
                480:{
                    items:1,
                    center: false
                },
                600: {
                    items: 1,
                    center: false
                },
                768: {
                    items: 1
                },
                992: {
                    items: 2
                },
                1200: {
                    items: 3
                }
            }
        })
    }

    /*  Owl-Testimonial-carousel  */
    if($('.testimonial-carousel').length){
        $('.testimonial-carousel').bxSlider({
          auto: true,
          infiniteLoop: true,
          mode: 'vertical',
          nextSelector: '#slider-next',
          prevSelector: '#slider-prev',
          pager: false,
          slideMargin: 5,
          speed: 3000
        });
    }

    /*  Owl-gallery-carousel  */
    if($('.fancybox-gallery-slider').length){
        $('.fancybox-gallery-slider').owlCarousel({
            loop:true,
            margin:15,
            dots: false,
            nav:true,
            rtl:true,
            autoplayHoverPause:false,
            autoplay: true,
            smartSpeed: 1800,
            navText: [
              '<i class="flaticon-left-arrow"></i>',
              '<i class="flaticon-right-arrow"></i>'
            ],
            responsive: {
                0: {
                    items: 1,
                    center: false
                },
                480:{
                    items:1,
                    center: false
                },
                600: {
                    items: 2,
                    center: false
                },
                768: {
                    items: 3
                },
                992: {
                    items: 4
                },
                1200: {
                    items: 4
                }
            }
        })
    }

    /*  Owl-Testimonial-carousel  */
    if($('.testimonial-slider').length){
        $('.testimonial-slider').owlCarousel({
            loop:true,
            margin:15,
            dots: true,
            nav:false,
            rtl:true,
            autoplayHoverPause:false,
            autoplay: false,
            smartSpeed: 1200,
            singleItem: true,
            navText: [
              '<i class="fa fa-long-arrow-left"></i>',
              '<i class="fa fa-long-arrow-right"></i>'
            ],
            responsive: {
                0: {
                    items: 1,
                    center: false
                },
                320:{
                    items:1,
                    center: false
                },
                480:{
                    items:1,
                    center: false
                },
                600: {
                    items: 2,
                    center: false
                },
                768: {
                    items: 2
                },
                992: {
                    items: 3
                },
                1200: {
                    items: 3
                }
            }
        })
    }

    /*  Owl-Testimonial-carousel  */
    if($('.partner-slider').length){
        $('.partner-slider').owlCarousel({
            loop:true,
            margin:15,
            dots: false,
            nav:false,
            rtl:true,
            autoplayHoverPause:false,
            autoplay: true,
            smartSpeed: 1200,
            singleItem: true,
            navText: [
              '<i class="fa fa-long-arrow-left"></i>',
              '<i class="fa fa-long-arrow-right"></i>'
            ],
            responsive: {
                0: {
                    items: 1,
                    center: false
                },
                320:{
                    items:2,
                    center: false
                },
                480:{
                    items:2,
                    center: false
                },
                600: {
                    items: 3,
                    center: false
                },
                768: {
                    items: 4
                },
                992: {
                    items: 5
                },
                1200: {
                    items: 5
                }
            }
        })
    }

    /*  Owl-Testimonial-carousel  */
     if ($(".banner-style-one").length) {
        $(".banner-style-one").owlCarousel({
            loop: true,
            items: 1,
            margin: 0,
            dots: true,
            nav: true,
            true: true,
            animateOut: "slideOutDown",
            animateIn: "fadeIn",
            active: true,
            smartSpeed: 1000,
            autoplay: false
        });
        $(".banner-carousel-btn .left-btn").on("click", function() {
            $(".banner-style-one").trigger("next.owl.carousel");
            return false;
        });
        $(".banner-carousel-btn .right-btn").on("click", function() {
            $(".banner-style-one").trigger("prev.owl.carousel");
            return false;
        });
    }


    /* Shop Slider */
    if($('#custom_carousel').length){
        $('#custom_carousel').on('slide.bs.carousel', function (evt) {
            $('#custom_carousel .controls li.active').removeClass('active');
            $('#custom_carousel .controls li:eq('+$(evt.relatedTarget).index()+')').addClass('active');
        })
    }

    /* ----- Google Map Settings ----- */
    if($('#map-location').length){
        var map;
        map = new GMaps({
            el: '#map-location',
            zoom: 14,
            scrollwheel:false,
            //Set Latitude and Longitude Here
            lat: 39.768403,
            lng: -86.158068
        });
    }

    /* ----- FLICEKR FEED ----- */
    if($('.flickr-photo').length){
        $('.flickr-photo').jflickrfeed({
            limit: 9,
            qstrings: {
                id: '44802888@N04'
            },
            itemTemplate: 
            '<li>' +
                '<a href="{{image_b}}"><img src="{{image_s}}" alt="{{title}}" /></a>' +
            '</li>'
        });
    }

    /* ----- FLICEKR FEED ----- */
    function twitterFeed() {
        $('.twitter').twittie({
            dateFormat: '%b. %d, %Y',
            template: '{{tweet}} <div class="date">{{date}}</div> <a href="{{url}}" target="_blank">Details</a>',
            count: 2,
            hideReplies: true
        });
    }

    /* ----- INSTAGRAM FEED ----- */
    var uins_feed = new Instafeed({
        get: 'user',
        userId: 1691981710,
        accessToken: '1691981710.b1cd863.1c4d5299499e466392732854131d0641',
        resolution: 'standard_resolution',
        target: 'instafeed',
        limit: 10,
        mock: true,
        success: function(data) {
          for(i=0;i<data.data.length;i++) {
            // console.log(data.data[i]);
            console.log(data.data[i].images.low_resolution.width);
            if (data.data[i].images.low_resolution.width == data.data[i].images.low_resolution.height) {
                $('#instafeed').append('<div class="instagram-feed-image"><a href="'+ data.data[i].link +'" target="_blank"><img src="'+data.data[i].images.standard_resolution.url+'" /></a></div>'
            );
            }
          }
        }
    });
    uins_feed.run();

    /* ----- Scroll To top ----- */
    function scrollToTop() {
        $(window).scroll(function(){
            if ($(this).scrollTop() > 600) {
                $('.scrollToHome').fadeIn();
            } else {
                $('.scrollToHome').fadeOut();
            }
        });
        
        //Click event to scroll to top
        $('.scrollToHome').on('click',function(){
            $('html, body').animate({scrollTop : 0},800);
            return false;
        });

        $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        })
        $(function () {
          $('[data-toggle="popover"]').popover();
        })
    }


/* ======
   When document is ready, do
   ====== */
    $(document).on('ready', function() {
        // add your functions
        preloaderLoad();
        navbarScrollfixed();
        scrollToTop();
        wowAnimation();
        flip_Clock();
        twitterFeed();
        mhome_slider();
    });
    
/* ======
   When document is loading, do
   ====== */
    // window on Load function
    $(window).on('load', function() {
        // add your functions
        counterNumber();
        
    });
    // window on Scroll function
    $(window).scroll(function() {
        // add your functions
    });



})(window.jQuery);