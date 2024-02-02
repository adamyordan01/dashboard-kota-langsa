<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('name', 'asc')
            ->paginate(10);

        return view('roles.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama role harus diisi',
            'name.string' => 'Nama role harus berupa string',
            'name.max' => 'Nama role maksimal 255 karakter',
        ]);

        if ($validator->fails()){
            return response()->json([
                'code' => 422,
                'status' => 'error',
                'message' => 'Terjadi kesalahan',
                'errors' => $validator->errors(),
            ], 422);
        } else {
            $role = Role::create([
                'name' => Str::lower($request->name),
            ]);

            return response()->json([
                'code' => 201,
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
                'data' => $role,
            ], 201);
        }
    }

    public function getRoleDetail(Request $request)
    {
        $role = Role::find($request->id);

        $response = [
            'code'=>200,
            'status'=>'success',
            'message'=>'Data berhasil diambil',
            'data'=>$role,
        ];

        return response()->json($response, 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama role harus diisi',
            'name.string' => 'Nama role harus berupa string',
            'name.max' => 'Nama role maksimal 255 karakter',
        ]);

        if ($validator->fails()){
            return response()->json([
                'code' => 422,
                'status' => 'error',
                'message' => 'Terjadi kesalahan',
                'errors' => $validator->errors(),
            ], 422);
        } else {
            $role = Role::find($request->id);
            $role->name = Str::lower($request->name);
            $role->save();

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Data berhasil diubah',
                'data' => $role,
            ], 200);
        }
    }
}
