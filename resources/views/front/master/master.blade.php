<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

   @include('front/layouts/css')
</head>

<body>

    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row bg-secondary py-1 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center h-100">
                    <a class="text-body mr-3" href="">About</a>
                    <a class="text-body mr-3" href="{{ route('contact') }}">Contact</a>
                    <a class="text-body mr-3" href="">Help</a>
                    <a class="text-body mr-3" href="">FAQs</a>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">
                            My Account
                        </button>

                        <div class="dropdown-menu dropdown-menu-right">

                            @if(Auth::check())
                                <a class="dropdown-item" href="">Profile</a>
                                <a class="dropdown-item" href="{{ route('user_logout') }}">Log Out</a>
                            @else
                                <a class="dropdown-item" href="{{ route('user_login') }}">Sign in</a>
                                <a class="dropdown-item" href="{{ route('user.registration') }}">Sign up</a>
                            @endif
                        </div>
                    </div>

                    <div class="btn-group mx-2">
                        <button type="button" cla                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">টাকা</button>
                        {{-- <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">EUR</button>
                        </div> --}}
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">BAN</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">ENG</button>
                        </div>
                    </div>
                </div>
                <div class="d-inline-flex align-items-center d-block d-lg-none">
                    <a href="" class="btn px-0 ml-2">
                        <i class="fas fa-heart text-dark"></i>
                        <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">0</s<a href="" class="btn px-0 ml-2">
                        <i class="fas fa-shopping-cart text-dark"></i>
                        <span class="cart-count-mobile badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">0</span>
                    </a>
}-bottom: 2px;">0</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
            <div class="col-lg-4">
                <a href="{{ route('home') }}" class="text-decoration-none">
                    <span class="h1 text-uppercase text-primary bg-dark px-2">Sole</span>
                    <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">Bazar</span>
                </a>
            </div>
            <div class="col-lg-4 col-6 text-left">
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for products">
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            @php
                $nav = \App\Models\NavIcon::first();
            @endphp
            <div class="col-lg-4 col-6 text-right">
                <p class="m-0">Customer Service</p>
                <h5 class="m-0">{{ $nav->phone ?? '01947689192' }}</h5>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    @php
        $categories = \App\Models\Category::where('status', 1)->get();
    @endphp
    <div class="container-fluid bg-dark mb-30">
        <div class="row px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                    <h6 class="text-dark m-0"><i class="fa fa-bars mr-2"></i>Categories</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                    <div class="navbar-nav w-100">
                        {{-- <div class="nav-item dropdown dropright">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Dresses <i class="fa fa-angle-right float-right mt-1"></i></a>
                            <div class="dropdown-menu position-absolute rounded-0 border-0 m-0">
                                <a href="" class="dropdown-item">Men's Dresses</a>
                                <a href="" class="dropdown-item">Women's Dresses</a>
                                <a href="" class="dropdown-item">Baby's Dresses</a>
                            </div>
                        </div> --}}
                        @foreach($categories as $category)
                            <a href="{{ route('shop', ['category_id' => $category->id]) }}"
                            class="nav-item nav-link">
                            {{ $category->name }}
                            </a>
                        @endforeach

                        {{-- <a href="" class="nav-item nav-link">Jeans</a>
                        <a href="" class="nav-item nav-link">Swimwear</a>
                        <a href="" class="nav-item nav-link">Sleepwear</a>
                        <a href="" class="nav-item nav-link">Sportswear</a>
                        <a href="" class="nav-item nav-link">Jumpsuits</a>
                        <a href="" class="nav-item nav-link">Blazers</a>
                        <a href="" class="nav-item nav-link">Jackets</a>
                        <a href="" class="nav-item nav-link">Shoes</a> --}}
                    </div>
                </nav>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                    <a href="{{ route('home') }}" class="text-decoration-none d-block d-lg-none">
                        <span class="h1 text-uppercase text-dark bg-light px-2">Sole</span>
                        <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1">Bazar</span>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="{{ route('home') }}" class="nav-item nav-link active">Home</a>
                            <a href="{{ route('shop') }}" class="nav-item nav-link">Shop</a>
                            {{-- <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages <i class="fa fa-angle-down mt-1"></i></a>
                                <div class="dropdown-menu bg-primary rounded-0 border-0 m-0">
                                    <a href="cart.html" class="dropdown-item">Shopping Cart</a>
                                    <a href="checkout.html" class="dropdown-item">Checkout</a>
                                </div>
                            </div> --}}
           <a href="{{ route('orders') }}" class="nav-item nav-link">Orders</a>
                                {{-- <a class="nav-item nav-link" href="{{ route('user_logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    LogOut
                                </a>

                                <form id="logout-form" action="{{ route('user_logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form> --}}

                            {{-- @else
                                <a href="{{ route('user.registration') }}" class="nav-item nav-link">Registration</a>
                                <a href="{{ route('user_login') }}" class="nav-item nav-link">Login</a> --}}
                            @endif

                        </div>
                       <div class="navbar-nav ml-auto py-0 d-none d-lg-block">

                            <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                                <div class="btn-group">
                                    <a href="javascript:void(0)" class="btn px-0 ml-3 dropdown-toggle" data-toggle="dropdown">
                                        <i class="fas fa-shopping-cart text-primary"></i>
                                        <span class="badge text-secondary border border-secondary rounded-circle cart-count" style="padding-bottom: 2px;">
                                            0
                                        </span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right p-2" style="min-width: 300px;">
                                        <div class="cart-dropdown d-lg-none" style="display:none; position:absolute; right:10px; background:#fff; width:260px; z-index:999; padding:10px; border:1px solid #ddd;">
                                        <ul id="cart-items-list-mobile" class="list-unstyled m-0 p-0"></ul>
                                        <hr>
                                        <a href="{{ route('cart_view') }}" class="btn btn-primary btn-block">View Cart</a>
                                    </div>
           </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Navbar End -->


    @yield('content')

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-secondary mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <h5 class="text-secondary text-uppercase mb-4">Get In Touch</h5>
                <p class="mb-4">{{ $nav->footer_description ?? 'Get Your All Paikeri Clothes' }}</p>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>{{ $nav->footer_address ?? '411/2, Shenpara Parabat,  Mirpur - 13, Dhaka -1216' }}</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>{{ $nav->footer_email ?? 'mdhasnain6@yahoo.com' }}</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>{{ $nav->phone ?? '01947689192' }}</p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="text-secondary text-uppercase mb-4">Quick Shop</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                            <a class="text-secondary" href="{{ route('contact') }}"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="text-secondary text-uppercase mb-4">My Account</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                            <a class="text-secondary" href="{{ route('contact') }}"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="text-secondary text-uppercase mb-4">Newsletter</h5>
                        <p>Duo stet tempor ipsum sit amet magna ipsum tempor est</p>
                        <form action="">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Your Email Address">
                                <div class="input-group-append">
                                    <button class="btn btn-primary">Sign Up</button>
                                </div>
                            </div>
                        </form>
                        <h6 class="text-secondary text-uppercase mt-4 mb-3">Follow Us</h6>
                        <div class="d-flex">
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a class="btn btn-primary btn-square" href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row border-top mx-xl-5 py-4" style="border-color: rgba(256, 256, 256, .1) !important;">
            <div class="col-md-6 px-xl-0">
                <p class="mb-md-0 text-center text-md-left text-secondary">
                    &copy; <a class="text-primary" href="#">Domain</a>. All Rights Reserved. Designed
                    by
                    <a class="text-primary" href="https://htmlcodex.com">Tanvir Ahmed</a>
                    <br>Distributed By: <a href="https://themewagon.com" target="_blank">Tanvir</a>
                </p>
            </div>
            <div class="col-md-6 px-xl-0 text-center text-md-right">
                <img class="img-fluid" src="img/payments.png" alt="">
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    @include('front/layouts/js')
    <script>
        $(document).on("click", ".cart-icon", function () {
            $(".cart-dropdown").toggle();
        });
        $(document).ready(function() {
            $(document).on('click', '    $(".dropdown-menu, .cart-dropdown").toggle();) {
                    let id = $(this).closest('li').data('id');

                    $.ajax({
                        url: "{{ route('cart.remove') }}",
                        type: "GET",
                        data: {
                            _token: "{{ csrf_token() }}",
                            product_id: id
                        },
                        success: function(res) {
                            if(res.success) {
                                updateCartDropdown(res.cart_items, res.cart_count);
                            }
                        },
                        error: function(xhr) {
                            console.error('Remove cart item error:', xhr.responseText);
                        }
                    });
                });


        });
         function updateCartDropdown(cartItems, cartCount) {
            let $list = $('#cart-items-list');
            $list.empty();

            $.each(cartItems, function(id, item) {
                let li = `
                    <li class="d-flex justify-content-between align-items-center mb-2 p-2 border-bottom" data-id="${id}">
                        <span><strong>${item.name}</strong> <span class="text-muted">x ${item.qty}</span></span>
                        <button class="btn btn-sm btn-danger remove-cart-item">&times;</button>
                    </li>
                `;
                $list.append(li);
            });

            $('.cart-count').text(cartCount);
        }
         @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}"
            });
        @endif

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}"
            });
        @endif

    </script>


</body>

</html>
