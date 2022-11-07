<x-modal data-backdrop="static" data-keyboard="false">
    <x-slot name="title">
        Tambah Data Tahun Pelajaran
    </x-slot>

    @method('POST')
    <div class="col-lg-12">
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" name="nama" class="form-control" placeholder="Tahun Pelajaran 2020/2021" autocomplete="off">
        </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
            <label for="is_semester">Semester</label>
            <select name="is_semester" id="is_semester" class="custom-select">
                <option disabled selected>Pilih Semester</option>
                <option value="Ganjil">Ganjil</option>
                <option value="Genap">Genap</option>
            </select>
        </div>
    </div>

    <x-slot name="footer">
        <button type="button" onclick="submitForm(this.form)" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Simpan</button>
    </x-slot>

</x-modal>