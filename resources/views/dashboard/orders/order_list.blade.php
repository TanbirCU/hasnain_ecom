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
                                    {{-- <td >
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
                                       
                                        <a href="{{ route('admin.order_details',$order->id) }}"> <i class="fas fa-eye"></i></a>

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
