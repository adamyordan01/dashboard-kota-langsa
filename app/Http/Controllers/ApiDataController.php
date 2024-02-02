<?php

namespace App\Http\Controllers;

use App\Models\ApiData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ApiCategory;

class ApiDataController extends Controller
{
    public function index()
    {
        $dataApi = ApiData::orderBy('api_category_id', 'asc', 'name', 'asc')
            ->paginate(10);
        
        $categories = ApiCategory::orderBy('name', 'asc')->get();

        return view('api-data.index', compact('dataApi', 'categories'));
    }
    
    public function store(Request $request)
    {
        // api_category_id, name, url, method, is_active
        $validator = Validator::make($request->all(), [
            'category' => 'required|integer',
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'method' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
        ], [
            'category.required' => 'Kategori API harus diisi',
            'category.integer' => 'Kategori API harus berupa angka',
            'name.required' => 'Nama API harus diisi',
            'name.string' => 'Nama API harus berupa string',
            'name.max' => 'Nama API maksimal 255 karakter',
            'url.required' => 'URL API harus diisi',
            'url.string' => 'URL API harus berupa string',
            'url.max' => 'URL API maksimal 255 karakter',
            'method.required' => 'Method API harus diisi',
            'method.string' => 'Method API harus berupa string',
            'method.max' => 'Method API maksimal 255 karakter',
            'is_active.boolean' => 'Status aktif API harus berupa boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'status' => 'error',
                'message' => 'Terjadi kesalahan',
                'errors' => $validator->errors(),
            ], 422);
        } else {
            $dataApi = ApiData::create([
                'api_category_id' => $request->category,
                'name' => $request->name,
                'url' => $request->url,
                'method' => $request->method ?? null,
                'is_active' => $request->is_active ?? 1,
            ]);

            if ($dataApi) {
                return response()->json([
                    'code' => 201,
                    'status' => 'success',
                    'message' => 'Data API berhasil ditambahkan',
                    'data' => $dataApi,
                ], 201);
            } else {
                return response()->json([
                    'code' => 500,
                    'status' => 'error',
                    'message' => 'Data API gagal ditambahkan',
                ], 500);
            }
        }
    }

    public function getApiDataDetail(Request $request)
    {
        $dataApi = ApiData::where('id', $request->id)->first();

        // dd($dataApi);

        if ($dataApi) {
            return response()->json($dataApi, 200);
        } else {
            return response()->json([
                'code' => 404,
                'status' => 'error',
                'message' => 'Data API tidak ditemukan',
            ], 404);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:api_data,id',
            'category' => 'required|integer',
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'method' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
        ], [
            'id.required' => 'ID API harus diisi',
            'id.integer' => 'ID API harus berupa angka',
            'id.exists' => 'ID API tidak ditemukan',
            'category.required' => 'Kategori API harus diisi',
            'category.integer' => 'Kategori API harus berupa angka',
            'name.required' => 'Nama API harus diisi',
            'name.string' => 'Nama API harus berupa string',
            'name.max' => 'Nama API maksimal 255 karakter',
            'url.required' => 'URL API harus diisi',
            'url.string' => 'URL API harus berupa string',
            'url.max' => 'URL API maksimal 255 karakter',
            'method.required' => 'Method API harus diisi',
            'method.string' => 'Method API harus berupa string',
            'method.max' => 'Method API maksimal 255 karakter',
            'is_active.boolean' => 'Status aktif API harus berupa boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'status' => 'error',
                'message' => 'Terjadi kesalahan',
                'errors' => $validator->errors(),
            ], 422);
        } else {
            $dataApi = ApiData::find($request->id);

            if ($dataApi) {
                $dataApi->update([
                    'api_category_id' => $request->category,
                    'name' => $request->name,
                    'url' => $request->url,
                    'method' => $request->method ?? null,
                    'is_active' => 1
                ]);

                return response()->json([
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Data API berhasil diperbarui',
                    'data' => $dataApi,
                ], 200);
            } else {
                return response()->json([
                    'code' => 404,
                    'status' => 'error',
                    'message' => 'Data API tidak ditemukan',
                ], 404);
            }
        }
    }
}
