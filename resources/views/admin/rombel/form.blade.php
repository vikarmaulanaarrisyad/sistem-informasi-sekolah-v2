<x-modal data-backdrop="static" data-keyboard="false">
    <x-slot name="title">
        Tambah Data Kelas
    </x-slot>

    @method('POST')
    <div class="row">
        <input type="hidden" name="tahun_ajaran_id" value="{{ $tahunAjaran->id }}">
        <div class="col-lg-12">
            <div class="form-group">
                <label for="nama_kelas">Nama Kelas</label>
                <input type="text" name="nama_kelas" class="form-control" placeholder="Nama kelas" autocomplete="off">
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label for="rombel">Rombel</label>
                <input type="text" name="rombel" class="form-control" placeholder="Jenis rombel" autocomplete="off">
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label for="kapasitas_kls">Kapasitas Kelas</label>
                <input type="number" name="kapasitas_kls" class="form-control" placeholder="Kapasitas kelas" autocomplete="off">
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label for="kapasitas_kls">Wali Kelas</label>
                <select name="guru_id" id="guru_id" class="custom-select">
                    <option disabled selected>Pilih Guru</option>
                    @foreach ($guru as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_guru }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    
    <x-slot name="footer">
        <button type="button" onclick="submitForm(this.form)" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Simpan</button>
    </x-slot>

</x-modal>