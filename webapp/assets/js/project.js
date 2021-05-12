var project = {
    setSession(pid, nextpage){
        window.location = '../controller/project.php?stage=3&pid=' + pid + '&next=' + nextpage
    },
    delete(pid){
        swal({    
            title: "คำเตือน",
            text: "หากทำการลบโครงการแล้วจะไม่สามารถนำโครงการดังกล่าวและข้อมูลที่เกี่ยวข้องกลับมาได้อีก",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "ยืนยัน",   
            cancelButtonText: "ยกเลิก",   
            closeOnConfirm: true 
        }, 
        function(){   
            preload.show()
            var param = {
                project_id: pid
            }
            var jxr = $.post('../controller/project.php?stage=2', param, function(){})
                       .always(function(resp){
                           if(resp == 'Success'){
                                setTimeout(function(){
                                    preload.hide();
                                    swal({    title: "สำเร็จ",
                                    text: "โครงการที่ท่านเลือกถูกลบเรียบร้อยแล้ว",   
                                    type: "success",   
                                    showCancelButton: false,   
                                    confirmButtonColor: "green",   
                                    confirmButtonText: "รับทราบ",   
                                    closeOnConfirm: true }, 
                                    function(){   
                                    window.location.reload()
                                    });
                                }, 1000)
                           }else{
                            setTimeout(function(){
                                preload.hide();
                                swal("เกิดข้อผิดพลาด", "ไม่สามารถลบข้อมูลได้", "error")
                            }, 1000)
                           }
                       })

        });
    
        
    }
}