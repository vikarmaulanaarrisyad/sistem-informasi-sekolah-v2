<x-modal data-backdrop="static" data-keyboard="false">
    <x-slot name="title">
        Tambah Data Ruangan
    </x-slot>

    @method('POST')
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <label for="jenis_ruang_id">Jenis Ruangan</label>
                <select name="jenis_ruang_id" id="jenis_ruang_id" class="custom-select">
                    <option disabled selected>Jenis Ruangan</option>
                    @foreach ($jenisRuangan as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_ruang }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label for="nama_ruangan">Nama Ruangan</label>
                <input type="text" name="nama_ruangan" class="form-control" placeholder="Nama Ruangan" autocomplete="off">
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label for="penggunaan_ruangan">Penggunaan Ruangan</label>
                <select name="penggunaan_ruangan" id="penggunaan_ruangan">
                    <option disabled selected>Pilih Penggunaan Ruangan</option>
                    <option value="0">Tidak digunakan untuk ruang kelas</option>
                    <option value="1">Digunakan untuk ruang kelas utama</option>
                    <option value="2">Digunakan untuk ruang kelas tambahan</option>
                </select>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label for="kapasitas_kls">Tanggal Dibangun</label>

            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label for="panjang_ruangan">Panjang Ruangan</label>
                <input type="number" name="panjang_ruangan" id="panjang_ruangan" class="form-control">
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label for="lebar_ruangan">Lebar Ruangan</label>
                <input type="number" name="lebar_ruangan" id="lebar_ruangan" class="form-control">
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label for="foto_ruangan">Gambar</label>
                <input type="file" name="foto_ruangan" id="foto_ruangan" class="form-control">
            </div>
        </div>
    </div>
    
    <x-slot name="footer">
        <button type="button" onclick="submitForm(this.form)" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Simpan</button>
    </x-slot>

</x-modal>