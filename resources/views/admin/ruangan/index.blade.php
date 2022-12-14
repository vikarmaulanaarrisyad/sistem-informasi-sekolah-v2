@extends('layouts.app')

@section('title', 'Data Ruangan')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Data Ruangan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-card>
                <x-slot name="header">
                    @can('ruangan_store')
                    <button onclick="addForm(`{{ route('ruangan.index') }}`)" class="btn btn-sm btn-primary"><i
                        class="fas fa-plus-circle"></i> Tambah Ruangan</button>
                    @endcan

                </x-slot>

                <x-table>
                    <x-slot name="thead">
                        <th width="5%">No</th>
                        <th width="20%">Jenis Ruangan</th>
                        <th width="15%">Nama Ruangan</th>
                        <th width="10%">Gambar</th>
                        <th width="10%">Aksi</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>

@include('admin.ruangan.form')
@endsection

@include('layouts.include.datatables')
@include('layouts.include.datepicker')
@include('layouts.include.select2')

@push('scripts')
    <script>
        let modal = '#modal-form';
        let table;

        table = $('.table').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('admin.ruangan.data') }}',
            },
            columns: [
                {data: 'DT_RowIndex' , searchable: false},
                {data: 'jenis_ruangan'},
                {data: 'nama_ruangan'},
                {data: 'gambar'},
                {data: 'aksi', seacrhable: false, sortable: false},
                ]
        });

        function addForm(url, title = 'Tambah Kelas') {
            $(modal).modal('show');
            $(`${modal} .modal-title`).text(title);
            $(`${modal} form`).attr('action', url);
            $(`${modal} [name=_method]`).val('POST');
            resetForm(`${modal} form`);
        }

        function editForm(url, title = 'Edit Kelas') {
            $.get(url)
                .done(response => {
                    $(`${modal}`).modal('show');
                    $(`${modal} .modal-title`).text(title);
                    $(`${modal} form`).attr('action', url);
                    $(`${modal} [name=_method]`).val('PUT');
                    resetForm(`${modal} form`);
                    loopForm(response.data);
                })
                .fail(errors => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: errors.responseJSON.message,
                        showConfirmButton: false,
                        timer: 2000
                    })
                });
        }

        function submitForm(originalForm) {
            $.post({
                    url: $(originalForm).attr('action'),
                    data: new FormData(originalForm),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false
                })
                .done(response => {
                    $(modal).modal('hide');
                    if (response.status = 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        })
                    }
                    table.ajax.reload();
                })
                .fail(errors => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: errors.responseJSON.message,
                        showConfirmButton: false,
                        timer: 2000
                    })
                    if (errors.status == 422) {
                        loopErrors(errors.responseJSON.errors);
                        return;
                    }
                });
        }

        function deleteData(url) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: true,
            })
            swalWithBootstrapButtons.fire({
                title: 'Apakah anda yakin hapus data ini?',
                text: "Data yang sudah dihapus tidak bisa dikembalikan lagi.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'rgb(50, 133, 214)',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(url, {
                            '_method': 'delete'
                        })
                        .done(response => {
                            if (response.status = 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 2000
                                })
                                table.ajax.reload();
                            }
                        })
                        .fail(errors => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: errors.responseJSON.message,
                                showConfirmButton: false,
                                timer: 2000
                            })
                            table.ajax.reload();
                        });
                }
            })
        }
    </script>
@endpush

