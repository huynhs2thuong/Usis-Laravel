<div id="wrapper">
    <span class="menu-btn overlay"> </span>
    <div id="panel">
        <div class="container">
            <div class="list-social">
                <a href="https://www.facebook.com/dautumy/" class="fb"><i class="fa fa-facebook-f"></i></a>
                <!-- <a href="#" class="in"><i class="fa fa-twitter"></i></a>
                <a href="#" class="you"><i class="fa fa-google-plus"></i></a> -->
                <a href="https://www.youtube.com/channel/UCCGhCV9sVnYczPh4lx9nXBg" class="you"><i class="fa fa-youtube"></i></a>
            </div>
            <div class="header-right">
                <div class="search">
                    <a href="{{action('SiteController@search')}}"><i class="fa fa-search" ></i></a>
                </div>
                <div class="link">
                    <?php if($current_locale == 'en'): $faqurl = 'faqs'; else: $faqurl = 'cau-hoi-chung'; endif;?>
                    <a href="{{route('subfaqs',$faqurl)}}">Q&A </a>
                </div>
                <div class="language">
                    <a href="/" <?php if($current_locale == 'vi'):?> class="active" <?php endif;?>>Vi</a> - 
                    <a href="/en" <?php if($current_locale == 'en'):?> class="active" <?php endif;?>> En </a>
                </div>
            </div>
        </div>
    </div>
</div>
<header id="header">

    <div class="container">

        <a href="/{{ ($current_locale == 'vi') ? '' : $current_locale }}" id="logo"> 
          <div class="display-table">
            <div class="table-cell"><img src="@if($setting){{$setting->getLogo()}}@endif" alt="" /> </div>
          </div>
        </a>
        <div class="header-right">
            <span class="menu-btn"><span></span></span> 
        </div>

        <div class="menu-mainmenu">
            <ul class="mainmenu pull-left">
                <?php $midLane = (int)(count($menus)/2) -1;
                
                ?>
               
                @foreach($menus as $key => $menu)
                    <li  class="@if(array_key_exists('children',$menu)) parent @endif" style="@if( !empty($menu['hidden']) && $menu['hidden'] == 1) display:none @endif"> 
                        <a class="parent-link" href='<?php if($current_locale == 'en' && $menu[$current_locale."_url"] != 'javascript:;'): ?>/en<?php endif; ?>{{ $menu[$current_locale."_url"] }}' @if(array_key_exists('children',$menu)) class="parent" @endif >{!! $menu[$current_locale] !!}</a>
                        @if(array_key_exists('children',$menu))
                            <ul class="@if(array_key_exists('children',$menu)) {{'parent-child'}}<?=$key ?> @endif">
                                @foreach($menu['children'] as $item)
                                    <li id="service" class="@if(array_key_exists('children',$item)){{'has-child'}}@endif" style="@if( !empty($item['hidden']) && $item['hidden'] == 1) display:none; @endif width:100%">
                                        <a href='<?php if($current_locale == 'en'): ?>/en<?php endif; ?>{!! $item[$current_locale."_url"] !!}'>{!! $item[$current_locale] !!}</a>
                                        <?php // print_r($item)?>
                                        @if(array_key_exists('children',$item))
                                        <ul class="submenu2">
                                            @foreach($item['children'] as $sub)
                                            <li style="@if(!empty($sub['hidden']) && $sub['hidden'] == 1) display:none; @endif height:40px;">
                                                <a href='<?php if($current_locale == 'en'): ?>/en<?php endif; ?>{!! $sub[$current_locale."_url"] !!}'>{!! $sub[$current_locale] !!}</a>
                                            </li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>






					@if($key == $midLane)
			</ul>
			<ul class="mainmenu pull-right">
                    @endif
                @endforeach
            </ul>
			<div style="clear:left;"></div>
        </div>
    </div>
</header>
