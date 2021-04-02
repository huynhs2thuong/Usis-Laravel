<div id="floatMenu" [class]="visible1 ? 'sidebar-fixed show' : 'sidebar-fixed hide'">
<div class="sidebar-fixed">
    <span class="btnbook">
    <?php 
    if($current_locale == 'en'){
        $urlimag = '/images/Button-Tai-cam-nang-E.png';
    }else{
         $urlimag = '/images/Tai-cam-nang.png';
    }

    ?>
    <button [class]="visible1 ? 'show' : 'hide'" on="tap:AMP.setState({visible1: !visible1})">
        <amp-img src="{{URL::to('/')}}{{$urlimag}}" width="45" height="180" layout="responsive" alt="" ></amp-img>
    </button>
    </span>                
    <div class="inner">
        
        <div class=" f03">
            <h4>
            @lang('menu.page.vui_long_nhap_thong_tin')
            </h4>
            @include('partials.amp.footer_form2')

        </div>

    </div>
</div>
</div>
<section class="f03 row-section" id="form">
    <div class="chart-div">
        <div class="row">
            <div class="col-sm-8 col-md-8">
                
                <div class="row noclear">
                <div class="col-sm-6 col-md-6">
                <h2 class="uppercase">@lang('page.registry_advice')</h2>
                <p>@lang('page.text_advice')</p>
                    <p>@lang('page.text_advice1')</p>
                </div>
                <div class="col-sm-6 col-md-6">
              <amp-iframe allowfullscreen="" sandbox="allow-scripts allow-same-origin" frameborder="0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.381877455573!2d106.70343431480084!3d10.782035992317741!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f49357d9e5b%3A0x94bb88ba0f704b6f!2zVVNJUyB8IFTGsCB24bqlbiDEkeG6p3UgdMawIMSR4buLbmggY8awIG3hu7kgdGhlbyBjaMawxqFuZyB0csOsbmggRUItNQ!5e0!3m2!1sen!2svn!4v1454575923928" width="375" height="300" layout="responsive"></amp-iframe>
                </div>
                </div>
            </div>
            <div class="col-sm-4 col-md-4 pleft50">
                <p>@lang('page.text_info')</p>
                @include('partials.amp.footer_form')
            </div>  
        </div>
    </div>  
</section>

<footer id="footer">
    <div class="chart-div">
        <div class="logogroup">
            <div class="row">
                <div class="col-sm-2 firstlogo">
                    @if($footerlogo)
                        <a href="/">
                        @if($imagelogofooter)
                            <amp-img width="160" height="160" src="/uploads/thumbnail/setting/{{$imagelogofooter->name}}" layout="responsive" alt=""></amp-img>
                        @endif
                        </a>
                    @endif
                </div>
                <div class="col-sm-10">
                    <div class="row">
                        @if($menus)
                            <?php $i = 0 ?>
                            @foreach($menus as $menu)
                            <div class="col-sm-3 col-xs-6">
                                <p class="logof">
                                    @if(isset($logofooter['link']) && $logofooter['link'][$i] != '')<a href="{{$logofooter['link'][$i]}}" target="_blank">@endif
                                         @if(isset($logofooter['url']))
                                        <amp-img width="122" height="65" src="/uploads/thumbnail/setting/{{$logofooter['url'][$i]}}" layout="responsive" alt=""></amp-img>
                                        @else
                                        <amp-img width="122" height="65" src="/images/logo3.png" layout="responsive" alt=""></amp-img>
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
        <div class="chart-div">
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
<meta name="_token" content="{{ csrf_token() }}">