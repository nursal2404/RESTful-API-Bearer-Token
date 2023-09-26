<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_buku = Buku::all();
            if(!count($data_buku)){
                return response()->json(['message' => 'Error, tidak ada data buku'], 404);
            }
        return response()->json(['data' => $data_buku , 'message' => 'Sukses, mengambil data semua buku'], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi = $request->validate([
            'nama_buku' => 'required',
            'kode_buku' => 'required',
        ]);

        $data_baru = Buku::create([
            'nama_buku' => $request->nama_buku,
            'kode_buku' => $request->kode_buku,
        ]);

        return response()->json(['data' => $data_baru , 'message' => 'Sukses, membuat data buku'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $buku = Buku::find($id);
            if (!$buku) {
                return response()->json(['message' => 'Error, data buku tidak ditemukan'], 404);
            }
        return response()->json(['data' => $buku , 'message' => 'Success, data buku dengan id '. $id .' berhasil diambil'],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Buku $buku)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data_buku = Buku::find($id);
        if (!$data_buku) {
            return response()->json(['message' => 'Error, data buku tidak ditemukan'], 404);
        }

        $validasi = $request->validate([
            'nama_buku' => 'required',
            'kode_buku' => 'required',
        ]);

            $data_buku->nama_buku = $request->nama_buku;
            $data_buku->kode_buku = $request->kode_buku;
            $data_buku->save();

            return response()->json(['data'=> $data_buku,'message' => 'Success, data buku berhasil diperbarui'],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $buku = Buku::find($id);
            if (!$buku) {
                return response()->json(['message' => 'Error, data buku tidak ditemukan'], 404);
            }
        $buku->delete();
        return response()->json(['message' => 'Success, data buku  berhasil dihapus'], 204);
    }
}
