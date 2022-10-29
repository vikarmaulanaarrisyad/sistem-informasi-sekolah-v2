<x-modal data-backdrop="static" data-keyboard="false">
    <x-slot name="title">
        Tambah Data Roles
    </x-slot>

    @method('POST')
    <div class="col-lg-12">
        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" name="name" class="form-control" placeholder="Wajib diisi" autocomplete="off">
        </div>
    </div>

    <x-slot name="footer">
        <button type="button" onclick="submitForm(this.form)" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Simpan</button>
    </x-slot>

</x-modal>