<?php

use DomainProvider\Helpers\Constants;
use DomainProvider\Models\Role;

class RoleTableSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create([
            'name' => Constants::ROLE_SUPER_ADMIN,
            'permissions' => json_encode([])
        ]);

        $user = Role::create([
            'name' => Constants::ROLE_USER,
            'permissions' => json_encode([])
        ]);

        $this->set('role-admin', $admin);
        $this->set('role-user', $user);
    }

    public function remove()
    {
        Role::whereNotNull('id')->delete();
    }
}
