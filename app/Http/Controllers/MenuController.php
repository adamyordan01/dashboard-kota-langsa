<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::orderBy('order', 'asc')
            ->paginate(10);
        return view('menus.index', compact('menus'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:1',
            'ispublic' => 'required|boolean',
            'isactive' => 'required|boolean',
        ], [
            'name.required' => 'Nama menu harus diisi',
            'name.string' => 'Nama menu harus berupa string',
            'name.max' => 'Nama menu maksimal 255 karakter',
            'icon.required' => 'Icon menu harus diisi',
            'icon.string' => 'Icon menu harus berupa string',
            'icon.max' => 'Icon menu maksimal 255 karakter',
            'url.string' => 'URL menu harus berupa string',
            'url.max' => 'URL menu maksimal 255 karakter',
            'order.integer' => 'Urutan menu harus berupa angka',
            'order.min' => 'Urutan menu minimal 1',
            'ispublic.required' => 'Status publik menu harus diisi',
            'ispublic.boolean' => 'Status publik menu harus berupa boolean',
            'isactive.required' => 'Status aktif menu harus diisi',
            'isactive.boolean' => 'Status aktif menu harus berupa boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'status' => 'error',
                'message' => 'Terjadi kesalahan',
                'errors' => $validator->errors(),
            ], 422);
        } else {
            $menu = Menu::create([
                'name' => Str::title($request->name),
                'slug' => Str::slug($request->name),
                'icon' => $request->icon,
                'url' => $request->url ? Str::lower(Str::replace(' ', '-', $request->url)) : null,
                'order' => $request->order,
                'is_public' => $request->ispublic,
                'is_active' => $request->isactive,
            ]);

            // forget cache after create new menu
            Cache::forget('private-menu');
            Cache::forget('public-menu');

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Menu berhasil ditambahkan',
                'data' => $menu,
            ], 200);
        }
    }

    public function getMenuDetail(Request $request)
    {
        $menu = Menu::find($request->id);

        $response = [];

        $response['id'] = $menu->id;
        $response['name'] = $menu->name;
        $response['icon'] = $menu->icon;
        $response['url'] = $menu->url;
        $response['order'] = $menu->order;
        $response['ispublic'] = $menu->is_public;
        $response['isactive'] = $menu->is_active;
        
        return response()->json([
            'data' => $menu,
        ], 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:menus,id',
            'name' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:1',
            'ispublic' => 'required|boolean',
            'isactive' => 'required|boolean',
        ], [
            'id.required' => 'ID menu harus diisi',
            'id.integer' => 'ID menu harus berupa angka',
            'id.exists' => 'ID menu tidak ditemukan',
            'name.required' => 'Nama menu harus diisi',
            'name.string' => 'Nama menu harus berupa string',
            'name.max' => 'Nama menu maksimal 255 karakter',
            'icon.required' => 'Icon menu harus diisi',
            'icon.string' => 'Icon menu harus berupa string',
            'icon.max' => 'Icon menu maksimal 255 karakter',
            'url.string' => 'URL menu harus berupa string',
            'url.max' => 'URL menu maksimal 255 karakter',
            'order.integer' => 'Urutan menu harus berupa angka',
            'order.min' => 'Urutan menu minimal 1',
            'ispublic.required' => 'Status publik menu harus diisi',
            'ispublic.boolean' => 'Status publik menu harus berupa boolean',
            'isactive.required' => 'Status aktif menu harus diisi',
            'isactive.boolean' => 'Status aktif menu harus berupa boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'status' => 'error',
                'message' => 'Terjadi kesalahan',
                'errors' => $validator->errors(),
            ], 422);
        } else {
            $menu = Menu::find($request->id);

            $menu->update([
                'name' => Str::title($request->name),
                'slug' => Str::slug($request->name),
                'icon' => $request->icon,
                'url' => $request->url ? Str::lower(Str::replace(' ', '-', $request->url)) : null,
                'order' => $request->order,
                'is_public' => $request->ispublic,
                'is_active' => $request->isactive,
            ]);

            // forget cache after update new menu
            Cache::forget('private-menu');
            Cache::forget('public-menu');
            
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Menu berhasil diperbarui',
                'data' => $menu,
            ], 200);
        }
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer',
        ]);

        foreach ($request->ids as $index => $id) {
            DB::table('menus')->where('id', $id)->update([
                'order' => $index + 1,
            ]);
        }

        // forget cache after reorder menu
        Cache::forget('private-menu');
        Cache::forget('public-menu');

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
