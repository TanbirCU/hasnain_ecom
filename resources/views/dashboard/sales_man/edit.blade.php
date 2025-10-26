@extends('dashboard.master')

@section('title', 'Edit Sales Man')

@section('content')
   <div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Sales Man</h4>
                <p class="">Here You Will Edit Sales Man.</p>

                <form id="SalesManEdit" action="{{ route('admin.sales_man.update', $sales_man->id) }}" method="post" enctype="multipart/form-data" class="mt-5">
                    @csrf
                    @method('PUT')
                    <div class="row justify-content-center">
                        <div class="col-md-12">

                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Sales Man Name</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="name" value="{{ $sales_man->name }}" id="example-text-input">
                                </div>
                            </div>
                          
                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Email</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="email" name="email" value="{{ $sales_man->email }}" id="example-text-input">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Phone</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="number" name="phone" value="{{ $sales_man->phone }}" id="example-text-input">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Area</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="area" value="{{ $sales_man->area }}" id="example-text-input">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Address</label>
                                <div class="col-md-10">
                                    <input class="form-control"  type="text" name="address" value="{{ $sales_man->address }}" id="example-text-input" style="height: 80px;">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Status</label>
                                <div class="col-md-10">
                                     <div class="custom-control custom-radio custom-control-inline mb-3">
                                        <input type="radio" id="statusActive" name="status" value="1" class="custom-control-input" {{ $sales_man->status == 1 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="statusActive">Active</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline mb-3">
                                        <input type="radio" id="statusInactive" name="status" value="0" class="custom-control-input" {{ $sales_man->status == 0 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="statusInactive">Inactive</label>
                                    </div>

                                   
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <div class="row mb-3 align-items-center mt-5">
                                <div class="col-md-2 text-md-end"></div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">Update Sales Man</button>
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
            ajaxFormSubmitJQ('#SalesManEdit', {
                url: "{{ route('admin.sales_man.update', $sales_man->id) }}",
                method: 'POST',
                onSuccess: function (response) {
                    window.location.href = "{{ route('admin.sales_man.index') }}";
                    toastr.success(response.message || 'Sales Man updated successfully!');
                }
            });
        });
    </script>
@endpush
