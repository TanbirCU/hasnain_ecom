@extends('front/master/master')
@section('title')
    Product Cart | Sole Bazer
@endsection
@section('content')

    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="{{ route('home') }}">Home</a>
                    <a class="breadcrumb-item text-dark" href="{{ route('shop') }}">Shop</a>
                    <span class="breadcrumb-item active">Shopping Cart</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach($cart as $id => $item)
                            @php
                                $product = \App\Models\Product::find($item['product_id']);
                                $price = $product ? $product->selling_price : 0;
                                $total = $price * $item['qty'];
                            @endphp
                            @if($product)
                            <tr data-id="{{ $id }}">
                                <td class="align-middle">
                                    <img src="{{ $product->image ?? 'img/product-1.jpg' }}" alt="" style="width: 50px;">
                                    {{ $product->name }}
                                </td>
                                <td class="align-middle">ট {{ number_format($price, 2) }}</td>
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-minus"><i class="fa fa-minus"></i></button>
                                        </div>
                                        <input 
                                                type="text" 
                                                class="form-control form-control-sm bg-secondary border-0 text-center cart-qty" 
                                                value="{{ $item['qty'] }}" 
                                                data-min="{{ $product->min_order_quantity }}" 
                                                readonly
                                            >

                                            <button class="btn btn-sm btn-primary btn-plus"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle total-price">ট {{ number_format($total, 2) }}</td>
                                <td class="align-middle">
                                    <button class="btn btn-sm btn-danger remove-cart-item"><i class="fa fa-times"></i></button>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>

                </table>
            </div>
            <div class="col-lg-4">
                <form class="mb-30" action="">
                    <div class="input-group">
                        <input type="text" class="form-control border-0 p-4" placeholder="Coupon Code">
                        <div class="input-group-append">
                            <button class="btn btn-primary">Apply Coupon</button>
                        </div>
                    </div>
                </form>
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        {{-- <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6>$150</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">$10</h6>
                        </div> --}}
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Grand Total</h5>
                            <h5 id="grand_tottal">ট:</h5>
                        </div>
                        <!-- Change the button to this -->
                        <button class="btn btn-block btn-primary font-weight-bold my-3 py-3 proceed-checkout">
                            Proceed To Checkout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->

@endsection
@push('js')
    <script>

        // ========= REMOVE CART ITEM =========
        $(document).on('click', '.remove-cart-item', function () {
            let id = $(this).closest('tr').data('id');

            $.ajax({
                url: "{{ route('cart.remove') }}",
                type: "GET",
                data: { product_id: id },
                success: function (res) {
                    if (res.success) {
                        // Remove row
                        $(`tr[data-id="${id}"]`).remove();

                        // Update dropdown
                        updateCartDropdown(res.cart_items, res.cart_count);

                        // Recalculate totals
                        calculateGrandTotal();
                    }
                }
            });
        });


        // ========= PLUS / MINUS QUANTITY =========
        $(document).on('click', '.btn-plus, .btn-minus', function () {
            let $row = $(this).closest('tr');
            let qtyInput = $row.find('.cart-qty');

            let min = parseInt(qtyInput.data('min'));
            let qty = parseInt(qtyInput.val());

            // Get price from the price column (2nd column)
            let priceText = $row.find('td:nth-child(2)').text().trim();
            let price = parseFloat(priceText.replace('ট', '').replace(/,/g, '').trim()) || 0;

            if ($(this).hasClass('btn-plus')) {
                qty += min;
            } else {
                if (qty > min) {
                    qty -= min;
                }
            }

            qtyInput.val(qty);

            // Update row total
            let newTotal = (price * qty).toFixed(2);
            $row.find('.total-price').text('ট ' + Number(newTotal).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));

            // Recalculate cart totals
            calculateGrandTotal();
        });


        // ========= GRAND TOTAL CALCULATION =========
        function calculateGrandTotal() {
            let total = 0;

            $('.total-price').each(function () {
                let text = $(this).text().trim();
                
                // Remove ট symbol, commas, and any extra spaces
                let cleanText = text.replace('ট', '').replace(/,/g, '').trim();
                let amount = parseFloat(cleanText);

                if (!isNaN(amount) && amount > 0) {
                    total += amount;
                }
            });

            // Format the grand total with thousand separators
            $('#grand_tottal').text('ট ' + total.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
        }


        // ========= INITIALIZE ON PAGE LOAD =========
        $(document).ready(function () {
            // Small delay to ensure DOM is fully rendered
            setTimeout(function() {
                calculateGrandTotal();
            }, 100);
        });

        // Also calculate when window is fully loaded (backup)
        $(window).on('load', function() {
            calculateGrandTotal();
        });


        // ========= PROCEED TO CHECKOUT BUTTON =========
        $(document).on('click', '.proceed-checkout', function (e) {
            e.preventDefault();

            // Collect all cart items data
            let cartItems = [];
            let grandTotal = 0;

            $('tbody tr[data-id]').each(function () {
                let $row = $(this);
                let id = $row.data('id');
                
                // Get product image
                let imageUrl = $row.find('td:nth-child(1) img').attr('src');
                
                // Get product name (excluding image)
                let fullText = $row.find('td:nth-child(1)').text().trim();
                let name = fullText; // You may need to clean this
                
                let priceText = $row.find('td:nth-child(2)').text().trim();
                let price = parseFloat(priceText.replace('ট', '').replace(/,/g, '').trim());
                let qty = parseInt($row.find('.cart-qty').val());
                let totalText = $row.find('.total-price').text().trim();
                let total = parseFloat(totalText.replace('ট', '').replace(/,/g, '').trim());

                cartItems.push({
                    id: id,
                    name: name,
                    image: imageUrl,
                    price: price,
                    quantity: qty,
                    total: total
                });

                grandTotal += total;
            });

            // Check if cart is empty
            if (cartItems.length === 0) {
                alert('Your cart is empty!');
                return;
            }

            // Show loading state
            let $btn = $(this);
            let originalText = $btn.html();
            $btn.html('<i class="fa fa-spinner fa-spin"></i> Processing...').prop('disabled', true);

            // Create a form and submit
            let form = $('<form>', {
                'method': 'POST',
                'action': "{{ route('checkout') }}"
            });

            // Add CSRF token
            form.append($('<input>', {
                'type': 'hidden',
                'name': '_token',
                'value': '{{ csrf_token() }}'
            }));

            // Add cart items as JSON
            form.append($('<input>', {
                'type': 'hidden',
                'name': 'cart_items',
                'value': JSON.stringify(cartItems)
            }));

            // Add grand total
            form.append($('<input>', {
                'type': 'hidden',
                'name': 'grand_total',
                'value': grandTotal
            }));

            // Append form to body and submit
            $('body').append(form);
            form.submit();
        });


    </script>
@endpush



