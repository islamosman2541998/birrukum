<?php

namespace Database\Seeders;

use App\Models\Contactus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContactUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contactuses')->delete();

        Contactus::factory()->count(200)->create();
    }
}
