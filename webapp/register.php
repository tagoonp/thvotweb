<?php
require("../../database_config/thvot/config.inc.php");
require('./configuration/configuration.php');
require('./configuration/database.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <title>สมัครใช้งานระบบติดตามการรับประทานยา :: TH-VOT</title>

    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/fontawesome/css/all.min.css" >
    <link rel="stylesheet" href="./node_modules/sweetalert/dist/sweetalert.css">
    <link rel="stylesheet" href="./node_modules/preload.js/dist/css/preload.css">
    <link rel="stylesheet" href="./assets/css/style.css?v=<?php echo filemtime('./assets/css/style.css'); ?>" type="text/css">
    
</head>
<body>

    <div class="main-content pl-4 pr-4 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-6 offset-sm-3">

                <nav class="navbar navbar-light pl-0 pr-0 pb-4 pt-4">
                        <a class="navbar-brand" href="./">
                            <img src="https://thvot.com/img/thvot-web-logo.png" width="120" alt="">
                        </a>
                    </nav>
                    
                    <a href="index.php" class="text-dark">
                        <i class="fas fa-chevron-left"></i> กลับหน้าเข้าสู่ระบบ
                    </a>

                    <div class="row pt-4">
                        <div class="col-12">
                            <h1 class="mb-2">สมัครใช้งานระบบ</h1>
                            <h4 class="text-muted mb-0">สำหรับผู้ดูแลภาพรวมการติดตาม</h4>
                        </div>
                        <div class="col-12 pt-3">
                            <form action="./controller/authen.php?stage=2" method="post" id="registerForm">
                                <hr>
                                <h5>ข้อมูลผู้ใช้งาน</h5>
                                <div class="row">
                                    <div class="form-group col-12 col-sm-6">
                                        <label for="">ชื่อ : <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" require id="txtFname" name="txtFname" autofocus>
                                    </div>
                                    <div class="form-group col-12 col-sm-6">
                                        <label for="">นามสกุล : <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" require id="txtLname" name="txtLname" >
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-12 col-sm-6">
                                        <label for="">E-mail address : <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" require id="txtEmail" name="txtEmail" >
                                    </div>
                                    <div class="form-group col-12 col-sm-6">
                                        <label for="">หมายเลขโทรศัพท์ : <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" require id="txtPhone" name="txtPhone">
                                    </div>
                                </div>
                                <hr>
                                <h5>บัญชีสำหรับเข้าใช้งานระบบ</h5>
                                <div class="form-group">
                                    <label for="">สร้างบัญชีผู้ใช้งาน (Username) : <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" require id="txtUsername" name="txtUsername" >
                                </div>
                                <div class="row">
                                    <div class="form-group  col-12 ">
                                        <label for="">ตั้งรหัสผ่าน (ขั้นต่ำ 8 ตัวอักษร) : <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" require id="txtPassword1" name="txtPassword1">
                                    </div>
                                    <div class="form-group col-12 ">
                                        <label for="">ยืนยันรหัสผ่าน : <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" require id="txtPassword2" name="txtPassword2">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">รหัสยืนยันการลงทะเบียน (Verification code) : <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" require id="txtCode" name="txtCode" >
                                    <small id="emailHelp" class="form-text text-muted th200">กรอกรหัสที่ได้จาก E-mail การตอบรับการสมัครใช้งาน</small>
                                </div>
                                <div class="form-group pt-3">
                                    <button class="btn btn-primary th200" type="button" onclick="checkRegister()">ลงทะเบียน</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="./node_modules/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="./node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript" src="./node_modules/preload.root.js/dist/js/preload.js"></script>

    <script>

        $(document).ready(function(){
            preload.hide();
        })

        $(function(){

        })

        function checkRegister(){
            $check = 0
            $('.form-control').removeClass('is-invalid')
            if($('#txtFname').val() == ''){
                $('#txtFname').addClass('is-invalid')
                $check++;
            }
            if($('#txtLname').val() == ''){
                $('#txtLname').addClass('is-invalid')
                $check++;
            }
            if($('#txtEmail').val() == ''){
                $('#txtEmail').addClass('is-invalid')
                $check++;
            }
            if($('#txtPhone').val() == ''){
                $('#txtPhone').addClass('is-invalid')
                $check++;
            }
            if($('#txtCode').val() == ''){
                $('#txtCode').addClass('is-invalid')
                $check++;
            }
            if($('#txtUsername').val() == ''){
                $('#txtUsername').addClass('is-invalid')
                $check++;
            }
            if($('#txtPassword1').val() == ''){
                $('#txtPassword1').addClass('is-invalid')
                $check++;
            }
            if($('#txtPassword2').val() == ''){
                $('#txtPassword2').addClass('is-invalid')
                $check++;
            }
            if( $('#txtPassword1').val() != $('#txtPassword2').val() ){
                $('#txtPassword2').addClass('is-invalid')
                $('#txtPassword1').addClass('is-invalid')
                $check++;
            }
            if($check != 0){
                return false;
            }

            preload.show()
            var jxr = $.post('https://thvot.com/app-api/api-check-code.php?stage=2', {code: $('#txtCode').val()}, function(){})
                       .always(function(resp){
                           console.log(resp);
                           if(resp == 'Fail'){
                                preload.hide()
                                swal("คำเตือน", "รหัสยืนยันการลงทะเบียนไม่สามารถใช้งานได้", "error")
                                $check++;
                           }else{
                             var param = {
                                 username : $('#txtUsername').val(),
                                 email: $('#txtEmail').val()
                             }
                             var jxr2 = $.post('https://thvot.com/app-api/api-check-account.php?stage=1', param, function(){})
                                        .always(function(resp2){
                                            console.log(resp2);
                                            if(resp2 == ''){
                                                $('#registerForm').submit()
                                            }else{
                                                preload.hide()
                                                swal("คำเตือน", "ชื่อบัญชีผู้ใช้งานหรืออีเมลนี้เคยถูกใช้งานแล้ว", "error")
                                                $check++;
                                            }
                                        })
                           }
                       })
            if($check != 0){
                return false;
            }
        }
    </script>
</body>
</html>