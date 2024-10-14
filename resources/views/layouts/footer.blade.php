<script src="{{ asset('assets/js/vendors/jquery/jquery.min.js')}}"></script>
<!-- bootstrap js-->
<script src="{{ asset('assets/js/vendors/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('assets/js/vendors/bootstrap/dist/js/popper.min.js')}}"></script>
<!--fontawesome-->
<script src="{{ asset('assets/js/vendors/font-awesome/fontawesome-min.js')}}"></script>
<!-- feather-->
<script src="{{ asset('assets/js/vendors/feather-icon/feather.min.js')}}"></script>
<script src="{{ asset('assets/js/vendors/feather-icon/custom-script.js')}}"></script>
<!-- sidebar -->
<script src="{{ asset('assets/js/sidebar.js')}}"></script>
<!-- height_equal-->
<script src="{{ asset('assets/js/height-equal.js')}}"></script>
<!-- config-->
<script src="{{ asset('assets/js/config.js')}}"></script>
<!-- apex-->
<!-- scrollbar-->
<script src="{{ asset('assets/js/scrollbar/simplebar.js')}}"></script>
<script src="{{ asset('assets/js/scrollbar/custom.js')}}"></script>
<!-- slick-->
<script src="{{ asset('assets/js/slick/slick.min.js')}}"></script>
<script src="{{ asset('assets/js/slick/slick.js')}}"></script>
<!-- data_table-->
<script src="{{ asset('assets/js/js-datatables/datatables/jquery.dataTables.min.js')}}"></script>
<!-- page_datatable-->
<script src="{{ asset('assets/js/js-datatables/datatables/datatable.custom.js')}}"></script>
<!-- page_datatable1-->
<script src="{{ asset('assets/js/js-datatables/datatables/datatable.custom1.js')}}"></script>
<!-- page_datatable-->
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js')}}"></script>
<!-- theme_customizer-->
<script src="{{ asset('assets/js/theme-customizer/customizer.js')}}"></script>
<!-- tilt-->
<script src="{{ asset('assets/js/animation/tilt/tilt.jquery.js')}}"></script>
<!-- page_tilt-->
<script src="{{ asset('assets/js/animation/tilt/tilt-custom.js')}}"></script>
<!-- dashboard_1-->
<!-- custom script -->
<script src="{{ asset('assets/js/script.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script type="text/javascript" src="{{ asset('assets/css/richtexteditor/rte.js') }}"></script>
<script type="text/javascript" src='{{ asset('assets/css/richtexteditor/all_plugins.js') }}'></script>

<script>
    toastr.options = {
  "closeButton": true,
  "newestOnTop": false,
  "progressBar": true,
  "positionClass": "toast-top-center",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}


</script>

 @yield('page_script')



</body>
</html>
