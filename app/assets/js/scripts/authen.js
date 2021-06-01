var auth = {
  chk_login(){
    $check = 0;
    $('.form-control').removeClass('is-invalid')
    if($('#txtUsername').val() == ''){
      $check++; $('#txtUsername').addClass('is-invalid')
    }
  
    if($('#txtPassword').val() == ''){
      $check++; $('#txtPassword').addClass('is-invalid')
    }
    if($check != 0){ return false; }else{ return true; }
  },
  chk_register(){
    $check = 0;
    $('.form-control').removeClass('is-invalid')
    if($('#txtUsername').val() == ''){
      $check++; $('#txtUsername').addClass('is-invalid')
    }
  
    if($('#txtPassword1').val() == ''){
      $check++; $('#txtPassword1').addClass('is-invalid')
    }

    if($('#txtPassword2').val() == ''){
      $check++; $('#txtPassword2').addClass('is-invalid')
    }

    if($('#txtFname').val() == ''){
      $check++; $('#txtFname').addClass('is-invalid')
    }

    if($('#txtLname').val() == ''){
      $check++; $('#txtLname').addClass('is-invalid')
    }

    if($('#txtEmail').val() == ''){
      $check++; $('#txtEmail').addClass('is-invalid')
    }

    if($check != 0){ return false; }

    if($('#txtPassword1').val() != $('#txtPassword2').val()){
      $check++; $('#txtPassword2').addClass('is-invalid'); $('#txtPassword1').addClass('is-invalid')
    }

    if($check != 0){ return false; }
  }
}

$(function () {
    'use strict';
    
})