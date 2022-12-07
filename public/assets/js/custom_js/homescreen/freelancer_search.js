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
            url: "data:image/png;base64,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", // url
            // scaledSize: new google.maps.Size(100, 100), // scaled size
        };

        my_marker = new google.maps.Marker({
            position:  new google.maps.LatLng(Number(latEl.value), Number(longEl.value) ),
            map: map,
            icon: user_icon_marker
        })

        for (i = 0; i <= freelancers.data.length; i++) {

            var data = freelancers.data[i]
            var myLatlng = new google.maps.LatLng(data.latitude, data.longitude);

            let marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                icon: 'https://img.icons8.com/ios-filled/40/FF7E00/user-location.png',
                labelContent: data.display_name,
                labelAnchor: new google.maps.Point(7, 30),
                labelClass: "labels",
                labelInBackground: true
            });

            (function (marker, data) {
                    google.maps.event.addListener(marker, "click", function (e) {
                    infoWindow.setContent(`<a href="/project/view/${data.id}" class="font-weight-bold">${data.display_name}</a><br>
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
