<x-modal data-backdrop="static" data-keyboard="false">
    <x-slot name="title">
        Tambah Data Kelas
    </x-slot>

    @method('POST')
    <div class="row">
        <input type="hidden" name="tahun_ajaran_id" value="{{ $tahun_ajaran}}">
        <div class="col-lg-12">
            <div class="form-group">
                <label for="ruangan_id">Nama Ruangan</label>
                <select name="ruangan_id" id="ruangan_id" class="custom-select select2">
                    <option disabled selected>Pilih Ruangan</option>
                    @foreach ($ruangan as $data)
                        <option value="{{ $data->id }}">{{ $data->nama_ruangan }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label for="guru_id">Wali Kelas</label>
                <select name="guru_id" id="guru_id" class="custom-select">
                    <option disabled selected>Pilih Guru</option>
                    @foreach ($guru as $data)
                        <option value="{{ $data->id }}">{{ $data->nama_guru }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label for="kurikulum_id">Kurikulum</label>
                <select name="kurikulum_id" id="kurikulum_id" class="custom-select">
                    <option disabled selected>Pilih Kurikulum</option>
                    @foreach ($kurikulum as $data)
                        <option value="{{ $data->id }}">{{ $data->nama_kurikulum }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label for="nama_rombel">Rombel</label>
                <input type="text" name="nama_rombel" class="form-control" placeholder="Jenis rombel" autocomplete="off">
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label for="tingkat_rombel_id">Tingkat Rombel</label>
               <select name="tingkat_rombel_id" id="tingkat_rombel_id" class="custom-select">
                <option disabled selected>Pilih Tingkat Rombel</option>
                @foreach ($tingkat_rombel as $data )
                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                @endforeach
               </select>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label for="jumlah_siswa">Kapasitas Rombel</label>
                <input type="number" name="jumlah_siswa" class="form-control" placeholder="Kapasitas Rombel" autocomplete="off">
            </div>
        </div>

    </div>
    
    <x-slot name="footer">
        <button type="button" onclick="submitForm(this.form)" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Simpan</button>
    </x-slot>

</x-modal>