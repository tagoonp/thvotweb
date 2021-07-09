function getPatientCalendar(){
    var caneldar_url = api_url + 'calendar.php?stage=getpatient_calendar&patient_id=' + $('#txtPatient_id').val()
    // calendar = $("#calendar").fullCalendar({
    //     defaultView: 'agendaMonth',
    //     height: 'auto',
    //     header: {
    //         left: 'prev',
    //         center: 'title',
    //         right: 'next'
    //     },
    //     editable: false,
    //     allDaySlot: false,
    //     minTime : "08:00:00",
    //     maxTime : "17:00:00",
    //     height: 650,
    //     events: [
            
    //         {
    //             // title: '<i class="bx bxs-bell"></i>',
    //             start: '2021-06-22',
    //             // end: $('#txtEndMon').val(),
    //             // backgroundColor: '#06c'
    //             // className: ["redEvent"]
                
    //             eventRender: function( event, element, view ) {
    //                     element.find('.fc-title').prepend('<i class="bx bxs-star"></i> '); 
    //             }
    //         },
    //         {
    //             title: '',
    //             start: $('#txtStartMon').val(),
    //             end: $('#txtEndMon').val(),
    //             // backgroundColor: '#06c'
    //             className: ["redEvent"]
    //         }
    //     ]
    // });


    calendar = $("#calendar").fullCalendar({
        height: 'auto',
        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'month'
        },
        editable: false,
        allDaySlot: false,
        minTime : "08:00:00",
        maxTime : "17:00:00",
        height: 650,
        events: {
            url: caneldar_url,
            error: function(err) {
              console.log(err);
              preload.hide()
              alert('Error : can not access database')
            },
            success: function(reply) {
              console.log(reply);
              calendar.fullCalendar('destroy');
              calendar = $('#calendar').fullCalendar({
                lang: 'de',
                minTime : "08:00:00",
                maxTime : "17:00:00",
                header: {
                  left: 'prev,next today',
                  center: 'title',
                  right: 'month'
                },
                events: reply,
                eventRender: function (event, element) {
                    console.log(event.title);
                    element.find('.fc-title').html(event.title);/*For Month,Day and Week Views*/
                    // element.find('.fc-list-item-title').html(event.title);/*For List view*/
                }
              });
            }
        }
    });

    calendar.fullCalendar('render');
}

function viewCommentDialog(com_date, stopdrug){
    $('#modalComment').modal()
    $('#txtCommentDate').val(com_date)

    if(stopdrug == '1'){
        $('#stopDrug').removeClass('dn')
    }else{
        $('#stopDrug').addClass('dn')
    }
}