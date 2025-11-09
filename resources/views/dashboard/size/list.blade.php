@extends('dashboard.master')

@section('title', 'Size List')

@section('content')
   <div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Size List</h4>
                <p class="">Here You Will See Size List.</p>
                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Serial</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($sizes as $size)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $size->name }}</td>
                                    <td>{{ $size->status == 1 ? 'Active' : 'Inactive' }}</td>
                                    
                                    <td>
                                        <a href="{{ route('admin.sizes.edit',$size->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                        <form id="deleteForm_{{ $size->id }}" action="{{ route('admin.sizes.destroy', $size->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $size->id }})"><i class="fas fa-trash"></i></button>
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
            </div><!-- Card body end -->
        </div><!-- Card end -->
    </div><!-- Col end -->
</div><!-- Row end -->
@endsection

