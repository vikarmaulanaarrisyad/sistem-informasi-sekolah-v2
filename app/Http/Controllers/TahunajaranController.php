<?php

namespace App\Http\Controllers;

use App\Models\Tahunajaran;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class TahunajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('tahun_ajaran_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view ('admin.tahunajaran.index');
    }

    public function data()
    {
        abort_if(Gate::denies('tahun_ajaran_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tahunAjaran = Tahunajaran::orderBy('created_at', 'ASC')->get();
        return datatables($tahunAjaran)
            ->addIndexColumn()
            ->editColumn('nama', function ($tahunAjaran) {
                return $tahunAjaran->nama .' '. $tahunAjaran->is_semester;
            })
            ->editColumn('is_active', function ($tahunAjaran) {
                return '
                    <button data-nama="'.$tahunAjaran->nama.'" id="updateStatus" onclick="updateStatus(`' . route('admin.tahun_ajaran.update_status', $tahunAjaran->id) . '`)"
                    class="btn btn-xs updateStatus btn-'.$tahunAjaran->statusColor() . '">'. $tahunAjaran->statusText() .'</button>
                ';
            })
            ->editColumn('created_at', function ($tahunAjaran) {
                return tanggal_indonesia($tahunAjaran->created_at);
            })
            ->editColumn('updated_at', function ($tahunAjaran) {
                return tanggal_indonesia($tahunAjaran->updated_at);
            })
            ->addColumn('aksi', function ($tahunAjaran) {
                $aksi = '';
                if ($tahunAjaran->is_active == 1) {
                    $aksi .= '<button onclick="editForm(`' . route('tahun-ajaran.show', $tahunAjaran->id) . '`)" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i> Edit</button>
                    ';
                } else {
                    $aksi = '
                    <button onclick="editForm(`' . route('tahun-ajaran.show', $tahunAjaran->id) . '`)" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i> Edit</button>
                    <button  onclick="deleteData(`' . route('tahun-ajaran.destroy', $tahunAjaran->id) . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>';
                }

                return $aksi;
            })
            ->escapeColumns([])
            ->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('tahun_ajaran_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:5',
            'is_semester' => 'required|in:Ganjil,Genap'
        ],
        [
            'is_semester.required' => 'Semester wajib diisi.',
            'is_semester.in' => 'Semester yang dipilih tidak valid.'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Gagal menyimpan data'],422);
        }

        $data = [
            'nama' => $request->nama,
            'is_active' => 0,
            'is_semester' => $request->is_semester
        ];

        Tahunajaran::create($data);

        return response()->json(['message' => 'Tahun Pelajaran Berhasil Disimpan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tahunajaran  $tahunajaran
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(Gate::denies('tahun_ajaran_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tahunAjaran = Tahunajaran::findOrfail($id);
        return response()->json(['data' => $tahunAjaran]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tahunajaran  $tahunajaran
     * @return \Illuminate\Http\Response
     */
    public function edit(Tahunajaran $tahunajaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tahunajaran  $tahunajaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tahunPelajaran = Tahunajaran::findOrfail($id);

        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:5',
            'is_semester' => 'required'
        ],
        [
            'is_semester.required' => 'Semester wajib diisi.'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Gagal menyimpan data'],422);
        }

        $data = [
            'nama' => $request->nama,
            'is_semester' => $request->is_semester
        ];

        $tahunPelajaran->update($data);

        return response()->json(['message' => 'Tahun Pelajaran Berhasil Disimpan']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tahunajaran  $tahunajaran
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('tahun_ajaran_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tahunPelajaran = Tahunajaran::findOrfail($id);

        if ($tahunPelajaran->is_active == 0) {
            $tahunPelajaran->delete();
            return response()->json(['message' => 'Tahun Pelajaran Berhasil Dihapus']);
        } 

        return response()->json(['message' => 'Tahun Pelajaran Gagal Dihapus'],400);
    }

    public function updateStatus($id) {
        $tahunAjaran = Tahunajaran::all();

        foreach ($tahunAjaran as $item) {
            $item->update(['is_active' => 0]);
        }

        $tahunPelajaran = Tahunajaran::find($id);
        $tahunPelajaran->update(['is_active' => 1]);

        return response()->json(['message' => 'Tahun Pelajaran Berhasil Diaktifkan']);
    }
}
