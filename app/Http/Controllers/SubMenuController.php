<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\SubMenu;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;

class SubMenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('submenus')
            ->orderBy('order', 'asc')
            ->get();

            // dd($menus);

        $selectMenus = Menu::orderBy('order', 'asc')
            ->get();
        return view('sub-menus.index', compact('menus', 'selectMenus'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'menu_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:1',
            'ispublic' => 'required|boolean',
            'isactive' => 'required|boolean',
        ], [
            'menu_id.required' => 'Menu harus diisi',
            'menu_id.integer' => 'Menu harus berupa angka',
            'name.required' => 'Nama submenu harus diisi',
            'name.string' => 'Nama submenu harus berupa string',
            'name.max' => 'Nama submenu maksimal 255 karakter',
            'icon.string' => 'Icon submenu harus berupa string',
            'icon.max' => 'Icon submenu maksimal 255 karakter',
            'url.string' => 'URL submenu harus berupa string',
            'url.max' => 'URL submenu maksimal 255 karakter',
            'order.integer' => 'Urutan submenu harus berupa angka',
            'order.min' => 'Urutan submenu minimal 1',
            'ispublic.required' => 'Status publik submenu harus diisi',
            'ispublic.boolean' => 'Status publik submenu harus berupa boolean',
            'isactive.required' => 'Status aktif submenu harus diisi',
            'isactive.boolean' => 'Status aktif submenu harus berupa boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'status' => 'error',
                'message' => 'Terjadi kesalahan',
                'errors' => $validator->errors(),
            ], 422);
        } else {
            $subMenu = SubMenu::create([
                'menu_id' => $request->menu_id,
                'name' => Str::title($request->name),
                'slug' => Str::slug($request->name),
                'icon' => $request->icon,
                'url' => $request->url ? Str::lower(Str::replace(' ', '-', $request->url)) : null,
                'order' => $request->order,
                'is_public' => $request->ispublic,
                'is_active' => $request->isactive,
            ]);

            // forget cache after create new submenu
            Cache::forget('private-menu');
            Cache::forget('public-menu');

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Submenu berhasil ditambahkan',
                'data' => $subMenu,
            ], 200);
        }
    }

    public function getSubMenuDetail(Request $request)
    {
        $subMenu = SubMenu::find($request->id);

        $response = [];

        $response['id'] = $subMenu->id;
        $response['menu_id'] = $subMenu->menu_id;
        $response['name'] = $subMenu->name;
        $response['icon'] = $subMenu->icon;
        $response['url'] = $subMenu->url;
        $response['order'] = $subMenu->order;
        $response['ispublic'] = $subMenu->is_public;
        $response['isactive'] = $subMenu->is_active;

        return response()->json($response, 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'menu_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:1',
            'ispublic' => 'required|boolean',
            'isactive' => 'required|boolean',
        ], [
            'menu_id.required' => 'Menu harus diisi',
            'menu_id.integer' => 'Menu harus berupa angka',
            'name.required' => 'Nama submenu harus diisi',
            'name.string' => 'Nama submenu harus berupa string',
            'name.max' => 'Nama submenu maksimal 255 karakter',
            'icon.string' => 'Icon submenu harus berupa string',
            'icon.max' => 'Icon submenu maksimal 255 karakter',
            'url.string' => 'URL submenu harus berupa string',
            'url.max' => 'URL submenu maksimal 255 karakter',
            'order.integer' => 'Urutan submenu harus berupa angka',
            'order.min' => 'Urutan submenu minimal 1',
            'ispublic.required' => 'Status publik submenu harus diisi',
            'ispublic.boolean' => 'Status publik submenu harus berupa boolean',
            'isactive.required' => 'Status aktif submenu harus diisi',
            'isactive.boolean' => 'Status aktif submenu harus berupa boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'status' => 'error',
                'message' => 'Terjadi kesalahan',
                'errors' => $validator->errors(),
            ], 422);
        } else {
            $subMenu = SubMenu::find($request->id);

            $subMenu->update([
                'menu_id' => $request->menu_id,
                'name' => Str::title($request->name),
                'slug' => Str::slug($request->name),
                'icon' => $request->icon,
                'url' => $request->url ? Str::lower(Str::replace(' ', '-', $request->url)) : null,
                'order' => $request->order,
                'is_public' => $request->ispublic,
                'is_active' => $request->isactive,
            ]);

            // forget cache after update menu
            Cache::forget('private-menu');
            Cache::forget('public-menu');

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Submenu berhasil diupdate',
                'data' => $subMenu,
            ], 200);
        }
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer',
            'menu_id' => 'required|integer|exists:menus,id',
        ]);

        // dd($request->all());

        foreach ($request->ids as $index => $id) {
            DB::table('sub_menus')->where('id', $id)->update([
                'order' => $index + 1,
                'menu_id' => $request->menu_id,
            ]);
            // SubMenu::where('id', $id)->update([
            //     'order' => $index + 1,
            //     'menu_id' => $request->menu_id,
            // ]);
        }

        $orders = Menu::find($request->menu_id)
            ->submenus()
            ->pluck('order', 'id');

        // forget cache after reorder menu
        Cache::forget('private-menu');
        Cache::forget('public-menu');

        return response(compact('orders'), Response::HTTP_OK);
    }
}
