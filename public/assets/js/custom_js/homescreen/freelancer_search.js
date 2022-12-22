var map, infoWindow;
var latEl, longEl, address, my_marker, circle;

latEl = document.querySelector( '.latitude' )
longEl = document.querySelector( '.longitude' )
address = document.querySelector('#address');



    // set the default radius
    var radius = $('#radius').val();

    // window.addEventListener('load', function() {
    //     fetchFreelancers(1);
    // });

    function initialize() {

        $(document).on('click', '.pagination .page-item a', function(event) {
            event.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            $('#page_count').val(page);
            fetchFreelancers(page);
        })

        $(document).on('click', '#filter-btn', function(event) {
            event.preventDefault();
            if(!$('#address').val() && !$('.latitude').val() && !$('.longitude').val()) return toastr.warning('The location is invalid please input a correct value', 'Fail');
            fetchFreelancers(1);
        })

        $(document).on('change', '#title', function(event) {
            if(!$('#address').val() && !$('.latitude').val() && !$('.longitude').val()) return toastr.warning('The location is invalid please input a correct value', 'Fail');
            fetchFreelancers(1);
        })

        $(document).on('change', '#radius', function(event) {
            if(!$('#address').val() && !$('.latitude').val() && !$('.longitude').val()) return toastr.warning('The location is invalid please input a correct value', 'Fail');
            fetchFreelancers(1);
        })

        $(document).on('change', '#sort', function(event) {
            if(!$('#address').val() && !$('.latitude').val() && !$('.longitude').val()) return toastr.warning('The location is invalid please input a correct value', 'Fail');
            fetchFreelancers(1);
        })

        function fetchFreelancers(page) {
            let selected_skills = [];
            let selected_freelancer_type = [];

            // get all checked skills
            $.each($("#skills:checked"), function(){
               selected_skills.push($(this).val());
            });

            // get all checked skills
            $.each($("#freelancer_type:checked"), function(){
                selected_freelancer_type.push($(this).val());
             });


            let filter_data = {
                title: $('#title').val(),
                address: $('#address').val(),
                latitude: $('.latitude').val(),
                longitude: $('.longitude').val(),
                hourly_rate: $('#my_range').val(),
                freelance_type: encodeURIComponent(JSON.stringify(selected_freelancer_type)),
                skills: encodeURIComponent(JSON.stringify(selected_skills)),
                radius: $('#radius').val(),
                result: $('#result').val(),
                sort: $('#sort').val()
            }

            let filter_parameters = `title=${filter_data.title}&address=${filter_data.address}&latitude=${filter_data.latitude}&longitude=${filter_data.longitude}&radius=${filter_data.radius}&result=${filter_data.result}&hourly_rate=${filter_data.hourly_rate}&skills=${filter_data.skills}&freelance_type=${filter_data.freelance_type}&sort=${filter_data.sort}`;
            $('.freelancers-data').html('<h1>Searching...</h1>');
            $.ajax({
                url: "/search_freelancers/fetch_data?page="+page+'&'+filter_parameters,
                success: function (data) {
                    console.log(data);
                    radius = data.radius;
                    $('.freelancers-data').html(data.view_data);
                    $('.protip-container').remove();
                    data.freelancers.length == 0 || data.freelancers.data.length == 0 ? $('.view-map-btn').css('display', 'none') : $('.view-map-btn').css('display', 'block');
                    setLocations(data.freelancers);
                }
            })
        }

        var mapOptions = {
            center: new google.maps.LatLng( 14.5995124, 120.9842195 ),
            zoom: 13,
            mapId: 'ad277f0b2aef047a',
            disableDefaultUI: false, // Disables the controls like zoom control on the map if set to true
            scrollWheel: true, // If set to false disables the scrolling on the map.
            draggable: true, // If set to false , you cannot move the map around.
        };

        map = new google.maps.Map(document.querySelector(".search-map"), mapOptions);
        infoWindow = new google.maps.InfoWindow({
            maxWidth: 200,
        });

        const user_icon_marker = {
            url: '../../../images/icons/red_pin_instrabaho.svg',
            scaledSize: new google.maps.Size(50,50)
        }

        my_marker = new google.maps.Marker({
            position:  new google.maps.LatLng(Number(14.5995124), Number(120.9842195) ),
            map: map,
            icon: user_icon_marker,
            draggable: true,
        })

        circle = new google.maps.Circle({
            center: latEl.value == '' ? new google.maps.LatLng( 14.5995124, 120.9842195 ) : new google.maps.LatLng(Number(latEl.value), Number(longEl.value) ),
            radius: Number(radius) * 1000,
            strokeColor: '#04bbff',
            strokeOpacity: 1,
            strokeWeight: 1,
            fillColor: '#e6f0ff',
            fillOpacity: 0.5,
            map: map
        })
        circle.bindTo('center', my_marker, 'position');
        map.setZoom( 13 );

        searchBox = new google.maps.places.SearchBox( address );

        google.maps.event.addListener( searchBox, 'places_changed', function () {
            var places = searchBox.getPlaces(),
                bounds = new google.maps.LatLngBounds(),
                i, place, lat, long, resultArray,
                address = places[0].formatted_address;

            for( i = 0; place = places[i]; i++ ) {
                bounds.extend( place.geometry.location );
                my_marker.setPosition( place.geometry.location );  // Set my_marker position new.
            }

            map.fitBounds( bounds );  // Fit to the bound
            map.setZoom( 15 ); // This function sets the zoom to 15, meaning zooms to level 15.
            // console.log( map.getZoom() );

            lat = my_marker.getPosition().lat();
            long = my_marker.getPosition().lng();
            latEl.value = lat;
            longEl.value = long;
            fetchFreelancers(1);

            resultArray =  places[0].address_components;

            // Closes the previous info window if it already exists
            if ( infoWindow ) {
                infoWindow.close();
            }
            infoWindow = new google.maps.InfoWindow({
                content: address
            });

            infoWindow.open( map, my_marker );
        });

        google.maps.event.addListener( my_marker, "dragend", function ( event ) {
            var lat, long, address, resultArray;
            var addressEl = document.querySelector( '#address' );
            var latEl = document.querySelector( '.latitude' );
            var longEl = document.querySelector( '.longitude' );

            lat = my_marker.getPosition().lat();
            long = my_marker.getPosition().lng();


            var geocoder = new google.maps.Geocoder();
            geocoder.geocode( { latLng: my_marker.getPosition() }, function ( result, status ) {
                if ( 'OK' === status ) {  // This line can also be written like if ( status == google.maps.GeocoderStatus.OK ) {
                    address = result[0].formatted_address;
                    resultArray =  result[0].address_components;
                    addressEl.value = address;
                    latEl.value = lat;
                    longEl.value = long;

                    fetchFreelancers(1);
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

                infoWindow.open( map );
            });
        });

        function setLocations(freelancers) {
            var mapOptions = {
                center: new google.maps.LatLng( latEl.value, longEl.value ),
                zoom: 11,
                mapId: 'ad277f0b2aef047a',
                disableDefaultUI: false, // Disables the controls like zoom control on the map if set to true
                scrollWheel: true, // If set to false disables the scrolling on the map.
                draggable: true, // If set to false , you cannot move the map around.
            };

            map = new google.maps.Map(document.querySelector(".search-map"), mapOptions);

            const user_icon_marker = {
                url: '../../../images/icons/red_pin_instrabaho.svg',
                scaledSize: new google.maps.Size(50,50)
            }

            my_marker = new google.maps.Marker({
                position:  new google.maps.LatLng(Number(latEl.value), Number(longEl.value) ),
                map: map,
                icon: user_icon_marker,
                draggable: true,
            })

            circle = new google.maps.Circle({
                center: latEl.value == '' ? new google.maps.LatLng( 14.5995124, 120.9842195 ) : new google.maps.LatLng(Number(latEl.value), Number(longEl.value) ),
                radius: Number(radius) * 1000,
                strokeColor: '#04bbff',
                strokeOpacity: 1,
                strokeWeight: 1,
                fillColor: '#e6f0ff',
                fillOpacity: 0.3,
                map: map
            })
            circle.bindTo('center', my_marker, 'position');
            map.setZoom( 13 );

            google.maps.event.addListener( my_marker, "dragend", function ( event ) {
                var lat, long, address, resultArray;
                var addressEl = document.querySelector( '#address' );
                var latEl = document.querySelector( '.latitude' );
                var longEl = document.querySelector( '.longitude' );

                lat = my_marker.getPosition().lat();
                long = my_marker.getPosition().lng();


                var geocoder = new google.maps.Geocoder();
                geocoder.geocode( { latLng: my_marker.getPosition() }, function ( result, status ) {
                    if ( 'OK' === status ) {  // This line can also be written like if ( status == google.maps.GeocoderStatus.OK ) {
                        address = result[0].formatted_address;
                        resultArray =  result[0].address_components;
                        addressEl.value = address;
                        latEl.value = lat;
                        longEl.value = long;
                        fetchFreelancers(1);
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

                    infoWindow.open( map );
                });
            });

            if(freelancers.data.length === 0) return false;

            let total_freelancers = freelancers.data.length;
            let marker;

            for (i = 0; i <= total_freelancers; i++) {

                var data = freelancers.data[i];
                var myLatlng = new google.maps.LatLng(data.latitude, data.longitude);

                const freelancers_icon = {
                    url: '../../../images/icons/blue_pin_instrabaho.svg',
                    scaledSize: new google.maps.Size(50,50)
                }

                marker = new google.maps.Marker({
                    position: myLatlng,
                    map: map,
                    icon: freelancers_icon,
                    labelContent: data.display_name,
                    labelAnchor: new google.maps.Point(7, 30),
                    labelClass: "labels",
                    labelInBackground: true
                });

                (function (marker, data) {
                        google.maps.event.addListener(marker, "click", function (e) {
                        infoWindow.setContent(`
                            <div class="d-flex justify-content-between" style="gap: 10px; max-width: 220px; height: 70px; max-height: 70px;">
                                <img src="${data.user.profile_image ?  `../../../images/user/profile/${data.user.profile_image}` : '../../../images/user-profile.png' }" style="width: 40%; height: 100%; object-fit: cover;" />
                                <div style="60%">
                                    <a href="/freelancers/${data.user.username}" class="font-weight-bold">${data.user.firstname} ${data.user.lastname}</a>
                                    <div style="font-size: 10px;">${data.address}</div>
                                <div>
                            </div>`);
                        infoWindow.open(map, marker);
                        });
                })(marker, data);
            }

            if ( infoWindow ) {
                infoWindow.close();
            }

            /**
                * Creates the info Window at the top of the marker
            */
            infoWindow = new google.maps.InfoWindow({
                content: address,
            });

            infoWindow.open( map, marker );
        }
    }

    $(document).on('click', '.boundary-btn', function(event) {
        if(circle) {
            circle.setMap(null);
            circle = null;
            event.target.innerHTML = 'Show Boundary';
        } else {
            circle = new google.maps.Circle({
                center: latEl.value == '' && longEl.value == '' ? new google.maps.LatLng( 14.5995124, 120.9842195 ) : new google.maps.LatLng(Number(latEl.value), Number(longEl.value) ),
                radius: Number(radius) * 1000,
                strokeColor: '#04bbff',
                strokeOpacity: 1,
                strokeWeight: 1,
                fillColor: '#e6f0ff',
                fillOpacity: 0.3,
                map: map
            })
            event.target.innerHTML = 'Hide Boundary';
        }
    })


    window.addEventListener('load', () => {
        initialize();
    })
