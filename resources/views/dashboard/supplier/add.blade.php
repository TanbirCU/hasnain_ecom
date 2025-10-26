@extends('dashboard.master')

@section('title', 'Add Supplier')

@section('content')
   <div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add New Supplier</h4>
                <p class="">Here You Will Add New Supplier.</p>

                <form id="SupplierAdd" action="{{ route('admin.supplier.store') }}" method="post" enctype="multipart/form-data" class="mt-5">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-md-12">

                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Supplier Name</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="name" value="" id="example-text-input">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Contact Person</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="contact_person" value="" id="example-text-input">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Email</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="email" name="email" value="" id="example-text-input">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Phone</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="number" name="phone" value="" id="example-text-input">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Address</label>
                                <div class="col-md-10">
                                    <input class="form-control"  type="text" name="address" value="" id="example-text-input" style="height: 80px;">
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
                                    <button type="submit" class="btn btn-primary">Add Supplier</button>
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
            ajaxFormSubmitJQ('#SupplierAdd', {
                url: "{{ route('admin.supplier.store') }}",
                method: 'POST',
                onSuccess: function (response) {
                    window.location.href = "{{ route('admin.supplier.index') }}";
                    toastr.success(response.message || 'Supplier added successfully!');
                }
            });
        });
    </script>
@endpush
