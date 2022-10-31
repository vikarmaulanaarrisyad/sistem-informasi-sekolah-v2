<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all();
        return view ('admin.user.index', compact('roles'));
    }

    /**
     * Display a listing of the JSON.
     *
     * @return \Illuminate\Http\Response
     */
    public function data (Request $request)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::orderBy('name', 'asc')
            ->filter($request)
            ->get();

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
                $aksi = '';
                if ($users->hasRole('admin')) {
                    $aksi .= '<button onclick="editForm(`' . route('users.show', $users->id) . '`)" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i> Edit</button>';
                } else {
                    $aksi = '<button onclick="editForm(`' . route('users.show', $users->id) . '`)" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i> Edit</button>
                    <button  onclick="deleteData(`' . route('users.destroy', $users->id) . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>';
                }
                return $aksi;
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
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required',
        ], [
            'name.required' => 'Nama Lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah ada sebelumnya.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah ada sebelumnya.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Gagal menyimpan data'],422);
        }

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ];

        
        DB::beginTransaction();
        try {
             // Step 1 : Create User
             $user = User::create($data);

            // Step 2 : create Role
            $user->assignRole($request->role);

            DB::commit();

            return response()->json(['message' => 'User berhasil disimpan.']);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();

            return response()->json(['message' => 'Something Went Wrong!'],422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->role = $user->roles;
        return response()->json(['data' => $user]);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:users,username,'. $user->id,
            'email' => 'required|email|unique:users,email,'. $user->id,
            'password' => 'nullable|min:6',
            'role' => 'required',
        ], [
            'name.required' => 'Nama Lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah ada sebelumnya.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah ada sebelumnya.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Gagal menyimpan data'],422);
        }

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ];

        if ($request->password != '') {
            $data['password'] = Hash::make($request->password);
        }

        DB::beginTransaction();
        try {
             // Step 1 : Create User
             $user->update($data);

            // Step 2 : create Role
            $user->syncRoles($request->role);

            DB::commit();

            return response()->json(['message' => 'User berhasil disimpan.']);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();

            return response()->json(['message' => 'Something Went Wrong!'],422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->hasRole('admin')) {
            return response()->json(['message' => 'Tidak dapat menghapus user ini'],422);
        }

        $user->delete();
        $user->syncRoles($user->role);

        return response()->json(['message' => 'User berhasil dihapus']);
    }
}
