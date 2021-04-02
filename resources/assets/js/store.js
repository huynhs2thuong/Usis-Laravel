var mapCanvas, bounds_GMapFP,
    infowindow      = [],
    markerImage     = '/images/store/icon-marker.png',
    num_open        = 0,
    infowindowLevel = 0,
    marker          = [];

function attachinfowindow(marker, place, i) {
    infowindow[i] = new google.maps.InfoWindow({
        content: '<div class="store-image"><img width="220" src="' + place.image + '"></div>',
        maxWidth: 197,
        disableAutoPan: 0
    });
    google.maps.event.addListener(marker, 'mouseover', function(e) {
        infowindow[num_open].close(mapCanvas, marker);
        infowindow[i].setZIndex(++infowindowLevel);
        infowindow[i].open(mapCanvas, marker);
        num_open = i;
        mapCanvas.setCenter(marker.getPosition());
    });
}

function initMap() {
    mapCanvas = new google.maps.Map(document.getElementById('map-canvas'), {
        zoom: 13,
        panControl: false,
        scaleControl: false,
        scrollwheel: false
    });

    bounds_GMapFP = new google.maps.LatLngBounds();

    for (var i = 0; i < locations.length; i++) {
        var place = locations[i],
            maLatLng = new google.maps.LatLng(place.lat, place.lng);

        bounds_GMapFP.extend(maLatLng);
        marker[i] = new google.maps.Marker({
            map: mapCanvas,
            position: maLatLng,
            //title: place[3],
            icon: markerImage,
        });
        attachinfowindow(marker[i], place, i);
    }
    mapCanvas.setCenter(bounds_GMapFP.getCenter());
}

app.controller('StoreController', ['$scope', '$http', function($scope, $http) {
    $scope.stores = locations;
    $scope.currentStore = locations[0];
    $scope.cities = [];
    $scope.districts = [];
    $scope.city = customerCity;
    $scope.district = null;

    $scope.storeClick = function(index, store) {
        google.maps.event.trigger(marker[index], 'mouseover');
        $scope.currentStore = store;
        //window.location.hash = store.slug;
    };

    $scope.submit = function() {
        if ($scope.district === null) return;
        $http.get('/api/store/' + $scope.district).success(function(response) {
            if (response.length === 0) {
                swal('', messageNoStore);
                return;
            }
            locations = $scope.stores = response;
            $scope.currentStore = $scope.stores[0];
            initMap();
        });
    };

    $http.get('/api/area/0').success(function(response) {
        $scope.cities = response.cities;
        $scope.districts = response.districts;
    });
}]);
