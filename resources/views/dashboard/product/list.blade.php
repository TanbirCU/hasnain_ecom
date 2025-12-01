@extends('dashboard.master')

@section('title', 'Product List')

@section('content')
   <div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Product List</h4>
                <p class="">Here You Will See Product List.</p>
                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Serial</th>
                                <th>Product Name</th>
                                <th>Product Code</th>
                                <th>Category</th>
                                <th>Purchase Price</th>
                                <th>Selling Price</th>
                                <th>MOQ</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->product_code ?? '' }}</td>
                                    <td>{{ $product->category->name  }}</td>
                                    <td>{{ $product->purchase_price }}</td>
                                    <td>{{ $product->selling_price }}</td>
                                    <td>{{ $product->min_order_quantity }}</td>
                                    <td>{{ $product->status == 1 ? 'Active' : 'Inactive' }}</td>

                                    <td>
                                        <a href="javascript:void(0)"
                                            class="btn btn-primary btn-sm view-product"
                                            data-id="{{ $product->id }}">
                                            <i class="fas fa-eye"></i>
                                            </a>

                                        <a href="{{ route('admin.product.edit',$product->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                        <form id="deleteForm_{{ $product->id }}" action="{{ route('admin.product.destroy', $product->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $product->id }})"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Data not found</td>
                                </tr>
                            @endforelse


                        </tbody>
                    </table>
                {{-- Start Form --}}
                {{-- End Form --}}
            </div><!-- Card body end -->
        </div><!-- Card end -->
    </div><!-- Col end -->
</div><!-- Row end -->


<!-- Modal Structure (place at bottom of page, outside loops) -->
<div class="modal fade" id="productModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Product Details</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="productModalBody">
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
$(document).on('click', '.view-product', function() {
    let productId = $(this).data('id');

    $('#productModal').modal('show');
    $('#productModalBody').html(`
        <div class="text-center">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    `);

    $.ajax({
        url: "{{ route('admin.product.show', '') }}/" + productId,
        type: 'GET',
        success: function(response) {
            $('#productModalBody').html(response);
        },
        error: function() {
            $('#productModalBody').html('<p class="text-danger">Error loading product details.</p>');
        }
    });
});
</script>
@endpush

