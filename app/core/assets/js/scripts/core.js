// var api_url = 'http://localhost/thvotweb/app/api/'

var api_url = 'https://thvot.com/thvotweb/app/api/'

function initMap() {
    // const myLatlng = { lat: -25.363, lng: 131.044 };
    // const map = new google.maps.Map(document.getElementById("map"), {
    //   zoom: 4,
    //   center: myLatlng,
    // });
    // // Create the initial InfoWindow.
    // let infoWindow = new google.maps.InfoWindow({
    //   content: "Click the map to get Lat/Lng!",
    //   position: myLatlng,
    // });
    // infoWindow.open(map);
    // // Configure the click listener.
    // map.addListener("click", (mapsMouseEvent) => {
    //   // Close the current InfoWindow.
    //   infoWindow.close();
    //   // Create a new InfoWindow.
    //   infoWindow = new google.maps.InfoWindow({
    //     position: mapsMouseEvent.latLng,
    //   });
    //   infoWindow.setContent(
    //     JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)
    //   );
    //   infoWindow.open(map);
    // });

    getLocation()
  }

  function getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition);
    } else {
      alert("Geolocation is not supported by this browser.");
    }
  }

  function showPosition(position) {
    var lat = position.coords.latitude;
    var lng = position.coords.longitude;
    
    preload.show()

    var param = {
        lat: lat,
        lng: lng,
        uid: window.localStorage.getItem('thvot_patient_web_uid')
    }

    var jxr = $.post(api_url + 'authen-api?stage=savelocation2', param, function(){}, 'json')
                   .always(function(snap){
                       preload.hide()
                       if(snap.status == 'Success'){
                            Swal.fire({
                                icon: "success",
                                title: 'บันทึกสำเร็จ',
                                text: 'พิกัดบ้านของท้านถูกบันทึกเรียบร้อยแล้ว',
                                confirmButtonClass: 'btn btn-danger',
                            })
                       }else{
                        Swal.fire({
                            icon: "error",
                            title: 'เกิดข้อผิดพลาด',
                            text: 'ไม่สามารถบันทึกพิกัดบ้านของท่านได้ กรุุณาตรวจสอบเครือข่ายและลองใหม่อีกครั้ง',
                            confirmButtonClass: 'btn btn-danger',
                        })
                       }
                   })
  }