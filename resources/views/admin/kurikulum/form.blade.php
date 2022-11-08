<x-modal data-backdrop="static" data-keyboard="false">
    <x-slot name="title">
        Tambah Data Kurikulum
    </x-slot>

    @method('POST')
    <div class="row">
        <input type="hidden" name="tahun_ajaran_id" value="{{ $tahunAjaran->id }}">

        <div class="col-lg-12">
            <div class="form-group">
                <label for="nama_kurikulum">Kurikulum</label>
                <input type="text" name="nama_kurikulum" class="form-control" placeholder="Kurikulum 2013" autocomplete="off">
            </div>
        </div>
    </div>
    
    <x-slot name="footer">
        <button type="button" onclick="submitForm(this.form)" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Simpan</button>
    </x-slot>

</x-modal>