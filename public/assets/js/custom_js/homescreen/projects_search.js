$(document).ready(function() {

    // set the default radius
    var radius = $('#radius').val();

    $(document).on('click', '.pagination .page-item a', function(event) {
        event.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        $('#page_count').val(page);
        fetchProjects(page);
    })

    $(document).on('submit', '#projects-filter-form', function(event) {
        event.preventDefault();
        if(!$('#map-search').val() && !$('.latitude').val() && !$('.longitude').val()) return toastr.warning('The location is invalid please input a correct value', 'Fail');
        fetchProjects(1);
        $('.view-map-btn').click();
    })

    function fetchProjects(page) {
        let selected_categories = [];
        $.each($("#categories:checked"), function(){
           selected_categories.push($(this).val());
        });
        let filter_data = {
            title: $('#title').val(),
            address: $('#map-search').val(),
            latitude: $('.latitude').val(),
            longitude: $('.longitude').val(),
            my_range: $('#my_range').val(),
            type: $('#type').val(),
            radius: $('#radius').val(),
            result: $('#result').val(),
            categories: encodeURIComponent(JSON.stringify(selected_categories)),
        }

        let filter_parameters = `title=${filter_data.title}&address=${filter_data.address}&latitude=${filter_data.latitude}&longitude=${filter_data.longitude}&my_range=${filter_data.my_range}&type=${filter_data.type}&categories=${filter_data.categories}&radius=${filter_data.radius}&result=${filter_data.result}`;
        $('.projects-data').html('<h1>Loading...</h1>');
        $.ajax({
            url: "/search_projects/fetch_data?page="+page+'&'+filter_parameters,
            success: function (data) {
                $('.projects-data').html(data.view_data);
                $('.protip-container').remove();
                radius = data.radius;
                data.projects.length == 0 || data.projects.data.length == 0 ? $('.view-map-btn').css('display', 'none') : $('.view-map-btn').css('display', 'block');
                setLocations(data.projects);
            }
        })
    }


    var map;
    var latEl, longEl, my_marker, circle;

    function setLocations(projects) {
        if(projects.length == 0) return;

        latEl = document.querySelector( '.latitude' )
        longEl = document.querySelector( '.longitude' )
        var mapOptions = {
            center: latEl.value == '' ? new google.maps.LatLng( 14.5995124, 120.9842195 ) : new google.maps.LatLng(Number(latEl.value), Number(longEl.value) ),
            zoom: 12,
            disableDefaultUI: false, // Disables the controls like zoom control on the map if set to true
            scrollWheel: true, // If set to false disables the scrolling on the map.
            draggable: true, // If set to false , you cannot move the map around.
        };

        map = new google.maps.Map(document.getElementById("projects-locations"), mapOptions);

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

        for (i = 0; i <= projects.data.length; i++) {

            var data = projects.data[i]
            var myLatlng = new google.maps.LatLng(data.latitude, data.longitude);

            let attachments = JSON.parse(data.attachments);

            const projects_icon = {
                url: '../../../images/icons/blue_pin_instrabaho.svg',
                scaledSize: new google.maps.Size(50,50)
            }

            let marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                icon: projects_icon,
                labelContent: data.name,
                labelAnchor: new google.maps.Point(7, 30),
                labelClass: "labels",
                labelInBackground: true
            });

            (function (marker, data) {
                    google.maps.event.addListener(marker, "click", function (e) {
                    infoWindow.setContent(`<a href="/projects/${data.id}/${data.title}" class="font-weight-bold">${data.title}</a><br>
                        ${data.location}`);
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
                fillOpacity: 0.3,
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
