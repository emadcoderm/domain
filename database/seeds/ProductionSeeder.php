<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class ProductionSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /**
         * just add this with seeder class name
         * @var [string]
         */
        $seeders = [
            'RoleTableSeeder',
            'ProductionUserTableSeeder',
            'BlacklistDomainTableSeeder',
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
