

(function ($) {
    $(document).ready(function () {
		// menu 
		
		$('.mainmenu >li').each(function(){
			var item = $(this);
			if(item.find('.submenu2').length > 0){
				item.addClass('parent-full');
			}
		});
		
		// menu mobile
		$('#header ul.mainmenu li').on('click', function(e){
			if($(window).width() < 1199 ){
				e.stopPropagation();
				$(this).toggleClass('menu_expand');	
			}	
		});
		
		
        $(window).scroll(function() {    
            var scroll = $(window).scrollTop();    
            if (scroll >= 40) {
                $("body").addClass("header-fixed");
            }else{
                $("body").removeClass("header-fixed");
            }
        });


        /* Menu mobile */
        $('.menu-btn').click(function(){
            if($('body').hasClass('showMenu')){
                $('body').removeClass('showMenu');
				$('.mainmenu >li').removeClass('menu_expand');
            }else{
                $('body').addClass('showMenu');
                //$('.flexMenuToggle:first').click();
				return false;
            }
        }); 
    


        // Scroll to fix
        var windowW = $(window).width();
        if(windowW > 767){
            if($('.widget-register').length){
                var summaries = $('.sidebar .widget');
                summaries.each(function(i) {
                    var summary = $(summaries[i]);
                    var next = summaries[i + 1];
                    summary.scrollToFixed({
                        marginTop: $('#header').outerHeight(true) + 20,
                        limit: function() {
                            var limit = 0;
                            if (next) {
                                limit = $(next).offset().top - $(this).outerHeight(true) - 20;
                            } else {
                                limit = $('.u008').offset().top - $(this).outerHeight(true) - 120;
                            }
                            return limit;
                        },
                        zIndex: 98
                    });
                });
               }
        }
        


    // Search
    $('.btnSearch').click(function(){
        $('body').toggleClass('showSearch');
    });    

    // Search
    $('.closeDown').click(function(){
        $(this).parent().hide();
    });    

    if ($(".select-chosen").length > 0) {
        $('.select-chosen').chosen();
    }

        $(".sidebar-fixed .btnbook").click(function() {
            setTimeout(
            function() {
              $('.btnbook,#btnClose').addClass("show");
            }, 300);
            $('.sidebar-fixed').toggleClass("show");
        });

        $(".btnpopupform").click(function() {
            $('body').toggleClass("showpopupform");
        });
        

        //OWL----------------------------------------------------

        $('.single-slide').each(function () {
            $(this).owlCarousel({
                navText: ["<i class='icon-arrow-left2'></i>","<i class='icon-arrow-right2'></i>"],
                items:1,
                autoplayHoverPause:false,
                autoplay: true,
                dots: $(this).hasClass('s-dots') ? true : false,
                loop: true,
                lazyLoad: $(this).hasClass('s-lazy') ? true : false,
                nav: $(this).hasClass('s-nav') ? true : false
            })
        });


        $('.title-slide').each(function () {
            $(this).owlCarousel({
                navText: ["<span class='text'></span><i class='icon-arrow-left2'></i>","<span class='text'></span><i class='icon-arrow-right2'></i>"],
                items:1,
                autoplayHoverPause:false,
                autoplay: true,
                loop: true,
                nav: tru
            })
        });



        $('.slide-center, .slide-center2').owlCarousel({
            navText: ["<i class='icon-arrow-left2'></i>","<i class='icon-arrow-right2'></i>"],
            center: true,
            items:2,
            loop:true,
            dots:false,
            margin:0,
            autoplay:true,
            nav:true,
            responsive : {
                0 : {
                        center: false,
                        items:1,
                },
                768 : {
                        margin:10,
                        padding:150,
                },
                1200 : {
                        margin:20,
                        padding:250,
                }    
            }
        });

        var countValue = $('.slide3-a-arr>div').length;
        var windowW = $(window).width();
        if(countValue >=3 && windowW >= 1024){
            // console.log(countValue);

            $('.slide3-a-arr').owlCarousel({
                navText: ["<i class='icon-arrow-left2'></i>","<i class='icon-arrow-right2'></i>"],
                nav:true,
                dots:false,
                margin:30,
                responsive:{
                    0:{
                        items:1
                    },
                    600:{
                        items:2
                    },
                    800:{
                        items:2
                    },
                    1000:{
                        items:3
                    }

                }            
            });
        }else{
            $('.slide3-a-arr.owl-carousel').css({'display':'block','text-align':'center'});
            $('.slide3-a-arr>div').each(function(){
                $(this).children('.img').css({'height':'273px','overflow':'hidden'});
                $(this).css({'width':'360px','margin-right':'30px','display':'inline-block','vertical-align':'top'});
            })
        }

        $('.slide3-arr').owlCarousel({
            navText: ["<i class='icon-arrow-left2'></i>","<i class='icon-arrow-right2'></i>"],
            nav:true,
            dots:false,
            margin:30,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:2
                },
                800:{
                    items:2
                },
                1000:{
                    items:3
                }

            }            
        });
        
        $('.slide4-arr').owlCarousel({
            navText: ["<i class='icon-arrow-left2'></i>","<i class='icon-arrow-right2'></i>"],
            nav:true,
            dots:false,
            margin:20,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:2
                },
                800:{
                    items:3
                },
                1200:{
                    items:3
                }

            }            
        });

        $('.slide5-arr').owlCarousel({
            navText: ["<i class='icon-arrow-left2'></i>","<i class='icon-arrow-right2'></i>"],
            nav:true,
            dots:false,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                },
                800:{
                    items:4
                },
                1200:{
                    items:5
                }

            }            
        });

        $('.slide6-arr').owlCarousel({
            navText: ["<i class='icon-arrow-left2'></i>","<i class='icon-arrow-right2'></i>"],
            nav:true,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:2
                },
                800:{
                    items:3
                },
                1200:{
                    items:3
                }

            }            
        });

        // END OWL----------------------------------------------------




		// Menu
		/*
		$('ul.mainmenu li.parent ').each(function(){
		     var 
                p = $(this),
                btn = $('<span>',{'class':'showsubmenu fa fa-caret-down', text : '' }).click(function(){
    				if(p.hasClass('parent-showsub')){
    				    menu.slideUp(300,function(){
    				        p.removeClass('parent-showsub');
    				    });        										
    				}else{
    				    menu.slideDown(300,function(){
    				        p.addClass('parent-showsub');
    				    });        										
    				};	
    			}),
                menu = p.children('ul')
             ;
             p.prepend(btn) 
		});	
		
		
		

$(".sniphover").mouseleave(
  function() {
    $(this).removeClass("sniphover");
  }
);



var titles = $('.carousel-inner .item').map(function(){ return this.title; });
$('.carousel-control').on('mouseover', function() {

    var currentIndex = $('.carousel .active').prevAll('.item').length;
    var title = titles[currentIndex + 1 > titles.length -1 ? 0 : currentIndex + 1];
    if ($(this).hasClass('left')) {
        title = titles[currentIndex - 1 < 0 ? titles.length - 1 : currentIndex - 1];
    }
    $(this).children('.text').html(title); 
});

$('.carousel-control').on('click', function() {
    var currentIndex = $('.carousel .active').prevAll('.item').length + 1;
    var title = titles[currentIndex + 1 > titles.length -1 ? 0 : currentIndex + 1];
    if ($(this).hasClass('left')) {
        title = titles[currentIndex - 1 < 0 ? titles.length - 1 : currentIndex - 1];
    }
    $(this).children('.text').html(title);
});





        // WOW scroll


        wow = new WOW(
            {
                boxClass:     'wow',      // default
                animateClass: 'animated fadeInUpS', // default
                offset:       100,          // default
                mobile:       false,       // default
                live:         true        // default
            }
        )
        wow.init();



        $('.box-acordion > .tab > .tab-title').each(function(){
            $(this).click(function(){ 
                parent = $(this).parent();
                acordion = $(this).parent().parent();
                tab = acordion.children('.tab');
                if (parent.hasClass('show')) {
                    $(this).next().slideToggle(300);
                    parent.removeClass('show'); 
                } else {
                    //hide
                    acordion.children('.tab').children('.tab-content').slideUp(300);
                    tab.removeClass('show');
                    //show
                    $(this).next().slideDown(300);
                    parent.addClass('show');
                };
            });
        });        

        $('.box-acordion-slide > .tab > .tab-title').each(function(){
            height = $(this).next().height();
            $(this).click(function(){ 
                parent = $(this).parent();
                acordion = $(this).parent().parent();
                tab = acordion.children('.tab');
                if (parent.hasClass('show')) {
                    parent.removeClass('show'); 
                } else {
                    //hide
                    tab.removeClass('show');
                    //show
                    parent.addClass('show');
                };
            });
        });   





        //equalHeight




                if ($(".block1 .table-cell").length > 0) {
                  $('.block1 .table-cell').imagesLoaded(function () {
                    equalHeight(".block1 .table-cell", 0);
                  });
                }

                if ($(".list2 .list_desc").length > 0) {
                  $('.list2 .list_desc').imagesLoaded(function () {
                    equalHeight(".list2  .list_desc", 0);
                  });
                }

                if ($(".list5 .list_item").length > 0) {
                  $('.list5 .list_item').imagesLoaded(function () {
                    equalHeight(".list5 .list_item", 0);
                  });
                }
                if ($(".list6 .list_item").length > 0) {
                  $('.list6 .list_item').imagesLoaded(function () {
                    equalHeight(".list6 .list_item", 0);
                  });
                }
                if ($(".block3 .block .row-1 > div").length > 0) {
                  $('.block3 .block .row-1 > div').imagesLoaded(function () {
                    equalHeight(".block3 .block .row-1 > div", 30);
                  });
                }


                if ($(".u019 .equal").length > 0) {
                  $('.u019 .equal').imagesLoaded(function () {
                    equalHeight(".u019 .equal", 80);
                  });
                }


              $(window).resize(function() {

                if ($(".block1 .table-cell").length > 0) {
                  $('.block1 .table-cell').imagesLoaded(function () {
                    equalHeight(".block1 .table-cell", 0);
                  });
                }

              });






        /* Equal Height good*/
        function equalHeight(className, padding) {
          var tempHeight = 0;
          $(className).each(function () {
            current = $(this).height();
            if (parseInt(tempHeight) < parseInt(current)) {
              tempHeight = current;
            }
          });
          $(className).css("height", tempHeight + padding + "px");
        }


        
        $(window).bind("load", function() {
            // Lazy img 
            $('.img-lazy').each(function(){
                var src = $(this).attr('data-src');
                $(this).attr('src', src);
                $(this).removeClass('img-lazy').addClass('img-loaded');
            }); // end Lazy img 
            // Lazy bg 
            $('.bg-lazy').each(function(){
                var src = $(this).attr('data-src');
                $(this).css('background-image', 'url(' + src + ')');
                $(this).removeClass('bg-lazy').addClass('bg-loaded');
            }); // end Lazy bg 
        });        



     

    });
})(jQuery);	



