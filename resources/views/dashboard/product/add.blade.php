@extends('dashboard.master')

@section('title', 'Add Product')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add Product</h4>
                <p>Here You Will Add New Product.</p>

                {{-- Product Form --}}
                <form id="ProductAdd" action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data" class="mt-4">
                    @csrf

                    {{-- Category --}}
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Category Name</label>
                        <div class="col-md-10">
                            <select name="category_id" id="category_id" class="form-control select2">
                                <option value="" selected disabled>Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Sub Category --}}
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Sub Category Name</label>
                        <div class="col-md-10">
                            <select name="sub_category_id" id="sub_category_id" class="form-control select2">
                                <option value="" selected>Select Sub Category</option>
                                @foreach ($sub_categories as $sub)
                                    <option value="{{ $sub->id }}" data-category="{{ $sub->category_id }}">{{ $sub->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Product Name --}}
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Product Name</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="name">
                        </div>
                    </div>

                    {{-- Small Description --}}
                    <div class="form-group row mb-4">
                        <label class="col-form-label col-lg-2">Small Description</label>
                        <div class="col-lg-10">
                            <input class="form-control" type="text" name="small_description">
                        </div>
                    </div>

                    {{-- Product Status --}}
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Status</label>
                        <div class="col-md-10">
                            <div class="custom-control custom-radio custom-control-inline mb-3">
                                <input type="radio" id="statusActive" name="status" value="1" class="custom-control-input" checked>
                                <label class="custom-control-label" for="statusActive">Active</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline mb-3">
                                <input type="radio" id="statusInactive" name="status" value="0" class="custom-control-input">
                                <label class="custom-control-label" for="statusInactive">Inactive</label>
                            </div>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="row mt-4">
                        <div class="col-md-2"></div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">Add Product</button>
                        </div>
                    </div>
                </form>

                {{-- 🔥 Dropzone Area (outside main form) --}}
                <hr class="my-4">
                <h5>Upload Product Images</h5>
                <form action="{{ route('admin.upload_image') }}" class="dropzone" id="imageDropzone">
                    @csrf
                    <div class="dz-message needsclick">
                        <i class="display-4 text-muted bx bxs-cloud-upload"></i>
                        <h4>Drop files here or click to upload.</h4>
                    </div>
                </form>
                <div id="uploadedImagesPreview" class="mt-3 d-flex flex-wrap"></div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
Dropzone.options.imageDropzone = {
    paramName: "file",
    maxFilesize: 5, // MB
    acceptedFiles: ".jpeg,.jpg,.png,.gif",
    headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
    success: function(file, response) {
        if (response.success) {
            $('#uploadedImagesPreview').append(
                `<img src="${response.file_path}" width="120" class="m-2 rounded shadow">`
            );
        }
    },
    error: function(file, response) {
        console.error(response);
    }
};

// select2 init
$('.select2').select2();

// subcategory filter
$('#category_id').on('change', function() {
    const categoryId = $(this).val();
    $('#sub_category_id option').hide().filter(`[data-category="${categoryId}"]`).show();
});
</script>
@endpush

<style>
.dropzone {
    min-height: 200px;
    border: 2px dashed #ced4da;
    border-radius: 8px;
    background: #f8f9fa;
}
.dropzone .dz-message {
    color: #6c757d;
    font-size: 16px;
}
.dropzone .dz-preview .dz-image img {
    border-radius: 8px;
}
</style>
