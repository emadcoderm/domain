<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ('local' !== App::environment()) {
            exit('Only run on local environment.');
        }

        /**
         * just add this with seeder class name
         * @var [string]
         */
        $seeders = [
            'RoleTableSeeder',
            'UserTableSeeder',
            'ApiKeyTableSeeder',
            'ContactTableSeeder',
            'ZoneTableSeeder',
            'BlacklistDomainTableSeeder',
            'UserDomainTableSeeder',
            'DnsRecordTableSeeder',
            'PageTableSeeder',
            'SettingTableSeeder',
        ];

        /**
         * Dont change code below
         */

        Model::unguard();

        /**
         * remove all table record
         * from the inverse
         */
        foreach (array_reverse($seeders) as $seeder) {
            $a = new $seeder;
            $a->remove();
        }

        /**
         * Run the seeder
         */
        foreach ($seeders as $seeder) {
            $this->call($seeder);
        }
    }
}
