@extends('front/master/master')
@section('title')
    Orders | Sole Bazer
@endsection

@section('content')
<div class="orders-page py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh;">
    <div class="container">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold text-white mb-1">My Orders</h2>
                    <p class="text-white-50 mb-0">Track and manage your purchases</p>
                </div>
                <div class="badge bg-white text-primary px-3 py-2 rounded-pill">
                    {{ $orders->count() }} Orders
                </div>
            </div>
        </div>

        @if($orders->isEmpty())
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-lg" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                        <div class="card-body text-center py-5">
                            <h4 class="fw-bold mb-2">No Orders Yet</h4>
                            <p class="text-muted mb-4">Start shopping to see your orders here</p>
                            <a href="{{ route('home') }}" class="btn btn-primary px-4 py-2 rounded-pill">
                                <i class="fas fa-shopping-bag me-2"></i>Start Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row g-4">
                @foreach($orders as $order)
                <div class="col-12">
                    <div class="card border-0 shadow-lg hover-lift" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                        <div class="card-body p-4">
                            <div class="row align-items-center mb-3 pb-3 border-bottom">
                                <div class="col-md-3 d-flex align-items-center">
                                    <div class="order-icon me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-receipt text-white fs-5"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Order ID</small>
                                        <strong class="text-dark">#{{ $order->user_order_id }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <small class="text-muted d-block">Date</small>
                                    <strong class="text-dark">{{ $order->created_at->format('d M Y') }}</strong>
                                </div>
                                <div class="col-md-2">
                                    <small class="text-muted d-block">Status</small>
                                    @if($order->status == 0)
                                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill"><i class="fas fa-clock me-1"></i>Pending</span>
                                    @elseif($order->status == 1)
                                        <span class="badge bg-info text-white px-3 py-2 rounded-pill"><i class="fas fa-truck me-1"></i>Processing</span>
                                    @elseif($order->status == 2)
                                        <span class="badge bg-success px-3 py-2 rounded-pill"><i class="fas fa-check-circle me-1"></i>Completed</span>
                                    @else
                                        <span class="badge bg-danger px-3 py-2 rounded-pill"><i class="fas fa-times-circle me-1"></i>Cancelled</span>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <small class="text-muted d-block">Grand Total</small>
                                    <h5 class="mb-0 fw-bold" style="color: #667eea;">টাকা {{ number_format($order->grand_total, 2) }}</h5>
                                </div>
                                <div class="col-md-2 text-end">
                                    <button type="button" class="btn btn-sm px-3 py-2 rounded-pill" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;" data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}">
                                        <i class="fas fa-eye me-1"></i>View
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Modal -->
                <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1" aria-labelledby="orderModalLabel{{ $order->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content border-0 shadow-lg">
                            <div class="modal-header border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <h5 class="modal-title text-white fw-bold" id="orderModalLabel{{ $order->id }}">Order #{{ $order->user_order_id }}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Customer:</strong> {{ $order->name }}</p>
                                <p><strong>Email:</strong> {{ $order->email }}</p>
                                <p><strong>Phone:</strong> {{ $order->mobile }}</p>
                                <p><strong>District:</strong> {{ $order->district }}</p>
                                <p><strong>Upzilla:</strong> {{ $order->upzilla }}</p>
                                <p><strong>Union:</strong> {{ $order->union }}</p>
                                <p><strong>Extra Address:</strong> {{ $order->extra_address }}</p>
                                <p><strong>Total:</strong> টাকা {{ number_format($order->grand_total,2) }}</p>

                                <h6>Order Items:</h6>
                                <ul>
                                    @foreach($order->orderItems as $item)
                                        <li>{{ $item->product_name }} - Quantity: {{ $item->quantity }} - Sub Total: টাকা {{ number_format($item->total,2) }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<!-- Bootstrap 5 JS Bundle (Includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
