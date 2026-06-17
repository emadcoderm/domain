<?php

use DomainProvider\Models\UserDomain;

class UserDomainTableSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $j = 1;
        for ($i = 1; $i <= 2; ++$i) {
            $apikey = UserDomain::create([
                'user_id' => $this->get('user-admin')->id,
                'zone_id' => $this->get('zone-1')->id,
                'name' => $faker->domainWord,
                'expired_at' => (new \DateTime())->add(new \DateInterval('P1Y'))
            ]);

            $this->set('domain-'.$j++, $apikey);
        }

        for ($i = $j, $limit = $j + 1; $i <= $limit; ++$i) {
            $apikey = UserDomain::create([
                'user_id' => $this->get('user-1')->id,
                'zone_id' => $this->get('zone-2')->id,
                'name' => $faker->domainWord,
                'expired_at' => (new \DateTime())->add(new \DateInterval('P1Y'))
            ]);

            $this->set('domain-'.$j++, $apikey);
        }
    }

    public function remove()
    {
        UserDomain::whereNotNull('id')->delete();
    }
}
