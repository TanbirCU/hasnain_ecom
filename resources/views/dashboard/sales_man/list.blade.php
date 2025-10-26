@extends('dashboard.master')

@section('title', 'Sales Man List')

@section('content')
   <div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Sales Man List</h4>
                <p class="">Here You Will See Sales Man List.</p>
                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Serial</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Area</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($sales_men as $sales_man)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $sales_man->name }}</td>
                                    <td>{{ $sales_man->email }}</td>
                                    <td>{{ $sales_man->phone }}</td>
                                    <td>{{ $sales_man->area }}</td>
                                    <td>{{ $sales_man->address }}</td>
                                    <td>{{ $sales_man->status == 1 ? 'Active' : 'Inactive' }}</td>

                                    <td>
                                        <a href="{{ route('admin.sales_man.edit',$sales_man->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                        <form id="deleteForm_{{ $sales_man->id }}" action="{{ route('admin.sales_man.destroy', $sales_man->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $sales_man->id }})"><i class="fas fa-trash"></i></button>
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

