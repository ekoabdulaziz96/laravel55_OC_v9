<?php

use Illuminate\Database\Seeder;
use App\Cabang;

class CabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          cabang::create([
            'nama' => '-',
            'slug' =>  '-',
            'maks_wilayah' => 0,

        ]);           cabang::create([
            'nama' => 'Jawa Tengah',
            'slug' =>  str_slug('Jawa Tengah', '_'),
            'maks_wilayah' => 5,

        ]);          
          cabang::create([
            'nama' => 'Jawa Timur',
            'slug' =>  str_slug('Jawa Timur', '_'),
            'maks_wilayah' => 5,

        ]);
    }
}
