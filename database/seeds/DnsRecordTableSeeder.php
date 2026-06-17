<?php

use DomainProvider\Models\DnsRecord;

class DnsRecordTableSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $dnsystems = [
            [
                'type' => 'A',
                'name' => $faker->domainWord,
                'content' => $faker->ipv4,
            ],
            [
                'type' => 'AAAA',
                'name' => $faker->domainWord,
                'content' => $faker->ipv6,
            ],
            [
                'type' => 'CNAME',
                'name' => $faker->domainWord,
                'content' => $faker->domainName,
            ],
            [
                'type' => 'MX',
                'name' => $faker->domainName,
                'content' => $faker->domainWord,
                'priority' => '10',
            ],
            [
                'type' => 'TXT',
                'name' => $faker->domainWord,
                'content' => $faker->swiftBicNumber,
            ],
            [
                'type' => 'NS',
                'name' => $faker->domainWord,
                'content' => $faker->ipv4,
            ],
        ];

        for ($i = 1; $i <= 10; ++$i) {
            $userDomain = $this->get('domain-'.($i <= 5 ? 1 : 2));
            $dns = $dnsystems[$faker->numberBetween(0, count($dnsystems) - 1)];
            $apikey = DnsRecord::create(array_merge([
                'zone_id' => $userDomain->zone->id,
                'user_domain_id' => $userDomain->id,
                'cf_id' => $faker->md5,
                'proxiable' => false,
                'proxied' => false,
                'ttl' => $faker->randomElement([1, 120, 300, 1800, 3600, 43200, 86400]),
                'locked' => false,
                'data' => json_encode([]),
            ], $dns));

            $this->set('dns-record-'.$i, $apikey);
        }
    }

    public function remove()
    {
        DnsRecord::whereNotNull('id')->delete();
    }
}
