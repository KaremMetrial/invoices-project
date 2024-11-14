<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'invoice',
            'invoice_read',
            'invoice_paid',
            'invoice_unpaid',
            'invoice_archive_list',
            'invoice_partial_paid',


            'report',
            'report_read',
            'report_client',

            'users',
            'users_read',
            'users_role',

            'settings',
            'products',
            'sections',

            'invoice_create',
            'invoice_delete',
            'invoice_export',
            'invoice_change_status',
            'invoice_edit',
            'invoice_archive',
            'invoice_print',
            'invoice_add_attachment',
            'invoice_delete_attachment',


            'users_create',
            'users_edit',
            'users_delete',


            'roles',
            'roles_read',
            'roles_create',
            'roles_edit',
            'roles_delete',

            'products_create',
            'products_edit',
            'products_delete',

            'sections_create',
            'sections_edit',
            'sections_delete',

            'notifications',


         ];

         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }
    }
}
