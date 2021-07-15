$(document).ready(function () {


    //Date Picker
    $("#mydate").flatpickr();

    $("#date-time").flatpickr({
        enableTime: true
    });

    $("#min-date").flatpickr({
        minDate: "2017-04"
    });

    $(".max-date").flatpickr({
        maxDate: new Date()
    });
    $("#max-date2").flatpickr({
        maxDate: new Date()
    });

    $("#multiple-date").flatpickr({
        mode: "multiple"
    });

    $("#preloading-multiple-date").flatpickr({
        mode: "multiple",
        defaultDate: ["2016-10-20", "2016-11-04"]
    });

    $("#min-date").flatpickr({
        minDate: "2017-04"
    });

    $("#range-date").flatpickr({
        mode: "range"
    });

    $("#preloading-range-date").flatpickr({
        mode: "range",
        defaultDate: ["2016-10-10", "2016-10-20"]
    });

    $("#inline-calendar1").flatpickr({
        inline: true
    });

    $("#inline-calendar2").flatpickr({
        inline: true
    }, );

    $("#default-timepicker").flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i"
    });

    $("#24-hour-timepicker").flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });

    $("#limits-timepicker").flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        minDate: "16:00",
        maxDate: "22:30",
    });

    $("#preloading-timepicker").flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        defaultDate: "13:45"
    });


});
