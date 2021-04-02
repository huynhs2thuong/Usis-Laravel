@push('styles')
    <style type="text/css">
        .input-field > .browser-default {
            margin-top: 1rem;
        }
    </style>
@endpush

<div class="post col s9">
    <h1 class="text-capitalize">
        @if ($store->id)
            @lang('admin.title.edit', ['object' => trans('admin.object.store')])
            <a href="{{ action('Admin\StoreController@create') }}" class="page-title-action btn waves-effect waves-light cyan">@lang('admin.title.create raw')</a>
        @else
            @lang('admin.title.create', ['object' => trans('admin.object.store')])
        @endif
    </h1>
    <div class="input-field">
        @include('partials.lang_input', ['type' => 'text', 'model' => 'store', 'attr' => 'title', 'title' => trans('admin.field.title'), 'class' => 'auto-width'])
    </div>
    <div class="input-field">
        @include('partials.lang_input', ['type' => 'text', 'model' => 'store', 'attr' => 'address', 'title' => trans('admin.field.address'), 'class' => 'auto-width'])
    </div>
    <div class="row" ng-controller="StoreCtrl">
        <div class="input-field col s3">
            <label class="active">@lang('admin.field.city')</label>
            <select name="city" class="browser-default" ng-model="city" ng-options="city.id as getTranslate(city.title) for city in cities">
                <option value="" disabled="">--</option>
            </select>
        </div>
        <div class="input-field col s3">
            <label class="active">@lang('admin.field.district')</label>
            <select name="district_id" class="browser-default" ng-model="district" ng-options="district.id as getTranslate(district.title) for district in districts | filter:{city_id: city}:true">
                <option value="" disabled="">--</option>
            </select>
        </div>
    </div>
    <div class="input-field">
        @include('partials.lang_input', ['type' => 'text', 'model' => 'store', 'attr' => 'business_hours', 'title' => trans('admin.field.business_hours'), 'class' => 'auto-width'])
    </div>
    {{-- <div class="input-field">
        <label class="active" for="business_hours">@lang('admin.field.business_hours')</label>
        {{ Form::text('business_hours', $store->business_hours, ['id' => 'business_hours', 'class' => 'auto-width', 'placeholder' => '']) }}
    </div> --}}
    <div class="input-field">
        <label class="active" for="phone">@lang('admin.field.phone')</label>
        {{ Form::text('phone', $store->phone, ['id' => 'phone', 'class' => 'auto-width', 'placeholder' => '']) }}
    </div>
    <div class="input-field">
        <label class="active" for="phone">@lang('admin.field.position')</label>
        <div class="row">
            <div class="col s3">
                {{ Form::text('lat', $store->lat, ['id' => 'lat', 'class' => 'num']) }}
            </div>
            <div class="input-field col s1 center-align">-</div>
            <div class="col s3">
                {{ Form::text('lng', $store->lng, ['id' => 'lng', 'class' => 'num']) }}
            </div>
        </div>
    </div>
    <input id="pac-input" class="controls" type="text" placeholder="@lang('admin.button.search')">
    <div id="googlemap" class=""></div>
</div>
<div class="category col s3">
    <div class="cat-top card hoverable">
        <h3 class="text-capitalize">@lang('admin.button.publish')</h3>
        <div class="divider"></div>
        @if ($store->id)
            <div class="status">
                <p>@lang('admin.field.created at'): {{ $store->created_at }}</p>
                <p>@lang('admin.field.updated at'): {{ $store->updated_at }}</p>
            </div>
            <button type="button" class="btn-delete btn btn-sm left waves-light waves-effect red darken-4">@lang('admin.button.delete')</button>
            <button type="submit" class="btn btn-sm right waves-light waves-effect green accent-4">@lang('admin.button.update')</button>
        @else
            <button type="submit" class="btn btn-sm waves-light waves-effect green accent-4">@lang('admin.button.publish')</button>
        @endif
        <div class="clearfix"></div>
    </div>
    <div class="cat-bottom card hoverable">
        <h1 class="text-capitalize">@lang('admin.field.image')</h1>
        <div class="divider"></div>
        <div class="postimagediv">
            <img src="{{ $store->image }}" class="responsive-img" alt="">
            <input type="hidden" name="resource_id" value="{{ $store->resource_id }}">
            <div class="clearfix"></div>
            <a class="btn waves-effect waves-light cyan {{ $store->resource_id ? 'hide' : '' }} set-image modal-trigger" href="#modal-upload">@lang('admin.button.set image')</a>
            <a class="btn waves-effect waves-light cyan {{ $store->resource_id ? '' : 'hide' }} remove-image">@lang('admin.button.remove image')</a>
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript" src="/js/plugins/angular.min.js"></script>
    <script src="//maps.googleapis.com/maps/api/js?key={{ config('services.google.key') }}&libraries=places&callback=initMap&language={{ $current_locale }}" async defer></script>
    <script type="text/javascript">
        var app = angular.module('jollibee', []);
        app.controller('StoreCtrl', ['$scope', '$http', function($scope, $http) {
            $scope.cities = $scope.districts = [];
            $scope.getTranslate = function(text) {
                return getLocaleText(text, current_locale);
            };
            @if ($store->id)
                $scope.city = {{ $store->district->city_id }};
                $scope.district = {{ $store->district_id }};
            @endif
            $http.get('/api/area/0').success(function(response) {
                $scope.cities = response.cities;
                $scope.districts = response.districts;
            });

        }]);

        var map, init_marker,
            $lat     = $('#lat'),
            $lng     = $('#lng');

        function initMap() {
            var latlng = new google.maps.LatLng({{ $store->lat }}, {{ $store->lng }});

            map = new google.maps.Map(document.getElementById("googlemap"), {
                zoom: 14,
                center: latlng
            });

            init_marker = new google.maps.Marker({
                draggable: true,
                position: latlng,
                map: map
            });

            google.maps.event.addListener(init_marker, 'dragend', function (event) {
                document.getElementById("lat").value = this.getPosition().lat();
                document.getElementById("lng").value = this.getPosition().lng();
            });

            var input = document.getElementById('pac-input');
            var searchBox = new google.maps.places.SearchBox(input);
            var first_search = false;
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            // Bias the SearchBox results towards current map's viewport.
            map.addListener('bounds_changed', function() {
                searchBox.setBounds(map.getBounds());
                if (this.getZoom() > 14 && !first_search) {
                    first_search = true;
                    this.setZoom(14);
                }
            });

            var markers = [];
            searchBox.addListener('places_changed', function() {
                first_search = false;
                var places = searchBox.getPlaces();

                if (places.length === 0) return;

                markers.forEach(function(marker) {
                    marker.setMap(null);
                });
                markers = [];

                var bounds = new google.maps.LatLngBounds();
                places.forEach(function(place) {
                    if (!place.geometry) return;

                    var marker = new google.maps.Marker({
                        map: map,
                        title: place.name,
                        position: place.geometry.location,
                        draggable: true
                    });
                    google.maps.event.addListener(marker, 'dragend', function (event) {
                        document.getElementById('lat').value = this.getPosition().lat();
                        document.getElementById('lng').value = this.getPosition().lng();
                    });
                    markers.push(marker);

                    if (place.geometry.viewport) bounds.union(place.geometry.viewport);
                    else bounds.extend(place.geometry.location);
                });
                map.fitBounds(bounds);
                markers.forEach(function(marker) {
                    document.getElementById('lat').value = parseFloat(marker.getPosition().lat()).toFixed(7);
                    document.getElementById('lng').value = parseFloat(marker.getPosition().lng()).toFixed(7);
                });
            });
        }

        $('#form-store').validate({
            rules: {
                'title[vi]': {
                    required: true,
                    minlength: 3
                },
                'title[en]': {
                    minlength: 3
                },
                'address[vi]': {
                    required: true,
                    minlength: 3
                },
                'address[en]': {
                    minlength: 3
                },
                city: {
                    required: true
                },
                district_id: {
                    required: true
                },
                lat: {
                    required: true,
                    number: true
                },
                lng: {
                    required: true,
                    number: true
                },
            },
            errorElement : 'div',
            errorPlacement: function(error, element) {
                var placement = $(element).data('error');
                if (placement) $(placement).append(error)
                else error.insertAfter(element);
            }
        })
    </script>
@endpush
