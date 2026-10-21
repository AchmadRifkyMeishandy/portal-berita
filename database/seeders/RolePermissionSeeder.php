<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Permissions
        |--------------------------------------------------------------------------
        */

        $permissions = [
            // Article
            'articles.view',
            'articles.create',
            'articles.update',
            'articles.delete',
            'articles.restore',
            'articles.submit_review',
            'articles.review',
            'articles.publish',

            // Categories
            'categories.manage',

            // Tags
            'tags.manage',

            // Comments
            'comments.view',
            'comments.moderate',
            'comments.delete',

            // Users
            'users.view',
            'users.create',
            'users.update',
            'users.delete',

            // Media
            'media.view',
            'media.upload',
            'media.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */

        $superAdmin = Role::findOrCreate('super_admin', 'web');

        $editor = Role::findOrCreate('editor', 'web');

        $journalist = Role::findOrCreate('journalist', 'web');

        $reader = Role::findOrCreate('reader', 'web');

        /*
        |--------------------------------------------------------------------------
        | Assign Permissions to Roles
        |--------------------------------------------------------------------------
        */

        $superAdmin->syncPermissions($permissions);

        $editor->syncPermissions([
            'articles.view',
            'articles.create',
            'articles.update',
            'articles.delete',
            'articles.restore',
            'articles.submit_review',
            'articles.review',
            'articles.publish',

            'categories.manage',
            'tags.manage',

            'comments.view',
            'comments.moderate',

            'media.view',
            'media.upload',
        ]);

        $journalist->syncPermissions([
            'articles.view',
            'articles.create',
            'articles.update',
            'articles.submit_review',

            'comments.view',

            'media.view',
            'media.upload',
        ]);

        $reader->syncPermissions([
            'articles.view',
            'comments.view',
        ]);
    }
}
