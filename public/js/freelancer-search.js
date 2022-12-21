var map;

function initialize() {

    let map_container = document.querySelector('.search-map');
    let address = document.querySelector('#address');
    let latitude = document.querySelector('.latitude');
    let longitude = document.querySelector('.longitude');

    var mapOptions = {
        // How far the maps zooms in.
        zoom: 15,
        // Current Lat and Long position of the pin/
        center: new google.maps.LatLng( 14.5995124, 120.9842195 ),
        disableDefaultUI: false, // Disables the controls like zoom control on the map if set to true
        scrollWheel: true, // If set to false disables the scrolling on the map.
        draggable: true, // If set to false , you cannot move the map around.

    };

    // Create an object map with the constructor function Map()
    map = new google.maps.Map( map_container, mapOptions ); // Till this like of code it loads up the map.

    const user_icon_marker = {
        url: '../../../images/icons/red_pin_instrabaho.svg',
        scaledSize: new google.maps.Size(60,60)
    }

    marker = new google.maps.Marker({
        position: mapOptions.center,
        map: map,
        icon: user_icon_marker,
        draggable: true,
        animation: google.maps.Animation.DROP,
    });

    searchBox = new google.maps.places.SearchBox( address );

    google.maps.event.addListener( searchBox, 'places_changed', function () {
        var places = searchBox.getPlaces(),
            bounds = new google.maps.LatLngBounds(),
            i, place, lat, long, resultArray,
            address = places[0].formatted_address;

        for( i = 0; place = places[i]; i++ ) {
            bounds.extend( place.geometry.location );
            marker.setPosition( place.geometry.location );  // Set marker position new.
        }

        map.fitBounds( bounds );  // Fit to the bound
        map.setZoom( 15 ); // This function sets the zoom to 15, meaning zooms to level 15.
        // console.log( map.getZoom() );

        lat = marker.getPosition().lat();
        long = marker.getPosition().lng();
        latitude.value = lat;
        longitude.value = long;

        resultArray =  places[0].address_components;

        // Closes the previous info window if it already exists
        if ( infoWindow ) {
            infoWindow.close();
        }
        infoWindow = new google.maps.InfoWindow({
            content: address
        });

        infoWindow.open( map, marker );
    });

}

initialize();