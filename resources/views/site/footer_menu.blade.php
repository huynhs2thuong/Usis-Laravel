<div id="floatMenu">
<div class="sidebar-fixed">
    <span id="btnClose">x</span>
    <span class="btnbook">
    <?php if($current_locale == 'en'){
        $urlimag = '/images/Button-Tai-cam-nang-E.png';
    }else{
         $urlimag = '/images/Tai-cam-nang.png';
    }

    ?>
    <img src="{{URL::to('/')}}{{$urlimag}}" alt=""  />
    </span>                
    <div class="inner">
        
        <div class=" f03">
            <h4>
            @lang('menu.page.vui_long_nhap_thong_tin')
            </h4>
            @include('partials.footer_form2')

        </div>

    </div>
</div>
</div>
<!--Mobile-->
<span class="btnpopupform"> <img src="{{URL::to('/')}}{{$urlimag}}" alt=""></span>
<div id="popupform" >

    <span class="btnpopupform">x</span>
    <div class="sidebar-fixed">              
        <div class="inner">
            
            <div class=" f03">
                <h4>
            @lang('menu.page.vui_long_nhap_thong_tin')
            </h4>
            @include('partials.footer_form2')

            </div>

        </div>
    </div>
</div> 


<section class="f03 row-section" id="form">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-md-8">
                
                <div class="row noclear">
                <div class="col-sm-6 col-md-6">
                <h2 class="uppercase">@lang('page.registry_advice')</h2>
                <p>@lang('page.text_advice')</p>
                    <p>@lang('page.text_advice1')</p>
                </div>
                <div class="col-sm-6 col-md-6" style="margin-top: 30px">
              <!--      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.386769949894!2d106.70427251785604!3d10.78166041838211!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f49355b9e3b%3A0x4035bc879a502570!2sThe+Nomad+Offices%2C+Gemadept+Tower!5e0!3m2!1svi!2s!4v1532420252707" width="375" height="300" frameborder="0" style="border:0" allowfullscreen></iframe> -->
              <iframe allowfullscreen="" frameborder="0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.381877455573!2d106.70343431480084!3d10.782035992317741!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f49357d9e5b%3A0x94bb88ba0f704b6f!2zVVNJUyB8IFTGsCB24bqlbiDEkeG6p3UgdMawIMSR4buLbmggY8awIG3hu7kgdGhlbyBjaMawxqFuZyB0csOsbmggRUItNQ!5e0!3m2!1sen!2svn!4v1454575923928" style="border:0"  width="375" height="300"></iframe>
                </div>
                </div>
            </div>
            <div class="col-sm-4 col-md-4 pleft50">
                <p>@lang('page.text_info')</p>
                @include('partials.footer_form')
            </div>  
        </div>
    </div>  
</section>
 
<footer id="footer">
    <div class="container">
        <div class="logogroup">
            <div class="row">
                <div class="col-sm-2">
                    @if($footerlogo)
                        <a href="/">
                        @if($imagelogofooter)
                            <img src="/uploads/thumbnail/setting/{{$imagelogofooter->name}}" alt="" />
                        @endif
                        </a>
                    @endif
                </div>
                <div class="col-sm-10">
                    <div class="row">
                        @if($menus)
                            <?php $i = 0 ?>
                            @foreach($menus as $menu)
                            <div class="col-sm-4 col-xs-6">
                                <p class="logof">
                                    @if(isset($logofooter['link']) && $logofooter['link'][$i] != '')<a href="{{$logofooter['link'][$i]}}" target="_blank">@endif
                                         @if(isset($logofooter['url']))
                                        <img  src="/uploads/thumbnail/setting/{{$logofooter['url'][$i]}}" alt=""/>
                                        @else
                                        <img src="/images/logo3.png" alt="">
                                        @endif
                                     @if(isset($logofooter['link']) && $logofooter['link'][$i] != '')</a>@endif
                                </p>
                                @if(isset($menu['children']))
                                    <p><strong>{{$menu[$current_locale]}}</strong></p>
                                    <ul class="menu">
                                        @foreach($menu['children'] as $child)
                                        <li><a href="{{$child[$current_locale.'_url']}}" target="_blank">
                                            {{$child[$current_locale]}}
                                        </a></li>
                                        @endforeach
                                    </ul>
                                @else
                                <ul class="menu">
                                    <li><a href="{{$menu[$current_locale.'_url']}}">{{$menu[$current_locale]}}</a></li>
                                </ul>
                                @endif
                            </div>
                            <?php $i++;?>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bottomfooter">
        <div class="container">
            <div class="copyright">All right reserved © USIS Group 2018.</div>
            <a href="//www.dmca.com/Protection/Status.aspx?ID=c9176573-8d43-4535-9bc6-086800e6cec7" title="DMCA.com Protection Status" class="dmca-badge"> <img src ="https://images.dmca.com/Badges/dmca-badge-w100-5x1-04.png?ID=c9176573-8d43-4535-9bc6-086800e6cec7"  alt="DMCA.com Protection Status" /></a>
            <script src="https://images.dmca.com/Badges/DMCABadgeHelper.min.js"> </script>
            <div class="list-social">
                <a href="https://www.facebook.com/dautumy/" class="fb"><i class="fa fa-facebook-official"></i></a>
                <!-- <a href="#" class="in"><i class="fa fa-instagram"></i></a> -->
                <a href="https://www.youtube.com/channel/UCCGhCV9sVnYczPh4lx9nXBg" class="you"><i class="fa fa-youtube"></i></a>
            </div>
        </div>
    </div>
</footer>
<style>
/*.row-label {
    padding: 0px !important;
    margin: 0 0 15px !important;
}*/
.pleft50{padding-left: 50px}
.container ul {padding-left:30px;}
.logogroup ul {padding-left: 0}
    .section-header i{display: none}
    #myModalDownload .infusion-field {position: relative;}
    #myModalDownload .infusion-field label.error {position: absolute;top: 8px;right: 7px;color: red;}
    .loadingForm{position: absolute;top: 0;left: 0;width: 100%;height: 100%;vertical-align: middle;text-align: center;display: none}
    .loadingForm:before{content:"";display: inline-block;}
    .loadingForm img {width:50%;display: inline-block;}
    #formContact {position: relative;}
    .textreturn{text-align: center;display: none;display: none;clear: both}
    .downloadFile{display: none}
    .sidebar-fixed .vanphong{display: none}
    body>#wrapper>#wrapper{overflow-x: visible;}
    #header ul.mainmenu ul.submenu2 {
        left: 100%;
        top: 0;
        margin-top: 0 !important;
    }
    #header ul.mainmenu ul li.has-child{position: relative;}
    #header ul.mainmenu ul.submenu2:before{
        left: -20px;
        top: 20px;
        border-bottom:10px solid transparent;
        border-right:10px solid #1D3768;
        border-top: 10px solid transparent;
    }
    #header ul.mainmenu ul.submenu2:hover:before{
       border-right:10px solid #0C50B8;
    }
    #header ul.mainmenu ul li.has-child:before{
        content:"";
        position: absolute;top: 25px;right: 10px;
        border-bottom:5px solid transparent;
        border-left:5px solid #fff;
        border-top: 5px solid transparent;
    }
    #floatMenu{
        transition: all 0.4s ease 0s;-moz-transition: all 0.4s ease 0s;[-webkit-transition: all 0.4s ease 0s;-o-transition: all 0.4s ease 0s;}
    .noclear{
        clear: inherit;
    }
</style>
<script>
    jQuery(document).ready(function(){
      $('#form-Contact').validate({
         rules:{
            firstname: "required",
            lastname: "required",
            Email: "required",
            Phone: "required",
            // option: {
            //    required: true
            //  },
         },
         messages:{
            firstname: "required",
            lastname: "required",
            Email: "required",
            Phone: "required",
            // option:"required",
         }
      })
   });
    $('#formContact').submit(function(e){
    // $('#submitContact').on('click',function(e){
        // if($('#checkoutform').valid({
        //     rules:{
        //     firstname: "required",
        //     lastname: "required",
        //     Email: "required",
        //     Phone: "required",
        //     option: {
        //        required: true
        //      },
        //  },
        //  messages:{
        //     firstname: "required",
        //     lastname: "required",
        //     Email: "required",
        //     Phone: "required",
        //     option:"required",
        //  }
        // }) == false){
        //     return false;
        // }
        var formparent = $(this).closest('form'),
        firstname = formparent.find('input[name=firstname]').val(),
        lastname = formparent.find('input[name=lastname]').val(),
        email = formparent.find('input[name=Email]').val(),
        phone = formparent.find('input[name=Phone]').val(),
        message = '',
        // option = formparent.find('#vanphong').val();
        name = firstname+' '+lastname;
        ajaxContact(name,phone,email,message);
        e.preventDefault();
    //ajax send contact
    });
    //ajax gổi contact trong popup
    function ajaxContact(name,phone,email,message){
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
        });
        $.ajax({
            type: 'POST',
            url: "{{action('ContactController@contactUs')}}",
            data: {'email':email,'name':name,'phone':phone,'message':message},
            beforeSend: function(){
                $('.loadingForm').show();
            },
            success: function(data){
                $('.textreturn').css('display','block');
                $('.loadingForm').hide();
                $('.downloadFile').show();
                // window.location.href = '{{URL::to('/')}}/download/test.pdf';
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    }
     $('.downloadFile').mousedown(function(){
        $(this).trigger( "click" );
    });


(function ($) {
    $(document).ready(function () {
        $('#btnClose').on('click',function(){
            $('.sidebar-fixed').removeClass('show');
            setTimeout(
            function() {
              $('.btnbook,#btnClose').removeClass("show");
            }, 300);
        });
        $(".ia-container").each(function () {    
            main = $(this);
            total = parseInt($(main).attr('data-item'));    
            container = $(main).width();
            item = container*0.6;
            widthdu = container - item;
            input = widthdu/(total-1);
            $(main).find('figure').css('width',item+'px');
            $(main).find('figure').css('left',input+'px');
            $(main).find('input:checked ~ figure').css('left',item+'px');
            input2 = $(main).find('input');
            input2.each(function () {  
                $(this).on('change',function() {
                    if($(this).prop('checked')){
                        $(main).find('figure').css('left',input+'px').removeClass('active');
                        $(this).next().next().css('left',item+'px').addClass('active');
                    }
                });
            });  
            $(main).find('input').css('width',input+'px');
        });  


    // function moveFloatMenu() {
    //     var menuOffset = menuYloc.top + $(this).scrollTop() + "px";
    //     $('#floatMenu').animate({
    //         top: menuOffset
    //     }, {
    //         duration: 700,
    //         queue: false
    //     });
    // }
    function moveFloatMenu() {
        var winWidth = $(window).width();
        if(winWidth > 1024){
            var menuOffset = menuYloc.top + $(this).scrollTop() + "px";
            $('#floatMenu').animate({
                top: menuOffset
            }, {
                duration: 100,
                queue: false
            });
        }else{
            var $sidebar = $('#floatMenu'),
            $window = $(window),
            offset = $sidebar.offset(),
            topPadding = 100;
            if ($window.scrollTop() > $sidebar.scrollTop()) {
                $sidebar.stop().animate({
                    marginTop: $window.scrollTop() - $sidebar.scrollTop() + topPadding
                },{
                    duration: 100,
                    queue: false
                });
            }else {
                $sidebar.stop().animate({
                    marginTop: 100
                });
            }
        }
        
    }
    menuYloc = $('#floatMenu').offset();
    $(window).scroll(moveFloatMenu);
    // moveFloatMenu();

    });
})(jQuery); 

//menu cấp 2
var winWidth = $(window).width();
if(winWidth <= 1024){
    $('.menu-mainmenu li.has-child').each(function(){
        var $this = $(this);
        $this.append('<span class="showsubmenu-2 fa fa-caret-down"></span>');
        $this.children('.showsubmenu-2').css({'top':'0px'});
        var button = $this.children('.showsubmenu-2');
        button.on('click',function(){
            if($(this).prev().is(':visible')){
                $(this).prev().slideUp(300);
                $(this).removeClass('rotate');
            }else{
                $(this).prev().slideDown(300);
                $(this).addClass('rotate');
            }
        }) 
    });

}


</script>
<meta name="_token" content="{{ csrf_token() }}">