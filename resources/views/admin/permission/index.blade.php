@extends('layouts.app')

@section('title', 'Permissions')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Permission List</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-card>
                <x-slot name="header">
                    <button onclick="addForm(`{{ route('permission.store') }}`)" class="btn btn-sm btn-primary"><i
                            class="fas fa-plus-circle"></i> Tambah Permissions</button>
                </x-slot>

                <x-table>
                    <x-slot name="thead">
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th width="15%" style="text-align: center">Aksi</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>

@include('admin.permission.form')
@endsection

@include('layouts.include.datatables')

@push('scripts')
    <script>
        let modal = '#modal-form'
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
                {data: 'created_at'},
                {data: 'updated_at'},
                {data: 'aksi', seacrhable: false, sortable: false},
                ]
        });

        function addForm(url, title = 'Tambah Data Permissions') {
            $(modal).modal('show');
        }
    </script>
@endpush