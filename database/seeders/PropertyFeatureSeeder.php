<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PropertyFeature;

class PropertyFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            'WiFi',
            'Climatisation',
            'Chauffage',
            'Cuisine équipée',
            'Lave-linge',
            'Parking',
            'Ascenseur',
            'Piscine',
            'Jardin',
            'Terrasse',
            'Gym',
            'Sécurité',
            'Animaux acceptés'
        ];

        foreach ($features as $featureName) {
            PropertyFeature::create([
                'name' => $featureName,
                'description' => $this->getFeatureDescription($featureName)
            ]);
        }

        $this->command->info(count($features) . ' fonctionnalités de propriété ont été créées avec succès.');
    }

    /**
     * Get description for each feature
     */
    private function getFeatureDescription(string $featureName): string
    {
        $descriptions = [
            'WiFi' => 'Connexion Internet sans fil haut débit',
            'Climatisation' => 'Système de climatisation pour un confort optimal',
            'Chauffage' => 'Système de chauffage central ou électrique',
            'Cuisine équipée' => 'Cuisine complète avec électroménagers',
            'Lave-linge' => 'Machine à laver incluse dans le logement',
            'Parking' => 'Place de parking privée ou garage',
            'Ascenseur' => 'Accès par ascenseur dans l\'immeuble',
            'Piscine' => 'Piscine privée ou commune',
            'Jardin' => 'Espace jardin privatif ou partagé',
            'Terrasse' => 'Terrasse ou balcon aménagé',
            'Gym' => 'Accès à une salle de sport ou équipements fitness',
            'Sécurité' => 'Système de sécurité et surveillance',
            'Animaux acceptés' => 'Animaux domestiques autorisés'
        ];

        return $descriptions[$featureName] ?? 'Fonctionnalité de propriété';
    }
}
