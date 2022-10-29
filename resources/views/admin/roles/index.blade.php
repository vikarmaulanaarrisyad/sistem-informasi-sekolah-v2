@extends('layouts.app')

@section('title', 'Roles')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Roles List</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <x-card>
            <x-slot name="header">
                @can('role_create')
                    <button onclick="addForm(`{{ route('role.store') }}`)" class="btn btn-sm btn-primary"><i
                        class="fas fa-plus-circle"></i> Tambah Roles</button>
                    @endcan
            </x-slot>

            <x-table>
                <x-slot name="thead">
                    <th width="7%">No</th>
                    <th>Role</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th width="15%">Aksi</th>
                </x-slot>
            </x-table>
        </x-card>
    </div>
</div>
@include('admin.roles.form')
@endsection

@include('layouts.include.datatables')

@push('scripts')
    <script>
        let modal = '#modal-form';
        let table;

        table = $('.table').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('admin.role.data') }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false},
                {data: 'name'},
                {data: 'created_at'},
                {data: 'updated_at'},
                {data: 'aksi', sortable: false, searchable: false},
            ]
        });

        function addForm (url, title = 'Tambah Roles') {
            $(modal).modal('show')
            $(`${modal} .modal-title`).text(title)
            $(`${modal} form`).attr('action',url)
            $(`${modal} [name=_method]`).val('POST')
            resetForm(`${modal} form`)
        }

    </script>
@endpush