
@extends('front/master/master')

@section('title')
    Business Registration | Sole Bazer
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4 class="mb-0">Register Your Business</h4>
                    <small>Provide your business details to register</small>
                </div>
                <div class="card-body p-4">
                    <form id="businessRegisterForm" action="{{ route('user.registration_store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="business_name">Business Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter your business name" required>
                        </div>

                        {{-- <div class="form-group">
                            <label for="trade_license_no">Trade License No.</label>
                            <input type="text" name="trade_license_no" id="trade_license_no" class="form-control" placeholder="Enter trade license number">
                        </div> --}}
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Contact Number <span class="text-danger">*</span></label>
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter contact number" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                        </div>

                        <div class="form-group">
                            <label for="address">Business Address <span class="text-danger">*</span></label>
                            <textarea name="address" id="address" class="form-control" rows="3" placeholder="Enter your full address" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="nid">Nid</label>
                            <input type="number" name="nid" id="nid" class="form-control" placeholder="Enter Nid number">
                        </div>
                        <div class="form-group">
                            <label for="reference_no">reference Number</label>
                            <input type="number" name="reference_no" id="reference_no" class="form-control" placeholder="Enter reference number">
                        </div>
                        <div class="form-group">
                            <label for="trade_license_image">Trade License</label>
                            <input type="file" name="trade_license_image" id="trade_license_image" class="form-control" >
                            <img id="trade_license_preview" src="" style="max-width:150px; margin-top:10px; display:none; border:1px solid #ccc; padding:5px;">
                        </div>

                        <div class="form-group">
                            <label for="shop_image">Shop Image</label>
                            <input type="file" name="shop_image" id="shop_image" class="form-control">

                            <img id="shop_image_preview" src="" style="max-width:150px; margin-top:10px; display:none; border:1px solid #ccc; padding:5px;">
                        </div>


                        <button type="submit" class="btn btn-primary btn-block mt-3">
                            <i class="fas fa-paper-plane"></i> Submit Registration
                        </button>
                    </form>
                </div>
                <div class="card-footer text-center text-muted small">
                    <p class="mb-0">Already registered? <a href="#" class="text-primary font-weight-bold">Login here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@push('js')

    <script>
        $(document).ready(function(){
            // For trade license URL preview

            $('#trade_license_image').on('change', function (e) {
                let file = e.target.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function (e) {
                        $('#trade_license_preview').attr('src', e.target.result).show();
                    }
                    reader.readAsDataURL(file);
                }
            });

            // For shop image file preview
            $('#shop_image').on('change', function (e) {
                let file = e.target.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function (e) {
                        $('#shop_image_preview').attr('src', e.target.result).show();
                    }
                    reader.readAsDataURL(file);
                }
            });

            $('#businessRegisterForm').on('submit', function(e){
                e.preventDefault();

                let formData = new FormData(this);
                let url = $(this).attr('action');

                $.ajax({
                    url: url,
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function(){
                        Swal.fire({
                            title: 'Please wait...',
                            text: 'Submitting your registration',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading()
                            }
                        });
                    },
                    success: function(response){
                        Swal.fire({
                            icon: 'success',
                            title: 'Registration Successful!',
                            text: response.message ?? 'Your business has been registered successfully.',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            window.location.href = "{{ route('home') }}";
                        });
                    },
                    error: function(xhr){
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: xhr.responseJSON?.message ?? 'Something went wrong. Please try again.'
                        });
                    }
                });
            });
        });
    </script>
@endpush
