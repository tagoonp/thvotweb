// var dm = 'http://localhost/rmis5/staff/'
// var dm = 'http://rmis2.medicine.psu.ac.th/rmis/'
var preload = {
  init:function(){
    var load_element = '<div class="loadelement">' +
                          '<div class="loadelement_1">' +
                            '&nbsp;' +
                          '</div>' +
                          '<div class="loadelement_2">' +
                            '<img src="https://thvot.com/thvotweb/app/core/tools/preload.js/img/oval.svg" width="100%" />' +
                          '</div>' +
                        '</div>'
    document.write(load_element)
  },
  show: function(){
    $('.loadelement').fadeIn()
  },
  hide: function(){
    $('.loadelement').fadeOut()
  }
}

preload.init()
