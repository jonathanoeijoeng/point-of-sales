<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use TimoKoerber\LaravelJsonSeeder\JsonDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::create([
        //     'name' => 'Super Admin',
        //     'email' => 'super-admin@user.com',
        //     'password' => Hash::make('password'),
        //     'email_verified_at' => now(),
        // ]);
        // User::create([
        //     'name' => 'Admin',
        //     'email' => 'admin@user.com',
        //     'password' => Hash::make('password'),
        //     'email_verified_at' => now(),
        // ]);
        // User::create([
        //     'name' => 'Cashier',
        //     'email' => 'cashier@user.com',
        //     'password' => Hash::make('password'),
        //     'email_verified_at' => now(),
        // ]);

        $this->call([
            CategorySeeder::class,
            FoodDetailSeeder::class,
            TableSeeder::class,
            JsonDatabaseSeeder::class
        ]);

        // $user = User::find(1);
        // $user->syncRoles('Super Admin');

        // $user = User::find(2);
        // $user->syncRoles('Admin');

        // $user = User::find(3);
        // $user->syncRoles('Cashier');

        // $role = Role::find(1);
        // $role->givePermissionTo('view settings');

        // $role = Role::find(1);
        // $role->givePermissionTo('view dashboard');

        // $role = Role::find(2);
        // $role->givePermissionTo('view settings');

        // $role = Role::find(2);
        // $role->givePermissionTo('view dashboard');
    }
}
