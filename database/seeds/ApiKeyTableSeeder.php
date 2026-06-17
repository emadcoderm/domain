<?php

use DomainProvider\Models\ApiKey;

class ApiKeyTableSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 1; $i <= 2; ++$i) {
            $apikey = ApiKey::create([
                'user_id' => $this->get('user-admin')->id,
                'cf_id' => $faker->md5,
                'api_key' => $faker->sha1,
                'email' => $faker->email
            ]);

            $this->set('apikey-'.$i, $apikey);
        }
    }

    public function remove()
    {
        ApiKey::whereNotNull('id')->delete();
    }
}
