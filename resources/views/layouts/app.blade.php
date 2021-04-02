<!DOCTYPE html>
<html lang="{{ $current_locale }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="shortcut icon" href="/images/logo.png" sizes="32x32">
    @stack('og-meta')
   
    <link href="https://fonts.googleapis.com/css?family=Muli:200,300,400,400i,600,700,800,900" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel='stylesheet'   href='/css/bootstrap.min.css' type='text/css' media='all' />
    <link rel='stylesheet'   href='/css/style.css?v=20190704' type='text/css' media='all' />
    <link rel='stylesheet'   href='/css/flipclock.css?v=20190704' type='text/css' media='all' />
    <script type="text/javascript" src="/js/jquery.min.js" ></script>
    <script type="text/javascript" src="/js/flipclock.js" ></script>
    <style type="text/css">
        .list_position{
            text-align: justify;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 4;
            line-height: 24px;
            max-height: 96px;
            overflow: hidden
        }
            .menu-content li{padding: 0 10px}
    .menu-content a{font-size: 20px}
    </style>
    @stack('styles')
    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-46138167-1', 'usis.us');
        ga('send', 'pageview');

    </script>

    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window,document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
     fbq('init', '1820761744851440'); 
    fbq('track', 'PageView');
    </script>
    <noscript>
     <img height="1" width="1" 
    src="https://www.facebook.com/tr?id=1820761744851440&ev=PageView
    &noscript=1"/>
    </noscript>
    <!-- End Facebook Pixel Code -->
    <!-- Global site tag (gtag.js) - AdWords: 949292858 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-949292858"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'AW-949292858');
    </script>
	<!-- Load Facebook SDK for JavaScript -->
      <div id="fb-root"></div>
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            xfbml            : true,
            version          : 'v5.0'
          });
        };

        (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));</script>

      <!-- Your customer chat code -->
      <div class="fb-customerchat"
        attribution=setup_tool
        page_id="1420321108181650"
  logged_in_greeting="Chào a/c. USIS có thể giúp gì được cho a/c?"
  logged_out_greeting="Chào a/c. USIS có thể giúp gì được cho a/c?">
      </div>
    <style>
    div.tags{
            margin-top: 30px;
    border-top: 1px solid #ddd;
    padding-top: 30px;
    }
    .container ul.tags{padding:0;margin: 0;list-style: none;display: inline}
    .tags>span{font-weight: bold}
    .container ul.tags li{display: inline-block;}
    .container ul.tags li a{padding: 5px 10px;border: 1px solid #ddd}
    .container ul.tags li a:hover{background: #1E2E42;color: #fff;border: 1px solid #1E2E42}
    .sidebar ul.menu{padding-left: 0}
    h2{
        text-transform:capitalize
    }
    @media screen and (max-width: 1024px){
        #header ul.mainmenu ul.submenu2{position: relative;display: none;visibility: visible;opacity: 1;left: 0!important;background: #f7f7f7;}
        
        .showsubmenu-2
        {
            font-size: 26px;
            z-index: 10;
            position: absolute;
            right: 0;
            width: 50px;
            height: 50px;
            display: block!important;
            line-height: 50px;
            text-align: center;
            font-family: FontAwesome;
            transition: .5s;
            -webkit-transition: .5s;
            -moz-transition: .5s;
            -o-transition: .5s;
        }
        .showsubmenu-2:before{
            content:'\f107';
        }
        .showsubmenu-2.rotate{transform: rotate(180deg);-webkit-transform: rotate(180deg);-moz-transform: rotate(180deg);-ms-transform: rotate(180deg);}
        #floatMenu{
            top:0;right: 0;
        }

    }
    #btnClose{
        position: absolute;
        width: 30px;
        height: 30px;
        background: #bb2142;
        z-index: 999;
        text-align: center;
        line-height: 28px;
        border-radius: 50%;
        color: #fff;
        left: -15px;
        top: -15px;
        cursor: pointer;
        -o-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
        -webkit-transition: all 0.3s ease-in-out;
        overflow: hidden;
        -ms-transform: scale(0.5, 0.5); /* IE 9 */
        -webkit-transform: scale(0.5, 0.5); /* Safari */
        transform: scale(0.5, 0.5);
        opacity: 0;
    }
    .sidebar-fixed #btnClose.show {
        -ms-transform: scale(1, 1); /* IE 9 */
        -webkit-transform: scale(1, 1); /* Safari */
        transform: scale(1, 1);
        opacity: 1;
    }
    @media screen and (max-width: 767px){
        .snip1543 .desc {
            display: block !important;bottom: 0;left: 0;top: auto;width: 100%;height:100%;
            -ms-transform: translateX(0%);
            transform: translateX(0);
            -webkit-transform: translateX(0%);opacity: 1
        }
        .snip1543 .desc .table-cell,.snip1543 .desc .display-table {display: block;}
        .snip1543 .desc .display-table {position: absolute;bottom: 0;height: 50px;background: #1d3768}
        .snip1543 .desc .table-cell p {display: none}
        .display-table .table-cell{padding: 10px}
        .snip1543 .desc h3{font-size: .8em !important;line-height: 1.4 !important;}
        .snip1543{background: #ddd}
        .sidebar ul.menu{padding-left: 0}
    }
    .sidebar-fixed .btnbook{
        width: 35px;left: -35px;
    }
    .sidebar-fixed .btnbook.show{
        left:0;
    }
</style>

</head>
<body class="{{ $bodyClass . (isset($page) ? " page-$page->template page-$page->slug" : '') . ' ' . $current_locale }}">
    <div id="wrapper">
        @include('site.header_menu')
            @yield('content')
        @include('site.footer_menu')
    </div>
	
	@stack('body_end')
    
    <script type='text/javascript' src='/js/wow.min.js'></script> 
    <script type='text/javascript' src='/js/owl.carousel.min.js'></script> 
    <script type='text/javascript' src='/js/bootstrap.min.js'></script> 
    <script type='text/javascript' src='/js/jquery-scrolltofixed-min.js'></script> 
    <script type='text/javascript' src='/js/imagesloaded.pkgd.min.js'></script> 
    <script type='text/javascript' src='/js/script.js'></script> 
    <script type='text/javascript' src='/js/jquery.validate.min.js'></script> 
    <script type='text/javascript' src='/js/jquery.validate.min.js'></script> 
    @stack('scripts')   
</body>
</html>
