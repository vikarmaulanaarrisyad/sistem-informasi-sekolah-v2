<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kurikulum;
use App\Models\Rombel;
use App\Models\Ruangan;
use App\Models\Tahunajaran;
use App\Models\TingkatRombel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Rules\Role;

class RombelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'ruangan' => Ruangan::where('jenis_ruang_id', 1)->select('nama_ruangan','id')->get(),
            'kurikulum' => Kurikulum::select('nama_kurikulum','id')->get(),
            'tingkat_rombel' => TingkatRombel::all(),
            'tahun_ajaran' => Tahunajaran::where('is_active',1)->pluck('id')->first(),
            'guru' => Guru::where('status','Guru')->select('gelar_belakang','nama_guru','id')->get()
        ];

        return view ('admin.rombel.index')->with($data);
    }

    public function data(Request $request)
    {

        abort_if(Gate::denies('rombel_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rombel = Rombel::filter($request)
            ->get();

        return datatables($rombel)
            ->addIndexColumn()
            ->editColumn('nama_rombel', function ($rombel) {
                return $rombel->nama_rombel;
            })
            ->editColumn('wali_kelas', function ($rombel) {
                if ($rombel->guru_id == NULL ) {
                    return 'Wali kelas Belum Diatur';
                }
                return $rombel->guru->nama_guru;
            })
            ->editColumn('nama_ruangan', function ($rombel) {
                return $rombel->ruangan->nama_ruangan;
            })
            ->editColumn('tingkat_rombel', function ($rombel) {
                return $rombel->tingkat_rombel->name;
            })
            ->editColumn('jumlah_siswa', function ($rombel) {
                return '0' . '/'. $rombel->jumlah_siswa;
            })
            ->addColumn('aksi', function ($rombel) {
                return '
                <a href="'.route('admin.rombel.detail', $rombel->id).'" class="btn btn-sm btn-info"><i class="fas fa-search"></i> Detail</a>
                <button onclick="editForm(`' . route('rombel.show', $rombel->id) . '`)" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i> Edit</button>
                <button  onclick="deleteData(`' . route('rombel.destroy', $rombel->id) . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>';

            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view ('admin.rombel.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('rombel_store'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $validator = Validator::make($request->all(), [
            'ruangan_id' => 'required',
            'tahun_ajaran_id'    => 'required',
            'kurikulum_id'    => 'required',
            'guru_id'    => 'nullable',
            'nama_rombel'    => 'required',
            'tingkat_rombel_id'    => 'required',
            'jumlah_siswa'    => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Gagal Menyimpan Data'],422);
        }

        $data = [
            'ruangan_id' => $request->ruangan_id,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
            'kurikulum_id' => $request->kurikulum_id,
            'guru_id' => $request->guru_id ?? Null,
            'tahun_ajaran_id' => $request->tahun_ajaran_id ?? Null,
            'nama_rombel' => $request->nama_rombel,
            'tingkat_rombel_id' => $request->tingkat_rombel_id,
            'jumlah_siswa' => $request->jumlah_siswa,
        ];

         $rombel = Rombel::create($data);
        return response()->json(['message' => 'Kelas Berhasil Disimpan', 'data' => $rombel]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rombel  $rombel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rombel = Rombel::findOrfail($id);

        return response()->json(['data' => $rombel]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rombel  $rombel
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        $rombel = Rombel::findOrfail($id);

        return view ('admin.rombel.detail',compact('rombel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rombel  $rombel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rombel $rombel)
    {
        $validator = Validator::make($request->all(), [
            'ruangan_id' => 'required',
            'tahun_ajaran_id'    => 'required',
            'kurikulum_id'    => 'required',
            'guru_id'    => 'nullable',
            'nama_rombel'    => 'required|min:1',
            'tingkat_rombel'    => 'required',
            'jumlah_siswa'    => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Gagal Menyimpan Data'],422);
        }

        $data = [
            'ruangan_id' => $request->ruangan_id,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
            'kurikulum_id' => $request->kurikulum_id,
            'guru_id' => $request->guru_id ?? Null,
            'tahun_ajaran_id' => $request->tahun_ajaran_id ?? Null,
            'nama_rombel' => $request->nama_rombel,
            'tingkat_rombel_id' => $request->tingkat_rombel_id,
            'jumlah_siswa' => $request->jumlah_siswa,
        ];

         $rombel = Rombel::update($data);

        return response()->json(['message' => 'Rombel Berhasil Disimpan', 'data' => $rombel]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rombel  $rombel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('rombel_destroy'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rombel = Rombel::findOrfail($id);

        $rombel->delete();

        return response()->json(['message' => 'Rombel Berhasil Dihapus']);
    }
}
