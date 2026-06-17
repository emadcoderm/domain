<?php

use DomainProvider\Models\BlacklistDomain;

class BlacklistDomainTableSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['www', 'mail', 'ftp', 'cpanel'];

        foreach ($names as $name) {
            $zone = BlacklistDomain::create([
                'zone_id' => null,
                'name' => $name,
                'reason' => 'Unavailable Domain Name',
            ]);
        }
    }

    public function remove()
    {
        BlacklistDomain::whereNotNull('id')->delete();
    }
}
