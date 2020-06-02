<?php

use Illuminate\Database\Seeder;

class ConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configs')->insert([
           [
               'der' => '高德api定位 key',
               'name' => 'gaode_api',
               'created_at' => date("Y-m-d H:i:s",time()),
               'value' => ''
           ],
        ]);
    }
}
