var menu = {};
var page = {};
var index = {};
var map;
var infoWindow;
var curentPos;
$(document).ready(function() {
    page.district();
    menu.init();
    index.animate_cover();
});


index.map = function() {
    map = new google.maps.Map(document.getElementById('map'), {});
    infoWindow = new google.maps.InfoWindow({
        maxWidth: 350
    });
    var latlngbounds = new google.maps.LatLngBounds();
    var LatLngList = [];
    $('.map-list-store li').each(function() {
        var latlng = $(this).children("a").data("latlng");
        latlng = latlng.split("-");
        var lat = Number(latlng[0]);
        var lng = Number(latlng[1]);
        
        var marker = new google.maps.Marker({
            position: {
                lat: lat,
                lng: lng
            },
            map: map,
            icon: 'asset/images/map.png'
        });



        LatLngList.push(new google.maps.LatLng(lat, lng));
        $(this).children("a").click(function(e) {
            e.preventDefault();
            var latlng = $(this).data("latlng");
            latlng = latlng.split("-");
            var pos = {
                lat: Number(latlng[0]),
                lng: Number(latlng[1])
            };
            infoWindow.setPosition(pos);
            infoWindow.setContent($(this).text());
            infoWindow.open(map);
            map.setCenter(pos);
        });
    });
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            curentPos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            var marker = new google.maps.Marker({
                position: curentPos,
                map: map,
                icon: 'images/icons/icon_current.svg'
            });
            LatLngList.push(new google.maps.LatLng(curentPos.lat, curentPos.lng));
        });
    }
    LatLngList.forEach(function(latLng) {
        latlngbounds.extend(latLng);
    });
    map.setCenter(latlngbounds.getCenter());
    map.setZoom(13);
};
index.direction = function() {
    var directionsService = new google.maps.DirectionsService;
    var directionsDisplay = new google.maps.DirectionsRenderer({
        suppressMarkers: true,
        polylineOptions: {
            strokeColor: "#0C713D"
        }
    });
    directionsDisplay.setMap(map);
    $('.map-list-store li').each(function() {
        var latlng = $(this).children("a").data("latlng");
        latlng = latlng.split("-");
        var lat = Number(latlng[0]);
        var lng = Number(latlng[1]);
        $(this).children("button").click(function() {
            directionsService.route({
                origin: curentPos,
                destination: {
                    lat: lat,
                    lng: lng
                },
                travelMode: 'DRIVING'
            }, function(response, status) {
                if (status === 'OK') {
                    directionsDisplay.setDirections(response);
                } else {
                    window.alert('Directions request failed due to ' + status);
                }
            });
        })
    });
};
index.animate_cover = function() {
    $('#home_id ul li').each(function() {
        $(this).hover(function() {
            $(this).children("img").toggleClass('animated bounceIn');
        });
    });
};
menu.init = function() {
    $(".h_menu__btn, .h_menu__overlay").click(function() {
        $(".h_menu").toggleClass("active");
    });
    if ($(window).width() <= 991) {
        $(".main-full").css("margin-top", function() {
            return $("header").outerHeight(true) + $(".h_logo").outerHeight(true);
        });
    } else {
        $(".main-full").css("margin-top", function() {
            return $("header").outerHeight(true);
        });
    }
};
var data_district = [{
    "id": "1",
    "name": "Tp Hồ Chí Minh",
    "lat": "10.7687085",
    "long": "106.4141728",
    "district": [{
        "id": "1",
        "name": "Quận 1",
        "store": [{
            "lat": "10.763924",
            "long": "106.682804",
            "name": "TTTM NowZone ",
            "address": "235 Nguyễn Văn Cừ, Quận 1",
            "phone": "0123456789"

        }, {
            "lat": "10.7730741",
            "long": "106.7002641",
            "name": "B217, Takashimaya Department Store ",
            "address": "235 Nguyễn Văn Cừ, Quận 1",
            "phone": "0123456789"
        }, {
            "lat": "10.772096",
            "long": "106.704395",
            "name": "Lầu 4, Khu vực ẩm thực Food Creative, Tòa nhà Bitexco ",
            "address": "235 Nguyễn Văn Cừ, Quận 1",
            "phone": "0123456789"
        }, {
            "lat": "10.784195",
            "long": "106.699551",
            "name": "L1-01, Tòa nhà Somerset Chancellor Court",
            "address": "235 Nguyễn Văn Cừ, Quận 1",
            "phone": "0123456789"
        }, {
            "lat": "10.774819",
            "long": "106.704337",
            "name": "63 Mạc Thị Bưởi",
            "address": "235 Nguyễn Văn Cừ, Quận 1",
            "phone": "0123456789"
        }, {
            "lat": "10.773345",
            "long": "106.705582",
            "name": "29 Ngô Đức Kế",
            "address": "235 Nguyễn Văn Cừ, Quận 1",
            "phone": "0123456789"
        }, {
            "lat": "10.772775",
            "long": "106.704586",
            "name": "42 Ngô Đức Kế",
            "address": "235 Nguyễn Văn Cừ, Quận 1",
            "phone": "0123456789"
        }, {
            "lat": "10.772456",
            "long": "106.698946",
            "name": "122 Lê Lợi",
            "address": "235 Nguyễn Văn Cừ, Quận 1",
            "phone": "0123456789"
        }, {
            "lat": "10.771444",
            "long": "106.693651",
            "name": "325 Lý Tự Trọng",
            "address": "235 Nguyễn Văn Cừ, Quận 1",
            "phone": "0123456789"
        }, {
            "lat": "10.771161",
            "long": "106.695621",
            "name": "42 Phạm Hồng Thái",
            "address": "235 Nguyễn Văn Cừ, Quận 1",
            "phone": "0123456789"
        }, {
            "lat": "10.768177",
            "long": "106.695251",
            "name": "157 - 159 Nguyễn Thái Học",
            "address": "235 Nguyễn Văn Cừ, Quận 1",
            "phone": "0123456789"
        }, {
            "lat": "10.773045",
            "long": "106.702646",
            "name": "26 Huỳnh Thúc Kháng",
            "address": "235 Nguyễn Văn Cừ, Quận 1",
            "phone": "0123456789"
        }]
    }, {
        "id": "2",
        "name": "Quận 3",
        "store": [{
            "lat": "10.7830099",
            "long": "106.696067",
            "name": "42 Trần Cao Vân",
            "address": "235 Nguyễn Văn Cừ, Quận 1",
            "phone": "0123456789"
        }, {
            "lat": "10.787509",
            "long": "106.678823",
            "name": "350 Lê Văn Sỹ, Quận 3",
            "address": "235 Nguyễn Văn Cừ",
            "phone": "0123456789",
        }, {
            "lat": "10.777984",
            "long": "106.689742",
            "name": "B-004A, TTTM RomeA - 117 Nguyễn Đình Chiểu, Quận 3",
            "address": "235 Nguyễn Văn Cừ",
            "phone": "0123456789"
        }]
    }, {
        "id": "3",
        "name": "Quận 5",
        "store": [{
            "lat": "10.752601",
            "long": "106.666603",
            "name": "188 Trần Hưng Đạo",
            "address": "235 Nguyễn Văn Cừ, Quận 1",
            "phone": "0123456789",
        }, {
            "lat": "10.7535934",
            "long": "106.654622",
            "name": "G-001, TTTM Golden Plaza",
            "address": "235 Nguyễn Văn Cừ",
            "phone": "0123456789"
        }]
    }, {
        "id": "4",
        "name": "Quận 7",
        "store": [{
            "lat": "10.729510",
            "long": "106.702977",
            "name": "01-41A & 01-41B, SC VivoCity ",
            "address": "235 Nguyễn Văn Cừ, Quận 1",
            "phone": "0123456789"
        }, {
            "lat": "10.728699",
            "long": "106.718773",
            "name": "GF-21B, Crescent Mall ",
            "address": "235 Nguyễn Văn Cừ, Quận 1",
            "phone": "0123456789"
        }, {
            "lat": "10.740790",
            "long": "106.702045",
            "name": "1F-32, Lotte Mart Quận 7",
            "address": "235 Nguyễn Văn Cừ, Quận 1",
            "phone": "0123456789"
        }]
    }, {
        "id": "5",
        "name": "Phú Nhuận",
        "store": [{
            "lat": "10.7970586",
            "long": "106.6734174",
            "name": "Centre Point",
            "address": "235 Nguyễn Văn Cừ, Quận 1",
            "phone": "0123456789"
        }]
    }, {
        "id": "6",
        "name": "Tân Bình",
        "store": [{
            "lat": "10.8006119",
            "long": "106.6606479",
            "name": "1B Cộng Hòa",
            "address": "235 Nguyễn Văn Cừ, Quận 1",
            "phone": "0123456789"
        }]
    }, {
        "id": "7",
        "name": "Bình Tân",
        "store": [{
            "lat": "10.7437149",
            "long": "106.6130481",
            "name": "G17, Aeon Mall Bình Tân ",
            "address": "235 Nguyễn Văn Cừ, Quận 1",
            "phone": "0123456789"
        }]
    }]
}, {
    "id": "2",
    "name": "Bình Dương",
    "lat": "11.1827222",
    "long": "106.3709458",
    "district": [{
        "id": "1",
        "name": "Thị xã Thuận An",
        "store": [{
            "lat": "10.931793",
            "long": "106.711701",
            "name": "G31, Aeon Mall Bình Dương Canary",
            "address": "235 Nguyễn Văn Cừ, Quận 1",
            "phone": "0123456789"
        }]
        
    }]
}];
page.district = function() {
    fillCity();
    loadDistrict();
    loadStore();
    index.map();
    index.direction();
    $('#slb_city').on('changed.bs.select', function(e) {
        loadDistrict();
        loadStore();
        index.map();
        index.direction();
    });
    $("#slb_district").on('changed.bs.select', function() {
        loadStore();
        index.map();
        index.direction();
    });
};

function fillCity() {
    var html = "";
    var d_val = null;
    for (var i = 0; i < data_district.length; i++) {
        var c = (i == 0) ? "selected" : "";
        if (i == 0) {
            d_val = data_district[i].id;
        }
        html += "<option value='" + data_district[i].id + "' " + c + ">" + data_district[i].name + "</option>";
    }
    $("#slb_city").html(html);
    $("#slb_city").selectpicker('refresh');
}

function loadDistrict() {
    var d = Number($("#slb_city").val());
    var dt = [];
    var d_val = null;
    for (var i = 0; i < data_district.length; i++) {
        if (d == data_district[i].id) {
            dt = data_district[i].district;
            break;
        }
    }
    var html = "";
    for (var i = 0; i < dt.length; i++) {
        if (i == 0) {
            d_val = data_district[i].id;
        }
        var c = (i == 0) ? "selected" : "";
        html += "<option value='" + dt[i].id + "' " + c + ">" + dt[i].name + "</option>";
    }
    $("#slb_district").html(html).selectpicker("refresh");
}

function loadStore() {
    var c = Number($("#slb_city").val());
    var d = Number($("#slb_district").val());
    var store = [];
    for (var i = 0; i < data_district.length; i++) {
        if (c == data_district[i].id) {
            for (var j = 0; j < data_district[i].district.length; j++) {
                if (d == data_district[i].district[j].id) {
                    store = data_district[i].district[j].store;
                    break;
                }
            }
        }
    }
    var html = "";
    for (var i = 0; i < store.length; i++) {
        html += '<li><a href="http://maps.google.com/?q=' + store[i].name + '" data-latlng="' + store[i].lat + '-' + store[i].long + '">';
        html += '<span class="name">' + store[i].name + '</span> ';
        html += '<span class="address">' + store[i].address + '</span> ';
        html += '<span class="phone"> <span class="b"> Điện thoại </span>' + store[i].phone + '</span> </a>';
        html += '</li>';
    }
    $(".map-list-store").html(html);
}



