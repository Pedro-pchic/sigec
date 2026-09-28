<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DevelopmentAdminSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! app()->environment('local')) {
            return;
        }

        $email = config('seeders.development_admin.email');
        $password = config('seeders.development_admin.password');

        if (blank($email) || blank($password)) {
            $this->command?->warn('Configure DEV_ADMIN_EMAIL and DEV_ADMIN_PASSWORD locally to create the development administrator.');

            return;
        }

        $administratorRole = Role::where('name', Role::ADMINISTRATOR)->firstOrFail();

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => config('seeders.development_admin.name'),
                'role_id' => $administratorRole->id,
                'is_active' => true,
                'password' => Hash::make($password),
            ],
        );
    }
}
