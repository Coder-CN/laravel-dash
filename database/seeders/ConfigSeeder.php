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
                'value' => ''
            ],
            [
                'key' => 'web_name',
                'value' => 'myWeb'
            ],
            [
                'key' => 'web_host',
                'value' => 'https://'
            ],
            [
                'key' => 'web_seotitle',
                'value' => ''
            ],
            [
                'key' => 'web_keywords',
                'value' => ''
            ],
            [
                'key' => 'web_description',
                'value' => ''
            ],
            [
                'key' => 'web_copyright',
                'value' => ''
            ],
            [
                'key' => 'address',
                'value' => ''
            ],
            [
                'key' => 'contact_phone',
                'value' => ''
            ],
            [
                'key' => 'fax',
                'value' => ''
            ],
            [
                'key' => 'contact_email',
                'value' => ''
            ],
            [
                'key' => 'contacts',
                'value' => ''
            ],
            [
                'key' => 'upload_type',
                'value' => ''
            ],
            [
                'key' => 'upload_maximum_size',
                'value' => ''
            ],
        ]);
    }
}
