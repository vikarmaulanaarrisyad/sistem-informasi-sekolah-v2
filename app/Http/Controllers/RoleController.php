<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('admin.roles.index');
    }

    /**
     * Display a listing of the json.
     *
     * @return \Illuminate\Http\Response
     */
    public function data(Request $request)
    {
        $roles = Role::all();

        return datatables($roles)
            ->addIndexColumn()
            ->editColumn('created_at', function ($roles) {
                return tanggal_indonesia($roles->created_at);
            })
            ->editColumn('updated_at', function ($roles) {
                return tanggal_indonesia($roles->updated_at);
            })
            ->addColumn('aksi', function ($roles) {
                return '
                <button onclick="editForm(`' . route('permission.show', $roles->id) . '`)" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i> Edit</button>
                <button  onclick="deleteData(`' . route('permission.destroy', $roles->id) . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                ';
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
