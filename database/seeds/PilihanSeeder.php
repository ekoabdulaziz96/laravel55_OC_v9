<?php

use Illuminate\Database\Seeder;

class PilihanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          $pilihans = [
            ['nama' => 'shalat dhuha1', 'slug' =>  str_slug('shalat dhuha', '-'),'form_id' => 4],
            ['nama' => 'shalat dhuha2', 'slug' =>  str_slug('shalat dhuha', '-'),'form_id' => 4],
            ['nama' => 'shalat dhuha3', 'slug' =>  str_slug('shalat dhuha', '-'),'form_id' => 4],
            ['nama' => 'shalat dhuha4', 'slug' =>  str_slug('shalat dhuha', '-'),'form_id' => 4],
            ['nama' => 'shalat dhuha5', 'slug' =>  str_slug('shalat dhuha', '-'),'form_id' => 4],  

            ['nama' => 'shalat dhuha1', 'slug' =>  str_slug('shalat dhuha', '-'),'form_id' => 3],
            ['nama' => 'shalat dhuha2', 'slug' =>  str_slug('shalat dhuha', '-'),'form_id' => 3],
            ['nama' => 'shalat dhuha3', 'slug' =>  str_slug('shalat dhuha', '-'),'form_id' => 3],
            ['nama' => 'shalat dhuha4', 'slug' =>  str_slug('shalat dhuha', '-'),'form_id' => 3],
            ['nama' => 'shalat dhuha5', 'slug' =>  str_slug('shalat dhuha', '-'),'form_id' => 3],   

            ['nama' => 'shalat dhuha1', 'slug' =>  str_slug('shalat dhuha', '-'),'form_id' => 5],
            ['nama' => 'shalat dhuha2', 'slug' =>  str_slug('shalat dhuha', '-'),'form_id' => 5],
            ['nama' => 'shalat dhuha3', 'slug' =>  str_slug('shalat dhuha', '-'),'form_id' => 5],
            ['nama' => 'shalat dhuha4', 'slug' =>  str_slug('shalat dhuha', '-'),'form_id' => 5],
            ['nama' => 'shalat dhuha5', 'slug' =>  str_slug('shalat dhuha', '-'),'form_id' => 5],  

            ['nama' => 'shalat tahajut1', 'slug' =>  str_slug('shalat tahajut', '-'),'form_id' => 6],
            ['nama' => 'shalat tahajut2', 'slug' =>  str_slug('shalat tahajut', '-'),'form_id' => 6],
            ['nama' => 'shalat tahajut3', 'slug' =>  str_slug('shalat tahajut', '-'),'form_id' => 6],
            ['nama' => 'shalat tahajut4', 'slug' =>  str_slug('shalat tahajut', '-'),'form_id' => 6],
            ['nama' => 'shalat tahajut5', 'slug' =>  str_slug('shalat tahajut', '-'),'form_id' => 6],
        ];
 
        DB::table('pilihan')->insert($pilihans);
    }
}
