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

    public function create()
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Jenis Kegiatan', 'url' => route('jenis-kegiatans.index')],
            ['name' => 'Create', 'url' => null],
        ];

        return view('jenis-kegiatans.create', compact('breadcrumbs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|unique:jenis_kegiatan',
        ]);
        JenisKegiatan::create($validated);

        return  redirect()->route('jenis-kegiatans.index')
            ->with('successs', 'Jenis Kegiatan succesfully created');
    }

    public function show(JenisKegiatan $jenisKegiatan)
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Jenis Kegiatan', 'url' => route('jenis-kegiatans.index')],
            ['name' => 'Show', 'url' => null],
        ];

        $fields = [
            ['label' => 'ID', 'value' => $jenisKegiatan->id],
            ['label' => 'Nama', 'value' => $jenisKegiatan->nama]
        ];

        return view('jenis-kegiatans.show', compact('breadcrumbs', 'fields', 'jenisKegiatan'));
    }

    public function edit(JenisKegiatan $jenisKegiatan)
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Jenis Kegiatan', 'url' => route('jenis-kegiatans.index')],
            ['name' => 'Edit', 'url' => null],
        ];

        return view('jenis-kegiatans.edit', compact('jenisKegiatan', 'breadcrumbs'));
    }

    public function update(Request $request, JenisKegiatan $jenisKegiatan)
    {
        $validated = $request->validate([
            'nama' =>   'required|string|unique:jenis_kegiatans|min:3'
        ]);

        $jenisKegiatan->update($validated);

        return redirect()->route('jenis-kegiatans.index')
            ->with('success', 'Jenis Kegiatan updated succesfully');
    }

    public function destroy(JenisKegiatan $jenisKegiatan)
    {
        $jenisKegiatan->delete();

        return  redirect()->route('jenis-kegiatans.index')->with('success', 'Jenis Kegiatan deleted succesfully');
    }


}
