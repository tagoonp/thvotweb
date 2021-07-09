/*=========================================================================================
    File Name: app-users.js
    Description: Users page
    --------------------------------------------------------------------------------------
    Item Name: Frest HTML Admin Template
    Version: 1.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/
$(document).ready(function () {

    // variable declaration
    var usersTable;
    var usersDataArray = [],
    form = $('.form-validate');

    // datatable initialization
    if ($("#users-list-datatable").length > 0) {
        usersTable = $("#users-list-datatable").DataTable({
            responsive: true,
            'columnDefs': [
                {
                    "orderable": false,
                    // "targets": [7]
                }]
        });
    };
    // on click selected users data from table(page named app-users-list)
    // to store into local storage to get rendered on second page named app-users-view
    $(document).on("click", "#users-list-datatable tr", function () {
        $(this).find("td").each(function () {
            usersDataArray.push($(this).text().trim())
        })
        localStorage.setItem("usersId", usersDataArray[0]);
        localStorage.setItem("usersUsername", usersDataArray[1]);
        localStorage.setItem("usersName", usersDataArray[2]);
        localStorage.setItem("usersVerified", usersDataArray[4]);
        localStorage.setItem("usersRole", usersDataArray[5]);
        localStorage.setItem("usersStatus", usersDataArray[6]);
    })
    // render stored local storage data on page named app-users-view
    if (localStorage.usersId !== undefined) {
        $(".users-view-id").html(localStorage.getItem("usersId"));
        $(".users-view-username").html(localStorage.getItem("usersUsername"));
        $(".users-view-name").html(localStorage.getItem("usersName"));
        $(".users-view-verified").html(localStorage.getItem("usersVerified"));
        $(".users-view-role").html(localStorage.getItem("usersRole"));
        $(".users-view-status").html(localStorage.getItem("usersStatus"));
        // update badge color on status change
        if ($(".users-view-status").text() === "Banned") {
            $(".users-view-status").toggleClass("badge-light-success badge-light-danger")
        }
        // update badge color on status change
        if ($(".users-view-status").text() === "Close") {
            $(".users-view-status").toggleClass("badge-light-success badge-light-warning")
        }
    }
    // page users list verified filter
    $("#users-list-verified").on("change", function () {
        var usersVerifiedSelect = $("#users-list-verified").val();
        usersTable.search(usersVerifiedSelect).draw();
    });
    // page users list role filter
    $("#users-list-role").on("change", function () {
        var usersRoleSelect = $("#users-list-role").val();
        // console.log(usersRoleSelect);
        usersTable.search(usersRoleSelect).draw();
    });
    // page users list status filter
    $("#users-list-status").on("change", function () {
        var usersStatusSelect = $("#users-list-status").val();
        // console.log(usersStatusSelect);
        usersTable.search(usersStatusSelect).draw();
    });
    // users language select
    if ($("#users-language-select2").length > 0) {
        $("#users-language-select2").select2({
            dropdownAutoWidth: true,
            width: '100%'
        });
    }
    // page users list clear filter
    $(".users-list-clear").on("click", function(){
        usersTable.search("").draw();
    })
    // users music select
    if ($("#users-music-select2").length > 0) {
        $("#users-music-select2").select2({
            dropdownAutoWidth: true,
            width: '100%'
        });
    }
    // users movies select
    if ($("#users-movies-select2").length > 0) {
        $("#users-movies-select2").select2({
            dropdownAutoWidth: true,
            width: '100%'
        });
    }
    // users birthdate date
    if ($(".birthdate-picker").length > 0) {
        $('.birthdate-picker').pickadate({
            format: 'mmmm, d, yyyy'
        });
    }


  // Validation
  if (form.length) {
    $(form).each(function () {
      var $this = $(this);
      $this.validate({
        submitHandler: function (form, event) {
          event.preventDefault();
        },
        rules: {
          username: {
            required: true
          },
          name: {
            required: true
          },
          email: {
            required: true,
            email: true
          },
          dob: {
            required: true,
            step: false
          },
          phone: {
            required: true
          },
          website: {
            required: true,
            url: true
          },
          address: {
            required: true
          }
        }
      });
    });

    $(this).on('submit', function (event) {
      event.preventDefault();
    });
  }
});

function addHcode(hcode){
  
  console.log(hcode);

  $('#modalHospAdd').modal()
  var jxr = $.post('../../../controller/facility?stage=getinfo', {hcode: hcode}, function(){}, 'json')
             .always(function(snap){
               console.log(snap);
               if(snap != ''){
                 console.log(snap);
                  $('#txtHospname').val(snap.hosname)
                  $('#txtLat').val(snap.hlat)
                  $('#txtLng').val(snap.hlng)
                  $('#txtHcode').val(hcode)
               }else{
                Swal.fire(
                  {
                    icon: "error",
                    title: 'คำเตือน',
                    text: 'ไม่พบข้อมูลสถานบริการดังกล่าว',
                    confirmButtonClass: 'btn btn-danger',
                  }
                )
               }
             })

  // Swal.fire({
  //   title: 'ยืนยันดำเนินการ?',
  //   text: "เปิดใช้งานสถานบริการนี้หรือไม่",
  //   icon: 'warning',
  //   showCancelButton: true,
  //   confirmButtonColor: '#3085d6',
  //   cancelButtonColor: '#d33',
  //   confirmButtonText: 'เปิดใช้งาน',
  //   confirmButtonClass: 'btn btn-primary',
  //   cancelButtonClass: 'btn btn-danger ml-1',
  //   cancelButtonText: 'ยกเลิก',
  //   buttonsStyling: false,
  // }).then(function (result) {
  //   if (result.value) {
  //     var jxr = $.post("../../../api/admin-api?stage=add_hcode", {target_hcode: hcode}, function(){})
  //                .always(function(resp){
  //                  console.log(resp);
  //                 if(resp == 'Success'){
  //                   Swal.fire({
  //                     title: 'สำเร็จ',
  //                     text: "หน่วยบริการได้เปิดให้ใช้งานแล้ว",
  //                     icon: 'success',
  //                     showCancelButton: false,
  //                     confirmButtonColor: '#3085d6',
  //                     confirmButtonText: 'ดูข้อมูล',
  //                     confirmButtonClass: 'btn btn-primary',
  //                     buttonsStyling: false,
  //                   }).then(function (result) {
  //                     if (result.value) {
  //                       window.location = './app-facility-list'
  //                     }
  //                   })
  //                 }else{
  //                   Swal.fire(
  //                     {
  //                       icon: "error",
  //                       title: 'เกิดข้อผิดพลาด',
  //                       text: 'ไม่สามารถเพิ่มสถานบริการได้',
  //                       confirmButtonClass: 'btn btn-danger',
  //                     }
  //                   )
  //                 }
  //                })
      
  //   }
  // })
}

function removeHcode(hcode){
  Swal.fire({
    title: 'ยืนยันดำเนินการ?',
    text: "ต้องการปิดการใช้งานสถานบริการนี้หรือไม่",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'ปิดใช้งาน',
    confirmButtonClass: 'btn btn-primary',
    cancelButtonClass: 'btn btn-danger ml-1',
    cancelButtonText: 'ยกเลิก',
    buttonsStyling: false,
  }).then(function (result) {
    if (result.value) {
      var jxr = $.post("../../../api/admin-api?stage=remove_hcode", {target_hcode: hcode}, function(){})
                 .always(function(resp){
                   console.log(resp);
                  if(resp == 'Success'){
                    Swal.fire({
                      title: 'สำเร็จ',
                      text: "ปิดการใช้งานหน่วยบริการแล้ว",
                      icon: 'success',
                      showCancelButton: false,
                      confirmButtonColor: '#3085d6',
                      confirmButtonText: 'รีโหลดข้อมูล',
                      confirmButtonClass: 'btn btn-primary',
                      buttonsStyling: false,
                    }).then(function (result) {
                      if (result.value) {
                        window.location.reload()
                      }
                    })
                  }else{
                    Swal.fire(
                      {
                        icon: "error",
                        title: 'เกิดข้อผิดพลาด',
                        text: 'ไม่สามารถปิดการใช้งานสถานบริการได้',
                        confirmButtonClass: 'btn btn-danger',
                      }
                    )
                  }
                 })
      
    }
  })
}

$(function(){

})

var facility = {
  check_admin_update_hosp(){
    $check = 0; $('.form-control').removeClass('is-invalid')
    if($('#txtHospname').val() == ''){ $check++; $('#txtHospname').addClass('is-invalid')}
    if($('#txtLat').val() == ''){ $check++; $('#txtLat').addClass('is-invalid')}
    if($('#txtLng').val() == ''){ $check++; $('#txtLng').addClass('is-invalid')}
    if($('#txtType').val() == ''){ $check++; $('#txtType').addClass('is-invalid')}
    if($('#txtMainhname').val() == ''){ $check++; $('#txtMainhname').addClass('is-invalid')}
    if($check != 0){return false;}
  },
  check_admin_save_hosp(){
    $check = 0; $('.form-control').removeClass('is-invalid')
    if($('#txtHospname').val() == ''){ $check++; $('#txtHospname').addClass('is-invalid')}
    if($('#txtLat').val() == ''){ $check++; $('#txtLat').addClass('is-invalid')}
    if($('#txtLng').val() == ''){ $check++; $('#txtLng').addClass('is-invalid')}
    if($('#txtType').val() == ''){ $check++; $('#txtType').addClass('is-invalid')}
    if($('#txtMainhname').val() == ''){ $check++; $('#txtMainhname').addClass('is-invalid')}

    
    if($check != 0){return false;}
  }
}
function setHospconfig(hcode){
  $('#modalHospEdit').modal()
  var jxr = $.post('../../../controller/facility?stage=getinfo', {hcode: hcode}, function(){}, 'json')
             .always(function(snap){
               console.log(snap);
               if(snap != ''){
                $('#txtHospname').val(snap.hserv)
                $('#txtLat').val(snap.hlat)
                $('#txtLng').val(snap.hlng)
                // $('#txtMainhname').val(snap.hospname)
                // $('#mySelect2').find(':selected');
                $('#txtMainhname').val(snap.hospname).trigger('change');
                $('#txtType').val(snap.htype_code)
                $('#txtHcode').val(hcode)
               }else{
                Swal.fire(
                  {
                    icon: "error",
                    title: 'คำเตือน',
                    text: 'ไม่พบข้อมูลสถานบริการดังกล่าว',
                    confirmButtonClass: 'btn btn-danger',
                  }
                )
               }
             })
}

$(".select2").select2({
  // the following code is used to disable x-scrollbar when click in select input and
  // take 100% width in responsive also
  dropdownAutoWidth: true,
  width: '100%'
});
