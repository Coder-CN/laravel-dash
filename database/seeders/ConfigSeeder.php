<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigSeeder extends Seeder
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
                'key' => 'web_logo',
                'value' => null
            ],
            [
                'key' => 'web_name',
                'value' => '我的網站'
            ],
            [
                'key' => 'web_host',
                'value' => 'https://'
            ],
            [
                'key' => 'web_seotitle',
                'value' => null
            ],
            [
                'key' => 'web_keywords',
                'value' => null
            ],
            [
                'key' => 'web_description',
                'value' => null
            ],
            [
                'key' => 'web_copyright',
                'value' => null
            ],
            [
                'key' => 'address',
                'value' => null
            ],
            [
                'key' => 'contact_phone',
                'value' => null
            ],
            [
                'key' => 'fax',
                'value' => null
            ],
            [
                'key' => 'contact_email',
                'value' => null
            ],
            [
                'key' => 'contacts',
                'value' => null
            ],
            [
                'key' => 'upload_type',
                'value' => null
            ],
            [
                'key' => 'upload_maximum_size',
                'value' => null
            ],
        ]);
    }
}
