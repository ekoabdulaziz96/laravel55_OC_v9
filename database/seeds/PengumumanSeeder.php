<?php

use Illuminate\Database\Seeder;
use App\Pengumuman;

class PengumumanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Pengumuman::create([
            'status' => 'ft_admin',
            'isi' =>  ('hhhhh hhhhhhhhhhhhh hhhhhhhhhhhh hhhhhhhhhhah hhhhhhhhhhhhhhhhaf asf asf asf'),
        ]);
    }
}
