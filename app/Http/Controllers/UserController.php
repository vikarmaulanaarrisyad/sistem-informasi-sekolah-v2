<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('admin.user.index');
    }

    /**
     * Display a listing of the JSON.
     *
     * @return \Illuminate\Http\Response
     */
    public function data (Request $request)
    {
        $users = User::with('roles')->get();

        return datatables($users)
            ->addIndexColumn()
            ->addColumn('role', function ($users) {
               foreach ($users->roles as  $user) {
                    if ($user->name == 'admin') {
                        return '<span class="badge badge-danger">Admin</span>';
                    } else if ($user->name == 'kepala sekolah') {
                        return '<span class="badge badge-info">Kepala Madrasah</span>';
                    } else if ($user->name == 'guru') {
                        return '<span class="badge badge-warning">Guru</span>';
                    } else {
                        return '<span class="badge badge-success">Siswa</span>';
                    }
               }
            })
            ->addColumn('aksi', function ($users) {
                return '
                <button onclick="editForm(`' . route('role.show', $users->id) . '`)" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i> Edit</button>
                <button  onclick="deleteData(`' . route('role.destroy', $users->id) . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
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
    public function show(User $user)
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
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
