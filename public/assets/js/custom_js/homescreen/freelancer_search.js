$(document).ready(function() {

    // set the default radius
    var radius = $('#radius').val();

    $(document).on('click', '.pagination .page-item a', function(event) {
        event.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        $('#page_count').val(page);
        fetchFreelancers(page);
    })

    $(document).on('submit', '#freelancer-filter-form', function(event) {
        event.preventDefault();
        if(!$('#map-search').val() && !$('.latitude').val() && !$('.longitude').val()) return toastr.warning('The location is invalid please input a correct value', 'Fail');
        fetchFreelancers(1);
        $('.view-map-btn').click();
    })

    $(document).on('change', '#sort', function(event) {
        if(!$('#map-search').val() && !$('.latitude').val() && !$('.longitude').val()) return toastr.warning('The location is invalid please input a correct value', 'Fail');
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
            address: $('#map-search').val(),
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
                radius = data.radius;
                $('.freelancers-data').html(data.view_data);
                $('.protip-container').remove();
                data.freelancers.length == 0 || data.freelancers.data.length == 0 ? $('.view-map-btn').css('display', 'none') : $('.view-map-btn').css('display', 'block');
                setLocations(data.freelancers);
            }
        })
    }


    var map;
    var latEl, longEl, my_marker, circle;

    function setLocations(freelancers) {
        if(freelancers.length == 0) return;

        latEl = document.querySelector( '.latitude' )
        longEl = document.querySelector( '.longitude' )
        var mapOptions = {
            center: latEl.value == '' ? new google.maps.LatLng( 14.5995124, 120.9842195 ) : new google.maps.LatLng(Number(latEl.value), Number(longEl.value) ),
            zoom: 11,
            disableDefaultUI: false, // Disables the controls like zoom control on the map if set to true
            scrollWheel: true, // If set to false disables the scrolling on the map.
            draggable: true, // If set to false , you cannot move the map around.
        };

        map = new google.maps.Map(document.getElementById("freelancers-locations"), mapOptions);
        var infoWindow = new google.maps.InfoWindow();


        let directionsService = new google.maps.DirectionsService;
        let directionsDisplay = new google.maps.DirectionsRenderer({
            map: map
        });

        const user_icon_marker = {
            url: '../../../images/icons/red_pin_instrabaho.svg',
            scaledSize: new google.maps.Size(50,50)
        }

        my_marker = new google.maps.Marker({
            position:  new google.maps.LatLng(Number(latEl.value), Number(longEl.value) ),
            map: map,
            icon: user_icon_marker
        })

        let total_freelancers = freelancers.data.length;

        for (i = 0; i <= total_freelancers; i++) {

            var data = freelancers.data[i]
            var myLatlng = new google.maps.LatLng(data.latitude, data.longitude);

            const freelancers_icon = {
                url: '../../../images/icons/blue_pin_instrabaho.svg',
                scaledSize: new google.maps.Size(50,50)
            }

            let marker = new google.maps.Marker({
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
                    infoWindow.setContent(`<a href="/freelancer/view/${data.display_name}" class="font-weight-bold">${data.display_name}</a><br>
                        ${data.address}`);
                    infoWindow.open(map, marker);
                    });
            })(marker, data);

        }
    }

    $(document).on('click', '.show-boundary-btn', function(event) {
        let modal_map = document.querySelector('#modal-map');
        if(!circle || modal_map.classList.contains('show')) {
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
        } else {
            circle.setMap(null);
            circle = null;
        }
    })

    $(document).on('click', '.hide-boundary-btn', function(event) {
        circle.setMap(null);
        circle = null;
    })

})
