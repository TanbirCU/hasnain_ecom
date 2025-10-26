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
                                <label for="example-text-input" class="col-md-2 col-form-label">Category Name</label>
                                <div class="col-md-10">
                                    <select name="category_id" class="form-control select2" id="">
                                        <option value="" selected disabled>Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                             
                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Sub Category Name</label>
                                <div class="col-md-10">
                                    <select name="sub_category_id" class="form-control select2" id="">
                                        <option value="" selected disabled>Select Sub Category</option>
                                        @foreach ($sub_categories as $sub_category)
                                            <option value="{{ $sub_category->id }}">{{ $sub_category->name }}</option>
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
                                <label for="example-text-input" class="col-md-2 col-form-label">Stock</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="number" name="stock" value="" id="example-text-input">
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
         $('.select2').select2({
            placeholder: "Select Category",
            allowClear: true
        });

       $(document).ready(function () {
            ajaxFormSubmitJQ('#subCategoryAdd', {
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
