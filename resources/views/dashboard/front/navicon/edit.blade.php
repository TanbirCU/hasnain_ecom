@extends('dashboard.master')

@section('title', 'Nav Icon')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Update Home Page</h4>
                <p class="">Here You can update Home page Details.</p>

                <form action="{{ route('admin.navicon_update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label>Phone</label>
                        <input type="text" name="phone" value="{{ $nav->phone ?? '' }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Icon (Image)</label><br>

                        <!-- Preview Image -->
                        <img id="iconPreview" 
                             src="{{ !empty($nav->icon) ? asset('assets/front/img/' . $nav->icon) : '' }}" 
                             width="60" class="mb-2" 
                             style="display: {{ !empty($nav->icon) ? 'block' : 'none' }};">

                        <input type="file" name="icon" id="iconInput" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Footer Description</label>
                        <textarea name="footer_description" class="form-control" rows="3">{{ $nav->footer_description ?? '' }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label>Footer Address</label>
                        <input type="text" name="footer_address" class="form-control"
                            value="{{ $nav->footer_address ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label>Footer Email</label>
                        <input type="email" name="footer_email" class="form-control"
                            value="{{ $nav->footer_email ?? '' }}">
                    </div>

                    <button class="btn btn-primary">Save / Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JS for live preview -->
<script>
    document.getElementById('iconInput').addEventListener('change', function(event){
        const file = event.target.files[0];
        const preview = document.getElementById('iconPreview');

        if(file){
            const reader = new FileReader();
            reader.onload = function(e){
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
