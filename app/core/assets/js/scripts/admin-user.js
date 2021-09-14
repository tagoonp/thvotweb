var admin_user = {
    resetLocation(uid){
        Swal.fire({
            title: 'ยืนยันดำเนินการ?',
            text: "ยืนยันการรีเซ็ตพิกัดที่อยู่ของผู้ป่วยหรือไม่",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยัน',
            confirmButtonClass: 'btn btn-primary',
            cancelButtonClass: 'btn btn-danger ml-1',
            cancelButtonText: 'ยกเลิก',
            buttonsStyling: false,
        }).then(function (result) {
            if (result.value) {
            var jxr = $.post("https://thvot.com/thvotweb/app/api/admin-api?stage=admin_reset_patient_location", {target_uid: uid}, function(){})
                        .always(function(resp){
                        console.log(resp);
                        if(resp == 'Success'){
                            Swal.fire({
                            title: 'สำเร็จ',
                            text: "ลบบัญชีผู้งานเรียบร้อยแล้ว",
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
                                    text: 'ไม่สามารถลบบัญชีผู้ใช้งานได้',
                                    confirmButtonClass: 'btn btn-danger',
                                }
                            )
                        }
                        })
            }
        })
    },
    delete_user(uid){
        
        Swal.fire({
            title: 'ยืนยันดำเนินการ?',
            text: "ต้องการลบผู้ใช้งานนี้หรือไม่",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยัน',
            confirmButtonClass: 'btn btn-primary',
            cancelButtonClass: 'btn btn-danger ml-1',
            cancelButtonText: 'ยกเลิก',
            buttonsStyling: false,
        }).then(function (result) {
            if (result.value) {
            var jxr = $.post(api_url + "admin-api?stage=admin_delete_user", {target_uid: uid}, function(){})
                        .always(function(resp){
                        console.log(resp);
                        if(resp == 'Success'){
                            Swal.fire({
                            title: 'สำเร็จ',
                            text: "ลบบัญชีผู้งานเรียบร้อยแล้ว",
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
                                    text: 'ไม่สามารถลบบัญชีผู้ใช้งานได้',
                                    confirmButtonClass: 'btn btn-danger',
                                }
                            )
                        }
                        })
            
            }
        })
    },
    toggle_active(input){
        $toggle_to = '0'
        if ($('#sw_active_' + input).is(':checked')) {
            $toggle_to = '1'
        }
        var jxr = $.post(api_url + "admin-api?stage=toggle_active", {target_id: input, toggle_to: $toggle_to}, function(){})
                   .always(function(resp){ console.log(resp); })
    },
    toggle_status(input){
        $toggle_to = '0'
        if ($('#sw_status_' + input).is(':checked')) {
            $toggle_to = '1'
        }
        var jxr = $.post(api_url + "admin-api?stage=toggle_status", {target_id: input, toggle_to: $toggle_to}, function(){})
                   .always(function(resp){ console.log(resp); })
    },
    toggle_access(input, lv){
        $toggle_to = '0'
        if ($('#' + lv + input).is(':checked')) {
            $toggle_to = '1'
        }
        var jxr = $.post(api_url + "admin-api?stage=toggle_access", {target_id: input, toggle_to: $toggle_to, level: lv}, function(){})
                   .always(function(resp){ console.log(resp); })
    },
    check_password_form(){
        $check = 0
        $('.form-control').removeClass('is-invalid')
        if($('#txtPassword1').val() == ''){ $check++; $('#txtPassword1').addClass('is-invalid') }
        if($('#txtPassword2').val() == ''){ $check++; $('#txtPassword2').addClass('is-invalid') }
        if($('#txtPassword1').val() != $('#txtPassword2').val()){ $check++; $('#txtPassword2').addClass('is-invalid') }

        if($check != 0){
            Swal.fire(
                {
                  icon: "error",
                  title: 'คำเตือน',
                  text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                  confirmButtonClass: 'btn btn-danger',
                }
              )
              return false;
        }

        preload.show()

        var param = {
            uid: $('#txtCurrentUid').val(),
            puid: $('#txtPasswordUid').val(),
            password: $('#txtPassword1').val(),
        }

        var jxr = $.post(api_url + 'patient?stage=updatepassword', param, function(){}, 'json')
                   .always(function(snap){
                       console.log(snap);
                       preload.hide()
                       if(snap.status == 'Success'){
                        Swal.fire({
                            title: 'ปรับปรุงข้อมูลสำเร็จ',
                            text: 'ข้อมูลของผู้ป่วย ID ' + $('#txtUsername').val() + ' ถูกปรับปรุงเรียบร้อยแล้ว',
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
                              text: 'ไม่สามารถปรับปรุงข้อมูลผู้ป่วยได้',
                              confirmButtonClass: 'btn btn-danger',
                            }
                          )
                       }
                   })
        return ;
    },
    check_patientadd_form(){
        $check = 0
        $('.form-control').removeClass('is-invalid')
        $('.select-error').css({'border': 'none'});
        // if($('#txtUsername').val() == ''){ $check++; $('#txtUsername').addClass('is-invalid') }
        if($('#txtFname').val() == ''){ $check++; $('#txtFname').addClass('is-invalid') }
        if($('#txtLname').val() == ''){ $check++; $('#txtLname').addClass('is-invalid') }
        if($('#txtRole').val() == ''){ $check++; $('#txtRole').addClass('is-invalid') }
        if($('#txtPhone').val() == ''){ $check++; $('#txtPhone').addClass('is-invalid') }
        if($('#txtStatus').val() == ''){ $check++; $('#txtStatus').addClass('is-invalid') }
        if($('#txtVerify').val() == ''){ $check++; $('#txtVerify').addClass('is-invalid') }
        if($('#txtPassword1').val() == ''){ $check++; $('#txtPassword1').addClass('is-invalid') }
        if($('#txtPassword2').val() == ''){ $check++; $('#txtPassword2').addClass('is-invalid') }
        if($('#txtPassword1').val() != $('#txtPassword2').val()){ $check++; $('#txtPassword2').addClass('is-invalid') }
        if($('#txtHn').val() == ''){ $check++; $('#txtHn').addClass('is-invalid') }
        if($('#txtProvince').val() == ''){ $check++; $('#txtProvince').addClass('is-invalid') }
        if($('#txtDist').val() == ''){ $check++; $('#txtDist').addClass('is-invalid') }
        if($('#txtSubdist').val() == ''){ $check++; $('#txtSubdist').addClass('is-invalid') }

        $('[data-required]').each(function() {
            if (!$(this).val()) {
                $check++;
              if ($(this).data('select2')) {
                    if(this.id == 'txtHcodeReg'){ 
                        $('#regHcode').css({
                            'border': '1px solid #FF5B5C',
                            'border-radius': '4px'
                        });
                    }

                     if(this.id == 'txtHcodeManage'){ 
                        $('#manageHcode').css({
                        'border': '1px solid #FF5B5C',
                        'border-radius': '4px'
                        });
                    }

                    if(this.id == 'txtHcodeObs'){ 
                        $('#obsHcode').css({
                        'border': '1px solid #FF5B5C',
                        'border-radius': '4px'
                        });
                    }

                    if(this.id == 'txtStaff'){ 
                        $('#staff').css({
                        'border': '1px solid #FF5B5C',
                        'border-radius': '4px'
                        });
                    }
            }
        }});

        if($check != 0){
            Swal.fire(
                {
                  icon: "error",
                  title: 'คำเตือน',
                  text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                  confirmButtonClass: 'btn btn-danger',
                }
              )
              return ;
        }


        preload.show()

        var param = {
            othbo: $('#txtTbno').val(),
            pusername: $('#txtUsername').val(),
            fname: $('#txtFname').val(),
            lname: $('#txtLname').val(),
            phone: $('#txtPhone').val(),
            rphone: $('#txtRelatedPhone').val(),
            status: '1',
            ptype: $('#txtRole').val(),
            verify: '1',
            hn: $('#txtHn').val(),
            password: $('#txtPassword1').val(),
            reg_hcode: $('#txtHcodeReg').val(),
            hcode: $('#txtHcodeManage').val(),
            obs_hcode: $('#txtHcodeObs').val(),
            obs_uid: $('#txtStaff').val(),
            province: $('#txtProvince').val(),
            district: $('#txtDist').val(),
            subdistrict: $('#txtSubdist').val(),
            uid: $('#txtCurrentUid').val()
        }

        console.log(param);

        var jxr = $.post(api_url + 'patient?stage=patient_register', param, function(){}, 'json')
                   .always(function(snap){
                       console.log(snap);
                       preload.hide()
                       if(snap.status == 'Success'){
                           window.location = 'app-patient-management?uid=' + $('#txtCurrentUid').val() + '&role=' + $('#txtCurrentUrole').val() + '&hcode=' + $('#txtCurrentUhcode').val() + '&id=' + snap.pid
                       }else if(snap.status == 'Duplicate'){
                            Swal.fire(
                                {
                                icon: "error",
                                title: 'คำเตือน',
                                text: 'พบชื่อบัญชีผู้ใช้นี้แล้ว',
                                confirmButtonClass: 'btn btn-danger',
                                }
                            )
                       }else{
                            Swal.fire(
                                {
                                icon: "error",
                                title: 'เกิดข้อผิดพลาด',
                                text: 'ไม่สามารถลงทะเบียนผู้ป่าวยได้ กรุณาลองใหม่หรือติดต่อผู้ดูแลระบบ',
                                confirmButtonClass: 'btn btn-danger',
                                }
                            )
                       }
                   })

        return ;
    },
    check_patientupdate_form(){
        $check = 0
        $('.form-control').removeClass('is-invalid')
        $('.select-error').css({'border': 'none'});
        if($('#txtUsername').val() == ''){ $check++; $('#txtUsername').addClass('is-invalid') }
        if($('#txtFname').val() == ''){ $check++; $('#txtFname').addClass('is-invalid') }
        if($('#txtLname').val() == ''){ $check++; $('#txtLname').addClass('is-invalid') }
        if($('#txtRole').val() == ''){ $check++; $('#txtRole').addClass('is-invalid') }
        if($('#txtPhone').val() == ''){ $check++; $('#txtPhone').addClass('is-invalid') }
        if($('#txtStatus').val() == ''){ $check++; $('#txtStatus').addClass('is-invalid') }
        if($('#txtVerify').val() == ''){ $check++; $('#txtVerify').addClass('is-invalid') }
        if($('#txtHn').val() == ''){ $check++; $('#txtHn').addClass('is-invalid') }
        if($('#txtProvince').val() == ''){ $check++; $('#txtProvince').addClass('is-invalid') }
        if($('#txtDist').val() == ''){ $check++; $('#txtDist').addClass('is-invalid') }
        if($('#txtSubdist').val() == ''){ $check++; $('#txtSubdist').addClass('is-invalid') }

        $('[data-required]').each(function() {
            if (!$(this).val()) {
                $check++;
              if ($(this).data('select2')) {
                $('.select-error').css({
                  'border': '1px solid #FF5B5C',
                  'border-radius': '4px'
                });
            }
        }});

        if($check != 0){
            Swal.fire(
                {
                  icon: "error",
                  title: 'คำเตือน',
                  text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                  confirmButtonClass: 'btn btn-danger',
                }
              )
              return false;
        }

        preload.show()

        var param = {
            puid: $('#txtUid').val(),
            pusername: $('#txtUsername').val(),
            fname: $('#txtFname').val(),
            lname: $('#txtLname').val(),
            phone: $('#txtPhone').val(),
            rphone: $('#txtRPhone').val(),
            status: $('#txtStatus').val(),
            ptype: $('#txtRole').val(),
            verify: $('#txtVerify').val(),
            reg_hcode: $('#txtHcodeReg').val(),
            hcode: $('#txtHcodeManage').val(),
            rphone: $('#txtrPhone').val(),
            obs_hcode: $('#txtHcodeObs').val(),
            province: $('#txtProvince').val(),
            district: $('#txtDist').val(),
            subdistrict: $('#txtSubdist').val(),
            uid: $('#txtCurrentUid').val()
        }

        var jxr = $.post(api_url + 'patient?stage=patient_update_info', param, function(){}, 'json')
                   .always(function(snap){
                       console.log(snap);
                       preload.hide()
                       if(snap.status == 'Success'){
                        Swal.fire({
                            title: 'ปรับปรุงข้อมูลสำเร็จ',
                            text: 'ข้อมูลของผู้ป่วย ID ' + $('#txtUsername').val() + ' ถูกปรับปรุงเรียบร้อยแล้ว',
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
                          Swal.fire({
                              icon: "error",
                              title: 'เกิดข้อผิดพลาด',
                              text: 'ไม่สามารถปรับปรุงข้อมูลผู้ป่วยได้',
                              confirmButtonClass: 'btn btn-danger',
                          })
                       }
                   })
        return ;
    },
    check_date_form(){
        $check = 0
        $('.form-control').removeClass('is-invalid')
        if($('#txtStartmonitor').val() == ''){ $check++; $('#txtStartmonitor').addClass('is-invalid') }
        if($('#txtEndmonitor').val() == ''){ $check++; $('#txtEndmonitor').addClass('is-invalid') }

        console.log($('#txtStartmonitor').val());
        if($check != 0){
            Swal.fire(
                {
                  icon: "error",
                  title: 'คำเตือน',
                  text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                  confirmButtonClass: 'btn btn-danger',
                }
              )
              return false;
        }

        var param = {
            puid: $('#txtMonitorUid').val(),
            start_mon: $('#txtStartmonitor').val(),
            end_mon: $('#txtEndmonitor').val(),
            uid: $('#txtCurrentUid').val()
        }

        preload.show()

        var jxr = $.post(api_url + 'patient?stage=updatemonitor', param, function(){}, 'json')
                   .always(function(snap){
                       console.log(snap);
                       preload.hide()
                       if(snap.status == 'Success'){
                        Swal.fire({
                            title: 'ปรับปรุงข้อมูลสำเร็จ',
                            text: 'ข้อมูลข้อมูลการติดตามการรับประทานยาของผู้ป่วย ID ' + $('#txtUsername').val() + ' ถูกปรับปรุงเรียบร้อยแล้ว',
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
                              text: 'ไม่สามารถปรับปรุงข้อมูลการติดตามการรับประทานยาของผู้ป่วยได้',
                              confirmButtonClass: 'btn btn-danger',
                            }
                          )
                       }
                   })
        return ;
    },
    check_update_form(){
        $check = 0
        $('.form-control').removeClass('is-invalid')
        $('.select-error').css({'border': 'none'});
        if($('#txtUsername').val() == ''){ $check++; $('#txtUsername').addClass('is-invalid') }
        if($('#txtFname').val() == ''){ $check++; $('#txtFname').addClass('is-invalid') }
        if($('#txtLname').val() == ''){ $check++; $('#txtLname').addClass('is-invalid') }
        if($('#txtRole').val() == ''){ $check++; $('#txtRole').addClass('is-invalid') }
        if($('#txtPhone').val() == ''){ $check++; $('#txtPhone').addClass('is-invalid') }
        if($('#txtStatus').val() == ''){ $check++; $('#txtStatus').addClass('is-invalid') }
        if($('#txtVerify').val() == ''){ $check++; $('#txtVerify').addClass('is-invalid') }

        $('[data-required]').each(function() {
            if (!$(this).val()) {
                $check++;
              if ($(this).data('select2')) {
                $('.select-error').css({
                  'border': '1px solid #FF5B5C',
                  'border-radius': '4px'
                });
            }
        }});

        if($check != 0){
            Swal.fire(
                {
                  icon: "error",
                  title: 'คำเตือน',
                  text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                  confirmButtonClass: 'btn btn-danger',
                }
              )
              return false;
        }
    },
    check_update_form(){
        $check = 0
        $('.form-control').removeClass('is-invalid')
        $('.select-error').css({'border': 'none'});
        if($('#txtUsername').val() == ''){ $check++; $('#txtUsername').addClass('is-invalid') }
        if($('#txtFname').val() == ''){ $check++; $('#txtFname').addClass('is-invalid') }
        if($('#txtLname').val() == ''){ $check++; $('#txtLname').addClass('is-invalid') }
        if($('#txtRole').val() == ''){ $check++; $('#txtRole').addClass('is-invalid') }
        if($('#txtPhone').val() == ''){ $check++; $('#txtPhone').addClass('is-invalid') }
        if($('#txtStatus').val() == ''){ $check++; $('#txtStatus').addClass('is-invalid') }
        if($('#txtVerify').val() == ''){ $check++; $('#txtVerify').addClass('is-invalid') }

        $('[data-required]').each(function() {
            if (!$(this).val()) {
                $check++;
              if ($(this).data('select2')) {
                $('.select-error').css({
                  'border': '1px solid #FF5B5C',
                  'border-radius': '4px'
                });
            }
        }});

        if($check != 0){
            Swal.fire(
                {
                  icon: "error",
                  title: 'คำเตือน',
                  text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                  confirmButtonClass: 'btn btn-danger',
                }
              )
              return false;
        }

        preload.show()

        var param = {
            uid: $('#txtCurrentUid').val(),
            username: $('#txtUsername').val(),
            fname: $('#txtFname').val(),
            lname: $('#txtLname').val(),
            role: $('#txtRole').val(),
            phone: $('#txtPhone').val(),
            status: $('#txtStatus').val(),
            verify: $('#txtVerify').val(),
            email: $('#txtEmail').val(),
            hcode: $('#txtHcode').val()
        }

        var jxr = $.post(api_url + 'user?stage=update', param, function(){}, 'json')
                   .always(function(snap){
                        console.log(snap);
                        if(snap.status == 'Success'){
                            preload.hide()
                            Swal.fire({
                                icon: "success",
                                title: 'สำเร็จ',
                                text: 'ปรับปรุงข้อมูลสำเร็จ',
                                confirmButtonClass: 'btn btn-success',
                            })
                                
                        }else if(snap.status == 'Duplicate'){
                            preload.hide()
                            Swal.fire({
                                icon: "error",
                                title: 'เกิดข้อผิดพลาด',
                                text: 'ชื่อผู้ใช้งานนี้ถูกใช้แล้ว',
                                confirmButtonClass: 'btn btn-danger',
                            })
                        }else{
                            preload.hide()
                            Swal.fire({
                                icon: "error",
                                title: 'เกิดข้อผิดพลาด',
                                text: 'ไม่สามารถเพิ่มผู้ใช้ใหม่ได้',
                                confirmButtonClass: 'btn btn-danger',
                            })
                        }
                   })
    },
    check_add_form(){
        $check = 0
        $('.form-control').removeClass('is-invalid')
        $('.select-error').css({'border': 'none'});
        if($('#txtUsername').val() == ''){ $check++; $('#txtUsername').addClass('is-invalid') }
        if($('#txtFname').val() == ''){ $check++; $('#txtFname').addClass('is-invalid') }
        if($('#txtLname').val() == ''){ $check++; $('#txtLname').addClass('is-invalid') }
        if($('#txtRole').val() == ''){ $check++; $('#txtRole').addClass('is-invalid') }
        if($('#txtPhone').val() == ''){ $check++; $('#txtPhone').addClass('is-invalid') }
        if($('#txtStatus').val() == ''){ $check++; $('#txtStatus').addClass('is-invalid') }
        if($('#txtVerify').val() == ''){ $check++; $('#txtVerify').addClass('is-invalid') }
        if($('#txtPassword1').val() == ''){ $check++; $('#txtPassword1').addClass('is-invalid') }
        if($('#txtPassword2').val() == ''){ $check++; $('#txtPassword2').addClass('is-invalid') }
        if($('#txtPassword1').val() != $('#txtPassword2').val()){ $check++; $('#txtPassword2').addClass('is-invalid') }

        $('[data-required]').each(function() {
            if (!$(this).val()) {
                $check++;
              if ($(this).data('select2')) {
                $('.select-error').css({
                  'border': '1px solid #FF5B5C',
                  'border-radius': '4px'
                });
            }
        }});

        if($check != 0){
            Swal.fire(
                {
                  icon: "error",
                  title: 'คำเตือน',
                  text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                  confirmButtonClass: 'btn btn-danger',
                }
              )
              return false;
        }

        preload.show()

        var param = {
            uid: $('#txtCurrentUid').val(),
            username: $('#txtUsername').val(),
            fname: $('#txtFname').val(),
            lname: $('#txtLname').val(),
            role: $('#txtRole').val(),
            phone: $('#txtPhone').val(),
            status: $('#txtStatus').val(),
            verify: $('#txtVerify').val(),
            password: $('#txtPassword1').val(),
            email: $('#txtEmail').val(),
            hcode: $('#txtHcode').val()
        }

        var jxr = $.post(api_url + 'user?stage=create', param, function(){}, 'json')
                   .always(function(snap){
                        console.log(snap);
                        if(snap.status == 'Success'){
                            window.location = 'app-users-edit?id='+ snap.uid
                        }else if(snap.status == 'Duplicate'){
                            preload.hide()
                            Swal.fire({
                                icon: "error",
                                title: 'เกิดข้อผิดพลาด',
                                text: 'ชื่อผู้ใช้งานนี้ถูกใช้แล้ว',
                                confirmButtonClass: 'btn btn-danger',
                            })
                        }else{
                            preload.hide()
                            Swal.fire({
                                icon: "error",
                                title: 'เกิดข้อผิดพลาด',
                                text: 'ไม่สามารถเพิ่มผู้ใช้ใหม่ได้',
                                confirmButtonClass: 'btn btn-danger',
                            })
                        }
                   })

    },
    calculate_findate(){

        if($('#txtStartmonitor').val() == ''){
            $('#txtStartmonitor').addClass('is-invalid')
            return ;
        }
        var param = {
            csdate: $('#txtStartmonitor').val()
        }
        var jxr = $.post(api_url + 'core-api?stage=check2month', param, function(){})
                   .always(function(resp){
                       $('#txtEndmonitor').val(resp)
                   })
    }
}

$('#txtHcode').change(function(){
    $('#txtPrefix').val($('#txtHcode').select2('val'))
})