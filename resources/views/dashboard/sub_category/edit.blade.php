@extends('dashboard.master')

@section('title', 'Edit Sub Category')

@section('content')
   <div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Sub Category</h4>
                <p class="">Here You Will Edit Sub Category.</p>

                <form id="subCategoryEdit" action="{{ route('admin.sub_category.update', $sub_category->id) }}" method="post" enctype="multipart/form-data" class="mt-5">
                    @csrf
                    @method('PUT')
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                             <div class="forn-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Category Name</label>
                                <div class="col-md-10">
                                    <select name="category_id" class="form-control select2" id="">
                                        <option value="" selected disabled>Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ $sub_category->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row  mt-3">
                                <label for="example-text-input" class="col-md-2 col-form-label">Sub Category Name</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="name" value="{{ $sub_category->name }}" id="example-text-input">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Status</label>
                                <div class="col-md-10">
                                     <div class="custom-control custom-radio custom-control-inline mb-3">
                                        <input type="radio" id="statusActive" name="status" value="1" class="custom-control-input" {{ $sub_category->status == 1 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="statusActive">Active</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline mb-3">
                                        <input type="radio" id="statusInactive" name="status" value="0" class="custom-control-input" {{ $sub_category->status == 0 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="statusInactive">Inactive</label>
                                    </div>


                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <div class="row mb-3 align-items-center mt-5">
                                <div class="col-md-3 text-md-end"></div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">Update Category</button>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <script>
         $('.select2').select2({
            placeholder: "Select Category",
            allowClear: true
        });

       $(document).ready(function () {
            ajaxFormSubmitJQ('#subCategoryEdit', {
                url: "{{ route('admin.sub_category.update', $sub_category->id) }}",
                method: 'POST',
                onSuccess: function (response) {
                    window.location.href = "{{ route('admin.sub_category.index') }}";
                    toastr.success(response.message || 'Sub Category updated successfully!');
                }
            });
        });
    </script>
@endpush
