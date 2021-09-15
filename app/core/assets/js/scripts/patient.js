function addDailyProgressNote(){

    $('.form-control').removeClass('is-invalid')
    $check = 0;
    
    if($('#txtCommentPatientMsg').val() == ''){
        $('#txtCommentPatientMsg').addClass('is-invalid')
        $check++;
    }

    if($('#txtCommentPatientStopdrug').val() == ''){
        $('#txtCommentPatientStopdrug').addClass('is-invalid')
        $check++;
    }

    if($check != 0){ return ; }

    preload.show()
    
    var param = {
        patient_id: $('#txtCommentPatientId').val(),
        progress_date: $('#txtCommentDate').val(),
        progress_msg: $('#txtCommentPatientMsg').val(),
        progress_stopdrug: $('#txtCommentPatientStopdrug').val(),
        uid: $('#txtCurrentUid').val(),
    }

    var jxr = $.post(api_url + 'followup.php?stage=setpatient_dailyprogress', param, function(){}, 'json')
               .always(function(snap){
                   console.log(snap);
                   if(snap.status != 'Success'){
                        Swal.fire({
                            title: "เกิดข้อผิดพลาด",
                            text: "ไม่สามารถเพิ่มบันทึกได้",
                            icon: "error",
                            confirmButtonClass: 'btn btn-danger',
                            buttonsStyling: false,
                        });
                   }else{
                    $('#txtCommentPatientMsg').val('')
                    $('#modalComment').modal('hide')
                   }
                   getDailyProgressNote($('#txtCommentDate').val())
                   calendar.fullCalendar('destroy');
                   getPatientCalendar()
               })

    
}

function getDailyProgressNote(selected_date){
    preload.show()
    var jxr = $.post(api_url + 'followup.php?stage=getpatient_dailyprogress', {patient_id: $('#txtPatient_id').val(), sdate: selected_date }, function(){}, 'json')
               .always(function(snap){
                   $('#dailyNote').empty()
                   if(snap.status == 'Success'){
                       snap.data.forEach(i => {
                        $('#dailyNote').append('<tr>' + 
                                                    '<td style="vertical-align: top;" class="th">' + i.fn_datetime + '</td>' + 
                                                    '<td style="vertical-align: top;" class="th">' + i.fn_note + '</td>' + 
                                                    '<td style="vertical-align: top;" class="th">' + i.fname + ' ' + i.lname + '</td>' + 
                                                '</tr>') 
                       });

                       
                   }else{
                    $('#dailyNote').html('<tr><td colspan="3" class="th text-center">ยังไม่มีคำชี้แจง</td></tr>')
                   }

                   preload.hide()
               })
}

function getPatientCalendar(){
    console.log($('#txtPatient_id').val());
    var caneldar_url = api_url + 'calendar.php?stage=getpatient_calendar&patient_id=' + $('#txtPatient_id').val()
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
        aspectRatio: 1.15,
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
                height: 650,
                aspectRatio: 1.15,
                header: {
                  left: 'prev,next today',
                  center: 'title',
                  right: 'month'
                },
                events: reply,
                eventRender: function (event, element) {
                    console.log(event);
                    element.find('.fc-title').html(event.title);/*For Month,Day and Week Views*/
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
    setTimeout(() => {
        // $('#txtCommentPatientMsg').focus()
    }, 500)

    getDailyProgressNote(com_date)

    if(stopdrug == '1'){
        $('#stopDrug').removeClass('dn')
    }else{
        $('#stopDrug').addClass('dn')
    }

    getVideoList(com_date)
}

function getVideoList(select_date){
    var param = {
        uid: $('#txtCurrentUid').val(),
        pid: $('#txtPatient_id').val(),
        sdate: select_date
    }
    var jxr = $.post(api_url + 'followup.php?stage=get_daily_video_list', param, function(){}, 'json')
               .always(function(snap){
                    $('#dailyVideoList').empty()
                    if(snap.status == 'Success'){
                        snap.data.forEach(i=>{
                            $status = '<span class="badge badge-light-danger round">รอการตรวจสอบ</span>'
                            if(i.fu_status == 'complete'){
                                $status = '<span class="badge badge-light-success round">ตรวจสอบแล้ว</span>'
                            }
                            $dt = '<tr>' + 
                                        '<td><a href="Javascript:manangeVideo(\'' + i.fu_id + '\')"><i class="bx bx-play"></i></a></td>' + 
                                        '<td>' + i.fu_upload_datetime + '</td>' + 
                                        '<td>' + $status + '</td>' + 
                                  '</tr>'
                                  $('#dailyVideoList').append($dt)
                        })
                    }else{
                        $('#dailyVideoList').html('<tr><td colspan="3" class="text-center th">ไม่พบรายการวิดีโอ</td></tr>')
                    }
               })
}

function manangeVideo(vid){
    window.location = 'app-video-check?uid=' + $('#txtCurrentUid').val() + '&role=' + $('#txtCurrentUrole').val() + '&hcode=' + $('#txtCurrentUhcode').val() + '&id=' + $('#txtPatient_id').val() + '&vid=' + vid
}

$(function(){
 
})