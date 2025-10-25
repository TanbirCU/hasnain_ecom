@extends('dashboard.master')

@section('title', 'Sub Category List')

@section('content')
   <div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Sub Category List</h4>
                <p class="">Here You Will See Sub Category List.</p>
                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Serial</th>
                                <th>Category Name</th>
                                <th>Sub Category Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($sub_categories as $sub_category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $sub_category->name }}</td>
                                    <td>{{ $sub_category->category->name }}</td>
                                    <td>{{ $sub_category->status == 1 ? 'Active' : 'Inactive' }}</td>

                                    <td>
                                        <a href="{{ route('admin.sub_category.edit',$sub_category->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                        <form id="deleteForm_{{ $sub_category->id }}" action="{{ route('admin.sub_category.destroy', $sub_category->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $sub_category->id }})"><i class="fas fa-trash"></i></button>
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

