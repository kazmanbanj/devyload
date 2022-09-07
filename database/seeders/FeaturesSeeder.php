<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeaturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $features = config('features.feature');

        foreach ($features as $feature) {
            Feature::FirstOrCreate([
                'feature' => $feature
            ],[
                'title' => $feature,
                'description' => 'This is the ' . $feature . ' feature',
                'active_at' => now(),
            ]);
        }
    }
}
