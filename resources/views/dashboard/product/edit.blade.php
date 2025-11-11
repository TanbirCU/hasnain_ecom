@extends('dashboard.master')

@section('title', 'Edit Product')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Product</h4>
                <p class="">Here You Will Edit Product.</p>

                <form id="ProductEdit" action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="mt-5">
                    @csrf
                    @method('PUT')
                    <div class="row justify-content-center">
                        <div class="col-md-12">

                            <!-- Category -->
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Category Name</label>
                                <div class="col-md-10">
                                    <select name="category_id" id="category_id" class="form-control select2">
                                        <option value="" disabled>Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Subcategory -->
                            <div class="form-group row" id="subcategory_wrapper">
                                <label class="col-md-2 col-form-label">Sub Category Name</label>
                                <div class="col-md-10">
                                    <select name="sub_category_id" id="sub_category_id" class="form-control select2">
                                        <option value="">Select Sub Category</option>
                                        @foreach ($sub_categories as $sub)
                                            <option value="{{ $sub->id }}"
                                                data-category="{{ $sub->category_id }}"
                                                {{ $product->sub_category_id == $sub->id ? 'selected' : '' }}>
                                                {{ $sub->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Product Name -->
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Product Name</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="name" value="{{ $product->name }}">
                                </div>
                            </div>

                            <!-- Small Description -->
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Small Description</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="small_description" value="{{ $product->small_description }}">
                                </div>
                            </div>

                            <!-- Unit -->
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Unit</label>
                                <div class="col-md-10">
                                    <select name="unit_id" class="form-control select2">
                                        <option value="" disabled>Unit</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}" {{ $product->unit_id == $unit->id ? 'selected' : '' }}>
                                                {{ $unit->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Color -->
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Color</label>
                                <div class="col-md-10">
                                    <select name="color_id[]" class="form-control select2 select2-multiple" multiple="multiple">
                                        @foreach ($colors as $color)
                                            <option value="{{ $color->id }}"
                                                {{ in_array($color->id, $product->colors->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                {{ $color->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Size -->
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Size</label>
                                <div class="col-md-10">
                                    <select name="size_id[]" class="form-control select2 select2-multiple" multiple="multiple">
                                        @foreach ($sizes as $size)
                                            <option value="{{ $size->id }}"
                                                {{ in_array($size->id, $product->sizes->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                {{ $size->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Purchase Price -->
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Purchase Price</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="number" name="purchase_price" value="{{ $product->purchase_price }}">
                                </div>
                            </div>

                            <!-- Selling Price -->
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Selling Price</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="number" name="selling_price" value="{{ $product->selling_price }}">
                                </div>
                            </div>

                            <!-- Stock -->
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Stock</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="number" name="stock" value="{{ $product->stock }}">
                                </div>
                            </div>

                            <!-- MOQ -->
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">MOQ</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="number" name="min_order_quantity" value="{{ $product->min_order_quantity }}">
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="form-group row mb-4">
                                <label class="col-form-label col-lg-2">Description</label>
                                <div class="col-lg-10">
                                    <textarea id="summernote" name="description" class="form-control">{{ $product->description }}</textarea>
                                </div>
                            </div>

                            <!-- Existing Product Images -->
                            @if($product->images->count() > 0)
                            <div class="form-group row mb-4">
                                <label class="col-form-label col-lg-2">Existing Images</label>
                                <div class="col-lg-10">
                                    <div class="row" id="existing-images">
                                        @foreach($product->images as $image)
                                        <div class="col-md-3 mb-3 existing-image-wrapper" data-image-id="{{ $image->id }}">
                                            <div class="card">
                                                <img src="{{ asset($image->image_path) }}" class="card-img-top" alt="Product Image">
                                                <div class="card-body text-center p-2">
                                                    <button type="button" class="btn btn-danger btn-sm delete-existing-image" data-id="{{ $image->id }}">
                                                        <i class="bx bx-trash"></i> Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- New Product Images -->
                            <div class="form-group row mb-4">
                                <label class="col-form-label col-lg-2">Add New Images</label>
                                <div class="col-lg-10">
                                    <div id="image-preview-dropzone" class="dropzone">
                                        <div class="dz-message needsclick">
                                            <div class="mb-3">
                                                <i class="display-4 text-muted bx bxs-cloud-upload"></i>
                                            </div>
                                            <h4>Drop images here or click to upload.</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Status</label>
                                <div class="col-md-10">
                                    <div class="custom-control custom-radio custom-control-inline mb-3">
                                        <input type="radio" id="statusActive" name="status" value="1"
                                            class="custom-control-input" {{ $product->status == 1 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="statusActive">Active</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline mb-3">
                                        <input type="radio" id="statusInactive" name="status" value="0"
                                            class="custom-control-input" {{ $product->status == 0 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="statusInactive">Inactive</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Hidden field to store deleted image IDs -->
                            <input type="hidden" name="deleted_images" id="deleted_images" value="">

                            <!-- Submit -->
                            <div class="row mb-3 align-items-center mt-3">
                                <div class="col-md-2 text-md-end"></div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary" id="submitProduct">Update Product</button>
                                    <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
$('select[name="color_id[]"]').select2({
    placeholder: "Select Color",
    allowClear: true
});

$('select[name="size_id[]"]').select2({
    placeholder: "Select Size",
    allowClear: true
});

Dropzone.autoDiscover = false;

$(document).ready(function () {
    let deletedImages = [];

    // Initialize Select2
    $('.select2').select2({ width: '100%', placeholder: 'Select an option', allowClear: true });

    // Store original subcategory options
    const originalSubCategories = $('#sub_category_id option[data-category]').clone();

    // Category change event
    $('#category_id').on('change', function () {
        const categoryId = $(this).val();
        const $subCategory = $('#sub_category_id');

        // Clear current options
        $subCategory.empty();

        if (categoryId) {
            // Filter subcategories by selected category
            const filteredSubCategories = originalSubCategories.filter(function() {
                return $(this).data('category') == categoryId;
            });

            if (filteredSubCategories.length > 0) {
                // Enable and populate subcategory dropdown
                $subCategory.prop('disabled', false)
                    .append('<option value="">Select Sub Category</option>')
                    .append(filteredSubCategories.clone());

                // Reinitialize Select2 for subcategory
                $subCategory.select2({
                    width: '100%',
                    placeholder: 'Select Sub Category',
                    allowClear: true
                });
            } else {
                // No subcategories found
                $subCategory.prop('disabled', true)
                    .append('<option value="" disabled selected>No Sub Category Found</option>');

                $subCategory.select2({
                    width: '100%',
                    placeholder: 'No Sub Category Found'
                });
            }
        } else {
            // No category selected
            $subCategory.prop('disabled', true)
                .append('<option value="" selected>Select a category first</option>');
        }

        $subCategory.trigger('change');
    });

    // Summernote
    $('#summernote').summernote({
        height: 300,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });

    // Delete existing image
    $(document).on('click', '.delete-existing-image', function() {
        let imageId = $(this).data('id');
        let wrapper = $(this).closest('.existing-image-wrapper');

        if(confirm('Are you sure you want to delete this image?')) {
            deletedImages.push(imageId);
            $('#deleted_images').val(deletedImages.join(','));
            wrapper.fadeOut(300, function() {
                $(this).remove();
            });
        }
    });

    // Initialize Dropzone
    let myDropzone = new Dropzone("#image-preview-dropzone", {
        url: "{{ route('admin.product.update', $product->id) }}",
        paramName: "images[]",
        maxFilesize: 5,
        acceptedFiles: "image/*",
        uploadMultiple: true,
        addRemoveLinks: true,
        parallelUploads: 5,
        autoProcessQueue: false,
        dictDefaultMessage: "Drop images here or click to upload",
        maxFiles: 4
    });

    // Prevent more than 4 images
    myDropzone.on("maxfilesexceeded", function(file) {
        this.removeFile(file);
        toastr.error("You can upload a maximum of 4 images only.");
    });

    // Submit form + images together
    $("#submitProduct").click(function (e) {
        e.preventDefault();

        if (myDropzone.getQueuedFiles().length > 0) {
            myDropzone.processQueue();
        } else {
            $("#ProductEdit")[0].submit();
        }
    });

    myDropzone.on("sendingmultiple", function(file, xhr, formData) {
        // Append other form data
        $('#ProductEdit').serializeArray().forEach(function(field) {
            formData.append(field.name, field.value);
        });
    });

    myDropzone.on("successmultiple", function(files, response) {
        toastr.success("Product updated successfully!");
        window.location.href = "{{ route('admin.product.index') }}";
    });

    myDropzone.on("error", function(file, errorMessage) {
        toastr.error("Error uploading images: " + errorMessage);
    });
});
</script>
@endpush
