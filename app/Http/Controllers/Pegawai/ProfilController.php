<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Profil;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function index()
    {
        return view('pegawai.jabatan.profil.data');
    }
}
