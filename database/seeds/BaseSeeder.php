<?php

use Illuminate\Database\Seeder;

class BaseSeeder extends Seeder
{
    private static $datas = [];

    protected function set($key, $value)
    {
        self::$datas[$key] = $value;
    }

    protected function get($key)
    {
        return self::$datas[$key];
    }
}
