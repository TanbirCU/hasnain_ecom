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
                                    <td>
                                        @if ($order->status == 0)
                                            <span class="badge badge-warning">Pending</span>

                                        @elseif ($order->status == 1)
                                            <span class="badge badge-info">Processing</span>

                                        @elseif ($order->status == 2)
                                            <span class="badge badge-success">Completed</span>

                                        @else
                                            <span class="badge badge-danger">Cancelled</span>
                                        @endif
                                    </td>

                                  

                                    <td>
                                       
                                        <a href="{{ route('admin.order_details',$order->id) }}"> <i class="fas fa-eye"></i></a>
                                        <a href="javascript:void(0)" 
                                            class="text-primary ml-2 updateStatusBtn" 
                                            data-id="{{ $order->id }}" 
                                            data-status="{{ $order->status }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.order.pdf', $order->id) }}" class="text-danger ml-2">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>

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

<!-- Update Status Modal -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title">Update Order Status</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <form id="updateStatusForm" method="POST">
        @csrf
        @method('PUT')

        <div class="modal-body">
            <input type="hidden" name="order_id" id="order_id">

            <label>Status</label>
            <select name="status" id="order_status" class="form-control">
                <option value="0">Pending</option>
                <option value="1">Processing</option>
                <option value="2">Completed</option>
                <option value="3">Cancelled</option>
            </select>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>

      </form>

    </div>
  </div>
</div>

@endsection
@push('js')
<script>
$(document).ready(function() {
    $(document).on('click', '.updateStatusBtn', function () {
        let id = $(this).data('id');
        let status = $(this).data('status');

        $('#order_id').val(id);
        $('#order_status').val(status);

        // Set action URL dynamically
        $('#updateStatusForm').attr('action', '/admin/orders/update-status/' + id);

        $('#updateStatusModal').modal('show');
    });
});

</script>
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
