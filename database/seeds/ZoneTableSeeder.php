<?php

use DomainProvider\Models\Zone;

class ZoneTableSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $domainNames = ['example.com', 'example.net'];
        for ($i = 1; $i <= 2; ++$i) {
            $zone = Zone::create([
                'api_key_id' => $this->get('apikey-1')->id,
                'cf_id' => $faker->md5,
                'name' => $domainName[$i - 1],
                'status' => 'active',
                'paused' => false,
            ]);

            $this->set('zone-'.$i, $zone);
        }
    }

    public function remove()
    {
        Zone::whereNotNull('id')->delete();
    }
}
