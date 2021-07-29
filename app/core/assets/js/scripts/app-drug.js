$(function(){
    $('#txtReason').change(function(){
        if($('#txtReason').val() == 'dianosis'){
            $('#divReason').removeClass('dn')
        }else{
            $('#divReason').addClass('dn')
            $('#txtCnfMsg').val('')
        }
    })
})

function update_drug(id, name){
    $('#modalDrug').modal()
    $('#txtuDrugId').val(id)
    $('#txtuDrugName').val(name)
}

function resetDrugForm(){
    $('#txtDrug').val('')
    $('#txtDrugQ').val('')
    $('#txtDrugInfo').val('')

    $('#txtDrugu').val('')
    $('#txtDrugQu').val('')
    $('#txtDrugInfou').val('')
}

function saveDrugForm(){
    $check = 0;
    $('.form-control').removeClass('is-invalid')
    if($('#txtDrug').val() == ''){
        $check++; $('#txtDrug').addClass('is-invalid')
    }else{
        if($('#txtDrug').val() == '99'){
            if($('#txtDrugName').val() == ''){
                $('#txtDrugName').addClass('is-invalid')
                return ;
            }
        }
    }

    if($('#txtDrugQ').val() == ''){
        $check++; $('#txtDrugQ').addClass('is-invalid')
    }

    if($check != 0){
        return ;
    }

    preload.show()

    var param = {
        uid: $('#txtCurrentUid').val(),
        puid: $('#txtPatient_id').val(),
        drug_id: $('#txtDrug').val(),
        drug_name: $('#txtDrugName').val(),
        drug_q: $('#txtDrugQ').val(),
        drug_info: $('#txtDrugInfo').val()
    }

    var jxr = $.post(api_url + 'patient?stage=add_drug', param, function(){}, 'json')
               .always(function(snap){
                   if(snap.status == 'Success'){
                        resetDrugForm()
                        $('#addDrugModal').modal('hide')
                        loadDruglist()
                   }else{
                        Swal.fire({
                            icon: "error",
                            title: 'เกิดข้อผิดพลาด',
                            text: 'ไม่สามารถเพิ่มรายการยาได้',
                            confirmButtonClass: 'btn btn-danger',
                        })
                   }
               })
}

// loadDruglist()

function loadDruglist(){
    var param = {
        uid: $('#txtCurrentUid').val(),
        puid: $('#txtPatient_id').val()
    }

    var jxr = $.post(api_url + 'patient?stage=list_patient_drug', param, function(){}, 'json')
               .always(function(snap){
                    console.log(snap.data);
                    preload.hide()
                    $('#drugList').html('<tr><td colspan="4" class="text-center th">ยังไม่มีรายการยาของผู้ป่วย</td></tr>')
                   if(snap.status == 'Success'){
                        $('#drugList').empty()
                        $c = 1;
                        $cnf = 0;
                        snap.data.forEach(i=>{
                            if(i.med_cnf == 'N'){
                                $cnf++;
                            }
                            $('#drugList').append('<tr>' + 
                                '<td>' + $c + '</td>' +
                                '<td>' + i.med_name + '</td>' +
                                '<td>' + i.med_amount + '</td>' +
                                '<td><td style="" class="text-right">' +
                                '<a href="Javascript:updateDrug(\'' + i.ID + '\')" class="text-muted mr-1"><i class="bx bx-wrench"></i></a>' +
                                '<a href="Javascript:deleteDrug(\'' + i.ID + '\')" class="text-danger"><i class="bx bx-trash"></i></a>' +
                                '</td></td>' +
                            '</tr>')
                            $c++;
                        })

                        console.log($cnf);
                        if($cnf != 0){
                            $('#btnConfirmDrug').removeClass('dn')
                        }else{
                            $('#btnConfirmDrug').addClass('dn')
                        }

                        // snap.foreach(i=>{})
                   }
               })
}

function deleteDrug(did){
    Swal.fire({
        title: 'ลบรายการยา',
        text: 'ยืนยันการลยรายการยานี้หรือไม่',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'ยกเลิก',
        confirmButtonClass: 'btn btn-primary mr-1',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
      }).then(function (result) {
        if (result.value) {
          preload.show()
          var param = {
              did: did,
              uid: $('#txtCurrentUid').val(),
              puid: $('#txtPatient_id').val()
          }
          var jxr = $.post(api_url + 'patient?stage=delete_patient_drug', param, function(){}, 'json')
               .always(function(snap){
                   if(snap.status == 'Success'){
                    loadDruglist()
                        Swal.fire({
                            icon: "success",
                            title: 'สำเร็จ',
                            text: 'รายการยาถูกลบแล้ว',
                            confirmButtonClass: 'btn btn-success',
                    })
                   }else{
                       preload.hide();
                       Swal.fire({
                            icon: "error",
                            title: 'เกิดข้อผิดพลาด',
                            text: 'ไม่สามารถลบรายการยาได้',
                            confirmButtonClass: 'btn btn-danger',
                       })
                   }
               })
        }
      })
}

function updateDrugForm(){
    $check = 0;
    $('.form-control').removeClass('is-invalid')
    if($('#txtDrugu').val() == ''){
        $check++; $('#txtDrugu').addClass('is-invalid')
    }

    if($('#txtDrugQu').val() == ''){
        $check++; $('#txtDrugQu').addClass('is-invalid')
    }

    if($check != 0){
        return ;
    }

    preload.show()

    var param = {
        uid: $('#txtCurrentUid').val(),
        puid: $('#txtPatient_id').val(),
        drug_id: $('#txtDrugIdu').val(),
        drug_name: $('#txtDrugu').val(),
        drug_med_id: $('#txtDrugDidu').val(),
        drug_q: $('#txtDrugQu').val(),
        drug_info: $('#txtDrugInfo').val()
    }

    var jxr = $.post(api_url + 'patient?stage=update_drug', param, function(){}, 'json')
               .always(function(snap){
                   console.log(snap);
                   if(snap.status == 'Success'){
                        resetDrugForm()
                        $('#modalUpdateDrug').modal('hide')
                        loadDruglist()
                   }else{
                        preload.hide()
                        Swal.fire({
                            icon: "error",
                            title: 'เกิดข้อผิดพลาด',
                            text: 'ไม่สามารถแก้ไขข้อมูลยาได้',
                            confirmButtonClass: 'btn btn-danger',
                        })
                   }
               })
}

function updateDrug(id){
    $('#modalUpdateDrug').modal()
    $('#txtDrugIdu').val(id)
    preload.show()
    var param = {
        did: id,
        uid: $('#txtCurrentUid').val(),
        puid: $('#txtPatient_id').val()
    }
    var jxr = $.post(api_url + 'patient?stage=get_patient_drug', param, function(){}, 'json')
               .always(function(snap){
                   preload.hide();
                   console.log(snap);
                   if(snap.status == 'Success'){
                    $('#txtDrugQu').val(snap.data.med_amount)
                    $('#txtDrugu').val(snap.data.med_name)
                    $('#txtDrugInfou').val(snap.data.med_desc)
                    $('#txtDrugDidu').val(snap.data.med_id)
                   }
               })
}
function confirmDruglist(){
    $check = 0;
    $('.form-control').removeClass('is-invalid')
    if($('#txtReason').val() == ''){
        $('#txtReason').addClass('is-invalid')
        $check++;
    }else{
        if($('#txtReason').val() == 'dianosis'){
            if($('#txtCnfMsg').val() == ''){
                $('#txtCnfMsg').addClass('is-invalid')
                $check++;
            }
        }
    }

    if($check != 0){
        return ;
    }


    Swal.fire({
        title: 'ยืนยันรายการยา',
        text: 'ท่านยืนยันว่ารายการยานี้ได้รับการตรวจสอบและยืนยันแล้วหรือไม่',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'ตรวจสอบอีกครั้ง',
        confirmButtonClass: 'btn btn-primary mr-1',
        cancelButtonClass: 'btn btn-secondary',
        buttonsStyling: false,
    }).then(function (result) {
        if (result.value) {
            preload.show()

            var param = {
                uid: $('#txtCurrentUid').val(),
                puid: $('#txtPatient_id').val(),
                reason: $('#txtReason').val(),
                reason_inf: $('#txtCnfMsg').val(),
            }
            
            var jxr = $.post(api_url + 'patient?stage=confirm_patient_drug', param, function(){}, 'json')
                       .always(function(snap){
                           console.log(snap);
                           if(snap.status == 'Success'){
                            resetDrugForm()
                            $('#cnfDrugmodal').modal('hide')
                            loadDruglist()
                            Swal.fire({
                                icon: "success",
                                title: 'สำเร็จ',
                                text: 'รายการยาถูกยืนยันแล้ว',
                                confirmButtonClass: 'btn btn-success',
                            })
                           }else{
                               preload.hide()
                               Swal.fire({
                                    icon: "error",
                                    title: 'เกิดข้อผิดพลาด',
                                    text: 'ไม่สามารถยืนยันรายการยาได้',
                                    confirmButtonClass: 'btn btn-danger',
                                })
                           }
                       })
        }
    })

    
}

function addNewdrug(){
    $('#txtDrugname').removeClass('is-invalid')
    if($('#txtDrugname').val() == ''){
        $('#txtDrugname').addClass('is-invalid')
        return ;
    }
    var param = {
        uid: $('#txtCurrentUid').val(),
        drug_name: $('#txtDrugname').val()
    }

    preload.show()

    var jxr = $.post(api_url + 'core-api?stage=add_new_drug', param, function(){}, 'json')
               .always(function(snap){
                   preload.hide()
                   if(snap.status == 'Duplicate'){
                        Swal.fire({
                            icon: "error",
                            title: 'เกิดข้อผิดพลาด',
                            text: 'พบชื่อยาซ้ำ',
                            confirmButtonClass: 'btn btn-danger',
                        })
                   }else if(snap.status == 'Success'){
                        window.location = './app-drug-list'
                   }else{
                        Swal.fire({
                            icon: "error",
                            title: 'เกิดข้อผิดพลาด',
                            text: 'พบชื่อยาซ้ำ',
                            confirmButtonClass: 'btn btn-danger',
                        })
                   }
               })
}

function delete_drug(id){
    Swal.fire({
        title: 'ยืนยันดำเนินการ',
        text: 'ท่านยืนยันลบรายการยาหรือไม่',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'ตรวจสอบอีกครั้ง',
        confirmButtonClass: 'btn btn-danger mr-1',
        cancelButtonClass: 'btn btn-secondary',
        buttonsStyling: false,
    }).then(function (result) {
        if (result.value) {
            preload.show()
            var param = {
                uid: $('#txtCurrentUid').val(),
                drug_id: id
            }
            var jxr = $.post(api_url + 'core-api?stage=delete_new_drug', param, function(){}, 'json')
               .always(function(snap){
                   console.log(snap);
                if(snap.status == 'Success'){
                    window.location.reload()
                }else{
                    preload.hide()
                    Swal.fire({
                        icon: "error",
                        title: 'เกิดข้อผิดพลาด',
                        text: 'ไม่สามารถลบยาได้',
                        confirmButtonClass: 'btn btn-danger',
                    })
                }
               })
        }
    })
}

function updateNewDrug(){
    $('#txtuDrugName').removeClass('is-invalid')
    if($('#txtuDrugName').val() == ''){
        $('#txtuDrugName').addClass('is-invalid')
        return ;
    }
    var param = {
        did: $('#txtuDrugId').val(),
        dname: $('#txtuDrugName').val(),
        uid: $('#txtCurrentUid').val()
    }
    preload.show()
    var jxr = $.post(api_url + 'core-api?stage=update_new_drug', param, function(){}, 'json')
               .always(function(snap){
                    console.log(snap);
                    if(snap.status == 'Success'){
                        window.location.reload()
                    }else{
                        preload.hide()
                        Swal.fire({
                            icon: "error",
                            title: 'เกิดข้อผิดพลาด',
                            text: 'ไม่สามารถลบยาได้',
                            confirmButtonClass: 'btn btn-danger',
                        })
                    }
               })
}