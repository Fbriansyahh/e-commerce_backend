<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    // ✅ GET: Ambil semua banner
    public function index()
    {
        return response()->json(Banner::latest()->get());
    }

    // ✅ POST: Buat banner baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'image' => 'required|string', // Path gambar atau URL
            'link'  => 'nullable|string',
        ]);

        $banner = Banner::create($request->all());

        return response()->json([
            'message' => 'Banner created successfully',
            'data' => $banner
        ], 201);
    }

    // ✅ GET: Ambil 1 banner by ID
    public function show($id)
    {
        $banner = Banner::find($id);

        if (!$banner) {
            return response()->json(['message' => 'Banner not found'], 404);
        }

        return response()->json($banner);
    }

    // ✅ PUT/PATCH: Update banner
    public function update(Request $request, $id)
    {
        $banner = Banner::find($id);

        if (!$banner) {
            return response()->json(['message' => 'Banner not found'], 404);
        }

        $request->validate([
            'title' => 'sometimes|required|string',
            'image' => 'sometimes|required|string',
            'link'  => 'nullable|string',
        ]);

        $banner->update($request->all());

        return response()->json([
            'message' => 'Banner updated successfully',
            'data' => $banner
        ]);
    }

    // ✅ DELETE: Hapus banner
    public function destroy($id)
    {
        $banner = Banner::find($id);

        if (!$banner) {
            return response()->json(['message' => 'Banner not found'], 404);
        }

        $banner->delete();

        return response()->json(['message' => 'Banner deleted successfully']);
    }
}
