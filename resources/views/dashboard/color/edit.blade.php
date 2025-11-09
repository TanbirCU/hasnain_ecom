@extends('dashboard.master')

@section('title', 'Edit Color')

@section('content')
   <div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Color</h4>
                <p class="">Here You Will Edit Color.</p>

                <form id="colorEdit" action="{{ route('admin.colors.update', $color->id) }}" method="post" enctype="multipart/form-data" class="mt-5">
                    @csrf
                    @method('PUT')
                    <div class="row justify-content-center">
                        <div class="col-md-12">

                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Color Name</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="name" value="{{ $color->name }}" id="example-text-input">
                                </div>
                            </div>
                             
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Status</label>
                                <div class="col-md-10">
                                     <div class="custom-control custom-radio custom-control-inline mb-3">
                                        <input type="radio" id="statusActive" name="status" value="1" class="custom-control-input" {{ $color->status == 1 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="statusActive">Active</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline mb-3">
                                        <input type="radio" id="statusInactive" name="status" value="0" class="custom-control-input" {{ $color->status == 0 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="statusInactive">Inactive</label>
                                    </div>

                                   
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <div class="row mb-3 align-items-center mt-5">
                                <div class="col-md-3 text-md-end"></div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">Update Color</button>
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
            ajaxFormSubmitJQ('#colorEdit', {
                url: "{{ route('admin.colors.update', $color->id) }}",
                method: 'POST',
                onSuccess: function (response) {
                    window.location.href = "{{ route('admin.colors.index') }}";
                    toastr.success(response.message || 'Color updated successfully!');
                }
            });
        });
      
    </script>

@endpush



