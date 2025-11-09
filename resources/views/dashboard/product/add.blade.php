@extends('dashboard.master')

@section('title', 'Add Product')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add Product</h4>
                <p class="">Here You Will Add New Product.</p>

                <form id="ProductAdd" action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data" class="mt-5">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-md-12">

                            <!-- Category -->
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

                            <!-- Subcategory -->
                            <div class="form-group row" id="subcategory_wrapper">
                                <label class="col-md-2 col-form-label">Sub Category Name</label>
                                <div class="col-md-10">
                                    <select name="sub_category_id" id="sub_category_id" class="form-control select2" disabled>
                                        <option value="">Select Sub Category</option>
                                        @foreach ($sub_categories as $sub)
                                            <option value="{{ $sub->id }}" data-category="{{ $sub->category_id }}">
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
                                    <input class="form-control" type="text" name="name">
                                </div>
                            </div>

                            <!-- Small Description -->
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Small Description</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="small_description">
                                </div>
                            </div>

                            <!-- Unit -->
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Unit</label>
                                <div class="col-md-10">
                                    <select name="unit_id" class="form-control select2">
                                        <option value="" selected disabled>Unit</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Color</label>
                                <div class="col-md-10">
                                    <select name="color_id[]" class="form-control select2 select2-multiple" multiple="multiple">
                                        @foreach ($colors as $color)
                                            <option value="{{ $color->id }}">{{ $color->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Size</label>
                                <div class="col-md-10">
                                    <select name="size_id[]" class="form-control select2 select2-multiple" multiple="multiple">
                                        @foreach ($sizes as $size)
                                            <option value="{{ $size->id }}">{{ $size->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <!-- Stock -->
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Purchase Price</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="number" name="purchase_price">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Selling Price</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="number" name="selling_price">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Stock</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="number" name="stock">
                                </div>
                            </div>

                            <!-- MOQ -->
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">MOQ</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="number" name="min_order_quantity">
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="form-group row mb-4">
                                <label class="col-form-label col-lg-2">Description</label>
                                <div class="col-lg-10">
                                    <textarea id="summernote" name="description" class="form-control"></textarea>
                                </div>
                            </div>

                            <!-- Product Images -->
                            <div class="form-group row mb-4">
                                <label class="col-form-label col-lg-2">Product Images</label>
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
                                        <input type="radio" id="statusActive" name="status" value="1" class="custom-control-input" checked>
                                        <label class="custom-control-label" for="statusActive">Active</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline mb-3">
                                        <input type="radio" id="statusInactive" name="status" value="0" class="custom-control-input">
                                        <label class="custom-control-label" for="statusInactive">Inactive</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit -->
                            <div class="row mb-3 align-items-center mt-3">
                                <div class="col-md-2 text-md-end"></div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary" id="submitProduct">Add Product</button>
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

                    // Open subcategory dropdown
                    setTimeout(() => {
                        $subCategory.select2('open');
                    }, 100);
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

    // Initialize Dropzone
    let myDropzone = new Dropzone("#image-preview-dropzone", {
        url: "{{ route('admin.product.store') }}",
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
            $("#ProductAdd")[0].submit();
        }
    });

    myDropzone.on("sendingmultiple", function(file, xhr, formData) {
        // Append other form data
        $('#ProductAdd').serializeArray().forEach(function(field) {
            formData.append(field.name, field.value);
        });
    });

    myDropzone.on("successmultiple", function(files, response) {
        toastr.success("Product added successfully!");
        window.location.href = "{{ route('admin.product.index') }}";
    });
});
</script>
@endpush
