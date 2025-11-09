@extends('dashboard.master')

@section('title', 'Color List')

@section('content')
   <div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Color List</h4>
                <p class="">Here You Will See Color List.</p>
                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Serial</th>
                                <th>Color Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($colors as $color)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $color->name }}</td>
                                    <td>{{ $color->status == 1 ? 'Active' : 'Inactive' }}</td>
                                    
                                    <td>
                                        <a href="{{ route('admin.color.edit',$color->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                        <form id="deleteForm_{{ $color->id }}" action="{{ route('admin.color.destroy', $color->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $category->id }})"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                    
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Data not found</td>
                                </tr>
                            @endforelse
                        

                        </tbody>
                    </table>
                {{-- Start Form --}}
                {{-- End Form --}}
            </div><!-- Card body end -->
        </div><!-- Card end -->
    </div><!-- Col end -->
</div><!-- Row end -->
@endsection

