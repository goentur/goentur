function cekKoneksiInternet() {
     if (navigator.onLine) {
          return true;
     } else {
          return false;
     }
}
function unLoading(sender, args){
     $.unblockUI();
}
//Center the element
$.fn.center = function () {
     this.css("position", "absolute");
     this.css("top", ($(window).height() - this.height()) / 2 + $(window).scrollTop() + "px");
     this.css("left", ($(window).width() - this.width()) / 2 + $(window).scrollLeft() + "px");
     return this;
}
//blockUI
function loading() {
     $.blockUI({
          css: {
               backgroundColor: 'transparent',
               border: 'none'
          },
               message: '<div class="text-primary spinner-border" style="width: 3rem; height: 3rem;" role="status"><span class="sr-only">Loading...</span> </div><h3 class="text-primary">LOADING...</h3>',
               baseZ: 1500,
               overlayCSS: {
               backgroundColor: '#FFFFFF',
               opacity: 0.7,
               cursor: 'wait'
          }
     });
     $('.blockUI.blockMsg').center();
}//end Blockui   
function alert_error(title, text) {
     Command: toastr["error"](text, title);
     toastr.options = {
          closeButton: false,
          debug: false,
          newestOnTop: false,
          progressBar: false,
          positionClass: "toast-top-right",
          preventDuplicates: false,
          onclick: null,
          showDuration: "300",
          hideDuration: "1000",
          timeOut: "5000",
          extendedTimeOut: "1000",
          showEasing: "easeOutBounce",
          hideEasing: "easeInBack",
          showMethod: "slideDown",
          hideMethod: "slideUp",
     };
     unLoading();
}

function alert_sukses(title, text) {
     Command: toastr["success"](text, title);
     toastr.options = {
          closeButton: false,
          debug: false,
          newestOnTop: false,
          progressBar: false,
          positionClass: "toast-top-right",
          preventDuplicates: false,
          onclick: null,
          showDuration: "300",
          hideDuration: "1000",
          timeOut: "5000",
          extendedTimeOut: "1000",
          showEasing: "easeOutBounce",
          hideEasing: "easeInBack",
          showMethod: "slideDown",
          hideMethod: "slideUp",
     };
     unLoading();
}
function formatRupiah(angka, prefix) {
     var number_string = angka.replace(/[^,\d]/g, "").toString(),
          split = number_string.split(","),
          sisa = split[0].length % 3,
          rupiah = split[0].substr(0, sisa),
          ribuan = split[0].substr(sisa).match(/\d{3}/gi);
     if (ribuan) {
          separator = sisa ? "." : "";
          rupiah += separator + ribuan.join(".");
     }
     rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
     return prefix == undefined ? rupiah : rupiah ? "" + rupiah : "";
}
$(document).ready(function() {
     // document.body.style.zoom = "80%"
     $(".select2").select2();
     $(".tanggal-umum").datepicker({
         language: "id",
         format: "dd-mm-yyyy",
         autoclose: true,
         todayHighlight: true,
         daysOfWeekHighlighted: "0,6",
         orientation: "bottom",
     });
	$(".bulan-umum").datepicker({
	     language: "id",
	     format: "mm-yyyy",
	     autoclose: true,
	     viewMode: "months", 
	     minViewMode: "months",
	     endDate: "m",
	});
	$(".rupiah").on("keyup", function () {
		$(".rupiah").val(formatRupiah($(this).val(), ""));
	});
});