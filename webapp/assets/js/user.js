var user = {
    logout(){
        swal({    title: "ออกจากระบบ",
              text: "ท่านยืนยันการจบการทำงานและออกจากระบบหรือไม่",   
              type: "warning",   
              showCancelButton: true,   
              confirmButtonColor: "#DD6B55",   
              confirmButtonText: "ยืนยัน",   
              cancelButtonText: "ยกเลิก",   
              closeOnConfirm: false }, 
              function(){   
              window.location = '../controller/authen.php?stage=3'
              });
    }
}