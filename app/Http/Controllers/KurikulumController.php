<?php

namespace App\Http\Controllers;

use App\Models\Kurikulum;
use App\Models\Tahunajaran;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class KurikulumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('kurikulum_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tahunAjaran = Tahunajaran::active()->first();

        return view ('admin.kurikulum.index', compact('tahunAjaran'));
    }

    public function data()
    {
        abort_if(Gate::denies('kurikulum_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kurikulum = Kurikulum::all();
        
        return datatables($kurikulum)
            ->addIndexColumn()
            ->editColumn('tahun_ajaran', function ($kurikulum) {
                if ($kurikulum->tahun_ajaran->is_active == 1) {
                return $kurikulum->tahun_ajaran->nama . ' '.$kurikulum->tahun_ajaran->is_semester . ' <span class="badge  badge-xs badge-success"><i class="fas fa-check"></i></span>';
                }
                return $kurikulum->tahun_ajaran->nama . ' '.$kurikulum->tahun_ajaran->is_semester;
            })
            ->editColumn('created_at', function ($kurikulum) {
                return tanggal_indonesia($kurikulum->created_at);
            })
            ->editColumn('updated_at', function ($kurikulum) {
                return tanggal_indonesia($kurikulum->updated_at);
            })
            ->addColumn('aksi', function ($kurikulum) {
                return '
                <button onclick="editForm(`' . route('kurikulum.show', $kurikulum->id) . '`)" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i> Edit</button>
                <button  onclick="deleteData(`' . route('kurikulum.destroy', $kurikulum->id) . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>';
                
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
        abort_if(Gate::denies('kurikulum_store'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $validator = Validator::make($request->all(), [
            'nama_kurikulum' => 'required',
            'tahun_ajaran_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Gagal Menyimpan Data'],422);
        }

        $data = [
            'nama_kurikulum' => $request->nama_kurikulum,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
        ];

        Kurikulum::create($data);

        return response()->json(['message' => 'Kurikulum Berhasil Disimpan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kurikulum  $kurikulum
     * @return \Illuminate\Http\Response
     */
    public function show(Kurikulum $kurikulum)
    {

        abort_if(Gate::denies('kurikulum_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response()->json(['data' => $kurikulum]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kurikulum  $kurikulum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kurikulum $kurikulum)
    {
        
        $validator = Validator::make($request->all(), [
            'nama_kurikulum' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Gagal Menyimpan Data'],422);
        }

        $data = [
            'nama_kurikulum' => $request->nama_kurikulum,
        ];

       $kurikulum->update($data);

        return response()->json(['message' => 'Kurikulum Berhasil Disimpan']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kurikulum  $kurikulum
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kurikulum $kurikulum)
    {
        abort_if(Gate::denies('kurikulum_destroy'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kurikulum->delete();

        return response()->json(['message' => 'Kurikulum Berhasil Dihapus']);
    }
}
