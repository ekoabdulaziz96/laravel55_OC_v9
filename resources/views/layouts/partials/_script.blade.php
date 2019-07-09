
   {{-- javascript --}}
   <!-- jQuery 3 -->
<script src="{{ asset('AdminLTE/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- DataTables -->
<script src="{{ asset('AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<!-- SlimScroll -->
<script src="{{ asset('AdminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{ asset('AdminLTE/bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('AdminLTE/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('AdminLTE/dist/js/demo.js')}}"></script>
{{-- <script src="{{ asset('assets/jquery/jquery-1.12.4.min.js') }}"></script> --}}
<!-- iCheck 1.0.1 -->
<script src="{{ asset('AdminLTE/plugins/iCheck/icheck.min.js')}}"></script>

<!-- bootstrap datepicker -->
<script src="{{ asset('AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<!-- bootstrap time picker -->
<script src="{{ asset('AdminLTE/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<!-- Select2 -->
{{-- <script src="{{ asset('AdminLTE/bower_components/select2/dist/js/select2.full.min.js')}}"></script> --}}

{{-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx --}}
   {{-- SweetAlert2 --}}
<script src="{{ asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('formhelper/bootstrap-formhelpers.min.js')  }}"></script>
<script src="{{ asset('select/bootstrap-select.min.js')  }}"></script>

<script src="{{ asset('assets/bootstrap/js/ie-emulation-modes-warning.js') }}"></script>

{{-- Validator --}}
<script src="{{ asset('assets/validator/validator.min.js') }}"></script>

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="{{ asset('assets/bootstrap/js/ie10-viewport-bug-workaround.js') }}"></script>

<!-- date-range-picker -->
<script src="{{ asset('AdminLTE/bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{ asset('AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>





<script>
	 $(function () {
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
    //Date picker
    $('.formdatepicker').datepicker({  format: 'yyyy-mm-dd',
      autoclose: true
    })

    //Timepicker
    $('input.timepicker').timepicker({
            showMeridian: false,
            // showInputs: false

        });
    //Initialize Select2 Elements
    // $('.select2').select2()

  	});
	
</script>
