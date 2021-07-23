function update_drug(id, name){
    $('#modalDrug').modal()
    $('#txtDrugId').val(id)
    $('#txtDrugName').val(name)
}

function resetDrugForm(){
    $('#txtDrug').val('')
    $('#txtDrugInfo').val('')
}

function saveDrugForm(){
    $check = 0;
    $('.form-control').removeClass('is-invalid')
    if($('#txtDrug').val() == ''){
        $check++; $('#txtDrug').addClass('is-invalid')
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
                        snap.data.forEach(i=>{
                            $('#drugList').append('<tr>' + 
                                '<td>' + $c + '</td>' +
                                '<td>' + i.med_name + '</td>' +
                                '<td>' + i.med_amount + '</td>' +
                                '<td></td>' +
                            '</tr>')
                            $c++;
                        })

                        // snap.foreach(i=>{})
                   }
               })
}