@extends('layouts.app')

@section('title', 'Users')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">User List</li>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12 col-md-12">
        <x-card>
            <x-slot name="header">
                @can('user_create')
                <button onclick="addForm(`{{ route('users.store') }}`)" class="btn btn-sm btn-primary"><i
                    class="fas fa-plus-circle"></i> Tambah User</button>
                @endcan
            </x-slot>

            <div class="d-flex mb-4">
                <div class="form-group">
                    <select name="roles2" id="roles2" class="custom-select rounded-5">
                        <option disabled selected>Semua Role</option>
                        @foreach ($roles as  $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>


            <x-table>
                <x-slot name="thead">
                        <th width="5%">No</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                </x-slot>
            </x-table>
        </x-card>
    </div>
</div>
@include('admin.user.form')
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
        $('[name=roles2]').on('change', function () {
            table.ajax.reload();
        })

    </script>
@endpush