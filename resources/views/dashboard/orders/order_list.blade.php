@extends('dashboard.master')

@section('title', 'orders List')

@section('content')
   <div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">orders List</h4>
                <p class="">Here You Will See orders List.</p>
                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Serial</th>
                                <th>Order Id</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Grand Total</th>
                                <th>district</th>
                                <th>Upazila</th>    
                                <th>Union</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->user_order_id }}</td>
                                    <td>{{ $order->name }}</td>
                                    <td>{{ $order->mobile ?? '' }}</td>
                                    <td>{{ $order->grand_total ?? '' }}</td>
                                    <td>{{ $order->district ?? '' }}</td>
                                    <td>{{ $order->upzilla ?? '' }}</td>
                                    <td>{{ $order->union  ?? '' }}</td>
                                    {{-- <td id="status_{{ $order->id }}">
                                        @if($order->status == 0)
                                            <button class="btn btn-sm btn-warning approveBtn" data-id="{{ $order->id }}">
                                                Approve Please
                                            </button>
                                        @else
                                            <span class="badge badge-success">Approved</span>
                                        @endif
                                    </td> --}}
                                    <td>{{ $order->status }}</td>

                                    <td>
                                        {{-- <a href="javascript:void(0)"
                                            class="btn btn-primary btn-sm view-product"
                                            data-name="{{ $order->name }}"
                                            data-email="{{ $order->email }}"
                                            data-phone="{{ $order->phone }}"
                                            data-trade="{{ $order->trade_license_no }}"
                                            data-address="{{ $order->address }}"
                                            data-nid="{{ $order->nid }}"
                                            data-status="{{ $order->status }}"
                                            data-tradeimg="{{ asset($order->trade_license_image) }}"
                                            data-shopimg="{{ asset($order->shop_image) }}">
                                                <i class="fas fa-eye"></i>
                                            </a> --}}


                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Data not found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
            </div><!-- Card body end -->
        </div><!-- Card end -->
    </div><!-- Col end -->
</div><!-- Row end -->
<!-- order Details Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">order Details</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <table class="table table-bordered">
                    <tr><th>Name</th><td id="modal_name"></td></tr>
                    <tr><th>Email</th><td id="modal_email"></td></tr>
                    <tr><th>Phone</th><td id="modal_phone"></td></tr>
                    <tr><th>Trade License No</th><td id="modal_trade"></td></tr>
                    <tr><th>Address</th><td id="modal_address"></td></tr>
                    <tr><th>NID</th><td id="modal_nid"></td></tr>

                    <tr>
                        <th>Trade License Image</th>
                        <td><img id="modal_tradeimg" style="max-width:150px; border:1px solid #ddd; padding:4px;"></td>
                    </tr>

                    <tr>
                        <th>Shop Image</th>
                        <td><img id="modal_shopimg" style="max-width:150px; border:1px solid #ddd; padding:4px;"></td>
                    </tr>

                    <tr><th>Status</th><td id="modal_status"></td></tr>
                </table>
            </div>

        </div>
    </div>
</div>



@endsection
@push('js')
    {{-- <script>
        $(document).ready(function() {
            $(document).on('click', '.approveBtn', function () {
                let orderId = $(this).data('id');

                $.ajax({
                    url: "{{ route('admin.order_approve') }}",
                    method: "POST",
                    data: {
                        id: orderId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {

                        window.location.href = "{{ route('admin.orderList') }}";
                        toastr.success(response.message || 'order Approved successfully!');
                    }
                });
            });

        });
        $(document).on('click', '.view-product', function () {

            $('#modal_name').text($(this).data('name'));
            $('#modal_email').text($(this).data('email'));
            $('#modal_phone').text($(this).data('phone'));
            $('#modal_trade').text($(this).data('trade'));
            $('#modal_address').text($(this).data('address'));
            $('#modal_nid').text($(this).data('nid'));

            // Set Images
            $('#modal_tradeimg').attr('src', $(this).data('tradeimg'));
            $('#modal_shopimg').attr('src', $(this).data('shopimg'));

            let status = $(this).data('status');
            $('#modal_status').html(
                status == 1
                ? '<span class="badge badge-success">Approved</span>'
                : '<span class="badge badge-warning">Pending</span>'
            );

            $('#orderDetailsModal').modal('show');
        });



    </script> --}}

@endpush
