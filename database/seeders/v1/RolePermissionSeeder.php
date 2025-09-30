<?php

namespace Database\Seeders\v1;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Clear cached roles & permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // -----------------------
        // 1. Create Permissions
        // -----------------------
        $permissions = [
            // Books
            'books.index',
            'books.show',
            'books.store',
            'books.update',
            'books.destroy',

            // Authors
            'authors.index',
            'authors.show',
            'authors.store',
            'authors.update',
            'authors.destroy',

            // Categories
            'categories.index',
            'categories.show',
            'categories.store',
            'categories.update',
            'categories.destroy',

            // Loans (only librarian)
            'loans.store',    // register borrow
            'loans.update',   // register return

            // Admin panel access
            'access-admin-panel',

            // Admin: Users
            'admin.users.index',
            'admin.users.store',
            'admin.users.show',
            'admin.users.update',
            'admin.users.destroy',

            // Admin: Roles
            'admin.roles.index',
            'admin.roles.store',
            'admin.roles.show',
            'admin.roles.update',
            'admin.roles.destroy',

            // Admin: Permissions
            'admin.permissions.index',
            'admin.permissions.store',
            'admin.permissions.show',
            'admin.permissions.update',
            'admin.permissions.destroy',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // -----------------------
        // 2. Create Roles
        // -----------------------
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $librarianRole = Role::firstOrCreate(['name' => 'librarian']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // -----------------------
        // 3. Assign Permissions to Roles
        // -----------------------

        // Admin → full access (all permissions)
        $adminRole->syncPermissions($permissions);

        // Librarian → manage library & loans
        $librarianPermissions = [
            'books.index', 'books.show', 'books.store', 'books.update', 'books.destroy',
            'authors.index', 'authors.show', 'authors.store', 'authors.update', 'authors.destroy',
            'categories.index', 'categories.show', 'categories.store', 'categories.update', 'categories.destroy',
            'loans.store', 'loans.update',
        ];
        $librarianRole->syncPermissions($librarianPermissions);

        // User → limited access (view only)
        $userPermissions = [
            'books.index', 'books.show',
            'authors.index', 'authors.show',
            'categories.index', 'categories.show',
        ];
        $userRole->syncPermissions($userPermissions);

        // -----------------------
        // 4. Assign Roles to Sample Users
        // -----------------------
        $admin = User::where('email', 'admin@example.com')->first();
        $admin?->assignRole('admin');

        $librarian = User::where('email', 'librarian@example.com')->first();
        $librarian?->assignRole('librarian');

        $user = User::where('email', 'user@example.com')->first();
        $user?->assignRole('user');
    }
}
