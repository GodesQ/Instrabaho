const token =  document.querySelector('input[name="_token"]').value;

$(document).ready(function () {
    $(document).on("click", "#start-working-btn", function (e) {
        e.preventDefault();
        let id = $(this).attr("data-id");
        Swal.fire({
            title: "Start Working",
            text: "Are you sure you want to start working for this?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, start it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/project/contract/start_working`,
                    method: 'PUT',
                    data: {
                        _token: token,
                        id: id,
                    },
                    success: function (response) {
                        if(response.status) {
                            Swal.fire(
                                "Success!",
                                "You are now start working.",
                                "success"
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        }
                    },
                });
            }
        });
    });
});

let [milliseconds,seconds,minutes,hours] = [0,0,0,0];
let total_hours = $('#total_hours_input').val();
let total_minutes = $('#total_minutes_input').val();
let timerRef = document.querySelector('.timerDisplay');
let trackerIcon = document.querySelector('.tracker-icon');
let status_input = document.querySelector('#status');
let int = null;

hours = $('#current_hours_input').val();
minutes = $('#current_minutes_input').val();


$(document).on("change", "#timer-btn", function (e) {
    const date = new Date();
    if(e.target.checked) {
        $('.start_date').html(date.toLocaleString());
        $('.end_date').html(null);
        $('#start_date_input').val(date.toLocaleString());
        $('#end_date_input').val(null);
        $('#current_minute_input').val(0);
        $('#current_hours_input').val(0);
        $('#status').val('start');
        sendTrackerAjax();
    } else {
        $('.end_date').html(date.toLocaleString());
        $('#end_date_input').val(date.toLocaleString());
        let time = timeConvert(diff_mins(new Date($('#start_date_input').val()), new Date($('#end_date_input').val())));
        $('#current_minute_input').val(time.rminutes);
        $('#current_hours_input').val(time.rhours);
        $('#status').val('stop');
        sendTrackerAjax();
    }
});

// function displayTimer() {
//     milliseconds+=10;
//     if(milliseconds == 1000) {
//         milliseconds = 0;
//             seconds++;
//         if(seconds == 60){j
//             seconds = 0;
//             minutes++;
//             if(minutes == 60) {
//                 minutes = 0;
//                 hours++;
//             }
//         }
//     }

//     let h = hours < 10 ? "0" + hours : hours;
//     let m = minutes < 10 ? "0" + minutes : minutes;
//     let s = seconds < 10 ? "0" + seconds : seconds;
//     let ms = milliseconds < 10 ? "00" + milliseconds : milliseconds < 100 ? "0" + milliseconds : milliseconds;

//     $('#current_hours_input').val(h);
//     $('#current_minutes_input').val(m);

//     timerRef.innerHTML = ` ${h} hrs ${m} m ${s} s`;
// }

function sendTrackerAjax() {
    if(navigator.onLine) {
        $.ajax({
            url: `/project/contract/store_time`,
            method: 'POST',
            data: {
                _token: token,
                contract_id: $('#contract_id').attr('data-id'),
                start_date: $('#start_date_input').val(),
                end_date: $('#end_date_input').val(),
                current_minute: $('#current_minute_input').val(),
                current_hours: $('#current_hours_input').val(),
                status: $('#status').val()
            },
            success: function (response) {
                $('.total-hours-text').html(response.total_hours);
                $('.total-minutes-text').html(response.total_minutes);
            },
        });
    }
}


function diff_hours(dt2, dt1)
 {
    var diff =(dt2.getTime() - dt1.getTime()) / 1000;
    diff /= (60 * 60);
    return Math.abs(Math.round(diff));
 }

function diff_mins(startDate, endDate) {
    const msInMinute = 60 * 1000;

    return Math.round(
      Math.abs(endDate - startDate) / msInMinute
    );
}

function timeConvert(n) {
    var num = n;
    var hours = (num / 60);
    var rhours = Math.floor(hours);
    var minutes = (hours - rhours) * 60;
    var rminutes = Math.round(minutes);
    var time = {
        rhours : rhours,
        rminutes : rminutes
    };
    return time;
}

dt1 = new Date('2023-01-05 11:59:33');
dt2 = new Date('2023-01-05 17:05:20');

// let total_minutes = diff_mins(dt1, dt2);

// console.log(timeConvert(total_minutes));
