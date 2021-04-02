

(function ($) {
    $(document).ready(function () {

        /* Menu mobile */
        $('.menu-btn').click(function(){
            if($('body').hasClass('showMenu')){
                $('body').removeClass('showMenu');
            }else{
                $('body').addClass('showMenu');
                //$('.flexMenuToggle:first').click();
            return false;
            }
        }); 
    


    // Search
    $('.btnSearch').click(function(){
        $('body').toggleClass('showSearch');
    });    


    if ($(".select-chosen").length > 0) {
        $('.select-chosen').chosen();
    }


        //equalHeight
        if ($(".list2 .list_desc").length > 0) {
          $('.list2 .list_desc').imagesLoaded(function () {
            equalHeight(".list2  .list_desc", 0);
          });

        }



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
                    items:3
                },
                1200:{
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
                    items:4
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

        // END OWL----------------------------------------------------

        // iframe video
        var getVideoUrl = function(id){
            return 'https://www.youtube.com/embed/' + id + '?rel=0&autoplay=1';
        }
        var addVideoUrl = function(id){
            return 'https://www.youtube.com/embed/' + id + '?rel=0';
        }

        var modal = $('#myVideo').on('hidden.bs.modal',function(){
            modal.find('iframe').removeAttr('src');
        });
        var fullVideo = $('#fullVideo');

        
        $(document).on('click','.item_video',function(){
            var btnVideo = $(this);    
            var video = btnVideo.attr('data-video');     
            //modal.find('iframe').attr('src', getVideoUrl(video));
            fullVideo.addClass('show-video');
            fullVideo.find('iframe').attr('src', getVideoUrl(video));
        });  

        // single video
        $(document).on('click','.single-video .item_video',function(){
            var btnVideo = $(this);    
            var video = btnVideo.attr('data-video');
            var parent = btnVideo.parent().parent();     
            if(parent.hasClass('show-video')){
                    parent.removeClass('show-video');
                    parent.find('iframe').removeAttr('src');
            }else{
                    parent.addClass('show-video');
                    parent.find('iframe').attr('src', getVideoUrl(video));
            };  
        });  




        // slideToggle
        $('.block-toggle .block-title').each(function(){
            var btnTg = $(this).click(function(){ 
                    if(btnTg.parent().hasClass('active')){
                        btnTg.parent().removeClass('active');
                        btnTg.parent().find('.block-content').slideUp(300);                                           
                    }else{
                        $('.block-toggle .block-item').removeClass('active');
                        $('.block-toggle .block-content').slideUp(300);
                        btnTg.parent().addClass('active');
                        btnTg.parent().find('.block-content').slideDown(300);               
                    };  
            });
        });       




		// Menu
		$('ul.mainmenu li.parent, #footer ul.menu li.parent ').each(function(){
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



        // WOW scroll
        new WOW().init();
        wow2 = new WOW(
            {
                boxClass:     'wow2',      // default
                animateClass: 'ffffffffff', // default
                offset:       0,          // default
                mobile:       true,       // default
                live:         true        // default
            }
        )
        wow2.init();

     


        //equalHeight
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


        /* Equal Height good*/
        function equalHeight(className, padding) {
          var tempHeight = 0;
          $(className).each(function () {
            current = $(this).height();
            if (parseInt(tempHeight) < parseInt(current)) {
              tempHeight = current;
            }
          });
          $(className).css("minHeight", tempHeight + padding + "px");
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

            // Facebook
            $('.fb-messenger .btnFb').click(function(){

                $('.fb-messenger').toggleClass('active');

                (function(d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) return;
                    js = d.createElement(s); js.id = id;
                    js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));


            }); 


        });        

     

    });
})(jQuery);	




