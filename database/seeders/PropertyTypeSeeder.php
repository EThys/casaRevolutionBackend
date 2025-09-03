<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PropertyType;

class PropertyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $propertyTypes = [
            [
                'name' => 'Studios',
                'description' => 'Studios et petits espaces résidentiels'
            ],
            [
                'name' => 'Apparts',
                'description' => 'Appartements de différentes tailles'
            ],
            [
                'name' => 'Maisons',
                'description' => 'Maisons individuelles et pavillons'
            ],
            [
                'name' => 'Bureaux',
                'description' => 'Espaces de bureau et locaux professionnels'
            ],
            [
                'name' => 'Hotels',
                'description' => 'Chambres d\'hôtel et établissements hôteliers'
            ],
            [
                'name' => 'Vacances',
                'description' => 'Locations de vacances et résidences secondaires'
            ]
        ];

        foreach ($propertyTypes as $type) {
            PropertyType::firstOrCreate(
                ['name' => $type['name']],
                ['description' => $type['description']]
            );
        }

        $this->command->info(count($propertyTypes) . ' types de propriété ont été créés avec succès.');
    }
}
