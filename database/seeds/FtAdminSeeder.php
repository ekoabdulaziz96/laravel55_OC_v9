<?php

use Illuminate\Database\Seeder;

class FtAdmin_LaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
                 $laporan = [
            ['created'=>'2018-4-1', 'expired' => '2018-4-7', 'user_id' => '2','status_laporan'=>'baru'],
            ['created'=>'2018-4-2', 'expired' => '2018-4-8', 'user_id' => '2','status_laporan'=>'baru'],
            ['created'=>'2018-4-3', 'expired' => '2018-4-9', 'user_id' => '2','status_laporan'=>'baru'],
            ['created'=>'2018-4-4', 'expired' => '2018-4-10', 'user_id' => '2','status_laporan'=>'baru'],

            ['created'=>'2018-4-1', 'expired' => '2018-4-7', 'user_id' => '2','status_laporan'=>'proses'],
            ['created'=>'2018-4-2', 'expired' => '2018-4-8', 'user_id' => '2','status_laporan'=>'proses'],


            ['created'=>'2018-4-1', 'expired' => '2018-4-7', 'user_id' => '2','status_laporan'=>'perbaikan'],
            ['created'=>'2018-4-2', 'expired' => '2018-4-8', 'user_id' => '2','status_laporan'=>'perbaikan'],

            ['created'=>'2018-4-3', 'expired' => '2018-4-9', 'user_id' => '2','status_laporan'=>'disetujui'],
            ['created'=>'2018-4-4', 'expired' => '2018-4-10', 'user_id' => '2','status_laporan'=>'disetujui'],
         
        ];
 
        DB::table('ft_admin')->insert($laporan);
    }
}
