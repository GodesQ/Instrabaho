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
let timerRef = document.querySelector('.timerDisplay');
let trackerIcon = document.querySelector('.tracker-icon');
let int = null;

hours = $('#hours').val();
minutes = $('#minutes').val();

$(document).on("change", "#timer-btn", function (e) {
    if(e.target.checked) {
        if(int!==null){
        clearInterval(int);
    }

    trackerIcon.innerHTML = `<i class="fa fa-play success"><i/>`;
    int = setInterval(displayTimer, 10);
    } else {
        trackerIcon.innerHTML = `<i class="fa fa-stop danger"><i/>`;
        clearInterval(int);
    }
});

function displayTimer() {
    milliseconds+=10;
    if(milliseconds == 1000) {
        milliseconds = 0;
        seconds++;
        if(seconds == 60){
            seconds = 0;
            minutes++;
            if(minutes == 60) {
                minutes = 0;
                hours++;
            }
        }
    }

let h = hours < 10 ? "0" + hours : hours;
let m = minutes < 10 ? "0" + minutes : minutes;
let s = seconds < 10 ? "0" + seconds : seconds;
let ms = milliseconds < 10 ? "00" + milliseconds : milliseconds < 100 ? "0" + milliseconds : milliseconds;

$('#hours_input').val(h);
$('#minutes_input').val(m);

timerRef.innerHTML = ` ${h} hrs ${m} m ${s} s`;
}

function sendTrackerAjax() {
    if(document.querySelector('#timer-btn').checked) {

        let hours = $('#hours_input').val();
        let minutes = $('#minutes_input').val();
        let id = $('#contract_id').attr("data-id");

        $.ajax({
            url: `/project/contract/store_time`,
            method: 'PUT',
            data: {
                _token: token,
                id: id,
                hours: hours,
                minutes: minutes
            },
            success: function (response) {
                console.log(response);
            },
        });

    }
}

setInterval(sendTrackerAjax, 60000);


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
    return num + " minutes = " + rhours + " hour(s) and " + rminutes + " minute(s).";
}

dt1 = new Date('2023-01-05 11:59:33');
dt2 = new Date('2023-01-05 17:05:20');

let total_minutes = diff_mins(dt1, dt2);

// console.log(timeConvert(total_minutes));
