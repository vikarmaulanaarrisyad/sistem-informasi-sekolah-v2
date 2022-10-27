@extends('layouts.app')

@section('title', 'Permissions')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Permission List</li>
@endsection

@section('content')

@endsection

@include('layouts.include.datatables')

@push('scripts')
    <script>
        let table;

        table = $('.table').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('admin.permission.data') }}'
            },
            columns: [
                {data: 'DT_RowIndex' , searchable: false},
                {data: 'name'},
                ]
        });
    </script>
@endpush