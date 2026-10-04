<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $journalists = [
            [
                'name' => 'Andi Pratama',
                'email' => 'andi@portalberita.test',
                'password' => 'password',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@portalberita.test',
                'password' => 'password',
            ],
            [
                'name' => 'Citra Lestari',
                'email' => 'citra@portalberita.test',
                'password' => 'password',
            ],
        ];

        foreach ($journalists as $journalist) {
            $user = User::updateOrCreate(
                ['email' => $journalist['email']],
                $journalist
            );

            $user->assignRole('journalist');
        }
    }
}
