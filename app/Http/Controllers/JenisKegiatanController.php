<?php

namespace App\Http\Controllers;

use App\Models\JenisKegiatan;
use Illuminate\Http\Request;

class JenisKegiatanController extends Controller
{
    public function index()
    {
        $header = [
            'title' => 'Manajemen Jenis Kegiatan',
            'description' => 'Kelola Master Jenis Kegiatan disini.',
        ];

        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Jenis Kegiatan', 'url' => null],
        ];

        $jenisKegiatans = JenisKegiatan::latest()->paginate(10);

        return view('jenis-kegiatans.index', compact('jenisKegiatans', 'header', 'breadcrumbs'));
    }
}
