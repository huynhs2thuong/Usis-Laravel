<div id="wrapper">
    <span class="menu-btn overlay"> </span>
    <div id="panel">
        <div class="chart-div">
            <div class="list-social">
                <a href="https://www.facebook.com/dautumy/" class="fb"><i class="fa fa-facebook-f"></i></a>
                <!-- <a href="#" class="in"><i class="fa fa-twitter"></i></a>
                <a href="#" class="you"><i class="fa fa-google-plus"></i></a> -->
                <a href="https://www.youtube.com/channel/UCCGhCV9sVnYczPh4lx9nXBg" class="you"><i class="fa fa-youtube"></i></a>
            </div>
            <div class="header-right">
                <div class="search">
                    <a href="{{action('AmpController@search')}}"><i class="fa fa-search" ></i></a>
                </div>
                <div class="link">
                    <?php if($current_locale == 'en'): $faqurl = 'faqs'; else: $faqurl = 'cau-hoi-chung'; endif;?>
                    <a href="{{route('subfaqsamp',$faqurl)}}">Q&A</a>
                </div>
                <div class="language">
                    <a href="/amp" <?php if($current_locale == 'vi'):?> class="active" <?php endif;?>>Vi</a> - 
                    <a href="/en/amp" <?php if($current_locale == 'en'):?> class="active" <?php endif;?>> En </a>
                </div>
            </div>
        </div>
    </div>
</div>
<header id="header">

    <div class="chart-div">

        <a href="/{{ ($current_locale == 'vi') ? '' : $current_locale.'/' }}amp" id="logo a"> 
          <div class="display-table">
            <div class="table-cell"><amp-img src="@if($setting){{$setting->getLogo()}}@endif" layout="responsive" width="94" height="50" alt=""></amp-img> </div>
          </div>
        </a>
        <div class="header-right">
            <button class="menu-btn" [class]="visible ? 'menu-btn show' : 'menu-btn hide'" 
           on="tap:AMP.setState({visible: !visible})" ><span></span></button> 
        </div>

        <div class="menu-mainmenu hide" [class]="visible ? 'menu-mainmenu show' : 'menu-mainmenu hide'">
            <amp-accordion class="mainmenu pull-left">
                <?php $midLane = (int)(count($menus)/2) -1; ?>
                @foreach($menus as $key => $menu)
                    <section class="@if(array_key_exists('children',$menu)) parent @endif">
                        <h4 class='a'>
                        @if(array_key_exists('children',$menu))
                            <span class="showsubmenu fa fa-caret-down"></span>
                            @endif
                            <a href='<?php if($current_locale == 'en' && $menu[$current_locale."_url"] != 'javascript:;'): ?>/en<?php endif; ?>{{ $menu[$current_locale."_url"] }}' @if(array_key_exists('children',$menu)) class="parent" @endif >{!! $menu[$current_locale] !!}</a>
                        </h4>
                        @if(array_key_exists('children',$menu))
                        <div>
                            <ul>
                                @foreach($menu['children'] as $item)
                                    <div class="@if(array_key_exists('children',$item)){{'has-child'}}@endif">
                                        @if(array_key_exists('children',$item))
                                            <amp-accordion>
                                                <section>
                                                    <h4>          
                                                        <span class="showsubmenu fa fa-caret-down rotate"></span>
                                                        <a href='<?php if($current_locale == 'en'): ?>/en<?php endif; ?>{!! $item[$current_locale."_url"] !!}'>{!! $item[$current_locale] !!}</a>
                                                    </h4>
                                                    <div>
                                                         @foreach($item['children'] as $sub)
                                                        <li>
                                                            <a href='<?php if($current_locale == 'en'): ?>/en<?php endif; ?>{!! $item[$current_locale."_url"] !!}/{!! $sub[$current_locale."_url"] !!}'>{!! $sub[$current_locale] !!}</a>
                                                        </li>
                                                        @endforeach
                                                    </div>
                                                </section>
                                            </amp-accordion>
                                        @else
                                            <h4>
                                            <a href='<?php if($current_locale == 'en'): ?>/en<?php endif; ?>{!! $item[$current_locale."_url"] !!}'>{!! $item[$current_locale] !!}</a>
                                            </h4>
                                        @endif

                                    </div>
                                @endforeach
                            </ul>
                        </div>
                        @else
                        <div></div>
                        @endif
                    </section>
                    @if($key == $midLane)
                    </amp-accordion>
                    <amp-accordion class="mainmenu pull-right">
                    @endif
                @endforeach
            </amp-accordion>
        </div>
    </div>
</header>
