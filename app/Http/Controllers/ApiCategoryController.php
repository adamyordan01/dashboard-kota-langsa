<?php

namespace App\Http\Controllers;

use App\Models\ApiCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiCategoryController extends Controller
{
    public function index()
    {
        $apiCategories = ApiCategory::orderBy('name', 'asc')
            ->paginate(10);
        return view('api-categories.index', compact('apiCategories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama kategori API harus diisi',
            'name.string' => 'Nama kategori API harus berupa string',
            'name.max' => 'Nama kategori API maksimal 255 karakter',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'status' => 'error',
                'message' => 'Terjadi kesalahan',
                'errors' => $validator->errors(),
            ], 422);
        } else {
            $apiCategory = ApiCategory::create([
                'name' => $request->name,
            ]);

            if ($apiCategory) {
                return response()->json([
                    'code' => 201,
                    'status' => 'success',
                    'message' => 'Kategori API berhasil ditambahkan',
                    'data' => $apiCategory,
                ], 201);
            } else {
                return response()->json([
                    'code' => 500,
                    'status' => 'error',
                    'message' => 'Kategori API gagal ditambahkan',
                ], 500);
            }
        }
    }

    public function getApiCategoryDetail(Request $request)
    {
        $apiCategory = ApiCategory::find($request->id);
        if ($apiCategory) {
            return response()->json($apiCategory, 200);
        } else {
            return response()->json([
                'code' => 404,
                'status' => 'error',
                'message' => 'Kategori API tidak ditemukan',
            ], 404);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:1',
            'name' => 'required|string|max:255',
        ], [
            'id.required' => 'ID kategori API harus diisi',
            'id.integer' => 'ID kategori API harus berupa angka',
            'id.min' => 'ID kategori API minimal 1',
            'name.required' => 'Nama kategori API harus diisi',
            'name.string' => 'Nama kategori API harus berupa string',
            'name.max' => 'Nama kategori API maksimal 255 karakter',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'status' => 'error',
                'message' => 'Terjadi kesalahan',
                'errors' => $validator->errors(),
            ], 422);
        } else {
            $apiCategory = ApiCategory::find($request->id);
            if ($apiCategory) {
                $apiCategory->name = $request->name;
                $apiCategory->save();

                return response()->json([
                    'code' => 201,
                    'status' => 'success',
                    'message' => 'Kategori API berhasil diperbarui',
                    'data' => $apiCategory,
                ], 201);
            } else {
                return response()->json([
                    'code' => 404,
                    'status' => 'error',
                    'message' => 'Kategori API tidak ditemukan',
                ], 404);
            }
        }
    }
}
