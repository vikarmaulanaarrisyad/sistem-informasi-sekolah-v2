@extends('layouts.app')

@section('title', 'Detail Rombel')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('rombel.index') }}">Rombongan Belajar</a></li>
    <li class="breadcrumb-item active">Detail Rombongan Belajar</li>
@endsection

@section('content')

<div class="row"></div>
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <button onclick="addRombelSiswa(`{{ $rombel->id }}`)" class="btn btn-sm btn-primary float-right"><i class="fas fa-plus-circle"></i> Tambah Siswa</button>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-lg-4">
                        <h4 for="">Tahun Pelajaran</h4>
                        <p>{{ $rombel->tahun_ajaran->nama }}</p>
                    </div>
                    <div class="col-lg-4">
                        <h4 for="">Semester</h4>
                        <p>{{ $rombel->tahun_ajaran->is_semester }}</p>
                    </div>
                    <div class="col-lg-4">
                        <h4 for="">Kurikulum</h4>
                        <p>{{ $rombel->kurikulum->nama_kurikulum }}</p>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-lg-4">
                        <h4 for="">Nama Rombel</h4>
                        <p>{{ $rombel->nama_rombel }}</p>
                    </div>
                    <div class="col-lg-4">
                        <h4 for="">Wali Kelas</h4>
                        <p>{{ $rombel->guru()->nama_guru ?? 'Belum ada wali kelas' }}</p>
                    </div>
                    <div class="col-lg-4">
                        <h4>Ruangan</h4>
                        <p>{{ $rombel->ruangan->nama_ruangan }}</p>
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        
        function addRombelSiswa ($rombelId) {
            alert($rombelId);
        }

    </script>
@endpush