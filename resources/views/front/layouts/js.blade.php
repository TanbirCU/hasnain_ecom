<!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('/assets/front/lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('/assets/front/lib/owlcarousel/owl.carousel.min.js')}}"></script>

    <!-- Contact Javascript File -->
    <script src="{{asset('/assets/front/mail/jqBootstrapValidation.min.js')}}"></script>
    <script src="{{asset('/assets/front/mail/contact.js')}}"></script>


    {{-- SweetAlert & AJAX --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- toaster --}}

    {{-- Toaster Start --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    {{-- Toaster End --}}
    <script>

        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

         @if(Session::has('message'))
            var type = "{{ Session::get('alert-type', 'success') }}";
            switch(type){
                case 'success':
                    toastr.success("{{ Session::get('message') }}");
                    break;
                case 'info':
                    toastr.info("{{ Session::get('message') }}");
                    break;
                case 'warning':
                    toastr.warning("{{ Session::get('message') }}");
                    break;
                case 'error':
                    toastr.error("{{ Session::get('message') }}");
                    break;
            }
        @endif

    </script>

    {{-- toaster end --}}
    <!-- Template Javascript -->
    <script src="{{asset('/assets/front/js/main.js')}}"></script>


    @stack('js')
