@extends('dashboard.master')

@section('title', 'Add Category')

@section('content')
   <div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add New Category</h4>
                <p class="">Here You Will Add New Category.</p>

                <form id="categoryAdd" action="{{ route('admin.category.store') }}" method="post" enctype="multipart/form-data" class="mt-5">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-md-12">

                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Category Name</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="name" value="" id="example-text-input">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="category_image" class="col-md-2 col-form-label">Category Image</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="file" name="category_image" id="category_image" accept="image/*">
                                    
                                    <!-- Image Preview -->
                                    <div id="imagePreview" class="mt-3" style="display: none;">
                                        <img id="previewImg" src="" alt="Image Preview" 
                                            style="max-width: 200px; border-radius: 10px; box-shadow: 0 4 10px rgba(0,0,0,0.2); border: 1px solid #ddd; padding: 5px;">
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
                                    <button type="submit" class="btn btn-primary">Add Category</button>
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
            ajaxFormSubmitJQ('#categoryAdd', {
                url: "{{ route('admin.category.store') }}",
                method: 'POST',
                onSuccess: function (response) {
                    window.location.href = "{{ route('admin.category.index') }}";
                    toastr.success(response.message || 'Category added successfully!');
                }
            });
        });

       
        // Preview image when selected
        document.getElementById('category_image').addEventListener('change', function(event) {
            let input = event.target;
            let previewDiv = document.getElementById('imagePreview');
            let previewImg = document.getElementById('previewImg');
            
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewDiv.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                previewDiv.style.display = 'none';
            }
        });
                          
    </script>
@endpush
