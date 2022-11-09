@extends('layouts.app')

@section('title', 'Kelas')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Kelas</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-card>
                <x-slot name="header">
                    <div class="d-flex flex-column">
                        <div class="row">
                            <div class="col-9">
                                @can('kelas_store')
                                <button onclick="addForm(`{{ route('kelas.store') }}`)" class="btn btn-sm btn-primary"><i
                                    class="fas fa-plus-circle"></i> Tambah Kelas</button>
                                @endcan
                            </div>
                            <div class="col-3 ">
                                <div class="form-group">
                                    <select name="tahunpelajaran2" id="tahunpelajaran2" class="custom-select text-sm float-right">
                                        <option disbaled selected>Pilih Tahun Pelajaran</option>
                                        @foreach ($getAllTahunAjaran as $tahunPelajaran )
                                            <option value="{{ $tahunPelajaran->id }}">{{ $tahunPelajaran->nama }} {{ $tahunPelajaran->is_semester }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                </x-slot>

                <x-table>
                    <x-slot name="thead">
                        <th width="5%">No</th>
                        <th>Nama Kelas</th>
                        <th>Wali Kelas</th>
                        <th>Kapasitas Kelas</th>
                        <th width="15%" style="text-align: center">Aksi</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>

@include('admin.kelas.form')
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
                url: '{{ route('admin.kelas.data') }}',
                data: function (d) {
                    d.tahunpelajaran = $('[name=tahunpelajaran2]').val()
                },
            
            },
            columns: [
                {data: 'DT_RowIndex' , searchable: false},
                {data: 'nama_kelas'},
                {data: 'wali_kelas'},
                {data: 'kapasitas'},
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
                title: 'Perhatian',
                text: "Apakah Anda yakin akan menghapus data ini?, data yang dihapus tidak dapat dikembalikan lagi",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'rgb(48, 133, 214)',
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

               // Filtering Data
        $('[name=tahunpelajaran2]').on('change', function () {
            table.ajax.reload();
        })

    

        function updateStatus (url) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: true,
            })
            swalWithBootstrapButtons.fire({
                title: 'Perhatian',
                text: "Apakah Anda yakin ingin meluluskan siswa ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'rgb(48, 133, 214)',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Ya, Aktifkan!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(url, {
                            '_method': 'put'
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
            });
        }

    </script>
@endpush