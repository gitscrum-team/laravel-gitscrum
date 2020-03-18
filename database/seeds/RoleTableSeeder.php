<?php

use Illuminate\Database\Seeder;
use GitScrum\Models\Role;
class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $role_employee = new Role();
      $role_employee->name = 'developer';
      $role_employee->description = 'Desenvolvedores de TI';
      $role_employee->save();
      $role_manager = new Role();
      $role_manager->name = 'admin';
      $role_manager->description = 'Administradores desta plataforma';
      $role_manager->save();
      $role_manager = new Role();
      $role_manager->name = 'manager';
      $role_manager->description = 'Gestores da empresa mantenedora';
      $role_manager->save();
    }
}
