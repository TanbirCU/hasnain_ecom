
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
                    <form id="businessRegisterForm">
                        @csrf
                        <div class="form-group">
                            <label for="business_name">Business Name <span class="text-danger">*</span></label>
                            <input type="text" name="business_name" id="business_name" class="form-control" placeholder="Enter your business name" required>
                        </div>

                        <div class="form-group">
                            <label for="trade_license_no">Trade License No.</label>
                            <input type="text" name="trade_license_no" id="trade_license_no" class="form-control" placeholder="Enter trade license number">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
                        </div>
                        <div class="form-group">
                            <label for="contact">Contact Number <span class="text-danger">*</span></label>
                            <input type="text" name="contact" id="contact" class="form-control" placeholder="Enter contact number" required>
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
                            <label for="vat_tax_info">VAT / TAX Information</label>
                            <input type="text" name="vat_tax_info" id="vat_tax_info" class="form-control" placeholder="Enter VAT or TAX info">
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


<script>
$(document).ready(function(){
    $('#businessRegisterForm').on('submit', function(e){
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: "",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
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
                });
                $('#businessRegisterForm')[0].reset();
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
@endsection
