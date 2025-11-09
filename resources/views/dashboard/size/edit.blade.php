@extends('dashboard.master')

@section('title', 'Edit Category')

@section('content')
   <div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Category</h4>
                <p class="">Here You Will Edit Category.</p>

                <form id="categoryEdit" action="{{ route('admin.category.update', $category->id) }}" method="post" enctype="multipart/form-data" class="mt-5">
                    @csrf
                    @method('PUT')
                    <div class="row justify-content-center">
                        <div class="col-md-12">

                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Category Name</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="name" value="{{ $category->name }}" id="example-text-input">
                                </div>
                            </div>
                              <div class="form-group row">
                                    <label for="category_image" class="col-md-2 col-form-label">Category Image</label>
                                    <div class="col-md-10">
                                        <input type="file" name="category_image" id="category_image" class="form-control" accept="image/*">

                                        <!-- Preview current or selected image -->
                                        <div id="preview_category" class="mt-3">
                                            @if($category->category_image)
                                                <img src="{{ asset($category->category_image) }}" 
                                                    alt="Category Image" 
                                                    class="preview-img" style="max-width: 200px; border-radius: 10px; box-shadow: 0 4 10px rgba(0,0,0,0.2); border: 1px solid #ddd; padding: 5px;">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Status</label>
                                <div class="col-md-10">
                                     <div class="custom-control custom-radio custom-control-inline mb-3">
                                        <input type="radio" id="statusActive" name="status" value="1" class="custom-control-input" {{ $category->status == 1 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="statusActive">Active</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline mb-3">
                                        <input type="radio" id="statusInactive" name="status" value="0" class="custom-control-input" {{ $category->status == 0 ? 'checked' : '' }}>
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
       
       $(document).ready(function () {
            ajaxFormSubmitJQ('#categoryEdit', {
                url: "{{ route('admin.category.update', $category->id) }}",
                method: 'POST',
                onSuccess: function (response) {
                    window.location.href = "{{ route('admin.category.index') }}";
                    toastr.success(response.message || 'Category updated successfully!');
                }
            });
        });
       document.getElementById('category_image').addEventListener('change', function() {
            const previewContainer = document.getElementById('preview_category');
            previewContainer.innerHTML = '';

            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'preview-img';
                    img.style.width = '120px';
                    img.style.height = '120px';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '8px';
                    img.style.border = '1px solid #ddd';
                    img.style.boxShadow = '0 2px 8px rgba(0,0,0,0.2)';
                    previewContainer.appendChild(img);
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

    </script>

@endpush
@section('css')
    <style>
        .preview-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
    </style>
@endsection


