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
                                        <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center cart-qty" value="{{ $item['qty'] }}">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-plus"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle total-price">ট{{ number_format($total, 2) }}</td>
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
                        <button class="btn btn-block btn-primary font-weight-bold my-3 py-3">Proceed To Checkout</button>
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
        let price = parseFloat($row.find('td:nth-child(2)').text().replace('$', '')) || 0;

        let qty = parseInt(qtyInput.val());

        if ($(this).hasClass('btn-plus')) {
            qty++;
        } else if ($(this).hasClass('btn-minus') && qty > 1) {
            qty--;
        }

        qtyInput.val(qty);

        // Update row total
        $row.find('.total-price').text('$' + (price * qty).toFixed(2));

        // Recalculate cart totals
        calculateGrandTotal();
    });


    // ========= GRAND TOTAL CALCULATION =========
    function calculateGrandTotal() {
        let sum = 0;

        $('.total-price').each(function () {
            let price = parseFloat($(this).text().replace('$', '')) || 0;
            sum += price;
        });

        $("#grand-total").text(sum.toFixed(2));
    }


    // Run calculation initially
    $(document).ready(function () {
        calculateGrandTotal();
    });

</script>
@endpush



