<?php

namespace App\Http\Controllers\Api;

use App\Models\Buku;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buku = Buku::orderBy('judul', 'asc')->get();
        return response()->json([
            'status' => true,
            'message' => 'Data Buku ditampilkan',
            'data' => $buku,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'judul' => 'required',
            'pengarang' => 'required',
            'tanggal_publikasi' => 'required|date',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambahkan data',
                'data' => $validator->errors(),
            ], 422);
        }
        $buku = Buku::create([
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'tanggal_publikasi' => $request->tanggal_publikasi,
        ]);

        // $dataBuku = new Buku;
        // $dataBuku->judul = $request->judul;
        // $dataBuku->pengarang = $request->pengarang;
        // $dataBuku->tanggal_publikasi = $request->tanggal_publikasi;
        // $buku = $dataBuku->save();

        if ($buku) {
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil ditambahkan',
                'data' => $buku
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambahkan data',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $buku = Buku::find($id);
        if ($buku) {
            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan',
                'data' => $buku,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak berhasil ditemukan',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'judul' => 'required',
            'pengarang' => 'required',
            'tanggal_publikasi' => 'required|date',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui data',
                'data' => $validator->errors(),
            ], 422);
        }

        $buku = Buku::find($id);
        if (!$buku) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
        $updatedBuku = $buku->update([
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'tanggal_publikasi' => $request->tanggal_publikasi,
        ]);

        if ($updatedBuku) {
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diperbarui',
                'data' => $updatedBuku
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui data',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $buku = Buku::find($id);
        if (!$buku) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
        $deletedBuku = $buku->delete();

        if ($deletedBuku) {
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data',
            ], 500);
        }
    }
}