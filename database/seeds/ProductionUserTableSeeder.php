<?php

use DomainProvider\Models\User;

class ProductionUserTableSeeder extends BaseSeeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $request = \Session::get('request');

        $userAdmin = User::create([
            'full_name' => $request['admin_full_name'],
            'role_id' => $this->get('role-admin')->id,
            'email' => $request['admin_email'],
            'password' => $request['admin_password'],
        ]);

        $this->set('user-admin', $userAdmin);
    }

    public function remove()
    {
        User::whereNotNull('id')->delete();
    }
}
