<?php

use DomainProvider\Models\User;

class UserTableSeeder extends BaseSeeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $userAdmin = User::create([
            'full_name' => 'Administrator',
            'role_id' => $this->get('role-admin')->id,
            'email' => 'admin@studionesia.com',
            'password' => 'admin',
        ]);

        $user1 = User::create([
            'full_name' => 'User',
            'role_id' => $this->get('role-user')->id,
            'email' => 'user@studionesia.com',
            'password' => 'user',
        ]);

        for ($i = 0; $i < 5; ++$i) {
            $email = $faker->freeEmail;

            User::create([
                'full_name' => $faker->name,
                'role_id' => $this->get('role-user')->id,
                'email' => $email,
                'password' => bcrypt($email)
            ]);
        }

        $this->set('user-admin', $userAdmin);
        $this->set('user-1', $user1);
    }

    public function remove()
    {
        User::whereNotNull('id')->delete();
    }
}
