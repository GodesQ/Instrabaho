var map;

function initialize() { 
    var mapOptions, map, marker, searchBox, city,
        infoWindow = '',
        addressEl = document.querySelector( '#map-search' ),
        latEl = document.querySelector( '.latitude' ),
        longEl = document.querySelector( '.longitude' ),
        element = document.getElementById( 'map-canvas' ),
        currentLocationButton = document.getElementById( 'get-current-location' ),
    city = document.querySelector( '.reg-input-city' );

    mapOptions = {
        // How far the maps zooms in.
        zoom: 15,
        // Current Lat and Long position of the pin/
        center: latEl.value == '' ? new google.maps.LatLng( 14.5995124, 120.9842195 ) : new google.maps.LatLng(Number(latEl.value), Number(longEl.value) ),
        disableDefaultUI: false, // Disables the controls like zoom control on the map if set to true
        scrollWheel: true, // If set to false disables the scrolling on the map.
        draggable: true, // If set to false , you cannot move the map around.

    };
    // Create an object map with the constructor function Map()
    map = new google.maps.Map( element, mapOptions ); // Till this like of code it loads up the map.

    marker = new google.maps.Marker({
        position: mapOptions.center,
        map: map,
        icon: '',
        draggable: true,
        animation: google.maps.Animation.DROP,
    });

    searchBox = new google.maps.places.SearchBox( addressEl );

    google.maps.event.addListener( searchBox, 'places_changed', function () {
        var places = searchBox.getPlaces(),
            bounds = new google.maps.LatLngBounds(),
            i, place, lat, long, resultArray,
            addresss = places[0].formatted_address;

        for( i = 0; place = places[i]; i++ ) {
            bounds.extend( place.geometry.location );
            marker.setPosition( place.geometry.location );  // Set marker position new.
        }

        map.fitBounds( bounds );  // Fit to the bound
        map.setZoom( 15 ); // This function sets the zoom to 15, meaning zooms to level 15.
        // console.log( map.getZoom() );

        lat = marker.getPosition().lat();
        long = marker.getPosition().lng();
        latEl.value = lat;
        longEl.value = long;

        resultArray =  places[0].address_components;

        // Closes the previous info window if it already exists
        if ( infoWindow ) {
            infoWindow.close();
        }
        infoWindow = new google.maps.InfoWindow({
            content: address
        });

        infoWindow.open( map, marker );
    } );

    google.maps.event.addListener( marker, "dragend", function ( event ) {
        var lat, long, address, resultArray, citi;

        lat = marker.getPosition().lat();
        long = marker.getPosition().lng();

        var geocoder = new google.maps.Geocoder();
        geocoder.geocode( { latLng: marker.getPosition() }, function ( result, status ) {
            if ( 'OK' === status ) {  // This line can also be written like if ( status == google.maps.GeocoderStatus.OK ) {
                address = result[0].formatted_address;
                resultArray =  result[0].address_components;

                addressEl.value = address;
                latEl.value = lat;
                longEl.value = long;

            } else {
                console.log( 'Geocode was not successful for the following reason: ' + status );
            }

            // Closes the previous info window if it already exists
            if ( infoWindow ) {
                infoWindow.close();
            }

            /**
             * Creates the info Window at the top of the marker
             */
            infoWindow = new google.maps.InfoWindow({
                content: address
            });

            infoWindow.open( map, marker );
        });
    });

    currentLocationButton.addEventListener('click', (e) => {
        console.log(e);
        if (navigator.geolocation){
            navigator.geolocation.getCurrentPosition(function(position){
                var currentLatitude = position.coords.latitude;
                var currentLongitude = position.coords.longitude;
                var infoWindowHTML = "Latitude: " + currentLatitude + "<br>Longitude: " + currentLongitude;
                var infoWindow = new google.maps.InfoWindow({map: map, content: infoWindowHTML});
                var currentLocation = { lat: currentLatitude, lng: currentLongitude };
                // infoWindow.setPosition(currentLocation);
                marker.setPosition(currentLocation);
                map.setZoom( 15 );
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode( { latLng: marker.getPosition() }, function ( result, status ) {
                    if ( 'OK' === status ) {  // This line can also be written like if ( status == google.maps.GeocoderStatus.OK ) {
                        address = result[0].formatted_address;
                        resultArray =  result[0].address_components;

                        addressEl.value = address;
                        latEl.value = currentLatitude;
                        longEl.value = currentLongitude;

                    } else {
                        console.log( 'Geocode was not successful for the following reason: ' + status );
                    }


                    infoWindow = new google.maps.InfoWindow({
                        content: address
                    });

                    infoWindow.open( map, marker );
                });
            });
        }
    });

}
