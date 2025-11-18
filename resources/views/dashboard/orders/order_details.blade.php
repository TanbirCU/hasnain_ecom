@extends('dashboard.master')

@section('title', 'Order Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">

        <div class="card shadow-sm border-0">
            <div class="card-body">

                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title mb-1">Order Details</h4>
                        <p class="text-muted">Here you can view complete order information.</p>
                    </div>

                    <!-- PDF Download -->
                    <a href="" 
                        class="btn btn-sm btn-danger">
                        <i class="fas fa-file-pdf"></i> Download PDF
                    </a>
                </div>

                <hr>

                <!-- Customer Details -->
                <h5 class="mb-3">Customer Information</h5>
                <div class="row mb-4">
                    
                    <div class="col-md-4">
                        <strong>Name:</strong> 
                        <p>{{ $order->name }}</p>
                    </div>
                    <div class="col-md-4">
                        <strong>Phone:</strong> 
                        <p>{{ $order->mobile }}</p>
                    </div>
                    <div class="col-md-4">
                        <strong>Email:</strong> 
                        <p>{{ $order->email }}</p>
                    </div>
                    <div class="col-md-4">
                        <strong>District:</strong> 
                        <p>{{ $order->district }}</p>
                    </div>
                    <div class="col-md-4">
                        <strong>Upazila:</strong> 
                        <p>{{ $order->upzilla }}</p>
                    </div>
                    <div class="col-md-4">
                        <strong>Union:</strong> 
                        <p>{{ $order->union }}</p>
                    </div>
                </div>

                <!-- Order Info -->
                <h5 class="mb-3">Order Information</h5>
                <div class="row mb-4">
                    <div class="col-md-4">
                        <strong>Order ID:</strong> 
                        <p>#{{ $order->user_order_id }}</p>
                    </div>
                    
                    <div class="col-md-4">
                        <strong>Date:</strong> 
                        <p>{{ $order->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="col-md-4">
                        <strong>Status:</strong> 
                        @if($order->status == 0)
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($order->status == 1)
                            <span class="badge bg-success">Completed</span>
                        @else
                            <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                        @endif
                    </div>
                </div>

                <!-- Items List -->
                <h5 class="mb-3">Ordered Products</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Product</th>
                                <th style="width:120px;">Qty</th>
                                <th style="width:120px;">Price</th>
                                <th style="width:120px;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->price, 2) }}</td>
                                    <td>{{ number_format($item->total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Totals -->
                <div class="row justify-content-end mt-4">
                    <div class="col-md-4">
                        <ul class="list-group">
                            {{-- <li class="list-group-item d-flex justify-content-between">
                                <span>Subtotal:</span> 
                                <strong>{{ number_format($order->subtotal, 2) }}</strong>
                            </li> --}}
                            
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Grand Total:</span> 
                                <strong>{{ number_format($order->grand_total, 2) }}</strong>
                            </li>
                        </ul>
                    </div>
                </div>

            </div><!-- Card body end -->
        </div><!-- Card end -->
    </div><!-- Col end -->
</div><!-- Row end -->
@endsection
