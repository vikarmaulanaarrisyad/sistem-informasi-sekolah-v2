<x-modal size="modal-lg" data-backdrop="static" data-keyboard="false">
    <x-slot name="title">
        Tambah Data User
    </x-slot>

    @method('POST')
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" autocomplete="off">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Username" autocomplete="off">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email aktif" autocomplete="off">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="off">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="roles">Role</label>
                <select class="custom-select rounded-0" id="roles" name="role">
                    <option disabled selected>Pilih Role</option>
                    @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <x-slot name="footer">
        <button type="button" onclick="submitForm(this.form)" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Simpan</button>
    </x-slot>

</x-modal>