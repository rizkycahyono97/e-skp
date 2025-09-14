<?php

namespace Database\Seeders;

use App\Models\Indicator;
use App\Models\PerformanceAgreement;
use App\Models\User;
use App\Models\WorkResult;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PerformanceAgreementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rektor = User::where('nip', '1001')->first();

        if ($rektor) {
            $pk = PerformanceAgreement::firstOrCreate(['user_id' => $rektor->id, 'year' => 2024], [
                'title' => 'Perjanjian Kinerja Rektor 2024',
                'status' => 'approved',
            ]);

            $workResult = WorkResult::updateOrCreate(
                ['description' => 'Meningkatkan Jumlah Publikasi Internasional'],
                [
                    'pa_id' => $pk->id,
                    'skp_id' => null,
                    // 'is_from_cascading' => true,
                ]
            );


                // dd($pk->pa_id, $workResult->toArray());
            // if (is_null($workResult->pa_id)) {
            //     $workResult->update(['pa_id' =>  $pk->pa_id]);
            // }

            $indicators = [
                [
                    'description' => 'Jumlah publikasi international terindeks A',
                    'target' => '10 artikel',
                ],
                [
                    'description' => 'Jumlah publikasi international terindeks B',
                    'target' => '20 artikel',
                ],
                [
                    'description' => 'Jumlah publikasi international terindeks C',
                    'target' => '30 artikel',
                ]
                ];
            foreach ($indicators as $indicator) {
                Indicator::updateOrCreate(
                    [
                        'work_result_id' => $workResult->id,
                        'description' => $indicator['description'],
                    ],
                );
            }
        }
    }
}