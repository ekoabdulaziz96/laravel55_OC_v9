<?php

use Illuminate\Database\Seeder;
use App\Form;

class FormsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $forms = [
            ['urutan'=>1, 'nama' => 'shalat dhuha', 'tipe' => 'text','slug' =>  str_slug('shalat dhuha', '-'),'status' => 'ft_admin','view'=>'show','kategori'=>'formula_pagi'],
        ];
 
        DB::table('form')->insert($forms);
        
        Schema::table('ft_admin', function ($table)  {
                    $table->string(str_slug('shalat dhuha','_'),200)->nullable()->default(null);
        });
          //schema keterangan
        Schema::table('ft_admin', function ($table) {
            $table->string('ket_'.str_slug('shalat dhuha','_'),999)->nullable()->default(null);

        });
    }
}
