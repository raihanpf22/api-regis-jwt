<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Buku;
use Illuminate\Support\Facades\Storage;
class BukuController extends Controller
{
    //
    public function buku()
    {
        $data = "Data Buku";
        return response()->json($data, 200);
    }

    public function bukuAuth()
    {
        $data = "Selamat Datang ". Auth::user()->name;
        return response()->json($data, 200);
    }

    public function index()
    {
        $databukudvf = Buku::all();
        
        return $databukudvf;
    }

    public function tampil($kode_buku)
    {
        $databukudvf = Buku::find($kode_buku);

        return $databukudvf;
    }

    public function simpan_buku(Request $request)
    {
        $this->validate($request, [
            'gambar_buku' => 'required|file|max:1000'
        ]);
        if ($request->hasFile('gambar_buku')) {
            $name = $request->file('gambar_buku')->getClientOriginalName();
            $file = $request->file('gambar_buku');
            $path = $file->storeAs('public/uploads', $name);
            $url = env('APP_URL').Storage::url($path);
        }else {
            $name = 'noimage.jpg';
            $url = $name;
        }
        $databukudvf = new Buku();
        $databukudvf -> kode_buku = $request->kode_buku;
        $databukudvf -> judlu_buku = $request->judlu_buku;
        $databukudvf -> id_kategori = $request->id_kategori;
        $databukudvf -> penulis_buku = $request->penulis_buku;
        $databukudvf -> penerbit_buku = $request->penerbit_buku;
        $databukudvf -> tahun_terbit = $request->tahun_terbit;
        $databukudvf -> stok_buku = $request->stok_buku;
        $databukudvf -> gambar_buku = $name;
        $databukudvf -> url_gambar_buku = $url;
        $databukudvf -> status_buku = $request->status_buku;
        $databukudvf->save();

        return $databukudvf;
    }
}
