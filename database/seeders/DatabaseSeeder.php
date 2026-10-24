<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

       $customer = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Category::create(
            [
                'name' => 'Fasilitas'
            ],
        );

       app(PermissionRegistrar::class)->forgetCachedPermissions();

        $manageUser = Permission::firstOrCreate([
            'name' => 'manage pengaduan',
            'guard_name' => 'web',
        ]);

        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        Role::firstOrCreate([
            'name' => 'customer',
            'guard_name' => 'web',
        ]);

        // Only admin gets this permission; customer gets none
        $admin->givePermissionTo($manageUser);

        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);

        $user->assignRole('admin');
        $customer->assignRole('customer');
 
    }
}
