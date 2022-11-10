<?php

namespace App\Http\Controllers;

use App\Models\Jenisruang;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('ruangan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $jenisRuangan = Jenisruang::all();

        return view ('admin.ruangan.index', compact('jenisRuangan'));
    }
    public function data(Request $request)
    {
        abort_if(Gate::denies('ruangan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ruangan = Ruangan::orderBy('nama_ruangan','ASC')->get();

        return datatables($ruangan)
            ->addIndexColumn()
            ->editColumn('jenis_ruangan', function ($ruangan) {
                return $ruangan->jenis_ruang->nama_ruang;
            })
            ->editColumn('gambar', function ($ruangan) {
                return '<img src="'. Storage::disk('public')->url($ruangan->foto_ruangan) .'" class="img-fluid">';
            })
            ->editColumn('panjang_ruangan', function ($ruangan) {
                return $ruangan->panjang_ruangan .' M';
            })
            ->editColumn('lebar_ruangan', function ($ruangan) {
                return $ruangan->lebar_ruangan .' M';
            })
            ->addColumn('aksi', function ($ruangan) {
                return '
                <button onclick="editForm(`' . route('ruangan.show', $ruangan->id) . '`)" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i> Edit</button>
                <button  onclick="deleteData(`' . route('ruangan.destroy', $ruangan->id) . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>';

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
        abort_if(Gate::denies('ruangan_store'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rules = [
            'jenis_ruang_id' => 'required',
            'nama_ruangan' => 'required',
            'penggunaan_ruangan' => 'required|in:0,1,2',
            'tahun_dibangun' => 'required|date_format:Y-m-d',
            'panjang_ruangan' => 'required|numeric',
            'lebar_ruangan' => 'required|numeric',
            'foto_ruangan' => 'required|mimes:png,jpg,jpeg|min:200|max:2048'
        ];
        $message = [
            'jenis_ruang_id.required' => 'Jenis ruangan wajib diisi.',
            'nama_ruangan.required' => 'Nama ruangan wajib diisi',
            'tahun_dibangun.required' => 'Tanggal dibangun wajib diisi',
            'panjang_ruangan.required' => 'Panjang ruangan wajib diisi',
            'lebar_ruangan.required' => 'Lebar ruangan wajib diisi',
            'foto_ruangan.min' => 'File gambar minimal 200kb',
            'foto_ruangan.max' => 'File gambar maksimal 2 MB',
        ];

        $validator = Validator::make($request->all(),$rules,$message );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Tidak dapat menyimpan data'],422);
        }

        $data = $request->except('foto_ruangan');

        $data['foto_ruangan'] = upload('ruangan',$request->file('foto_ruangan'), 'ruangan');

        Ruangan::create($data);

        return response()->json(['message' => 'Ruangan Berhasil Disimpan.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ruangan  $ruangan
     * @return \Illuminate\Http\Response
     */
    public function show(Ruangan $ruangan)
    {
        abort_if(Gate::denies('ruangan_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

       $ruangan->foto_ruangan = Storage::disk('public')->url($ruangan->foto_ruangan);
        return response()->json(['data' => $ruangan]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ruangan  $ruangan
     * @return \Illuminate\Http\Response
     */
    public function edit(Ruangan $ruangan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ruangan  $ruangan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ruangan $ruangan)
    {
        $rules = [
            'jenis_ruang_id' => 'required',
            'nama_ruangan' => 'required',
            'penggunaan_ruangan' => 'required|in:0,1,2',
            'tahun_dibangun' => 'required|date_format:Y-m-d',
            'panjang_ruangan' => 'required|numeric',
            'lebar_ruangan' => 'required|numeric',
            'foto_ruangan' => 'nullable|mimes:png,jpg,jpeg|min:200|max:2048'
        ];
        $message = [
            'jenis_ruang_id.required' => 'Jenis ruangan wajib diisi.',
            'nama_ruangan.required' => 'Nama ruangan wajib diisi',
            'tahun_dibangun.required' => 'Tanggal dibangun wajib diisi',
            'panjang_ruangan.required' => 'Panjang ruangan wajib diisi',
            'lebar_ruangan.required' => 'Lebar ruangan wajib diisi',
            'foto_ruangan.min' => 'File gambar minimal 200kb',
            'foto_ruangan.max' => 'File gambar maksimal 2 MB',
        ];

        $validator = Validator::make($request->all(),$rules,$message );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Tidak dapat menyimpan data'],422);
        }

        $data = $request->except('foto_ruangan');

        if ($request->hasFile('foto_ruangan')) {
            if (Storage::disk('public')->exists($ruangan->foto_ruangan)) {
                Storage::disk('public')->delete($ruangan->foto_ruangan);
            }

            $data['foto_ruangan'] = upload('ruangan', $request->file('path_image'), 'ruangan');
        }

        $ruangan->update($data);

        return response()->json(['message' => 'Ruangan berhasil disimpan']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ruangan  $ruangan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ruangan $ruangan)
    {
        abort_if(Gate::denies('ruangan_destroy'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (Storage::disk('public')->exists($ruangan->foto_ruangan)) {
            Storage::disk('public')->delete($ruangan->foto_ruangan);
        }

        $ruangan->delete();

        return response()->json(['message' => 'Ruangan berhasil dihapus']);
    }
}
