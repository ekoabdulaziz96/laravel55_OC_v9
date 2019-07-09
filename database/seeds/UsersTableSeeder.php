<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Admin;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $pilihans = [
        // super admin
            [ 'nama' => 'eko ','email' => 'karimunenam@gmail.com','password' => bcrypt('123456'),'foto'=>'-','active'=>true,'status'=>'super_admin','wilayah'=>0,'cabang_id'=>1, 'remember_token'=>str_random(100),'no_hp'=>'0890898089'],  
        // ft_admin
            [ 'nama' => 'abdul ','email' => 'karimunenam2@gmail.com','password' => bcrypt('123456'),'foto'=>'-','active'=>true,'status'=>'ft_admin','wilayah'=>2,'cabang_id'=>2, 'remember_token'=>str_random(100),'no_hp'=>'0890898089'],
            [ 'nama' => 'abdul ','email' => 'karimunenam12@gmail.com','password' => bcrypt('123456'),'foto'=>'-','active'=>true,'status'=>'ft_admin','wilayah'=>2,'cabang_id'=>3, 'remember_token'=>str_random(100),'no_hp'=>'0890898089'],        
        // ft_sponsorship
            [ 'nama' => 'abdul ','email' => 'karimunenam23@gmail.com','password' => bcrypt('123456'),'foto'=>'-','active'=>true,'status'=>'ft_sponsorship','wilayah'=>2,'cabang_id'=>2, 'remember_token'=>str_random(100),'no_hp'=>'0890898089'],
            [ 'nama' => 'abdul ','email' => 'karimunenam123@gmail.com','password' => bcrypt('123456'),'foto'=>'-','active'=>true,'status'=>'ft_sponsorship','wilayah'=>2,'cabang_id'=>3, 'remember_token'=>str_random(100),'no_hp'=>'0890898089'],
        // ft_kacab
            [ 'nama' => 'aziz ','email' => 'karimunenam3@gmail.com','password' => bcrypt('123456'),'foto'=>'-','active'=>true,'status'=>'ft_kacab','wilayah'=>3,'cabang_id'=>2, 'remember_token'=>str_random(100),'no_hp'=>'0890898089'],
            [ 'nama' => 'aziz ','email' => 'karimunenam31@gmail.com','password' => bcrypt('123456'),'foto'=>'-','active'=>true,'status'=>'ft_kacab','wilayah'=>1,'cabang_id'=>2, 'remember_token'=>str_random(100),'no_hp'=>'0890898089'],
        // direktur
            [ 'nama' => 'haqi ','email' => 'karimunenam42@gmail.com','password' => bcrypt('123456'),'foto'=>'-','active'=>true,'status'=>'direktur','wilayah'=>0,'cabang_id'=>1, 'remember_token'=>str_random(100),'no_hp'=>'0890898089'],
            [ 'nama' => 'halo ','email' => 'karimunenam52@gmail.com','password' => bcrypt('123456'),'foto'=>'-','active'=>true,'status'=>'direktur','wilayah'=>0,'cabang_id'=>1, 'remember_token'=>str_random(100),'no_hp'=>'0890898089'],      
        // manajer
            [ 'nama' => 'haqi ','email' => 'karimunenam4@gmail.com','password' => bcrypt('123456'),'foto'=>'-','active'=>true,'status'=>'manajer','wilayah'=>0,'cabang_id'=>1, 'remember_token'=>str_random(100),'no_hp'=>'0890898089'],
            [ 'nama' => 'halo ','email' => 'karimunenam5@gmail.com','password' => bcrypt('123456'),'foto'=>'-','active'=>true,'status'=>'manajer','wilayah'=>0,'cabang_id'=>1, 'remember_token'=>str_random(100),'no_hp'=>'0890898089'],
          
        ];
       DB::table('users')->insert($pilihans);
           
       

    }
}
