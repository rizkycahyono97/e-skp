<?php

namespace Database\Seeders;

use App\Models\Indicator;
use App\Models\PerformanceAgreement;
use App\Models\SkpPlan;
use App\Models\User;
use App\Models\WorkCascading;
use App\Models\WorkResult;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rektor = User::where('nip', '1001')->first();
        $dekan = User::where('nip', '1002')->first();
        $dosen = User::where('nip', '1003')->first();
        $pkRektor = PerformanceAgreement::where('user_id', $rektor->id)->first();

        // dd([$rektor, $dekan, $dosen, $pkRektor]);

        if ($dekan && $dosen && $pkRektor) {
            $skpDekan = SkpPlan::updateOrCreate(['user_id' => $dekan->id, 'year' => '2024'],  [
                'duration_start' => '2024-01-01',
                'duration_end' => '2024-12-31',
                'status' => 'approved',
                'approver_id' => $rektor->id,
            ]);

            // cascading
            $workResultPkRektor = WorkResult::where('pa_id', $pkRektor->pa_id)->first();
            if ($workResultPkRektor) {
                WorkCascading::updateOrCreate(['parent_work_result_id' => $workResultPkRektor->work_result_id], [
                    'target_plan_id' => $skpDekan->skp_id
                ]);
            }

            $workResultDekan = WorkResult::updateOrCreate(['skp_id' =>  $skpDekan->skp_id, 'description' =>  'Menyumbang 20 publikasi international'], [
                'is_from_cascading' => true,
                'penugasan_dari' => 'Rektor'
            ]) ;

            // Indicator::updateOrCreate(['work_result_id' => $workResultDekan->work_result_id], [
            //     'description' => 'Jumlah artikel yang disumbangkan fakultas',
            //     'target' => '20 artikel'
            // ]);

            // skp dosen
            $skpDosen =  SkpPlan::updateOrCreate(['user_id' =>  $dosen->id, 'year' => '2024'], [
                'duration_start' => '2024-01-01',
                'duration_end' => '2024-12-31',
                'status' => 'approved',
                'approver_id' => $dekan->id
            ]);

            WorkCascading::updateOrCreate(['parent_work_result_id' => $workResultDekan->work_result_id], [
                'target_plan_id' =>  $skpDosen->skp_id
            ]);

            $workResultDosen = WorkResult::updateOrCreate(['skp_id' => $skpDosen->skp_id, 'description' => 'Menyumbang 2 publikasi international'], [
                'is_from_cascading' => true,
                'penugasan_dari' => 'Dekan'
            ]);

            // Indicator::updateOrCreate(['work_result_id' => $workResultDosen->work_result_id], [
            //     'description' => 'Jumlah artikel yang diterbitkan',
            //     'target' => '2 artikel'
            // ]);
        }
    }
}