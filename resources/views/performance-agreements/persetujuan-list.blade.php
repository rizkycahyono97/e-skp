<x-layouts.app>
    <x-partials.breadcrumbs :items="$breadcrumbs" />

    <x-partials.header title="Daftar Persetujuan Kinerja"
        description="Berikut adalah daftar perjanjian kinerja yang diajukan oleh bawahan." />

    <x-tables.table :headers="[
        'No',
        'Nama Pengaju',
        'Judul Perjanjian',
        'Unit Kerja',
        'Jabatan',
        'Tanggal Diajukan',
        'Status',
        'Action',
    ]" :rows="$approvals->map(function ($approval, $index) use ($approvals) {
        return [
            'no' => $index + 1 + ($approvals->currentPage() - 1) * $approvals->perPage(),
            'nama pengaju' => $approval->user->username,
            'judul perjanjian' => $approval->title,
            'unit kerja' => $approval->user->unit->unit_name,
            'jabatan' => $approval->user->position->position_name,
            'tanggal diajukan' => $approval->submitted_at,
            'status' => $approval->status,
            'actions' => view('performance-agreements.partials.approval-actions', compact('approval'))->render(),
        ];
    })">

    </x-tables.table>

</x-layouts.app>
