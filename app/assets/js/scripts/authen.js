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
  },
  chk_register_dot(){
    $check = 0;
    $('.form-control').removeClass('is-invalid')
    $('.select-error').css({'border': 'none'});

    if($('#txtHn').val() == ''){
      $check++; $('#txtHn').addClass('is-invalid')
    }
  
    if($('#txtPhone').val() == ''){
      $check++; $('#txtPhone').addClass('is-invalid')
    }

    if($('#txtFname').val() == ''){
      $check++; $('#txtFname').addClass('is-invalid')
    }

    if($('#txtLname').val() == ''){
      $check++; $('#txtLname').addClass('is-invalid')
    }

    if($('#txtProvince').val() == ''){
      $check++; $('#txtProvince').addClass('is-invalid')
    }

    if($('#txtDist').val() == ''){
      $check++; $('#txtDist').addClass('is-invalid')
    }

    if($('#txtSubdist').val() == ''){
      $check++; $('#txtSubdist').addClass('is-invalid')
    }

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

    if($check != 0){ return false; }
  }
}

$(function () {
    'use strict';
    $('#txtProvince').change(function(){
      $('#txtDist').empty()
      $('#txtSubdist').empty()

      $('#txtDist').append('<option value="">-- เลือกอำเภอ --</option>')
      $('#txtSubdist').append('<option value="">-- เลือกตำบล --</option>')

      var jxt = $.post('./api/core-api?stage=district', {province : $('#txtProvince').val()}, function(){}, 'json')
              .always(function(snap){
                if(snap.status == 'Success'){
                  snap.data.forEach(i => {
                    $('#txtDist').append('<option value="' + i.Ampur + '">' + i.Name + '</option>')
                  });
                }
              })
    })

    $('#txtDist').change(function(){
      $('#txtSubdist').empty()
      $('#txtSubdist').append('<option value="">-- เลือกตำบล --</option>')

      var jxt = $.post('./api/core-api?stage=subdistrict', {province : $('#txtProvince').val(), dist: $('#txtDist').val() }, function(){}, 'json')
              .always(function(snap){
                console.log(snap);
                if(snap.status == 'Success'){
                  snap.data.forEach(i => {
                    $('#txtSubdist').append('<option value="' + i.Tumbon + '">' + i.Name + '</option>')
                  });
                }
              })
    })
})