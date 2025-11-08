
<!-- DataTables -->
<link href="{{ asset('/') }}assets/admin/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="{{ asset('/') }}assets/admin/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->
<link href="{{ asset('/') }}assets/admin/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

  {{-- Toaster Start --}}
<!-- Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>


{{-- sweetalert start --}}
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.17/dist/sweetalert2.min.css" rel="stylesheet">
{{-- sweetalert end --}}

 <!-- Summernote css -->
 <link href="{{ asset('/') }}assets/admin/libs/summernote/summernote-bs4.min.css" rel="stylesheet" type="text/css" />
  <!-- Summernote css -->
  {{-- <link href="assets/libs/summernote/summernote-bs4.min.css" rel="stylesheet" type="text/css" /> --}}

 {{-- dropzone start --}}
 {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" rel="stylesheet"> --}}
{{-- <link href="{{asset('/')}}assets/libs/dropzone/min/dropzone.min.css" rel="stylesheet" type="text/css" /> --}}


 {{-- dropzone end --}}

 {{-- select2 --}}
  <link href="{{ asset('/') }}assets/admin/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
 {{-- select2 --}}
 {{-- @include('./custom_css') --}}
@stack('css')
