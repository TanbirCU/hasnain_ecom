  <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('/assets/front/lib/animate/animate.min.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/front/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('/assets/front/css/style.css')}}" rel="stylesheet">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    {{-- <style>
        .cart-badge {
            animation: bounce 1s infinite;
        }
        @keyframes bounce {
            0%   { transform: translateY(0); }
            30%  { transform: translateY(-6px); }
            50%  { transform: translateY(0); }
            70%  { transform: translateY(-3px); }
            100% { transform: translateY(0); }
        }
    </style> --}}
    @stack('front_css')
