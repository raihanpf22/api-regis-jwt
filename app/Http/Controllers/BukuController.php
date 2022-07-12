<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

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
}
