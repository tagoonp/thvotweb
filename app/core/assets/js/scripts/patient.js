function getPatientCalendar(){
    console.log('asd');
    calendar = $("#calendar").fullCalendar({
        // defaultView: 'agendaMonth',
        height: 'auto',
        header: {
            left: 'prev',
            center: 'title',
            right: 'next'
        },
        editable: false,
        allDaySlot: false,
        minTime : "08:00:00",
        maxTime : "17:00:00",
        height: 650,
        events: [
            {
                // title: '<i class="bx bxs-bell"></i>',
                start: '2021-06-22',
                // end: $('#txtEndMon').val(),
                // backgroundColor: '#06c'
                // className: ["redEvent"]
                
                eventRender: function( event, element, view ) {
                        element.find('.fc-title').prepend('<i class="bx bxs-star"></i> '); 
                }
            },
            {
                title: '',
                start: $('#txtStartMon').val(),
                end: $('#txtEndMon').val(),
                // backgroundColor: '#06c'
                className: ["redEvent"]
            }
        ]
        });
        calendar.fullCalendar('render');
}