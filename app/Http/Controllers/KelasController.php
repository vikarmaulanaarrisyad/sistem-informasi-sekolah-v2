<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Tahunajaran;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('kelas_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = [
            'guru' => Guru::all(),
            'tahunAjaran' => Tahunajaran::active()->first(),
            'getAllTahunAjaran' => Tahunajaran::all()
        ];
        return view ('admin.kelas.index')->with($data);
    }

    public function data(Request $request)
    {
        $kelas = Kelas::orderBy('nama_kelas','ASC')
            ->filter($request)
            ->get();

        return datatables($kelas)
            ->addIndexColumn()
            ->editColumn('nama_kelas', function ($kelas) {
                return $kelas->nama_kelas . ' ' .$kelas->rombel;
            })
            ->editColumn('wali_kelas', function ($kelas) {
                if ($kelas->guru_id == NULL) {
                    return 'Wali Kelas Belum Diatur';
                } 
                return $kelas->wali_kelas->nama_guru;
            })
            ->editColumn('kapasitas', function ($kelas) {
                return $kelas->kapasitas_kls;
            })
            ->addColumn('aksi', function ($kelas) {
                return '
                <button onclick="editForm(`' . route('kelas.show', $kelas->id) . '`)" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i> Edit</button>
                <button  onclick="deleteData(`' . route('kelas.destroy', $kelas->id) . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>';
                
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('kelas_store'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'required',
            'rombel'    => 'required',
            'kapasitas_kls'    => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Gagal Menyimpan Data'],422);
        }

        $data = [
            'nama_kelas' => $request->nama_kelas,
            'rombel' => $request->rombel,
            'kapasitas_kls' => $request->kapasitas_kls,
            'guru_id' => $request->guru_id ?? Null,
            'tahun_ajaran_id' => $request->tahun_ajaran_id ?? Null
        ];

         $kelas = Kelas::create($data);
        return response()->json(['message' => 'Kelas Berhasil Disimpan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kelas = Kelas::findOrfail($id);

        return response()->json(['data' => $kelas]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrfail($id);

        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'required',
            'rombel'    => 'required',
            'kapasitas_kls'    => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Gagal Menyimpan Data'],422);
        }

        $data = [
            'nama_kelas' => $request->nama_kelas,
            'rombel' => $request->rombel,
            'kapasitas_kls' => $request->kapasitas_kls,
            'guru_id' => $request->guru_id,
            'tahun_ajaran_id' => $request->tahun_ajaran_id
        ];

        $kelas->update($data);

        return response()->json(['message' => 'Kelas Berhasil Disimpan']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('kelas_destroy'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kelas = Kelas::findOrfail($id);

        $kelas->delete();

        return response()->json(['message' => 'Kelas Berhasil Dihapus']);
    }
}
