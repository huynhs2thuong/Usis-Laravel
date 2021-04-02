function initialize() {
    var myCenter = new google.maps.LatLng(10.781879, 106.694577);
    mapProp  = {
        center:myCenter,
        zoom:17,
        disableDefaultUI:true,
        scrollwheel: false,
        navigationControl: false,
        mapTypeControl: false,
        scaleControl: false,
        draggable: false,
        mapTypeId:google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("mapholder"),mapProp);

    marker = new google.maps.Marker({
        position:myCenter
    });

    marker.setMap(map);
}

$(window).on("load", function() {
    var script = document.createElement("script");
    script.type="text/javascript";
    script.async = true;
    script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyDU0yN98BhCCqfHm8Gfazz6SlvkG-G-qvA&callback=initialize";
    document.body.appendChild(script);
});