<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Profile;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sampleImages = [
            database_path('seeders/sample_images/SampleProfile.jpeg'),
        ];

        $users =User::orderBy('id')->get();

        foreach ($users as $index => $user) {
            $imagePath = 'profile_images/sample_' . ($index + 1) . '.jpeg';
            Storage::disk('public')->put($imagePath, file_get_contents($sampleImages[$index % count($sampleImages)]));

            Profile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'image' => $imagePath,
                    'name' => 'テストユーザー' . ($index + 1),
                    'postal_code' => '123-456' . $index,
                    'address' => '東京都渋谷区テスト' . ($index + 1) . '-1-1',
                    'building' => 'テストビル' . ($index + 1) . '01',
                ]
            );
        }
    }
}
