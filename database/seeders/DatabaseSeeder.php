<?php

namespace Database\Seeders;

use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        DB::table('TTypeCards')->insert(
            [
                [
                    "name" => "Carte d'électeur",
                    'created_at' => (Carbon::now())->toDateTimeString(),
                    'updated_at' => (Carbon::now())->toDateTimeString()
                ],
                [
                    "name" => "Passeport",
                    'created_at' => (Carbon::now())->toDateTimeString(),
                    'updated_at' => (Carbon::now())->toDateTimeString()
                ],
                [
                    "name" => "Autres",
                    'created_at' => (Carbon::now())->toDateTimeString(),
                    'updated_at' => (Carbon::now())->toDateTimeString()
                ]
            ]
        );
    }
}
