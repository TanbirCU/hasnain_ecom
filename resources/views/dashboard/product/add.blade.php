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

                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Sub Category Name</label>
                                <div class="col-md-10">
                                    <select name="sub_category_id" id="sub_category_id" class="form-control select2">
                                        <option value="" selected >Select Sub Category</option>
                                        @foreach ($sub_categories as $sub)
                                            <option value="{{ $sub->id }}" data-category="{{ $sub->category_id }}">
                                                {{ $sub->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

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
                                    <div class="summernote">Hello Summernote</div>
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
                {{-- End Form --}}
            </div><!-- Card body end -->
        </div><!-- Card end -->
    </div><!-- Col end -->
</div><!-- Row end -->
@endsection
@push('js')
<script>
    $(document).ready(function () {
        // Initialize all select2 fields
        $('.select2').select2({
            placeholder: "Select Option",
            allowClear: true
        });

        // Handle dynamic subcategory filtering
        const categorySelect = $('#category_id');
        const subCategorySelect = $('#sub_category_id');
        const allSubOptions = subCategorySelect.find('option').clone();

        // Initially disable subcategory dropdown
        subCategorySelect.prop('disabled', true);

        categorySelect.on('change', function () {
            const selectedCategoryId = $(this).val();

            // Clear current options and add placeholder
            subCategorySelect.html('<option value="" disabled selected>Select Sub Category</option>');

            // Filter and add subcategories for the selected category
            allSubOptions.each(function () {
                if ($(this).data('category') == selectedCategoryId) {
                    subCategorySelect.append($(this).clone());
                }
            });

            // Enable subcategory select if it has options
            const hasOptions = subCategorySelect.find('option').length > 1;
            subCategorySelect.prop('disabled', !hasOptions);

            // Re-initialize select2 cleanly
            subCategorySelect.trigger('change.select2');
        });

        // ✅ Fix your form submission binding
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

