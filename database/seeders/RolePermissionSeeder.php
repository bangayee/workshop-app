<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'create-user']);
        Permission::create(['name' => 'edit-user']); 
        Permission::create(['name' => 'delete-user']); 
        Permission::create(['name' => 'show-user']); 
        
        Permission::create(['name' => 'create-product']);
        Permission::create(['name' => 'edit-product']); 
        Permission::create(['name' => 'delete-product']); 
        Permission::create(['name' => 'show-product']); 

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'operator']);

        $roleAdmin = Role::findByName('admin');
        $roleAdmin->givePermissionTo('create-user');
        $roleAdmin->givePermissionTo('edit-user');  
        $roleAdmin->givePermissionTo('delete-user');
        $roleAdmin->givePermissionTo('show-user');
        $roleAdmin->givePermissionTo('create-product');
        $roleAdmin->givePermissionTo('edit-product');
        $roleAdmin->givePermissionTo('delete-product');
        $roleAdmin->givePermissionTo('show-product');

        $roleOperator = Role::findByName('operator');
        $roleOperator->givePermissionTo('create-product');
        $roleOperator->givePermissionTo('edit-product');
        $roleOperator->givePermissionTo('delete-product');
        $roleOperator->givePermissionTo('show-product');
    }
}
