<?php

namespace App\Http\Controllers;

use App\Models\Tahunajaran;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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

        $tahunAjaran = Tahunajaran::all();
        return datatables($tahunAjaran)
            ->addIndexColumn()
            ->editColumn('is_active', function ($tahunAjaran) {
                return '
                    <button data-nama="'.$tahunAjaran->nama.'" id="updateStatus" onclick="updateStatus(`' . route('admin.tahun_ajaran.update_status', $tahunAjaran->id) . '`)"
                    class="btn btn-xs updateStatus btn-'.$tahunAjaran->statusColor() . '">'. $tahunAjaran->statusText() .'</button>
                ';
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tahunajaran  $tahunajaran
     * @return \Illuminate\Http\Response
     */
    public function show(Tahunajaran $tahunajaran)
    {
        abort_if(Gate::denies('tahun_ajaran_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        //
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
    public function update(Request $request, Tahunajaran $tahunajaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tahunajaran  $tahunajaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tahunajaran $tahunajaran)
    {
        abort_if(Gate::denies('tahun_ajaran_destroy'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($tahunajaran->active()) {
            $tahunajaran->delete();
        } 

        return response()->json(['message' => 'Tahun Ajaran Tidak Dapat Dihapus'],400);
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
