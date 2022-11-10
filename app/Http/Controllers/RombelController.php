<?php

namespace App\Http\Controllers;

use App\Models\Rombel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class RombelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('admin.rombel.index');
    }

    public function data(Request $request)
    {

        abort_if(Gate::denies('kelas_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rombel = Rombel::orderBy('tingkat_rombel','ASC')
            ->filter($request)
            ->get();

        return datatables($rombel)
            ->addIndexColumn()
            ->editColumn('nama_rombel', function ($rombel) {
                return $rombel->nama_rombel;
            })
            ->editColumn('wali_kelas', function ($rombel) {
                if ($rombel->guru_id == NULL) {
                    return 'Wali kelas Belum Diatur';
                }
                return $rombel->guru->nama_guru;
            })
            ->editColumn('kapasitas', function ($rombel) {
                return $rombel->jumlah_siswa;
            })
            ->addColumn('aksi', function ($rombel) {
                return '
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
        return view ('admin.rombel.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rombel  $rombel
     * @return \Illuminate\Http\Response
     */
    public function show(Rombel $rombel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rombel  $rombel
     * @return \Illuminate\Http\Response
     */
    public function edit(Rombel $rombel)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rombel  $rombel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rombel $rombel)
    {
        //
    }
}
