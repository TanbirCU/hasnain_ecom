@extends('front/master/master')
@section('title')
     Checkout Product | Sole Bazer
@endsection
@section('content')

    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="{{ route('home') }}">Home</a>
                    <a class="breadcrumb-item text-dark" href="{{ route('shop') }}">Shop</a>
                    <span class="breadcrumb-item active">Checkout</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Checkout Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Billing Address</span></h5>
                <div class="bg-light p-30 mb-5">
                    <form id="checkout-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>নাম</label>
                                <input class="form-control" type="text" name="name" placeholder="John" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>মোবাইল নম্বর</label>
                                <input class="form-control" type="text" name="mobile" placeholder="01728......." required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>ই-মেইল</label>
                                <input class="form-control" type="email" name="email" placeholder="example@email.com" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>জেলা</label>
                                <input class="form-control" type="text" name="district" placeholder="জেলা" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>উপজেলা</label>
                                <input class="form-control" type="text" name="upzilla" placeholder="উপজেলা" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>ইউনিয়ন</label>
                                <input class="form-control" type="text" name="union" placeholder="ইউনিয়ন" required>
                            </div>
                           
                            <div class="col-md-12 form-group">
                                <label>অতিরিক্ত ঠিকানা</label>
                                <input class="form-control" type="text" name="extra_address" placeholder="অতিরিক্ত ঠিকানা" required style="height: 100px;">
                            </div>
                            
                           
                            
                        </div>

                        <!-- Hidden fields for cart data -->
                        <input type="hidden" name="cart_items" value="{{ json_encode($cartItems) }}">
                        <input type="hidden" name="grand_total" value="{{ $grandTotal }}">
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Order Total</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-3">
                        <h6 class="mb-3">Products</h6>
                        @foreach($cartItems as $item)
                        <div class="d-flex justify-content-between mb-2">
                            <p class="mb-0">
                                <small>
                                    @if(isset($item['image']))
                                        <img src="{{ $item['image'] }}" alt="" style="width: 30px; height: 30px; object-fit: cover; margin-right: 5px;">
                                    @endif
                                    {{ $item['name'] }} x {{ $item['quantity'] }}
                                </small>
                            </p>
                            <p class="mb-0">ট {{ number_format($item['total'], 2) }}</p>
                        </div>
                        @endforeach
                    </div>
                   
                    <div class="pt-3">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Grand Total</h5>
                            <h5>ট {{ number_format($grandTotal, 2) }}</h5>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Payment</span></h5>
                    <div class="bg-light p-30">
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment_method" id="cash_on_delivery" value="cash_on_delivery" checked>
                                <label class="custom-control-label" for="cash_on_delivery">Cash on Delivery</label>
                            </div>
                        </div>
                        
                        <button type="button" class="btn btn-block btn-primary font-weight-bold py-3 place-order-btn">
                            Place Order
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Checkout End -->

@endsection

@push('js')
<script>
$(document).on('click', '.place-order-btn', function(e) {
    e.preventDefault();
    
    let $btn = $(this);
    let $form = $('#checkout-form');
    
    // Validate form
    if (!$form[0].checkValidity()) {
        $form[0].reportValidity();
        return;
    }
    
    // Show loading
    let originalText = $btn.html();
    $btn.html('<i class="fa fa-spinner fa-spin"></i> Processing...').prop('disabled', true);
    
    // Get form data
    let formData = $form.serialize();
    formData += '&payment_method=' + $('input[name="payment_method"]:checked').val();
    
    // Submit order
    $.ajax({
        url: "{{ route('order.place') }}",
        type: "POST",
        data: formData,
        success: function(res) {
            if (res.success) {
                alert('Order placed successfully!');
                window.location.href = res.redirect_url || "{{ route('home') }}";
            } else {
                alert(res.message || 'Something went wrong!');
                $btn.html(originalText).prop('disabled', false);
            }
        },
        error: function(xhr) {
            console.error(xhr);
            alert('Error placing order. Please try again.');
            $btn.html(originalText).prop('disabled', false);
        }
    });
});
</script>
@endpush