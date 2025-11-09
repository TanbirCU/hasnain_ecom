@extends('dashboard.master')

@section('title', 'Add Product')

@section('content')
   <div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add Product</h4>
                <p class="">Here You Will Add New Product.</p>

                <form id="ProductAdd" action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data" class="mt-5">
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

                            <!-- Rest of your form fields remain the same -->
                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Product Name</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="name" value="" id="example-text-input">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Small Description</label>
                                <div class="col-md-10">
                                    <input class="form-control h-100" type="text" name="small_description" value="" id="example-text-input">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Unit</label>
                                <div class="col-md-10">
                                    <select name="unit_id" class="form-control select2" id="">
                                        <option value="" selected disabled>Unit</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Stock</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="number" name="stock" value="" id="example-text-input">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">MOQ</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="number" name="min_order_quantity" value="" id="example-text-input">
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label col-lg-2">Task Description</label>
                                <div class="col-lg-10">
                                    <textarea id="summernote" name="description" class="form-control"></textarea>
                                </div>
                            </div>

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
                            <div class="row mb-3 align-items-center mt-3">
                                <div class="col-md-2 text-md-end"></div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">Add Product</button>
                                </div>
                            </div>

                        </div><!-- Col end -->
                    </div><!-- Row end -->
                </form><!-- Form end -->
            </div><!-- Card body end -->
        </div><!-- Card end -->
    </div><!-- Col end -->
</div><!-- Row end -->
@endsection

{{-- @push('css') --}}

<!-- Dropzone CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" rel="stylesheet">
{{-- @endpush --}}
<!-- Dropzone JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>
@push('js')



<script>
    $(document).ready(function () {
        // Initialize Select2
        $('.select2').select2({
            width: '100%',
            placeholder: 'Select an option',
            allowClear: true
        });

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

        // Initialize Summernote
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
        const myDropzone = new Dropzone("#image-preview-dropzone", {
            url: "{{ route('admin.upload_image') }}", // Temporary URL, will be handled by form submission
            paramName: "images", // The name that will be used to transfer the file
            maxFilesize: 5, // MB
            maxFiles: 5, // Maximum number of files
            acceptedFiles: "image/*",
            addRemoveLinks: true,
            autoProcessQueue: false, // Important: Don't auto-upload
            parallelUploads: 5,
            dictDefaultMessage: "<i class='display-4 text-muted bx bxs-cloud-upload'></i><h4>Drop images here or click to upload.</h4>",
            dictRemoveFile: "Remove",
            init: function() {
                this.on("addedfile", function(file) {
                    console.log("File added: ", file.name);
                });

                this.on("removedfile", function(file) {
                    console.log("File removed: ", file.name);
                });

                this.on("error", function(file, message) {
                    toastr.error(message);
                });
            }
        });

        // Handle form submission with Dropzone files
        $('#ProductAdd').on('submit', function(e) {
            e.preventDefault();

            const form = this;
            const formData = new FormData(form);

            // Append all Dropzone files to formData
            if (myDropzone.files.length > 0) {
                myDropzone.files.forEach((file, index) => {
                    formData.append('images[]', file);
                });
            }

            // Submit form via AJAX
            $.ajax({
                url: $(form).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    toastr.success(response.message || 'Product added successfully!');
                    setTimeout(() => {
                        window.location.href = "{{ route('admin.product.index') }}";
                    }, 1500);
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON?.errors;
                    if (errors) {
                        Object.values(errors).forEach(errorArray => {
                            errorArray.forEach(error => {
                                toastr.error(error);
                            });
                        });
                    } else {
                        toastr.error('An error occurred while adding the product.');
                    }
                }
            });
        });

        // Your existing AJAX form submission function (as fallback)
        ajaxFormSubmitJQ('#ProductAdd', {
            url: "{{ route('admin.product.store') }}",
            method: 'POST',
            onSuccess: function (response) {
                window.location.href = "{{ route('admin.product.index') }}";
                toastr.success(response.message || 'Product added successfully!');
            }
        });
    });
</script>
@endpush
