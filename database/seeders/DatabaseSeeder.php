<?php
namespace Database\Seeders;

use App\Models\Role;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        $ownerRole = Role::create(['name' => 'owner']);

        // Admin User
        User::create([
            'role_id' => $adminRole->id,
            'name' => 'Super Admin',
            'email' => 'admin@fnbkasir.com',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'is_active' => true,
        ]);

        // Demo Owner
        $owner = User::create([
            'role_id' => $ownerRole->id,
            'name' => 'Demo Owner',
            'email' => 'owner@demo.com',
            'password' => Hash::make('password'),
            'phone' => '089876543210',
            'is_active' => true,
        ]);

        // Demo Store
        Store::create([
            'user_id' => $owner->id,
            'name' => 'Kedai Kopi Demo',
            'address' => 'Jl. Jenderal Sudirman No. 1, Jakarta',
            'phone' => '02198765432',
        ]);
    }
}
