{{-- resources/views/admin/product/show-modal.blade.php --}}
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered">
            <tr>
                <th width="30%">Product Name</th>
                <td>{{ $product->name }}</td>
            </tr>
            <tr>
                <th>Category</th>
                <td>{{ $product->category->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Sub Category</th>
                <td>{{ $product->subCategory->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Unit</th>
                <td>{{ $product->unit->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Colors</th>
                <td>
                    @forelse($product->colors as $color)
                        <span class="badge badge-info">{{ $color->name }}</span>
                    @empty
                        N/A
                    @endforelse
                </td>
            </tr>
            <tr>
                <th>Sizes</th>
                <td>
                    @forelse($product->sizes as $size)
                        <span class="badge badge-secondary">{{ $size->name }}</span>
                    @empty
                        N/A
                    @endforelse
                </td>
            </tr>
            <tr>
                <th>Purchase Price</th>
                <td>{{ $product->purchase_price }}</td>
            </tr>
            <tr>
                <th>Selling Price</th>
                <td>{{ $product->selling_price }}</td>
            </tr>
            <tr>
                <th>Stock</th>
                <td>{{ $product->stock }}</td>
            </tr>
            <tr>
                <th>MOQ</th>
                <td>{{ $product->min_order_quantity }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    @if($product->status == 1)
                        <span class="badge badge-success">Active</span>
                    @else
                        <span class="badge badge-danger">Inactive</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Small Description</th>
                <td>{{ $product->small_description ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Description</th>
                <td>{!! $product->description ?? 'N/A' !!}</td>
            </tr>
        </table>

        @if($product->images->count() > 0)
        <h5 class="mt-4">Product Images</h5>
        <div class="row">
            @foreach($product->images as $image)
            <div class="col-md-3 mb-3">
                <img src="{{ asset($image->image_path) }}"
                     class="img-fluid img-thumbnail"
                     alt="Product Image">
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
