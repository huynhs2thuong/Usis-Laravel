@extends('layouts.app')
@section('title', $page->title)
@section('content')
<div id="breadcrumbs">
    <div class="container"> 
        <ul class="breadcrumb">
            <li><a href="@lang('menu.url.home')">@lang('menu.page.home')</a></li>
            <li><a href="{{action('AboutController@index')}}">@lang('admin.object.introduction')</a></li>
            <li><span>{{$page->title}}</span></li>
        </ul>
    </div>
</div>
	<div class="wrap-page-title-emty"></div>
	<div id="maincontent">
		{!! $page->description !!}

		<section id="google_photo"  ng-app="TOA" ng-controller="GooglePhotos">
            <div class="photos row block-1 grid-space-2">
                    <div class="col-sm-3 col-md-3 photo" ng-repeat="project in model.projects" ng-click="showDetail($index)" google-photo-element> 
                        <div class="item">
                            <div class="item_img">
                                <img ng-src="<%project.thumb%>" />
                            </div>
                            <div class="item_content">
                                <p class="item_date"><%dateFormat(project.date)%></p>
                                <div class="item_title">
                                    <%project.title%>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
            <div id="google_photo_detail" ng-controller="GooglePhotoDetail" class="col-sm-12 col-md-12 " style="display:none;">
	            <div class="container">
                    <div class="row">
                        <div class="col-md-8 ">
                            <div class="col-img">
                                <div class="">
                                    <div class="images owl-carousel single-slide s-nav s-auto s-dots">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 ">
                            <div class="col-text bg-1">

                                    <h3><%model.project.title%></h3>
                                    <div class="desc" style="max-height: 250px"><%model.project.fullDesc%></div>
                                    <div class="colors">
                                        <div class="color" ng-repeat="color in model.project.colors"></div>
                                    </div>
                                    <p class="b color-main">@lang('page.son_trong_cong_trinh'):</p>
                                     <ul  class="link">
                                        <li ng-repeat="opt in model.project.products ">
                                            <a href="<% opt.url %>"><% opt.title %></a>
                                        </li>
                                    </ul>                             
                            </div>
                        </div>
                    </div>
                    
	            </div>
                <a href="javascript:void(0)" class="close" ng-click="closeDetail()">
                        <i class="icon-close"></i>
                    </a>
                    <a href="javascript:void(0)" class="btn-prev" ng-click="prevDetail()">
                        <i class="fa fa-chevron-left"></i>
                    </a>
                    <a href="javascript:void(0)" class="btn-next" ng-click="nextDetail()">
                        <i class="fa fa-chevron-right"></i>
                    </a> 
            </div>
		</section>
        <div class=" mt-40">
            @if($datas->lastPage() > 1)
                {{ $datas->links() }}
            @endif
        </div>
		@include('partials.toaTool')
	</div>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script type="text/javascript">window.TOA = window.TOA || {};
    TOA.GooglePhotos = (function($) {
        var mapData = function(data, map) {
            $.each(map, function(key, val) {
                if (data[key] != undefined) {
                    data[val] = data[key];
                    delete data[key];
                }
            });
            return data;
        }
        return $.extend(function(options, data) {
            var self = arguments.callee;
            options = $.extend({}, self.options, options);
            var app = angular.module(options.module, [], function($interpolateProvider) {
                $interpolateProvider.startSymbol('<%');
                $interpolateProvider.endSymbol('%>');
            });
            var getEndOfRow = function(element) {
                var endEl = $(element),
                    currentTop = endEl.position().top,
                    nextEl;
                while (true) {
                    nextEl = endEl.next();
                    while (nextEl.length && !nextEl.hasClass('photo')) nextEl = nextEl.next();
                    if (!nextEl.length) break;
                    if (nextEl.position().top > currentTop) break;
                    endEl = endEl.next();
                }
                return endEl;
            }
            app.controller('GooglePhotos', ['$scope', function(scope) {
                var viewPort, viewportPos, transitionEvts = 'transitionend webkitTransitionEnd oTransitionEnd';
                $.extend(scope, {
                    model: {
                        projects: (data || []).map(function(project) {
                            return mapData(project, options.map);
                        })
                    },
                    viewport: {},
                    showDetail: function(index) {
                        index = index < 0?0:index;
                        index = index > scope.model.projects.length - 1? scope.model.projects.length - 1: index;
                        scope.model.projectIndex = index;
                        var panel = scope.viewport.el(),project = scope.model.projects[index];
                        project.element.parent().children('.active').removeClass('active');
                        if (project === scope.viewport.model.project) {
                            if (panel.is(':visible')) {
                                this.closeDetail();
                            } else {
                                panel.addClass('animating').slideDown(options.duration, function() {
                                    panel.removeClass('animating');
                                });
                                project.element.addClass('active');
                            }
                        } else {
                            scope.refreshViewport(project, true);
                            scope.viewport.show(project);
                            project.element.addClass('active');
                        }
                    },
                    closeDetail: function() {
                        this.viewport.el().addClass('animating').slideUp(options.duration, function() {
                            $(this).removeClass('animating')
                        });
                    },
                    prevDetail: function(){ scope.showDetail(scope.model.projectIndex - 1)},
                    nextDetail: function(){ scope.showDetail(scope.model.projectIndex + 1)},
                    dateFormat: function(date) {
                        return date;
                    },
                    refreshViewport: function(project, animate) {
                        if (!project) return;
                        var
                            isVisible = scope.viewport.el().is(':visible'),
                            viewport = scope.viewport.el().hide(),
                            endEl = getEndOfRow(project.element);
                        viewport.show();
                        if (!endEl.is(viewportPos)) {
                            if (animate) {
                                if (isVisible) {
                                    var holder = viewport.clone().insertAfter(viewport).addClass('animating').slideUp(options.duration, function() {
                                        holder.remove();
                                    });
                                }
                                viewport.hide().addClass('animating').slideDown(options.duration, function() {
                                    viewport.removeClass('animating');
                                });
                            }
                            endEl.after(viewport);
                            viewportPos = endEl;
                        } else if (animate && !isVisible) {
                            viewport.hide().addClass('animating').slideDown(options.duration, function() {
                                viewport.removeClass('animating');
                            });
                        }
                    }
                });
                $(window).resize(function() {
                    scope.refreshViewport(scope.viewport.model.project);
                });
            }]).controller('GooglePhotoDetail', ['$scope', '$element', function(scope, element) {
                scope.$parent.viewport = scope;


                var
                    $scoll = $('html,body'),
                    owl = element.find('.images');
                $.extend(scope, {
                    model: {},
                    el: function() {
                        return element;
                    },
                    project: {},
                    close: function() {},
                    show: function(project) {
                        if (this.model.project === project) return;
                        this.model.project = project;
                        owl.find('.owl-stage').children().each(function(index){
                            owl.trigger('remove.owl.carousel', [index]);
                        });

                        $.each(project.images,function(i,img){
                            owl.trigger('add.owl.carousel', [$('<div class="item">').append($('<img>',{src:img})), i]);
                        });
                        owl.trigger('refresh.owl.carousel');
                        setTimeout(function(){
                            $scoll.stop().animate({scrollTop: element.offset().top - 100});
                        },300);
                    }
                });
            }]).directive('googlePhotoElement', function() {
                var propName;
                return function(scope, element, attrs) {
                    propName = propName || $.trim(attrs.ngRepeat.split(' in ')[0]);
                    scope[propName].element = element;
                };
            });
        }, {
            options: {
                module: 'TOA',
                map: function(project) {
                    return project;
                },
                duration: 300
            }
        })
    })(jQuery);


    var exampleData = (function(count){
        var arr = [];
        @foreach($datas as $data)
            arr.push({
                id: {{ $data->id }},
                title: '{{ $data->title }}',
                date: '{{date("d-M-Y", strtotime(str_replace("/", "-", "$data->created_at")))}}',
                thumb: '{{ $data->getImage("full") }}',
                fullDesc: <?php 
                                $string = strip_tags($data->description, '</p>');
                                $string = str_replace("\n", "", $string);
                                $string = str_replace("\r", "", $string); 
                                $string = str_replace("&nbsp;", " ", $string); 
                                echo "'".$string."'"; 
                        ?>,
                images: [<?php echo $data->img_slide; ?>],
                colors: [
                    {
                        title: 'Nau',
                        hex: 'ff0000',
                        id: 12453
                    }
                ],
                products:[
                    <?php $i=0; ?>
                    @foreach($data->products as $product)
                        <?php if($i>0) echo ','; ?>
                        {
                            title: '{{$product->shortTitle}}',
                            url: '{{action("ProductController@detail",["slug"=>$product->slug])}}'
                        }
                        <?php $i++; ?>
                    @endforeach
                ]
            });
        @endforeach
        return arr;
    })(12);
    TOA.GooglePhotos({
        module: 'TOA'
    },exampleData);
</script>
@endsection
