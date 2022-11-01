@extends('layouts.app')

@section('title', 'Profil Sekolah')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Edit Profil Sekolah</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 col-sm-12 col-md-12">
        <form action="{{ route('instansi.store') }}" method="post">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-school"></i> Edit Profil Sekolah</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="nsm_instansi">NSM Sekolah</label>
                                <input type="text" name="nsm_instansi" id="nsm_instansi" class="form-control" autocomplete="off" value="{{ $instansi->nsm_instansi }}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="npsn_instansi">NPSN Sekolah</label>
                                <input type="text" name="npsn_instansi" id="npsn_instansi" class="form-control" autocomplete="off" value="{{ $instansi->npsn_instansi }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="nama_instansi">Nama Sekolah</label>
                                <input type="text" name="nama_instansi" id="nama_instansi" class="form-control" autocomplete="off" value="{{ $instansi->nama_instansi }}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="nama_sekolah">Kepala Sekolah</label>
                                <select name="" id="" class="custom-select">
                                    <option disabled selected>Pilih Kepala Sekolah</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="alamat_instansi">Alamat Sekolah</label>
                                <input type="text" name="alamat_instansi" id="alamat_instansi" class="form-control" autocomplete="off" value="{{ $instansi->alamat_instansi }}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="email_instansi">Email Sekolah</label>
                                <input type="text" name="email_instansi" id="email_instansi" class="form-control" autocomplete="off" value="{{ $instansi->email_instansi }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="logo_instansi">Logo Sekolah</label>
                                <input type="file" name="logo_instansi" id="logo_instansi" class="form-control" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" onclick="submitForm(this.form)" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@include('layouts.include.datatables')

@push('scripts')
    <script>
        let modal = '#modal-form';
        let table;

        table = $('.table').DataTable({
            processing: true,
            autoWidth: true,
            ajax: {
                url: '{{ route('admin.user.data') }}',
                data: function (d) {
                    d.roles = $('[name=roles2]').val();
                }
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false},
                {data: 'avatar'},
                {data: 'name'},
                {data: 'email'},
                {data: 'role'},
                {data: 'aksi', sortable: false, searchable: false},
            ]
        });

        function addForm (url, title = 'Tambah User Baru') {
            $(modal).modal('show')
            $(`${modal} .modal-title`).text(title)
            $(`${modal} form`).attr('action',url)
            $(`${modal} [name=_method]`).val('POST')
            resetForm(`${modal} form`)
        }

        function editForm(url, title = 'Edit User') {
            $.get(url)
                .done(response => {
                    $(`${modal}`).modal('show');
                    $(`${modal} .modal-title`).text(title);
                    $(`${modal} form`).attr('action', url);
                    $(`${modal} [name=_method]`).val('PUT');
                    resetForm(`${modal} form`);
                    loopForm(response.data);

                    let selectedRoles = [];
                    response.data.role.forEach(item => {
                        selectedRoles.push(item.id);
                    });
                    $('#roles')
                        .val(selectedRoles)
                        .trigger('change');
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
                    if (response.status = 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        })
                        window.location.reload();
                    }
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
        $('[name=roles2]').on('change', function () {
            table.ajax.reload();
        })

    </script>
@endpush