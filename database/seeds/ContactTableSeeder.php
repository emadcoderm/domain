<?php

use DomainProvider\Models\Contact;

class ContactTableSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 1; $i <= 5; ++$i) {
            Contact::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'message' => $faker->text,
                'seen' => $faker->randomElement([0, 1])
            ]);
        }
    }

    public function remove()
    {
        Contact::whereNotNull('id')->delete();
    }
}
