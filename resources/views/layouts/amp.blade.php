<!DOCTYPE html>
<html amp>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <link rel="shortcut icon" href="/images/logo.png" sizes="32x32">
    @stack('og-meta')
   
    <link href="https://fonts.googleapis.com/css?family=Muli:200,300,400,400i,600,700,800,900" rel="stylesheet">
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
    <script async custom-element="amp-facebook" src="https://cdn.ampproject.org/v0/amp-facebook-0.1.js"></script>
    <script async custom-element="amp-iframe" src="https://cdn.ampproject.org/v0/amp-iframe-0.1.js"></script>
    <script async custom-element="amp-form" src="https://cdn.ampproject.org/v0/amp-form-0.1.js"></script>
    <script async custom-element="amp-bind" src="https://cdn.ampproject.org/v0/amp-bind-0.1.js"></script>
    <script async custom-element="amp-accordion" src="https://cdn.ampproject.org/v0/amp-accordion-0.1.js"></script>
    <script async custom-element="amp-carousel" src="https://cdn.ampproject.org/v0/amp-carousel-0.1.js"></script>
    <script async custom-element="amp-selector" src="https://cdn.ampproject.org/v0/amp-selector-0.1.js"></script>
    <script async custom-element="amp-youtube" src="https://cdn.ampproject.org/v0/amp-youtube-0.1.js"></script>
    <!-- <script async custom-element="amp-install-serviceworker" src="https://cdn.ampproject.org/v0/amp-install-serviceworker-0.1.js"></script> -->
    @stack('scriptamp')
    @include('amp.styles')
</head>
<body class="{{(isset($page) ? " page-$page->template page-$page->slug" : '') . ' ' . $current_locale }}">
    <div id="wrapper">
        @include('amp.header_menu')
        <!-- <amp-install-serviceworker
              src="{{URL::to('/')}}/serviceworker.js"
              layout="nodisplay">
        </amp-install-serviceworker> -->
            @yield('content')
        @include('amp.footer_menu')
    </div> 
</body>
</html>