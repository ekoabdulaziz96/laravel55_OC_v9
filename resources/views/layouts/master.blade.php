
<!DOCTYPE html>
<html>
@include('layouts/partials/_head')
@yield('stylesheet')
<body class="hold-transition skin-green sidebar-mini" style="padding:0px !important;">
<div class="wrapper">

@include('layouts/partials/_header')

  <!-- Left side column. contains the logo and sidebar -->
@include('layouts/partials/_sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
         @yield('content-header')
      
    </section>
{{-- @include('layouts/partials/_content-header') --}}

    <!-- Main content -->
    <section class="content">
    {{-- profil modal --}}
    @include('layouts/profil/_modal')
    
    @yield('content-body')

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



  {{-- //footer --}}
@include('layouts/partials/_footer')


  <!-- Control Sidebar -->
{{-- @include('layouts/partials/_sidebar-control') --}}

</div>
<!-- ./wrapper -->



<!-- jQuery 3 -->
@include('layouts/partials/_script')

{{-- profil script--}}
@include('layouts/profil/_script')

@yield('script')
</body>
</html>
